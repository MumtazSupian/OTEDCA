@extends('layouts.app')

@section('content')
@php
    $isRestrictedBranch = in_array(strtolower(auth()->user()->branch ?? ''), ['inunit_jatiasih', 'inunit_cinere'] );
    $readonlyStyle = 'width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; box-sizing: border-box; background-color: #f1f5f9; color: #94a3b8; pointer-events: none;';
    $normalStyle = 'width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; box-sizing: border-box;';
    $normalSelectStyle = 'width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; box-sizing: border-box; background: white;';
@endphp

<div class="page-header" style="margin-bottom: 24px;">
    <div>
        <h1 class="page-title">Edit Data IN UNIT</h1>
        <p class="page-subtitle">Silakan ubah form di bawah ini untuk memperbarui data kedatangan unit.</p>
    </div>
</div>

<div style="background:#fff; border-radius:10px; border:1px solid #e2e8f0; padding:24px;">
    <form action="{{ route('admin.in-units.update', $inUnit->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Row 1: Nama Driver & Tanggal --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
            <div>
                <label for="nama_driver" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">Nama Driver <span style="color:#e11d48">*</span></label>
                <input type="text" name="nama_driver" id="nama_driver" value="{{ old('nama_driver', $inUnit->nama_driver) }}" {{ $isRestrictedBranch ? 'readonly' : 'required' }}
                    style="{{ $isRestrictedBranch ? $readonlyStyle : $normalStyle }}">
                @error('nama_driver')
                    <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="tanggal" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">Tanggal <span style="color:#e11d48">*</span></label>
                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $inUnit->tanggal ? $inUnit->tanggal->format('Y-m-d') : '') }}" {{ $isRestrictedBranch ? 'readonly' : 'required' }}
                    style="{{ $isRestrictedBranch ? $readonlyStyle : $normalStyle }}">
                @error('tanggal')
                    <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Row 2: Type & Warna --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
            <div>
                <label for="type" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">Type (Unit Yang Diambil) <span style="color:#e11d48">*</span></label>
                <input type="text" name="type" id="type" value="{{ old('type', $inUnit->type) }}" {{ $isRestrictedBranch ? 'readonly' : 'required' }}
                    style="{{ $isRestrictedBranch ? $readonlyStyle : $normalStyle }}">
                @error('type')
                    <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="warna" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">Warna <span style="color:#e11d48">*</span></label>
                <input type="text" name="warna" id="warna" value="{{ old('warna', $inUnit->warna) }}" {{ $isRestrictedBranch ? 'readonly' : 'required' }}
                    style="{{ $isRestrictedBranch ? $readonlyStyle : $normalStyle }}">
                @error('warna')
                    <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Row 3: No Rangka & No Mesin --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
            <div>
                <label for="no_rangka" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">No. Rangka</label>
                <input type="text" name="no_rangka" id="no_rangka" value="{{ old('no_rangka', $inUnit->no_rangka) }}" {{ $isRestrictedBranch ? 'readonly' : '' }}
                    style="{{ $isRestrictedBranch ? $readonlyStyle : $normalStyle }}">
                @error('no_rangka')
                    <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="no_mesin" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">No. Mesin</label>
                <input type="text" name="no_mesin" id="no_mesin" value="{{ old('no_mesin', $inUnit->no_mesin) }}" {{ $isRestrictedBranch ? 'readonly' : '' }}
                    style="{{ $isRestrictedBranch ? $readonlyStyle : $normalStyle }}">
                @error('no_mesin')
                    <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Row 4: Lokasi Pengambilan & Cabang --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
            <div>
                <label for="lokasi_pengambilan" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">Lokasi Pengambilan</label>
                <input type="text" name="lokasi_pengambilan" id="lokasi_pengambilan" value="{{ old('lokasi_pengambilan', $inUnit->lokasi_pengambilan) }}" {{ $isRestrictedBranch ? 'readonly' : '' }}
                    style="{{ $isRestrictedBranch ? $readonlyStyle : $normalStyle }}">
                @error('lokasi_pengambilan')
                    <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="cabang_id" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">Cabang</label>
                <select name="cabang_id" id="cabang_id" {{ $isRestrictedBranch ? 'disabled' : '' }}
                    style="{{ $isRestrictedBranch ? $readonlyStyle : $normalSelectStyle }}">
                    <option value="">-- Pilih Cabang --</option>
                    @foreach($cabangs as $cabang)
                        <option value="{{ $cabang->id }}" {{ old('cabang_id', $inUnit->cabang_id) == $cabang->id ? 'selected' : '' }}>
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
                <input type="text" name="cekits" id="cekits" value="{{ old('cekits', $inUnit->cekits) }}"
                    style="{{ $normalStyle }}">
                @error('cekits')
                    <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="jam_kedatangan" style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px;">Jam Kedatangan</label>
                <input type="time" name="jam_kedatangan" id="jam_kedatangan" value="{{ old('jam_kedatangan', $inUnit->jam_kedatangan) }}"
                    style="{{ $normalStyle }}">
                @error('jam_kedatangan')
                    <div style="color: #e11d48; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="submit" style="background: #2563eb; color: white; padding: 10px 24px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">Update</button>
            <a href="{{ route('admin.in-units.index') }}" style="background: #f1f5f9; color: #475569; padding: 10px 24px; border-radius: 6px; text-decoration: none; font-weight: 600; text-align: center; border: 1px solid #cbd5e1;">Batal</a>
        </div>
    </form>
</div>
@endsection
