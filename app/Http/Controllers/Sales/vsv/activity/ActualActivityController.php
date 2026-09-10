<?php

namespace App\Http\Controllers\Sales\vsv\activity;

use App\Http\Controllers\Controller;
use App\Models\Sales\vsv\activity\ActualActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ActualActivityExport;

class ActualActivityController extends Controller
{
    private function resolveCabangAndUser(Request $request)
    {
        $user = Auth::user();
        $isPusat = (!$user || ($user->is_admin ?? false) || 
                   in_array(strtolower($user->branch ?? ''), ['admin', 'pusat']) ||
                   in_array(strtolower($user->role ?? ''), ['admin', 'om', 'admin dca', 'om dca', 'admin stock', '']));

        $availableCabangs = ['Semua Cabang', 'Ciawi', 'Cianjur', 'Cinere', 'Jatiasih', 'Cipanas'];
        
        $cabangMap = [
            'ciawi'    => 'Ciawi',
            'cianjur'  => 'Cianjur',
            'cinere'   => 'Cinere',
            'jatiasih' => 'Jatiasih',
            'cipanas'  => 'Cipanas',
        ];

        if ($isPusat) {
            $reqCabang = $request->get('cabang');
            if ($reqCabang && in_array($reqCabang, $availableCabangs)) {
                $selectedCabang = $reqCabang;
            } else {
                $selectedCabang = 'Semua Cabang';
            }
        } else {
            $userCabangKey = strtolower(trim($user->cabang ?: ($user->branch ?: 'Ciawi')));
            $selectedCabang = $cabangMap[$userCabangKey] ?? 'Ciawi';
        }

        return [$user, $isPusat, $selectedCabang, $availableCabangs];
    }

    public function index(Request $request)
    {
        list($user, $isPusat, $selectedCabang, $availableCabangs) = $this->resolveCabangAndUser($request);

        // Default Actual: Bulan Kemarin (M-1)
        $defaultMonth = (int)date('n') - 1;
        $defaultYear  = (int)date('Y');
        if ($defaultMonth < 1) {
            $defaultMonth = 12;
            $defaultYear--;
        }

        $currMonthNum = (int)$request->get('bulan', $defaultMonth);
        $currYear = (int)$request->get('tahun', $defaultYear);

        $performanceData = $this->calculatePerformanceData(ActualActivity::class, $selectedCabang, $currMonthNum, $currYear);

        $query = ActualActivity::query();
        if ($selectedCabang !== 'Semua Cabang') {
            $query->where('cabang', $selectedCabang);
        }
        $query->whereYear('tanggal', $currYear)->whereMonth('tanggal', $currMonthNum);
        $data = $query->orderBy('id', 'desc')->get();

        return view('sales.vsv.activity.actual.index', array_merge(
            compact('data', 'selectedCabang', 'availableCabangs', 'currMonthNum', 'currYear', 'isPusat'),
            $performanceData
        ));
    }

