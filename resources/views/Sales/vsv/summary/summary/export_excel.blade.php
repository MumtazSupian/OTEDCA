<table>
    <thead>
        <tr>
            <th>OPERASIONAL</th>
            <th>CABANG</th>
            <th>PLAN PELAKSANAAN</th>
            <th>AKTUAL PELAKSANAAN</th>
            <th>DO / DON'T</th>
        </tr>
    </thead>
    <tbody>
        @foreach($summaries as $s)
            <tr>
                <td>{{ $s->operasional }}</td>
                <td>{{ $s->cabang }}</td>
                <td>{{ $s->plan_perbaikan }}</td>
                <td>{{ $s->aktual_perbaikan }}</td>
                <td>{{ $s->do_dont == 'V' ? 'DO' : 'DON\'T' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
