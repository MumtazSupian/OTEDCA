@extends('layouts.app')

@section('content')
<div class="page-header" style="margin-bottom: 24px;">
    <div>
        <h1 class="page-title">Tambah Data IN UNIT</h1>
        <p class="page-subtitle">Silakan isi form di bawah ini untuk menambahkan data kedatangan unit.</p>
    </div>
</div>

<div style="background:#fff; border-radius:10px; border:1px solid #e2e8f0; padding:24px;">
    <form action="{{ route('admin.in-units.store') }}" method="POST">
        @csrf

        {{-- Row 1: Nama Driver & Tanggal --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
            <div>
                <label for="nama_driver" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">Nama Driver <span style="color:#e11d48">*</span></label>
                <input type="text" name="nama_driver" id="nama_driver" value="{{ old('nama_driver') }}" required
                    style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; box-sizing: border-box;"
                    placeholder="Contoh: Budi">
                @error('nama_driver')
                    <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="tanggal" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">Tanggal <span style="color:#e11d48">*</span></label>
                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}" required
                    style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; box-sizing: border-box;">
                @error('tanggal')
                    <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Row 2: Type & Warna --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
            <div>
                <label for="type" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">Type (Unit Yang Diambil) <span style="color:#e11d48">*</span></label>
                <input type="text" name="type" id="type" value="{{ old('type') }}" required
                    style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; box-sizing: border-box;"
                    placeholder="Contoh: JIMNY 5 DOORS AT 2025">
                @error('type')
                    <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="warna" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">Warna <span style="color:#e11d48">*</span></label>
                <input type="text" name="warna" id="warna" value="{{ old('warna') }}" required
                    style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; box-sizing: border-box;"
                    placeholder="Contoh: PRL BLUISH BLACK 4">
                @error('warna')
                    <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Row 3: No Rangka & No Mesin --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
            <div>
                <label for="no_rangka" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">No. Rangka</label>
                <input type="text" name="no_rangka" id="no_rangka" value="{{ old('no_rangka') }}"
                    style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; box-sizing: border-box;"
                    placeholder="Contoh: 228841">
                @error('no_rangka')
                    <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="no_mesin" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">No. Mesin</label>
                <input type="text" name="no_mesin" id="no_mesin" value="{{ old('no_mesin') }}"
                    style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; box-sizing: border-box;"
                    placeholder="Contoh: 4455864">
                @error('no_mesin')
                    <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Row 4: Lokasi Pengambilan & Cabang --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
            <div>
                <label for="lokasi_pengambilan" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">Lokasi Pengambilan</label>
                <input type="text" name="lokasi_pengambilan" id="lokasi_pengambilan" value="{{ old('lokasi_pengambilan') }}"
                    style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; box-sizing: border-box;"
                    placeholder="Contoh: CIAWI">
                @error('lokasi_pengambilan')
                    <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="cabang_id" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">Cabang</label>
                <select name="cabang_id" id="cabang_id"
                    style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; box-sizing: border-box; background: white;">
                    <option value="">-- Pilih Cabang --</option>
                    @foreach($cabangs as $cabang)
                        <option value="{{ $cabang->id }}" {{ old('cabang_id') == $cabang->id ? 'selected' : '' }}>
                            {{ $cabang->nama }}
                        </option>
                    @endforeach
                </select>
                @error('cabang_id')
                    <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Row 5: Cekits & Jam Kedatangan --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
            <div>
                <label for="cekits" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">Cekits</label>
                <input type="text" name="cekits" id="cekits" value="{{ old('cekits') }}"
                    style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; box-sizing: border-box;"
                    placeholder="Cekits kedatangan unit">
                @error('cekits')
                    <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="jam_kedatangan" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">Jam Kedatangan</label>
                <input type="time" name="jam_kedatangan" id="jam_kedatangan" value="{{ old('jam_kedatangan') }}"
                    style="width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; box-sizing: border-box;">
                @error('jam_kedatangan')
                    <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="submit" style="background: #2563eb; color: white; padding: 10px 24px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">Simpan</button>
            <a href="{{ route('admin.in-units.index') }}" style="background: #f1f5f9; color: #475569; padding: 10px 24px; border-radius: 6px; text-decoration: none; font-weight: 600; text-align: center; border: 1px solid #cbd5e1;">Batal</a>
        </div>
    </form>
</div>
@endsection
