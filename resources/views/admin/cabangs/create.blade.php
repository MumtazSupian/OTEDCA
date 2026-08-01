@extends('layouts.app')

@section('content')
<style>
    .form-container {
        max-width: 560px;
        margin: 0 auto;
        background: #fff;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .form-container input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        margin-bottom: 16px;
        background: #fff;
        color: #111827;
    }
    .form-container button {
        padding: 10px 20px;
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Cabang</h1>
        <p class="page-subtitle">Masukkan data cabang baru.</p>
    </div>
    <a href="{{ route('admin.cabangs.index') }}" class="btn-secondary">Kembali</a>
</div>

@if ($errors->any())
    <div style="margin-bottom:18px; padding:14px 16px; border-radius:12px; background:#fee2e2; color:#991b1b; border:1px solid #fecaca;">
        <strong>Terjadi kesalahan:</strong>
        <ul style="margin-top:8px; margin-left:20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-container">
    <form method="POST" action="{{ route('admin.cabangs.store') }}">
        @csrf
        <label for="nama" style="font-weight:600; display:block; margin-bottom:4px;">Nama Cabang</label>
        <input type="text" name="nama" id="nama" placeholder="Contoh: Ciawi" value="{{ old('nama') }}" required />
        <button type="submit" class="btn-primary">Simpan</button>
    </form>
</div>
@endsection
