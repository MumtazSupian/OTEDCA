<?php

namespace App\Exports;

use App\Models\summary\Summary;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\Auth;

class SummaryExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $user = Auth::user();
        $pusatRoles = ['Admin', 'OM', 'Admin DCA', 'OM DCA'];
        $query = \App\Models\summary\Summary::query(); 

        if (in_array($user->role, $pusatRoles)) {
            $data = $query->get();
        } elseif ($user->role === 'BM') {
            $data = $query->where('cabang', $user->cabang)->get();
        } elseif ($user->role === 'SH') {
            $data = $query->where('user_id', $user->id)->get();
        } else {
            $data = $query->where('cabang', $user->cabang)->get();
        }

        return view('summary.summary.export_excel', ['summaries' => $data]); 
    }
}
