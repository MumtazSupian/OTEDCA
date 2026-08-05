<?php

namespace App\Http\Controllers\Sales\vsv\summary;

use App\Http\Controllers\Controller;
use App\Models\Sales\vsv\summary\SummaryAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\SummaryActionExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class SummaryActionController extends Controller
{
        private function getFilteredQuery()
    {
        $user = Auth::user();
        $query = \App\Models\Sales\vsv\summary\SummaryAction::query();

        if (!$user || $user->is_admin || $user->is_admin_stock || in_array(strtolower($user->role ?? ''), ['admin', 'om', 'admin dca', 'om dca', 'admin stock', ''])) {
            return $query->orderBy('id', 'desc');
        }

        $cabang = $user->cabang ?: ($user->branch ?: 'Ciawi');
        return $query->where('cabang', $cabang)->orderBy('id', 'desc');
    }

    

    public function index()
    {
        $summary_actions = $this->getFilteredQuery()->get();
        return view('sales.vsv.summary.summaryaction.index', compact('summary_actions'));
    }

    public function create()
    {
        return view('sales.vsv.summary.summaryaction.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'operasional' => 'required|string',
            'do_dont' => 'nullable|in:X,V',
        ]);

        SummaryAction::create([
            'operasional'      => $request->operasional,
            'kondisi_yang_ada' => $request->kondisi_yang_ada,
            'action_perbaikan' => $request->action_perbaikan,
            'do_dont'          => $request->do_dont,
            'cabang'           => ($user->cabang ?: 'Ciawi'),
                    ]);

        return redirect()->route('summary.summaryaction.index')->with('success', 'Data berhasil disimpan');
    }

    public function edit($id)
    {
        $summary_actions = SummaryAction::findOrFail($id);
        if (Auth::user()->role == 'SH' && $summary_actions->user_id != Auth::id()) {
            return redirect()->route('summary.summaryaction.index')->with('error', 'Akses dilarang!');
        }
        return view('sales.vsv.summary.summaryaction.edit', compact('summary_actions'));
    }

    public function update(Request $request, $id)
    {
        $summary_actions = SummaryAction::findOrFail($id);
        if (Auth::user()->role == 'SH' && $summary_actions->user_id != Auth::id()) {
            return redirect()->route('summary.summaryaction.index')->with('error', 'Update ditolak.');
        }

        $summary_actions->update($request->all());
        return redirect()->route('summary.summaryaction.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $summary_actions = SummaryAction::findOrFail($id);
        if (Auth::user()->role == 'SH' && $summary_actions->user_id != Auth::id()) {
            return redirect()->route('summary.summaryaction.index')->with('error', 'Hapus ditolak.');
        }

        $summary_actions->delete();
        return redirect()->route('summary.summaryaction.index')->with('success', 'Data berhasil dihapus');
    }

    public function exportExcel()
    {
        return Excel::download(new SummaryActionExport, 'summary-action.xlsx');
    }

    public function exportPdf()
    {
        $actions = $this->getFilteredQuery()->get();
        $pdf = Pdf::loadView('summary.summaryaction.export_pdf', compact('actions'))
                  ->setPaper('a4', 'landscape');
        return $pdf->download('summary-action.pdf');
    }
}