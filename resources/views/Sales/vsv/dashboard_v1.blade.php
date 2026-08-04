@extends('layouts.app')

@section('title', 'Dashboard V1 - Monthly Dealer Business Review')

@section('content')
<style>
    .v1-container {
        background-color: var(--bg-main, #f4f5f7);
        min-height: 100vh;
        padding: 20px;
        color: #ffffff;
        font-family: 'Segoe UI', Arial, sans-serif;
    }

    .v1-filter-bar {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        background: #ffffff;
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 25px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .v1-filter-bar label {
        font-weight: 600;
        color: #334155;
        font-size: 14px;
    }

    .v1-filter-bar input[type="date"] {
        padding: 7px 12px;
        border: 1.5px solid #38bdf8;
        border-radius: 6px;
        font-weight: 600;
        color: #0f172a;
        background: #f0f9ff;
        outline: none;
        cursor: pointer;
        font-size: 13px;
    }

    .v1-branch-header {
        margin-top: 30px;
        margin-bottom: 15px;
        border-bottom: 3px solid #dc2626;
        padding-bottom: 8px;
    }

    .v1-branch-title {
        color: #ffffff;
        background-color: #dc2626;
        padding: 10px 20px;
        border-radius: 6px;
        display: inline-block;
        font-weight: 800;
        font-size: 16px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    }

    .v1-table-responsive {
        width: 100%;
        overflow-x: auto;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        margin-bottom: 35px;
    }

    .v1-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
        text-align: center;
        background: #ffffff;
        color: #000000;
    }

    /* Primary group headers */
    .v1-table th.header-group {
        background-color: #137888;
        color: #ffffff;
        font-weight: 800;
        font-size: 12px;
        text-transform: uppercase;
        border: 1px solid #0f5966;
        padding: 8px 4px;
    }

    .v1-table th.header-total {
        background-color: #137888;
        color: #ffffff;
        font-weight: 900;
        font-size: 15px;
        border: 1px solid #0f5966;
        padding: 10px;
    }

    /* Sub-headers */
    .v1-table th.header-sub {
        background-color: #ffeb9c;
        color: #000000;
        font-weight: 700;
        border: 1px solid #d6c175;
        padding: 6px 4px;
    }

    .v1-table th.header-rf {
        background-color: #ffeb9c;
        color: #000000;
        font-weight: 700;
        border: 1px solid #d6c175;
        width: 25px;
    }

    /* Cell styling */
    .v1-table td {
        border: 1px solid #cbd5e1;
        padding: 5px 6px;
        vertical-align: middle;
        font-weight: 500;
    }

    .v1-table tr:nth-child(even) td {
        background-color: #fafafa;
    }

    .model-cell {
        font-weight: 800;
        text-align: left;
        padding-left: 10px !important;
        color: #0f172a;
        background-color: #ffffff !important;
        font-size: 11px;
    }

    .rf-cell {
        font-weight: 700;
        color: #475569;
        background-color: #f1f5f9 !important;
        font-style: italic;
        width: 25px;
    }

    .bg-lavender {
        background-color: #eae8f5 !important;
    }

    .bg-light-purple {
        background-color: #f3f0f9 !important;
    }

    .gwth-up {
        color: #16a34a;
        font-weight: 700;
    }

    .gwth-down {
        color: #dc2626;
        font-weight: 700;
    }

    /* Bottom Total Row */
    .total-row td {
        background-color: #ffff00 !important;
        color: #000000 !important;
        font-weight: 900 !important;
        font-size: 12px;
        border: 1px solid #b3b300 !important;
    }

    .total-row-label {
        text-align: left;
        padding-left: 10px !important;
        font-weight: 900 !important;
        text-transform: uppercase;
    }
</style>

<div class="v1-container">
    {{-- FILTER BULAN PERIODE BERJALAN --}}
    <form action="{{ url()->current() }}" method="GET" id="v1FilterForm">
        <div class="v1-filter-bar">
            <label for="filter_bulan" style="margin-right: 6px;">Periode Bulan Berjalan:</label>
            <select name="filter_bulan" id="filter_bulan" onchange="this.form.submit()" style="padding: 7px 14px; border: 1.5px solid #38bdf8; border-radius: 6px; font-weight: 700; color: #0f172a; background: #f0f9ff; outline: none; cursor: pointer; font-size: 13px;">
                @php
                    $monthsDisplay = [
                        'jan' => 'Januari', 'feb' => 'Februari', 'mar' => 'Maret', 'apr' => 'April',
                        'mei' => 'Mei', 'jun' => 'Juni', 'jul' => 'Juli', 'agu' => 'Agustus',
                        'sep' => 'September', 'okt' => 'Oktober', 'nov' => 'November', 'des' => 'Desember'
                    ];
                @endphp
                @foreach(($bulanMap ?? []) as $mNum => $mCode)
                    <option value="{{ $mCode }}" {{ (isset($filter_bulan) && $filter_bulan == $mCode) ? 'selected' : '' }}>
                        {{ strtoupper($mCode) }} ({{ $monthsDisplay[$mCode] ?? ucfirst($mCode) }})
                    </option>
                @endforeach
            </select>
            <button type="submit" style="background-color: #dc2626; color: #ffffff; border: none; border-radius: 8px; padding: 7px 18px; font-weight: 700; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.2);">
                <span>🔍</span> Tampilkan
            </button>

            @php
                $pdfRoute = Route::has('sales.vsv.dashboard.v1.export_pdf') ? route('sales.vsv.dashboard.v1.export_pdf', ['filter_bulan' => $filter_bulan ?? 'jul']) : (Route::has('dashboard.v1.export_pdf') ? route('dashboard.v1.export_pdf', ['filter_bulan' => $filter_bulan ?? 'jul']) : url('/sales/vsv/dashboard/v1/export-pdf?filter_bulan=' . ($filter_bulan ?? 'jul')));
            @endphp
            <a href="{{ $pdfRoute }}"  style="background-color: #dc2626; color: #ffffff !important; text-decoration: none; border-radius: 8px; padding: 7px 18px; font-weight: 700; font-size: 14px; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.2);">
                <span>📄</span> Export PDF
            </a>
        </div>
    </form>

    {{-- PEMISAHAN DATA PERCABANG (SEPERTI FOTO 2-3) --}}
    @foreach ($all_branch_review_data as $namaCabang => $branchContent)
        @php
            $reviewData = $branchContent['reviewData'];
            $summaryTotal = $branchContent['summaryTotal'];
        @endphp

        <div class="v1-branch-header">
            <div class="v1-branch-title">
                <i class="fas fa-building"></i> DATA CABANG: {{ strtoupper($namaCabang) }}
            </div>
        </div>

        <div class="v1-table-responsive">
            <table class="v1-table">
                <thead>
                    <tr>
                        <th rowspan="2" class="header-total" style="width: 140px;">TOTAL</th>
                        <th colspan="3" class="header-group">INQUIRY</th>
                        <th colspan="3" class="header-group">SPK</th>
                        <th colspan="5" class="header-group">FAKTUR POLISI</th>
                        <th colspan="3" class="header-group">SR INQ TO SPK</th>
                        <th colspan="3" class="header-group">SR SPK TO FP</th>
                    </tr>
                    <tr>
                        <!-- INQUIRY -->
                        <th class="header-sub" style="width: 60px;">{{ $prevMonthLabel }}</th>
                        <th class="header-sub" style="width: 60px;">{{ $currMonthLabel }}</th>
                        <th class="header-sub" style="width: 75px;">GWTH</th>

                        <!-- SPK -->
                        <th class="header-sub" style="width: 60px;">{{ $prevMonthLabel }}</th>
                        <th class="header-sub" style="width: 60px;">{{ $currMonthLabel }}</th>
                        <th class="header-sub" style="width: 75px;">GWTH</th>

                        <!-- FAKTUR POLISI -->
                        <th class="header-rf"></th>
                        <th class="header-sub" style="width: 60px;">{{ $prevMonthLabel }}</th>
                        <th class="header-sub" style="width: 60px;">{{ $currMonthLabel }}</th>
                        <th class="header-sub" style="width: 75px;">GWTH</th>
                        <th class="header-sub" style="width: 75px;">GWTH</th>

                        <!-- SR INQ TO SPK -->
                        <th class="header-sub" style="width: 65px;">{{ $prevMonthLabel }}</th>
                        <th class="header-sub" style="width: 65px;">{{ $currMonthLabel }}</th>
                        <th class="header-sub" style="width: 70px;">+/-</th>

                        <!-- SR SPK TO FP -->
                        <th class="header-sub" style="width: 65px;">{{ $prevMonthLabel }}</th>
                        <th class="header-sub" style="width: 65px;">{{ $currMonthLabel }}</th>
                        <th class="header-sub" style="width: 70px;">+/-</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reviewData as $row)
                        <!-- Row 1: R -->
                        <tr>
                            <!-- MODEL -->
                            <td rowspan="2" class="model-cell">{{ $row->model }}</td>

                            <!-- INQUIRY (Spans 2 rows) -->
                            <td rowspan="2">{{ $row->inq_prev ?: '-' }}</td>
                            <td rowspan="2">{{ $row->inq_curr ?: '-' }}</td>
                            <td rowspan="2">
                                @if ($row->inq_gwth >= 0)
                                    <span class="gwth-up"><i class="fas fa-arrow-up"></i> {{ number_format($row->inq_gwth, 1) }}%</span>
                                @else
                                    <span class="gwth-down"><i class="fas fa-arrow-down"></i> {{ number_format(abs($row->inq_gwth), 1) }}%</span>
                                @endif
                            </td>

                            <!-- SPK (Spans 2 rows) -->
                            <td rowspan="2" class="bg-lavender">{{ $row->spk_prev ?: '-' }}</td>
                            <td rowspan="2" class="bg-lavender">{{ $row->spk_curr ?: '-' }}</td>
                            <td rowspan="2" class="bg-lavender">
                                @if ($row->spk_gwth >= 0)
                                    <span class="gwth-up"><i class="fas fa-arrow-up"></i> {{ number_format($row->spk_gwth, 1) }}%</span>
                                @else
                                    <span class="gwth-down"><i class="fas fa-arrow-down"></i> {{ number_format(abs($row->spk_gwth), 1) }}%</span>
                                @endif
                            </td>

                            <!-- FAKTUR POLISI: R subrow -->
                            <td class="rf-cell">R</td>
                            <td>{{ $row->fp_r_prev ?: '-' }}</td>
                            <td>{{ $row->fp_r_curr ?: '-' }}</td>
                            <td>
                                @if ($row->fp_r_gwth >= 0)
                                    <span class="gwth-up"><i class="fas fa-arrow-up"></i> {{ number_format($row->fp_r_gwth, 1) }}%</span>
                                @else
                                    <span class="gwth-down"><i class="fas fa-arrow-down"></i> {{ number_format(abs($row->fp_r_gwth), 1) }}%</span>
                                @endif
                            </td>
                            <!-- FP Total GWTH (Spans 2 rows) -->
                            <td rowspan="2" class="bg-lavender">
                                @if ($row->fp_total_gwth >= 0)
                                    <span class="gwth-up"><i class="fas fa-arrow-up"></i> {{ number_format($row->fp_total_gwth, 1) }}%</span>
                                @else
                                    <span class="gwth-down"><i class="fas fa-arrow-down"></i> {{ number_format(abs($row->fp_total_gwth), 1) }}%</span>
                                @endif
                            </td>

                            <!-- SR INQ TO SPK (Spans 2 rows) -->
                            <td rowspan="2" class="bg-light-purple">{{ number_format($row->sr_inq_spk_prev, 1) }}%</td>
                            <td rowspan="2" class="bg-light-purple">{{ number_format($row->sr_inq_spk_curr, 1) }}%</td>
                            <td rowspan="2" class="bg-light-purple">
                                @if ($row->sr_inq_spk_diff >= 0)
                                    <span class="gwth-up"><i class="fas fa-arrow-up"></i> {{ number_format($row->sr_inq_spk_diff, 1) }}%</span>
                                @else
                                    <span class="gwth-down"><i class="fas fa-arrow-down"></i> {{ number_format(abs($row->sr_inq_spk_diff), 1) }}%</span>
                                @endif
                            </td>

                            <!-- SR SPK TO FP (Spans 2 rows) -->
                            <td rowspan="2" class="bg-light-purple">{{ number_format($row->sr_spk_fp_prev, 1) }}%</td>
                            <td rowspan="2" class="bg-light-purple">{{ number_format($row->sr_spk_fp_curr, 1) }}%</td>
                            <td rowspan="2" class="bg-light-purple">
                                @if ($row->sr_spk_fp_diff >= 0)
                                    <span class="gwth-up"><i class="fas fa-arrow-up"></i> {{ number_format($row->sr_spk_fp_diff, 1) }}%</span>
                                @else
                                    <span class="gwth-down"><i class="fas fa-arrow-down"></i> {{ number_format(abs($row->sr_spk_fp_diff), 1) }}%</span>
                                @endif
                            </td>
                        </tr>

                        <!-- Row 2: F -->
                        <tr>
                            <td class="rf-cell">F</td>
                            <td>{{ $row->fp_f_prev ?: '-' }}</td>
                            <td>{{ $row->fp_f_curr ?: '-' }}</td>
                            <td>
                                @if ($row->fp_f_gwth >= 0)
                                    <span class="gwth-up"><i class="fas fa-arrow-up"></i> {{ number_format($row->fp_f_gwth, 1) }}%</span>
                                @else
                                    <span class="gwth-down"><i class="fas fa-arrow-down"></i> {{ number_format(abs($row->fp_f_gwth), 1) }}%</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    <!-- TOTAL SUBSIDIARY 4W (Bottom Row) -->
                    <tr class="total-row">
                        <td rowspan="2" class="total-row-label">TOTAL SUBSIDIARY 4W</td>
                        <td rowspan="2">{{ $summaryTotal->inq_prev ?: '-' }}</td>
                        <td rowspan="2">{{ $summaryTotal->inq_curr ?: '-' }}</td>
                        <td rowspan="2">
                            @if ($summaryTotal->inq_gwth >= 0)
                                <span class="gwth-up"><i class="fas fa-arrow-up"></i> {{ number_format($summaryTotal->inq_gwth, 1) }}%</span>
                            @else
                                <span class="gwth-down"><i class="fas fa-arrow-down"></i> {{ number_format(abs($summaryTotal->inq_gwth), 1) }}%</span>
                            @endif
                        </td>

                        <td rowspan="2">{{ $summaryTotal->spk_prev ?: '-' }}</td>
                        <td rowspan="2">{{ $summaryTotal->spk_curr ?: '-' }}</td>
                        <td rowspan="2">
                            @if ($summaryTotal->spk_gwth >= 0)
                                <span class="gwth-up"><i class="fas fa-arrow-up"></i> {{ number_format($summaryTotal->spk_gwth, 1) }}%</span>
                            @else
                                <span class="gwth-down"><i class="fas fa-arrow-down"></i> {{ number_format(abs($summaryTotal->spk_gwth), 1) }}%</span>
                            @endif
                        </td>

                        <!-- FP Total R -->
                        <td class="rf-cell" style="background-color: #e2e8f0 !important;">R</td>
                        <td>{{ $summaryTotal->fp_r_prev ?: '-' }}</td>
                        <td>{{ $summaryTotal->fp_r_curr ?: '-' }}</td>
                        <td>
                            @if ($summaryTotal->fp_r_gwth >= 0)
                                <span class="gwth-up"><i class="fas fa-arrow-up"></i> {{ number_format($summaryTotal->fp_r_gwth, 1) }}%</span>
                            @else
                                <span class="gwth-down"><i class="fas fa-arrow-down"></i> {{ number_format(abs($summaryTotal->fp_r_gwth), 1) }}%</span>
                            @endif
                        </td>

                        <!-- FP Total GWTH Overall -->
                        <td rowspan="2">
                            @if ($summaryTotal->fp_total_gwth >= 0)
                                <span class="gwth-up"><i class="fas fa-arrow-up"></i> {{ number_format($summaryTotal->fp_total_gwth, 1) }}%</span>
                            @else
                                <span class="gwth-down"><i class="fas fa-arrow-down"></i> {{ number_format(abs($summaryTotal->fp_total_gwth), 1) }}%</span>
                            @endif
                        </td>

                        <!-- SR INQ TO SPK Total -->
                        <td rowspan="2">{{ number_format($summaryTotal->sr_inq_spk_prev, 1) }}%</td>
                        <td rowspan="2">{{ number_format($summaryTotal->sr_inq_spk_curr, 1) }}%</td>
                        <td rowspan="2">
                            @if ($summaryTotal->sr_inq_spk_diff >= 0)
                                <span class="gwth-up"><i class="fas fa-arrow-up"></i> {{ number_format($summaryTotal->sr_inq_spk_diff, 1) }}%</span>
                            @else
                                <span class="gwth-down"><i class="fas fa-arrow-down"></i> {{ number_format(abs($summaryTotal->sr_inq_spk_diff), 1) }}%</span>
                            @endif
                        </td>

                        <!-- SR SPK TO FP Total -->
                        <td rowspan="2">{{ number_format($summaryTotal->sr_spk_fp_prev, 1) }}%</td>
                        <td rowspan="2">{{ number_format($summaryTotal->sr_spk_fp_curr, 1) }}%</td>
                        <td rowspan="2">
                            @if ($summaryTotal->sr_spk_fp_diff >= 0)
                                <span class="gwth-up"><i class="fas fa-arrow-up"></i> {{ number_format($summaryTotal->sr_spk_fp_diff, 1) }}%</span>
                            @else
                                <span class="gwth-down"><i class="fas fa-arrow-down"></i> {{ number_format(abs($summaryTotal->sr_spk_fp_diff), 1) }}%</span>
                            @endif
                        </td>
                    </tr>
                    <tr class="total-row">
                        <!-- FP Total F -->
                        <td class="rf-cell" style="background-color: #e2e8f0 !important;">F</td>
                        <td>{{ $summaryTotal->fp_f_prev ?: '-' }}</td>
                        <td>{{ $summaryTotal->fp_f_curr ?: '-' }}</td>
                        <td>
                            @if ($summaryTotal->fp_f_gwth >= 0)
                                <span class="gwth-up"><i class="fas fa-arrow-up"></i> {{ number_format($summaryTotal->fp_f_gwth, 1) }}%</span>
                            @else
                                <span class="gwth-down"><i class="fas fa-arrow-down"></i> {{ number_format(abs($summaryTotal->fp_f_gwth), 1) }}%</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endforeach
</div>
@endsection
