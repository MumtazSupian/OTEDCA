<?php

namespace App\Http\Controllers\Sales\vsv\rka;

use App\Http\Controllers\Controller;
use App\Models\Sales\vsv\rka\TargetDoBySoi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\TargetDoBySoiExport;

class TargetDoBySoiController extends Controller
{
    // --- PRIVATE METHODS (HELPER) ---

        private function getFilteredQuery()
    {
        $user = Auth::user();
        $query = \App\Models\Sales\vsv\rka\TargetDoBySoi::query();

        if (!$user || $user->is_admin || $user->is_admin_stock || in_array(strtolower($user->role ?? ''), ['admin', 'om', 'admin dca', 'om dca', 'admin stock', ''])) {
            return $query->orderBy('id', 'desc');
        }

        $cabang = $user->cabang ?: ($user->branch ?: 'Ciawi');
        return $query->where('cabang', $cabang)->orderBy('id', 'desc');
    }

    

    public function index()
    {
        $data = $this->getFilteredQuery()->get();
        return view('sales.vsv.rka.target_do_by_soi.index', compact('data'));
    }

    public function create()
    {
        // Role check relaxed for all authenticated users

        $sources = [
            'Call In (dari Iklan)', 'Canvasing', 'Data Base', 'Digital Hyperlocal',
            'Digital Non Hyperlocal', 'Exhibition', 'Media Digital', 'Media Elektronik',
            'Mediator', 'Referensi', 'Referensi Customer', 'Showroom Activity',
            'Showroom Walk-in', 'Website Dealer'
        ];

        return view('sales.vsv.rka.target_do_by_soi.create', compact('sources'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        // Role check relaxed for all authenticated users

        // Validasi disamakan, bulan menjadi nullable (biar kalau dikosongin nggak error)
        $request->validate([
            'tahun' => 'required|numeric',
            'source_inquiry' => 'required|string',
            'jan' => 'nullable|numeric', 'feb' => 'nullable|numeric', 'mar' => 'nullable|numeric',
            'apr' => 'nullable|numeric', 'mei' => 'nullable|numeric', 'jun' => 'nullable|numeric',
            'jul' => 'nullable|numeric', 'agu' => 'nullable|numeric', 'sep' => 'nullable|numeric',
            'okt' => 'nullable|numeric', 'nov' => 'nullable|numeric', 'des' => 'nullable|numeric',
        ]);

        $months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        $monthlyData = [];
        $total = 0;

        foreach ($months as $m) {
            $val = $request->input($m, 0) ?: 0; 
            $monthlyData[$m] = $val;
            $total += $val;
        }

        // Cek Duplikat!
        $existingData = TargetDoBySoi::where('source_inquiry', $request->source_inquiry)
            ->where('tahun', $request->tahun)
            ->where('user_id', $user->id)
            ->first();

        if ($existingData) {
            return back()->with('error', 'Target DO untuk Source Inquiry ini di tahun tersebut sudah ada di akun Anda!');
        }

        try {
            TargetDoBySoi::create(array_merge([
                'source_inquiry' => $request->source_inquiry,
                'tahun'          => $request->tahun,
                'cabang'         => $user->cabang,
                                'total'          => $total,
            ], $monthlyData));
            
            return redirect()->route('rka.target-do-by-soi.index')->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            Log::error("Error Store TargetDoBySoi: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data.');
        }
    }

    public function edit($id)
    {
        $data = TargetDoBySoi::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($data, $user)) {
            return redirect()->route('rka.target-do-by-soi.index')->with('error', 'Akses dilarang.');
        }

        $sources = [
            'Call In (dari Iklan)', 'Canvasing', 'Data Base', 'Digital Hyperlocal',
            'Digital Non Hyperlocal', 'Exhibition', 'Media Digital', 'Media Elektronik',
            'Mediator', 'Referensi', 'Referensi Customer', 'Showroom Activity',
            'Showroom Walk-in', 'Website Dealer'
        ];

        return view('sales.vsv.rka.target_do_by_soi.edit', compact('data', 'sources'));
    }

    public function update(Request $request, $id)
    {
        $data = TargetDoBySoi::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($data, $user)) {
             return redirect()->route('rka.target-do-by-soi.index')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'jan' => 'nullable|numeric', 'feb' => 'nullable|numeric', 'mar' => 'nullable|numeric',
            'apr' => 'nullable|numeric', 'mei' => 'nullable|numeric', 'jun' => 'nullable|numeric',
            'jul' => 'nullable|numeric', 'agu' => 'nullable|numeric', 'sep' => 'nullable|numeric',
            'okt' => 'nullable|numeric', 'nov' => 'nullable|numeric', 'des' => 'nullable|numeric',
        ]);

        $months = ['jan','feb','mar','apr','mei','jun','jul','agu','sep','okt','nov','des'];
        
        $monthlyData = [];
        $total = 0;

        foreach ($months as $m) {
            $val = $request->input($m, 0) ?: 0;
            $monthlyData[$m] = $val;
            $total += $val;
        }

        $data->update(array_merge(
            $monthlyData,
            ['total' => $total]
        ));

        return redirect()->route('rka.target-do-by-soi.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $data = TargetDoBySoi::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($data, $user)) {
            return redirect()->route('rka.target-do-by-soi.index')->with('error', 'Akses ditolak.');
        }

        $data->delete();
        return redirect()->route('rka.target-do-by-soi.index')->with('success', 'Data berhasil dihapus');
    }

    public function exportPdf()
    {
        $data = $this->getFilteredQuery()->get();
        $pdf = Pdf::loadView('rka.target_do_by_soi.pdf', compact('data'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Target-DO-By-SOI.pdf');
    }

    public function exportExcel()
    {
        ini_set('memory_limit', '512M'); 
        return Excel::download(new TargetDoBySoiExport, 'Target-DO-By-SOI.xlsx');
    }
}