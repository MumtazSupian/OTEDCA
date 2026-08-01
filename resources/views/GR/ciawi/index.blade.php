@extends('layouts.app')

@section('title', 'GR Ciawi - Rekapitulasi Piutang')

@section('content')
    <div style="width: 100%; box-sizing: border-box; overflow-x: hidden;">
        <div class="page-header" style="margin-bottom: 20px;">
            <div>
                <h1 class="page-title">Rekapitulasi Piutang - GR Ciawi</h1>
                <p class="page-subtitle">Kelola data saldo awal, mutasi, rekonsiliasi GL, dan saldo akhir konsumen cabang
                    Ciawi.</p>
            </div>
            <div class="server-time">
                <span class="dot"></span>
                <span>Waktu Server: {{ now()->setTimezone('Asia/Jakarta')->format('d F Y \\p\\u\\k\\u\\l H.i') }} WIB</span>
            </div>
        </div>

        <div class="toolbar" style="margin-bottom: 20px;">
            <div class="search-wrapper">
                <input type="text" class="search-input" placeholder="Cari konsumen, no. bukti, plat/no. polisi, polis..."
                    id="searchInput">
                <span class="search-shortcut">Ctrl+K</span>
            </div>
            <div class="toolbar-right">
                <span class="toolbar-label">Tampilkan:</span>
                <select class="toolbar-select" id="rowsPerPage">
                    <option value="50">50 Baris</option>
                    <option value="100">100 Baris</option>
                    <option value="200">200 Baris</option>
                </select>
                @if(optional(Auth::user())->is_admin)
                        <button class="btn-primary" onclick="openModal()" id="btnTambahData"
                        style="background-color: var(--accent-red); border-color: var(--accent-red); color: #ffffff;">Tambah Data</button>
                    @endif
            </div>
        </div>

        {{-- Style Khusus: Tabel (Merah-Putih) & Modal (Putih-Merah) --}}
        <style>
            /* 1. TEMA TABEL */
            #piutangTable th,
            #piutangTable td {
                border: 1px solid #1e3a8a !important;
                /* Garis merah elegan antar kolom */
            }

            #piutangTable thead th {
                color: #ffffff !important;
                /* Warna font judul putih */
                background-color: #111a36 !important;
                /* Background judul gelap agar font putih jelas */
            }

            #piutangTable tbody td {
                color: #111827 !important;
                /* Warna font isi tabel gelap pekat agar jelas */
            }

            /* 2. TEMA MODAL / FORM CREATE (PUTIH & MERAH) */
            .modal {
                background-color: #ffffff !important;
                /* Latar belakang putih */
                border: 2px solid var(--accent-red) !important;
                box-shadow: 0 25px 50px -12px rgba(37, 99, 235, 0.25) !important;
            }

            .modal-header {
                border-bottom: 1px solid var(--accent-red-light) !important;
                background: #ffffff !important;
            }

            .modal-title {
                color: var(--accent-red) !important;
                font-weight: 700 !important;
            }

            .modal-body {
                background-color: #ffffff !important;
            }

            .form-label {
                color: #111827 !important;
                /* Label font gelap agar jelas */
                font-weight: 600 !important;
                margin-bottom: 6px !important;
                display: block;
            }

            .form-input,
            .form-select {
                background-color: #ffffff !important;
                /* Input background putih */
                border: 1px solid #d1d5db !important;
                /* Border abu standar */
                color: #111827 !important;
                /* Tulisan input gelap */
            }

            .form-input:focus,
            .form-select:focus {
                border-color: var(--accent-red) !important;
                box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1) !important;
                outline: none;
            }

            .modal-footer {
                background-color: #f9fafb !important;
                border-top: 1px solid var(--accent-red-light) !important;
            }

            .btn-primary {
                background-color: var(--accent-red) !important;
                border-color: var(--accent-red) !important;
                color: #ffffff !important;
            }

            .btn-primary:hover {
                background-color: #1e40af !important;
            }

            .btn-secondary {
                background-color: #ffffff !important;
                /* Tombol Batal Putih */
                border: 1px solid #d1d5db !important;
                color: #374151 !important;
            }

            .modal-close {
                color: #9ca3af !important;
            }

            .modal-close:hover {
                color: var(--accent-red) !important;
            }

            .perusahaan-dropdown-container {
                display: none;
                position: absolute;
                /* Ubah left menjadi negatif agar melebar ke kiri */
                left: -150px; 
                /* Sesuaikan lebar agar lebih lebar dari container aslinya */
                width: 400px; 
                z-index: 1050;
                background: #ffffff;
                border: 1px solid #d1d5db;
                border-radius: 8px;
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
                padding: 16px;
                margin-top: 8px;
            }

            /* Merapikan tabel agar jaraknya konsisten */
            .perusahaan-table {
                width: 100%;
                border-collapse: collapse;
            }

            .perusahaan-table td {
                padding: 12px 8px;
                border-bottom: 1px solid #f3f4f6;
            }

            /* Membuat tombol 'Pilih' sedikit lebih kecil agar pas */
            .btn-pilih-perusahaan {
                background-color: #0ea5e9 !important;
                color: #ffffff !important;
                border: none;
                border-radius: 4px;
                padding: 4px 12px;
                font-size: 11px;
                cursor: pointer;
            }
        </style>

        {{-- Kontainer Utama Tabel --}}
        <div class="table-container"
            style="width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; border-radius: 8px; background: #ffffff;">
            <div class="table-scroll" style="width: 100%; min-width: 1300px;">
                <table class="data-table" id="piutangTable" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th rowspan="2">NO</th>
                            <th rowspan="2">NO SPK</th>
                            <th rowspan="2">TIPE KONSUMEN</th>
                            <th rowspan="2">PERUSAHAAN</th>
                            <th rowspan="2">NAMA KONSUMEN</th>
                            <th rowspan="2">TGL. BUKTI</th>
                            <th rowspan="2" class="col-bukti">NO. INVOICE</th>
                            <th rowspan="2" class="col-spk">KATEGORI SPK</th>
                            <th rowspan="2">SALDO AWAL</th>
                            <th colspan="2" style="text-align:center;">MUTASI</th>
                            <th rowspan="2" class="col-rek-tgl">TGL. BUKTI</th>
                            <th rowspan="2" class="col-keterangan">KETERANGAN</th>
                            <th rowspan="2">TGL. BUKTI TAHAP 2</th>
                            <th rowspan="2">KETERANGAN TAHAP 2</th>
                            <th rowspan="2">SALDO AKHIR</th>
                            <th rowspan="2" class="col-no-polisi">NO POLISI</th>
                            <th rowspan="2" class="col-action">AKSI</th>
                        </tr>
                        <tr>
                            <th>DEBET</th>
                            <th>KREDIT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($records ?? [] as $row)
                            @php
                                $rawTglBukti = $row->tgl_bukti ?? ($row['tgl_bukti'] ?? null);
                                $rawTglRek = $row->tgl_bukti_rek ?? ($row['tgl_bukti_rek'] ?? null);
                                $rawTglRek2 = $row->tgl_bukti_rek_2 ?? ($row['tgl_bukti_rek_2'] ?? null);
                                $tglBukti = $rawTglBukti
                                    ? \Illuminate\Support\Carbon::parse($rawTglBukti)->format('d F Y')
                                    : '-';
                                $tglRek = $rawTglRek
                                    ? \Illuminate\Support\Carbon::parse($rawTglRek)->format('d F Y')
                                    : '-';

                                $tglRek2 = $rawTglRek2
                                    ? \Illuminate\Support\Carbon::parse($rawTglRek2)->format('d F Y')
                                    : '-';

                                $saldoAwal = $row->saldo_awal ?? ($row['saldo_awal'] ?? 0);
                                $debet = $row->debet ?? ($row['debet'] ?? 0);
                                $kredit =
                                        ($row->kredit ?? 0)
                                        + ($row->kredit_2 ?? 0)
                                        + ($row->kredit_3 ?? 0);
                                $saldoAkhir = $row->saldo_akhir ?? ($row['saldo_akhir'] ?? 0);

                                $tipeKonsumen = strtolower($row->tipe_konsumen ?? '');
                                $namaPerusahaan = strtoupper(optional($row->perusahaan)->nama ?? '');
                                $branch = $row->branch ?? '';                                                   

                                // 1. Set default style (jika tidak ada tanggal bukti)
                                $rowStyle = 'background-color: ' . ($loop->even ? '#fef2f2' : '#ffffff') . ';';

                                if ($rawTglBukti) {

                                    // Samakan timezone ke Asia/Jakarta agar perhitungannya sinkron dengan server
                                    $hariIni = \Illuminate\Support\Carbon::now('Asia/Jakarta')->startOfDay();

                                    $tanggalInput = \Illuminate\Support\Carbon::parse(
                                        $rawTglBukti,
                                        'Asia/Jakarta'
                                    )->startOfDay();

                                    // Hitung selisih hari
                                    $selisihHari = $tanggalInput->diffInDays($hariIni);

                                    // Kategori SPK
                                    $kategoriSpk = strtoupper($row->spk_type ?? ($row['spk_type'] ?? ''));

                                    if ($saldoAkhir <= 0) {

                                    $rowStyle =
                                        'background-color:#ffffff !important;color:#111827 !important;';

                                    } else {

                                        // PRIORITAS 1 : TIPE KONSUMEN PERUSAHAAN
                                        if ($tipeKonsumen === 'perusahaan') {

                                            $overdue = optional($row->perusahaan)->overdue ?? 28;

                                            if ($selisihHari >= $overdue) {

                                                $rowStyle =
                                                    'background-color:#f87171 !important;color:#111827 !important;font-weight:600;';

                                            } else {

                                                $rowStyle =
                                                    'background-color:#4ade80 !important;color:#111827 !important;font-weight:600;';
                                            }

                                        }

                                        // PRIORITAS 2 : LOGIC SPK
                                        elseif ($kategoriSpk === 'ASURANSI') {

                                            if ($selisihHari >= 35) {
                                                $rowStyle =
                                                    'background-color:#f87171 !important;color:#111827 !important;font-weight:600;';
                                            } else {
                                                $rowStyle =
                                                    'background-color:#4ade80 !important;color:#111827 !important;font-weight:600;';
                                            }

                                        } elseif ($kategoriSpk === 'REGULER') {

                                            if ($selisihHari >= 7) {
                                                $rowStyle =
                                                    'background-color:#f87171 !important;color:#111827 !important;font-weight:600;';
                                            } else {
                                                $rowStyle =
                                                    'background-color:#4ade80 !important;color:#111827 !important;font-weight:600;';
                                            }

                                        } elseif ($kategoriSpk === 'INTERNAL') {

                                            $rowStyle =
                                                'background-color:#fef3c7 !important;color:#111827 !important;font-weight:600;';
                                        }
                                    }
                                }
                            @endphp

                            <tr style="{{ $rowStyle }}">
                                <td style="text-align: center;">{{ $loop->iteration }}.</td>
                                <td>{{ $row->no_spk ?? ($row['no_spk'] ?? '-') }}</td>
                                <td style="text-align: center;">
                                    {{ $row->tipe_konsumen ? ucfirst($row->tipe_konsumen) : '-' }}
                                </td>
                                <td>
                                    {{ $row->perusahaan ? $row->perusahaan->nama : '-' }}
                                </td>
                                <td>{{ $row->nama_konsumen ?? ($row['nama_konsumen'] ?? '-') }}</td>
                                <td>{{ $tglBukti }}</td>
                                <td>{{ $row->no_bukti ?? ($row['no_bukti'] ?? '-') }}</td>
                                <td class="col-spk">{{ strtoupper($row->spk_type ?? ($row['spk_type'] ?? '-')) }}</td>
                                <td class="text-bold">
                                    {{ is_numeric($saldoAwal) ? number_format($saldoAwal, 0, '.', ',') : '-' }}</td>
                                <td style="color: #111827 !important; font-weight: 800;">
                                    {{ is_numeric($debet) ? number_format($debet, 0, '.', ',') : '-' }}</td>
                                <td style="color: #111827 !important; font-weight: 800;">
                                    {{ is_numeric($kredit) ? number_format($kredit, 0, '.', ',') : '-' }}</td>
                                <td class="col-rek-tgl">{{ $tglRek }}</td>
                                <td class="col-keterangan">{{ $row->keterangan ?? ($row['keterangan'] ?? '-') }}</td>

                                <td class="col-rek-tgl">{{ $tglRek2 }}</td>
                                <td class="col-keterangan">{{ $row->keterangan_2 ?? ($row['keterangan_2'] ?? '-') }}</td>

                                <td class="text-bold">
                                    {{ is_numeric($saldoAkhir) ? number_format($saldoAkhir, 0, '.', ',') : '-' }}</td>
                                <td class="col-no-polisi">{{ $row->no_polisi ?? ($row['no_polisi'] ?? '-') }}</td>
                                <td class="col-action"
                                    style="background-color: #ffffff !important; border-left: 1px solid #e5e7eb;">
                                    <div
                                        style="display:flex; gap:12px; justify-content: center; align-items: center; height: 100%;">
                                        <a href="{{ url('/gr/ciawi/' . ($row->id ?? ($row['id'] ?? '')) . '/edit') }}"
                                            class="action-btn edit" title="Edit"
                                            style="text-decoration: none; color: #1d4ed8 !important; font-size: 16px; font-weight: bold;">✎</a>
                                        @if(optional(Auth::user())->is_admin)
                                            <form method="POST"
                                                action="{{ url('/gr/ciawi/' . ($row->id ?? ($row['id'] ?? ''))) }}"
                                                style="display:inline; margin: 0;">
                                                @csrf @method('DELETE')
                                                <button class="action-btn delete" title="Hapus"
                                                    style="background: none; border: none; padding: 0; color: #dc2626 !important; font-size: 16px; font-weight: bold; cursor: pointer;">🗑</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="no-data-row" style="background-color: #ffffff;">
                                <td colspan="21" style="text-align:center; color: #6b7280 !important; padding: 20px;">
                                    Tidak ada data untuk ditampilkan.</td>
                            </tr>
                        @endforelse
                    </tbody>

                    {{-- Bagian Footer / Summary --}}
                    <tfoot>
                        <tr style="background-color: #eff6ff; font-weight: 600;">
                            <td colspan="8"
                                style="text-align: right; padding-right: 16px; font-weight: bold; color: #111827;">Total
                            </td>
                            <td style="color: #111827;">{{ number_format($totalSaldoAwal ?? 0, 0, '.', ',') }}</td>
                            <td style="color: #111827;">{{ number_format($totalDebet ?? 0, 0, '.', ',') }}</td>
                            <td style="color: #111827;">{{ number_format($totalKredit ?? 0, 0, '.', ',') }}</td>
                            <td colspan="4"></td>
                            <td style="color: #111827;">{{ number_format($totalSaldoAkhir ?? 0, 0, '.', ',') }}</td>
                            <td colspan="3"></td>
                        </tr>
                        @php
                            $glSaldoAwal = $totalSaldoAwal ?? 0;
                            $glDebet = $totalDebet ?? 0;
                            $glKredit = $totalKredit ?? 0;
                            $glSaldoAkhir = $totalSaldoAkhir ?? 0;

                            $selisihAwal = ($totalSaldoAwal ?? 0) - $glSaldoAwal;
                            $selisihDebet = ($totalDebet ?? 0) - $glDebet;
                            $selisihKredit = ($totalKredit ?? 0) - $glKredit;
                            $selisihAkhir = ($totalSaldoAkhir ?? 0) - $glSaldoAkhir;
                        @endphp
                        <tr style="background-color: #f8fafc; font-weight: 600;">
                            <td colspan="8"
                                style="text-align: right; padding-right: 16px; font-weight: bold; color: #111827;">GL</td>
                            <td style="color: #111827;">{{ number_format($glSaldoAwal, 0, '.', ',') }}</td>
                            <td style="color: #111827;">{{ number_format($glDebet, 0, '.', ',') }}</td>
                            <td style="color: #111827;">{{ number_format($glKredit, 0, '.', ',') }}</td>
                            <td colspan="4"></td>
                            <td style="color: #111827;">{{ number_format($glSaldoAkhir, 0, '.', ',') }}</td>
                            <td colspan="3"></td>
                        </tr>
                        <tr style="background-color: #fef2f2; font-weight: 600;">
                            <td colspan="8"
                                style="text-align: right; padding-right: 16px; font-weight: bold; color: var(--accent-red);">SELISIH
                            </td>
                            <td style="color: var(--accent-red);">
                                {{ $selisihAwal == 0 ? '-' : number_format($selisihAwal, 0, '.', ',') }}</td>
                            <td style="color: var(--accent-red);">
                                {{ $selisihDebet == 0 ? '-' : number_format($selisihDebet, 0, '.', ',') }}</td>
                            <td style="color: var(--accent-red);">
                                {{ $selisihKredit == 0 ? '-' : number_format($selisihKredit, 0, '.', ',') }}</td>
                            <td colspan="4"></td>
                            <td style="color: #dc2626;">
                                {{ $selisihAkhir == 0 ? '-' : number_format($selisihAkhir, 0, '.', ',') }}</td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        @if(optional(Auth::user())->is_admin)
            {{-- Modal Create --}}
            <div class="modal-overlay" id="createModal">
    <div class="modal" style="max-width: 1100px; width: 95%;">
        <div class="modal-header">
            <h2 class="modal-title">Tambah Data Piutang</h2>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body">
            @if ($errors->any())
                <div class="alert alert-danger"
                    style="margin-bottom: 16px; padding: 12px 16px; background: rgba(37,99,235,0.08); border: 1px solid rgba(37,99,235,0.15); border-radius: 8px; color: var(--accent-red); font-size: 14px;">
                    <ul style="list-style: none; margin: 0; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form id="createForm" method="POST" action="{{ url('/gr/ciawi') }}">
                @csrf
                <div class="form-grid"
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 14px;">
                    <div class="form-group">
                        <label class="form-label">No SPK</label>
                        <input type="text" name="no_spk" class="form-input" placeholder="No SPK"
                            value="{{ old('no_spk') }}">
                    </div>
                    <div class="form-group" id="tipe_konsumen_field">
                        <label class="form-label">Tipe Konsumen</label>
                        <select class="form-select" name="tipe_konsumen" id="tipe_konsumen" onchange="handleTipeChange()">
                            <option value="">Pilih Tipe Konsumen</option>
                            <option value="reguler">REGULER</option>
                            <option value="perusahaan">PERUSAHAAN</option>
                        </select>
                    </div>

                    <div class="form-group" id="perusahaan_container" style="display: none; position: relative;">
                        <label class="form-label">Pilih Perusahaan</label>
                        <input type="text" id="perusahaan_display" class="form-input" placeholder="Klik untuk memilih perusahaan..." readonly style="cursor: pointer; background-color: #f9fafb !important;">
                        <small id="info_overdue_perusahaan"
                            style="display:block; margin-top:6px; color:var(--accent-red); font-weight:600;">
                        </small>
                        
                        <div id="perusahaan_dropdown" class="perusahaan-dropdown-container">
                            <div class="perusahaan-header-flex" style="display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 10px;">
                                <div style="font-weight: 600; color: #111827; white-space: nowrap;">Pilih Perusahaan</div>
                                <input type="text" id="perusahaan_search" class="form-input" 
                                    placeholder="Ketik nama..." 
                                    style="width: 100%; padding: 6px; border: 1px solid #d1d5db; border-radius: 4px;">
                            </div>

                            <div style="max-height: 250px; overflow-y: auto;">
                                <table class="perusahaan-table">
                                    <thead>
                                        <tr>
                                            <th>Nama Perusahaan</th>
                                            <th style="text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="perusahaan_list">
                                        @foreach($perusahaans as $p)
                                            <tr>
                                                <td>{{ $p->nama }}</td>
                                                <td>{{ $p->overdue }} Hari</td>
                                                <td style="text-align: center;">
                                                    <button type="button" class="btn-pilih-perusahaan" onclick="pilihPerusahaan('{{ $p->id }}', '{{ $p->nama }}', '{{ $p->overdue }}')">Pilih</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <input type="hidden" name="perusahaan_id" id="perusahaan_id_input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Konsumen</label>
                        <input type="text" name="nama_konsumen" class="form-input" placeholder="Nama Konsumen"
                            value="{{ old('nama_konsumen') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tgl. Bukti</label>
                        <input type="date" name="tgl_bukti" class="form-input"
                            value="{{ old('tgl_bukti') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">No. Invoice</label>
                        <input type="text" name="no_bukti" class="form-input" placeholder="Nomor invoice"
                            value="{{ old('no_bukti') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Saldo Awal</label>
                        <input type="text" name="saldo_awal" class="form-input" placeholder="0"
                            value="{{ old('saldo_awal') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">KATEGORI SPK</label>
                        <select class="form-select" name="spk_type" id="spk_type_select" style="width: 100%;">
                            <option value="">Pilih Jenis SPK</option>
                            <option value="REGULER">REGULER</option>
                            <option value="INTERNAL">INTERNAL</option>
                        </select>
                    </div>
                    {{-- payment fields hidden on create for GR; payments done on edit --}}
                    <input type="hidden" name="debet" value="0">
                    <input type="hidden" name="kredit" value="0">
                    <input type="hidden" name="tgl_bukti_rek" value="">
                    <div class="form-group">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" class="form-input" placeholder="Keterangan"
                            value="{{ old('keterangan') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">No Polisi</label>
                        <input type="text" name="no_polisi" class="form-input" placeholder="Nomor polisi"
                            value="{{ old('no_polisi') }}">
                    </div>
                    <div class="form-group full-width" style="grid-column: 1 / -1;">
                        <label class="form-label">Saldo Akhir</label>
                        <input type="text" name="saldo_akhir" class="form-input" placeholder="Saldo Akhir"
                            id="create_saldo_akhir" readonly value="{{ old('saldo_akhir') }}">
                    </div>
                </div>
            </form>
            
            <script>
                (function() {
                    const inputSaldoAwal = document.querySelector('#createForm input[name="saldo_awal"]');
                    const inputSaldoAkhir = document.getElementById('create_saldo_akhir');
                    if (inputSaldoAwal && inputSaldoAkhir) {
                        inputSaldoAwal.addEventListener('input', function() {
                            const v = this.value.replace(/[^0-9.\-]/g, '') || 0;
                            inputSaldoAkhir.value = v;
                        });;
                        inputSaldoAkhir.value = inputSaldoAwal.value || 0;
                    }
                })();
            </script>
        </div>
        <div class="modal-footer">
            <button class="btn-secondary" onclick="closeModal()">Batal</button>
            <button class="btn-primary" form="createForm">Simpan</button>
            </div>
        </div>
    </div>
        @endif
    </div>

    {{-- Script Fitur Search Real-time & Shortcut Ctrl+K --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');

            // Listener Input Pencarian
            searchInput.addEventListener('input', function() {
                const filterValue = this.value.toLowerCase().trim();
                const tableRows = document.querySelectorAll('#piutangTable tbody tr');

                tableRows.forEach(row => {
                    // Jangan sembunyikan baris kalau bawaan data memang kosong
                    if (row.classList.contains('no-data-row')) return;

                    // Mengambil seluruh teks di baris tabel saat ini
                    const rowText = row.textContent.toLowerCase();

                    // Tampilkan/Sembunyikan baris berdasarkan kecocokan keyword pencarian
                    if (rowText.includes(filterValue)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Jika data yang cocok tidak ada, tetap tampilkan baris no-data-row
                const noDataRow = document.querySelector('.no-data-row');
                if (noDataRow) {
                    const visibleRows = Array.from(tableRows).some(row => row.style.display !== 'none');
                    noDataRow.style.display = visibleRows ? 'none' : '';
                }
            });

            // Fitur Shortcut: Tekan Ctrl + K untuk otomatis fokus ke Input Pencarian
            window.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
                    e.preventDefault(); // Mencegah default browser search bar
                    searchInput.focus();
                }
            });

            // Asuransi searchable dropdown: fetch data and enable search/select
            const spkTypeSelect = document.getElementById('spk_type_select');
            const asuransiField = document.getElementById('asuransi_field');
            if (spkTypeSelect && asuransiField) {
                let asuransiData = [];
                let asuransiLoaded = false;

                const asuransiListEl = () => document.getElementById('asuransi_list');
                const asuransiDropdownWrap = () => document.getElementById('asuransi_dropdown');
                const asuransiHidden = () => document.getElementById('nama_asuransi_input');
                const asuransiSearchInput = () => document.getElementById('asuransi_search');

                async function loadAsuransi() {
                    try {
                        const res = await fetch('{{ url('/asuransi/list') }}');
                        if (!res.ok) throw new Error('Network error');
                        asuransiData = await res.json();
                        asuransiLoaded = true;
                        renderList(asuransiData);
                    } catch (e) {
                        console.error('Failed to load asuransi', e);
                    }
                }

                function renderList(list) {
                    const ul = asuransiListEl();
                    if (!ul) return;
                    ul.innerHTML = '';
                    list.forEach(item => {
                        const li = document.createElement('li');
                        li.textContent = item.nama;
                        li.setAttribute('data-id', item.id);
                        li.style.padding = '8px 12px';
                        li.style.cursor = 'pointer';
                        li.addEventListener('click', function() {
                            const name = this.textContent;
                            asuransiHidden().value = name;
                            asuransiSearchInput().value = name;
                            const wrap = asuransiDropdownWrap();
                            if (wrap) wrap.style.display = 'none';
                        });
                        ul.appendChild(li);
                    });
                }

                function filterList(q) {
                    const ql = q.trim().toLowerCase();
                    const filtered = asuransiData.filter(a => a.nama.toLowerCase().includes(ql));
                    renderList(filtered);
                }

                spkTypeSelect.addEventListener('change', function() {
                    if (this.value === 'ASURANSI') {
                        asuransiField.style.display = 'block';
                        if (!asuransiLoaded) loadAsuransi();
                    } else {
                        asuransiField.style.display = 'none';
                        const ah = asuransiHidden(); if (ah) ah.value = '';
                        const si = asuransiSearchInput(); if (si) si.value = '';
                        const wrap = asuransiDropdownWrap(); if (wrap) wrap.style.display = 'none';
                    }
                });

                // hide dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    const wrap = asuransiDropdownWrap();
                    if (!wrap) return;
                    if (e.target.closest('#asuransi_field')) return;
                    wrap.style.display = 'none';
                });

                const si = asuransiSearchInput();
                if (si) {
                    si.addEventListener('input', function() {
                        const q = this.value;
                        if (!asuransiLoaded) {
                            loadAsuransi().then(() => filterList(q));
                        } else {
                            filterList(q);
                        }
                        const wrap = asuransiDropdownWrap(); if (wrap) wrap.style.display = 'block';
                    });
                    si.addEventListener('focus', function() {
                        const wrap = asuransiDropdownWrap(); if (wrap) wrap.style.display = 'block';
                    });
                }
            }
        });

        function handleTipeChange() {
        const tipe = document.getElementById('tipe_konsumen').value;
        const container = document.getElementById('perusahaan_container');
        container.style.display = (tipe === 'perusahaan') ? 'block' : 'none';
        }

        document.addEventListener('DOMContentLoaded', function () {

            const tipeKonsumen = document.getElementById('tipe_konsumen');

            if (tipeKonsumen) {
                tipeKonsumen.addEventListener('change', handleTipeChange);

                // jalankan saat halaman pertama kali dibuka
                handleTipeChange();
            }

        });

        // 2. Toggle Dropdown saat input diklik
        document.getElementById('perusahaan_display').addEventListener('click', function(e) {
            e.stopPropagation(); // Mencegah klik menutup otomatis
            const dd = document.getElementById('perusahaan_dropdown');
            dd.style.display = (dd.style.display === 'block') ? 'none' : 'block';
        });

        // 3. Fungsi Pilih Perusahaan
        function pilihPerusahaan(id, nama, overdue) {

            document.getElementById('perusahaan_id_input').value = id;

            document.getElementById('perusahaan_display').value = nama;

            document.getElementById('info_overdue_perusahaan').innerHTML =
                'Overdue perusahaan ini : <b>' + overdue + ' hari</b>';

            document.getElementById('perusahaan_dropdown').style.display = 'none';
        }

        // 4. Fitur Search
        document.getElementById('perusahaan_search').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#perusahaan_list tr');
            rows.forEach(row => {
                // Hanya cari di kolom pertama (Nama Perusahaan)
                let text = row.cells[0].innerText.toLowerCase(); 
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });

        // Opsional: Tutup dropdown jika klik di luar area
        document.addEventListener('click', function(e) {
            const dd = document.getElementById('perusahaan_dropdown');
            const display = document.getElementById('perusahaan_display');
            if (!display.contains(e.target) && !dd.contains(e.target)) {
                dd.style.display = 'none';
            }
        });
    </script>
@endsection
