@extends('layouts.app')

@section('title', 'Tambah Data Faktur Polisi')

@section('content')
<style>
    .faktur-form-container {
        padding: 10px 0 30px 0;
        max-width: 800px;
        margin: 0 auto;
    }

    .form-card-faktur {
        background: white;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        padding: 28px;
    }

    .form-card-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 24px;
        padding-bottom: 18px;
        border-bottom: 1px solid #f1f5f9;
    }

    .form-icon-wrap {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .form-title-area h2 {
        font-size: 1.25rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 4px 0;
    }

    .form-title-area p {
        font-size: 0.85rem;
        color: #64748b;
        margin: 0;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    @media (max-width: 640px) {
        .form-grid-2 {
            grid-template-columns: 1fr;
        }
    }

    .form-group-custom {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 18px;
    }

    .form-group-custom label {
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        margin: 0;
    }

    .form-group-custom label .req {
        color: #ef4444;
        margin-left: 2px;
    }

    .input-custom {
        width: 100%;
        padding: 10px 14px;
        font-size: 14px;
        color: #0f172a;
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        outline: none;
        transition: all 0.2s ease;
    }

    .input-custom:focus {
        border-color: #2563eb;
        background-color: #fff;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
    }

    .btn-cancel {
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 600;
        color: #64748b;
        background: #f1f5f9;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
    }

    .btn-cancel:hover {
        background: #e2e8f0;
        color: #334155;
    }

    .btn-submit {
        padding: 10px 24px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 700;
        color: white;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        transition: all 0.2s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(37, 99, 235, 0.35);
    }
</style>

<div class="faktur-form-container">
    {{-- Error Alert --}}
    @if ($errors->any())
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-size: 13.5px;">
            <div style="font-weight: 700; margin-bottom: 4px;">Harap periksa kesalahan input berikut:</div>
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card-faktur">
        <div class="form-card-header">
            <div class="form-icon-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 22px; height: 22px;">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="12" y1="18" x2="12" y2="12"></line>
                    <line x1="9" y1="15" x2="15" y2="15"></line>
                </svg>
            </div>
            <div class="form-title-area">
                <h2>Tambah Data Faktur Polisi</h2>
                <p>Input jumlah Faktur Polisi kendaraan per tipe model, periode bulan & tahun, dan cabang.</p>
            </div>
        </div>

        <form action="{{ route('sales.faktur.store') }}" method="POST">
            @csrf

            <div class="form-grid-2">
                {{-- Tipe Kendaraan --}}
                <div class="form-group-custom">
                    <label for="tipe_kendaraan">TIPE KENDARAAN <span class="req">*</span></label>
                    <select name="tipe_kendaraan" id="tipe_kendaraan" class="input-custom" required>
                        <option value="">-- Pilih Tipe Kendaraan --</option>
                        @foreach($tipeKendaraanList as $tipe)
                            <option value="{{ $tipe }}" {{ old('tipe_kendaraan') == $tipe ? 'selected' : '' }}>
                                {{ $tipe }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Cabang --}}
                <div class="form-group-custom">
                    <label for="cabang">CABANG <span class="req">*</span></label>
                    <select name="cabang" id="cabang" class="input-custom" required>
                        @foreach($availableBranches as $cb)
                            <option value="{{ $cb }}" {{ old('cabang') == $cb ? 'selected' : '' }}>{{ $cb }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-grid-2">
                {{-- Bulan --}}
                <div class="form-group-custom">
                    <label for="bulan">BULAN <span class="req">*</span></label>
                    <select name="bulan" id="bulan" class="input-custom" required>
                        @php
                            $currBulanStr = $bulanMap[(int)date('n')] ?? 'jan';
                        @endphp
                        @foreach($bulanMap as $num => $b)
                            <option value="{{ $b }}" {{ old('bulan', $currBulanStr) == $b ? 'selected' : '' }}>
                                {{ strtoupper($b) }} - {{ $bulanNamaLengkap[$b] ?? $b }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tahun --}}
                <div class="form-group-custom">
                    <label for="tahun">TAHUN <span class="req">*</span></label>
                    <select name="tahun" id="tahun" class="input-custom" required>
                        @for($y = date('Y') + 1; $y >= 2023; $y--)
                            <option value="{{ $y }}" {{ old('tahun', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            {{-- Jumlah Faktur --}}
            <div class="form-group-custom">
                <label for="jumlah">JUMLAH FAKTUR (UNIT) <span class="req">*</span></label>
                <input type="number" name="jumlah" id="jumlah" min="0" value="{{ old('jumlah', 1) }}" class="input-custom" placeholder="Contoh: 15" required style="font-size: 16px; font-weight: 700;">
                <span style="font-size: 12px; color: #64748b;">Masukkan total unit yang telah terbit faktur polisi pada periode ini.</span>
            </div>

            {{-- Keterangan --}}
            <div class="form-group-custom">
                <label for="keterangan">KETERANGAN / CATATAN (OPSIONAL)</label>
                <textarea name="keterangan" id="keterangan" rows="3" class="input-custom" placeholder="Tambahkan catatan khusus bila ada...">{{ old('keterangan') }}</textarea>
            </div>

            <div class="form-actions">
                <a href="{{ route('sales.faktur.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">
                    Simpan Data Faktur
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
