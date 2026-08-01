<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data In Unit</title>
    <style>
        @page { margin: 10px; }
        body { font-family: Arial, sans-serif; font-size: 8px; color: #333; }
        h2 { text-align: center; margin-bottom: 2px; font-size: 14px; }
        p.subtitle { text-align: center; font-size: 10px; margin-top: 0; margin-bottom: 10px; color: #666; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th, td { border: 1px solid #000; padding: 4px 2px; text-align: left; vertical-align: middle; word-wrap: break-word; }
        th { background-color: #1e293b; color: #ffffff; font-size: 7px; text-transform: uppercase; text-align: center; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <h2>Laporan Data In Unit</h2>
    <p class="subtitle">Daftar unit yang diinput pada hari ini</p>

    <table>
        <thead>
            <tr>
                <th style="width: 4%;">NO</th>
                <th style="width: 12%;">NAMA DRIVER</th>
                <th style="width: 8%;">TANGGAL</th>
                <th style="width: 6%;">JAM</th>
                <th style="width: 10%;">TYPE</th>
                <th style="width: 8%;">WARNA</th>
                <th style="width: 12%;">NO RANGKA</th>
                <th style="width: 10%;">NO MESIN</th>
                <th style="width: 12%;">LOKASI PENGAMBILAN</th>
                <th style="width: 8%;">CEKITS</th>
                <th style="width: 10%;">CABANG</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inUnits as $index => $inUnit)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ strtoupper($inUnit->nama_driver) }}</td>
                <td class="text-center">{{ $inUnit->tanggal ? \Carbon\Carbon::parse($inUnit->tanggal)->format('d-M-Y') : '-' }}</td>
                <td class="text-center">{{ $inUnit->jam_kedatangan ?? '-' }}</td>
                <td>{{ strtoupper($inUnit->type) }}</td>
                <td>{{ strtoupper($inUnit->warna) }}</td>
                <td>{{ strtoupper($inUnit->no_rangka) }}</td>
                <td>{{ strtoupper($inUnit->no_mesin) }}</td>
                <td>{{ strtoupper($inUnit->lokasi_pengambilan) }}</td>
                <td>{{ strtoupper($inUnit->cekits) }}</td>
                <td>{{ strtoupper($inUnit->cabang->nama ?? '-') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="11" style="text-align:center; font-weight:bold; padding: 10px;">Tidak ada data In Unit untuk hari ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
