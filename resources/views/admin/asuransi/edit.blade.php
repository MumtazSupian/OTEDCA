@extends('layouts.app')

@section('content')
<style>
    .bright-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        color: #0f172a;
    }
    .bright-card .form-label {
        color: #395c8c;
    }
    .bright-card .form-input {
        background: #ffffff;
        color: #0f172a;
        border-color: #cbd5e1;
    }
    .bright-card .form-input:focus {
        border-color: var(--accent-red);
        box-shadow: 0 0 0 3px rgba(220,38,38,.12);
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">Edit Asuransi</h1>
        <p class="page-subtitle">Perbarui informasi asuransi dengan cepat dan mudah.</p>
    </div>
    <a href="{{ route('admin.asuransi.index') }}" class="btn-secondary">Kembali</a>
</div>

@if($errors->any())
    <div style="margin-bottom:18px; padding:14px 16px; border-radius:12px; background:#fee2e2; color:#b91c1c; border:1px solid #fca5a5;">
        <ul style="margin:0; padding-left:18px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bright-card">
    <form method="POST" action="{{ route('admin.asuransi.update', $item) }}">
        @csrf @method('PUT')
        <div class="form-grid">
            <div class="form-group full-width">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" value="{{ old('nama', $item->nama) }}" class="form-input" required>
            </div>
            <div class="form-group full-width">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-input" style="min-height:140px;">{{ old('deskripsi', $item->deskripsi) }}</textarea>
            </div>
        </div>

        <div class="modal-footer" style="justify-content:flex-start; padding:0; border:none; margin-top:12px;">
            <a href="{{ route('admin.asuransi.index') }}" class="btn-secondary" style="margin-right:12px;">Batal</a>
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>

@endsection
