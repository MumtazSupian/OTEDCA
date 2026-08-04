<?php

namespace App\Exports;

use App\Models\Sales\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StockExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    private $rowNumber = 0;
    private $stocks;

    public function __construct($stocks = null)
    {
        $this->stocks = $stocks ?? Stock::all();
    }

    public function collection()
    {
        return collect($this->stocks);
    }

    public function headings(): array
    {
        return [
            'NO', 'NO DO', 'TANGGAL DO', 'KODE MOBIL', 'NAMA MOBIL', 'VARIAN', 
            'WARNA', 'TAHUN', 'CHASSIS CODE', 'NO RANGKA', 'ENGINE CODE', 
            'NO MESIN', 'FAKTUR', 'BLN NAIK FAKTUR', 'HARGA', 'KPT + KF', 
            'ACS2', 'SUBSIDI', 'HPP', 'LOKASI', 'ESTIMASI MASUK GUDANG', 
            'STATUS', 'LAIN-LAIN', 'PENJUALAN', 'TANGGAL MATCHING/DO', 'CABANG', 
            'KETERANGAN', 'UNIT',
        ];
    }

    public function map($stock): array
    {
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $stock->no_do,
            $stock->tanggal_do,
            $stock->kode_mobil,
            $stock->nama_mobil,
            $stock->varian,
            $stock->warna,
            $stock->tahun,
            $stock->chassis_code,
            $stock->norangka,
            $stock->enginecode,
            $stock->nomesin,
            $stock->faktur,
            $stock->bln_naik_faktur,
            $stock->harga,
            $stock->kpt_kf,
            $stock->acs2,
            $stock->subsidi,
            $stock->hpp,
            $stock->lokasi,
            $stock->estimasi_unit_masuk_gudang_dca,
            $stock->status,
            $stock->lain_lain,
            $stock->penjualan,
            $stock->tanggal_matching_do,
            $stock->cabang,
            $stock->keterangan,
            $stock->unit,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'O' => '#,##0', // HARGA
            'P' => '#,##0', // KPT + KF
            'Q' => '#,##0', // ACS2
            'R' => '#,##0', // SUBSIDI
            'S' => '#,##0', // HPP
            'J' => '@',     // NO RANGKA sebagai text murni
            'L' => '@',     // NO MESIN sebagai text murni
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Beri style tebal pada Header (baris pertama)
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFEAEAEA']
                ]
            ],
        ];
    }
}
