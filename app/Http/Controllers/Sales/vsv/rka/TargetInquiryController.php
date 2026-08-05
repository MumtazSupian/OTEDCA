<?php

namespace App\Http\Controllers\Sales\vsv\rka;

use App\Http\Controllers\Controller;
use App\Models\Sales\vsv\rka\TargetInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TargetInquiryExport;

class TargetInquiryController extends Controller
{
    // --- PRIVATE METHODS (HELPER) ---

        private function getFilteredQuery()
    {
        $user = Auth::user();
        $query = \App\Models\Sales\vsv\rka\TargetInquiry::query();

        if (!$user || $user->is_admin || $user->is_admin_stock || in_array(strtolower($user->role ?? ''), ['admin', 'om', 'admin dca', 'om dca', 'admin stock', ''])) {
            return $query->orderBy('id', 'desc');
        }

        $cabang = $user->cabang ?: ($user->branch ?: 'Ciawi');
        return $query->where('cabang', $cabang)->orderBy('id', 'desc');
    }

    

    public function index()
    {
        $data = $this->getFilteredQuery()->get();
        return view('sales.vsv.rka.target_inquiries.index', compact('data'));
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

        return view('sales.vsv.rka.target_inquiries.create', compact('sources'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        // Role check relaxed for all authenticated users

        // Validasi disamakan dengan TargetDoUnit
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
            // Ambil input per bulan, default 0 jika kosong
            $val = $request->input($m, 0) ?: 0; 
            $monthlyData[$m] = $val;
            $total += $val;
        }

        // Cek duplikat data berdasarkan User ID (Mencegah data tertimpa!)
        $existingData = TargetInquiry::where('source_inquiry', $request->source_inquiry)
            ->where('tahun', $request->tahun)
            ->where('user_id', $user->id) 
            ->first();

        if ($existingData) {
            return back()->with('error', 'Target untuk Source Inquiry ini di tahun tersebut sudah ada di akun Anda!');
        }

        // Simpan data baru
        TargetInquiry::create(array_merge([
            'source_inquiry' => $request->source_inquiry,
            'tahun'          => $request->tahun,
            'cabang'         => $user->cabang,
                        'total'          => $total,
        ], $monthlyData));

        return redirect()->route('rka.target-inquiries.index')->with('success', 'Data berhasil disimpan.');
    }

    public function edit($id)
    {
        $data = TargetInquiry::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($data, $user)) {
            return redirect()->route('rka.target-inquiries.index')->with('error', 'Akses dilarang.');
        }

        return view('sales.vsv.rka.target_inquiries.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = TargetInquiry::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($data, $user)) {
            return redirect()->route('rka.target-inquiries.index')->with('error', 'Akses dilarang.');
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

        return redirect()->route('rka.target-inquiries.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $data = TargetInquiry::findOrFail($id);
        $user = Auth::user();

        if (!$this->checkAccess($data, $user)) {
            return redirect()->route('rka.target-inquiries.index')->with('error', 'Akses dilarang.');
        }

        $data->delete();
        return redirect()->route('rka.target-inquiries.index')->with('success', 'Data berhasil dihapus');
    }

    public function exportPdf()
    {
        $data = $this->getFilteredQuery()->get();
        return Pdf::loadView('rka.target_inquiries.pdf', compact('data'))
            ->setPaper('a4', 'landscape')
            ->download('Laporan-Target-Inquiries.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new TargetInquiryExport, 'Target-Inquiries.xlsx');
    }
}