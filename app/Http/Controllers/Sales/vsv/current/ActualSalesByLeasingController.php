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
        $pusatRoles = ['Admin', 'OM', 'Admin DCA', 'OM DCA'];
        
        // Tambahkan with('user') agar proses load data selalu cepat (Eager Loading)
        $query = ActualSalesByLeasing::with('user');

        if (in_array($user->role, $pusatRoles)) {
            return $query->orderBy('tahun', 'desc');
        } elseif ($user->role === 'BM') {
            return $query->where('cabang', $user->cabang)->orderBy('tahun', 'desc');
        } elseif ($user->role === 'SH') {
            return $query->where('user_id', $user->id)->orderBy('tahun', 'desc'); 
        }

        return $query->where('cabang', $user->cabang)->orderBy('tahun', 'desc');
    }

    // Fungsi helper agar tidak mengulang kode pengecekan hak akses
    private function checkAccess($data, $user)
    {
        if ($user->role === 'SH' && $data->user_id != $user->id) {
            return false;
        }
        if ($data->cabang != $user->cabang && !in_array($user->role, ['Admin', 'OM', 'Admin DCA', 'OM DCA'])) {
            return false;
        }
        return true;
    }

    // --- PUBLIC METHODS (CRUD & EXPORT) ---

    public function index()
    {
        $data = $this->getFilteredQuery()->get();
        $months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        return view('sales.vsv.current.actual_sales_by_leasing.index', compact('data', 'months'));
    }

    public function create()
    {
        if (!in_array(Auth::user()->role, ['BM', 'SH', 'Admin', 'OM', 'Admin DCA', 'OM DCA'])) {
            return redirect()->route('current.actual-sales-by-leasing.index')->with('error', 'Akses dibatasi.');
        }

        $leasingOptions = ['tunai','suzuki_finance','bca_finance','kbb_bca','mandiri_tunas_finance','kbb_mandiri','bsi','mandiri_utama_finance','indomobil_finance','adira_finance','bni_finance','maybank','oto_multiartha_finance','niaga_finance','clipan_finance','lain_lain'];

        return view('sales.vsv.current.actual_sales_by_leasing.create', compact('leasingOptions'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['BM', 'SH', 'Admin', 'OM', 'Admin DCA', 'OM DCA'])) {
            return redirect()->route('current.actual-sales-by-leasing.index')->with('error', 'Akses dilarang.');
        }

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
            'user_id'      => $user->id,
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