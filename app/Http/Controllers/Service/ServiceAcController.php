<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\ServiceAc;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ServiceAcController extends Controller
{
    /**
     * Menampilkan dashboard monitoring Service AC dengan filter data dari database
     */
    public function monitoring(Request $request)
    {
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

        // 1. Fetch Targets from svMstTarget (Target referensi tahun 2025 sesuai data master DMS)
        $targetYear = 2025;
        $targets = DB::connection('dms')->table('svMstTarget')
            ->where('PeriodYear', $targetYear)
            ->where('PeriodMonth', $m)
            ->whereIn('BranchCode', array_values($branchServiceMap))
            ->get()
            ->keyBy('BranchCode');

        // 2. Fetch Month Service Units from svTrnService (tgl 1 s/d tgl berjalan)
        $monthUnits = DB::connection('dms')->table('svTrnService')
            ->whereYear('JobOrderDate', $y)
            ->whereMonth('JobOrderDate', $m)
            ->whereIn('BranchCode', array_values($branchServiceMap))
            ->select('BranchCode', DB::raw('count(*) as total_bulan'))
            ->groupBy('BranchCode')
            ->get()
            ->keyBy('BranchCode');

        // 3. Fetch Today Service Units from svTrnService (hari ini)
        $isCurrentMonth = ($y == intval(date('Y')) && $m == intval(date('m')));
        $todayUnits = collect();
        if ($isCurrentMonth) {
            $todayUnits = DB::connection('dms')->table('svTrnService')
                ->whereDate('JobOrderDate', date('Y-m-d'))
                ->whereIn('BranchCode', array_values($branchServiceMap))
                ->select('BranchCode', DB::raw('count(*) as total_hari_ini'))
                ->groupBy('BranchCode')
                ->get()
                ->keyBy('BranchCode');
        }

        $soms = ServiceAc::where('periode', $filterDate)->get();
        
        // Mempersiapkan struktur data seperti dummy sebelumnya agar sesuai dengan view
        $dataCabang = [
            'CIAWI' => ['entry' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0], 'spooring' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0], 'ac' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0]],
            'CIANJUR' => ['entry' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0], 'spooring' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0], 'ac' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0]],
            'CINERE' => ['entry' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0], 'spooring' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0], 'ac' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0]],
            'JATIASIH' => ['entry' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0], 'spooring' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0], 'ac' => ['bulan' => 0, 'hari_ini' => 0, 'target' => 0]],
        ];

        foreach ($soms as $som) {
            $cabang = strtoupper($som->cabang);
            if (isset($dataCabang[$cabang])) {
                $dataCabang[$cabang] = [
                    'entry' => ['bulan' => $som->unit_entry_bulan, 'hari_ini' => $som->unit_entry_hari_ini, 'target' => $som->unit_entry_target],
                    'spooring' => ['bulan' => $som->unit_spooring_bulan, 'hari_ini' => $som->unit_spooring_hari_ini, 'target' => $som->unit_spooring_target],
                    'ac' => ['bulan' => $som->unit_ac_bulan, 'hari_ini' => $som->unit_ac_hari_ini, 'target' => $som->unit_ac_target],
                ];
            }
        }

        // Set / Override UNIT ENTRY SERVICE from DMS (svTrnService & svMstTarget)
        foreach ($branchServiceMap as $cabName => $bCode) {
            $targetVal = isset($targets[$bCode]) ? intval($targets[$bCode]->TotalUnitService) : ($dataCabang[$cabName]['entry']['target'] ?? 0);
            $bulanVal = isset($monthUnits[$bCode]) ? intval($monthUnits[$bCode]->total_bulan) : ($dataCabang[$cabName]['entry']['bulan'] ?? 0);
            $hariIniVal = isset($todayUnits[$bCode]) ? intval($todayUnits[$bCode]->total_hari_ini) : ($isCurrentMonth ? 0 : ($dataCabang[$cabName]['entry']['hari_ini'] ?? 0));

            $dataCabang[$cabName]['entry'] = [
                'bulan' => $bulanVal,
                'hari_ini' => $hariIniVal,
                'target' => $targetVal,
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
