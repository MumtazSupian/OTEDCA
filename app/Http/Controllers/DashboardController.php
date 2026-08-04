<?php

namespace App\Http\Controllers;

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
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return (new \App\Http\Controllers\Finance\DashboardController())->index();
    }

    public function v1(Request $request)
    {
        @set_time_limit(300);
        @ini_set('max_execution_time', '300');
        $user = Auth::user();
        $tahunSekarang = 2026;

        $isAdminOrOM = in_array(strtolower($user->role), ['admin', 'om', 'admin dca', 'om dca', 'bm']);
        $isSH = strtolower($user->role) == 'sh';

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

        // Fallback to to_date if explicitly provided without filter_bulan
        if (!$request->has('filter_bulan') && !$request->has('bulan') && $request->has('to_date')) {
            $t = strtotime($request->get('to_date'));
            if ($t) {
                $currMonthNum = (int)date('n', $t);
                $currYear = (int)date('Y', $t);
            }
        }

        // Current month date boundaries
        $daysInCurr = cal_days_in_month(CAL_GREGORIAN, $currMonthNum, $currYear);
        $fromDate   = sprintf("%04d-%02d-01", $currYear, $currMonthNum);
        $toDate     = sprintf("%04d-%02d-%02d", $currYear, $currMonthNum, $daysInCurr);
        $bulanCurr  = $bulanMap[$currMonthNum] ?? 'jul';

        // Calculate previous period dates (1 month prior with exact boundaries)
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

        // Urutan cabang: CIAWI, CIANJUR, CINERE, JATIASIH, CIPANAS
        if ($request->has('cabang') && !empty($request->get('cabang'))) {
            $cabangs = [$request->get('cabang')];
        } else {
            $cabangs = ['Ciawi', 'Cianjur', 'Cinere', 'Jatiasih', 'Cipanas'];
        }

        $shUserIds = User::whereRaw('LOWER(role) = ?', ['sh'])->pluck('id')->toArray();

        $modelList = [
            'NEW CARRY'      => ['NEW CARRY', 'CARRY', 'DC', 'AEV'],
            'XL7'            => ['XL7', 'XL-7', 'XL 7'],
            'FRONX'          => ['FRONX', 'BU4'],
            'ALL NEW ERTIGA' => ['ALL NEW ERTIGA', 'ERTIGA', 'A3L'],
            'APV'            => ['APV BLIND VAN', 'APV', 'GC4'],
            'S-PRESSO'       => ['S-PRESSO', 'SPRESO', 'S PRESSO', 'DN4'],
            'GRAND VITARA'   => ['GRAND VITARA', 'VITARA'],
            'JIMNY 3D'       => ['JIMNY 3D', 'JIMNY 3-DOOR'],
            'JIMNY 5D'       => ['JIMNY 5D', 'JIMNY 5-DOOR'],
        ];

        $branchCodeMap = [
            'Ciawi'    => ['641940101', '01.19.08.102', 'CIAWI'],
            'Cianjur'  => ['641940102', '06.24.11.005', 'CIANJUR'],
            'Cinere'   => ['641940103', '03.24.02.001', 'CINERE'],
            'Jatiasih' => ['641940104', '06.25.11.001', 'JATIASIH'],
            'Cipanas'  => ['641940106', '14.26.01.549', 'CIPANAS'],
        ];

        // --- BATCH QUERY REMOTE DATABASE (INQUIRY & SPK FROM pmKDP ON DMS SERVER) ---
        $allKdpPrevInquiryRecords = collect();
        $allKdpCurrInquiryRecords = collect();
        $allKdpPrevSpkRecords = collect();
        $allKdpCurrSpkRecords = collect();

        // --- BATCH QUERY REMOTE DATABASE (FAKTUR POLISI ON DMS SERVER) ---
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

            // Faktur Polisi date boundaries: dari tanggal 2 bulan berjalan (00:00:00) s/d tanggal 1 bulan berikutnya (23:59:59)
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

            // 1. INQUIRY FROM pmKDP
            try {
                $qInqPrev = \App\Models\Sales\vsv\Kdp::whereBetween('InquiryDate', [$prevStartDate, $prevEndDate]);
                $qInqCurr = \App\Models\Sales\vsv\Kdp::whereBetween('InquiryDate', [$currStartDate, $currEndDate]);
                if (!empty($allBranchCodes)) {
                    $qInqPrev->whereIn('BranchCode', $allBranchCodes);
                    $qInqCurr->whereIn('BranchCode', $allBranchCodes);
                }
                $allKdpPrevInquiryRecords = $qInqPrev->get(['BranchCode', 'TipeKendaraan', 'Variant', 'InquiryDate']);
                $allKdpCurrInquiryRecords = $qInqCurr->get(['BranchCode', 'TipeKendaraan', 'Variant', 'InquiryDate']);
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error("Dashboard v1 Inquiry Error: " . $e->getMessage());
            }

            // 2. SPK FROM omTrSalesSO (using BranchCode & SODate)
            try {
                $qSpkPrev = \Illuminate\Support\Facades\DB::connection('dms')->table('omTrSalesSO')
                    ->join('omTrSalesSOModel', function($join) {
                        $join->on('omTrSalesSO.SONo', '=', 'omTrSalesSOModel.SONo')
                             ->on('omTrSalesSO.BranchCode', '=', 'omTrSalesSOModel.BranchCode');
                    })->whereBetween('omTrSalesSO.SODate', [$prevStartDate, $prevEndDate]);

                $qSpkCurr = \Illuminate\Support\Facades\DB::connection('dms')->table('omTrSalesSO')
                    ->join('omTrSalesSOModel', function($join) {
                        $join->on('omTrSalesSO.SONo', '=', 'omTrSalesSOModel.SONo')
                             ->on('omTrSalesSO.BranchCode', '=', 'omTrSalesSOModel.BranchCode');
                    })->whereBetween('omTrSalesSO.SODate', [$currStartDate, $currEndDate]);

                if (!empty($allBranchCodes)) {
                    $qSpkPrev->whereIn('omTrSalesSO.BranchCode', $allBranchCodes);
                    $qSpkCurr->whereIn('omTrSalesSO.BranchCode', $allBranchCodes);
                }

                $allKdpPrevSpkRecords = $qSpkPrev->select(['omTrSalesSO.BranchCode', 'omTrSalesSOModel.SalesModelCode as TipeKendaraan', 'omTrSalesSO.SODate as SPKDate'])->get();
                $allKdpCurrSpkRecords = $qSpkCurr->select(['omTrSalesSO.BranchCode', 'omTrSalesSOModel.SalesModelCode as TipeKendaraan', 'omTrSalesSO.SODate as SPKDate'])->get();
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error("Dashboard v1 SPK Error: " . $e->getMessage());
            }

            // 3. FAKTUR POLISI FROM omTrSalesReqDetail (using CreatedDate: tgl 2 s/d tgl 1 bulan berikutnya)
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

            // Filter pmKDP for branch
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

            // Filter Faktur Polisi for branch
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
                    return $this->isModelMatch($item->TipeKendaraan ?? '', $displayName, $dbTypes, $item->Variant ?? '');
                })->count();

                $spkCurr = $spkCurrForBranch->filter(function($item) use ($displayName, $dbTypes) {
                    return $this->isModelMatch($item->TipeKendaraan ?? '', $displayName, $dbTypes, $item->Variant ?? '');
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

                $viewData = [
            'all_branch_review_data' => $all_branch_review_data,
            'fromDate'       => $fromDate,
            'toDate'         => $toDate,
            'filter_bulan'   => $bulanCurr,
            'bulanMap'       => $bulanMap,
            'prevMonthLabel' => $prevMonthLabel,
            'currMonthLabel' => $currMonthLabel,
        ];

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

        $isAdminOrOM = in_array(strtolower($user->role), ['admin', 'om', 'admin dca', 'om dca', 'bm']);
        $isSH = strtolower($user->role) == 'sh';

        $bulanMap = [
            1 => 'jan', 2 => 'feb', 3 => 'mar', 4 => 'apr', 5 => 'mei', 6 => 'jun',
            7 => 'jul', 8 => 'agu', 9 => 'sep', 10 => 'okt', 11 => 'nov', 12 => 'des'
        ];

        $bulanSekarangAngka = (int)date('n');
        $bulanDefault = $bulanMap[$bulanSekarangAngka];
        $bulan = $request->get('filter_bulan', $bulanDefault);

        // Urutan cabang: CIAWI, CIANJUR, CINERE, JATIASIH, CIPANAS
        if ($request->has('cabang') && !empty($request->get('cabang'))) {
            $cabangs = [$request->get('cabang')];
        } else {
            $cabangs = ['Ciawi', 'Cianjur', 'Cinere', 'Jatiasih', 'Cipanas'];
        }

        $shUserIds = User::whereRaw('LOWER(role) = ?', ['sh'])->pluck('id')->toArray();

        $branchCodeMap = [
            'Ciawi'    => ['641940101', '01.19.08.102', 'CIAWI'],
            'Cianjur'  => ['641940102', '06.24.11.005', 'CIANJUR'],
            'Cinere'   => ['641940103', '03.24.02.001', 'CINERE'],
            'Jatiasih' => ['641940104', '06.25.11.001', 'JATIASIH'],
            'Cipanas'  => ['641940106', '14.26.01.549', 'CIPANAS'],
        ];

        $modelList = [
            'NEW CARRY'      => ['NEW CARRY', 'CARRY', 'DC', 'AEV'],
            'APV BLIND VAN'  => ['APV BLIND VAN', 'APV'],
            'ERTIGA'         => ['ALL NEW ERTIGA', 'ERTIGA'],
            'XL7'            => ['XL7', 'XL-7', 'XL 7'],
            'SPRESO'         => ['S-PRESSO', 'SPRESO', 'S PRESSO'],
            'IGNIS'          => ['IGNIS'],
            'e-VITARA'       => ['e-VITARA', 'EVITARA'],
            'GRAND VITARA'   => ['GRAND VITARA', 'VITARA'],
            'JIMNY 3D'       => ['JIMNY 3D', 'JIMNY 3-DOOR'],
            'JIMNY 5D'       => ['JIMNY 5D', 'JIMNY 5-DOOR'],
            'FRONX'          => ['FRONX'],
            'BALENO'         => ['BALENO'],
        ];

        $currMonthNum = array_search($bulan, $bulanMap) ?: 7;
        $daysInMonth    = cal_days_in_month(CAL_GREGORIAN, $currMonthNum, $tahunSekarang);
        $startDateMonth = sprintf("%04d-%02d-01 00:00:00", $tahunSekarang, $currMonthNum);
        $endDateMonth   = sprintf("%04d-%02d-%02d 23:59:59", $tahunSekarang, $currMonthNum, $daysInMonth);
        $ytdStartDate   = sprintf("%04d-01-01 00:00:00", $tahunSekarang);
        $nextMonthNum   = ($currMonthNum < 12) ? $currMonthNum + 1 : 12;

        $allBranchCodes = [];
        foreach ($cabangs as $cb) {
            if (!empty($branchCodeMap[$cb])) {
                $allBranchCodes = array_merge($allBranchCodes, $branchCodeMap[$cb]);
            }
        }

        // 1. BATCH FETCH FROM REMOTE SERVER DMS MODELS (PlanSales, Kdp, omTrSalesFakturPolisi)
        $allPlanSalesRecords = collect();
        $allInquiryRecords   = collect();
        $allSpkRecords       = collect();
        $allFpYtdRecords     = collect();

        try {
            $allPlanSalesRecords = \App\Models\Sales\vsv\PlanSales::where('Year', $tahunSekarang)
                ->whereIn('SourceName', ['ByType', 'ByActivity'])
                ->whereIn('BranchCode', $allBranchCodes)
                ->get(['BranchCode', 'Year', 'Month', 'SourceName', 'DetailName', 'DetailCode', 'DO_Week1', 'DO_Week2', 'DO_Week3', 'DO_Week4', 'DO_Week5', 'SPK_Week1', 'SPK_Week2', 'SPK_Week3', 'SPK_Week4', 'SPK_Week5', 'INQ_Week1', 'INQ_Week2', 'INQ_Week3', 'INQ_Week4', 'INQ_Week5']);

            $allInquiryRecords = \App\Models\Sales\vsv\Kdp::whereBetween('InquiryDate', [$startDateMonth, $endDateMonth])
                ->whereIn('BranchCode', $allBranchCodes)
                ->get(['BranchCode', 'TipeKendaraan', 'Variant', 'InquiryDate', 'PerolehanData', 'LastProgress']);

            $allSpkRecords = \App\Models\Sales\vsv\Kdp::whereBetween('SPKDate', [$startDateMonth, $endDateMonth])
                ->whereIn('BranchCode', $allBranchCodes)
                ->get(['BranchCode', 'TipeKendaraan', 'Variant', 'SPKDate']);

            $allFpYtdRecords = \App\Models\Sales\vsv\omTrSalesFakturPolisi::whereBetween('CreatedDate', [$ytdStartDate, $endDateMonth])
                ->whereIn('BranchCode', $allBranchCodes)
                ->get(['BranchCode', 'SalesModelCode', 'CreatedDate', 'IsBlanko']);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("Dashboard v2 DMS Error: " . $e->getMessage());
        }

        $allFpCurrRecords = $allFpYtdRecords->filter(function($item) use ($startDateMonth) {
            return ($item->CreatedDate ?? '') >= $startDateMonth;
        });

        // 2. BATCH FETCH LOCAL MYSQL MODELS (Eliminates 2,000+ individual SQL queries for fast execution)
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

            // Filter DMS Server records for this branch
            $plansForBranch = $allPlanSalesRecords->filter(function($item) use ($branchCodes) {
                $bCode = trim($item->BranchCode ?? '');
                return in_array($bCode, $branchCodes);
            });

            $inqForBranch = $allInquiryRecords->filter(function($item) use ($branchCodes) {
                $bCode = trim($item->BranchCode ?? '');
                return in_array($bCode, $branchCodes);
            });

            $spkForBranch = $allSpkRecords->filter(function($item) use ($branchCodes) {
                $bCode = trim($item->BranchCode ?? '');
                return in_array($bCode, $branchCodes);
            });

            $fpCurrForBranch = $allFpCurrRecords->filter(function($item) use ($branchCodes) {
                $bCode = trim($item->BranchCode ?? '');
                return in_array($bCode, $branchCodes);
            });

            $fpYtdForBranch = $allFpYtdRecords->filter(function($item) use ($branchCodes) {
                $bCode = trim($item->BranchCode ?? '');
                return in_array($bCode, $branchCodes);
            });

            // --- A. PERFORMANCE UNIT ---
            $performance = [];

            foreach ($modelList as $displayName => $dbTypes) {
                // TRG RKA Server
                $serverTrgRka = $plansForBranch->where('SourceName', 'ByType')->where('Month', $currMonthNum)->filter(function($p) use ($displayName, $dbTypes) {
                    return $this->isModelMatch(($p->DetailName ?? '') . ' ' . ($p->DetailCode ?? ''), $displayName, $dbTypes);
                })->sum(function($p) {
                    return ($p->DO_Week1 ?? 0) + ($p->DO_Week2 ?? 0) + ($p->DO_Week3 ?? 0) + ($p->DO_Week4 ?? 0) + ($p->DO_Week5 ?? 0);
                });

                // ACT INQ Server
                $serverActInq = $inqForBranch->filter(function($item) use ($displayName, $dbTypes) {
                    return $this->isModelMatch($item->TipeKendaraan ?? '', $displayName, $dbTypes, $item->Variant ?? '');
                })->count();

                // ACT SPK Server
                $serverActSpk = $spkForBranch->filter(function($item) use ($displayName, $dbTypes) {
                    return $this->isModelMatch($item->TipeKendaraan ?? '', $displayName, $dbTypes, $item->Variant ?? '');
                })->count();

                // ACT DO Server
                $serverActDo = $fpCurrForBranch->filter(function($item) use ($displayName, $dbTypes) {
                    return $this->isModelMatch($item->SalesModelCode ?? '', $displayName, $dbTypes);
                })->count();

                // YTD TRG RKA Server
                $serverYtdTarget = $plansForBranch->where('SourceName', 'ByType')->where('Month', '<=', $currMonthNum)->filter(function($p) use ($displayName, $dbTypes) {
                    return $this->isModelMatch(($p->DetailName ?? '') . ' ' . ($p->DetailCode ?? ''), $displayName, $dbTypes);
                })->sum(function($p) {
                    return ($p->DO_Week1 ?? 0) + ($p->DO_Week2 ?? 0) + ($p->DO_Week3 ?? 0) + ($p->DO_Week4 ?? 0) + ($p->DO_Week5 ?? 0);
                });

                // YTD ACT DO Server
                $serverYtdActDo = $fpYtdForBranch->filter(function($item) use ($displayName, $dbTypes) {
                    return $this->isModelMatch($item->SalesModelCode ?? '', $displayName, $dbTypes);
                })->count();

                // Sales Plan (N+1) RKA Server
                $serverPlanRkaNext = $plansForBranch->where('SourceName', 'ByType')->where('Month', $nextMonthNum)->filter(function($p) use ($displayName, $dbTypes) {
                    return $this->isModelMatch(($p->DetailName ?? '') . ' ' . ($p->DetailCode ?? ''), $displayName, $dbTypes);
                })->sum(function($p) {
                    return ($p->DO_Week1 ?? 0) + ($p->DO_Week2 ?? 0) + ($p->DO_Week3 ?? 0) + ($p->DO_Week4 ?? 0) + ($p->DO_Week5 ?? 0);
                });

                // Local fallback filtering in memory
                $locTrgRows = $allLocalTrg->where('cabang', $cabang)->where('type_unit', $displayName);
                $locDoRows  = $allLocalDo->where('cabang', $cabang)->where('type_unit', $displayName);
                $locSpkRows = $allLocalSpk->where('cabang', $cabang)->where('type_unit', $displayName);
                $locInqRows = $allLocalInq->where('cabang', $cabang)->where('type_unit', $displayName);

                $localTrgRka = (int)$locTrgRows->sum($bulan);
                $localActDo  = (int)$locDoRows->sum($bulan);
                $localActSpk = (int)$locSpkRows->sum($bulan);
                $localActInq = (int)$locInqRows->sum($bulan);

                $localYtdTarget = 0; $localYtdActDo = 0;
                foreach ($bulanMap as $m) {
                    $localYtdTarget += (int)$locTrgRows->sum($m);
                    $localYtdActDo  += (int)$locDoRows->sum($m);
                    if ($m == $bulan) break;
                }

                $localPlanRkaNext = (int)$locTrgRows->sum($nextMonthKey);

                $row = new \stdClass();
                $row->mobil_type    = $displayName;
                $row->$bulan        = $serverTrgRka > 0 ? $serverTrgRka : $localTrgRka;
                $row->act_do        = $serverActDo > 0 ? $serverActDo : $localActDo;
                $row->act_spk       = $serverActSpk > 0 ? $serverActSpk : $localActSpk;
                $row->act_inq       = $serverActInq > 0 ? $serverActInq : $localActInq;
                $row->ytd_target    = $serverYtdTarget > 0 ? $serverYtdTarget : $localYtdTarget;
                $row->ytd_act_do    = $serverYtdActDo > 0 ? $serverYtdActDo : $localYtdActDo;
                $row->plan_rka_next = $serverPlanRkaNext > 0 ? $serverPlanRkaNext : $localPlanRkaNext;

                $performance[] = $row;
            }

            // --- B. PERFORMANCE LEASING ---
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

            // --- C. PERFORMANCE SOI ---
            $all_sources = [
                'Call In (dari Iklan)', 'Canvasing', 'Data Base', 'Digital Hyperlocal',
                'Digital Non Hyperlocal', 'Exhibition', 'Media Digital', 'Media Elektronik',
                'Mediator', 'Referensi', 'Referensi Customer', 'Showroom Activity',
                'Showroom Walk-in', 'Website Dealer'
            ];

            $soiPatternsMap = [
                'Call In (dari Iklan)'   => ['CALL IN'],
                'Canvasing'              => ['CANVASING'],
                'Data Base'              => ['DATABASE', 'DATA BASE'],
                'Digital Hyperlocal'     => ['DIGITAL HYPERLOCAL'],
                'Digital Non Hyperlocal' => ['DIGITAL NON-HYPERLOCAL', 'DIGITAL NON HYPERLOCAL'],
                'Exhibition'             => ['EXHIBITION'],
                'Media Digital'          => ['MEDIA DIGITAL'],
                'Media Elektronik'       => ['MEDIA ELEKTRONIK'],
                'Mediator'               => ['MEDIATOR'],
                'Referensi'              => ['REFERENSI CUSTOMER', 'REFERENSI'],
                'Referensi Customer'     => ['REFERENSI CUSTOMER'],
                'Showroom Activity'      => ['SHOWROOM ACTIVITY'],
                'Showroom Walk-in'       => ['SHOWROOM WALK-IN', 'WALK-IN', 'WALK IN'],
                'Website Dealer'         => ['WEBSITE DEALER', 'WEBSITE'],
            ];

            $soi_performance_data = [];
            foreach ($all_sources as $source) {
                $patterns = $soiPatternsMap[$source] ?? [$source];

                // TRG INQ: From PlanSales (ByActivity) on server, with local fallback
                $serverTrgInq = $plansForBranch->where('SourceName', 'ByActivity')->where('Month', $currMonthNum)->filter(function($p) use ($patterns) {
                    $name = strtoupper(($p->DetailName ?? '') . ' ' . ($p->DetailCode ?? ''));
                    foreach ($patterns as $pat) {
                        if (stripos($name, strtoupper($pat)) !== false) return true;
                    }
                    return false;
                })->sum(function($p) {
                    return ($p->INQ_Week1 ?? 0) + ($p->INQ_Week2 ?? 0) + ($p->INQ_Week3 ?? 0) + ($p->INQ_Week4 ?? 0) + ($p->INQ_Week5 ?? 0);
                });

                $locTInq = $allLocalTInq->where('cabang', $cabang)->where('source_inquary', $source);
                if ($isSH) $locTInq = $locTInq->where('user_id', $user->id);
                $localTrgInq = (int)$locTInq->sum($bulan);

                $trg_inq = $serverTrgInq > 0 ? $serverTrgInq : $localTrgInq;

                // TRG DO: From PlanSales (ByActivity) on server, with local fallback
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

                $locTDo = $allLocalTDo->where('cabang', $cabang)->where('source_inquiry', $source);
                if ($isSH) $locTDo = $locTDo->where('user_id', $user->id);
                $localTrgDo = (int)$locTDo->sum($bulan);
                $trg_do = $serverTrgDo > 0 ? $serverTrgDo : $localTrgDo;

                // ACT INQ: From Kdp (InquiryDate) on server, with local fallback
                $serverActInq = $inqForBranch->filter(function($k) use ($patterns) {
                    $perolehan = strtoupper($k->PerolehanData ?? '');
                    foreach ($patterns as $pat) {
                        if (stripos($perolehan, strtoupper($pat)) !== false) return true;
                    }
                    return false;
                })->count();

                $locAInq = $allLocalAInq->where('cabang', $cabang)->where('source_inquary', $source);
                if ($isSH) $locAInq = $locAInq->where('user_id', $user->id);
                $localActInq = (int)$locAInq->sum($bulan);
                $act_inq = $serverActInq > 0 ? $serverActInq : $localActInq;

                // ACT DO: From Kdp (LastProgress = DO/DELIVERY) on server, with local fallback
                $serverActDo = $inqForBranch->filter(function($k) use ($patterns) {
                    $perolehan = strtoupper($k->PerolehanData ?? '');
                    $prog = strtoupper(trim($k->LastProgress ?? ''));
                    if ($prog !== 'DO' && $prog !== 'DELIVERY') return false;
                    foreach ($patterns as $pat) {
                        if (stripos($perolehan, strtoupper($pat)) !== false) return true;
                    }
                    return false;
                })->count();

                $locADo = $allLocalADo->where('cabang', $cabang)->where('source_inquary', $source);
                if ($isSH) $locADo = $locADo->where('user_id', $user->id);
                $localActDo = (int)$locADo->sum($bulan);
                $act_do = $serverActDo > 0 ? $serverActDo : $localActDo;

                $soi_performance_data[] = (object)[
                    'source_name' => $source,
                    'trg_inq'     => $trg_inq,
                    'act_inq'     => $act_inq,
                    'trg_do'      => $trg_do,
                    'act_do'      => $act_do
                ];
            }

            // --- D. PERFORMANCE SALES FORCE ---
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

        return view('sales.vsv.dashboard', [
            'all_branch_data'      => $all_branch_data,
            'bulan'                => $bulan,
            'bulan_list'           => $bulanMap
        ]);
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