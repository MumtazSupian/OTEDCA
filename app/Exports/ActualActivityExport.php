<?php

namespace App\Exports;

use App\Models\activity\ActualActivity;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Support\Facades\Auth;

class ActualActivityExport implements FromView, ShouldAutoSize, WithStyles
{
    public function view(): View
    {
        $user = Auth::user();
        $pusatRoles = ['Admin', 'OM', 'Admin DCA', 'OM DCA'];
        $query = \App\Models\Activity\ActualActivity::query();

        if (in_array($user->role, $pusatRoles)) {
            $data = $query->get();
        } elseif ($user->role === 'BM') {
            $data = $query->where('cabang', $user->cabang)->get();
        } elseif ($user->role === 'SH') {
            $data = $query->where('user_id', $user->id)->get();
        } else {
            $data = $query->where('cabang', $user->cabang)->get();
        }

        return view('activity.actual.pdf', ['data' => $data]);
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();

        $sheet->getStyle('A3:W' . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        return [
            1 => ['font' => ['bold' => true, 'size' => 16], 'alignment' => ['horizontal' => 'center']],
        ];
    }
}