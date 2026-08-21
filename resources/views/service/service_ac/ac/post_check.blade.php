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


        /* Modal & Input Icon Styles */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1050;
        }
        .modal-box {
            background: white;
            width: 90%;
            max-width: 600px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .modal-header {
            padding: 15px 20px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
        }
        .modal-close {
            cursor: pointer;
            font-size: 22px;
            color: #adb5bd;
            background: none;
            border: none;
            line-height: 1;
        }
        .modal-close:hover {
            color: #dc3545;
        }
        .modal-body {
            padding: 20px;
            max-height: 70vh;
            overflow-y: auto;
        }
        .input-with-icon {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
        }
        .input-with-icon input {
            width: 100%;
            padding-right: 40px !important;
        }
        .input-with-icon i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #1976d2;
            cursor: pointer;
            font-size: 15px;
            transition: color 0.2s, transform 0.2s;
        }
        .input-with-icon i:hover {
            color: #0d47a1;
            transform: translateY(-50%) scale(1.15);
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
            <!-- Left Column -->
            <div class="form-col">
                <div class="form-group">
                    <label>Jenis Pemeriksaan</label>
                    <select name="jenis_pemeriksaan" class="form-control">
                        <option value="POST CHECK">POST CHECK</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>No SPK:</label>
                    <div class="input-with-icon">
                        <input type="text" id="no_spk" name="no_spk" class="form-control" placeholder="Masukkan No SPK" onchange="fetchSpkData()">
                        <i class="fas fa-search" onclick="openSpkModal()" title="Cari SPK Bulan Ini"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label>Cabang</label>
                    <input type="text" id="cabang" name="cabang" class="form-control" readonly style="background-color: #e9ecef; cursor: not-allowed;">
                </div>
                <div class="form-group">
                    <label>Service Advisor (SA):</label>
                    <input type="text" id="sa" name="sa" class="form-control" readonly style="background-color: #e9ecef; cursor: not-allowed;">
                </div>
            </div>

            <!-- Right Column -->
            <div class="form-col">
                <div class="form-group">
                    <label>No Polisi:</label>
                    <input type="text" id="no_polisi" name="no_polisi" class="form-control" readonly style="background-color: #e9ecef; cursor: not-allowed;">
                </div>
                <div class="form-group">
                    <label>Tipe Kendaraan:</label>
                    <input type="text" id="tipe_kendaraan" name="tipe_kendaraan" class="form-control" readonly style="background-color: #e9ecef; cursor: not-allowed;">
                </div>
                <div class="form-group">
                    <label>Teknisi Pemeriksa</label>
                    <select name="teknisi" id="teknisi" class="form-control">
                        <option value="">-- Pilih Teknisi --</option>
                        @foreach($teknisis as $tek)
                            @php $tekName = is_object($tek) ? $tek->nama : $tek; @endphp
                            <option value="{{ $tekName }}" {{ old('teknisi') == $tekName ? 'selected' : '' }}>{{ $tekName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Hari, Tanggal:</label>
                    <input type="date" id="tanggal" name="tanggal" class="form-control" readonly style="background-color: #e9ecef; cursor: not-allowed;">
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
            <button type="submit" class="btn-submit"><i class="fas fa-save"></i> SIMPAN DATA POST CHECK</button>
        </div>
    </form>
</div>

<!-- TAB LIST DATA -->
<div class="tab-content {{ $tab == 'list' ? 'active' : '' }}" style="background-color: #f4f6f9; padding: 20px;">
    
    <!-- Header Card -->
    <div style="background: white; padding: 20px 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h3 style="margin: 0; color: #1976d2; font-size: 22px; font-weight: 500;">Data Post Check</h3>
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

        <table class="custom-table" id="postCheckTable" style="border-collapse: collapse; width: 100%;">
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
                                    <th style="padding: 10px; text-transform: uppercase; font-size: 10px; color: #777; border-bottom: 2px solid #eee;">No</th>
                        <th style="padding: 10px; text-transform: uppercase; font-size: 10px; color: #777; border-bottom: 2px solid #eee;">Jenis Pemeriksaan</th>
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
                <tbody id="postCheckTableBody">
                    @foreach($postCheckAcs as $index => $item)
                    <tr style="border-bottom: 1px solid #f9f9f9;">
                        <td style="padding: 15px 10px; border-bottom: 1px solid #f5f5f5; color: #555;">{{ $index + 1 }}</td>
                        <td style="padding: 15px 10px; border-bottom: 1px solid #f5f5f5; color: #555;">{{ $item->jenis_pemeriksaan ?: 'Post Check' }}</td>
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
                                <form action="{{ route('service.service-ac.ac.post_check_status', $item->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="DIKERJAKAN">
                                    <button type="submit" style="background: #4caf50; color: white; border: none; padding: 4px 6px; border-radius: 4px; cursor: pointer; font-size: 10px;" title="Set Dikerjakan"><i class="fas fa-check"></i></button>
                                </form>
                                <form action="{{ route('service.service-ac.ac.post_check_status', $item->id) }}" method="POST" style="display:inline-block;">
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
                            <a href="{{ route('service.service-ac.ac.post_check_pdf', $item->id) }}" style="background: #1976d2; color: white; padding: 5px 8px; border-radius: 4px; font-size: 9px; font-weight: 600; text-decoration: none; display: inline-block;" target="_blank">PDF</a>
                            <button type="button" onclick="sendWA({{ $item->id }}, '{{ $item->no_polisi }}', '{{ $item->tipe_kendaraan }}')" style="background: #4caf50; color: white; padding: 5px 8px; border-radius: 4px; font-size: 9px; font-weight: 600; border: none; cursor: pointer; display: inline-block;">WA</button>
                            <a href="{{ route('service.service-ac.ac.post_check_edit', $item->id) }}" style="background: #ffb300; color: white; padding: 5px 8px; border-radius: 4px; font-size: 9px; font-weight: 600; text-decoration: none; display: inline-block;">EDT</a>
                            <form action="{{ route('service.service-ac.ac.post_check_destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Hapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: #e53935; color: white; padding: 5px 8px; border-radius: 4px; font-size: 9px; font-weight: 600; border: none; cursor: pointer;"><i class="fas fa-trash"></i></button>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const saData = @json($sas);
const teknisiData = @json($teknisis);

function updateDropdowns() {
    const cabang = document.getElementById('cabang_select').value;
    const saSelect = document.getElementById('sa_select');
    const teknisiSelect = document.getElementById('teknisi_select');
    
    saSelect.innerHTML = '<option value="">-- Pilih SA --</option>';
    teknisiSelect.innerHTML = '<option value="">-- Pilih Teknisi --</option>';
    
    if (cabang) {
        if (saData[cabang]) {
            saData[cabang].forEach(function(sa) {
                const option = document.createElement('option');
                option.value = sa;
                option.textContent = sa;
                saSelect.appendChild(option);
            });
        }
        
        if (teknisiData[cabang]) {
            teknisiData[cabang].forEach(function(teknisi) {
                const option = document.createElement('option');
                option.value = teknisi;
                option.textContent = teknisi;
                teknisiSelect.appendChild(option);
            });
        }
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
            
            let pdfUrl = "{{ url('/service/service-ac/ac/post-check') }}/" + id + "/pdf";
            
            let message = `*Hasil Post Check Kendaraan*\n\nNo Polisi: ${noPolisi}\nTipe: ${tipeKendaraan}\n\nSilakan lihat laporan lengkap:\n${pdfUrl}`;
            
            let encodedMessage = encodeURIComponent(message);
            let waLink = `https://api.whatsapp.com/send?phone=${waNumber}&text=${encodedMessage}`;
            
            window.open(waLink, '_blank');
        }
    });
}

function applyFilters() {
    const table = document.getElementById("postCheckTable");
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
                // We use exact match or includes here
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
                            break; // no need to check other columns if one fails
                        }
                    }
                }
            }
        }
        
        tr[i].style.display = displayRow ? "" : "none";
    }
}
</script>


