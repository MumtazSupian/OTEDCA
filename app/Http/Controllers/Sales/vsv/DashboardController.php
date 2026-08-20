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
            'JIMNY 5D'       => ['JIMNY 5D', 'JIMNY 5-DOOR'],
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

                // 2. DATA SPK: omTrSalesSO TANPA SQL JOIN
                try {
                    $qSpkPrev = \Illuminate\Support\Facades\DB::connection('dms')->table('omTrSalesSO')
                        ->whereBetween('SODate', [$prevStartDate, $prevEndDate]);

                    $qSpkCurr = \Illuminate\Support\Facades\DB::connection('dms')->table('omTrSalesSO')
                        ->whereBetween('SODate', [$currStartDate, $currEndDate]);

                    if (!empty($allBranchCodes)) {
                        $qSpkPrev->whereIn('BranchCode', $allBranchCodes);
                        $qSpkCurr->whereIn('BranchCode', $allBranchCodes);
                    }

                    $allKdpPrevSpkRecords = $qSpkPrev->select(['BranchCode', 'SONo', 'SODate as SPKDate'])->get();
                    $allKdpCurrSpkRecords = $qSpkCurr->select(['BranchCode', 'SONo', 'SODate as SPKDate'])->get();

                    $allSoNos = $allKdpPrevSpkRecords->pluck('SONo')->merge($allKdpCurrSpkRecords->pluck('SONo'))->filter()->unique()->toArray();
                    $soModelMap = [];
                    if (!empty($allSoNos)) {
                        $soModelRecords = \Illuminate\Support\Facades\DB::connection('dms')->table('omTrSalesSOModel')
                            ->whereIn('SONo', $allSoNos)
                            ->get(['SONo', 'SalesModelCode']);
                        foreach ($soModelRecords as $sm) {
                            if (!isset($soModelMap[$sm->SONo])) {
                                $soModelMap[$sm->SONo] = $sm->SalesModelCode;
                            }
                        }
                    }

                    $allKdpPrevSpkRecords = $allKdpPrevSpkRecords->map(function($item) use ($soModelMap) {
                        $item->TipeKendaraan = $soModelMap[$item->SONo] ?? '';
                        return $item;
                    });

                    $allKdpCurrSpkRecords = $allKdpCurrSpkRecords->map(function($item) use ($soModelMap) {
                        $item->TipeKendaraan = $soModelMap[$item->SONo] ?? '';
                        return $item;
                    });
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
            'JIMNY 5D'       => ['JIMNY 5D', 'JIMNY 5-DOOR'],
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
        $cacheKeyV2 = 'dash_v2_pure_server_fix_ertiga_v15_' . $tahunSekarang . '_' . $currMonthNum . '_' . ($isPusat ? 'pusat' : $cabangUserForCache);

        $viewDataV2 = Cache::remember($cacheKeyV2, 60, function() use (
            $cabangs, $branchCodeMap, $modelList, $tahunSekarang, $currMonthNum, $startDateMonth, $endDateMonth,
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
                $qInq = \App\Models\Sales\vsv\Kdp::whereBetween('InquiryDate', [$startDateMonth, $endDateMonth]);
                if (!empty($allBranchCodes)) {
                    $qInq->whereIn('BranchCode', $allBranchCodes);
                }
                $allInquiryRecords = $qInq->get(['BranchCode', 'TipeKendaraan', 'Variant', 'InquiryDate', 'PerolehanData']);

                // 2. DO Bulan Berjalan (LastUpdateDate >= StartOfMonth AND LastUpdateDate < StartOfNextMonth)
                $qDo = \App\Models\Sales\vsv\Kdp::where('LastUpdateStatus', '>=', $startDateMonth)
                    ->where('LastUpdateStatus', '<', $nextMonthStartDate);
                if (!empty($allBranchCodes)) {
                    $qDo->whereIn('BranchCode', $allBranchCodes);
                }
                $allDoRecords = $qDo->get(['BranchCode', 'TipeKendaraan', 'Variant', 'LastProgress', 'StatusProspek', 'LastUpdateStatus', 'PerolehanData']);

                // 3. DO YTD (LastUpdateDate >= YtdStartDate AND LastUpdateDate < StartOfNextMonth)
                $qDoYtd = \App\Models\Sales\vsv\Kdp::where('LastUpdateStatus', '>=', $ytdStartDate)
                    ->where('LastUpdateStatus', '<', $nextMonthStartDate);
                if (!empty($allBranchCodes)) {
                    $qDoYtd->whereIn('BranchCode', $allBranchCodes);
                }
                $allDoYtdRecords = $qDoYtd->get(['BranchCode', 'TipeKendaraan', 'Variant', 'LastProgress', 'StatusProspek', 'LastUpdateStatus']);

                // 4. SPK Murni dari omTrSalesSO
                $qSpk = \Illuminate\Support\Facades\DB::connection('dms')->table('omTrSalesSO')
                    ->whereBetween('SODate', [$startDateMonth, $endDateMonth]);

                if (!empty($allBranchCodes)) {
                    $qSpk->whereIn('BranchCode', $allBranchCodes);
                }
                $allSpkRecords = $qSpk->select(['BranchCode', 'SONo', 'SODate as SPKDate'])->get();

                $allSoNosV2 = $allSpkRecords->pluck('SONo')->filter()->unique()->toArray();
                $soModelMapV2 = [];
                if (!empty($allSoNosV2)) {
                    $soModelRecordsV2 = \Illuminate\Support\Facades\DB::connection('dms')->table('omTrSalesSOModel')
                        ->whereIn('SONo', $allSoNosV2)
                        ->get(['SONo', 'SalesModelCode']);
                    foreach ($soModelRecordsV2 as $sm) {
                        if (!isset($soModelMapV2[$sm->SONo])) {
                            $soModelMapV2[$sm->SONo] = $sm->SalesModelCode;
                        }
                    }
                }

                $allSpkRecords = $allSpkRecords->map(function($item) use ($soModelMapV2) {
                    $item->TipeKendaraan = $soModelMapV2[$item->SONo] ?? '';
                    return $item;
                });
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

            $all_branch_data = [];
            $keys = array_values($bulanMap);
            $currentIndex = array_search($bulan, $keys);
            $nextMonthKey = ($currentIndex < 11) ? $keys[$currentIndex + 1] : 'des';

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
                    'Mediator', 'Referensi', 'Referensi Customer', 'Showroom Activity',
                    'Showroom Walk-in', 'Website Dealer'
                ];

                $soiPatternsMap = [
                    'Call In (dari Iklan)'   => ['CALL IN', 'CALL-IN', 'CALLIN', 'IKLAN', 'TELEPON', 'PHONE', 'TELP'],
                    'Canvasing'              => ['CANVASING', 'KANVASING', 'CANVAS', 'FLYERING', 'SEBAR BROSUR', 'BROSUR', 'CANVASING/FLYERING'],
                    'Data Base'              => ['DATABASE', 'DATA BASE', 'DB', 'CUSTOMER LAMA', 'RO', 'DATA BASE SERVICE', 'DB SERVICE'],
                    'Digital Hyperlocal'     => ['DIGITAL HYPERLOCAL', 'HYPERLOCAL', 'HYPER LOCAL', 'HYPER-LOCAL'],
                    'Digital Non Hyperlocal' => ['DIGITAL NON-HYPERLOCAL', 'DIGITAL NON HYPERLOCAL', 'NON-HYPERLOCAL', 'NON HYPERLOCAL', 'NON-HYPER LOCAL', 'NON HYPER'],
                    'Exhibition'             => ['EXHIBITION', 'PAMERAN', 'EVENT', 'EXPO', 'MALL', 'BAZAAR', 'DISPLAY', 'AUTO SHOW'],
                    'Media Digital'          => ['MEDIA DIGITAL', 'DIGITAL', 'SOSMED', 'INSTAGRAM', 'IG', 'FACEBOOK', 'FB', 'TIKTOK', 'GOOGLE', 'ADS', 'YOUTUBE', 'MEDSOS'],
                    'Media Elektronik'       => ['MEDIA ELEKTRONIK', 'ELEKTRONIK', 'RADIO', 'TV', 'BILLBOARD', 'KORAN', 'MAJALAH', 'CETAK'],
                    'Mediator'               => ['MEDIATOR', 'BROKER', 'PERANTARA', 'PIHAK KETIGA', 'AGENT', 'AGEN', 'SHOWROOM MOBIL BEKAS'],
                    'Referensi'              => ['REFERENSI CUSTOMER', 'REFERENSI', 'REF', 'TEMAN', 'KENALAN', 'KELUARGA', 'RELASI'],
                    'Referensi Customer'     => ['REFERENSI CUSTOMER', 'REF CUSTOMER', 'REF CUST', 'RO CUSTOMER', 'REKOMENDASI'],
                    'Showroom Activity'      => ['SHOWROOM ACTIVITY', 'SHOWROOM EVENT', 'WEEKEND SALES', 'CUSTOMER GATHERING', 'GATHERING', 'SHOWROOM EVENT / GATHERING'],
                    'Showroom Walk-in'       => ['SHOWROOM WALK-IN', 'SHOWROOM WALK IN', 'WALK-IN', 'WALK IN', 'WALKIN', 'SHOWROOM', 'DATANG LANGSUNG', 'KUNJUNGAN', 'WALK-IN SHOWROOM', 'WALK IN SHOWROOM'],
                    'Website Dealer'         => ['WEBSITE DEALER', 'WEBSITE', 'WEB', 'PORTAL', 'LANDING PAGE', 'WEB DEALER', 'WEBSITE RESMI'],
                ];

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

                    $serverActInq = $inqForBranch->filter(function($k) use ($patterns) {
                        $perolehan = strtoupper(trim($k->PerolehanData ?? ''));
                        foreach ($patterns as $pat) {
                            if (stripos($perolehan, strtoupper($pat)) !== false) return true;
                        }
                        return false;
                    })->count();

                    $act_inq = $serverActInq;

                    $serverActDo = $doForBranch->filter(function($k) use ($patterns) {
                        $perolehan = strtoupper(trim($k->PerolehanData ?? ''));
                        $prog = strtoupper(trim($k->LastProgress ?? ''));
                        if (!in_array($prog, ['DELIVERY', 'DO'])) return false;

                        foreach ($patterns as $pat) {
                            if (stripos($perolehan, strtoupper($pat)) !== false) return true;
                        }
                        return false;
                    })->count();

                    $act_do = $serverActDo;

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

                $all_branch_data[$cabang] = [
                    'performance'          => collect($performance),
                    'salesforce'           => collect($salesforce_performance),
                    'soi_performance_data' => collect($soi_performance_data),
                    'leasing_performance'  => collect($leasing_performance),
                ];
            }

            return [
                'all_branch_data' => $all_branch_data,
                'bulan'           => $bulan,
                'bulan_list'      => $bulanMap
            ];
        });

        return view('sales.vsv.dashboard', $viewDataV2);
    }

    private function isModelMatch($itemStr, $displayName, $patterns, $variantStr = '')
    {
        $fullStr = strtoupper(trim($itemStr . ' ' . $variantStr));

        if ($displayName === 'JIMNY 5D') {
            $hasJimny = (stripos($fullStr, 'JIMNY') !== false || stripos($fullStr, 'JIM') !== false || stripos($fullStr, 'JMN') !== false || stripos($fullStr, 'SN413') !== false || stripos($fullStr, 'JB74') !== false || stripos($fullStr, 'JB674') !== false);
            $has5D = (stripos($fullStr, '5D') !== false || stripos($fullStr, '5-DOOR') !== false || stripos($fullStr, '5 DOOR') !== false);
            return $hasJimny && $has5D;
        }

        if ($displayName === 'JIMNY 3D') {
            $hasJimny = (stripos($fullStr, 'JIMNY') !== false || stripos($fullStr, 'JIM') !== false || stripos($fullStr, 'JMN') !== false || stripos($fullStr, 'SN413') !== false || stripos($fullStr, 'JB74') !== false || stripos($fullStr, 'JB674') !== false);
            $has5D = (stripos($fullStr, '5D') !== false || stripos($fullStr, '5-DOOR') !== false || stripos($fullStr, '5 DOOR') !== false);
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
}