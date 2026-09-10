@extends('layouts.app')

@section('title', 'Data Promo Service')

@section('content')
<div class="promo-container">
    {{-- 1. HEADER SECTION --}}
    <div class="page-header-row">
        <div>
            <h1 class="page-title">PROMO SERVICE - {{ strtoupper($branchList[$cabang] ?? $cabang) }}</h1>
            <p class="page-subtitle">Data transaksi servis kategori promo dari SDMS cabang {{ $branchList[$cabang] ?? $cabang }}</p>
        </div>
        <div class="header-badges">
            <span class="badge-role-it">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                    <line x1="8" y1="21" x2="16" y2="21"></line>
                    <line x1="12" y1="17" x2="12" y2="21"></line>
                </svg>
                Khusus IT
            </span>
        </div>
    </div>

    @if(!empty($errorMessage))
    <div style="background: #fef2f2; border: 1px solid #f87171; border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 12px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0; margin-top: 2px;">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
        </svg>
        <div style="flex-grow: 1;">
            <div style="font-weight: 700; color: #991b1b; font-size: 13px; margin-bottom: 3px;">Koneksi ke Database SDMS Timeout / Gangguan Jaringan</div>
            <div style="font-size: 12px; color: #b91c1c; line-height: 1.4;">Server database SDMS (36.95.146.107:24835) sedang lambat atau mengalami gangguan koneksi sementara. Data tidak hilang, silakan klik tombol di bawah untuk mencoba muat ulang.</div>
            <button onclick="location.reload()" style="margin-top: 8px; background: #dc2626; color: white; border: none; padding: 5px 12px; border-radius: 6px; font-weight: 600; font-size: 11px; cursor: pointer;">Coba Muat Ulang</button>
        </div>
    </div>
    @endif

    {{-- 2. METRIC SUMMARY BAR --}}
    <div class="summary-cards-grid">
        <div class="sum-card">
            <div class="sum-lbl">Cabang</div>
            <div class="sum-val text-brand">{{ $branchList[$cabang] ?? $cabang }}</div>
        </div>
        <div class="sum-card">
            <div class="sum-lbl">Periode</div>
            <div class="sum-val">
                @php
                    $months = [
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                    ];
                @endphp
                {{ $months[$bulan] ?? $bulan }} {{ $tahun }}
            </div>
        </div>
        <div class="sum-card">
            <div class="sum-lbl">Total Transaksi Promo</div>
            <div class="sum-val">{{ number_format($totalRecords, 0, ',', '.') }}</div>
        </div>
        <div class="sum-card card-highlight">
            <div class="sum-lbl">Total Nominal Promo</div>
            <div class="sum-val text-total">Rp {{ number_format($grandTotalHarga, 0, ',', '.') }}</div>
        </div>
    </div>

    {{-- 3. FILTER TOOLBAR CARD --}}
    <div class="filter-card-wrapper">
        <form action="{{ route('service.promo') }}" method="GET" class="filter-form-row">
            {{-- Hidden Cabang agar filter tetap berada di cabang aktif --}}
            <input type="hidden" name="cabang" value="{{ $cabang }}">

            {{-- Filter Bulan --}}
            <div class="filter-item">
                <label class="filter-lbl">Bulan</label>
                <select name="bulan" class="filter-select" onchange="this.form.submit()">
                    @foreach($months as $mNum => $mName)
                        <option value="{{ $mNum }}" {{ $bulan == $mNum ? 'selected' : '' }}>{{ $mName }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Tahun --}}
            <div class="filter-item">
                <label class="filter-lbl">Tahun</label>
                <select name="tahun" class="filter-select" onchange="this.form.submit()">
                    @foreach($availableYears as $y)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Search Bar --}}
            <div class="filter-item filter-search-box" style="flex-grow: 1;">
                <label class="filter-lbl">Pencarian</label>
                <div class="search-input-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="search-icon">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari No SPK / Invoice / Foreman / Promo..." class="filter-input-search">
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="filter-item filter-actions">
                <label class="filter-lbl">&nbsp;</label>
                <div style="display: flex; gap: 8px;">
                    <button type="submit" class="btn-filter-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                        </svg>
                        <span>Filter</span>
                    </button>
                    @if(!empty($search) || $bulan != date('n') || $tahun != date('Y'))
                    <a href="{{ route('service.promo', ['cabang' => $cabang]) }}" class="btn-filter-reset" title="Reset Filter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                            <path d="M3 3v5h5"></path>
                        </svg>
                        <span>Reset</span>
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    {{-- 4. TABLE SECTION --}}
    <div class="table-card-wrapper">
        <div class="table-responsive">
            <table class="promo-table">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">No</th>
                        <th style="min-width: 140px;">No SPK</th>
                        <th style="min-width: 140px;">No Invoice</th>
                        <th style="min-width: 180px;">Foreman</th>
                        <th style="min-width: 220px;">Promo</th>
                        <th style="min-width: 130px; text-align: center;">Tanggal Dibuat</th>
                        <th style="min-width: 150px; text-align: right;">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($promos as $idx => $row)
                    @php
                        $rowHarga = (float)($row->harga ?? 0);
                        
                        $tglDibuat = '-';
                        if (!empty($row->tanggal_dibuat)) {
                            $tglDibuat = date('d/m/Y', strtotime($row->tanggal_dibuat));
                        }

                        $foremanDisplay = $row->foreman_nama ?: ($row->foreman_id ?: '-');
                    @endphp
                    <tr>
                        <td style="text-align: center; color: #64748b; font-weight: 600;">{{ $idx + 1 }}</td>
                        <td>
                            <span class="cell-spk">{{ $row->no_spk ?: '-' }}</span>
                        </td>
                        <td>
                            <span class="cell-invoice">{{ $row->no_invoice ?: '-' }}</span>
                        </td>
                        <td>
                            <div class="cell-foreman">
                                <span class="foreman-name">{{ $foremanDisplay }}</span>
                                @if(!empty($row->foreman_id) && !empty($row->foreman_nama))
                                    <span class="foreman-id">({{ $row->foreman_id }})</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="badge-promo-tag">
                                {{ $row->promo ?: 'PROMO' }}
                            </span>
                        </td>
                        <td style="text-align: center; color: #475569;">
                            {{ $tglDibuat }}
                        </td>
                        <td style="text-align: right; font-weight: 700; color: #0f172a; font-family: 'JetBrains Mono', 'Courier New', monospace;">
                            {{ number_format($rowHarga, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center" style="padding: 45px 20px; color: #94a3b8; text-align: center;">
                            @if(!empty($errorMessage))
                                <div style="font-size: 14px; font-weight: 600; color: #dc2626; margin-bottom: 4px;">Koneksi SDMS Timeout</div>
                                <div style="font-size: 12px; color: #94a3b8;">Tidak dapat memuat data karena server database DMS sedang tidak merespons.</div>
                            @else
                                <div style="font-size: 14px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Tidak ada data promo ditemukan</div>
                                <div style="font-size: 12px; color: #94a3b8;">Coba ubah filter bulan, tahun, atau kata kunci pencarian.</div>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>

                {{-- TABLE FOOTER: TOTAL BARIS (Foto 2) --}}
                @if(count($promos) > 0)
                <tfoot>
                    <tr class="table-total-row">
                        <td colspan="6" style="text-align: right; font-weight: 800; font-size: 13px; color: #0f172a; padding: 12px 18px;">
                            Total
                        </td>
                        <td style="text-align: right; font-weight: 800; font-size: 14px; color: #dc2626; padding: 12px 14px; font-family: 'JetBrains Mono', 'Courier New', monospace;">
                            {{ number_format($grandTotalHarga, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

<style>
    /* Global Container */
    .promo-container {
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
        gap: 12px;
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
    .badge-role-it {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fee2e2;
        color: #dc2626;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 700;
        border: 1px solid #fecaca;
    }

    /* Summary Grid */
    .summary-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
        gap: 16px;
        margin-bottom: 20px;
    }
    .sum-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 16px 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02);
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 4px;
        transition: transform 0.15s ease;
    }
    .sum-card:hover {
        transform: translateY(-2px);
    }
    .sum-card.card-highlight {
        background: linear-gradient(135deg, #ffffff, #fff5f5);
        border-color: #fecaca;
    }
    .sum-lbl {
        font-size: 11.5px;
        font-weight: 600;
        color: #64748b;
    }
    .sum-val {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.3px;
    }
    .text-brand {
        color: #0284c7 !important;
    }
    .text-total {
        color: #dc2626 !important;
    }

    /* Filter Toolbar Card */
    .filter-card-wrapper {
        background: #ffffff;
        border-radius: 12px;
        padding: 16px 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02);
        margin-bottom: 20px;
    }
    .filter-form-row {
        display: flex;
        align-items: flex-end;
        gap: 12px;
        flex-wrap: wrap;
    }
    .filter-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .filter-lbl {
        font-size: 11.5px;
        font-weight: 700;
        color: #475569;
    }
    .filter-select {
        height: 38px;
        padding: 0 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        background-color: #ffffff;
        outline: none;
        min-width: 140px;
        cursor: pointer;
        transition: border-color 0.15s ease;
    }
    .filter-select:focus {
        border-color: #dc2626;
    }
    .search-input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }
    .search-icon {
        position: absolute;
        left: 12px;
        pointer-events: none;
    }
    .filter-input-search {
        height: 38px;
        width: 100%;
        padding: 0 12px 0 34px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 13px;
        color: #334155;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.15s ease;
    }
    .filter-input-search:focus {
        border-color: #dc2626;
    }
    .btn-filter-submit {
        height: 38px;
        padding: 0 16px;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.2);
        transition: all 0.15s ease;
    }
    .btn-filter-submit:hover {
        background: linear-gradient(135deg, #b91c1c, #991b1b);
        transform: translateY(-1px);
    }
    .btn-filter-reset {
        height: 38px;
        padding: 0 14px;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
    }
    .btn-filter-reset:hover {
        background: #e2e8f0;
        color: #0f172a;
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
    .promo-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 12.5px;
    }
    .promo-table thead th {
        background: #f8fafc;
        color: #475569;
        font-weight: 700;
        font-size: 12px;
        padding: 12px 14px;
        border-bottom: 1.5px solid #e2e8f0;
        white-space: nowrap;
    }
    .promo-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s ease;
    }
    .promo-table tbody tr:hover {
        background-color: #f8fafc;
    }
    .promo-table tbody td {
        padding: 11px 14px;
        color: #334155;
        vertical-align: middle;
    }

    /* Cells */
    .cell-spk {
        font-family: 'JetBrains Mono', 'Courier New', monospace;
        font-weight: 700;
        color: #0f172a;
        font-size: 12px;
    }
    .cell-invoice {
        font-family: 'JetBrains Mono', 'Courier New', monospace;
        font-weight: 600;
        color: #0284c7;
        font-size: 12px;
    }
    .cell-foreman {
        display: flex;
        flex-direction: column;
        gap: 1px;
    }
    .foreman-name {
        font-weight: 700;
        color: #1e293b;
    }
    .foreman-id {
        font-size: 10.5px;
        color: #94a3b8;
    }
    .badge-promo-tag {
        display: inline-block;
        background: #e0f2fe;
        color: #0369a1;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 5px;
        max-width: 260px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Total Footer Row (Foto 2) */
    .table-total-row {
        background: #f1f5f9 !important;
        border-top: 2px solid #cbd5e1;
        border-bottom: 2px solid #cbd5e1;
    }

    /* Pagination Footer */
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
        text-decoration: none;
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
    .btn-disabled {
        opacity: 0.4;
        cursor: not-allowed;
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
</style>
@endsection
