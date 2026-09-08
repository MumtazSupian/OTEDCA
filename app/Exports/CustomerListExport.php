<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class CustomerListExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithColumnFormatting, WithTitle, WithCustomValueBinder
{
    private $rowNumber = 0;
    private $customers;

    public function bindValue(Cell $cell, $value)
    {
        if (in_array($cell->getColumn(), ['D', 'G', 'H'])) {
            $cell->setValueExplicit((string)$value, DataType::TYPE_STRING);
            return true;
        }

        return parent::bindValue($cell, $value);
    }

    public function __construct($customers = [])
    {
        $this->customers = $customers;
    }

    public function collection()
    {
        return collect($this->customers);
    }

    public function title(): string
    {
        return 'Customer Database';
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Tipe',
            'NIK',
            'Gender',
            'Tgl Lahir',
            'HP',
            'HP 2',
            'Email',
            'Alamat',
            'Kelurahan',
            'Kecamatan',
            'Kota',
            'Provinsi',
            'Sumber Data',
            'Kendaraan',
            'Transaksi Terakhir',
            'Service Terakhir',
            'Status Review',
        ];
    }

    public function map($row): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $row['nama'] ?? '-',
            $row['tipe'] ?? 'Personal',
            $row['nik'] ?? '-',
            $row['gender'] ?? '-',
            $row['tgl_lahir'] ?? '-',
            $row['hp'] ?? '-',
            $row['hp_2'] ?? '-',
            $row['email'] ?? '-',
            $row['alamat'] ?? '-',
            $row['kelurahan'] ?? '-',
            $row['kecamatan'] ?? '-',
            $row['kota'] ?? '-',
            $row['provinsi'] ?? 'JAWA BARAT',
            $row['sumber_data'] ?? '-',
            (int)($row['kendaraan'] ?? 1),
            $row['transaksi_terakhir'] ?? '-',
            $row['service_terakhir'] ?? '-',
            $row['status_review'] ?? 'Bersih',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => '@',       // NIK (Text agar awalan 0 & 16 digit utuh)
            'G' => '@',       // HP (Text)
            'H' => '@',       // HP 2 (Text)
            'P' => '#,##0',   // Kendaraan (Angka)
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->freezePane('A2');

        $sheet->setAutoFilter('A1:S1');

        $sheet->getStyle('A1:S1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
                'size' => 10.5,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF1E5627'], 
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF143D1B'],
                ],
            ],
        ]);

        $sheet->getRowDimension(1)->setRowHeight(26);

        return [];
    }
}
