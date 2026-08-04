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
        $pusatRoles = ['Admin', 'OM', 'Admin DCA', 'OM DCA'];
        $query = PlanActivity::query();

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
        if (!in_array($user->role, ['BM', 'SH', 'Admin', 'OM', 'Admin DCA', 'OM DCA'])) {
            return redirect()->route('activity.plan.index')->with('error', 'Akses dibatasi.');
        }

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
        $data['cabang'] = $user->cabang;
        $data['user_id'] = $user->id;

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
        } elseif (!in_array($user->role, array_merge(['SH', 'BM'], $pusatRoles))) {
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
        } elseif (!in_array($user->role, array_merge(['SH', 'BM'], $pusatRoles))) {
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