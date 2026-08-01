@extends('layouts.app')

@section('title', 'GR Cianjur - Edit Piutang')

@section('content')
    <div style="padding: 16px; max-width: 1100px; margin: 0 auto; box-sizing: border-box; background-color: #ffffff;">

        {{-- Header --}}
        <div class="page-header" style="margin-bottom: 16px; border-bottom: 2px solid #f3f4f6; padding-bottom: 8px;">
            <div>
                <h1 class="page-title" style="color: #dc2626 !important; font-weight: 700 !important; font-size: 20px; margin: 0;">Edit Data Piutang - GR Cianjur</h1>
                <p class="page-subtitle" style="color: #6b7280; font-size: 12px; margin-top: 2px;">Perbarui detail piutang konsumen cabang Cianjur.</p>
            </div>
        </div>

        {{-- Error Alert --}}
        @if ($errors->any())
            <div style="background-color: #fee2e2; border: 1px solid #fca5a5; color: #b91c1c; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 13px;">
                <strong>Terjadi kesalahan input:</strong>
                <ul style="margin: 5px 0 0 20px; padding: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <style>
            .form-section-card {
                background: #ffffff;
                border: 1px solid #e5e7eb;
                border-radius: 6px;
                padding: 12px 16px;
                margin-bottom: 12px;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            }

            .section-title {
                font-size: 11px;
                font-weight: 700;
                color: #374151;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                margin-bottom: 10px;
                padding-bottom: 4px;
                border-bottom: 2px solid #fee2e2;
                display: inline-block;
            }

            .form-label {
                color: #4b5563 !important;
                font-weight: 600 !important;
                font-size: 12px !important;
                margin-bottom: 4px !important;
                display: block;
            }

            .form-input, .form-select {
                background-color: #ffffff !important;
                border: 1px solid #d1d5db !important;
                color: #111827 !important;
                width: 100%;
                padding: 6px 10px;
                border-radius: 5px;
                box-sizing: border-box;
                font-size: 13px;
                transition: all 0.15s ease-in-out;
            }

            .form-input:focus, .form-select:focus {
                border-color: #dc2626 !important;
                box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.15) !important;
                outline: none;
            }

            /* Style Khusus untuk Field yang di Block */
            .input-blocked {
                background-color: #f3f4f6 !important;
                color: #6b7280 !important;
                cursor: not-allowed !important;
                pointer-events: none;
            }

            .btn-primary {
                background-color: #dc2626 !important;
                border: 1px solid #dc2626 !important;
                color: #ffffff !important;
                padding: 8px 18px;
                border-radius: 5px;
                font-weight: 600;
                font-size: 13px;
                cursor: pointer;
            }

            .btn-primary:hover { background-color: #b91c1c !important; }
            .btn-secondary {
                background-color: #ffffff !important;
                border: 1px solid #d1d5db !important;
                color: #4b5563 !important;
                padding: 8px 18px;
                border-radius: 5px;
                font-weight: 600;
                font-size: 13px;
                cursor: pointer;
            }
            .btn-secondary:hover { background-color: #f9fafb !important; }

            /* Dropdown Perusahaan */
            .perusahaan-dropdown-container {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                width: 600px;
                max-width: 90vw;
                background: #fff;
                border: 1px solid #d1d5db;
                border-radius: 10px;
                box-shadow: 0 10px 25px rgba(0,0,0,.15);
                z-index: 9999;
                padding: 12px;
                margin-top: 5px;
            }

            /* Header */
            .perusahaan-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 12px;
                margin-bottom: 12px;
            }

            .perusahaan-header strong {
                font-size: 14px;
                color: #111827;
            }

            .perusahaan-header input {
                width: 250px;
                padding: 8px 12px;
                border: 1px solid #d1d5db;
                border-radius: 8px;
                font-size: 14px;
            }

            .perusahaan-header input:focus {
                border-color: #dc2626;
                box-shadow: 0 0 0 3px rgba(220,38,38,.15);
                outline: none;
            }

            /* Table */
            .perusahaan-table {
                width: 100%;
                border-collapse: collapse;
            }

            .perusahaan-table th {
                position: sticky;
                top: 0;
                background: #f9fafb;
                padding: 10px;
                border-bottom: 2px solid #e5e7eb;
                font-weight: 700;
                text-align: left;
            }

            .perusahaan-table td {
                padding: 10px;
                border-bottom: 1px solid #f3f4f6;
            }

            .perusahaan-table tr:hover {
                background: #fef2f2;
            }

            /* Tombol */
            .btn-pilih-perusahaan {
                background: #dc2626;
                color: #fff;
                border: none;
                padding: 6px 12px;
                border-radius: 6px;
                cursor: pointer;
                font-size: 13px;
                font-weight: 600;
            }

            .btn-pilih-perusahaan:hover {
                background: #b91c1c;
            }
        </style>

        <form method="POST" action="{{ url('/gr/cianjur/' . ($id ?? ($record->id ?? ''))) }}" id="formEditPiutang">
            @csrf
            @method('PUT')

            {{-- Section 1: Informasi Konsumen --}}
            <div class="form-section-card">
                <span class="section-title" style="color: #dc2626; border-bottom-color: #fca5a5;">1. Informasi Konsumen</span>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px;">
                    <div class="form-group">
                        <label class="form-label">No SPK <span style="color:red">*</span></label>
                        <input type="text" name="no_spk" class="form-input input-blocked" value="{{ old('no_spk', $record->no_spk ?? ($record['no_spk'] ?? '')) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tipe Konsumen</label>
                        <select class="form-select input-blocked" name="tipe_konsumen" id="tipe_konsumen_edit">
                            <option value="reguler"
                                {{ old('tipe_konsumen', $record->tipe_konsumen ?? '') == 'reguler' ? 'selected' : '' }}>
                                REGULER
                            </option>
                            <option value="perusahaan"
                                {{ old('tipe_konsumen', $record->tipe_konsumen ?? '') == 'perusahaan' ? 'selected' : '' }}>
                                PERUSAHAAN
                            </option>
                        </select>
                    </div>

                    <div class="form-group"
                        id="perusahaan_container_edit"
                        style="{{ old('tipe_konsumen', $record->tipe_konsumen ?? '') == 'perusahaan' ? '' : 'display:none;' }} position:relative;">

                        <label class="form-label">
                            Nama Perusahaan
                        </label>

                        <input
                            type="text"
                            id="perusahaan_display_edit"
                            class="form-input"
                            readonly
                            style="cursor:pointer;background:#f9fafb !important;"
                            value="{{ old('perusahaan_nama', optional($record->perusahaan)->nama ?? '') }}"
                            placeholder="Klik untuk memilih perusahaan">

                            <div id="overdueInfoEdit" style="margin-top:8px;">
                                @if(isset($record->perusahaan) && $record->perusahaan)
                                    <div style="
                                        background:#fef2f2;
                                        border:1px solid #fecaca;
                                        color:var(--accent-red);
                                        padding:8px 12px;
                                        border-radius:6px;
                                        font-size:12px;
                                        font-weight:600;
                                    ">
                                        Overdue Perusahaan:
                                            {{ $record->perusahaan->overdue ?? 0 }} Hari
                                    </div>
                                @endif
                            </div>

                        <input
                            type="hidden"
                            name="perusahaan_id"
                            id="perusahaan_id_input_edit"
                            value="{{ old('perusahaan_id', $record->perusahaan_id ?? '') }}">

                        <div id="perusahaan_dropdown_edit" class="perusahaan-dropdown-container">

                            <div class="perusahaan-header">
                                <strong>Pilih Perusahaan</strong>

                                <div style="display:flex;gap:8px;align-items:center;">
                                    <label>Search:</label>

                                    <input
                                        type="text"
                                        id="perusahaan_search_edit"
                                        placeholder="Ketik nama perusahaan...">                                                             
                                </div>
                            </div>

                            <div style="max-height:250px;overflow-y:auto;">
                                <table class="perusahaan-table">
                                    <thead>
                                        <tr>
                                            <th>Nama Perusahaan</th>
                                            <th width="120">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody id="perusahaan_list_edit">
                                        @foreach($perusahaans as $p)
                                            <tr>
                                                <td>{{ $p->nama }}</td>
                                                <td>{{ $p->overdue }}</td>
                                                <td style="text-align:center;">
                                                    <button
                                                        type="button"
                                                        class="btn-pilih-perusahaan"
                                                        onclick="pilihPerusahaanEdit('{{ $p->id }}','{{ $p->nama }}', '{{ $p->overdue ?? 0 }}')">
                                                        Pilih
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Konsumen <span style="color:red">*</span></label>
                        <input type="text" name="nama_konsumen" class="form-input {{ ($record->nama_konsumen ?? ($record['nama_konsumen'] ?? '')) ? 'input-blocked' : '' }}" value="{{ old('nama_konsumen', $record->nama_konsumen ?? ($record['nama_konsumen'] ?? '')) }}" {{ ($record->nama_konsumen ?? ($record['nama_konsumen'] ?? '')) ? 'readonly' : '' }}>
                    </div>
                    <div class="form-group">
                        <label class="form-label">No. Polisi (Plat) <span style="color:red">*</span></label>
                        <input type="text" name="no_polisi" class="form-input {{ ($record->no_polisi ?? ($record['no_polisi'] ?? '')) ? 'input-blocked' : '' }}" value="{{ old('no_polisi', $record->no_polisi ?? ($record['no_polisi'] ?? '')) }}" {{ ($record->no_polisi ?? ($record['no_polisi'] ?? '')) ? 'readonly' : '' }}>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kategori SPK <span style="color:red">*</span></label>
                        <select class="form-select input-blocked" name="spk_type" id="spkTypeSelect">
                            <option value="">Pilih Jenis SPK</option>
                            <option value="REGULER" {{ old('spk_type', $record->spk_type ?? ($record['spk_type'] ?? '')) == 'REGULER' ? 'selected' : '' }}>REGULER</option>
                            <option value="INTERNAL" {{ old('spk_type', $record->spk_type ?? ($record['spk_type'] ?? '')) == 'INTERNAL' ? 'selected' : '' }}>INTERNAL</option>
                            <option value="ASURANSI" {{ old('spk_type', $record->spk_type ?? ($record['spk_type'] ?? '')) == 'ASURANSI' ? 'selected' : '' }}>ASURANSI</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Section 2: Transaksi & Pembukuan Utama --}}
            <div class="form-section-card">
                <span class="section-title">2. Transaksi & Pembukuan Utama</span>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px;">
                    <div class="form-group">
                        <label class="form-label">Tgl. Bukti Utama (Locked)</label>
                        <input type="date" name="tgl_bukti" class="form-input input-blocked" readonly
                            value="{{ old('tgl_bukti', isset($record->tgl_bukti) ? \Illuminate\Support\Carbon::parse($record->tgl_bukti)->format('Y-m-d') : ($record['tgl_bukti'] ?? '')) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">No. Invoice Utama (Locked)</label>
                        <input type="text" name="no_bukti" class="form-input input-blocked" readonly value="{{ old('no_bukti', $record->no_bukti ?? ($record['no_bukti'] ?? '')) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Saldo Pembukuan Awal (Locked)</label>
                        <input type="text" name="saldo_awal" class="form-input rupiah-field input-blocked" readonly 
                            value="{{ old('saldo_awal', isset($record) ? number_format((is_object($record) ? $record->saldo_awal : ($record['saldo_awal'] ?? 0)) ?? 0, 0, '', '') : 0) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Debet</label>
                        <input type="text" name="debet" class="form-input rupiah-field input-blocked" readonly
                            value="{{ old('debet', isset($record) ? number_format((is_object($record) ? $record->debet : ($record['debet'] ?? 0)) ?? 0, 0, '', '') : '') }}">
                    </div>
                    <input type="hidden" name="kredit" id="hidden_kredit" value="">
                </div>
            </div>

            {{-- Section 3: Rekonsiliasi & Saldo Akhir --}}
            <div class="form-section-card" style="border-left: 3px solid #dc2626;">
                <span class="section-title" style="color: #dc2626; border-bottom-color: #fca5a5;">3. Rekonsiliasi & Saldo Akhir</span>
                
                @php 
                    $tgl1 = $record->tgl_bukti_rek ?? ($record['tgl_bukti_rek'] ?? null);
                    $isStage1Filled = !empty($tgl1); 
                    $isLunas = (($record->saldo_akhir ?? ($record['saldo_akhir'] ?? 0)) <= 0);
                @endphp 
                <div id="paymentStage1" class="payment-stage" data-stage="1" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px; margin-bottom: 10px;">
                    <div class="form-group">
                        <label class="form-label">Tgl. Bukti Tahap 1 @if(!$isStage1Filled) <span style="color:red">*</span> @endif</label>
                        <input type="date" name="tgl_bukti_rek" class="form-input {{ $isStage1Filled ? 'input-blocked' : '' }}" {{ $isStage1Filled ? 'readonly' : '' }}
                            value="{{ old('tgl_bukti_rek', !empty($tgl1) ? \Illuminate\Support\Carbon::parse($tgl1)->format('Y-m-d') : '') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Keterangan Tahap 1 @if(!$isStage1Filled) <span style="color:red">*</span> @endif</label>
                        <input type="text" name="keterangan" id="ket_stage_1" class="form-input {{ $isStage1Filled ? 'input-blocked' : '' }}" {{ $isStage1Filled ? 'readonly' : '' }}
                            value="{{ old('keterangan', $record->keterangan ?? ($record['keterangan'] ?? '')) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kredit Tahap 1 @if(!$isStage1Filled) <span style="color:red">*</span> @endif</label>
                        <input type="text" name="kredit_stage1" id="kredit_stage_1" class="form-input rupiah-field {{ $isStage1Filled ? 'input-blocked' : '' }}" {{ $isStage1Filled ? 'readonly' : '' }} placeholder="0"
                            value="{{ old('kredit_stage1', isset($record) ? number_format((is_object($record) ? $record->kredit : ($record['kredit'] ?? 0)) ?? 0, 0, '', '') : '') }}">
                    </div>
                    <div class="form-group" style="align-self: center;">
                        <label class="form-label">Sisa Saldo Tahap 1</label>
                        <input type="text" id="saldo_after_1" class="form-input rupiah-field input-blocked" readonly value="">
                    </div>
                </div>

                {{-- TAHAP 2 --}}
                @php 
                    $tgl2 = $record->tgl_bukti_rek_2 ?? ($record['tgl_bukti_rek_2'] ?? null);
                    $isStage2Filled = !empty($tgl2); 
                    $isLunas = (($record->saldo_akhir ?? ($record['saldo_akhir'] ?? 0)) <= 0);
                @endphp
                <div id="paymentStage2" class="payment-stage" data-stage="2" style="display: none; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px; margin-bottom: 10px;">
                    <div class="form-group">
                        <label class="form-label">Tgl. Bukti Tahap 2 @if($isStage1Filled && !$isStage2Filled) <span style="color:red">*</span> @endif</label>
                        <input type="date" name="tgl_bukti_rek_2" class="form-input {{ ($isStage2Filled || $isLunas) ? 'input-blocked' : '' }}" {{ ($isStage2Filled || $isLunas) ? 'readonly' : '' }}
                            value="{{ old('tgl_bukti_rek_2', !empty($tgl2) ? \Illuminate\Support\Carbon::parse($tgl2)->format('Y-m-d') : '') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Keterangan Tahap 2 @if($isStage1Filled && !$isStage2Filled) <span style="color:red">*</span> @endif</label>
                        <input type="text" name="keterangan_2" class="form-input {{ ($isStage2Filled || $isLunas) ? 'input-blocked' : '' }}" {{ ($isStage2Filled || $isLunas) ? 'readonly' : '' }}
                            value="{{ old('keterangan_2', $record->keterangan_2 ?? ($record['keterangan_2'] ?? '')) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kredit Tahap 2 @if($isStage1Filled && !$isStage2Filled) <span style="color:red">*</span> @endif</label>
                        <input type="text" name="kredit_stage2" id="kredit_stage_2" class="form-input rupiah-field {{ ($isStage2Filled || $isLunas) ? 'input-blocked' : '' }}" {{ ($isStage2Filled || $isLunas) ? 'readonly' : '' }} placeholder="0"
                            value="{{ old('kredit_stage2', isset($record) ? number_format((is_object($record) ? ($record->kredit_2 ?? 0) : ($record['kredit_2'] ?? 0)) ?? 0, 0, '', '') : '') }}">
                    </div>
                    <div class="form-group" style="align-self: center;">
                        <label class="form-label">Sisa Saldo Tahap 2</label>
                        <input type="text" id="saldo_after_2" class="form-input rupiah-field input-blocked" readonly value="">
                    </div>
                </div>

                {{-- Total Saldo Akhir --}}
                <div class="form-group" style="border-top: 1px dashed #e5e7eb; padding-top: 10px; display: flex; align-items: center; gap: 12px;">
                    <label class="form-label" style="margin-bottom: 0 !important; white-space: nowrap; font-size: 13px !important; color: #111827 !important;">Total Saldo Akhir:</label>
                    <input type="text" name="saldo_akhir" class="form-input rupiah-field input-blocked" readonly
                        style="font-weight: 700; font-size: 14px; color: #111827; background-color: #f9fafb !important; max-width: 250px;"
                        value="{{ old('saldo_akhir', isset($record) ? number_format((is_object($record) ? $record->saldo_akhir : ($record['saldo_akhir'] ?? 0)) ?? 0, 0, '', '') : 0) }}">
                </div>

                {{-- JAVASCRIPT LOGIC --}}
                <script>
                    const spkTypeSelect = document.getElementById('spkTypeSelect');
                    const paymentStages = [2, 3];

                    function getMaxStages(spkType) {
                        switch ((spkType || '').toUpperCase()) {
                            case 'ASURANSI': return 3;
                            case 'REGULER': return 2;
                            case 'INTERNAL': return 2;
                            default: return 1;
                        }
                    }

                    function updatePaymentStageVisibility() {
                        const maxStages = getMaxStages(spkTypeSelect.value);
                        paymentStages.forEach(stage => {
                            const stageSection = document.getElementById('paymentStage' + stage);
                            const inputs = stageSection.querySelectorAll('input');
                            
                            if (stage <= maxStages) {
                                stageSection.style.display = 'grid';
                                inputs.forEach(input => input.disabled = false);
                            } else {
                                stageSection.style.display = 'none';
                                inputs.forEach(input => input.disabled = true);
                            }
                        });
                    }

                    // Mendukung angka negatif untuk kasus overpayment
                    function formatRupiah(angka) {
                        let isNegative = false;
                        let str = angka.toString();
                        if (str.startsWith('-')) {
                            isNegative = true;
                            str = str.replace('-', '');
                        }

                        let number_string = str.replace(/[^0-9]/g, ''),
                            sisa = number_string.length % 3,
                            rupiah = number_string.substr(0, sisa),
                            ribuan = number_string.substr(sisa).match(/\d{3}/g);
                            
                        if (ribuan) {
                            let separator = sisa ? '.' : '';
                            rupiah += separator + ribuan.join('.');
                        }
                        return isNegative ? '-' + rupiah : rupiah;
                    }

                    function cleanNumber(value) {
                        if (!value) return 0;
                        let cleanStr = value.toString().replace(/\./g, '');
                        return parseFloat(cleanStr) || 0;
                    }

                    document.addEventListener('DOMContentLoaded', () => {
                        if (spkTypeSelect) {
                            spkTypeSelect.addEventListener('change', () => {
                                updatePaymentStageVisibility();
                                updateSaldoPreviews();
                            });
                            updatePaymentStageVisibility();
                        }

                        const fields = document.querySelectorAll('.rupiah-field');
                        fields.forEach(field => {
                            if(field.value) field.value = formatRupiah(field.value);

                            field.addEventListener('input', function(e) {
                                e.target.value = formatRupiah(e.target.value);
                                updateSaldoPreviews();
                            });
                        });

                        const startingSaldo = cleanNumber('{{ isset($record) ? number_format((is_object($record) ? $record->saldo_awal : ($record['saldo_awal'] ?? 0)) ?? 0, 0, '', '') : 0 }}');
                        const dbKreditAwal = cleanNumber('{{ isset($record) ? number_format((is_object($record) ? $record->kredit : ($record['kredit'] ?? 0)) ?? 0, 0, '', '') : 0 }}');
                        const dbKredit2 = cleanNumber('{{ isset($record) ? number_format((is_object($record) ? ($record->kredit_2 ?? 0) : ($record['kredit_2'] ?? 0)) ?? 0, 0, '', '') : 0 }}');

                        const kreditInputs = [
                            document.getElementById('kredit_stage_1'),
                            document.getElementById('kredit_stage_2'),
                        ];
                        const saldoAfter = [
                            document.getElementById('saldo_after_1'),
                            document.getElementById('saldo_after_2'),
                        ];
                        const totalSaldoField = document.querySelector('input[name="saldo_akhir"]');

                        function updateSaldoPreviews() {
                            let runningSaldo = startingSaldo;
                            
                            const debetVal = cleanNumber(document.querySelector('input[name="debet"]').value);
                            runningSaldo += debetVal;

                            kreditInputs.forEach((input, idx) => {
                                if (!input || !saldoAfter[idx]) return;
                                
                                let payment = 0;
                                if (input.classList.contains('input-blocked')) {
                                    if (idx === 0) payment = dbKreditAwal;
                                    else if (idx === 1) payment = dbKredit2;
                                    else if (idx === 2) payment = dbKredit3;
                                } else {
                                    payment = cleanNumber(input.value);
                                }

                                runningSaldo -= payment;
                                saldoAfter[idx].value = formatRupiah(runningSaldo);
                            });

                            if (totalSaldoField) {
                                totalSaldoField.value = formatRupiah(runningSaldo);
                            }
                        }

                        updateSaldoPreviews();

                        // Intersepsi submit: Kembalikan format angka murni ke backend agar tidak error validasi
                        const form = document.getElementById('formEditPiutang');
                        if (form) {
                            form.addEventListener('submit', function() {
                                // Set nilai hidden kredit lawas jika dibutuhkan sistem Anda
                                const hidden = document.getElementById('hidden_kredit');
                                if (hidden) {
                                    hidden.value = '';
                                    for (let k of kreditInputs) {
                                        if (k && k.value && !k.classList.contains('input-blocked') && cleanNumber(k.value) > 0) {
                                            hidden.value = cleanNumber(k.value);
                                            break;
                                        }
                                    }
                                }

                                // Bersihkan titik ribuan dari semua field sebelum dikirim ke Laravel
                                document.querySelectorAll('.rupiah-field').forEach(field => {
                                    field.removeAttribute('readonly'); 
                                    field.value = cleanNumber(field.value);
                                });
                            });
                        }
                    });

                    const tipeKonsumenEdit = document.getElementById('tipe_konsumen_edit');
                    const perusahaanContainerEdit = document.getElementById('perusahaan_container_edit');

                    function handleTipeKonsumenEdit() {
                        if (!tipeKonsumenEdit || !perusahaanContainerEdit) return;

                        perusahaanContainerEdit.style.display =
                            tipeKonsumenEdit.value === 'perusahaan'
                                ? 'block'
                                : 'none';
                    }

                    if (tipeKonsumenEdit) {
                        tipeKonsumenEdit.addEventListener('change', handleTipeKonsumenEdit);
                        handleTipeKonsumenEdit();
                    }    
                    
                    const perusahaanDisplayEdit = document.getElementById('perusahaan_display_edit');
                    const perusahaanDropdownEdit = document.getElementById('perusahaan_dropdown_edit');

                    if (perusahaanDisplayEdit) {
                        perusahaanDisplayEdit.addEventListener('click', function (e) {
                            e.stopPropagation();

                            perusahaanDropdownEdit.style.display =
                                perusahaanDropdownEdit.style.display === 'block'
                                    ? 'none'
                                    : 'block';
                        });
                    }

                    function pilihPerusahaanEdit(id, nama, overdue) {
                        document.getElementById('perusahaan_id_input_edit').value = id;
                        document.getElementById('perusahaan_display_edit').value = nama;

                        document.getElementById('overdueInfoEdit').innerHTML = `
                            <div style="
                                background:#fef2f2;
                                border:1px solid #fecaca;
                                color:#dc2626;
                                padding:8px 12px;
                                border-radius:6px;
                                font-size:12px;
                                font-weight:600;
                            ">
                                Overdue Perusahaan: ${overdue} Hari
                            </div>
                        `;

                        perusahaanDropdownEdit.style.display = 'none';
                    }

                    const perusahaanSearchEdit = document.getElementById('perusahaan_search_edit');

                    if (perusahaanSearchEdit) {
                        perusahaanSearchEdit.addEventListener('keyup', function () {

                            let filter = this.value.toLowerCase();

                            document.querySelectorAll('#perusahaan_list_edit tr')
                                .forEach(row => {

                                    let text = row.cells[0].innerText.toLowerCase();

                                    row.style.display =
                                        text.includes(filter)
                                            ? ''
                                            : 'none';
                                });
                        });
                    }

                    document.addEventListener('click', function (e) {

                        if (
                            perusahaanDropdownEdit &&
                            !e.target.closest('#perusahaan_dropdown_edit') &&
                            !e.target.closest('#perusahaan_display_edit')
                        ) {
                            perusahaanDropdownEdit.style.display = 'none';
                        }
                    });
                </script>
            </div>

            {{-- Footer Buttons --}}
            <div style="margin-top: 16px; display: flex; justify-content: flex-end; gap: 8px; border-top: 1px solid #e5e7eb; padding-top: 12px;">
                <button class="btn-secondary" type="button" onclick="history.back();return false;">Batal</button>
                <button class="btn-primary" type="submit">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection