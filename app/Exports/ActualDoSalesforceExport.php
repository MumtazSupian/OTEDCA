<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ActualDoSalesforceExport implements FromView, ShouldAutoSize
{
    protected $year;
    protected $selectedCabang;

    private $branchNameToCode = [
        'CIAWI'    => '641940101',
        'CIANJUR'  => '641940102',
        'CINERE'   => '641940103',
        'JATIASIH' => '641940104',
        'CIPANAS'  => '641940106',
    ];

    public function __construct($year = null, $selectedCabang = null)
    {
        $this->year = $year ?: 2026;
        $this->selectedCabang = $selectedCabang;
    }

    public function view(): View
    {
        $user = Auth::user();
        $userRole = strtoupper($user->role ?? '');
        $userCabang = strtoupper(trim($user->branch ?? $user->cabang ?? ''));
        
        $isPusat = ($user->is_admin ?? false) || 
                   in_array($userCabang, ['ADMIN', 'PUSAT']) || 
                   in_array($userRole, ['ADMIN', 'OM', 'ADMIN DCA', 'OM DCA']) ||
                   in_array(strtolower($user->email ?? ''), ['dcasr', 'it', 'heruit', 'mumtazit', 'rizkyit']);

        $year = (int)$this->year;
        $selectedCabang = $this->selectedCabang;

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

        $viewName = view()->exists('sales.vsv.current.actual_do_salesforces.pdf')
            ? 'sales.vsv.current.actual_do_salesforces.pdf'
            : 'evaluasi.export_pdf';

        return view($viewName, [
            'data'          => $flatData,
            'dataByBranch'  => $dataByBranch,
            'year'          => $year,
            'months'        => $monthKeys,
            'grandTotals'   => $grandTotals,
            'grandTotalAll' => $grandTotalAll,
            'isExcel'       => true
        ]);
    }
}