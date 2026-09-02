<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\SumberLead;
use App\Models\StatusLead;
use App\Models\BudgetLead;
use App\Models\UnitLead;
use Illuminate\Support\Facades\DB;

class LeadsDashboardController extends Controller
{
    public function index(Request $request)
    {
        $periodeLeads = $request->input('periode_leads', 'bulan_ini');
        $tanggal = $request->input('tanggal');
        $tahun = $request->input('tahun', 'semua');
        $periodeTren = $request->input('periode_tren', 'tahun_ini');

        // Translate periode_leads to date range format
        if ($periodeLeads === 'semua') {
            $tanggal = null; // Do not apply date range, just rely on $tahun
        } elseif ($periodeLeads === 'bulan_ini') {
            $yearToUse = ($tahun !== 'semua') ? $tahun : date('Y');
            $start = \Carbon\Carbon::createFromDate($yearToUse, date('m'), 1)->startOfMonth()->format('d/m/Y');
            $end = \Carbon\Carbon::createFromDate($yearToUse, date('m'), 1)->endOfMonth()->format('d/m/Y');
            $tanggal = "$start - $end";
            $tahun = 'semua'; // clear tahun so whereYear isn't redundantly applied over whereBetween
        } elseif ($periodeLeads === 'bulan_lalu') {
            $lastMonth = \Carbon\Carbon::now()->subMonth();
            $yearToUse = ($tahun !== 'semua') ? $tahun : $lastMonth->year;
            $start = \Carbon\Carbon::createFromDate($yearToUse, $lastMonth->month, 1)->startOfMonth()->format('d/m/Y');
            $end = \Carbon\Carbon::createFromDate($yearToUse, $lastMonth->month, 1)->endOfMonth()->format('d/m/Y');
            $tanggal = "$start - $end";
            $tahun = 'semua'; // clear tahun
        } elseif ($periodeLeads === 'custom') {
            // let tahun remain as selected so it applies whereYear if needed
        }

        // Query leads for main widgets (filtered by global tanggal/tahun)
        $leadsQuery = Lead::query();
        if ($tahun && $tahun !== 'semua') {
            $leadsQuery->whereYear('tanggal', $tahun);
        }
        if ($tanggal) {
            $dates = explode(' - ', $tanggal);
            if (count($dates) == 2) {
                $customStartDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[0]))->startOfDay();
                $customEndDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[1]))->endOfDay();
                $leadsQuery->whereBetween('tanggal', [$customStartDate->format('Y-m-d'), $customEndDate->format('Y-m-d')]);
            }
        }
        $leads = $leadsQuery->get();
        
        $periodeLabel = 'SEMUA PERIODE';
        if ($tanggal) {
            $dates = explode(' - ', $tanggal);
            if (count($dates) == 2) {
                $start = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[0]));
                $end = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[1]));
                if ($start->format('m-Y') == $end->format('m-Y')) {
                    $monthsIndo = [1=>'JANUARI', 2=>'FEBRUARI', 3=>'MARET', 4=>'APRIL', 5=>'MEI', 6=>'JUNI', 7=>'JULI', 8=>'AGUSTUS', 9=>'SEPTEMBER', 10=>'OKTOBER', 11=>'NOVEMBER', 12=>'DESEMBER'];
                    $periodeLabel = $monthsIndo[(int)$start->format('m')];
                } else {
                    $periodeLabel = $tanggal;
                }
            }
        } elseif ($tahun != 'semua') {
            $periodeLabel = 'TAHUN ' . $tahun;
        }

        // Previous Period Query for Percentage Change Calculation
        $prevQuery = Lead::query();
        if ($tahun && $tahun !== 'semua') {
            $prevQuery->whereYear('tanggal', $tahun - 1);
            if ($tanggal) {
                $dates = explode(' - ', $tanggal);
                if (count($dates) == 2) {
                    $customStartDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[0]))->subYear()->startOfDay();
                    $customEndDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[1]))->subYear()->endOfDay();
                    $prevQuery->whereBetween('tanggal', [$customStartDate->format('Y-m-d'), $customEndDate->format('Y-m-d')]);
                }
            }
        } else {
            // If 'semua' year is selected, we can't do a year-over-year comparison
            $prevQuery->whereRaw('1 = 0');
        }
        $prevLeads = $prevQuery->get();

        // Top Level Total
        $totalCiawi = $leads->filter(function($q) { return stripos($q->cabang, 'ciawi') !== false; })->count();
        $totalCianjur = $leads->filter(function($q) { return stripos($q->cabang, 'cianjur') !== false; })->count();
        $totalCinere = $leads->filter(function($q) { return stripos($q->cabang, 'cinere') !== false; })->count();
        $totalJatiasih = $leads->filter(function($q) { return stripos($q->cabang, 'jatiasih') !== false; })->count();
        $totalCipanas = $leads->filter(function($q) { return stripos($q->cabang, 'cipanas') !== false; })->count();
        $totalLeads = $leads->count();

        // Base Setup
        $allStatuses = StatusLead::all();
        $spkStatusIds = $allStatuses->filter(function($s) { return stripos($s->nama_status, 'spk') !== false; })->pluck('id')->toArray();
        $doStatusIds = $allStatuses->filter(function($s) { return stripos($s->nama_status, 'do') !== false; })->pluck('id')->toArray();
        $prospectStatusIds = $allStatuses->filter(function($s) { 
            $nama = strtolower($s->nama_status);
            return stripos($nama, 'prospek') !== false || $nama === 'follow up'; 
        })->pluck('id')->toArray();
        $lostStatusIds = $allStatuses->filter(function($s) { return stripos($s->nama_status, 'lost') !== false || stripos($s->nama_status, 'batal') !== false; })->pluck('id')->toArray();
        $noReportStatusId = $allStatuses->filter(function($s) { return stripos($s->nama_status, 'no report') !== false; })->pluck('id')->first();

        $sumbers = SumberLead::all();
        $units = UnitLead::all();
        
        // Budgets
        $budgetQuery = BudgetLead::query();
        
        $budgetBulanFilter = null;
        if ($tanggal) {
            $dates = explode(' - ', $tanggal);
            if (count($dates) == 2) {
                $start = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[0]));
                $end = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[1]));
                if ($start->format('m-Y') == $end->format('m-Y')) {
                    $monthsIndo = [1=>'JANUARI', 2=>'FEBRUARI', 3=>'MARET', 4=>'APRIL', 5=>'MEI', 6=>'JUNI', 7=>'JULI', 8=>'AGUSTUS', 9=>'SEPTEMBER', 10=>'OKTOBER', 11=>'NOVEMBER', 12=>'DESEMBER'];
                    $budgetBulanFilter = $monthsIndo[(int)$start->format('m')] . ' ' . $start->format('Y');
                }
            }
        }
        
        if ($budgetBulanFilter) {
            $budgetQuery->where('bulan', $budgetBulanFilter);
        } elseif ($tahun != 'semua') {
            $budgetQuery->where('bulan', 'like', '%' . $tahun);
        }
        
        $budgets = $budgetQuery->get();

        $resultLeadsMappings = [
            'WEB' => 'Web',
            'WEB ORGANIK' => 'Organik',
            'FB/IG Official' => 'Sosmed',
            'FB/IG Cabang' => 'Sosmed',
            'GMB' => 'Google My Business'
        ];

        $dbNameMapping = [
            'WEB' => 'web',
            'WEB ORGANIK' => 'web organik',
            'FB/IG Official' => 'fb/ig official',
            'FB/IG Cabang' => 'fb/ig cabang',
            'GMB' => 'gmb'
        ];


        $chartStatusLabels = ['No Report', 'Prospect', 'SPK', 'DO', 'Lost'];
        $chartSourceLabels = ['WEB', 'WEB ORGANIK', 'FB/IG Official', 'FB/IG Cabang', 'GMB'];
        $chartUnitLabels = $units->pluck('nama_unit')->toArray();

        // Trend Query for all branches
        $trendQuery = Lead::query();
        $targetYear = date('Y');
        $customStartDate = null;
        $customEndDate = null;

        if ($periodeTren === 'tahun_lalu') {
            $targetYear = date('Y') - 1;
            $trendQuery->whereYear('tanggal', $targetYear);
        } else if ($periodeTren === 'tahun_ini') {
            $trendQuery->whereYear('tanggal', $targetYear);
        } else if ($periodeTren === 'custom') {
            $customDate = $request->input('custom_date');
            if ($customDate) {
                $dates = explode(' - ', $customDate);
                if (count($dates) == 2) {
                    $customStartDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[0]))->startOfDay();
                    $customEndDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[1]))->endOfDay();
                    $trendQuery->whereBetween('tanggal', [$customStartDate->format('Y-m-d'), $customEndDate->format('Y-m-d')]);
                }
            }
        }
        $allTrendLeads = $trendQuery->get();

        // ================= GLOBAL DATA =================
        $noReportCount = 0;
        if ($noReportStatusId) {
            $noReportCount = $leads->where('status_id', $noReportStatusId)->count();
        }
        
        $chartStatusData = [
            $noReportCount,
            $leads->whereIn('status_id', $prospectStatusIds)->count(),
            $leads->whereIn('status_id', $spkStatusIds)->count(),
            $leads->whereIn('status_id', $doStatusIds)->count(),
            $leads->whereIn('status_id', $lostStatusIds)->count(),
        ];
        
        $chartSourceData = [];
        $prevChartSourceData = [];
        $trendSourceData = [];
        foreach ($chartSourceLabels as $targetSource) {
            $matchingIds = $sumbers->filter(function($s) use ($targetSource, $dbNameMapping) {
                $dbName = strtolower(trim($s->nama_sumber));
                $targetName = isset($dbNameMapping[$targetSource]) ? $dbNameMapping[$targetSource] : strtolower(trim($targetSource));
                return $dbName === $targetName;
            })->pluck('id')->toArray();
            
            $chartSourceData[] = $leads->whereIn('sumber_id', $matchingIds)->count();
            $prevChartSourceData[] = $prevLeads->whereIn('sumber_id', $matchingIds)->count();

            $sourceTrend = [];
            $allTrendLeadsSource = $allTrendLeads->whereIn('sumber_id', $matchingIds);
            for ($i = 1; $i <= 12; $i++) {
                $sourceTrend[] = $allTrendLeadsSource->filter(function($l) use ($i, $targetYear, $periodeTren) {
                    if ($periodeTren === 'custom') {
                        return (int)date('m', strtotime($l->tanggal)) === $i;
                    }
                    return (int)date('m', strtotime($l->tanggal)) === $i && (int)date('Y', strtotime($l->tanggal)) === (int)$targetYear;
                })->count();
            }
            $trendSourceData[strtoupper($targetSource)] = $sourceTrend;
        }

        // Sort global sources by count descending
        array_multisort($chartSourceData, SORT_DESC, $chartSourceLabels, $prevChartSourceData);
        
        $monthlyTrend = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyTrend[] = $allTrendLeads->filter(function($l) use ($i, $targetYear, $periodeTren) {
                if ($periodeTren === 'custom') {
                    return (int)date('m', strtotime($l->tanggal)) === $i;
                }
                return (int)date('m', strtotime($l->tanggal)) === $i && (int)date('Y', strtotime($l->tanggal)) === (int)$targetYear;
            })->count();
        }
        
        $chartUnitData = [];
        foreach ($units as $u) {
            $chartUnitData[] = $leads->where('unit_id', $u->id)->count();
        }
        
        $resultLeads = [];
        foreach ($resultLeadsMappings as $targetSource => $keterangan) {
            $matchingIds = $sumbers->filter(function($s) use ($targetSource, $dbNameMapping) {
                $dbName = strtolower(trim($s->nama_sumber));
                $targetName = isset($dbNameMapping[$targetSource]) ? $dbNameMapping[$targetSource] : strtolower(trim($targetSource));
                return $dbName === $targetName;
            })->pluck('id')->toArray();
            
            $leadsBySumber = $leads->whereIn('sumber_id', $matchingIds);
            $resultLeads[] = [
                'sumber' => $targetSource,
                'keterangan' => $keterangan,
                'leads' => $leadsBySumber->count(),
                'no_report' => $leadsBySumber->whereIn('status_id', $noReportStatusId ? [$noReportStatusId] : [])->count(),
                'prospect' => $leadsBySumber->whereIn('status_id', $prospectStatusIds)->count(),
                'spk' => $leadsBySumber->whereIn('status_id', $spkStatusIds)->count(),
                'do' => $leadsBySumber->whereIn('status_id', $doStatusIds)->count(),
                'lost' => $leadsBySumber->whereIn('status_id', $lostStatusIds)->count(),
            ];
        }
        
        $spkDoLeads = $leads->whereIn('status_id', array_merge($spkStatusIds, $doStatusIds));
        // ===============================================

        $branches = ['ciawi', 'cianjur', 'cinere', 'jatiasih', 'cipanas'];
        $branchData = [];
        $bChartStatusLabels = ['UNFOLLOW UP', 'FOLLOW UP', 'PROSPEK', 'HOT PROSPEK', 'SPK', 'LOST', 'DO', 'NO REPORT'];

        foreach ($branches as $branch) {
            $bLeads = $leads->filter(function($q) use ($branch) {
                return stripos($q->cabang, $branch) !== false;
            });
            $bPrevLeads = $prevLeads->filter(function($q) use ($branch) {
                return stripos($q->cabang, $branch) !== false;
            });
            
            // Total & No Report
            $bNoReportCount = 0;
            if ($noReportStatusId) {
                $bNoReportCount = $bLeads->where('status_id', $noReportStatusId)->count();
            }
            
            // Chart Status (Branch specific with 8 separated statuses)
            $unfollowUpIds = $allStatuses->filter(function($s) { return strtolower(trim($s->nama_status)) === 'unfollow up'; })->pluck('id')->toArray();
            $followUpIds = $allStatuses->filter(function($s) { return strtolower(trim($s->nama_status)) === 'follow up'; })->pluck('id')->toArray();
            $prospekIds = $allStatuses->filter(function($s) { return strtolower(trim($s->nama_status)) === 'prospek'; })->pluck('id')->toArray();
            $hotProspekIds = $allStatuses->filter(function($s) { return strtolower(trim($s->nama_status)) === 'hot prospek'; })->pluck('id')->toArray();
            $spkIds = $allStatuses->filter(function($s) { return strtolower(trim($s->nama_status)) === 'spk'; })->pluck('id')->toArray();
            $lostIds = $allStatuses->filter(function($s) { return strtolower(trim($s->nama_status)) === 'lost' || strtolower(trim($s->nama_status)) === 'batal'; })->pluck('id')->toArray();
            $doIds = $allStatuses->filter(function($s) { return strtolower(trim($s->nama_status)) === 'do'; })->pluck('id')->toArray();

            $bChartStatusData = [
                !empty($unfollowUpIds) ? $bLeads->whereIn('status_id', $unfollowUpIds)->count() : 0,
                !empty($followUpIds) ? $bLeads->whereIn('status_id', $followUpIds)->count() : 0,
                !empty($prospekIds) ? $bLeads->whereIn('status_id', $prospekIds)->count() : 0,
                !empty($hotProspekIds) ? $bLeads->whereIn('status_id', $hotProspekIds)->count() : 0,
                !empty($spkIds) ? $bLeads->whereIn('status_id', $spkIds)->count() : 0,
                !empty($lostIds) ? $bLeads->whereIn('status_id', $lostIds)->count() : 0,
                !empty($doIds) ? $bLeads->whereIn('status_id', $doIds)->count() : 0,
                $bNoReportCount,
            ];
            
            // Source & Trend Source
            $bChartSourceData = [];
            $bPrevChartSourceData = [];
            $bTrendSourceData = [];
            foreach ($chartSourceLabels as $targetSource) {
                $matchingIds = $sumbers->filter(function($s) use ($targetSource, $dbNameMapping) {
                    $dbName = strtolower(trim($s->nama_sumber));
                    $targetName = isset($dbNameMapping[$targetSource]) ? $dbNameMapping[$targetSource] : strtolower(trim($targetSource));
                    return $dbName === $targetName;
                })->pluck('id')->toArray();
                
                $bChartSourceData[] = $bLeads->whereIn('sumber_id', $matchingIds)->count();
                $bPrevChartSourceData[] = $bPrevLeads->whereIn('sumber_id', $matchingIds)->count();
                
                $bSourceTrend = [];
                $bAllTrendLeadsSource = $allTrendLeads->filter(function($q) use ($branch) {
                    return stripos($q->cabang, $branch) !== false;
                })->whereIn('sumber_id', $matchingIds);
                for ($i = 1; $i <= 12; $i++) {
                    $bSourceTrend[] = $bAllTrendLeadsSource->filter(function($l) use ($i, $targetYear, $periodeTren) {
                        if ($periodeTren === 'custom') {
                            return (int)date('m', strtotime($l->tanggal)) === $i;
                        }
                        return (int)date('m', strtotime($l->tanggal)) === $i && (int)date('Y', strtotime($l->tanggal)) === (int)$targetYear;
                    })->count();
                }
                $bTrendSourceData[$targetSource] = $bSourceTrend;
            }
            
            // Trend Total
            $bMonthlyTrend = [];
            $bAllTrendLeadsTotal = $allTrendLeads->filter(function($q) use ($branch) {
                return stripos($q->cabang, $branch) !== false;
            });
            for ($i = 1; $i <= 12; $i++) {
                $bMonthlyTrend[] = $bAllTrendLeadsTotal->filter(function($l) use ($i, $targetYear, $periodeTren) {
                    if ($periodeTren === 'custom') {
                        return (int)date('m', strtotime($l->tanggal)) === $i;
                    }
                    return (int)date('m', strtotime($l->tanggal)) === $i && (int)date('Y', strtotime($l->tanggal)) === (int)$targetYear;
                })->count();
            }
            
            // Unit Chart
            $bChartUnitData = [];
            foreach ($units as $u) {
                $bChartUnitData[] = $bLeads->where('unit_id', $u->id)->count();
            }
            
            // Result Table
            $bResultLeads = [];
            foreach ($resultLeadsMappings as $targetSource => $keterangan) {
                $matchingIds = $sumbers->filter(function($s) use ($targetSource, $dbNameMapping) {
                    $dbName = strtolower(trim($s->nama_sumber));
                    $targetName = isset($dbNameMapping[$targetSource]) ? $dbNameMapping[$targetSource] : strtolower(trim($targetSource));
                    return $dbName === $targetName;
                })->pluck('id')->toArray();
                
                $leadsBySumber = $bLeads->whereIn('sumber_id', $matchingIds);
                $bResultLeads[] = [
                    'sumber' => $targetSource,
                    'keterangan' => $keterangan,
                    'leads' => $leadsBySumber->count(),
                    'no_report' => $leadsBySumber->whereIn('status_id', $noReportStatusId ? [$noReportStatusId] : [])->count(),
                    'prospect' => $leadsBySumber->whereIn('status_id', $prospectStatusIds)->count(),
                    'spk' => $leadsBySumber->whereIn('status_id', $spkStatusIds)->count(),
                    'do' => $leadsBySumber->whereIn('status_id', $doStatusIds)->count(),
                    'lost' => $leadsBySumber->whereIn('status_id', $lostStatusIds)->count(),
                ];
            }
            
            // SPK DO
            $bSpkDoLeads = $bLeads->whereIn('status_id', array_merge($spkStatusIds, $doStatusIds));
            
            $branchData[$branch] = [
                'totalLeads' => $bLeads->count(),
                'noReportCount' => $bNoReportCount,
                'chartStatusData' => $bChartStatusData,
                'chartSourceData' => $bChartSourceData,
                'prevChartSourceData' => $bPrevChartSourceData,
                'chartUnitData' => $bChartUnitData,
                'monthlyTrend' => $bMonthlyTrend,
                'trendSourceData' => $bTrendSourceData,
                'resultLeads' => $bResultLeads,
                'spkDoLeads' => $bSpkDoLeads,
            ];
        }

        return view('Sales.leads.dashboard', compact(
            'tanggal', 'tahun', 'periodeTren', 'periodeLabel',
            'totalCiawi', 'totalCianjur', 'totalCinere', 'totalJatiasih', 'totalCipanas',
            'totalLeads',
            'chartStatusLabels', 'chartSourceLabels', 'chartUnitLabels',
            'noReportCount', 'chartStatusData', 'chartSourceData', 'prevChartSourceData', 'monthlyTrend', 'trendSourceData', 
            'chartUnitData', 'resultLeads', 'spkDoLeads', 'budgets',
            'branches', 'branchData', 'bChartStatusLabels'
        ));
    }
}
