<?php

namespace App\Http\Controllers\Sales\vsv\current;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales\vsv\current\ActualDoSalesForce;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ActualDoSalesforceExport;

class ActualDoSalesForceController extends Controller
{
    private $branchNameToCode = [
        'CIAWI'    => '641940101',
        'CIANJUR'  => '641940102',
        'CINERE'   => '641940103',
        'JATIASIH' => '641940104',
        'CIPANAS'  => '641940106',
    ];

    public function index(Request $request)
    {
        $user = Auth::user();
        
        $userRole = strtoupper($user->role ?? '');
        $userCabang = strtoupper(trim($user->branch ?? $user->cabang ?? ''));
        
        $isPusat = ($user->is_admin ?? false) || 
                   in_array($userCabang, ['ADMIN', 'PUSAT']) || 
                   in_array($userRole, ['ADMIN', 'OM', 'ADMIN DCA', 'OM DCA']);

        $year = (int)$request->input('year', now()->year);
        $selectedCabang = $request->input('cabang');

        $branchMap = [
            '641940101' => 'Ciawi',
            '641940102' => 'Cianjur',
            '641940103' => 'Cinere',
            '641940104' => 'Jatiasih',
            '641940106' => 'Cipanas',
        ];

        $allowedBranches = $branchMap;
        if (!$isPusat && !empty($userCabang)) {
            $uCode = $this->branchNameToCode[$userCabang] ?? null;
            if ($uCode && isset($branchMap[$uCode])) {
                $allowedBranches = [$uCode => $branchMap[$uCode]];
            }
        } elseif (!empty($selectedCabang)) {
            $sCode = $this->branchNameToCode[strtoupper(trim($selectedCabang))] ?? $selectedCabang;
            if (isset($branchMap[$sCode])) {
                $allowedBranches = [$sCode => $branchMap[$sCode]];
            }
        }

        $gradeMap = [
            4 => 'PLATINUM',
            3 => 'GOLD',
            2 => 'SILVER',
            1 => 'TRAINEE',
        ];
        $gradeOrder = [
            'PLATINUM' => 1,
            'GOLD'     => 2,
            'SILVER'   => 3,
            'TRAINEE'  => 4,
        ];
        $monthKeys = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];

