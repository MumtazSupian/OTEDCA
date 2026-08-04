<?php

namespace App\Exports;

use App\Models\leasing\AktualPo;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet; 
use PhpOffice\PhpSpreadsheet\Style\Border;       
use Illuminate\Support\Facades\Auth;

class AktualPoExport implements FromView, ShouldAutoSize, WithStyles
{
    public function view(): View
    {
        $user = Auth::user();
        $pusatRoles = ['Admin', 'OM', 'Admin DCA', 'OM DCA'];
        $query = AktualPo::query();

        if (in_array($user->role, $pusatRoles)) {
        } elseif ($user->role === 'BM') {
            $query->where('cabang', $user->cabang);
        } elseif ($user->role === 'SH') {
            $query->where('user_id', $user->id);
        } else {
            $query->where('cabang', $user->cabang);
        }

        return view('leasing.aktual_po.pdf', ['data' => $query->get()]);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle($sheet->calculateWorksheetDimension())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
    }
}