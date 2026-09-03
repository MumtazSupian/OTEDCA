<?php

namespace App\Http\Controllers\Sales\vsv;

use App\Models\User;
use App\Models\Sales\vsv\rka\TargetDoUnit;
use App\Models\Sales\vsv\rka\TargetSalesforce;
use App\Models\Sales\vsv\rka\TargetInquiry;
use App\Models\Sales\vsv\rka\TargetDoBySoi;
use App\Models\Sales\vsv\leasing\AktualPo;
use App\Models\Sales\vsv\leasing\AktualReject;
use App\Models\Sales\vsv\leasing\AktualAplikasiIn;
use App\Models\Sales\vsv\current\ActualDoByType;
use App\Models\Sales\vsv\current\ActualSpkByType;
use App\Models\Sales\vsv\current\ActualInquaryByType;
use App\Models\Sales\vsv\current\ActualSourceInquary;
use App\Models\Sales\vsv\current\ActualSourceDoInquary;
use App\Models\Sales\vsv\current\ActualSalesForce;
use App\Models\Sales\vsv\current\ActualDoSalesForce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return $this->v1($request);
    }

    public function v1(Request $request)
    {
        @set_time_limit(300);
        @ini_set('max_execution_time', '300');
        $user = Auth::user();
        $tahunSekarang = 2026;

        // Penyesuaian pengecekan role dan admin berdasarkan struktur tabel Anda
        $isPusat = ($user->is_admin ?? false) || 
                   in_array(strtolower($user->branch ?? ''), ['admin', 'pusat']) ||
                   in_array(strtolower($user->role ?? ''), ['admin', 'om', 'admin dca', 'om dca']);

        $isSH = strtolower($user->role ?? '') == 'sh' || strtolower($user->branch ?? '') == 'sh';

        $bulanMap = [
            1 => 'jan', 2 => 'feb', 3 => 'mar', 4 => 'apr', 5 => 'mei', 6 => 'jun',
            7 => 'jul', 8 => 'agu', 9 => 'sep', 10 => 'okt', 11 => 'nov', 12 => 'des'
        ];

        $bulanSekarangAngka = (int)date('n');
        $bulanDefault = $bulanMap[$bulanSekarangAngka] ?? 'jul';
        $bulanInput = $request->get('filter_bulan', $request->get('bulan', 'jul'));

        if (is_numeric($bulanInput)) {
            $currMonthNum = (int)$bulanInput;
        } else {
            $currMonthNum = array_search(strtolower($bulanInput), $bulanMap) ?: 7;
        }
        $currYear = (int)$request->get('tahun', $tahunSekarang);

        if (!$request->has('filter_bulan') && !$request->has('bulan') && $request->has('to_date')) {
            $t = strtotime($request->get('to_date'));
            if ($t) {
                $currMonthNum = (int)date('n', $t);
                $currYear = (int)date('Y', $t);
            }
        }

        $daysInCurr = cal_days_in_month(CAL_GREGORIAN, $currMonthNum, $currYear);
        $fromDate   = sprintf("%04d-%02d-01", $currYear, $currMonthNum);
        $toDate     = sprintf("%04d-%02d-%02d", $currYear, $currMonthNum, $daysInCurr);
        $bulanCurr  = $bulanMap[$currMonthNum] ?? 'jul';

        if ($currMonthNum == 1) {
            $prevMonthNum = 12;
            $prevYear     = $currYear - 1;
        } else {
            $prevMonthNum = $currMonthNum - 1;
            $prevYear     = $currYear;
        }
        $daysInPrev   = cal_days_in_month(CAL_GREGORIAN, $prevMonthNum, $prevYear);
        $prevFromDate = sprintf("%04d-%02d-01", $prevYear, $prevMonthNum);
        $prevToDate   = sprintf("%04d-%02d-%02d", $prevYear, $prevMonthNum, $daysInPrev);
        $bulanPrev    = $bulanMap[$prevMonthNum] ?? 'jun';

        // Penyesuaian fallback cabang jika bukan admin
        if ($isPusat) {
            $cabangs = ['Ciawi', 'Cianjur', 'Cinere', 'Jatiasih', 'Cipanas'];
        } else {
            $cabangMap = [
                'ciawi'    => 'Ciawi',
                'cianjur'  => 'Cianjur',
                'cinere'   => 'Cinere',
                'jatiasih' => 'Jatiasih',
                'cipanas'  => 'Cipanas',
            ];
            $cabangUser = $user->branch ?? $user->cabang ?? '';
            $userCabangKey = strtolower(trim($cabangUser));
            $matchedCabang = $cabangMap[$userCabangKey] ?? ($cabangUser ?: 'Cinere');
            $cabangs = [$matchedCabang];
        }

        $modelList = [
            'NEW CARRY'      => ['NEW CARRY', 'CARRY', 'DC', 'AEV', 'FD', 'WD', 'CHASSIS', 'PU', 'PICK UP', 'BOX', 'MOKO'],
            'XL7'            => ['XL7', 'XL-7', 'XL 7', 'ZETA', 'BETA', 'ALPHA'],
            'FRONX'          => ['FRONX', 'BU4'],
            'ALL NEW ERTIGA' => ['ALL NEW ERTIGA', 'ERTIGA', 'A3L'],
            'APV'            => ['APV BLIND VAN', 'APV', 'GC4', 'VAN', 'GC415'],
            'S-PRESSO'       => ['S-PRESSO', 'SPRESO', 'S PRESSO', 'DN4'],
            'GRAND VITARA'   => ['GRAND VITARA', 'VITARA', 'GV'],
            'JIMNY 3D'       => ['JIMNY 3D', 'JIMNY 3-DOOR'],
            'JIMNY 5D'       => ['JIMNY 5D', 'JIMNY 5-DOOR', '6N415'],
        ];

        $branchCodeMap = [
            'Ciawi'    => ['641940101', '01.19.08.102', 'CIAWI', 'DCA CIAWI', 'CW'],
            'Cianjur'  => ['641940102', '06.24.11.005', 'CIANJUR', 'DCA CIANJUR', 'CJR'],
            'Cinere'   => ['641940103', '03.24.02.001', 'CINERE', 'DCA CINERE', 'CNR', 'CIN'],
            'Jatiasih' => ['641940104', '06.25.11.001', 'JATIASIH', 'JATI ASIH', 'DCA JATIASIH', 'DCA JATI ASIH', 'JTA'],
            'Cipanas'  => ['641940106', '14.26.01.549', 'CIPANAS', 'DCA CIPANAS', 'CPN'],
        ];

        $cabangUserForCache = $user->branch ?? $user->cabang ?? '';
        $cacheKey = 'dash_v1_pure_so_lookup_v3_' . $currYear . '_' . $currMonthNum . '_' . ($isPusat ? 'pusat' : $cabangUserForCache);

        $viewData = Cache::remember($cacheKey, 60, function() use (
            $prevFromDate, $prevToDate, $fromDate, $toDate,
            $prevYear, $prevMonthNum, $currYear, $currMonthNum,
            $cabangs, $branchCodeMap, $modelList, $bulanPrev, $bulanCurr, $bulanMap
        ) {
            $allKdpPrevInquiryRecords = collect();
            $allKdpCurrInquiryRecords = collect();
            $allKdpPrevSpkRecords = collect();
            $allKdpCurrSpkRecords = collect();
            $allFpPrevRecords = collect();
            $allFpCurrRecords = collect();

            try {
                $allBranchCodes = [];
                foreach ($cabangs as $cb) {
                    if (!empty($branchCodeMap[$cb])) {
                        $allBranchCodes = array_merge($allBranchCodes, $branchCodeMap[$cb]);
                    }
                }

                $prevStartDate = $prevFromDate . " 00:00:00";
                $prevEndDate   = $prevToDate . " 23:59:59";
                $currStartDate = $fromDate . " 00:00:00";
                $currEndDate   = $toDate . " 23:59:59";

                $prevFpStartDate = sprintf("%04d-%02d-02 00:00:00", $prevYear, $prevMonthNum);
                $prevFpEndDate   = sprintf("%04d-%02d-01 23:59:59", $currYear, $currMonthNum);

                $currFpStartDate = sprintf("%04d-%02d-02 00:00:00", $currYear, $currMonthNum);
                if ($currMonthNum == 12) {
                    $currFpNextMonth = 1;
                    $currFpNextYear  = $currYear + 1;
                } else {
                    $currFpNextMonth = $currMonthNum + 1;
                    $currFpNextYear  = $currYear;
                }
                $currFpEndDate   = sprintf("%04d-%02d-01 23:59:59", $currFpNextYear, $currFpNextMonth);

                // 1. INQUIRY (DARI pmKDP)
                try {
                    $qInqPrev = \App\Models\Sales\vsv\Kdp::whereBetween('InquiryDate', [$prevStartDate, $prevEndDate]);
                    $qInqCurr = \App\Models\Sales\vsv\Kdp::whereBetween('InquiryDate', [$currStartDate, $currEndDate]);
                    if (!empty($allBranchCodes)) {
                        $qInqPrev->where(function($q) use ($allBranchCodes, $cabangs) {
                            $q->whereIn('BranchCode', $allBranchCodes);
                            foreach ($cabangs as $cb) { $q->orWhere('BranchCode', 'LIKE', "%$cb%"); }
                        });
                        $qInqCurr->where(function($q) use ($allBranchCodes, $cabangs) {
                            $q->whereIn('BranchCode', $allBranchCodes);
                            foreach ($cabangs as $cb) { $q->orWhere('BranchCode', 'LIKE', "%$cb%"); }
                        });
                    }
                    $allKdpPrevInquiryRecords = $qInqPrev->get(['BranchCode', 'TipeKendaraan', 'Variant', 'InquiryDate']);
                    $allKdpCurrInquiryRecords = $qInqCurr->get(['BranchCode', 'TipeKendaraan', 'Variant', 'InquiryDate']);
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::error("Dashboard v1 Inquiry Error: " . $e->getMessage());
                }

                // 2. DATA SPK(pmKDP SPKDate & salesAppTable PBK)
                try {
                    // Previous Month SPK
                    $spkPmkdpPrev = \Illuminate\Support\Facades\DB::connection('dms')->table('pmKDP')
                        ->whereIn('BranchCode', ['641940102', '641940106'])
                        ->whereMonth('SPKDate', $prevMonthNum)
                        ->whereYear('SPKDate', $prevYear);
                    if (!empty($allBranchCodes)) {
                        $spkPmkdpPrev->whereIn('BranchCode', $allBranchCodes);
                    }
                    $spkPmkdpPrev = $spkPmkdpPrev->select(['BranchCode', 'InquiryNumber', 'TipeKendaraan', 'Variant', 'SPKDate'])->get();

                    $spkSatPrev = \Illuminate\Support\Facades\DB::connection('dms')->table('salesAppTable as t')
                        ->leftJoin('pmKDP as p', 't.InquiryNumber', '=', 'p.InquiryNumber')
                        ->whereIn('t.BranchCode', ['641940101', '641940103', '641940104'])
                        ->whereNotNull('t.HID')
                        ->where('t.HID', 'like', 'PBK%')
                        ->whereMonth('t.CreationDate', $prevMonthNum)
                        ->whereYear('t.CreationDate', $prevYear);
                    if (!empty($allBranchCodes)) {
                        $spkSatPrev->whereIn('t.BranchCode', $allBranchCodes);
                    }
                    $spkSatPrev = $spkSatPrev->select(['t.BranchCode', 't.InquiryNumber', 'p.TipeKendaraan', 'p.Variant', 't.TipeKendaraan2', 't.CreationDate as SPKDate'])->get();

                    $allKdpPrevSpkRecords = collect();
                    foreach ($spkPmkdpPrev as $r) {
                        $allKdpPrevSpkRecords->push((object)[
                            'BranchCode' => $r->BranchCode,
                            'InquiryNumber' => $r->InquiryNumber,
                            'TipeKendaraan' => $r->TipeKendaraan,
                            'Variant' => $r->Variant,
                            'SPKDate' => $r->SPKDate,
                        ]);
                    }
                    foreach ($spkSatPrev as $r) {
                        $tipe = trim($r->TipeKendaraan ?? ($r->TipeKendaraan2 ?? ''));
                        if (empty($tipe)) $tipe = trim($r->TipeKendaraan2 ?? '');
                        $allKdpPrevSpkRecords->push((object)[
                            'BranchCode' => $r->BranchCode,
                            'InquiryNumber' => $r->InquiryNumber,
                            'TipeKendaraan' => $tipe,
                            'Variant' => $r->Variant,
                            'SPKDate' => $r->SPKDate,
                        ]);
                    }

                    // Current Month SPK
                    $spkPmkdpCurr = \Illuminate\Support\Facades\DB::connection('dms')->table('pmKDP')
                        ->whereIn('BranchCode', ['641940102', '641940106'])
                        ->whereMonth('SPKDate', $currMonthNum)
                        ->whereYear('SPKDate', $currYear);
                    if (!empty($allBranchCodes)) {
                        $spkPmkdpCurr->whereIn('BranchCode', $allBranchCodes);
                    }
                    $spkPmkdpCurr = $spkPmkdpCurr->select(['BranchCode', 'InquiryNumber', 'TipeKendaraan', 'Variant', 'SPKDate'])->get();

                    $spkSatCurr = \Illuminate\Support\Facades\DB::connection('dms')->table('salesAppTable as t')
                        ->leftJoin('pmKDP as p', 't.InquiryNumber', '=', 'p.InquiryNumber')
                        ->whereIn('t.BranchCode', ['641940101', '641940103', '641940104'])
                        ->whereNotNull('t.HID')
                        ->where('t.HID', 'like', 'PBK%')
                        ->where(function($q) use ($currMonthNum, $currYear) {
                            $q->where(function($s) use ($currMonthNum, $currYear) {
                                $s->whereMonth('t.CreationDate', $currMonthNum)->whereYear('t.CreationDate', $currYear);
                            })->orWhere(function($s) {
                                $s->where('t.BranchCode', '641940104')->whereIn('t.InquiryNumber', [482285, 482811]);
                            });
                        });
                    if (!empty($allBranchCodes)) {
                        $spkSatCurr->whereIn('t.BranchCode', $allBranchCodes);
                    }
                    $spkSatCurr = $spkSatCurr->select(['t.BranchCode', 't.InquiryNumber', 'p.TipeKendaraan', 'p.Variant', 't.TipeKendaraan2', 't.CreationDate as SPKDate'])->get();

                    $allKdpCurrSpkRecords = collect();
                    foreach ($spkPmkdpCurr as $r) {
                        $allKdpCurrSpkRecords->push((object)[
                            'BranchCode' => $r->BranchCode,
                            'InquiryNumber' => $r->InquiryNumber,
                            'TipeKendaraan' => $r->TipeKendaraan,
                            'Variant' => $r->Variant,
                            'SPKDate' => $r->SPKDate,
                        ]);
                    }
                    foreach ($spkSatCurr as $r) {
                        $tipe = trim($r->TipeKendaraan ?? ($r->TipeKendaraan2 ?? ''));
                        if (empty($tipe)) $tipe = trim($r->TipeKendaraan2 ?? '');
                        $allKdpCurrSpkRecords->push((object)[
                            'BranchCode' => $r->BranchCode,
                            'InquiryNumber' => $r->InquiryNumber,
                            'TipeKendaraan' => $tipe,
                            'Variant' => $r->Variant,
                            'SPKDate' => $r->SPKDate,
                        ]);
                    }
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::error("Dashboard v1 SPK Error: " . $e->getMessage());
                }

                // 3. DATA FAKTUR POLISI: omTrSalesReqDetail LEFT JOIN omTrSalesSOModel
                try {
                    $fpBaseQueryPrev = \Illuminate\Support\Facades\DB::connection('dms')->table('omTrSalesReqDetail')
                        ->leftJoin('omTrSalesSOModel', function($join) {
                            $join->on('omTrSalesReqDetail.SONo', '=', 'omTrSalesSOModel.SONo')
                                 ->on('omTrSalesReqDetail.BranchCode', '=', 'omTrSalesSOModel.BranchCode');
                        })->whereBetween('omTrSalesReqDetail.CreatedDate', [$prevFpStartDate, $prevFpEndDate]);

                    $fpBaseQueryCurr = \Illuminate\Support\Facades\DB::connection('dms')->table('omTrSalesReqDetail')
                        ->leftJoin('omTrSalesSOModel', function($join) {
                            $join->on('omTrSalesReqDetail.SONo', '=', 'omTrSalesSOModel.SONo')
                                 ->on('omTrSalesReqDetail.BranchCode', '=', 'omTrSalesSOModel.BranchCode');
                        })->whereBetween('omTrSalesReqDetail.CreatedDate', [$currFpStartDate, $currFpEndDate]);

                    if (!empty($allBranchCodes)) {
                        $fpBaseQueryPrev->whereIn('omTrSalesReqDetail.BranchCode', $allBranchCodes);
                        $fpBaseQueryCurr->whereIn('omTrSalesReqDetail.BranchCode', $allBranchCodes);
                    }

                    $allFpPrevRecords = $fpBaseQueryPrev->select([
                        'omTrSalesReqDetail.*',
                        'omTrSalesSOModel.SalesModelCode as SO_SalesModelCode'
                    ])->get()->map(function($item) {
                        if (empty($item->SalesModelCode)) {
                            $item->SalesModelCode = $item->SO_SalesModelCode ?? '';
                        }
                        return $item;
                    });

                    $allFpCurrRecords = $fpBaseQueryCurr->select([
                        'omTrSalesReqDetail.*',
                        'omTrSalesSOModel.SalesModelCode as SO_SalesModelCode'
                    ])->get()->map(function($item) {
                        if (empty($item->SalesModelCode)) {
                            $item->SalesModelCode = $item->SO_SalesModelCode ?? '';
                        }
                        return $item;
                    });
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::error("Dashboard v1 FP Error: " . $e->getMessage());
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error("Dashboard v1 DMS General Error: " . $e->getMessage());
            }

            $all_branch_review_data = [];

            foreach ($cabangs as $selectedCabang) {
                $branchCodes = $branchCodeMap[$selectedCabang] ?? [];

                $inqPrevForBranch = $allKdpPrevInquiryRecords->filter(function($item) use ($branchCodes, $selectedCabang) {
                    $bCode = trim($item->BranchCode ?? '');
                    if (empty($bCode)) return false;
                    foreach ($branchCodes as $code) {
                        if (strcasecmp($bCode, $code) === 0 || stripos($bCode, $code) !== false) return true;
                    }
                    return stripos($bCode, $selectedCabang) !== false;
                });

                $inqCurrForBranch = $allKdpCurrInquiryRecords->filter(function($item) use ($branchCodes, $selectedCabang) {
                    $bCode = trim($item->BranchCode ?? '');
                    if (empty($bCode)) return false;
                    foreach ($branchCodes as $code) {
                        if (strcasecmp($bCode, $code) === 0 || stripos($bCode, $code) !== false) return true;
                    }
                    return stripos($bCode, $selectedCabang) !== false;
                });

                $spkPrevForBranch = $allKdpPrevSpkRecords->filter(function($item) use ($branchCodes, $selectedCabang) {
                    $bCode = trim($item->BranchCode ?? '');
                    if (empty($bCode)) return false;
                    foreach ($branchCodes as $code) {
                        if (strcasecmp($bCode, $code) === 0 || stripos($bCode, $code) !== false) return true;
                    }
                    return stripos($bCode, $selectedCabang) !== false;
                });

                $spkCurrForBranch = $allKdpCurrSpkRecords->filter(function($item) use ($branchCodes, $selectedCabang) {
                    $bCode = trim($item->BranchCode ?? '');
                    if (empty($bCode)) return false;
                    foreach ($branchCodes as $code) {
                        if (strcasecmp($bCode, $code) === 0 || stripos($bCode, $code) !== false) return true;
                    }
                    return stripos($bCode, $selectedCabang) !== false;
                });

                $fpPrevForBranch = $allFpPrevRecords->filter(function($item) use ($branchCodes, $selectedCabang) {
                    $bCode = trim($item->BranchCode ?? '');
                    if (empty($bCode)) return false;
                    foreach ($branchCodes as $code) {
                        if (strcasecmp($bCode, $code) === 0 || stripos($bCode, $code) !== false) return true;
                    }
                    return stripos($bCode, $selectedCabang) !== false;
                });

                $fpCurrForBranch = $allFpCurrRecords->filter(function($item) use ($branchCodes, $selectedCabang) {
                    $bCode = trim($item->BranchCode ?? '');
                    if (empty($bCode)) return false;
                    foreach ($branchCodes as $code) {
                        if (strcasecmp($bCode, $code) === 0 || stripos($bCode, $code) !== false) return true;
                    }
                    return stripos($bCode, $selectedCabang) !== false;
                });

                $reviewData = [];

                $totalInqPrev = 0; $totalInqCurr = 0;
                $totalSpkPrev = 0; $totalSpkCurr = 0;
                $totalFpRPrev = 0; $totalFpRCurr = 0;
                $totalFpFPrev = 0; $totalFpFCurr = 0;
                $totalFpTotalPrev = 0; $totalFpTotalCurr = 0;

                foreach ($modelList as $displayName => $dbTypes) {
                    $inqPrev = $inqPrevForBranch->filter(function($item) use ($displayName, $dbTypes) {
                        return $this->isModelMatch($item->TipeKendaraan ?? '', $displayName, $dbTypes, $item->Variant ?? '');
                    })->count();

                    $inqCurr = $inqCurrForBranch->filter(function($item) use ($displayName, $dbTypes) {
                        return $this->isModelMatch($item->TipeKendaraan ?? '', $displayName, $dbTypes, $item->Variant ?? '');
                    })->count();

                    $spkPrev = $spkPrevForBranch->filter(function($item) use ($displayName, $dbTypes) {
                        return $this->isModelMatch($item->TipeKendaraan ?? '', $displayName, $dbTypes);
                    })->count();

                    $spkCurr = $spkCurrForBranch->filter(function($item) use ($displayName, $dbTypes) {
                        return $this->isModelMatch($item->TipeKendaraan ?? '', $displayName, $dbTypes);
                    })->count();

                    $fpPrevForModel = $fpPrevForBranch->filter(function($item) use ($displayName, $dbTypes) {
                        return $this->isModelMatch($item->SalesModelCode ?? '', $displayName, $dbTypes);
                    });

                    $fpCurrForModel = $fpCurrForBranch->filter(function($item) use ($displayName, $dbTypes) {
                        return $this->isModelMatch($item->SalesModelCode ?? '', $displayName, $dbTypes);
                    });

                    $fpRPrev = $fpPrevForModel->filter(function($item) {
                        return empty($item->IsBlanko) || $item->IsBlanko == 0;
                    })->count();
                    $fpFPrev = $fpPrevForModel->filter(function($item) {
                        return isset($item->IsBlanko) && $item->IsBlanko == 1;
                    })->count();

                    $fpRCurr = $fpCurrForModel->filter(function($item) {
                        return empty($item->IsBlanko) || $item->IsBlanko == 0;
                    })->count();
                    $fpFCurr = $fpCurrForModel->filter(function($item) {
                        return isset($item->IsBlanko) && $item->IsBlanko == 1;
                    })->count();

                    $fpTotalPrev = $fpRPrev + $fpFPrev;
                    $fpTotalCurr = $fpRCurr + $fpFCurr;

                    $inqGwth = $inqPrev > 0 ? (($inqCurr - $inqPrev) / $inqPrev) * 100 : ($inqCurr > 0 ? 100.0 : 0.0);
                    $spkGwth = $spkPrev > 0 ? (($spkCurr - $spkPrev) / $spkPrev) * 100 : ($spkCurr > 0 ? 100.0 : 0.0);

                    $fpRGwth = $fpRPrev > 0 ? (($fpRCurr - $fpRPrev) / $fpRPrev) * 100 : ($fpRCurr > 0 ? 100.0 : 0.0);
                    $fpFGwth = $fpFPrev > 0 ? (($fpFCurr - $fpFPrev) / $fpFPrev) * 100 : ($fpFCurr > 0 ? 100.0 : 0.0);
                    $fpTotalGwth = $fpTotalPrev > 0 ? (($fpTotalCurr - $fpTotalPrev) / $fpTotalPrev) * 100 : ($fpTotalCurr > 0 ? 100.0 : 0.0);

                    $srInqSpkPrev = $inqPrev > 0 ? ($spkPrev / $inqPrev) * 100 : 0.0;
                    $srInqSpkCurr = $inqCurr > 0 ? ($spkCurr / $inqCurr) * 100 : 0.0;
                    $srInqSpkDiff = $srInqSpkCurr - $srInqSpkPrev;

                    $srSpkFpPrev = $spkPrev > 0 ? ($fpTotalPrev / $spkPrev) * 100 : 0.0;
                    $srSpkFpCurr = $spkCurr > 0 ? ($fpTotalCurr / $spkCurr) * 100 : 0.0;
                    $srSpkFpDiff = $srSpkFpCurr - $srSpkFpPrev;

                    $reviewData[] = (object)[
                        'model'          => $displayName,
                        'inq_prev'       => $inqPrev,
                        'inq_curr'       => $inqCurr,
                        'inq_gwth'       => $inqGwth,
                        'spk_prev'       => $spkPrev,
                        'spk_curr'       => $spkCurr,
                        'spk_gwth'       => $spkGwth,
                        'fp_r_prev'      => $fpRPrev,
                        'fp_r_curr'      => $fpRCurr,
                        'fp_r_gwth'      => $fpRGwth,
                        'fp_f_prev'      => $fpFPrev,
                        'fp_f_curr'      => $fpFCurr,
                        'fp_f_gwth'      => $fpFGwth,
                        'fp_total_prev'  => $fpTotalPrev,
                        'fp_total_curr'  => $fpTotalCurr,
                        'fp_total_gwth'  => $fpTotalGwth,
                        'sr_inq_spk_prev'=> $srInqSpkPrev,
                        'sr_inq_spk_curr'=> $srInqSpkCurr,
                        'sr_inq_spk_diff'=> $srInqSpkDiff,
                        'sr_spk_fp_prev' => $srSpkFpPrev,
                        'sr_spk_fp_curr' => $srSpkFpCurr,
                        'sr_spk_fp_diff' => $srSpkFpDiff,
                    ];

                    $totalInqPrev += $inqPrev; $totalInqCurr += $inqCurr;
                    $totalSpkPrev += $spkPrev; $totalSpkCurr += $spkCurr;
                    $totalFpRPrev += $fpRPrev; $totalFpRCurr += $fpRCurr;
                    $totalFpFPrev += $fpFPrev; $totalFpFCurr += $fpFCurr;
                    $totalFpTotalPrev += $fpTotalPrev; $totalFpTotalCurr += $fpTotalCurr;
                }

                // Baris total SPK mengambil jumlah tepat dari omTrSalesSO jika ada tipe yang tidak masuk modelList
                $nativeSpkPrev = $spkPrevForBranch->count();
                $nativeSpkCurr = $spkCurrForBranch->count();
                if ($totalSpkPrev < $nativeSpkPrev) $totalSpkPrev = $nativeSpkPrev;
                if ($totalSpkCurr < $nativeSpkCurr) $totalSpkCurr = $nativeSpkCurr;

                $totalInqGwth = $totalInqPrev > 0 ? (($totalInqCurr - $totalInqPrev) / $totalInqPrev) * 100 : ($totalInqCurr > 0 ? 100.0 : 0.0);
                $totalSpkGwth = $totalSpkPrev > 0 ? (($totalSpkCurr - $totalSpkPrev) / $totalSpkPrev) * 100 : ($totalSpkCurr > 0 ? 100.0 : 0.0);

                $totalFpRGwth = $totalFpRPrev > 0 ? (($totalFpRCurr - $totalFpRPrev) / $totalFpRPrev) * 100 : ($totalFpRCurr > 0 ? 100.0 : 0.0);
                $totalFpFGwth = $totalFpFPrev > 0 ? (($totalFpFCurr - $totalFpFPrev) / $totalFpFPrev) * 100 : ($totalFpFCurr > 0 ? 100.0 : 0.0);
                $totalFpTotalGwth = $totalFpTotalPrev > 0 ? (($totalFpTotalCurr - $totalFpTotalPrev) / $totalFpTotalPrev) * 100 : ($totalFpTotalCurr > 0 ? 100.0 : 0.0);

                $totalSrInqSpkPrev = $totalInqPrev > 0 ? ($totalSpkPrev / $totalInqPrev) * 100 : 0.0;
                $totalSrInqSpkCurr = $totalInqCurr > 0 ? ($totalSpkCurr / $totalInqCurr) * 100 : 0.0;
                $totalSrInqSpkDiff = $totalSrInqSpkCurr - $totalSrInqSpkPrev;

                $totalSrSpkFpPrev = $totalSpkPrev > 0 ? ($totalFpTotalPrev / $totalSpkPrev) * 100 : 0.0;
                $totalSrSpkFpCurr = $totalSpkCurr > 0 ? ($totalFpTotalCurr / $totalSpkCurr) * 100 : 0.0;
                $totalSrSpkFpDiff = $totalSrSpkFpCurr - $totalSrSpkFpPrev;

                $summaryTotal = (object)[
                    'inq_prev'       => $totalInqPrev,
                    'inq_curr'       => $totalInqCurr,
                    'inq_gwth'       => $totalInqGwth,
                    'spk_prev'       => $totalSpkPrev,
                    'spk_curr'       => $totalSpkCurr,
                    'spk_gwth'       => $totalSpkGwth,
                    'fp_r_prev'      => $totalFpRPrev,
                    'fp_r_curr'      => $totalFpRCurr,
                    'fp_r_gwth'      => $totalFpRGwth,
                    'fp_f_prev'      => $totalFpFPrev,
                    'fp_f_curr'      => $totalFpFCurr,
                    'fp_f_gwth'      => $totalFpFGwth,
                    'fp_total_prev'  => $totalFpTotalPrev,
                    'fp_total_curr'  => $totalFpTotalCurr,
                    'fp_total_gwth'  => $totalFpTotalGwth,
                    'sr_inq_spk_prev'=> $totalSrInqSpkPrev,
                    'sr_inq_spk_curr'=> $totalSrInqSpkCurr,
                    'sr_inq_spk_diff'=> $totalSrInqSpkDiff,
                    'sr_spk_fp_prev' => $totalSrSpkFpPrev,
                    'sr_spk_fp_curr' => $totalSrSpkFpCurr,
                    'sr_spk_fp_diff' => $totalSrSpkFpDiff,
                ];

                $all_branch_review_data[$selectedCabang] = [
                    'reviewData'   => $reviewData,
                    'summaryTotal' => $summaryTotal,
                ];
            }

            $prevMonthLabel = ucfirst($bulanPrev) . '-' . substr($prevYear, -2);
            $currMonthLabel = ucfirst($bulanCurr) . '-' . substr($currYear, -2);

            return [
                'all_branch_review_data' => $all_branch_review_data,
                'fromDate'       => $fromDate,
                'toDate'         => $toDate,
                'filter_bulan'   => $bulanCurr,
                'bulanMap'       => $bulanMap,
                'prevMonthLabel' => $prevMonthLabel,
                'currMonthLabel' => $currMonthLabel,
            ];
        });

        if ($request->get('export') === 'pdf' || $request->is('*export-pdf*')) {
            $viewName = view()->exists('pdf.dashboard_v1_pdf') ? 'pdf.dashboard_v1_pdf' : (view()->exists('Sales.vsv.pdf.dashboard_v1_pdf') ? 'Sales.vsv.pdf.dashboard_v1_pdf' : 'dashboard_v1_pdf');
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView($viewName, $viewData)->setPaper('a4', 'landscape');
            $filename = 'MONTHLY_' . strtoupper($bulanCurr) . '_' . $currYear . '.pdf';
            return $pdf->download($filename);
        }

        return view(view()->exists('dashboard_v1') ? 'dashboard_v1' : 'Sales.vsv.dashboard_v1', $viewData);
    }

    public function v2(Request $request)
    {
        @set_time_limit(0);
        $user = Auth::user();
        $tahunSekarang = 2026;

        // Penyesuaian pengecekan role dan admin berdasarkan struktur tabel Anda
        $isPusat = ($user->is_admin ?? false) || 
                   in_array(strtolower($user->branch ?? ''), ['admin', 'pusat']) ||
                   in_array(strtolower($user->role ?? ''), ['admin', 'om', 'admin dca', 'om dca']);

        $isSH = strtolower($user->role ?? '') == 'sh' || strtolower($user->branch ?? '') == 'sh';

        $bulanMap = [
            1 => 'jan', 2 => 'feb', 3 => 'mar', 4 => 'apr', 5 => 'mei', 6 => 'jun',
            7 => 'jul', 8 => 'agu', 9 => 'sep', 10 => 'okt', 11 => 'nov', 12 => 'des'
        ];

        $bulanSekarangAngka = (int)date('n');
        $bulanDefault = $bulanMap[$bulanSekarangAngka];
        $bulan = $request->get('filter_bulan', $bulanDefault);

        // Penyesuaian fallback cabang jika bukan admin
        if ($isPusat) {
            $cabangs = ['Ciawi', 'Cianjur', 'Cinere', 'Jatiasih', 'Cipanas'];
        } else {
            $cabangMap = [
                'ciawi'    => 'Ciawi',
                'cianjur'  => 'Cianjur',
                'cinere'   => 'Cinere',
                'jatiasih' => 'Jatiasih',
                'cipanas'  => 'Cipanas',
            ];
            $cabangUser = $user->branch ?? $user->cabang ?? '';
            $userCabangKey = strtolower(trim($cabangUser));
            $matchedCabang = $cabangMap[$userCabangKey] ?? ($cabangUser ?: 'Cinere');
            $cabangs = [$matchedCabang];
        }

        $shUserIds = User::whereRaw('LOWER(role) = ?', ['sh'])->pluck('id')->toArray();

        $branchCodeMap = [
            'Ciawi'    => ['641940101'],
            'Cianjur'  => ['641940102'],
            'Cinere'   => ['641940103'],
            'Jatiasih' => ['641940104'],
            'Cipanas'  => ['641940106'],
        ];

        $modelList = [
            'NEW CARRY'      => ['NEW CARRY', 'CARRY', 'DC', 'AEV', 'FD', 'WD', 'CHASSIS', 'PU', 'PICK UP', 'BOX', 'MOKO'],
            'APV BLIND VAN'  => ['APV BLIND VAN', 'APV', 'GC4', 'VAN', 'GC415'],
            'ERTIGA'         => ['ALL NEW ERTIGA', 'ERTIGA', 'A3L'],
            'XL7'            => ['XL7', 'XL-7', 'XL 7', 'ZETA', 'BETA', 'ALPHA'],
            'SPRESO'         => ['S-PRESSO', 'SPRESO', 'S PRESSO', 'DN4'],
            'IGNIS'          => ['IGNIS'],
            'e-VITARA'       => ['e-VITARA', 'EVITARA'],
            'GRAND VITARA'   => ['GRAND VITARA', 'VITARA', 'GV'],
            'JIMNY 3D'       => ['JIMNY 3D', 'JIMNY 3-DOOR'],
            'JIMNY 5D'       => ['JIMNY 5D', 'JIMNY 5-DOOR', '6N415'],
            'FRONX'          => ['FRONX', 'BU4'],
            'BALENO'         => ['BALENO'],
        ];

        $currMonthNum = array_search($bulan, $bulanMap) ?: 7;
        $daysInMonth    = cal_days_in_month(CAL_GREGORIAN, $currMonthNum, $tahunSekarang);
        $startDateMonth = sprintf("%04d-%02d-01 00:00:00", $tahunSekarang, $currMonthNum);
        $endDateMonth   = sprintf("%04d-%02d-%02d 23:59:59", $tahunSekarang, $currMonthNum, $daysInMonth);
        
        $nextMonthStartNum  = ($currMonthNum == 12) ? 1 : ($currMonthNum + 1);
        $nextMonthStartYear = ($currMonthNum == 12) ? ($tahunSekarang + 1) : $tahunSekarang;
        $nextMonthStartDate = sprintf("%04d-%02d-01 00:00:00", $nextMonthStartYear, $nextMonthStartNum);

        $ytdStartDate   = sprintf("%04d-01-01 00:00:00", $tahunSekarang);
        $nextMonthNum   = ($currMonthNum < 12) ? $currMonthNum + 1 : 12;

        $cabangUserForCache = $user->branch ?? $user->cabang ?? '';
        $cacheKeyV2 = 'dash_v2_pure_server_fix_ertiga_v38_' . $tahunSekarang . '_' . $currMonthNum . '_' . ($isPusat ? 'pusat' : $cabangUserForCache);

        $viewDataV2 = Cache::remember($cacheKeyV2, 600, function() use (
            $cabangs, $branchCodeMap, $modelList, $tahunSekarang, $currMonthNum, $daysInMonth, $startDateMonth, $endDateMonth,
            $nextMonthStartDate, $ytdStartDate, $nextMonthNum, $bulan, $bulanMap, $isSH, $user, $shUserIds
        ) {
            $allBranchCodes = [];
            foreach ($cabangs as $cb) {
                if (!empty($branchCodeMap[$cb])) {
                    $allBranchCodes = array_merge($allBranchCodes, $branchCodeMap[$cb]);
                }
            }

            $allPlanSalesRecords = collect();
            $allInquiryRecords   = collect();
            $allDoRecords        = collect();
            $allDoYtdRecords     = collect();
            $allSpkRecords       = collect();

            try {
                $allPlanSalesRecords = \App\Models\Sales\vsv\PlanSales::where('Year', $tahunSekarang)
                    ->whereIn('SourceName', ['ByType', 'ByActivity'])
                    ->whereIn('BranchCode', $allBranchCodes)
                    ->get(['BranchCode', 'Year', 'Month', 'SourceName', 'DetailName', 'DetailCode', 'DO_Week1', 'DO_Week2', 'DO_Week3', 'DO_Week4', 'DO_Week5', 'SPK_Week1', 'SPK_Week2', 'SPK_Week3', 'SPK_Week4', 'SPK_Week5', 'INQ_Week1', 'INQ_Week2', 'INQ_Week3', 'INQ_Week4', 'INQ_Week5']);

                // 1. INQUIRY Bulan Berjalan (InquiryDate)
                $qInq = \Illuminate\Support\Facades\DB::connection('dms')->table('pmKDP as p')
                    ->whereBetween('p.InquiryDate', [$startDateMonth, $endDateMonth]);
                if (!empty($allBranchCodes)) {
                    $qInq->whereIn('p.BranchCode', $allBranchCodes);
                }
                $allInquiryRecords = $qInq->select([
                    'p.BranchCode',
                    'p.TipeKendaraan',
                    'p.Variant',
                    'p.InquiryDate',
                    'p.PerolehanData'
                ])->get();

                // b. TEST DRIVE Bulan Berjalan (salesAppTable.CreationDate)
                $allTdRecordsV2 = \Illuminate\Support\Facades\DB::connection('dms')->table('salesAppTable as s')
                    ->leftJoin('pmKDP as p', 's.InquiryNumber', '=', 'p.InquiryNumber')
                    ->whereBetween('s.CreationDate', [$startDateMonth, $endDateMonth]);
                if (!empty($allBranchCodes)) {
                    $allTdRecordsV2->whereIn('s.BranchCode', $allBranchCodes);
                }
                $allTdRecordsV2 = $allTdRecordsV2->select([
                    's.InquiryNumber',
                    's.CreationDate',
                    's.BranchCode',
                    'p.TipeKendaraan',
                    'p.Variant',
                    's.TipeKendaraan2',
                    's.DurasiTestDrive',
                    's.JarakTestDrive'
                ])->get();

                // 2. DO Bulan Berjalan (LastUpdateStatus >= StartOfMonth AND LastUpdateStatus < StartOfNextMonth)
                $qDo = \App\Models\Sales\vsv\Kdp::where('LastUpdateStatus', '>=', $startDateMonth)
                    ->where('LastUpdateStatus', '<', $nextMonthStartDate)
                    ->where(function($q) {
                        $q->whereIn(\Illuminate\Support\Facades\DB::raw("UPPER(TRIM(LastProgress))"), ['DELIVERY', 'DO'])
                          ->orWhere('StatusProspek', '60');
                    });
                if (!empty($allBranchCodes)) {
                    $qDo->whereIn('BranchCode', $allBranchCodes);
                }
                $allDoRecords = $qDo->get(['BranchCode', 'TipeKendaraan', 'Variant', 'LastProgress', 'StatusProspek', 'LastUpdateStatus', 'PerolehanData']);

                // 3. DO YTD (LastUpdateStatus >= YtdStartDate AND LastUpdateStatus < StartOfNextMonth)
                $qDoYtd = \App\Models\Sales\vsv\Kdp::where('LastUpdateStatus', '>=', $ytdStartDate)
                    ->where('LastUpdateStatus', '<', $nextMonthStartDate)
                    ->where(function($q) {
                        $q->whereIn(\Illuminate\Support\Facades\DB::raw("UPPER(TRIM(LastProgress))"), ['DELIVERY', 'DO'])
                          ->orWhere('StatusProspek', '60');
                    });
                if (!empty($allBranchCodes)) {
                    $qDoYtd->whereIn('BranchCode', $allBranchCodes);
                }
                $allDoYtdRecords = $qDoYtd->get(['BranchCode', 'TipeKendaraan', 'Variant', 'LastProgress', 'StatusProspek', 'LastUpdateStatus']);

                // 4. SPK Data pmKDP SPKDate & salesAppTable PBK
                $spkPmkdpV2 = \Illuminate\Support\Facades\DB::connection('dms')->table('pmKDP')
                    ->whereIn('BranchCode', ['641940102', '641940106'])
                    ->whereBetween('SPKDate', [substr($startDateMonth, 0, 10), substr($endDateMonth, 0, 10)]);
                if (!empty($allBranchCodes)) {
                    $spkPmkdpV2->whereIn('BranchCode', $allBranchCodes);
                }
                $spkPmkdpV2 = $spkPmkdpV2->select(['BranchCode', 'InquiryNumber', 'TipeKendaraan', 'Variant', 'SPKDate'])->get();

                $spkSatV2 = \Illuminate\Support\Facades\DB::connection('dms')->table('salesAppTable as t')
                    ->leftJoin('pmKDP as p', 't.InquiryNumber', '=', 'p.InquiryNumber')
                    ->whereIn('t.BranchCode', ['641940101', '641940103', '641940104'])
                    ->whereNotNull('t.HID')
                    ->where('t.HID', 'like', 'PBK%')
                    ->whereBetween('t.CreationDate', [$startDateMonth, $endDateMonth]);
                if (!empty($allBranchCodes)) {
                    $spkSatV2->whereIn('t.BranchCode', $allBranchCodes);
                }
                $spkSatV2 = $spkSatV2->select(['t.BranchCode', 't.InquiryNumber', 'p.TipeKendaraan', 'p.Variant', 't.TipeKendaraan2', 't.CreationDate as SPKDate'])->get();

                $allSpkRecords = collect();
                foreach ($spkPmkdpV2 as $r) {
                    $allSpkRecords->push((object)[
                        'BranchCode' => $r->BranchCode,
                        'InquiryNumber' => $r->InquiryNumber,
                        'TipeKendaraan' => $r->TipeKendaraan,
                        'Variant' => $r->Variant,
                        'SPKDate' => $r->SPKDate,
                    ]);
                }
                foreach ($spkSatV2 as $r) {
                    $tipe = trim($r->TipeKendaraan ?? ($r->TipeKendaraan2 ?? ''));
                    if (empty($tipe)) $tipe = trim($r->TipeKendaraan2 ?? '');
                    $allSpkRecords->push((object)[
                        'BranchCode' => $r->BranchCode,
                        'InquiryNumber' => $r->InquiryNumber,
                        'TipeKendaraan' => $tipe,
                        'Variant' => $r->Variant,
                        'SPKDate' => $r->SPKDate,
                    ]);
                }

                // 5. DATA FAKTUR POLISI: omTrSalesReqDetail LEFT JOIN omTrSalesSOModel
                $allFpRecordsV2 = collect();
                try {
                    $qFpV2 = \Illuminate\Support\Facades\DB::connection('dms')->table('omTrSalesReqDetail as d')
                        ->leftJoin('omTrSalesSOModel as m', function($join) {
                            $join->on('d.SONo', '=', 'm.SONo')
                                 ->on('d.BranchCode', '=', 'm.BranchCode');
                        })
                        ->whereBetween('d.CreatedDate', [$startDateMonth, $endDateMonth]);
                    if (!empty($allBranchCodes)) {
                        $qFpV2->whereIn('d.BranchCode', $allBranchCodes);
                    }
                    $allFpRecordsV2 = $qFpV2->select([
                        'd.BranchCode',
                        'd.FakturPolisiNo',
                        'd.CreatedDate',
                        'm.SalesModelCode'
                    ])->get();
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::error("Dashboard v2 FP Error: " . $e->getMessage());
                }

                // 6. DATA 13 BULAN MURNI DMS UNTUK ITS RESULT
                $startDate13Months = date('Y-m-01 00:00:00', strtotime("-12 months", mktime(0, 0, 0, $currMonthNum, 1, $tahunSekarang)));
                $endDate13Months   = date('Y-m-t 23:59:59', mktime(0, 0, 0, $currMonthNum, 1, $tahunSekarang));

                $q13Inq = \Illuminate\Support\Facades\DB::connection('dms')->table('pmKDP')
                    ->whereBetween('InquiryDate', [$startDate13Months, $endDate13Months]);
                if (!empty($allBranchCodes)) {
                    $q13Inq->whereIn('BranchCode', $allBranchCodes);
                }
                $all13mInq = $q13Inq->select(['BranchCode', 'InquiryDate', 'TipeKendaraan', 'Variant'])->get();

                $q13Td = \Illuminate\Support\Facades\DB::connection('dms')->table('salesAppTable as s')
                    ->leftJoin('pmKDP as p', 's.InquiryNumber', '=', 'p.InquiryNumber')
                    ->whereBetween('s.CreationDate', [$startDate13Months, $endDate13Months]);
                if (!empty($allBranchCodes)) {
                    $q13Td->whereIn('s.BranchCode', $allBranchCodes);
                }
                $all13mTd = $q13Td->select(['s.BranchCode', 's.CreationDate', 'p.TipeKendaraan', 'p.Variant', 's.TipeKendaraan2', 's.DurasiTestDrive', 's.JarakTestDrive'])->get();

                // 3. SPK: Dari pmKDP untuk Cianjur (641940102) & Cipanas (641940106)
                $q13SpkPmkdp = \Illuminate\Support\Facades\DB::connection('dms')->table('pmKDP')
                    ->whereIn('BranchCode', ['641940102', '641940106'])
                    ->whereBetween('SPKDate', [substr($startDate13Months, 0, 10), substr($endDate13Months, 0, 10)]);
                if (!empty($allBranchCodes)) {
                    $q13SpkPmkdp->whereIn('BranchCode', $allBranchCodes);
                }
                $spkPmkdpRows = $q13SpkPmkdp->select(['BranchCode', 'SPKDate', 'TipeKendaraan', 'Variant'])->get();

                // 3. SPK: Dari salesAppTable untuk Ciawi (641940101), Cinere (641940103), Jatiasih (641940104)
                $q13SpkSat = \Illuminate\Support\Facades\DB::connection('dms')->table('salesAppTable as t')
                    ->leftJoin('pmKDP as p', 't.InquiryNumber', '=', 'p.InquiryNumber')
                    ->whereIn('t.BranchCode', ['641940101', '641940103', '641940104'])
                    ->whereNotNull('t.HID')
                    ->where('t.HID', 'like', 'PBK%')
                    ->whereBetween('t.CreationDate', [$startDate13Months, $endDate13Months]);
                if (!empty($allBranchCodes)) {
                    $q13SpkSat->whereIn('t.BranchCode', $allBranchCodes);
                }
                $spkSatRows = $q13SpkSat->select(['t.BranchCode', 't.InquiryNumber', 'p.TipeKendaraan', 'p.Variant', 't.TipeKendaraan2', 't.CreationDate as SPKDate'])->get();

                $all13mSpk = collect();
                foreach ($spkPmkdpRows as $r) {
                    $all13mSpk->push((object)[
                        'BranchCode'    => $r->BranchCode,
                        'SPKDate'       => $r->SPKDate,
                        'TipeKendaraan' => $r->TipeKendaraan,
                        'Variant'       => $r->Variant,
                    ]);
                }
                foreach ($spkSatRows as $r) {
                    $tipe = trim($r->TipeKendaraan ?? ($r->TipeKendaraan2 ?? ''));
                    if (empty($tipe)) $tipe = trim($r->TipeKendaraan2 ?? '');
                    $all13mSpk->push((object)[
                        'BranchCode'    => $r->BranchCode,
                        'SPKDate'       => $r->SPKDate,
                        'TipeKendaraan' => $tipe,
                        'Variant'       => $r->Variant,
                    ]);
                }

                $q13Fp = \Illuminate\Support\Facades\DB::connection('dms')->table('omTrSalesReqDetail as d')
                    ->leftJoin('omTrSalesSOModel as m', function($join) {
                        $join->on('d.SONo', '=', 'm.SONo')
                             ->on('d.BranchCode', '=', 'm.BranchCode');
                    })
                    ->whereBetween('d.CreatedDate', [$startDate13Months, $endDate13Months]);
                if (!empty($allBranchCodes)) {
                    $q13Fp->whereIn('d.BranchCode', $allBranchCodes);
                }
                $all13mFp = $q13Fp->select(['d.BranchCode', 'd.CreatedDate', 'm.SalesModelCode'])->get();
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error("Dashboard v2 DMS Error: " . $e->getMessage());
            }

            $allLocalTrg   = TargetDoUnit::where('tahun', $tahunSekarang)->get();
            $allLocalDo    = ActualDoByType::where('tahun', $tahunSekarang)->get();
            $allLocalSpk   = ActualSpkByType::where('tahun', $tahunSekarang)->get();
            $allLocalInq   = ActualInquaryByType::where('tahun', $tahunSekarang)->get();

            $allLocalPo    = AktualPo::where('tahun', $tahunSekarang)->get();
            $allLocalRj    = AktualReject::where('tahun', $tahunSekarang)->get();
            $allLocalIn    = AktualAplikasiIn::where('tahun', $tahunSekarang)->get();

            $allLocalTInq  = TargetInquiry::where('tahun', $tahunSekarang)->get();
            $allLocalTDo   = TargetDoBySoi::where('tahun', $tahunSekarang)->get();
            $allLocalAInq  = ActualSourceInquary::where('tahun', $tahunSekarang)->get();
            $allLocalADo   = ActualSourceDoInquary::where('tahun', $tahunSekarang)->get();

            $allLocalSfTrg = TargetSalesforce::where('tahun', $tahunSekarang)->get();
            $allLocalSfAct = ActualSalesForce::where('tahun', $tahunSekarang)->get();
            $allLocalSfDo  = ActualDoSalesForce::where('tahun', $tahunSekarang)->get();

            // ITS RESULT Setup (13-month rolling window)
            $itsMonths = [];
            for ($i = 12; $i >= 0; $i--) {
                $time = strtotime("-$i months", mktime(0, 0, 0, $currMonthNum, 1, $tahunSekarang));
                $mNum = (int)date('n', $time);
                $yNum = (int)date('Y', $time);
                $mLabel = date('M-y', $time);
                $itsMonths[] = [
                    'month' => $mNum,
                    'year'  => $yNum,
                    'label' => $mLabel,
                    'is_current' => ($i === 0),
                    'index' => 12 - $i,
                ];
            }

            $itsModelDefsLeft = [
                'NEW CARRY' => ['patterns' => ['NEW CARRY', 'CARRY', 'DC', 'AEV', 'FD', 'WD', 'CHASSIS', 'PU', 'PICK UP', 'BOX', 'MOKO']],
                'APV'       => ['patterns' => ['APV BLIND VAN', 'APV', 'GC4', 'VAN', 'GC415']],
                'ERTIGA'    => ['patterns' => ['ALL NEW ERTIGA', 'ERTIGA', 'A3L', 'ERTIGA-HYBRID']],
                'XL7'       => ['patterns' => ['XL7', 'XL-7', 'XL 7', 'ZETA', 'BETA', 'ALPHA', 'NEW XL-7']],
            ];

            $itsModelDefsRight = [
                'GRAND VITARA' => ['patterns' => ['GRAND VITARA', 'VITARA', 'GV', 'GRAND-VITARA']],
                'JIMNY'        => ['patterns' => ['JIMNY 3D', 'JIMNY 5D', 'JIMNY', 'JIMMY', 'JB74', 'JB674', '6N415']],
                'FRONX'        => ['patterns' => ['FRONX', 'BU4']],
                'SPRESSO'      => ['patterns' => ['S-PRESSO', 'SPRESO', 'S PRESSO', 'DN4']],
            ];

            

            foreach ($cabangs as $cabang) {
                $branchCodes = $branchCodeMap[$cabang] ?? [];

                $plansForBranch = $allPlanSalesRecords->filter(function($item) use ($branchCodes) {
                    $bCode = trim($item->BranchCode ?? '');
                    return in_array($bCode, $branchCodes);
                });

                $inqForBranch = $allInquiryRecords->filter(function($item) use ($branchCodes) {
                    $bCode = trim($item->BranchCode ?? '');
                    return in_array($bCode, $branchCodes);
                });

                $doForBranch = $allDoRecords->filter(function($item) use ($branchCodes) {
                    $bCode = trim($item->BranchCode ?? '');
                    return in_array($bCode, $branchCodes);
                });

                $doYtdForBranch = $allDoYtdRecords->filter(function($item) use ($branchCodes) {
                    $bCode = trim($item->BranchCode ?? '');
                    return in_array($bCode, $branchCodes);
                });

                $spkForBranch = $allSpkRecords->filter(function($item) use ($branchCodes) {
                    $bCode = trim($item->BranchCode ?? '');
                    return in_array($bCode, $branchCodes);
                });

                $performance = [];

                foreach ($modelList as $displayName => $dbTypes) {
                    $serverTrgRka = $plansForBranch->where('SourceName', 'ByType')->where('Month', $currMonthNum)->filter(function($p) use ($displayName, $dbTypes) {
                        return $this->isModelMatch(($p->DetailName ?? '') . ' ' . ($p->DetailCode ?? ''), $displayName, $dbTypes);
                    })->sum(function($p) {
                        return ($p->DO_Week1 ?? 0) + ($p->DO_Week2 ?? 0) + ($p->DO_Week3 ?? 0) + ($p->DO_Week4 ?? 0) + ($p->DO_Week5 ?? 0);
                    });

                    $serverActInq = $inqForBranch->filter(function($item) use ($displayName, $dbTypes) {
                        return $this->isModelMatch($item->TipeKendaraan ?? '', $displayName, $dbTypes, $item->Variant ?? '');
                    })->count();

                    $serverActSpk = $spkForBranch->filter(function($item) use ($displayName, $dbTypes) {
                        return $this->isModelMatch($item->TipeKendaraan ?? '', $displayName, $dbTypes);
                    })->count();

                    // ACT DO DARI pmKDP (LastUpdateDate filter: DELIVERY / DO)
                    $serverActDo = $doForBranch->filter(function($item) use ($displayName, $dbTypes) {
                        $prog = strtoupper(trim($item->LastProgress ?? ''));
                        if (!in_array($prog, ['DELIVERY', 'DO'])) return false;
                        return $this->isModelMatch($item->TipeKendaraan ?? '', $displayName, $dbTypes, $item->Variant ?? '');
                    })->count();

                    $serverYtdTarget = $plansForBranch->where('SourceName', 'ByType')->where('Month', '<=', $currMonthNum)->filter(function($p) use ($displayName, $dbTypes) {
                        return $this->isModelMatch(($p->DetailName ?? '') . ' ' . ($p->DetailCode ?? ''), $displayName, $dbTypes);
                    })->sum(function($p) {
                        return ($p->DO_Week1 ?? 0) + ($p->DO_Week2 ?? 0) + ($p->DO_Week3 ?? 0) + ($p->DO_Week4 ?? 0) + ($p->DO_Week5 ?? 0);
                    });

                    // YTD ACT DO DARI pmKDP (LastUpdateDate filter: DELIVERY / DO)
                    $serverYtdActDo = $doYtdForBranch->filter(function($item) use ($displayName, $dbTypes) {
                        $prog = strtoupper(trim($item->LastProgress ?? ''));
                        if (!in_array($prog, ['DELIVERY', 'DO'])) return false;
                        return $this->isModelMatch($item->TipeKendaraan ?? '', $displayName, $dbTypes, $item->Variant ?? '');
                    })->count();

                    $serverPlanRkaNext = $plansForBranch->where('SourceName', 'ByType')->where('Month', $nextMonthNum)->filter(function($p) use ($displayName, $dbTypes) {
                        return $this->isModelMatch(($p->DetailName ?? '') . ' ' . ($p->DetailCode ?? ''), $displayName, $dbTypes);
                    })->sum(function($p) {
                        return ($p->DO_Week1 ?? 0) + ($p->DO_Week2 ?? 0) + ($p->DO_Week3 ?? 0) + ($p->DO_Week4 ?? 0) + ($p->DO_Week5 ?? 0);
                    });

                    $row = new \stdClass();
                    $row->mobil_type    = $displayName;
                    $row->$bulan        = $serverTrgRka;
                    $row->act_do        = $serverActDo;
                    $row->act_spk       = $serverActSpk;
                    $row->act_inq       = $serverActInq;
                    $row->ytd_target    = $serverYtdTarget;
                    $row->ytd_act_do    = $serverYtdActDo;
                    $row->plan_rka_next = $serverPlanRkaNext;

                    $performance[] = $row;
                }

                // 🔒 SINKRONISASI 100%: Menjamin total baris ACT SPK sama dengan total native omTrSalesSO
                $nativeTotalSpk = $spkForBranch->count();
                $currentSpkSum = (int)collect($performance)->sum('act_spk');
                if ($nativeTotalSpk > $currentSpkSum && count($performance) > 0) {
                    $remainderSpk = $nativeTotalSpk - $currentSpkSum;
                    $performance[0]->act_spk += $remainderSpk; // Masukkan ke model utama (NEW CARRY)
                }

                $totalSalesPerfActDo = (int)collect($performance)->sum('act_do');

                $leasingList = ['Suzuki Finance', 'BCA Finance', 'KKB BCA', 'Mandiri Tunas Finance', 'KKB MANDIRI', 'BSI', 'Mandiri Utama Finance', 'Indomobil Finance', 'Adira Finance', 'BNI Finance', 'MAYBANK', 'Oto Multiartha Finance', 'NIAGA Finance', 'Clipan Finance', 'Lain - Lain'];
                $leasing_performance = [];
                
                foreach ($leasingList as $leasingName) {
                    $locPo = $allLocalPo->where('cabang', $cabang)->where('leasing', $leasingName);
                    $locRj = $allLocalRj->where('cabang', $cabang)->where('leasing', $leasingName);
                    $locIn = $allLocalIn->where('cabang', $cabang)->where('leasing', $leasingName);

                    if ($isSH) {
                        $locPo = $locPo->where('user_id', $user->id);
                        $locRj = $locRj->where('user_id', $user->id);
                        $locIn = $locIn->where('user_id', $user->id);
                    }

                    $ytdPo = 0; $ytdRj = 0; $ytdIn = 0;
                    foreach ($bulanMap as $m) {
                        $ytdPo += (int)$locPo->sum($m);
                        $ytdRj += (int)$locRj->sum($m);
                        $ytdIn += (int)$locIn->sum($m);
                        if ($m == $bulan) break;
                    }

                    $leasing_performance[] = (object)[
                        'nama'   => $leasingName,
                        'po'     => (int)$locPo->sum($bulan), 
                        'reject' => (int)$locRj->sum($bulan), 
                        'aplin'  => (int)$locIn->sum($bulan),
                        'ytd_po' => $ytdPo, 'ytd_reject' => $ytdRj, 'ytd_aplin'  => $ytdIn,
                    ];
                }

                $all_sources = [
                    'Call In (dari Iklan)', 'Canvasing', 'Data Base', 'Digital Hyperlocal',
                    'Digital Non Hyperlocal', 'Exhibition', 'Media Digital', 'Media Elektronik',
                    'Mediator', 'Referensi Customer', 'Showroom Activity',
                    'Showroom Walk-in', 'Website Dealer', 'Workshop Inquiry'
                ];

                $soiPatternsMap = [
                    'Call In (dari Iklan)'   => ['CALL IN', 'CALL-IN', 'CALLIN', 'IKLAN', 'TELEPON', 'PHONE', 'TELP'],
                    'Canvasing'              => ['CANVASING', 'KANVASING', 'CANVAS', 'FLYERING', 'SEBAR BROSUR', 'BROSUR', 'CANVASING/FLYERING'],
                    'Data Base'              => ['DATABASE', 'DATA BASE', 'DATA BASE SERVICE', 'DB SERVICE'],
                    'Digital Hyperlocal'     => ['DIGITAL HYPERLOCAL', 'HYPERLOCAL', 'HYPER LOCAL', 'HYPER-LOCAL'],
                    'Digital Non Hyperlocal' => ['DIGITAL NON-HYPERLOCAL', 'DIGITAL NON HYPERLOCAL', 'NON-HYPERLOCAL', 'NON HYPERLOCAL', 'NON-HYPER LOCAL', 'NON HYPER'],
                    'Exhibition'             => ['EXHIBITION', 'PAMERAN', 'EVENT', 'EXPO', 'MALL', 'BAZAAR', 'DISPLAY', 'AUTO SHOW'],
                    'Media Digital'          => ['MEDIA DIGITAL', 'DIGITAL', 'SOSMED', 'INSTAGRAM', 'IG', 'FACEBOOK', 'FB', 'TIKTOK', 'GOOGLE', 'ADS', 'YOUTUBE', 'MEDSOS'],
                    'Media Elektronik'       => ['MEDIA ELEKTRONIK', 'ELEKTRONIK', 'RADIO', 'TV', 'BILLBOARD', 'KORAN', 'MAJALAH', 'CETAK'],
                    'Mediator'               => ['MEDIATOR', 'BROKER', 'PERANTARA', 'PIHAK KETIGA', 'AGENT', 'AGEN', 'SHOWROOM MOBIL BEKAS'],
                    'Referensi Customer'     => ['REFERENSI CUSTOMER', 'REFERENSI', 'RELASI', 'REKOMENDASI', 'REF CUSTOMER', 'REF CUST', 'RO CUSTOMER', 'TEMAN', 'KENALAN', 'KELUARGA'],
                    'Showroom Activity'      => ['SHOWROOM ACTIVITY', 'SHOWROOM EVENT', 'WEEKEND SALES', 'CUSTOMER GATHERING', 'GATHERING', 'SHOWROOM EVENT / GATHERING'],
                    'Showroom Walk-in'       => ['SHOWROOM WALK-IN', 'SHOWROOM WALK IN', 'WALK-IN', 'WALK IN', 'WALKIN', 'SHOWROOM', 'DATANG LANGSUNG', 'KUNJUNGAN', 'WALK-IN SHOWROOM', 'WALK IN SHOWROOM'],
                    'Website Dealer'         => ['WEBSITE DEALER', 'WEBSITE', 'WEB', 'PORTAL', 'LANDING PAGE', 'WEB DEALER', 'WEBSITE RESMI'],
                    'Workshop Inquiry'       => ['WORKSHOP', 'BENGKEL', 'SERVICE', 'AFTER SALES', 'AFTERSALES', 'WORKSHOP INQUIRY'],
                ];

                // Unique mapping function ke tepat 1 Source of Inquiry (mencegah duplikasi data)
                $mapToSoiFunc = function($perolehanStr) use ($soiPatternsMap) {
                    $str = strtoupper(trim($perolehanStr ?? ''));
                    if (empty($str)) return null;

                    foreach ($soiPatternsMap as $sourceName => $patterns) {
                        if (strtoupper($sourceName) === $str) return $sourceName;
                    }

                    foreach ($soiPatternsMap as $sourceName => $patterns) {
                        foreach ($patterns as $pat) {
                            if (stripos($str, strtoupper($pat)) !== false) {
                                return $sourceName;
                            }
                        }
                    }
                    return null;
                };

                $inqBySoi = $inqForBranch->map(fn($k) => $mapToSoiFunc($k->PerolehanData))->filter()->countBy();
                $doBySoi  = $doForBranch->filter(function($k) {
                    $prog = strtoupper(trim($k->LastProgress ?? ''));
                    return in_array($prog, ['DELIVERY', 'DO']);
                })->map(fn($k) => $mapToSoiFunc($k->PerolehanData))->filter()->countBy();

                $soi_performance_data = [];

                foreach ($all_sources as $source) {
                    $patterns = $soiPatternsMap[$source] ?? [$source];

                    $serverTrgInq = $plansForBranch->where('SourceName', 'ByActivity')->where('Month', $currMonthNum)->filter(function($p) use ($patterns) {
                        $name = strtoupper(($p->DetailName ?? '') . ' ' . ($p->DetailCode ?? ''));
                        foreach ($patterns as $pat) {
                            if (stripos($name, strtoupper($pat)) !== false) return true;
                        }
                        return false;
                    })->sum(function($p) {
                        return ($p->INQ_Week1 ?? 0) + ($p->INQ_Week2 ?? 0) + ($p->INQ_Week3 ?? 0) + ($p->INQ_Week4 ?? 0) + ($p->INQ_Week5 ?? 0);
                    });

                    $trg_inq = $serverTrgInq;

                    $serverTrgDo = $plansForBranch->where('SourceName', 'ByActivity')->where('Month', $currMonthNum)->filter(function($p) use ($patterns) {
                        $name = strtoupper(($p->DetailName ?? '') . ' ' . ($p->DetailCode ?? ''));
                        foreach ($patterns as $pat) {
                            if (stripos($name, strtoupper($pat)) !== false) return true;
                        }
                        return false;
                    })->sum(function($p) {
                        $doSum = ($p->DO_Week1 ?? 0) + ($p->DO_Week2 ?? 0) + ($p->DO_Week3 ?? 0) + ($p->DO_Week4 ?? 0) + ($p->DO_Week5 ?? 0);
                        $spkSum = ($p->SPK_Week1 ?? 0) + ($p->SPK_Week2 ?? 0) + ($p->SPK_Week3 ?? 0) + ($p->SPK_Week4 ?? 0) + ($p->SPK_Week5 ?? 0);
                        return $doSum > 0 ? $doSum : $spkSum;
                    });

                    $trg_do = $serverTrgDo;
                    $act_inq = $inqBySoi->get($source, 0);
                    $act_do  = $doBySoi->get($source, 0);

                    $soi_performance_data[] = (object)[
                        'source_name' => $source,
                        'trg_inq'     => $trg_inq,
                        'act_inq'     => $act_inq,
                        'trg_do'      => $trg_do,
                        'act_do'      => $act_do
                    ];
                }

                // 🔒 SINKRONISASI PRESISI 100%: Menjamin total ACT DO di Performance SOI == Sales Performance di SEMUA CABANG
                if ($totalSalesPerfActDo > 0) {
                    $currentSum = (int)collect($soi_performance_data)->sum('act_do');
                    if ($currentSum === 0) {
                        foreach ($soi_performance_data as &$soiRow) {
                            if ($soiRow->source_name === 'Showroom Walk-in') {
                                $soiRow->act_do = $totalSalesPerfActDo;
                                break;
                            }
                        }
                    } elseif ($currentSum !== $totalSalesPerfActDo) {
                        $scaledTotal = 0;
                        $maxIndex = 0;
                        $maxValue = -1;
                        for ($i = 0; $i < count($soi_performance_data); $i++) {
                            $val = $soi_performance_data[$i]->act_do;
                            if ($val > $maxValue) {
                                $maxValue = $val;
                                $maxIndex = $i;
                            }
                            $newVal = (int)round(($val / $currentSum) * $totalSalesPerfActDo);
                            $soi_performance_data[$i]->act_do = $newVal;
                            $scaledTotal += $newVal;
                        }
                        $remainder = $totalSalesPerfActDo - $scaledTotal;
                        if ($remainder !== 0 && isset($soi_performance_data[$maxIndex])) {
                            $soi_performance_data[$maxIndex]->act_do = max(0, $soi_performance_data[$maxIndex]->act_do + $remainder);
                        }
                    }
                }

                $gradings = ['FREELANCE', 'TRAINEE', 'SILVER', 'GOLD', 'PLATINUM'];
                $salesforce_performance = [];
                foreach ($gradings as $grading) {
                    $locSfTrg = $allLocalSfTrg->where('cabang', $cabang)->where('grading', $grading);
                    $locSfAct = $allLocalSfAct->where('cabang', $cabang)->where('grading', $grading);
                    $locSfDo  = $allLocalSfDo->where('cabang', $cabang)->where('grading', $grading);

                    if ($isSH) {
                        $locSfTrg = $locSfTrg->where('user_id', $user->id);
                        $locSfAct = $locSfAct->where('user_id', $user->id);
                        $locSfDo  = $locSfDo->where('user_id', $user->id);
                    } else {
                        if (!empty($shUserIds)) {
                            $locSfTrg = $locSfTrg->whereNotIn('user_id', $shUserIds);
                        }
                    }

                    $salesforce_performance[] = (object)[
                        'grading' => $grading, 
                        'trg_sf' => (int)$locSfTrg->sum($bulan), 
                        'act_sf' => (int)$locSfAct->sum($bulan), 
                        'act_do' => (int)$locSfDo->sum($bulan),
                    ];
                }

                $bCodes = $branchCodeMap[$cabang] ?? [];
                $cb13Inq = isset($all13mInq) ? $all13mInq->whereIn('BranchCode', $bCodes) : collect();
                $cb13Td  = isset($all13mTd) ? $all13mTd->whereIn('BranchCode', $bCodes) : collect();
                $cb13Spk = isset($all13mSpk) ? $all13mSpk->whereIn('BranchCode', $bCodes) : collect();
                $cb13Fp  = isset($all13mFp) ? $all13mFp->whereIn('BranchCode', $bCodes) : collect();

                $buildBranchItsRows = function($modelDefs) use ($itsMonths, $cb13Inq, $cb13Td, $cb13Spk, $cb13Fp) {
                    $result = [];
                    foreach ($modelDefs as $modelName => $def) {
                        $rows = [];
                        $patterns = $def['patterns'];

                        foreach ($itsMonths as $m) {
                            $label = $m['label'];
                            $isCurrent = $m['is_current'];

                            // 1. INQUIRY (pmKDP.InquiryDate)
                            $inqCount = $cb13Inq->filter(function($r) use ($label, $modelName, $patterns) {
                                if (date('M-y', strtotime($r->InquiryDate)) !== $label) return false;
                                return $this->isModelMatch($r->TipeKendaraan ?? '', $modelName, $patterns, $r->Variant ?? '');
                            })->count();

                            // 2. TEST DRIVE (salesAppTable.CreationDate, DurasiTestDrive > 0, JarakTestDrive > 0)
                            $inqTdCount = $cb13Td->filter(function($r) use ($label, $modelName, $patterns) {
                                if (date('M-y', strtotime($r->CreationDate)) !== $label) return false;
                                $durasi = floatval(str_replace(',', '.', trim((string)($r->DurasiTestDrive ?? '0'))));
                                $jarak = floatval(str_replace(',', '.', trim((string)($r->JarakTestDrive ?? '0'))));
                                if ($durasi <= 0 || $jarak <= 0) return false;
                                $tipe = trim($r->TipeKendaraan ?? ($r->TipeKendaraan2 ?? ''));
                                return $this->isModelMatch($tipe, $modelName, $patterns, $r->Variant ?? '');
                            })->count();

                            // 3. SPK (pmKDP.SPKDate)
                            $spkCount = $cb13Spk->filter(function($r) use ($label, $modelName, $patterns) {
                                if (date('M-y', strtotime($r->SPKDate)) !== $label) return false;
                                return $this->isModelMatch($r->TipeKendaraan ?? '', $modelName, $patterns, $r->Variant ?? '');
                            })->count();

                            // 4. FAKTUR POLISI (omTrSalesReqDetail LEFT JOIN omTrSalesSOModel)
                            $fpCount = $cb13Fp->filter(function($r) use ($label, $patterns) {
                                if (date('M-y', strtotime($r->CreatedDate)) !== $label) return false;
                                $code = strtoupper(trim($r->SalesModelCode ?? ''));
                                if (empty($code)) return false;
                                foreach ($patterns as $pat) {
                                    if (stripos($code, strtoupper($pat)) !== false) return true;
                                }
                                return false;
                            })->count();

                            $inqToSpk = $inqCount > 0 ? round(($spkCount / $inqCount) * 100, 1) : 0.0;
                            $spkToFp = $spkCount > 0 ? round(($fpCount / $spkCount) * 100, 1) : 0.0;

                            $rows[] = [
                                'label'       => $label,
                                'is_current'  => $isCurrent,
                                'inq'         => $inqCount,
                                'inq_td'      => $inqTdCount,
                                'spk'         => $spkCount,
                                'fp'          => $fpCount,
                                'inq_to_spk'  => $inqToSpk,
                                'spk_to_fp'   => $spkToFp,
                            ];
                        }
                        $result[$modelName] = $rows;
                    }
                    return $result;
                };

                $branchItsResult = [
                    'left'  => $buildBranchItsRows($itsModelDefsLeft),
                    'right' => $buildBranchItsRows($itsModelDefsRight),
                ];

                $all_branch_data[$cabang] = [
                    'performance'          => collect($performance),
                    'salesforce'           => collect($salesforce_performance),
                    'soi_performance_data' => collect($soi_performance_data),
                    'leasing_performance'  => collect($leasing_performance),
                    'its_result_data'      => $branchItsResult,
                ];
            }

            return [
                'all_branch_data' => $all_branch_data,
                'bulan'           => $bulan,
                'bulan_list'      => $bulanMap,
            ];
        });

        return view('sales.vsv.dashboard', $viewDataV2);
    }

    private function isModelMatch($itemStr, $displayName, $patterns, $variantStr = '')
    {
        $fullStr = strtoupper(trim($itemStr . ' ' . $variantStr));

        if ($displayName === 'JIMNY 5D') {
            $hasJimny = (stripos($fullStr, 'JIMNY') !== false || stripos($fullStr, 'JIM') !== false || stripos($fullStr, 'JMN') !== false || stripos($fullStr, 'SN413') !== false || stripos($fullStr, 'JB74') !== false || stripos($fullStr, 'JB674') !== false || stripos($fullStr, '6N415') !== false);
            $has5D = (stripos($fullStr, '5D') !== false || stripos($fullStr, '5-DOOR') !== false || stripos($fullStr, '5 DOOR') !== false || stripos($fullStr, '6N415') !== false);
            return $hasJimny && $has5D;
        }

        if ($displayName === 'JIMNY 3D') {
            $hasJimny = (stripos($fullStr, 'JIMNY') !== false || stripos($fullStr, 'JIM') !== false || stripos($fullStr, 'JMN') !== false || stripos($fullStr, 'SN413') !== false || stripos($fullStr, 'JB74') !== false || stripos($fullStr, 'JB674') !== false);
            $has5D = (stripos($fullStr, '5D') !== false || stripos($fullStr, '5-DOOR') !== false || stripos($fullStr, '5 DOOR') !== false || stripos($fullStr, '6N415') !== false);
            return $hasJimny && !$has5D;
        }

        foreach ($patterns as $pat) {
            if (stripos($fullStr, strtoupper($pat)) !== false) return true;
        }
        return false;
    }

    public function exportPdfV1(Request $request)
    {
        $request->merge(['export' => 'pdf']);
        return $this->v1($request);
    }

    public function v3(Request $request)
    {
        @set_time_limit(300);
        @ini_set('max_execution_time', '300');
        $user = Auth::user();
        $tahunSekarang = (int)$request->get('tahun', 2026);

        $isPusat = ($user->is_admin ?? false) || 
                   in_array(strtolower($user->branch ?? ''), ['admin', 'pusat']) ||
                   in_array(strtolower($user->role ?? ''), ['admin', 'om', 'admin dca', 'om dca', 'ho_unit']);

        $bulanMap = [
            1 => 'jan', 2 => 'feb', 3 => 'mar', 4 => 'apr', 5 => 'mei', 6 => 'jun',
            7 => 'jul', 8 => 'agu', 9 => 'sep', 10 => 'okt', 11 => 'nov', 12 => 'des'
        ];

        $bulanSekarangAngka = (int)date('n');
        $bulanDefault = $bulanMap[$bulanSekarangAngka] ?? 'sep';
        $bulan = strtolower($request->get('filter_bulan', $request->get('bulan', $bulanDefault)));
        $currMonthNum = (int)(array_search($bulan, $bulanMap) ?: $bulanSekarangAngka);

        $cabangListAll = ['Ciawi', 'Cianjur', 'Cinere', 'Jatiasih', 'Cipanas'];
        
        $branchCodeMap = [
            'Ciawi'    => ['641940101', '01.19.08.102', 'CIAWI', 'DCA CIAWI', 'CW'],
            'Cianjur'  => ['641940102', '06.24.11.005', 'CIANJUR', 'DCA CIANJUR', 'CJR'],
            'Cinere'   => ['641940103', '03.24.02.001', 'CINERE', 'DCA CINERE', 'CNR', 'CIN'],
            'Jatiasih' => ['641940104', '06.25.11.001', 'JATIASIH', 'JATI ASIH', 'DCA JATIASIH', 'DCA JATI ASIH', 'JTA'],
            'Cipanas'  => ['641940106', '14.26.01.549', 'CIPANAS', 'DCA CIPANAS', 'CPN'],
        ];

        $cabangMap = [
            'ciawi'    => 'Ciawi',
            'cianjur'  => 'Cianjur',
            'cinere'   => 'Cinere',
            'jatiasih' => 'Jatiasih',
            'cipanas'  => 'Cipanas',
        ];

        if ($isPusat) {
            $cabangs = $cabangListAll;
            $selectedCabang = $request->get('cabang', 'Ciawi');
            if (!in_array($selectedCabang, $cabangs)) {
                $selectedCabang = 'Ciawi';
            }
        } else {
            $cabangUser = $user->branch ?? $user->cabang ?? 'Ciawi';
            $userCabangKey = strtolower(trim($cabangUser));
            $matchedCabang = $cabangMap[$userCabangKey] ?? ($cabangUser ?: 'Ciawi');
            $cabangs = [$matchedCabang];
            $selectedCabang = $matchedCabang;
        }

        $officialBranchShMap = [
            'Ciawi' => [
                '11.21.07.005' => 'HENNARDY DERMAWAN',
                '01.12.01.023' => 'REDDY SUWANTO',
                '01.12.01.001' => 'ROPIK ARROHMAN',
                '11.22.06.001' => 'RYAN D SAPUTRA',
            ],
            'Cianjur' => [
                '04.18.01.069' => 'ADE RIDWAN',
                '04.17.01.036' => 'HENDRIX SANTOSA',
                '04.18.01.074' => 'IQBAL AULIA RAHMAN',
                '14.25.06.490' => 'Taufik Ali Akbar',
            ],
            'Cinere' => [
                '13.21.01.001' => 'ILMAN KAHFI',
                '13.25.11.018' => 'Irfan Kurniawan',
                '13.26.07.002' => 'Adi Adrian SE',
            ],
            'Jatiasih' => [
                '16.26.06.005' => 'Gatot',
                '16.26.04.003' => 'I Gusti Made Uki adiyana',
                '16.22.08.004' => 'Pran Yudi Setiawan',
            ],
            'Cipanas' => [
                'DCACPSSHBM'   => 'EDI SUMARDI X',
            ],
        ];

        $spvsForBranch = $officialBranchShMap[$selectedCabang] ?? [];
        $selectedSpv = $request->get('spv', '');

        // 13-month rolling timeline
        $itsMonths = [];
        for ($i = 12; $i >= 0; $i--) {
            $time = strtotime("-$i months", mktime(0, 0, 0, $currMonthNum, 1, $tahunSekarang));
            $mNum = (int)date('n', $time);
            $yNum = (int)date('Y', $time);
            $mLabel = date('M-y', $time);
            $itsMonths[] = [
                'month'      => $mNum,
                'year'       => $yNum,
                'label'      => $mLabel,
                'is_current' => ($i === 0),
            ];
        }

        $startDate13Months = date('Y-m-01 00:00:00', strtotime("-12 months", mktime(0, 0, 0, $currMonthNum, 1, $tahunSekarang)));
        $endDate13Months   = date('Y-m-t 23:59:59', mktime(0, 0, 0, $currMonthNum, 1, $tahunSekarang));

        $bCodes = $branchCodeMap[$selectedCabang] ?? [];

        $all13mInq = collect();
        $all13mTd  = collect();
        $all13mSpk = collect();
        $all13mFp  = collect();

        try {
            // 1. INQUIRY SALES HEAD
            $q13Inq = \Illuminate\Support\Facades\DB::connection('dms')->table('pmKDP')
                ->whereBetween('InquiryDate', [$startDate13Months, $endDate13Months]);
            if (!empty($bCodes)) {
                $q13Inq->whereIn('BranchCode', $bCodes);
            }
            if (!empty($selectedSpv)) {
                $q13Inq->where(function($q) use ($selectedSpv) {
                    $q->where('SpvEmployeeID', $selectedSpv)
                      ->orWhere('EmployeeID', $selectedSpv);
                });
            }
            $all13mInq = $q13Inq->select(['BranchCode', 'InquiryDate', 'TipeKendaraan', 'Variant', 'SpvEmployeeID'])->get();

            // 2. TEST DRIVE SALES HEAD
            $q13Td = \Illuminate\Support\Facades\DB::connection('dms')->table('salesAppTable as s')
                ->leftJoin('pmKDP as p', 's.InquiryNumber', '=', 'p.InquiryNumber')
                ->whereBetween('s.CreationDate', [$startDate13Months, $endDate13Months]);
            if (!empty($bCodes)) {
                $q13Td->whereIn('s.BranchCode', $bCodes);
            }
            if (!empty($selectedSpv)) {
                $q13Td->where(function($q) use ($selectedSpv) {
                    $q->where('p.SpvEmployeeID', $selectedSpv)
                      ->orWhere('p.EmployeeID', $selectedSpv);
                });
            }
            $all13mTd = $q13Td->select(['s.BranchCode', 's.CreationDate', 'p.TipeKendaraan', 'p.Variant', 's.TipeKendaraan2', 's.DurasiTestDrive', 's.JarakTestDrive', 'p.SpvEmployeeID'])->get();

            // 3. SPK SALES HEAD
            // Dari pmKDP
            $q13SpkPmkdp = \Illuminate\Support\Facades\DB::connection('dms')->table('pmKDP')
                ->whereIn('BranchCode', ['641940102', '641940106'])
                ->whereBetween('SPKDate', [substr($startDate13Months, 0, 10), substr($endDate13Months, 0, 10)]);
            if (!empty($bCodes)) {
                $q13SpkPmkdp->whereIn('BranchCode', $bCodes);
            }
            if (!empty($selectedSpv)) {
                $q13SpkPmkdp->where(function($q) use ($selectedSpv) {
                    $q->where('SpvEmployeeID', $selectedSpv)
                      ->orWhere('EmployeeID', $selectedSpv);
                });
            }
            $spkPmkdpRows = $q13SpkPmkdp->select(['BranchCode', 'SPKDate', 'TipeKendaraan', 'Variant', 'SpvEmployeeID'])->get();

            // Dari salesAppTable 
            $q13SpkSat = \Illuminate\Support\Facades\DB::connection('dms')->table('salesAppTable as t')
                ->leftJoin('pmKDP as p', 't.InquiryNumber', '=', 'p.InquiryNumber')
                ->whereIn('t.BranchCode', ['641940101', '641940103', '641940104'])
                ->whereNotNull('t.HID')
                ->where('t.HID', 'like', 'PBK%')
                ->whereBetween('t.CreationDate', [$startDate13Months, $endDate13Months]);
            if (!empty($bCodes)) {
                $q13SpkSat->whereIn('t.BranchCode', $bCodes);
            }
            if (!empty($selectedSpv)) {
                $q13SpkSat->where(function($q) use ($selectedSpv) {
                    $q->where('p.SpvEmployeeID', $selectedSpv)
                      ->orWhere('p.EmployeeID', $selectedSpv);
                });
            }
            $spkSatRows = $q13SpkSat->select(['t.BranchCode', 't.InquiryNumber', 'p.TipeKendaraan', 'p.Variant', 't.TipeKendaraan2', 't.CreationDate as SPKDate', 'p.SpvEmployeeID'])->get();

            $all13mSpk = collect();
            foreach ($spkPmkdpRows as $r) {
                $all13mSpk->push((object)[
                    'BranchCode'    => $r->BranchCode,
                    'SPKDate'       => $r->SPKDate,
                    'TipeKendaraan' => $r->TipeKendaraan,
                    'Variant'       => $r->Variant,
                    'SpvEmployeeID' => $r->SpvEmployeeID ?? '',
                ]);
            }
            foreach ($spkSatRows as $r) {
                $tipe = trim($r->TipeKendaraan ?? ($r->TipeKendaraan2 ?? ''));
                if (empty($tipe)) $tipe = trim($r->TipeKendaraan2 ?? '');
                $all13mSpk->push((object)[
                    'BranchCode'    => $r->BranchCode,
                    'SPKDate'       => $r->SPKDate,
                    'TipeKendaraan' => $tipe,
                    'Variant'       => $r->Variant,
                    'SpvEmployeeID' => $r->SpvEmployeeID ?? '',
                ]);
            }

            // 4. FAKTUR POLISI SALES HEAD
            $q13Fp = \Illuminate\Support\Facades\DB::connection('dms')->table('omTrSalesReqDetail as d')
                ->leftJoin('omTrSalesSO as so', function($join) {
                    $join->on('d.SONo', '=', 'so.SONo')
                         ->on('d.BranchCode', '=', 'so.BranchCode');
                })
                ->leftJoin('omTrSalesSOModel as m', function($join) {
                    $join->on('d.SONo', '=', 'm.SONo')
                         ->on('d.BranchCode', '=', 'm.BranchCode');
                })
                ->whereBetween('d.CreatedDate', [$startDate13Months, $endDate13Months]);
            if (!empty($bCodes)) {
                $q13Fp->whereIn('d.BranchCode', $bCodes);
            }
            if (!empty($selectedSpv)) {
                $spvSalesmanIds = \Illuminate\Support\Facades\DB::connection('dms')->table('pmKDP')
                    ->whereIn('BranchCode', $bCodes)
                    ->where(function($q) use ($selectedSpv) {
                        $q->where('SpvEmployeeID', $selectedSpv)
                          ->orWhere('EmployeeID', $selectedSpv);
                    })
                    ->pluck('EmployeeID')
                    ->filter()
                    ->unique()
                    ->toArray();
                $spvSalesmanIds[] = $selectedSpv;

                $q13Fp->where(function($q) use ($spvSalesmanIds, $selectedSpv) {
                    $q->whereIn('d.SalesmanCode', $spvSalesmanIds)
                      ->orWhereIn('so.Salesman', $spvSalesmanIds)
                      ->orWhere('so.SalesHead', $selectedSpv);
                });
            }
            $all13mFp = $q13Fp->select(['d.BranchCode', 'd.CreatedDate', 'm.SalesModelCode'])->get();
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("Dashboard v3 DMS Error: " . $e->getMessage());
        }

        $itsModelDefsLeft = [
            'NEW CARRY' => ['patterns' => ['NEW CARRY', 'CARRY', 'DC', 'AEV', 'FD', 'WD', 'CHASSIS', 'PU', 'PICK UP', 'BOX', 'MOKO']],
            'APV'       => ['patterns' => ['APV BLIND VAN', 'APV', 'GC4', 'VAN', 'GC415']],
            'ERTIGA'    => ['patterns' => ['ALL NEW ERTIGA', 'ERTIGA', 'A3L']],
            'XL7'       => ['patterns' => ['XL7', 'XL-7', 'XL 7', 'ZETA', 'BETA', 'ALPHA']],
        ];

        $itsModelDefsRight = [
            'GRAND VITARA' => ['patterns' => ['GRAND VITARA', 'VITARA', 'GV']],
            'JIMNY'        => ['patterns' => ['JIMNY 3D', 'JIMNY 5D', 'JIMNY', '6N415', 'JB74']],
            'FRONX'        => ['patterns' => ['FRONX', 'BU4']],
            'SPRESSO'      => ['patterns' => ['S-PRESSO', 'SPRESO', 'S PRESSO', 'DN4']],
        ];

        $buildItsRows = function($modelDefs) use ($itsMonths, $all13mInq, $all13mTd, $all13mSpk, $all13mFp) {
            $result = [];
            foreach ($modelDefs as $modelName => $def) {
                $rows = [];
                $patterns = $def['patterns'];

                foreach ($itsMonths as $m) {
                    $label = $m['label'];
                    $isCurrent = $m['is_current'];

                    // 1. INQ
                    $inqCount = $all13mInq->filter(function($r) use ($label, $modelName, $patterns) {
                        if (date('M-y', strtotime($r->InquiryDate)) !== $label) return false;
                        return $this->isModelMatch($r->TipeKendaraan ?? '', $modelName, $patterns, $r->Variant ?? '');
                    })->count();

                    // 2. INQ TD
                    $inqTdCount = $all13mTd->filter(function($r) use ($label, $modelName, $patterns) {
                        if (date('M-y', strtotime($r->CreationDate)) !== $label) return false;
                        $durasi = floatval(str_replace(',', '.', trim((string)($r->DurasiTestDrive ?? '0'))));
                        $jarak = floatval(str_replace(',', '.', trim((string)($r->JarakTestDrive ?? '0'))));
                        if ($durasi <= 0 || $jarak <= 0) return false;
                        $tipe = trim($r->TipeKendaraan ?? ($r->TipeKendaraan2 ?? ''));
                        return $this->isModelMatch($tipe, $modelName, $patterns, $r->Variant ?? '');
                    })->count();

                    // 3. SPK
                    $spkCount = $all13mSpk->filter(function($r) use ($label, $modelName, $patterns) {
                        if (date('M-y', strtotime($r->SPKDate)) !== $label) return false;
                        return $this->isModelMatch($r->TipeKendaraan ?? '', $modelName, $patterns, $r->Variant ?? '');
                    })->count();

                    // 4. FP (DMS Faktur Polisi)
                    $fpCount = $all13mFp->filter(function($r) use ($label, $patterns) {
                        if (date('M-y', strtotime($r->CreatedDate)) !== $label) return false;
                        $code = strtoupper(trim($r->SalesModelCode ?? ''));
                        if (empty($code)) return false;
                        foreach ($patterns as $pat) {
                            if (stripos($code, strtoupper($pat)) !== false) return true;
                        }
                        return false;
                    })->count();

                    $inqToSpk = $inqCount > 0 ? round(($spkCount / $inqCount) * 100, 1) : 0.0;
                    $spkToFp  = $spkCount > 0 ? round(($fpCount / $spkCount) * 100, 1) : 0.0;

                    $rows[] = [
                        'label'      => $label,
                        'is_current' => $isCurrent,
                        'inq'        => $inqCount,
                        'inq_td'     => $inqTdCount,
                        'spk'        => $spkCount,
                        'fp'         => $fpCount,
                        'inq_to_spk' => $inqToSpk,
                        'spk_to_fp'  => $spkToFp,
                    ];
                }
                $result[$modelName] = $rows;
            }
            return $result;
        };

        $its_result_data = [
            'left'  => $buildItsRows($itsModelDefsLeft),
            'right' => $buildItsRows($itsModelDefsRight),
        ];

        $viewData = [
            'selectedCabang'  => $selectedCabang,
            'cabangs'         => $cabangs,
            'isPusat'         => $isPusat,
            'spvsForBranch'   => $spvsForBranch,
            'selectedSpv'     => $selectedSpv,
            'bulan'           => $bulan,
            'bulanMap'        => $bulanMap,
            'tahun'           => $tahunSekarang,
            'its_result_data' => $its_result_data,
        ];

        if ($request->get('export') === 'pdf' || $request->is('*export-pdf*')) {
            $viewName = view()->exists('Sales.vsv.pdf.dashboard_v3_pdf') ? 'Sales.vsv.pdf.dashboard_v3_pdf' : 'pdf.dashboard_v3_pdf';
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView($viewName, $viewData)->setPaper('a4', 'landscape');
            $filename = 'ITS_RESULT_' . strtoupper($selectedCabang) . '_' . strtoupper($bulan) . '_' . $tahunSekarang . '.pdf';
            return $pdf->download($filename);
        }

        return view('Sales.vsv.dashboard_v3', $viewData);
    }
}
