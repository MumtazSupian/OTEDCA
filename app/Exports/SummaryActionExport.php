<?php

namespace App\Exports;

use App\Models\summary\SummaryAction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\Auth;

class SummaryActionExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $user = Auth::user();
        $pusatRoles = ['Admin', 'OM', 'Admin DCA', 'OM DCA'];
        
        $query = SummaryAction::query();

        if (in_array($user->role, $pusatRoles)) {
            $actions = $query->orderBy('cabang')->get();
        } elseif ($user->role === 'BM') {
            $actions = $query->where('cabang', $user->cabang)
                             ->orderBy('id', 'desc')
                             ->get();
        } elseif ($user->role === 'SH') {
            $actions = $query->where('user_id', $user->id)
                             ->orderBy('id', 'desc')
                             ->get();
        } else {
            $actions = $query->where('cabang', $user->cabang)->get();
        }

        return view('summary.summaryaction.export_excel', [
            'actions' => $actions
        ]);
    }
}