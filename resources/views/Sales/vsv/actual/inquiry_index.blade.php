@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
    * { box-sizing: border-box; }

    body {
        background-color: var(--bg-main, #f4f5f7) !important;
        color: #ffffff;
        font-family: 'Inter', 'Segoe UI', sans-serif;
    }

    /* ===== WRAPPER ===== */
    .page-wrapper {
        max-width: 1480px;
        margin: 0 auto;
        padding: 24px 16px;
    }

    /* ===== HEADER ===== */
    .page-header-wrap {
        text-align: center;
        margin-bottom: 16px;
    }
    .page-header-icon { font-size: 1.6rem; filter: drop-shadow(0 0 8px rgba(220,38,38,0.3)); }
    .page-header-title {
        color: #1e293b; font-weight: 800; font-size: 1.4rem; letter-spacing: 2px;
        text-transform: uppercase; text-shadow: none; margin: 0;
    }
    .page-header-subtitle { color: #64748b; font-size: 0.8rem; margin: 3px 0 0 0; }

    /* ===== DASHBOARD BUTTON ===== */
    .btn-dashboard {
        display: inline-flex; align-items: center; gap: 5px; padding: 6px 14px;
        border-radius: 7px; font-size: 0.78rem; font-weight: 600; border: 1.5px solid #e2e8f0;
        cursor: pointer; transition: all 0.2s ease; text-decoration: none;
        background: #1e293b; color: #475569;
    }
    .btn-dashboard:hover { background: #fee2e2; color: #991b1b; transform: translateY(-1px); }

    /* ===== FILTER CARD MATCHING OFFICE SYSTEM ===== */
    .filter-card {
        background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px;
        padding: 18px 24px; margin-bottom: 18px; box-shadow: 0 4px 12px rgba(0,0,0,0.04);
    }
    .filter-grid {
        display: grid;
        grid-template-columns: 130px 1fr 180px;
        gap: 12px 16px;
        align-items: center;
    }
    .filter-label {
        color: #475569; font-size: 0.76rem; font-weight: 600; letter-spacing: 0.3px;
        white-space: nowrap;
    }
    .date-range-row {
        display: flex; align-items: center; gap: 10px; flex: 1;
    }
    .input-date-wrap { flex: 1; max-width: 220px; }
    .input-date-wrap input[type="date"] {
        width: 100%; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 7px;
        color: #ffffff; padding: 7px 11px; font-size: 0.82rem; outline: none;
        font-family: 'Inter', sans-serif; transition: border-color 0.2s, box-shadow 0.2s;
    }
    .input-date-wrap input[type="date"]:focus { border-color: #dc2626; box-shadow: 0 0 0 2px rgba(59,130,246,0.15); }
    .input-date-wrap input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(0.6) sepia(1) saturate(3) hue-rotate(180deg); cursor: pointer;
    }
    .detail-checkbox-wrap {
        display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: #cbd5e1; font-weight: 500;
    }
    .detail-checkbox-wrap input[type="checkbox"] {
        width: 16px; height: 16px; accent-color: #dc2626; cursor: pointer;
    }

    .input-with-icon { position: relative; flex: 1; max-width: 500px; }
    .input-with-icon input {
        width: 100%; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 7px;
        color: #ffffff; padding: 7px 32px 7px 11px; font-size: 0.82rem;
        transition: border-color 0.2s, box-shadow 0.2s; outline: none; font-family: 'Inter', sans-serif;
    }
    .input-with-icon input:focus { border-color: #dc2626; box-shadow: 0 0 0 2px rgba(59,130,246,0.15); }
    .input-icon-btn {
        position: absolute; right: 7px; top: 50%; transform: translateY(-50%);
        background: #dc2626; border: none; border-radius: 4px; color: #1e293b; font-weight:800;
        width: 22px; height: 22px; display: flex; align-items: center; justify-content: center;
        cursor: pointer; font-size: 0.65rem; transition: background 0.2s;
    }
    .input-icon-btn:hover { background: #b91c1c; }

    /* ACTION BUTTONS (CYAN/BLUE GRADIENT MATCHING OFFICE PROGRAM) */
    .filter-actions {
        grid-column: 3;
        grid-row: 2 / span 3;
        display: flex;
        flex-direction: column;
        gap: 10px;
        justify-content: center;
    }
    .btn-search-cyan {
        background: linear-gradient(135deg, #00b4d8, #0077b6); color: #1e293b; font-weight:800; border: none;
        border-radius: 6px; padding: 8px 18px; font-size: 0.82rem; font-weight: 700;
        cursor: pointer; transition: all 0.2s ease; display: inline-flex; align-items: center;
        justify-content: center; gap: 6px; font-family: 'Inter', sans-serif;
        box-shadow: 0 4px 12px rgba(0,180,216,0.3);
    }
    .btn-search-cyan:hover { background: linear-gradient(135deg, #48cae4, #00b4d8); transform: translateY(-1px); }
    
    .btn-expand-cyan {
        background: linear-gradient(135deg, #0096c7, #023e8a); color: #1e293b; font-weight:800; border: none;
        border-radius: 6px; padding: 8px 18px; font-size: 0.82rem; font-weight: 600;
        cursor: pointer; transition: all 0.2s ease; display: inline-flex; align-items: center;
        justify-content: center; gap: 6px; font-family: 'Inter', sans-serif;
    }
    .btn-expand-cyan:hover { background: linear-gradient(135deg, #00b4d8, #0096c7); transform: translateY(-1px); }

    /* ===== TABLE CARD ===== */
    .table-card {
        background: #ffffff; border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e2e8f0;
    }
    .table-scroll-wrapper {
        overflow-x: auto;
        overflow-y: auto;
        max-height: 520px;
        max-width: 100%;
    }
    .table-custom { margin-bottom: 0; color: #1e293b; width: 100%; border-collapse: collapse; font-size: 0.75rem; white-space: nowrap; }
    .table-custom thead tr th {
        background: #fee2e2 !important;
        color: #991b1b; font-weight: 700; text-transform: uppercase; font-size: 0.68rem;
        letter-spacing: 0.4px; padding: 10px 12px; border-bottom: 2px solid #f87171;
        border-right: 1px solid #cbd5e1; text-align: left; position: sticky; top: 0; z-index: 10;
    }
    .table-custom thead tr th:last-child { border-right: none; }
    .table-custom tbody tr { transition: background 0.15s; }
    .table-custom tbody tr:nth-child(even) { background-color: #f8fafc; }
    .table-custom tbody tr:hover { background-color: #eff6ff; }
    .table-custom tbody td {
        padding: 8px 12px; border-bottom: 1px solid #e2e8f0;
        border-right: 1px solid #f1f5f9; font-size: 0.74rem; vertical-align: middle;
    }
    .table-custom tbody td:last-child { border-right: none; }

    .badge-progress {
        display: inline-block; padding: 2px 8px; border-radius: 4px; font-weight: 700; font-size: 0.68rem;
    }
    .badge-p { background: #dbeafe; color: #1e40af; }
    .badge-hp { background: #fef3c7; color: #92400e; }
    .badge-spk { background: #dcfce7; color: #166534; }
    .badge-do { background: #e0e7ff; color: #3730a3; }
    .badge-delivery { background: #f3e8ff; color: #6b21a8; }
    .badge-lost { background: #fee2e2; color: #991b1b; }

    /* ===== EMPTY STATE ===== */
    .empty-state { padding: 48px 16px; text-align: center; color: #475569; }
    .empty-state-icon { font-size: 2.2rem; display: block; margin-bottom: 8px; }

    /* ===== PAGINATION FOOTER MATCHING OFFICE SYSTEM SCREENSHOT ===== */
    .pagination-footer {
        background: linear-gradient(135deg, #e0f2fe, #bae6fd);
        border-top: 1px solid #7dd3fc;
        padding: 9px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.78rem;
        color: #0369a1;
        font-weight: 600;
    }
    .pagination-controls {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .page-num-btn {
        min-width: 26px; height: 26px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        background: #ffffff; color: #0284c7; border: 1px solid #38bdf8;
        font-size: 0.75rem; font-weight: 700; text-decoration: none;
        transition: all 0.15s; padding: 0 6px;
    }
    .page-num-btn:hover { background: #e0f2fe; color: #0369a1; }
    .page-num-btn.active {
        background: #0284c7; color: #ffffff; border-color: #0284c7;
        box-shadow: 0 2px 6px rgba(2,132,199,0.4);
    }
    .page-nav-btn {
        width: 26px; height: 26px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        background: #ffffff; color: #0284c7; border: 1px solid #38bdf8;
        font-size: 0.75rem; font-weight: 700; text-decoration: none;
        transition: all 0.15s;
    }
    .page-nav-btn:hover { background: #e0f2fe; color: #0369a1; }
    .page-nav-btn.disabled {
        opacity: 0.45; cursor: not-allowed; pointer-events: none; background: #f1f5f9; border-color: #cbd5e1; color: #475569;
    }
    .per-page-select {
        background: #ffffff; border: 1px solid #38bdf8; border-radius: 5px;
        color: #0369a1; padding: 2px 8px; font-size: 0.76rem; font-weight: 700;
        outline: none; cursor: pointer;
    }

    /* ===== CUSTOM MODAL POP-UP OVERLAY ===== */
    .custom-modal-overlay {
        display: none !important;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.75);
        z-index: 99999;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(4px);
    }
    .custom-modal-overlay.active {
        display: flex !important;
    }
    .modal-content-custom {
        background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px;
        color: #1e293b; font-weight:800; box-shadow: 0 20px 50px rgba(0,0,0,0.8);
        width: 580px; max-width: 90%; overflow: hidden;
    }
    .modal-header-custom {
        border-bottom: 1px solid #1e3a5f; padding: 14px 20px;
        display: flex; align-items: center; justify-content: space-between;
    }
    .modal-title-custom { font-size: 0.95rem; font-weight: 700; color: #1e293b; font-weight:800; margin: 0; }
    .modal-close-btn {
        background: none; border: none; color: #64748b; font-size: 1.2rem;
        cursor: pointer; transition: color 0.2s;
    }
    .modal-close-btn:hover { color: #1e293b; font-weight:800; }
    .modal-search-box {
        padding: 12px 20px; border-bottom: 1px solid #1e3a5f; background: #0b1728;
    }
    .modal-search-box input {
        width: 100%; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 6px;
        color: #1e293b; font-weight:800; padding: 7px 12px; font-size: 0.8rem; outline: none;
    }
    .modal-search-box input:focus { border-color: #dc2626; }
    .modal-list-group { max-height: 320px; overflow-y: auto; padding: 6px 0; }
    .modal-list-item {
        padding: 10px 20px; display: flex; align-items: center; justify-content: space-between;
        cursor: pointer; transition: background 0.15s; border-bottom: 1px solid #16263d;
    }
    .modal-list-item:hover { background: #1a2d47; }
    .modal-item-name { font-size: 0.84rem; font-weight: 600; color: #0f172a; }
    .modal-item-code { font-size: 0.72rem; color: #64748b; font-family: monospace; }
    .modal-item-badge {
        font-size: 0.65rem; padding: 2px 6px; border-radius: 4px;
        background: #1e3a5f; color: #60a5fa; font-weight: 600;
    }
</style>

<div class="page-wrapper">

    <!-- HEADER & BUTTON DASHBOARD -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <a href="{{ url('/current/dashboard') }}" class="btn-dashboard">
            <span>‹</span> Dashboard
        </a>
        <div class="page-header-wrap mb-0">
            <div class="d-flex align-items-center justify-content-center gap-2">
                <span class="page-header-icon">📊</span>
                <h1 class="page-header-title">{{ $pageTitle }}</h1>
            </div>
            <p class="page-header-subtitle">{{ $subTitle }}</p>
        </div>
        <div style="width:100px;"></div>
    </div>

    <!-- FILTER CARD MATCHING OFFICE SYSTEM -->
    <div class="filter-card">
        <form method="GET" action="{{ route('actual.inquiry_by_type') }}" id="filterForm">
            <!-- Search trigger flag & per page parameter -->
            <input type="hidden" name="search" value="1">
            <input type="hidden" name="per_page" id="hidden_per_page" value="{{ request('per_page', 500) }}">

            <!-- Hidden inputs for filter selections -->
            <input type="hidden" name="BranchCode" id="hidden_branch_code" value="{{ request('BranchCode', $BranchCode ?? '') }}">
            <input type="hidden" name="SpvEmployeeID" id="hidden_spv_id" value="{{ request('SpvEmployeeID', $SpvEmployeeID ?? '') }}">
            <input type="hidden" name="salesman" id="hidden_salesman" value="{{ request('salesman', '') }}">

            <div class="filter-grid">

                <!-- ROW 1: Date (From - To) & Detail Data Checkbox -->
                <span class="filter-label">Date (From - To)</span>
                <div class="date-range-row">
                    <div class="input-date-wrap">
                        <input type="date" name="from_date" value="{{ $fromDate }}">
                    </div>
                    <span style="color:#64748b;">-</span>
                    <div class="input-date-wrap">
                        <input type="date" name="to_date" value="{{ $toDate }}">
                    </div>
                </div>
                <div class="detail-checkbox-wrap">
                    <label style="cursor:pointer; display:flex; align-items:center; gap:6px;">
                        <input type="checkbox" name="detail_data" value="1" {{ request('detail_data', '1') == '1' ? 'checked' : '' }}>
                        Detail Data
                    </label>
                </div>

                <!-- ROW 2: Branch/Outlet -->
                <span class="filter-label">Branch/Outlet</span>
                <div class="input-with-icon">
                    <input type="text" 
                           id="bm_display_input" 
                           value="{{ !empty($selectedBranchName) ? $selectedBranchName : '[SELECT ALL]' }}" 
                           placeholder="[SELECT ALL]" 
                           readonly 
                           style="cursor:pointer; background:#f8fafc; color:#0f172a; font-weight:600;" 
                           onclick="openBmModal()">
                    <button type="button" class="input-icon-btn" onclick="openBmModal()">▼</button>
                </div>

                <!-- ROW 3: Sales Head -->
                <span class="filter-label">Sales Head</span>
                <div class="input-with-icon">
                    <input type="text" 
                           id="spv_display_input" 
                           value="{{ !empty($selectedSpvName) ? $selectedSpvName : '[SELECT ALL]' }}" 
                           placeholder="[SELECT ALL]" 
                           readonly 
                           style="cursor:pointer; background:#f8fafc; color:#0f172a; font-weight:600;" 
                           onclick="openSpvModal()">
                    <button type="button" class="input-icon-btn" onclick="openSpvModal()">▼</button>
                </div>

                <!-- ROW 4: Salesman -->
                <span class="filter-label">Salesman</span>
                <div class="input-with-icon">
                    <input type="text" 
                           id="salesman_display_input" 
                           value="{{ !empty($selectedSalesmanName) ? $selectedSalesmanName : '[SELECT ALL]' }}" 
                           placeholder="[SELECT ALL]" 
                           readonly 
                           style="cursor:pointer; background:#f8fafc; color:#0f172a; font-weight:600;" 
                           onclick="openSalesmanModal()">
                    <button type="button" class="input-icon-btn" onclick="openSalesmanModal()">▼</button>
                </div>

                <!-- RIGHT ACTION BUTTONS -->
                <div class="filter-actions">
                    <button type="submit" class="btn-search-cyan">
                        🔍 Search
                    </button>
                    <button type="button" class="btn-expand-cyan" onclick="toggleExpandTable()">
                        Expand data
                    </button>
                </div>

            </div>
        </form>
    </div>

    <!-- TABLE CARD -->
    <div class="table-card">
        <div class="table-scroll-wrapper">
            <table class="table-custom" id="inquiryTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>EnquiryId (SID)</th>
                        <th>Pelanggan</th>
                        <th>No Handphone</th>
                        <th>Tipe Pelanggan</th>
                        <th>Tipe</th>
                        <th>Varian</th>
                        <th>Warna</th>
                        <th>Tgl Inquiry</th>
                        <th>Perolehan Data</th>
                        <th>Keterangan Lokasi</th>
                        <th>Koordinator (SH)</th>
                        <th>Last Progress</th>
                        <th>Tgl SPK</th>
                        <th>Tgl DO</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!$isSearched)
                        <tr>
                            <td colspan="15">
                                <div class="empty-state">
                                    <span class="empty-state-icon">🔍</span>
                                    <p style="font-weight:700; color:#dc2626; font-size:0.95rem;">Silakan atur filter di atas lalu klik tombol <strong>🔍 Search</strong> untuk menampilkan data.</p>
                                </div>
                            </td>
                        </tr>
                    @else
                        @forelse($data as $row)
                            @php
                                $progressClass = 'badge-p';
                                $prog = trim(strtoupper($row->LastProgress ?? ''));
                                if($prog === 'SPK') $progressClass = 'badge-spk';
                                elseif($prog === 'DO') $progressClass = 'badge-do';
                                elseif($prog === 'DELIVERY') $progressClass = 'badge-delivery';
                                elseif($prog === 'LOST') $progressClass = 'badge-lost';
                                elseif($prog === 'HP') $progressClass = 'badge-hp';

                                // Format ENQ SID matching office system
                                $enqSid = !empty($row->EnquiryID) ? $row->EnquiryID : ('ENQ' . ($row->BranchCode ?? '') . date('Y', strtotime($row->InquiryDate ?? date('Y-m-d'))) . str_pad(substr($row->InquiryNumber, -5), 5, '0', STR_PAD_LEFT));
                            @endphp
                            <tr>
                                <td class="text-center" style="font-weight:600; color:#475569;">{{ $row->InquiryNumber }}</td>
                                <td style="font-family:monospace; font-weight:600; color:#dc2626;">{{ $enqSid }}</td>
                                <td style="font-weight:600;">{{ $row->NamaProspek ?? '-' }}</td>
                                <td>{{ $row->Handphone ?? '-' }}</td>
                                <td>{{ !empty($row->NamaPerusahaan) ? 'Perusahaan' : 'Individu' }}</td>
                                <td style="font-weight:600;">{{ $row->TipeKendaraan ?? '-' }}</td>
                                <td>{{ $row->Variant ?? '-' }}</td>
                                <td>{{ $row->ColourCode ?? '-' }}</td>
                                <td>{{ !empty($row->InquiryDate) ? date('Y/m/d', strtotime($row->InquiryDate)) : '-' }}</td>
                                <td>{{ $row->PerolehanData ?? '-' }}</td>
                                <td>{{ $row->AlamatProspek ?? $row->CityID ?? '-' }}</td>
                                <td style="font-weight:600; color:#0f766e;">{{ $row->SalesHeadName ?? $row->SpvEmployeeID ?? '-' }}</td>
                                <td><span class="badge-progress {{ $progressClass }}">{{ $row->LastProgress ?? '-' }}</span></td>
                                <td>{{ !empty($row->SPKDate) ? date('Y/m/d', strtotime($row->SPKDate)) : '-' }}</td>
                                <td>{{ !empty($row->DODate) ? date('Y/m/d', strtotime($row->DODate)) : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="15">
                                    <div class="empty-state">
                                        <span class="empty-state-icon">📭</span>
                                        <p>Data inquiry tidak ditemukan untuk periode tanggal dan filter ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>

        <!-- PAGINATION FOOTER MATCHING OFFICE SYSTEM SCREENSHOT -->
        @if($isSearched && $data->total() > 0)
            <div class="pagination-footer">
                <div class="pagination-controls">
                    <!-- First Page -->
                    <a href="{{ $data->url(1) }}" class="page-nav-btn {{ $data->onFirstPage() ? 'disabled' : '' }}" title="Halaman Pertama">«</a>
                    
                    <!-- Previous Page -->
                    <a href="{{ $data->previousPageUrl() ?? '#' }}" class="page-nav-btn {{ $data->onFirstPage() ? 'disabled' : '' }}" title="Halaman Sebelumnya">‹</a>

                    <!-- Page Numbers -->
                    @php
                        $startPage = max(1, $data->currentPage() - 2);
                        $endPage = min($data->lastPage(), $data->currentPage() + 3);
                    @endphp

                    @for($p = $startPage; $p <= $endPage; $p++)
                        <a href="{{ $data->url($p) }}" class="page-num-btn {{ $p == $data->currentPage() ? 'active' : '' }}">{{ $p }}</a>
                    @endfor

                    <!-- Next Page -->
                    <a href="{{ $data->nextPageUrl() ?? '#' }}" class="page-nav-btn {{ !$data->hasMorePages() ? 'disabled' : '' }}" title="Halaman Berikutnya">›</a>

                    <!-- Last Page -->
                    <a href="{{ $data->url($data->lastPage()) }}" class="page-nav-btn {{ !$data->hasMorePages() ? 'disabled' : '' }}" title="Halaman Terakhir">»</a>

                    <div class="d-flex align-items-center gap-2 ms-3">
                        <select class="per-page-select" onchange="changePerPage(this.value)">
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            <option value="250" {{ request('per_page') == 250 ? 'selected' : '' }}>250</option>
                            <option value="500" {{ request('per_page', 500) == 500 ? 'selected' : '' }}>500</option>
                            <option value="1000" {{ request('per_page') == 1000 ? 'selected' : '' }}>1000</option>
                        </select>
                        <span>baris per halaman</span>
                    </div>
                </div>

                <div>
                    <span>{{ number_format($data->firstItem()) }} - {{ number_format($data->lastItem()) }} dari {{ number_format($data->total()) }} baris</span>
                </div>
            </div>
        @endif
    </div>

</div>

<!-- ===== MODAL BRANCH / OUTLET ===== -->
<div id="bmModal" class="custom-modal-overlay">
    <div class="modal-content-custom">
        <div class="modal-header-custom">
            <h5 class="modal-title-custom">🏢 Pilih Branch / Outlet</h5>
            <button type="button" class="modal-close-btn" onclick="closeBmModal()">✕</button>
        </div>
        <div class="modal-search-box">
            <input type="text" id="bmSearchInput" placeholder="Cari nama Cabang..." onkeyup="filterBmList()">
        </div>
        <div class="modal-list-group" id="bmListGroup">
            <div class="modal-list-item" onclick="selectBm('', '[SELECT ALL]', '')">
                <div>
                    <div class="modal-item-name" style="color:#60a5fa; font-weight:700;">[SELECT ALL]</div>
                </div>
            </div>
            @foreach(($branchesMap ?? []) as $code => $name)
                <div class="modal-list-item bm-item" onclick="selectBm('{{ $code }}', '{{ $name }}', '{{ $code }}')">
                    <div>
                        <div class="modal-item-name">{{ $name }}</div>
                        <div class="modal-item-code">{{ $code }}</div>
                    </div>
                    <span class="modal-item-badge">BRANCH</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- ===== MODAL SALES HEAD ===== -->
<div id="spvModal" class="custom-modal-overlay">
    <div class="modal-content-custom">
        <div class="modal-header-custom">
            <h5 class="modal-title-custom">👔 Pilih Sales Head</h5>
            <button type="button" class="modal-close-btn" onclick="closeSpvModal()">✕</button>
        </div>
        <div class="modal-search-box">
            <input type="text" id="spvSearchInput" placeholder="Cari nama Sales Head..." onkeyup="filterSpvList()">
        </div>
        <div class="modal-list-group" id="spvListGroup">
            <div class="modal-list-item" onclick="selectSpv('', '[SELECT ALL]')">
                <div>
                    <div class="modal-item-name" style="color:#60a5fa; font-weight:700;">[SELECT ALL]</div>
                </div>
            </div>
            @foreach(($spvsMap ?? []) as $id => $info)
                <div class="modal-list-item spv-item" 
                     data-branch="{{ $info['BranchCode'] }}"
                     onclick="selectSpv('{{ $id }}', '{{ $info['Name'] }}')">
                    <div>
                        <div class="modal-item-name">{{ $info['Name'] }}</div>
                        <div class="modal-item-code">{{ $id }}</div>
                    </div>
                    <span class="modal-item-badge">SALES HEAD</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- ===== MODAL SALESMAN ===== -->
<div id="salesmanModal" class="custom-modal-overlay">
    <div class="modal-content-custom">
        <div class="modal-header-custom">
            <h5 class="modal-title-custom">💼 Pilih Salesman</h5>
            <button type="button" class="modal-close-btn" onclick="closeSalesmanModal()">✕</button>
        </div>
        <div class="modal-search-box">
            <input type="text" id="salesmanSearchInput" placeholder="Cari nama Salesman..." onkeyup="filterSalesmanList()">
        </div>
        <div class="modal-list-group" id="salesmanListGroup">
            <div class="modal-list-item" onclick="selectSalesman('', '[SELECT ALL]')">
                <div>
                    <div class="modal-item-name" style="color:#60a5fa; font-weight:700;">[SELECT ALL]</div>
                </div>
            </div>
            @foreach(($salesmenMap ?? []) as $id => $info)
                <div class="modal-list-item salesman-item" 
                     data-branch="{{ $info['BranchCode'] }}"
                     data-spv="{{ $info['SpvEmployeeID'] }}"
                     onclick="selectSalesman('{{ $id }}', '{{ $info['Name'] }}')">
                    <div>
                        <div class="modal-item-name">{{ $info['Name'] }}</div>
                        <div class="modal-item-code">{{ $id }}</div>
                    </div>
                    <span class="modal-item-badge">SALES</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    function openBmModal() {
        document.getElementById('bmModal').classList.add('active');
    }
    function closeBmModal() {
        document.getElementById('bmModal').classList.remove('active');
    }

    function selectBm(code, name, branchCode) {
        document.getElementById('hidden_branch_code').value = code;
        document.getElementById('bm_display_input').value = name ? name : '[SELECT ALL]';

        document.getElementById('hidden_spv_id').value = '';
        document.getElementById('spv_display_input').value = '[SELECT ALL]';

        document.getElementById('hidden_salesman').value = '';
        document.getElementById('salesman_display_input').value = '[SELECT ALL]';

        filterSpvsBySelectedBranch(code);
        closeBmModal();
    }

    function filterBmList() {
        let q = document.getElementById('bmSearchInput').value.toLowerCase();
        let items = document.querySelectorAll('.bm-item');
        items.forEach(el => {
            let text = el.innerText.toLowerCase();
            el.style.display = text.includes(q) ? 'flex' : 'none';
        });
    }

    function openSpvModal() {
        let currentBranch = document.getElementById('hidden_branch_code').value;
        filterSpvsBySelectedBranch(currentBranch);
        document.getElementById('spvModal').classList.add('active');
    }
    function closeSpvModal() {
        document.getElementById('spvModal').classList.remove('active');
    }

    function filterSpvsBySelectedBranch(branchCode) {
        let items = document.querySelectorAll('.spv-item');
        items.forEach(el => {
            let itemBranch = el.getAttribute('data-branch');
            if (!branchCode || itemBranch === branchCode) {
                el.style.display = 'flex';
            } else {
                el.style.display = 'none';
            }
        });
    }

    function selectSpv(id, name) {
        document.getElementById('hidden_spv_id').value = id;
        document.getElementById('spv_display_input').value = name ? name : '[SELECT ALL]';

        document.getElementById('hidden_salesman').value = '';
        document.getElementById('salesman_display_input').value = '[SELECT ALL]';

        closeSpvModal();
    }

    function filterSpvList() {
        let q = document.getElementById('spvSearchInput').value.toLowerCase();
        let currentBranch = document.getElementById('hidden_branch_code').value;

        let items = document.querySelectorAll('.spv-item');
        items.forEach(el => {
            let text = el.innerText.toLowerCase();
            let itemBranch = el.getAttribute('data-branch');
            let matchesBranch = !currentBranch || itemBranch === currentBranch;
            let matchesSearch = text.includes(q);
            el.style.display = (matchesBranch && matchesSearch) ? 'flex' : 'none';
        });
    }

    function openSalesmanModal() {
        let currentBranch = document.getElementById('hidden_branch_code').value;
        let currentSpv = document.getElementById('hidden_spv_id').value;
        filterSalesmanListByContext(currentBranch, currentSpv);
        document.getElementById('salesmanModal').classList.add('active');
    }
    function closeSalesmanModal() {
        document.getElementById('salesmanModal').classList.remove('active');
    }

    function selectSalesman(id, name) {
        document.getElementById('hidden_salesman').value = id;
        document.getElementById('salesman_display_input').value = name ? name : '[SELECT ALL]';
        closeSalesmanModal();
    }

    function filterSalesmanListByContext(branchCode, spvId) {
        let q = document.getElementById('salesmanSearchInput').value.toLowerCase();
        let items = document.querySelectorAll('.salesman-item');
        items.forEach(el => {
            let text = el.innerText.toLowerCase();
            let itemBranch = el.getAttribute('data-branch');
            let itemSpv = el.getAttribute('data-spv');

            let matchesBranch = !branchCode || itemBranch === branchCode;
            let matchesSpv = !spvId || itemSpv === spvId;
            let matchesSearch = text.includes(q);

            el.style.display = (matchesBranch && matchesSpv && matchesSearch) ? 'flex' : 'none';
        });
    }

    function filterSalesmanList() {
        let currentBranch = document.getElementById('hidden_branch_code').value;
        let currentSpv = document.getElementById('hidden_spv_id').value;
        filterSalesmanListByContext(currentBranch, currentSpv);
    }

    function changePerPage(val) {
        document.getElementById('hidden_per_page').value = val;
        document.getElementById('filterForm').submit();
    }

    let isExpanded = false;
    function toggleExpandTable() {
        isExpanded = !isExpanded;
        let cells = document.querySelectorAll('.table-custom th, .table-custom td');
        cells.forEach(c => {
            if(isExpanded) {
                c.style.whiteSpace = 'normal';
                c.style.padding = '12px 14px';
            } else {
                c.style.whiteSpace = 'nowrap';
                c.style.padding = '8px 12px';
            }
        });
    }

    // Close modal on outside click
    window.onclick = function(event) {
        if (event.target.classList.contains('custom-modal-overlay')) {
            event.target.classList.remove('active');
        }
    };
</script>
@endsection
