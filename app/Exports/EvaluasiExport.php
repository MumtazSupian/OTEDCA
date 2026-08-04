<?php

namespace App\Exports;

use App\Models\evaluasi\EvaluasiWiraniaga;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EvaluasiExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $user = Auth::user();
        $pusatRoles = ['Admin', 'OM', 'Admin DCA', 'OM DCA'];
        $query = EvaluasiWiraniaga::query();

        if (in_array($user->role, $pusatRoles)) {
            $data = $query->orderBy('nama_sales')->get();
        } elseif ($user->role === 'BM') {
            $data = $query->where('cabang', $user->cabang)->orderBy('nama_sales')->get();
        } elseif ($user->role === 'SH') {
            $data = $query->where('user_id', $user->id)->orderBy('nama_sales')->get();
        } else {
            $data = $query->where('cabang', $user->cabang)->orderBy('nama_sales')->get();
        }

        return view('evaluasi.export_excel', [
            'data' => $data,
            'grandTotal' => $data->sum('total')
        ]);
    }
}
