@extends('layouts.app')

@section('title', 'BP - Rekapitulasi Piutang')

@section('content')
    <div style="width: 100%; box-sizing: border-box; overflow-x: hidden;">
        <div class="page-header" style="margin-bottom: 20px;">
            <div>
                <h1 class="page-title">Rekapitulasi Piutang - BP</h1>
                <p class="page-subtitle">Kelola data saldo awal, mutasi, rekonsiliasi GL, dan saldo akhir konsumen secara
                    instan.</p>
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
                /* Saat diklik berubah accent */
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

            /* TEMA DROPDOWN TABEL ASURANSI */
            .asuransi-dropdown-container {
                display: none;
                position: absolute;
                left: 0;
                right: 0;
                z-index: 1050;
                background: #ffffff;
                border: 1px solid #d1d5db;
                border-radius: 8px;
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
                padding: 16px;
                margin-top: 8px;
                width: 100%;
                min-width: 400px;
            }

            .asuransi-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }

            .asuransi-table th {
                background-color: #f9fafb;
                color: #4b5563;
                font-size: 12px;
                font-weight: 600;
                padding: 10px;
                border-bottom: 2px solid #e5e7eb;
                text-align: left;
            }

            .asuransi-table td {
                padding: 10px;
                border-bottom: 1px solid #f3f4f6;
                font-size: 13px;
                color: #374151;
                vertical-align: middle;
            }

            .asuransi-table tr:hover {
                background-color: #f8fafc;
            }

            .btn-pilih-asuransi {
                background-color: #0ea5e9 !important; /* Biru muda mirip foto */
                color: #ffffff !important;
                border: none;
                border-radius: 4px;
                padding: 6px 16px;
                font-size: 12px;
                font-weight: 600;
                cursor: pointer;
                transition: background-color 0.2s;
                text-align: center;
            }

            .btn-pilih-asuransi:hover {
                background-color: #0284c7 !important;
            }

            .asuransi-header-flex {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 10px;
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
                            <th rowspan="2">NAMA KONSUMEN</th>
                            <th rowspan="2">TGL. BUKTI</th>
                            <th rowspan="2" class="col-bukti">NO. INVOICE</th>
                            <th rowspan="2" class="col-spk">KATEGORI SPK</th>
                            <th rowspan="2">NAMA ASURANSI</th>
                            <th rowspan="2">SALDO AWAL</th>
                            <th colspan="2" style="text-align:center;">MUTASI</th>
                            <th rowspan="2" class="col-rek-tgl">TGL. BUKTI</th>
                            <th rowspan="2" class="col-keterangan">KETERANGAN</th>
                            <th rowspan="2">TGL. BUKTI TAHAP 2</th>
                            <th rowspan="2">KETERANGAN TAHAP 2</th>
                            <th rowspan="2">TGL. BUKTI TAHAP 3</th>
                            <th rowspan="2">KETERANGAN TAHAP 3</th>
                            <th rowspan="2">SALDO AKHIR</th>
                            <th rowspan="2" class="col-no-polisi">NO POLISI</th>
                            <th rowspan="2" class="col-no-polis">NO POLIS</th>
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
                                $rawTglRek3 = $row->tgl_bukti_rek_3 ?? ($row['tgl_bukti_rek_3'] ?? null);
                                $tglBukti = $rawTglBukti
                                    ? \Illuminate\Support\Carbon::parse($rawTglBukti)->format('d F Y')
                                    : '-';
                                $tglRek = $rawTglRek
                                    ? \Illuminate\Support\Carbon::parse($rawTglRek)->format('d F Y')
                                    : '-';

                                $tglRek2 = $rawTglRek2
                                    ? \Illuminate\Support\Carbon::parse($rawTglRek2)->format('d F Y')
                                    : '-';

                                $tglRek3 = $rawTglRek3
                                    ? \Illuminate\Support\Carbon::parse($rawTglRek3)->format('d F Y')
                                    : '-';

                                $saldoAwal = $row->saldo_awal ?? ($row['saldo_awal'] ?? 0);
                                $debet = $row->debet ?? ($row['debet'] ?? 0);
                                $kredit =
                                        ($row->kredit ?? 0) +
                                        ($row->kredit_2 ?? 0) +
                                        ($row->kredit_3 ?? 0);
                                $saldoAkhir = $row->saldo_akhir ?? ($row['saldo_akhir'] ?? 0);

                                $kategoriSpk = strtoupper($row->spk_type ?? ($row['spk_type'] ?? ''));

                                $rowStyle = 'background-color: #ffffff;';

                                if ($rawTglBukti) {

                                    $hariIni = \Illuminate\Support\Carbon::now('Asia/Jakarta')->startOfDay();

                                    $tanggalInput = \Illuminate\Support\Carbon::parse(
                                        $rawTglBukti,
                                        'Asia/Jakarta'
                                    )->startOfDay();

                                    $selisihHari = $tanggalInput->diffInDays($hariIni);

                                    if ($saldoAkhir <= 0) {

                                        $rowStyle = 'background-color: #ffffff !important;';

                                    } else {

                                        if ($kategoriSpk === 'ASURANSI') {

                                            if ($selisihHari >= 35) {
                                                $rowStyle = 'background-color: #f28888 !important; color:#111827 !important; font-weight:600;';
                                            } else {
                                                $rowStyle = 'background-color: #86f7af !important; color:#111827 !important; font-weight:600;';
                                            }

                                        } elseif ($kategoriSpk === 'REGULER') {

                                            if ($selisihHari >= 7) {
                                                $rowStyle = 'background-color: #f28888 !important; color:#111827 !important; font-weight:600;';
                                            } else {
                                                $rowStyle = 'background-color: #86f7af !important; color:#111827 !important; font-weight:600;';
                                            }

                                        } elseif ($kategoriSpk === 'INTERNAL') {

                                            // BELUM LUNAS INTERNAL = KREM
                                            $rowStyle = 'background-color: #fef3c7 !important; color:#111827 !important; font-weight:600;';
                                        }
                                    }
                                }
                            @endphp

                            <tr style="{{ $rowStyle }}">
                                <td style="text-align: center;">{{ $loop->iteration }}.</td>
                                <td>{{ $row->no_spk ?? ($row['no_spk'] ?? '-') }}</td>
                                <td>{{ $row->nama_konsumen ?? ($row['nama_konsumen'] ?? '-') }}</td>
                                <td>{{ $tglBukti }}</td>
                                <td>{{ $row->no_bukti ?? ($row['no_bukti'] ?? '-') }}</td>
                                <td class="col-spk">{{ strtoupper($row->spk_type ?? ($row['spk_type'] ?? '-')) }}</td>
                                <td>{{ $row->nama_asuransi ?? ($row['nama_asuransi'] ?? '-') }}</td>
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

                                <td class="col-rek-tgl">{{ $tglRek3 }}</td>
                                <td class="col-keterangan">{{ $row->keterangan_3 ?? ($row['keterangan_3'] ?? '-') }}</td>

                                <td class="text-bold">
                                    {{ is_numeric($saldoAkhir) ? number_format($saldoAkhir, 0, '.', ',') : '-' }}</td>
                                <td class="col-no-polisi">{{ $row->no_polisi ?? ($row['no_polisi'] ?? '-') }}</td>
                                <td class="col-no-polis">{{ $row->no_polis ?? ($row['no_polis'] ?? '-') }}</td>
                                <td class="col-action"
                                    style="background-color: #ffffff !important; border-left: 1px solid #e5e7eb;">
                                    <div
                                        style="display:flex; gap:12px; justify-content: center; align-items: center; height: 100%;">
                                        <a href="{{ url('/bp/' . ($row->id ?? ($row['id'] ?? '')) . '/edit') }}"
                                            class="action-btn edit" title="Edit"
                                            style="text-decoration: none; color: #1d4ed8 !important; font-size: 16px; font-weight: bold;">✎</a>
                                        @if(optional(Auth::user())->is_admin)
                                            <form method="POST" action="{{ url('/bp/' . ($row->id ?? ($row['id'] ?? ''))) }}"
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
                            <td colspan="7"
                                style="text-align: right; padding-right: 16px; font-weight: bold; color: #111827;">Total
                            </td>
                            <td style="color: #111827;">{{ number_format($totalSaldoAwal ?? 0, 0, '.', ',') }}</td>
                            <td style="color: #111827;">{{ number_format($totalDebet ?? 0, 0, '.', ',') }}</td>
                            <td style="color: #111827;">{{ number_format($totalKredit ?? 0, 0, '.', ',') }}</td>
                            <td colspan="6"></td>
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
                            <td colspan="7"
                                style="text-align: right; padding-right: 16px; font-weight: bold; color: #111827;">GL</td>
                            <td style="color: #111827;">{{ number_format($glSaldoAwal, 0, '.', ',') }}</td>
                            <td style="color: #111827;">{{ number_format($glDebet, 0, '.', ',') }}</td>
                            <td style="color: #111827;">{{ number_format($glKredit, 0, '.', ',') }}</td>
                            <td colspan="6"></td>
                            <td style="color: #111827;">{{ number_format($glSaldoAkhir, 0, '.', ',') }}</td>
                            <td colspan="3"></td>
                        </tr>
                        <tr style="background-color: #fef2f2; font-weight: 600;">
                            <td colspan="7"
                                style="text-align: right; padding-right: 16px; font-weight: bold; color: #dc2626;">SELISIH
                            </td>
                            <td style="color: var(--accent-red);">
                                {{ $selisihAwal == 0 ? '-' : number_format($selisihAwal, 0, '.', ',') }}</td>
                            <td style="color: var(--accent-red);">
                                {{ $selisihDebet == 0 ? '-' : number_format($selisihDebet, 0, '.', ',') }}</td>
                            <td style="color: var(--accent-red);">
                                {{ $selisihKredit == 0 ? '-' : number_format($selisihKredit, 0, '.', ',') }}</td>
                            <td colspan="6"></td>
                            <td style="color: var(--accent-red);">
                                {{ $selisihAkhir == 0 ? '-' : number_format($selisihAkhir, 0, '.', ',') }}</td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

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
            <form id="createForm" method="POST" action="{{ url('/bp') }}">
                @csrf
                <div class="form-grid"
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 14px;">
                    <div class="form-group">
                        <label class="form-label">No SPK</label>
                        <input type="text" name="no_spk" class="form-input" placeholder="No SPK"
                            value="{{ old('no_spk') }}">
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
                            <option value="ASURANSI">ASURANSI</option>
                            <option value="REGULER">REGULER</option>
                            <option value="INTERNAL">INTERNAL</option>
                        </select>
                    </div>
                    <div class="form-group" id="asuransi_field" style="display: none; position: relative;">
                        <label class="form-label">Nama Asuransi</label>
                        
                        <input type="text" id="asuransi_display" class="form-input" placeholder="Klik untuk memilih asuransi..." readonly style="cursor: pointer; background-color: #f9fafb !important;">
                        
                        <div id="asuransi_dropdown" class="asuransi-dropdown-container">
                            <div class="asuransi-header-flex">
                                <div style="font-weight: 600; color: #111827; font-size: 14px;">Pilih Asuransi</div>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <label style="font-size: 13px; color: #6b7280;">Search:</label>
                                    <input type="text" id="asuransi_search" class="form-input" placeholder="Ketik nama..." style="padding: 4px 8px; font-size: 13px; max-height: 30px;">
                                </div>
                            </div>

                            <div style="max-height: 250px; overflow-y: auto; border: 1px solid #e5e7eb; border-radius: 6px;">
                                <table class="asuransi-table">
                                    <thead style="position: sticky; top: 0; z-index: 10;">
                                        <tr>
                                            <th>Nama Asuransi <span style="color: #9ca3af; font-size: 10px;">↓↑</span></th>
                                            <th style="text-align: center; width: 100px;">Action <span style="color: #9ca3af; font-size: 10px;">↓↑</span></th>
                                        </tr>
                                    </thead>
                                    <tbody id="asuransi_list">
                                        </tbody>
                                </table>
                            </div>
                        </div>

                        <input type="hidden" name="nama_asuransi" id="nama_asuransi_input" value="{{ old('nama_asuransi') }}">
                    </div>
                    {{-- payment fields are set by admin later; hide on create modal --}}
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
                    <div class="form-group">
                        <label class="form-label">No Polis</label>
                        <input type="text" name="no_polis" class="form-input" placeholder="Nomor polis"
                            value="{{ old('no_polis') }}">
                    </div>
                    <div class="form-group full-width" style="grid-column: 1 / -1;">
                        <label class="form-label">Saldo Akhir</label>
                        <input type="text" name="saldo_akhir" class="form-input input-blocked" placeholder="Saldo Akhir" 
                            id="create_saldo_akhir" readonly value="{{ old('saldo_akhir') }}">
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn-secondary" onclick="closeModal()">Batal</button>
            <button class="btn-primary" form="createForm">Simpan</button>
        </div>
    </div>
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
            });

            // Fitur Shortcut: Tekan Ctrl + K untuk otomatis fokus ke Input Pencarian
            window.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
                    e.preventDefault(); // Mencegah default browser search bar
                    searchInput.focus();
                }
            });

            // Asuransi searchable dropdown: fetch data and enable search/select
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
    const asuransiDisplayInput = () => document.getElementById('asuransi_display');

    async function loadAsuransi() {
        try {
            // Ubah loading state di dalam tabel
            asuransiListEl().innerHTML = '<tr><td colspan="2" style="text-align:center;">Memuat data...</td></tr>';
            const res = await fetch('{{ url('/asuransi/list') }}');
            if (!res.ok) throw new Error('Network error');
            asuransiData = await res.json();
            asuransiLoaded = true;
            renderList(asuransiData);
        } catch (e) {
            console.error('Failed to load asuransi', e);
            asuransiListEl().innerHTML = '<tr><td colspan="2" style="text-align:center; color: red;">Gagal memuat data</td></tr>';
        }
    }

    // Merubah render <li> menjadi baris tabel <tr>
    function renderList(list) {
        const tbody = asuransiListEl();
        if (!tbody) return;
        tbody.innerHTML = '';
        
        if (list.length === 0) {
            tbody.innerHTML = '<tr><td colspan="2" style="text-align:center; padding:15px; color:#6b7280;">Tidak ada asuransi ditemukan.</td></tr>';
            return;
        }

        list.forEach(item => {
            const tr = document.createElement('tr');
            
            // Kolom Nama
            const tdName = document.createElement('td');
            tdName.textContent = item.nama;
            
            // Kolom Action (Tombol Pilih)
            const tdAction = document.createElement('td');
            tdAction.style.textAlign = 'center';
            
            const btn = document.createElement('button');
            btn.type = 'button'; // Cegah submit form
            btn.textContent = 'Pilih';
            btn.className = 'btn-pilih-asuransi';
            
            // Event saat tombol pilih ditekan
            btn.addEventListener('click', function() {
                asuransiHidden().value = item.nama;
                asuransiDisplayInput().value = item.nama; // Tampilkan di input form
                asuransiDropdownWrap().style.display = 'none'; // Tutup modal/dropdown
            });

            tdAction.appendChild(btn);
            tr.appendChild(tdName);
            tr.appendChild(tdAction);
            tbody.appendChild(tr);
        });
    }

    function filterList(q) {
        const ql = q.trim().toLowerCase();
        const filtered = asuransiData.filter(a => a.nama.toLowerCase().includes(ql));
        renderList(filtered);
    }

    // Toggle tampilan dropdown saat asuransi_display di-klik
    const asuransiDisplay = asuransiDisplayInput();
    if (asuransiDisplay) {
        asuransiDisplay.addEventListener('click', function(e) {
            e.preventDefault();
            const wrap = asuransiDropdownWrap();
            if (wrap.style.display === 'none' || wrap.style.display === '') {
                wrap.style.display = 'block';
                if (!asuransiLoaded) loadAsuransi();
            } else {
                wrap.style.display = 'none';
            }
        });
    }

    // Mencegah dropdown tertutup saat mengklik bagian dalamnya
    const wrapEl = asuransiDropdownWrap();
    if (wrapEl) {
        wrapEl.addEventListener('click', function(e) {
            e.stopPropagation(); 
        });
    }

    // Menangani pencarian lokal di dalam dropdown
    const searchInputEl = asuransiSearchInput();
    if (searchInputEl) {
        searchInputEl.addEventListener('input', function() {
            filterList(this.value);
        });
    }

    // Logika menampilkan field asuransi berdasarkan Kategori SPK
    spkTypeSelect.addEventListener('change', function() {
        if (this.value === 'ASURANSI') {
            asuransiField.style.display = 'block';
            if (!asuransiLoaded) {
                // Opsional: Langsung memuat data di belakang layar saat SPK Asuransi dipilih
                loadAsuransi(); 
            }
        } else {
            asuransiField.style.display = 'none';
            if (asuransiHidden()) asuransiHidden().value = '';
            if (asuransiDisplayInput()) asuransiDisplayInput().value = '';
            if (asuransiSearchInput()) asuransiSearchInput().value = '';
            if (asuransiDropdownWrap()) asuransiDropdownWrap().style.display = 'none';
        }
    });

    // Menutup dropdown saat klik di luar area
    document.addEventListener('click', function(e) {
        const wrap = asuransiDropdownWrap();
        if (!wrap) return;
        // Jika klik di luar asuransi_field, tutup dropdown
        if (!e.target.closest('#asuransi_field')) {
            wrap.style.display = 'none';
        }
    });
}

            // Auto-fill saldo_akhir on create to match saldo_awal
            const inputSaldoAwal = document.querySelector('input[name="saldo_awal"]');
            const inputSaldoAkhir = document.getElementById('create_saldo_akhir');
            if (inputSaldoAwal && inputSaldoAkhir) {
                inputSaldoAwal.addEventListener('input', function() {
                    const v = this.value.replace(/[^0-9.\-]/g, '') || 0;
                    inputSaldoAkhir.value = v;
                });
                // initialize
                inputSaldoAkhir.value = inputSaldoAwal.value || 0;
            }
        });
    </script>
@endsection
