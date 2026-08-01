<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; color: #333; line-height: 1.6; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 11px; }
        th, td { border: 1px solid #ddd; padding: 8px 6px; text-align: left; }
        th { background-color: #1e293b; color: white; text-transform: uppercase; font-size: 10px; }
        .header { background: #1e293b; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; border: 1px solid #ddd; border-top: none; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Notifikasi Data In Unit Hari Ini</h2>
    </div>
    <div class="content">
        <p>Halo Team,</p>
        <p>Berikut adalah daftar data <strong>In Unit</strong> yang diinput pada hari ini:</p>
        
        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NAMA DRIVER</th>
                    <th>TANGGAL</th>
                    <th>JAM KEDATANGAN</th>
                    <th>TYPE</th>
                    <th>WARNA</th>
                    <th>NO RANGKA</th>
                    <th>NO MESIN</th>
                    <th>LOKASI PENGAMBILAN</th>
                    <th>CEKITS</th>
                    <th>CABANG</th>
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
                    <td colspan="11" style="text-align:center; font-weight: bold;">Tidak ada data In Unit yang diinput hari ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <p style="margin-top: 20px;"><em>Email ini dikirimkan secara otomatis oleh sistem scheduling ArUnit.</em></p>
    </div>
</body>
</html>
