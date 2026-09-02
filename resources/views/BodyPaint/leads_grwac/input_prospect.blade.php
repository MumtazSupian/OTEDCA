@extends('layouts.app')

@section('title', 'Input Prospect BP - OTE DCA')

@section('content')
<div class="input-prospect-container">
    {{-- 1. HEADER SECTION --}}
    <div class="page-header-row">
        <div class="header-text-group">
            <h1 class="page-title">Input Prospect BP</h1>
            <p class="page-subtitle">Input kendaraan dari GR/MRA untuk ditindaklanjuti SA Body & Paint</p>
        </div>
    </div>

    {{-- 2. MAIN FORM CARD --}}
    <div class="form-card-wrapper">
        <form method="POST" action="javascript:void(0)" id="inputProspectForm" onsubmit="submitProspectForm()">
            @csrf

            {{-- SECTION 1: DATA KENDARAAN --}}
            <div class="form-section">
                <div class="section-title-row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="section-icon">
                        <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9C2.1 11.2 2 11.6 2 12v4c0 .6.4 1 1 1h2"></path>
                        <circle cx="7" cy="17" r="2"></circle>
                        <path d="M9 17h6"></path>
                        <circle cx="17" cy="17" r="2"></circle>
                    </svg>
                    <h3 class="section-heading">Data Kendaraan</h3>
                </div>

                <div class="form-grid-3">
                    {{-- No. Polisi --}}
                    <div class="form-group">
                        <label class="form-label">No. Polisi <span class="text-required">*</span></label>
                        <div class="input-with-action">
                            <input type="text" name="no_polisi" id="noPolisiInput" placeholder="B 1234 ABC" class="input-form-control font-mono uppercase" required>
                            <button type="button" class="btn-input-search" onclick="searchNopol()" title="Cari Data Kendaraan">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Model Kendaraan --}}
                    <div class="form-group">
                        <label class="form-label">Model Kendaraan <span class="text-required">*</span></label>
                        <select name="model_kendaraan" id="modelKendaraanSelect" class="input-form-control" required>
                            <option value="" disabled selected>Pilih model kendaraan...</option>
                            @foreach($modelKendaraanList as $mk)
                                <option value="{{ $mk }}">{{ $mk }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- No. WO GR --}}
                    <div class="form-group">
                        <label class="form-label">No. WO GR</label>
                        <input type="text" name="no_wo_gr" id="noWoGrInput" placeholder="Nomor WO dari GR (opsional)" class="input-form-control font-mono">
                    </div>
                </div>
            </div>

            {{-- SECTION 2: DATA KONSUMEN --}}
            <div class="form-section">
                <div class="section-title-row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="section-icon">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <h3 class="section-heading">Data Konsumen</h3>
                </div>

                <div class="form-grid-2">
                    {{-- Nama Konsumen --}}
                    <div class="form-group">
                        <label class="form-label">Nama Konsumen <span class="text-required">*</span></label>
                        <input type="text" name="nama_konsumen" id="namaKonsumenInput" placeholder="Nama lengkap konsumen" class="input-form-control uppercase" required>
                    </div>

                    {{-- No. HP --}}
                    <div class="form-group">
                        <label class="form-label">No. HP <span class="text-required">*</span></label>
                        <input type="text" name="no_hp" id="noHpInput" placeholder="08xx-xxxx-xxxx" class="input-form-control font-mono" required>
                    </div>
                </div>

                {{-- Checkbox Konfirmasi --}}
                <div class="checkbox-box-container">
                    <label class="checkbox-full-label">
                        <input type="checkbox" name="konfirmasi_valid" id="konfirmasiValidCheck" required>
                        <span>Saya sudah memastikan nama & no HP konsumen ini benar dan terbaru.</span>
                    </label>
                </div>
            </div>

            {{-- SECTION 3: KONDISI & KETERANGAN --}}
            <div class="form-section">
                <div class="section-title-row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="section-icon">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    <h3 class="section-heading">Kondisi & Keterangan</h3>
                </div>

                <div class="form-grid-2">
                    {{-- Asuransi Pill Toggle --}}
                    <div class="form-group">
                        <label class="form-label">Asuransi <span class="text-required">*</span></label>
                        <div class="pill-toggle-group">
                            <input type="radio" name="asuransi" id="asuransi_tanpa" value="Tanpa Asuransi" checked class="pill-radio">
                            <label for="asuransi_tanpa" class="pill-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                </svg>
                                <span>Tanpa Asuransi</span>
                            </label>

                            <input type="radio" name="asuransi" id="asuransi_punya" value="Punya Asuransi" class="pill-radio">
                            <label for="asuransi_punya" class="pill-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                </svg>
                                <span>Punya Asuransi</span>
                            </label>
                        </div>
                    </div>

                    {{-- Minat Perbaikan Pill Toggle --}}
                    <div class="form-group">
                        <label class="form-label">Minat Perbaikan <span class="text-required">*</span></label>
                        <div class="pill-toggle-group">
                            <input type="radio" name="minat_perbaikan" id="minat_ya" value="Berminat" checked class="pill-radio" onchange="handleMinatChange()">
                            <label for="minat_ya" class="pill-btn">
                                <span>✓ Berminat</span>
                            </label>

                            <input type="radio" name="minat_perbaikan" id="minat_menolak" value="Awalnya Menolak" class="pill-radio" onchange="handleMinatChange()">
                            <label for="minat_menolak" class="pill-btn">
                                <span>✕ Awalnya Menolak</span>
                            </label>
                        </div>

                        {{-- Alert Warning saat Awalnya Menolak --}}
                        <div class="warning-alert-box" id="warningAwalnyaMenolak" style="display: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;">
                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                                <line x1="12" y1="9" x2="12" y2="13"></line>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                            <span>Prospect ini awalnya menolak &mdash; SA BP akan diberitahu untuk pendekatan lebih hati-hati.</span>
                        </div>
                    </div>
                </div>

                {{-- Keterangan Kerusakan --}}
                <div class="form-group" style="margin-top: 14px;">
                    <label class="form-label">Keterangan Kerusakan <span class="text-required">*</span></label>
                    <textarea name="keterangan_kerusakan" id="keteranganKerusakanInput" rows="3" placeholder="Deskripsikan kondisi kerusakan kendaraan..." class="input-form-control textarea-control" required></textarea>
                </div>

                {{-- Potensi Penggantian Part --}}
                <div class="form-group" style="margin-top: 14px;">
                    <label class="form-label">Potensi Penggantian Part <span class="text-required">*</span></label>
                    <div class="pill-toggle-group" style="max-width: 240px;">
                        <input type="radio" name="potensi_part" id="part_tidak" value="Tidak" checked class="pill-radio" onchange="handlePartChange()">
                        <label for="part_tidak" class="pill-btn">
                            <span>✕ Tidak</span>
                        </label>

                        <input type="radio" name="potensi_part" id="part_ya" value="Ya" class="pill-radio" onchange="handlePartChange()">
                        <label for="part_ya" class="pill-btn">
                            <span>✓ Ya</span>
                        </label>
                    </div>
                </div>

                {{-- Catatan Penggantian Part (Muncul jika Ya) --}}
                <div class="form-group" id="groupCatatanPart" style="display: none; margin-top: 14px;">
                    <label class="form-label">Catatan Penggantian Part <span class="text-required">*</span></label>
                    <input type="text" name="catatan_penggantian_part" id="catatanPartInput" placeholder="Sebutkan part yang berpotensi diganti..." class="input-form-control">
                </div>
            </div>

            {{-- SECTION 4: FOTO KERUSAKAN --}}
            <div class="form-section" style="border-bottom: none; margin-bottom: 0; padding-bottom: 10px;">
                <div class="section-title-row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="section-icon">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg>
                    <h3 class="section-heading">Foto Kerusakan</h3>
                </div>

                {{-- Upload Area Buttons --}}
                <div class="photo-upload-container">
                    <input type="file" id="cameraInput" accept="image/*" capture="environment" style="display: none;" onchange="handlePhotoUpload(this)">
                    <input type="file" id="galleryInput" accept="image/*" multiple style="display: none;" onchange="handlePhotoUpload(this)">

                    <div class="upload-btn-box" onclick="document.getElementById('cameraInput').click()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                            <circle cx="12" cy="13" r="4"></circle>
                        </svg>
                        <span>Kamera</span>
                    </div>

                    <div class="upload-btn-box" onclick="document.getElementById('galleryInput').click()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                            <polyline points="21 15 16 10 5 21"></polyline>
                        </svg>
                        <span>Galeri</span>
                    </div>
                </div>

                {{-- Photo Counter & Thumbnails --}}
                <div class="photo-counter-text" id="photoCounterText">0/5 foto</div>
                <div class="photo-preview-grid" id="photoPreviewGrid"></div>
            </div>

            {{-- 3. FOOTER ACTIONS --}}
            <div class="form-action-footer">
                <button type="reset" class="btn-form-reset" onclick="resetPhotos()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="1 4 1 10 7 10"></polyline>
                        <polyline points="23 20 23 14 17 14"></polyline>
                        <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path>
                    </svg>
                    <span>Reset</span>
                </button>

                <button type="submit" class="btn-form-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span>Simpan Prospect</span>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Global Container */
    .input-prospect-container {
        padding: 24px 28px 40px 28px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        color: #1e293b;
        box-sizing: border-box;
    }

    /* Header */
    .page-header-row {
        margin-bottom: 20px;
    }
    .page-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
        letter-spacing: -0.3px;
    }
    .page-subtitle {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }

    /* Main Form Card */
    .form-card-wrapper {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 24px 28px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
    }

    /* Section Rows */
    .form-section {
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 20px;
        margin-bottom: 20px;
    }
    .section-title-row {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
    }
    .section-icon {
        color: #dc2626;
    }
    .section-heading {
        font-size: 14px;
        font-weight: 800;
        color: #dc2626;
        margin: 0;
        letter-spacing: -0.2px;
    }

    /* Grids */
    .form-grid-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 16px;
    }
    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    @media (max-width: 900px) {
        .form-grid-3, .form-grid-2 { grid-template-columns: 1fr; }
    }

    /* Form Group & Controls */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .form-label {
        font-size: 12px;
        font-weight: 700;
        color: #475569;
    }
    .text-required {
        color: #dc2626;
        font-weight: 800;
    }
    .input-form-control {
        width: 100%;
        height: 38px;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        font-size: 12.5px;
        color: #1e293b;
        box-sizing: border-box;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .input-form-control:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
    }
    .textarea-control {
        height: auto;
        resize: vertical;
    }
    .font-mono { font-family: 'JetBrains Mono', monospace; font-size: 12.5px; }
    .uppercase { text-transform: uppercase; }

    /* Input With Action Button */
    .input-with-action {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .btn-input-search {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        border: none;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #ffffff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: background 0.2s ease;
    }
    .btn-input-search:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
    }

    /* Checkbox Container */
    .checkbox-box-container {
        margin-top: 14px;
        padding: 10px 14px;
        background: #f8fafc;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }
    .checkbox-full-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 12.5px;
        color: #334155;
        font-weight: 500;
        cursor: pointer;
    }

    /* Pill Toggles */
    .pill-toggle-group {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .pill-radio {
        display: none;
    }
    .pill-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
        transition: all 0.15s ease;
        user-select: none;
    }
    .pill-radio:checked + .pill-btn {
        background: #ffffff;
        border-color: #dc2626;
        color: #dc2626;
        box-shadow: 0 1px 4px rgba(220, 38, 38, 0.15);
        font-weight: 700;
    }

    /* Photo Upload Area */
    .photo-upload-container {
        display: flex;
        gap: 12px;
        margin-bottom: 8px;
    }
    .upload-btn-box {
        width: 80px;
        height: 72px;
        border: 1.5px dashed #cbd5e1;
        border-radius: 8px;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 11px;
        font-weight: 600;
        color: #475569;
    }
    .upload-btn-box:hover {
        border-color: #dc2626;
        background: #fef2f2;
        color: #dc2626;
    }
    .photo-counter-text {
        font-size: 11.5px;
        color: #94a3b8;
        margin-top: 4px;
    }
    .photo-preview-grid {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 10px;
    }
    .preview-thumbnail-box {
        position: relative;
        width: 72px;
        height: 72px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }
    .preview-thumbnail-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .btn-remove-photo {
        position: absolute;
        top: 2px;
        right: 2px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: rgba(15, 23, 42, 0.7);
        color: #ffffff;
        border: none;
        font-size: 11px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Warning Alert Box */
    .warning-alert-box {
        margin-top: 8px;
        background: #fffbeb;
        border: 1px solid #fef08a;
        border-radius: 8px;
        padding: 9px 12px;
        font-size: 11.5px;
        color: #92400e;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
        line-height: 1.4;
        animation: fadeIn 0.2s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Footer Action */
    .form-action-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }
    .btn-form-reset {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #64748b;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-form-reset:hover {
        background: #f1f5f9;
        color: #334155;
    }
    .btn-form-submit {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 22px;
        border-radius: 8px;
        border: none;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #ffffff;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.25);
        transition: all 0.2s ease;
    }
    .btn-form-submit:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        transform: translateY(-1px);
    }
