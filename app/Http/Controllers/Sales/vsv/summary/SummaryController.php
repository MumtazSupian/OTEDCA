<?php

namespace App\Http\Controllers\Sales\vsv\summary;

use App\Http\Controllers\Controller;
use App\Models\Sales\vsv\summary\Summary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SummaryExport;
use Barryvdh\DomPDF\Facade\Pdf;

class SummaryController extends Controller
{
    private function getFilteredQuery()
    {
        $user = Auth::user();
        $pusatRoles = ['Admin', 'OM', 'Admin DCA', 'OM DCA'];
        $query = Summary::query();

        if (in_array($user->role, $pusatRoles)) {
            return $query;
        } elseif ($user->role === 'BM') {
            return $query->where('cabang', $user->cabang);
        } elseif ($user->role === 'SH') {
            return $query->where('user_id', $user->id);
        }
        return $query->where('cabang', $user->cabang);
    }

    public function index()
    {
        $summaries = $this->getFilteredQuery()->get();
        return view('sales.vsv.summary.summary.index', compact('summaries'));
    }

    public function create()
    {
        return view('sales.vsv.summary.summary.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'operasional' => 'required|in:Jumlah Sales Force by Grading,Jumlah Inquiry by Type,Jumlah Activity by Type,Source Of Inquiry,Issue,Usulan',
            'do_dont' => 'nullable|in:X,V',
        ]);

        Summary::create([
            'operasional'      => $request->operasional,
            'plan_perbaikan'   => $request->plan_perbaikan,
            'aktual_perbaikan' => $request->aktual_perbaikan,
            'do_dont'          => $request->do_dont,
            'cabang'           => $user->cabang,
            'user_id'          => $user->id,
        ]);

        return redirect()->route('summary.summary.index')->with('success', 'Data berhasil disimpan');
    }

    public function edit($id)
    {
        $summary = Summary::findOrFail($id);
        if (Auth::user()->role == 'SH' && $summary->user_id != Auth::id()) {
            return redirect()->route('summary.summary.index')->with('error', 'Akses dilarang!');
        }
        return view('sales.vsv.summary.summary.edit', compact('summary'));
    }

    public function update(Request $request, $id)
    {
        $summary = Summary::findOrFail($id);
        if (Auth::user()->role == 'SH' && $summary->user_id != Auth::id()) {
            return redirect()->route('summary.summary.index')->with('error', 'Update ditolak.');
        }

        $summary->update($request->all());

        return redirect()->route('summary.summary.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $summary = Summary::findOrFail($id);
        if (Auth::user()->role == 'SH' && $summary->user_id != Auth::id()) {
            return redirect()->route('summary.summary.index')->with('error', 'Hapus ditolak.');
        }

        $summary->delete();
        return redirect()->route('summary.summary.index')->with('success', 'Data berhasil dihapus');
    }

    public function exportExcel()
    {
        return Excel::download(new SummaryExport, 'summary-improvement.xlsx');
    }

    public function exportPdf()
    {
        $summaries = $this->getFilteredQuery()->get();
        $pdf = Pdf::loadView('summary.summary.export_pdf', compact('summaries'))
                  ->setPaper('a4', 'landscape');
        return $pdf->download('summary-improvement.pdf');
    }
}