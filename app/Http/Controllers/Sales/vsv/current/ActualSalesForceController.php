<?php

namespace App\Http\Controllers\Sales\vsv\current;

use App\Http\Controllers\Controller;
use App\Models\Sales\vsv\current\ActualSalesForce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ActualSalesforceExport;

class ActualSalesforceController extends Controller
{
    // --- PRIVATE METHODS (HELPER) ---

    private function getFilteredQuery()
    {
        $user = Auth::user();
        $pusatRoles = ['Admin', 'OM', 'Admin DCA', 'OM DCA'];
        
        // Eager loading 'user' untuk performa lebih baik (pastikan relasi user() ada di model)
        $query = ActualSalesforce::with('user');

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

        return view('sales.vsv.current.actual_salesforces.index', compact('data', 'year', 'grandTotal'));
    }

    public function create()
    {
        // Role check relaxed for all authenticated users

        $gradings = ['G1', 'G2', 'G3', 'G4']; // Contoh opsi grading salesforce

        return view('sales.vsv.current.actual_salesforces.create', compact('gradings'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        // Role check relaxed for all authenticated users

        // Validasi input
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

        // Cek duplikat data untuk akun yang sama
        $existingData = ActualSalesforce::where('grading', $request->grading)
            ->where('tahun', $request->tahun)
            ->where('user_id', $user->id) 
            ->first();

        if ($existingData) {
            return back()->with('error', 'Data untuk grading ini di tahun tersebut sudah ada di akun Anda!');
        }

        ActualSalesforce::create(array_merge([
            'grading' => $request->grading,
            'tahun'   => $request->tahun,
            'cabang'  => $user->cabang,
            'user_id' => $user->id,
            'total'   => $total,
        ], $monthData));

        return redirect()->route('current.actual-salesforces.index')->with('success', 'Data berhasil disimpan.');
    }

    public function edit(string $id)
    {
        $actualSalesforce = ActualSalesforce::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($actualSalesforce, $user)) {
            return redirect()->route('current.actual-salesforces.index')->with('error', 'Akses dilarang!');
        }

        return view('sales.vsv.current.actual_salesforces.edit', compact('actualSalesforce'));
    }

    public function update(Request $request, string $id)
    {
        $actualSalesforce = ActualSalesforce::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($actualSalesforce, $user)) {
            return redirect()->route('current.actual-salesforces.index')->with('error', 'Akses dilarang.');
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

        $actualSalesforce->update(array_merge(
            $monthData,
            ['total' => $total]
        ));

        return redirect()->route('current.actual-salesforces.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $actualSalesforce = ActualSalesforce::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($actualSalesforce, $user)) {
            return redirect()->route('current.actual-salesforces.index')->with('error', 'Akses dilarang.');
        }

        $actualSalesforce->delete();
        return redirect()->route('current.actual-salesforces.index')->with('success', 'Data berhasil dihapus.');
    }

    public function exportPdf()
    {
        $data = $this->getFilteredQuery()->get();
        $pdf = Pdf::loadView('current.actual_salesforces.pdf', compact('data'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Actual-Salesforce.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ActualSalesforceExport, 'Actual_Salesforce_'.now()->format('Ymd').'.xlsx');
    }
}