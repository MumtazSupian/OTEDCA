@extends('layouts.app')

@section('title', 'Actual DO Salesforce')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    .page-wrapper {
        padding: 24px 16px;
        max-width: 1400px;
        margin: 0 auto;
        font-family: 'Inter', sans-serif;
    }
    
    /* JUDUL GLOWING MERAH */
    .page-title {
        text-align: center;
        font-weight: 900;
        color: #1e293b;
        text-shadow: 0px 4px 15px rgba(220, 38, 38, 0.45);
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 4px;
        font-size: 1.6rem;
    }
    .page-subtitle {
        text-align: center;
        color: #64748b;
        margin-bottom: 20px;
        font-size: 0.85rem;
    }
    
    /* TOOLBAR */
    .toolbar-wrap {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
        background: #0f172a;
        padding: 12px 18px;
        border-radius: 12px;
        border: 1px solid #1e293b;
    }
    .btn-nav {
        padding: 7px 14px;
        background: #1e293b;
        color: #e2e8f0;
        text-decoration: none;
        border-radius: 7px;
        font-weight: 600;
        font-size: 0.78rem;
        border: 1px solid #334155;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-nav:hover { background: #334155; color: #ffffff; transform: translateY(-1px); }
    .btn-pdf { background: #dc2626; border-color: #ef4444; color: #ffffff; }
    .btn-pdf:hover { background: #b91c1c; color: #ffffff; }
    .btn-excel { background: #16a34a; border-color: #22c55e; color: #ffffff; }
    .btn-excel:hover { background: #15803d; color: #ffffff; }
    
    .filter-select {
        background: #1e293b;
        color: #e2e8f0;
        border: 1px solid #334155;
        border-radius: 7px;
        padding: 6px 12px;
        font-size: 0.8rem;
        font-weight: 600;
        outline: none;
        cursor: pointer;
    }

    /* KARTU CABANG */
    .branch-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 24px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }
    .branch-header {
        background: #1e293b;
        color: #ffffff;
        padding: 12px 18px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 3px solid #dc2626;
    }
    .branch-title {
        font-size: 0.95rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
    }
    .branch-badge {
        background: rgba(255,255,255,0.15);
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    /* TABEL SALESFORCE SANGAT RAPIH */
    .table-sf {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.8rem;
        color: #1e293b;
    }
    .table-sf th, .table-sf td {
        border: 1px solid #e2e8f0;
        padding: 10px 12px;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap; /* Mencegah teks turun ke bawah / patah */
    }
    .table-sf thead th {
        background: #fee2e2;
        color: #991b1b;
        font-weight: 700;
        font-size: 0.72rem;
        text-transform: uppercase;
        border-color: #fca5a5;
    }
    .table-sf tbody tr:nth-child(even) { background-color: #f8fafc; }
    .table-sf tbody tr:hover { background-color: #f1f5f9; }
    .table-sf tbody td.text-left { text-align: left; padding-left: 16px; }
    
    /* KOLOM TOTAL YANG KONSISTEN */
    .table-sf .col-total {
        background: #fff5f5;
        color: #dc2626;
        font-weight: 800;
    }
    .table-sf tfoot td {
        background: #fef2f2;
        color: #991b1b;
        font-weight: 800;
        border-color: #fca5a5;
        padding: 12px 12px;
    }
    .table-sf tfoot td.col-total {
        background: #fca5a5;
        color: #7f1d1d;
    }

    /* BADGE GRADING */
    .grade-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 6px;
        font-weight: 800;
        font-size: 0.72rem;
        letter-spacing: 0.5px;
        text-align: center;
    }
    .grade-PLATINUM { background: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe; }
    .grade-GOLD     { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
    .grade-SILVER   { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
    .grade-TRAINEE  { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }

    /* GRAND TOTAL KESELURUHAN */
    .grand-card {
        background: #1e293b;
        border-radius: 12px;
        padding: 18px 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border: 1px solid #334155;
        margin-top: 10px;
    }
    .grand-table {
        width: 100%;
        border-collapse: collapse;
        color: #ffffff;
        font-size: 0.82rem;
    }
    .grand-table th, .grand-table td {
        border: 1px solid #334155;
        padding: 12px 10px;
        text-align: center;
        white-space: nowrap;
    }
    .grand-table th {
        background: #0f172a;
        color: #94a3b8;
        font-size: 0.72rem;
    }
    .grand-table td {
        background: #1e293b;
        font-weight: 700;
    }
    .grand-table .col-total {
        background: #dc2626;
        color: #ffffff;
    }
</style>

<div class="page-wrapper">
    <h1 class="page-title">👥 ACTUAL DO SALESFORCE</h1>
    <p class="page-subtitle">Monitoring pencapaian delivery order berdasarkan grading salesforce aktif</p>

    <div class="toolbar-wrap">
        <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
            <a href="{{ url('/current/dashboard') }}" class="btn-nav">← Dashboard</a>
            <a href="{{ url()->current() }}?year={{ $year ?? date('Y') }}" class="btn-nav">🔄 Refresh</a>
            <a href="{{ route('current.actual-do-salesforces.pdf', ['year' => $year ?? date('Y'), 'cabang' => request('cabang')]) }}" class="btn-nav btn-pdf">📄 Export PDF</a>
            <a href="{{ route('current.actual-do-salesforces.excel', ['year' => $year ?? date('Y'), 'cabang' => request('cabang')]) }}" class="btn-nav btn-excel">📊 Excel</a>
        </div>

        <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
            <form method="GET" action="{{ url()->current() }}" style="display:flex; gap:10px; align-items:center; margin:0;">
                @if(!empty($isPusat))
                <select name="cabang" class="filter-select" onchange="this.form.submit()">
                    <option value="">-- Semua Cabang --</option>
                    @foreach($allowedBranches ?? [] as $bName)
                        <option value="{{ $bName }}" {{ (request('cabang') == $bName || ($selectedCabang ?? '') == $bName) ? 'selected' : '' }}>
                            Cabang {{ $bName }}
                        </option>
                    @endforeach
                </select>
                @endif

                <select name="year" class="filter-select" onchange="this.form.submit()">
                    @for($y = date('Y'); $y >= 2022; $y--)
                        <option value="{{ $y }}" {{ ($year ?? date('Y')) == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                    @endfor
                </select>
            </form>
        </div>
    </div>

    @php
        $monthCols = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        $isNotSH = (strtoupper(Auth::user()->role ?? '') !== 'SH');
    @endphp

    {{-- LIST TABEL PER CABANG --}}
    @forelse($dataByBranch ?? [] as $bData)
        <div class="branch-card">
            <div class="branch-header">
                <h3 class="branch-title">
                    🏢 CABANG {{ strtoupper($bData['branch_name']) }}
                </h3>
                <span class="branch-badge">TAHUN {{ $year }}</span>
            </div>

            <div style="overflow-x:auto;">
                <table class="table-sf">
                    <thead>
                        <tr>
                            <th style="width:40px;">NO</th>
                            <th class="text-left" style="min-width: 180px;">NAMA SALESMAN</th>
                            <th>GRADING</th>
                            <th>CABANG</th>
                            @if($isNotSH)
                                <th>NAMA PENGINPUT</th>
                            @endif
                            <th>TAHUN</th>
                            @foreach($monthCols as $m)
                                <th style="width:50px;">{{ strtoupper($m) }}</th>
                            @endforeach
                            <th class="col-total" style="width:70px;">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bData['rows'] as $idx => $row)
                            <tr>
                                <td style="color:#64748b; font-weight:600;">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="text-left" style="font-weight:700; color:#1e293b;">
                                    {{ $row->salesman_name ?? $row->user->name ?? $row->employee_id ?? '-' }}
                                </td>
                                <td>
                                    <span class="grade-badge grade-{{ $row->grading }}">{{ $row->grading }}</span>
                                </td>
                                <td style="font-weight:600; color:#475569;">{{ $row->cabang }}</td>
                                
                                @if($isNotSH)
                                    <td style="font-style:italic; color:#64748b; font-size: 0.75rem;">
                                        {{ $row->user->name ?? 'Sistem' }}
                                    </td>
                                @endif

                                <td style="color:#64748b;">{{ $row->tahun }}</td>
                                
                                @foreach($monthCols as $m)
                                    <td>{{ number_format($row->$m ?? 0, 0, ',', '.') }}</td>
                                @endforeach
                                
                                <td class="col-total">{{ number_format($row->total ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $isNotSH ? 19 : 18 }}" style="padding:20px; color:#94a3b8; white-space:normal;">
                                    Belum ada transaksi salesforce untuk cabang ini pada tahun {{ $year }}.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="{{ $isNotSH ? 6 : 5 }}" style="text-align:right; padding-right:16px;">
                                TOTAL CABANG {{ strtoupper($bData['branch_name']) }}
                            </td>
                            @foreach($monthCols as $m)
                                <td>{{ number_format($bData['subtotal'][$m] ?? 0, 0, ',', '.') }}</td>
                            @endforeach
                            <td class="col-total" style="font-size:0.85rem;">
                                {{ number_format($bData['subtotal']['total'] ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @empty
        <div style="background:#1e293b; padding:40px; text-align:center; border-radius:12px; color:#94a3b8;">
            📭 Data Actual DO Salesforce tidak ditemukan untuk periode tahun {{ $year }}.
        </div>
    @endforelse

    {{-- GRAND TOTAL KESELURUHAN (JIKA MENAMPILKAN LEBIH DARI 1 CABANG) --}}
    @if(isset($dataByBranch) && count($dataByBranch) > 1)
        <div class="grand-card">
            <h4 style="margin:0 0 12px 0; color:#ffffff; font-weight:800; font-size:0.9rem; text-transform:uppercase; letter-spacing:0.5px;">
                GRAND TOTAL KESELURUHAN (SEMUA CABANG) - TAHUN {{ $year }}
            </h4>
            <div style="overflow-x:auto;">
                <table class="grand-table">
                    <thead>
                        <tr>
                            <th style="text-align:left; padding-left:16px;">DESKRIPSI</th>
                            @foreach($monthCols as $m)
                                <th>{{ strtoupper($m) }}</th>
                            @endforeach
                            <th class="col-total">TOTAL AKUMULASI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align:left; padding-left:16px; color:#f8fafc;">TOTAL UNIT DELIVERY ORDER (DO)</td>
                            @foreach($monthCols as $m)
                                <td>{{ number_format($grandTotals[$m] ?? 0, 0, ',', '.') }}</td>
                            @endforeach
                            <td class="col-total" style="font-size:0.95rem;">
                                {{ number_format($grandTotalAll ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection