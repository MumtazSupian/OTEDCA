<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #cbd5e1;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">LAPORAN SUMMARY ACTION</h2>
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
            @foreach ($actions as $i => $a)
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

</body>

</html>
