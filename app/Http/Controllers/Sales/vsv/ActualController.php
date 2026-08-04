<?php

namespace App\Http\Controllers\Sales\vsv;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales\vsv\Kdp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ActualController extends Controller
{
    public function doByType(Request $request)
    {
        return $this->processActual($request, 'do', 'ACTUAL DO BY TYPE', 'By Type Mobil');
    }

    public function spkByType(Request $request)
    {
        return $this->processActual($request, 'spk', 'ACTUAL SPK BY TYPE', 'By Type Mobil');
    }

    public function inquiryByType(Request $request)
    {
        return $this->processActualInquiry($request, 'ACTUAL INQUIRY BY TYPE', 'By Type Mobil');
    }

    public function sourceInquiry(Request $request)
    {
        return $this->processActualSource($request, 'source_inquiry', 'ACTUAL SOURCE INQUIRY', 'Berdasarkan Sumber Data');
    }

    public function sourceDoInquiry(Request $request)
    {
        return $this->processActualSource($request, 'source_do_inquiry', 'ACTUAL SOURCE DO INQUIRY', 'Berdasarkan Sumber Data');
    }

    public function salesByLeasing(Request $request)
    {
        return $this->processActualSalesByLeasing($request, 'ACTUAL SALES BY LEASING', 'By Leasing');
    }

    private function processActual(Request $request, $viewType, $pageTitle, $headerLabel)
    {
        $selectedMonth = $request->input('month', date('n'));
        $selectedYear = $request->input('year', date('Y'));

        $branchCode = $request->input('BranchCode', $request->input('branch_code', $request->input('branch_manager')));
        $spvId = $request->input('SpvEmployeeID', $request->input('spv_id', $request->input('sales_head')));
        $salesman = $request->input('salesman');

        $fromDate = $request->input('from_date', "{$selectedYear}-" . str_pad($selectedMonth, 2, '0', STR_PAD_LEFT) . "-01");
        $toDate = $request->input('to_date', date('Y-m-t', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)));

