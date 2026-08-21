<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\PostCheckAc;
use App\Models\Teknisi;
use Illuminate\Http\Request;

class PostCheckAcController extends Controller
{
    /**
     * Display a listing of the resource and the form.
     */
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'input'); // default tab is input
        
        $postCheckAcs = PostCheckAc::orderBy('created_at', 'desc')->get();
        $teknisis = Teknisi::orderBy('nama', 'asc')->get();
        
        // Data dummy untuk dropdown
        $cabangs = ['CIAWI', 'CIANJUR', 'CINERE', 'JATIASIH'];
        
        $sas = [
            'CIAWI' => ['Asep Mulyadi', 'Rahmat', 'Nana'],
            'CIANJUR' => ['SA Cianjur 1', 'SA Cianjur 2'],
            'CINERE' => ['SA Cinere 1', 'SA Cinere 2'],
            'JATIASIH' => ['SA Jatiasih 1', 'SA Jatiasih 2']
        ];
        
        $perawatans = [
            'OZONE',
            'CABIN COMPARTEMENT',
            'CONDENSOR CLEANER',
            'SUPER LIGHT',
            'SUPER LIGHT PLUS',
            'LIGHT SERVICE - SINGLE BLOWER',
            'LIGHT SERVICE - DOUBLE BLOWER',
            'HEAVY SERVICE - SINGLE BLOWER',
            'HEAVY - SERVICE - DOUBLE BLOWER',
            'BONGKAR PASANG COMPRESSOR - MAGNET DILUAR FREON',
            'BONGKAR PASANG CONDENSOR - INC PIPA DILUAR FREON',
            'BONGKAR PASANG MOTOR FAN',
            'JASA GANTI PIPA - TANPA BONGKAR COMPRESSOR',
            'VACUM ISI FREON + OLI SINGLE',
            'VACUM ISI FREON + OLI DOUBLE',
            'FLUSHING + OLI SINGLE',
            'FLUSHING + OLI DOUBLE',
            'GANTI EVAPORATOR SINGLE BLOWER',
            'GANTI EVAPORATOR DOUBLE BLOWER',
            'GANTI EXPANDSI SINGLE BLOWER',
            'GANTI EXPANDSI DOUBLE BLOWER',
            'GANTI FILTER DRYER',
            'GANTI FILTER CABIN',
            'LAINNYA',
        ];
        
        return view('service.service_ac.ac.post_check', compact('tab', 'postCheckAcs', 'cabangs', 'teknisis', 'sas', 'perawatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_pemeriksaan' => 'nullable|string',
            'no_spk' => 'nullable|string',
            'no_polisi' => 'nullable|string',
            'cabang' => 'nullable|string',
            'teknisi' => 'nullable|string',
            'sa' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'tipe_kendaraan' => 'nullable|string',
            
            'post_high_pressure' => 'nullable|string',
            'post_low_pressure' => 'nullable|string',
            'post_suhu_outlet' => 'nullable|string',
            'post_wind_speed' => 'nullable|string',
            
            'pemeriksaan_tambahan' => 'nullable|string',
            'pekerjaan_dilakukan' => 'nullable|string',
            'pekerjaan_disarankan' => 'nullable|string',
            'status_pekerjaan' => 'nullable|string',
            'catatan' => 'nullable|string',
            
            'keterangan_foto' => 'nullable|array',
            'keterangan_foto.*' => 'nullable|string',
            'foto_kendaraan' => 'nullable|array',
            'foto_kendaraan.*' => 'nullable|image|max:8192',
        ]);
        
        $fotos = [];
        if ($request->hasFile('foto_kendaraan')) {
            $files = $request->file('foto_kendaraan');
            $keterangans = $request->input('keterangan_foto', []);
            
            foreach ($files as $index => $file) {
                if ($file) {
                    $path = $file->store('post_check_ac', 'public');
                    $fotos[] = [
                        'path' => 'storage/' . $path,
                        'keterangan' => $keterangans[$index] ?? 'KETERANGAN FOTO'
                    ];
                }
            }
        }
        
        $validated['foto_kendaraan'] = count($fotos) > 0 ? json_encode($fotos) : null;
        $validated['keterangan_foto'] = null;
        
        $validated['status_approve'] = 'BELUM DIPROSES';

        PostCheckAc::create($validated);

        return redirect()->route('service.service-ac.ac.post_check', ['tab' => 'list'])->with('success', 'Data Post Check AC berhasil disimpan!');
    }

    public function edit($id)
    {
        $data = PostCheckAc::findOrFail($id);
        
        $teknisis = Teknisi::orderBy('nama', 'asc')->get();
        $cabangs = ['CIAWI', 'CIANJUR', 'CINERE', 'JATIASIH'];
        $sas = [
            'CIAWI' => ['Asep Mulyadi', 'Rahmat', 'Nana'],
            'CIANJUR' => ['SA Cianjur 1', 'SA Cianjur 2'],
            'CINERE' => ['SA Cinere 1', 'SA Cinere 2'],
            'JATIASIH' => ['SA Jatiasih 1', 'SA Jatiasih 2']
        ];
        $perawatans = [
            'OZONE',
            'CABIN COMPARTEMENT',
            'CONDENSOR CLEANER',
            'SUPER LIGHT',
            'SUPER LIGHT PLUS',
            'LIGHT SERVICE - SINGLE BLOWER',
            'LIGHT SERVICE - DOUBLE BLOWER',
            'HEAVY SERVICE - SINGLE BLOWER',
            'HEAVY - SERVICE - DOUBLE BLOWER',
            'BONGKAR PASANG COMPRESSOR - MAGNET DILUAR FREON',
            'BONGKAR PASANG CONDENSOR - INC PIPA DILUAR FREON',
            'BONGKAR PASANG MOTOR FAN',
            'JASA GANTI PIPA - TANPA BONGKAR COMPRESSOR',
            'VACUM ISI FREON + OLI SINGLE',
            'VACUM ISI FREON + OLI DOUBLE',
            'FLUSHING + OLI SINGLE',
            'FLUSHING + OLI DOUBLE',
            'GANTI EVAPORATOR SINGLE BLOWER',
            'GANTI EVAPORATOR DOUBLE BLOWER',
            'GANTI EXPANDSI SINGLE BLOWER',
            'GANTI EXPANDSI DOUBLE BLOWER',
            'GANTI FILTER DRYER',
            'GANTI FILTER CABIN',
            'LAINNYA',
        ];

        return view('service.service_ac.ac.post_check_edit', compact('data', 'cabangs', 'teknisis', 'sas', 'perawatans'));
    }

    public function update(Request $request, $id)
    {
        $data = PostCheckAc::findOrFail($id);
        
        $validated = $request->validate([
            'jenis_pemeriksaan' => 'nullable|string',
            'no_spk' => 'nullable|string',
            'no_polisi' => 'nullable|string',
            'cabang' => 'nullable|string',
            'teknisi' => 'nullable|string',
            'sa' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'tipe_kendaraan' => 'nullable|string',
            'post_high_pressure' => 'nullable|string',
            'post_low_pressure' => 'nullable|string',
            'post_suhu_outlet' => 'nullable|string',
            'post_wind_speed' => 'nullable|string',
            'pemeriksaan_tambahan' => 'nullable|string',
            'pekerjaan_dilakukan' => 'nullable|string',
            'pekerjaan_disarankan' => 'nullable|string',
            'status_pekerjaan' => 'nullable|string',
            'catatan' => 'nullable|string',
            'keterangan_foto' => 'nullable|array',
            'keterangan_foto.*' => 'nullable|string',
            'foto_kendaraan' => 'nullable|array',
            'foto_kendaraan.*' => 'nullable|image|max:8192',
            'existing_foto_keterangan' => 'nullable|array',
        ]);
        
        $fotos = [];
        
        if ($data->foto_kendaraan) {
            $existingFotos = json_decode($data->foto_kendaraan, true) ?? [];
            $updatedKeterangan = $request->input('existing_foto_keterangan', []);
            
            foreach ($existingFotos as $index => $foto) {
                if (isset($updatedKeterangan[$index])) {
                    $foto['keterangan'] = $updatedKeterangan[$index];
                }
                $fotos[] = $foto;
            }
        }
        
        if ($request->hasFile('foto_kendaraan')) {
            $files = $request->file('foto_kendaraan');
            $keterangans = $request->input('keterangan_foto', []);
            
            foreach ($files as $index => $file) {
                if ($file) {
                    $path = $file->store('post_check_ac', 'public');
                    $fotos[] = [
                        'path' => 'storage/' . $path,
                        'keterangan' => $keterangans[$index] ?? 'KETERANGAN FOTO'
                    ];
                }
            }
        }
        
        $validated['foto_kendaraan'] = json_encode($fotos);
        $validated['keterangan_foto'] = null;

        $data->update($validated);

        return redirect()->route('service.service-ac.ac.post_check', ['tab' => 'list'])->with('success', 'Data Post Check AC berhasil diupdate!');
    }

    public function updateStatus(Request $request, $id)
    {
        $data = PostCheckAc::findOrFail($id);
        
        $request->validate([
            'status' => 'required|string|in:DIKERJAKAN,TIDAK DIKERJAKAN'
        ]);
        
        $data->status_approve = $request->status;
        $data->save();
        
        return back()->with('success', 'Status Approve berhasil diubah!');
    }

    public function pdf($id)
    {
        $data = PostCheckAc::findOrFail($id);
        if(class_exists('\Barryvdh\DomPDF\Facade\Pdf')) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('service.service_ac.ac.post_check_pdf', compact('data'));
            return $pdf->stream('laporan-post-check-'.$data->no_polisi.'.pdf');
        } else {
            return "DomPDF not installed or configuration error.";
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = PostCheckAc::findOrFail($id);
        $data->delete();
        
        return redirect()->route('service.service-ac.ac.post_check', ['tab' => 'list'])->with('success', 'Data Post Check AC berhasil dihapus!');
    }

    /**
     * API untuk mendapatkan data detail SPK dari DMS berdasarkan No SPK
     */
    public function getSpkData(Request $request)
    {
        try {
            $no_spk = $request->query('no_spk');
            if (!$no_spk) {
                return response()->json(['success' => false, 'message' => 'No SPK tidak boleh kosong']);
            }
            
            $spk = \Illuminate\Support\Facades\DB::connection('dms')->table('svTrnService')
                ->leftJoin('gnMstEmployee', 'svTrnService.ForemanID', '=', 'gnMstEmployee.EmployeeID')
                ->where('svTrnService.JobOrderNo', $no_spk)
                ->select(
                    'svTrnService.JobOrderNo',
                    'svTrnService.BranchCode',
                    'svTrnService.PoliceRegNo',
                    'svTrnService.BasicModel',
                    'svTrnService.JobOrderDate',
                    'svTrnService.ForemanID',
                    'gnMstEmployee.EmployeeName'
                )
                ->first();
                
            if ($spk) {
                $branchMap = [
                    '641940101' => 'CIAWI',
                    '641940102' => 'CIANJUR',
                    '641940103' => 'CINERE',
                    '641940104' => 'JATIASIH',
                    '641940105' => 'BODY REPAIR',
                    '641940106' => 'CIPANAS',
                ];
                
                $branchName = $branchMap[$spk->BranchCode] ?? $spk->BranchCode;
                
                // Cari nama SA: jika ada di gnMstEmployee pakai EmployeeName, jika tidak ada fallback ke ForemanID agar tidak kosong
                $saName = '';
                if (!empty($spk->EmployeeName)) {
                    $saName = $spk->EmployeeName;
                } elseif (!empty($spk->ForemanID)) {
                    $cleanId = trim($spk->ForemanID, "' \t\n\r\0\x0B");
                    $varId = str_replace('.00.', '.0', $cleanId);
                    $emp = \Illuminate\Support\Facades\DB::connection('dms')->table('gnMstEmployee')
                        ->where('EmployeeID', $cleanId)
                        ->orWhere('EmployeeID', $varId)
                        ->first();
                    if ($emp && !empty($emp->EmployeeName)) {
                        $saName = $emp->EmployeeName;
                    } else {
                        $saName = $spk->ForemanID;
                    }
                }
                
                $tipeKendaraan = $spk->BasicModel;
                if (!empty($spk->BasicModel)) {
                    $cleanBasic = explode('-', trim($spk->BasicModel))[0];
                    $modelInfo = \Illuminate\Support\Facades\DB::connection('dms')->table('omMstModel')
                        ->where('BasicModel', $spk->BasicModel)
                        ->orWhere('BasicModel', $cleanBasic)
                        ->orWhere('BasicModel', 'like', $cleanBasic . '%')
                        ->select('GroupCode', 'SalesModelDesc')
                        ->first();
                    
                    if ($modelInfo) {
                        $group = trim($modelInfo->GroupCode ?? '');
                        if (!empty($group) && !in_array(strtoupper($group), ['OTHERS', 'OTHER'])) {
                            $tipeKendaraan = $group;
                        } elseif (!empty($modelInfo->SalesModelDesc)) {
                            $tipeKendaraan = trim($modelInfo->SalesModelDesc);
                        }
                    }
                }

                $jobDate = !empty($spk->JobOrderDate) ? substr($spk->JobOrderDate, 0, 10) : '';

                return response()->json([
                    'success' => true,
                    'data' => [
                        'JobOrderNo'   => $spk->JobOrderNo,
                        'BranchCode'   => $branchName,
                        'PoliceRegNo'  => $spk->PoliceRegNo,
                        'BasicModel'   => $tipeKendaraan,
                        'JobOrderDate' => $jobDate,
                        'EmployeeName' => $saName,
                    ]
                ]);
            }
            
            return response()->json(['success' => false, 'message' => 'SPK tidak ditemukan']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal terhubung ke server DMS ('.$e->getMessage().')']);
        }
    }

    /**
     * API untuk mendapatkan list SPK bulan ini dari DMS
     */
    public function getSpkList(Request $request)
    {
        try {
            $month = date('m');
            $year = date('Y');
            
            $branchMap = [
                '641940101' => 'CIAWI',
                '641940102' => 'CIANJUR',
                '641940103' => 'CINERE',
                '641940104' => 'JATIASIH',
                '641940105' => 'BODY REPAIR',
                '641940106' => 'CIPANAS',
            ];

            $spkList = \Illuminate\Support\Facades\DB::connection('dms')->table('svTrnService')
                ->whereMonth('JobOrderDate', $month)
                ->whereYear('JobOrderDate', $year)
                ->select('JobOrderNo', 'BranchCode', 'PoliceRegNo', 'BasicModel', 'JobOrderDate')
                ->orderBy('JobOrderDate', 'desc')
                ->limit(500)
                ->get();
            
            $allBasics = $spkList->pluck('BasicModel')->filter()->unique()->toArray();
            $cleanBasics = array_map(fn($b) => explode('-', trim($b))[0], $allBasics);

            $modelMap = [];
            if (!empty($allBasics)) {
                $modelMap = \Illuminate\Support\Facades\DB::connection('dms')->table('omMstModel')
                    ->whereIn('BasicModel', array_merge($allBasics, $cleanBasics))
                    ->select('BasicModel', 'GroupCode', 'SalesModelDesc')
                    ->get()
                    ->groupBy('BasicModel')
                    ->map(function($rows) {
                        $first = $rows->first();
                        $group = trim($first->GroupCode ?? '');
                        if (!empty($group) && !in_array(strtoupper($group), ['OTHERS', 'OTHER'])) {
                            return $group;
                        }
                        return trim($first->SalesModelDesc ?? ($first->BasicModel ?? ''));
                    });
            }
            
            foreach ($spkList as $item) {
                if (isset($branchMap[$item->BranchCode])) {
                    $item->BranchName = $branchMap[$item->BranchCode];
                } else {
                    $item->BranchName = $item->BranchCode;
                }

                $b = trim($item->BasicModel ?? '');
                $cleanB = explode('-', $b)[0];
                $item->BasicModel = $modelMap[$b] ?? ($modelMap[$cleanB] ?? $b);
            }
            
            return response()->json(['success' => true, 'data' => $spkList]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal terhubung ke server DMS ('.$e->getMessage().')']);
        }
    }
}
