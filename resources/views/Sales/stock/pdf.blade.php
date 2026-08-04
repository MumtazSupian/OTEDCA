<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Data Stock - PDF</title>
        <style>
        @page { size: A2 landscape; margin: 10mm; }
        body { font-family: sans-serif; font-size: 8px; } /* Huruf diperkecil karena kolom banyak */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #cbd5e1; padding: 2px 4px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>

</head>
<body>
    <h2 class="text-center">Laporan Data Stock</h2>
    <p class="text-center">Tanggal Cetak: {{ now()->format('d M Y H:i') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>NO DO</th>
                <th>TANGGAL DO</th>
                <th>KODE MOBIL</th>
                <th>NAMA MOBIL</th>
                <th>VARIAN</th>
                <th>WARNA</th>
                <th>TAHUN</th>
                <th>CHASSIS CODE</th>
                <th>NO RANGKA</th>
                <th>ENGINE CODE</th>
                <th>NO MESIN</th>
                <th>FAKTUR</th>
                <th>BLN NAIK FAKTUR</th>
                <th>HARGA</th>
                <th>KPT + KF</th>
                <th>ACS2</th>
                <th>SUBSIDI</th>
                <th>HPP</th>
                <th>LOKASI</th>
                <th>ESTIMASI MASUK GUDANG</th>
                <th>STATUS</th>
                <th>LAIN-LAIN</th>
                <th>PENJUALAN</th>
                <th>TANGGAL MATCHING/SOLD</th>
                <th>CABANG</th>
                <th>KETERANGAN</th>
                <th>UNIT</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $i => $item)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $item->no_do }}</td>
                    <td>{{ $item->tanggal_do }}</td>
                    <td>{{ $item->kode_mobil }}</td>
                    <td>{{ $item->nama_mobil }}</td>
                    <td>{{ $item->varian }}</td>
                    <td>{{ $item->warna }}</td>
                    <td class="text-center">{{ $item->tahun }}</td>
                    <td>{{ $item->chassis_code }}</td>
                    <td>{{ $item->norangka }}</td>
                    <td>{{ $item->enginecode }}</td>
                    <td>{{ $item->nomesin }}</td>
                    <td>{{ $item->faktur }}</td>
                    <td>{{ $item->bln_naik_faktur }}</td>
                    <td class="text-right">{{ number_format((float)$item->harga, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format((float)$item->kpt_kf, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format((float)$item->acs2, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format((float)$item->subsidi, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format((float)$item->hpp, 0, ',', '.') }}</td>
                    <td>{{ $item->lokasi }}</td>
                    <td>{{ $item->estimasi_unit_masuk_gudang_dca }}</td>
                    <td class="text-center">{{ strtoupper($item->status) }}</td>
                    <td>{{ $item->lain_lain }}</td>
                    <td>{{ $item->penjualan }}</td>
                    <td>{{ $item->tanggal_matching_do }}</td>
                    <td>{{ $item->cabang }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td class="text-center">{{ $item->unit }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
