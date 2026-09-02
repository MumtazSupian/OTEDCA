<?php

namespace App\Http\Controllers\Sales\vsv\evaluasi;

use App\Http\Controllers\Controller;
use App\Models\Sales\vsv\evaluasi\EvaluasiWiraniaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ActualDoSalesforceExport;
use App\Exports\EvaluasiExport;

class EvaluasiWiraniagaController extends Controller
{
    private $branchNameToCode = [
        'CIAWI'    => '641940101',
        'CIANJUR'  => '641940102',
        'CINERE'   => '641940103',
        'JATIASIH' => '641940104',
        'CIPANAS'  => '641940106',
    ];

    private function getFilteredQuery()
    {
        $user = Auth::user();
        $query = EvaluasiWiraniaga::query();

        if (!$user || $user->is_admin || $user->is_admin_stock || in_array(strtolower($user->role ?? ''), ['admin', 'om', 'admin dca', 'om dca', 'admin stock', ''])) {
            return $query->orderBy('id', 'desc');
        }

        $cabang = $user->cabang ?: ($user->branch ?: 'Ciawi');
        return $query->where('cabang', $cabang)->orderBy('id', 'desc');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        
        $userRole = strtoupper($user->role ?? '');
        $userCabang = strtoupper(trim($user->branch ?? $user->cabang ?? ''));
        
        $isPusat = ($user->is_admin ?? false) || 
                   in_array($userCabang, ['ADMIN', 'PUSAT']) || 
                   in_array($userRole, ['ADMIN', 'OM', 'ADMIN DCA', 'OM DCA']) ||
                   in_array(strtolower($user->email ?? ''), ['dcasr', 'it', 'heruit', 'mumtazit', 'rizkyit']);

        $year = (int)$request->input('year', 2026);
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
            // pmKDP JOIN HrEmployee dari DMS
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
                    $rowObj->nama_sales = $empData['name'];
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
            Log::error("Error reading Evaluasi Salesforce from DMS pmKDP: " . $e->getMessage());
            $dataByBranch = [];
            $data = collect();
            $grandTotals = array_fill_keys($monthKeys, 0);
            $grandTotal = 0;
            $grandTotalAll = 0;
        }

