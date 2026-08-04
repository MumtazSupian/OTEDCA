<?php

namespace App\Http\Controllers\Sales\vsv\current;

use App\Http\Controllers\Controller;
use App\Models\Sales\vsv\current\ActualSourceDoInquary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ActualSourceDoInquaryExport;

class ActualSourceDoInquaryController extends Controller
{
    // --- PRIVATE METHODS (HELPER) ---

    private function getFilteredQuery()
    {
        $user = Auth::user();
        $pusatRoles = ['Admin', 'OM', 'Admin DCA', 'OM DCA'];
        
        // Eager loading 'user' untuk performa lebih baik
        $query = ActualSourceDoInquary::with('user');

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
        // Jika SH, hanya boleh edit/hapus data miliknya sendiri
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

        return view('sales.vsv.current.actual-source-do-inquary.index', compact('data', 'year', 'grandTotal'));
    }

    public function create()
    {
        if (!in_array(Auth::user()->role, ['BM', 'SH', 'Admin', 'OM', 'Admin DCA', 'OM DCA'])) {
            return redirect()->route('current.actual-source-do-inquary.index')->with('error', 'Akses dibatasi.');
        }

        return view('sales.vsv.current.actual-source-do-inquary.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['BM', 'SH', 'Admin', 'OM', 'Admin DCA', 'OM DCA'])) {
            return redirect()->route('current.actual-source-do-inquary.index')->with('error', 'Akses dilarang.');
        }

        // Validasi input
        $request->validate([
            'tahun'          => 'required|numeric',
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

        // Cek duplikat data untuk source yang sama di tahun yang sama oleh user yang sama
        $existingData = ActualSourceDoInquary::where('source_inquary', $request->source_inquary)
            ->where('tahun', $request->tahun)
            ->where('user_id', $user->id) 
            ->first();

        if ($existingData) {
            return back()->with('error', 'Data untuk source ini di tahun tersebut sudah ada!');
        }

        ActualSourceDoInquary::create(array_merge([
            'source_inquary' => $request->source_inquary,
            'tahun'          => $request->tahun,
            'cabang'         => $user->cabang,
            'user_id'        => $user->id,
            'total'          => $total,
        ], $monthData));

        return redirect()->route('current.actual-source-do-inquary.index')->with('success', 'Data berhasil disimpan.');
    }

    public function edit(string $id)
    {
        $actualSourceDoInquary = ActualSourceDoInquary::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($actualSourceDoInquary, $user)) {
            return redirect()->route('current.actual-source-do-inquary.index')->with('error', 'Akses dilarang!');
        }

        return view('sales.vsv.current.actual-source-do-inquary.edit', compact('actualSourceDoInquary'));
    }

    public function update(Request $request, string $id)
    {
        $data = ActualSourceDoInquary::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($data, $user)) {
            return redirect()->route('current.actual-source-do-inquary.index')->with('error', 'Akses dilarang.');
        }

        $request->validate([
            'source_inquary' => 'required|string',
            'tahun'          => 'required|numeric',
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
            [
                'total' => $total,
                'source_inquary' => $request->source_inquary,
                'tahun' => $request->tahun
            ]
        ));

        return redirect()->route('current.actual-source-do-inquary.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $data = ActualSourceDoInquary::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($data, $user)) {
            return redirect()->route('current.actual-source-do-inquary.index')->with('error', 'Akses dilarang.');
        }

        $data->delete();
        return redirect()->route('current.actual-source-do-inquary.index')->with('success', 'Data berhasil dihapus.');
    }

    public function exportPdf()
    {
        $data = $this->getFilteredQuery()->get();
        $months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        
        $grandTotals = collect($months)->mapWithKeys(fn($m) => [$m => $data->sum($m)]);
        $grandTotalAll = $data->sum('total');

        $pdf = Pdf::loadView('current.actual-source-do-inquary.pdf', compact('data', 'months', 'grandTotals', 'grandTotalAll'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Source-DO.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ActualSourceDoInquaryExport, 'Actual_Source_DO_'.now()->format('Ymd').'.xlsx');
    }
}