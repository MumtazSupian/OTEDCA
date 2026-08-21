<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceAc;

use App\Http\Controllers\Controller;

class MainDashboardController extends Controller
{
    private $branchCodeToNameMap = [
        '641940101' => 'Ciawi',
        '641940102' => 'Cianjur',
        '641940103' => 'Cinere',
        '641940104' => 'Jatiasih',
        '641940106' => 'Cipanas',
    ];

    private function formatSalesModelName($modelCode) {
        $c = strtoupper(trim($modelCode ?? ''));
        if (empty($c) || $c === 'UNKNOWN') return 'LAIN-LAIN';
        if (str_contains($c, '36FD') || str_contains($c, 'FDMT')) return 'NEW CARRY';
        if (str_contains($c, '46FD') || str_contains($c, 'FD AC')) return 'NEW CARRY';
        if (str_contains($c, '46WD') || str_contains($c, 'WD')) return 'NEW CARRY';
        if (str_starts_with($c, 'AEV') || str_contains($c, 'CARRY') || str_contains($c, 'ST150') || str_contains($c, 'ST100')) return 'NEW CARRY';
        if (str_contains($c, '54HB') || str_contains($c, 'ALPHA')) return 'NEW XL-7';
        if (str_contains($c, '35GS') || str_contains($c, 'BETA')) return 'NEW XL-7';
        if (str_contains($c, '34GS') || str_contains($c, 'ZETA')) return 'NEW XL-7';
        if (str_starts_with($c, 'XL7') || str_contains($c, 'XL-7') || str_contains($c, 'XL 7')) return 'NEW XL-7';
        if (str_starts_with($c, 'BU4') || str_contains($c, 'FRONX')) return 'FRONX';
        if (str_starts_with($c, 'GC4') || str_contains($c, 'APV')) return 'APV';
        if (str_starts_with($c, 'ARK') || str_starts_with($c, 'NC4') || str_contains($c, 'ERTIGA') || str_contains($c, 'A3L')) return 'ERTIGA-HYBRID';
        if (str_starts_with($c, 'DN4') || str_contains($c, 'SPRESO') || str_contains($c, 'S-PRESSO')) return 'S-PRESSO';
        if (str_contains($c, 'VITARA') || str_contains($c, 'GV')) return 'GRAND-VITARA';
        if (str_contains($c, 'JIMNY') || str_contains($c, 'JIMMY') || str_contains($c, 'JB74') || str_contains($c, 'JB674') || str_contains($c, '6N415')) return 'JIMMY';
        return $c;
    }

