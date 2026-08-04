@extends('layouts.app')

@section('content')
    @php
        $currentRoute = $reportMode ? route('admin.stocks.report') : route('admin.stocks.index');
        $currentPdf = $reportMode ? route('admin.stocks.report.exportPdf') : route('admin.stocks.exportPdf');
        $currentExcel = $reportMode ? route('admin.stocks.report.exportExcel') : route('admin.stocks.exportExcel');
        $pageTitle = $reportMode ? 'Report Stock Bulan Lalu' : 'Data Stock';
        $pageSubtitle = $reportMode ? 'Menampilkan stock sold dari bulan lalu pada submenu REPORT.' : 'Kelola daftar stock kendaraan dengan mudah.';
        $pageNote = $reportMode ? 'Keterangan: TANGGAL DO adalah tanggal data, TAHUN UNIT adalah tahun model/unit.' : 'Keterangan: TANGGAL DO adalah tanggal data, TAHUN UNIT adalah tahun model/unit.';
    @endphp

    <style>
        .data-table {
            table-layout: auto;
            width: 100%;
            border-collapse: collapse;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 0.9rem;
        }

        .data-table thead {
            background-color: #1e293b;
            color: #f8fafc;
        }

        .data-table thead tr th {
            padding: 14px 16px;
            text-align: left;
            font-weight: 600;
            border: 1px solid #ef4444 !important;
            white-space: nowrap;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
        }

        .data-table tbody tr {
            border-bottom: 1px solid #e2e8f0;
            transition: background-color 0.2s ease;
        }

        .data-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .data-table tbody tr:hover {
            background-color: #0f172a;
        }

        .data-table tbody tr.row-matching {
            background-color: #f3e8ff !important; /* light purple */
        }

        .data-table tbody tr.row-matching:hover {
            background-color: #e9d5ff !important; /* darker purple */
        }

        .data-table tbody tr.row-sold {
            background-color: #dcfce7 !important;
        }

        .data-table tbody tr.row-sold:hover {
            background-color: #bbf7d0 !important;
        }

        .data-table tbody tr.row-free {
            background-color: #ffffff !important;
        }

        .data-table tbody tr.row-free:hover {
            background-color: #f1f5f9 !important;
        }

        .data-table tbody tr td {
            padding: 12px 16px;
            color: #0f172a !important;
            font-weight: 500; 
            border: 1px solid #ef4444 !important;
            vertical-align: middle;
            white-space: nowrap;
        }

        .table-container {
            overflow-x: auto;
            border-radius: 12px;
            background: #fff;
            border: 1px solid #cbd5e1;
            width: 100%;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .col-action {
            position: sticky;
            right: 0;
            z-index: 10;
            background-color: #1e293b !important;
            border-left: 2px solid #cbd5e1 !important;
            box-shadow: -4px 0 6px -1px rgba(0, 0, 0, 0.05);
        }

        .col-action-body {
            position: sticky;
            right: 0;
            z-index: 10;
            background-color: inherit;
            border-left: 2px solid #e2e8f0 !important;
            text-align: center;
        }

        /* Ensure action column has background on hover/even rows */
        .data-table tbody tr:hover .col-action-body {
            background-color: #0f172a;
        }

        .data-table tbody tr:nth-child(even) .col-action-body {
            background-color: #f8fafc;
        }

        /* default action bg to white for odd rows */
        .data-table tbody tr:nth-child(odd) .col-action-body {
            background-color: #ffffff;
        }

        .btn-action-primary {
            background-color: #dc2626;
            color: #1e293b; font-weight:800;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.85rem;
            transition: background-color 0.2s;
            display: inline-block;
        }

        .btn-action-primary:hover {
            background-color: #dc2626;
            color: #1e293b; font-weight:800;
        }

        .btn-action-danger {
            background-color: #ef4444;
            color: #1e293b; font-weight:800;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.85rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-action-danger:hover {
            background-color: #dc2626;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
        }

        .page-subtitle {
            color: #64748b;
            font-size: 0.95rem;
        }

        .search-input {
            width: 100%;
            max-width: 400px;
            padding: 10px 16px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            background: #fff;
            color: #0f172a;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .search-input:focus {
            outline: none;
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Ensure filter controls in table header show black text for better readability */
        .data-table thead select,
        .data-table thead input,
        .data-table thead input[type="date"] {
            color: #000 !important;
            background: #fff !important;
        }

        .data-table thead select option,
        .data-table thead input[type="date"]::-webkit-datetime-edit,
        .data-table thead input[type="date"]::-webkit-input-placeholder {
            color: #000 !important;
        }

        .btn-primary-top {
            background-color: #10b981;
            color: #1e293b; font-weight:800;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.2s;
            border: none;
            cursor: pointer;
            display: inline-block;
        }

        .btn-primary-top:hover {
            background-color: #059669;
            color: #1e293b; font-weight:800;
        }

        .btn-search {
            background-color: #dc2626;
            color: #1e293b; font-weight:800;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-search:hover {
            background-color: #dc2626;
        }
    </style>

    <div class="page-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
        <div>
            <h1 class="page-title">{{ $pageTitle }}</h1>
            <p class="page-subtitle" style="margin-top: 4px;">{{ $pageSubtitle }}</p>
            <p style="margin-top: 4px; color: #64748b; font-size: 0.95rem;">{{ $pageNote }}</p>
        </div>
        <div style="display:flex; gap:12px;">
            @if(!$reportMode)
                <a href="{{ route('admin.stocks.print') }}" target="_blank" class="btn-primary-top" style="background-color: #64748b;">
                    <i class="fa-solid fa-print"></i> Print
                </a>
            @endif
            <a href="{{ $currentPdf }}" class="btn-primary-top" style="background-color: #ef4444;">
                <i class="fa-solid fa-file-pdf"></i> PDF
            </a>
            <a href="{{ $currentExcel }}" class="btn-primary-top" style="background-color: #10b981;">
                <i class="fa-solid fa-file-excel"></i> Excel
            </a>
            @if($reportMode)
                <a href="{{ route('admin.stocks.index') }}" class="btn-primary-top" style="background-color: #dc2626;">
                    <i class="fa-solid fa-arrow-left"></i> Kembali Stock
                </a>
            @else
                <a href="{{ route('admin.stocks.create') }}" class="btn-primary-top" style="background-color: #dc2626;">
                    <i class="fa-solid fa-plus"></i> Tambah Stock
                </a>
            @endif
        </div>
    </div>

    @if (session('success'))
        <div
            style="margin-bottom:20px; padding:16px 20px; border-radius:8px; background-color:#ecfdf5; color:#065f46; border-left:4px solid #10b981; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
            <strong>Sukses!</strong> {{ session('success') }}
        </div>
    @endif

    <div
        style="margin-bottom:20px; display:flex; flex-wrap:wrap; gap:16px; align-items:center; justify-content:space-between; background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px solid #e2e8f0;">
        <form method="GET" action="{{ $currentRoute }}"
            style="display:flex; gap:12px; align-items:center; flex:1; min-width:260px;">
            <input type="text" name="search" class="search-input" value="{{ old('search', $search ?? '') }}"
                placeholder="Cari No DO, Nama Mobil, No Rangka...">
            <select name="bulan" class="search-input" style="max-width: 150px; padding: 10px 16px; border-radius: 8px; border: 1px solid #cbd5e1; background: #fff; color: #0f172a;" onchange="this.form.submit()">
                <option value="">Semua Bulan</option>
                @if(isset($bulanOptions))
                    @foreach($bulanOptions as $value => $label)
                        <option value="{{ $value }}" {{ request('bulan') == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                @endif
            </select>
            <select name="tahun_filter" class="search-input" style="max-width: 150px; padding: 10px 16px; border-radius: 8px; border: 1px solid #cbd5e1; background: #fff; color: #0f172a;" onchange="this.form.submit()">
                <option value="">Semua Tahun Matching/Sold</option>
                @if(isset($tahunDoOptions))
                    @foreach($tahunDoOptions as $tahun)
                        <option value="{{ $tahun }}" {{ request('tahun_filter') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                    @endforeach
                @endif
            </select>
            <button type="submit" class="btn-search">Cari</button>
        </form>
        @if (!empty($search) || (request()->has('bulan') && request('bulan') != '') || (request()->has('tahun_filter') && request('tahun_filter') != ''))
            <a href="{{ $currentRoute }}"
                style="color:#ef4444; text-decoration:none; font-weight:600; padding: 8px 12px; border-radius: 6px; transition: background 0.2s;"
                onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='transparent'">
                Reset Filter
            </a>
        @endif
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NO DO</th>
                    <th>TANGGAL DO</th>
                    <th>KODE MOBIL</th>
                        <th style="position: relative;">
                            <div style="display:flex; align-items:center; justify-content:space-between;">
                                NAMA MOBIL
                                <div style="position:relative; width:20px; height:20px; display:flex; align-items:center; justify-content:center;">
                                    <i class="fas fa-filter" style="font-size: 0.8rem; color: {{ request('nama_mobil') ? '#10b981' : '#cbd5e1' }}; transition: color 0.2s;"></i>
                                    <form method="GET" action="{{ $currentRoute }}" style="margin: 0; position: absolute; top:0; left:0; width:100%; height:100%;">
                                        @foreach(request()->except('nama_mobil','page') as $k => $v)
                                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                                        @endforeach
                                        <select name="nama_mobil" onchange="this.form.submit()" style="opacity: 0; position: absolute; top: 0; left: 0; width: 100%; height: 100%; cursor: pointer; -webkit-appearance: none; appearance: none;">
                                            <option value="">Semua Nama Mobil</option>
                                            @if(isset($namaMobilOptions))
                                                @foreach($namaMobilOptions as $nm)
                                                    <option value="{{ $nm }}" {{ request('nama_mobil') == $nm ? 'selected' : '' }}>{{ $nm }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </th>
                        <th style="position: relative;">
                            <div style="display:flex; align-items:center; justify-content:space-between;">
                                VARIAN
                                <div style="position:relative; width:20px; height:20px; display:flex; align-items:center; justify-content:center;">
                                    <i class="fas fa-filter" style="font-size: 0.8rem; color: {{ request('varian') ? '#10b981' : '#cbd5e1' }}; transition: color 0.2s;"></i>
                                    <form method="GET" action="{{ $currentRoute }}" style="margin: 0; position: absolute; top:0; left:0; width:100%; height:100%;">
                                        @foreach(request()->except('varian','page') as $k => $v)
                                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                                        @endforeach
                                        <select name="varian" onchange="this.form.submit()" style="opacity: 0; position: absolute; top: 0; left: 0; width: 100%; height: 100%; cursor: pointer; -webkit-appearance: none; appearance: none;">
                                            <option value="">Semua Varian</option>
                                            @if(isset($varianOptions))
                                                @foreach($varianOptions as $v)
                                                    <option value="{{ $v }}" {{ request('varian') == $v ? 'selected' : '' }}>{{ $v }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </th>
                        <th style="position: relative;">
                            <div style="display:flex; align-items:center; justify-content:space-between;">
                                WARNA
                                <div style="position:relative; width:20px; height:20px; display:flex; align-items:center; justify-content:center;">
                                    <i class="fas fa-filter" style="font-size: 0.8rem; color: {{ request('warna') ? '#10b981' : '#cbd5e1' }}; transition: color 0.2s;"></i>
                                    <form method="GET" action="{{ $currentRoute }}" style="margin: 0; position: absolute; top:0; left:0; width:100%; height:100%;">
                                        @foreach(request()->except('warna','page') as $k => $v)
                                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                                        @endforeach
                                        <select name="warna" onchange="this.form.submit()" style="opacity: 0; position: absolute; top: 0; left: 0; width: 100%; height: 100%; cursor: pointer; -webkit-appearance: none; appearance: none;">
                                            <option value="">Semua Warna</option>
                                            @if(isset($warnaOptions))
                                                @foreach($warnaOptions as $w)
                                                    <option value="{{ $w }}" {{ request('warna') == $w ? 'selected' : '' }}>{{ $w }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </th>
                        <th style="position: relative; text-align: center;">
                            <div style="display:flex; align-items:center; justify-content:space-between;">
                                TAHUN UNIT
                                <div style="position:relative; width:20px; height:20px; display:flex; align-items:center; justify-content:center;">
                                    <i class="fas fa-filter" style="font-size: 0.8rem; color: {{ request('tahun') ? '#10b981' : '#cbd5e1' }}; transition: color 0.2s;"></i>
                                    <form method="GET" action="{{ $currentRoute }}" style="margin: 0; position: absolute; top:0; left:0; width:100%; height:100%;">
                                        @foreach(request()->except('tahun','page') as $k => $v)
                                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                                        @endforeach
                                        <select name="tahun" onchange="this.form.submit()" style="opacity: 0; position: absolute; top: 0; left: 0; width: 100%; height: 100%; cursor: pointer; -webkit-appearance: none; appearance: none;">
                                            <option value="">Semua Tahun Unit</option>
                                            @if(isset($tahunOptions))
                                                @foreach($tahunOptions as $t)
                                                    <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </th>
                    <th>CHASSIS CODE</th>
                    <th>NO RANGKA</th>
                    <th>ENGINE CODE</th>
                    <th>NO MESIN</th>
                    <th>FAKTUR</th>
                    <th>BLN NAIK FAKTUR</th>
                    <th>HARGA</th>
                    <th>KPT + KF</th>
                    <th>ACS2</th>
                    <th>SUBSIDI</th>
                    <th>HPP</th>
                    <th style="position: relative;">
                        <div style="display:flex; align-items:center; justify-content:space-between;">
                            LOKASI
                            <div style="position:relative; width:20px; height:20px; display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-filter" style="font-size: 0.8rem; color: {{ request('lokasi') ? '#10b981' : '#cbd5e1' }}; transition: color 0.2s;"></i>
                                <form method="GET" action="{{ $currentRoute }}" style="margin: 0; position: absolute; top:0; left:0; width:100%; height:100%;">
                                    @foreach(request()->except('lokasi','page') as $k => $v)
                                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                                    @endforeach
                                    <select name="lokasi" onchange="this.form.submit()" style="opacity: 0; position: absolute; top: 0; left: 0; width: 100%; height: 100%; cursor: pointer; -webkit-appearance: none; appearance: none;">
                                        <option value="">Semua Lokasi</option>
                                        @if(isset($lokasiOptions))
                                            @foreach($lokasiOptions as $lokasi)
                                                <option value="{{ $lokasi }}" {{ request('lokasi') == $lokasi ? 'selected' : '' }}>{{ $lokasi }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </form>
                            </div>
                        </div>
                    </th>
                    <th>ESTIMASI MASUK GUDANG</th>
                    <th style="position: relative;">
                        <div style="display:flex; align-items:center; justify-content:space-between;">
                            STATUS
                            <div style="position:relative; width:20px; height:20px; display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-filter" style="font-size: 0.8rem; color: {{ request('status') ? '#10b981' : '#cbd5e1' }}; transition: color 0.2s;"></i>
                                <form method="GET" action="{{ $currentRoute }}" style="margin: 0; position: absolute; top:0; left:0; width:100%; height:100%;">
                                    @foreach(request()->except('status','page') as $k => $v)
                                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                                    @endforeach
                                    <select name="status" onchange="this.form.submit()" style="opacity: 0; position: absolute; top: 0; left: 0; width: 100%; height: 100%; cursor: pointer; -webkit-appearance: none; appearance: none;">
                                        <option value="">Semua Status</option>
                                        @if(isset($statusOptions))
                                            @foreach($statusOptions as $s)
                                                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </form>
                            </div>
                        </div>
                    </th>
                    <th>LAIN-LAIN</th>
                    <th>PENJUALAN</th>
                    <th style="position: relative;">
                        <div style="display:flex; align-items:center; justify-content:space-between;">
                            TANGGAL MATCHING/SOLD
                            <div style="position:relative; width:20px; height:20px; display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-filter" style="font-size: 0.8rem; color: {{ request('tanggal_matching_do') ? '#10b981' : '#cbd5e1' }}; transition: color 0.2s;"></i>
                                <form method="GET" action="{{ $currentRoute }}" style="margin: 0; position: absolute; top:0; left:0; width:100%; height:100%;">
                                    @foreach(request()->except('tanggal_matching_do','page') as $k => $v)
                                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                                    @endforeach
                                    <input type="date" name="tanggal_matching_do" onchange="this.form.submit()" style="opacity: 0; position: absolute; top: 0; left: 0; width: 100%; height: 100%; cursor: pointer;" value="{{ request('tanggal_matching_do') }}">
                                </form>
                            </div>
                        </div>
                    </th>
                        <th style="position: relative;">
                            <div style="display:flex; align-items:center; justify-content:space-between;">
                                CABANG
                                <div style="position:relative; width:20px; height:20px; display:flex; align-items:center; justify-content:center;">
                                    <i class="fas fa-filter" style="font-size: 0.8rem; color: {{ request('cabang') ? '#10b981' : '#cbd5e1' }}; transition: color 0.2s;"></i>
                                    <form method="GET" action="{{ $currentRoute }}" style="margin: 0; position: absolute; top:0; left:0; width:100%; height:100%;">
                                        @foreach(request()->except('cabang','page') as $k => $v)
                                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                                        @endforeach
                                        <select name="cabang" onchange="this.form.submit()" style="opacity: 0; position: absolute; top: 0; left: 0; width: 100%; height: 100%; cursor: pointer; -webkit-appearance: none; appearance: none;">
                                            <option value="">Semua Cabang</option>
                                            @if(isset($cabangOptions))
                                                @foreach($cabangOptions as $c)
                                                    <option value="{{ $c }}" {{ request('cabang') == $c ? 'selected' : '' }}>{{ $c }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </th>
                    <th>KETERANGAN</th>
                    <th>UNIT</th>
                    <th class="col-action">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i => $item)
                    @php
                        $statusLower = strtolower($item->status ?? '');
                        $rowClass = '';
                        if ($statusLower == 'free') {
                            $rowClass = 'row-free';
                        } elseif ($statusLower == 'matching') {
                            $rowClass = 'row-matching';
                        } elseif ($statusLower == 'sold') {
                            $rowClass = 'row-sold';
                        }

                        // --- TAMBAHKAN PENANGANAN ERROR TANGGAL DI SINI ---
                        $tanggalDo = '-';
                        if ($item->tanggal_do) {
                            try {
                                $tanggalDo = \Carbon\Carbon::parse($item->tanggal_do)->format('d-M-Y');
                            } catch (\Exception $e) {
                                $tanggalDo = $item->tanggal_do; // Tampilkan apa adanya (misal "12") jika error
                            }
                        }

                        $tanggalMatching = '-';
                        if ($item->tanggal_matching_do) {
                            try {
                                $tanggalMatching = \Carbon\Carbon::parse($item->tanggal_matching_do)->format('d-M-Y');
                            } catch (\Exception $e) {
                                $tanggalMatching = $item->tanggal_matching_do; // Tampilkan apa adanya jika error
                            }
                        }
                    @endphp

                    <tr class="{{ $rowClass }}">
                        <td style="text-align: center;">{{ $items->firstItem() + $i }}</td>
                        <td>{{ $item->no_do }}</td>

                        <td>{{ $tanggalDo }}</td>

                        <td>{{ $item->kode_mobil }}</td>
                        <td style="font-weight: 500;">{{ $item->nama_mobil }}</td>
                        <td>{{ $item->varian }}</td>
                        <td>{{ $item->warna }}</td>
                        <td style="text-align: center;">{{ $item->tahun }}</td>
                        <td>{{ $item->chassis_code }}</td>
                        <td>{{ $item->norangka }}</td>
                        <td>{{ $item->enginecode }}</td>
                        <td>{{ $item->nomesin }}</td>
                        <td>{{ $item->faktur }}</td>
                        <td>{{ $item->bln_naik_faktur }}</td>
                        <td style="text-align: right;">{{ number_format($item->harga ?? 0, 0, ',', '.') }}</td>
                        <td style="text-align: right;">{{ number_format($item->kpt_kf ?? 0, 0, ',', '.') }}</td>
                        <td style="text-align: right;">{{ number_format($item->acs2 ?? 0, 0, ',', '.') }}</td>
                        <td style="text-align: right;">{{ number_format($item->subsidi ?? 0, 0, ',', '.') }}</td>
                        <td style="text-align: right; font-weight: 600;">{{ number_format($item->hpp ?? 0, 0, ',', '.') }}
                        </td>
                        <td>{{ $item->lokasi }}</td>
                        <td>{{ $item->estimasi_unit_masuk_gudang_dca }}</td>
                        <td style="text-align: center; font-weight: 600; text-transform: uppercase;">
                            {{ $item->status ?? '-' }}
                        </td>
                        <td>{{ $item->lain_lain }}</td>
                        <td>{{ $item->penjualan }}</td>

                        <td>{{ $tanggalMatching }}</td>

                        <td>{{ $item->cabang }}</td>
                        <td>{{ $item->keterangan }}</td>
                        <td style="text-align: center;">{{ $item->unit }}</td>
                        <td class="col-action-body">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <a href="{{ route('admin.stocks.edit', $item) }}" class="btn-action-primary">Edit</a>
                                <form action="{{ route('admin.stocks.destroy', $item) }}" method="POST"
                                    style="margin: 0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="28" style="text-align:center; padding:30px 16px; color: #64748b; background: #fff;">
                            <div style="font-size: 1.1rem; margin-bottom: 8px;">Tidak ada data stock untuk ditampilkan.
                            </div>
                        </td>
                    </tr>
                @endempty
        </tbody>
    </table>
</div>

<div style="margin-top:20px; display: flex; justify-content: flex-end;">
    {{ $items->links() }}
</div>
@endsection
