<?php

namespace App\Http\Controllers\Sales\vsv\activity;

use App\Http\Controllers\Controller;
use App\Models\Sales\vsv\activity\PlanActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PlanActivityExport;

class PlanActivityController extends Controller
{
        private function getFilteredQuery()
    {
        $user = Auth::user();
        $query = \App\Models\Sales\vsv\activity\PlanActivity::query();

        if (!$user || $user->is_admin || $user->is_admin_stock || in_array(strtolower($user->role ?? ''), ['admin', 'om', 'admin dca', 'om dca', 'admin stock', ''])) {
            return $query->orderBy('id', 'desc');
        }

        $cabang = $user->cabang ?: ($user->branch ?: 'Ciawi');
        return $query->where('cabang', $cabang)->orderBy('id', 'desc');
    }

    

    public function index()
    {
        $data = $this->getFilteredQuery()->get();
        return view('sales.vsv.activity.plan.index', compact('data'));
    }

    public function create()
    {
        // Role check relaxed for all authenticated users
        return view('sales.vsv.activity.plan.create');
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
        ], [
            'required' => ':attribute wajib diisi, tidak boleh kosong!',
        ]);

        $data = $request->all();
        $data['cabang'] = ($user->cabang ?: 'Ciawi');
        
        // Hitung Cost Otomatis
        $total = $request->total_cost ?? 0;
        $data['cost_p']   = ($request->actual_p > 0)   ? $total / $request->actual_p   : 0;
        $data['cost_spk'] = ($request->actual_spk > 0) ? $total / $request->actual_spk : 0;
        $data['cost_do']  = ($request->actual_do > 0)  ? $total / $request->actual_do  : 0;

        PlanActivity::create($data);
        return redirect()->route('activity.plan.index')->with('success', 'Data Plan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $activity = PlanActivity::findOrFail($id);
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
        return redirect()->route('activity.plan.index')->with('success', 'Data Plan berhasil diupdate');
    }

    public function destroy($id)
    {
        $activity = PlanActivity::findOrFail($id);
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
        return redirect()->route('activity.plan.index')->with('success', 'Data Plan berhasil dihapus');
    }

    public function exportPdf()
    {
        $data = $this->getFilteredQuery()->get();
        return Pdf::loadView('activity.plan.pdf', compact('data'))
                    ->setPaper('a4', 'landscape')
                    ->download('Laporan-Plan-Activity.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new PlanActivityExport, 'Plan-Activity.xlsx');
    }
}