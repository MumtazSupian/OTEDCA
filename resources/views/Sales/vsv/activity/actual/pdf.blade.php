<!DOCTYPE html>
<html>
<head>
    <title>Actual Activity</title>
    <style>
        body { font-family: sans-serif; font-size: 7px; }
        table { width: 100%; border-collapse: collapse; text-align: center; }
        th, td { border: 1px solid #000000; padding: 3px; vertical-align: middle; }
        .text-left { text-align: left; padding-left: 3px; }
    </style>
</head>
<body>
    @php
        $gtSales = 0;
        $gtTP = 0; $gtTHP = 0; $gtTSPK = 0;
        $gtAP = 0; $gtAHP = 0; $gtASPK = 0; $gtADO = 0;
        $gtCost = 0; $gtCostP = 0; $gtCostSPK = 0; $gtCostDO = 0;
    @endphp

    <table>
        <thead>
            <tr>
                <th colspan="23" style="text-align: center; font-size: 16px; font-weight: bold; border: none; background-color: #ffffff; color: #000000;">
                    ACTUAL ACTIVITY
                </th>
            </tr>
            <tr>
                <th colspan="23" style="border: none; background-color: #ffffff; height: 15px;"></th>
            </tr>
            <tr>
                <th rowspan="2" style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">NO</th>
                <th rowspan="2" style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">CABANG</th>
                <th rowspan="2" style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">JENIS</th>
                <th rowspan="2" style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">ACTIVITY</th>
                <th rowspan="2" style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">LOKASI</th>
                <th colspan="2" style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">UPLOAD KONTEN</th>
                <th colspan="2" style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">WAKTU</th>
                <th rowspan="2" style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">PIC</th>
                <th rowspan="2" style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">JML SALES</th>
                <th colspan="3" style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">TARGET</th>
                <th colspan="4" style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">ACTUAL</th>
                <th rowspan="2" style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">TOTAL COST</th>
                <th rowspan="2" style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">COST/P</th>
                <th rowspan="2" style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">COST/SPK</th>
                <th rowspan="2" style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">COST/DO</th>
                <th rowspan="2" style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">KETERANGAN</th>
            </tr>
            <tr>
                <th style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">Jenis</th>
                <th style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">Type</th>
                <th style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">Tgl</th>
                <th style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">Jam</th>
                <th style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">P</th>
                <th style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">HP</th>
                <th style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">SPK</th>
                <th style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">P</th>
                <th style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">HP</th>
                <th style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">SPK</th>
                <th style="background-color: #0f172a; color: #000; font-weight: bold; text-align: center;">DO</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                @php
                    $currentSales = (int) ($row->jml_sales_shift ?? 0);
                    $gtSales += $currentSales;
                    $gtTP += $row->target_p;
                    $gtTHP += $row->target_hp;
                    $gtTSPK += $row->target_spk;
                    $gtAP += $row->actual_p;
                    $gtAHP += $row->actual_hp;
                    $gtASPK += $row->actual_spk;
                    $gtADO += $row->actual_do;
                    $gtCost += $row->total_cost;
                    $gtCostP += $row->cost_p;
                    $gtCostSPK += $row->cost_spk;
                    $gtCostDO += $row->cost_do;
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td style="text-align: center;">{{ $row->cabang }}</td>
                    <td style="text-align: center;">{{ $row->jenis_activity }}</td>
                    <td class="text-left">{{ $row->activity }}</td>
                    <td style="text-align: center;">{{ $row->platform_lokasi }}</td>
                    <td style="text-align: center;">{{ $row->jenis_unit }}</td>
                    <td style="text-align: center;">{{ $row->type_unit }}</td>
                    <td style="text-align: center;">{{ $row->tanggal }}</td>
                    <td style="text-align: center;">{{ \Carbon\Carbon::parse($row->jam)->format('H:i') }}</td>
                    <td style="text-align: center;">{{ $row->pic }}</td>
                    <td style="text-align: center;">{{ $currentSales }}</td>
                    <td style="text-align: center;">{{ $row->target_p }}</td>
                    <td style="text-align: center;">{{ $row->target_hp }}</td>
                    <td style="text-align: center;">{{ $row->target_spk }}</td>
                    <td style="text-align: center;">{{ $row->actual_p }}</td>
                    <td style="text-align: center;">{{ $row->actual_hp }}</td>
                    <td style="text-align: center;">{{ $row->actual_spk }}</td>
                    <td style="text-align: center;">{{ $row->actual_do }}</td>
                    <td style="text-align: right;">Rp{{ number_format($row->total_cost, 0, ',', '.') }}</td>
                    <td style="text-align: right;">Rp{{ number_format($row->cost_p, 0, ',', '.') }}</td>
                    <td style="text-align: right;">Rp{{ number_format($row->cost_spk, 0, ',', '.') }}</td>
                    <td style="text-align: right;">Rp{{ number_format($row->cost_do, 0, ',', '.') }}</td>
                    <td class="text-left">{{ $row->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="10" style="background-color: #dc2626; color: #1e293b; font-weight:800; font-weight: bold; text-align: right; padding-right: 10px;">GRAND TOTAL</td>
                <td style="background-color: #dc2626; color: #1e293b; font-weight:800; font-weight: bold; text-align: center;">{{ $gtSales }}</td>
                <td style="background-color: #dc2626; color: #1e293b; font-weight:800; font-weight: bold; text-align: center;">{{ $gtTP }}</td>
                <td style="background-color: #dc2626; color: #1e293b; font-weight:800; font-weight: bold; text-align: center;">{{ $gtTHP }}</td>
                <td style="background-color: #dc2626; color: #1e293b; font-weight:800; font-weight: bold; text-align: center;">{{ $gtTSPK }}</td>
                <td style="background-color: #dc2626; color: #1e293b; font-weight:800; font-weight: bold; text-align: center;">{{ $gtAP }}</td>
                <td style="background-color: #dc2626; color: #1e293b; font-weight:800; font-weight: bold; text-align: center;">{{ $gtAHP }}</td>
                <td style="background-color: #dc2626; color: #1e293b; font-weight:800; font-weight: bold; text-align: center;">{{ $gtASPK }}</td>
                <td style="background-color: #dc2626; color: #1e293b; font-weight:800; font-weight: bold; text-align: center;">{{ $gtADO }}</td>
                <td style="background-color: #dc2626; color: #1e293b; font-weight:800; font-weight: bold; text-align: right;">Rp{{ number_format($gtCost, 0, ',', '.') }}</td>
                <td style="background-color: #dc2626; color: #1e293b; font-weight:800; font-weight: bold; text-align: right;">Rp{{ number_format($gtCostP, 0, ',', '.') }}</td>
                <td style="background-color: #dc2626; color: #1e293b; font-weight:800; font-weight: bold; text-align: right;">Rp{{ number_format($gtCostSPK, 0, ',', '.') }}</td>
                <td style="background-color: #dc2626; color: #1e293b; font-weight:800; font-weight: bold; text-align: right;">Rp{{ number_format($gtCostDO, 0, ',', '.') }}</td>
                <td style="background-color: #dc2626; color: #1e293b; font-weight:800; font-weight: bold; text-align: center;">-</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>