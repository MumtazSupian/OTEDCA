@extends('layouts.app')

@section('title', 'Monitoring Follow-Up - OTE DCA')

@section('content')
<div class="monitoring-container">
    {{-- 1. HEADER SECTION --}}
    <div class="page-header-row">
        <div class="header-text-group">
            <h1 class="page-title">Monitoring Follow-Up</h1>
            <p class="page-subtitle">KPI dan performa tim follow-up asuransi</p>
        </div>
        <div class="header-action-group">
            <a href="{{ route('asuransi.monitoring_follow_up') }}" class="btn-header-refresh">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 4 23 10 17 10"></polyline>
                    <polyline points="1 20 1 14 7 14"></polyline>
                    <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                </svg>
                <span>Refresh</span>
            </a>
        </div>
    </div>

    {{-- 2. MAIN CARD: PERFORMA PER SPV --}}
    <div class="monitoring-card">
        <div class="monitoring-card-header">
            <h3 class="card-title">Performa Per SPV</h3>
            <span class="card-hint">Klik baris untuk lihat detail per sales</span>
        </div>

        <div class="table-responsive">
            <table class="monitoring-table">
                <thead>
                    <tr>
                        <th style="min-width: 200px;">SPV</th>
                        <th style="width: 80px; text-align: center;">Total</th>
                        <th style="width: 80px; text-align: center;">Open</th>
                        <th style="width: 80px; text-align: center;">Overdue</th>
                        <th style="width: 80px; text-align: center;">Berhasil</th>
                        <th style="width: 100px; text-align: center;">Tdk Berminat</th>
                        <th style="width: 110px; text-align: center;">Kontak Dicatat</th>
                        <th style="width: 110px; text-align: center;">Kontak Rate</th>
                        <th style="width: 110px; text-align: center;">Response Rate</th>
                        <th style="min-width: 130px;">Terakhir Aktif</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($spvList as $spv)
                    <tr class="clickable-row" onclick="openDetailSpv({{ json_encode($spv) }})">
                        <td>
                            <div class="spv-name-cell">
                                <span class="spv-name-text">{{ $spv['nama'] }}</span>
                                <span class="spv-sales-count">{{ count($spv['sales'] ?? []) }} sales</span>
                            </div>
                        </td>
                        <td style="text-align: center; font-weight: 700;">{{ $spv['total'] ?? 0 }}</td>
                        <td style="text-align: center;">{{ $spv['open'] ?? 0 }}</td>
                        <td style="text-align: center; color: #dc2626; font-weight: 700;">{{ $spv['overdue'] ?? 0 }}</td>
                        <td style="text-align: center; color: #16a34a; font-weight: 700;">{{ $spv['berhasil'] ?? 0 }}</td>
                        <td style="text-align: center; color: #64748b;">{{ $spv['tidak_berminat'] ?? 0 }}</td>
                        <td style="text-align: center;">{{ $spv['kontak_dicatat'] ?? 0 }}</td>
                        <td style="text-align: center;">
                            <span class="badge-rate">{{ $spv['kontak_rate'] ?? '0%' }}</span>
                        </td>
                        <td style="text-align: center;">
                            <span class="badge-rate">{{ $spv['response_rate'] ?? '0%' }}</span>
                        </td>
                        <td>{{ $spv['terakhir_aktif'] ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="empty-state-row">
                            <div class="empty-state-content">
                                <div class="empty-icon-circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                </div>
                                <p class="empty-text">Belum ada data SPV</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL DETAIL PER SALES DALAM SPV --}}
    <div class="modal-backdrop" id="modalDetailSpv">
        <div class="modal-dialog modal-detail-dialog">
            <div class="modal-header">
                <div>
                    <h3 class="modal-title" id="modalSpvTitle">Detail Performa Sales</h3>
                    <p class="modal-subtitle" id="modalSpvSubtitle">Tim SPV: -</p>
                </div>
                <button type="button" class="btn-modal-close" onclick="closeDetailSpv()">&times;</button>
            </div>
            <div class="modal-body" style="padding: 16px;">
                <div class="table-responsive">
                    <table class="monitoring-table">
                        <thead>
                            <tr>
                                <th>Nama Sales</th>
                                <th style="text-align: center;">Total</th>
                                <th style="text-align: center;">Open</th>
                                <th style="text-align: center;">Overdue</th>
                                <th style="text-align: center;">Berhasil</th>
                                <th style="text-align: center;">Tdk Berminat</th>
                                <th style="text-align: center;">Kontak Rate</th>
                                <th>Terakhir Aktif</th>
                            </tr>
                        </thead>
                        <tbody id="modalSalesTableBody">
                            <tr>
                                <td colspan="8" class="text-center" style="padding: 30px; color: #94a3b8;">
                                    Belum ada data sales dalam tim ini.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-close-action" onclick="closeDetailSpv()">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Global Container */
    .monitoring-container {
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
    .btn-header-refresh {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        padding: 6px 12px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        transition: all 0.2s ease;
    }
    .btn-header-refresh:hover {
        color: #dc2626;
        border-color: #fca5a5;
        background: #fef2f2;
    }

    /* Main Card */
    .monitoring-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }
    .monitoring-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 20px;
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
    }
    .card-title {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }
    .card-hint {
        font-size: 11.5px;
        color: #94a3b8;
    }

    /* Table */
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
        padding: 12px 16px;
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
    .clickable-row {
        cursor: pointer;
    }
    .monitoring-table tbody td {
        padding: 12px 16px;
        color: #334155;
        vertical-align: middle;
    }

    .spv-name-cell {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .spv-name-text {
        font-weight: 700;
        color: #0f172a;
    }
    .spv-sales-count {
        font-size: 11px;
        color: #64748b;
    }

    .badge-rate {
        font-size: 11px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 4px;
        background: #f1f5f9;
        color: #475569;
    }

    /* Empty State */
    .empty-state-row {
        text-align: center;
        padding: 80px 20px !important;
    }
    .empty-state-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }
    .empty-icon-circle {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #f8fafc;
    }
    .empty-text {
        font-size: 13px;
        font-weight: 600;
        color: #94a3b8;
        margin: 0;
    }

    /* Modal Detail */
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
        width: 800px;
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
        margin: 0 0 2px 0;
    }
    .modal-subtitle {
        font-size: 12px;
        color: #64748b;
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
    function openDetailSpv(spv) {
        document.getElementById('modalSpvTitle').textContent = 'Detail Performa Sales: ' + spv.nama;
        document.getElementById('modalSpvSubtitle').textContent = 'Tim SPV: ' + spv.nama;
        document.getElementById('modalDetailSpv').style.display = 'flex';
    }

    function closeDetailSpv() {
        document.getElementById('modalDetailSpv').style.display = 'none';
    }

    // Close on backdrop click
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('modalDetailSpv');
        if (event.target === modal) {
            closeDetailSpv();
        }
    });
</script>
@endsection
