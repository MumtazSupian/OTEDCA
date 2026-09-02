@extends('layouts.app')

@section('title', 'Master Asuransi - OTE DCA')

@section('content')
<div class="master-asuransi-container">
    {{-- 1. HEADER SECTION --}}
    <div class="page-header-row">
        <div class="header-text-group">
            <h1 class="page-title">Master Asuransi</h1>
            <p class="page-subtitle">Kelola daftar perusahaan asuransi dan pengaturan threshold</p>
        </div>
    </div>

    {{-- 2. TAB NAVIGATION --}}
    <div class="tab-nav-bar">
        <button type="button" class="tab-btn {{ ($activeTab ?? 'perusahaan') == 'perusahaan' ? 'active' : '' }}" onclick="switchTab('perusahaan')">
            <span>Perusahaan Asuransi</span>
        </button>
        <button type="button" class="tab-btn {{ ($activeTab ?? '') == 'pengaturan' ? 'active' : '' }}" onclick="switchTab('pengaturan')">
            <span>Pengaturan</span>
        </button>
        <button type="button" class="tab-btn {{ ($activeTab ?? '') == 'riwayat_import' ? 'active' : '' }}" onclick="switchTab('riwayat_import')">
            <span>Riwayat Import</span>
        </button>
    </div>

    {{-- 3. TAB 1: PERUSAHAAN ASURANSI --}}
    <div class="tab-content-panel" id="tabPanelPerusahaan" style="display: {{ ($activeTab ?? 'perusahaan') == 'perusahaan' ? 'block' : 'none' }};">
        <div class="tab-action-bar">
            <button type="button" class="btn-add-primary" onclick="openModalAddPerusahaan()">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>Tambah Perusahaan</span>
            </button>
        </div>

        <div class="table-card-wrapper">
            <div class="table-responsive">
                <table class="master-table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Nama Perusahaan</th>
                            <th style="width: 140px;">Urutan</th>
                            <th style="width: 140px;">Status</th>
                            <th style="width: 100px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($perusahaanList as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <span class="company-name-text">{{ $p['nama_perusahaan'] }}</span>
                            </td>
                            <td>{{ $p['urutan'] ?? 0 }}</td>
                            <td>
                                <span class="badge-status-aktif">{{ $p['status'] ?? 'Aktif' }}</span>
                            </td>
                            <td style="text-align: center;">
                                <div class="action-btn-group">
                                    <button type="button" class="btn-icon-action btn-icon-edit" onclick="openModalEditPerusahaan({{ json_encode($p) }})" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 20h9"></path>
                                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                        </svg>
                                    </button>
                                    <button type="button" class="btn-icon-action btn-icon-delete" onclick="deletePerusahaan('{{ $p['nama_perusahaan'] }}')" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="15" y1="9" x2="9" y2="15"></line>
                                            <line x1="9" y1="9" x2="15" y2="15"></line>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center" style="padding: 40px; color: #94a3b8;">
                                Belum ada daftar perusahaan asuransi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- 4. TAB 2: PENGATURAN (SETTINGS) --}}
    <div class="tab-content-panel" id="tabPanelPengaturan" style="display: {{ ($activeTab ?? '') == 'pengaturan' ? 'block' : 'none' }};">
        <form method="POST" action="javascript:void(0)" onsubmit="saveSettings()">
            @csrf
            
            {{-- Section 1: Threshold Status Asuransi --}}
            <div class="settings-card">
                <div class="settings-header">
                    <h3 class="settings-title">Threshold Status Asuransi</h3>
                    <p class="settings-subtitle">Atur batas hari untuk menentukan status segera habis dan kritis.</p>
                </div>
                <div class="settings-grid-2">
                    <div class="settings-item">
                        <label class="form-label">Batas Hari Kritis (Merah)</label>
                        <div class="input-with-suffix">
                            <input type="number" name="kritis_hari" value="{{ $settings['kritis_hari'] ?? 30 }}" class="input-form-control" min="1">
                            <span class="suffix-text">hari</span>
                        </div>
                        <span class="field-hint">Asuransi dengan sisa &le; nilai ini ditandai merah</span>
                    </div>
                    <div class="settings-item">
                        <label class="form-label">Batas Hari Peringatan (Kuning)</label>
                        <div class="input-with-suffix">
                            <input type="number" name="peringatan_hari" value="{{ $settings['peringatan_hari'] ?? 60 }}" class="input-form-control" min="1">
                            <span class="suffix-text">hari</span>
                        </div>
                        <span class="field-hint">Asuransi dengan sisa &le; nilai ini ditandai kuning</span>
                    </div>
                </div>
            </div>

            {{-- Section 2: Scope Analisis --}}
            <div class="settings-card">
                <div class="settings-header">
                    <h3 class="settings-title">Scope Analisis</h3>
                    <p class="settings-subtitle">Berapa tahun ke belakang kendaraan yang ditampilkan di halaman Tanpa Asuransi.</p>
                </div>
                <div class="settings-grid-2">
                    <div class="settings-item">
                        <label class="form-label">Scope Kendaraan Tanpa Asuransi</label>
                        <div class="input-with-suffix">
                            <input type="number" name="scope_tahun" value="{{ $settings['scope_tahun'] ?? 5 }}" class="input-form-control" min="1">
                            <span class="suffix-text">tahun</span>
                        </div>
                        <span class="field-hint">Kendaraan dengan tanggal DO dalam N tahun terakhir</span>
                    </div>
                </div>
            </div>

            {{-- Section 3: Follow-Up Asuransi --}}
            <div class="settings-card">
                <div class="settings-header">
                    <h3 class="settings-title">Follow-Up Asuransi</h3>
                    <p class="settings-subtitle">Konfigurasi attack list harian dan notifikasi WhatsApp.</p>
                </div>
                <div class="settings-grid-2">
                    <div class="settings-item">
                        <label class="form-label">Lookback Tanpa Asuransi (Bulan)</label>
                        <div class="input-with-suffix">
                            <input type="number" name="lookback_bulan" value="{{ $settings['lookback_bulan'] ?? 12 }}" class="input-form-control" min="1">
                            <span class="suffix-text">bulan</span>
                        </div>
                        <span class="field-hint">Kendaraan DO dalam N bulan terakhir tanpa asuransi masuk attack list</span>
                    </div>
                    <div class="settings-item">
                        <label class="form-label">Asuransi Habis dalam (Bulan)</label>
                        <div class="input-with-suffix">
                            <input type="number" name="habis_bulan" value="{{ $settings['habis_bulan'] ?? 2 }}" class="input-form-control" min="1">
                            <span class="suffix-text">bulan</span>
                        </div>
                        <span class="field-hint">Asuransi yang habis dalam N bulan ke depan masuk attack list</span>
                    </div>
                    <div class="settings-item">
                        <label class="form-label">Snooze Tidak Berminat (Bulan)</label>
                        <div class="input-with-suffix">
                            <input type="number" name="snooze_bulan" value="{{ $settings['snooze_bulan'] ?? 6 }}" class="input-form-control" min="1">
                            <span class="suffix-text">bulan</span>
                        </div>
                        <span class="field-hint">Kendaraan TIDAK_BERMINAT disembunyikan selama N bulan</span>
                    </div>
                    <div class="settings-item">
                        <label class="form-label">Waktu Sync Harian (WIB, format HH:MM)</label>
                        <input type="text" name="waktu_sync" value="{{ $settings['waktu_sync'] ?? '02:00' }}" class="input-form-control font-mono" placeholder="02:00">
                        <span class="field-hint">Jam sync attack list dari DLR, dalam WIB (Jakarta UTC+7). Server otomatis konversi ke UTC.</span>
                    </div>
                </div>

                <div class="settings-toggle-row">
                    <div class="toggle-text-block">
                        <span class="form-label">Aktifkan Kirim WA Follow-Up</span>
                        <span class="field-hint" style="margin-top: 2px;">Jika aktif, sales dapat mengirim WA ke konsumen dari halaman follow-up</span>
                    </div>
                    <label class="switch-ui">
                        <input type="checkbox" name="aktifkan_wa" value="1" {{ !empty($settings['aktifkan_wa']) ? 'checked' : '' }}>
                        <span class="slider-ui round"></span>
                    </label>
                </div>
            </div>

            {{-- Submit Settings --}}
            <div class="settings-action-bar">
                <button type="submit" class="btn-save-settings">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    <span>Simpan Pengaturan</span>
                </button>
            </div>
        </form>
    </div>

    {{-- 5. TAB 3: RIWAYAT IMPORT --}}
    <div class="tab-content-panel" id="tabPanelRiwayat" style="display: {{ ($activeTab ?? '') == 'riwayat_import' ? 'block' : 'none' }};">
        <div class="table-card-wrapper">
            <div class="table-subtoolbar">
                <h3 class="subtoolbar-title">Riwayat Import Data Asuransi</h3>
                <a href="javascript:location.reload()" class="btn-refresh-icon" title="Refresh">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="23 4 23 10 17 10"></polyline>
                        <polyline points="1 20 1 14 7 14"></polyline>
                        <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                    </svg>
                </a>
            </div>

            <div class="table-responsive">
                <table class="master-table">
                    <thead>
                        <tr>
                            <th style="width: 35px;"></th>
                            <th style="min-width: 140px;">Tanggal</th>
                            <th style="min-width: 180px;">Diimport Oleh</th>
                            <th style="min-width: 180px;">File</th>
                            <th style="width: 80px; text-align: center;">Dibuat</th>
                            <th style="width: 80px; text-align: center;">Update</th>
                            <th style="width: 80px; text-align: center;">Lewati</th>
                            <th style="width: 80px; text-align: center;">Error</th>
                            <th style="width: 120px; text-align: center;">Status</th>
                            <th style="width: 90px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatImport as $r)
                        <tr>
                            <td style="color: #94a3b8; font-weight: 700; cursor: pointer;">&rsaquo;</td>
                            <td>{{ $r['tanggal'] }}</td>
                            <td class="font-bold">{{ $r['diimport_oleh'] }}</td>
                            <td class="font-mono" style="color: #0284c7;">{{ $r['file'] }}</td>
                            <td style="text-align: center;">{{ $r['dibuat'] }}</td>
                            <td style="text-align: center;">{{ $r['update'] }}</td>
                            <td style="text-align: center;">{{ $r['lewati'] }}</td>
                            <td style="text-align: center;">{{ $r['error'] }}</td>
                            <td style="text-align: center;">
                                @if($r['status'] == 'completed')
                                    <span class="badge-import-completed">completed</span>
                                @else
                                    <span class="badge-import-cancelled">cancelled</span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <div class="action-btn-group">
                                    <button type="button" class="btn-icon-action btn-icon-download" title="Download Excel" onclick="alert('Download file {{ $r['file'] }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                            <polyline points="7 10 12 15 17 10"></polyline>
                                            <line x1="12" y1="15" x2="12" y2="3"></line>
                                        </svg>
                                    </button>
                                    <button type="button" class="btn-icon-action btn-icon-rollback" title="Rollback" onclick="alert('Rollback import {{ $r['file'] }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="1 4 1 10 7 10"></polyline>
                                            <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center" style="padding: 40px; color: #94a3b8;">
                                Belum ada riwayat import data asuransi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="table-pagination-footer">
                <div class="pagination-controls">
                    <button type="button" class="btn-page" title="Halaman Pertama">«</button>
                    <button type="button" class="btn-page" title="Sebelumnya">‹</button>
                    <button type="button" class="btn-page btn-page-active">1</button>
                    <button type="button" class="btn-page" title="Selanjutnya">›</button>
                    <button type="button" class="btn-page" title="Halaman Terakhir">»</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH / EDIT PERUSAHAAN --}}
    <div class="modal-backdrop" id="modalPerusahaan">
        <div class="modal-dialog modal-perusahaan-dialog">
            <div class="modal-header">
                <h3 class="modal-title" id="modalPerusahaanTitle">Tambah Perusahaan Asuransi</h3>
                <button type="button" class="btn-modal-close" onclick="closeModalPerusahaan()">&times;</button>
            </div>
            <div class="modal-body modal-form-body">
                <div class="form-group">
                    <label class="form-label">Nama Perusahaan Asuransi</label>
                    <input type="text" id="formNamaPerusahaan" class="input-form-control" placeholder="Contoh: GARDA OTO">
                </div>
                <div class="form-group">
                    <label class="form-label">Urutan Tampilan</label>
                    <input type="number" id="formUrutan" class="input-form-control" value="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select id="formStatusPerusahaan" class="input-form-control">
                        <option value="Aktif">Aktif</option>
                        <option value="Nonaktif">Nonaktif</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-edit-cancel" onclick="closeModalPerusahaan()">Batal</button>
                <button type="button" class="btn-edit-save" onclick="savePerusahaan()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Global Container */
    .master-asuransi-container {
        padding: 24px 28px 40px 28px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        color: #1e293b;
        box-sizing: border-box;
    }

    /* Header */
    .page-header-row {
        margin-bottom: 20px;
    }
    .page-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
        letter-spacing: -0.3px;
    }
    .page-subtitle {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }

    /* Tab Navigation */
    .tab-nav-bar {
        display: flex;
        align-items: center;
        gap: 8px;
        border-bottom: 2px solid #f1f5f9;
        margin-bottom: 24px;
    }
    .tab-btn {
        background: transparent;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 10px 18px;
        font-size: 13.5px;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        margin-bottom: -2px;
        transition: all 0.2s ease;
    }
    .tab-btn:hover {
        color: #dc2626;
    }
    .tab-btn.active {
        color: #dc2626;
        border-bottom-color: #dc2626;
        font-weight: 800;
    }

    /* Tab 1 Content */
    .tab-action-bar {
        margin-bottom: 16px;
    }
    .btn-add-primary {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.25);
        transition: all 0.2s ease;
    }
    .btn-add-primary:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        transform: translateY(-1px);
    }

    /* Table Section */
    .table-card-wrapper {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }
    .master-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 12.5px;
    }
    .master-table thead th {
        background: #ffffff;
        color: #475569;
        font-weight: 700;
        font-size: 12px;
        padding: 12px 16px;
        border-bottom: 1.5px solid #e2e8f0;
        white-space: nowrap;
    }
    .master-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s ease;
    }
    .master-table tbody tr:hover {
        background-color: #f8fafc;
    }
    .master-table tbody td {
        padding: 12px 16px;
        color: #334155;
        vertical-align: middle;
    }
    .company-name-text {
        font-weight: 700;
        color: #0f172a;
        letter-spacing: 0.1px;
    }
    .badge-status-aktif {
        background: #dcfce7;
        color: #15803d;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 5px;
        display: inline-block;
    }
    .action-btn-group {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-icon-action {
        width: 26px;
        height: 26px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #64748b;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
    }
    .btn-icon-edit:hover {
        background: #eff6ff;
        color: #2563eb;
        border-color: #bfdbfe;
    }
    .btn-icon-delete:hover {
        background: #fee2e2;
        color: #dc2626;
        border-color: #fecaca;
    }
    .btn-icon-download:hover {
        background: #eff6ff;
        color: #0284c7;
        border-color: #bae6fd;
    }
    .btn-icon-rollback:hover {
        background: #fef3c7;
        color: #d97706;
        border-color: #fde68a;
    }

    /* Tab 2: Settings Cards */
    .settings-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 20px 24px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
        margin-bottom: 20px;
    }
    .settings-header {
        margin-bottom: 16px;
    }
    .settings-title {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
    }
    .settings-subtitle {
        font-size: 12px;
        color: #64748b;
        margin: 0;
    }
    .settings-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px 24px;
    }
    @media (max-width: 768px) {
        .settings-grid-2 { grid-template-columns: 1fr; }
    }
    .settings-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .form-label {
        font-size: 12px;
        font-weight: 700;
        color: #475569;
    }
    .input-form-control {
        width: 100%;
        height: 38px;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 12.5px;
        color: #1e293b;
        box-sizing: border-box;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .input-form-control:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
    }
    .input-with-suffix {
        position: relative;
        display: flex;
        align-items: center;
    }
    .input-with-suffix input {
        padding-right: 50px;
    }
    .suffix-text {
        position: absolute;
        right: 12px;
        font-size: 12px;
        color: #94a3b8;
        font-weight: 600;
        pointer-events: none;
    }
    .field-hint {
        font-size: 11px;
        color: #94a3b8;
    }
    .settings-toggle-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 18px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }
    .toggle-text-block {
        display: flex;
        flex-direction: column;
    }
    .settings-action-bar {
        display: flex;
        justify-content: flex-start;
        margin-top: 10px;
    }
    .btn-save-settings {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 22px;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.25);
        transition: all 0.2s ease;
    }
    .btn-save-settings:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        transform: translateY(-1px);
    }

    /* Switch UI */
    .switch-ui {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
    }
    .switch-ui input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider-ui {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: #cbd5e1;
        transition: .25s;
        border-radius: 24px;
    }
    .slider-ui:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .25s;
        border-radius: 50%;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
    .switch-ui input:checked + .slider-ui {
        background-color: #dc2626;
    }
    .switch-ui input:checked + .slider-ui:before {
        transform: translateX(20px);
    }

    /* Tab 3: Subtoolbar */
    .table-subtoolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 18px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }
    .subtoolbar-title {
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }
    .badge-import-completed {
        background: #dcfce7;
        color: #15803d;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 5px;
        display: inline-block;
    }
    .badge-import-cancelled {
        background: #fee2e2;
        color: #b91c1c;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 5px;
        display: inline-block;
    }
    .font-mono { font-family: 'JetBrains Mono', monospace; font-size: 12px; }
    .font-bold { font-weight: 700; }

    .table-pagination-footer {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 14px 18px;
        background: #ffffff;
        border-top: 1px solid #e2e8f0;
    }
    .pagination-controls {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .btn-page {
        min-width: 30px;
        height: 30px;
        padding: 0 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #475569;
        font-size: 12.5px;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
    }
    .btn-page-active {
        background: #dc2626 !important;
        border-color: #dc2626 !important;
        color: #ffffff !important;
        font-weight: 800;
    }
    .btn-refresh-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 6px;
        color: #ef4444;
        background: #fee2e2;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-refresh-icon:hover {
        background: #fecaca;
        color: #dc2626;
    }

    /* Modal */
    .modal-backdrop {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(4px);
        z-index: 99999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
    }
    .modal-dialog {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        animation: modalFadeSlide 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        width: 440px;
        max-width: 100%;
    }
    @keyframes modalFadeSlide {
        from { opacity: 0; transform: translateY(12px) scale(0.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 20px;
        border-bottom: 1px solid #e2e8f0;
    }
    .modal-title {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }
    .btn-modal-close {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #64748b;
        font-size: 18px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .modal-form-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .modal-footer {
        padding: 14px 20px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    .btn-edit-cancel {
        padding: 7px 16px;
        background: transparent;
        color: #64748b;
        border: none;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-edit-save {
        padding: 7px 18px;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #ffffff;
        border: none;
        border-radius: 6px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.25);
    }
</style>

<script>
    function switchTab(tabName) {
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-content-panel').forEach(panel => panel.style.display = 'none');

        if (tabName === 'perusahaan') {
            document.querySelectorAll('.tab-btn')[0].classList.add('active');
            document.getElementById('tabPanelPerusahaan').style.display = 'block';
        } else if (tabName === 'pengaturan') {
            document.querySelectorAll('.tab-btn')[1].classList.add('active');
            document.getElementById('tabPanelPengaturan').style.display = 'block';
        } else if (tabName === 'riwayat_import') {
            document.querySelectorAll('.tab-btn')[2].classList.add('active');
            document.getElementById('tabPanelRiwayat').style.display = 'block';
        }
    }

    function openModalAddPerusahaan() {
        document.getElementById('modalPerusahaanTitle').textContent = 'Tambah Perusahaan Asuransi';
        document.getElementById('formNamaPerusahaan').value = '';
        document.getElementById('formUrutan').value = '0';
        document.getElementById('formStatusPerusahaan').value = 'Aktif';
        document.getElementById('modalPerusahaan').style.display = 'flex';
    }

    function openModalEditPerusahaan(item) {
        document.getElementById('modalPerusahaanTitle').textContent = 'Edit Perusahaan Asuransi';
        document.getElementById('formNamaPerusahaan').value = item.nama_perusahaan || '';
        document.getElementById('formUrutan').value = item.urutan || '0';
        document.getElementById('formStatusPerusahaan').value = item.status || 'Aktif';
        document.getElementById('modalPerusahaan').style.display = 'flex';
    }

    function closeModalPerusahaan() {
        document.getElementById('modalPerusahaan').style.display = 'none';
    }

    function savePerusahaan() {
        const nama = document.getElementById('formNamaPerusahaan').value;
        if (!nama) {
            alert('Silakan isi nama perusahaan.');
            return;
        }
        alert('Perusahaan asuransi ' + nama + ' berhasil disimpan.');
        closeModalPerusahaan();
    }

    function deletePerusahaan(nama) {
        if (confirm('Apakah Anda yakin ingin menghapus perusahaan ' + nama + '?')) {
            alert('Perusahaan ' + nama + ' berhasil dihapus.');
        }
    }

    function saveSettings() {
        alert('Pengaturan threshold dan follow-up berhasil disimpan.');
    }

    // Close on backdrop click
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('modalPerusahaan');
        if (event.target === modal) {
            closeModalPerusahaan();
        }
    });
</script>
@endsection