        try {
            // pmKDP JOIN HrEmployee 
            $records = DB::connection('dms')
                ->table('pmKDP')
                ->join('HrEmployee', 'pmKDP.EmployeeID', '=', 'HrEmployee.EmployeeID')
                ->where('pmKDP.LastProgress', 'DELIVERY')
                ->where('HrEmployee.IsDeleted', '0')
                ->whereYear('pmKDP.LastUpdateStatus', $year)
                ->whereIn('pmKDP.BranchCode', array_keys($allowedBranches))
                ->selectRaw('pmKDP.BranchCode, HrEmployee.EmployeeID, HrEmployee.EmployeeName, HrEmployee.Grade, MONTH(pmKDP.LastUpdateStatus) as m_num, COUNT(*) as total')
                ->groupBy('pmKDP.BranchCode', 'HrEmployee.EmployeeID', 'HrEmployee.EmployeeName', 'HrEmployee.Grade', DB::raw('MONTH(pmKDP.LastUpdateStatus)'))
                ->get();

            $salesMatrix = [];
            foreach ($records as $r) {
                $bCode = trim($r->BranchCode);
                $empId = trim($r->EmployeeID);
                $empName = trim($r->EmployeeName);
                $gNum = (int)$r->Grade;
                $gName = $gradeMap[$gNum] ?? 'TRAINEE';
                $mNum = (int)$r->m_num;

                if (!isset($salesMatrix[$bCode][$empId])) {
                    $salesMatrix[$bCode][$empId] = [
                        'name'   => $empName,
                        'grade'  => $gName,
                        'months' => array_fill(1, 12, 0),
                    ];
                }

                $salesMatrix[$bCode][$empId]['months'][$mNum] += (int)$r->total;
            }

            $dataByBranch = [];
            $flatData = collect();
            $grandTotals = array_fill_keys($monthKeys, 0);
            $grandTotalAll = 0;

            foreach ($allowedBranches as $bCode => $bName) {
                $branchRows = [];
                $subtotal = array_fill_keys($monthKeys, 0);
                $subtotalAll = 0;

                $empList = $salesMatrix[$bCode] ?? [];

                uasort($empList, function($a, $b) use ($gradeOrder) {
                    $orderA = $gradeOrder[$a['grade']] ?? 99;
                    $orderB = $gradeOrder[$b['grade']] ?? 99;
                    if ($orderA === $orderB) {
                        return strcmp($a['name'], $b['name']);
                    }
                    return $orderA <=> $orderB;
                });

                foreach ($empList as $empId => $empData) {
                    $rowObj = new \stdClass();
                    $rowObj->id = $empId;
                    $rowObj->employee_id = $empId;
                    $rowObj->salesman_name = $empData['name'];
                    $rowObj->grading = $empData['grade'];
                    $rowObj->cabang = $bName;
                    $rowObj->tahun = $year;
                    $rowTotal = 0;

                    for ($m = 1; $m <= 12; $m++) {
                        $mKey = $monthKeys[$m - 1];
                        $val = $empData['months'][$m] ?? 0;
                        $rowObj->$mKey = $val;
                        $rowTotal += $val;
                        $subtotal[$mKey] += $val;
                        $grandTotals[$mKey] += $val;
                    }

                    $rowObj->total = $rowTotal;
                    $subtotalAll += $rowTotal;
                    $grandTotalAll += $rowTotal;

                    $branchRows[] = $rowObj;
                    $flatData->push($rowObj);
                }

                $subtotal['total'] = $subtotalAll;

                $dataByBranch[] = [
                    'branch_code' => $bCode,
                    'branch_name' => $bName,
                    'rows'        => $branchRows,
                    'subtotal'    => $subtotal,
                ];
            }

            $data = $flatData;
            $grandTotal = $grandTotalAll;

        } catch (\Exception $e) {
            Log::error("Error reading Actual DO Salesforce from DMS pmKDP: " . $e->getMessage());
            $dataByBranch = [];
            $data = collect();
            $grandTotals = array_fill_keys($monthKeys, 0);
            $grandTotal = 0;
            $grandTotalAll = 0;
        }

