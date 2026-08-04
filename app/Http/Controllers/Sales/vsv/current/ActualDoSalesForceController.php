<?php

namespace App\Http\Controllers\Sales\vsv\current;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales\vsv\current\ActualDoSalesForce;
use Illuminate\Support\Facades\Auth; 
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ActualDoSalesforceExport;

class ActualDoSalesForceController extends Controller
{
    // --- PRIVATE METHODS (HELPER) ---

    private function getFilteredQuery()
    {
        $user = Auth::user();
        $pusatRoles = ['Admin', 'OM', 'Admin DCA', 'OM DCA'];
        
        // Eager loading 'user' jika relasi tersedia di model
        $query = ActualDoSalesforce::query();

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

        return view('sales.vsv.current.actual_do_salesforces.index', compact('data', 'year', 'grandTotal'));
    }

    public function create() 
    { 
        $user = Auth::user();
        $allowedRoles = ['Admin', 'OM', 'Admin DCA', 'OM DCA', 'BM', 'SH'];

        if (!in_array($user->role, $allowedRoles)) {
            return redirect()->route('current.actual-do-salesforces.index')->with('error', 'Akses ditolak.');
        }
        return view('sales.vsv.current.actual_do_salesforces.create'); 
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $allowedRoles = ['BM', 'SH', 'Admin', 'OM', 'Admin DCA', 'OM DCA'];

        if (!in_array($user->role, $allowedRoles)) {
            return redirect()->route('current.actual-do-salesforces.index')->with('error', 'Akses dilarang.');
        }

        // Validasi input disesuaikan dengan standarisasi
        $request->validate([
            'tahun'   => 'required|numeric',
            'grading' => 'required|string',
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

        // Cek duplikat data berdasarkan cabang, tahun, dan grading
        $existing = ActualDoSalesforce::where('cabang', $user->cabang)
            ->where('tahun', $request->tahun)
            ->where('grading', $request->grading)
            ->first();

        if ($existing) {
            return back()->with('error', 'Data Actual untuk grading ini di tahun tersebut sudah ada di cabang Anda!')
                         ->withInput();
        }

        ActualDoSalesforce::create(array_merge([
            'grading' => $request->grading,
            'tahun'   => $request->tahun,
            'cabang'  => $user->cabang,
            'user_id' => $user->id,
            'total'   => $total,
        ], $monthData));

        return redirect()->route('current.actual-do-salesforces.index')->with('success', 'Data berhasil disimpan.');
    }

    public function edit(string $id)
    {
        $actualDoSalesforce = ActualDoSalesforce::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($actualDoSalesforce, $user)) {
            return redirect()->route('current.actual-do-salesforces.index')->with('error', 'Akses dilarang!');
        }

        return view('sales.vsv.current.actual_do_salesforces.edit', compact('actualDoSalesforce'));
    }

    public function update(Request $request, string $id)
    {
        $actualDoSalesforce = ActualDoSalesforce::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($actualDoSalesforce, $user)) {
            return redirect()->route('current.actual-do-salesforces.index')->with('error', 'Akses dilarang.');
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

        $actualDoSalesforce->update(array_merge(
            $monthData,
            ['total' => $total]
        ));

        return redirect()->route('current.actual-do-salesforces.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $actualDoSalesforce = ActualDoSalesforce::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($actualDoSalesforce, $user)) {
            return redirect()->route('current.actual-do-salesforces.index')->with('error', 'Akses dilarang.');
        }

        $actualDoSalesforce->delete();
        return redirect()->route('current.actual-do-salesforces.index')->with('success', 'Data berhasil dihapus.');
    }

    public function exportPdf()
    {
        $data = $this->getFilteredQuery()->get();
        $months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        
        $pdf = Pdf::loadView('current.actual_do_salesforces.pdf', [
            'data' => $data, 
            'months' => $months,
            'grandTotals' => collect($months)->mapWithKeys(fn($m) => [$m => $data->sum($m)]),
            'grandTotalAll' => $data->sum('total')
        ])->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Actual-Salesforce-'.now()->format('Ymd').'.pdf');
    }

    public function exportExcel() 
    { 
        return Excel::download(new ActualDoSalesforceExport, 'Actual_Salesforce_'.now()->format('Ymd').'.xlsx'); 
    }
}