        return view('sales.vsv.evaluasi.index', compact('data', 'dataByBranch', 'year', 'grandTotal', 'grandTotals', 'grandTotalAll', 'allowedBranches', 'selectedCabang', 'isPusat'));
    }

    public function exportPdf(Request $request)
    {
        $user = Auth::user();
        
        $userRole = strtoupper($user->role ?? '');
        $userCabang = strtoupper(trim($user->branch ?? $user->cabang ?? ''));
        
        $isPusat = ($user->is_admin ?? false) || 
                   in_array($userCabang, ['ADMIN', 'PUSAT']) || 
                   in_array($userRole, ['ADMIN', 'OM', 'ADMIN DCA', 'OM DCA']) ||
                   in_array(strtolower($user->email ?? ''), ['dcasr', 'it', 'heruit', 'mumtazit', 'rizkyit']);

        $year = (int)$request->input('year', 2026);
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
                $rowObj->nama_sales = $empData['name'];
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

        $pdfView = view()->exists('sales.vsv.current.actual_do_salesforces.pdf') 
            ? 'sales.vsv.current.actual_do_salesforces.pdf' 
            : 'evaluasi.export_pdf';

        $pdf = Pdf::loadView($pdfView, [
            'data'          => $flatData,
            'dataByBranch'  => $dataByBranch,
            'year'          => $year,
            'months'        => $monthKeys,
            'grandTotals'   => $grandTotals,
            'grandTotalAll' => $grandTotalAll
        ])->setPaper('a4', 'landscape');

        return $pdf->download('Evaluasi-Wiraniaga-' . $year . '.pdf');
    }

    public function exportExcel(Request $request) 
    { 
        $year = (int)$request->input('year', 2026);
        $selectedCabang = $request->input('cabang');
        return Excel::download(new ActualDoSalesforceExport($year, $selectedCabang), 'Evaluasi_Wiraniaga_' . $year . '.xlsx'); 
    }

    // --- METODE CRUD CADANGAN / LAMA YANG DIPERTAHANKAN ---

    public function create()
    {
        return view('sales.vsv.evaluasi.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        $calculated = $this->calculateTotalAndGrading($request);
        $data['total'] = $calculated['total'];
        $data['grading'] = $calculated['grading'];
        $data['cabang'] = ($user->cabang ?: 'Ciawi');

        EvaluasiWiraniaga::create($data);
        return redirect()->route('evaluasi.index')->with('success', 'Data berhasil disimpan!');
    }

    public function edit($id)
    {
        $row = EvaluasiWiraniaga::findOrFail($id);
        $user = Auth::user();
        
        if ($user->role == 'SH' && $row->user_id != $user->id) {
            return redirect()->route('evaluasi.index')->with('error', 'Akses dilarang!');
        }

        if ($user->role == 'BM' && $row->cabang != $user->cabang) {
            return redirect()->route('evaluasi.index')->with('error', 'Akses dilarang!');
        }

        return view('sales.vsv.evaluasi.edit', compact('row'));
    }

    public function update(Request $request, $id)
    {
        $row = EvaluasiWiraniaga::findOrFail($id);
        $user = Auth::user();

        if ($user->role == 'SH' && $row->user_id != $user->id) {
            return redirect()->route('evaluasi.index')->with('error', 'Update ditolak.');
        }

        $data = $request->all();
        $calculated = $this->calculateTotalAndGrading($request);
        $data['total'] = $calculated['total'];
        $data['grading'] = $calculated['grading'];

        $row->update($data);
        return redirect()->route('evaluasi.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $row = EvaluasiWiraniaga::findOrFail($id);
        if (Auth::user()->role == 'SH' && $row->user_id != Auth::id()) {
            return redirect()->route('evaluasi.index')->with('error', 'Hapus ditolak.');
        }

        $row->delete();
        return redirect()->route('evaluasi.index')->with('success', 'Data berhasil dihapus');
    }

    private function calculateTotalAndGrading($request)
    {
        $months = [
            (int)$request->input('jan', 0),
            (int)$request->input('feb', 0),
            (int)$request->input('mar', 0),
            (int)$request->input('apr', 0),
            (int)$request->input('mei', 0),
            (int)$request->input('jun', 0),
        ];

        $total6Bulan = array_sum($months);
        $firstIdx = -1;
        foreach ($months as $idx => $val) {
            if ($val > 0) {
                $firstIdx = $idx;
                break;
            }
        }

        if ($firstIdx === -1) {
            return ['total' => 0, 'grading' => "TRAINEE -> EVALUASI"];
        }

        $data3BulanAwal = array_slice($months, $firstIdx, 3);
        $total3Awal = array_sum($data3BulanAwal);
        $avg3Awal = $total3Awal / count($data3BulanAwal);

        $data3BulanAkhir = array_slice($months, 3, 3);
        $total3Akhir = array_sum($data3BulanAkhir);
        $avg3Akhir = $total3Akhir / 3;

        $avg6 = $total6Bulan / (6 - $firstIdx);

        if ($avg6 >= 5 && $total6Bulan >= 31) {
            $grading = "PLATINUM";
        } elseif ($avg6 >= 4 && $total6Bulan >= 25) {
            $grading = "GOLD -> KADAR PLATINUM";
        } elseif ($avg3Awal >= 2 || $total3Awal >= 7 || $avg3Akhir >= 2 || $total3Akhir >= 6) {
            $grading = "SILVER -> KADAR GOLD";
        } elseif ($avg3Awal >= 1) {
            $grading = "TRAINEE -> KADAR SILVER";
        } else {
            $grading = "TRAINEE -> EVALUASI";
        }

        return ['total' => $total6Bulan, 'grading' => $grading];
    }
}