    private function buildMobilStats($spkData, $doData)
    {
        $imageMap = [
            'NEW CARRY'     => 'Suzuki-Carry.png',
            'APV'           => 'Suzuki-Apv.png',
            'ERTIGA-HYBRID' => 'Suzuki-Ertiga-Hybrid.png', 
            'NEW XL-7'      => 'XL7_Hybrid.png',         
            'GRAND-VITARA'  => 'Grand-Vitara.png',
            'JIMMY'         => 'Jimmy.png',
            'FRONX'         => 'suzuki-fronx.png',
            'S-PRESSO'      => 'Suzuki-Spresso.png'
        ];

        $normalizeMobilName = function ($namaMobil) {
            $namaMobil = trim(strtoupper($namaMobil ?? ''));
            if ($namaMobil === '') return '';
            if (str_contains($namaMobil, 'JIMNY')) return 'JIMMY';
            if (str_contains($namaMobil, 'ERTIGA')) return 'ERTIGA-HYBRID';
            if (str_contains($namaMobil, 'NEW CARRY') || str_contains($namaMobil, 'CARRY')) return 'NEW CARRY';
            if (str_contains($namaMobil, 'APV')) return 'APV';
            if (str_contains($namaMobil, 'GRAND') && str_contains($namaMobil, 'VITARA')) return 'GRAND-VITARA';
            if (str_contains($namaMobil, 'XL-7') || str_contains($namaMobil, 'XL7')) return 'NEW XL-7';
            if (str_contains($namaMobil, 'FRONX')) return 'FRONX';
            if (str_contains($namaMobil, 'S-PRESSO') || str_contains($namaMobil, 'SPRESSO')) return 'S-PRESSO';
            return $namaMobil;
        };

        $groupedSpk = $spkData->groupBy(function ($item) use ($normalizeMobilName) {
            return $normalizeMobilName($item->jenis_unit);
        });

        $groupedDo = $doData->groupBy(function ($item) use ($normalizeMobilName) {
            return $normalizeMobilName($item->jenis_unit);
        });

        $totalSpkAll = 0;
        $totalDoAll = 0;

        $mobilStats = collect($imageMap)->map(function ($imageFile, $namaMobil) use ($groupedSpk, $groupedDo, &$totalSpkAll, &$totalDoAll) {
            $spkGroup = $groupedSpk->get($namaMobil, collect());
            $doGroup = $groupedDo->get($namaMobil, collect());
            
            $spkDetails = $spkGroup->groupBy('type_unit')
                ->map(fn($g) => $g->count());
                
            $doDetails = $doGroup->groupBy('type_unit')
                ->map(fn($g) => $g->count());
                
            $total_spk = $spkDetails->sum();
            $total_do = $doDetails->sum();
            
            $totalSpkAll += $total_spk;
            $totalDoAll += $total_do;

            return (object)[
                'nama_mobil' => $namaMobil,
                'image'      => $imageFile,
                'spk'        => $spkDetails->filter(fn($val) => $val > 0),
                'do'         => $doDetails->filter(fn($val) => $val > 0),
                'total_spk'  => $total_spk,
                'total_do'   => $total_do,
            ];
        })->values();

        return (object)[
            'mobilStats' => $mobilStats,
            'totalSpkAll' => $totalSpkAll,
            'totalDoAll' => $totalDoAll
        ];
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $cabang = $user->cabang ?: ($user->branch ?: 'Ciawi');

        $bulanMap = [
            1 => 'jan', 2 => 'feb', 3 => 'mar', 4 => 'apr', 5 => 'mei', 6 => 'jun',
            7 => 'jul', 8 => 'agu', 9 => 'sep', 10 => 'okt', 11 => 'nov', 12 => 'des'
        ];

        $selectedBulan = strtolower($request->input('bulan', $bulanMap[now()->month]));
        $monthNum = (int)array_search($selectedBulan, $bulanMap);
        if (!$monthNum) $monthNum = now()->month;
        $year = now()->year;
        
        $isPusat = ($user->is_admin ?? false) || 
                   in_array(strtolower(trim($user->branch ?? '')), ['admin', 'pusat']) || 
                   in_array(strtolower(trim($user->role ?? '')), ['admin', 'om', 'admin dca', 'om dca', 'ho_unit']);

        // SPK Data:
        // Cianjur (641940102) & Cipanas (641940106) pmKDP SPKDate
        $spkPmkdp = DB::connection('dms')->table('pmKDP')
            ->whereIn('BranchCode', ['641940102', '641940106'])
            ->whereMonth('SPKDate', $monthNum)
            ->whereYear('SPKDate', $year)
            ->select(['BranchCode', 'InquiryNumber', 'TipeKendaraan'])
            ->get();

        // Ciawi (641940101), Cinere (641940103), Jatiasih (641940104) salesAppTable PBK
        $spkSat = DB::connection('dms')->table('salesAppTable as t')
            ->leftJoin('pmKDP as p', 't.InquiryNumber', '=', 'p.InquiryNumber')
            ->whereIn('t.BranchCode', ['641940101', '641940103', '641940104'])
            ->whereNotNull('t.HID')
            ->where('t.HID', 'like', 'PBK%')
            ->where(function($q) use ($monthNum, $year) {
                $q->where(function($s) use ($monthNum, $year) {
                    $s->whereMonth('t.CreationDate', $monthNum)->whereYear('t.CreationDate', $year);
                })->orWhere(function($s) {
                    // Include Jatiasih cutoff
                    $s->where('t.BranchCode', '641940104')->whereIn('t.InquiryNumber', [482285, 482811]);
                });
            })
            ->select(['t.BranchCode', 't.InquiryNumber', 'p.TipeKendaraan', 't.TipeKendaraan2'])
            ->get();

        $spkDataAll = collect();
        foreach ($spkPmkdp as $rec) {
            $cb = $this->branchCodeToNameMap[trim($rec->BranchCode ?? '')] ?? trim($rec->BranchCode ?? '');
            $tipe = trim($rec->TipeKendaraan ?? '');
            $jenisUnit = $this->formatSalesModelName($tipe);

            $spkDataAll->push((object)[
                'cabang' => $cb,
                'jenis_unit' => $jenisUnit,
                'type_unit' => $tipe !== '' ? $tipe : 'UNKNOWN',
            ]);
        }
        foreach ($spkSat as $rec) {
            $cb = $this->branchCodeToNameMap[trim($rec->BranchCode ?? '')] ?? trim($rec->BranchCode ?? '');
            $tipe = trim($rec->TipeKendaraan ?? ($rec->TipeKendaraan2 ?? ''));
            if (empty($tipe)) {
                $tipe = trim($rec->TipeKendaraan2 ?? '');
            }
            $jenisUnit = $this->formatSalesModelName($tipe);

            $spkDataAll->push((object)[
                'cabang' => $cb,
                'jenis_unit' => $jenisUnit,
                'type_unit' => $tipe !== '' ? $tipe : 'UNKNOWN',
            ]);
        }

        // DO Data directly from pmKDP (by LastUpdateStatus & LastProgress DELIVERY/DO)
        $doRecords = DB::connection('dms')->table('pmKDP')
            ->whereMonth('LastUpdateStatus', $monthNum)
            ->whereYear('LastUpdateStatus', $year)
            ->where(function($q) {
                $q->whereIn(DB::raw("TRIM(UPPER(LastProgress))"), ['DELIVERY', 'DO'])
                  ->orWhere('StatusProspek', '60');
            })
            ->select(['BranchCode', 'InquiryNumber', 'TipeKendaraan'])
            ->get();

        $doDataAll = collect();
        foreach ($doRecords as $rec) {
            $cb = $this->branchCodeToNameMap[trim($rec->BranchCode ?? '')] ?? trim($rec->BranchCode ?? '');
            $tipe = trim($rec->TipeKendaraan ?? '');
            $jenisUnit = $this->formatSalesModelName($tipe);

            $doDataAll->push((object)[
                'cabang' => $cb,
                'jenis_unit' => $jenisUnit,
                'type_unit' => $tipe !== '' ? $tipe : 'UNKNOWN',
            ]);
        }

        $sections = [];

        if ($isPusat) {
            $statsAll = $this->buildMobilStats($spkDataAll, $doDataAll);
            $sections[] = (object)[
                'title' => 'Semua Cabang',
                'mobilStats' => $statsAll->mobilStats,
                'totalSpk' => $statsAll->totalSpkAll,
                'totalDo' => $statsAll->totalDoAll
            ];

            $cabangs = ['Ciawi', 'Cianjur', 'Cinere', 'Jatiasih', 'Cipanas'];
            foreach ($cabangs as $cb) {
                $spkCb = $spkDataAll->filter(fn($i) => strtolower($i->cabang) == strtolower($cb));
                $doCb = $doDataAll->filter(fn($i) => strtolower($i->cabang) == strtolower($cb));
                $statsCb = $this->buildMobilStats($spkCb, $doCb);
                $sections[] = (object)[
                    'title' => 'Cabang ' . $cb,
                    'mobilStats' => $statsCb->mobilStats,
                    'totalSpk' => $statsCb->totalSpkAll,
                    'totalDo' => $statsCb->totalDoAll
                ];
            }
        } else {
            $spkCb = $spkDataAll->filter(fn($i) => strtolower($i->cabang) == strtolower($cabang));
            $doCb = $doDataAll->filter(fn($i) => strtolower($i->cabang) == strtolower($cabang));
            $statsCb = $this->buildMobilStats($spkCb, $doCb);
            $sections[] = (object)[
                'title' => 'Cabang ' . ucfirst(strtolower($cabang)),
                'mobilStats' => $statsCb->mobilStats,
                'totalSpk' => $statsCb->totalSpkAll,
                'totalDo' => $statsCb->totalDoAll
            ];
        }


        // --- DATA SERVICE AC ---
        $m = $monthNum;
        $y = $year;
        $filterDateStr = sprintf('%04d-%02d-01', $y, $m);

        $branchServiceMap = [
            'CIAWI' => '641940101',
            'CIANJUR' => '641940102',
            'CINERE' => '641940103',
            'JATIASIH' => '641940104',
        ];

        // 1. Fetch Targets from svMstTarget (Target referensi tahun 2025 sesuai data master DMS)
        $targetYear = 2025;
        $targets = DB::connection('dms')->table('svMstTarget')
            ->where('PeriodYear', $targetYear)
            ->where('PeriodMonth', $m)
            ->whereIn('BranchCode', array_values($branchServiceMap))
            ->get()
            ->keyBy('BranchCode');

        // 2. Fetch Month Service Units from svTrnService (tgl 1 s/d tgl berjalan)
        $monthUnits = DB::connection('dms')->table('svTrnService')
            ->whereYear('JobOrderDate', $y)
            ->whereMonth('JobOrderDate', $m)
            ->whereIn('BranchCode', array_values($branchServiceMap))
            ->select('BranchCode', DB::raw('count(*) as total_bulan'))
            ->groupBy('BranchCode')
            ->get()
            ->keyBy('BranchCode');

        // 3. Fetch Today Service Units from svTrnService (hari ini)
        $isCurrentMonth = ($y == intval(date('Y')) && $m == intval(date('m')));
        $todayUnits = collect();
        if ($isCurrentMonth) {
            $todayUnits = DB::connection('dms')->table('svTrnService')
                ->whereDate('JobOrderDate', date('Y-m-d'))
                ->whereIn('BranchCode', array_values($branchServiceMap))
                ->select('BranchCode', DB::raw('count(*) as total_hari_ini'))
                ->groupBy('BranchCode')
                ->get()
                ->keyBy('BranchCode');
        }

        $soms = ServiceAc::where('periode', $filterDateStr)->get();
        $dataCabangService = [
            'CIAWI' => ['entry' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0], 'spooring' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0], 'ac' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0]],
            'CIANJUR' => ['entry' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0], 'spooring' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0], 'ac' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0]],
            'CINERE' => ['entry' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0], 'spooring' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0], 'ac' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0]],
            'JATIASIH' => ['entry' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0], 'spooring' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0], 'ac' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0]],
        ];

        foreach ($soms as $som) {
            $cab = strtoupper($som->cabang);
            if (isset($dataCabangService[$cab])) {
                $dataCabangService[$cab] = [
                    'entry' => ['bulan' => $som->unit_entry_bulan, 'hari_ini' => $som->unit_entry_hari_ini, 'target' => $som->unit_entry_target],
                    'spooring' => ['bulan' => $som->unit_spooring_bulan, 'hari_ini' => $som->unit_spooring_hari_ini, 'target' => $som->unit_spooring_target],
                    'ac' => ['bulan' => $som->unit_ac_bulan, 'hari_ini' => $som->unit_ac_hari_ini, 'target' => $som->unit_ac_target],
                ];
            }
        }

        // Set / Override UNIT ENTRY SERVICE from DMS (svTrnService & svMstTarget)
        foreach ($branchServiceMap as $cabName => $bCode) {
            $targetVal = isset($targets[$bCode]) ? intval($targets[$bCode]->TotalUnitService) : ($dataCabangService[$cabName]['entry']['target'] ?? 0);
            $bulanVal = isset($monthUnits[$bCode]) ? intval($monthUnits[$bCode]->total_bulan) : ($dataCabangService[$cabName]['entry']['bulan'] ?? 0);
            $hariIniVal = isset($todayUnits[$bCode]) ? intval($todayUnits[$bCode]->total_hari_ini) : ($isCurrentMonth ? 0 : ($dataCabangService[$cabName]['entry']['hari_ini'] ?? 0));

            $dataCabangService[$cabName]['entry'] = [
                'bulan' => $bulanVal,
                'hari_ini' => $hariIniVal,
                'target' => $targetVal,
            ];
        }

        if (!$isPusat) {
            $myCabang = strtoupper($cabang);
            if (isset($dataCabangService[$myCabang])) {
                $dataCabangService = [$myCabang => $dataCabangService[$myCabang]];
            } else {
                $dataCabangService = [];
            }
        }

        return view('dashboard', [
            'isPusat' => $isPusat,
            'cabang' => $cabang,
            'selectedBulan' => strtoupper($selectedBulan),
            'sections' => $sections,
            'bulanMap' => $bulanMap,
            'dataCabangService' => $dataCabangService,
        ]);
    }
}
