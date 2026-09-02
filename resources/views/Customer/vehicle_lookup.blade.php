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
                            <rect x="2" y="7" width="20" height="13" rx="2"></rect>
                            <path d="M16 3H8l-3 4h14l-3-4z"></path>
                            <circle cx="7" cy="15" r="2"></circle>
                            <circle cx="17" cy="15" r="2"></circle>
                        </svg>
                        <span>Cari Kendaraan (VIN/Plat)</span>
                    </button>
                </div>

                {{-- Input Field --}}
                <div class="search-input-box">
                    <input type="text" name="q" id="lookupInput" value="{{ $keyword ?? '' }}" 
                           placeholder="{{ ($mode ?? 'konsumen') == 'kendaraan' ? 'Ketik VIN / plat nomor (min. 4 karakter)...' : 'Ketik nama / NIK / HP konsumen...' }}" 
                           class="lookup-input-control">
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
        <div class="panel-card">
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
                </div>
            </div>

            <div class="panel-body">
                @if(empty($sampleResults))
                    {{-- Empty State --}}
                    <div class="empty-state-wrap">
                        <div class="empty-icon-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </div>
                        <p class="empty-text">Cari untuk menampilkan hasil</p>
                        <span class="empty-subtext">Gunakan kolom pencarian di atas untuk menemukan data konsumen atau kendaraan</span>
                    </div>
                @else
                    {{-- List of Results --}}
                    <div class="results-list">
                        @foreach($sampleResults as $idx => $res)
                        <div class="result-item {{ $idx === 0 ? 'result-item-selected' : '' }}" onclick="selectConsumer({{ json_encode($res) }})">
                            <div class="result-item-top">
                                <span class="result-name">{{ $res['nama'] }}</span>
                                <span class="result-badge-units">{{ $res['total_unit'] }} unit</span>
                            </div>
                            <div class="result-item-meta">
                                <span><strong>NIK:</strong> {{ $res['nik'] }}</span>
                                <span><strong>HP:</strong> {{ $res['hp'] }}</span>
                            </div>
                            <div class="result-item-addr">
                                📍 {{ $res['alamat'] }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- KOLOM KANAN: KETERKAITAN --}}
        <div class="panel-card">
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
                @if(empty($selectedDetail))
                    {{-- Empty State --}}
                    <div class="empty-state-wrap">
                        <div class="empty-icon-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                <polyline points="12 19 5 12 12 5"></polyline>
                            </svg>
                        </div>
                        <p class="empty-text">Pilih hasil di sebelah kiri</p>
                        <span class="empty-subtext">Detail unit kendaraan, riwayat transaksi, dan service akan muncul di sini</span>
                    </div>
                @else
                    {{-- Detail Content --}}
                    <div class="detail-container">
                        {{-- Consumer Profile Card --}}
                        <div class="consumer-profile-box">
                            <div class="profile-avatar">👤</div>
                            <div class="profile-info">
                                <div class="profile-name">{{ $selectedDetail['nama'] }}</div>
                                <div class="profile-tags">
                                    <span class="badge-tipe">{{ $selectedDetail['tipe'] }}</span>
                                    <span class="badge-units">{{ $selectedDetail['total_unit'] }} Kendaraan Terdaftar</span>
                                </div>
                            </div>
                        </div>

                        <h4 class="section-divider-title">Daftar Kendaraan Terhubung</h4>

                        {{-- Vehicle Cards List --}}
                        <div class="vehicles-stack">
                            @foreach($selectedDetail['kendaraans'] as $vk)
                            <div class="vehicle-detail-card">
                                <div class="vehicle-card-top">
                                    <div class="vehicle-model-title">
                                        🚗 {{ $vk['model'] }}
                                    </div>
                                    <span class="plate-badge">{{ $vk['no_polisi'] }}</span>
                                </div>
                                
                                <div class="vehicle-specs-grid">
                                    <div class="spec-row">
                                        <span class="spec-label">VIN / Rangka:</span>
                                        <span class="spec-val font-mono">{{ $vk['vin'] }}</span>
                                    </div>
                                    <div class="spec-row">
                                        <span class="spec-label">No. Mesin:</span>
                                        <span class="spec-val font-mono">{{ $vk['no_mesin'] }}</span>
                                    </div>
                                    <div class="spec-row">
                                        <span class="spec-label">Tahun / Warna:</span>
                                        <span class="spec-val">{{ $vk['tahun'] }} • {{ $vk['warna'] }}</span>
                                    </div>
                                    <div class="spec-row">
                                        <span class="spec-label">Cabang Pembelian:</span>
                                        <span class="spec-val font-bold">Cabang {{ $vk['cabang'] }} ({{ $vk['tgl_beli'] }})</span>
                                    </div>
                                    <div class="spec-row">
                                        <span class="spec-label">Service Terakhir:</span>
                                        <span class="spec-val text-green">{{ $vk['service_terakhir'] }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
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

    /* Header */
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

    /* Unified Search Card */
    .search-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
        margin-bottom: 24px;
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
        height: 40px;
        padding: 8px 16px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 13.5px;
        color: #1e293b;
        box-sizing: border-box;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
    }
    .lookup-input-control:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
    }
    .btn-search-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 40px;
        padding: 0 24px;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.25);
        transition: all 0.2s ease;
    }
    .btn-search-action:hover {
        background: linear-gradient(135deg, #b91c1c, #991b1b);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.35);
    }

    /* Grid Layout */
    .lookup-results-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    @media (max-width: 900px) {
        .lookup-results-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Panel Card */
    .panel-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
        display: flex;
        flex-direction: column;
        min-height: 420px;
        overflow: hidden;
    }
    .panel-header {
        padding: 14px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .panel-header-title {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        font-weight: 700;
        color: #1e293b;
    }
    .panel-body {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
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
    .empty-icon-circle {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        margin-bottom: 16px;
    }
    .empty-text {
        font-size: 15px;
        font-weight: 700;
        color: #475569;
        margin: 0 0 6px 0;
    }
    .empty-subtext {
        font-size: 12.5px;
        color: #94a3b8;
        max-width: 280px;
        line-height: 1.45;
    }

    /* Results List */
    .results-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .result-item {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px 16px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .result-item:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
        transform: translateY(-1px);
    }
    .result-item-selected {
        border-color: #dc2626 !important;
        background: #fef2f2 !important;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.12);
    }
    .result-item-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }
    .result-name {
        font-size: 14px;
        font-weight: 800;
        color: #0f172a;
    }
    .result-badge-units {
        font-size: 11px;
        font-weight: 700;
        background: #dbeafe;
        color: #1d4ed8;
        padding: 2px 8px;
        border-radius: 999px;
    }
    .result-item-meta {
        display: flex;
        gap: 16px;
        font-size: 12px;
        color: #475569;
        margin-bottom: 6px;
    }
    .result-item-addr {
        font-size: 11.5px;
        color: #64748b;
    }

    /* Right Panel Detail View */
    .detail-container {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .consumer-profile-box {
        display: flex;
        align-items: center;
        gap: 14px;
        background: #f8fafc;
        padding: 14px 16px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }
    .profile-avatar {
        font-size: 28px;
        width: 46px;
        height: 46px;
        background: #fee2e2;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .profile-name {
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 4px;
    }
    .profile-tags {
        display: flex;
        gap: 6px;
    }
    .badge-tipe {
        font-size: 11px;
        font-weight: 700;
        background: #e2e8f0;
        color: #334155;
        padding: 2px 8px;
        border-radius: 4px;
    }
    .badge-units {
        font-size: 11px;
        font-weight: 700;
        background: #dcfce7;
        color: #15803d;
        padding: 2px 8px;
        border-radius: 4px;
    }
    .section-divider-title {
        font-size: 13px;
        font-weight: 800;
        color: #334155;
        margin: 8px 0 0 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .vehicles-stack {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .vehicle-detail-card {
        background: #ffffff;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px 16px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
    }
    .vehicle-card-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 1px dashed #e2e8f0;
    }
    .vehicle-model-title {
        font-size: 13.5px;
        font-weight: 800;
        color: #0f172a;
    }
    .plate-badge {
        font-size: 12px;
        font-weight: 800;
        background: #0f172a;
        color: #ffffff;
        padding: 3px 10px;
        border-radius: 6px;
        font-family: 'JetBrains Mono', 'Courier New', monospace;
        letter-spacing: 0.8px;
    }
    .vehicle-specs-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 6px;
        font-size: 12px;
    }
    .spec-row {
        display: flex;
        justify-content: space-between;
        gap: 8px;
    }
    .spec-label {
        color: #64748b;
        font-weight: 600;
    }
    .spec-val {
        color: #1e293b;
        font-weight: 700;
        text-align: right;
    }
    .font-mono {
        font-family: 'JetBrains Mono', 'Courier New', monospace;
    }
    .font-bold {
        font-weight: 800;
    }
    .text-green {
        color: #15803d;
        font-weight: 800;
    }
</style>

<script>
    function setLookupMode(mode) {
        document.getElementById('lookupMode').value = mode;
        const input = document.getElementById('lookupInput');
        const title = document.getElementById('leftPanelTitle');
        const iconWrap = document.getElementById('leftPanelIcon');
        
        if (mode === 'kendaraan') {
            input.placeholder = 'Ketik VIN / plat nomor (min. 4 karakter)...';
            if (title) title.textContent = 'Hasil Kendaraan';
            if (iconWrap) {
                iconWrap.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #475569;">
                        <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9C2.1 11.2 2 11.6 2 12v4c0 .6.4 1 1 1h2"></path>
                        <circle cx="7" cy="17" r="2"></circle>
                        <path d="M9 17h6"></path>
                        <circle cx="17" cy="17" r="2"></circle>
                    </svg>
                `;
            }
        } else {
            input.placeholder = 'Ketik nama / NIK / HP konsumen...';
            if (title) title.textContent = 'Hasil Konsumen';
            if (iconWrap) {
                iconWrap.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #475569;">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                `;
            }
        }
        
        // Update button states
        const btns = document.querySelectorAll('.btn-mode');
        btns.forEach(b => b.classList.remove('btn-mode-active'));
        if (mode === 'kendaraan') {
            if (btns[1]) btns[1].classList.add('btn-mode-active');
        } else {
            if (btns[0]) btns[0].classList.add('btn-mode-active');
        }
    }
</script>
@endsection
