@extends('layouts.app')

@section('title', 'BP - Edit Piutang')

@section('content')
    <div style="padding: 16px; max-width: 1100px; margin: 0 auto; box-sizing: border-box; background-color: #ffffff;">

        {{-- Header --}}
        <div class="page-header" style="margin-bottom: 16px; border-bottom: 2px solid #f3f4f6; padding-bottom: 8px;">
            <div>
                <h1 class="page-title" style="color: #dc2626 !important; font-weight: 700 !important; font-size: 20px; margin: 0;">Edit Data Piutang - BP</h1>
                <p class="page-subtitle" style="color: #6b7280; font-size: 12px; margin-top: 2px;">Perbarui detail piutang konsumen cabang BP.</p>
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

            /* Modal Asuransi */
            .asuransi-modal {
                background: #fff;
                border-radius: 12px;
                box-shadow: 0 10px 25px rgba(0,0,0,.15);
                padding: 16px;
            }

            /* Search */
            .asuransi-modal input[type="text"] {
                width: 100%;
                padding: 10px 14px;
                border: 1px solid #d1d5db;
                border-radius: 8px;
                font-size: 14px;
            }

            .asuransi-modal input[type="text"]:focus {
                border-color: #dc2626;
                box-shadow: 0 0 0 3px rgba(220,38,38,.15);
                outline: none;
            }

            /* Table */
            .asuransi-modal table {
                width: 100%;
                border-collapse: collapse;
            }

            .asuransi-modal th {
                background: #f9fafb;
                padding: 10px;
                font-weight: 700;
                text-align: left;
                border-bottom: 2px solid #e5e7eb;
            }

            .asuransi-modal td {
                padding: 10px;
                border-bottom: 1px solid #f3f4f6;
            }

            .asuransi-modal tr:hover {
                background: #fef2f2;
            }

            /* Tombol pilih */
            .btn-pilih-asuransi {
                background: #dc2626;
                color: white;
                border: none;
                padding: 6px 12px;
                border-radius: 6px;
                cursor: pointer;
                font-size: 13px;
                font-weight: 600;
            }

            .btn-pilih-asuransi:hover {
                background: #b91c1c;
            }

            .asuransi-dropdown-container {
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

        .asuransi-table {
            width: 100%;
            border-collapse: collapse;
        }

        .asuransi-table th {
            position: sticky;
            top: 0;
            background: #f9fafb;
            padding: 10px;
            border-bottom: 2px solid #e5e7eb;
        }

        .asuransi-table td {
            padding: 10px;
            border-bottom: 1px solid #f3f4f6;
        }

        .asuransi-table tr:hover {
            background: #fef2f2;
        }
        </style>

        <form method="POST" action="{{ url('/bp/' . ($id ?? ($record->id ?? ''))) }}" id="formEditPiutang">
            @csrf
            @method('PUT')

            {{-- Section 1: Informasi Konsumen --}}
            <div class="form-section-card">
                <span class="section-title" style="color: #dc2626; border-bottom-color: #fca5a5;">1. Informasi Konsumen</span>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px;">
                    <div class="form-group">
                        <label class="form-label">No SPK <span style="color:red">*</span></label>
                        <input type="text" name="no_spk" class="form-input input-blocked" value="{{ old('no_spk', $record->no_spk ?? ($record['no_spk'] ?? '')) }}" readonly style="background-color: #e9ecef; cursor: not-allowed;">
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
                        <label class="form-label">No. Polis (Asuransi) <span style="color:red">*</span></label>
                        <input type="text" name="no_polis" class="form-input {{ ($record->no_polis ?? ($record['no_polis'] ?? '')) ? 'input-blocked' : '' }}" value="{{ old('no_polis', $record->no_polis ?? ($record['no_polis'] ?? '')) }}" {{ ($record->no_polis ?? ($record['no_polis'] ?? '')) ? 'readonly' : '' }}>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kategori SPK <span style="color:red">*</span></label>
                        <select class="form-select input-blocked" id="spkTypeSelect" disabled style="background-color: #e9ecef; cursor: not-allowed;">
                            <option value="">Pilih Jenis SPK</option>
                            <option value="REGULER" {{ old('spk_type', $record->spk_type ?? ($record['spk_type'] ?? '')) == 'REGULER' ? 'selected' : '' }}>REGULER</option>
                            <option value="INTERNAL" {{ old('spk_type', $record->spk_type ?? ($record['spk_type'] ?? '')) == 'INTERNAL' ? 'selected' : '' }}>INTERNAL</option>
                            <option value="ASURANSI" {{ old('spk_type', $record->spk_type ?? ($record['spk_type'] ?? '')) == 'ASURANSI' ? 'selected' : '' }}>ASURANSI</option>
                        </select>
                        <input type="hidden" name="spk_type" value="{{ old('spk_type', $record->spk_type ?? ($record['spk_type'] ?? '')) }}">
                    </div>
                    <div class="form-group"
                        id="asuransi_field_edit"
                        style="display:none; position:relative;">

                        <label class="form-label">
                            Nama Asuransi <span style="color:red">*</span>
                        </label>

                        <input
                            type="text"
                            id="asuransi_display_edit"
                            class="form-input {{ ($record->nama_asuransi ?? ($record['nama_asuransi'] ?? '')) ? 'input-blocked' : '' }}"
                            readonly
                            value="{{ old('nama_asuransi', $record->nama_asuransi ?? ($record['nama_asuransi'] ?? '')) }}"
                            placeholder="Klik untuk memilih asuransi">

                        <input
                            type="hidden"
                            name="nama_asuransi"
                            id="nama_asuransi_input_edit"
                            value="{{ old('nama_asuransi', $record->nama_asuransi ?? ($record['nama_asuransi'] ?? '')) }}">

                        <div id="asuransi_dropdown_edit" class="asuransi-dropdown-container">

                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                                <strong>Pilih Asuransi</strong>

                                <div style="display:flex;gap:8px;align-items:center;">
                                    <label>Search:</label>

                                    <input
                                        type="text"
                                        id="asuransi_search_edit"
                                        class="form-input"
                                        placeholder="Ketik nama..."
                                        style="max-height:30px;">
                                </div>
                            </div>

                            <div style="max-height:250px;overflow-y:auto;">
                                <table class="asuransi-table">
                                    <thead>
                                        <tr>
                                            <th>Nama Asuransi</th>
                                            <th width="120">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody id="asuransi_list_edit"></tbody>
                                </table>
                            </div>
                        </div>
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
                            value="{{ old('tgl_bukti', isset($record->tgl_bukti) ? \Illuminate\Support\Carbon::parse($record->tgl_bukti)->format('Y-m-d') : (isset($record['tgl_bukti']) ? \Illuminate\Support\Carbon::parse($record['tgl_bukti'])->format('Y-m-d') : '')) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">No. Invoice Utama (Locked)</label>
                        <input type="text" name="no_bukti" class="form-input input-blocked" readonly value="{{ old('no_bukti', $record->no_bukti ?? ($record['no_bukti'] ?? '')) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Saldo Pembukuan Awal (Locked)</label>
                        <input type="text" name="saldo_awal" class="form-input rupiah-field input-blocked" readonly 
                            value="{{ old('saldo_awal', isset($record->saldo_awal) ? number_format($record->saldo_awal, 0, '', '') : (isset($record['saldo_awal']) ? number_format($record['saldo_awal'], 0, '', '') : 0)) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Debet</label>
                        <input type="text" name="debet" class="form-input rupiah-field input-blocked" readonly 
                            value="{{ old('debet', isset($record->debet) ? number_format($record->debet, 0, '', '') : (isset($record['debet']) ? number_format($record['debet'], 0, '', '') : '')) }}">
                    </div>
                    <input type="hidden" name="kredit" id="hidden_kredit" value="">
                </div>
            </div>

            {{-- Section 3: Rekonsiliasi & Saldo Akhir --}}
            <div class="form-section-card" style="border-left: 3px solid #dc2626;">
                <span class="section-title" style="color: #dc2626; border-bottom-color: #fca5a5;">3. Rekonsiliasi & Saldo Akhir</span>
                
                {{-- TAHAP 1 --}}
                @php 
                    $tgl_bukti_rek = $record->tgl_bukti_rek ?? ($record['tgl_bukti_rek'] ?? null);
                    $keterangan = $record->keterangan ?? ($record['keterangan'] ?? null);
                    $kredit = $record->kredit ?? ($record['kredit'] ?? null);
                    $isStage1Filled = !empty($tgl_bukti_rek);
                    $saldoAkhirDb = $record->saldo_akhir ?? ($record['saldo_akhir'] ?? 0);
                    $isLunas = (float) $saldoAkhirDb <= 0;
                @endphp
                <div id="paymentStage1" class="payment-stage" data-stage="1" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px; margin-bottom: 10px;">
                    <div class="form-group">
                        <label class="form-label">Tgl. Bukti Tahap 1 @if(!$isStage1Filled) <span style="color:red">*</span> @endif</label>
                        <input type="date" name="tgl_bukti_rek" class="form-input {{ $isStage1Filled ? 'input-blocked' : '' }}" {{ $isStage1Filled ? 'readonly' : '' }}
                            value="{{ old('tgl_bukti_rek', isset($tgl_bukti_rek) ? \Illuminate\Support\Carbon::parse($tgl_bukti_rek)->format('Y-m-d') : '') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Keterangan Tahap 1 @if(!$isStage1Filled) <span style="color:red">*</span> @endif</label>
                        <input type="text" name="keterangan" id="ket_stage_1" class="form-input {{ $isStage1Filled ? 'input-blocked' : '' }}" {{ $isStage1Filled ? 'readonly' : '' }}
                            value="{{ old('keterangan', $keterangan ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kredit Tahap 1 @if(!$isStage1Filled) <span style="color:red">*</span> @endif</label>
                        <input type="text" name="kredit_stage1" id="kredit_stage_1" class="form-input rupiah-field {{ $isStage1Filled ? 'input-blocked' : '' }}" {{ $isStage1Filled ? 'readonly' : '' }} placeholder="0"
                            value="{{ old('kredit_stage1', isset($kredit) ? number_format($kredit, 0, '', '') : '') }}">
                    </div>
                    <div class="form-group" style="align-self: center;">
                        <label class="form-label">Sisa Saldo Tahap 1</label>
                        <input type="text" id="saldo_after_1" class="form-input rupiah-field input-blocked" readonly value="">
                    </div>  
                </div>

                {{-- TAHAP 2 --}}
                @php 
                    $tgl_bukti_rek_2 = $record->tgl_bukti_rek_2 ?? ($record['tgl_bukti_rek_2'] ?? null);
                    $keterangan_2 = $record->keterangan_2 ?? ($record['keterangan_2'] ?? null);
                    $kredit_2 = $record->kredit_2 ?? ($record['kredit_2'] ?? null);
                    $isStage2Filled = !empty($tgl_bukti_rek_2); 
                    $saldoAkhirDb = $record->saldo_akhir ?? ($record['saldo_akhir'] ?? 0);
                    $isLunas = (float) $saldoAkhirDb <= 0;
                @endphp
                <div id="paymentStage2" class="payment-stage" data-stage="2" style="display: none; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px; margin-bottom: 10px;">
                    <div class="form-group">
                        <label class="form-label">Tgl. Bukti Tahap 2 @if($isStage1Filled && !$isStage2Filled) <span style="color:red">*</span> @endif</label>
                        <input type="date" name="tgl_bukti_rek_2" class="form-input {{ ($isStage2Filled || $isLunas) ? 'input-blocked' : '' }}" {{ $isStage2Filled ? 'readonly' : '' }}
                            value="{{ old('tgl_bukti_rek_2', isset($tgl_bukti_rek_2) ? \Illuminate\Support\Carbon::parse($tgl_bukti_rek_2)->format('Y-m-d') : '') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Keterangan Tahap 2 @if($isStage1Filled && !$isStage2Filled) <span style="color:red">*</span> @endif</label>
                        <input type="text" name="keterangan_2" class="form-input {{ ($isStage2Filled || $isLunas) ? 'input-blocked' : '' }}" {{ $isStage2Filled ? 'readonly' : '' }}
                            value="{{ old('keterangan_2', $keterangan_2 ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kredit Tahap 2 @if($isStage1Filled && !$isStage2Filled) <span style="color:red">*</span> @endif</label>
                        <input type="text" name="kredit_stage2" id="kredit_stage_2" class="form-input rupiah-field {{ ($isStage2Filled || $isLunas) ? 'input-blocked' : '' }}" {{ $isStage2Filled ? 'readonly' : '' }} placeholder="0"
                            value="{{ old('kredit_stage2', isset($kredit_2) ? number_format($kredit_2, 0, '', '') : '') }}">
                    </div>
                    <div class="form-group" style="align-self: center;">
                        <label class="form-label">Sisa Saldo Tahap 2</label>
                        <input type="text" id="saldo_after_2" class="form-input rupiah-field input-blocked" readonly value="">
                    </div>
                </div>

                {{-- TAHAP 3 --}}
                @php 
                    $tgl_bukti_rek_3 = $record->tgl_bukti_rek_3 ?? ($record['tgl_bukti_rek_3'] ?? null);
                    $keterangan_3 = $record->keterangan_3 ?? ($record['keterangan_3'] ?? null);
                    $kredit_3 = $record->kredit_3 ?? ($record['kredit_3'] ?? null);
                    $isStage3Filled = !empty($tgl_bukti_rek_3); 
                    $saldoAkhirDb = $record->saldo_akhir ?? ($record['saldo_akhir'] ?? 0);
                    $isLunas = (float) $saldoAkhirDb <= 0;
                @endphp
                <div id="paymentStage3" class="payment-stage" data-stage="3" style="display: none; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px; margin-bottom: 10px;">
                    <div class="form-group">
                        <label class="form-label">Tgl. Bukti Tahap 3 @if($isStage2Filled && !$isStage3Filled) <span style="color:red">*</span> @endif</label>
                        <input type="date" name="tgl_bukti_rek_3" class="form-input {{ ($isStage3Filled || $isLunas) ? 'input-blocked' : '' }}" {{ $isStage3Filled ? 'readonly' : '' }}
                            value="{{ old('tgl_bukti_rek_3', isset($tgl_bukti_rek_3) ? \Illuminate\Support\Carbon::parse($tgl_bukti_rek_3)->format('Y-m-d') : '') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Keterangan Tahap 3 @if($isStage2Filled && !$isStage3Filled) <span style="color:red">*</span> @endif</label>
                        <input type="text" name="keterangan_3" class="form-input {{ ($isStage3Filled || $isLunas) ? 'input-blocked' : '' }}" {{ $isStage3Filled ? 'readonly' : '' }}
                            value="{{ old('keterangan_3', $keterangan_3 ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kredit Tahap 3 @if($isStage2Filled && !$isStage3Filled) <span style="color:red">*</span> @endif</label>
                        <input type="text" name="kredit_stage3" id="kredit_stage_3" class="form-input rupiah-field {{ ($isStage3Filled || $isLunas) ? 'input-blocked' : '' }}" {{ $isStage3Filled ? 'readonly' : '' }} placeholder="0"
                            value="{{ old('kredit_stage3', isset($kredit_3) ? number_format($kredit_3, 0, '', '') : '') }}">
                    </div>
                    <div class="form-group" style="align-self: center;">
                        <label class="form-label">Sisa Saldo Tahap 3</label>
                        <input type="text" id="saldo_after_3" class="form-input rupiah-field input-blocked" readonly value="">
                    </div>
                </div>

                {{-- Total Saldo Akhir --}}
                <div class="form-group" style="border-top: 1px dashed #e5e7eb; padding-top: 10px; display: flex; align-items: center; gap: 12px;">
                    <label class="form-label" style="margin-bottom: 0 !important; white-space: nowrap; font-size: 13px !important; color: #111827 !important;">Total Saldo Akhir:</label>
                    <input type="text" name="saldo_akhir" class="form-input rupiah-field input-blocked" readonly
                        style="font-weight: 700; font-size: 14px; color: #111827; background-color: #f9fafb !important; max-width: 250px;"
                        value="{{ old('saldo_akhir', isset($saldo_akhir) ? number_format($saldo_akhir, 0, '', '') : 0) }}">
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
                            if (stage <= maxStages) {
                                stageSection.style.display = 'grid';
                            } else {
                                stageSection.style.display = 'none';
                            }
                        });
                    }

                    function updateAsuransiVisibility() {
                        const asuransiField = document.getElementById('asuransi_field_edit');
                        if (spkTypeSelect && asuransiField) {
                            if (spkTypeSelect.value === 'ASURANSI') {
                                asuransiField.style.display = 'block';
                            } else {
                                asuransiField.style.display = 'none';
                                const input = asuransiField.querySelector('input');
                                if(input) input.value = '';
                            }
                        }
                    }

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
                                updateAsuransiVisibility();
                            });
                            updatePaymentStageVisibility();
                            updateAsuransiVisibility();
                        }

                        const fields = document.querySelectorAll('.rupiah-field');
                        fields.forEach(field => {
                            if(field.value) field.value = formatRupiah(field.value);

                            field.addEventListener('input', function(e) {
                                e.target.value = formatRupiah(e.target.value);
                                updateSaldoPreviews();
                            });
                        });

                        const startingSaldo = cleanNumber('{{ isset($record->saldo_awal) ? number_format($record->saldo_awal, 0, '', '') : (isset($record['saldo_awal']) ? number_format($record['saldo_awal'], 0, '', '') : 0) }}');
                        const dbKreditAwal = cleanNumber('{{ isset($record->kredit) ? number_format($record->kredit, 0, '', '') : (isset($record['kredit']) ? number_format($record['kredit'], 0, '', '') : 0) }}');
                        const dbKredit2 = cleanNumber('{{ isset($record->kredit_2) ? number_format($record->kredit_2, 0, '', '') : (isset($record['kredit_2']) ? number_format($record['kredit_2'], 0, '', '') : 0) }}');
                        const dbKredit3 = cleanNumber('{{ isset($record->kredit_3) ? number_format($record->kredit_3, 0, '', '') : (isset($record['kredit_3']) ? number_format($record['kredit_3'], 0, '', '') : 0) }}');

                        const kreditInputs = [
                            document.getElementById('kredit_stage_1'),
                            document.getElementById('kredit_stage_2'),
                            document.getElementById('kredit_stage_3'),
                        ];
                        const saldoAfter = [
                            document.getElementById('saldo_after_1'),
                            document.getElementById('saldo_after_2'),
                            document.getElementById('saldo_after_3'),
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
                        let asuransiData = [];
                        let asuransiLoaded = false;

                        const displayEdit =
                            document.getElementById('asuransi_display_edit');

                        const hiddenEdit =
                            document.getElementById('nama_asuransi_input_edit');

                        const dropdownEdit =
                            document.getElementById('asuransi_dropdown_edit');

                        const listEdit =
                            document.getElementById('asuransi_list_edit');

                        const searchEdit =
                            document.getElementById('asuransi_search_edit');

                        async function loadAsuransiEdit() {
                            try {
                                const res = await fetch('/asuransi/list');
                                asuransiData = await res.json();
                                asuransiLoaded = true;
                                renderAsuransiEdit(asuransiData);
                            } catch (e) {
                                console.error(e);
                            }
                        }

                        function renderAsuransiEdit(data) {
                            listEdit.innerHTML = '';

                            data.forEach(item => {
                                const tr = document.createElement('tr');

                                tr.innerHTML = `
                                    <td>${item.nama}</td>
                                    <td style="text-align:center">
                                        <button
                                            type="button"
                                            class="btn-pilih-asuransi">
                                            Pilih
                                        </button>
                                    </td>
                                `;

                                tr.querySelector('button')
                                    .addEventListener('click', () => {

                                        hiddenEdit.value = item.nama;
                                        displayEdit.value = item.nama;
                                        dropdownEdit.style.display = 'none';
                                    });

                                listEdit.appendChild(tr);
                            });
                        }

                        if (displayEdit) {
                            displayEdit.addEventListener('click', () => {
                                if (displayEdit.classList.contains('input-blocked')) return;

                                dropdownEdit.style.display =
                                    dropdownEdit.style.display === 'block'
                                        ? 'none'
                                        : 'block';

                                if (!asuransiLoaded) {
                                    loadAsuransiEdit();
                                }
                            });
                        }

                        if (searchEdit) {
                            searchEdit.addEventListener('input', function () {

                                const keyword = this.value.toLowerCase();

                                const filtered = asuransiData.filter(x =>
                                    x.nama.toLowerCase().includes(keyword)
                                );

                                renderAsuransiEdit(filtered);
                            });
                        }

                        document.addEventListener('click', function(e) {

                            if (
                                dropdownEdit &&
                                !e.target.closest('#asuransi_field_edit')
                            ) {
                                dropdownEdit.style.display = 'none';
                            }
                        });

                        // Atur penguncian input debet jika data rekam awal sudah ada isinya (> 0)
                        const debetInput = document.getElementsByName('debet')[0];
                        if (debetInput && cleanNumber('{{ $record->debet ?? 0 }}') > 0) {
                            debetInput.classList.add('input-blocked');
                            debetInput.setAttribute('readonly', 'readonly');
                        }
                        const form = document.getElementById('formEditPiutang');
                        if (form) {
                            form.addEventListener('submit', function() {
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
                                document.querySelectorAll('.rupiah-field').forEach(field => {
                                    field.removeAttribute('readonly'); 
                                    field.value = cleanNumber(field.value);
                                });
                            });
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