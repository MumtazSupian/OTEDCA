<?php

namespace App\Http\Controllers\Sales\vsv\current;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales\vsv\current\ActualSalesByLeasing;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ActualSalesByLeasingExport;

class ActualSalesByLeasingController extends Controller
{
    // --- PRIVATE METHODS (HELPER) ---

        private function getFilteredQuery()
    {
        $user = Auth::user();
        $query = \App\Models\Sales\vsv\current\ActualSalesByLeasing::query();

        if (!$user || $user->is_admin || $user->is_admin_stock || in_array(strtolower($user->role ?? ''), ['admin', 'om', 'admin dca', 'om dca', 'admin stock', ''])) {
            return $query->orderBy('id', 'desc');
        }

        $cabang = $user->cabang ?: ($user->branch ?: 'Ciawi');
        return $query->where('cabang', $cabang)->orderBy('id', 'desc');
    }

    

    public function index()
    {
        $data = $this->getFilteredQuery()->get();
        $months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        return view('sales.vsv.current.actual_sales_by_leasing.index', compact('data', 'months'));
    }

    public function create()
    {
        // Role check relaxed for all authenticated users

        $leasingOptions = ['tunai','suzuki_finance','bca_finance','kbb_bca','mandiri_tunas_finance','kbb_mandiri','bsi','mandiri_utama_finance','indomobil_finance','adira_finance','bni_finance','maybank','oto_multiartha_finance','niaga_finance','clipan_finance','lain_lain'];

        return view('sales.vsv.current.actual_sales_by_leasing.create', compact('leasingOptions'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        // Role check relaxed for all authenticated users

        // Validasi inputan
        $request->validate([
            'leasing_name' => 'required|string',
            'tahun'        => 'required|numeric',
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

        // Cek duplikat data (Mencegah user input leasing yang sama di tahun yang sama)
        $existingData = ActualSalesByLeasing::where('leasing_name', $request->leasing_name)
            ->where('tahun', $request->tahun)
            ->where('user_id', $user->id) 
            ->first();

        if ($existingData) {
            return back()->with('error', 'Data untuk Leasing ini di tahun tersebut sudah ada di akun Anda!');
        }

        ActualSalesByLeasing::create(array_merge([
            'leasing_name' => $request->leasing_name,
            'tahun'        => $request->tahun,
            'cabang'       => $user->cabang,
                        'total'        => $total,
        ], $monthData));

        return redirect()->route('current.actual-sales-by-leasing.index')->with('success', 'Data berhasil disimpan.');
    }

    public function edit(string $id)
    {
        $row = ActualSalesByLeasing::findOrFail($id); // Pakai variabel $row menyesuaikan view kamu
        $user = Auth::user();

        // Gunakan fungsi checkAccess
        if (!$this->checkAccess($row, $user)) {
            return redirect()->route('current.actual-sales-by-leasing.index')->with('error', 'Akses dilarang!');
        }

        $leasingOptions = ['tunai','suzuki_finance','bca_finance','kbb_bca','mandiri_tunas_finance','kbb_mandiri','bsi','mandiri_utama_finance','indomobil_finance','adira_finance','bni_finance','maybank','oto_multiartha_finance','niaga_finance','clipan_finance','lain_lain'];
        $months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];

        return view('sales.vsv.current.actual_sales_by_leasing.edit', compact('row', 'leasingOptions', 'months'));
    }

    public function update(Request $request, string $id)
    {
        $row = ActualSalesByLeasing::findOrFail($id);
        $user = Auth::user();

        // Gunakan fungsi checkAccess
        if (!$this->checkAccess($row, $user)) {
            return redirect()->route('current.actual-sales-by-leasing.index')->with('error', 'Akses dilarang.');
        }

        $request->validate([
            'leasing_name' => 'required|string',
            'tahun'        => 'required|numeric',
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

        $row->update(array_merge([
            'leasing_name' => $request->leasing_name,
            'tahun'        => $request->tahun,
            'total'        => $total
        ], $monthData));

        return redirect()->route('current.actual-sales-by-leasing.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $row = ActualSalesByLeasing::findOrFail($id);
        $user = Auth::user();

        // Gunakan fungsi checkAccess
        if (!$this->checkAccess($row, $user)) {
            return redirect()->route('current.actual-sales-by-leasing.index')->with('error', 'Akses dilarang.');
        }

        $row->delete();
        return redirect()->route('current.actual-sales-by-leasing.index')->with('success', 'Data berhasil dihapus');
    }

    public function exportPdf()
    {
        $data = $this->getFilteredQuery()->get();
        $months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        $pdf = Pdf::loadView('current.actual_sales_by_leasing.pdf', [
            'data' => $data, 'months' => $months,
            'grandTotals' => collect($months)->mapWithKeys(fn($m) => [$m => $data->sum($m)]),
            'grandTotalAll' => $data->sum('total')
        ])->setPaper('a4', 'landscape');
        return $pdf->download('Actual_Sales_Leasing.pdf');
    }

    public function exportExcel() { return Excel::download(new ActualSalesByLeasingExport, 'Actual_Sales_Leasing.xlsx'); }
}