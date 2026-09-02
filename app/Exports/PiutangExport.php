<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;

class PiutangExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    private $rowNumber = 0;
    private $records;
    private $branchTitle;
    private $rowStyles = [];

    public function __construct($records, $branchTitle = 'AR')
    {
        $this->records = $records;
        $this->branchTitle = $branchTitle;
    }

    public function collection()
    {
        return collect($this->records);
    }

    public function headings(): array
    {
        return [
            'NO',
            'NO SPK',
            'NAMA KONSUMEN',
            'TGL. BUKTI',
            'NO. INVOICE',
            'KATEGORI SPK',
            'NAMA ASURANSI',
            'SALDO AWAL',
            'MUTASI DEBET',
            'MUTASI KREDIT',
            'TGL. BUKTI',
            'KETERANGAN',
            'TGL. BUKTI TAHAP 2',
            'KETERANGAN TAHAP 2',
            'TGL. BUKTI TAHAP 3',
            'KETERANGAN TAHAP 3',
            'SALDO AKHIR',
            'NO POLISI',
            'NO POLIS'
        ];
    }

    public function map($row): array
    {
        $this->rowNumber++;
        $currentRowIndex = $this->rowNumber + 1; // Row 1 is header

        $rawTglBukti = $row->tgl_bukti ?? null;
        $rawTglRek = $row->tgl_bukti_rek ?? null;
        $rawTglRek2 = $row->tgl_bukti_rek_2 ?? null;
        $rawTglRek3 = $row->tgl_bukti_rek_3 ?? null;

        $tglBukti = $rawTglBukti ? Carbon::parse($rawTglBukti)->format('d F Y') : '-';
        $tglRek = $rawTglRek ? Carbon::parse($rawTglRek)->format('d F Y') : '-';
        $tglRek2 = $rawTglRek2 ? Carbon::parse($rawTglRek2)->format('d F Y') : '-';
        $tglRek3 = $rawTglRek3 ? Carbon::parse($rawTglRek3)->format('d F Y') : '-';

        $saldoAwal = (float) ($row->saldo_awal ?? 0);
        $debet = (float) ($row->debet ?? 0);
        $kredit = (float) (($row->kredit ?? 0) + ($row->kredit_2 ?? 0) + ($row->kredit_3 ?? 0));
        $saldoAkhir = (float) ($row->saldo_akhir ?? 0);

        $kategoriSpk = strtoupper($row->spk_type ?? ($row->tipe_konsumen ?? '-'));
        $namaAsuransi = !empty($row->nama_asuransi) ? $row->nama_asuransi : (!empty($row->perusahaan->nama) ? $row->perusahaan->nama : '-');

        // Check Color Status matching Web logic
        $bgColor = null;
        if ($rawTglBukti) {
            $hariIni = Carbon::now('Asia/Jakarta')->startOfDay();
            $tanggalInput = Carbon::parse($rawTglBukti, 'Asia/Jakarta')->startOfDay();
            $selisihHari = $tanggalInput->diffInDays($hariIni);

            if ($saldoAkhir <= 0) {
                $bgColor = 'FFFFFF';
            } else {
                if ($kategoriSpk === 'ASURANSI') {
                    $bgColor = ($selisihHari >= 35) ? 'F28888' : '86F7AF';
                } elseif ($kategoriSpk === 'REGULER') {
                    $bgColor = ($selisihHari >= 7) ? 'F28888' : '86F7AF';
                } elseif ($kategoriSpk === 'INTERNAL') {
                    $bgColor = 'FEF3C7';
                }
            }
        }

        if ($bgColor) {
            $this->rowStyles[$currentRowIndex] = $bgColor;
        }

        return [
            $this->rowNumber,
            $row->no_spk ?? '-',
            $row->nama_konsumen ?? '-',
            $tglBukti,
            $row->no_bukti ?? '-',
            $kategoriSpk,
            $namaAsuransi,
            $saldoAwal,
            $debet,
            $kredit,
            $tglRek,
            $row->keterangan ?? '-',
            $tglRek2,
            $row->keterangan_2 ?? '-',
            $tglRek3,
            $row->keterangan_3 ?? '-',
            $saldoAkhir,
            $row->no_polisi ?? '-',
            $row->no_polis ?? '-'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'H' => '#,##0', // Saldo Awal
            'I' => '#,##0', // Mutasi Debet
            'J' => '#,##0', // Mutasi Kredit
            'Q' => '#,##0', // Saldo Akhir
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $this->rowNumber + 1;

        // Apply Header Style
        $sheet->getStyle('A1:S1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
                'size' => 11
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF111A36'] // Dark Navy matching web
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ]);

        // Apply Borders
        $sheet->getStyle("A1:S{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF1E3A8A']
                ]
            ]
        ]);

        // Center alignments for ID/Dates/Codes
        $sheet->getStyle("A2:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B2:B{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("D2:F{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("K2:K{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("M2:M{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("O2:O{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("R2:S{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Apply Row Background Colors
        foreach ($this->rowStyles as $rowIndex => $colorHex) {
            $sheet->getStyle("A{$rowIndex}:S{$rowIndex}")->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF' . $colorHex]
                ],
                'font' => [
                    'bold' => ($colorHex !== 'FFFFFF'),
                    'color' => ['argb' => 'FF111827']
                ]
            ]);
        }

        return [];
    }
}
