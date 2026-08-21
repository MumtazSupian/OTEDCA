<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\PostCheckAc;
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
        
        // Data dummy untuk dropdown
        $cabangs = ['CIAWI', 'CIANJUR', 'CINERE', 'JATIASIH'];
        
        $teknisis = [
            'CIAWI' => ['Teknisi Ciawi 1', 'Teknisi Ciawi 2'],
            'CIANJUR' => ['Teknisi Cianjur 1', 'Teknisi Cianjur 2'],
            'CINERE' => ['Teknisi Cinere 1', 'Teknisi Cinere 2'],
            'JATIASIH' => ['Teknisi Jatiasih 1', 'Teknisi Jatiasih 2']
        ];
        
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
        
        return view('service.service_ac.ac.post_check', compact('tab', 'postCheckAcs', 'cabangs', 'teknisis', 'sas', 'perawatans'));
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
            
            'pre_high_pressure' => 'nullable|string',
            'pre_low_pressure' => 'nullable|string',
            'pre_suhu_outlet' => 'nullable|string',
            'pre_wind_speed' => 'nullable|string',
            
            'post_high_pressure' => 'nullable|string',
            'post_low_pressure' => 'nullable|string',
            'post_suhu_outlet' => 'nullable|string',
            'post_wind_speed' => 'nullable|string',
            
            'catatan_tambahan' => 'nullable|string',
            'perawatan' => 'nullable|string',
            'penggantian' => 'nullable|string',
            
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
        
        $validated['foto_kendaraan'] = json_encode($fotos);
        $validated['keterangan_foto'] = null; // No longer used separately
        
        $validated['status_approve'] = 'BELUM DIPROSES'; // Default status

        PostCheckAc::create($validated);

        return redirect()->route('service.service-ac.ac.post_check', ['tab' => 'list'])->with('success', 'Data Post Check AC berhasil disimpan!');
    }

    public function edit($id)
    {
        $data = PostCheckAc::findOrFail($id);
        
        $cabangs = ['CIAWI', 'CIANJUR', 'CINERE', 'JATIASIH'];
        $teknisis = [
            'CIAWI' => ['Teknisi Ciawi 1', 'Teknisi Ciawi 2'],
            'CIANJUR' => ['Teknisi Cianjur 1', 'Teknisi Cianjur 2'],
            'CINERE' => ['Teknisi Cinere 1', 'Teknisi Cinere 2'],
            'JATIASIH' => ['Teknisi Jatiasih 1', 'Teknisi Jatiasih 2']
        ];
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

        return view('service.service_ac.ac.post_check_edit', compact('data', 'cabangs', 'teknisis', 'sas', 'perawatans'));
    }

    public function update(Request $request, $id)
    {
        $data = PostCheckAc::findOrFail($id);
        
        $validated = $request->validate([
            'jenis_pemeriksaan' => 'nullable|string',
            'no_polisi' => 'nullable|string',
            'cabang' => 'nullable|string',
            'teknisi' => 'nullable|string',
            'sa' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'tipe_kendaraan' => 'nullable|string',
            'pre_high_pressure' => 'nullable|string',
            'pre_low_pressure' => 'nullable|string',
            'pre_suhu_outlet' => 'nullable|string',
            'pre_wind_speed' => 'nullable|string',
            'post_high_pressure' => 'nullable|string',
            'post_low_pressure' => 'nullable|string',
            'post_suhu_outlet' => 'nullable|string',
            'post_wind_speed' => 'nullable|string',
            'catatan_tambahan' => 'nullable|string',
            'perawatan' => 'nullable|string',
            'penggantian' => 'nullable|string',
            'keterangan_foto' => 'nullable|array',
            'keterangan_foto.*' => 'nullable|string',
            'foto_kendaraan' => 'nullable|array',
            'foto_kendaraan.*' => 'nullable|image|max:8192',
            'existing_foto_keterangan' => 'nullable|array',
        ]);
        
        $fotos = [];
        
        // Keep existing photos if provided (if we build UI to delete them, we can handle it)
        if ($data->foto_kendaraan) {
            $existingFotos = json_decode($data->foto_kendaraan, true) ?? [];
            $updatedKeterangan = $request->input('existing_foto_keterangan', []);
            
            foreach ($existingFotos as $index => $foto) {
                // If the UI sends updated keterangan for existing photos, apply it
                if (isset($updatedKeterangan[$index])) {
                    $foto['keterangan'] = $updatedKeterangan[$index];
                }
                // (In a real app, if they delete from UI we'd filter it out here based on a hidden input array of kept indices)
                $fotos[] = $foto;
            }
        }
        
        // Add new photos
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
        // We will just generate a simple pdf view using dompdf
        if(class_exists('\Barryvdh\DomPDF\Facade\Pdf')) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('service.service_ac.ac.post_check_pdf', compact('data'));
            return $pdf->stream('laporan-post-check-'.$data->no_polisi.'.pdf');
        } else {
            return "DomPDF not installed or configuration error. Please run: composer require barryvdh/laravel-dompdf";
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
}
