@extends('layouts.app')

@section('content')
<style>
    .tab-header {
        display: flex;
        background: white;
        border-bottom: 2px solid #eee;
    }
    .tab-item {
        flex: 1;
        text-align: center;
        padding: 15px;
        cursor: pointer;
        font-weight: 600;
        color: #555;
        border-bottom: 2px solid transparent;
        transition: all 0.3s;
        text-decoration: none;
    }
    .tab-item.active {
        color: #2196f3;
        border-bottom-color: #2196f3;
    }
    .tab-content {
        display: none;
        padding: 20px;
        background: #f4f6f9;
        min-height: calc(100vh - 150px);
    }
    .tab-content.active {
        display: block;
    }
    
    /* Form Styles */
    .form-section {
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-size: 11px;
        color: #555;
        font-weight: 600;
    }
    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 12px;
        background: white;
    }
    .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 15px;
    }
    .form-col {
        flex: 1;
    }
    .section-title {
        color: #1565c0;
        font-size: 13px;
        font-weight: bold;
        margin-bottom: 15px;
        border-left: 4px solid #1565c0;
        padding-left: 10px;
    }
    
    /* Table Styles */
    .table-container {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        overflow-x: auto;
    }
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        white-space: nowrap;
    }
    .custom-table th, .custom-table td {
        padding: 10px;
        border-bottom: 1px solid #eee;
    }
    .custom-table th {
        color: #777;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 10px;
    }
    .badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
    }
    .badge-success { background: #e8f5e9; color: #2e7d32; }
    .badge-danger { background: #ffebee; color: #c62828; }
    .badge-warning { background: #fff3e0; color: #ef6c00; }
    
    .action-btn {
        padding: 4px 8px;
        border-radius: 4px;
        color: white;
        text-decoration: none;
        font-size: 11px;
        display: inline-block;
        margin-right: 4px;
        border: none;
        cursor: pointer;
    }
    .btn-pdf { background: #1976d2; }
    .btn-wa { background: #4caf50; }
    .btn-edit { background: #ffb300; }
</style>

<div style="margin: -20px; margin-bottom: 20px;">
    <div class="tab-header">
        <a href="?tab=input" class="tab-item {{ $tab == 'input' ? 'active' : '' }}">Input Check</a>
        <a href="?tab=list" class="tab-item {{ $tab == 'list' ? 'active' : '' }}">List Data</a>
    </div>
</div>

@if(session('success'))
<div style="background: #d4edda; color: #155724; padding: 10px 15px; border-radius: 4px; margin-bottom: 20px;">
    {{ session('success') }}
</div>
@endif

@if ($errors->any())
<div style="background: #f8d7da; color: #721c24; padding: 10px 15px; border-radius: 4px; margin-bottom: 20px;">
    <strong>Gagal menyimpan data!</strong>
    <ul style="margin: 5px 0 0 15px; padding: 0;">
        @foreach ($errors->all() as $error)
            <li style="font-size: 12px;">{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- TAB INPUT CHECK -->
<div class="tab-content {{ $tab == 'input' ? 'active' : '' }}">
    <form action="{{ route('service.service-ac.ac.post_check_store') }}" method="POST" enctype="multipart/form-data" class="form-section">
        @csrf
        
        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label>Jenis Pemeriksaan</label>
                    <select name="jenis_pemeriksaan" class="form-control">
                        <option value="POST CHECK">POST CHECK</option>
                        <option value="PRE CHECK">PRE CHECK</option>
                    </select>
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label>No Polisi:</label>
                    <input type="text" name="no_polisi" class="form-control" placeholder="B 1234 ABC">
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label>Cabang</label>
                    <select name="cabang" class="form-control">
                        <option value="">-- Pilih Cabang --</option>
                        @foreach($cabangs as $cab)
                        <option value="{{ $cab }}">{{ $cab }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label>Teknisi Pemeriksa</label>
                    <select name="teknisi" class="form-control">
                        <option value="">-- Pilih Teknisi --</option>
                        @foreach($teknisis as $teknisi)
                        <option value="{{ $teknisi }}">{{ $teknisi }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label>SA:</label>
                    <select name="sa" class="form-control">
                        <option value="">-- Pilih SA --</option>
                        @foreach($sas as $sa)
                        <option value="{{ $sa }}">{{ $sa }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label>Hari, Tanggal:</label>
                    <input type="date" name="tanggal" class="form-control">
                </div>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 30px;">
            <label>Tipe Kendaraan:</label>
            <input type="text" name="tipe_kendaraan" class="form-control" placeholder="CONTOH: ERTIGA, XL7, DLL">
        </div>

        <!-- Form Pre Check -->
        <div class="section-title">Form Pre Check</div>
        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label>High Pressure</label>
                    <input type="text" name="pre_high_pressure" class="form-control" placeholder=".. PSI">
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label>Low Pressure</label>
                    <input type="text" name="pre_low_pressure" class="form-control" placeholder=".. PSI">
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label>Suhu Outlet</label>
                    <input type="text" name="pre_suhu_outlet" class="form-control" placeholder=".. °C">
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-col" style="max-width: 33.33%;">
                <div class="form-group">
                    <label>Wind Speed:</label>
                    <input type="text" name="pre_wind_speed" class="form-control" placeholder=".. M/S">
                </div>
            </div>
        </div>

        <!-- Form Post Check -->
        <div class="section-title" style="margin-top: 30px;">Form Post Check</div>
        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label>High Pressure</label>
                    <input type="text" name="post_high_pressure" class="form-control" placeholder=".. PSI">
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label>Low Pressure</label>
                    <input type="text" name="post_low_pressure" class="form-control" placeholder=".. PSI">
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label>Suhu Outlet</label>
                    <input type="text" name="post_suhu_outlet" class="form-control" placeholder=".. °C">
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-col" style="max-width: 33.33%;">
                <div class="form-group">
                    <label>Wind Speed:</label>
                    <input type="text" name="post_wind_speed" class="form-control" placeholder=".. M/S">
                </div>
            </div>
        </div>

        <!-- Tambahan Pemeriksaan -->
        <div class="section-title" style="margin-top: 30px;">Tambahan Pemeriksaan</div>
        <div class="form-group">
            <textarea name="catatan_tambahan" class="form-control" rows="3" placeholder="CATATAN TAMBAHAN..."></textarea>
        </div>

        <!-- Hasil Pekerjaan -->
        <div class="section-title" style="margin-top: 30px;">Hasil Pekerjaan</div>
        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label>Perawatan:</label>
                    <select name="perawatan" class="form-control">
                        <option value="">-- Pilih Perawatan --</option>
                        @foreach($perawatans as $per)
                        <option value="{{ $per }}">{{ $per }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label>Penggantian:</label>
                    <input type="text" name="penggantian" class="form-control" placeholder="NAMA PART YANG PERLU DIGANTI">
                </div>
            </div>
        </div>

        <!-- Upload Foto Kendaraan -->
        <div class="section-title" style="margin-top: 30px;">Upload Foto Kendaraan</div>
        <div class="form-group">
            <div style="border: 1px dashed #ccc; padding: 15px; border-radius: 8px; width: 250px; background: #fafafa;">
                <input type="file" name="foto_kendaraan" class="form-control" style="border: 1px solid #ccc; padding: 5px; margin-bottom: 10px; background: white;">
                <input type="text" name="keterangan_foto" class="form-control" placeholder="KETERANGAN FOTO" style="border: 1px solid #ccc; padding: 8px; margin-bottom: 10px;">
                <p style="font-size: 11px; color: #d32f2f; margin: 0;">Maksimal 4MB (JPG/PNG)</p>
            </div>
            <button type="button" style="margin-top: 15px; background: white; color: #1565c0; border: 1px solid #1565c0; border-radius: 4px; padding: 6px 15px; font-size: 11px; cursor: pointer; font-weight: 600;">+ Tambah Foto</button>
        </div>

        <div style="text-align: center; margin-top: 40px;">
            <button type="submit" style="background: #1565c0; color: white; padding: 10px 40px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">SIMPAN DATA</button>
        </div>
    </form>
</div>

<!-- TAB LIST DATA -->
<div class="tab-content {{ $tab == 'list' ? 'active' : '' }}">
    <div class="table-container">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div>
                <h3 style="margin: 0; color: #333;">Data Post Check</h3>
                <p style="margin: 0; font-size: 12px; color: #777;">Kelola data pemeriksaan kendaraan</p>
            </div>
            <div style="display: flex; gap: 10px;">
                <select class="form-control" style="width: 150px;">
                    <option>Semua Cabang</option>
                </select>
                <input type="text" class="form-control" placeholder="CARI DATA..." style="width: 200px;">
                <button style="background: #4caf50; color: white; border: none; padding: 8px 15px; border-radius: 4px; font-size: 12px; cursor: pointer;">Export Excel</button>
            </div>
        </div>

        <table class="custom-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Pemeriksaan</th>
                    <th>Cabang</th>
                    <th>SA / Teknisi</th>
                    <th>Tanggal</th>
                    <th>No Polisi</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th style="text-align: center;">Approve Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
                <tr>
                    <th></th>
                    <th><input type="text" class="form-control" style="padding: 4px; font-size: 11px;" placeholder="Cari..."></th>
                    <th><input type="text" class="form-control" style="padding: 4px; font-size: 11px;" placeholder="Cari..."></th>
                    <th><input type="text" class="form-control" style="padding: 4px; font-size: 11px;" placeholder="Cari..."></th>
                    <th><input type="text" class="form-control" style="padding: 4px; font-size: 11px;" placeholder="Cari..."></th>
                    <th><input type="text" class="form-control" style="padding: 4px; font-size: 11px;" placeholder="Cari..."></th>
                    <th><input type="text" class="form-control" style="padding: 4px; font-size: 11px;" placeholder="Cari..."></th>
                    <th><input type="text" class="form-control" style="padding: 4px; font-size: 11px;" placeholder="Cari..."></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($postCheckAcs as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->jenis_pemeriksaan ?: 'POST CHECK' }}</td>
                    <td>{{ $item->cabang }}</td>
                    <td>
                        <div style="font-weight: 600;">SA: {{ $item->sa }}</div>
                        <div style="color: #777; font-size: 11px;">Tek: {{ $item->teknisi }}</div>
                    </td>
                    <td>{{ $item->tanggal }}</td>
                    <td style="font-weight: 600;">{{ $item->no_polisi }}</td>
                    <td>{{ $item->tipe_kendaraan }}</td>
                    <td>
                        @if($item->perawatan != null)
                            <span class="badge badge-success">DIKERJAKAN</span>
                        @else
                            <span class="badge badge-warning">BELUM DIPROSES</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        <button style="background: #4caf50; color: white; border: none; padding: 4px 6px; border-radius: 4px; cursor: pointer; font-size: 10px;"><i class="fas fa-check"></i></button>
                        <button style="background: #f44336; color: white; border: none; padding: 4px 6px; border-radius: 4px; cursor: pointer; font-size: 10px;"><i class="fas fa-times"></i></button>
                    </td>
                    <td style="text-align: center;">
                        <a href="{{ route('service.service-ac.ac.post_check_pdf', $item->id) }}" class="action-btn btn-pdf" target="_blank">PDF</a>
                        <button type="button" class="action-btn btn-wa" onclick="sendWA({{ $item->id }}, '{{ $item->no_polisi }}', '{{ $item->tipe_kendaraan }}')">WA</button>
                        <a href="{{ route('service.service-ac.ac.post_check_edit', $item->id) }}" class="action-btn btn-edit">EDIT</a>
                        <form action="{{ route('service.service-ac.ac.post_check_destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Hapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn" style="background:#f44336;"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
                
                @if($postCheckAcs->isEmpty())
                <tr>
                    <td colspan="10" style="text-align: center; padding: 20px;">Belum ada data Post Check.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<script>
function sendWA(id, noPolisi, tipeKendaraan) {
    let waNumber = prompt("Masukkan nomor WhatsApp tujuan (contoh: 08123456789):");
    if (waNumber) {
        waNumber = waNumber.replace(/[^0-9+]/g, '');
        if (waNumber.startsWith('0')) {
            waNumber = '62' + waNumber.substring(1);
        }
        
        // Menggunakan url() bawaan laravel agar link mengarah ke website ini sendiri
        let pdfUrl = "{{ url('/postcheck/pdf_laporan') }}/" + id;
        
        let message = `*Hasil Pemeriksaan Kendaraan*\n\nNo Polisi: ${noPolisi}\nTipe: ${tipeKendaraan}\n\nSilakan lihat laporan lengkap:\n${pdfUrl}`;
        
        let encodedMessage = encodeURIComponent(message);
        let waLink = `https://api.whatsapp.com/send?phone=${waNumber}&text=${encodedMessage}`;
        
        window.open(waLink, '_blank');
    }
}
</script>
@endsection
