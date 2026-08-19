<?php

namespace App\Http\Controllers\Sales\vsv;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales\vsv\PlanSales;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TargetRkaController extends Controller
{
    private $branchNameToCode = [
        'CIPANAS'  => '641940106',
        'CINERE'   => '641940103',
        'JATIASIH' => '641940104',
        'CIANJUR'  => '641940102',
        'CIAWI'    => '641940101',
        'HOLDING'  => '641940100',
    ];

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

    /**
     * Resolusi otomatis EmployeeID DMS berdasarkan ID, nama, atau email user
     */
    private function resolveSpvEmployeeIds($spvInput, $user = null, $userCabangCode = null)
    {
        if (!empty($spvInput)) {
            $matched = DB::connection('dms')->table('gnMstEmployee')
                ->where('EmployeeID', $spvInput)
                ->pluck('EmployeeID')
                ->toArray();
            if (!empty($matched)) {
                return $matched;
            }

            $matchedByName = DB::connection('dms')->table('gnMstEmployee')
                ->where('EmployeeName', 'LIKE', "%{$spvInput}%")
                ->pluck('EmployeeID')
                ->toArray();
            if (!empty($matchedByName)) {
                return $matchedByName;
            }
        }

        // Jika ID lokal (seperti 27792 / 11228), otomatis dicocokkan via email user login
        if ($user && !empty($user->email)) {
            $emailPrefix = explode('@', $user->email)[0];
            $cleanPrefix = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $emailPrefix));

            $query = DB::connection('dms')->table('gnMstEmployee')
                ->where('PersonnelStatus', '1');

            if (!empty($userCabangCode)) {
                $query->where('BranchCode', $userCabangCode);
            }

            $branchEmps = $query->get();

            foreach ($branchEmps as $emp) {
                $cleanName = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $emp->EmployeeName));
                if (str_contains($cleanName, $cleanPrefix) || str_contains($cleanPrefix, $cleanName)) {
                    return [$emp->EmployeeID];
                }
            }
        }

        return !empty($spvInput) ? [$spvInput] : [];
    }

    private function fetchData(Request $request, $headerLabel, $pageTitle, $sourceName)
    {
        $user = Auth::user();
        
        // Penyesuaian pengecekan role dan admin berdasarkan struktur tabel Anda (is_admin & branch)
        $userRole = strtoupper($user->role ?? '');
        $userCabang = strtoupper(trim($user->branch ?? $user->cabang ?? ''));
        
        $isPusat = ($user->is_admin ?? false) || 
                   in_array($userCabang, ['ADMIN', 'PUSAT']) || 
                   in_array($userRole, ['ADMIN', 'OM', 'ADMIN DCA', 'OM DCA']);
                   
        $isBM = ($userRole === 'BM' || $userCabang === 'BM');
        $isSH = ($userRole === 'SH' || $userCabang === 'SH');

        $selectedMonth = $request->input('month', date('n'));
        $selectedYear = $request->input('year', date('Y'));

        // 🔒 Penentuan Branch & Sales Head sesuai Role
        if (!$isPusat) {
            $userBranchCode = $this->branchNameToCode[$userCabang] ?? ($user->branch ?? $user->cabang);
            $branchCode = $userBranchCode;

            if ($isSH) {
                $spvId = $request->input('SpvEmployeeID', $request->input('spv_id', $user->name));
            } else {
                $spvId = $request->input('SpvEmployeeID', $request->input('spv_id'));
            }
        } else {
            $branchCode = $request->input('BranchCode', $request->input('branch_code'));
            $spvId = $request->input('SpvEmployeeID', $request->input('spv_id'));
            $userBranchCode = null;
        }

        if (empty($branchCode) && empty($spvId)) {
            $dataMatrix = collect();
        } else {
            try {
                // 1. Resolusi BranchCode
                $matchingBranchCodes = [];
                if (!empty($branchCode)) {
                    $matchingBranchCodes = DB::connection('dms')
                        ->table('gnMstOrganizationDtl')
                        ->where('BranchCode', 'LIKE', "%{$branchCode}%")
                        ->orWhere('BranchName', 'LIKE', "%{$branchCode}%")
                        ->pluck('BranchCode')
                        ->unique()
                        ->values()
                        ->toArray();
                }

                // 2. Resolusi SpvEmployeeID Otomatis (Smart Lookup via DMS / Email)
                $matchingSpvIds = $this->resolveSpvEmployeeIds($spvId, $user, $userBranchCode);

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
                        $activeEmpCodes = DB::connection('dms')
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
            $branchesData = DB::connection('dms')
                ->table('gnMstOrganizationDtl')
                ->select('BranchCode', 'BranchName')
                ->orderBy('BranchCode')
                ->pluck('BranchName', 'BranchCode');
            $branches = $branchesData->keys()->sort();

            $planCombos = PlanSales::select('BranchCode', 'SpvEmployeeID')
                ->where('Year', $selectedYear)
                ->where('SourceName', $sourceName)
                ->distinct()
                ->get();
            $branchSpvMap = $planCombos->groupBy('BranchCode')
                ->map(fn($items) => $items->pluck('SpvEmployeeID')->filter()->unique()->values());

            $spvCodes = $branchSpvMap->flatten()->unique()->values();

            $spvsData = DB::connection('dms')
                ->table('gnMstEmployee')
                ->select('EmployeeID', 'EmployeeName')
                ->whereIn('EmployeeID', $spvCodes->toArray())
                ->where('PersonnelStatus', '1')
                ->get()
                ->unique('EmployeeID')
                ->pluck('EmployeeName', 'EmployeeID');

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

        // Tetap menggunakan return view yang pertama
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
            'spvsData'          => $spvsData,
            'isLockedBranch'    => !$isPusat,
            'isLockedSpv'       => $isSH
        ]);
    }

    public function index(Request $request)
    {
        return $this->salesforce($request);
    }
}