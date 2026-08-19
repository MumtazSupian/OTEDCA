<!DOCTYPE html>
<html>
<head>
    <title>Laporan Evaluasi</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #cbd5e1; padding: 4px; text-align: center; }
        th { background-color: #e3f2fd; }
        .badge { padding: 2px 4px; color: #1e293b; font-weight:800; border-radius: 3px; font-weight: bold; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">LAPORAN EVALUASI WIRANIAGA</h2>
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>CABANG</th>
                <th>NAMA SALES</th>
                <th>GRADING</th>
                <th>JAN</th><th>FEB</th><th>MAR</th><th>APR</th><th>MEI</th><th>JUN</th>
                <th>JUL</th><th>AGU</th><th>SEP</th><th>OKT</th><th>NOV</th><th>DES</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $d)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $d->cabang }}</td>
                <td>{{ $d->nama_sales }}</td>
                <td>{{ $d->grading }}</td>
                <td>{{ $d->jan }}</td>
                <td>{{ $d->feb }}</td>
                <td>{{ $d->mar }}</td>
                <td>{{ $d->apr }}</td>
                <td>{{ $d->mei }}</td>
                <td>{{ $d->jun }}</td>
                <td>{{ $d->jul }}</td>
                <td>{{ $d->agu }}</td>
                <td>{{ $d->sep }}</td>
                <td>{{ $d->okt }}</td>
                <td>{{ $d->nov }}</td>
                <td>{{ $d->des }}</td>
                <td>{{ $d->total }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot style="background-color: #f2f2f2;">
            <tr>
                <td colspan="10" style="text-align: right; font-weight: bold;">GRAND TOTAL</td>
                <td style="font-weight: bold;">{{ $grandTotal }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