</style>

<script>
    let uploadedFiles = [];

    function handleMinatChange() {
        const minatMenolak = document.getElementById('minat_menolak').checked;
        const warningBox = document.getElementById('warningAwalnyaMenolak');
        if (minatMenolak) {
            warningBox.style.display = 'flex';
        } else {
            warningBox.style.display = 'none';
        }
    }

    function handlePartChange() {
        const partYa = document.getElementById('part_ya').checked;
        const groupCatatan = document.getElementById('groupCatatanPart');
        const catatanInput = document.getElementById('catatanPartInput');
        if (partYa) {
            groupCatatan.style.display = 'flex';
            catatanInput.required = true;
        } else {
            groupCatatan.style.display = 'none';
            catatanInput.required = false;
            catatanInput.value = '';
        }
    }

    function searchNopol() {
        const nopol = document.getElementById('noPolisiInput').value.trim();
        if (!nopol) {
            alert('Masukkan nomor polisi terlebih dahulu.');
            return;
        }
        alert('Mencari riwayat kendaraan untuk Nopol: ' + nopol);
    }

    function handlePhotoUpload(input) {
        if (!input.files || input.files.length === 0) return;

        for (let i = 0; i < input.files.length; i++) {
            if (uploadedFiles.length >= 5) {
                alert('Maksimal 5 foto kerusakan.');
                break;
            }
            uploadedFiles.push(input.files[i]);
        }
        renderPhotoPreviews();
        input.value = '';
    }

    function renderPhotoPreviews() {
        const grid = document.getElementById('photoPreviewGrid');
        const counter = document.getElementById('photoCounterText');
        grid.innerHTML = '';
        counter.textContent = uploadedFiles.length + '/5 foto';

        uploadedFiles.forEach((file, index) => {
            const box = document.createElement('div');
            box.className = 'preview-thumbnail-box';

            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn-remove-photo';
            removeBtn.innerHTML = '&times;';
            removeBtn.onclick = function() {
                removePhoto(index);
            };

            box.appendChild(img);
            box.appendChild(removeBtn);
            grid.appendChild(box);
        });
    }

    function removePhoto(index) {
        uploadedFiles.splice(index, 1);
        renderPhotoPreviews();
    }

    function resetPhotos() {
        uploadedFiles = [];
        renderPhotoPreviews();
        setTimeout(() => {
            handleMinatChange();
            handlePartChange();
        }, 50);
    }

    function submitProspectForm() {
        const nopol = document.getElementById('noPolisiInput').value;
        const konsumen = document.getElementById('namaKonsumenInput').value;
        alert('Data prospect untuk ' + nopol + ' (' + konsumen + ') berhasil disimpan!');
    }
</script>
@endsection
