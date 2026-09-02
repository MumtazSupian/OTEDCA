@extends('layouts.app')

@section('title', 'Dashboard V3 - ITS RESULT')

@section('content')
<style>
    .v3-container {
        padding: 10px 0 30px 0;
    }

    .v3-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
    }

    .v3-header h1 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .v3-header p {
        font-size: 0.85rem;
        color: #64748b;
        margin: 0;
    }

    /* FILTER CARD */
    .v3-filter-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 16px 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
        margin-bottom: 22px;
    }

    .v3-filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 14px;
        align-items: flex-end;
    }

    .v3-form-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .v3-form-group label {
        font-size: 11.5px;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin: 0;
    }

    .v3-form-control {
        width: 100%;
        padding: 8px 12px;
        font-size: 13px;
        color: #1e293b;
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        outline: none;
        transition: all 0.2s ease;
    }

    .v3-form-control:focus {
        border-color: #2563eb;
        background-color: #fff;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .btn-filter-v3 {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: white !important;
        padding: 9px 18px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-filter-v3:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    .btn-pdf-v3 {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #ef4444;
        color: white !important;
        padding: 9px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-pdf-v3:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }

    /* ITS RESULT CARD */
    .its-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.04);
        border: 1px solid #e2e8f0;
        margin-bottom: 25px;
    }

    .its-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #0f172a;
        padding-bottom: 10px;
        margin-bottom: 18px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .badge-cabang-v3 {
        font-size: 11px;
        background: #e0f2fe;
        color: #0369a1;
        padding: 3px 10px;
        border-radius: 20px;
        font-weight: 700;
        border: 1px solid #bae6fd;
    }

    .badge-sh-v3 {
        font-size: 11px;
        background: #fdf4ff;
        color: #a21caf;
        padding: 3px 10px;
        border-radius: 20px;
        font-weight: 700;
        border: 1px solid #f5d0fe;
    }

    .its-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(520px, 1fr));
        gap: 20px;
        align-items: start;
    }

    @media (max-width: 600px) {
        .its-grid {
            grid-template-columns: 1fr;
        }
    }

    .its-table-wrap {
        margin-bottom: 16px;
        overflow-x: auto;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .its-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
        text-align: center;
        background: #ffffff;
    }

    .its-table th {
        padding: 6px 4px;
        font-weight: 700;
        border: 1px solid #cbd5e1;
        font-size: 10.5px;
        text-transform: uppercase;
    }

    .its-table td {
        border: 1px solid #cbd5e1;
        padding: 3.5px 5px;
        font-size: 10.5px;
        vertical-align: middle;
    }

    .model-sidebar-label {
        background: #f8fafc;
        font-weight: 800;
        font-size: 11px;
        text-align: center;
        vertical-align: middle;
        width: 44px;
        color: #1e293b;
        writing-mode: vertical-lr;
        transform: rotate(180deg);
        letter-spacing: 2px;
        border: 1px solid #cbd5e1;
    }
</style>