<!-- Modal SPK -->
<div class="modal-overlay" id="spkModal">
    <div class="modal-box" style="max-width: 600px;">
        <div class="modal-header">
            <h4 style="margin:0; font-size:16px; font-weight:700; color:#2c3e50;"><i class="fas fa-file-invoice" style="color:#1976d2; margin-right:8px;"></i> Pilih No SPK (Bulan Ini)</h4>
            <button type="button" class="modal-close" onclick="closeSpkModal()">&times;</button>
        </div>
        <div class="modal-body">
            <div style="margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; gap: 10px;">
                <div>
                    <label style="font-size:12px; font-weight:normal; color:#555;">Show 
                        <select id="spkLimit" onchange="renderSpkTable()" style="padding:4px 8px; border-radius:6px; border:1px solid #ced4da; font-size:12px;">
                            <option value="10">10</option><option value="25">25</option><option value="50">50</option>
                        </select> entries
                    </label>
                </div>
                <div>
                    <input type="text" id="spkSearch" class="form-control" style="display:inline-block; width:180px; padding:6px 12px; font-size:12px; border-radius:6px;" onkeyup="renderSpkTable()" placeholder="Cari No SPK...">
                </div>
            </div>
            <table style="width: 100%; border-collapse: collapse; font-size:13px;">
                <thead>
                    <tr style="border-bottom: 2px solid #e9ecef; background:#f8f9fa;">
                        <th style="padding: 12px 15px; text-align: left; color:#495057; font-weight:700;">No SPK</th>
                        <th style="padding: 12px 15px; text-align: center; width: 120px; color:#495057; font-weight:700;">Action</th>
                    </tr>
                </thead>
                <tbody id="spkTableBody">
                    <tr><td colspan="2" style="text-align: center; padding: 25px; color:#6c757d;">Memuat data dari server...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
