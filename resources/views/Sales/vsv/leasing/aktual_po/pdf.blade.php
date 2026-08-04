<!DOCTYPE html>
<html>
<head>
    <title>Laporan Aktual PO</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; text-align: center; }
        th, td { border: 1px solid #000000; padding: 6px; }
    </style>
</head>
<body>
    
    @php
        $months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        $grandTotals = [];
        foreach ($months as $m) {
            $grandTotals[$m] = $data->sum($m);
        }
        $grandTotalAll = $data->sum('total');
    @endphp

    <table>
        <thead>
            <tr>
                <th colspan="16" style="text-align: center; font-size: 16px; font-weight: bold; border: none; background-color: #ffffff;">
                    LAPORAN AKTUAL PO
                </th>
            </tr>
            <tr>
                <th colspan="16" style="border: none; background-color: #ffffff; height: 15px;"></th>
            </tr>
            <tr>
                <th style="background-color: #cce5ff; font-weight: bold; text-align: center;">LEASING</th>
                <th style="background-color: #cce5ff; font-weight: bold; text-align: center;">CABANG</th>
                <th style="background-color: #cce5ff; font-weight: bold; text-align: center;">TAHUN</th>
                @foreach(['JAN','FEB','MAR','APR','MEI','JUN','JUL','AGU','SEP','OKT','NOV','DES'] as $m)
                    <th style="background-color: #cce5ff; font-weight: bold; text-align: center;">{{ $m }}</th>
                @endforeach
                <th style="background-color: #cce5ff; font-weight: bold; text-align: center;">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
            <tr>
                <td style="text-align: left;">{{ $row->leasing }}</td>
                <td style="text-align: center;">{{ $row->cabang }}</td>
                <td style="text-align: center;">{{ $row->tahun }}</td>
                <td style="text-align: center;">{{ number_format($row->jan, 0, ',', '.') }}</td>
                <td style="text-align: center;">{{ number_format($row->feb, 0, ',', '.') }}</td>
                <td style="text-align: center;">{{ number_format($row->mar, 0, ',', '.') }}</td>
                <td style="text-align: center;">{{ number_format($row->apr, 0, ',', '.') }}</td>
                <td style="text-align: center;">{{ number_format($row->mei, 0, ',', '.') }}</td>
                <td style="text-align: center;">{{ number_format($row->jun, 0, ',', '.') }}</td>
                <td style="text-align: center;">{{ number_format($row->jul, 0, ',', '.') }}</td>
                <td style="text-align: center;">{{ number_format($row->agu, 0, ',', '.') }}</td>
                <td style="text-align: center;">{{ number_format($row->sep, 0, ',', '.') }}</td>
                <td style="text-align: center;">{{ number_format($row->okt, 0, ',', '.') }}</td>
                <td style="text-align: center;">{{ number_format($row->nov, 0, ',', '.') }}</td>
                <td style="text-align: center;">{{ number_format($row->des, 0, ',', '.') }}</td>
                <td style="text-align: center; font-weight: bold;">{{ number_format($row->total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="background-color: #dc2626; color: #ffffff; font-weight: bold; text-align: right; padding-right: 15px;">GRAND TOTAL</td>
                @foreach($months as $m)
                    <td style="background-color: #dc2626; color: #ffffff; font-weight: bold; text-align: center;">{{ number_format($grandTotals[$m], 0, ',', '.') }}</td>
                @endforeach
                <td style="background-color: #dc2626; color: #ffffff; font-weight: bold; text-align: center;">{{ number_format($grandTotalAll, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>