<div class="v3-container">
    {{-- Header --}}
    <div class="v3-header">
        <div>
            <h1>
                📊 ITS RESULT ({{ strtoupper($selectedCabang) }})
            </h1>
            <p>Monitoring data Inquiry, Test Drive, SPK, Faktur Polisi & Closing Ratio 13 Bulan per Cabang & Tim Sales Head.</p>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="v3-filter-card">
        <form action="{{ route('sales.vsv.dashboard.v3') }}" method="GET">
            <div class="v3-filter-grid">
                {{-- Cabang --}}
                @if($isPusat)
                <div class="v3-form-group">
                    <label for="cabang">CABANG</label>
                    <select name="cabang" id="cabang" class="v3-form-control" onchange="this.form.submit()">
                        @foreach($cabangs as $cb)
                            <option value="{{ $cb }}" {{ $selectedCabang == $cb ? 'selected' : '' }}>{{ $cb }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                {{-- Tim Sales Head (SH) --}}
                <div class="v3-form-group">
                    <label for="spv">TIM SALES HEAD</label>
                    <select name="spv" id="spv" class="v3-form-control">
                        <option value="">-- Semua Tim Sales Head --</option>
                        @foreach($spvsForBranch as $spvId => $spvName)
                            <option value="{{ $spvId }}" {{ $selectedSpv == $spvId ? 'selected' : '' }}>
                                {{ $spvName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Bulan Acuan --}}
                <div class="v3-form-group">
                    <label for="filter_bulan">BULAN ACUAN</label>
                    <select name="filter_bulan" id="filter_bulan" class="v3-form-control">
                        @foreach($bulanMap as $num => $b)
                            <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                                {{ strtoupper($b) }} ({{ \App\Models\Sales\faktur\Faktur::BULAN_NAMA_LENGKAP[$b] ?? $b }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tahun Acuan --}}
                <div class="v3-form-group">
                    <label for="tahun">TAHUN ACUAN</label>
                    <select name="tahun" id="tahun" class="v3-form-control">
                        @for($y = date('Y') + 1; $y >= 2023; $y--)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                {{-- Filter Action --}}
                <div style="display: flex; gap: 8px;">
                    <button type="submit" class="btn-filter-v3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        Tampilkan Data
                    </button>
                    @if($selectedSpv || ($isPusat && $selectedCabang !== 'Ciawi') || $bulan !== 'sep' || $tahun != 2026)
                        <a href="{{ route('sales.vsv.dashboard.v3') }}" style="display: inline-flex; align-items: center; justify-content: center; padding: 8px 12px; background: #f1f5f9; color: #475569; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600;">
                            Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    {{-- ITS RESULT CARD --}}
    <div class="its-card">
        <div class="its-card-header">
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <h3 style="font-weight: 800; font-size: 14px; color: #0f172a; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                    📈 HASIL ITS RESULT
                </h3>
                <span class="badge-cabang-v3">
                    Cabang: {{ strtoupper($selectedCabang) }}
                </span>
                <span class="badge-sh-v3">
                    Tim: {{ !empty($selectedSpv) && isset($spvsForBranch[$selectedSpv]) ? $spvsForBranch[$selectedSpv] : 'Semua Sales Head' }}
                </span>
                <span style="font-size: 11px; background: #f1f5f9; color: #334155; padding: 3px 10px; border-radius: 20px; font-weight: 600;">
                    Periode Acuan: {{ strtoupper($bulan) }} {{ $tahun }}
                </span>
            </div>
        </div>

        {{-- 2 Columns Grid Layout --}}
        <div class="its-grid">
            {{-- LEFT COLUMN: NEW CARRY, APV, ERTIGA, XL7 --}}
            <div>
                @foreach($its_result_data['left'] as $modelName => $rows)
                    <div class="its-table-wrap">
                        <table class="its-table">
                            <thead>
                                <tr style="background: #f8fafc; color: #1e293b;">
                                    <th style="width: 44px; background: #f1f5f9;"></th>
                                    <th style="width: 55px; background: #f1f5f9;"></th>
                                    <th style="background: #e0f2fe; color: #0369a1; width: 48px;">INQ</th>
                                    <th style="background: #e0f2fe; color: #0369a1; width: 48px;">INQ TD</th>
                                    <th style="background: #fef08a; color: #854d0e; width: 44px;">SPK</th>
                                    <th style="background: #fed7aa; color: #9a3412; width: 44px;">FP</th>
                                    <th style="background: #e0e7ff; color: #3730a3; width: 56px;">INQtoSPK</th>
                                    <th style="background: #e0e7ff; color: #3730a3; width: 56px;">SPKtoFP</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rows as $idx => $r)
                                    @php $isCurrent = $r['is_current'] ?? false; @endphp
                                    <tr style="background: {{ $isCurrent ? '#fefce8' : '#ffffff' }}; font-weight: {{ $isCurrent ? '700' : 'normal' }};">
                                        @if($idx === 0)
                                            <td rowspan="{{ count($rows) }}" class="model-sidebar-label">
                                                {{ $modelName }}
                                            </td>
                                        @endif
                                        <td style="text-align: center; background: {{ $isCurrent ? '#fef08a' : '#f1f5f9' }}; color: #334155; font-weight: {{ $isCurrent ? '700' : '600' }}; font-size: 10px;">
                                            {{ $r['label'] }}
                                        </td>
                                        <td style="text-align: right; background: #f0fdf4; color: #166534; font-size: 10px;">
                                            {{ number_format($r['inq']) }}
                                        </td>
                                        <td style="text-align: right; background: #f0fdf4; color: #166534; font-size: 10px;">
                                            {{ number_format($r['inq_td']) }}
                                        </td>
                                        <td style="text-align: right; background: {{ $isCurrent ? '#facc15' : '#fef9c3' }}; color: #854d0e; font-weight: {{ $isCurrent ? '800' : '600' }}; font-size: 10px;">
                                            {{ number_format($r['spk']) }}
                                        </td>
                                        <td style="text-align: right; background: {{ $isCurrent ? '#fb923c' : '#ffedd5' }}; color: #7c2d12; font-weight: {{ $isCurrent ? '800' : '600' }}; font-size: 10px;">
                                            {{ number_format($r['fp']) }}
                                        </td>
                                        <td style="text-align: right; color: #475569; font-size: 10px;">
                                            {{ number_format($r['inq_to_spk'], 1) }}%
                                        </td>
                                        <td style="text-align: right; color: #475569; font-size: 10px;">
                                            {{ number_format($r['spk_to_fp'], 1) }}%
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>

            {{-- RIGHT COLUMN: GRAND VITARA, JIMNY, FRONX, SPRESSO --}}
            <div>
                @foreach($its_result_data['right'] as $modelName => $rows)
                    <div class="its-table-wrap">
                        <table class="its-table">
                            <thead>
                                <tr style="background: #f8fafc; color: #1e293b;">
                                    <th style="width: 44px; background: #f1f5f9;"></th>
                                    <th style="width: 55px; background: #f1f5f9;"></th>
                                    <th style="background: #e0f2fe; color: #0369a1; width: 48px;">INQ</th>
                                    <th style="background: #e0f2fe; color: #0369a1; width: 48px;">INQ TD</th>
                                    <th style="background: #fef08a; color: #854d0e; width: 44px;">SPK</th>
                                    <th style="background: #fed7aa; color: #9a3412; width: 44px;">FP</th>
                                    <th style="background: #e0e7ff; color: #3730a3; width: 56px;">INQtoSPK</th>
                                    <th style="background: #e0e7ff; color: #3730a3; width: 56px;">SPKtoFP</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rows as $idx => $r)
                                    @php $isCurrent = $r['is_current'] ?? false; @endphp
                                    <tr style="background: {{ $isCurrent ? '#fefce8' : '#ffffff' }}; font-weight: {{ $isCurrent ? '700' : 'normal' }};">
                                        @if($idx === 0)
                                            <td rowspan="{{ count($rows) }}" class="model-sidebar-label">
                                                {{ $modelName }}
                                            </td>
                                        @endif
                                        <td style="text-align: center; background: {{ $isCurrent ? '#fef08a' : '#f1f5f9' }}; color: #334155; font-weight: {{ $isCurrent ? '700' : '600' }}; font-size: 10px;">
                                            {{ $r['label'] }}
                                        </td>
                                        <td style="text-align: right; background: #f0fdf4; color: #166534; font-size: 10px;">
                                            {{ number_format($r['inq']) }}
                                        </td>
                                        <td style="text-align: right; background: #f0fdf4; color: #166534; font-size: 10px;">
                                            {{ number_format($r['inq_td']) }}
                                        </td>
                                        <td style="text-align: right; background: {{ $isCurrent ? '#facc15' : '#fef9c3' }}; color: #854d0e; font-weight: {{ $isCurrent ? '800' : '600' }}; font-size: 10px;">
                                            {{ number_format($r['spk']) }}
                                        </td>
                                        <td style="text-align: right; background: {{ $isCurrent ? '#fb923c' : '#ffedd5' }}; color: #7c2d12; font-weight: {{ $isCurrent ? '800' : '600' }}; font-size: 10px;">
                                            {{ number_format($r['fp']) }}
                                        </td>
                                        <td style="text-align: right; color: #475569; font-size: 10px;">
                                            {{ number_format($r['inq_to_spk'], 1) }}%
                                        </td>
                                        <td style="text-align: right; color: #475569; font-size: 10px;">
                                            {{ number_format($r['spk_to_fp'], 1) }}%
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
