<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\PreCheckAc;
use Illuminate\Http\Request;

class PreCheckAcController extends Controller
{
    /**
     * Display a listing of the resource and the form.
     */
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'input'); // default tab is input
        
        $preCheckAcs = PreCheckAc::orderBy('created_at', 'desc')->get();
        
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
            'ONLY TAMBAHAN FREON',
            'ANTI RATS',
            'ENGINE CLEAN',
            'PAKET BERSIH ( E/G CLEAN + ANTI RATS )',
            'HHO'
        ];
        
        return view('service.service_ac.ac.pre_check', compact('tab', 'preCheckAcs', 'cabangs', 'sas', 'perawatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_pemeriksaan' => 'nullable|string',
            'no_polisi' => 'nullable|string',
            'cabang' => 'nullable|string',
            'teknisi' => 'nullable|string',
            'sa' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'tipe_kendaraan' => 'nullable|string',
            
            'high_pressure' => 'nullable|string',
            'low_pressure' => 'nullable|string',
            'suhu_outlet' => 'nullable|string',
            'wind_speed' => 'nullable|string',
            
            'pemeriksaan_tambahan' => 'nullable|string',
            'rekomendasi_perawatan' => 'nullable|string',
            'estimasi_penggantian_part' => 'nullable|string',
            
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
                    $path = $file->store('pre_check_ac', 'public');
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

        PreCheckAc::create($validated);

        return redirect()->route('service.service-ac.ac.pre_check', ['tab' => 'list'])->with('success', 'Data Pre Check AC berhasil disimpan!');
    }

    public function edit($id)
    {
        $data = PreCheckAc::findOrFail($id);
        
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
            'ONLY TAMBAHAN FREON',
            'ANTI RATS',
            'ENGINE CLEAN',
            'PAKET BERSIH ( E/G CLEAN + ANTI RATS )',
            'HHO'
        ];

        return view('service.service_ac.ac.pre_check_edit', compact('data', 'cabangs', 'sas', 'perawatans'));
    }

    public function update(Request $request, $id)
    {
        $data = PreCheckAc::findOrFail($id);
        
        $validated = $request->validate([
            'jenis_pemeriksaan' => 'nullable|string',
            'no_polisi' => 'nullable|string',
            'cabang' => 'nullable|string',
            'teknisi' => 'nullable|string',
            'sa' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'tipe_kendaraan' => 'nullable|string',
            'high_pressure' => 'nullable|string',
            'low_pressure' => 'nullable|string',
            'suhu_outlet' => 'nullable|string',
            'wind_speed' => 'nullable|string',
            'pemeriksaan_tambahan' => 'nullable|string',
            'rekomendasi_perawatan' => 'nullable|string',
            'estimasi_penggantian_part' => 'nullable|string',
            'keterangan_foto' => 'nullable|array',
            'keterangan_foto.*' => 'nullable|string',
            'foto_kendaraan' => 'nullable|array',
            'foto_kendaraan.*' => 'nullable|image|max:8192',
            'existing_foto_keterangan' => 'nullable|array',
        ]);
        
        $fotos = [];
        
        if ($data->foto_kendaraan) {
            $existingFotos = json_decode($data->foto_kendaraan, true) ?? [];
            if (!is_array($existingFotos)) {
                $existingFotos = [['path' => $data->foto_kendaraan, 'keterangan' => $data->keterangan_foto]];
            }
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
                    $path = $file->store('pre_check_ac', 'public');
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

        return redirect()->route('service.service-ac.ac.pre_check', ['tab' => 'list'])->with('success', 'Data Pre Check AC berhasil diupdate!');
    }

    public function pdf($id)
    {
        $data = PreCheckAc::findOrFail($id);
        if(class_exists('\Barryvdh\DomPDF\Facade\Pdf')) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('service.service_ac.ac.pre_check_pdf', compact('data'));
            return $pdf->stream('laporan-pre-check-'.$data->no_polisi.'.pdf');
        } else {
            return "DomPDF not installed or configuration error.";
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $data = PreCheckAc::findOrFail($id);
        
        $request->validate([
            'status' => 'required|string|in:DIKERJAKAN,TIDAK DIKERJAKAN'
        ]);
        
        $data->status_approve = $request->status;
        $data->save();
        
        return back()->with('success', 'Status Approve berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = PreCheckAc::findOrFail($id);
        $data->delete();
        
        return redirect()->route('service.service-ac.ac.pre_check', ['tab' => 'list'])->with('success', 'Data Pre Check AC berhasil dihapus!');
    }
}
