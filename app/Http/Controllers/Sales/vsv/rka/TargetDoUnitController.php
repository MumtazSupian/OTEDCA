<?php

namespace App\Http\Controllers\Sales\vsv\rka;

use App\Http\Controllers\Controller;
use App\Models\Sales\vsv\rka\TargetDoUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TargetDoUnitExport;

class TargetDoUnitController extends Controller
{
    // --- PRIVATE METHODS (HELPER) ---

        private function getFilteredQuery()
    {
        $user = Auth::user();
        $query = \App\Models\Sales\vsv\rka\TargetDoUnit::query();

        if (!$user || $user->is_admin || $user->is_admin_stock || in_array(strtolower($user->role ?? ''), ['admin', 'om', 'admin dca', 'om dca', 'admin stock', ''])) {
            return $query->orderBy('id', 'desc');
        }

        $cabang = $user->cabang ?: ($user->branch ?: 'Ciawi');
        return $query->where('cabang', $cabang)->orderBy('id', 'desc');
    }

    

    public function index()
    {
        $data = $this->getFilteredQuery()->get();
        return view('sales.vsv.rka.target_do_units.index', compact('data'));
    }

    public function create()
    {
        // Role check relaxed for all authenticated users

        $commercial_units = ['NEW CARRY'];
        $passenger_units = ['APV BLIND VAN', 'ERTIGA', 'XL7', 'SPRESO', 'IGNIS', 'e-VITARA', 'GRAND VITARA', 'JIMNY 3D', 'JIMNY 5D', 'FRONX'];

        return view('sales.vsv.rka.target_do_units.create', compact('commercial_units', 'passenger_units'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        // Role check relaxed for all authenticated users

        // Validasi inputan (termasuk validasi bulan wajib angka)
        $request->validate([
            'tahun'      => 'required|numeric',
            'jenis_unit' => 'required|string',
            'type_unit'  => 'required|string',
            'jan' => 'nullable|numeric', 'feb' => 'nullable|numeric', 'mar' => 'nullable|numeric',
            'apr' => 'nullable|numeric', 'mei' => 'nullable|numeric', 'jun' => 'nullable|numeric',
            'jul' => 'nullable|numeric', 'agu' => 'nullable|numeric', 'sep' => 'nullable|numeric',
            'okt' => 'nullable|numeric', 'nov' => 'nullable|numeric', 'des' => 'nullable|numeric',
        ]);

        $months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        
        $monthData = [];
        $total = 0;

        // Ambil input per bulan, default 0 jika kosong
        foreach ($months as $month) {
            $val = $request->input($month, 0) ?: 0;
            $monthData[$month] = $val;
            $total += $val;
        }

        // Cek duplikat data berdasarkan User ID (Masing-masing SH punya target sendiri)
        $existingData = TargetDoUnit::where('jenis_unit', $request->jenis_unit)
            ->where('type_unit', $request->type_unit)
            ->where('tahun', $request->tahun)
            ->where('user_id', $user->id) 
            ->first();

        if ($existingData) {
            return back()->with('error', 'Target untuk tipe unit ini di tahun tersebut sudah ada di akun Anda!');
        }

        TargetDoUnit::create(array_merge([
            'jenis_unit' => $request->jenis_unit,
            'type_unit'  => $request->type_unit,
            'tahun'      => $request->tahun,
            'cabang'     => $user->cabang,
                        'total'      => $total,
        ], $monthData));

        return redirect()->route('rka.target-do-units.index')->with('success', 'Data berhasil disimpan.');
    }

    public function edit(string $id)
    {
        $data = TargetDoUnit::findOrFail($id);
        $user = Auth::user();

        // Gunakan fungsi checkAccess yang sudah kita buat
        if (!$this->checkAccess($data, $user)) {
            return redirect()->route('rka.target-do-units.index')->with('error', 'Akses dilarang!');
        }

        $commercial_units = ['NEW CARRY'];
        $passenger_units = ['APV BLIND VAN', 'ERTIGA', 'XL7', 'SPRESO', 'IGNIS', 'e-VITARA', 'GRAND VITARA', 'JIMNY 3D', 'JIMNY 5D', 'FRONX'];

        return view('sales.vsv.rka.target_do_units.edit', compact('data', 'commercial_units', 'passenger_units'));
    }

    public function update(Request $request, string $id)
    {
        $data = TargetDoUnit::findOrFail($id);
        $user = Auth::user();

        // Gunakan fungsi checkAccess
        if (!$this->checkAccess($data, $user)) {
            return redirect()->route('rka.target-do-units.index')->with('error', 'Akses dilarang.');
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
            $monthData[$month] = $val;
            $total += $val;
        }

        $data->update(array_merge(
            $monthData,
            ['total' => $total]
        ));

        return redirect()->route('rka.target-do-units.index')->with('success', 'Data target bulanan berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $data = TargetDoUnit::findOrFail($id);
        $user = Auth::user();

        // Gunakan fungsi checkAccess
        if (!$this->checkAccess($data, $user)) {
            return redirect()->route('rka.target-do-units.index')->with('error', 'Akses dilarang.');
        }

        $data->delete();
        return redirect()->route('rka.target-do-units.index')->with('success', 'Data berhasil dihapus');
    }

    public function exportPdf()
    {
        $data = $this->getFilteredQuery()->get();
        $pdf = Pdf::loadView('rka.target_do_units.pdf', compact('data'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Target-DO-Unit.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new TargetDoUnitExport, 'Target-DO-Unit.xlsx');
    }
}