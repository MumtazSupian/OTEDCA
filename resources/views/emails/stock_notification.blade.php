<!-- <!DOCTYPE html>
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
        <h2>Notifikasi Stock Kendaraan per Cabang</h2>
    </div>
    <div class="content">
        <p>Halo Team,</p>
        <p>Berikut adalah daftar data stock berdasarkan <strong>Tanggal DO</strong> 3 hari yang lalu:</p>
        
        <table>
            <thead>
                <tr>
                    <th>NO DO</th>
                    <th>TANGGAL DO</th>
                    <th>KODE MOBIL</th>
                    <th>NAMA MOBIL</th>
                    <th>WARNA</th>
                    <th>TAHUN</th>
                    <th>CHASSIS CODE</th>
                    <th>NO RANGKA</th>
                    <th>ENGINE CODE</th>
                    <th>NO MESIN</th>
                    <th>FAKTUR</th>
                    <th>BLN NAIK FAKTUR</th>
                    <th>LOKASI</th>
                    <th>STATUS</th>
                    <th>CABANG</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stocks as $stock)
                <tr>
                    <td>{{ $stock->no_do }}</td>
                    <td class="text-center">{{ $stock->tanggal_do ? \Carbon\Carbon::parse($stock->tanggal_do)->format('d-M-Y') : '-' }}</td>
                    <td>{{ $stock->kode_mobil }}</td>
                    <td>{{ $stock->nama_mobil }}</td>
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
                    <td colspan="15" style="text-align:center; font-weight: bold;">Tidak ada data stock untuk periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <p style="margin-top: 20px;"><em>Email ini dikirimkan secara otomatis oleh sistem scheduling ArUnit.</em></p>
    </div>
</body>
</html> -->

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
        <!-- <h2>Notifikasi Stock Kendaraan per Cabang</h2> -->
        <h2>{{ $withPrices ? 'Notifikasi Stock' : 'Notifikasi Stock Free Matching' }}</h2>
    </div>
    <div class="content">
        <p>Halo Team,</p>
        <p>Berikut adalah daftar data stock :</p>
        
        @if(isset($dashboardData))
            <h3 style="margin-top: 20px; color: #1e293b; font-size: 14px;">Ringkasan Data Kendaraan Stock</h3>
            <table width="100%" style="margin-bottom: 20px; border-collapse: separate; border-spacing: 10px 0;">
                <tr>
                    <td style="padding: 15px; background: #eff6ff; border-left: 4px solid #3b82f6; text-align:center;">
                        <h3 style="margin:0; color:#3b82f6; font-size:18px;">{{ $dashboardData['totalStock'] }}</h3>
                        <span style="font-size:12px; color:#555;">Total Stock</span>
                    </td>
                    <td style="padding: 15px; background: #ecfdf5; border-left: 4px solid #10b981; text-align:center;">
                        <h3 style="margin:0; color:#10b981; font-size:18px;">{{ $dashboardData['stockByStatus']['free'] ?? 0 }}</h3>
                        <span style="font-size:12px; color:#555;">Stock Free</span>
                    </td>
                    <td style="padding: 15px; background: #fef2f2; border-left: 4px solid #ef4444; text-align:center;">
                        <h3 style="margin:0; color:#ef4444; font-size:18px;">{{ $dashboardData['stockByStatus']['matching'] ?? 0 }}</h3>
                        <span style="font-size:12px; color:#555;">Stock Matching</span>
                    </td>
                    <td style="padding: 15px; background: #f5f3ff; border-left: 4px solid #8b5cf6; text-align:center;">
                        <h3 style="margin:0; color:#8b5cf6; font-size:18px;">{{ $dashboardData['stockByStatus']['sold'] ?? 0 }}</h3>
                        <span style="font-size:12px; color:#555;">Stock Sold</span>
                    </td>
                </tr>
            </table>
            <hr style="border: none; border-top: 1px dashed #cbd5e1; margin-bottom: 20px;">
        @endif

        <table>
            <thead>
                <tr>
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
                    <th>LOKASI</th>
                    @if($withPrices ?? false)
                        <th>HARGA</th>
                        <th>KPT+KF</th>
                        <th>ACS2</th>
                        <th>SUBSIDI</th>
                        <th>HPP</th>
                    @endif
                    <th>STATUS</th>
                    <th>CABANG</th>
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
                    <td colspan="{{ ($withPrices ?? false) ? 21 : 16 }}" style="text-align:center; font-weight: bold;">Tidak ada data stock untuk periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <p style="margin-top: 20px;"><em>Email ini dikirimkan secara otomatis oleh sistem scheduling ArUnit.</em></p>
    </div>
</body>
</html>