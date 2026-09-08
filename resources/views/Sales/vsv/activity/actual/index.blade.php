@extends('layouts.app')
@section('title', 'Activity Actual')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');

    .activity-wrapper {
        padding: 24px 16px;
        max-width: 1440px;
        margin: 0 auto;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* HEADER & JUDUL MODERN */
    .page-title {
        text-align: center;
        font-weight: 900;
        color: #0f172a;
        text-shadow: 0px 4px 15px rgba(220, 38, 38, 0.2);
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 4px;
        font-size: 1.65rem;
    }
    .page-subtitle {
        text-align: center;
        color: #64748b;
        margin-bottom: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    /* TOOLBAR MODERN GLASS */
    .toolbar-wrap {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
        background: #0f172a;
        padding: 12px 20px;
        border-radius: 14px;
        border: 1px solid #1e293b;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.25);
    }
    .btn-nav {
        padding: 7px 14px;
        background: #1e293b;
        color: #e2e8f0;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.78rem;
        border: 1px solid #334155;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-nav:hover {
        background: #334155;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .btn-pdf { background: #dc2626; border-color: #ef4444; color: #ffffff; }
    .btn-pdf:hover { background: #b91c1c; color: #ffffff; }
    .btn-excel { background: #16a34a; border-color: #22c55e; color: #ffffff; }
    .btn-excel:hover { background: #15803d; color: #ffffff; }
    
    .btn-create {
        padding: 8px 18px;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #ffffff !important;
        font-weight: 800;
        text-decoration: none;
        border-radius: 8px;
        font-size: 0.8rem;
        border: 1px solid #ef4444;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.35);
    }
    .btn-create:hover {
        background: linear-gradient(135deg, #b91c1c, #991b1b);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(220, 38, 38, 0.45);
    }

    /* BRANCH FILTER SELECTOR */
    .branch-selector-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .branch-select {
        background: #1e293b;
        color: #f8fafc;
        border: 1.5px solid #475569;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 0.78rem;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        outline: none;
    }
    .branch-select:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.3);
    }

    .branch-active-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #b91c1c;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.78rem;
        margin-bottom: 14px;
    }

    /* CARD & TABEL UTAMA */
    .table-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 10px 30px -5px rgba(0,0,0,0.06), 0 4px 6px -2px rgba(0,0,0,0.02);
        border: 1px solid #e2e8f0;
        overflow-x: auto;
        margin-bottom: 24px;
    }

    .table-summary {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.78rem;
        font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
        color: #1e293b;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #cbd5e1;
    }

    .table-summary th, .table-summary td {
        border-right: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
        padding: 9px 12px;
        vertical-align: middle;
        white-space: nowrap;
    }
    .table-summary th:last-child, .table-summary td:last-child {
        border-right: none;
    }

    /* HEADER STYLING MODERN */
    .table-summary thead tr:first-child th {
        font-weight: 800;
        text-align: center;
        font-size: 0.78rem;
        letter-spacing: 0.5px;
        padding: 10px 12px;
    }
    .table-summary thead tr:first-child th.th-main-left {
        background: #f1f5f9;
        color: #0f172a;
    }
    .table-summary thead tr:first-child th.th-its {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
        border-bottom: 1px solid #93c5fd;
    }
    .table-summary thead tr:first-child th.th-cost {
        background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
        color: #5b21b6;
        border-bottom: 1px solid #c4b5fd;
    }

    .table-summary thead tr:nth-child(2) th {
        font-weight: 700;
        text-align: center;
        font-size: 0.73rem;
        padding: 8px 10px;
    }
    .table-summary thead tr:nth-child(2) th.th-sub-inq { background: #eff6ff; color: #1d4ed8; }
    .table-summary thead tr:nth-child(2) th.th-sub-spk { background: #dbeafe; color: #1e40af; }
    .table-summary thead tr:nth-child(2) th.th-sub-do  { background: #eff6ff; color: #1d4ed8; }
    .table-summary thead tr:nth-child(2) th.th-sub-cost { background: #f5f3ff; color: #6d28d9; }

    /* ROW SUB-COLUMNS (ACT / TGT) */
    .tr-subcols th {
        background: #f8fafc;
        font-size: 0.68rem;
        color: #64748b;
        font-weight: 800;
        text-align: center;
        padding: 6px 8px;
    }
    .tr-subcols th.th-act { background: #f1f5f9; color: #334155; }
    .tr-subcols th.th-tgt { background: #e2e8f0; color: #1e293b; }

    /* EDIT ICON BESIDE TARGET & BUDGET */
    .btn-edit-header {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-left: 4px;
        cursor: pointer;
        padding: 3px 5px;
        border-radius: 6px;
        background: rgba(37, 99, 235, 0.12);
        transition: all 0.2s ease;
        vertical-align: middle;
        text-decoration: none;
    }
    .btn-edit-header:hover {
        background: #2563eb;
        transform: scale(1.15);
    }
    .btn-edit-header:hover svg {
        color: #ffffff !important;
    }
    .btn-edit-header svg {
        color: #2563eb;
        transition: color 0.2s ease;
    }

    .btn-edit-purple {
        background: rgba(109, 40, 217, 0.12);
    }
    .btn-edit-purple:hover {
        background: #7c3aed;
    }
    .btn-edit-purple svg {
        color: #7c3aed;
    }

    .btn-edit-row {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-left: 6px;
        padding: 2px 5px;
        border-radius: 4px;
        background: #fee2e2;
        color: #dc2626;
        text-decoration: none;
        font-size: 0.68rem;
        transition: all 0.2s ease;
        opacity: 0.7;
    }
    .data-row:hover .btn-edit-row {
        opacity: 1;
    }
    .btn-edit-row:hover {
        background: #dc2626;
        color: #ffffff;
        transform: scale(1.1);
    }

    /* SECTION HEADER ROWS */
    .tr-section-header td {
        background: linear-gradient(90deg, #f8fafc 0%, #f1f5f9 100%);
        font-weight: 800;
        color: #0f172a;
        letter-spacing: 0.5px;
        font-size: 0.82rem;
        text-align: left;
        padding: 10px 14px;
        border-left: 4px solid #dc2626;
        border-top: 1.5px solid #cbd5e1 !important;
    }

    /* SPACER BETWEEN SECTIONS */
    .tr-section-spacer td {
        height: 26px !important;
        background: #ffffff !important;
        border: none !important;
        padding: 0 !important;
    }

    /* DATA ROWS */
    .table-summary tbody tr.data-row {
        background: #ffffff;
        transition: all 0.15s ease;
    }
    .table-summary tbody tr.data-row:nth-child(even) {
        background: #fbfcfd;
    }
    .table-summary tbody tr.data-row:hover {
        background: #f1f5f9;
    }

    .table-summary td.text-center { text-align: center; font-weight: 600; }
    .table-summary td.text-left   { text-align: left; font-weight: 700; color: #1e293b; padding-left: 16px; }
    .table-summary td.text-right  { text-align: right; font-variant-numeric: tabular-nums; font-weight: 600; }

    /* HIGHLIGHT NUMBERS */
    .num-muted { color: #94a3b8; font-weight: 500; }
    .num-bold  { color: #0f172a; font-weight: 700; }
    .num-red   { color: #dc2626; font-weight: 800; }
    .num-blue  { color: #2563eb; font-weight: 700; }

    /* TOTAL ROW */
    .tr-total td {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%) !important;
        color: #78350f !important;
        font-weight: 900 !important;
        font-size: 0.82rem !important;
        border-top: 2px solid #f59e0b !important;
        border-bottom: 2px solid #f59e0b !important;
        padding: 10px 12px;
    }

    /* FOOTNOTE BADGE */
    .footer-wrap {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-top: 14px;
    }
    .cutoff-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.76rem;
        color: #475569;
        font-weight: 600;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    /* RECORDS DETAIL TABLE */
    .records-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 10px 30px -5px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0;
        margin-top: 20px;
    }
    .records-title {
        font-size: 0.95rem;
        font-weight: 800;
        color: #0f172a;
        text-transform: uppercase;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .table-records {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.76rem;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        overflow: hidden;
    }
    .table-records th {
        background: #f1f5f9;
        color: #334155;
        font-weight: 700;
        padding: 8px 10px;
        text-align: center;
        border-bottom: 1.5px solid #cbd5e1;
        border-right: 1px solid #e2e8f0;
    }
    .table-records td {
        padding: 8px 10px;
        border-bottom: 1px solid #e2e8f0;
        border-right: 1px solid #e2e8f0;
        vertical-align: middle;
    }
    .badge-cabang {
        background: #fee2e2;
        color: #991b1b;
        padding: 2px 8px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.72rem;
    }
    .btn-action-edit {
        background: #3b82f6;
        color: #fff;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.72rem;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }
    .btn-action-delete {
        background: #ef4444;
        color: #fff;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.72rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }
</style>

<div class="activity-wrapper">
    <h1 class="page-title">ACTIVITY ACTUAL</h1>
    <p class="page-subtitle">Summary Marketing Activity & ITS Performance Matrix</p>

    <div class="toolbar-wrap">
        <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
            <a href="{{ url('/activity/dashboard') }}" class="btn-nav">← Dashboard</a>
            <a href="{{ url()->current() }}" class="btn-nav">🔄 Refresh</a>
            <a href="{{ route('activity.actual.pdf', ['cabang' => $selectedCabang, 'bulan' => $currMonthNum, 'tahun' => $currYear]) }}" class="btn-nav btn-pdf">📄 Export PDF</a>
            <a href="{{ route('activity.actual.excel', ['cabang' => $selectedCabang, 'bulan' => $currMonthNum, 'tahun' => $currYear]) }}" class="btn-nav btn-excel">📊 Excel</a>
        </div>

        <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
            {{-- DROPDOWN FILTER CABANG --}}
            <div class="branch-selector-wrap">
                <span style="color:#94a3b8; font-size:0.75rem; font-weight:700;">📍 CABANG:</span>
                @if(!empty($isPusat))
                    <select class="branch-select" id="filter-cabang" onchange="applyFilters()">
                        <option value="" {{ empty($selectedCabang) || $selectedCabang == 'Semua Cabang' ? 'selected' : '' }}>Semua Cabang (Pusat)</option>
                        @foreach(['Ciawi', 'Cianjur', 'Cinere', 'Jatiasih', 'Cipanas'] as $cb)
                            <option value="{{ $cb }}" {{ ($selectedCabang == $cb) ? 'selected' : '' }}>Cabang {{ $cb }}</option>
                        @endforeach
                    </select>
                @else
                    <select class="branch-select" id="filter-cabang" disabled style="opacity: 0.9; cursor: not-allowed; background: #0f172a; color: #38bdf8; font-weight: 700;">
                        <option value="{{ $selectedCabang }}">Cabang {{ $selectedCabang }}</option>
                    </select>
                @endif
            </div>

            {{-- DROPDOWN FILTER BULAN --}}
            <div class="branch-selector-wrap">
                <span style="color:#94a3b8; font-size:0.75rem; font-weight:700;">📅 BULAN:</span>
                <select class="branch-select" id="filter-bulan" onchange="applyFilters()">
                    @php
                        $bulanList = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                    @endphp
                    @foreach($bulanList as $num => $bName)
                        <option value="{{ $num }}" {{ $currMonthNum == $num ? 'selected' : '' }}>{{ $bName }}</option>
                    @endforeach
                </select>
            </div>

            {{-- DROPDOWN FILTER TAHUN --}}
            <div class="branch-selector-wrap">
                <span style="color:#94a3b8; font-size:0.75rem; font-weight:700;">🗓️ TAHUN:</span>
                <select class="branch-select" id="filter-tahun" onchange="applyFilters()">
                    @for($y = 2024; $y <= 2028; $y++)
                        <option value="{{ $y }}" {{ $currYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
        </div>
    </div>

    <div>
        <span class="branch-active-pill">
            📍 Cabang: <strong>{{ !empty($selectedCabang) && $selectedCabang !== 'Semua Cabang' ? $selectedCabang : 'Semua Cabang (Pusat)' }}</strong>
            &nbsp;•&nbsp; 📅 Periode: <strong>{{ $bulanList[$currMonthNum] ?? $currMonthNum }} {{ $currYear }}</strong>
            <span style="background: rgba(220, 38, 38, 0.15); color: #dc2626; padding: 2px 6px; border-radius: 4px; font-size: 0.68rem; margin-left: 6px; font-weight: 800;">
                ACTUAL / EVALUASI
            </span>
        </span>
    </div>

    @php
        $activeCabangTarget = (!empty($selectedCabang) && $selectedCabang !== 'Semua Cabang') ? $selectedCabang : 'Ciawi';

        // LIST MODEL DARI FOTO 4
        $unitModels = [
            'NEW CARRY',
            'APV',
            'ERTIGA-HYBRID',
            'NEW XL-7',
            'GRAND-VITARA',
            'JIMNY',
            'FRONX',
            'S-PRESSO'
        ];

        // LIST BY ACTIVITY DARI FOTO 5
        $activityList = [
            'Call In (Dari iklan)',
            'Canvasing',
            'Database',
            'Exhibition/Event',
            'Media Digital',
            'Mediator',
            'Referensi Customer',
            'Showroom Walk-in',
            'Website Dealer',
            'Workshop Inquiry'
        ];

        if (!isset($byTypeData) || empty($byTypeData)) {
            $byTypeData = [];
            $totType = [
                'qty' => 0, 'inq_act' => 0, 'inq_tgt' => 0, 'spk_act' => 0, 'spk_tgt' => 0,
                'do_act' => 0, 'do_tgt' => 0, 'budget' => 0, 'per_spk' => 0
            ];
            foreach ($unitModels as $mName) {
                $byTypeData[$mName] = ['qty' => 0, 'inq_act' => 0, 'inq_tgt' => 0, 'spk_act' => 0, 'spk_tgt' => 0, 'do_act' => 0, 'do_tgt' => 0, 'budget' => 0, 'per_spk' => 0];
            }
        }

        if (!isset($byActData) || empty($byActData)) {
            $byActData = [];
            $totAct = [
                'qty' => 0, 'inq_act' => 0, 'inq_tgt' => 0, 'spk_act' => 0, 'spk_tgt' => 0,
                'do_act' => 0, 'do_tgt' => 0, 'budget' => 0, 'per_spk' => 0
            ];
            foreach ($activityList as $aName) {
                $byActData[$aName] = ['qty' => 0, 'inq_act' => 0, 'inq_tgt' => 0, 'spk_act' => 0, 'spk_tgt' => 0, 'do_act' => 0, 'do_tgt' => 0, 'budget' => 0, 'per_spk' => 0];
            }
        }
    @endphp

    <div class="table-card">
        <table class="table-summary">
            <thead>
                <tr>
                    <th rowspan="3" class="th-main-left" style="width: 45px;">NO</th>
                    <th rowspan="3" class="th-main-left" style="min-width: 190px; text-align: left; padding-left: 16px;">REMARK</th>
                    <th rowspan="3" class="th-main-left" style="width: 90px; vertical-align: middle;">
                        QTY<br>ACTIVITIES
                        <a href="{{ route('activity.actual.create', ['cabang' => $activeCabangTarget, 'bulan' => $currMonthNum, 'tahun' => $currYear, 'target' => 'qty']) }}" class="btn-edit-header" title="Input / Edit QTY Activities">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </a>
                    </th>
                    <th colspan="6" class="th-its">ITS RESULT</th>
                    <th colspan="2" class="th-cost">COST EFFICIENCY</th>
                </tr>
                <tr>
                    <th colspan="2" class="th-sub-inq">INQ</th>
                    <th colspan="2" class="th-sub-spk">SPK</th>
                    <th colspan="2" class="th-sub-do">DO</th>
                    <th rowspan="2" class="th-sub-cost" style="min-width: 135px; vertical-align: middle;">
                        TOTAL BUDGET
                        <a href="{{ route('activity.actual.create', ['cabang' => $activeCabangTarget, 'bulan' => $currMonthNum, 'tahun' => $currYear, 'target' => 'budget']) }}" class="btn-edit-header btn-edit-purple" title="Input / Edit Total Budget">
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </a>
                    </th>
                    <th rowspan="2" class="th-sub-cost" style="min-width: 130px; vertical-align: middle;">
                        PER SPK
                        <a href="{{ route('activity.actual.create', ['cabang' => $activeCabangTarget, 'bulan' => $currMonthNum, 'tahun' => $currYear, 'target' => 'perspk']) }}" class="btn-edit-header btn-edit-purple" title="Input / Edit Cost Per SPK">
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </a>
                    </th>
                </tr>
                <tr class="tr-subcols">
                    <th class="th-act" style="width: 48px;">ACT</th>
                    <th class="th-tgt" style="width: 54px;">
                        TGT
                        <a href="{{ route('activity.actual.create', ['cabang' => $activeCabangTarget, 'bulan' => $currMonthNum, 'tahun' => $currYear, 'target' => 'inq']) }}" class="btn-edit-header" title="Input / Edit Target INQ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </a>
                    </th>
                    <th class="th-act" style="width: 48px;">ACT</th>
                    <th class="th-tgt" style="width: 54px;">
                        TGT
                        <a href="{{ route('activity.actual.create', ['cabang' => $activeCabangTarget, 'bulan' => $currMonthNum, 'tahun' => $currYear, 'target' => 'spk']) }}" class="btn-edit-header" title="Input / Edit Target SPK">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </a>
                    </th>
                    <th class="th-act" style="width: 48px;">ACT</th>
                    <th class="th-tgt" style="width: 54px;">
                        TGT
                        <a href="{{ route('activity.actual.create', ['cabang' => $activeCabangTarget, 'bulan' => $currMonthNum, 'tahun' => $currYear, 'target' => 'do']) }}" class="btn-edit-header" title="Input / Edit Target DO">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                {{-- ================= SECTION 1: # BY TYPE ================= --}}
                <tr class="tr-section-header">
                    <td colspan="11"># BY TYPE</td>
                </tr>
                @foreach ($unitModels as $idx => $model)
                    @php $row = $byTypeData[$model]; @endphp
                    <tr class="data-row">
                        <td class="text-center" style="color: #64748b;">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $model }}</td>
                        <td class="text-center {{ $row['qty'] > 0 ? 'num-bold' : 'num-muted' }}">{{ $row['qty'] > 0 ? number_format($row['qty'], 0, ',', '.') : '-' }}</td>
                        
                        {{-- INQ --}}
                        <td class="text-center {{ $row['inq_act'] > 0 ? 'num-bold' : 'num-muted' }}">{{ $row['inq_act'] > 0 ? number_format($row['inq_act'], 0, ',', '.') : '-' }}</td>
                        <td class="text-center {{ $row['inq_tgt'] > 0 ? 'num-blue' : 'num-muted' }}">{{ $row['inq_tgt'] > 0 ? number_format($row['inq_tgt'], 0, ',', '.') : '-' }}</td>
                        
                        {{-- SPK --}}
                        <td class="text-center {{ $row['spk_act'] > 0 ? 'num-bold' : 'num-muted' }}">{{ $row['spk_act'] > 0 ? number_format($row['spk_act'], 0, ',', '.') : '-' }}</td>
                        <td class="text-center {{ $row['spk_tgt'] > 0 ? 'num-blue' : 'num-muted' }}">{{ $row['spk_tgt'] > 0 ? number_format($row['spk_tgt'], 0, ',', '.') : '-' }}</td>
                        
                        {{-- DO --}}
                        <td class="text-center {{ $row['do_act'] > 0 ? 'num-red' : 'num-muted' }}">{{ $row['do_act'] > 0 ? number_format($row['do_act'], 0, ',', '.') : '-' }}</td>
                        <td class="text-center {{ $row['do_tgt'] > 0 ? 'num-blue' : 'num-muted' }}">{{ $row['do_tgt'] > 0 ? number_format($row['do_tgt'], 0, ',', '.') : '-' }}</td>
                        
                        {{-- COST EFFICIENCY --}}
                        <td class="text-right {{ $row['budget'] > 0 ? 'num-bold' : 'num-muted' }}">
                            {{ $row['budget'] > 0 ? 'Rp ' . number_format($row['budget'], 0, ',', '.') : 'Rp -' }}
                        </td>
                        <td class="text-right {{ $row['per_spk'] > 0 ? 'num-bold' : 'num-muted' }}">
                            {{ $row['per_spk'] > 0 ? 'Rp ' . number_format($row['per_spk'], 0, ',', '.') : 'Rp -' }}
                        </td>
                    </tr>
                @endforeach

                {{-- TOTAL # BY TYPE --}}
                <tr class="tr-total">
                    <td colspan="2" class="text-center" style="letter-spacing: 1px;">TOTAL</td>
                    <td class="text-center {{ $totType['qty'] > 0 ? 'num-bold' : 'num-muted' }}">{{ $totType['qty'] > 0 ? number_format($totType['qty'], 0, ',', '.') : '-' }}</td>
                    <td class="text-center">{{ $totType['inq_act'] > 0 ? number_format($totType['inq_act'], 0, ',', '.') : '-' }}</td>
                    <td class="text-center">{{ $totType['inq_tgt'] > 0 ? number_format($totType['inq_tgt'], 0, ',', '.') : '-' }}</td>
                    <td class="text-center">{{ $totType['spk_act'] > 0 ? number_format($totType['spk_act'], 0, ',', '.') : '-' }}</td>
                    <td class="text-center">{{ $totType['spk_tgt'] > 0 ? number_format($totType['spk_tgt'], 0, ',', '.') : '-' }}</td>
                    <td class="text-center">{{ $totType['do_act'] > 0 ? number_format($totType['do_act'], 0, ',', '.') : '-' }}</td>
                    <td class="text-center">{{ $totType['do_tgt'] > 0 ? number_format($totType['do_tgt'], 0, ',', '.') : '-' }}</td>
                    <td class="text-right">{{ $totType['budget'] > 0 ? 'Rp ' . number_format($totType['budget'], 0, ',', '.') : 'Rp -' }}</td>
                    <td class="text-right">{{ $totType['per_spk'] > 0 ? 'Rp ' . number_format($totType['per_spk'], 0, ',', '.') : 'Rp -' }}</td>
                </tr>

                {{-- SPACER ROW ANTARA SECTION (FOTO 2) --}}
                <tr class="tr-section-spacer">
                    <td colspan="11"></td>
                </tr>

                {{-- ================= SECTION 2: # BY ACTIVITY ================= --}}
                <tr class="tr-section-header">
                    <td colspan="11"># BY ACTIVITY</td>
                </tr>
                @foreach ($activityList as $idx => $act)
                    @php $row = $byActData[$act]; @endphp
                    <tr class="data-row">
                        <td class="text-center" style="color: #64748b;">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $act }}</td>
                        <td class="text-center {{ $row['qty'] > 0 ? 'num-bold' : 'num-muted' }}">{{ $row['qty'] > 0 ? number_format($row['qty'], 0, ',', '.') : '-' }}</td>
                        
                        {{-- INQ --}}
                        <td class="text-center {{ $row['inq_act'] > 0 ? 'num-bold' : 'num-muted' }}">{{ $row['inq_act'] > 0 ? number_format($row['inq_act'], 0, ',', '.') : '-' }}</td>
                        <td class="text-center {{ $row['inq_tgt'] > 0 ? 'num-blue' : 'num-muted' }}">{{ $row['inq_tgt'] > 0 ? number_format($row['inq_tgt'], 0, ',', '.') : '-' }}</td>
                        
                        {{-- SPK --}}
                        <td class="text-center {{ $row['spk_act'] > 0 ? 'num-bold' : 'num-muted' }}">{{ $row['spk_act'] > 0 ? number_format($row['spk_act'], 0, ',', '.') : '-' }}</td>
                        <td class="text-center {{ $row['spk_tgt'] > 0 ? 'num-blue' : 'num-muted' }}">{{ $row['spk_tgt'] > 0 ? number_format($row['spk_tgt'], 0, ',', '.') : '-' }}</td>
                        
                        {{-- DO --}}
                        <td class="text-center {{ $row['do_act'] > 0 ? 'num-red' : 'num-muted' }}">{{ $row['do_act'] > 0 ? number_format($row['do_act'], 0, ',', '.') : '-' }}</td>
                        <td class="text-center {{ $row['do_tgt'] > 0 ? 'num-blue' : 'num-muted' }}">{{ $row['do_tgt'] > 0 ? number_format($row['do_tgt'], 0, ',', '.') : '-' }}</td>
                        
                        {{-- COST EFFICIENCY --}}
                        <td class="text-right {{ $row['budget'] > 0 ? 'num-bold' : 'num-muted' }}">
                            {{ $row['budget'] > 0 ? 'Rp ' . number_format($row['budget'], 0, ',', '.') : 'Rp -' }}
                        </td>
                        <td class="text-right {{ $row['per_spk'] > 0 ? 'num-bold' : 'num-muted' }}">
                            {{ $row['per_spk'] > 0 ? 'Rp ' . number_format($row['per_spk'], 0, ',', '.') : 'Rp -' }}
                        </td>
                    </tr>
                @endforeach

                {{-- TOTAL # BY ACTIVITY --}}
                <tr class="tr-total">
                    <td colspan="2" class="text-center" style="letter-spacing: 1px;">TOTAL</td>
                    <td class="text-center {{ $totAct['qty'] > 0 ? 'num-bold' : 'num-muted' }}">{{ $totAct['qty'] > 0 ? number_format($totAct['qty'], 0, ',', '.') : '-' }}</td>
                    <td class="text-center">{{ $totAct['inq_act'] > 0 ? number_format($totAct['inq_act'], 0, ',', '.') : '-' }}</td>
                    <td class="text-center">{{ $totAct['inq_tgt'] > 0 ? number_format($totAct['inq_tgt'], 0, ',', '.') : '-' }}</td>
                    <td class="text-center">{{ $totAct['spk_act'] > 0 ? number_format($totAct['spk_act'], 0, ',', '.') : '-' }}</td>
                    <td class="text-center">{{ $totAct['spk_tgt'] > 0 ? number_format($totAct['spk_tgt'], 0, ',', '.') : '-' }}</td>
                    <td class="text-center">{{ $totAct['do_act'] > 0 ? number_format($totAct['do_act'], 0, ',', '.') : '-' }}</td>
                    <td class="text-center">{{ $totAct['do_tgt'] > 0 ? number_format($totAct['do_tgt'], 0, ',', '.') : '-' }}</td>
                    <td class="text-right">{{ $totAct['budget'] > 0 ? 'Rp ' . number_format($totAct['budget'], 0, ',', '.') : 'Rp -' }}</td>
                    <td class="text-right">{{ $totAct['per_spk'] > 0 ? 'Rp ' . number_format($totAct['per_spk'], 0, ',', '.') : 'Rp -' }}</td>
                </tr>
            </tbody>
        </table>

        <div class="footer-wrap">
            <div class="cutoff-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#2563eb;">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                Cut Off ITS Per tanggal {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y') }}
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function applyFilters() {
        const cb = document.getElementById('filter-cabang').value;
        const bln = document.getElementById('filter-bulan').value;
        const thn = document.getElementById('filter-tahun').value;
        
        let url = '{{ route("activity.actual.index") }}?cabang=' + encodeURIComponent(cb) + '&bulan=' + encodeURIComponent(bln) + '&tahun=' + encodeURIComponent(thn);
        window.location.href = url;
    }

    function confirmDeleteRecord(formId) {
        Swal.fire({
            title: 'Hapus Data Aktivitas?',
            text: 'Data yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
</script>
@endsection

