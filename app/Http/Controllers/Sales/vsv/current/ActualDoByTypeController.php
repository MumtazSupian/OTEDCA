<?php

namespace App\Http\Controllers\Sales\vsv\current;

use App\Http\Controllers\Controller;
use App\Models\Sales\vsv\current\ActualDoByType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ActualDoByTypeExport;

class ActualDoByTypeController extends Controller
{
    // --- PRIVATE METHODS (HELPER) ---

    private function getFilteredQuery()
    {
        $user = Auth::user();
        $pusatRoles = ['Admin', 'OM', 'Admin DCA', 'OM DCA'];
        
        // Eager loading 'user' untuk performa lebih baik
        $query = ActualDoByType::with('user');

        if (in_array($user->role, $pusatRoles)) {
            return $query;
        } elseif ($user->role === 'BM') {
            return $query->where('cabang', $user->cabang);
        } elseif ($user->role === 'SH') {
            return $query->where('user_id', $user->id); 
        }

        return $query->where('cabang', $user->cabang);
    }

    private function checkAccess($data, $user)
    {
        // Jika SH, hanya boleh edit data miliknya sendiri
        if ($user->role === 'SH' && $data->user_id != $user->id) {
            return false;
        }
        // Jika bukan pusat, hanya boleh edit data di cabang yang sama
        if ($data->cabang != $user->cabang && !in_array($user->role, ['Admin', 'OM', 'Admin DCA', 'OM DCA'])) {
            return false;
        }
        return true;
    }

    // --- PUBLIC METHODS (CRUD & EXPORT) ---

    public function index()
    {
        $data = $this->getFilteredQuery()->get();
        $year = now()->year;
        $grandTotal = $data->sum('total');

        return view('sales.vsv.current.actual_do_by_type.index', compact('data', 'year', 'grandTotal'));
    }

    public function create()
    {
        // Role check relaxed for all authenticated users

        $commercial_units = ['NEW CARRY'];
        $passenger_units = ['APV BLIND VAN', 'ERTIGA', 'XL7', 'SPRESO', 'IGNIS', 'e-VITARA', 'GRAND VITARA', 'JIMNY 3D', 'JIMNY 5D', 'FRONX'];

        return view('sales.vsv.current.actual_do_by_type.create', compact('commercial_units', 'passenger_units'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        // Role check relaxed for all authenticated users

        // Validasi input (Sesuai dengan standarisasi TargetDoUnit)
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

        foreach ($months as $month) {
            $val = $request->input($month, 0) ?: 0;
            $monthData[$month] = (int)$val;
            $total += (int)$val;
        }

        // Cek duplikat data
        $existingData = ActualDoByType::where('jenis_unit', $request->jenis_unit)
            ->where('type_unit', $request->type_unit)
            ->where('tahun', $request->tahun)
            ->where('user_id', $user->id) 
            ->first();

        if ($existingData) {
            return back()->with('error', 'Data untuk tipe unit ini di tahun tersebut sudah ada di akun Anda!');
        }

        ActualDoByType::create(array_merge([
            'jenis_unit' => $request->jenis_unit,
            'type_unit'  => $request->type_unit,
            'tahun'      => $request->tahun,
            'cabang'     => $user->cabang,
            'user_id'    => $user->id,
            'total'      => $total,
        ], $monthData));

        return redirect()->route('current.actual-do-by-type.index')->with('success', 'Data berhasil disimpan.');
    }

    public function edit(string $id)
    {
        $actualDoByType = ActualDoByType::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($actualDoByType, $user)) {
            return redirect()->route('current.actual-do-by-type.index')->with('error', 'Akses dilarang!');
        }

        $commercial_units = ['NEW CARRY'];
        $passenger_units = ['APV BLIND VAN', 'ERTIGA', 'XL7', 'SPRESO', 'IGNIS', 'e-VITARA', 'GRAND VITARA', 'JIMNY 3D', 'JIMNY 5D', 'FRONX'];

        return view('sales.vsv.current.actual_do_by_type.edit', compact('actualDoByType', 'commercial_units', 'passenger_units'));
    }

    public function update(Request $request, string $id)
    {
        $actualDoByType = ActualDoByType::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($actualDoByType, $user)) {
            return redirect()->route('current.actual-do-by-type.index')->with('error', 'Akses dilarang.');
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

        $actualDoByType->update(array_merge(
            $monthData,
            ['total' => $total]
        ));

        return redirect()->route('current.actual-do-by-type.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $actualDoByType = ActualDoByType::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($actualDoByType, $user)) {
            return redirect()->route('current.actual-do-by-type.index')->with('error', 'Akses dilarang.');
        }

        $actualDoByType->delete();
        return redirect()->route('current.actual-do-by-type.index')->with('success', 'Data berhasil dihapus.');
    }

    public function exportPdf()
    {
        $data = $this->getFilteredQuery()->get();
        $pdf = Pdf::loadView('current.actual_do_by_type.pdf', compact('data'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Actual-DO-By-Type.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ActualDoByTypeExport, 'Actual_DO_Type_'.now()->format('Ymd').'.xlsx');
    }
}