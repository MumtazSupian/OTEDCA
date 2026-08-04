<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard V1 - Monthly Dealer Business Review</title>
    <style>
        @page {
            margin: 15px;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 8px;
            color: #1e293b;
            margin: 0;
            padding: 10px;
            background: #ffffff;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #dc2626;
            padding-bottom: 8px;
        }
        .header h1 {
            font-size: 16px;
            color: #dc2626;
            margin: 0 0 4px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 800;
        }
        .header p {
            font-size: 10px;
            color: #64748b;
            margin: 0;
            font-weight: 600;
        }
        .branch-section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .branch-title {
            background-color: #dc2626;
            color: #ffffff;
            font-size: 11px;
            font-weight: 800;
            padding: 6px 14px;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            background: #ffffff;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 4px 5px;
            text-align: center;
            font-size: 8px;
        }
        th.header-group {
            background-color: #1e293b;
            color: #ffffff;
            font-weight: 800;
            font-size: 9px;
            text-transform: uppercase;
        }
        th.header-total {
            background-color: #1e293b;
            color: #ffffff;
            font-weight: 800;
            font-size: 10px;
        }
        th.header-sub {
            background-color: #fee2e2;
            color: #991b1b;
            font-weight: 700;
        }
        .model-cell {
            text-align: left;
            font-weight: 800;
            background-color: #f8fafc;
            padding-left: 8px !important;
            color: #0f172a;
        }
        .rf-cell {
            font-style: italic;
            font-weight: 700;
            background-color: #f1f5f9;
            color: #475569;
            width: 20px;
        }
        .gwth-up {
            color: #16a34a;
            font-weight: 700;
        }
        .gwth-down {
            color: #dc2626;
            font-weight: 700;
        }
        .total-row td {
            background-color: #fef2f2 !important;
            color: #991b1b !important;
            font-weight: 800 !important;
            border: 1.5px solid #f87171 !important;
            font-size: 9px;
        }
        .footer {
            margin-top: 10px;
            text-align: right;
            font-size: 8px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>MONTHLY DEALER BUSINESS REVIEW</h1>
        <p>PERIODE BULAN: {{ strtoupper($filter_bulan ?? 'JUL') }} 2026 | TANGGAL CETAK: {{ \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->format('d M Y H.i') }} WIB</p>
    </div>

    @foreach ($all_branch_review_data as $namaCabang => $branchContent)
        @php
            $reviewData = $branchContent['reviewData'];
            $summaryTotal = $branchContent['summaryTotal'];
        @endphp

        <div class="branch-section">
            <div class="branch-title">DATA CABANG: {{ strtoupper($namaCabang) }}</div>

            <table>
                <thead>
                    <tr>
                        <th rowspan="2" class="header-total" style="width: 120px;">TOTAL</th>
                        <th colspan="3" class="header-group">INQUIRY</th>
                        <th colspan="3" class="header-group">SPK</th>
                        <th colspan="5" class="header-group">FAKTUR POLISI</th>
                        <th colspan="3" class="header-group">SR INQ TO SPK</th>
                        <th colspan="3" class="header-group">SR SPK TO FP</th>
                    </tr>
                    <tr>
                        <!-- INQUIRY -->
                        <th class="header-sub">{{ $prevMonthLabel }}</th>
                        <th class="header-sub">{{ $currMonthLabel }}</th>
                        <th class="header-sub">GWTH</th>

                        <!-- SPK -->
                        <th class="header-sub">{{ $prevMonthLabel }}</th>
                        <th class="header-sub">{{ $currMonthLabel }}</th>
                        <th class="header-sub">GWTH</th>

                        <!-- FAKTUR POLISI -->
                        <th class="header-sub" style="width: 18px;"></th>
                        <th class="header-sub">{{ $prevMonthLabel }}</th>
                        <th class="header-sub">{{ $currMonthLabel }}</th>
                        <th class="header-sub">GWTH</th>
                        <th class="header-sub">GWTH</th>

                        <!-- SR INQ TO SPK -->
                        <th class="header-sub">{{ $prevMonthLabel }}</th>
                        <th class="header-sub">{{ $currMonthLabel }}</th>
                        <th class="header-sub">+/-</th>

                        <!-- SR SPK TO FP -->
                        <th class="header-sub">{{ $prevMonthLabel }}</th>
                        <th class="header-sub">{{ $currMonthLabel }}</th>
                        <th class="header-sub">+/-</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reviewData as $row)
                        <!-- Row 1: R -->
                        <tr>
                            <td rowspan="2" class="model-cell">{{ $row->model }}</td>
                            <td rowspan="2">{{ $row->inq_prev ?: '-' }}</td>
                            <td rowspan="2">{{ $row->inq_curr ?: '-' }}</td>
                            <td rowspan="2">
                                <span class="{{ $row->inq_gwth >= 0 ? 'gwth-up' : 'gwth-down' }}">
                                    {{ $row->inq_gwth >= 0 ? '+' : '-' }} {{ number_format(abs($row->inq_gwth), 1) }}%
                                </span>
                            </td>
                            <td rowspan="2">{{ $row->spk_prev ?: '-' }}</td>
                            <td rowspan="2">{{ $row->spk_curr ?: '-' }}</td>
                            <td rowspan="2">
                                <span class="{{ $row->spk_gwth >= 0 ? 'gwth-up' : 'gwth-down' }}">
                                    {{ $row->spk_gwth >= 0 ? '+' : '-' }} {{ number_format(abs($row->spk_gwth), 1) }}%
                                </span>
                            </td>
                            <td class="rf-cell">R</td>
                            <td>{{ $row->fp_r_prev ?: '-' }}</td>
                            <td>{{ $row->fp_r_curr ?: '-' }}</td>
                            <td>
                                <span class="{{ $row->fp_r_gwth >= 0 ? 'gwth-up' : 'gwth-down' }}">
                                    {{ $row->fp_r_gwth >= 0 ? '+' : '-' }} {{ number_format(abs($row->fp_r_gwth), 1) }}%
                                </span>
                            </td>
                            <td rowspan="2">
                                <span class="{{ $row->fp_total_gwth >= 0 ? 'gwth-up' : 'gwth-down' }}">
                                    {{ $row->fp_total_gwth >= 0 ? '+' : '-' }} {{ number_format(abs($row->fp_total_gwth), 1) }}%
                                </span>
                            </td>
                            <td rowspan="2">{{ number_format($row->sr_inq_spk_prev, 1) }}%</td>
                            <td rowspan="2">{{ number_format($row->sr_inq_spk_curr, 1) }}%</td>
                            <td rowspan="2">
                                <span class="{{ $row->sr_inq_spk_diff >= 0 ? 'gwth-up' : 'gwth-down' }}">
                                    {{ $row->sr_inq_spk_diff >= 0 ? '+' : '-' }} {{ number_format(abs($row->sr_inq_spk_diff), 1) }}%
                                </span>
                            </td>
                            <td rowspan="2">{{ number_format($row->sr_spk_fp_prev, 1) }}%</td>
                            <td rowspan="2">{{ number_format($row->sr_spk_fp_curr, 1) }}%</td>
                            <td rowspan="2">
                                <span class="{{ $row->sr_spk_fp_diff >= 0 ? 'gwth-up' : 'gwth-down' }}">
                                    {{ $row->sr_spk_fp_diff >= 0 ? '+' : '-' }} {{ number_format(abs($row->sr_spk_fp_diff), 1) }}%
                                </span>
                            </td>
                        </tr>
                        <!-- Row 2: F -->
                        <tr>
                            <td class="rf-cell">F</td>
                            <td>{{ $row->fp_f_prev ?: '-' }}</td>
                            <td>{{ $row->fp_f_curr ?: '-' }}</td>
                            <td>
                                <span class="{{ $row->fp_f_gwth >= 0 ? 'gwth-up' : 'gwth-down' }}">
                                    {{ $row->fp_f_gwth >= 0 ? '+' : '-' }} {{ number_format(abs($row->fp_f_gwth), 1) }}%
                                </span>
                            </td>
                        </tr>
                    @endforeach

                    <!-- TOTAL SUBSIDIARY 4W -->
                    <tr class="total-row">
                        <td rowspan="2" class="model-cell">TOTAL SUBSIDIARY 4W</td>
                        <td rowspan="2">{{ $summaryTotal->inq_prev ?: '-' }}</td>
                        <td rowspan="2">{{ $summaryTotal->inq_curr ?: '-' }}</td>
                        <td rowspan="2">
                            <span class="{{ $summaryTotal->inq_gwth >= 0 ? 'gwth-up' : 'gwth-down' }}">
                                {{ $summaryTotal->inq_gwth >= 0 ? '+' : '-' }} {{ number_format(abs($summaryTotal->inq_gwth), 1) }}%
                            </span>
                        </td>
                        <td rowspan="2">{{ $summaryTotal->spk_prev ?: '-' }}</td>
                        <td rowspan="2">{{ $summaryTotal->spk_curr ?: '-' }}</td>
                        <td rowspan="2">
                            <span class="{{ $summaryTotal->spk_gwth >= 0 ? 'gwth-up' : 'gwth-down' }}">
                                {{ $summaryTotal->spk_gwth >= 0 ? '+' : '-' }} {{ number_format(abs($summaryTotal->spk_gwth), 1) }}%
                            </span>
                        </td>
                        <td class="rf-cell">R</td>
                        <td>{{ $summaryTotal->fp_r_prev ?: '-' }}</td>
                        <td>{{ $summaryTotal->fp_r_curr ?: '-' }}</td>
                        <td>
                            <span class="{{ $summaryTotal->fp_r_gwth >= 0 ? 'gwth-up' : 'gwth-down' }}">
                                {{ $summaryTotal->fp_r_gwth >= 0 ? '+' : '-' }} {{ number_format(abs($summaryTotal->fp_r_gwth), 1) }}%
                            </span>
                        </td>
                        <td rowspan="2">
                            <span class="{{ $summaryTotal->fp_total_gwth >= 0 ? 'gwth-up' : 'gwth-down' }}">
                                {{ $summaryTotal->fp_total_gwth >= 0 ? '+' : '-' }} {{ number_format(abs($summaryTotal->fp_total_gwth), 1) }}%
                            </span>
                        </td>
                        <td rowspan="2">{{ number_format($summaryTotal->sr_inq_spk_prev, 1) }}%</td>
                        <td rowspan="2">{{ number_format($summaryTotal->sr_inq_spk_curr, 1) }}%</td>
                        <td rowspan="2">
                            <span class="{{ $summaryTotal->sr_inq_spk_diff >= 0 ? 'gwth-up' : 'gwth-down' }}">
                                {{ $summaryTotal->sr_inq_spk_diff >= 0 ? '+' : '-' }} {{ number_format(abs($summaryTotal->sr_inq_spk_diff), 1) }}%
                            </span>
                        </td>
                        <td rowspan="2">{{ number_format($summaryTotal->sr_spk_fp_prev, 1) }}%</td>
                        <td rowspan="2">{{ number_format($summaryTotal->sr_spk_fp_curr, 1) }}%</td>
                        <td rowspan="2">
                            <span class="{{ $summaryTotal->sr_spk_fp_diff >= 0 ? 'gwth-up' : 'gwth-down' }}">
                                {{ $summaryTotal->sr_spk_fp_diff >= 0 ? '+' : '-' }} {{ number_format(abs($summaryTotal->sr_spk_fp_diff), 1) }}%
                            </span>
                        </td>
                    </tr>
                    <tr class="total-row">
                        <td class="rf-cell">F</td>
                        <td>{{ $summaryTotal->fp_f_prev ?: '-' }}</td>
                        <td>{{ $summaryTotal->fp_f_curr ?: '-' }}</td>
                        <td>
                            <span class="{{ $summaryTotal->fp_f_gwth >= 0 ? 'gwth-up' : 'gwth-down' }}">
                                {{ $summaryTotal->fp_f_gwth >= 0 ? '+' : '-' }} {{ number_format(abs($summaryTotal->fp_f_gwth), 1) }}%
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endforeach

    <div class="footer">
        Dicetak secara otomatis oleh Sistem VSV OTE DCA
    </div>

</body>
</html>
