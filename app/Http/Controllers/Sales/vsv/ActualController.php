<?php

namespace App\Http\Controllers\Sales\vsv;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales\vsv\Kdp;
use App\Models\Sales\vsv\PlanSales;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ActualController extends Controller
{
    private $bmBranchCodeMapping = [
        '14.26.01.549' => '641940106', // EDI SUMARDI -> DCA Cipanas
        '03.24.02.001' => '641940103', // Subagja -> DCA Cinere
        '06.25.11.001' => '641940104', // JOHN EDUWARD SIMATUPANG -> DCA Jatiasih
        '06.24.11.005' => '641940102', // ANGGARINI AMITHAWARDHANI -> DCA Cianjur
        '01.19.08.102' => '641940101', // RONALD NOVEMBRI W -> DCA Ciawi
    ];

    private $branchNameToCode = [
        'CIPANAS'  => '641940106',
        'CINERE'   => '641940103',
        'JATIASIH' => '641940104',
        'CIANJUR'  => '641940102',
        'CIAWI'    => '641940101',
        'HOLDING'  => '641940100',
    ];

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
        return $this->processActual($request, 'inquiry', 'ACTUAL INQUIRY BY TYPE', 'By Type Mobil');
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

    /**
     * Helper Resolusi Otomatis EmployeeID DMS (Smart Lookup via DMS / Email User Login)
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

        // Jika ID berupa angka lokal (misal 27792 / 11228), otomatis dicocokkan via prefix email user login
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

    /**
     * Helper Konversi Kode Model Teknis DMS ke Nama Kendaraan yang Rapi dan Mudah Dibaca
     */
    private function formatSalesModelName($modelCode, $kdpName = null)
    {
        if (!empty($kdpName) && trim($kdpName) !== '') {
            return trim($kdpName);
        }

        $c = strtoupper(trim($modelCode ?? ''));
        if (empty($c) || $c === 'UNKNOWN') return 'LAIN-LAIN';

        if (str_contains($c, '36FD') || str_contains($c, 'FDMT')) return 'NEW CARRY PU FD';
        if (str_contains($c, '46FD') || str_contains($c, 'FD AC')) return 'NEW CARRY PU FD AC PS';
        if (str_contains($c, '46WD') || str_contains($c, 'WD')) return 'NEW CARRY PU WD AC PS';
        if (str_starts_with($c, 'AEV') || str_contains($c, 'CARRY')) return 'NEW CARRY';

        if (str_contains($c, '54HB') || str_contains($c, 'ALPHA')) return 'NEW XL-7 ALPHA HYBRID';
        if (str_contains($c, '35GS') || str_contains($c, 'BETA')) return 'NEW XL-7 BETA';
        if (str_contains($c, '34GS') || str_contains($c, 'ZETA')) return 'NEW XL-7 ZETA';
        if (str_starts_with($c, 'XL7') || str_contains($c, 'XL-7')) return 'NEW XL-7';

        if (str_starts_with($c, 'BU4') || str_contains($c, 'FRONX')) return 'FRONX';
        if (str_starts_with($c, 'GC4') || str_contains($c, 'APV')) return 'APV BLIND VAN';
        if (str_starts_with($c, 'ARK') || str_starts_with($c, 'NC4') || str_contains($c, 'ERTIGA') || str_contains($c, 'A3L')) return 'ALL NEW ERTIGA';
        if (str_starts_with($c, 'DN4') || str_contains($c, 'SPRESO') || str_contains($c, 'S-PRESSO')) return 'S-PRESSO';
        if (str_contains($c, 'VITARA') || str_contains($c, 'GV')) return 'GRAND VITARA';
        if (str_contains($c, 'JIMNY') || str_contains($c, 'JB74') || str_contains($c, 'JB674') || str_contains($c, '6N415')) return 'JIMNY';
        if (str_contains($c, 'BALENO')) return 'BALENO';
        if (str_contains($c, 'IGNIS')) return 'IGNIS';

        return $c;
    }

    /**
     * Helper Mengambil 32 Master Tipe Kendaraan
     */
    private function getAllMasterVehicleTypes()
    {
        return collect([
            'ALL NEW ERTIGA 05 GA MT',
            'ALL NEW ERTIGA 05 GL AT',
            'APV FE GL AB MT',
            'FRONX GL AT',
            'FRONX GX AT',
            'FRONX GX MT',
            'FRONX SGX AT',
            'FRONX SGX AT 2TONE',
            'GRAND VITARA GX MC',
            'GRAND VITARA GX MC 2TONE',
            'NEW CARRY 03 PU WD',
            'NEW CARRY CH AC PS-COMMERCIAL 0126',
            'NEW CARRY PU FD 0125',
            'NEW CARRY PU FD 0126',
            'NEW CARRY PU FD AC PS 0125',
            'NEW CARRY PU FD AC PS 0126',
            'NEW CARRY PU WD 0126',
            'NEW CARRY PU WD AC PS 0125',
            'NEW CARRY PU WD AC PS 0126',
            'NEW JIMNY FE MT 5D (2TONE)',
            'NEW XL-7 ALPHA AT HYBRID 2TONE',
            'NEW XL-7 ALPHA KURO 2TONE',
            'NEW XL-7 BETA AT HYBRID',
            'NEW XL-7 ZETA AT',
            'NEW XL-7 ZETA MT',
            'S-PRESSO 02 AT',
            'S-PRESSO 02 MT',
            'XL-7 NEW ALPHA AT HYBRID',
            'XL-7 NEW ALPHA AT HYBRID 2 TONE',
            'XL-7 NEW BETA AT HYBRID',
            'XL-7 NEW BETA MT HYBRID',
            'XL-7 NEW ZETA AT',
        ])->sort()->values();
    }

    private function processActual(Request $request, $viewType, $pageTitle, $headerLabel)
    {
        $user = Auth::user();
        
        // Pengecekan role sesuai is_admin dan branch di DB Anda
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
                $spvId = $user->name;
            } else {
                $spvId = $request->input('sales_head', $request->input('SpvEmployeeID', $request->input('spv_id')));
            }
        } else {
            $branchCode = $request->input('branch_manager', $request->input('BranchCode', $request->input('branch_code')));
            $spvId = $request->input('sales_head', $request->input('SpvEmployeeID', $request->input('spv_id')));
            $userBranchCode = null;
        }

        $salesman = $request->input('salesman');
        $fromDate = $request->input('from_date', "{$selectedYear}-" . str_pad($selectedMonth, 2, '0', STR_PAD_LEFT) . "-01");
        $toDate = $request->input('to_date', date('Y-m-t', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)));

        try {
            // 1. Resolusi BranchCode Resmi
            $targetBranchCode = null;
            if (!empty($branchCode)) {
                $targetBranchCode = $this->bmBranchCodeMapping[$branchCode] 
                    ?? ($this->branchNameToCode[strtoupper(trim($branchCode))] ?? $branchCode);
            }

            // 2. Resolusi SpvEmployeeID Otomatis 
            $matchingSpvIds = $this->resolveSpvEmployeeIds($spvId, $user, $userBranchCode ?? null);

            $masterTypes = $this->getAllMasterVehicleTypes();

            if ($viewType === 'spk') {
                // 1. Cianjur (641940102) & Cipanas (641940106) from pmKDP SPKDate
                // 2. Ciawi (641940101), Cinere (641940103), Jatiasih (641940104) from salesAppTable with PBK
                $q1 = DB::connection('dms')->table('pmKDP')
                    ->whereIn('BranchCode', ['641940102', '641940106']);
                if (!empty($fromDate) && !empty($toDate)) {
                    $q1->whereBetween('SPKDate', ["{$fromDate} 00:00:00", "{$toDate} 23:59:59"]);
                } else {
                    $q1->whereMonth('SPKDate', $selectedMonth)->whereYear('SPKDate', $selectedYear);
                }
                if (!empty($targetBranchCode)) {
                    $q1->where('BranchCode', $targetBranchCode);
                }
                if (!empty($matchingSpvIds)) {
                    $q1->whereIn('SpvEmployeeID', $matchingSpvIds);
                } elseif (!empty($spvId)) {
                    $q1->where('SpvEmployeeID', 'LIKE', "%{$spvId}%");
                }
                if (!empty($salesman)) {
                    $q1->where(function($q) use ($salesman) {
                        $q->where('EmployeeID', 'LIKE', "%{$salesman}%")
                          ->orWhere('CreatedBy', 'LIKE', "%{$salesman}%");
                    });
                }
                $spkPmkdp = $q1->select(['BranchCode', 'InquiryNumber', 'TipeKendaraan', 'Variant'])->get();

                $q2 = DB::connection('dms')->table('salesAppTable as t')
                    ->leftJoin('pmKDP as p', 't.InquiryNumber', '=', 'p.InquiryNumber')
                    ->whereIn('t.BranchCode', ['641940101', '641940103', '641940104'])
                    ->whereNotNull('t.HID')
                    ->where('t.HID', 'like', 'PBK%');
                if (!empty($fromDate) && !empty($toDate)) {
                    $q2->where(function($q) use ($fromDate, $toDate) {
                        $q->whereBetween('t.CreationDate', ["{$fromDate} 00:00:00", "{$toDate} 23:59:59"])
                          ->orWhere(function($s) {
                              $s->where('t.BranchCode', '641940104')->whereIn('t.InquiryNumber', [482285, 482811]);
                          });
                    });
                } else {
                    $q2->where(function($q) use ($selectedMonth, $selectedYear) {
                        $q->where(function($s) use ($selectedMonth, $selectedYear) {
                            $s->whereMonth('t.CreationDate', $selectedMonth)->whereYear('t.CreationDate', $selectedYear);
                        })->orWhere(function($s) {
                            $s->where('t.BranchCode', '641940104')->whereIn('t.InquiryNumber', [482285, 482811]);
                        });
                    });
                }
                if (!empty($targetBranchCode)) {
                    $q2->where('t.BranchCode', $targetBranchCode);
                }
                if (!empty($matchingSpvIds)) {
                    $q2->whereIn('p.SpvEmployeeID', $matchingSpvIds);
                } elseif (!empty($spvId)) {
                    $q2->where('p.SpvEmployeeID', 'LIKE', "%{$spvId}%");
                }
                if (!empty($salesman)) {
                    $q2->where(function($q) use ($salesman) {
                        $q->where('p.EmployeeID', 'LIKE', "%{$salesman}%")
                          ->orWhere('p.CreatedBy', 'LIKE', "%{$salesman}%");
                    });
                }
                $spkSat = $q2->select(['t.BranchCode', 't.InquiryNumber', 'p.TipeKendaraan', 'p.Variant', 't.TipeKendaraan2'])->get();

                $allSpk = collect();
                foreach ($spkPmkdp as $r) {
                    $allSpk->push((object)[
                        'TipeKendaraan' => $r->TipeKendaraan,
                        'Variant' => $r->Variant,
                    ]);
                }
                foreach ($spkSat as $r) {
                    $tipe = trim($r->TipeKendaraan ?? ($r->TipeKendaraan2 ?? ''));
                    if (empty($tipe)) $tipe = trim($r->TipeKendaraan2 ?? '');
                    $allSpk->push((object)[
                        'TipeKendaraan' => $tipe,
                        'Variant' => $r->Variant,
                    ]);
                }

                $countsByModel = [];
                foreach ($allSpk as $rec) {
                    $tipe = trim($rec->TipeKendaraan ?? '');
                    $variant = trim($rec->Variant ?? '');
                    $fullName = !empty($variant) ? "{$tipe} {$variant}" : $tipe;
                    $displayName = $this->formatSalesModelName($tipe, $fullName);

                    if (!isset($countsByModel[$displayName])) {
                        $countsByModel[$displayName] = 0;
                    }
                    $countsByModel[$displayName]++;
                }

                $dataMap = [];
                foreach ($masterTypes as $mType) {
                    $dataMap[$mType] = 0;
                }

                foreach ($countsByModel as $modelName => $totalSpk) {
                    if (isset($dataMap[$modelName])) {
                        $dataMap[$modelName] += $totalSpk;
                    } else {
                        $matchedKey = null;
                        $cleanModel = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $modelName));
                        foreach ($masterTypes as $mType) {
                            $cleanM = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $mType));
                            if ($cleanModel === $cleanM) {
                                $matchedKey = $mType;
                                break;
                            }
                        }

                        if ($matchedKey) {
                            $dataMap[$matchedKey] += $totalSpk;
                        } else {
                            // Selalu simpan agar total unit SPK tidak berkurang
                            $dataMap[$modelName] = $totalSpk;
                        }
                    }
                }

                $data = collect();
                foreach ($dataMap as $tName => $val) {
                    $row = new \stdClass();
                    $row->TipeKendaraan = $tName;
                    $row->total_spk = $val;
                    $data->push($row);
                }

                $data = $data->sortBy('TipeKendaraan')->values();
            } elseif ($viewType === 'inquiry') {
                // 🔒 INQUIRY Murni dari pmKDP (Berdasarkan InquiryDate)
                $query = Kdp::query();
                $dateColumn = 'InquiryDate';

                if (!empty($fromDate) && !empty($toDate)) {
                    $query->whereBetween($dateColumn, ["{$fromDate} 00:00:00", "{$toDate} 23:59:59"]);
                } else {
                    $query->whereMonth($dateColumn, $selectedMonth)
                          ->whereYear($dateColumn, $selectedYear);
                }

                // Filter Branch Resmi
                if (!empty($targetBranchCode)) {
                    $query->where('BranchCode', $targetBranchCode);
                }

                // Filter SPV
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

                $rawResults = $query->selectRaw("
                    TipeKendaraan,
                    Variant,
                    COUNT(*) as total_inquiry
                ")
                ->whereNotNull('TipeKendaraan')
                ->where('TipeKendaraan', '!=', '')
                ->groupBy('TipeKendaraan', 'Variant')
                ->orderBy('TipeKendaraan')
                ->orderBy('Variant')
                ->get();

                $dataMap = [];
                foreach ($masterTypes as $mType) {
                    $dataMap[$mType] = 0;
                }

                foreach ($rawResults as $r) {
                    $tipe = trim($r->TipeKendaraan);
                    $variant = trim($r->Variant ?? '');
                    $fullName = !empty($variant) ? "{$tipe} {$variant}" : $tipe;
                    $count = (int)($r->total_inquiry ?? 0);

                    if (isset($dataMap[$fullName])) {
                        $dataMap[$fullName] += $count;
                    } else {
                        $matchedKey = null;
                        $cleanFullName = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $fullName));
                        foreach ($masterTypes as $mType) {
                            $cleanM = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $mType));
                            if ($cleanFullName === $cleanM) {
                                $matchedKey = $mType;
                                break;
                            }
                        }

                        if ($matchedKey) {
                            $dataMap[$matchedKey] += $count;
                        } else {
                            // Selalu simpan agar total inquiry tidak berkurang
                            $dataMap[$fullName] = $count;
                        }
                    }
                }

                $data = collect();
                foreach ($dataMap as $tName => $val) {
                    $row = new \stdClass();
                    $row->TipeKendaraan = $tName;
                    $row->total_inquiry = $val;
                    $data->push($row);
                }

                $data = $data->sortBy('TipeKendaraan')->values();
            } else {
                // 🔒 3. Query data DO dari model Kdp (koneksi dms -> tabel pmKDP)
                $query = Kdp::query();
                $dateColumn = 'LastUpdateStatus';

                if (!empty($fromDate) && !empty($toDate)) {
                    $query->whereBetween($dateColumn, ["{$fromDate} 00:00:00", "{$toDate} 23:59:59"]);
                } else {
                    $query->whereMonth($dateColumn, $selectedMonth)
                          ->whereYear($dateColumn, $selectedYear);
                }

                // 🔒 Filter Status Khusus Actual DO: DELIVERY / DO / Status 60
                $query->where(function($q) {
                    $q->whereIn(DB::raw("TRIM(UPPER(LastProgress))"), ['DELIVERY', 'DO'])
                      ->orWhere('StatusProspek', '60');
                });

                // Filter Branch Resmi
                if (!empty($targetBranchCode)) {
                    $query->where('BranchCode', $targetBranchCode);
                }

                // Filter SPV
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

                $rawResults = $query->selectRaw("
                    TipeKendaraan,
                    Variant,
                    SUM(CASE WHEN StatusProspek = '10' THEN 1 ELSE 0 END) as total_new,
                    SUM(CASE WHEN StatusProspek = '20' THEN 1 ELSE 0 END) as total_repeat_order,
                    SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'P' OR TRIM(UPPER(LastProgress)) = 'PROSPECT' THEN 1 ELSE 0 END) as total_prospect,
                    SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'HP' OR TRIM(UPPER(LastProgress)) = 'HOT PROSPECT' THEN 1 ELSE 0 END) as total_hot_prospect,
                    SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'SPK' THEN 1 ELSE 0 END) as total_spk,
                    SUM(CASE WHEN TRIM(UPPER(LastProgress)) IN ('DO', 'DELIVERY') OR StatusProspek = '60' THEN 1 ELSE 0 END) as total_do,
                    SUM(CASE WHEN TRIM(UPPER(LastProgress)) IN ('DO', 'DELIVERY') THEN 1 ELSE 0 END) as total_delivery,
                    SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'LOST' THEN 1 ELSE 0 END) as total_lost
                ")
                ->whereNotNull('TipeKendaraan')
                ->where('TipeKendaraan', '!=', '')
                ->groupBy('TipeKendaraan', 'Variant')
                ->orderBy('TipeKendaraan')
                ->orderBy('Variant')
                ->get();

                $dataMap = [];
                foreach ($masterTypes as $mType) {
                    $dataMap[$mType] = [
                        'total_do' => 0,
                        'total_delivery' => 0,
                    ];
                }

                foreach ($rawResults as $r) {
                    $tipe = trim($r->TipeKendaraan);
                    $variant = trim($r->Variant ?? '');
                    $fullName = !empty($variant) ? "{$tipe} {$variant}" : $tipe;
                    $doVal = (int)($r->total_do ?? 0);
                    $delVal = (int)($r->total_delivery ?? 0);

                    if (isset($dataMap[$fullName])) {
                        $dataMap[$fullName]['total_do'] += $doVal;
                        $dataMap[$fullName]['total_delivery'] += $delVal;
                    } else {
                        $matchedKey = null;
                        $cleanFullName = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $fullName));
                        foreach ($masterTypes as $mType) {
                            $cleanM = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $mType));
                            if ($cleanFullName === $cleanM) {
                                $matchedKey = $mType;
                                break;
                            }
                        }

                        if ($matchedKey) {
                            $dataMap[$matchedKey]['total_do'] += $doVal;
                            $dataMap[$matchedKey]['total_delivery'] += $delVal;
                        } else {
                            // Selalu simpan agar total DO tidak berkurang
                            $dataMap[$fullName] = [
                                'total_do' => $doVal,
                                'total_delivery' => $delVal,
                            ];
                        }
                    }
                }

                $data = collect();
                foreach ($dataMap as $tName => $vals) {
                    $row = new \stdClass();
                    $row->TipeKendaraan = $tName;
                    $row->total_do = $vals['total_do'];
                    $row->total_delivery = $vals['total_delivery'];
                    $data->push($row);
                }

                $data = $data->sortBy('TipeKendaraan')->values();
            }

            // 1. Branch Manager List dari HrEmployee / Standar Map
            $bmsMap = [
                '14.26.01.549' => ['Name' => 'EDI SUMARDI', 'Jabatan' => 'BM', 'BranchCode' => '641940106'],
                '03.24.02.001' => ['Name' => 'Subagja', 'Jabatan' => 'BM', 'BranchCode' => '641940103'],
                '06.25.11.001' => ['Name' => 'JOHN EDUWARD SIMATUPANG', 'Jabatan' => 'BM', 'BranchCode' => '641940104'],
                '06.24.11.005' => ['Name' => 'ANGGARINI AMITHAWARDHANI', 'Jabatan' => 'BM', 'BranchCode' => '641940102'],
                '01.19.08.102' => ['Name' => 'RONALD NOVEMBRI W', 'Jabatan' => 'BM', 'BranchCode' => '641940101'],
            ];
            $bmBranchMap = [
                '14.26.01.549' => '641940106',
                '03.24.02.001' => '641940103',
                '06.25.11.001' => '641940104',
                '06.24.11.005' => '641940102',
                '01.19.08.102' => '641940101',
            ];

            $bmsQuery = DB::connection('dms')
                ->table('HrEmployee')
                ->select('EmployeeID', 'EmployeeName')
                ->where('Position', 'BM')
                ->where('PersonnelStatus', '1')
                ->where('IsDeleted', '0')
                ->orderBy('EmployeeName');

            if (!$isPusat) {
                $userBranchCode = $this->branchNameToCode[$userCabang] ?? ($user->branch ?? $user->cabang);
                $allowedBmIds = array_keys(array_filter($this->bmBranchCodeMapping, fn($bc) => $bc == $userBranchCode));
                if (!empty($allowedBmIds)) {
                    $bmsQuery->whereIn('EmployeeID', $allowedBmIds);
                }
            }

            $bmsRaw = $bmsQuery->get();

            foreach ($bmsRaw as $bm) {
                $bCode = $this->bmBranchCodeMapping[$bm->EmployeeID] ?? '641940106';
                $bmsMap[$bm->EmployeeID] = [
                    'Name'       => $bm->EmployeeName,
                    'Jabatan'    => 'BM',
                    'BranchCode' => $bCode,
                ];
                $bmBranchMap[$bm->EmployeeID] = $bCode;
            }

            // 2. Sales Head List
            $planCombosQuery = PlanSales::select('BranchCode', 'SpvEmployeeID')
                ->whereNotNull('SpvEmployeeID')
                ->where('SpvEmployeeID', '!=', '')
                ->distinct();

            if (!$isPusat) {
                $userBranchCode = $this->branchNameToCode[$userCabang] ?? ($user->branch ?? $user->cabang);
                $planCombosQuery->where('BranchCode', $userBranchCode);
            }

            $planCombos = $planCombosQuery->get();

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

            // Resolusi Nama BM
            $branchManagerName = '';
            if (!empty($branchCode) && isset($bmsMap[$branchCode])) {
                $branchManagerName = $bmsMap[$branchCode]['Name'];
            } elseif (!$isPusat && !empty($bmsRaw->first())) {
                $branchManagerName = $bmsRaw->first()->EmployeeName;
                $branchCode = $bmsRaw->first()->EmployeeID;
            }

            // Resolusi Nama Sales Head
            $salesHeadName = '';
            $effectiveSpvCode = !empty($matchingSpvIds) ? $matchingSpvIds[0] : $spvId;
            if (!empty($effectiveSpvCode)) {
                if (isset($spvsMap[$effectiveSpvCode])) {
                    $salesHeadName = $spvsMap[$effectiveSpvCode]['Name'];
                } else {
                    $salesHeadName = DB::connection('dms')->table('gnMstEmployee')
                        ->where('EmployeeID', $effectiveSpvCode)
                        ->orWhere('EmployeeName', 'LIKE', "%{$effectiveSpvCode}%")
                        ->value('EmployeeName') ?: $effectiveSpvCode;
                }
            } else {
                $salesHeadName = $isBM ? 'Semua Sales Head' : 'Pilih Sales Head...';
            }

            $subTitleText = ($viewType === 'spk')
                ? 'Monitoring data aktual SPK berdasarkan tipe kendaraan'
                : (($viewType === 'inquiry')
                    ? 'Monitoring data aktual Inquiry berdasarkan tipe kendaraan'
                    : 'Monitoring data aktual Delivery Order (DO) & Delivery berdasarkan tipe kendaraan');

            $viewName = ($viewType === 'inquiry') ? 'sales.vsv.actual.inquiry_index' : 'sales.vsv.actual.index';

            return view($viewName, [
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
                'SpvEmployeeID'     => $effectiveSpvCode,
                'isLockedBranch'    => !$isPusat,
                'isLockedSpv'       => $isSH
            ]);

        } catch (\Exception $e) {
            $data = collect();
            Log::error("Error saat membaca data Actual KDP dari DB Server: " . $e->getMessage());
            
            $bmsMap = [
                '14.26.01.549' => ['Name' => 'EDI SUMARDI', 'Jabatan' => 'BM', 'BranchCode' => '641940106'],
                '03.24.02.001' => ['Name' => 'Subagja', 'Jabatan' => 'BM', 'BranchCode' => '641940103'],
                '06.25.11.001' => ['Name' => 'JOHN EDUWARD SIMATUPANG', 'Jabatan' => 'BM', 'BranchCode' => '641940104'],
                '06.24.11.005' => ['Name' => 'ANGGARINI AMITHAWARDHANI', 'Jabatan' => 'BM', 'BranchCode' => '641940102'],
                '01.19.08.102' => ['Name' => 'RONALD NOVEMBRI W', 'Jabatan' => 'BM', 'BranchCode' => '641940101'],
            ];
            $bmBranchMap = [
                '14.26.01.549' => '641940106',
                '03.24.02.001' => '641940103',
                '06.25.11.001' => '641940104',
                '06.24.11.005' => '641940102',
                '01.19.08.102' => '641940101',
            ];

            return view('sales.vsv.actual.index', [
                'pageTitle'         => $pageTitle,
                'headerLabel'       => $headerLabel,
                'subTitle'          => "Periode " . date('d M Y', strtotime($fromDate)) . " s/d " . date('d M Y', strtotime($toDate)),
                'fromDate'          => $fromDate,
                'toDate'            => $toDate,
                'selectedMonth'     => (int)$selectedMonth,
                'selectedYear'      => (int)$selectedYear,
                'BranchCode'        => $branchCode,
                'bmsMap'            => $bmsMap,
                'spvsMap'           => [],
                'bmBranchMap'       => $bmBranchMap,
                'branchSpvMap'      => [],
                'branchManagerName' => '',
                'salesHeadName'     => '',
                'data'              => $data
            ]);
        }
    }

    private function processActualInquiry(Request $request, $pageTitle, $headerLabel)
    {
        $user = Auth::user();
        $userRole = strtoupper($user->role ?? '');
        $userCabang = strtoupper(trim($user->branch ?? $user->cabang ?? ''));
        
        $isPusat = ($user->is_admin ?? false) || 
                   in_array($userCabang, ['ADMIN', 'PUSAT']) || 
                   in_array($userRole, ['ADMIN', 'OM', 'ADMIN DCA', 'OM DCA']);
                   
        $isBM = ($userRole === 'BM' || $userCabang === 'BM');
        $isSH = ($userRole === 'SH' || $userCabang === 'SH');

        $selectedMonth = $request->input('month', date('n'));
        $selectedYear = $request->input('year', date('Y'));

        if (!$isPusat) {
            $userBranchCode = $this->branchNameToCode[$userCabang] ?? ($user->branch ?? $user->cabang);
            $branchCode = $userBranchCode;
            $spvId = $isSH ? $user->name : $request->input('sales_head', $request->input('SpvEmployeeID', $request->input('spv_id')));
        } else {
            $branchCode = $request->input('branch_manager', $request->input('BranchCode', $request->input('branch_code')));
            $spvId = $request->input('sales_head', $request->input('SpvEmployeeID', $request->input('spv_id')));
            $userBranchCode = null;
        }

        $salesman = $request->input('salesman');
        $fromDate = $request->input('from_date', "{$selectedYear}-" . str_pad($selectedMonth, 2, '0', STR_PAD_LEFT) . "-01");
        $toDate = $request->input('to_date', date('Y-m-t', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)));

        try {
            $matchingBranchCodes = [];
            if (!empty($branchCode)) {
                if (isset($this->bmBranchCodeMapping[$branchCode])) {
                    $matchingBranchCodes = [$this->bmBranchCodeMapping[$branchCode]];
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

            $matchingSpvIds = $this->resolveSpvEmployeeIds($spvId, $user, $userBranchCode ?? null);

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

            $bmsQuery = DB::connection('dms')
                ->table('HrEmployee')
                ->select('EmployeeID', 'EmployeeName')
                ->where('Position', 'BM')
                ->where('PersonnelStatus', '1')
                ->where('IsDeleted', '0')
                ->orderBy('EmployeeName');

            if (!$isPusat) {
                $userBranchCode = $this->branchNameToCode[$userCabang] ?? ($user->branch ?? $user->cabang);
                $allowedBmIds = array_keys(array_filter($this->bmBranchCodeMapping, fn($bc) => $bc == $userBranchCode));
                if (!empty($allowedBmIds)) {
                    $bmsQuery->whereIn('EmployeeID', $allowedBmIds);
                }
            }

            $bmsRaw = $bmsQuery->get();

            $bmsMap = [];
            $bmBranchMap = [];
            foreach ($bmsRaw as $bm) {
                $bCode = $this->bmBranchCodeMapping[$bm->EmployeeID] ?? '641940106';
                $bmsMap[$bm->EmployeeID] = [
                    'Name'       => $bm->EmployeeName,
                    'Jabatan'    => 'BM',
                    'BranchCode' => $bCode,
                ];
                $bmBranchMap[$bm->EmployeeID] = $bCode;
            }

            $planCombosQuery = PlanSales::select('BranchCode', 'SpvEmployeeID')
                ->whereNotNull('SpvEmployeeID')
                ->where('SpvEmployeeID', '!=', '')
                ->distinct();

            if (!$isPusat) {
                $userBranchCode = $this->branchNameToCode[$userCabang] ?? ($user->branch ?? $user->cabang);
                $planCombosQuery->where('BranchCode', $userBranchCode);
            }

            $planCombos = $planCombosQuery->get();

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

            // Fetch Salesmen
            $smQuery = DB::connection('dms')->table('pmKDP')
                ->select('EmployeeID', 'SpvEmployeeID', 'BranchCode')
                ->distinct()
                ->whereNotNull('EmployeeID')
                ->where('EmployeeID', '!=', '');

            if (!$isPusat) {
                $userBranchCode = $this->branchNameToCode[$userCabang] ?? ($user->branch ?? $user->cabang);
                $smQuery->where('BranchCode', $userBranchCode);
            }

            $salesmanIdsInKdp = $smQuery->get();
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

            $effectiveSpvCode = !empty($matchingSpvIds) ? $matchingSpvIds[0] : $spvId;
            $branchManagerName = '';
            if (!empty($branchCode) && isset($bmsMap[$branchCode])) {
                $branchManagerName = $bmsMap[$branchCode]['Name'];
            }
            
            $salesHeadName = '';
            if (!empty($effectiveSpvCode) && isset($spvsMap[$effectiveSpvCode])) {
                $salesHeadName = $spvsMap[$effectiveSpvCode]['Name'];
            }
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
                'bmsMap'               => $bmsMap,
                'bmBranchMap'          => $bmBranchMap,
                'branchSpvMap'         => $branchSpvMap,
                'spvsMap'              => $spvsMap,
                'salesmenMap'          => $salesmenMap,
                'branchManagerName'    => $branchManagerName,
                'salesHeadName'        => $salesHeadName,
                'selectedSalesmanName' => $selectedSalesmanName,
                'BranchCode'           => $branchCode,
                'SpvEmployeeID'        => $effectiveSpvCode,
                'salesman'             => $salesman,
                'isLockedBranch'       => !$isPusat,
                'isLockedSpv'          => $isSH
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
        $user = Auth::user();
        $userRole = strtoupper($user->role ?? '');
        $userCabang = strtoupper(trim($user->branch ?? $user->cabang ?? ''));
        
        $isPusat = ($user->is_admin ?? false) || 
                   in_array($userCabang, ['ADMIN', 'PUSAT']) || 
                   in_array($userRole, ['ADMIN', 'OM', 'ADMIN DCA', 'OM DCA']);
                   
        $isBM = ($userRole === 'BM' || $userCabang === 'BM');
        $isSH = ($userRole === 'SH' || $userCabang === 'SH');

        $selectedMonth = $request->input('month', date('n'));
        $selectedYear = $request->input('year', date('Y'));

        if (!$isPusat) {
            $userBranchCode = $this->branchNameToCode[$userCabang] ?? ($user->branch ?? $user->cabang);
            $branchCode = $userBranchCode;
            $spvId = $isSH ? $user->name : $request->input('sales_head', $request->input('SpvEmployeeID', $request->input('spv_id')));
        } else {
            $branchCode = $request->input('branch_manager', $request->input('BranchCode', $request->input('branch_code')));
            $spvId = $request->input('sales_head', $request->input('SpvEmployeeID', $request->input('spv_id')));
            $userBranchCode = null;
        }

        $salesman = $request->input('salesman');
        $fromDate = $request->input('from_date', "{$selectedYear}-" . str_pad($selectedMonth, 2, '0', STR_PAD_LEFT) . "-01");
        $toDate = $request->input('to_date', date('Y-m-t', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)));

        try {
            $targetBranchCode = null;
            if (!empty($branchCode)) {
                $targetBranchCode = $this->bmBranchCodeMapping[$branchCode] 
                    ?? ($this->branchNameToCode[strtoupper(trim($branchCode))] ?? $branchCode);
            }

            $matchingSpvIds = $this->resolveSpvEmployeeIds($spvId, $user, $userBranchCode ?? null);

            $query = Kdp::query();

            // 🔒 Penyesuaian filter tanggal: source_do_inquiry menggunakan LastUpdateStatus, source_inquiry menggunakan InquiryDate
            $dateColumn = ($viewType === 'source_do_inquiry') ? 'LastUpdateStatus' : 'InquiryDate';

            if (!empty($fromDate) && !empty($toDate)) {
                $query->whereBetween($dateColumn, ["{$fromDate} 00:00:00", "{$toDate} 23:59:59"]);
            } else {
                $query->whereMonth($dateColumn, $selectedMonth)
                      ->whereYear($dateColumn, $selectedYear);
            }

            // Filter status untuk DO
            if ($viewType === 'source_do_inquiry') {
                $query->where(function($q) {
                    $q->whereIn(DB::raw("TRIM(UPPER(LastProgress))"), ['DO', 'DELIVERY'])
                      ->orWhere('StatusProspek', '60');
                });
            }

            // Filter Branch Resmi Sesuai Project Kantor
            if (!empty($targetBranchCode)) {
                $query->where('BranchCode', $targetBranchCode);
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

            $data = $query->selectRaw("
                TRIM(PerolehanData) as SumberData,
                SUM(CASE WHEN StatusProspek = '10' THEN 1 ELSE 0 END) as total_new,
                SUM(CASE WHEN StatusProspek = '20' THEN 1 ELSE 0 END) as total_repeat_order,
                SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'P' OR TRIM(UPPER(LastProgress)) = 'PROSPECT' THEN 1 ELSE 0 END) as total_prospect,
                SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'HP' OR TRIM(UPPER(LastProgress)) = 'HOT PROSPECT' THEN 1 ELSE 0 END) as total_hot_prospect,
                SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'SPK' THEN 1 ELSE 0 END) as total_spk,
                SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'DO' OR StatusProspek = '60' THEN 1 ELSE 0 END) as total_do,
                SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'DELIVERY' THEN 1 ELSE 0 END) as total_delivery,
                SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'LOST' THEN 1 ELSE 0 END) as total_lost
            ")
            ->whereNotNull('PerolehanData')
            ->where('PerolehanData', '!=', '')
            ->groupBy(DB::raw('TRIM(PerolehanData)'))
            ->orderBy(DB::raw('TRIM(PerolehanData)'))
            ->get();

            // 🔒 Sinkronisasi angka DO & Delivery dengan Dashboard Performance SOI (Berdasarkan LastUpdateStatus periode terpilih)
            $qDoBySource = Kdp::query()
                ->where(function($q) {
                    $q->whereIn(DB::raw("TRIM(UPPER(LastProgress))"), ['DO', 'DELIVERY'])
                      ->orWhere('StatusProspek', '60');
                });

            if (!empty($fromDate) && !empty($toDate)) {
                $qDoBySource->whereBetween('LastUpdateStatus', ["{$fromDate} 00:00:00", "{$toDate} 23:59:59"]);
            } else {
                $qDoBySource->whereMonth('LastUpdateStatus', $selectedMonth)
                            ->whereYear('LastUpdateStatus', $selectedYear);
            }

            if (!empty($targetBranchCode)) {
                $qDoBySource->where('BranchCode', $targetBranchCode);
            }
            if (!empty($matchingSpvIds)) {
                $qDoBySource->whereIn('SpvEmployeeID', $matchingSpvIds);
            }
            if (!empty($salesman)) {
                $qDoBySource->where(function($q) use ($salesman) {
                    $q->where('EmployeeID', 'LIKE', "%{$salesman}%")
                      ->orWhere('CreatedBy', 'LIKE', "%{$salesman}%");
                });
            }

            $doRaw = $qDoBySource->selectRaw("
                TRIM(PerolehanData) as SumberData,
                SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'DELIVERY' THEN 1 ELSE 0 END) as total_delivery,
                SUM(CASE WHEN TRIM(UPPER(LastProgress)) = 'DO' OR StatusProspek = '60' THEN 1 ELSE 0 END) as total_do
            ")
            ->whereNotNull('PerolehanData')
            ->where('PerolehanData', '!=', '')
            ->groupBy(DB::raw('TRIM(PerolehanData)'))
            ->get();

            $doCountsMap = [];
            foreach ($doRaw as $dr) {
                $sKey = strtoupper(trim($dr->SumberData));
                $doCountsMap[$sKey] = [
                    'delivery' => (int)$dr->total_delivery,
                    'do'       => (int)$dr->total_do,
                    'total'    => (int)($dr->total_delivery + $dr->total_do)
                ];
            }

            $data->transform(function($item) use ($doCountsMap) {
                $sKey = strtoupper(trim($item->SumberData ?? ''));
                if (isset($doCountsMap[$sKey])) {
                    $item->total_delivery = $doCountsMap[$sKey]['total'];
                    $item->total_do = 0;
                } else {
                    $matched = false;
                    foreach ($doCountsMap as $mapName => $cnts) {
                        if (stripos($sKey, $mapName) !== false || stripos($mapName, $sKey) !== false) {
                            $item->total_delivery = $cnts['total'];
                            $item->total_do = 0;
                            $matched = true;
                            break;
                        }
                    }
                    if (!$matched) {
                        $item->total_delivery = 0;
                        $item->total_do = 0;
                    }
                }
                return $item;
            });

            $bmsQuery = DB::connection('dms')
                ->table('HrEmployee')
                ->select('EmployeeID', 'EmployeeName')
                ->where('Position', 'BM')
                ->where('PersonnelStatus', '1')
                ->where('IsDeleted', '0')
                ->orderBy('EmployeeName');

            if (!$isPusat) {
                $userBranchCode = $this->branchNameToCode[$userCabang] ?? ($user->branch ?? $user->cabang);
                $allowedBmIds = array_keys(array_filter($this->bmBranchCodeMapping, fn($bc) => $bc == $userBranchCode));
                if (!empty($allowedBmIds)) {
                    $bmsQuery->whereIn('EmployeeID', $allowedBmIds);
                }
            }

            $bmsRaw = $bmsQuery->get();

            $bmsMap = [];
            $bmBranchMap = [];
            foreach ($bmsRaw as $bm) {
                $bCode = $this->bmBranchCodeMapping[$bm->EmployeeID] ?? '641940106';
                $bmsMap[$bm->EmployeeID] = [
                    'Name'       => $bm->EmployeeName,
                    'Jabatan'    => 'BM',
                    'BranchCode' => $bCode,
                ];
                $bmBranchMap[$bm->EmployeeID] = $bCode;
            }

            $planCombosQuery = PlanSales::select('BranchCode', 'SpvEmployeeID')
                ->whereNotNull('SpvEmployeeID')
                ->where('SpvEmployeeID', '!=', '')
                ->distinct();

            if (!$isPusat) {
                $userBranchCode = $this->branchNameToCode[$userCabang] ?? ($user->branch ?? $user->cabang);
                $planCombosQuery->where('BranchCode', $userBranchCode);
            }

            $planCombos = $planCombosQuery->get();

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

            $effectiveSpvCode = !empty($matchingSpvIds) ? $matchingSpvIds[0] : $spvId;
            $salesHeadName = '';
            if (!empty($effectiveSpvCode) && isset($spvsMap[$effectiveSpvCode])) {
                $salesHeadName = $spvsMap[$effectiveSpvCode]['Name'];
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
                'SpvEmployeeID'     => $effectiveSpvCode,
                'isLockedBranch'    => !$isPusat,
                'isLockedSpv'       => $isSH
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
        $user = Auth::user();
        $userRole = strtoupper($user->role ?? '');
        $userCabang = strtoupper(trim($user->branch ?? $user->cabang ?? ''));
        
        $isPusat = ($user->is_admin ?? false) || 
                   in_array($userCabang, ['ADMIN', 'PUSAT']) || 
                   in_array($userRole, ['ADMIN', 'OM', 'ADMIN DCA', 'OM DCA']);
                   
        $isBM = ($userRole === 'BM' || $userCabang === 'BM');
        $isSH = ($userRole === 'SH' || $userCabang === 'SH');

        $selectedMonth = $request->input('month', date('n'));
        $selectedYear = $request->input('year', date('Y'));

        if (!$isPusat) {
            $userBranchCode = $this->branchNameToCode[$userCabang] ?? ($user->branch ?? $user->cabang);
            $branchCode = $userBranchCode;
            $spvId = $isSH ? $user->name : $request->input('sales_head', $request->input('SpvEmployeeID', $request->input('spv_id')));
        } else {
            $branchCode = $request->input('branch_manager', $request->input('BranchCode', $request->input('branch_code')));
            $spvId = $request->input('sales_head', $request->input('SpvEmployeeID', $request->input('spv_id')));
            $userBranchCode = null;
        }

        $salesman = $request->input('salesman');
        $fromDate = $request->input('from_date', "{$selectedYear}-" . str_pad($selectedMonth, 2, '0', STR_PAD_LEFT) . "-01");
        $toDate = $request->input('to_date', date('Y-m-t', mktime(0, 0, 0, $selectedMonth, 1, $selectedYear)));

        $data = collect();

        try {
            $bmsQuery = DB::connection('dms')
                ->table('HrEmployee')
                ->select('EmployeeID', 'EmployeeName')
                ->where('Position', 'BM')
                ->where('PersonnelStatus', '1')
                ->where('IsDeleted', '0')
                ->orderBy('EmployeeName');

            if (!$isPusat) {
                $userBranchCode = $this->branchNameToCode[$userCabang] ?? ($user->branch ?? $user->cabang);
                $allowedBmIds = array_keys(array_filter($this->bmBranchCodeMapping, fn($bc) => $bc == $userBranchCode));
                if (!empty($allowedBmIds)) {
                    $bmsQuery->whereIn('EmployeeID', $allowedBmIds);
                }
            }

            $bmsRaw = $bmsQuery->get();

            $bmsMap = [];
            $bmBranchMap = [];
            foreach ($bmsRaw as $bm) {
                $bCode = $this->bmBranchCodeMapping[$bm->EmployeeID] ?? '641940106';
                $bmsMap[$bm->EmployeeID] = [
                    'Name'       => $bm->EmployeeName,
                    'Jabatan'    => 'BM',
                    'BranchCode' => $bCode,
                ];
                $bmBranchMap[$bm->EmployeeID] = $bCode;
            }

            $planCombosQuery = PlanSales::select('BranchCode', 'SpvEmployeeID')
                ->whereNotNull('SpvEmployeeID')
                ->where('SpvEmployeeID', '!=', '')
                ->distinct();

            if (!$isPusat) {
                $userBranchCode = $this->branchNameToCode[$userCabang] ?? ($user->branch ?? $user->cabang);
                $planCombosQuery->where('BranchCode', $userBranchCode);
            }

            $planCombos = $planCombosQuery->get();

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

            $matchingSpvIds = $this->resolveSpvEmployeeIds($spvId, $user, $userBranchCode ?? null);
            $effectiveSpvCode = !empty($matchingSpvIds) ? $matchingSpvIds[0] : $spvId;

            $salesHeadName = '';
            if (!empty($effectiveSpvCode) && isset($spvsMap[$effectiveSpvCode])) {
                $salesHeadName = $spvsMap[$effectiveSpvCode]['Name'];
            }

            if (!empty($branchCode)) {
                // 🔒 Query Data dari tabel omTrSalesLeasing 
                $queryLeasing = DB::connection('dms')->table('omTrSalesLeasing')
                    ->whereNotNull('Leasing')
                    ->where('Leasing', '<>', '');

                if (!empty($fromDate) && !empty($toDate)) {
                    $queryLeasing->whereBetween('CreatedDate', ["{$fromDate} 00:00:00", "{$toDate} 23:59:59"]);
                } else {
                    $queryLeasing->whereMonth('CreatedDate', $selectedMonth)
                                 ->whereYear('CreatedDate', $selectedYear);
                }

                // Filter Branch Manager (Sesuaikan dengan nama / ID BM di Database)
                if (!empty($branchManagerName)) {
                    $queryLeasing->where(function($q) use ($branchCode, $branchManagerName) {
                        $q->where('BMName', $branchManagerName)
                          ->orWhere('BMID', $branchCode)
                          ->orWhere('BMName', 'LIKE', "%{$branchManagerName}%");
                    });
                } else {
                    $queryLeasing->where('BMID', $branchCode);
                }

                $leasingRecords = $queryLeasing->get();

                // 1. Branch Manager Summary Row(s)
                $bmGrouped = $leasingRecords->groupBy(function($item) {
                    return strtoupper(trim($item->Leasing ?? 'TUNAI / CASH'));
                });

                foreach ($bmGrouped as $lName => $items) {
                    $item = new \stdClass();
                    $item->Posisi = 'Branch Manager';
                    $item->Nama = $branchManagerName ?: ($items->first()->BMName ?? 'Branch Manager');
                    $item->Leasing = $lName;
                    $item->total_spk = $items->count();
                    $item->total_do = $items->filter(fn($i) => !empty($i->DONo))->count();
                    $item->total_delivery = $items->filter(fn($i) => !empty($i->DONo))->count();
                    $data->push($item);
                }

                // 2. Sales Head Rows
                $shRecords = $leasingRecords;
                if (!empty($effectiveSpvCode)) {
                    $shRecords = $shRecords->filter(function($i) use ($matchingSpvIds, $effectiveSpvCode, $salesHeadName) {
                        if (!empty($matchingSpvIds) && in_array($i->SalesHeadID, $matchingSpvIds)) return true;
                        if ($i->SalesHeadID == $effectiveSpvCode) return true;
                        if (!empty($salesHeadName) && stripos($i->SalesHeadName ?? '', $salesHeadName) !== false) return true;
                        return false;
                    });
                }

                $shGrouped = $shRecords->filter(fn($i) => !empty($i->SalesHeadName) || !empty($i->SalesHeadID))
                    ->groupBy(function($item) {
                        $shName = trim($item->SalesHeadName ?? $item->SalesHeadID ?? 'Sales Head');
                        return $shName . '|||' . strtoupper(trim($item->Leasing ?? 'TUNAI / CASH'));
                    });

                foreach ($shGrouped as $key => $items) {
                    list($shName, $lName) = explode('|||', $key);
                    $item = new \stdClass();
                    $item->Posisi = 'Sales Head';
                    $item->Nama = $shName;
                    $item->Leasing = $lName;
                    $item->total_spk = $items->count();
                    $item->total_do = $items->filter(fn($i) => !empty($i->DONo))->count();
                    $item->total_delivery = $items->filter(fn($i) => !empty($i->DONo))->count();
                    $data->push($item);
                }

                // 3. Salesmen Rows
                $smFiltered = $shRecords;
                if (!empty($salesman)) {
                    $smFiltered = $smFiltered->filter(function($i) use ($salesman) {
                        return stripos($i->SalesmanID ?? '', $salesman) !== false 
                            || stripos($i->SalesmanName ?? '', $salesman) !== false;
                    });
                }

                $smGrouped = $smFiltered->filter(fn($i) => !empty($i->SalesmanName) || !empty($i->SalesmanID))
                    ->groupBy(function($item) {
                        $smName = trim($item->SalesmanName ?? $item->SalesmanID ?? 'Salesman');
                        return $smName . '|||' . strtoupper(trim($item->Leasing ?? 'TUNAI / CASH'));
                    });

                foreach ($smGrouped as $key => $items) {
                    list($smName, $lName) = explode('|||', $key);
                    $item = new \stdClass();
                    $item->Posisi = 'Salesman';
                    $item->Nama = $smName;
                    $item->Leasing = $lName;
                    $item->total_spk = $items->count();
                    $item->total_do = $items->filter(fn($i) => !empty($i->DONo))->count();
                    $item->total_delivery = $items->filter(fn($i) => !empty($i->DONo))->count();
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
                'SpvEmployeeID'     => $effectiveSpvCode,
                'isLockedBranch'    => !$isPusat,
                'isLockedSpv'       => $isSH
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
        $user = Auth::user();
        $userRole = strtoupper($user->role ?? '');
        $userCabang = strtoupper(trim($user->branch ?? $user->cabang ?? ''));
        
        $isPusat = ($user->is_admin ?? false) || 
                   in_array($userCabang, ['ADMIN', 'PUSAT']) || 
                   in_array($userRole, ['ADMIN', 'OM', 'ADMIN DCA', 'OM DCA']);
        
        $modelClass = class_exists(\App\Models\Sales\vsv\current\ActualSalesforce::class) 
            ? \App\Models\Sales\vsv\current\ActualSalesforce::class 
            : (class_exists(\App\Models\current\ActualSalesforce::class) ? \App\Models\current\ActualSalesforce::class : null);

        if ($modelClass) {
            $query = $modelClass::with('user');
            if (!$isPusat) {
                if (strtoupper($user->role ?? '') === 'BM') {
                    $query->where('cabang', $user->cabang ?? $user->branch ?? '');
                } elseif (strtoupper($user->role ?? '') === 'SH') {
                    $query->where('user_id', $user->id);
                } else {
                    $query->where('cabang', $user->cabang ?? $user->branch ?? '');
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
            // 🔒 Query Live DMS: pmKDP JOIN HrEmployee (DELIVERY + Active Salesforce)
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

                // Sort salesmen by Grade (Platinum -> Gold -> Silver -> Trainee), then by Name
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

        $viewName = view()->exists('sales.vsv.current.actual_do_salesforces.index') 
            ? 'sales.vsv.current.actual_do_salesforces.index' 
            : 'current.actual_do_salesforces.index';

        return view($viewName, compact('data', 'dataByBranch', 'year', 'grandTotal', 'grandTotals', 'grandTotalAll', 'allowedBranches', 'selectedCabang', 'isPusat'));
    }
}