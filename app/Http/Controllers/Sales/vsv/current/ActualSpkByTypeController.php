<?php

namespace App\Http\Controllers\Sales\vsv\current;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales\vsv\current\ActualSpkByType;
use Illuminate\Support\Facades\Auth; 
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ActualSpkByTypeExport;

class ActualSpkByTypeController extends Controller
{
    // Fungsi bantuan untuk filter data (BM bisa lihat semua di cabangnya, SH hanya miliknya)
        private function getFilteredQuery()
    {
        $user = Auth::user();
        $query = \App\Models\Sales\vsv\current\ActualSpkByType::query();

        if (!$user || $user->is_admin || $user->is_admin_stock || in_array(strtolower($user->role ?? ''), ['admin', 'om', 'admin dca', 'om dca', 'admin stock', ''])) {
            return $query->orderBy('id', 'desc');
        }

        $cabang = $user->cabang ?: ($user->branch ?: 'Ciawi');
        return $query->where('cabang', $cabang)->orderBy('id', 'desc');
    }

    

   public function index()
{
    $year = now()->year;
    // Menggunakan with('user') untuk menghindari N+1 query problem
    $data = $this->getFilteredQuery()->with('user')->get();
    
    return view('sales.vsv.current.actual_spk_by_type.index', compact('data', 'year'));
}

    public function create()
    {
        if (!in_array(Auth::user()->role, ['BM', 'SH'])) {
            return redirect()->route('current.actual-spk-by-type.index')->with('error', 'Akses ditolak.');
        }

        $year = now()->year;
        $commercial_units = ['NEW CARRY'];
        $passenger_units = ['APV BLIND VAN', 'ERTIGA', 'XL7', 'SPRESO', 'IGNIS', 'e-VITARA', 'GRAND VITARA', 'JIMNY 3D', 'JIMNY 5D', 'FRONX'];

        return view('sales.vsv.current.actual_spk_by_type.create', compact('year', 'commercial_units', 'passenger_units'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        // 1. Proteksi Role
        // Role check relaxed for all authenticated users

        // 2. Validasi Input Dasar
        $request->validate([
            'jenis_unit' => 'required',
            'type_unit'  => 'required',
            'tahun'      => 'required|numeric',
        ]);

        $months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        
        // 3. Hitung Total Keseluruhan
        $total = 0;
        foreach ($months as $m) {
            $total += (int) $request->input($m, 0);
        }

        try {
            // 4. Gunakan updateOrCreate agar data tidak duplikat jika user input unit & tahun yang sama
            ActualSpkByType::updateOrCreate(
                [
                    'cabang'     => $user->cabang,
                    'tahun'      => $request->tahun,
                    'type_unit'  => $request->type_unit,
                    // Jika ingin membedakan per user (untuk SH), aktifkan baris bawah ini:
                    //  
                ],
                [
                    'jenis_unit' => $request->jenis_unit,
                                        'total'      => $total,
                    'jan' => $request->jan ?? 0,
                    'feb' => $request->feb ?? 0,
                    'mar' => $request->mar ?? 0,
                    'apr' => $request->apr ?? 0,
                    'mei' => $request->mei ?? 0,
                    'jun' => $request->jun ?? 0,
                    'jul' => $request->jul ?? 0,
                    'agu' => $request->agu ?? 0,
                    'sep' => $request->sep ?? 0,
                    'okt' => $request->okt ?? 0,
                    'nov' => $request->nov ?? 0,
                    'des' => $request->des ?? 0,
                ]
            );

            return redirect()->route('current.actual-spk-by-type.index')->with('success', 'Data SPK berhasil disimpan.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
    public function edit(ActualSpkByType $actualSpkByType)
    {
        $user = Auth::user();

        // Proteksi Akses
        if ($user->role === 'SH' && $actualSpkByType->user_id != $user->id) {
            return redirect()->route('current.actual-spk-by-type.index')->with('error', 'Akses dilarang! Anda hanya boleh mengelola data sendiri.');
        }
        
        if ($user->role === 'BM' && $actualSpkByType->cabang != $user->cabang) {
            return redirect()->route('current.actual-spk-by-type.index')->with('error', 'Akses dilarang!');
        }

        $commercial_units = ['NEW CARRY'];
        $passenger_units = ['APV BLIND VAN', 'ERTIGA', 'XL7', 'SPRESO', 'IGNIS', 'e-VITARA', 'GRAND VITARA', 'JIMNY 3D', 'JIMNY 5D', 'FRONX'];

        return view('sales.vsv.current.actual_spk_by_type.edit', compact('actualSpkByType', 'commercial_units', 'passenger_units'));
    }

    public function update(Request $request, ActualSpkByType $actualSpkByType)
    {
        $user = Auth::user();

        if (($user->role === 'SH' && $actualSpkByType->user_id != $user->id) || ($user->role === 'BM' && $actualSpkByType->cabang != $user->cabang)) {
            return redirect()->route('current.actual-spk-by-type.index')->with('error', 'Akses dilarang.');
        }

        $months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        $total = 0;
        foreach ($months as $m) {
            $total += (int) $request->$m;
        }

        $commercial_units = ['NEW CARRY'];
        $jenis_unit = in_array($request->type_unit, $commercial_units) ? 'Commercial' : 'Passenger';

        $actualSpkByType->update(array_merge(
            [
                'jenis_unit' => $jenis_unit,
                'type_unit'  => $request->type_unit,
                'tahun'      => $request->tahun,
                'total'      => $total
            ],
            $request->only($months)
        ));

        return redirect()->route('current.actual-spk-by-type.index')->with('success', 'Data SPK berhasil diperbarui');
    }

    public function destroy(ActualSpkByType $actualSpkByType)
    {
        $user = Auth::user();

        if (($user->role === 'SH' && $actualSpkByType->user_id != $user->id) || ($user->role === 'BM' && $actualSpkByType->cabang != $user->cabang)) {
            return redirect()->route('current.actual-spk-by-type.index')->with('error', 'Akses dilarang!');
        }

        $actualSpkByType->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }

    public function exportExcel()
    {
        return Excel::download(new ActualSpkByTypeExport, 'Actual_SPK_By_Type_'.now()->format('Ymd').'.xlsx');
    }

    public function exportPdf()
    {
        $data = $this->getFilteredQuery()->orderBy('jenis_unit', 'asc')->get();
        $months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        
        $grandTotals = [];
        foreach ($months as $m) { 
            $grandTotals[$m] = $data->sum($m); 
        }
        $grandTotalAll = $data->sum('total');

        $pdf = Pdf::loadView('current.actual_spk_by_type.pdf', compact('data', 'months', 'grandTotals', 'grandTotalAll'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('Actual_SPK_By_Type_'.now()->format('Ymd').'.pdf');
    }
}