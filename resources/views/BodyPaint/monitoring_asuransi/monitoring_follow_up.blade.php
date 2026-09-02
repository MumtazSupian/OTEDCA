@extends('layouts.app')

@section('title', 'Monitoring & Follow-up Asuransi - OTE DCA')

@section('content')
<div class="monitoring-fu-container">
    {{-- 1. HEADER SECTION --}}
    <div class="page-header-row">
        <div class="header-text-group">
            <h1 class="page-title">Monitoring & Follow-up</h1>
            <p class="page-subtitle">Kendaraan COMP aktif &mdash; catat follow-up dan pantau status klaim</p>
        </div>
        <div class="header-action-group">
            <button type="button" class="btn-header-export" onclick="alert('Export data Monitoring Follow-up sedang dipersiapkan...')">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                <span>Export</span>
            </button>
            <a href="{{ route('body_paint.monitoring.follow_up') }}" class="btn-icon-refresh-header" title="Refresh Data">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 4 23 10 17 10"></polyline>
                    <polyline points="1 20 1 14 7 14"></polyline>
                    <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                </svg>
            </a>
        </div>
    </div>

    {{-- 2. FILTER CARD --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('body_paint.monitoring.follow_up') }}" id="filterMonitoringForm">
            <div class="filter-grid-5">
                {{-- Sisa Hari Filter --}}
                <div class="filter-item">
                    <label class="filter-label">Sisa Hari</label>
                    <select name="sisa_hari" class="select-filter-control" onchange="document.getElementById('filterMonitoringForm').submit()">
                        @foreach($sisaHariList as $sh)
                            <option value="{{ $sh }}" {{ ($sisaHari ?? 'Semua aktif') == $sh ? 'selected' : '' }}>{{ $sh }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Status Follow-up --}}
                <div class="filter-item">
                    <label class="filter-label">Status Follow-up</label>
                    <select name="status_fu" class="select-filter-control" onchange="document.getElementById('filterMonitoringForm').submit()">
                        @foreach($statusFuList as $sfu)
                            <option value="{{ $sfu }}" {{ ($statusFu ?? 'Semua') == $sfu ? 'selected' : '' }}>{{ $sfu }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Perusahaan --}}
                <div class="filter-item">
                    <label class="filter-label">Perusahaan</label>
                    <select name="perusahaan" class="select-filter-control" onchange="document.getElementById('filterMonitoringForm').submit()">
                        @foreach($perusahaanList as $p)
                            <option value="{{ $p }}" {{ ($perusahaan ?? 'Semua') == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Verbatim Terakhir --}}
                <div class="filter-item">
                    <label class="filter-label">Verbatim Terakhir</label>
                    <select name="verbatim" class="select-filter-control" onchange="document.getElementById('filterMonitoringForm').submit()">
                        @foreach($verbatimList as $v)
                            <option value="{{ $v }}" {{ ($verbatim ?? 'Semua') == $v ? 'selected' : '' }}>{{ $v }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Cari VIN & Reset --}}
                <div class="filter-item-search">
                    <label class="filter-label">Cari VIN</label>
                    <div class="search-btn-group">
                        <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Cari VIN..." class="input-filter-control font-mono">
                        <a href="{{ route('body_paint.monitoring.follow_up') }}" class="btn-reset-filter" title="Reset Filter">
                            <span>✕ Reset</span>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- 3. TABLE CARD WRAPPER --}}
    <div class="table-card-wrapper">
        <div class="table-responsive">
            <table class="monitoring-table">
                <thead>
                    <tr>
                        <th style="min-width: 170px;">VIN</th>
                        <th style="min-width: 120px;">No Polisi</th>
                        <th style="min-width: 180px;">Nama Konsumen</th>
                        <th style="min-width: 130px;">No HP</th>
                        <th style="min-width: 140px;">Model</th>
                        <th style="min-width: 130px;">Perusahaan</th>
                        <th style="min-width: 120px;">Tgl Habis</th>
                        <th style="min-width: 100px;">Sisa Hari</th>
                        <th style="min-width: 130px;">Status F/U</th>
                        <th style="min-width: 140px;">Verbatim Terakhir</th>
                        <th style="min-width: 150px;">Tgl Terakhir F/U</th>
                        <th style="min-width: 140px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($monitoringList as $item)
                    <tr>
                        <td class="font-mono font-bold">{{ $item['vin'] }}</td>
                        <td class="font-mono">{{ $item['no_polisi'] ?? '-' }}</td>
                        <td class="font-bold">{{ $item['nama_konsumen'] }}</td>
                        <td class="font-mono">{{ $item['no_hp'] ?? '-' }}</td>
                        <td>{{ $item['model'] }}</td>
                        <td>{{ $item['perusahaan'] }}</td>
                        <td>{{ $item['tgl_habis'] }}</td>
                        <td>
                            @php
                                $sisa = $item['sisa_hari'] ?? 0;
                                $badgeClass = $sisa <= 30 ? 'badge-sisa-red' : ($sisa <= 60 ? 'badge-sisa-amber' : 'badge-sisa-green');
                            @endphp
                            <span class="{{ $badgeClass }}">{{ $sisa }} hari</span>
                        </td>
                        <td>
                            @if(($item['status_fu'] ?? '') === 'Sudah Dihubungi')
                                <span class="badge-status-green">Sudah Dihubungi</span>
                            @else
                                <span class="badge-status-blue">Belum Dihubungi</span>
                            @endif
                        </td>
                        <td>{{ $item['verbatim'] ?? '-' }}</td>
                        <td class="font-mono text-muted" style="font-size: 11.5px;">{{ $item['tgl_terakhir_fu'] ?? '-' }}</td>
                        <td style="text-align: center;">
                            <div class="action-btn-group">
                                <button type="button" class="btn-catat-fu" onclick="openModalCatatFu({{ json_encode($item) }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                    </svg>
                                    <span>Catat F/U</span>
                                </button>
                                <button type="button" class="btn-history-fu" onclick="openModalHistory({{ json_encode($item) }})" title="History Follow-up">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="empty-state-row">
                            <div class="empty-state-content">
                                <div class="empty-icon-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline>
                                        <path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path>
                                    </svg>
                                </div>
                                <p class="empty-text">Tidak ada data follow-up asuransi</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL 1: CATAT F/U --}}
    <div class="modal-backdrop" id="modalCatatFu">
        <div class="modal-dialog modal-form-dialog">
            <div class="modal-header">
                <div>
                    <h3 class="modal-title">Catat Follow-up Asuransi</h3>
                    <p class="modal-subtitle" id="modalCatatSubtitle">-</p>
                </div>
                <button type="button" class="btn-modal-close" onclick="closeModalCatatFu()">&times;</button>
            </div>
            <div class="modal-body modal-form-body">
                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label">Channel Komunikasi</label>
                        <select id="modalChannel" class="input-form-control">
                            <option value="WhatsApp">WhatsApp</option>
                            <option value="Telepon">Telepon</option>
                            <option value="Kunjungan">Kunjungan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status Klaim</label>
                        <select id="modalStatusKlaim" class="input-form-control">
                            <option value="Belum Klaim">Belum Klaim</option>
                            <option value="Sudah Klaim">Sudah Klaim</option>
                            <option value="Walk-In / Booking">Walk-In / Booking</option>
                            <option value="Tidak Berminat">Tidak Berminat</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Alasan / Verbatim</label>
                    <select id="modalVerbatim" class="input-form-control">
                        @foreach($verbatimList as $v)
                            @if($v !== 'Semua')
                                <option value="{{ $v }}">{{ $v }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Catatan Interaksi</label>
                    <textarea id="modalCatatanTeks" class="input-form-control" rows="3" placeholder="Hasil komunikasi dengan konsumen..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-edit-cancel" onclick="closeModalCatatFu()">Batal</button>
                <button type="button" class="btn-edit-save" onclick="saveCatatFu()">Simpan Follow-up</button>
            </div>
        </div>
    </div>

    {{-- MODAL 2: HISTORY FOLLOW-UP --}}
    <div class="modal-backdrop" id="modalHistory">
        <div class="modal-dialog modal-history-dialog">
            <div class="modal-header">
                <div>
                    <h3 class="modal-title">History Follow-up</h3>
                    <p class="modal-subtitle" id="modalHistorySubtitle">VIN &bull; No Polisi &bull; Perusahaan &bull; Model</p>
                </div>
                <button type="button" class="btn-modal-close" onclick="closeModalHistory()">&times;</button>
            </div>
            <div class="modal-body modal-history-body" id="modalHistoryBody">
                <div class="empty-state-content" style="padding: 40px 20px;">
                    <div class="empty-icon-box" style="width: 50px; height: 50px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline>
                            <path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path>
                        </svg>
                    </div>
                    <p class="empty-text" style="font-size: 13px;">Belum ada log follow-up</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Global Container */
    .monitoring-fu-container {
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
        gap: 8px;
    }
    .btn-header-export {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        height: 36px;
        padding: 0 14px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #475569;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-header-export:hover {
        background: #f8fafc;
        border-color: #94a3b8;
    }
    .btn-icon-refresh-header {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: 1px solid #fecaca;
        background: #fef2f2;
        color: #dc2626;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-icon-refresh-header:hover {
        background: #fee2e2;
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
    .filter-grid-5 {
        display: grid;
        grid-template-columns: 1.2fr 1fr 1fr 1fr 1.6fr;
        gap: 12px;
        align-items: flex-end;
    }
    @media (max-width: 1200px) {
        .filter-grid-5 { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 768px) {
        .filter-grid-5 { grid-template-columns: 1fr; }
    }
    .filter-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .filter-item-search {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .filter-label {
        font-size: 11.5px;
        font-weight: 700;
        color: #475569;
    }
    .select-filter-control, .input-filter-control {
        width: 100%;
        height: 38px;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 12px;
        color: #1e293b;
        box-sizing: border-box;
        outline: none;
        transition: border-color 0.2s;
    }
    .select-filter-control:focus, .input-filter-control:focus {
        border-color: #dc2626;
    }
    .search-btn-group {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .btn-reset-filter {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 38px;
        padding: 0 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.2s ease;
    }
    .btn-reset-filter:hover {
        background: #f1f5f9;
        color: #dc2626;
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
    .monitoring-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 12.5px;
    }
    .monitoring-table thead th {
        background: #ffffff;
        color: #475569;
        font-weight: 700;
        font-size: 12px;
        padding: 12px 14px;
        border-bottom: 1.5px solid #e2e8f0;
        white-space: nowrap;
    }
    .monitoring-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s ease;
    }
    .monitoring-table tbody tr:hover {
        background-color: #f8fafc;
    }
    .monitoring-table tbody td {
        padding: 12px 14px;
        color: #334155;
        vertical-align: middle;
    }

    .font-mono { font-family: 'JetBrains Mono', monospace; font-size: 12px; }
    .font-bold { font-weight: 700; }
    .text-muted { color: #94a3b8; }

    /* Badges */
    .badge-sisa-green {
        background: #dcfce7;
        color: #15803d;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 4px;
        display: inline-block;
    }
    .badge-sisa-amber {
        background: #fffbeb;
        color: #d97706;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 4px;
        display: inline-block;
    }
    .badge-sisa-red {
        background: #fee2e2;
        color: #dc2626;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 4px;
        display: inline-block;
    }
    .badge-status-green {
        background: #dcfce7;
        color: #15803d;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 4px;
        display: inline-block;
    }
    .badge-status-blue {
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 4px;
        display: inline-block;
    }

    /* Actions */
    .action-btn-group {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-catat-fu {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 10px;
        border-radius: 6px;
        background: #fb7185;
        color: #ffffff;
        border: none;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-catat-fu:hover {
        background: #f43f5e;
    }
    .btn-history-fu {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        border: 1px solid #fecaca;
        background: #fff5f5;
        color: #f43f5e;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
    }
    .btn-history-fu:hover {
        background: #fee2e2;
    }

    /* Empty State */
    .empty-state-row {
        text-align: center;
        padding: 70px 20px !important;
    }
    .empty-state-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }
    .empty-icon-box {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
    }
    .empty-text {
        font-size: 13.5px;
        font-weight: 600;
        color: #64748b;
        margin: 0;
    }

    /* Modals */
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
        width: 520px;
        max-width: 100%;
    }
    .modal-history-dialog {
        width: 560px;
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
        margin: 0 0 2px 0;
    }
    .modal-subtitle {
        font-size: 12px;
        color: #64748b;
        margin: 0;
        font-family: 'JetBrains Mono', monospace;
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
    .form-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
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
    }
    .input-form-control:focus {
        border-color: #dc2626;
    }
    textarea.input-form-control {
        height: auto;
        resize: vertical;
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
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #ffffff;
        border: none;
        border-radius: 6px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.25);
    }

    /* History Log Card */
    .history-card-item {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px 16px;
        margin-bottom: 12px;
    }
    .history-top-row {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
    }
    .history-date {
        color: #dc2626;
        font-weight: 700;
        font-size: 12px;
        font-family: 'JetBrains Mono', monospace;
    }
    .badge-channel {
        background: #f1f5f9;
        color: #475569;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 4px;
    }
    .badge-klaim-orange {
        background: #ffedd5;
        color: #c2410c;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 4px;
    }
    .history-content-text {
        font-size: 12.5px;
        color: #1e293b;
        margin: 0 0 6px 0;
        line-height: 1.4;
    }
    .history-author {
        font-size: 11px;
        color: #94a3b8;
        margin: 0;
    }
</style>

<script>
    function openModalCatatFu(item) {
        document.getElementById('modalCatatSubtitle').textContent = item.vin + ' • ' + (item.no_polisi || '-') + ' • ' + (item.perusahaan || '-') + ' • ' + (item.model || '-');
        document.getElementById('modalCatatFu').style.display = 'flex';
    }

    function closeModalCatatFu() {
        document.getElementById('modalCatatFu').style.display = 'none';
    }

    function saveCatatFu() {
        alert('Follow-up berhasil dicatat.');
        closeModalCatatFu();
    }

    function openModalHistory(item) {
        document.getElementById('modalHistorySubtitle').textContent = item.vin + ' • ' + (item.no_polisi || '-') + ' • ' + (item.perusahaan || '-') + ' • ' + (item.model || '-');
        
        const historyBody = document.getElementById('modalHistoryBody');
        if (item.history && item.history.length > 0) {
            let html = '';
            item.history.forEach(h => {
                html += `
                    <div class="history-card-item">
                        <div class="history-top-row">
                            <span class="history-date">${h.tanggal}</span>
                            <span class="badge-channel">${h.channel || 'WhatsApp'}</span>
                            <span class="badge-klaim-orange">${h.status_klaim || 'Belum Klaim'}</span>
                        </div>
                        <p class="history-content-text"><strong>${h.verbatim || 'Lainnya'}</strong> &mdash; ${h.catatan || '-'}</p>
                        <p class="history-author">oleh ${h.user || 'SA'}</p>
                    </div>
                `;
            });
            historyBody.innerHTML = html;
        } else {
            historyBody.innerHTML = `
                <div class="empty-state-content" style="padding: 40px 20px;">
                    <div class="empty-icon-box" style="width: 50px; height: 50px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline>
                            <path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path>
                        </svg>
                    </div>
                    <p class="empty-text" style="font-size: 13px;">Belum ada log follow-up</p>
                </div>
            `;
        }

        document.getElementById('modalHistory').style.display = 'flex';
    }

    function closeModalHistory() {
        document.getElementById('modalHistory').style.display = 'none';
    }

    // Close on backdrop click
    window.addEventListener('click', function(event) {
        if (event.target === document.getElementById('modalCatatFu')) {
            closeModalCatatFu();
        }
        if (event.target === document.getElementById('modalHistory')) {
            closeModalHistory();
        }
    });
</script>
@endsection
