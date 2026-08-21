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
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
        $periodeTren = $request->input('periode_tren', 'tahun_ini');

        // Query leads for main widgets (filtered by global bulan/tahun)
        $leadsQuery = Lead::query();
        if ($tahun && $tahun !== 'semua') {
            $leadsQuery->whereYear('tanggal', $tahun);
        }
        if ($bulan && $bulan !== 'semua') {
            $leadsQuery->whereMonth('tanggal', $bulan);
        }
        $leads = $leadsQuery->get();

        // Top Level Total
        $totalCiawi = $leads->where('cabang', 'ciawi')->count();
        $totalCianjur = $leads->where('cabang', 'cianjur')->count();
        $totalCinere = $leads->where('cabang', 'cinere')->count();
        $totalJatiasih = $leads->where('cabang', 'jatiasih')->count();
        $totalCipanas = $leads->where('cabang', 'cipanas')->count();
        $totalLeads = $leads->count();

        // Base Setup
        $allStatuses = StatusLead::all();
        $spkStatusIds = $allStatuses->filter(function($s) { return stripos($s->nama_status, 'spk') !== false; })->pluck('id')->toArray();
        $doStatusIds = $allStatuses->filter(function($s) { return stripos($s->nama_status, 'do') !== false; })->pluck('id')->toArray();
        $prospectStatusIds = $allStatuses->filter(function($s) { return stripos($s->nama_status, 'prospect') !== false; })->pluck('id')->toArray();
        $lostStatusIds = $allStatuses->filter(function($s) { return stripos($s->nama_status, 'lost') !== false || stripos($s->nama_status, 'batal') !== false; })->pluck('id')->toArray();
        $noReportStatusId = $allStatuses->filter(function($s) { return stripos($s->nama_status, 'no report') !== false; })->pluck('id')->first();

        $sumbers = SumberLead::all();
        $units = UnitLead::all();
        
        // Budgets
        $budgets = BudgetLead::all();

        $resultLeadsMappings = [
            'Google Ads' => 'Web',
            'Web Official Dealer' => 'Organik',
            'FB/IG Official' => 'Sosmed',
            'FB/IG Cabang' => 'Sosmed',
            'GMB' => 'Google My Business'
        ];

        $chartStatusLabels = ['No Report', 'Prospect', 'SPK', 'DO', 'Lost'];
        $chartSourceLabels = ['Google Ads', 'Web Official Dealer', 'FB/IG Official', 'FB/IG Cabang', 'GMB'];
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
        $noReportCount = $leads->whereNull('status_id')->count();
        if ($noReportStatusId) {
            $noReportCount += $leads->where('status_id', $noReportStatusId)->count();
        }
        
        $chartStatusData = [
            $noReportCount,
            $leads->whereIn('status_id', $prospectStatusIds)->count(),
            $leads->whereIn('status_id', $spkStatusIds)->count(),
            $leads->whereIn('status_id', $doStatusIds)->count(),
            $leads->whereIn('status_id', $lostStatusIds)->count(),
        ];
        
        $chartSourceData = [];
        foreach ($chartSourceLabels as $targetSource) {
            $matchingIds = $sumbers->filter(function($s) use ($targetSource) {
                $dbName = strtolower(trim($s->nama_sumber));
                $targetName = strtolower(trim($targetSource));
                return strpos($dbName, $targetName) !== false || strpos($targetName, $dbName) !== false;
            })->pluck('id')->toArray();
            
            $chartSourceData[] = $leads->whereIn('sumber_id', $matchingIds)->count();
        }
        
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
            $matchingIds = $sumbers->filter(function($s) use ($targetSource) {
                $dbName = strtolower(trim($s->nama_sumber));
                $targetName = strtolower(trim($targetSource));
                return strpos($dbName, $targetName) !== false || strpos($targetName, $dbName) !== false;
            })->pluck('id')->toArray();
            
            $leadsBySumber = $leads->whereIn('sumber_id', $matchingIds);
            $resultLeads[] = [
                'sumber' => $targetSource,
                'keterangan' => $keterangan,
                'leads' => $leadsBySumber->count(),
                'no_report' => $leadsBySumber->whereIn('status_id', $noReportStatusId ? [$noReportStatusId] : [])->count() + $leadsBySumber->whereNull('status_id')->count(),
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

        foreach ($branches as $branch) {
            $bLeads = $leads->where('cabang', $branch);
            
            // Total & No Report
            $bNoReportCount = $bLeads->whereNull('status_id')->count();
            if ($noReportStatusId) {
                $bNoReportCount += $bLeads->where('status_id', $noReportStatusId)->count();
            }
            
            // Chart Status
            $bChartStatusData = [
                $bNoReportCount,
                $bLeads->whereIn('status_id', $prospectStatusIds)->count(),
                $bLeads->whereIn('status_id', $spkStatusIds)->count(),
                $bLeads->whereIn('status_id', $doStatusIds)->count(),
                $bLeads->whereIn('status_id', $lostStatusIds)->count(),
            ];
            
            // Source & Trend Source
            $bChartSourceData = [];
            $bTrendSourceData = [];
            foreach ($chartSourceLabels as $targetSource) {
                $matchingIds = $sumbers->filter(function($s) use ($targetSource) {
                    $dbName = strtolower(trim($s->nama_sumber));
                    $targetName = strtolower(trim($targetSource));
                    return strpos($dbName, $targetName) !== false || strpos($targetName, $dbName) !== false;
                })->pluck('id')->toArray();
                
                $bChartSourceData[] = $bLeads->whereIn('sumber_id', $matchingIds)->count();
                
                $bSourceTrend = [];
                $bAllTrendLeadsSource = $allTrendLeads->where('cabang', $branch)->whereIn('sumber_id', $matchingIds);
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
            $bAllTrendLeadsTotal = $allTrendLeads->where('cabang', $branch);
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
                $matchingIds = $sumbers->filter(function($s) use ($targetSource) {
                    $dbName = strtolower(trim($s->nama_sumber));
                    $targetName = strtolower(trim($targetSource));
                    return strpos($dbName, $targetName) !== false || strpos($targetName, $dbName) !== false;
                })->pluck('id')->toArray();
                
                $leadsBySumber = $bLeads->whereIn('sumber_id', $matchingIds);
                $bResultLeads[] = [
                    'sumber' => $targetSource,
                    'keterangan' => $keterangan,
                    'leads' => $leadsBySumber->count(),
                    'no_report' => $leadsBySumber->whereIn('status_id', $noReportStatusId ? [$noReportStatusId] : [])->count() + $leadsBySumber->whereNull('status_id')->count(),
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
                'chartUnitData' => $bChartUnitData,
                'monthlyTrend' => $bMonthlyTrend,
                'trendSourceData' => $bTrendSourceData,
                'resultLeads' => $bResultLeads,
                'spkDoLeads' => $bSpkDoLeads,
            ];
        }

        return view('Sales.leads.dashboard', compact(
            'bulan', 'tahun', 'periodeTren',
            'totalCiawi', 'totalCianjur', 'totalCinere', 'totalJatiasih', 'totalCipanas',
            'totalLeads',
            'chartStatusLabels', 'chartSourceLabels', 'chartUnitLabels',
            'noReportCount', 'chartStatusData', 'chartSourceData', 'monthlyTrend', 
            'chartUnitData', 'resultLeads', 'spkDoLeads', 'budgets',
            'branches', 'branchData'
        ));
    }
}
