@extends('layouts.app')

@section('title', 'Customer List - Database Konsumen')

@section('content')
<div class="customer-list-container">
    {{-- 1. HEADER SECTION --}}
    <div class="page-header-row">
        <div class="header-text-group">
            <h1 class="page-title">Customer List</h1>
            <p class="page-subtitle">Database dari SDMS</p>
        </div>
        <div class="header-action-group">
            <button type="button" class="btn-export-excel" id="btnExportExcel">
                <svg class="export-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="8" y1="13" x2="16" y2="13"></line>
                    <line x1="8" y1="17" x2="16" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                <span>Export Excel</span>
            </button>
        </div>
    </div>

    {{-- 2. METRIC SUMMARY STRIP --}}
    <div class="metrics-grid">
        {{-- Card 1: Konsumen Unik --}}
        <div class="metric-card card-accent-red">
            <div class="metric-val">{{ number_format($metrics['konsumen_unik'] ?? 0, 0, ',', '.') }}</div>
            <div class="metric-lbl">
                <span>Konsumen Unik</span>
                <span class="info-icon" title="Jumlah total konsumen unik yang terdata di gnMstCustomer">ⓘ</span>
            </div>
        </div>

        {{-- Card 2: Duplikat Tergabung --}}
        <div class="metric-card card-accent-slate">
            <div class="metric-val">{{ number_format($metrics['duplikat_tergabung'] ?? 0, 0, ',', '.') }}</div>
            <div class="metric-lbl">
                <span>Duplikat Tergabung</span>
                <span class="info-icon" title="Data transaksi NIK/Nama ganda yang digabungkan">ⓘ</span>
            </div>
        </div>

        {{-- Card 3: Hanya Penjualan --}}
        <div class="metric-card card-accent-blue">
            <div class="metric-val">{{ number_format($metrics['hanya_penjualan'] ?? 0, 0, ',', '.') }}</div>
            <div class="metric-lbl">
                <span>Hanya Penjualan</span>
                <span class="info-icon" title="Unit dibeli di dealer tapi belum pernah tercatat service">ⓘ</span>
            </div>
        </div>

        {{-- Card 4: Hanya Service --}}
        <div class="metric-card card-accent-orange">
            <div class="metric-val">{{ number_format($metrics['hanya_service'] ?? 0, 0, ',', '.') }}</div>
            <div class="metric-lbl">
                <span>Hanya Service</span>
                <span class="info-icon" title="Kendaraan luar yang hanya melakukan perawatan service di bengkel">ⓘ</span>
            </div>
        </div>

        {{-- Card 5: Penjualan & Service --}}
        <div class="metric-card card-accent-green">
            <div class="metric-val">{{ number_format($metrics['penjualan_service'] ?? 0, 0, ',', '.') }}</div>
            <div class="metric-lbl">
                <span>Penjualan & Service</span>
                <span class="info-icon" title="Unit dibeli di dealer dan aktif melakukan perawatan berkala">ⓘ</span>
            </div>
        </div>

        {{-- Card 6: Hanya Database --}}
        <div class="metric-card card-accent-gray">
            <div class="metric-val">{{ number_format($metrics['hanya_database'] ?? 0, 0, ',', '.') }}</div>
            <div class="metric-lbl">
                <span>Hanya Database</span>
                <span class="info-icon" title="Master kontak customer tanpa riwayat transaksi unit maupun service">ⓘ</span>
            </div>
        </div>

        {{-- Card 7: Total Kendaraan --}}
        <div class="metric-card card-accent-teal">
            <div class="metric-val">{{ number_format($metrics['total_kendaraan'] ?? 0, 0, ',', '.') }}</div>
            <div class="metric-lbl">
                <span>Total Kendaraan</span>
                <span class="info-icon" title="Jumlah total kendaraan yang terdaftar di database service">ⓘ</span>
            </div>
        </div>
    </div>

    {{-- 3. FILTER & SEARCH CARD --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('customer.list') }}" id="filterForm">
            <div class="filter-grid">
                {{-- Input Cari --}}
                <div class="filter-item filter-search">
                    <label class="filter-label">Cari (Nama / NIK / HP / Email)</label>
                    <div class="search-input-wrapper">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Ketik untuk mencari..." class="input-control">
                        <svg class="search-icon-inside" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                </div>

                {{-- Tipe --}}
                <div class="filter-item">
                    <label class="filter-label">Tipe</label>
                    <select name="tipe" class="select-control">
                        <option value="">Semua</option>
                        <option value="Personal" {{ request('tipe') == 'Personal' ? 'selected' : '' }}>Personal</option>
                        <option value="Institusi" {{ request('tipe') == 'Institusi' ? 'selected' : '' }}>Institusi</option>
                    </select>
                </div>

                {{-- Status NIK --}}
                <div class="filter-item">
                    <label class="filter-label">Status NIK</label>
                    <select name="status_nik" class="select-control">
                        <option value="">Semua</option>
                        <option value="Valid" {{ request('status_nik') == 'Valid' ? 'selected' : '' }}>Valid</option>
                        <option value="Invalid" {{ request('status_nik') == 'Invalid' ? 'selected' : '' }}>Invalid</option>
                        <option value="Kosong" {{ request('status_nik') == 'Kosong' ? 'selected' : '' }}>Kosong</option>
                    </select>
                </div>

                {{-- Kendaraan --}}
                <div class="filter-item">
                    <label class="filter-label">Kendaraan</label>
                    <select name="kendaraan" class="select-control">
                        <option value="">Semua</option>
                        <option value="Punya Kendaraan" {{ request('kendaraan') == 'Punya Kendaraan' ? 'selected' : '' }}>Punya Kendaraan</option>
                        <option value="Tidak Ada" {{ request('kendaraan') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                    </select>
                </div>

                {{-- Sumber Data --}}
                <div class="filter-item">
                    <label class="filter-label">Sumber Data</label>
                    <select name="sumber_data" class="select-control">
                        <option value="">Semua</option>
                        <option value="Penjualan" {{ request('sumber_data') == 'Penjualan' ? 'selected' : '' }}>Penjualan</option>
                        <option value="Hanya Penjualan" {{ request('sumber_data') == 'Hanya Penjualan' ? 'selected' : '' }}>Hanya Penjualan</option>
                        <option value="Hanya Service" {{ request('sumber_data') == 'Hanya Service' ? 'selected' : '' }}>Hanya Service</option>
                        <option value="Penjualan & Service" {{ request('sumber_data') == 'Penjualan & Service' ? 'selected' : '' }}>Penjualan & Service</option>
                        <option value="Hanya Database" {{ request('sumber_data') == 'Hanya Database' ? 'selected' : '' }}>Hanya Database</option>
                    </select>
                </div>

                {{-- Toggle Duplikat --}}
                <div class="filter-item filter-toggle-box">
                    <label class="filter-label">Tampilkan Duplikat</label>
                    <label class="switch-ui">
                        <input type="checkbox" name="show_duplicates" value="1" {{ request('show_duplicates') ? 'checked' : '' }} onchange="document.getElementById('filterForm').submit()">
                        <span class="slider-ui round"></span>
                    </label>
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

    {{-- 4. TABLE SECTION --}}
    <div class="table-card-wrapper">
        {{-- Toolbar Subheader --}}
        <div class="table-subtoolbar">
            <div class="customer-count-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span>{{ number_format($customers instanceof \Illuminate\Pagination\AbstractPaginator ? $customers->total() : count($customers), 0, ',', '.') }} customer</span>
            </div>
            <div>
                <a href="{{ route('customer.list') }}" class="btn-refresh-icon" title="Reset / Refresh Filter">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="23 4 23 10 17 10"></polyline>
                        <polyline points="1 20 1 14 7 14"></polyline>
                        <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                    </svg>
                </a>
            </div>
        </div>

        {{-- Data Table --}}
        <div class="table-responsive">
            <table class="customer-table">
                <thead>
                    <tr>
                        <th style="min-width: 190px;">Nama</th>
                        <th style="min-width: 100px;">Tipe</th>
                        <th style="min-width: 170px;">NIK</th>
                        <th style="min-width: 130px;">HP</th>
                        <th style="min-width: 190px;">Email</th>
                        <th style="min-width: 95px; text-align: center;">Kendaraan</th>
                        <th style="min-width: 135px;">Transaksi Terakhir</th>
                        <th style="min-width: 130px;">Service Terakhir</th>
                        <th style="min-width: 160px;">Sumber Data</th>
                        <th style="min-width: 100px; text-align: center;">Flag</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $c)
                    <tr>
                        <td>
                            <div class="cell-nama">
                                <span class="customer-name-text">{{ $c['nama'] }}</span>
                                @if(!empty($c['is_duplicate']) && $c['is_duplicate'])
                                    <div class="custom-tooltip-wrapper">
                                        <span class="badge-duplicate-child">Duplikat</span>
                                        <div class="custom-tooltip">Sudah digabungkan ke master #{{ $c['master_id'] ?? '' }}</div>
                                    </div>
                                @elseif(!empty($c['duplicate_count']) && $c['duplicate_count'] > 1)
                                    <div class="custom-tooltip-wrapper">
                                        <span class="badge-duplicate-master">{{ $c['duplicate_count'] }} data</span>
                                        <div class="custom-tooltip">Master dari {{ $c['duplicate_count'] - 1 }} record duplikat</div>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="badge-tipe {{ strtolower($c['tipe']) == 'institusi' ? 'badge-institusi' : 'badge-personal' }}">
                                {{ $c['tipe'] }}
                            </span>
                        </td>
                        <td>
                            <div class="cell-nik">
                                <span>{{ $c['nik'] }}</span>
                                @if(!empty($c['nik']) && $c['nik'] !== '-')
                                    @if($c['nik_valid'])
                                        <span class="badge-valid">valid</span>
                                    @else
                                        <span class="badge-invalid">invalid</span>
                                    @endif
                                @endif
                            </div>
                        </td>
                        <td>{{ $c['hp'] }}</td>
                        <td>
                            <span class="cell-email">{{ $c['email'] ?: '-' }}</span>
                        </td>
                        <td style="text-align: center;">
                            <span class="badge-kendaraan">{{ $c['kendaraan'] }}</span>
                        </td>
                        <td>{{ $c['transaksi_terakhir'] }}</td>
                        <td>{{ $c['service_terakhir'] }}</td>
                        <td>
                            @php
                                $sumberClass = 'badge-sumber-penjualan';
                                if ($c['sumber_data'] === 'Penjualan & Service') $sumberClass = 'badge-sumber-both';
                                elseif ($c['sumber_data'] === 'Hanya Service') $sumberClass = 'badge-sumber-service';
                                elseif ($c['sumber_data'] === 'Hanya Database') $sumberClass = 'badge-sumber-db';
                            @endphp
                            <span class="badge-sumber {{ $sumberClass }}">
                                {{ $c['sumber_data'] }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            @if(!empty($c['flag']) && $c['flag'] !== '-')
                                <span class="badge-flag-ktp-invalid">{{ $c['flag'] }}</span>
                            @else
                                <span style="color: #cbd5e1;">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center" style="padding: 40px; color: #94a3b8;">
                            Belum ada data customer ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 5. PAGINATION FOOTER --}}
        @if($customers instanceof \Illuminate\Pagination\AbstractPaginator && $customers->hasPages())
        <div class="table-pagination-footer">
            <div class="pagination-controls">
                {{-- First & Prev --}}
                @if($customers->currentPage() > 1)
                    <a href="{{ $customers->url(1) }}" class="btn-page" title="Halaman Pertama">«</a>
                    <a href="{{ $customers->previousPageUrl() }}" class="btn-page" title="Sebelumnya">‹</a>
                @else
                    <button type="button" class="btn-page btn-disabled" disabled>«</button>
                    <button type="button" class="btn-page btn-disabled" disabled>‹</button>
                @endif

                {{-- Page Window --}}
                @php
                    $start = max(1, $customers->currentPage() - 2);
                    $end = min($customers->lastPage(), $customers->currentPage() + 2);
                @endphp

                @for($p = $start; $p <= $end; $p++)
                    @if($p == $customers->currentPage())
                        <button type="button" class="btn-page btn-page-active">{{ $p }}</button>
                    @else
                        <a href="{{ $customers->url($p) }}" class="btn-page">{{ $p }}</a>
                    @endif
                @endfor

                {{-- Next & Last --}}
                @if($customers->hasMorePages())
                    <a href="{{ $customers->nextPageUrl() }}" class="btn-page" title="Selanjutnya">›</a>
                    <a href="{{ $customers->url($customers->lastPage()) }}" class="btn-page" title="Halaman Terakhir">»</a>
                @else
                    <button type="button" class="btn-page btn-disabled" disabled>›</button>
                    <button type="button" class="btn-page btn-disabled" disabled>»</button>
                @endif
            </div>

            <div class="pagination-rows-select">
                <select class="select-page-rows" onchange="window.location.href='{{ request()->fullUrlWithQuery(['page' => 1]) }}' + '&per_page=' + this.value">
                    <option value="50" {{ request('per_page', 50) == 50 ? 'selected' : '' }}>50 / halaman</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 / halaman</option>
                    <option value="200" {{ request('per_page') == 200 ? 'selected' : '' }}>200 / halaman</option>
                </select>
            </div>
        </div>
        @endif
    </div>

    {{-- MODAL EXPORT DATABASE KONSUMEN --}}
    <div class="export-modal-overlay" id="exportModalOverlay" style="display: none;">
        <div class="export-modal-card">
            {{-- Modal Header --}}
            <div class="export-modal-header">
                <h3 class="export-modal-title">Export Database Konsumen</h3>
                <button type="button" class="export-modal-close" id="btnCloseExportModal" title="Tutup">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <form id="exportFormModal" method="GET" action="{{ route('customer.list.export') }}">
                {{-- Hidden input filter dari halaman --}}
                <input type="hidden" name="q" id="exportHiddenQ" value="{{ request('q') }}">
                <input type="hidden" name="tipe" id="exportHiddenTipe" value="{{ request('tipe') }}">
                <input type="hidden" name="status_nik" id="exportHiddenStatusNik" value="{{ request('status_nik') }}">
                <input type="hidden" name="kendaraan" id="exportHiddenKendaraan" value="{{ request('kendaraan') }}">

                <div class="export-modal-body">
                    {{-- Section 1: Kategori Sumber Data --}}
                    <div class="export-section">
                        <label class="export-section-label">Kategori Sumber Data (pilih satu atau lebih)</label>
                        <div class="export-checkbox-group">
                            <label class="export-check-item">
                                <input type="checkbox" name="kategori_sumber[]" value="Penjualan" class="custom-checkbox">
                                <span>Hanya Penjualan</span>
                            </label>
                            <label class="export-check-item">
                                <input type="checkbox" name="kategori_sumber[]" value="Hanya Service" class="custom-checkbox">
                                <span>Hanya Service</span>
                            </label>
                            <label class="export-check-item">
                                <input type="checkbox" name="kategori_sumber[]" value="Penjualan & Service" class="custom-checkbox">
                                <span>Penjualan & Service</span>
                            </label>
                            <label class="export-check-item">
                                <input type="checkbox" name="kategori_sumber[]" value="Hanya Database" class="custom-checkbox">
                                <span>Hanya Database</span>
                            </label>
                        </div>
                        <div class="export-hint-text">Tidak ada yang dicentang = semua kategori</div>
                    </div>

                    {{-- Section 2: Status Review Duplikat --}}
                    <div class="export-section">
                        <label class="export-section-label">Status Review Duplikat</label>
                        <div class="export-radio-group">
                            <label class="export-radio-item">
                                <input type="radio" name="status_review" value="semua" checked class="custom-radio">
                                <span>Semua</span>
                            </label>
                            <label class="export-radio-item">
                                <input type="radio" name="status_review" value="bersih" class="custom-radio">
                                <span>Bersih (tanpa duplikat menunggu review)</span>
                            </label>
                            <label class="export-radio-item">
                                <input type="radio" name="status_review" value="menunggu_review" class="custom-radio">
                                <span>Menunggu review duplikat saja</span>
                            </label>
                        </div>

                        <div class="export-include-dup-box">
                            <label class="export-check-item">
                                <input type="checkbox" name="include_duplicates" id="modalIncludeDuplicates" value="1" class="custom-checkbox" checked>
                                <span>Sertakan record duplikat (yang sudah digabung ke master)</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="export-modal-footer">
                    <button type="button" class="btn-modal-cancel" id="btnCancelExportModal">Batal</button>
                    <button type="submit" class="btn-modal-download" id="btnModalSubmitDownload">
                        <svg class="download-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>
                        <span>Download Excel</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Global Container */
    .customer-list-container {
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
        margin-bottom: 24px;
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
    .btn-export-excel {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 18px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);
        transition: all 0.2s ease;
    }
    .btn-export-excel:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
    }

    /* Metric Cards Grid */
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 14px;
        margin-bottom: 20px;
    }
    .metric-card {
        background: #ffffff;
        border-radius: 10px;
        padding: 16px 14px 14px 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.03);
        position: relative;
        border-left-width: 4.5px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(15, 23, 42, 0.06);
    }
    .card-accent-red    { border-left-color: #dc2626; }
    .card-accent-slate  { border-left-color: #475569; }
    .card-accent-blue   { border-left-color: #2563eb; }
    .card-accent-orange { border-left-color: #f97316; }
    .card-accent-green  { border-left-color: #10b981; }
    .card-accent-gray   { border-left-color: #94a3b8; }
    .card-accent-teal   { border-left-color: #0d9488; }

    .metric-val {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 4px;
        letter-spacing: -0.4px;
    }
    .metric-lbl {
        font-size: 11.5px;
        font-weight: 600;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .info-icon {
        font-size: 11px;
        color: #94a3b8;
        cursor: help;
    }

    /* Filter Card */
    .filter-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 18px 20px;
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
        flex: 1 1 130px;
    }
    .filter-search {
        flex: 2 1 240px;
    }
    .filter-label {
        font-size: 11.5px;
        font-weight: 700;
        color: #475569;
        white-space: nowrap;
    }
    .search-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    .input-control, .select-control {
        width: 100%;
        height: 38px;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 13px;
        color: #1e293b;
        box-sizing: border-box;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
    }
    .search-input-wrapper input {
        padding-right: 32px;
    }
    .search-icon-inside {
        position: absolute;
        right: 10px;
        color: #94a3b8;
        pointer-events: none;
    }
    .input-control:focus, .select-control:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
    }
    .filter-toggle-box {
        flex: 0 0 auto;
        align-items: center;
    }
    .filter-btn-box {
        flex: 0 0 auto;
    }

    /* Switch UI */
    .switch-ui {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
        margin-top: 4px;
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

    /* Primary Search Button */
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
        box-shadow: 0 4px 10px rgba(220, 38, 38, 0.35);
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
    }
    .customer-count-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12.5px;
        font-weight: 700;
        color: #475569;
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

    /* Table Styling */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }
    .customer-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 12.5px;
    }
    .customer-table thead th {
        background: #ffffff;
        color: #475569;
        font-weight: 700;
        font-size: 12px;
        padding: 12px 14px;
        border-bottom: 1.5px solid #e2e8f0;
        white-space: nowrap;
        letter-spacing: 0.1px;
    }
    .customer-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s ease;
    }
    .customer-table tbody tr:hover {
        background-color: #f8fafc;
    }
    .customer-table tbody td {
        padding: 12px 14px;
        color: #334155;
        vertical-align: middle;
    }

    /* Cell Badges */
    .cell-nama {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }
    .customer-name-text {
        font-weight: 700;
        color: #0f172a;
    }

    /* Tooltip Bubble for Badges */
    .custom-tooltip-wrapper {
        position: relative;
        display: inline-flex;
        align-items: center;
        cursor: default;
    }
    .custom-tooltip {
        visibility: hidden;
        opacity: 0;
        position: absolute;
        bottom: calc(100% + 8px);
        left: 50%;
        transform: translateX(-50%);
        background-color: #1e293b;
        color: #ffffff;
        text-align: center;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 600;
        white-space: nowrap;
        z-index: 1000;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.25);
        transition: opacity 0.2s cubic-bezier(0.16, 1, 0.3, 1), transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.2s;
        pointer-events: none;
    }
    .custom-tooltip::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border-width: 5px;
        border-style: solid;
        border-color: #1e293b transparent transparent transparent;
    }
    .custom-tooltip-wrapper:hover .custom-tooltip {
        visibility: visible;
        opacity: 1;
        transform: translateX(-50%) translateY(-2px);
    }
    .badge-duplicate-master {
        font-size: 10.5px;
        font-weight: 700;
        background: #dbeafe;
        color: #1d4ed8;
        padding: 2px 7px;
        border-radius: 5px;
        display: inline-flex;
        align-items: center;
        line-height: 1.3;
    }
    .badge-duplicate-child {
        font-size: 10.5px;
        font-weight: 700;
        background: #ffedd5;
        color: #c2410c;
        padding: 2px 7px;
        border-radius: 5px;
        display: inline-flex;
        align-items: center;
        line-height: 1.3;
    }

    .badge-tipe {
        font-size: 11px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 6px;
        display: inline-block;
    }
    .badge-personal {
        background: #e0f2fe;
        color: #0369a1;
    }
    .badge-institusi {
        background: #f1f5f9;
        color: #475569;
    }
    .cell-nik {
        display: flex;
        align-items: center;
        gap: 6px;
        font-family: 'JetBrains Mono', 'Courier New', monospace;
        font-size: 12px;
    }
    .badge-valid {
        font-size: 9.5px;
        font-weight: 800;
        background: #dcfce7;
        color: #15803d;
        padding: 1px 5px;
        border-radius: 4px;
        font-family: 'Inter', sans-serif;
    }
    .badge-invalid {
        font-size: 9.5px;
        font-weight: 800;
        background: #fee2e2;
        color: #dc2626;
        padding: 1px 5px;
        border-radius: 4px;
        font-family: 'Inter', sans-serif;
    }
    .badge-flag-ktp-invalid {
        font-size: 10px;
        font-weight: 700;
        background: #ffedd5;
        color: #c2410c;
        padding: 3px 8px;
        border-radius: 4px;
        display: inline-block;
        white-space: nowrap;
    }
    .cell-email {
        color: #64748b;
    }
    .badge-kendaraan {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        background: #dcfce7;
        color: #166534;
        font-weight: 800;
        font-size: 11.5px;
        border-radius: 5px;
    }
    .badge-sumber {
        padding: 4px 9px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        display: inline-block;
        white-space: nowrap;
    }
    .badge-sumber-both {
        background: #dcfce7;
        color: #166534;
    }
    .badge-sumber-penjualan {
        background: #e0f2fe;
        color: #0369a1;
    }
    .badge-sumber-service {
        background: #ffedd5;
        color: #c2410c;
    }
    .badge-sumber-db {
        background: #f1f5f9;
        color: #475569;
    }
    .btn-disabled {
        opacity: 0.4;
        cursor: not-allowed !important;
        background: #f8fafc !important;
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
        text-decoration: none;
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
        color: #334155;
        background: #ffffff;
        outline: none;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin {
        animation: spin 1s linear infinite;
    }

    /* ===================================================
       EXPORT MODAL STYLES (MATCHING SCREENSHOT)
       =================================================== */
    .export-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(3px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 99999;
        padding: 16px;
        box-sizing: border-box;
        animation: fadeInModalBg 0.2s ease-out;
    }
    @keyframes fadeInModalBg {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .export-modal-card {
        background: #ffffff;
        border-radius: 14px;
        width: 100%;
        max-width: 480px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
        padding: 22px 24px;
        box-sizing: border-box;
        animation: scaleUpModalCard 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes scaleUpModalCard {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .export-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }
    .export-modal-title {
        font-size: 17.5px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        letter-spacing: -0.2px;
    }
    .export-modal-close {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .export-modal-close:hover {
        background: #f1f5f9;
        color: #0f172a;
        border-color: #94a3b8;
    }

    .export-section {
        margin-bottom: 18px;
    }
    .export-section-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 10px;
    }
    .export-checkbox-group, .export-radio-group {
        display: flex;
        flex-direction: column;
        gap: 9px;
    }
    .export-check-item, .export-radio-item {
        display: flex;
        align-items: center;
        gap: 9px;
        font-size: 13px;
        color: #334155;
        cursor: pointer;
        user-select: none;
    }
    .custom-checkbox {
        width: 17px;
        height: 17px;
        border-radius: 4px;
        border: 1px solid #cbd5e1;
        cursor: pointer;
        accent-color: #dc2626;
    }
    .custom-radio {
        width: 17px;
        height: 17px;
        cursor: pointer;
        accent-color: #e11d48;
    }
    .export-hint-text {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 6px;
    }
    .export-include-dup-box {
        margin-top: 14px;
    }

    .export-modal-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        margin-top: 22px;
        padding-top: 14px;
    }
    .btn-modal-cancel {
        background: transparent;
        border: none;
        color: #64748b;
        font-size: 13.5px;
        font-weight: 600;
        padding: 8px 14px;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.15s ease, color 0.15s ease;
    }
    .btn-modal-cancel:hover {
        background: #f1f5f9;
        color: #1e293b;
    }
    .btn-modal-download {
        background: #16a34a;
        color: #ffffff;
        font-size: 13.5px;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        transition: background 0.15s ease;
    }
    .btn-modal-download:hover {
        background: #15803d;
    }
    .btn-modal-download:disabled {
        opacity: 0.75;
        cursor: not-allowed;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnExport = document.getElementById('btnExportExcel');
        const modalOverlay = document.getElementById('exportModalOverlay');
        const btnCloseModal = document.getElementById('btnCloseExportModal');
        const btnCancelModal = document.getElementById('btnCancelExportModal');
        const exportForm = document.getElementById('exportFormModal');
        const btnDownload = document.getElementById('btnModalSubmitDownload');

        // Buka modal saat klik Export Excel di header
        if (btnExport && modalOverlay) {
            btnExport.addEventListener('click', function(e) {
                e.preventDefault();

                // Sinkronkan parameter filter aktif dari formulir filter halaman ke hidden inputs modal
                const searchInput = document.querySelector('input[name="q"]');
                const tipeSelect = document.querySelector('select[name="tipe"]');
                const statusNikSelect = document.querySelector('select[name="status_nik"]');
                const kendaraanSelect = document.querySelector('select[name="kendaraan"]');
                const toggleDup = document.querySelector('input[name="show_duplicates"]');

                document.getElementById('exportHiddenQ').value = searchInput ? searchInput.value : '';
                document.getElementById('exportHiddenTipe').value = tipeSelect ? tipeSelect.value : '';
                document.getElementById('exportHiddenStatusNik').value = statusNikSelect ? statusNikSelect.value : '';
                document.getElementById('exportHiddenKendaraan').value = kendaraanSelect ? kendaraanSelect.value : '';

                // Sinkronkan checkbox sertakan duplikat dengan toggle di halaman
                const modalDupCheck = document.getElementById('modalIncludeDuplicates');
                if (modalDupCheck && toggleDup) {
                    modalDupCheck.checked = toggleDup.checked;
                }

                // Tampilkan modal
                modalOverlay.style.display = 'flex';
            });
        }

        // Fungsi tutup modal
        function closeModal() {
            if (modalOverlay) {
                modalOverlay.style.display = 'none';
            }
        }

        if (btnCloseModal) btnCloseModal.addEventListener('click', closeModal);
        if (btnCancelModal) btnCancelModal.addEventListener('click', closeModal);

        // Tutup modal jika user klik area gelap di luar kartu modal
        if (modalOverlay) {
            modalOverlay.addEventListener('click', function(e) {
                if (e.target === modalOverlay) {
                    closeModal();
                }
            });
        }

        // Handle submit download
        if (exportForm && btnDownload) {
            exportForm.addEventListener('submit', function() {
                const origHtml = btnDownload.innerHTML;
                btnDownload.innerHTML = `
                    <svg class="animate-spin" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="2" x2="12" y2="6"></line>
                        <line x1="12" y1="18" x2="12" y2="22"></line>
                        <line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line>
                        <line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line>
                        <line x1="2" y1="12" x2="6" y2="12"></line>
                        <line x1="18" y1="12" x2="22" y2="12"></line>
                        <line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line>
                        <line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line>
                    </svg>
                    <span>Mengekspor...</span>
                `;
                btnDownload.disabled = true;

                // Tutup modal dan reset tombol setelah beberapa detik
                setTimeout(function() {
                    btnDownload.innerHTML = origHtml;
                    btnDownload.disabled = false;
                    closeModal();
                }, 2500);
            });
        }
    });
</script>
@endsection
