<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Rekapitulasi Piutang' }}</title>
    <style>
        @page {
            size: A3 landscape;
            margin: 8mm;
        }
        * {
            box-sizing: border-box;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
        body {
            font-size: 8px;
            color: #111827;
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }
        .header-wrap {
            margin-bottom: 12px;
            border-bottom: 2px solid #dc2626;
            padding-bottom: 8px;
        }
        .title {
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
            margin: 0 0 4px 0;
            text-transform: uppercase;
        }
        .subtitle {
            font-size: 9px;
            color: #64748b;
            margin: 0;
        }
        .summary-grid {
            width: 100%;
            margin-bottom: 10px;
            border-collapse: separate;
            border-spacing: 6px 0;
        }
        .summary-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 6px 8px;
            text-align: center;
        }
        .summary-label {
            font-size: 7.5px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 2px;
        }
        .summary-val {
            font-size: 11px;
            font-weight: bold;
            color: #0f172a;
        }
        .text-red { color: #dc2626; }
        .text-emerald { color: #059669; }
        .text-blue { color: #2563eb; }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7.5px;
            table-layout: auto;
        }
        table.data-table thead th {
            background-color: #111a36;
            color: #ffffff;
            font-weight: bold;
            padding: 6px 4px;
            border: 1px solid #1e3a8a;
            text-align: center;
            vertical-align: middle;
            font-size: 8px;
            letter-spacing: 0.3px;
        }
        table.data-table tbody td {
            padding: 5px 4px;
            border: 1px solid #1e3a8a;
            vertical-align: middle;
            color: #111827;
            font-size: 7.5px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }

        /* Row Color Status matching Web */
        .row-green {
            background-color: #86f7af !important;
            color: #111827 !important;
            font-weight: 600;
        }
        .row-red {
            background-color: #f28888 !important;
            color: #111827 !important;
            font-weight: 600;
        }
        .row-cream {
            background-color: #fef3c7 !important;
            color: #111827 !important;
            font-weight: 600;
        }
        .row-white {
            background-color: #ffffff !important;
            color: #111827 !important;
        }

        .footer-note {
            margin-top: 8px;
            font-size: 7px;
            color: #94a3b8;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header-wrap">
        <table style="width: 100%;">
            <tr>
                <td style="vertical-align: middle;">
                    <div class="title">{{ $title ?? 'Rekapitulasi Piutang' }}</div>
                    <div class="subtitle">PT SUZUKI DUTA CENDANA ADIPRIMA &bull; Dicetak pada: {{ now()->setTimezone('Asia/Jakarta')->format('d F Y \\p\\u\\k\\u\\l H.i') }} WIB @if(!empty($year)) &bull; Tahun: {{ $year }} @endif</div>
                </td>
                <td style="text-align: right; vertical-align: middle;">
                    <span style="background:#dc2626; color:#fff; font-size:11px; font-weight:bold; padding:5px 12px; border-radius:4px;">{{ $branchTitle ?? 'AR' }}</span>
                </td>
            </tr>
        </table>
    </div>

    <table class="summary-grid">
        <tr>
            <td class="summary-card" style="border-left: 3px solid #2563eb;">
                <div class="summary-label">Total Saldo Awal</div>
                <div class="summary-val text-blue">Rp {{ number_format($totalSaldoAwal ?? 0, 0, ',', '.') }}</div>
            </td>
            <td class="summary-card" style="border-left: 3px solid #dc2626;">
                <div class="summary-label">Total Debet</div>
                <div class="summary-val text-red">Rp {{ number_format($totalDebet ?? 0, 0, ',', '.') }}</div>
            </td>
            <td class="summary-card" style="border-left: 3px solid #059669;">
                <div class="summary-label">Total Kredit</div>
                <div class="summary-val text-emerald">Rp {{ number_format($totalKredit ?? 0, 0, ',', '.') }}</div>
            </td>
            <td class="summary-card" style="border-left: 3px solid #7c3aed;">
                <div class="summary-label">Total Saldo Akhir</div>
                <div class="summary-val" style="color: #7c3aed;">Rp {{ number_format($totalSaldoAkhir ?? 0, 0, ',', '.') }}</div>
            </td>
            <td class="summary-card" style="border-left: 3px solid #ea580c;">
                <div class="summary-label">Total Selisih</div>
                <div class="summary-val" style="color: #ea580c;">Rp {{ number_format($totalSelisih ?? 0, 0, ',', '.') }}</div>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th rowspan="2" style="width: 22px;">NO</th>
                <th rowspan="2">NO SPK</th>
                <th rowspan="2">NAMA KONSUMEN</th>
                <th rowspan="2">TGL. BUKTI</th>
                <th rowspan="2">NO. INVOICE</th>
                <th rowspan="2">KATEGORI SPK</th>
                <th rowspan="2">NAMA ASURANSI</th>
                <th rowspan="2">SALDO AWAL</th>
                <th colspan="2" style="text-align: center;">MUTASI</th>
                <th rowspan="2">TGL. BUKTI</th>
                <th rowspan="2">KETERANGAN</th>
                <th rowspan="2">TGL. BUKTI TAHAP 2</th>
                <th rowspan="2">KETERANGAN TAHAP 2</th>
                <th rowspan="2">TGL. BUKTI TAHAP 3</th>
                <th rowspan="2">KETERANGAN TAHAP 3</th>
                <th rowspan="2">SALDO AKHIR</th>
                <th rowspan="2">NO POLISI</th>
                <th rowspan="2">NO POLIS</th>
            </tr>
            <tr>
                <th>DEBET</th>
                <th>KREDIT</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $index => $row)
                @php
                    $rawTglBukti = $row->tgl_bukti ?? null;
                    $rawTglRek = $row->tgl_bukti_rek ?? null;
                    $rawTglRek2 = $row->tgl_bukti_rek_2 ?? null;
                    $rawTglRek3 = $row->tgl_bukti_rek_3 ?? null;

                    $tglBukti = $rawTglBukti ? \Illuminate\Support\Carbon::parse($rawTglBukti)->format('d F Y') : '-';
                    $tglRek = $rawTglRek ? \Illuminate\Support\Carbon::parse($rawTglRek)->format('d F Y') : '-';
                    $tglRek2 = $rawTglRek2 ? \Illuminate\Support\Carbon::parse($rawTglRek2)->format('d F Y') : '-';
                    $tglRek3 = $rawTglRek3 ? \Illuminate\Support\Carbon::parse($rawTglRek3)->format('d F Y') : '-';

                    $saldoAwal = $row->saldo_awal ?? 0;
                    $debet = $row->debet ?? 0;
                    $kredit = ($row->kredit ?? 0) + ($row->kredit_2 ?? 0) + ($row->kredit_3 ?? 0);
                    $saldoAkhir = $row->saldo_akhir ?? 0;

                    $kategoriSpk = strtoupper($row->spk_type ?? ($row->tipe_konsumen ?? '-'));
                    $namaAsuransi = !empty($row->nama_asuransi) ? $row->nama_asuransi : (!empty($row->perusahaan->nama) ? $row->perusahaan->nama : '-');

                    $rowClass = 'row-white';
                    if ($rawTglBukti) {
                        $hariIni = \Illuminate\Support\Carbon::now('Asia/Jakarta')->startOfDay();
                        $tanggalInput = \Illuminate\Support\Carbon::parse($rawTglBukti, 'Asia/Jakarta')->startOfDay();
                        $selisihHari = $tanggalInput->diffInDays($hariIni);

                        if ($saldoAkhir <= 0) {
                            $rowClass = 'row-white';
                        } else {
                            if ($kategoriSpk === 'ASURANSI') {
                                $rowClass = ($selisihHari >= 35) ? 'row-red' : 'row-green';
                            } elseif ($kategoriSpk === 'REGULER') {
                                $rowClass = ($selisihHari >= 7) ? 'row-red' : 'row-green';
                            } elseif ($kategoriSpk === 'INTERNAL') {
                                $rowClass = 'row-cream';
                            }
                        }
                    }
                @endphp
                <tr class="{{ $rowClass }}">
                    <td class="text-center">{{ $index + 1 }}.</td>
                    <td class="text-center">{{ $row->no_spk ?? '-' }}</td>
                    <td class="text-left font-bold">{{ $row->nama_konsumen ?? '-' }}</td>
                    <td class="text-center">{{ $tglBukti }}</td>
                    <td class="text-center">{{ $row->no_bukti ?? '-' }}</td>
                    <td class="text-center">{{ $kategoriSpk }}</td>
                    <td class="text-left">{{ $namaAsuransi }}</td>
                    <td class="text-right font-bold">{{ is_numeric($saldoAwal) && $saldoAwal > 0 ? number_format($saldoAwal, 0, ',', '.') : '-' }}</td>
                    <td class="text-right font-bold">{{ is_numeric($debet) && $debet > 0 ? number_format($debet, 0, ',', '.') : '0' }}</td>
                    <td class="text-right font-bold">{{ is_numeric($kredit) && $kredit > 0 ? number_format($kredit, 0, ',', '.') : '0' }}</td>
                    <td class="text-center">{{ $tglRek }}</td>
                    <td class="text-left">{{ $row->keterangan ?? '-' }}</td>
                    <td class="text-center">{{ $tglRek2 }}</td>
                    <td class="text-left">{{ $row->keterangan_2 ?? '-' }}</td>
                    <td class="text-center">{{ $tglRek3 }}</td>
                    <td class="text-left">{{ $row->keterangan_3 ?? '-' }}</td>
                    <td class="text-right font-bold">{{ is_numeric($saldoAkhir) && $saldoAkhir > 0 ? number_format($saldoAkhir, 0, ',', '.') : '-' }}</td>
                    <td class="text-center">{{ $row->no_polisi ?? '-' }}</td>
                    <td class="text-center">{{ $row->no_polis ?? '-' }}</td>
                </tr>
            @empty
                <tr class="row-white">
                    <td colspan="19" class="text-center" style="padding: 15px; color: #64748b;">Tidak ada data piutang</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-note">
        Dokumen ini dibuat otomatis oleh Sistem OTE DCA &bull; Rekapitulasi Piutang {{ $branchTitle ?? 'AR' }}
    </div>
</body>
</html>
