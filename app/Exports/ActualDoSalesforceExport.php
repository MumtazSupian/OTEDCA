<?php

namespace App\Exports;

use App\Models\current\ActualDoSalesforce;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\Auth;

class ActualDoSalesforceExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $user = Auth::user();
        $query = ActualDoSalesforce::query();

        if (in_array($user->role, ['Admin', 'OM', 'Admin DCA', 'OM DCA'])) {
            // Pusat
        } elseif ($user->role === 'BM') {
            $query->where('cabang', $user->cabang);
        } elseif ($user->role === 'SH') {
            $query->where('user_id', $user->id);
        } else {
            $query->where('cabang', $user->cabang);
        }

        $data = $query->get();
        $months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        
        $grandTotals = [];
        foreach ($months as $m) {
            $grandTotals[$m] = $data->sum($m);
        }

        return view('current.actual_do_salesforces.pdf', [
            'data' => $data,
            'months' => $months,
            'grandTotals' => $grandTotals,
            'grandTotalAll' => $data->sum('total'),
            'isExcel' => true
        ]);
    }
}