        try {
            // 1. Resolusi BranchCode
            $bmBranchCodeMapping = [
                '14.26.01.549' => '641940106', // EDI SUMARDI -> DCA Cipanas
                '03.24.02.001' => '641940103', // Subagja -> DCA Cinere
                '06.25.11.001' => '641940104', // JOHN EDUWARD SIMATUPANG -> DCA Jatiasih
                '06.24.11.005' => '641940102', // ANGGARINI AMITHAWARDHANI -> DCA Cianjur
                '01.19.08.102' => '641940101', // RONALD NOVEMBRI W -> DCA Ciawi
            ];

            $matchingBranchCodes = [];
            if (!empty($branchCode)) {
                // Cek apakah input adalah EmployeeID dari BM
                if (isset($bmBranchCodeMapping[$branchCode])) {
                    $matchingBranchCodes = [$bmBranchCodeMapping[$branchCode]];
                } else {
                    $empBranch = DB::connection('dms')
                        ->table('gnMstEmployee')
                        ->where('EmployeeID', $branchCode)
                        ->value('BranchCode');
                    
                    if ($empBranch) {
                        $matchingBranchCodes = [$empBranch];
                    } else {
                        $matchingBranchCodes = DB::connection('dms')
                            ->table('gnMstOrganizationDtl')
                            ->where('BranchCode', 'LIKE', "%{$branchCode}%")
                            ->orWhere('BranchName', 'LIKE', "%{$branchCode}%")
                            ->pluck('BranchCode')
                            ->unique()
                            ->values()
                            ->toArray();
                    }
                }
            }

            // 2. Resolusi SpvEmployeeID
            $matchingSpvIds = [];
            if (!empty($spvId)) {
                $matchingSpvIds = DB::connection('dms')
                    ->table('gnMstEmployee')
                    ->where('EmployeeID', 'LIKE', "%{$spvId}%")
                    ->orWhere('EmployeeName', 'LIKE', "%{$spvId}%")
                    ->pluck('EmployeeID')
                    ->unique()
                    ->values()
                    ->toArray();
            }

            // 3. Query data dari model Kdp (koneksi dms -> tabel pmKDP)
            $query = Kdp::query();

            // Filter tanggal berdasarkan from_date & to_date jika diisi, atau bulan & tahun
            if (!empty($fromDate) && !empty($toDate)) {
                $query->whereBetween('InquiryDate', ["{$fromDate} 00:00:00", "{$toDate} 23:59:59"]);
            } else {
                $query->whereMonth('InquiryDate', $selectedMonth)
                      ->whereYear('InquiryDate', $selectedYear);
            }

            // Filter BranchCode
            if (!empty($matchingBranchCodes)) {
                $query->whereIn('BranchCode', $matchingBranchCodes);
            } elseif (!empty($branchCode)) {
                $query->where('BranchCode', 'LIKE', "%{$branchCode}%");
            }

            // Filter SPV / Sales Head
            if (!empty($matchingSpvIds)) {
                $query->whereIn('SpvEmployeeID', $matchingSpvIds);
            } elseif (!empty($spvId)) {
                $query->where('SpvEmployeeID', 'LIKE', "%{$spvId}%");
            }

            // Filter Salesman
            if (!empty($salesman)) {
                $query->where(function($q) use ($salesman) {
                    $q->where('EmployeeID', 'LIKE', "%{$salesman}%")
                      ->orWhere('CreatedBy', 'LIKE', "%{$salesman}%");
                });
            }

            // Tanpa filter branch_manager & sales_head, query akan mengambil seluruh data untuk rentang tanggal from_date s/d to_date
            $rawResults = $query->selectRaw("
                TipeKendaraan,
                Variant,
                SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'SPK' THEN 1 ELSE 0 END) as total_spk,
                SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'DO' THEN 1 ELSE 0 END) as total_do,
                SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'DELIVERY' THEN 1 ELSE 0 END) as total_delivery
            ")
            ->whereNotNull('TipeKendaraan')
            ->where('TipeKendaraan', '!=', '')
            ->groupBy('TipeKendaraan', 'Variant')
            ->orderBy('TipeKendaraan')
            ->orderBy('Variant')
            ->get();

            // Gabungkan TipeKendaraan & Variant untuk tampilan
            $data = $rawResults->map(function ($row) {
                $tipe = trim($row->TipeKendaraan);
                $variant = trim($row->Variant ?? '');
                if (!empty($variant)) {
                    $row->TipeKendaraan = "{$tipe} {$variant}";
                } else {
                    $row->TipeKendaraan = $tipe;
                }
                return $row;
            });

            $bmBranchCodeMapping = [
                '14.26.01.549' => '641940106', // EDI SUMARDI -> DCA Cipanas
                '03.24.02.001' => '641940103', // Subagja -> DCA Cinere
                '06.25.11.001' => '641940104', // JOHN EDUWARD SIMATUPANG -> DCA Jatiasih
                '06.24.11.005' => '641940102', // ANGGARINI AMITHAWARDHANI -> DCA Cianjur
                '01.19.08.102' => '641940101', // RONALD NOVEMBRI W -> DCA Ciawi
            ];

            // 1. Branch Manager List dari HrEmployee
            $bmsRaw = DB::connection('dms')
                ->table('HrEmployee')
                ->select('EmployeeID', 'EmployeeName')
                ->where('Position', 'BM')
                ->where('PersonnelStatus', '1')
                ->where('IsDeleted', '0')
                ->orderBy('EmployeeName')
                ->get();

            $bmsMap = [];
            $bmBranchMap = [];
            foreach ($bmsRaw as $bm) {
                $bCode = $bmBranchCodeMapping[$bm->EmployeeID] ?? '641940106';
                $bmsMap[$bm->EmployeeID] = [
                    'Name'       => $bm->EmployeeName,
                    'Jabatan'    => 'BM',
                    'BranchCode' => $bCode,
                ];
                $bmBranchMap[$bm->EmployeeID] = $bCode;
            }

            // 2. Sales Head List (diambil dari Target RKA PlanSales & gnMstEmployee)
            $planCombos = \App\Models\Sales\vsv\PlanSales::select('BranchCode', 'SpvEmployeeID')
                ->whereNotNull('SpvEmployeeID')
                ->where('SpvEmployeeID', '!=', '')
                ->distinct()
                ->get();

            $spvBranchRel = [];
            foreach ($planCombos as $combo) {
                $spvBranchRel[$combo->SpvEmployeeID] = $combo->BranchCode;
            }

            $spvCodes = array_keys($spvBranchRel);

            $spvsRaw = DB::connection('dms')
                ->table('gnMstEmployee')
                ->select('EmployeeID', 'EmployeeName', 'BranchCode', 'TitleCode')
                ->whereIn('EmployeeID', $spvCodes)
                ->where('PersonnelStatus', '1')
                ->orderBy('EmployeeName')
                ->get()
                ->unique('EmployeeID');

            $spvsMap = [];
            $branchSpvMap = [];
            foreach ($spvsRaw as $s) {
                $spvBranchCode = $spvBranchRel[$s->EmployeeID] ?? $s->BranchCode;
                $spvsMap[$s->EmployeeID] = [
                    'Name'       => $s->EmployeeName,
                    'Jabatan'    => 'SH',
                    'BranchCode' => $spvBranchCode,
                ];
                if (!isset($branchSpvMap[$spvBranchCode])) {
                    $branchSpvMap[$spvBranchCode] = [];
                }
                $branchSpvMap[$spvBranchCode][] = $s->EmployeeID;
            }

            $branchManagerName = '';
            if (!empty($branchCode) && isset($bmsMap[$branchCode])) {
                $branchManagerName = $bmsMap[$branchCode]['Name'];
            }

            $salesHeadName = '';
            if (!empty($spvId) && isset($spvsMap[$spvId])) {
                $salesHeadName = $spvsMap[$spvId]['Name'];
            }

            $subTitleText = ($viewType === 'spk')
                ? 'Monitoring data aktual SPK berdasarkan tipe kendaraan'
                : 'Monitoring data aktual Delivery Order (DO) & Delivery berdasarkan tipe kendaraan';

            return view('sales.vsv.actual.index', [
                'data'              => $data,
                'pageTitle'         => $pageTitle,
                'subTitle'          => $subTitleText,
                'viewType'          => $viewType,
                'headerLabel'       => $headerLabel,
                'fromDate'          => $fromDate,
                'toDate'            => $toDate,
                'selectedMonth'     => (int)$selectedMonth,
                'selectedYear'      => (int)$selectedYear,
                'bmsMap'            => $bmsMap,
                'spvsMap'           => $spvsMap,
                'bmBranchMap'       => $bmBranchMap,
                'branchSpvMap'      => $branchSpvMap,
                'branchManagerName' => $branchManagerName,
                'salesHeadName'     => $salesHeadName,
                'BranchCode'        => $branchCode,
                'SpvEmployeeID'     => $spvId
            ]);


        } catch (\Exception $e) {
            $data = collect();
            Log::error("Error saat membaca data Actual KDP dari DB Server: " . $e->getMessage());
            
            return view('sales.vsv.actual.index', [
                'pageTitle'     => $pageTitle,
                'headerLabel'   => $headerLabel,
                'subTitle'      => "Periode " . date('d M Y', strtotime($fromDate)) . " s/d " . date('d M Y', strtotime($toDate)),
                'fromDate'      => $fromDate,
                'toDate'        => $toDate,
                'selectedMonth' => (int)$selectedMonth,
                'selectedYear'  => (int)$selectedYear,
                'BranchCode'    => $branchCode,
                'data'          => $data
            ]);
        }
    }

    private function processActualInquiry(Request $request, $pageTitle, $headerLabel)
    {
        $selectedMonth = $request->input('month', date('n'));
        $selectedYear = $request->input('year', date('Y'));

        $branchCode = $request->input('BranchCode', $request->input('branch_code', $request->input('branch_manager')));
        $spvId = $request->input('SpvEmployeeID', $request->input('spv_id', $request->input('sales_head')));
        $salesman = $request->input('salesman');

        $fromDate = $request->input('from_date', "{$selectedYear}-" . str_pad($selectedMonth, 2, '0', STR_PAD_LEFT) . "-01");
        $toDate = $request->input('to_date', date('Y-m-t', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)));

        try {
            $bmBranchCodeMapping = [
                '14.26.01.549' => '641940106', // EDI SUMARDI -> DCA Cipanas
                '03.24.02.001' => '641940103', // Subagja -> DCA Cinere
                '06.25.11.001' => '641940104', // JOHN EDUWARD SIMATUPANG -> DCA Jatiasih
                '06.24.11.005' => '641940102', // ANGGARINI AMITHAWARDHANI -> DCA Cianjur
                '01.19.08.102' => '641940101', // RONALD NOVEMBRI W -> DCA Ciawi
            ];

            $matchingBranchCodes = [];
            if (!empty($branchCode)) {
                if (isset($bmBranchCodeMapping[$branchCode])) {
                    $matchingBranchCodes = [$bmBranchCodeMapping[$branchCode]];
                } else {
                    $empBranch = DB::connection('dms')
                        ->table('gnMstEmployee')
                        ->where('EmployeeID', $branchCode)
                        ->value('BranchCode');
                    
                    if ($empBranch) {
                        $matchingBranchCodes = [$empBranch];
                    } else {
                        $matchingBranchCodes = DB::connection('dms')
                            ->table('gnMstOrganizationDtl')
                            ->where('BranchCode', 'LIKE', "%{$branchCode}%")
                            ->orWhere('BranchName', 'LIKE', "%{$branchCode}%")
                            ->pluck('BranchCode')
                            ->unique()
                            ->values()
                            ->toArray();
                    }
                }
            }

            $matchingSpvIds = [];
            if (!empty($spvId)) {
                $matchingSpvIds = DB::connection('dms')
                    ->table('gnMstEmployee')
                    ->where('EmployeeID', 'LIKE', "%{$spvId}%")
                    ->orWhere('EmployeeName', 'LIKE', "%{$spvId}%")
                    ->pluck('EmployeeID')
                    ->unique()
                    ->values()
                    ->toArray();
            }

            $isSearched = $request->has('search') || $request->has('page');
            $perPage = (int)$request->input('per_page', 500);

            if ($isSearched) {
                $query = Kdp::query();

                if (!empty($fromDate) && !empty($toDate)) {
                    $query->whereBetween('InquiryDate', ["{$fromDate} 00:00:00", "{$toDate} 23:59:59"]);
                } else {
                    $query->whereMonth('InquiryDate', $selectedMonth)
                          ->whereYear('InquiryDate', $selectedYear);
                }

                if (!empty($matchingBranchCodes)) {
                    $query->whereIn('BranchCode', $matchingBranchCodes);
                } elseif (!empty($branchCode)) {
                    $query->where('BranchCode', 'LIKE', "%{$branchCode}%");
                }

                if (!empty($matchingSpvIds)) {
                    $query->whereIn('SpvEmployeeID', $matchingSpvIds);
                } elseif (!empty($spvId)) {
                    $query->where('SpvEmployeeID', 'LIKE', "%{$spvId}%");
                }

                if (!empty($salesman)) {
                    $query->where(function($q) use ($salesman) {
                        $q->where('EmployeeID', 'LIKE', "%{$salesman}%")
                          ->orWhere('CreatedBy', 'LIKE', "%{$salesman}%");
                    });
                }

                $paginated = $query->orderBy('InquiryNumber', 'asc')->paginate($perPage)->appends($request->all());

                $empIds = collect($paginated->items())->pluck('EmployeeID')->merge(collect($paginated->items())->pluck('CreatedBy'))->unique()->filter()->values()->toArray();
                $employeesMap = [];
                if (!empty($empIds)) {
                    $employeesMap = DB::connection('dms')->table('gnMstEmployee')
                        ->whereIn('EmployeeID', $empIds)
                        ->pluck('EmployeeName', 'EmployeeID')
                        ->toArray();
                }

                $spvIdsInKdp = collect($paginated->items())->pluck('SpvEmployeeID')->unique()->filter()->values()->toArray();
                $spvNamesMap = [];
                if (!empty($spvIdsInKdp)) {
                    $spvNamesMap = DB::connection('dms')->table('gnMstEmployee')
                        ->whereIn('EmployeeID', $spvIdsInKdp)
                        ->pluck('EmployeeName', 'EmployeeID')
                        ->toArray();
                }

                $inqNumbers = collect($paginated->items())->pluck('InquiryNumber')->unique()->filter()->values()->toArray();
                $sidMap = [];
                if (!empty($inqNumbers)) {
                    $sidMap = DB::connection('dms')->table('pmKdpAdditional')
                        ->whereIn('InquiryNumber', $inqNumbers)
                        ->pluck('SID', 'InquiryNumber')
                        ->toArray();
                }

                $paginated->getCollection()->transform(function($i) use ($employeesMap, $spvNamesMap, $sidMap) {
                    $i->WiraniagaName = $employeesMap[$i->EmployeeID] ?? $employeesMap[$i->CreatedBy] ?? $i->EmployeeID ?? '-';
                    $i->SalesHeadName = $spvNamesMap[$i->SpvEmployeeID] ?? $i->SpvEmployeeID ?? '-';
                    $i->EnquiryID = $sidMap[$i->InquiryNumber] ?? null;
                    return $i;
                });

                $data = $paginated;
            } else {
                $data = new \Illuminate\Pagination\LengthAwarePaginator([], 0, $perPage);
            }

            // 4. Fetch all 7 Branches from gnMstOrganizationDtl
            $branchesRaw = DB::connection('dms')
                ->table('gnMstOrganizationDtl')
                ->select('BranchCode', 'BranchName')
                ->orderBy('BranchCode')
                ->get();

            $branchesMap = [];
            foreach ($branchesRaw as $b) {
                $branchesMap[$b->BranchCode] = trim($b->BranchName);
            }

            // 5. Fetch all Sales Heads (SPVs)
            $spvIdsInKdp = DB::connection('dms')->table('pmKDP')
                ->select('SpvEmployeeID', 'BranchCode')
                ->distinct()
                ->whereNotNull('SpvEmployeeID')
                ->where('SpvEmployeeID', '!=', '')
                ->get();

            $spvCodes = $spvIdsInKdp->pluck('SpvEmployeeID')->unique()->filter()->values()->toArray();

            $spvsRaw = DB::connection('dms')
                ->table('gnMstEmployee')
                ->select('EmployeeID', 'EmployeeName', 'BranchCode')
                ->whereIn('EmployeeID', $spvCodes)
                ->where('PersonnelStatus', '1')
                ->orderBy('EmployeeName')
                ->get();

            $spvBranchRel = [];
            foreach ($spvIdsInKdp as $combo) {
                $spvBranchRel[$combo->SpvEmployeeID] = $combo->BranchCode;
            }

            $spvsMap = [];
            foreach ($spvsRaw as $s) {
                $bCode = $spvBranchRel[$s->EmployeeID] ?? $s->BranchCode;
                $spvsMap[$s->EmployeeID] = [
                    'Name'       => trim($s->EmployeeName),
                    'BranchCode' => $bCode
                ];
            }

            // 6. Fetch all Salesmen
            $salesmanIdsInKdp = DB::connection('dms')->table('pmKDP')
                ->select('EmployeeID', 'SpvEmployeeID', 'BranchCode')
                ->distinct()
                ->whereNotNull('EmployeeID')
                ->where('EmployeeID', '!=', '')
                ->get();

            $smCodes = $salesmanIdsInKdp->pluck('EmployeeID')->unique()->filter()->values()->toArray();

            $salesmenRaw = DB::connection('dms')
                ->table('gnMstEmployee')
                ->select('EmployeeID', 'EmployeeName', 'BranchCode')
                ->whereIn('EmployeeID', $smCodes)
                ->where('PersonnelStatus', '1')
                ->orderBy('EmployeeName')
                ->get();

            $smSpvRel = [];
            $smBranchRel = [];
            foreach ($salesmanIdsInKdp as $combo) {
                $smSpvRel[$combo->EmployeeID] = $combo->SpvEmployeeID;
                $smBranchRel[$combo->EmployeeID] = $combo->BranchCode;
            }

            $salesmenMap = [];
            foreach ($salesmenRaw as $sm) {
                $salesmenMap[$sm->EmployeeID] = [
                    'Name'          => trim($sm->EmployeeName),
                    'SpvEmployeeID' => $smSpvRel[$sm->EmployeeID] ?? '',
                    'BranchCode'    => $smBranchRel[$sm->EmployeeID] ?? $sm->BranchCode
                ];
            }

            $selectedBranchName = isset($branchesMap[$branchCode]) ? $branchesMap[$branchCode] : ($branchCode ?: '');
            $selectedSpvName = isset($spvsMap[$spvId]) ? $spvsMap[$spvId]['Name'] : ($spvId ?: '');
            $selectedSalesmanName = isset($salesmenMap[$salesman]) ? $salesmenMap[$salesman]['Name'] : ($salesman ?: '');

            return view('sales.vsv.actual.inquiry_index', [
                'data'                 => $data,
                'isSearched'           => $isSearched,
                'pageTitle'            => $pageTitle,
                'subTitle'             => 'Monitoring data rincian aktual inquiry berdasarkan tipe kendaraan',
                'headerLabel'          => $headerLabel,
                'fromDate'             => $fromDate,
                'toDate'               => $toDate,
                'selectedMonth'        => (int)$selectedMonth,
                'selectedYear'         => (int)$selectedYear,
                'branchesMap'          => $branchesMap,
                'spvsMap'              => $spvsMap,
                'salesmenMap'          => $salesmenMap,
                'selectedBranchName'   => $selectedBranchName,
                'selectedSpvName'      => $selectedSpvName,
                'selectedSalesmanName' => $selectedSalesmanName,
                'BranchCode'           => $branchCode,
                'SpvEmployeeID'        => $spvId,
                'salesman'             => $salesman
            ]);

        } catch (\Exception $e) {
            $data = collect();
            Log::error("Error saat membaca data Actual Inquiry KDP dari DB Server: " . $e->getMessage());
            
            return view('sales.vsv.actual.inquiry_index', [
                'pageTitle'         => $pageTitle,
                'headerLabel'       => $headerLabel,
                'subTitle'          => "Periode " . date('d M Y', strtotime($fromDate)) . " s/d " . date('d M Y', strtotime($toDate)),
                'fromDate'          => $fromDate,
                'toDate'            => $toDate,
                'selectedMonth'     => (int)$selectedMonth,
                'selectedYear'      => (int)$selectedYear,
                'BranchCode'        => $branchCode,
                'SpvEmployeeID'     => $spvId,
                'salesman'          => $salesman,
                'branchManagerName' => '',
                'salesHeadName'     => '',
                'salesmanName'      => '',
                'bmsMap'            => [],
                'spvsMap'           => [],
                'salesmenMap'       => [],
                'bmBranchMap'       => [],
                'branchSpvMap'      => [],
                'data'              => $data
            ]);
        }
    }

    private function processActualSource(Request $request, $viewType, $pageTitle, $headerLabel)
    {
        $selectedMonth = $request->input('month', date('n'));
        $selectedYear = $request->input('year', date('Y'));

        $branchCode = $request->input('BranchCode', $request->input('branch_code', $request->input('branch_manager')));
        $spvId = $request->input('SpvEmployeeID', $request->input('spv_id', $request->input('sales_head')));
        $salesman = $request->input('salesman');

        $fromDate = $request->input('from_date', "{$selectedYear}-" . str_pad($selectedMonth, 2, '0', STR_PAD_LEFT) . "-01");
        $toDate = $request->input('to_date', date('Y-m-t', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)));

        try {
            // 1. Resolusi BranchCode
            $bmBranchCodeMapping = [
                '14.26.01.549' => '641940106', // EDI SUMARDI -> DCA Cipanas
                '03.24.02.001' => '641940103', // Subagja -> DCA Cinere
                '06.25.11.001' => '641940104', // JOHN EDUWARD SIMATUPANG -> DCA Jatiasih
                '06.24.11.005' => '641940102', // ANGGARINI AMITHAWARDHANI -> DCA Cianjur
                '01.19.08.102' => '641940101', // RONALD NOVEMBRI W -> DCA Ciawi
            ];

            $matchingBranchCodes = [];
            if (!empty($branchCode)) {
                if (isset($bmBranchCodeMapping[$branchCode])) {
                    $matchingBranchCodes = [$bmBranchCodeMapping[$branchCode]];
                } else {
                    $empBranch = DB::connection('dms')
                        ->table('gnMstEmployee')
                        ->where('EmployeeID', $branchCode)
                        ->value('BranchCode');
                    
                    if ($empBranch) {
                        $matchingBranchCodes = [$empBranch];
                    } else {
                        $matchingBranchCodes = DB::connection('dms')
                            ->table('gnMstOrganizationDtl')
                            ->where('BranchCode', 'LIKE', "%{$branchCode}%")
                            ->orWhere('BranchName', 'LIKE', "%{$branchCode}%")
                            ->pluck('BranchCode')
                            ->unique()
                            ->values()
                            ->toArray();
                    }
                }
            }

            // 2. Resolusi SpvEmployeeID
            $matchingSpvIds = [];
            if (!empty($spvId)) {
                $matchingSpvIds = DB::connection('dms')
                    ->table('gnMstEmployee')
                    ->where('EmployeeID', 'LIKE', "%{$spvId}%")
                    ->orWhere('EmployeeName', 'LIKE', "%{$spvId}%")
                    ->pluck('EmployeeID')
                    ->unique()
                    ->values()
                    ->toArray();
            }

            // 3. Query data dari model Kdp (koneksi dms -> tabel pmKDP)
            $query = Kdp::query();

            if (!empty($fromDate) && !empty($toDate)) {
                $query->whereBetween('InquiryDate', ["{$fromDate} 00:00:00", "{$toDate} 23:59:59"]);
            } else {
                $query->whereMonth('InquiryDate', $selectedMonth)
                      ->whereYear('InquiryDate', $selectedYear);
            }

            if (!empty($matchingBranchCodes)) {
                $query->whereIn('BranchCode', $matchingBranchCodes);
            } elseif (!empty($branchCode)) {
                $query->where('BranchCode', 'LIKE', "%{$branchCode}%");
            }

            if (!empty($matchingSpvIds)) {
                $query->whereIn('SpvEmployeeID', $matchingSpvIds);
            } elseif (!empty($spvId)) {
                $query->where('SpvEmployeeID', 'LIKE', "%{$spvId}%");
            }

            if (!empty($salesman)) {
                $query->where(function($q) use ($salesman) {
                    $q->where('EmployeeID', 'LIKE', "%{$salesman}%")
                      ->orWhere('CreatedBy', 'LIKE', "%{$salesman}%");
                });
            }

            // Grouping berdasarkan PerolehanData (Sumber Data)
            $data = $query->selectRaw("
                TRIM(PerolehanData) as SumberData,
                SUM(CASE WHEN StatusProspek = '10' THEN 1 ELSE 0 END) as total_new,
                SUM(CASE WHEN StatusProspek = '20' THEN 1 ELSE 0 END) as total_repeat_order,
                SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'P' OR TRIM(UPPER(LastProgress)) = 'PROSPECT' THEN 1 ELSE 0 END) as total_prospect,
                SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'HP' OR TRIM(UPPER(LastProgress)) = 'HOT PROSPECT' THEN 1 ELSE 0 END) as total_hot_prospect,
                SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'SPK' THEN 1 ELSE 0 END) as total_spk,
                SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'DO' THEN 1 ELSE 0 END) as total_do,
                SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'DELIVERY' THEN 1 ELSE 0 END) as total_delivery,
                SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'LOST' THEN 1 ELSE 0 END) as total_lost
            ")
            ->whereNotNull('PerolehanData')
            ->where('PerolehanData', '!=', '')
            ->groupBy(DB::raw('TRIM(PerolehanData)'))
            ->orderBy(DB::raw('TRIM(PerolehanData)'))
            ->get();

            $bmsRaw = DB::connection('dms')
                ->table('HrEmployee')
                ->select('EmployeeID', 'EmployeeName')
                ->where('Position', 'BM')
                ->where('PersonnelStatus', '1')
                ->where('IsDeleted', '0')
                ->orderBy('EmployeeName')
                ->get();

            $bmsMap = [];
            $bmBranchMap = [];
            foreach ($bmsRaw as $bm) {
                $bCode = $bmBranchCodeMapping[$bm->EmployeeID] ?? '641940106';
                $bmsMap[$bm->EmployeeID] = [
                    'Name'       => $bm->EmployeeName,
                    'Jabatan'    => 'BM',
                    'BranchCode' => $bCode,
                ];
                $bmBranchMap[$bm->EmployeeID] = $bCode;
            }

            $planCombos = \App\Models\Sales\vsv\PlanSales::select('BranchCode', 'SpvEmployeeID')
                ->whereNotNull('SpvEmployeeID')
                ->where('SpvEmployeeID', '!=', '')
                ->distinct()
                ->get();

            $spvBranchRel = [];
            foreach ($planCombos as $combo) {
                $spvBranchRel[$combo->SpvEmployeeID] = $combo->BranchCode;
            }

            $spvCodes = array_keys($spvBranchRel);

            $spvsRaw = DB::connection('dms')
                ->table('gnMstEmployee')
                ->select('EmployeeID', 'EmployeeName', 'BranchCode', 'TitleCode')
                ->whereIn('EmployeeID', $spvCodes)
                ->where('PersonnelStatus', '1')
                ->orderBy('EmployeeName')
                ->get()
                ->unique('EmployeeID');

            $spvsMap = [];
            $branchSpvMap = [];
            foreach ($spvsRaw as $s) {
                $spvBranchCode = $spvBranchRel[$s->EmployeeID] ?? $s->BranchCode;
                $spvsMap[$s->EmployeeID] = [
                    'Name'       => $s->EmployeeName,
                    'Jabatan'    => 'SH',
                    'BranchCode' => $spvBranchCode,
                ];
                if (!isset($branchSpvMap[$spvBranchCode])) {
                    $branchSpvMap[$spvBranchCode] = [];
                }
                $branchSpvMap[$spvBranchCode][] = $s->EmployeeID;
            }

            $branchManagerName = '';
            if (!empty($branchCode) && isset($bmsMap[$branchCode])) {
                $branchManagerName = $bmsMap[$branchCode]['Name'];
            }

            $salesHeadName = '';
            if (!empty($spvId) && isset($spvsMap[$spvId])) {
                $salesHeadName = $spvsMap[$spvId]['Name'];
            }

            $subTitleText = ($viewType === 'source_do_inquiry')
                ? 'Monitoring data aktual DO inquiry berdasarkan sumber inquiry'
                : 'Monitoring data aktual inquiry berdasarkan sumber inquiry';

            return view('sales.vsv.actual.source_index', [
                'data'              => $data,
                'pageTitle'         => $pageTitle,
                'subTitle'          => $subTitleText,
                'viewType'          => $viewType,
                'headerLabel'       => $headerLabel,
                'fromDate'          => $fromDate,
                'toDate'            => $toDate,
                'selectedMonth'     => (int)$selectedMonth,
                'selectedYear'      => (int)$selectedYear,
                'bmsMap'            => $bmsMap,
                'spvsMap'           => $spvsMap,
                'bmBranchMap'       => $bmBranchMap,
                'branchSpvMap'      => $branchSpvMap,
                'branchManagerName' => $branchManagerName,
                'salesHeadName'     => $salesHeadName,
                'BranchCode'        => $branchCode,
                'SpvEmployeeID'     => $spvId
            ]);

        } catch (\Exception $e) {
            $data = collect();
            Log::error("Error saat membaca data Actual Source KDP dari DB Server: " . $e->getMessage());

            return view('sales.vsv.actual.source_index', [
                'pageTitle'     => $pageTitle,
                'headerLabel'   => $headerLabel,
                'subTitle'      => "Periode " . date('d M Y', strtotime($fromDate)) . " s/d " . date('d M Y', strtotime($toDate)),
                'fromDate'      => $fromDate,
                'toDate'        => $toDate,
                'selectedMonth' => (int)$selectedMonth,
                'selectedYear'  => (int)$selectedYear,
                'BranchCode'    => $branchCode,
                'data'          => $data
            ]);
        }
    }

    private function processActualSalesByLeasing(Request $request, $pageTitle, $headerLabel)
    {
        $selectedMonth = $request->input('month', date('n'));
        $selectedYear = $request->input('year', date('Y'));

        $branchCode = $request->input('BranchCode', $request->input('branch_code', $request->input('branch_manager')));
        $spvId = $request->input('SpvEmployeeID', $request->input('spv_id', $request->input('sales_head')));
        $salesman = $request->input('salesman');

        $fromDate = $request->input('from_date', "{$selectedYear}-" . str_pad($selectedMonth, 2, '0', STR_PAD_LEFT) . "-01");
        $toDate = $request->input('to_date', date('Y-m-t', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)));

        $data = collect();

        try {
            $bmBranchCodeMapping = [
                '14.26.01.549' => '641940106', // EDI SUMARDI -> DCA Cipanas
                '03.24.02.001' => '641940103', // Subagja -> DCA Cinere
                '06.25.11.001' => '641940104', // JOHN EDUWARD SIMATUPANG -> DCA Jatiasih
                '06.24.11.005' => '641940102', // ANGGARINI AMITHAWARDHANI -> DCA Cianjur
                '01.19.08.102' => '641940101', // RONALD NOVEMBRI W -> DCA Ciawi
            ];

            $bmsRaw = DB::connection('dms')
                ->table('HrEmployee')
                ->select('EmployeeID', 'EmployeeName')
                ->where('Position', 'BM')
                ->where('PersonnelStatus', '1')
                ->where('IsDeleted', '0')
                ->orderBy('EmployeeName')
                ->get();

            $bmsMap = [];
            $bmBranchMap = [];
            foreach ($bmsRaw as $bm) {
                $bCode = $bmBranchCodeMapping[$bm->EmployeeID] ?? '641940106';
                $bmsMap[$bm->EmployeeID] = [
                    'Name'       => $bm->EmployeeName,
                    'Jabatan'    => 'BM',
                    'BranchCode' => $bCode,
                ];
                $bmBranchMap[$bm->EmployeeID] = $bCode;
            }

            $planCombos = \App\Models\Sales\vsv\PlanSales::select('BranchCode', 'SpvEmployeeID')
                ->whereNotNull('SpvEmployeeID')
                ->where('SpvEmployeeID', '!=', '')
                ->distinct()
                ->get();

            $spvBranchRel = [];
            foreach ($planCombos as $combo) {
                $spvBranchRel[$combo->SpvEmployeeID] = $combo->BranchCode;
            }

            $spvCodes = array_keys($spvBranchRel);

            $spvsRaw = DB::connection('dms')
                ->table('gnMstEmployee')
                ->select('EmployeeID', 'EmployeeName', 'BranchCode', 'TitleCode')
                ->whereIn('EmployeeID', $spvCodes)
                ->where('PersonnelStatus', '1')
                ->orderBy('EmployeeName')
                ->get()
                ->unique('EmployeeID');

            $spvsMap = [];
            $branchSpvMap = [];
            foreach ($spvsRaw as $s) {
                $spvBranchCode = $spvBranchRel[$s->EmployeeID] ?? $s->BranchCode;
                $spvsMap[$s->EmployeeID] = [
                    'Name'       => $s->EmployeeName,
                    'Jabatan'    => 'SH',
                    'BranchCode' => $spvBranchCode,
                ];
                if (!isset($branchSpvMap[$spvBranchCode])) {
                    $branchSpvMap[$spvBranchCode] = [];
                }
                $branchSpvMap[$spvBranchCode][] = $s->EmployeeID;
            }

            $branchManagerName = '';
            if (!empty($branchCode) && isset($bmsMap[$branchCode])) {
                $branchManagerName = $bmsMap[$branchCode]['Name'];
            }

            $salesHeadName = '';
            if (!empty($spvId) && isset($spvsMap[$spvId])) {
                $salesHeadName = $spvsMap[$spvId]['Name'];
            }

            // CRITICAL RULE: Sebelum ada filtering branch manager & sales head, jangan tampilkan data
            if (!empty($branchCode) && !empty($spvId)) {
                $matchingBranchCodes = [];
                if (isset($bmBranchCodeMapping[$branchCode])) {
                    $matchingBranchCodes = [$bmBranchCodeMapping[$branchCode]];
                } else {
                    $empBranch = DB::connection('dms')
                        ->table('gnMstEmployee')
                        ->where('EmployeeID', $branchCode)
                        ->value('BranchCode');
                    
                    if ($empBranch) {
                        $matchingBranchCodes = [$empBranch];
                    } else {
                        $matchingBranchCodes = DB::connection('dms')
                            ->table('gnMstOrganizationDtl')
                            ->where('BranchCode', 'LIKE', "%{$branchCode}%")
                            ->orWhere('BranchName', 'LIKE', "%{$branchCode}%")
                            ->pluck('BranchCode')
                            ->unique()
                            ->values()
                            ->toArray();
                    }
                }

                $matchingSpvIds = [];
                if (!empty($spvId)) {
                    $matchingSpvIds = DB::connection('dms')
                        ->table('gnMstEmployee')
                        ->where('EmployeeID', 'LIKE', "%{$spvId}%")
                        ->orWhere('EmployeeName', 'LIKE', "%{$spvId}%")
                        ->pluck('EmployeeID')
                        ->unique()
                        ->values()
                        ->toArray();
                }

                // 1. Branch Manager Summary Row(s)
                $bmLeasings = Kdp::whereBetween('InquiryDate', ["{$fromDate} 00:00:00", "{$toDate} 23:59:59"])
                    ->whereIn('BranchCode', $matchingBranchCodes)
                    ->selectRaw("
                        COALESCE(NULLIF(TRIM(Leasing), ''), 'TUNAI / CASH') as LeasingName,
                        SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'SPK' THEN 1 ELSE 0 END) as total_spk,
                        SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'DO' THEN 1 ELSE 0 END) as total_do,
                        SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'DELIVERY' THEN 1 ELSE 0 END) as total_delivery
                    ")
                    ->groupBy(DB::raw("COALESCE(NULLIF(TRIM(Leasing), ''), 'TUNAI / CASH')"))
                    ->get();

                foreach ($bmLeasings as $bl) {
                    $item = new \stdClass();
                    $item->Posisi = 'Branch Manager';
                    $item->Nama = $branchManagerName ?: 'Branch Manager';
                    $item->Leasing = $bl->LeasingName;
                    $item->total_spk = $bl->total_spk;
                    $item->total_do = $bl->total_do;
                    $item->total_delivery = $bl->total_delivery;
                    $data->push($item);
                }

                // 2. Sales Head Summary Row(s)
                $shLeasings = Kdp::whereBetween('InquiryDate', ["{$fromDate} 00:00:00", "{$toDate} 23:59:59"])
                    ->whereIn('BranchCode', $matchingBranchCodes)
                    ->whereIn('SpvEmployeeID', $matchingSpvIds)
                    ->selectRaw("
                        COALESCE(NULLIF(TRIM(Leasing), ''), 'TUNAI / CASH') as LeasingName,
                        SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'SPK' THEN 1 ELSE 0 END) as total_spk,
                        SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'DO' THEN 1 ELSE 0 END) as total_do,
                        SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'DELIVERY' THEN 1 ELSE 0 END) as total_delivery
                    ")
                    ->groupBy(DB::raw("COALESCE(NULLIF(TRIM(Leasing), ''), 'TUNAI / CASH')"))
                    ->get();

                foreach ($shLeasings as $sl) {
                    $item = new \stdClass();
                    $item->Posisi = 'Sales Head';
                    $item->Nama = $salesHeadName ?: 'Sales Head';
                    $item->Leasing = $sl->LeasingName;
                    $item->total_spk = $sl->total_spk;
                    $item->total_do = $sl->total_do;
                    $item->total_delivery = $sl->total_delivery;
                    $data->push($item);
                }

                // 3. Salesmen Rows under Sales Head
                $smQuery = Kdp::whereBetween('InquiryDate', ["{$fromDate} 00:00:00", "{$toDate} 23:59:59"])
                    ->whereIn('BranchCode', $matchingBranchCodes)
                    ->whereIn('SpvEmployeeID', $matchingSpvIds);

                if (!empty($salesman)) {
                    $smQuery->where(function($q) use ($salesman) {
                        $q->where('EmployeeID', 'LIKE', "%{$salesman}%")
                          ->orWhere('CreatedBy', 'LIKE', "%{$salesman}%");
                    });
                }

                $smLeasings = $smQuery->selectRaw("
                        EmployeeID,
                        COALESCE(NULLIF(TRIM(Leasing), ''), 'TUNAI / CASH') as LeasingName,
                        SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'SPK' THEN 1 ELSE 0 END) as total_spk,
                        SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'DO' THEN 1 ELSE 0 END) as total_do,
                        SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'DELIVERY' THEN 1 ELSE 0 END) as total_delivery
                    ")
                    ->groupBy('EmployeeID', DB::raw("COALESCE(NULLIF(TRIM(Leasing), ''), 'TUNAI / CASH')"))
                    ->get();

                $smIds = $smLeasings->pluck('EmployeeID')->unique()->filter()->values()->toArray();
                $employeesMap = [];
                if (!empty($smIds)) {
                    $employeesMap = DB::connection('dms')->table('gnMstEmployee')
                        ->whereIn('EmployeeID', $smIds)
                        ->pluck('EmployeeName', 'EmployeeID')
                        ->toArray();
                }

                foreach ($smLeasings as $sm) {
                    $item = new \stdClass();
                    $item->Posisi = 'Salesman';
                    $item->Nama = $employeesMap[$sm->EmployeeID] ?? $sm->EmployeeID ?? 'Salesman';
                    $item->Leasing = $sm->LeasingName;
                    $item->total_spk = $sm->total_spk;
                    $item->total_do = $sm->total_do;
                    $item->total_delivery = $sm->total_delivery;
                    $data->push($item);
                }
            }

            return view('sales.vsv.actual.leasing_index', [
                'data'              => $data,
                'pageTitle'         => $pageTitle,
                'subTitle'          => 'Monitoring data aktual penjualan berdasarkan leasing',
                'headerLabel'       => $headerLabel,
                'fromDate'          => $fromDate,
                'toDate'            => $toDate,
                'selectedMonth'     => (int)$selectedMonth,
                'selectedYear'      => (int)$selectedYear,
                'bmsMap'            => $bmsMap,
                'spvsMap'           => $spvsMap,
                'bmBranchMap'       => $bmBranchMap,
                'branchSpvMap'      => $branchSpvMap,
                'branchManagerName' => $branchManagerName,
                'salesHeadName'     => $salesHeadName,
                'BranchCode'        => $branchCode,
                'SpvEmployeeID'     => $spvId
            ]);

        } catch (\Exception $e) {
            $data = collect();
            Log::error("Error saat membaca data Actual Sales By Leasing KDP dari DB Server: " . $e->getMessage());

            return view('sales.vsv.actual.leasing_index', [
                'pageTitle'     => $pageTitle,
                'headerLabel'   => $headerLabel,
                'subTitle'      => "Periode " . date('d M Y', strtotime($fromDate)) . " s/d " . date('d M Y', strtotime($toDate)),
                'fromDate'      => $fromDate,
                'toDate'        => $toDate,
                'selectedMonth' => (int)$selectedMonth,
                'selectedYear'  => (int)$selectedYear,
                'BranchCode'    => $branchCode,
                'data'          => $data
            ]);
        }
    }

    public function salesforces(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        
        $modelClass = class_exists(\App\Models\Sales\vsv\current\ActualSalesforce::class) 
            ? \App\Models\Sales\vsv\current\ActualSalesforce::class 
            : (class_exists(\App\Models\current\ActualSalesforce::class) ? \App\Models\current\ActualSalesforce::class : null);

        if ($modelClass) {
            $query = $modelClass::with('user');
            if (!in_array(strtolower($user->role ?? ''), ['admin', 'om', 'admin dca', 'om dca'])) {
                if (strtoupper($user->role ?? '') === 'BM') {
                    $query->where('cabang', $user->cabang ?? '');
                } elseif (strtoupper($user->role ?? '') === 'SH') {
                    $query->where('user_id', $user->id);
                } else {
                    $query->where('cabang', $user->cabang ?? '');
                }
            }
            $data = $query->get();
        } else {
            $data = collect();
        }

        $year = now()->year;
        $grandTotal = $data->sum('total');

        $viewName = view()->exists('sales.vsv.current.actual_salesforces.index') 
            ? 'sales.vsv.current.actual_salesforces.index' 
            : 'current.actual_salesforces.index';

        return view($viewName, compact('data', 'year', 'grandTotal'));
    }

    public function doSalesforces(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        $modelClass = class_exists(\App\Models\Sales\vsv\current\ActualDoSalesForce::class) 
            ? \App\Models\Sales\vsv\current\ActualDoSalesForce::class 
            : (class_exists(\App\Models\current\ActualDoSalesForce::class) ? \App\Models\current\ActualDoSalesForce::class : null);

        if ($modelClass) {
            $query = $modelClass::with('user');
            if (!in_array(strtolower($user->role ?? ''), ['admin', 'om', 'admin dca', 'om dca'])) {
                if (strtoupper($user->role ?? '') === 'BM') {
                    $query->where('cabang', $user->cabang ?? '');
                } elseif (strtoupper($user->role ?? '') === 'SH') {
                    $query->where('user_id', $user->id);
                } else {
                    $query->where('cabang', $user->cabang ?? '');
                }
            }
            $data = $query->get();
        } else {
            $data = collect();
        }

        $year = now()->year;
        $grandTotal = $data->sum('total');

        $viewName = view()->exists('sales.vsv.current.actual_do_salesforces.index') 
            ? 'sales.vsv.current.actual_do_salesforces.index' 
            : 'current.actual_do_salesforces.index';

        return view($viewName, compact('data', 'year', 'grandTotal'));
    }
}