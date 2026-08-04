<table border="1" style="width:100%; border-collapse:collapse; text-align:center;">
    <thead>
        <tr style="background:#fee2e2;">
            <th>NO</th>
            <th>CABANG</th>
            <th>SALES HEAD</th>
            <th>NAMA SALES</th>
            <th>TGL MASUK</th>
            <th>TGL EVALUASI</th>
            <th>GRADING</th>
            <th>JAN</th><th>FEB</th><th>MAR</th><th>APR</th><th>MEI</th><th>JUN</th>
            <th>TOTAL</th>
            <th>EVALUASI</th>
            <th>TGL KELUAR</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $i => $d)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $d->cabang }}</td>
                <td>{{ $d->nama_sales_head }}</td>
                <td>{{ $d->nama_sales }}</td>
                <td>{{ $d->tanggal_masuk }}</td>
                <td>{{ $d->tanggal_evaluasi }}</td>
                <td>{{ $d->grading }}</td>
                <td>{{ $d->jan }}</td>
                <td>{{ $d->feb }}</td>
                <td>{{ $d->mar }}</td>
                <td>{{ $d->apr }}</td>
                <td>{{ $d->mei }}</td>
                <td>{{ $d->jun }}</td>
                <td>{{ $d->total }}</td>
                <td>{{ $d->evaluasi }}</td>
                <td>{{ $d->tanggal_keluar }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="13">GRAND TOTAL</td>
            <td>{{ $grandTotal }}</td>
            <td colspan="2"></td>
        </tr>
    </tfoot>
</table>
