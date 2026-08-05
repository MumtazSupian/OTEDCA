<?php

namespace App\Http\Controllers\Sales\vsv\activity;

use App\Http\Controllers\Controller;
use App\Models\Sales\vsv\activity\ActualActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ActualActivityExport;

class ActualActivityController extends Controller
{
        private function getFilteredQuery()
    {
        $user = Auth::user();
        $query = \App\Models\Sales\vsv\activity\ActualActivity::query();

        if (!$user || $user->is_admin || $user->is_admin_stock || in_array(strtolower($user->role ?? ''), ['admin', 'om', 'admin dca', 'om dca', 'admin stock', ''])) {
            return $query->orderBy('id', 'desc');
        }

        $cabang = $user->cabang ?: ($user->branch ?: 'Ciawi');
        return $query->where('cabang', $cabang)->orderBy('id', 'desc');
    }

    

    public function index()
    {
        $data = $this->getFilteredQuery()->get();
        return view('sales.vsv.activity.actual.index', compact('data'));
    }

    public function create()
    {
        // Role check relaxed for all authenticated users
        return view('sales.vsv.activity.actual.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        // Role check relaxed for all authenticated users

        // --- VALIDASI WAJIB ISI ---
        $request->validate([
            'jenis_activity'  => 'required',
            'activity'        => 'required',
            'platform_lokasi' => 'required',
            'jenis_unit'      => 'required',
            'type_unit'       => 'required',
            'tanggal'         => 'required|date',
            'jam'             => 'required',
            'pic'             => 'required',
            'jml_sales_shift' => 'required',
            'total_cost'      => 'required|numeric',
        ]);

        $data = $request->all();
        $data['cabang'] = ($user->cabang ?: 'Ciawi');
         

        $total = $request->total_cost ?? 0;
        $data['cost_p']   = ($request->actual_p > 0)   ? $total / $request->actual_p   : 0;
        $data['cost_spk'] = ($request->actual_spk > 0) ? $total / $request->actual_spk : 0;
        $data['cost_do']  = ($request->actual_do > 0)  ? $total / $request->actual_do  : 0;

        ActualActivity::create($data);
        return redirect()->route('activity.actual.index')->with('success', 'Data Actual berhasil ditambahkan');
    }

    public function edit($id)
    {
        $activity = ActualActivity::findOrFail($id);
        $user = Auth::user();
        $pusatRoles = ['Admin', 'OM', 'Admin DCA', 'OM DCA'];

        if ($user->role === 'SH' && $activity->user_id != $user->id) {
            abort(403, 'Anda hanya bisa mengedit data milik sendiri!');
        } elseif ($user->role === 'BM' && $activity->cabang != $user->cabang) {
            abort(403, 'Akses dilarang. Beda cabang.');
        } elseif (!in_array($user->role, array_merge(['SH', 'BM', 'Admin', 'OM', 'Admin DCA', 'OM DCA', 'Admin Stock', ''], $pusatRoles)) && !$user->is_admin) {
            abort(403, 'Akses dilarang.');
        }

        return view('sales.vsv.activity.actual.edit', compact('activity'));
    }

    public function update(Request $request, $id)
    {
        $activity = ActualActivity::findOrFail($id);
        $user = Auth::user();
        $pusatRoles = ['Admin', 'OM', 'Admin DCA', 'OM DCA'];

        if ($user->role === 'SH' && $activity->user_id != $user->id) {
            abort(403, 'Anda hanya bisa mengedit data milik sendiri!');
        } elseif ($user->role === 'BM' && $activity->cabang != $user->cabang) {
            abort(403, 'Akses dilarang. Beda cabang.');
        } elseif (!in_array($user->role, array_merge(['SH', 'BM', 'Admin', 'OM', 'Admin DCA', 'OM DCA', 'Admin Stock', ''], $pusatRoles)) && !$user->is_admin) {
            abort(403, 'Akses dilarang.');
        }

        // --- VALIDASI WAJIB ISI SAAT EDIT ---
        $request->validate([
            'platform_lokasi' => 'required',
            'pic'             => 'required',
            'jml_sales_shift' => 'required',
            'total_cost'      => 'required|numeric',
        ]);

        $data = $request->all();
        $total = $request->total_cost ?? 0;
        $data['cost_p']   = ($request->actual_p > 0)   ? $total / $request->actual_p   : 0;
        $data['cost_spk'] = ($request->actual_spk > 0) ? $total / $request->actual_spk : 0;
        $data['cost_do']  = ($request->actual_do > 0)  ? $total / $request->actual_do  : 0;

        $activity->update($data);
        return redirect()->route('activity.actual.index')->with('success', 'Data Actual berhasil diupdate');
    }

    public function destroy($id)
    {
        $activity = ActualActivity::findOrFail($id);
        $user = Auth::user();
        $pusatRoles = ['Admin', 'OM', 'Admin DCA', 'OM DCA'];

        if ($user->role === 'SH' && $activity->user_id != $user->id) {
            abort(403, 'Anda hanya bisa menghapus data milik sendiri!');
        } elseif ($user->role === 'BM' && $activity->cabang != $user->cabang) {
            abort(403, 'Akses dilarang. Beda cabang.');
        } elseif (!in_array($user->role, array_merge(['SH', 'BM', 'Admin', 'OM', 'Admin DCA', 'OM DCA', 'Admin Stock', ''], $pusatRoles)) && !$user->is_admin) {
            abort(403, 'Akses dilarang.');
        }

        $activity->delete();
        return redirect()->route('activity.actual.index')->with('success', 'Data Actual berhasil dihapus');
    }

    public function exportExcel()
    {
        return Excel::download(new ActualActivityExport, 'Actual-Activity.xlsx');
    }

    public function exportPdf()
    {
        $data = $this->getFilteredQuery()->get();
        return Pdf::loadView('activity.actual.pdf', compact('data'))
                    ->setPaper('a4', 'landscape')
                    ->download('Laporan-Actual-Activity.pdf');
    }
}