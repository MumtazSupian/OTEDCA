<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pre Check</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; margin: 0; padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        .no-border th, .no-border td { border: none; text-align: left; padding: 2px; }
        
        .header-table { width: 100%; margin-bottom: 10px; border-bottom: 6px solid #333; padding-bottom: 10px; }
        .header-table td { border: none; vertical-align: middle; }
        .logo-cell { width: 33%; text-align: left; padding-right: 10px; }
        .title-cell { width: 34%; text-align: center; border-left: 1px solid #ccc !important; border-right: 1px solid #ccc !important; padding: 0 10px; }
        .title-cell h3 { margin: 0; font-size: 13px; color: #0062cc; font-weight: bold; margin-bottom: 3px; }
        .title-cell h1 { margin: 0; font-size: 28px; color: #0062cc; font-weight: bold; margin-bottom: 3px; letter-spacing: 1px; }
        .title-cell h2 { margin: 0; font-size: 19px; color: #0062cc; font-weight: bold; letter-spacing: 0.5px; }
        .info-cell { width: 33%; font-size: 12px; padding-left: 20px; font-family: serif; }
        .info-cell table { width: 100%; margin-left: 0; }
        .info-cell td { padding: 3px 0; text-align: left; }
        .info-cell td:first-child { width: 60px; }

        .blue-bar { background-color: #0062cc; color: white; text-align: center; padding: 6px; font-weight: bold; margin-top: 10px; margin-bottom: 15px; font-size: 13px; }
        .red-bar { background-color: #dc3545; color: white; text-align: center; padding: 6px; font-weight: bold; margin-bottom: 0px; font-size: 13px; margin-top: 0px; }
        .green-bar { background-color: #009900; color: white; text-align: center; padding: 6px; font-weight: bold; margin-bottom: 0px; font-size: 13px; margin-top: 35px; }
        
        .section-title { background-color: #eef2f5; font-weight: bold; text-align: left; padding: 6px 10px; margin-bottom: 0px; font-size: 11px; }
        
        .data-table th { font-weight: bold; font-size: 10px; padding: 8px 5px; }
        .data-table td { font-size: 10px; padding: 8px 5px; }
        .data-table.bold-table td { font-weight: bold; }
        .text-left { text-align: left !important; }
        .text-center { text-align: center !important; }
        
        .footer-note { font-size: 9px; font-style: italic; margin-top: 15px; margin-bottom: 2px; }

        .image-grid { width: 100%; text-align: center; margin-top: 15px; }
        .image-row { margin-bottom: 15px; }
        .image-box { width: 30%; display: inline-block; margin: 0 1%; vertical-align: top; }
        .image-box img { max-width: 100%; max-height: 120px; height: auto; object-fit: contain; }
        .image-box .caption { font-size: 9px; margin-top: 5px; font-weight: bold; font-style: italic; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td class="logo-cell">
                <img src="{{ public_path('assets/dca_full.png') }}" alt="Logo Suzuki DCA" style="width: 100%; max-width: 250px; height: auto;">
            </td>
            <td class="title-cell">
                <h3>PRE CHECK</h3>
                <h1>{{ $data->no_polisi }}</h1>
                <h2>{{ strtoupper($data->tipe_kendaraan) }}</h2>
            </td>
            <td class="info-cell">
                <table class="no-border">
                    <tr>
                        <td>SA</td>
                        <td>{{ $data->sa }}</td>
                    </tr>
                    <tr>
                        <td>Tgl</td>
                        <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d/m/y') }}</td>
                    </tr>
                    <tr>
                        <td>Teknisi</td>
                        <td>{{ $data->teknisi }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="blue-bar">LAKUKAN SERVICE AC KENDARAAN ANDA</div>
    <div class="section-title">DATA PEMERIKSAAN</div>
    
    <table class="data-table bold-table">
        <tr>
            <th width="35%">Standar Normal *</th>
            <th width="30%">Hasil Pemeriksaan</th>
            <th width="35%">Pemeriksaan Tambahan</th>
        </tr>
        <tr>
            <td class="text-left">* High Pressure : 199.1 Psi - 227.5 Psi</td>
            <td>{{ $data->high_pressure ?? '-' }} PSI</td>
            <td rowspan="4" style="vertical-align: top; text-align: left; font-weight: bold;">{{ $data->pemeriksaan_tambahan }}</td>
        </tr>
        <tr>
            <td class="text-left">> Low Pressure : 21.3 Psi - 35.5 Psi</td>
            <td>{{ $data->low_pressure ?? '-' }} PSI</td>
        </tr>
        <tr>
            <td class="text-left">* Suhu Outlet : 4°C - 7°C</td>
            <td>{{ $data->suhu_outlet ?? '-' }} °C</td>
        </tr>
        <tr>
            <td class="text-left">- Wind Speed : 2.5 m/s - 4 m/s</td>
            <td>{{ $data->wind_speed ?? '-' }} m/s</td>
        </tr>
    </table>
    <div class="footer-note">Sumber Referensi: Denso</div>

    <div class="red-bar">SARAN PERBAIKAN</div>
    <table class="data-table">
        <tr>
            <th width="50%">Rekomendasi Perawatan</th>
            <th width="50%">Estimasi Penggantian Part</th>
        </tr>
        <tr>
            <td>{{ $data->rekomendasi_perawatan ?? '-' }}</td>
            <td>{{ $data->estimasi_penggantian_part ?? '-' }}</td>
        </tr>
    </table>

    <div class="green-bar">KONDISI MOBIL ANDA</div>
    
    <?php
        $existingFotos = [];
        if ($data->foto_kendaraan) {
            $existingFotos = json_decode($data->foto_kendaraan, true) ?? [];
            if (!is_array($existingFotos)) {
                // Backwards compatibility for old data
                $existingFotos = [['path' => $data->foto_kendaraan, 'keterangan' => $data->keterangan_foto]];
            }
        }
    ?>

    <div class="image-grid">
        @if(count($existingFotos) > 0)
            @php $count = 0; @endphp
            @foreach($existingFotos as $foto)
                @if($count % 3 == 0)
                    <div class="image-row">
                @endif
                
                <?php
                    $imgPath = '';
                    $path = str_replace('storage/', '', $foto['path'] ?? '');
                    
                    $fullPath = '';
                    if ($path && file_exists(storage_path('app/public/' . $path))) {
                        $fullPath = storage_path('app/public/' . $path);
                    } elseif ($path && file_exists(storage_path('app/private/public/' . $path))) {
                        $fullPath = storage_path('app/private/public/' . $path);
                    }
                    
                    if ($fullPath) {
                        $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
                        if ($extension === 'webp' && function_exists('imagecreatefromwebp')) {
                            $im = @imagecreatefromwebp($fullPath);
                            if ($im) {
                                ob_start();
                                imagejpeg($im, NULL, 90);
                                $imgData = ob_get_clean();
                                imagedestroy($im);
                                $imgPath = 'data:image/jpeg;base64,' . base64_encode($imgData);
                            } else {
                                $imgPath = $fullPath;
                            }
                        } else {
                            $imgPath = $fullPath; // fallback
                        }
                    } elseif (file_exists(public_path($foto['path'] ?? ''))) {
                        $imgPath = public_path($foto['path'] ?? '');
                    }
                ?>
                
                @if($imgPath)
                <div class="image-box">
                    <img src="{{ $imgPath }}" alt="Foto">
                    <div class="caption">{{ strtoupper($foto['keterangan'] ?: 'FOTO') }}</div>
                </div>
                @endif
                
                @php $count++; @endphp
                @if($count % 3 == 0 || $loop->last)
                    </div>
                @endif
            @endforeach
        @else
            <p style="font-style: italic; color: #777; margin-top: 20px;">(Tidak ada foto kendaraan yang tersedia)</p>
        @endif
    </div>

</body>
</html>
