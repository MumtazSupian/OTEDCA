<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Cabang Mingguan</title>
    <style>
    @page {
        margin: 8px;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 7px;
    }

    h2 {
        text-align: center;
        margin-bottom: 5px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
        table-layout: fixed;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 2px;
        text-align: center;
        vertical-align: middle;
        word-wrap: break-word;
    }

    th {
        background-color: #0f172a;
        color: #ffffff;
        font-size: 6px;
        text-transform: uppercase;
    }

    td {
        font-size: 6px;
    }

    .text-right {
        text-align: right;
    }

    .bg-reguler {
        background-color: #fef3c7;
    }

    .bg-asuransi {
        background-color: #f87171;
    }

    .bg-internal {
        background-color: #4ade80;
    }

    .summary-row {
        background-color: #ffffff;
        font-weight: bold;
    }

    .summary-label {
        text-align: right;
    }
</style>
</head>
<body>

    <h2 style="text-align: left; font-size: 16px; margin-bottom: 2px;">Rekapitulasi Piutang</h2>
    <p style="text-align: left; font-size: 10px; margin-top: 0; margin-bottom: 15px;">Kelola data saldo awal, mutasi, rekonsiliasi GL, dan saldo akhir konsumen secara instan.</p>

    @foreach($branchData as $branch => $data)
        @php
            $isBP = strtolower($branch) === 'bp';
        @endphp
        <h3 style="margin-bottom: 5px; font-size: 12px;">Cabang: {{ strtoupper($branch ?: 'Tidak Diketahui') }}</h3>
        <table>
            <thead>

                @if($isBP)

                <tr>
                    <th>NO</th>
                    <th>NO SPK</th>
                    <th>NAMA KONSUMEN</th>
                    <th>TGL BUKTI</th>
                    <th>NO INVOICE</th>
                    <th>KATEGORI SPK</th>
                    <th>NAMA ASURANSI</th>
                    <th>SALDO AWAL</th>
                    <th>DEBET</th>
                    <th>KREDIT</th>
                    <th>TGL REK 1</th>
                    <th>KETERANGAN 1</th>
                    <th>TGL REK 2</th>
                    <th>KETERANGAN 2</th>
                    <th>TGL REK 3</th>
                    <th>KETERANGAN 3</th>
                    <th>SALDO AKHIR</th>
                    <th>NO POLISI</th>
                    <th>NO POLIS</th>
                </tr>

                @else

                <tr>
                    <th>NO</th>
                    <th>NO SPK</th>
                    <th>TIPE KONSUMEN</th>
                    <th>NAMA PERUSAHAAN</th>
                    <th>NAMA KONSUMEN</th>
                    <th>TGL BUKTI</th>
                    <th>NO INVOICE</th>
                    <th>KATEGORI SPK</th>
                    <th>SALDO AWAL</th>
                    <th>DEBET</th>
                    <th>KREDIT</th>
                    <th>TGL REK 1</th>
                    <th>KETERANGAN 1</th>
                    <th>TGL REK 2</th>
                    <th>KETERANGAN 2</th>
                    <th>SALDO AKHIR</th>
                    <th>NO POLISI</th>
                </tr>

                @endif

            </thead>

            <tbody>

                @php
                    $no = 1;

                    $totalSaldoAwal = 0;
                    $totalDebet = 0;
                    $totalKredit = 0;
                    $totalSaldoAkhir = 0;
                @endphp

                @foreach($data->filter(fn($row) => ($row->saldo_akhir ?? 0) > 0) as $row)

                    @php

                        $saldoAwal = $row->saldo_awal ?? 0;
                        $debet = $row->debet ?? 0;

                        $kredit =
                            ($row->kredit ?? 0)
                            + ($row->kredit_2 ?? 0)
                            + ($row->kredit_3 ?? 0);

                        $saldoAkhir = $row->saldo_akhir ?? 0;

                        $rowColor = '';

                        if ($row->tgl_bukti && $saldoAkhir > 0) {

                            $hariIni = \Carbon\Carbon::now('Asia/Jakarta')->startOfDay();

                            $tanggalInput = \Carbon\Carbon::parse(
                                $row->tgl_bukti,
                                'Asia/Jakarta'
                            )->startOfDay();

                            $selisihHari = $tanggalInput->diffInDays($hariIni);

                            if (
                                !$isBP &&
                                strtolower($row->tipe_konsumen ?? '') === 'perusahaan'
                            ) {

                                $overdue =
                                    optional($row->perusahaan)->overdue ?? 28;

                                $rowColor =
                                    $selisihHari >= $overdue
                                    ? 'bg-asuransi'
                                    : 'bg-internal';

                            } else {

                                $spk = strtoupper($row->spk_type ?? '');

                                if ($spk === 'ASURANSI') {

                                    $rowColor =
                                        $selisihHari >= 35
                                        ? 'bg-asuransi'
                                        : 'bg-internal';

                                } elseif ($spk === 'REGULER') {

                                    $rowColor =
                                        $selisihHari >= 7
                                        ? 'bg-asuransi'
                                        : 'bg-internal';

                                } elseif ($spk === 'INTERNAL') {

                                    $rowColor = 'bg-reguler';
                                }
                            }
                        }

                        $totalSaldoAwal += $saldoAwal;
                        $totalDebet += $debet; 0;
                        $totalKredit += $kredit;
                        $totalSaldoAkhir += $saldoAkhir;

                    @endphp

                    <tr class="{{ $rowColor }}">

                        @if($isBP)

                            <td>{{ $no++ }}</td>
                            <td>{{ $row->no_spk }}</td>
                            <td>{{ $row->nama_konsumen }}</td>

                            <td>
                                {{ $row->tgl_bukti
                                    ? \Carbon\Carbon::parse($row->tgl_bukti)->format('d M Y')
                                    : '-' }}
                            </td>

                            <td>{{ $row->no_bukti }}</td>

                            <td>{{ strtoupper($row->spk_type ?? '-') }}</td>

                            <td>{{ $row->nama_asuransi ?? '-' }}</td>

                            <td>{{ number_format($saldoAwal,0,',','.') }}</td>

                            <td>{{ number_format($debet,0,',','.') }}</td>

                            <td>{{ number_format($kredit,0,',','.') }}</td>

                            <td>
                                {{ $row->tgl_bukti_rek
                                    ? \Carbon\Carbon::parse($row->tgl_bukti_rek)->format('d M Y')
                                    : '-' }}
                            </td>

                            <td>{{ $row->keterangan ?? '-' }}</td>

                            <td>
                                {{ $row->tgl_bukti_rek_2
                                    ? \Carbon\Carbon::parse($row->tgl_bukti_rek_2)->format('d M Y')
                                    : '-' }}
                            </td>

                            <td>{{ $row->keterangan_2 ?? '-' }}</td>

                            <td>
                                {{ $row->tgl_bukti_rek_3
                                    ? \Carbon\Carbon::parse($row->tgl_bukti_rek_3)->format('d M Y')
                                    : '-' }}
                            </td>

                            <td>{{ $row->keterangan_3 ?? '-' }}</td>

                            <td>{{ number_format($saldoAkhir,0,',','.') }}</td>

                            <td>{{ $row->no_polisi ?? '-' }}</td>

                            <td>{{ $row->no_polis ?? '-' }}</td>

                        @else

                            <td>{{ $no++ }}</td>

                            <td>{{ $row->no_spk }}</td>

                            <td>
                                {{ $row->tipe_konsumen
                                    ? ucfirst($row->tipe_konsumen)
                                    : '-' }}
                            </td>

                            <td>
                                {{ optional($row->perusahaan)->nama ?? '-' }}
                            </td>

                            <td>{{ $row->nama_konsumen }}</td>

                            <td>
                                {{ $row->tgl_bukti
                                    ? \Carbon\Carbon::parse($row->tgl_bukti)->format('d M Y')
                                    : '-' }}
                            </td>

                            <td>{{ $row->no_bukti }}</td>

                            <td>{{ strtoupper($row->spk_type ?? '-') }}</td>

                            <td>{{ number_format($saldoAwal,0,',','.') }}</td>

                            <td>{{ number_format($debet,0,',','.') }}</td>

                            <td>{{ number_format($kredit,0,',','.') }}</td>

                            <td>
                                {{ $row->tgl_bukti_rek
                                    ? \Carbon\Carbon::parse($row->tgl_bukti_rek)->format('d M Y')
                                    : '-' }}
                            </td>

                            <td>{{ $row->keterangan ?? '-' }}</td>

                            <td>
                                {{ $row->tgl_bukti_rek_2
                                    ? \Carbon\Carbon::parse($row->tgl_bukti_rek_2)->format('d M Y')
                                    : '-' }}
                            </td>

                            <td>{{ $row->keterangan_2 ?? '-' }}</td>

                            <td>{{ number_format($saldoAkhir,0,',','.') }}</td>

                            <td>{{ $row->no_polisi ?? '-' }}</td>

                        @endif

                    </tr>

                @endforeach

                                <tr class="summary-row">
                    <td colspan="{{ $isBP ? 7 : 8 }}">TOTAL</td>
                    <td>{{ number_format($totalSaldoAwal,0,',','.') }}</td>
                    <td>{{ number_format($totalDebet,0,',','.') }}</td>
                    <td>{{ number_format($totalKredit,0,',','.') }}</td>
                    <td colspan="{{ $isBP ? 6 : 4 }}"></td>
                    <td>{{ number_format($totalSaldoAkhir,0,',','.') }}</td>
                    <td colspan="{{ $isBP ? 2 : 1 }}"></td>
                </tr>

                <tr class="summary-row">
                    <td colspan="{{ $isBP ? 7 : 8 }}">GL</td>
                    <td>{{ number_format($totalSaldoAwal,0,',','.') }}</td>
                    <td>{{ number_format($totalDebet,0,',','.') }}</td>
                    <td>{{ number_format($totalKredit,0,',','.') }}</td>
                    <td colspan="{{ $isBP ? 6 : 4 }}"></td>
                    <td>{{ number_format($totalSaldoAkhir,0,',','.') }}</td>
                    <td colspan="{{ $isBP ? 2 : 1 }}"></td>
                </tr>

                <tr class="summary-row" style="color:red;">
                    <td colspan="{{ $isBP ? 7 : 8 }}">SELISIH</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td colspan="{{ $isBP ? 6 : 4 }}"></td>
                    <td>-</td>
                    <td colspan="{{ $isBP ? 2 : 1 }}"></td>
                </tr>

            </tbody>
        </table>
    @endforeach

</body>
</html>