<!-- <!DOCTYPE html>
<html>
<head>
    <title>Laporan Stock Kendaraan</title>
    <style>
        @page { margin: 10px; }
        body { font-family: Arial, sans-serif; font-size: 8px; color: #333; }
        h2 { text-align: center; margin-bottom: 2px; font-size: 14px; }
        p.subtitle { text-align: center; font-size: 10px; margin-top: 0; margin-bottom: 10px; color: #666; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th, td { border: 1px solid #cbd5e1; padding: 4px 2px; text-align: left; vertical-align: middle; word-wrap: break-word; }
        th { background-color: #1e293b; color: #ffffff; font-size: 7px; text-transform: uppercase; text-align: center; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <h2>Laporan Stock Kendaraan</h2>
    <p class="subtitle">Daftar unit kendaraan dengan Tanggal DO tepat 3 hari yang lalu</p>

    <table>
        <thead>
            <tr>
                <th style="width: 6%;">NO DO</th>
                <th style="width: 7%;">TANGGAL DO</th>
                <th style="width: 6%;">KODE MOBIL</th>
                <th style="width: 10%;">NAMA MOBIL</th>
                <th style="width: 8%;">WARNA</th>
                <th style="width: 3%;">TAHUN</th>
                <th style="width: 6%;">CHASSIS CODE</th>
                <th style="width: 9%;">NO RANGKA</th>
                <th style="width: 5%;">ENGINECODE</th>
                <th style="width: 8%;">NO MESIN</th>
                <th style="width: 7%;">FAKTUR</th>
                <th style="width: 7%;">BLN NAIK</th>
                <th style="width: 6%;">LOKASI</th>
                <th style="width: 4%;">STATUS</th>
                <th style="width: 8%;">CABANG</th>
            </tr>
        </thead>
        <tbody>
            @forelse($stocks as $stock)
            <tr>
                <td>{{ $stock->no_do }}</td>
                <td class="text-center">{{ $stock->tanggal_do ? \Carbon\Carbon::parse($stock->tanggal_do)->format('d-M-Y') : '-' }}</td>
                <td>{{ $stock->kode_mobil }}</td>
                <td>{{ $stock->nama_mobil }}</td>
                <td>{{ $stock->varian }}</td>
                <td>{{ $stock->warna }}</td>
                <td class="text-center">{{ $stock->tahun }}</td>
                <td>{{ $stock->chassis_code }}</td>
                <td>{{ $stock->norangka }}</td>
                <td>{{ $stock->engine_code }}</td>
                <td>{{ $stock->nomesin }}</td>
                <td>{{ $stock->faktur }}</td>
                <td>{{ $stock->bln_naik_faktur }}</td>
                <td>{{ strtoupper($stock->lokasi) }}</td>
                <td class="text-center">{{ strtoupper($stock->status ?? '-') }}</td>
                <td>{{ strtoupper($stock->cabang) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="16" style="text-align:center; font-weight:bold; padding: 10px;">Tidak ada data stock untuk periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html> -->

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stock Kendaraan</title>
    <style>
        @page { margin: 10px; }
        body { font-family: Arial, sans-serif; font-size: 8px; color: #333; }
        h2 { text-align: center; margin-bottom: 2px; font-size: 14px; }
        p.subtitle { text-align: center; font-size: 10px; margin-top: 0; margin-bottom: 10px; color: #666; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th, td { border: 1px solid #cbd5e1; padding: 4px 2px; text-align: left; vertical-align: middle; word-wrap: break-word; }
        th { background-color: #1e293b; color: #ffffff; font-size: 7px; text-transform: uppercase; text-align: center; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <h2>Laporan Stock Kendaraan</h2>
    <p class="subtitle">Daftar unit kendaraan</p>

    <table>
        <thead>
            <tr>
                <th style="width: 6%;">NO DO</th>
                <th style="width: 7%;">TANGGAL DO</th>
                <th style="width: 6%;">KODE MOBIL</th>
                <th style="width: 10%;">NAMA MOBIL</th>
                <th style="width: 8%;">VARIAN</th>
                <th style="width: 8%;">WARNA</th>
                <th style="width: 3%;">TAHUN</th>
                <th style="width: 6%;">CHASSIS CODE</th>
                <th style="width: 9%;">NO RANGKA</th>
                <th style="width: 5%;">ENGINECODE</th>
                <th style="width: 8%;">NO MESIN</th>
                <th style="width: 7%;">FAKTUR</th>
                <th style="width: 7%;">BLN NAIK</th>
                <th style="width: 6%;">LOKASI</th>
                @if($withPrices ?? false)
                    <th style="width: 7%;">HARGA</th>
                    <th style="width: 7%;">KPT+KF</th>
                    <th style="width: 6%;">ACS2</th>
                    <th style="width: 7%;">SUBSIDI</th>
                    <th style="width: 7%;">HPP</th>
                @endif
                <th style="width: 4%;">STATUS</th>
                <th style="width: 8%;">CABANG</th>
            </tr>
        </thead>
        <tbody>
            @forelse($stocks as $stock)
            <tr>
                <td>{{ $stock->no_do }}</td>
                <td class="text-center">{{ $stock->tanggal_do ? \Carbon\Carbon::parse($stock->tanggal_do)->format('d-M-Y') : '-' }}</td>
                <td>{{ $stock->kode_mobil }}</td>
                <td>{{ $stock->nama_mobil }}</td>
                <td>{{ $stock->varian }}</td>
                <td>{{ $stock->warna }}</td>
                <td class="text-center">{{ $stock->tahun }}</td>
                <td>{{ $stock->chassis_code }}</td>
                <td>{{ $stock->norangka }}</td>
                <td>{{ $stock->engine_code }}</td>
                <td>{{ $stock->nomesin }}</td>
                <td>{{ $stock->faktur }}</td>
                <td>{{ $stock->bln_naik_faktur }}</td>
                <td>{{ strtoupper($stock->lokasi) }}</td>
                @if($withPrices ?? false)
                    <td style="white-space: nowrap;">Rp {{ number_format($stock->harga, 0, ',', '.') }}</td>
                    <td style="white-space: nowrap;">Rp {{ number_format($stock->kpt_kf, 0, ',', '.') }}</td>
                    <td style="white-space: nowrap;">Rp {{ number_format($stock->acs2, 0, ',', '.') }}</td>
                    <td style="white-space: nowrap;">Rp {{ number_format($stock->subsidi, 0, ',', '.') }}</td>
                    <td style="white-space: nowrap;">Rp {{ number_format($stock->hpp, 0, ',', '.') }}</td>
                @endif
                <td class="text-center">{{ strtoupper($stock->status ?? '-') }}</td>
                <td>{{ strtoupper($stock->cabang) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="{{ ($withPrices ?? false) ? 21 : 16 }}" style="text-align:center; font-weight:bold; padding: 10px;">Tidak ada data stock untuk periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>