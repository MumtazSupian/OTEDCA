<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Collection;

class InUnitExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $inUnits;

    public function __construct($inUnits)
    {
        $this->inUnits = $inUnits;
    }

    public function collection()
    {
        return collect($this->inUnits->map(function ($u) {
            return [
                'id' => $u->id ?? null,
                'nama_driver' => $u->nama_driver ?? null,
                'tanggal' => $u->tanggal ? $u->tanggal->format('Y-m-d') : null,
                'type' => $u->type ?? null,
                'warna' => $u->warna ?? null,
                'no_rangka' => $u->no_rangka ?? null,
                'no_mesin' => $u->no_mesin ?? null,
                'lokasi_pengambilan' => $u->lokasi_pengambilan ?? null,
                'cabang' => isset($u->cabang) ? ($u->cabang->nama ?? null) : null,
                'cekits' => $u->cekits ?? null,
                'jam_kedatangan' => $u->jam_kedatangan ?? null,
            ];
        }));
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Driver',
            'Tanggal',
            'Type',
            'Warna',
            'No Rangka',
            'No Mesin',
            'Lokasi Pengambilan',
            'Cabang',
            'Cekits',
            'Jam Kedatangan',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Header style
                $sheet->getStyle('A1:K1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F2F2F2'],
                    ],
                    'borders' => [
                        'bottom' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'DDDDDD'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Freeze header
                $sheet->freezePane('A2');

                // Date column format (C)
                $sheet->getStyle('C2:C1000')->getNumberFormat()->setFormatCode('yyyy-mm-dd');

                // Wrap text for Type and Lokasi
                $sheet->getStyle('D2:D1000')->getAlignment()->setWrapText(true);
                $sheet->getStyle('H2:H1000')->getAlignment()->setWrapText(true);

                // Set vertical alignment for all cells
                $sheet->getStyle('A2:K1000')->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
            },
        ];
    }
}
