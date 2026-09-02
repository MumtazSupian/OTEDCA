@extends('layouts.app')

@section('title', 'Prospek Saya - OTE DCA')

@section('content')
<div class="prospek-saya-container">
    {{-- 1. HEADER SECTION --}}
    <div class="page-header-row">
        <div class="header-text-group">
            <h1 class="page-title">Prospek Saya</h1>
            <p class="page-subtitle">Data prospect BP yang Anda input bulan ini</p>
        </div>
        <div class="header-action-group">
            <a href="{{ route('body_paint.leads.prospek_saya') }}" class="btn-icon-refresh-header" title="Refresh Data">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 4 23 10 17 10"></polyline>
                    <polyline points="1 20 1 14 7 14"></polyline>
                    <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                </svg>
            </a>
        </div>
    </div>

    {{-- 2. 4 KPI STATS CARDS --}}
    <div class="kpi-cards-grid-4">
        {{-- Total Input Bulan Ini --}}
        <div class="kpi-stat-card">
            <div class="kpi-icon-box kpi-icon-blue">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9C2.1 11.2 2 11.6 2 12v4c0 .6.4 1 1 1h2"></path>
                    <circle cx="7" cy="17" r="2"></circle>
                    <path d="M9 17h6"></path>
                    <circle cx="17" cy="17" r="2"></circle>
                </svg>
            </div>
            <div class="kpi-info">
                <div class="kpi-val">{{ $kpi['total_input'] ?? 0 }}</div>
                <div class="kpi-lbl">Total Input Bulan Ini</div>
            </div>
        </div>

        {{-- Unit Entry (Konversi) --}}
        <div class="kpi-stat-card">
            <div class="kpi-icon-box kpi-icon-green">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div class="kpi-info">
                <div class="kpi-val text-green">{{ $kpi['unit_entry'] ?? 0 }}</div>
                <div class="kpi-lbl">Unit Entry (Konversi)</div>
            </div>
        </div>

        {{-- Target Leads --}}
        <div class="kpi-stat-card">
            <div class="kpi-icon-box kpi-icon-amber">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <circle cx="12" cy="12" r="6"></circle>
                    <circle cx="12" cy="12" r="2"></circle>
                </svg>
            </div>
            <div class="kpi-info">
                <div class="kpi-val text-amber">{{ $kpi['target_leads'] ?? 0 }}</div>
                <div class="kpi-lbl">Target Leads</div>
            </div>
        </div>

        {{-- Gap (Target - Input) --}}
        <div class="kpi-stat-card">
            <div class="kpi-icon-box kpi-icon-red">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <polyline points="19 12 12 19 5 12"></polyline>
                </svg>
            </div>
            <div class="kpi-info">
                <div class="kpi-val text-red">{{ $kpi['gap'] ?? 0 }}</div>
                <div class="kpi-lbl">Gap (Target - Input)</div>
            </div>
        </div>
    </div>

    {{-- 3. TABLE CARD WRAPPER --}}
    <div class="table-card-wrapper">
        {{-- Toolbar Subheader --}}
        <div class="table-subtoolbar">
            <div class="task-count-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="8" y1="6" x2="21" y2="6"></line>
                    <line x1="8" y1="12" x2="21" y2="12"></line>
                    <line x1="8" y1="18" x2="21" y2="18"></line>
                    <line x1="3" y1="6" x2="3.01" y2="6"></line>
                    <line x1="3" y1="12" x2="3.01" y2="12"></line>
                    <line x1="3" y1="18" x2="3.01" y2="18"></line>
                </svg>
                <span>{{ count($prospekList) }} prospect aktif</span>
            </div>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="prospek-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th style="min-width: 150px;">No. Polisi</th>
                        <th style="min-width: 200px;">Nama Konsumen</th>
                        <th style="min-width: 140px;">Status</th>
                        <th style="min-width: 140px;">Next F/U</th>
                        <th style="min-width: 100px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prospekList as $index => $p)
                    <tr>
                        <td class="text-muted">{{ $index + 1 }}</td>
                        <td class="font-mono font-bold">{{ $p['nopol'] }}</td>
                        <td class="font-bold">{{ $p['nama_konsumen'] }}</td>
                        <td>
                            <span class="badge-status-prospek">{{ $p['status'] ?? 'Aktif' }}</span>
                        </td>
                        <td class="font-mono">{{ $p['next_fu'] ?? '-' }}</td>
                        <td style="text-align: center;">
                            <div class="action-btn-group">
                                @if(!empty($p['no_hp']))
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $p['no_hp']) }}" target="_blank" class="btn-icon-action btn-icon-wa" title="Hubungi via WhatsApp">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                                        </svg>
                                    </a>
                                @endif
                                <button type="button" class="btn-icon-action btn-icon-edit" onclick="openModalDetail({{ json_encode($p) }})" title="Lihat Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="3"></circle>
                                        <path d="M22 12c-2.4 4-5.4 6-10 6-4.6 0-7.6-2-10-6 2.4-4 5.4-6 10-6 4.6 0 7.6 2 10 6z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-state-row">
                            <div class="empty-state-content">
                                <div class="empty-icon-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline>
                                        <path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path>
                                    </svg>
                                </div>
                                <p class="empty-text">Tidak ada prospect aktif saat ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL DETAIL PROSPEK SAYA --}}
    <div class="modal-backdrop" id="modalDetailProspek">
        <div class="modal-dialog modal-prospek-dialog">
            <div class="modal-header">
                <h3 class="modal-title">Detail Prospek Saya</h3>
                <button type="button" class="btn-modal-close" onclick="closeModalDetail()">&times;</button>
            </div>
            <div class="modal-body modal-form-body">
                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label">No. Polisi</label>
                        <input type="text" id="modalNopol" class="input-form-control font-mono" readonly style="background: #f8fafc;">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Konsumen</label>
                        <input type="text" id="modalKonsumen" class="input-form-control" readonly style="background: #f8fafc;">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Status Terkini</label>
                    <input type="text" id="modalStatus" class="input-form-control" readonly style="background: #f8fafc;">
                </div>

                <div class="form-group">
                    <label class="form-label">Keterangan / Tindak Lanjut</label>
                    <textarea id="modalCatatan" class="input-form-control" rows="3" readonly style="background: #f8fafc;"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-close-action" onclick="closeModalDetail()">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Global Container */
    .prospek-saya-container {
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
    .btn-icon-refresh-header {
        width: 34px;
        height: 34px;
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

    /* 4 KPI Cards Grid */
    .kpi-cards-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }
    @media (max-width: 900px) {
        .kpi-cards-grid-4 { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 500px) {
        .kpi-cards-grid-4 { grid-template-columns: 1fr; }
    }
    .kpi-stat-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 16px 20px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .kpi-icon-box {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .kpi-icon-blue { background: #eff6ff; color: #2563eb; }
    .kpi-icon-green { background: #f0fdf4; color: #16a34a; }
    .kpi-icon-amber { background: #fffbeb; color: #d97706; }
    .kpi-icon-red { background: #fef2f2; color: #dc2626; }

    .kpi-info {
        display: flex;
        flex-direction: column;
    }
    .kpi-val {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }
    .kpi-lbl {
        font-size: 11.5px;
        font-weight: 600;
        color: #64748b;
        margin-top: 2px;
    }

    .text-green { color: #16a34a !important; }
    .text-amber { color: #d97706 !important; }
    .text-red { color: #dc2626 !important; }
    .text-muted { color: #94a3b8; }
    .font-bold { font-weight: 700; }
    .font-mono { font-family: 'JetBrains Mono', monospace; font-size: 12.5px; }

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
        padding: 14px 20px;
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
    }
    .task-count-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12.5px;
        font-weight: 700;
        color: #475569;
    }

    /* Table */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }
    .prospek-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 12.5px;
    }
    .prospek-table thead th {
        background: #f8fafc;
        color: #475569;
        font-weight: 700;
        font-size: 12px;
        padding: 12px 16px;
        border-bottom: 1.5px solid #e2e8f0;
        white-space: nowrap;
    }
    .prospek-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s ease;
    }
    .prospek-table tbody tr:hover {
        background-color: #f8fafc;
    }
    .prospek-table tbody td {
        padding: 12px 16px;
        color: #334155;
        vertical-align: middle;
    }

    .badge-status-prospek {
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 5px;
        background: #eff6ff;
        color: #1d4ed8;
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
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
    }
    .btn-icon-wa {
        color: #16a34a;
        background: #f0fdf4;
        border-color: #bbf7d0;
    }
    .btn-icon-wa:hover {
        background: #dcfce7;
    }
    .btn-icon-edit {
        color: #0284c7;
        background: #f0f9ff;
        border-color: #bae6fd;
    }
    .btn-icon-edit:hover {
        background: #e0f2fe;
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
        width: 480px;
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
    .modal-footer {
        padding: 14px 20px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
    }
    .btn-modal-close-action {
        padding: 7px 18px;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
    }
</style>

<script>
    function openModalDetail(item) {
        document.getElementById('modalNopol').value = item.nopol || '';
        document.getElementById('modalKonsumen').value = item.nama_konsumen || '';
        document.getElementById('modalStatus').value = item.status || 'Aktif';
        document.getElementById('modalCatatan').value = item.catatan || 'Belum ada catatan tindak lanjut.';
        document.getElementById('modalDetailProspek').style.display = 'flex';
    }

    function closeModalDetail() {
        document.getElementById('modalDetailProspek').style.display = 'none';
    }

    // Close modal on backdrop click
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('modalDetailProspek');
        if (event.target === modal) {
            closeModalDetail();
        }
    });
</script>
@endsection
