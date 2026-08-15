<!DOCTYPE html>
<html>
<head>
    <title>Laporan Actual DO Salesforce</title>
    <style>
        body { font-family: sans-serif; font-size: 9px; }
        table { width: 100%; border-collapse: collapse; text-align: center; }
        th, td { border: 1px solid #000000; padding: 5px 4px; font-size: 8.5px; }
    </style>
</head>
<body>
    @php
        $monthsList = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
    @endphp

    <table>
        <thead>
            <tr>
                <th colspan="18" style="text-align: center; font-size: 15px; font-weight: bold; border: none; background-color: #ffffff; padding: 10px 0;">
                    LAPORAN ACTUAL DO SALESFORCE - TAHUN {{ $year ?? date('Y') }}
                </th>
            </tr>
            <tr>
                <th style="background-color: #cce5ff; font-weight: bold; width: 25px;">NO</th>
                <th style="background-color: #cce5ff; font-weight: bold; text-align: left; width: 140px;">NAMA SALESMAN</th>
                <th style="background-color: #cce5ff; font-weight: bold; width: 65px;">GRADING</th>
                <th style="background-color: #cce5ff; font-weight: bold; width: 60px;">CABANG</th>
                <th style="background-color: #cce5ff; font-weight: bold; width: 45px;">TAHUN</th>
                @foreach(['JAN','FEB','MAR','APR','MEI','JUN','JUL','AGU','SEP','OKT','NOV','DES'] as $m)
                    <th style="background-color: #cce5ff; font-weight: bold; width: 32px;">{{ $m }}</th>
                @endforeach
                <th style="background-color: #99c2ff; font-weight: bold; width: 45px;">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td style="text-align: left; font-weight: bold;">{{ $row->salesman_name ?? $row->employee_id }}</td>
                <td style="text-align: center; font-weight: bold;">{{ $row->grading }}</td>
                <td style="text-align: center;">{{ $row->cabang }}</td>
                <td style="text-align: center;">{{ $row->tahun }}</td>
                @foreach ($monthsList as $m) 
                    <td style="text-align: center;">{{ number_format($row->$m ?? 0, 0, ',', '.') }}</td> 
                @endforeach
                <td style="text-align: center; font-weight: bold; background-color: #f0f8ff;">{{ number_format($row->total ?? 0, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" style="background-color: #0d47a1; color: #ffffff; font-weight: bold; text-align: right; padding-right: 10px;">GRAND TOTAL KESELURUHAN</td>
                @foreach ($monthsList as $m)
                    <td style="background-color: #0d47a1; color: #ffffff; font-weight: bold; text-align: center;">{{ number_format($grandTotals[$m] ?? 0, 0, ',', '.') }}</td>
                @endforeach
                <td style="background-color: #0d47a1; color: #ffffff; font-weight: bold; text-align: center;">{{ number_format($grandTotalAll ?? 0, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>