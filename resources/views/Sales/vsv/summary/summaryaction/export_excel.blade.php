<table>
    <thead>
        <tr>
            <th>NO</th>
            <th>CABANG</th>
            <th>KONDISI YANG ADA</th>
            <th>ACTION PERBAIKAN</th>
            <th>DO / DON'T</th>
        </tr>
    </thead>
    <tbody>
        @foreach($actions as $i => $a)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $a->cabang }}</td>
                <td>{{ $a->kondisi_yang_ada }}</td>
                <td>{{ $a->action_perbaikan }}</td>
                <td>{{ $a->do_dont }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