let spkDataList = [];

function openSpkModal() {
    document.getElementById('spkModal').style.display = 'flex';
    document.getElementById('spkTableBody').innerHTML = '<tr><td colspan="2" style="text-align: center; padding: 25px; color:#6c757d;">Memuat data dari server...</td></tr>';
    
    fetch("{{ route('service.service-ac.ac.post_check_get_spk_list') }}")
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                spkDataList = data.data;
                renderSpkTable();
            } else {
                document.getElementById('spkTableBody').innerHTML = '<tr><td colspan="2" style="text-align: center; padding: 25px; color: #dc3545;">' + data.message + '</td></tr>';
            }
        })
        .catch(error => {
            document.getElementById('spkTableBody').innerHTML = '<tr><td colspan="2" style="text-align: center; padding: 25px; color: #dc3545;">Terjadi kesalahan koneksi ke server</td></tr>';
        });
}

function closeSpkModal() {
    document.getElementById('spkModal').style.display = 'none';
}

function renderSpkTable() {
    let search = document.getElementById('spkSearch').value.toLowerCase();
    let limit = parseInt(document.getElementById('spkLimit').value);
    
    let filtered = spkDataList.filter(item => {
        return item.JobOrderNo && item.JobOrderNo.toLowerCase().includes(search);
    });
    
    let html = '';
    if (filtered.length === 0) {
        html = '<tr><td colspan="2" style="text-align: center; padding: 25px; color:#dc3545; font-size:12px;">Data SPK tidak ditemukan</td></tr>';
    } else {
        let count = 0;
        for (let item of filtered) {
            if (count >= limit) break;
            html += `
                <tr style="border-bottom: 1px solid #e9ecef;">
                    <td style="padding: 12px 15px; font-weight:600; color:#2c3e50;">${item.JobOrderNo}</td>
                    <td style="padding: 12px 15px; text-align: center;">
                        <button type="button" style="background: #1976d2; color: white; border: none; padding: 6px 18px; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: 700; transition: all 0.2s;" onclick="pilihSpk('${item.JobOrderNo}')">Pilih</button>
                    </td>
                </tr>
            `;
            count++;
        }
    }
    document.getElementById('spkTableBody').innerHTML = html;
}

function pilihSpk(spk) {
    document.getElementById('no_spk').value = spk;
    closeSpkModal();
    fetchSpkData();
}

function fetchSpkData() {
    let spk = document.getElementById('no_spk').value;
    if (!spk) return;

    fetch("{{ route('service.service-ac.ac.post_check_get_spk_data') }}?no_spk=" + encodeURIComponent(spk))
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data) {
                if (document.getElementById('cabang')) document.getElementById('cabang').value = data.data.BranchCode || '';
                if (document.getElementById('sa')) document.getElementById('sa').value = data.data.EmployeeName || '';
                if (document.getElementById('no_polisi')) document.getElementById('no_polisi').value = data.data.PoliceRegNo || '';
                if (document.getElementById('tipe_kendaraan')) document.getElementById('tipe_kendaraan').value = data.data.BasicModel || '';
                if (document.getElementById('tanggal')) {
                    document.getElementById('tanggal').value = data.data.JobOrderDate || '';
                }
            } else {
                alert(data.message || 'SPK tidak ditemukan di database');
            }
        })
        .catch(error => {
            console.error('Error fetching SPK:', error);
            alert('Gagal mengambil data SPK dari server.');
        });
}
</script>


@endsection