        return view('sales.vsv.current.actual_do_salesforces.index', compact('data', 'dataByBranch', 'year', 'grandTotal', 'grandTotals', 'grandTotalAll', 'allowedBranches', 'selectedCabang', 'isPusat'));
    }

    public function exportPdf(Request $request)
    {
        $user = Auth::user();
        
        $userRole = strtoupper($user->role ?? '');
        $userCabang = strtoupper(trim($user->branch ?? $user->cabang ?? ''));
        
        $isPusat = ($user->is_admin ?? false) || 
                   in_array($userCabang, ['ADMIN', 'PUSAT']) || 
                   in_array($userRole, ['ADMIN', 'OM', 'ADMIN DCA', 'OM DCA']);

        $year = (int)$request->input('year', now()->year);
        $selectedCabang = $request->input('cabang');

        $branchMap = [
            '641940101' => 'Ciawi',
            '641940102' => 'Cianjur',
            '641940103' => 'Cinere',
            '641940104' => 'Jatiasih',
            '641940106' => 'Cipanas',
        ];

        $allowedBranches = $branchMap;
        if (!$isPusat && !empty($userCabang)) {
            $uCode = $this->branchNameToCode[$userCabang] ?? null;
            if ($uCode && isset($branchMap[$uCode])) {
                $allowedBranches = [$uCode => $branchMap[$uCode]];
            }
        } elseif (!empty($selectedCabang)) {
            $sCode = $this->branchNameToCode[strtoupper(trim($selectedCabang))] ?? $selectedCabang;
            if (isset($branchMap[$sCode])) {
                $allowedBranches = [$sCode => $branchMap[$sCode]];
            }
        }

        $gradeMap = [4 => 'PLATINUM', 3 => 'GOLD', 2 => 'SILVER', 1 => 'TRAINEE'];
        $gradeOrder = ['PLATINUM' => 1, 'GOLD' => 2, 'SILVER' => 3, 'TRAINEE' => 4];
        $monthKeys = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];

        $records = DB::connection('dms')
            ->table('pmKDP')
            ->join('HrEmployee', 'pmKDP.EmployeeID', '=', 'HrEmployee.EmployeeID')
            ->where('pmKDP.LastProgress', 'DELIVERY')
            ->where('HrEmployee.IsDeleted', '0')
            ->whereYear('pmKDP.LastUpdateStatus', $year)
            ->whereIn('pmKDP.BranchCode', array_keys($allowedBranches))
            ->selectRaw('pmKDP.BranchCode, HrEmployee.EmployeeID, HrEmployee.EmployeeName, HrEmployee.Grade, MONTH(pmKDP.LastUpdateStatus) as m_num, COUNT(*) as total')
            ->groupBy('pmKDP.BranchCode', 'HrEmployee.EmployeeID', 'HrEmployee.EmployeeName', 'HrEmployee.Grade', DB::raw('MONTH(pmKDP.LastUpdateStatus)'))
            ->get();

        $salesMatrix = [];
        foreach ($records as $r) {
            $bCode = trim($r->BranchCode);
            $empId = trim($r->EmployeeID);
            $empName = trim($r->EmployeeName);
            $gNum = (int)$r->Grade;
            $gName = $gradeMap[$gNum] ?? 'TRAINEE';
            $mNum = (int)$r->m_num;

            if (!isset($salesMatrix[$bCode][$empId])) {
                $salesMatrix[$bCode][$empId] = [
                    'name'   => $empName,
                    'grade'  => $gName,
                    'months' => array_fill(1, 12, 0),
                ];
            }

            $salesMatrix[$bCode][$empId]['months'][$mNum] += (int)$r->total;
        }

        $dataByBranch = [];
        $flatData = collect();
        $grandTotals = array_fill_keys($monthKeys, 0);
        $grandTotalAll = 0;

        foreach ($allowedBranches as $bCode => $bName) {
            $branchRows = [];
            $subtotal = array_fill_keys($monthKeys, 0);
            $subtotalAll = 0;

            $empList = $salesMatrix[$bCode] ?? [];

            uasort($empList, function($a, $b) use ($gradeOrder) {
                $orderA = $gradeOrder[$a['grade']] ?? 99;
                $orderB = $gradeOrder[$b['grade']] ?? 99;
                if ($orderA === $orderB) {
                    return strcmp($a['name'], $b['name']);
                }
                return $orderA <=> $orderB;
            });

            foreach ($empList as $empId => $empData) {
                $rowObj = new \stdClass();
                $rowObj->id = $empId;
                $rowObj->employee_id = $empId;
                $rowObj->salesman_name = $empData['name'];
                $rowObj->grading = $empData['grade'];
                $rowObj->cabang = $bName;
                $rowObj->tahun = $year;
                $rowTotal = 0;

                for ($m = 1; $m <= 12; $m++) {
                    $mKey = $monthKeys[$m - 1];
                    $val = $empData['months'][$m] ?? 0;
                    $rowObj->$mKey = $val;
                    $rowTotal += $val;
                    $subtotal[$mKey] += $val;
                    $grandTotals[$mKey] += $val;
                }

                $rowObj->total = $rowTotal;
                $subtotalAll += $rowTotal;
                $grandTotalAll += $rowTotal;

                $branchRows[] = $rowObj;
                $flatData->push($rowObj);
            }

            $subtotal['total'] = $subtotalAll;
            $dataByBranch[] = [
                'branch_code' => $bCode,
                'branch_name' => $bName,
                'rows'        => $branchRows,
                'subtotal'    => $subtotal,
            ];
        }

        $pdf = Pdf::loadView('sales.vsv.current.actual_do_salesforces.pdf', [
            'data'          => $flatData,
            'dataByBranch'  => $dataByBranch,
            'year'          => $year,
            'months'        => $monthKeys,
            'grandTotals'   => $grandTotals,
            'grandTotalAll' => $grandTotalAll
        ])->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Actual-DO-Salesforce-' . $year . '.pdf');
    }

    public function exportExcel(Request $request) 
    { 
        $year = (int)$request->input('year', now()->year);
        $selectedCabang = $request->input('cabang');
        return Excel::download(new ActualDoSalesforceExport($year, $selectedCabang), 'Actual_DO_Salesforce_' . $year . '.xlsx'); 
    }

    // --- METODE CRUD LAMA YANG DIPERTAHANKAN ---

    public function create() 
    { 
        $user = Auth::user();
        $allowedRoles = ['Admin', 'OM', 'Admin DCA', 'OM DCA', 'BM', 'SH'];

        return view('sales.vsv.current.actual_do_salesforces.create'); 
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'tahun'   => 'required|numeric',
            'grading' => 'required|string',
            'jan' => 'nullable|numeric', 'feb' => 'nullable|numeric', 'mar' => 'nullable|numeric',
            'apr' => 'nullable|numeric', 'mei' => 'nullable|numeric', 'jun' => 'nullable|numeric',
            'jul' => 'nullable|numeric', 'agu' => 'nullable|numeric', 'sep' => 'nullable|numeric',
            'okt' => 'nullable|numeric', 'nov' => 'nullable|numeric', 'des' => 'nullable|numeric',
        ]);

        $months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        $monthData = [];
        $total = 0;

        foreach ($months as $month) {
            $val = $request->input($month, 0) ?: 0;
            $monthData[$month] = (int)$val;
            $total += (int)$val;
        }

        $existing = ActualDoSalesForce::where('cabang', ($user->cabang ?: 'Ciawi'))
            ->where('tahun', $request->tahun)
            ->where('grading', $request->grading)
            ->first();

        if ($existing) {
            return back()->with('error', 'Data Actual untuk grading ini di tahun tersebut sudah ada di cabang Anda!')
                         ->withInput();
        }

        ActualDoSalesForce::create(array_merge([
            'grading' => $request->grading,
            'tahun'   => $request->tahun,
            'cabang'  => ($user->cabang ?: 'Ciawi'),
            'total'   => $total,
        ], $monthData));

        return redirect()->route('current.actual-do-salesforces.index')->with('success', 'Data berhasil disimpan.');
    }

    public function edit(string $id)
    {
        $actualDoSalesforce = ActualDoSalesForce::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($actualDoSalesforce, $user)) {
            return redirect()->route('current.actual-do-salesforces.index')->with('error', 'Akses dilarang!');
        }

        return view('sales.vsv.current.actual_do_salesforces.edit', compact('actualDoSalesforce'));
    }

    public function update(Request $request, string $id)
    {
        $actualDoSalesforce = ActualDoSalesForce::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($actualDoSalesforce, $user)) {
            return redirect()->route('current.actual-do-salesforces.index')->with('error', 'Akses dilarang.');
        }

        $request->validate([
            'jan' => 'nullable|numeric', 'feb' => 'nullable|numeric', 'mar' => 'nullable|numeric',
            'apr' => 'nullable|numeric', 'mei' => 'nullable|numeric', 'jun' => 'nullable|numeric',
            'jul' => 'nullable|numeric', 'agu' => 'nullable|numeric', 'sep' => 'nullable|numeric',
            'okt' => 'nullable|numeric', 'nov' => 'nullable|numeric', 'des' => 'nullable|numeric',
        ]);

        $months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        $monthData = [];
        $total = 0;

        foreach ($months as $month) {
            $val = $request->input($month, 0) ?: 0;
            $monthData[$month] = (int)$val;
            $total += (int)$val;
        }

        $actualDoSalesforce->update(array_merge(
            $monthData,
            ['total' => $total]
        ));

        return redirect()->route('current.actual-do-salesforces.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $actualDoSalesforce = ActualDoSalesForce::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($actualDoSalesforce, $user)) {
            return redirect()->route('current.actual-do-salesforces.index')->with('error', 'Akses dilarang.');
        }

        $actualDoSalesforce->delete();
        return redirect()->route('current.actual-do-salesforces.index')->with('success', 'Data berhasil dihapus.');
    }

    private function checkAccess($record, $user)
    {
        return true;
    }
}