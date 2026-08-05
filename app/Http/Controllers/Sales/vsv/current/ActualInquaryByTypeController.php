<?php

namespace App\Http\Controllers\Sales\vsv\current;

use App\Http\Controllers\Controller;
use App\Models\Sales\vsv\current\ActualInquaryByType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ActualInquaryByTypeExport;

class ActualInquaryByTypeController extends Controller
{
    // --- PRIVATE METHODS (HELPER) ---

        private function getFilteredQuery()
    {
        $user = Auth::user();
        $query = \App\Models\Sales\vsv\current\ActualInquaryByType::query();

        if (!$user || $user->is_admin || $user->is_admin_stock || in_array(strtolower($user->role ?? ''), ['admin', 'om', 'admin dca', 'om dca', 'admin stock', ''])) {
            return $query->orderBy('id', 'desc');
        }

        $cabang = $user->cabang ?: ($user->branch ?: 'Ciawi');
        return $query->where('cabang', $cabang)->orderBy('id', 'desc');
    }

    

    public function index()
    {
        $data = $this->getFilteredQuery()->get();
        $year = now()->year;
        $grandTotal = $data->sum('total');

        return view('sales.vsv.current.actual_inquary_by_type.index', compact('data', 'year', 'grandTotal'));
    }

    public function create()
    {
        // Role check relaxed for all authenticated users

        $year = now()->year;
        $commercial_units = ['NEW CARRY'];
        $passenger_units = ['APV BLIND VAN', 'ERTIGA', 'XL7', 'SPRESO', 'IGNIS', 'e-VITARA', 'GRAND VITARA', 'JIMNY 3D', 'JIMNY 5D', 'FRONX'];

        return view('sales.vsv.current.actual_inquary_by_type.create', compact('year', 'commercial_units', 'passenger_units'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        // Role check relaxed for all authenticated users

        // Validasi input flat (bukan array targets)
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

        // Cek duplikat data agar tidak double input untuk unit yang sama di tahun yang sama
        $existingData = ActualInquaryByType::where('jenis_unit', $request->jenis_unit)
            ->where('type_unit', $request->type_unit)
            ->where('tahun', $request->tahun)
            ->where('user_id', $user->id) 
            ->first();

        if ($existingData) {
            return back()->with('error', 'Data untuk tipe unit ini di tahun tersebut sudah ada di akun Anda!');
        }

        ActualInquaryByType::create(array_merge([
            'jenis_unit' => $request->jenis_unit,
            'type_unit'  => $request->type_unit,
            'tahun'      => $request->tahun,
            'cabang'     => $user->cabang,
                        'total'      => $total,
        ], $monthData));

        return redirect()->route('current.actual-inquary-by-type.index')->with('success', 'Data Inquiry berhasil disimpan.');
    }

    public function edit(string $id)
    {
        $actualInquaryByType = ActualInquaryByType::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($actualInquaryByType, $user)) {
            return redirect()->route('current.actual-inquary-by-type.index')->with('error', 'Akses dilarang!');
        }

        $commercial_units = ['NEW CARRY'];
        $passenger_units = ['APV BLIND VAN', 'ERTIGA', 'XL7', 'SPRESO', 'IGNIS', 'e-VITARA', 'GRAND VITARA', 'JIMNY 3D', 'JIMNY 5D', 'FRONX'];

        return view('sales.vsv.current.actual_inquary_by_type.edit', compact('actualInquaryByType', 'commercial_units', 'passenger_units'));
    }

    public function update(Request $request, string $id)
    {
        $actualInquaryByType = ActualInquaryByType::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($actualInquaryByType, $user)) {
            return redirect()->route('current.actual-inquary-by-type.index')->with('error', 'Akses dilarang.');
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
            $monthData[$month] = (int)$val;
            $total += (int)$val;
        }

        $actualInquaryByType->update(array_merge(
            $monthData,
            ['total' => $total]
        ));

        return redirect()->route('current.actual-inquary-by-type.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $actualInquaryByType = ActualInquaryByType::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($actualInquaryByType, $user)) {
            return redirect()->route('current.actual-inquary-by-type.index')->with('error', 'Akses dilarang.');
        }

        $actualInquaryByType->delete();
        return redirect()->route('current.actual-inquary-by-type.index')->with('success', 'Data berhasil dihapus.');
    }

    public function exportPdf()
    {
        $data = $this->getFilteredQuery()->get();
        $months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        $grandTotals = collect($months)->mapWithKeys(fn($m) => [$m => $data->sum($m)]);
        $grandTotalAll = $data->sum('total');

        $pdf = Pdf::loadView('current.actual_inquary_by_type.pdf', compact('data', 'months', 'grandTotals', 'grandTotalAll'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Actual-Inquiry-By-Type.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ActualInquaryByTypeExport, 'Actual_Inquiry_Type_'.now()->format('Ymd').'.xlsx');
    }
}