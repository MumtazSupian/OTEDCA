@extends('layouts.app')

@section('title', 'Dashboard Asuransi - OTE DCA')

@section('content')
<div class="asuransi-dashboard-container">
    {{-- 1. HEADER SECTION --}}
    <div class="page-header-row">
        <div class="header-text-group">
            <h1 class="page-title">Dashboard Asuransi</h1>
            <p class="page-subtitle">Monitoring status asuransi kendaraan</p>
            <div class="period-badge-sub">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                <span>Periode: {{ date('d/m/Y', strtotime('-5 years')) }} &ndash; {{ date('d/m/Y') }}</span>
            </div>
        </div>

        {{-- Filter Top Right --}}
        <div class="header-action-group">
            <form method="GET" action="{{ route('asuransi.dashboard') }}" class="period-filter-form">
                <div class="input-period-wrapper">
                    <input type="text" name="periode" value="{{ $periode ?? '' }}" placeholder="Pilih periode..." class="input-period-control">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="calendar-icon">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <button type="submit" class="btn-tampilkan">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <span>Tampilkan</span>
                </button>
            </form>
            <a href="{{ route('asuransi.dashboard') }}" class="btn-icon-refresh-header" title="Refresh Dashboard">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 4 23 10 17 10"></polyline>
                    <polyline points="1 20 1 14 7 14"></polyline>
                    <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                </svg>
            </a>
        </div>
    </div>

    {{-- 2. 6 TOP KPI STATS CARDS --}}
    <div class="kpi-cards-grid-6">
        {{-- Total Kendaraan --}}
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
                <div class="kpi-val">{{ number_format($kpi['total_kendaraan'] ?? 0) }}</div>
                <div class="kpi-lbl">Total Kendaraan <span class="info-dot">ⓘ</span></div>
            </div>
        </div>

        {{-- Aktif --}}
        <div class="kpi-stat-card">
            <div class="kpi-icon-box kpi-icon-green">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
            </div>
            <div class="kpi-info">
                <div class="kpi-val text-green">{{ number_format($kpi['aktif'] ?? 0) }}</div>
                <div class="kpi-lbl">Aktif <span class="info-dot">ⓘ</span></div>
            </div>
        </div>

        {{-- Segera Habis --}}
        <div class="kpi-stat-card">
            <div class="kpi-icon-box kpi-icon-amber">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
            </div>
            <div class="kpi-info">
                <div class="kpi-val text-amber">{{ number_format($kpi['segera_habis'] ?? 0) }}</div>
                <div class="kpi-lbl">Segera Habis <span class="info-dot">ⓘ</span></div>
            </div>
        </div>

        {{-- Kritis --}}
        <div class="kpi-stat-card">
            <div class="kpi-icon-box kpi-icon-red">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <div class="kpi-info">
                <div class="kpi-val text-red">{{ number_format($kpi['kritis'] ?? 0) }}</div>
                <div class="kpi-lbl">Kritis <span class="info-dot">ⓘ</span></div>
            </div>
        </div>

        {{-- Expired --}}
        <div class="kpi-stat-card">
            <div class="kpi-icon-box kpi-icon-slate">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </div>
            <div class="kpi-info">
                <div class="kpi-val">{{ number_format($kpi['expired'] ?? 0) }}</div>
                <div class="kpi-lbl">Expired <span class="info-dot">ⓘ</span></div>
            </div>
        </div>

        {{-- Tanpa Data --}}
        <div class="kpi-stat-card">
            <div class="kpi-icon-box kpi-icon-purple">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
            </div>
            <div class="kpi-info">
                <div class="kpi-val text-purple">{{ number_format($kpi['tanpa_data'] ?? 0) }}</div>
                <div class="kpi-lbl">Tanpa Data <span class="info-dot">ⓘ</span></div>
                <div class="kpi-sub-detail">Leasing: {{ $kpi['leasing'] ?? 0 }} | Cash: {{ $kpi['cash'] ?? 0 }}</div>
            </div>
        </div>
    </div>

    {{-- 3. MIDDLE 2 STATUS CARDS --}}
    <div class="middle-cards-grid-2">
        {{-- Card 1: Kelengkapan Data Asuransi --}}
        <div class="middle-stat-card">
            <div class="middle-card-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="9" y1="9" x2="15" y2="9"></line>
                    <line x1="9" y1="13" x2="15" y2="13"></line>
                    <line x1="9" y1="17" x2="13" y2="17"></line>
                </svg>
                <h3 class="middle-card-title">Kelengkapan Data Asuransi</h3>
            </div>
            <div class="kelengkapan-split-grid">
                <div class="kelengkapan-box kelengkapan-terisi">
                    <div class="kelengkapan-num">{{ number_format($kelengkapan['sudah_terisi'] ?? 0) }}</div>
                    <div class="kelengkapan-sub-title">Sudah Terisi</div>
                    <div class="kelengkapan-sub-desc">Kendaraan dengan data asuransi tercatat</div>
                </div>
                <div class="kelengkapan-box kelengkapan-belum">
                    <div class="kelengkapan-num">{{ number_format($kelengkapan['belum_terisi'] ?? 0) }}</div>
                    <div class="kelengkapan-sub-title">Belum Terisi</div>
                    <div class="kelengkapan-sub-desc">Target follow-up &mdash; belum ada data asuransi</div>
                </div>
            </div>
        </div>

        {{-- Card 2: Status Follow-Up Asuransi --}}
        <div class="middle-stat-card">
            <div class="middle-card-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                </svg>
                <h3 class="middle-card-title">Status Follow-Up Asuransi</h3>
            </div>
            <div class="followup-stats-row">
                <div class="fu-stat-item">
                    <div class="fu-stat-num text-blue">{{ number_format($statusFu['open'] ?? 0) }}</div>
                    <div class="fu-stat-label">Open</div>
                </div>
                <div class="fu-stat-item">
                    <div class="fu-stat-num text-red">{{ number_format($statusFu['overdue'] ?? 0) }}</div>
                    <div class="fu-stat-label">Overdue</div>
                </div>
                <div class="fu-stat-item">
                    <div class="fu-stat-num text-green">{{ number_format($statusFu['berhasil'] ?? 0) }}</div>
                    <div class="fu-stat-label">Berhasil (bulan ini)</div>
                </div>
            </div>
            <div class="followup-link-footer">
                <a href="{{ route('asuransi.follow_up') }}" class="link-see-all-fu">
                    <span>&rarr; Lihat Semua Follow-Up</span>
                </a>
            </div>
        </div>
    </div>

    {{-- 4. THIRD ROW: 3 VISUAL CHARTS --}}
    <div class="charts-row-grid-3">
        {{-- Chart 1: Jenis Asuransi Aktif --}}
        <div class="dashboard-chart-card">
            <div class="chart-card-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                <h4 class="chart-card-title">Jenis Asuransi Aktif</h4>
            </div>
            <div class="chart-canvas-wrapper" style="height: 200px;">
                <canvas id="chartJenisAsuransi"></canvas>
            </div>
            <div class="chart-donut-legend">
                <div class="legend-item"><span class="legend-dot" style="background: #3b82f6;"></span><span>COMP</span></div>
                <div class="legend-item"><span class="legend-dot" style="background: #f59e0b;"></span><span>TLO</span></div>
            </div>
        </div>

        {{-- Chart 2: Top Perusahaan Asuransi --}}
        <div class="dashboard-chart-card">
            <div class="chart-card-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 21h18"></path>
                    <path d="M5 21V7l8-4v18"></path>
                    <path d="M19 21V11l-6-4"></path>
                </svg>
                <h4 class="chart-card-title">Top Perusahaan Asuransi</h4>
            </div>
            <div class="chart-canvas-wrapper" style="height: 220px;">
                <canvas id="chartTopPerusahaan"></canvas>
            </div>
        </div>

        {{-- Chart 3: Expiry 12 Bulan ke Depan --}}
        <div class="dashboard-chart-card">
            <div class="chart-card-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                <h4 class="chart-card-title">Expiry 12 Bulan ke Depan</h4>
            </div>
            <div class="chart-canvas-wrapper" style="height: 220px;">
                <canvas id="chartExpiry12Bulan"></canvas>
            </div>
        </div>
    </div>

    {{-- 5. FOURTH ROW: AGING + TREN + KONVERSI --}}
    <div class="charts-row-grid-3" style="margin-top: 20px;">
        {{-- Chart 4: Aging Kendaraan Tanpa Asuransi --}}
        <div class="dashboard-chart-card">
            <div class="chart-card-header" style="flex-direction: column; align-items: flex-start; gap: 2px;">
                <div style="display: flex; align-items: center; gap: 6px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <h4 class="chart-card-title">Aging Kendaraan Tanpa Asuransi</h4>
                </div>
                <p class="chart-sub-text">Berdasarkan selisih bulan sejak DO &mdash; kendaraan yang belum ada data asuransi aktif</p>
            </div>
            <div class="chart-canvas-wrapper" style="height: 190px;">
                <canvas id="chartAgingTanpaAsuransi"></canvas>
            </div>
        </div>

        {{-- Chart 5: Tren Registrasi Asuransi (12 Bulan) --}}
        <div class="dashboard-chart-card">
            <div class="chart-card-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                    <polyline points="17 6 23 6 23 12"></polyline>
                </svg>
                <h4 class="chart-card-title">Tren Registrasi Asuransi (12 Bulan)</h4>
            </div>
            <div class="chart-canvas-wrapper" style="height: 220px;">
                <canvas id="chartTrenRegistrasi"></canvas>
            </div>
        </div>

        {{-- Box 6: Konversi Follow-Up --}}
        <div class="dashboard-chart-card">
            <div class="chart-card-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                </svg>
                <h4 class="chart-card-title">Konversi Follow-Up</h4>
            </div>
            <div class="konversi-box-body">
                <div class="konversi-grid-4">
                    <div class="konversi-item">
                        <div class="konversi-val">{{ number_format($konversiFu['total_task'] ?? 0) }}</div>
                        <div class="konversi-lbl">Total Task</div>
                    </div>
                    <div class="konversi-item">
                        <div class="konversi-val text-blue">{{ number_format($konversiFu['open'] ?? 0) }}</div>
                        <div class="konversi-lbl">Open</div>
                    </div>
                    <div class="konversi-item">
                        <div class="konversi-val text-green">{{ number_format($konversiFu['berhasil'] ?? 0) }}</div>
                        <div class="konversi-lbl">Berhasil</div>
                    </div>
                    <div class="konversi-item">
                        <div class="konversi-val text-muted">{{ number_format($konversiFu['tidak_berlanjut'] ?? 0) }}</div>
                        <div class="konversi-lbl">Tidak Berlanjut</div>
                    </div>
                </div>

                <div class="konversi-progress-section">
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" style="width: 0%;"></div>
                    </div>
                    <div class="conversion-rate-text">Conversion Rate: {{ $konversiFu['rate'] ?? '0.0%' }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- 6. FIFTH ROW: TOP MODEL TANPA ASURANSI & COVERAGE PER SALES --}}
    <div class="charts-row-grid-2" style="margin-top: 20px;">
        {{-- Chart 7: Top Model Tanpa Asuransi --}}
        <div class="dashboard-chart-card">
            <div class="chart-card-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9C2.1 11.2 2 11.6 2 12v4c0 .6.4 1 1 1h2"></path>
                    <circle cx="7" cy="17" r="2"></circle>
                    <path d="M9 17h6"></path>
                    <circle cx="17" cy="17" r="2"></circle>
                </svg>
                <h4 class="chart-card-title">Top Model Tanpa Asuransi</h4>
            </div>
            <div class="chart-canvas-wrapper" style="height: 320px;">
                <canvas id="chartTopModelTanpaAsuransi"></canvas>
            </div>
        </div>

        {{-- Chart 8: Coverage Asuransi per Sales --}}
        <div class="dashboard-chart-card">
            <div class="chart-card-header">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <h4 class="chart-card-title">Coverage Asuransi per Sales</h4>
            </div>
            <div class="chart-canvas-wrapper" style="height: 320px;">
                <canvas id="chartCoverageSales"></canvas>
            </div>
            <div class="chart-donut-legend" style="margin-top: 8px;">
                <div class="legend-item"><span class="legend-dot" style="background: #10b981;"></span><span>Sudah Asuransi</span></div>
                <div class="legend-item"><span class="legend-dot" style="background: #94a3b8;"></span><span>Belum Asuransi</span></div>
            </div>
        </div>
    </div>

    {{-- 7. SIXTH ROW: TABLE 10 ASURANSI TERDEKAT HABIS --}}
    <div class="table-card-wrapper" style="margin-top: 20px;">
        <div class="table-subtoolbar">
            <div class="toolbar-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                <span>10 Asuransi Terdekat Habis</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="terdekat-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th style="min-width: 170px;">VIN</th>
                        <th style="min-width: 140px;">Model</th>
                        <th style="min-width: 180px;">Konsumen</th>
                        <th style="min-width: 100px;">Jenis</th>
                        <th style="min-width: 140px;">Asuransi</th>
                        <th style="min-width: 120px;">Tgl Habis</th>
                        <th style="min-width: 100px;">Sisa Hari</th>
                        <th style="min-width: 100px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($terdekatHabisList as $index => $item)
                    <tr>
                        <td class="text-muted">{{ $index + 1 }}</td>
                        <td class="font-mono font-bold">{{ $item['vin'] }}</td>
                        <td>{{ $item['model'] ?? '-' }}</td>
                        <td class="font-bold">{{ $item['nama_konsumen'] ?? '-' }}</td>
                        <td>
                            @if(($item['jenis'] ?? 'COMP') === 'COMP')
                                <span class="badge-jenis-comp">COMP</span>
                            @else
                                <span class="badge-jenis-tlo">TLO</span>
                            @endif
                        </td>
                        <td>{{ $item['asuransi'] ?? '-' }}</td>
                        <td>{{ $item['tgl_habis'] ?? '-' }}</td>
                        <td>
                            @php
                                $sisa = $item['sisa_hari'] ?? 0;
                                $badgeClass = $sisa <= 30 ? 'badge-sisa-red' : ($sisa <= 60 ? 'badge-sisa-amber' : 'badge-sisa-green');
                            @endphp
                            <span class="{{ $badgeClass }}">{{ $sisa }}</span>
                        </td>
                        <td>
                            <span class="badge-status-aktif">Aktif</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="empty-state-row">
                            <div class="empty-state-content">
                                <div class="empty-icon-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline>
                                        <path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path>
                                    </svg>
                                </div>
                                <p class="empty-text">Tidak ada data asuransi terdekat habis</p>
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
    /* Container */
    .asuransi-dashboard-container {
        padding: 24px 28px 40px 28px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        color: #1e293b;
        box-sizing: border-box;
    }

    /* Header */
    .page-header-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
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
        margin: 0 0 6px 0;
    }
    .period-badge-sub {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11.5px;
        color: #64748b;
        font-weight: 500;
    }

    /* Action Top Right */
    .header-action-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .period-filter-form {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .input-period-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    .input-period-control {
        height: 36px;
        padding: 6px 32px 6px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 12.5px;
        color: #1e293b;
        outline: none;
        width: 160px;
    }
    .input-period-control:focus {
        border-color: #dc2626;
    }
    .calendar-icon {
        position: absolute;
        right: 10px;
        color: #94a3b8;
        pointer-events: none;
    }
    .btn-tampilkan {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        height: 36px;
        padding: 0 16px;
        border-radius: 8px;
        border: none;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #ffffff;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.25);
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
    }

    /* 6 KPI Cards Grid */
    .kpi-cards-grid-6 {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 12px;
        margin-bottom: 20px;
    }
    @media (max-width: 1200px) {
        .kpi-cards-grid-6 { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 600px) {
        .kpi-cards-grid-6 { grid-template-columns: 1fr; }
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
    .kpi-icon-amber { background: #fffbeb; color: #d97706; }
    .kpi-icon-red { background: #fef2f2; color: #dc2626; }
    .kpi-icon-slate { background: #f1f5f9; color: #475569; }
    .kpi-icon-purple { background: #f5f3ff; color: #7c3aed; }

    .kpi-info { display: flex; flex-direction: column; }
    .kpi-val { font-size: 20px; font-weight: 800; color: #0f172a; line-height: 1.1; }
    .kpi-lbl { font-size: 11px; font-weight: 600; color: #64748b; margin-top: 3px; }
    .kpi-sub-detail { font-size: 10px; color: #94a3b8; margin-top: 2px; }
    .info-dot { font-size: 10px; color: #94a3b8; }

    .text-green { color: #16a34a !important; }
    .text-amber { color: #d97706 !important; }
    .text-red { color: #dc2626 !important; }
    .text-blue { color: #2563eb !important; }
    .text-purple { color: #7c3aed !important; }
    .text-muted { color: #94a3b8; }
    .font-bold { font-weight: 700; }
    .font-mono { font-family: 'JetBrains Mono', monospace; font-size: 12px; }

    /* Middle 2 Cards Grid */
    .middle-cards-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 20px;
    }
    @media (max-width: 900px) {
        .middle-cards-grid-2 { grid-template-columns: 1fr; }
    }
    .middle-stat-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 16px 20px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .middle-card-header {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 14px;
        color: #475569;
    }
    .middle-card-title {
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .kelengkapan-split-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }
    .kelengkapan-box {
        padding: 14px 16px;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .kelengkapan-terisi {
        background: #eff6ff;
        border: 1px solid #dbeafe;
    }
    .kelengkapan-terisi .kelengkapan-num { color: #1d4ed8; }
    .kelengkapan-belum {
        background: #fff7ed;
        border: 1px solid #ffedd5;
    }
    .kelengkapan-belum .kelengkapan-num { color: #c2410c; }
    .kelengkapan-num {
        font-size: 26px;
        font-weight: 800;
        line-height: 1.1;
    }
    .kelengkapan-sub-title {
        font-size: 12px;
        font-weight: 700;
        color: #334155;
        margin-top: 4px;
    }
    .kelengkapan-sub-desc {
        font-size: 10.5px;
        color: #64748b;
        margin-top: 2px;
    }

    .followup-stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        text-align: center;
        margin-bottom: 14px;
    }
    .fu-stat-num {
        font-size: 26px;
        font-weight: 800;
        line-height: 1.1;
    }
    .fu-stat-label {
        font-size: 11.5px;
        font-weight: 600;
        color: #64748b;
        margin-top: 4px;
    }
    .followup-link-footer {
        padding-top: 10px;
        border-top: 1px solid #f1f5f9;
    }
    .link-see-all-fu {
        font-size: 12.5px;
        font-weight: 700;
        color: #dc2626;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: color 0.15s ease;
    }
    .link-see-all-fu:hover {
        color: #b91c1c;
        text-decoration: underline;
    }

    /* 3 Charts Grid */
    .charts-row-grid-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1.3fr;
        gap: 16px;
    }
    @media (max-width: 1100px) {
        .charts-row-grid-3 { grid-template-columns: 1fr; }
    }
    .charts-row-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 16px;
    }
    @media (max-width: 1000px) {
        .charts-row-grid-2 { grid-template-columns: 1fr; }
    }

    .dashboard-chart-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 16px 18px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
        display: flex;
        flex-direction: column;
        position: relative;
    }
    .chart-card-header {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 12px;
        color: #475569;
    }
    .chart-card-title {
        font-size: 13px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }
    .chart-sub-text {
        font-size: 11px;
        color: #64748b;
        margin: 0;
    }
    .chart-canvas-wrapper {
        position: relative;
        width: 100%;
    }
    .chart-donut-legend {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 16px;
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

    /* Konversi Box */
    .konversi-box-body {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-top: 10px;
    }
    .konversi-grid-4 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }
    .konversi-item {
        background: #f8fafc;
        border-radius: 8px;
        padding: 12px 14px;
        border: 1px solid #f1f5f9;
        text-align: center;
    }
    .konversi-val { font-size: 20px; font-weight: 800; color: #0f172a; }
    .konversi-lbl { font-size: 11px; font-weight: 600; color: #64748b; margin-top: 2px; }

    .konversi-progress-section {
        margin-top: 6px;
    }
    .progress-bar-bg {
        width: 100%;
        height: 8px;
        border-radius: 99px;
        background: #f1f5f9;
        overflow: hidden;
    }
    .progress-bar-fill {
        height: 100%;
        background: #10b981;
        border-radius: 99px;
    }
    .conversion-rate-text {
        font-size: 11.5px;
        font-weight: 700;
        color: #475569;
        text-align: right;
        margin-top: 6px;
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
    .terdekat-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 12.5px;
    }
    .terdekat-table thead th {
        background: #ffffff;
        color: #475569;
        font-weight: 700;
        font-size: 12px;
        padding: 12px 14px;
        border-bottom: 1.5px solid #e2e8f0;
        white-space: nowrap;
    }
    .terdekat-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s ease;
    }
    .terdekat-table tbody tr:hover {
        background-color: #f8fafc;
    }
    .terdekat-table tbody td {
        padding: 12px 14px;
        color: #334155;
        vertical-align: middle;
    }

    /* Badges */
    .badge-jenis-comp {
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 4px;
    }
    .badge-jenis-tlo {
        background: #fff1f2;
        color: #e11d48;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 4px;
    }
    .badge-sisa-green {
        background: #f0fdf4;
        color: #16a34a;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 4px;
    }
    .badge-sisa-amber {
        background: #fffbeb;
        color: #d97706;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 4px;
    }
    .badge-sisa-red {
        background: #fef2f2;
        color: #dc2626;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 4px;
    }
    .badge-status-aktif {
        background: #dcfce7;
        color: #15803d;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 4px;
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
        // 1. Chart Jenis Asuransi Aktif (Donut)
        const ctxJenis = document.getElementById('chartJenisAsuransi');
        if (ctxJenis) {
            const comp = {{ $jenisAsuransi['comp'] ?? 0 }};
            const tlo = {{ $jenisAsuransi['tlo'] ?? 0 }};
            const sumJenis = comp + tlo;
            new Chart(ctxJenis, {
                type: 'doughnut',
                data: {
                    labels: sumJenis > 0 ? ['COMP', 'TLO'] : ['Belum ada data'],
                    datasets: [{
                        data: sumJenis > 0 ? [comp, tlo] : [1],
                        backgroundColor: sumJenis > 0 ? ['#3b82f6', '#f59e0b'] : ['#f1f5f9'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }

        // 2. Chart Top Perusahaan Asuransi (Horizontal Bar)
        const ctxPerusahaan = document.getElementById('chartTopPerusahaan');
        if (ctxPerusahaan) {
            new Chart(ctxPerusahaan, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($topPerusahaan['labels'] ?? []) !!},
                    datasets: [{
                        data: {!! json_encode($topPerusahaan['data'] ?? []) !!},
                        backgroundColor: '#6366f1',
                        borderRadius: 4,
                        barThickness: 14
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            max: 300,
                            grid: { color: '#f1f5f9' },
                            ticks: { font: { size: 10 } }
                        },
                        y: {
                            grid: { display: false },
                            ticks: { font: { size: 10 } }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }

        // 3. Chart Expiry 12 Bulan ke Depan (Vertical Bar)
        const ctxExpiry = document.getElementById('chartExpiry12Bulan');
        if (ctxExpiry) {
            new Chart(ctxExpiry, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($expiry12Bulan['labels'] ?? []) !!},
                    datasets: [{
                        data: {!! json_encode($expiry12Bulan['data'] ?? []) !!},
                        backgroundColor: '#ef4444',
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 9 }, maxRotation: 45 }
                        },
                        y: {
                            beginAtZero: true,
                            max: 60,
                            grid: { color: '#f1f5f9' },
                            ticks: { font: { size: 10 } }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }

        // 4. Chart Aging Kendaraan Tanpa Asuransi (Horizontal Bar)
        const ctxAging = document.getElementById('chartAgingTanpaAsuransi');
        if (ctxAging) {
            new Chart(ctxAging, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($agingTanpaAsuransi['labels'] ?? []) !!},
                    datasets: [{
                        data: {!! json_encode($agingTanpaAsuransi['data'] ?? []) !!},
                        backgroundColor: ['#ef4444', '#f59e0b', '#eab308', '#10b981'],
                        borderRadius: 4,
                        barThickness: 16
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            max: 3500,
                            grid: { color: '#f1f5f9' },
                            ticks: { font: { size: 9 } }
                        },
                        y: {
                            grid: { display: false },
                            ticks: { font: { size: 10 } }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }

        // 5. Chart Tren Registrasi Asuransi 12 Bulan (Line)
        const ctxTren = document.getElementById('chartTrenRegistrasi');
        if (ctxTren) {
            new Chart(ctxTren, {
                type: 'line',
                data: {
                    labels: {!! json_encode($trenRegistrasi['labels'] ?? []) !!},
                    datasets: [{
                        data: {!! json_encode($trenRegistrasi['data'] ?? []) !!},
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 3,
                        pointBackgroundColor: '#3b82f6'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 9 }, maxRotation: 45 }
                        },
                        y: {
                            beginAtZero: true,
                            max: 500,
                            grid: { color: '#f1f5f9' },
                            ticks: { font: { size: 10 } }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }

        // 6. Chart Top Model Tanpa Asuransi (Horizontal Bar)
        const ctxModel = document.getElementById('chartTopModelTanpaAsuransi');
        if (ctxModel) {
            new Chart(ctxModel, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($topModelTanpaAsuransi['labels'] ?? []) !!},
                    datasets: [{
                        data: {!! json_encode($topModelTanpaAsuransi['data'] ?? []) !!},
                        backgroundColor: '#f97316',
                        borderRadius: 4,
                        barThickness: 14
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            max: 1000,
                            grid: { color: '#f1f5f9' },
                            ticks: { font: { size: 10 } }
                        },
                        y: {
                            grid: { display: false },
                            ticks: { font: { size: 10.5 } }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }

        // 7. Chart Coverage Asuransi per Sales (Stacked Bar)
        const ctxSales = document.getElementById('chartCoverageSales');
        if (ctxSales) {
            new Chart(ctxSales, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($coverageSales['labels'] ?? []) !!},
                    datasets: [
                        {
                            label: 'Sudah Asuransi',
                            data: {!! json_encode($coverageSales['sudah'] ?? []) !!},
                            backgroundColor: '#10b981',
                            borderRadius: 3,
                            barThickness: 14
                        },
                        {
                            label: 'Belum Asuransi',
                            data: {!! json_encode($coverageSales['belum'] ?? []) !!},
                            backgroundColor: '#94a3b8',
                            borderRadius: 3,
                            barThickness: 14
                        }
                    ]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true,
                            beginAtZero: true,
                            max: 1200,
                            grid: { color: '#f1f5f9' },
                            ticks: { font: { size: 10 } }
                        },
                        y: {
                            stacked: true,
                            grid: { display: false },
                            ticks: { font: { size: 9.5 } }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }
    });
</script>
@endsection
