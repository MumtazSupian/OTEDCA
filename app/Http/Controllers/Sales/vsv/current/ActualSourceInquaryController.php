<?php

namespace App\Http\Controllers\Sales\vsv\current;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales\vsv\current\ActualSourceInquary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ActualSourceInquaryExport;

class ActualSourceInquaryController extends Controller
{
    // --- PRIVATE METHODS (HELPER) ---

    private function getFilteredQuery()
    {
        $user = Auth::user();
        $pusatRoles = ['Admin', 'OM', 'Admin DCA', 'OM DCA'];
        
        // Eager loading 'user' untuk performa lebih baik
        $query = ActualSourceInquary::with('user');

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
        // Jika SH, hanya boleh akses data miliknya sendiri
        if ($user->role === 'SH' && $data->user_id != $user->id) {
            return false;
        }
        // Jika bukan pusat, hanya boleh akses data di cabang yang sama
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

        return view('sales.vsv.current.actual_source_inquary.index', compact('data', 'year', 'grandTotal'));
    }

    public function create()
    {
        if (!in_array(Auth::user()->role, ['BM', 'SH', 'Admin', 'OM', 'Admin DCA', 'OM DCA'])) {
            return redirect()->route('current.actual-source-inquary.index')->with('error', 'Akses dibatasi.');
        }

        return view('sales.vsv.current.actual_source_inquary.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['BM', 'SH', 'Admin', 'OM', 'Admin DCA', 'OM DCA'])) {
            return redirect()->route('current.actual-source-inquary.index')->with('error', 'Akses dilarang.');
        }

        // Validasi
        $request->validate([
            'tahun' => 'required|numeric',
            'source_inquary' => 'required|string',
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

        // Cek duplikat data untuk user yang sama di tahun yang sama
        $existingData = ActualSourceInquary::where('source_inquary', $request->source_inquary)
            ->where('tahun', $request->tahun)
            ->where('user_id', $user->id)
            ->first();

        if ($existingData) {
            return back()->with('error', 'Data untuk source inquiry ini sudah ada di akun Anda!');
        }

        ActualSourceInquary::create(array_merge([
            'source_inquary' => $request->source_inquary,
            'tahun'          => $request->tahun,
            'cabang'         => $user->cabang,
            'user_id'        => $user->id,
            'total'          => $total,
        ], $monthData));

        return redirect()->route('current.actual-source-inquary.index')->with('success', 'Data berhasil disimpan.');
    }

    public function edit($id)
    {
        $actualSourceInquary = ActualSourceInquary::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($actualSourceInquary, $user)) {
            return redirect()->route('current.actual-source-inquary.index')->with('error', 'Akses dilarang!');
        }

        return view('sales.vsv.current.actual_source_inquary.edit', compact('actualSourceInquary'));
    }

    public function update(Request $request, $id)
    {
        $data = ActualSourceInquary::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($data, $user)) {
            return redirect()->route('current.actual-source-inquary.index')->with('error', 'Akses dilarang.');
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

        $data->update(array_merge(
            $monthData,
            [
                'total' => $total,
                'source_inquary' => $request->source_inquary ?? $data->source_inquary
            ]
        ));

        return redirect()->route('current.actual-source-inquary.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $data = ActualSourceInquary::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($data, $user)) {
            return redirect()->route('current.actual-source-inquary.index')->with('error', 'Akses dilarang.');
        }

        $data->delete();
        return redirect()->route('current.actual-source-inquary.index')->with('success', 'Data berhasil dihapus.');
    }

    public function exportExcel()
    {
        return Excel::download(new ActualSourceInquaryExport, 'Actual_Source_Inquiry_'.now()->format('Ymd').'.xlsx');
    }

    public function exportPdf()
    {
        $data = $this->getFilteredQuery()->get();
        $months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        
        $grandTotals = collect($months)->mapWithKeys(fn($m) => [$m => $data->sum($m)]);
        $grandTotalAll = $data->sum('total');

        $pdf = Pdf::loadView('current.actual_source_inquary.pdf', compact('data', 'months', 'grandTotals', 'grandTotalAll'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Actual-Source-Inquiry.pdf');
    }
}