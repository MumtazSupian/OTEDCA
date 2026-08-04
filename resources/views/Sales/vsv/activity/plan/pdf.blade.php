<!DOCTYPE html>
<html>
<head>
    <title>Activity Plan</title>
    <style>
        body { font-family: sans-serif; font-size: 7px; }
        table { width: 100%; border-collapse: collapse; text-align: center; }
        th, td { border: 1px solid #000000; padding: 3px; }
    </style>
</head>
<body>
    
    @php
        $gtSales = 0;
        $gtTP = 0; $gtTHP = 0; $gtTSPK = 0;
        $gtAP = 0; $gtAHP = 0; $gtASPK = 0; $gtADO = 0;
        $gtCost = 0; $gtCP = 0; $gtCSPK = 0; $gtCDO = 0;

        foreach ($data as $row) {
            $gtSales += (int) ($row->jml_sales_shift ?? 0);
            $gtTP += $row->target_p;
            $gtTHP += $row->target_hp;
            $gtTSPK += $row->target_spk;
            $gtAP += $row->actual_p;
            $gtAHP += $row->actual_hp;
            $gtASPK += $row->actual_spk;
            $gtADO += $row->actual_do;
            $gtCost += $row->total_cost;
            $gtCP += $row->cost_p;
            $gtCSPK += $row->cost_spk;
            $gtCDO += $row->cost_do;
        }
    @endphp

    <table>
        <thead>
            <tr>
                <th colspan="23" style="text-align: center; font-size: 16px; font-weight: bold; border: none; background-color: #ffffff; color: #000000;">
                    ACTIVITY PLAN
                </th>
            </tr>
            <tr>
                <th colspan="23" style="border: none; background-color: #ffffff; height: 15px;"></th>
            </tr>
            <tr>
                <th rowspan="2" style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">NO</th>
                <th rowspan="2" style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">CABANG</th>
                <th rowspan="2" style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">JENIS ACTIVITY</th>
                <th rowspan="2" style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">ACTIVITY</th>
                <th rowspan="2" style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">PLATFORM/LOKASI</th>
                <th colspan="2" style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">UPLOAD KONTEN/DISPLAY</th>
                <th colspan="2" style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">WAKTU PELAKSANAAN</th>
                <th rowspan="2" style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">PIC</th>
                <th rowspan="2" style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">JML SALES<br>PER SHIFT</th>
                <th colspan="3" style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">TARGET</th>
                <th colspan="4" style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">ACTUAL</th>
                <th rowspan="2" style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">TOTAL COST</th>
                <th rowspan="2" style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">COST/P</th>
                <th rowspan="2" style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">COST/SPK</th>
                <th rowspan="2" style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">COST/DO</th>
                <th rowspan="2" style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">KETERANGAN</th>
            </tr>
            <tr>
                <th style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">Jenis Unit</th>
                <th style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">Type Unit</th>
                <th style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">Tanggal</th>
                <th style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">Jam</th>
                <th style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">P</th>
                <th style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">HP</th>
                <th style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">SPK</th>
                <th style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">P</th>
                <th style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">HP</th>
                <th style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">SPK</th>
                <th style="background-color: #cce5ff; color: #003366; font-weight: bold; text-align: center;">DO</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td style="text-align: center;">{{ $row->cabang }}</td>
                <td style="text-align: center;">{{ $row->jenis_activity }}</td>
                <td style="text-align: left;">{{ $row->activity }}</td>
                <td style="text-align: center;">{{ $row->platform_lokasi }}</td>
                <td style="text-align: center;">{{ $row->jenis_unit }}</td>
                <td style="text-align: center;">{{ $row->type_unit }}</td>
                <td style="text-align: center;">{{ $row->tanggal }}</td>
                <td style="text-align: center;">{{ \Carbon\Carbon::parse($row->jam)->format('H:i') }}</td>
                <td style="text-align: center;">{{ $row->pic }}</td>
                <td style="text-align: center;">{{ (int) ($row->jml_sales_shift ?? 0) }}</td>
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
                <td style="text-align: left;">{{ $row->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="10" style="background-color: #dc2626; color: #ffffff; font-weight: bold; text-align: right; padding-right: 10px;">GRAND TOTAL</td>
                <td style="background-color: #dc2626; color: #ffffff; font-weight: bold; text-align: center;">{{ $gtSales }}</td>
                <td style="background-color: #dc2626; color: #ffffff; font-weight: bold; text-align: center;">{{ $gtTP }}</td>
                <td style="background-color: #dc2626; color: #ffffff; font-weight: bold; text-align: center;">{{ $gtTHP }}</td>
                <td style="background-color: #dc2626; color: #ffffff; font-weight: bold; text-align: center;">{{ $gtTSPK }}</td>
                <td style="background-color: #dc2626; color: #ffffff; font-weight: bold; text-align: center;">{{ $gtAP }}</td>
                <td style="background-color: #dc2626; color: #ffffff; font-weight: bold; text-align: center;">{{ $gtAHP }}</td>
                <td style="background-color: #dc2626; color: #ffffff; font-weight: bold; text-align: center;">{{ $gtASPK }}</td>
                <td style="background-color: #dc2626; color: #ffffff; font-weight: bold; text-align: center;">{{ $gtADO }}</td>
                <td style="background-color: #dc2626; color: #ffffff; font-weight: bold; text-align: right;">Rp{{ number_format($gtCost, 0, ',', '.') }}</td>
                <td style="background-color: #dc2626; color: #ffffff; font-weight: bold; text-align: right;">Rp{{ number_format($gtCP, 0, ',', '.') }}</td>
                <td style="background-color: #dc2626; color: #ffffff; font-weight: bold; text-align: right;">Rp{{ number_format($gtCSPK, 0, ',', '.') }}</td>
                <td style="background-color: #dc2626; color: #ffffff; font-weight: bold; text-align: right;">Rp{{ number_format($gtCDO, 0, ',', '.') }}</td>
                <td style="background-color: #dc2626; color: #ffffff; font-weight: bold; text-align: center;">-</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>