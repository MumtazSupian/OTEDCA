<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class StockEmailExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $stocks;

    public function __construct($stocks)
    {
        $this->stocks = $stocks;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->stocks;
    }

    public function headings(): array
    {
        $headings = [
            'NO DO',
            'TANGGAL DO',
            'KODE MOBIL',
            'NAMA MOBIL',
            'VARIAN',
            'WARNA',
            'TAHUN',
            'CHASSIS CODE',
            'NO RANGKA',
            'ENGINECODE',
            'NO MESIN',
            'FAKTUR',
            'BLN NAIK',
            'LOKASI',
        ];



        $headings = array_merge($headings, [
            'STATUS',
            'CABANG',
        ]);

        return $headings;
    }

    public function map($stock): array
    {
        $row = [
            $stock->no_do,
            $stock->tanggal_do ? Carbon::parse($stock->tanggal_do)->format('d-M-Y') : '-',
            $stock->kode_mobil,
            $stock->nama_mobil,
            $stock->varian,
            $stock->warna,
            $stock->tahun,
            $stock->chassis_code,
            $stock->norangka,
            $stock->engine_code,
            $stock->nomesin,
            $stock->faktur,
            $stock->bln_naik_faktur,
            strtoupper($stock->lokasi),
        ];



        $row = array_merge($row, [
            strtoupper($stock->status ?? '-'),
            strtoupper($stock->cabang),
        ]);

        return $row;
    }
}
