<?php

namespace App\Http\Controllers\Sales\vsv;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales\vsv\PlanSales;
use Illuminate\Support\Facades\Log;

class TargetRkaController extends Controller
{
    public function salesforce(Request $request)
    {
        return $this->fetchData($request, 'By Salesman', 'TARGET SALESFORCE', 'BySalesman');
    }

    public function doUnit(Request $request)
    {
        return $this->fetchData($request, 'By Type', 'TARGET DO UNIT', 'ByType');
    }

    public function doBySoi(Request $request)
    {
        return $this->fetchData($request, 'By Activity', 'TARGET DO BY SOI', 'ByActivity');
    }

    private function fetchData(Request $request, $headerLabel, $pageTitle, $sourceName)
    {
        $selectedMonth = $request->input('month', date('n'));
        $selectedYear = $request->input('year', date('Y'));
        $branchCode = $request->input('BranchCode', $request->input('branch_code'));
        $spvId = $request->input('SpvEmployeeID', $request->input('spv_id'));

        if (empty($branchCode) && empty($spvId)) {
            $dataMatrix = collect();
        } else {
            try {
                // 1. Resolusi BranchCode
                $matchingBranchCodes = [];
                if (!empty($branchCode)) {
                    $matchingBranchCodes = \Illuminate\Support\Facades\DB::connection('dms')
                        ->table('gnMstOrganizationDtl')
                        ->where('BranchCode', 'LIKE', "%{$branchCode}%")
                        ->orWhere('BranchName', 'LIKE', "%{$branchCode}%")
                        ->pluck('BranchCode')
                        ->unique()
                        ->values()
                        ->toArray();
                }

                // 2. Resolusi SpvEmployeeID
                $matchingSpvIds = [];
                if (!empty($spvId)) {
                    $matchingSpvIds = \Illuminate\Support\Facades\DB::connection('dms')
                        ->table('gnMstEmployee')
                        ->where('EmployeeID', 'LIKE', "%{$spvId}%")
                        ->orWhere('EmployeeName', 'LIKE', "%{$spvId}%")
                        ->pluck('EmployeeID')
                        ->unique()
                        ->values()
                        ->toArray();
                }

                // 3. Ambil daftar master detail
                $effectiveSpvIds = $matchingSpvIds;
                $isSoanEmpty = false;
                $isIGusti = false;

                if ($sourceName === 'BySalesman' && !empty($matchingSpvIds)) {
                    if (in_array('16.26.01.007', $matchingSpvIds)) {
                        $isSoanEmpty = true;
                    } elseif (in_array('16.26.04.003', $matchingSpvIds)) {
                        $isIGusti = true;
                    }
                }

                if ($isSoanEmpty) {
                    $allMasterDetails = collect();
                } elseif ($isIGusti) {
                    $igustiEmpIds = [
                        '16.26.05.001', 
                        '16.25.12.024', 
                        '16.26.01.005',
                        '16.26.07.002', 
                        '16.26.05.006', 
                        '16.26.01.006', 
                        '16.26.06.009',
                        '16.26.05.003',
                        '16.25.02.004', 
                        '16.26.07.004', 
                    ];
                    $allMasterDetails = \Illuminate\Support\Facades\DB::connection('dms')
                        ->table('gnMstEmployee')
                        ->whereIn('EmployeeID', $igustiEmpIds)
                        ->select('EmployeeID as DetailCode', 'EmployeeName as DetailName')
                        ->distinct()
                        ->orderBy('EmployeeName')
                        ->get();
                } else {
                    $masterQuery = PlanSales::where('Year', $selectedYear)
                        ->where('SourceName', $sourceName);

                    if ($sourceName !== 'ByType') {
                        if (!empty($matchingBranchCodes)) {
                            $masterQuery->whereIn('BranchCode', $matchingBranchCodes);
                        }

                        if (!empty($effectiveSpvIds)) {
                            $masterQuery->whereIn('SpvEmployeeID', $effectiveSpvIds);
                        }
                    }

                    $allMasterDetails = $masterQuery->select('DetailCode', 'DetailName')
                        ->distinct()
                        ->orderBy('DetailName')
                        ->get();
                }

                if ($sourceName === 'BySalesman' && $allMasterDetails->isNotEmpty()) {
                    $empCodes = $allMasterDetails->pluck('DetailCode')->filter()->unique()->toArray();
                    if (!empty($empCodes)) {
                        $activeEmpCodes = \Illuminate\Support\Facades\DB::connection('dms')
                            ->table('gnMstEmployee')
                            ->whereIn('EmployeeID', $empCodes)
                            ->where('PersonnelStatus', '1')
                            ->pluck('EmployeeID')
                            ->toArray();

                        $allMasterDetails = $allMasterDetails->filter(function ($item) use ($activeEmpCodes, $effectiveSpvIds) {
                            return in_array($item->DetailCode, $activeEmpCodes)
                                && !in_array($item->DetailCode, $effectiveSpvIds);
                        })->values();
                    }
                }

                // 4. Query data matrix target aktual untuk bulan terpilih
                $query = PlanSales::query()
                    ->select(
                        'DetailCode',
                        'DetailName',
                        'DO_Week1', 'SPK_Week1', 'INQ_Week1',
                        'DO_Week2', 'SPK_Week2', 'INQ_Week2',
                        'DO_Week3', 'SPK_Week3', 'INQ_Week3',
                        'DO_Week4', 'SPK_Week4', 'INQ_Week4',
                        'DO_Week5', 'SPK_Week5', 'INQ_Week5'
                    )
                    ->where('Month', $selectedMonth)
                    ->where('Year', $selectedYear)
                    ->where('SourceName', $sourceName);

                if (!empty($matchingBranchCodes)) {
                    $query->whereIn('BranchCode', $matchingBranchCodes);
                }

                if ($sourceName === 'BySalesman') {
                    if ($allMasterDetails->isNotEmpty()) {
                        $detailCodesList = $allMasterDetails->pluck('DetailCode')->filter()->unique()->toArray();
                        if (!empty($detailCodesList)) {
                            $query->whereIn('DetailCode', $detailCodesList);
                        }
                    } else {
                        $query->whereRaw('1 = 0');
                    }
                } else {
                    if (!empty($effectiveSpvIds)) {
                        $query->whereIn('SpvEmployeeID', $effectiveSpvIds);
                    }
                }

                $dataMatrix = $query->get();

                $existingMap = $dataMatrix->keyBy(function ($row) {
                    return $row->DetailCode ?: $row->DetailName;
                });

                $fullMatrix = collect();
                foreach ($allMasterDetails as $master) {
                    $key = $master->DetailCode ?: $master->DetailName;
                    if ($existingMap->has($key)) {
                        $fullMatrix->push($existingMap->get($key));
                    } else {
                        $dummy = new \stdClass();
                        $dummy->DetailCode = $master->DetailCode;
                        $dummy->DetailName = $master->DetailName;
                        for ($w = 1; $w <= 5; $w++) {
                            $dummy->{"DO_Week{$w}"} = 0;
                            $dummy->{"SPK_Week{$w}"} = 0;
                            $dummy->{"INQ_Week{$w}"} = 0;
                        }
                        $fullMatrix->push($dummy);
                    }
                }

                $dataMatrix = $fullMatrix;
                
            } catch (\Exception $e) {
                $dataMatrix = collect();
                Log::error("Error query PlanSales: " . $e->getMessage());
            }
        }

        try {
            // 1. Daftar SEMUA branch dari master (termasuk HOLDING & BODY REPAIR)
            $branchesData = \Illuminate\Support\Facades\DB::connection('dms')
                ->table('gnMstOrganizationDtl')
                ->select('BranchCode', 'BranchName')
                ->orderBy('BranchCode')
                ->pluck('BranchName', 'BranchCode');
            $branches = $branchesData->keys()->sort();

            // 2. Mapping Branch -> SPV dari DATA TARGET (pmMstPlanSales) sesuai Tahun & Target Source yang dipilih
            $planCombos = PlanSales::select('BranchCode', 'SpvEmployeeID')
                ->where('Year', $selectedYear)
                ->where('SourceName', $sourceName)
                ->distinct()
                ->get();
            $branchSpvMap = $planCombos->groupBy('BranchCode')
                ->map(fn($items) => $items->pluck('SpvEmployeeID')->filter()->unique()->values());

            // 3. Ambil semua SPV unik dari data target
            $spvCodes = $branchSpvMap->flatten()->unique()->values();

            // 4. Ambil nama SPV dari master employee (hanya karyawan AKTIF: PersonnelStatus = '1')
            $spvsData = \Illuminate\Support\Facades\DB::connection('dms')
                ->table('gnMstEmployee')
                ->select('EmployeeID', 'EmployeeName')
                ->whereIn('EmployeeID', $spvCodes->toArray())
                ->where('PersonnelStatus', '1')
                ->get()
                ->unique('EmployeeID')
                ->pluck('EmployeeName', 'EmployeeID');

            // 5. Saring branchSpvMap agar hanya menyajikan SPV yang masih AKTIF
            $activeSpvCodes = $spvsData->keys()->toArray();
            $branchSpvMap = $branchSpvMap->map(function ($spvList) use ($activeSpvCodes) {
                return $spvList->filter(fn($code) => in_array($code, $activeSpvCodes))->values();
            });
            $spvs = collect($activeSpvCodes)->sort();
        } catch (\Exception $e) {
            $branchSpvMap = collect();
            $branchesData = collect();
            $spvsData = collect();
            $branches = collect();
            $spvs = collect();
        }

        $summary = [
            'w1' => ['do' => $dataMatrix->sum('DO_Week1'), 'spk' => $dataMatrix->sum('SPK_Week1'), 'inq' => $dataMatrix->sum('INQ_Week1')],
            'w2' => ['do' => $dataMatrix->sum('DO_Week2'), 'spk' => $dataMatrix->sum('SPK_Week2'), 'inq' => $dataMatrix->sum('INQ_Week2')],
            'w3' => ['do' => $dataMatrix->sum('DO_Week3'), 'spk' => $dataMatrix->sum('SPK_Week3'), 'inq' => $dataMatrix->sum('INQ_Week3')],
            'w4' => ['do' => $dataMatrix->sum('DO_Week4'), 'spk' => $dataMatrix->sum('SPK_Week4'), 'inq' => $dataMatrix->sum('INQ_Week4')],
            'w5' => ['do' => $dataMatrix->sum('DO_Week5'), 'spk' => $dataMatrix->sum('SPK_Week5'), 'inq' => $dataMatrix->sum('INQ_Week5')],
        ];

        return view('sales.vsv.target_rka.index', [
            'pageTitle'         => $pageTitle,
            'tableHeaderLabel'  => $headerLabel,
            'selectedMonth'     => (int)$selectedMonth,
            'selectedYear'      => (int)$selectedYear,
            'BranchCode'        => $branchCode,
            'SpvEmployeeID'     => $spvId,
            'dataMatrix'        => $dataMatrix,
            'summary'           => $summary,
            'branchSpvMap'      => $branchSpvMap,
            'branches'          => $branches,
            'spvs'              => $spvs,
            'branchesData'      => $branchesData,
            'spvsData'          => $spvsData
        ]);
    }

        public function index(Request $request)
    {
        $semuaData = PlanSales::all();

        $dataFilter = PlanSales::where('Month', 7)
                            ->where('Year', 2026)
                            ->get();

        $dataCabang = PlanSales::where('BranchCode', 'JKT01')->get();

        return view('sales.vsv.target_rka.index', compact('dataFilter'));
    }
}