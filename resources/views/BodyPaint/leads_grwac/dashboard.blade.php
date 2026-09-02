@extends('layouts.app')

@section('title', 'Dashboard BP Prospect - OTE DCA')

@section('content')
<div class="bp-dashboard-container">
    {{-- 1. HEADER SECTION --}}
    <div class="page-header-row">
        <div class="header-text-group">
            <h1 class="page-title">Dashboard BP Prospect</h1>
            <p class="page-subtitle">Monitoring prospek Body & Paint — konversi dan follow-up tim</p>
        </div>
        <div class="header-filter-group">
            <form method="GET" action="{{ route('body_paint.leads.dashboard') }}" id="filterDashboardForm" class="filter-header-form">
                <select name="tahun" class="select-filter-control" onchange="document.getElementById('filterDashboardForm').submit()">
                    <option value="2024" {{ ($tahun ?? '') == '2024' ? 'selected' : '' }}>2024</option>
                    <option value="2025" {{ ($tahun ?? '') == '2025' ? 'selected' : '' }}>2025</option>
                    <option value="2026" {{ ($tahun ?? '2026') == '2026' ? 'selected' : '' }}>2026</option>
                    <option value="2027" {{ ($tahun ?? '') == '2027' ? 'selected' : '' }}>2027</option>
                </select>

                <select name="bulan" class="select-filter-control" onchange="document.getElementById('filterDashboardForm').submit()">
                    @php
                        $blnList = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                    @endphp
                    @foreach($blnList as $b)
                        <option value="{{ $b }}" {{ ($bulan ?? 'Agu') == $b ? 'selected' : '' }}>{{ $b }}</option>
                    @endforeach
                </select>

                <a href="{{ route('body_paint.leads.dashboard') }}" class="btn-icon-refresh" title="Refresh Dashboard">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="23 4 23 10 17 10"></polyline>
                        <polyline points="1 20 1 14 7 14"></polyline>
                        <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                    </svg>
                </a>

                <button type="button" class="btn-export-primary" onclick="alert('Export Dashboard sedang dipersiapkan...')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    <span>Export</span>
                </button>
            </form>
        </div>
    </div>

    {{-- 2. KPI STATS CARDS (6 CARDS) --}}
    <div class="kpi-cards-grid">
        {{-- Total Prospect --}}
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
                <div class="kpi-val">{{ $kpi['total_prospect'] ?? 0 }}</div>
                <div class="kpi-lbl">Total Prospect <span class="info-dot" title="Total seluruh prospek Body & Paint">ⓘ</span></div>
            </div>
        </div>

        {{-- Unit Entry --}}
        <div class="kpi-stat-card">
            <div class="kpi-icon-box kpi-icon-green">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div class="kpi-info">
                <div class="kpi-val text-green">{{ $kpi['unit_entry'] ?? 0 }}</div>
                <div class="kpi-lbl">Unit Entry <span class="info-dot" title="Prospek yang sudah masuk unit entry">ⓘ</span></div>
            </div>
        </div>

        {{-- Conv. Rate --}}
        <div class="kpi-stat-card">
            <div class="kpi-icon-box kpi-icon-purple">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="5" x2="5" y2="19"></line>
                    <circle cx="6.5" cy="6.5" r="2.5"></circle>
                    <circle cx="17.5" cy="17.5" r="2.5"></circle>
                </svg>
            </div>
            <div class="kpi-info">
                <div class="kpi-val text-purple">{{ $kpi['conv_rate'] ?? '0%' }}</div>
                <div class="kpi-lbl">Conv. Rate <span class="info-dot" title="Persentase konversi prospek menjadi unit entry">ⓘ</span></div>
            </div>
        </div>

        {{-- Avg Lead Time --}}
        <div class="kpi-stat-card">
            <div class="kpi-icon-box kpi-icon-amber">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
            <div class="kpi-info">
                <div class="kpi-val text-amber">{{ $kpi['avg_lead_time'] ?? 0 }}</div>
                <div class="kpi-lbl">Avg Lead Time (hari) <span class="info-dot" title="Rata-rata waktu tindak lanjut prospek">ⓘ</span></div>
            </div>
        </div>

        {{-- Gap (Input - Target) --}}
        <div class="kpi-stat-card">
            <div class="kpi-icon-box kpi-icon-red">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <polyline points="19 12 12 19 5 12"></polyline>
                </svg>
            </div>
            <div class="kpi-info">
                <div class="kpi-val text-red">{{ $kpi['gap'] ?? 0 }}</div>
                <div class="kpi-lbl">Gap (Input - Target) <span class="info-dot" title="Selisih antara realisasi input dengan target">ⓘ</span></div>
                <div class="kpi-sublbl">Target: {{ $kpi['target_leads'] ?? 0 }} leads</div>
            </div>
        </div>

        {{-- Overdue --}}
        <div class="kpi-stat-card">
            <div class="kpi-icon-box kpi-icon-orange">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <div class="kpi-info">
                <div class="kpi-val text-orange">{{ $kpi['overdue'] ?? 0 }}</div>
                <div class="kpi-lbl">Overdue <span class="info-dot" title="Prospek yang melewati batas waktu follow up">ⓘ</span></div>
            </div>
        </div>
    </div>

    {{-- 3. CHARTS ROW (3 VISUAL CARDS) --}}
    <div class="dashboard-charts-grid">
        {{-- Chart 1: Funnel Status --}}
        <div class="chart-card chart-card-donut">
            <div class="chart-header">
                <h3 class="chart-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M12 2a10 10 0 0 1 10 10"></path>
                    </svg>
                    <span>Funnel Status</span>
                    <span class="info-dot">ⓘ</span>
                </h3>
            </div>
            <div class="chart-body" style="height: 200px; position: relative;">
                <canvas id="chartFunnelStatus"></canvas>
            </div>
            <div class="chart-custom-legend">
                <div class="legend-item"><span class="legend-dot" style="background: #3b82f6;"></span><span>Baru</span></div>
                <div class="legend-item"><span class="legend-dot" style="background: #f59e0b;"></span><span>Dihubungi</span></div>
                <div class="legend-item"><span class="legend-dot" style="background: #10b981;"></span><span>Janji</span></div>
            </div>
        </div>

        {{-- Chart 2: Leads vs Target (12 Bulan) --}}
        <div class="chart-card chart-card-bar">
            <div class="chart-header">
                <h3 class="chart-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="20" x2="18" y2="10"></line>
                        <line x1="12" y1="20" x2="12" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="14"></line>
                    </svg>
                    <span>Leads vs Target (12 Bulan)</span>
                    <span class="info-dot">ⓘ</span>
                </h3>
            </div>
            <div class="chart-body" style="height: 200px; position: relative;">
                <canvas id="chartLeadsTarget"></canvas>
            </div>
            <div class="chart-custom-legend">
                <div class="legend-item"><span class="legend-dot" style="background: #6366f1;"></span><span>Leads</span></div>
                <div class="legend-item"><span class="legend-dot" style="background: #cbd5e1;"></span><span>Target</span></div>
            </div>
        </div>

        {{-- Chart 3: Status Asuransi --}}
        <div class="chart-card chart-card-donut">
            <div class="chart-header">
                <h3 class="chart-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                    <span>Status Asuransi</span>
                    <span class="info-dot">ⓘ</span>
                </h3>
            </div>
            <div class="chart-body" style="height: 200px; position: relative;">
                <canvas id="chartStatusAsuransi"></canvas>
            </div>
            <div class="chart-custom-legend">
                <div class="legend-item"><span class="legend-dot" style="background: #10b981;"></span><span>Berasuransi</span></div>
                <div class="legend-item"><span class="legend-dot" style="background: #94a3b8;"></span><span>Tidak Berasuransi</span></div>
            </div>
        </div>
    </div>

    {{-- 4. LEADERBOARD SECTION (2 TABLES) --}}
    <div class="dashboard-leaderboard-grid">
        {{-- Top SA GR --}}
        <div class="table-card-wrapper">
            <div class="table-subtoolbar">
                <div class="toolbar-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                    </svg>
                    <span>Top SA GR — Input Terbanyak</span>
                    <span class="info-dot">ⓘ</span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama SA GR</th>
                            <th style="width: 130px; text-align: right;">Jumlah Input</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topSaGr as $gr)
                        <tr>
                            <td class="text-muted">{{ $gr['no'] }}</td>
                            <td class="font-bold">{{ $gr['nama'] }}</td>
                            <td style="text-align: right;" class="text-blue font-bold font-mono">{{ $gr['jumlah'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted" style="padding: 24px;">Belum ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Top SA BP --}}
        <div class="table-card-wrapper">
            <div class="table-subtoolbar">
                <div class="toolbar-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                    </svg>
                    <span>Top SA BP — Konversi Tertinggi</span>
                    <span class="info-dot">ⓘ</span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama SA BP</th>
                            <th style="width: 80px; text-align: center;">Total</th>
                            <th style="width: 80px; text-align: center;">Konversi</th>
                            <th style="width: 90px; text-align: right;">Rate %</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topSaBp as $bp)
                        <tr>
                            <td class="text-muted">{{ $bp['no'] }}</td>
                            <td class="font-bold">{{ $bp['nama'] }}</td>
                            <td style="text-align: center;">{{ $bp['total'] }}</td>
                            <td style="text-align: center;" class="text-green font-bold">{{ $bp['konversi'] }}</td>
                            <td style="text-align: right;" class="text-purple font-bold font-mono">{{ $bp['rate'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted" style="padding: 24px;">Belum ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- 5. DAFTAR OVERDUE TABLE --}}
    <div class="table-card-wrapper overdue-section">
        <div class="table-subtoolbar overdue-toolbar">
            <div class="toolbar-title text-red">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
                <span>Daftar Overdue</span>
                <span class="info-dot">ⓘ</span>
            </div>
            <span class="badge-count-red">{{ count($daftarOverdue) }}</span>
        </div>
        <div class="table-responsive">
            <table class="dashboard-table overdue-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th style="width: 140px;">No. Polisi</th>
                        <th>Nama Konsumen</th>
                        <th style="width: 130px;">Status</th>
                        <th style="width: 140px;">Next F/U</th>
                        <th style="width: 180px;">SA BP</th>
                        <th style="width: 80px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($daftarOverdue as $od)
                    <tr>
                        <td class="text-muted">{{ $od['no'] }}</td>
                        <td>
                            <a href="javascript:void(0)" class="nopol-link font-mono font-bold">{{ $od['nopol'] }}</a>
                        </td>
                        <td class="font-bold">{{ $od['konsumen'] }}</td>
                        <td>
                            <span class="badge-status-dihubungi">{{ $od['status'] }}</span>
                        </td>
                        <td class="text-red font-bold font-mono">{{ $od['next_fu'] }}</td>
                        <td>{{ $od['sa_bp'] }}</td>
                        <td style="text-align: center;">
                            <button type="button" class="btn-icon-eye" title="Lihat Detail Prospek" onclick="alert('Detail prospek ' + '{{ $od['nopol'] }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M22 12c-2.4 4-5.4 6-10 6-4.6 0-7.6-2-10-6 2.4-4 5.4-6 10-6 4.6 0 7.6 2 10 6z"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted" style="padding: 30px;">Tidak ada prospek overdue.</td>
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
    .bp-dashboard-container {
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
    .filter-header-form {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .select-filter-control {
        height: 36px;
        padding: 4px 10px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 12.5px;
        font-weight: 600;
        color: #1e293b;
        outline: none;
    }
    .btn-icon-refresh {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #64748b;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-icon-refresh:hover {
        color: #dc2626;
        border-color: #fca5a5;
        background: #fef2f2;
    }
    .btn-export-primary {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        height: 36px;
        padding: 0 16px;
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
    .btn-export-primary:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
    }

    /* KPI Cards (6 Grid) */
    .kpi-cards-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 12px;
        margin-bottom: 20px;
    }
    @media (max-width: 1200px) {
        .kpi-cards-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 640px) {
        .kpi-cards-grid { grid-template-columns: repeat(2, 1fr); }
    }
    .kpi-stat-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 14px 16px;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.03);
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }
    .kpi-icon-box {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .kpi-icon-blue { background: #eff6ff; color: #2563eb; }
    .kpi-icon-green { background: #f0fdf4; color: #16a34a; }
    .kpi-icon-purple { background: #f5f3ff; color: #7c3aed; }
    .kpi-icon-amber { background: #fffbeb; color: #d97706; }
    .kpi-icon-red { background: #fef2f2; color: #dc2626; }
    .kpi-icon-orange { background: #fff7ed; color: #ea580c; }

    .kpi-info {
        display: flex;
        flex-direction: column;
    }
    .kpi-val {
        font-size: 20px;
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
    .kpi-sublbl {
        font-size: 10px;
        color: #94a3b8;
        margin-top: 1px;
    }
    .info-dot {
        font-size: 11px;
        color: #94a3b8;
        cursor: help;
        margin-left: 2px;
    }

    .text-green { color: #16a34a !important; }
    .text-purple { color: #7c3aed !important; }
    .text-amber { color: #d97706 !important; }
    .text-red { color: #dc2626 !important; }
    .text-orange { color: #ea580c !important; }
    .text-blue { color: #2563eb !important; }
    .text-muted { color: #94a3b8; }
    .font-bold { font-weight: 700; }
    .font-mono { font-family: 'JetBrains Mono', monospace; font-size: 12px; }

    /* Charts Row */
    .dashboard-charts-grid {
        display: grid;
        grid-template-columns: 1fr 2fr 1fr;
        gap: 16px;
        margin-bottom: 20px;
    }
    @media (max-width: 1024px) {
        .dashboard-charts-grid { grid-template-columns: 1fr; }
    }
    .chart-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 16px 18px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
        display: flex;
        flex-direction: column;
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

    /* Leaderboards */
    .dashboard-leaderboard-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 20px;
    }
    @media (max-width: 768px) {
        .dashboard-leaderboard-grid { grid-template-columns: 1fr; }
    }

    /* Table General */
    .table-card-wrapper {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
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
        font-size: 13.5px;
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
    .dashboard-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 12.5px;
    }
    .dashboard-table thead th {
        background: #f8fafc;
        color: #475569;
        font-weight: 700;
        font-size: 11.5px;
        padding: 10px 14px;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }
    .dashboard-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s ease;
    }
    .dashboard-table tbody tr:hover {
        background-color: #f8fafc;
    }
    .dashboard-table tbody td {
        padding: 10px 14px;
        color: #334155;
        vertical-align: middle;
    }

    /* Overdue Section */
    .overdue-toolbar {
        background: #fff5f5;
        border-bottom-color: #fee2e2;
    }
    .badge-count-red {
        background: #fee2e2;
        color: #dc2626;
        font-size: 11px;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 12px;
    }
    .nopol-link {
        color: #2563eb;
        text-decoration: none;
    }
    .nopol-link:hover {
        text-decoration: underline;
    }
    .badge-status-dihubungi {
        background: #fef2f2;
        color: #dc2626;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 4px;
        display: inline-block;
    }
    .btn-icon-eye {
        width: 26px;
        height: 26px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #0284c7;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
    }
    .btn-icon-eye:hover {
        background: #f0f9ff;
        border-color: #bae6fd;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Chart Funnel Status (Donut)
        const ctxFunnel = document.getElementById('chartFunnelStatus');
        if (ctxFunnel) {
            const funnelValues = [{{ $funnelData['baru'] ?? 0 }}, {{ $funnelData['dihubungi'] ?? 0 }}, {{ $funnelData['janji'] ?? 0 }}];
            const funnelSum = funnelValues.reduce((a, b) => a + b, 0);
            new Chart(ctxFunnel, {
                type: 'doughnut',
                data: {
                    labels: funnelSum > 0 ? ['Baru', 'Dihubungi', 'Janji'] : ['Belum ada data'],
                    datasets: [{
                        data: funnelSum > 0 ? funnelValues : [1],
                        backgroundColor: funnelSum > 0 ? ['#3b82f6', '#f59e0b', '#10b981'] : ['#f1f5f9'],
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
                                    return funnelSum > 0 ? ' ' + context.label + ': ' + context.raw : ' Belum ada data';
                                }
                            }
                        }
                    }
                }
            });
        }

        // 2. Chart Leads vs Target 12 Bulan (Bar)
        const ctxLeadsTarget = document.getElementById('chartLeadsTarget');
        if (ctxLeadsTarget) {
            new Chart(ctxLeadsTarget, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($chart12Bulan['labels'] ?? []) !!},
                    datasets: [
                        {
                            label: 'Leads',
                            data: {!! json_encode($chart12Bulan['leads'] ?? []) !!},
                            backgroundColor: '#6366f1',
                            borderRadius: 4,
                        },
                        {
                            label: 'Target',
                            data: {!! json_encode($chart12Bulan['target'] ?? []) !!},
                            backgroundColor: '#cbd5e1',
                            borderRadius: 4,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10 } }
                        },
                        y: {
                            beginAtZero: true,
                            max: 90,
                            grid: { color: '#f1f5f9' },
                            ticks: { stepSize: 10, font: { size: 10 } }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }

        // 3. Chart Status Asuransi (Donut)
        const ctxAsuransi = document.getElementById('chartStatusAsuransi');
        if (ctxAsuransi) {
            const asuransiValues = [{{ $asuransiData['berasuransi'] ?? 0 }}, {{ $asuransiData['tidak_berasuransi'] ?? 0 }}];
            const asuransiSum = asuransiValues.reduce((a, b) => a + b, 0);
            new Chart(ctxAsuransi, {
                type: 'doughnut',
                data: {
                    labels: asuransiSum > 0 ? ['Berasuransi', 'Tidak Berasuransi'] : ['Belum ada data'],
                    datasets: [{
                        data: asuransiSum > 0 ? asuransiValues : [1],
                        backgroundColor: asuransiSum > 0 ? ['#10b981', '#94a3b8'] : ['#f1f5f9'],
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
                                    return asuransiSum > 0 ? ' ' + context.label + ': ' + context.raw : ' Belum ada data';
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
