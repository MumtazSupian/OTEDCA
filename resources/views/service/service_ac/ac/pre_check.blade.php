@extends('layouts.app')

@section('content')
<style>
    .tab-wrapper {
        display: flex;
        justify-content: center;
        margin: 10px 0 30px;
    }
    .tab-header {
        display: inline-flex;
        background: white;
        border-radius: 30px;
        padding: 5px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .tab-item {
        padding: 10px 30px;
        cursor: pointer;
        font-weight: 700;
        color: #6c757d;
        border-radius: 25px;
        transition: all 0.3s ease;
        text-decoration: none;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .tab-item.active {
        background: #1976d2;
        color: white;
        box-shadow: 0 4px 10px rgba(25, 118, 210, 0.3);
    }
    .tab-item:not(.active):hover {
        background: #f8f9fa;
        color: #343a40;
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
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        margin-bottom: 30px;
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
        border: 1px solid rgba(0,0,0,0.02);
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 12px;
        color: #495057;
        font-weight: 700;
        letter-spacing: 0.3px;
    }
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        font-size: 13px;
        background: #f8f9fa;
        color: #495057;
        transition: all 0.3s;
    }
    .form-control:focus {
        outline: none;
        border-color: #3498db;
        background: white;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    }
    .form-row {
        display: flex;
        gap: 25px;
        margin-bottom: 20px;
    }
    .form-col {
        flex: 1;
    }
    .section-title {
        color: #2c3e50;
        font-size: 16px;
        font-weight: 800;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 1px solid #f0f4f8;
        padding-bottom: 15px;
    }
    .section-title::before {
        content: '';
        width: 4px;
        height: 20px;
        background: linear-gradient(to bottom, #3498db, #2ecc71);
        border-radius: 4px;
        display: inline-block;
    }
    .btn-submit {
        background: linear-gradient(135deg, #1976d2, #3498db);
        color: white;
        padding: 12px 40px;
        border: none;
        border-radius: 30px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(25, 118, 210, 0.3);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(25, 118, 210, 0.4);
    }
</style>

<div class="tab-wrapper">
    <div class="tab-header">
        <a href="?tab=input" class="tab-item {{ $tab == 'input' ? 'active' : '' }}"><i class="fas fa-edit"></i> Input Check</a>
        <a href="?tab=list" class="tab-item {{ $tab == 'list' ? 'active' : '' }}"><i class="fas fa-list"></i> List Data</a>
    </div>
</div>

@if(session('success'))
<div style="background: #d4edda; color: #155724; padding: 10px 15px; border-radius: 4px; margin-bottom: 20px;">
    {{ session('success') }}
</div>
@endif

@if ($errors->any())
<div style="background: #f8d7da; color: #721c24; padding: 10px 15px; border-radius: 4px; margin-bottom: 20px; max-width: 900px; margin-left: auto; margin-right: auto;">
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
    <form action="{{ route('service.service-ac.ac.pre_check_store') }}" method="POST" enctype="multipart/form-data" class="form-section">
        @csrf
        
        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label>Jenis Pemeriksaan</label>
                    <select name="jenis_pemeriksaan" class="form-control">
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
                    <select id="cabang_select" name="cabang" class="form-control" onchange="updateSA()">
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
                    <input type="text" name="teknisi" class="form-control" placeholder="NAMA TEKNISI">
                </div>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-col">
                <div class="form-group" id="sa_group" style="display: block;">
                    <label>Service Advisor (SA):</label>
                    <select id="sa_select" name="sa" class="form-control">
                        <option value="">-- Pilih SA --</option>
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

        <!-- Hasil Pengukuran (Form Check) -->
        <div class="section-title">Hasil Pengukuran (Form Check)</div>
        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label>High Pressure</label>
                    <input type="text" name="high_pressure" class="form-control" placeholder=".. PSI">
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label>Low Pressure</label>
                    <input type="text" name="low_pressure" class="form-control" placeholder=".. PSI">
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label>Suhu Outlet</label>
                    <input type="text" name="suhu_outlet" class="form-control" placeholder=".. °C">
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-col" style="max-width: 33.33%;">
                <div class="form-group">
                    <label>Wind Speed:</label>
                    <input type="text" name="wind_speed" class="form-control" placeholder=".. M/S">
                </div>
            </div>
        </div>

        <!-- Saran & Perbaikan -->
        <div class="section-title" style="margin-top: 30px;">Saran & Perbaikan</div>
        <div class="form-group">
            <label>Pemeriksaan Tambahan</label>
            <textarea name="pemeriksaan_tambahan" class="form-control" rows="3" placeholder="Catatan tambahan..."></textarea>
        </div>
        <div class="form-row">
            <div class="form-col">
                <div class="form-group">
                    <label>Rekomendasi Perawatan</label>
                    <select name="rekomendasi_perawatan" class="form-control">
                        <option value="">-- Pilih Perawatan --</option>
                        @foreach($perawatans as $per)
                        <option value="{{ $per }}">{{ $per }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-col">
                <div class="form-group">
                    <label>Estimasi Penggantian Part</label>
                    <input type="text" name="estimasi_penggantian_part" class="form-control" placeholder="NAMA PART YANG PERLU GANTI">
                </div>
            </div>
        </div>

        <!-- Upload Foto Kendaraan -->
        <div class="section-title" style="margin-top: 30px;">Dokumentasi Foto</div>
        <div class="form-group">
            <div id="photo-upload-container" style="display: flex; gap: 15px; flex-wrap: wrap;">
                <div class="photo-upload-row" style="border: 2px dashed #e9ecef; padding: 20px; border-radius: 12px; width: 260px; background: #fff; position: relative; transition: all 0.3s;">
                    <input type="file" name="foto_kendaraan[]" class="form-control" style="background: white; border: 1px solid #e9ecef; margin-bottom: 15px; padding: 8px;">
                    <input type="text" name="keterangan_foto[]" class="form-control" placeholder="KETERANGAN FOTO">
                    <p style="font-size: 11px; color: #e53935; margin: 10px 0 0 0; font-weight: 600;"><i class="fas fa-info-circle"></i> Maksimal 8MB</p>
                </div>
            </div>
            <button type="button" id="btn-tambah-foto" style="margin-top: 20px; background: #f8f9fa; color: #3498db; border: 2px dashed #3498db; border-radius: 8px; padding: 10px 20px; font-size: 13px; cursor: pointer; font-weight: 700; transition: all 0.3s;"><i class="fas fa-plus"></i> Tambah Foto Lainnya</button>
        </div>

        <script>
            document.getElementById('btn-tambah-foto').addEventListener('click', function() {
                const container = document.getElementById('photo-upload-container');
                const row = document.createElement('div');
                row.className = 'photo-upload-row';
                row.style = 'border: 1px dashed #ccc; padding: 15px; border-radius: 8px; width: 250px; background: #fafafa; margin-bottom: 15px; position: relative;';
                
                row.innerHTML = `
                    <button type="button" class="btn-remove-row" style="position: absolute; right: -10px; top: -10px; background: #e53935; color: white; border: none; border-radius: 50%; width: 26px; height: 26px; cursor: pointer; font-size: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(229, 57, 53, 0.3); z-index: 10;"><i class="fas fa-times"></i></button>
                    <input type="file" name="foto_kendaraan[]" class="form-control" style="background: white; border: 1px solid #e9ecef; margin-bottom: 15px; padding: 8px;">
                    <input type="text" name="keterangan_foto[]" class="form-control" placeholder="KETERANGAN FOTO">
                `;
                
                row.querySelector('.btn-remove-row').addEventListener('click', function() {
                    row.remove();
                });
                
                container.appendChild(row);
            });
        </script>

        <div style="text-align: center; margin-top: 40px;">
            <button type="submit" class="btn-submit"><i class="fas fa-save"></i> SIMPAN DATA PRE CHECK</button>
        </div>
    </form>
</div>

<!-- TAB LIST DATA -->
<div class="tab-content {{ $tab == 'list' ? 'active' : '' }}" style="background-color: #f4f6f9; padding: 20px;">
    
    <!-- Header Card -->
    <div style="background: white; padding: 20px 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h3 style="margin: 0; color: #1976d2; font-size: 22px; font-weight: 500;">Data Pre Check</h3>
            <p style="margin: 5px 0 0 0; font-size: 12px; color: #666; font-weight: 500;">Kelola data pemeriksaan kendaraan</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <select id="globalCabangFilter" class="form-control" style="width: 150px; padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px;" onchange="applyFilters()">
                <option value="">Semua Cabang</option>
                <option value="Ciawi">Ciawi</option>
                <option value="Cianjur">Cianjur</option>
                <option value="Cinere">Cinere</option>
                <option value="Jatiasih">Jatiasih</option>
                <option value="Body Repair">Body Repair</option>
                <option value="Cipanas">Cipanas</option>
            </select>
            <input type="text" id="globalSearchFilter" class="form-control" placeholder="CARI DATA..." style="width: 200px; padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px;" onkeyup="applyFilters()">
            <button style="background: #28a745; color: white; border: none; padding: 8px 15px; border-radius: 4px; font-size: 12px; font-weight: 600; cursor: pointer; box-shadow: 0 2px 4px rgba(40,167,69,0.2);">Export Excel</button>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-container" style="padding: 25px; border-radius: 8px; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">

        <table class="custom-table" id="preCheckTable" style="border-collapse: collapse; width: 100%;">
            <thead>
                <tr>
                    <th style="padding: 15px 10px; border-bottom: 1px solid #f0f0f0; color: #555; font-size: 10px; font-weight: 700;">NO</th>
                    <th style="padding: 15px 10px; border-bottom: 1px solid #f0f0f0; color: #555; font-size: 10px; font-weight: 700;">JENIS PEMERIKSAAN</th>
                    <th style="padding: 15px 10px; border-bottom: 1px solid #f0f0f0; color: #555; font-size: 10px; font-weight: 700;">CABANG</th>
                    <th style="padding: 15px 10px; border-bottom: 1px solid #f0f0f0; color: #555; font-size: 10px; font-weight: 700;">SA / TEKNISI</th>
                    <th style="padding: 15px 10px; border-bottom: 1px solid #f0f0f0; color: #555; font-size: 10px; font-weight: 700;">TANGGAL</th>
                    <th style="padding: 15px 10px; border-bottom: 1px solid #f0f0f0; color: #555; font-size: 10px; font-weight: 700;">NO POLISI</th>
                    <th style="padding: 15px 10px; border-bottom: 1px solid #f0f0f0; color: #555; font-size: 10px; font-weight: 700;">TIPE</th>
                    <th style="padding: 15px 10px; border-bottom: 1px solid #f0f0f0; color: #555; font-size: 10px; font-weight: 700;">STATUS</th>
                    <th style="padding: 15px 10px; border-bottom: 1px solid #f0f0f0; color: #555; font-size: 10px; font-weight: 700; text-align: center;">APPROVE STATUS</th>
                    <th style="padding: 15px 10px; border-bottom: 1px solid #f0f0f0; color: #555; font-size: 10px; font-weight: 700; text-align: center;">AKSI</th>
                </tr>
                <tr>
                    <th style="padding: 5px 10px; border-bottom: 1px solid #f0f0f0;"></th>
                    <th style="padding: 5px 10px; border-bottom: 1px solid #f0f0f0;"><input type="text" class="form-control col-filter" data-col="1" style="padding: 6px 8px; font-size: 10px; border: 1px solid #e0e0e0; border-radius: 4px;" placeholder="CARI.." onkeyup="applyFilters()"></th>
                    <th style="padding: 5px 10px; border-bottom: 1px solid #f0f0f0;"><input type="text" class="form-control col-filter" data-col="2" style="padding: 6px 8px; font-size: 10px; border: 1px solid #e0e0e0; border-radius: 4px;" placeholder="CARI.." onkeyup="applyFilters()"></th>
                    <th style="padding: 5px 10px; border-bottom: 1px solid #f0f0f0;"><input type="text" class="form-control col-filter" data-col="3" style="padding: 6px 8px; font-size: 10px; border: 1px solid #e0e0e0; border-radius: 4px;" placeholder="CARI.." onkeyup="applyFilters()"></th>
                    <th style="padding: 5px 10px; border-bottom: 1px solid #f0f0f0;"><input type="text" class="form-control col-filter" data-col="4" style="padding: 6px 8px; font-size: 10px; border: 1px solid #e0e0e0; border-radius: 4px;" placeholder="CARI.." onkeyup="applyFilters()"></th>
                    <th style="padding: 5px 10px; border-bottom: 1px solid #f0f0f0;"><input type="text" class="form-control col-filter" data-col="5" style="padding: 6px 8px; font-size: 10px; border: 1px solid #e0e0e0; border-radius: 4px;" placeholder="CARI.." onkeyup="applyFilters()"></th>
                    <th style="padding: 5px 10px; border-bottom: 1px solid #f0f0f0;"><input type="text" class="form-control col-filter" data-col="6" style="padding: 6px 8px; font-size: 10px; border: 1px solid #e0e0e0; border-radius: 4px;" placeholder="CARI.." onkeyup="applyFilters()"></th>
                    <th style="padding: 5px 10px; border-bottom: 1px solid #f0f0f0;"><input type="text" class="form-control col-filter" data-col="7" style="padding: 6px 8px; font-size: 10px; border: 1px solid #e0e0e0; border-radius: 4px;" placeholder="CARI.." onkeyup="applyFilters()"></th>
                    <th style="padding: 5px 10px; border-bottom: 1px solid #f0f0f0;"></th>
                    <th style="padding: 5px 10px; border-bottom: 1px solid #f0f0f0;"></th>
                </tr>
            </thead>
            <tbody>
                        <th style="padding: 10px; text-transform: uppercase; font-size: 10px; color: #777; border-bottom: 2px solid #eee;">No</th>
                        <th style="padding: 10px; text-transform: uppercase; font-size: 10px; color: #777; border-bottom: 2px solid #eee;">Cabang</th>
                        <th style="padding: 10px; text-transform: uppercase; font-size: 10px; color: #777; border-bottom: 2px solid #eee;">SA / Teknisi</th>
                        <th style="padding: 10px; text-transform: uppercase; font-size: 10px; color: #777; border-bottom: 2px solid #eee;">Tanggal</th>
                        <th style="padding: 10px; text-transform: uppercase; font-size: 10px; color: #777; border-bottom: 2px solid #eee;">No Polisi</th>
                        <th style="padding: 10px; text-transform: uppercase; font-size: 10px; color: #777; border-bottom: 2px solid #eee;">Tipe Kendaraan</th>
                        <th style="padding: 10px; text-transform: uppercase; font-size: 10px; color: #777; border-bottom: 2px solid #eee;">Status</th>
                        <th style="padding: 10px; text-transform: uppercase; font-size: 10px; color: #777; border-bottom: 2px solid #eee; text-align: center;">Set Status</th>
                        <th style="padding: 10px; text-transform: uppercase; font-size: 10px; color: #777; border-bottom: 2px solid #eee; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="preCheckTableBody">
                    @foreach($preCheckAcs as $index => $item)
                    <tr style="border-bottom: 1px solid #f9f9f9;">
                        <td style="padding: 15px 10px; border-bottom: 1px solid #f5f5f5; color: #555;">{{ $index + 1 }}</td>
                        <td style="padding: 15px 10px; border-bottom: 1px solid #f5f5f5; color: #555;">{{ $item->cabang }}</td>
                        <td style="padding: 15px 10px; border-bottom: 1px solid #f5f5f5; line-height: 1.4;">
                            <div style="font-weight: 600; font-size: 11px; color: #333;">SA: {{ $item->sa ?: '-' }}</div>
                            <div style="color: #888; font-size: 11px;">Tek: {{ $item->teknisi ?: '-' }}</div>
                        </td>
                        <td style="padding: 15px 10px; border-bottom: 1px solid #f5f5f5; color: #555;">{{ $item->tanggal }}</td>
                        <td style="padding: 15px 10px; border-bottom: 1px solid #f5f5f5; font-weight: 600; color: #333;">{{ $item->no_polisi }}</td>
                        <td style="padding: 15px 10px; border-bottom: 1px solid #f5f5f5; color: #555;">{{ strtoupper($item->tipe_kendaraan) }}</td>
                        <td style="padding: 15px 10px; border-bottom: 1px solid #f5f5f5;">
                            @if($item->status_approve == 'DIKERJAKAN')
                                <span style="background: #e8f5e9; color: #2e7d32; padding: 4px 10px; border-radius: 12px; font-size: 10px; font-weight: 600;">DIKERJAKAN</span>
                            @elseif($item->status_approve == 'TIDAK DIKERJAKAN')
                                <span style="background: #ffebee; color: #c62828; padding: 4px 10px; border-radius: 12px; font-size: 10px; font-weight: 600;">TIDAK DIKERJAKAN</span>
                            @else
                                <span style="background: #fff3e0; color: #ef6c00; padding: 4px 10px; border-radius: 12px; font-size: 10px; font-weight: 600;">BELUM DIPROSES</span>
                            @endif
                        </td>
                        <td style="padding: 15px 10px; border-bottom: 1px solid #f5f5f5; text-align: center;">
                            @if($item->status_approve == 'BELUM DIPROSES' || $item->status_approve == null)
                                <form action="{{ route('service.service-ac.ac.pre_check_status', $item->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="DIKERJAKAN">
                                    <button type="submit" style="background: #4caf50; color: white; border: none; padding: 4px 6px; border-radius: 4px; cursor: pointer; font-size: 10px;" title="Set Dikerjakan"><i class="fas fa-check"></i></button>
                                </form>
                                <form action="{{ route('service.service-ac.ac.pre_check_status', $item->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="TIDAK DIKERJAKAN">
                                    <button type="submit" style="background: #f44336; color: white; border: none; padding: 4px 6px; border-radius: 4px; cursor: pointer; font-size: 10px;" title="Set Tidak Dikerjakan"><i class="fas fa-times"></i></button>
                                </form>
                            @else
                                <span style="color: #ccc;">-</span>
                            @endif
                        </td>
                        <td style="padding: 15px 10px; border-bottom: 1px solid #f5f5f5; text-align: center; white-space: nowrap;">
                            <a href="{{ route('service.service-ac.ac.pre_check_pdf', $item->id) }}" style="background: #1976d2; color: white; padding: 5px 8px; border-radius: 4px; font-size: 9px; font-weight: 600; text-decoration: none; display: inline-block;" target="_blank">PDF</a>
                            <button type="button" onclick="sendWA({{ $item->id }}, '{{ $item->no_polisi }}', '{{ $item->tipe_kendaraan }}')" style="background: #4caf50; color: white; padding: 5px 8px; border-radius: 4px; font-size: 9px; font-weight: 600; border: none; cursor: pointer; display: inline-block;">WA</button>
                            <a href="{{ route('service.service-ac.ac.pre_check_edit', $item->id) }}" style="background: #ffb300; color: white; padding: 5px 8px; border-radius: 4px; font-size: 9px; font-weight: 600; text-decoration: none; display: inline-block;">EDT</a>
                            <form action="{{ route('service.service-ac.ac.pre_check_destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Hapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: #e53935; color: white; padding: 5px 8px; border-radius: 4px; font-size: 9px; font-weight: 600; border: none; cursor: pointer;"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                </tr>
                @endforeach
                
                @if($preCheckAcs->isEmpty())
                <tr>
                    <td colspan="10" style="text-align: center; padding: 20px;">Belum ada data Pre Check.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const saData = @json($sas);

function updateSA() {
    const cabang = document.getElementById('cabang_select').value;
    const saSelect = document.getElementById('sa_select');
    
    saSelect.innerHTML = '<option value="">-- Pilih SA --</option>';
    
    if (cabang && saData[cabang]) {
        saData[cabang].forEach(function(sa) {
            const option = document.createElement('option');
            option.value = sa;
            option.textContent = sa;
            saSelect.appendChild(option);
        });
    }
}

function sendWA(id, noPolisi, tipeKendaraan) {
    Swal.fire({
        title: 'Kirim WhatsApp',
        text: 'Masukkan nomor WhatsApp tujuan (contoh: 08123456789):',
        input: 'text',
        inputPlaceholder: 'Mulai dengan 08...',
        showCancelButton: true,
        confirmButtonText: '<i class="fab fa-whatsapp"></i> Kirim WA',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#25D366', // WA Official Color
        cancelButtonColor: '#d33',
        inputValidator: (value) => {
            if (!value) {
                return 'Nomor WhatsApp tidak boleh kosong!'
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            let waNumber = result.value;
            waNumber = waNumber.replace(/[^0-9+]/g, '');
            if (waNumber.startsWith('0')) {
                waNumber = '62' + waNumber.substring(1);
            }
            
            let pdfUrl = "{{ url('/service/service-ac/ac/pre-check') }}/" + id + "/pdf";
            
            let message = `*Hasil Pre Check Kendaraan*\n\nNo Polisi: ${noPolisi}\nTipe: ${tipeKendaraan}\n\nSilakan lihat laporan lengkap:\n${pdfUrl}`;
            
            let encodedMessage = encodeURIComponent(message);
            let waLink = `https://api.whatsapp.com/send?phone=${waNumber}&text=${encodedMessage}`;
            
            window.open(waLink, '_blank');
        }
    });
}

function applyFilters() {
    const table = document.getElementById("preCheckTable");
    const tr = table.getElementsByTagName("tr");
    
    const globalSearch = document.getElementById("globalSearchFilter").value.toLowerCase();
    const branchSearch = document.getElementById("globalCabangFilter").value.toLowerCase();
    
    // Get all column specific filters
    const colFilters = Array.from(document.querySelectorAll('.col-filter')).map(input => ({
        index: parseInt(input.getAttribute('data-col')),
        value: input.value.toLowerCase()
    }));

    // Start from row 2 (index 2) to skip the headers and filter inputs
    for (let i = 2; i < tr.length; i++) {
        const tds = tr[i].getElementsByTagName("td");
        
        // Skip rows that don't have enough columns (like the "Belum ada data" row)
        if (tds.length === 0 || (tds.length === 1 && tds[0].colSpan > 1)) {
            continue;
        }

        let displayRow = true;

        // 1. Global Search
        if (globalSearch) {
            let rowText = "";
            for (let j = 0; j < tds.length; j++) {
                rowText += (tds[j].textContent || tds[j].innerText) + " ";
            }
            if (rowText.toLowerCase().indexOf(globalSearch) === -1) {
                displayRow = false;
            }
        }
        
        // 2. Branch Dropdown Filter
        if (displayRow && branchSearch) {
            const tdCabang = tds[2]; // Column index 2 is Cabang
            if (tdCabang) {
                const cabangText = (tdCabang.textContent || tdCabang.innerText).toLowerCase();
                if (cabangText.indexOf(branchSearch) === -1) {
                    displayRow = false;
                }
            }
        }
        
        // 3. Column Specific Filters
        if (displayRow) {
            for (let filter of colFilters) {
                if (filter.value) {
                    const td = tds[filter.index];
                    if (td) {
                        const txtValue = (td.textContent || td.innerText).toLowerCase();
                        if (txtValue.indexOf(filter.value) === -1) {
                            displayRow = false;
                            break;
                        }
                    }
                }
            }
        }
        
        tr[i].style.display = displayRow ? "" : "none";
    }
}
</script>
@endsection
