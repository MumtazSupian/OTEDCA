@extends('layouts.app')

@section('title', 'Lookup Konsumen ↔ Kendaraan')

@section('content')
<div class="lookup-container">
    {{-- 1. HEADER SECTION --}}
    <div class="page-header-row">
        <div>
            <h1 class="page-title">Lookup Konsumen ↔ Kendaraan</h1>
            <p class="page-subtitle">Telusuri keterkaitan lewat VIN, plat nomor, atau nama konsumen</p>
        </div>
    </div>

    {{-- 2. UNIFIED SEARCH BAR CARD --}}
    <div class="search-card">
        <form method="GET" action="{{ route('customer.vehicle_lookup') }}" id="lookupForm">
            <div class="search-bar-wrap">
                {{-- Mode Switcher Buttons --}}
                <div class="search-mode-switcher">
                    <input type="hidden" name="mode" id="lookupMode" value="{{ $mode ?? 'konsumen' }}">
                    <button type="button" class="btn-mode {{ ($mode ?? 'konsumen') == 'konsumen' ? 'btn-mode-active' : '' }}" onclick="setLookupMode('konsumen')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span>Cari Konsumen</span>
                    </button>
                    <button type="button" class="btn-mode {{ ($mode ?? 'konsumen') == 'kendaraan' ? 'btn-mode-active' : '' }}" onclick="setLookupMode('kendaraan')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9C2.1 11.2 2 11.6 2 12v4c0 .6.4 1 1 1h2"></path>
                            <circle cx="7" cy="17" r="2"></circle>
                            <path d="M9 17h6"></path>
                            <circle cx="17" cy="17" r="2"></circle>
                        </svg>
                        <span>Cari Kendaraan (VIN/Plat)</span>
                    </button>
                </div>

                {{-- Input Field --}}
                <div class="search-input-box">
                    <input type="text" name="q" id="lookupInput" value="{{ $keyword ?? '' }}" 
                           placeholder="{{ ($mode ?? 'konsumen') == 'kendaraan' ? 'Ketik VIN / plat nomor (min. 4 karakter)...' : 'Ketik nama / NIK / HP konsumen...' }}" 
                           class="lookup-input-control" autofocus>
                </div>

                {{-- Search Button --}}
                <button type="submit" class="btn-search-action">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <span>Cari</span>
                </button>
            </div>
        </form>
    </div>

    {{-- 3. TWO COLUMN RESULTS GRID --}}
    <div class="lookup-results-grid">
        {{-- KOLOM KIRI: HASIL KONSUMEN / KENDARAAN --}}
        <div class="panel-card left-panel">
            <div class="panel-header">
                <div class="panel-header-title" id="leftPanelHeader">
                    <span id="leftPanelIcon">
                        @if(($mode ?? 'konsumen') == 'kendaraan')
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #475569;">
                                <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9C2.1 11.2 2 11.6 2 12v4c0 .6.4 1 1 1h2"></path>
                                <circle cx="7" cy="17" r="2"></circle>
                                <path d="M9 17h6"></path>
                                <circle cx="17" cy="17" r="2"></circle>
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #475569;">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        @endif
                    </span>
                    <span id="leftPanelTitle">{{ ($mode ?? 'konsumen') == 'kendaraan' ? 'Hasil Kendaraan' : 'Hasil Konsumen' }}</span>
                    @if(!empty($results))
                        <span class="badge-count-header">{{ count($results) }}</span>
                    @endif
                </div>
            </div>

            <div class="panel-body panel-body-table">
                @if(empty($results))
                    {{-- Empty State --}}
                    <div class="empty-state-wrap">
                        <div class="empty-icon-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" style="color: #94a3b8;">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </div>
                        <p class="empty-text">Cari untuk menampilkan hasil</p>
                        <span class="empty-subtext">{{ ($mode ?? 'konsumen') == 'kendaraan' ? 'Ketik VIN / plat nomor pada kolom pencarian dan klik Cari' : 'Ketik nama / NIK / HP konsumen pada kolom pencarian dan klik Cari' }}</span>
                    </div>
                @else
                    {{-- TABLE RESULTS --}}
                    <div class="table-responsive-left">
                        <table class="table-lookup">
                            <thead>
                                @if(($mode ?? 'konsumen') == 'kendaraan')
                                <tr>
                                    <th>VIN</th>
                                    <th>Plat</th>
                                    <th>Type</th>
                                    <th>Pemilik Saat Ini</th>
                                    <th style="text-align: right;">ID</th>
                                </tr>
                                @else
                                <tr>
                                    <th>Nama</th>
                                    <th>NIK</th>
                                    <th>HP</th>
                                    <th style="text-align: center;">Kendaraan</th>
                                </tr>
                                @endif
                            </thead>
                            <tbody>
                                @foreach($results as $idx => $r)
                                    @php
                                        $isSelected = false;
                                        if (($mode ?? 'konsumen') == 'kendaraan') {
                                            $isSelected = ($selectedChassis && $selectedChassis == ($r['vin'] ?? '')) || (!$selectedChassis && $idx === 0);
                                        } else {
                                            $isSelected = ($selectedCustomerCode && $selectedCustomerCode == ($r['customer_code'] ?? '')) || (!$selectedCustomerCode && $idx === 0);
                                        }
                                    @endphp
                                    @if(($mode ?? 'konsumen') == 'kendaraan')
                                        <tr class="lookup-row {{ $isSelected ? 'row-selected' : '' }}" 
                                            onclick="handleRowClick('kendaraan', '', '{{ $r['vin'] ?? '' }}', '{{ $r['plat'] ?? '' }}')">
                                            <td class="font-mono text-vin">{{ $r['vin'] }}</td>
                                            <td class="font-mono text-plat">{{ $r['plat'] }}</td>
                                            <td class="text-type">{{ $r['type'] ?? ($r['model'] ?? '-') }}</td>
                                            <td class="text-owner font-bold">{{ $r['pemilik'] ?? ($r['stnk_nama'] ?? '-') }}</td>
                                            <td class="text-id font-mono">{{ $r['id'] ?? '-' }}</td>
                                        </tr>
                                    @else
                                        <tr class="lookup-row {{ $isSelected ? 'row-selected' : '' }}" 
                                            onclick="handleRowClick('konsumen', '{{ $r['customer_code'] ?? '' }}', '{{ $r['all_chassis'][0] ?? ($r['chassis_list'][0] ?? '') }}', '')">
                                            <td>
                                                <div class="cell-main-name">{{ $r['nama'] }}</div>
                                                @if(($r['data_count'] ?? 1) > 1)
                                                    <div style="margin-top: 3px;">
                                                        <span class="badge-sub-data">{{ $r['data_count'] }} data</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="cell-nik">{{ $r['nik'] }}</td>
                                            <td class="cell-hp">{{ $r['hp'] }}</td>
                                            <td style="text-align: center;">
                                                <span class="badge-units-circle">{{ $r['total_unit'] }}</span>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- KOLOM KANAN: KETERKAITAN / DETAIL KENDARAAN --}}
        <div class="panel-card right-panel">
            <div class="panel-header">
                <div class="panel-header-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #475569;">
                        <circle cx="18" cy="5" r="3"></circle>
                        <circle cx="6" cy="12" r="3"></circle>
                        <circle cx="18" cy="19" r="3"></circle>
                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                    </svg>
                    <span>Keterkaitan</span>
                </div>
            </div>

            <div class="panel-body" id="detailPanelBody">
                @if(empty($selectedVehicles) && empty($selectedDetail))
                    {{-- Empty State Kanan --}}
                    <div class="empty-state-wrap">
                        <div class="empty-icon-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="color: #94a3b8;">
                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                <polyline points="12 19 5 12 12 5"></polyline>
                            </svg>
                        </div>
                        <p class="empty-text">Pilih hasil di sebelah kiri</p>
                    </div>
                @else
                    @php
                        $vehiclesToRender = !empty($selectedVehicles) ? $selectedVehicles : (empty($selectedDetail) ? [] : [$selectedDetail]);
                    @endphp
                    {{-- TAMPILAN SPESIFIKASI KENDARAAN & RIWAYAT SERVICE LENGKAP --}}
                    <div class="vehicle-specs-full-wrap" style="display: flex; flex-direction: column; gap: 32px;">
                        @foreach($vehiclesToRender as $vIdx => $vItem)
                            <div class="vehicle-unit-card" style="{{ $vIdx > 0 ? 'padding-top: 28px; border-top: 2px dashed #cbd5e1;' : '' }}">
                                {{-- 1. HEADER MODEL KENDARAAN DENGAN ICON MOBIL ASLI --}}
                                <div class="vs-header-title-box">
                                    <div class="vs-car-icon-wrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9C2.1 11.2 2 11.6 2 12v4c0 .6.4 1 1 1h2"></path>
                                            <circle cx="7" cy="17" r="2"></circle>
                                            <path d="M9 17h6"></path>
                                            <circle cx="17" cy="17" r="2"></circle>
                                        </svg>
                                    </div>
                                    <div style="flex: 1;">
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <h3 class="vs-model-name">{{ $vItem['specs']['model'] ?? 'Suzuki Unit' }}</h3>
                                        </div>
                                        <div class="vs-model-year">{{ $vItem['specs']['tahun'] ?? date('Y') }}</div>
                                    </div>
                                </div>

                                {{-- 2. GRID 4 SPESIFIKASI --}}
                                <div class="vs-specs-grid">
                                    <div class="spec-col">
                                        <div class="spec-lbl">VIN</div>
                                        <div class="spec-val font-mono">{{ $vItem['specs']['vin'] ?? '-' }}</div>
                                        <div class="spec-lbl" style="margin-top: 10px;">STNK A/N</div>
                                        <div class="spec-val font-bold">{{ $vItem['specs']['stnk_nama'] ?? '-' }}</div>
                                    </div>
                                    <div class="spec-col">
                                        <div class="spec-lbl">PLAT</div>
                                        <div class="spec-val font-mono font-bold">{{ $vItem['specs']['plat'] ?? '-' }}</div>
                                    </div>
                                    <div class="spec-col">
                                        <div class="spec-lbl">NO. MESIN</div>
                                        <div class="spec-val font-mono">{{ $vItem['specs']['no_mesin'] ?? '-' }}</div>
                                    </div>
                                    <div class="spec-col">
                                        <div class="spec-lbl">WARNA</div>
                                        <div class="spec-val font-bold">{{ $vItem['specs']['warna'] ?? 'WHITE' }}</div>
                                    </div>
                                </div>

                                {{-- 3. SECTION KETERKAITAN KONSUMEN --}}
                                <div class="vs-section-box">
                                    <div class="vs-section-header">
                                        <div class="vs-section-title">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            </svg>
                                            <span>Keterkaitan Konsumen</span>
                                            <span class="badge-count-pill">{{ $vItem['total_keterkaitan'] ?? count($vItem['keterkaitans'] ?? []) }}</span>
                                        </div>
                                    </div>

                                    <div class="table-responsive-section">
                                        <table class="table-section-data">
                                            <thead>
                                                <tr>
                                                    <th style="min-width: 90px;">Peran</th>
                                                    <th style="min-width: 65px;">Sumber</th>
                                                    <th style="min-width: 140px;">Konsumen</th>
                                                    <th style="min-width: 120px;">HP</th>
                                                    <th style="min-width: 160px;">Periode</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($vItem['keterkaitans'] ?? [] as $ket)
                                                <tr>
                                                    <td>
                                                        @if(stripos($ket['peran'], 'pemilik') !== false)
                                                            <span class="badge-role-green">{{ $ket['peran'] }}</span>
                                                        @else
                                                            <span class="badge-role-cyan">{{ $ket['peran'] }}</span>
                                                        @endif
                                                    </td>
                                                    <td><span class="text-muted font-bold">{{ $ket['sumber'] }}</span></td>
                                                    <td><span class="text-link-blue">{{ $ket['konsumen'] }}</span></td>
                                                    <td class="cell-nowrap">{{ $ket['hp'] }}</td>
                                                    <td class="text-muted">{{ $ket['periode'] }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-3">Tidak ada data keterkaitan</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- 4. SECTION RIWAYAT SERVICE (SPK) --}}
                                <div class="vs-section-box" style="margin-top: 24px;">
                                    <div class="vs-section-header">
                                        <div class="vs-section-title">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                                            </svg>
                                            <span>Riwayat Service</span>
                                            <span class="badge-count-pill">{{ $vItem['total_wo'] ?? count($vItem['services'] ?? []) }} SPK</span>
                                        </div>
                                    </div>

                                    <div class="table-responsive-section">
                                        <table class="table-section-data">
                                            <thead>
                                                <tr>
                                                    <th style="min-width: 140px;">No. SPK</th>
                                                    <th style="min-width: 90px;">Tgl SPK</th>
                                                    <th style="min-width: 90px;">Tgl Billing</th>
                                                    <th style="min-width: 180px;">Kategori</th>
                                                    <th style="min-width: 140px;">SA</th>
                                                    <th style="min-width: 75px; text-align: right;">KM</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($vItem['services'] ?? [] as $srv)
                                                <tr>
                                                    <td class="font-mono text-link-blue">{{ $srv['no_wo'] }}</td>
                                                    <td class="cell-nowrap">{{ $srv['tgl_wo'] }}</td>
                                                    <td class="text-green-accent cell-nowrap">{{ $srv['tgl_billing'] }}</td>
                                                    <td>{{ $srv['kategori'] }}</td>
                                                    <td>{{ $srv['sa'] }}</td>
                                                    <td style="text-align: right;" class="font-bold">{{ $srv['km'] }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted py-4">Belum ada riwayat service tercatat</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    /* Global Container */
    .lookup-container {
        padding: 24px 28px 40px 28px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        color: #1e293b;
        box-sizing: border-box;
    }
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

    /* Search Bar */
    .search-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 10px 14px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
        margin-bottom: 20px;
    }
    .search-bar-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .search-mode-switcher {
        display: inline-flex;
        background: #f1f5f9;
        padding: 3px;
        border-radius: 8px;
        gap: 2px;
    }
    .btn-mode {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border: none;
        background: transparent;
        color: #64748b;
        font-size: 12.5px;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-mode-active {
        background: #ffffff;
        color: #0f172a;
        font-weight: 700;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
    }
    .search-input-box {
        flex: 1 1 300px;
    }
    .lookup-input-control {
        width: 100%;
        height: 38px;
        padding: 6px 14px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 13.5px;
        color: #1e293b;
        box-sizing: border-box;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .lookup-input-control:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.12);
    }
    .btn-search-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        height: 38px;
        padding: 0 20px;
        background: #ef4444;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-search-action:hover {
        background: #dc2626;
        box-shadow: 0 4px 10px rgba(239, 68, 68, 0.25);
    }

    /* Grid Layout */
    .lookup-results-grid {
        display: grid;
        grid-template-columns: 500px 1fr;
        gap: 20px;
        align-items: start;
    }
    @media (max-width: 1180px) {
        .lookup-results-grid {
            grid-template-columns: 460px 1fr;
        }
    }
    @media (max-width: 992px) {
        .lookup-results-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Panel Card */
    .panel-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
        display: flex;
        flex-direction: column;
    }
    .left-panel {
        align-self: start;
    }
    .panel-header {
        padding: 14px 18px;
        background: #ffffff;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .panel-header-title {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
    }
    .badge-count-header {
        font-size: 11px;
        font-weight: 700;
        background: #e0f2fe;
        color: #0284c7;
        padding: 1px 8px;
        border-radius: 999px;
    }
    .panel-body {
        padding: 18px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .panel-body-table {
        padding: 0;
    }

    /* Left Table Styling - Match Foto 2 */
    .table-responsive-left {
        width: 100%;
        overflow-x: auto;
    }
    .table-lookup {
        width: 100%;
        border-collapse: collapse;
    }
    .table-lookup th {
        background: #ffffff;
        padding: 10px 12px;
        color: #334155;
        font-weight: 600;
        font-size: 12px;
        border-bottom: 1px solid #f1f5f9;
        text-align: left;
        white-space: nowrap;
    }
    .table-lookup td {
        padding: 10px 12px;
        border-bottom: 1px solid #f8fafc;
        color: #1e293b;
        font-size: 12.5px;
        vertical-align: middle;
    }
    .lookup-row {
        cursor: pointer;
        transition: background 0.15s ease;
    }
    .lookup-row:hover {
        background: #f8fafc;
    }
    .row-selected {
        background: #f1f5f9 !important;
    }
    .cell-main-name {
        color: #0f172a;
        font-weight: 600;
        white-space: nowrap;
    }
    .badge-sub-data {
        font-size: 11px;
        font-weight: 600;
        background: #e0f2fe;
        color: #0284c7;
        padding: 1px 6px;
        border-radius: 4px;
        display: inline-block;
        line-height: 1.3;
    }
    .cell-nik {
        color: #1e293b;
        white-space: nowrap;
        font-size: 12px;
        font-family: 'JetBrains Mono', monospace;
    }
    .cell-hp {
        color: #1e293b;
        white-space: nowrap;
        font-size: 12px;
    }
    .cell-nowrap {
        white-space: nowrap;
    }
    .text-vin {
        font-size: 11.5px;
        font-weight: 600;
        color: #1e293b;
        white-space: nowrap;
    }
    .text-plat {
        font-size: 11.5px;
        font-weight: 600;
        color: #0284c7;
        white-space: nowrap;
    }
    .text-type {
        color: #334155;
        font-weight: 500;
        white-space: nowrap;
    }
    .text-owner {
        color: #1e293b;
        white-space: nowrap;
    }
    .text-id {
        font-size: 11px;
        color: #94a3b8;
        white-space: nowrap;
    }
    .badge-units-circle {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 4px;
        background: #dcfce7;
        color: #16a34a;
        font-weight: 700;
        font-size: 11.5px;
        line-height: 1.2;
    }

    /* Empty States */
    .empty-state-wrap {
        margin: auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 40px 20px;
    }
    .empty-icon-circle, .empty-icon-arrow {
        margin-bottom: 14px;
    }
    .empty-text {
        font-size: 13.5px;
        font-weight: 600;
        color: #64748b;
        margin: 0;
    }
    .empty-subtext {
        font-size: 12px;
        color: #94a3b8;
        max-width: 280px;
        margin-top: 6px;
        line-height: 1.4;
    }

    /* Multi Vehicle Switcher Tab */
    .multi-vehicle-switcher {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
        background: #f8fafc;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #f1f5f9;
        flex-wrap: wrap;
    }
    .switcher-label {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }
    .btn-vehicle-tab {
        padding: 4px 10px;
        font-size: 11.5px;
        font-weight: 600;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #334155;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-vehicle-tab:hover {
        border-color: #94a3b8;
        background: #f1f5f9;
    }
    .btn-vehicle-tab-active {
        background: #0284c7;
        color: #ffffff;
        border-color: #0284c7;
        font-weight: 700;
    }

    /* Right Panel - Full Vehicle Specs */
    .vehicle-specs-full-wrap {
        display: flex;
        flex-direction: column;
    }
    .vs-header-title-box {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }
    .vs-car-icon-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .vs-model-name {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }
    .vs-model-year {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
    }
    .vs-specs-grid {
        display: grid;
        grid-template-columns: 1.4fr 1fr 1.2fr 1fr;
        gap: 16px;
        background: #ffffff;
        padding: 14px 18px;
        border: 1px solid #f1f5f9;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .spec-lbl {
        font-size: 10px;
        font-weight: 700;
        color: #94a3b8;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }
    .spec-val {
        font-size: 12.5px;
        color: #1e293b;
    }

    /* Section Subheaders */
    .vs-section-box {
        margin-top: 6px;
    }
    .vs-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .vs-section-title {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
    }
    .badge-count-pill {
        font-size: 11px;
        font-weight: 700;
        background: #e0f2fe;
        color: #0284c7;
        padding: 1px 7px;
        border-radius: 999px;
    }
    .table-responsive-section {
        width: 100%;
        overflow-x: auto;
        border-top: 1px solid #f1f5f9;
        border-bottom: 1px solid #f1f5f9;
    }
    .table-section-data {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }
    .table-section-data th {
        padding: 8px 12px;
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
        text-align: left;
        border-bottom: 1px solid #f1f5f9;
        background: #ffffff;
        white-space: nowrap;
    }
    .table-section-data td {
        padding: 10px 12px;
        color: #1e293b;
        border-bottom: 1px solid #f8fafc;
    }
    .text-link-blue {
        color: #0284c7;
        font-weight: 600;
    }
    .text-green-accent {
        color: #16a34a;
        font-weight: 600;
    }
    .badge-role-green {
        font-size: 11px;
        font-weight: 700;
        background: #dcfce7;
        color: #16a34a;
        padding: 2px 8px;
        border-radius: 4px;
        display: inline-block;
    }
    .badge-role-cyan {
        font-size: 11px;
        font-weight: 700;
        background: #e0f2fe;
        color: #0284c7;
        padding: 2px 8px;
        border-radius: 4px;
        display: inline-block;
    }

    /* Helper Utilities */
    .font-mono { font-family: 'JetBrains Mono', 'Courier New', monospace; }
    .font-bold { font-weight: 700; }
    .text-muted { color: #64748b; }
</style>

<script>
    function setLookupMode(mode) {
        const currentMode = '{{ $mode ?? 'konsumen' }}';
        if (mode !== currentMode) {
            window.location.href = "{{ route('customer.vehicle_lookup') }}?mode=" + mode;
        }
    }

    function handleRowClick(mode, custCode, vin, plat) {
        const url = new URL(window.location.href);
        url.searchParams.set('mode', mode);
        if (mode === 'kendaraan') {
            url.searchParams.set('chassis', vin);
            url.searchParams.set('plate', plat);
            url.searchParams.delete('cust_code');
        } else {
            url.searchParams.set('cust_code', custCode);
            url.searchParams.delete('chassis');
            url.searchParams.delete('plate');
        }
        window.location.href = url.toString();
    }
</script>
@endsection
