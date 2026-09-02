@extends('layouts.app')

@section('title', 'Dashboard Asuransi BP - OTE DCA')

@section('content')
<div class="bp-asuransi-dashboard-container">
    {{-- 1. HEADER SECTION --}}
    <div class="page-header-row">
        <div class="header-text-group">
            <h1 class="page-title">Dashboard Asuransi</h1>
            <p class="page-subtitle">Analitik follow-up asuransi COMP &mdash; verbatim, urgency, dan status klaim</p>
        </div>
        <div class="header-action-group">
            <a href="{{ route('body_paint.monitoring.dashboard') }}" class="btn-icon-refresh-header" title="Refresh Dashboard">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 4 23 10 17 10"></polyline>
                    <polyline points="1 20 1 14 7 14"></polyline>
                    <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                </svg>
            </a>
        </div>
    </div>

    {{-- 2. 7 KPI STATS CARDS --}}
    <div class="kpi-cards-grid-7">
        {{-- Total COMP Aktif --}}
        <div class="kpi-stat-card">
            <div class="kpi-icon-box kpi-icon-blue">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
            </div>
            <div class="kpi-info">
                <div class="kpi-val">{{ $kpi['total_comp_aktif'] ?? 0 }}</div>
                <div class="kpi-lbl">Total COMP Aktif</div>
            </div>
        </div>

        {{-- Habis <= 30 Hari --}}
        <div class="kpi-stat-card">
            <div class="kpi-icon-box kpi-icon-red">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <div class="kpi-info">
                <div class="kpi-val text-red">{{ $kpi['habis_30_hari'] ?? 0 }}</div>
                <div class="kpi-lbl">Habis &le; 30 Hari <span class="info-dot">ⓘ</span></div>
            </div>
        </div>

        {{-- Mau Habis (<= 60 hari) --}}
        <div class="kpi-stat-card">
            <div class="kpi-icon-box kpi-icon-amber">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
            <div class="kpi-info">
                <div class="kpi-val text-amber">{{ $kpi['mau_habis_60_hari'] ?? 0 }}</div>
                <div class="kpi-lbl">Mau Habis (&le; 60 hari) <span class="info-dot">ⓘ</span></div>
            </div>
        </div>

        {{-- Sudah Dihubungi --}}
        <div class="kpi-stat-card">
            <div class="kpi-icon-box kpi-icon-green">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                </svg>
            </div>
            <div class="kpi-info">
                <div class="kpi-val text-green">{{ $kpi['sudah_dihubungi'] ?? 0 }}</div>
                <div class="kpi-lbl">Sudah Dihubungi <span class="info-dot">ⓘ</span></div>
            </div>
        </div>

        {{-- Belum Dihubungi --}}
        <div class="kpi-stat-card">
            <div class="kpi-icon-box kpi-icon-purple">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
            </div>
            <div class="kpi-info">
                <div class="kpi-val text-purple">{{ $kpi['belum_dihubungi'] ?? 0 }}</div>
                <div class="kpi-lbl">Belum Dihubungi <span class="info-dot">ⓘ</span></div>
            </div>
        </div>

        {{-- Sudah Diklaim --}}
        <div class="kpi-stat-card">
            <div class="kpi-icon-box kpi-icon-emerald">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div class="kpi-info">
                <div class="kpi-val text-green">{{ $kpi['sudah_diklaim'] ?? 0 }}</div>
                <div class="kpi-lbl">Sudah Diklaim <span class="info-dot">ⓘ</span></div>
            </div>
        </div>

        {{-- Walk-In / Booking --}}
        <div class="kpi-stat-card">
            <div class="kpi-icon-box kpi-icon-teal">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9C2.1 11.2 2 11.6 2 12v4c0 .6.4 1 1 1h2"></path>
                    <circle cx="7" cy="17" r="2"></circle>
                    <path d="M9 17h6"></path>
                    <circle cx="17" cy="17" r="2"></circle>
                </svg>
            </div>
            <div class="kpi-info">
                <div class="kpi-val text-teal">{{ $kpi['walkin_booking'] ?? 0 }}</div>
                <div class="kpi-lbl">Walk-In / Booking <span class="info-dot">ⓘ</span></div>
            </div>
        </div>
    </div>

    {{-- 3. CHARTS ROW (2 VISUAL CARDS) --}}
    <div class="dashboard-charts-grid-2">
        {{-- Chart 1: Alasan Konsumen (Verbatim) --}}
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="20" x2="18" y2="10"></line>
                        <line x1="12" y1="20" x2="12" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="14"></line>
                    </svg>
                    <span>Alasan Konsumen (Verbatim)</span>
                    <span class="info-dot">ⓘ</span>
                </h3>
            </div>
            <div class="chart-body" style="height: 220px; position: relative;">
                <canvas id="chartAlasanVerbatim"></canvas>
            </div>
        </div>

        {{-- Chart 2: Urgency Expiry --}}
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <span>Urgency Expiry</span>
                    <span class="info-dot">ⓘ</span>
                </h3>
            </div>
            <div class="chart-body" style="height: 220px; position: relative;">
                <canvas id="chartUrgencyExpiry"></canvas>
                {{-- Center text for Donut --}}
                <div class="donut-center-text" id="donutCenterInfo">
                    <span class="donut-center-val">{{ $urgencyExpiry['total_kendaraan'] ?? 0 }}</span>
                    <span class="donut-center-lbl">kendaraan</span>
                </div>
            </div>
            <div class="chart-custom-legend">
                <div class="legend-item"><span class="legend-dot" style="background: #ef4444;"></span><span>&le; 30 hari</span></div>
                <div class="legend-item"><span class="legend-dot" style="background: #f59e0b;"></span><span>31&ndash;60 hari</span></div>
                <div class="legend-item"><span class="legend-dot" style="background: #10b981;"></span><span>&gt; 60 hari</span></div>
            </div>
        </div>
    </div>

    {{-- 4. TABLE SECTION: 10 KENDARAAN PALING DEKAT EXPIRY --}}
    <div class="table-card-wrapper">
        <div class="table-subtoolbar">
            <div class="toolbar-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="8" y1="6" x2="21" y2="6"></line>
                    <line x1="8" y1="12" x2="21" y2="12"></line>
                    <line x1="8" y1="18" x2="21" y2="18"></line>
                    <line x1="3" y1="6" x2="3.01" y2="6"></line>
                    <line x1="3" y1="12" x2="3.01" y2="12"></line>
                    <line x1="3" y1="18" x2="3.01" y2="18"></line>
                </svg>
                <span>{{ count($dekatExpiryList) }} Kendaraan Paling Dekat Expiry &mdash; Belum Dihubungi</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="asuransi-table">
                <thead>
                    <tr>
                        <th style="min-width: 170px;">VIN</th>
                        <th style="min-width: 130px;">No Polisi</th>
                        <th style="min-width: 180px;">Nama Konsumen</th>
                        <th style="min-width: 140px;">Model</th>
                        <th style="min-width: 140px;">Perusahaan</th>
                        <th style="min-width: 120px;">Tgl Habis</th>
                        <th style="min-width: 100px;">Sisa Hari</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dekatExpiryList as $item)
                    <tr>
                        <td class="font-mono font-bold">{{ $item['vin'] }}</td>
                        <td class="font-mono">{{ $item['no_polisi'] ?? '-' }}</td>
                        <td class="font-bold">{{ $item['nama_konsumen'] }}</td>
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
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty-state-row">
                            <div class="empty-state-content">
                                <div class="empty-icon-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline>
                                        <path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path>
                                    </svg>
                                </div>
                                <p class="empty-text">Tidak ada data kendaraan mendekati expiry</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    /* Global Container */
    .bp-asuransi-dashboard-container {
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

    /* 7 KPI Cards Grid */
    .kpi-cards-grid-7 {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 12px;
        margin-bottom: 20px;
    }
    @media (max-width: 1400px) {
        .kpi-cards-grid-7 { grid-template-columns: repeat(4, 1fr); }
    }
    @media (max-width: 900px) {
        .kpi-cards-grid-7 { grid-template-columns: repeat(2, 1fr); }
    }
    .kpi-stat-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 14px 14px;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.03);
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }
    .kpi-icon-box {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .kpi-icon-blue { background: #eff6ff; color: #2563eb; }
    .kpi-icon-red { background: #fef2f2; color: #dc2626; }
    .kpi-icon-amber { background: #fffbeb; color: #d97706; }
    .kpi-icon-green { background: #f0fdf4; color: #16a34a; }
    .kpi-icon-purple { background: #f5f3ff; color: #7c3aed; }
    .kpi-icon-emerald { background: #ecfdf5; color: #059669; }
    .kpi-icon-teal { background: #f0fdfa; color: #0d9488; }

    .kpi-info {
        display: flex;
        flex-direction: column;
    }
    .kpi-val {
        font-size: 19px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }
    .kpi-lbl {
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
        margin-top: 2px;
    }
    .info-dot {
        font-size: 10px;
        color: #94a3b8;
    }

    .text-green { color: #16a34a !important; }
    .text-amber { color: #d97706 !important; }
    .text-red { color: #dc2626 !important; }
    .text-purple { color: #7c3aed !important; }
    .text-teal { color: #0d9488 !important; }
    .font-bold { font-weight: 700; }
    .font-mono { font-family: 'JetBrains Mono', monospace; font-size: 12px; }

    /* 2 Charts Grid */
    .dashboard-charts-grid-2 {
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 16px;
        margin-bottom: 20px;
    }
    @media (max-width: 900px) {
        .dashboard-charts-grid-2 { grid-template-columns: 1fr; }
    }
    .chart-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 16px 18px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
        display: flex;
        flex-direction: column;
        position: relative;
    }
    .chart-header {
        margin-bottom: 12px;
    }
    .chart-title {
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .chart-custom-legend {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 14px;
        margin-top: 10px;
        font-size: 11.5px;
        font-weight: 600;
        color: #64748b;
    }
    .legend-item {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 3px;
    }

    /* Donut Center Overlay */
    .donut-center-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: flex;
        flex-direction: column;
        align-items: center;
        pointer-events: none;
    }
    .donut-center-val {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
    }
    .donut-center-lbl {
        font-size: 10.5px;
        color: #64748b;
        font-weight: 600;
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
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
    }
    .toolbar-title {
        font-size: 13px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 6px;
    }
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
        background: #f8fafc;
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

    /* Badges */
    .badge-sisa-green {
        background: #f0fdf4;
        color: #16a34a;
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
        background: #fef2f2;
        color: #dc2626;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 4px;
        display: inline-block;
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
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Chart Alasan Konsumen (Verbatim) - Horizontal Bar
        const ctxAlasan = document.getElementById('chartAlasanVerbatim');
        if (ctxAlasan) {
            new Chart(ctxAlasan, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($alasanVerbatim['labels'] ?? ['Lainnya', 'Sudah walk-in ke DCM', 'Belum ada waktu']) !!},
                    datasets: [{
                        data: {!! json_encode($alasanVerbatim['data'] ?? [0, 0, 0]) !!},
                        backgroundColor: '#3b82f6',
                        borderRadius: 4,
                        barThickness: 18
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            max: 40,
                            grid: { color: '#f1f5f9' },
                            ticks: { font: { size: 10 } }
                        },
                        y: {
                            grid: { display: false },
                            ticks: { font: { size: 11 } }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }

        // 2. Chart Urgency Expiry (Donut)
        const ctxUrgency = document.getElementById('chartUrgencyExpiry');
        if (ctxUrgency) {
            const urgencyValues = [
                {{ $urgencyExpiry['kritis_30'] ?? 0 }},
                {{ $urgencyExpiry['peringatan_60'] ?? 0 }},
                {{ $urgencyExpiry['aman_gt_60'] ?? 0 }}
            ];
            const urgencySum = urgencyValues.reduce((a, b) => a + b, 0);

            new Chart(ctxUrgency, {
                type: 'doughnut',
                data: {
                    labels: urgencySum > 0 ? ['<= 30 hari', '31-60 hari', '> 60 hari'] : ['Belum ada data'],
                    datasets: [{
                        data: urgencySum > 0 ? urgencyValues : [1],
                        backgroundColor: urgencySum > 0 ? ['#ef4444', '#f59e0b', '#10b981'] : ['#f1f5f9'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return urgencySum > 0 ? ' ' + context.label + ': ' + context.raw : ' Belum ada data';
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