    private function calculatePerformanceData($activityModelClass, $selectedCabang, $currMonthNum, $currYear)
    {
        $cacheKey = 'act_perf_' . class_basename($activityModelClass) . '_' . $currYear . '_' . $currMonthNum . '_' . str_replace(' ', '_', strtolower($selectedCabang));

        return Cache::remember($cacheKey, 300, function() use ($selectedCabang, $currMonthNum, $currYear, $activityModelClass) {
            $branchCodeMap = [
                'Ciawi'    => ['641940101'],
                'Cianjur'  => ['641940102'],
                'Cinere'   => ['641940103'],
                'Jatiasih' => ['641940104'],
                'Cipanas'  => ['641940106'],
            ];

            if ($selectedCabang === 'Semua Cabang') {
                $cabangs = ['Ciawi', 'Cianjur', 'Cinere', 'Jatiasih', 'Cipanas'];
            } else {
                $cabangs = [$selectedCabang];
            }

            $allBranchCodes = [];
            foreach ($cabangs as $cb) {
                if (!empty($branchCodeMap[$cb])) {
                    $allBranchCodes = array_merge($allBranchCodes, $branchCodeMap[$cb]);
                }
            }

            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currMonthNum, $currYear);
            $startDateMonth = sprintf("%04d-%02d-01 00:00:00", $currYear, $currMonthNum);
            $endDateMonth   = sprintf("%04d-%02d-%02d 23:59:59", $currYear, $currMonthNum, $daysInMonth);
            $nextMonthStartNum  = ($currMonthNum == 12) ? 1 : ($currMonthNum + 1);
            $nextMonthStartYear = ($currMonthNum == 12) ? ($currYear + 1) : $currYear;
            $nextMonthStartDate = sprintf("%04d-%02d-01 00:00:00", $nextMonthStartYear, $nextMonthStartNum);

            $unitModelPatterns = [
                'NEW CARRY'      => ['NEW CARRY', 'CARRY', 'DC', 'AEV', 'FD', 'WD', 'CHASSIS', 'PU', 'PICK UP', 'BOX', 'MOKO'],
                'APV'            => ['APV BLIND VAN', 'APV', 'GC4', 'VAN', 'GC415'],
                'ERTIGA-HYBRID'  => ['ALL NEW ERTIGA', 'ERTIGA', 'A3L', 'ERTIGA-HYBRID'],
                'NEW XL-7'       => ['XL7', 'XL-7', 'XL 7', 'ZETA', 'BETA', 'ALPHA', 'NEW XL-7'],
                'GRAND-VITARA'   => ['GRAND VITARA', 'VITARA', 'GV', 'GRAND-VITARA'],
                'JIMNY'          => ['JIMNY 3D', 'JIMNY 5D', 'JIMNY', 'JIMMY', 'JB74', 'JB674', '6N415'],
                'FRONX'          => ['FRONX', 'BU4'],
                'S-PRESSO'       => ['S-PRESSO', 'SPRESO', 'S PRESSO', 'DN4'],
            ];

            $activityPatterns = [
                'Call In (dari Iklan)'   => ['CALL IN', 'CALL-IN', 'CALLIN', 'IKLAN', 'TELEPON', 'PHONE', 'TELP'],
                'Canvasing'              => ['CANVASING', 'KANVASING', 'CANVAS', 'FLYERING', 'SEBAR BROSUR', 'BROSUR', 'CANVASING/FLYERING', 'MOVING EXHIBITION', 'MOVEC', 'MO VEC', 'MO-VEC', 'MOVE C', 'MOVING EXPO', 'MOVING'],
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

            $inquiryRecords = collect();
            $doRecords      = collect();
            $spkRecords     = collect();

            try {
                // 1. INQ dari pmKDP
                $qInq = DB::connection('dms')->table('pmKDP as p')
                    ->whereBetween('p.InquiryDate', [$startDateMonth, $endDateMonth]);
                if (!empty($allBranchCodes)) {
                    $qInq->whereIn('p.BranchCode', $allBranchCodes);
                }
                $inquiryRecords = $qInq->select(['p.BranchCode', 'p.TipeKendaraan', 'p.Variant', 'p.InquiryDate', 'p.PerolehanData'])->get();

                // 2. DO dari pmKDP (LastUpdateStatus)
                $qDo = DB::connection('dms')->table('pmKDP')
                    ->where('LastUpdateStatus', '>=', $startDateMonth)
                    ->where('LastUpdateStatus', '<', $nextMonthStartDate)
                    ->where(function($q) {
                        $q->whereIn(DB::raw("UPPER(TRIM(LastProgress))"), ['DELIVERY', 'DO'])
                          ->orWhere('StatusProspek', '60');
                    });
                if (!empty($allBranchCodes)) {
                    $qDo->whereIn('BranchCode', $allBranchCodes);
                }
                $doRecords = $qDo->select(['BranchCode', 'TipeKendaraan', 'Variant', 'LastProgress', 'StatusProspek', 'LastUpdateStatus', 'PerolehanData'])->get();

                // 3. SPK dari pmKDP (Cianjur/Cipanas) & salesAppTable (Ciawi/Cinere/Jatiasih)
                $spkPmkdp = DB::connection('dms')->table('pmKDP')
                    ->whereIn('BranchCode', ['641940102', '641940106'])
                    ->whereBetween('SPKDate', [substr($startDateMonth, 0, 10), substr($endDateMonth, 0, 10)]);
                if (!empty($allBranchCodes)) {
                    $spkPmkdp->whereIn('BranchCode', $allBranchCodes);
                }
                $spkPmkdp = $spkPmkdp->select(['BranchCode', 'InquiryNumber', 'TipeKendaraan', 'Variant', 'SPKDate', 'PerolehanData'])->get();

                $spkSat = DB::connection('dms')->table('salesAppTable as t')
                    ->leftJoin('pmKDP as p', 't.InquiryNumber', '=', 'p.InquiryNumber')
                    ->whereIn('t.BranchCode', ['641940101', '641940103', '641940104'])
                    ->whereNotNull('t.HID')
                    ->where('t.HID', 'like', 'PBK%')
                    ->whereBetween('t.CreationDate', [$startDateMonth, $endDateMonth]);
                if (!empty($allBranchCodes)) {
                    $spkSat->whereIn('t.BranchCode', $allBranchCodes);
                }
                $spkSat = $spkSat->select(['t.BranchCode', 't.InquiryNumber', 'p.TipeKendaraan', 'p.Variant', 't.TipeKendaraan2', 't.CreationDate as SPKDate', 'p.PerolehanData'])->get();

                foreach ($spkPmkdp as $r) {
                    $spkRecords->push((object)[
                        'BranchCode' => $r->BranchCode,
                        'InquiryNumber' => $r->InquiryNumber,
                        'TipeKendaraan' => $r->TipeKendaraan,
                        'Variant' => $r->Variant,
                        'SPKDate' => $r->SPKDate,
                        'PerolehanData' => $r->PerolehanData,
                    ]);
                }
                foreach ($spkSat as $r) {
                    $tipe = trim($r->TipeKendaraan ?? ($r->TipeKendaraan2 ?? ''));
                    if (empty($tipe)) $tipe = trim($r->TipeKendaraan2 ?? '');
                    $spkRecords->push((object)[
                        'BranchCode' => $r->BranchCode,
                        'InquiryNumber' => $r->InquiryNumber,
                        'TipeKendaraan' => $tipe,
                        'Variant' => $r->Variant,
                        'SPKDate' => $r->SPKDate,
                        'PerolehanData' => $r->PerolehanData,
                    ]);
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error("Activity Actual Performance Error: " . $e->getMessage());
            }

            // 4. Activity Records (HANYA input manual untuk bulan & tahun & cabang terpilih)
            $actQuery = $activityModelClass::query()
                ->whereYear('tanggal', $currYear)
                ->whereMonth('tanggal', $currMonthNum);

            if ($selectedCabang !== 'Semua Cabang') {
                $actQuery->where('cabang', $selectedCabang);
            }
            $activityRecords = $actQuery->get();

            // Mapping function ke tepat 1 Model
            $mapToModelFunc = function($tipeStr, $variantStr = '') use ($unitModelPatterns) {
                $fullStr = strtoupper(trim($tipeStr . ' ' . $variantStr));
                if (empty($fullStr)) return null;

                foreach ($unitModelPatterns as $mName => $patterns) {
                    foreach ($patterns as $pat) {
                        if (stripos($fullStr, strtoupper($pat)) !== false) {
                            return $mName;
                        }
                    }
                }
                return null;
            };

            // Mapping function ke tepat 1 Kategori Aktivitas (Sesuai Dashboard V2 Foto 1)
            $mapToActivityFunc = function($perolehanStr) use ($activityPatterns) {
                $str = strtoupper(trim($perolehanStr ?? ''));
                if (empty($str)) return null;

                foreach ($activityPatterns as $sourceName => $patterns) {
                    if (strtoupper($sourceName) === $str) return $sourceName;
                }

                foreach ($activityPatterns as $sourceName => $patterns) {
                    foreach ($patterns as $pat) {
                        if (stripos($str, strtoupper($pat)) !== false) {
                            return $sourceName;
                        }
                    }
                }
                return null;
            };

            // Pre-map DMS records
            $inqByModel = $inquiryRecords->map(fn($r) => $mapToModelFunc($r->TipeKendaraan ?? '', $r->Variant ?? ''))->filter()->countBy();
            $inqByAct   = $inquiryRecords->map(fn($r) => $mapToActivityFunc($r->PerolehanData))->filter()->countBy();

            $spkByModel = $spkRecords->map(fn($r) => $mapToModelFunc($r->TipeKendaraan ?? '', $r->Variant ?? ''))->filter()->countBy();
            $spkByAct   = $spkRecords->map(fn($r) => $mapToActivityFunc($r->PerolehanData))->filter()->countBy();

            $doByModel  = $doRecords->map(fn($r) => $mapToModelFunc($r->TipeKendaraan ?? '', $r->Variant ?? ''))->filter()->countBy();
            $doByAct    = $doRecords->map(fn($r) => $mapToActivityFunc($r->PerolehanData))->filter()->countBy();

            // BY TYPE
            $byTypeData = [];
            $totType = ['qty' => 0, 'inq_act' => 0, 'inq_tgt' => 0, 'spk_act' => 0, 'spk_tgt' => 0, 'do_act' => 0, 'do_tgt' => 0, 'budget' => 0, 'per_spk' => 0];

            foreach ($unitModelPatterns as $mName => $patterns) {
                $matchingAct = $activityRecords->filter(function($item) use ($mName) {
                    return !empty($item->type_unit) && strtoupper(trim($item->type_unit)) === strtoupper($mName);
                });

                $qty    = (int)$matchingAct->sum('jml_sales_shift');
                $budget = (float)$matchingAct->sum('total_cost');
                $inqTgt = (int)$matchingAct->sum('target_p');
                $spkTgt = (int)$matchingAct->sum('target_spk');
                $doTgt  = (int)$matchingAct->sum('target_do');

                $inqAct = $inqByModel->get($mName, 0);
                $spkAct = $spkByModel->get($mName, 0);
                $doAct  = $doByModel->get($mName, 0);

                $perSpk = $spkTgt > 0 ? ($budget / $spkTgt) : 0;

                $byTypeData[$mName] = [
                    'qty'      => $qty,
                    'inq_act'  => $inqAct,
                    'inq_tgt'  => $inqTgt,
                    'spk_act'  => $spkAct,
                    'spk_tgt'  => $spkTgt,
                    'do_act'   => $doAct,
                    'do_tgt'   => $doTgt,
                    'budget'   => $budget,
                    'per_spk'  => $perSpk,
                ];

                $totType['qty'] += $qty;
                $totType['inq_act'] += $inqAct;
                $totType['inq_tgt'] += $inqTgt;
                $totType['spk_act'] += $spkAct;
                $totType['spk_tgt'] += $spkTgt;
                $totType['do_act'] += $doAct;
                $totType['do_tgt'] += $doTgt;
                $totType['budget'] += $budget;
            }
            $totType['per_spk'] = $totType['spk_tgt'] > 0 ? ($totType['budget'] / $totType['spk_tgt']) : 0;

            // BY ACTIVITY
            $byActData = [];
            $totAct = ['qty' => 0, 'inq_act' => 0, 'inq_tgt' => 0, 'spk_act' => 0, 'spk_tgt' => 0, 'do_act' => 0, 'do_tgt' => 0, 'budget' => 0, 'per_spk' => 0];

            foreach ($activityPatterns as $actName => $patterns) {
                $matchingAct = $activityRecords->filter(function($item) use ($actName) {
                    return !empty($item->activity) && strtoupper(trim($item->activity)) === strtoupper($actName);
                });

                $qty    = (int)$matchingAct->sum('jml_sales_shift');
                $budget = (float)$matchingAct->sum('total_cost');
                $inqTgt = (int)$matchingAct->sum('target_p');
                $spkTgt = (int)$matchingAct->sum('target_spk');
                $doTgt  = (int)$matchingAct->sum('target_do');

                $inqAct = $inqByAct->get($actName, 0);
                $spkAct = $spkByAct->get($actName, 0);
                $doAct  = $doByAct->get($actName, 0);

                $perSpk = $spkTgt > 0 ? ($budget / $spkTgt) : 0;

                $byActData[$actName] = [
                    'qty'      => $qty,
                    'inq_act'  => $inqAct,
                    'inq_tgt'  => $inqTgt,
                    'spk_act'  => $spkAct,
                    'spk_tgt'  => $spkTgt,
                    'do_act'   => $doAct,
                    'do_tgt'   => $doTgt,
                    'budget'   => $budget,
                    'per_spk'  => $perSpk,
                ];

                $totAct['qty'] += $qty;
                $totAct['inq_act'] += $inqAct;
                $totAct['inq_tgt'] += $inqTgt;
                $totAct['spk_act'] += $spkAct;
                $totAct['spk_tgt'] += $spkTgt;
                $totAct['do_act'] += $doAct;
                $totAct['do_tgt'] += $doTgt;
                $totAct['budget'] += $budget;
            }
            $totAct['per_spk'] = $totAct['spk_tgt'] > 0 ? ($totAct['budget'] / $totAct['spk_tgt']) : 0;

            return compact('byTypeData', 'totType', 'byActData', 'totAct');
        });
    }

    public function create(Request $request)
    {
        list($user, $isPusat, $selectedCabang, $availableCabangs) = $this->resolveCabangAndUser($request);

        $defaultMonth = (int)date('n') - 1;
        $defaultYear  = (int)date('Y');
        if ($defaultMonth < 1) {
            $defaultMonth = 12;
            $defaultYear--;
        }

        $currMonthNum = (int)$request->get('bulan', $defaultMonth);
        $currYear = (int)$request->get('tahun', $defaultYear);
        $targetFocus = $request->get('target', '');

        $cabang = (!empty($selectedCabang) && $selectedCabang !== 'Semua Cabang') ? $selectedCabang : 'Ciawi';

        // 8 Models Sesuai Foto 4
        $unitModels = [
            'NEW CARRY', 'APV', 'ERTIGA-HYBRID', 'NEW XL-7',
            'GRAND-VITARA', 'JIMNY', 'FRONX', 'S-PRESSO'
        ];

        // 14 Activity Sesuai Dashboard V2 (Foto 1)
        $activityList = [
            'Call In (dari Iklan)', 'Canvasing', 'Data Base', 'Digital Hyperlocal',
            'Digital Non Hyperlocal', 'Exhibition', 'Media Digital', 'Media Elektronik',
            'Mediator', 'Referensi Customer', 'Showroom Activity',
            'Showroom Walk-in', 'Website Dealer', 'Workshop Inquiry'
        ];

        $targetDate = sprintf('%04d-%02d-01', $currYear, $currMonthNum);

        $existingByType = ActualActivity::where('cabang', $cabang)
            ->where('tanggal', $targetDate)
            ->whereNotNull('type_unit')
            ->get()
            ->keyBy('type_unit');

        $existingByAct = ActualActivity::where('cabang', $cabang)
            ->where('tanggal', $targetDate)
            ->whereNotNull('activity')
            ->get()
            ->keyBy('activity');

        return view('sales.vsv.activity.actual.create', compact(
            'user', 'isPusat', 'cabang', 'availableCabangs',
            'currMonthNum', 'currYear', 'targetFocus',
            'unitModels', 'activityList', 'existingByType', 'existingByAct'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $cabang = $request->get('cabang', $user->cabang ?: 'Ciawi');

        $defaultMonth = (int)date('n') - 1;
        $defaultYear  = (int)date('Y');
        if ($defaultMonth < 1) {
            $defaultMonth = 12;
            $defaultYear--;
        }

        $currMonthNum = (int)$request->get('bulan', $defaultMonth);
        $currYear = (int)$request->get('tahun', $defaultYear);
        $targetDate = sprintf('%04d-%02d-01', $currYear, $currMonthNum);

        $targetsType = $request->input('targets_type', []);
        $targetsAct  = $request->input('targets_act', []);

        // 1. Simpan Targets by Type (8 Model)
        foreach ($targetsType as $modelName => $vals) {
            $qtyAct    = (int)($vals['jml_sales_shift'] ?? ($vals['qty'] ?? 0));
            $targetInq = (int)($vals['target_p'] ?? 0);
            $targetSpk = (int)($vals['target_spk'] ?? 0);
            $targetDo  = (int)($vals['target_do'] ?? 0);
            $budgetRaw = str_replace(['Rp', '.', ' '], '', $vals['total_cost'] ?? '0');
            $budget    = (float)$budgetRaw;
            $costSpk   = $targetSpk > 0 ? ($budget / $targetSpk) : 0;

            ActualActivity::updateOrCreate(
                [
                    'cabang'    => $cabang,
                    'type_unit' => $modelName,
                    'tanggal'   => $targetDate,
                ],
                [
                    'user_id'         => $user->id ?? 1,
                    'activity'        => null,
                    'jenis_activity'  => 'Offline',
                    'platform_lokasi' => 'Target Unit',
                    'jenis_unit'      => in_array($modelName, ['NEW CARRY', 'APV']) ? 'Commercial' : 'Passenger',
                    'pic'             => $user->name ?? 'Admin',
                    'jam'             => '00:00:00',
                    'jml_sales_shift' => (string)$qtyAct,
                    'target_p'        => $targetInq,
                    'target_hp'       => 0,
                    'target_spk'      => $targetSpk,
                    'target_do'       => $targetDo,
                    'total_cost'      => $budget,
                    'cost_spk'        => $costSpk,
                ]
            );
        }

        // 2. Simpan Targets by Activity (10 Kategori)
        foreach ($targetsAct as $actName => $vals) {
            $qtyAct    = (int)($vals['jml_sales_shift'] ?? ($vals['qty'] ?? 0));
            $targetInq = (int)($vals['target_p'] ?? 0);
            $targetSpk = (int)($vals['target_spk'] ?? 0);
            $targetDo  = (int)($vals['target_do'] ?? 0);
            $budgetRaw = str_replace(['Rp', '.', ' '], '', $vals['total_cost'] ?? '0');
            $budget    = (float)$budgetRaw;
            $costSpk   = $targetSpk > 0 ? ($budget / $targetSpk) : 0;

            ActualActivity::updateOrCreate(
                [
                    'cabang'   => $cabang,
                    'activity' => $actName,
                    'tanggal'  => $targetDate,
                ],
                [
                    'user_id'         => $user->id ?? 1,
                    'type_unit'       => null,
                    'jenis_activity'  => in_array($actName, ['Media Digital', 'Website Dealer']) ? 'Online' : 'Offline',
                    'platform_lokasi' => 'Target Activity',
                    'jenis_unit'      => 'Passenger',
                    'pic'             => $user->name ?? 'Admin',
                    'jam'             => '00:00:00',
                    'jml_sales_shift' => (string)$qtyAct,
                    'target_p'        => $targetInq,
                    'target_hp'       => 0,
                    'target_spk'      => $targetSpk,
                    'target_do'       => $targetDo,
                    'total_cost'      => $budget,
                    'cost_spk'        => $costSpk,
                ]
            );
        }

        Cache::flush();

        return redirect()->route('activity.actual.index', [
            'cabang' => $cabang,
            'bulan'  => $currMonthNum,
            'tahun'  => $currYear
        ])->with('success', "Target & Budget Cabang {$cabang} Periode {$currMonthNum}/{$currYear} berhasil diperbarui.");
    }

    public function edit(Request $request, $id = null)
    {
        return $this->create($request);
    }

    public function update(Request $request, $id)
    {
        return $this->store($request);
    }

    public function destroy($id)
    {
        $activity = ActualActivity::findOrFail($id);
        $cabang = $activity->cabang;
        $activity->delete();
        Cache::flush();

        return redirect()->route('activity.actual.index', ['cabang' => $cabang])->with('success', 'Data Activity Actual berhasil dihapus');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new ActualActivityExport, 'Actual-Activity.xlsx');
    }

    public function exportPdf(Request $request)
    {
        list($user, $isPusat, $selectedCabang, $availableCabangs) = $this->resolveCabangAndUser($request);

        $defaultMonth = (int)date('n') - 1;
        $defaultYear  = (int)date('Y');
        if ($defaultMonth < 1) {
            $defaultMonth = 12;
            $defaultYear--;
        }

        $currMonthNum = (int)$request->get('bulan', $defaultMonth);
        $currYear = (int)$request->get('tahun', $defaultYear);

        $query = ActualActivity::query();
        if ($selectedCabang !== 'Semua Cabang') {
            $query->where('cabang', $selectedCabang);
        }
        $query->whereYear('tanggal', $currYear)->whereMonth('tanggal', $currMonthNum);
        $data = $query->orderBy('id', 'desc')->get();

        return Pdf::loadView('activity.actual.pdf', compact('data', 'selectedCabang', 'currMonthNum', 'currYear'))
                    ->setPaper('a4', 'landscape')
                    ->download('Laporan-Actual-Activity.pdf');
    }
}