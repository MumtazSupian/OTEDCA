<table>
    <thead>
        <tr>
            <th colspan="16" style="text-align: center; font-size: 14px; font-weight: bold;">
                LAPORAN ACTUAL SOURCE DO INQUIRY
            </th>
        </tr>
        <tr>
            <th style="background-color: #cce5ff; border: 1px solid #cbd5e1; font-weight: bold;">SOURCE INQUIRY</th>
            <th style="background-color: #cce5ff; border: 1px solid #cbd5e1; font-weight: bold;">CABANG</th>
            <th style="background-color: #cce5ff; border: 1px solid #cbd5e1; font-weight: bold;">TAHUN</th>
            @foreach(['JAN','FEB','MAR','APR','MEI','JUN','JUL','AGU','SEP','OKT','NOV','DES'] as $m)
                <th style="background-color: #cce5ff; border: 1px solid #cbd5e1; font-weight: bold;">{{ $m }}</th>
            @endforeach
            <th style="background-color: #cce5ff; border: 1px solid #cbd5e1; font-weight: bold;">TOTAL</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $row)
        <tr>
            <td style="border: 1px solid #cbd5e1;">{{ $row->source_inquary }}</td>
            <td style="border: 1px solid #cbd5e1; text-align: center;">{{ $row->cabang }}</td>
            <td style="border: 1px solid #cbd5e1; text-align: center;">{{ $row->tahun }}</td>
            @foreach ($months as $m) 
                <td style="border: 1px solid #cbd5e1; text-align: center;">{{ $row->$m }}</td> 
            @endforeach
            <td style="border: 1px solid #cbd5e1; text-align: center; font-weight: bold;">{{ $row->total }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" style="background-color: #dc2626; color: #ffffff; font-weight: bold; text-align: right; border: 1px solid #cbd5e1;">GRAND TOTAL</td>
            @foreach ($months as $m)
                <td style="background-color: #dc2626; color: #ffffff; font-weight: bold; text-align: center; border: 1px solid #cbd5e1;">{{ $grandTotals[$m] }}</td>
            @endforeach
            <td style="background-color: #dc2626; color: #ffffff; font-weight: bold; text-align: center; border: 1px solid #cbd5e1;">{{ $grandTotalAll }}</td>
        </tr>
    </tfoot>
</table>