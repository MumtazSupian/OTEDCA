@extends('layouts.app')

@section('title', 'Data Asuransi Kendaraan - OTE DCA')

@section('content')
<div class="asuransi-container">
    {{-- 1. HEADER SECTION --}}
    <div class="page-header-row">
        <div class="header-text-group">
            <h1 class="page-title">Data Asuransi Kendaraan</h1>
            <p class="page-subtitle">Daftar kendaraan dari data billing — overlay data asuransi user</p>
        </div>
        <div class="header-action-group">
            <button type="button" class="btn-import-excel" onclick="openImportModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="17 8 12 3 7 8"></polyline>
                    <line x1="12" y1="3" x2="12" y2="15"></line>
                </svg>
                <span>Import Excel</span>
            </button>
            <button type="button" class="btn-export-purple" onclick="alert('Export Excel asuransi sedang dipersiapkan...')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                <span>Export</span>
            </button>
        </div>
    </div>

    {{-- 2. FILTER & SEARCH CARD --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('asuransi.data') }}" id="filterForm">
            <div class="filter-grid">
                {{-- Periode (Tgl Billing) --}}
                <div class="filter-item filter-periode">
                    <label class="filter-label">Periode (Tgl Billing)</label>
                    <div class="date-range-input-wrapper">
                        <input type="date" name="start_date" value="{{ $startDate }}" class="input-date-range" id="startDateInput">
                        <span class="date-separator">s/d</span>
                        <input type="date" name="end_date" value="{{ $endDate }}" class="input-date-range" id="endDateInput">
                    </div>
                </div>

                {{-- Status Asuransi --}}
                <div class="filter-item">
                    <label class="filter-label">Status Asuransi</label>
                    <select name="status_asuransi" class="select-control">
                        <option value="Semua" {{ ($statusAsuransi ?? 'Semua') == 'Semua' ? 'selected' : '' }}>Semua</option>
                        <option value="Aktif" {{ ($statusAsuransi ?? '') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Segera Habis (Kuning)" {{ ($statusAsuransi ?? '') == 'Segera Habis (Kuning)' ? 'selected' : '' }}>Segera Habis (Kuning)</option>
                        <option value="Kritis (Merah)" {{ ($statusAsuransi ?? '') == 'Kritis (Merah)' ? 'selected' : '' }}>Kritis (Merah)</option>
                        <option value="Expired" {{ ($statusAsuransi ?? '') == 'Expired' ? 'selected' : '' }}>Expired</option>
                        <option value="Belum Ada Data" {{ ($statusAsuransi ?? '') == 'Belum Ada Data' ? 'selected' : '' }}>Belum Ada Data</option>
                    </select>
                </div>

                {{-- Jenis --}}
                <div class="filter-item">
                    <label class="filter-label">Jenis</label>
                    <select name="jenis" class="select-control">
                        <option value="Semua" {{ ($jenis ?? 'Semua') == 'Semua' ? 'selected' : '' }}>Semua</option>
                        <option value="COMP" {{ ($jenis ?? '') == 'COMP' ? 'selected' : '' }}>COMP</option>
                        <option value="TLO" {{ ($jenis ?? '') == 'TLO' ? 'selected' : '' }}>TLO</option>
                        <option value="DLR" {{ ($jenis ?? '') == 'DLR' ? 'selected' : '' }}>DLR</option>
                    </select>
                </div>

                {{-- Pembiayaan --}}
                <div class="filter-item">
                    <label class="filter-label">Pembiayaan</label>
                    <select name="pembiayaan" class="select-control">
                        <option value="Semua" {{ ($pembiayaan ?? 'Semua') == 'Semua' ? 'selected' : '' }}>Semua</option>
                        <option value="Leasing" {{ ($pembiayaan ?? '') == 'Leasing' ? 'selected' : '' }}>Leasing</option>
                        <option value="Cash" {{ ($pembiayaan ?? '') == 'Cash' ? 'selected' : '' }}>Cash</option>
                    </select>
                </div>

                {{-- Perusahaan --}}
                <div class="filter-item">
                    <label class="filter-label">Perusahaan</label>
                    <select name="perusahaan" class="select-control">
                        @foreach($perusahaanList as $p)
                            <option value="{{ $p }}" {{ ($perusahaan ?? 'Semua') == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Button Cari --}}
                <div class="filter-item filter-btn-box">
                    <button type="submit" class="btn-search-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <span>Cari</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- 3. TABLE SECTION --}}
    <div class="table-card-wrapper">
        {{-- Toolbar Subheader --}}
        <div class="table-subtoolbar">
            <div class="kendaraan-count-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="8" y1="6" x2="21" y2="6"></line>
                    <line x1="8" y1="12" x2="21" y2="12"></line>
                    <line x1="8" y1="18" x2="21" y2="18"></line>
                    <line x1="3" y1="6" x2="3.01" y2="6"></line>
                    <line x1="3" y1="12" x2="3.01" y2="12"></line>
                    <line x1="3" y1="18" x2="3.01" y2="18"></line>
                </svg>
                <span>{{ count($kendaraanList) }} / {{ $totalKendaraan }} kendaraan</span>
            </div>

            <div class="table-search-actions">
                <div class="table-search-input-box">
                    <input type="text" placeholder="Cari..." class="input-table-search" id="quickSearchInput">
                </div>
                <a href="{{ route('asuransi.data') }}" class="btn-refresh-icon" title="Reset / Refresh Filter">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="23 4 23 10 17 10"></polyline>
                        <polyline points="1 20 1 14 7 14"></polyline>
                        <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                    </svg>
                </a>
            </div>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="asuransi-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th style="min-width: 170px;">VIN</th>
                        <th style="min-width: 110px;">Tgl Billing</th>
                        <th style="min-width: 110px;">Pembiayaan</th>
                        <th style="min-width: 140px;">Model</th>
                        <th style="min-width: 180px;">Konsumen</th>
                        <th style="min-width: 140px;">Kota</th>
                        <th style="min-width: 80px; text-align: center;">Jenis</th>
                        <th style="min-width: 130px;">Asuransi</th>
                        <th style="min-width: 110px;">Periode</th>
                        <th style="min-width: 110px; text-align: center;">Status</th>
                        <th style="min-width: 70px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kendaraanList as $index => $k)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="font-mono font-bold">{{ $k['vin'] }}</td>
                        <td>{{ $k['tgl_billing'] }}</td>
                        <td>
                            <span class="badge-finance {{ strtolower($k['pembiayaan']) == 'leasing' ? 'badge-finance-leasing' : 'badge-finance-cash' }}">
                                {{ $k['pembiayaan'] }}
                            </span>
                        </td>
                        <td class="font-bold">{{ $k['model'] }}</td>
                        <td>{{ $k['konsumen'] ?? '-' }}</td>
                        <td>{{ $k['kota'] ?? '-' }}</td>
                        <td style="text-align: center;">
                            <span class="badge-jenis-pill">{{ $k['jenis'] ?? 'DLR' }}</span>
                        </td>
                        <td>{{ $k['asuransi'] ?? '-' }}</td>
                        <td>{{ $k['periode'] ?? '-' }}</td>
                        <td style="text-align: center;">
                            @php
                                $status = strtolower($k['status'] ?? 'belum');
                            @endphp
                            @if(str_contains($status, 'aktif'))
                                <span class="badge-status-asuransi badge-asuransi-aktif">Aktif</span>
                            @elseif(str_contains($status, 'kuning') || str_contains($status, 'segera'))
                                <span class="badge-status-asuransi badge-asuransi-kuning">Segera Habis</span>
                            @elseif(str_contains($status, 'merah') || str_contains($status, 'kritis'))
                                <span class="badge-status-asuransi badge-asuransi-kritis">Kritis</span>
                            @elseif(str_contains($status, 'expired'))
                                <span class="badge-status-asuransi badge-asuransi-expired">Expired</span>
                            @else
                                <span class="badge-status-asuransi badge-asuransi-belum">Belum diisi</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <button type="button" class="btn-action-shield" onclick="openEditAsuransiModal({{ json_encode($k) }})" title="Edit Data Asuransi">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="empty-state-row">
                            <div class="empty-state-content">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                    <path d="M12 8v4"></path>
                                    <path d="M12 16h.01"></path>
                                </svg>
                                <p class="empty-text">Belum ada data asuransi kendaraan ditemukan pada filter ini.</p>
                                <span class="empty-subtext">Sesuaikan rentang tanggal billing atau filter pencarian di atas untuk melihat data.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 4. PAGINATION FOOTER --}}
        <div class="table-pagination-footer">
            <div class="pagination-controls">
                <button type="button" class="btn-page" title="Halaman Pertama">«</button>
                <button type="button" class="btn-page" title="Sebelumnya">‹</button>
                <button type="button" class="btn-page btn-page-active">1</button>
                <button type="button" class="btn-page">2</button>
                <button type="button" class="btn-page" title="Selanjutnya">›</button>
                <button type="button" class="btn-page" title="Halaman Terakhir">»</button>
            </div>

            <div class="pagination-rows-select">
                <select class="select-page-rows">
                    <option value="20">20 / halaman</option>
                    <option value="50" selected>50 / halaman</option>
                    <option value="100">100 / halaman</option>
                </select>
            </div>
        </div>
    </div>

    {{-- MODAL 1: IMPORT EXCEL --}}
    <div class="modal-backdrop" id="modalImportExcel">
        <div class="modal-dialog modal-import-dialog">
            <div class="modal-header">
                <h3 class="modal-title">Import Data Asuransi</h3>
                <button type="button" class="btn-modal-close" onclick="closeImportModal()">&times;</button>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <div class="upload-dropzone">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 8px;">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" y1="3" x2="12" y2="15"></line>
                    </svg>
                    <p style="font-size: 13px; font-weight: 700; color: #0f172a; margin: 0 0 4px 0;">Pilih file Excel (.xlsx / .xls)</p>
                    <p style="font-size: 11.5px; color: #64748b; margin: 0 0 12px 0;">Format kolom: VIN, Asuransi, Jenis, Periode Mulai, Periode Selesai</p>
                    <input type="file" id="fileExcelInput" accept=".xlsx,.xls" style="display: none;" onchange="updateFileName(this)">
                    <button type="button" class="btn-browse-file" onclick="document.getElementById('fileExcelInput').click()">Pilih File Excel</button>
                    <span id="selectedFileNameText" style="display: block; margin-top: 10px; font-size: 12px; color: #0284c7; font-weight: 600;"></span>
                </div>
            </div>
            <div class="modal-footer modal-import-footer">
                <button type="button" class="btn-import-cancel" onclick="closeImportModal()">Batal</button>
                <button type="button" class="btn-import-submit" onclick="submitImport()">Upload & Proses</button>
            </div>
        </div>
    </div>

    {{-- MODAL 2: EDIT DATA ASURANSI --}}
    <div class="modal-backdrop" id="modalEditAsuransi">
        <div class="modal-dialog modal-edit-dialog">
            <div class="modal-header">
                <h3 class="modal-title">Edit Data Asuransi Kendaraan</h3>
                <button type="button" class="btn-modal-close" onclick="closeEditAsuransiModal()">&times;</button>
            </div>
            <div class="modal-body modal-form-body">
                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label">Nomor Rangka (VIN)</label>
                        <input type="text" id="formVin" class="input-form-control font-mono" readonly style="background: #f8fafc;">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Model Kendaraan</label>
                        <input type="text" id="formModel" class="input-form-control" readonly style="background: #f8fafc;">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Konsumen</label>
                    <input type="text" id="formKonsumen" class="input-form-control" readonly style="background: #f8fafc;">
                </div>

                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label">Perusahaan Asuransi</label>
                        <select id="formPerusahaan" class="input-form-control">
                            <option value="">-- Pilih Asuransi --</option>
                            @foreach($perusahaanList as $p)
                                @if($p !== 'Semua')
                                    <option value="{{ $p }}">{{ $p }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jenis Asuransi</label>
                        <select id="formJenis" class="input-form-control">
                            <option value="COMP">COMP (Comprehensive)</option>
                            <option value="TLO">TLO (Total Loss Only)</option>
                            <option value="DLR">DLR (Dealer)</option>
                        </select>
                    </div>
                </div>

                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label">Periode Mulai</label>
                        <input type="date" id="formPeriodeMulai" class="input-form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Periode Selesai</label>
                        <input type="date" id="formPeriodeSelesai" class="input-form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Catatan Tambahan</label>
                    <textarea id="formCatatan" class="input-form-control" rows="2" placeholder="Catatan asuransi (opsional)..."></textarea>
                </div>
            </div>
            <div class="modal-footer modal-edit-footer">
                <button type="button" class="btn-edit-cancel" onclick="closeEditAsuransiModal()">Batal</button>
                <button type="button" class="btn-edit-save" onclick="saveAsuransi()">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Global Container */
    .asuransi-container {
        padding: 24px 28px 40px 28px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        color: #1e293b;
        box-sizing: border-box;
    }

    /* Header */
    .page-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 16px;
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
    .header-action-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .btn-import-excel {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: linear-gradient(135deg, #0284c7, #0369a1);
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(2, 132, 199, 0.25);
        transition: all 0.2s ease;
    }
    .btn-import-excel:hover {
        background: linear-gradient(135deg, #0369a1, #075985);
        transform: translateY(-1px);
    }
    .btn-export-purple {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(139, 92, 246, 0.25);
        transition: all 0.2s ease;
    }
    .btn-export-purple:hover {
        background: linear-gradient(135deg, #7c3aed, #6d28d9);
        transform: translateY(-1px);
    }

    /* Filter Card */
    .filter-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 16px 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
        margin-bottom: 20px;
    }
    .filter-grid {
        display: flex;
        align-items: flex-end;
        gap: 12px;
        flex-wrap: wrap;
    }
    .filter-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
        flex: 1 1 140px;
    }
    .filter-periode {
        flex: 1.8 1 260px;
    }
    .filter-label {
        font-size: 11.5px;
        font-weight: 700;
        color: #475569;
        white-space: nowrap;
    }
    .date-range-input-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .input-date-range {
        width: 100%;
        height: 38px;
        padding: 6px 10px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 12.5px;
        color: #1e293b;
        box-sizing: border-box;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .input-date-range:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
    }
    .date-separator {
        font-size: 12px;
        color: #94a3b8;
        font-weight: 600;
    }
    .select-control {
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
    .select-control:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
    }
    .filter-btn-box {
        flex: 0 0 auto;
    }
    .btn-search-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        height: 38px;
        padding: 0 20px;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.25);
        transition: all 0.2s ease;
    }
    .btn-search-primary:hover {
        background: linear-gradient(135deg, #b91c1c, #991b1b);
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
    .table-subtoolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 18px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        flex-wrap: wrap;
        gap: 10px;
    }
    .kendaraan-count-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12.5px;
        font-weight: 700;
        color: #475569;
    }
    .table-search-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .input-table-search {
        height: 32px;
        padding: 4px 10px;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        font-size: 12px;
        outline: none;
        width: 150px;
        transition: all 0.2s;
    }
    .input-table-search:focus {
        border-color: #dc2626;
        width: 190px;
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

    /* Table */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }
    .asuransi-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 12.5px;
    }
    .asuransi-table thead th {
        background: #ffffff;
        color: #475569;
        font-weight: 700;
        font-size: 12px;
        padding: 12px 14px;
        border-bottom: 1.5px solid #e2e8f0;
        white-space: nowrap;
    }
    .asuransi-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s ease;
    }
    .asuransi-table tbody tr:hover {
        background-color: #f8fafc;
    }
    .asuransi-table tbody td {
        padding: 12px 14px;
        color: #334155;
        vertical-align: middle;
    }

    .font-mono { font-family: 'JetBrains Mono', monospace; font-size: 12px; }
    .font-bold { font-weight: 700; }

    /* Badges */
    .badge-finance {
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 5px;
        display: inline-block;
    }
    .badge-finance-leasing { background: #e0f2fe; color: #0369a1; }
    .badge-finance-cash    { background: #f1f5f9; color: #475569; }

    .badge-jenis-pill {
        font-size: 10.5px;
        font-weight: 700;
        background: #f1f5f9;
        color: #64748b;
        padding: 2px 7px;
        border-radius: 4px;
        border: 1px solid #e2e8f0;
    }

    .badge-status-asuransi {
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 5px;
        display: inline-block;
        white-space: nowrap;
    }
    .badge-asuransi-aktif   { background: #dcfce7; color: #15803d; }
    .badge-asuransi-kuning  { background: #fef3c7; color: #b45309; }
    .badge-asuransi-kritis  { background: #fee2e2; color: #b91c1c; }
    .badge-asuransi-expired { background: #f1f5f9; color: #475569; }
    .badge-asuransi-belum   { background: #f8fafc; color: #94a3b8; border: 1px dashed #cbd5e1; }

    .btn-action-shield {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
        border-radius: 6px;
        border: 1px solid #bbf7d0;
        background: #f0fdf4;
        color: #16a34a;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-action-shield:hover {
        background: #dcfce7;
        color: #15803d;
        transform: scale(1.05);
    }

    .empty-state-row {
        text-align: center;
        padding: 60px 20px !important;
    }
    .empty-state-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
    }
    .empty-text {
        font-size: 13.5px;
        font-weight: 700;
        color: #475569;
        margin: 4px 0 0 0;
    }
    .empty-subtext {
        font-size: 12px;
        color: #94a3b8;
    }

    /* Pagination */
    .table-pagination-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 18px;
        background: #ffffff;
        border-top: 1px solid #e2e8f0;
        flex-wrap: wrap;
        gap: 12px;
    }
    .pagination-controls {
        display: flex;
        align-items: center;
        gap: 4px;
        margin: 0 auto;
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
        transition: all 0.15s ease;
    }
    .btn-page:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }
    .btn-page-active {
        background: #dc2626 !important;
        border-color: #dc2626 !important;
        color: #ffffff !important;
        font-weight: 800;
    }
    .select-page-rows {
        height: 32px;
        padding: 4px 8px;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        outline: none;
    }

    /* Modal Styling */
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
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        animation: modalFadeSlide 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        max-width: 100%;
        box-sizing: border-box;
    }
    @keyframes modalFadeSlide {
        from { opacity: 0; transform: translateY(12px) scale(0.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 22px;
        border-bottom: 1px solid #e2e8f0;
    }
    .modal-title {
        font-size: 16px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }
    .btn-modal-close {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #64748b;
        font-size: 20px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        transition: all 0.15s ease;
    }
    .btn-modal-close:hover {
        background: #fee2e2;
        color: #dc2626;
        border-color: #fecaca;
    }

    /* Modal Import */
    .modal-import-dialog {
        width: 480px;
    }
    .upload-dropzone {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 28px 20px;
        text-align: center;
        background: #f8fafc;
    }
    .btn-browse-file {
        display: inline-flex;
        align-items: center;
        padding: 8px 18px;
        background: #ffffff;
        color: #1e293b;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-browse-file:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
    }
    .modal-import-footer {
        padding: 14px 20px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    .btn-import-cancel {
        padding: 7px 16px;
        background: transparent;
        color: #64748b;
        border: none;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-import-submit {
        padding: 7px 18px;
        background: linear-gradient(135deg, #0284c7, #0369a1);
        color: #ffffff;
        border: none;
        border-radius: 6px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(2, 132, 199, 0.25);
    }

    /* Modal Edit Form */
    .modal-edit-dialog {
        width: 540px;
    }
    .modal-form-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 14px;
        max-height: 75vh;
        overflow-y: auto;
    }
    .form-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }
    @media (max-width: 500px) {
        .form-row-2 { grid-template-columns: 1fr; }
    }
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .form-label {
        font-size: 11.5px;
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
        font-family: inherit;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .input-form-control:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
    }
    textarea.input-form-control {
        height: auto;
        resize: vertical;
    }
    .modal-edit-footer {
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
    // Modal Import
    function openImportModal() {
        document.getElementById('modalImportExcel').style.display = 'flex';
    }
    function closeImportModal() {
        document.getElementById('modalImportExcel').style.display = 'none';
        document.getElementById('fileExcelInput').value = '';
        document.getElementById('selectedFileNameText').textContent = '';
    }
    function updateFileName(input) {
        if (input.files && input.files[0]) {
            document.getElementById('selectedFileNameText').textContent = '📄 ' + input.files[0].name;
        }
    }
    function submitImport() {
        const file = document.getElementById('fileExcelInput').files[0];
        if (!file) {
            alert('Silakan pilih file Excel terlebih dahulu.');
            return;
        }
        alert('Fitur import Excel (' + file.name + ') sedang dipersiapkan...');
        closeImportModal();
    }

    // Modal Edit Asuransi
    function openEditAsuransiModal(item) {
        document.getElementById('formVin').value = item.vin || '';
        document.getElementById('formModel').value = item.model || '';
        document.getElementById('formKonsumen').value = item.konsumen || '';
        document.getElementById('formPerusahaan').value = item.asuransi || '';
        document.getElementById('formJenis').value = item.jenis || 'COMP';
        document.getElementById('formPeriodeMulai').value = item.periode_mulai || '';
        document.getElementById('formPeriodeSelesai').value = item.periode_selesai || '';
        document.getElementById('formCatatan').value = item.catatan || '';
        document.getElementById('modalEditAsuransi').style.display = 'flex';
    }
    function closeEditAsuransiModal() {
        document.getElementById('modalEditAsuransi').style.display = 'none';
    }
    function saveAsuransi() {
        const vin = document.getElementById('formVin').value;
        alert('Data asuransi untuk VIN ' + vin + ' berhasil disimpan.');
        closeEditAsuransiModal();
    }

    // Close on backdrop click
    window.addEventListener('click', function(event) {
        const modalImport = document.getElementById('modalImportExcel');
        const modalEdit = document.getElementById('modalEditAsuransi');
        if (event.target === modalImport) {
            closeImportModal();
        }
        if (event.target === modalEdit) {
            closeEditAsuransiModal();
        }
    });
</script>
@endsection
