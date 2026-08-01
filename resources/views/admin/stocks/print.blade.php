<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Data Stock - Print</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
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
                <th>KODE MOBIL</th>
                <th>NAMA MOBIL</th>
                <th>WARNA</th>
                <th>TAHUN</th>
                <th>NO RANGKA</th>
                <th>NO MESIN</th>
                <th>STATUS</th>
                <th>CABANG</th>
                <th>UNIT</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $i => $item)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $item->no_do }}</td>
                    <td>{{ $item->kode_mobil }}</td>
                    <td>{{ $item->nama_mobil }}</td>
                    <td>{{ $item->warna }}</td>
                    <td class="text-center">{{ $item->tahun }}</td>
                    <td>{{ $item->norangka }}</td>
                    <td>{{ $item->nomesin }}</td>
                    <td class="text-center">{{ strtoupper($item->status) }}</td>
                    <td>{{ $item->cabang }}</td>
                    <td class="text-center">{{ $item->unit }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <script>
        window.print();
    </script>
</body>
</html>
