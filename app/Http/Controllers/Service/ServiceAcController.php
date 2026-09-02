<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\ServiceAc;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ServiceAcController extends Controller
{
    /**
     * Menampilkan dashboard monitoring Service AC dengan filter data dari database
     */
    public function monitoring(Request $request)
    {
        $user = auth()->user();
        if ($user && ($user->role === 'ho_unit' || strtolower($user->email ?? '') === 'dcahounit')) {
            return redirect()->route('sales.dashboard');
        }

        // Default filter bulan ini
        $filterDate = $request->input('periode', date('Y-m-01'));
        $carbonDate = Carbon::parse($filterDate);
        $y = intval($carbonDate->format('Y'));
        $m = intval($carbonDate->format('m'));
        
        $branchServiceMap = [
            'CIAWI' => '641940101',
            'CIANJUR' => '641940102',
            'CINERE' => '641940103',
            'JATIASIH' => '641940104',
        ];

        $isCurrentMonth = ($y == intval(date('Y')) && $m == intval(date('m')));

        $targets = collect();
        $monthUnits = collect();
        $todayUnits = collect();
        $spooringMonthRows = collect();
        $spooringTodayRows = collect();
        $acMonthRows = collect();
        $acTodayRows = collect();

        try {
            // 1. Fetch Targets for Unit Entry from svMstTarget
            $targetYear = $y;
            $targets = DB::connection('dms')->table('svMstTarget')
                ->where('PeriodYear', $targetYear)
                ->where('PeriodMonth', $m)
                ->whereIn('BranchCode', array_values($branchServiceMap))
                ->get()
                ->keyBy('BranchCode');

            // 2. Fetch Month Service Units from svTrnService (Unit Entry)
            $monthUnits = DB::connection('dms')->table('svTrnService')
                ->whereYear('JobOrderDate', $y)
                ->whereMonth('JobOrderDate', $m)
                ->whereIn('BranchCode', array_values($branchServiceMap))
                ->where(function($q) {
                    $q->whereNull('JobType')
                      ->orWhere('JobType', '!=', 'PDI');
                })
                ->select('BranchCode', DB::raw('count(*) as total_bulan'))
                ->groupBy('BranchCode')
                ->get()
                ->keyBy('BranchCode');

            // 3. Fetch Today Service Units from svTrnService (Unit Entry)
            if ($isCurrentMonth) {
                $todayUnits = DB::connection('dms')->table('svTrnService')
                    ->whereDate('JobOrderDate', date('Y-m-d'))
                    ->whereIn('BranchCode', array_values($branchServiceMap))
                    ->where(function($q) {
                        $q->whereNull('JobType')
                          ->orWhere('JobType', '!=', 'PDI');
                    })
                    ->select('BranchCode', DB::raw('count(*) as total_hari_ini'))
                    ->groupBy('BranchCode')
                    ->get()
                    ->keyBy('BranchCode');
            }

            // 4. Fetch UNIT SPOORING from svTrnPoSubCon
            // Ciawi (641940101), Cinere (641940103), Jatiasih (641940104) => 00007134, 00006763
            // Cianjur (641940102) => 00007542
            $spooringMonthRows = DB::connection('dms')->table('svTrnPoSubCon')
                ->whereYear('JobOrderDate', $y)
                ->whereMonth('JobOrderDate', $m)
                ->where(function($q) {
                    $q->where(function($sub) {
                        $sub->whereIn('BranchCode', ['641940101', '641940103', '641940104'])
                            ->whereIn('SupplierCode', ['00007134', '00006763']);
                    })->orWhere(function($sub) {
                        $sub->where('BranchCode', '641940102')
                            ->where('SupplierCode', '00007542');
                    });
                })
                ->select('BranchCode', DB::raw('count(distinct JobOrderNo) as total_bulan'))
                ->groupBy('BranchCode')
                ->get()
                ->keyBy('BranchCode');

            if ($isCurrentMonth) {
                $spooringTodayRows = DB::connection('dms')->table('svTrnPoSubCon')
                    ->whereDate('JobOrderDate', date('Y-m-d'))
                    ->where(function($q) {
                        $q->where(function($sub) {
                            $sub->whereIn('BranchCode', ['641940101', '641940103', '641940104'])
                                ->whereIn('SupplierCode', ['00007134', '00006763']);
                        })->orWhere(function($sub) {
                            $sub->where('BranchCode', '641940102')
                                ->where('SupplierCode', '00007542');
                        });
                    })
                    ->select('BranchCode', DB::raw('count(distinct JobOrderNo) as total_hari_ini'))
                    ->groupBy('BranchCode')
                    ->get()
                    ->keyBy('BranchCode');
            }

            // 5. Fetch UNIT AC from svTrnPoSubCon
            // All branches => 00009684, 00009681, 00009676
            $acSuppliers = ['00009684', '00009681', '00009676'];

            $acMonthRows = DB::connection('dms')->table('svTrnPoSubCon')
                ->whereYear('JobOrderDate', $y)
                ->whereMonth('JobOrderDate', $m)
                ->whereIn('BranchCode', array_values($branchServiceMap))
                ->whereIn('SupplierCode', $acSuppliers)
                ->select('BranchCode', DB::raw('count(distinct JobOrderNo) as total_bulan'))
                ->groupBy('BranchCode')
                ->get()
                ->keyBy('BranchCode');

            if ($isCurrentMonth) {
                $acTodayRows = DB::connection('dms')->table('svTrnPoSubCon')
                    ->whereDate('JobOrderDate', date('Y-m-d'))
                    ->whereIn('BranchCode', array_values($branchServiceMap))
                    ->whereIn('SupplierCode', $acSuppliers)
                    ->select('BranchCode', DB::raw('count(distinct JobOrderNo) as total_hari_ini'))
                    ->groupBy('BranchCode')
                    ->get()
                    ->keyBy('BranchCode');
            }
        } catch (\Throwable $e) {}

        $dataCabang = [
            'CIAWI' => ['entry' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0], 'spooring' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 80], 'ac' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 80]],
            'CIANJUR' => ['entry' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0], 'spooring' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 80], 'ac' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 80]],
            'CINERE' => ['entry' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0], 'spooring' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 80], 'ac' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 80]],
            'JATIASIH' => ['entry' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0], 'spooring' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 80], 'ac' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 80]],
        ];

        foreach ($branchServiceMap as $cabName => $bCode) {
            $targetVal = isset($targets[$bCode]) ? intval($targets[$bCode]->TotalUnitService) : 0;
            $bulanVal = isset($monthUnits[$bCode]) ? intval($monthUnits[$bCode]->total_bulan) : 0;
            $hariIniVal = isset($todayUnits[$bCode]) ? intval($todayUnits[$bCode]->total_hari_ini) : 0;

            $spooringBulanVal = isset($spooringMonthRows[$bCode]) ? intval($spooringMonthRows[$bCode]->total_bulan) : 0;
            $spooringHariIniVal = isset($spooringTodayRows[$bCode]) ? intval($spooringTodayRows[$bCode]->total_hari_ini) : 0;

            $acBulanVal = isset($acMonthRows[$bCode]) ? intval($acMonthRows[$bCode]->total_bulan) : 0;
            $acHariIniVal = isset($acTodayRows[$bCode]) ? intval($acTodayRows[$bCode]->total_hari_ini) : 0;

            $dataCabang[$cabName] = [
                'entry' => [
                    'bulan' => $bulanVal,
                    'hari_ini' => $hariIniVal,
                    'target' => $targetVal,
                ],
                'spooring' => [
                    'bulan' => $spooringBulanVal,
                    'hari_ini' => $spooringHariIniVal,
                    'target' => 80,
                ],
                'ac' => [
                    'bulan' => $acBulanVal,
                    'hari_ini' => $acHariIniVal,
                    'target' => 80,
                ],
            ];
        }

        // Untuk dropdown filter (tampilkan 12 bulan terakhir)
        $availableDates = collect();
        for ($i = 0; $i < 12; $i++) {
            $date = Carbon::now()->subMonths($i)->format('Y-m-01');
            $availableDates->push([
                'value' => $date,
                'label' => Carbon::parse($date)->translatedFormat('F Y')
            ]);
        }

        $user = Auth::user();
        $isPusat = $user && ($user->is_admin || strtolower($user->role ?? '') === 'om' || empty($user->branch));
        $cabang = $user ? strtolower($user->branch ?? '') : '';
        if ($cabang === 'bp') {
            $cabang = 'jatiasih';
        }

        if (!$isPusat && !empty($cabang)) {
            $myCabang = strtoupper($cabang);
            if (isset($dataCabang[$myCabang])) {
                $dataCabang = [$myCabang => $dataCabang[$myCabang]];
            } else {
                $dataCabang = [];
            }
        }

        return view('service.service_ac.monitoring', [
            'dataCabang' => $dataCabang,
            'availableDates' => $availableDates,
            'currentFilter' => $filterDate
        ]);
    }

    /**
     * Menampilkan daftar data CRUD (Tabel)
     */
    public function index(Request $request)
    {
        $query = ServiceAc::query();
        
        if ($request->has('periode') && $request->periode != '') {
            $query->where('periode', $request->periode);
        } else {
            // Default filter ke bulan paling baru
            $latestPeriode = ServiceAc::max('periode');
            if ($latestPeriode) {
                $query->where('periode', $latestPeriode);
                $request->merge(['periode' => $latestPeriode]); // Update request var untuk view
            }
        }
        
        $serviceAcs = $query->orderBy('cabang')->get();
        
        $availableDates = ServiceAc::select('periode')->distinct()->orderBy('periode', 'desc')->get()->pluck('periode')->map(function($date) {
            return [
                'value' => $date,
                'label' => Carbon::parse($date)->translatedFormat('F Y')
            ];
        });

        return view('service.service_ac.index', compact('serviceAcs', 'availableDates'));
    }

    /**
     * Menampilkan form tambah data
     */
    public function create()
    {
        return view('service.service_ac.create');
    }

    /**
     * Menyimpan data baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'cabang' => 'required|string',
            'periode' => 'required|date',
            'unit_entry_bulan' => 'nullable|integer',
            'unit_entry_hari_ini' => 'nullable|integer',
            'unit_entry_target' => 'nullable|integer',
            'unit_spooring_bulan' => 'nullable|integer',
            'unit_spooring_hari_ini' => 'nullable|integer',
            'unit_spooring_target' => 'nullable|integer',
            'unit_ac_bulan' => 'nullable|integer',
            'unit_ac_hari_ini' => 'nullable|integer',
            'unit_ac_target' => 'nullable|integer',
        ]);

        // Cek apakah data untuk cabang dan periode tersebut sudah ada
        $exists = ServiceAc::where('cabang', $request->cabang)
                     ->where('periode', $request->periode)
                     ->first();
                     
        if ($exists) {
            return redirect()->back()->with('error', 'Data untuk cabang ' . $request->cabang . ' pada periode ' . Carbon::parse($request->periode)->translatedFormat('F Y') . ' sudah ada! Silakan gunakan fitur Edit.')->withInput();
        }

        ServiceAc::create($request->all());

        return redirect()->route('service.service-ac.data.index', ['periode' => $request->periode])->with('success', 'Data Service AC berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit data
     */
    public function edit(ServiceAc $data)
    {
        return view('service.service_ac.edit', ['serviceAc' => $data]);
    }

    /**
     * Menyimpan perubahan data
     */
    public function update(Request $request, ServiceAc $data)
    {
        $request->validate([
            'cabang' => 'required|string',
            'periode' => 'required|date',
            'unit_entry_bulan' => 'nullable|integer',
            'unit_entry_hari_ini' => 'nullable|integer',
            'unit_entry_target' => 'nullable|integer',
            'unit_spooring_bulan' => 'nullable|integer',
            'unit_spooring_hari_ini' => 'nullable|integer',
            'unit_spooring_target' => 'nullable|integer',
            'unit_ac_bulan' => 'nullable|integer',
            'unit_ac_hari_ini' => 'nullable|integer',
            'unit_ac_target' => 'nullable|integer',
        ]);

        $data->update($request->all());

        return redirect()->route('service.service-ac.data.index', ['periode' => $request->periode])->with('success', 'Data Service AC berhasil diperbarui!');
    }

    /**
     * Menghapus data
     */
    public function destroy(ServiceAc $data)
    {
        $periode = $data->periode;
        $data->delete();
        return redirect()->route('service.service-ac.data.index', ['periode' => $periode])->with('success', 'Data Service AC berhasil dihapus!');
    }

    /**
     * Display POST CHECK AC page
     */
    public function postCheckAc()
    {
        return view('service.service_ac.ac.post_check');
    }

    /**
     * Display PRE CHECK AC page
     */
    public function preCheckAc()
    {
        return view('service.service_ac.ac.pre_check');
    }

}
