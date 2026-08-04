<!DOCTYPE html>
<html>
<head>
    <title>Summary Improvement PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #cbd5e1; padding: 8px; text-align: left; vertical-align: top; }
        th { background-color: #f2f2f2; text-align: center; font-weight: bold; }
        .text-center { text-align: center; }
        .badge { padding: 3px 7px; border-radius: 10px; font-weight: bold; color: #1e293b; font-weight:800; font-size: 9px; }
        .bg-success { background-color: #198754; }
        .bg-danger { background-color: #dc3545; }
    </style>
</head>
<body>
    <h2 style="text-align: center; text-transform: uppercase;">Laporan Summary Improvement</h2>
    <p style="text-align: center;">Data Operasional, Rencana Perbaikan, dan Evaluasi</p>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">NO</th>
                <th style="width: 20%;">OPERASIONAL</th>
                <th style="width: 10%;">CABANG</th>
                <th>PLAN PERBAIKAN</th>
                <th>AKTUAL PERBAIKAN</th>
                <th style="width: 10%;">DO/DON'T</th>
            </tr>
        </thead>
        <tbody>
            @foreach($summaries as $i => $s)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td><strong>{{ $s->operasional }}</strong></td>
                <td class="text-center">{{ $s->cabang }}</td>
                <td>{{ $s->plan_perbaikan }}</td>
                <td>{{ $s->aktual_perbaikan }}</td>
                <td class="text-center">
                    @if($s->do_dont == 'V')
                        <span>DO</span>
                    @elseif($s->do_dont == 'X')
                        <span>DON'T</span>
                    @else
                        <span>-</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
