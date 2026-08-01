@extends('layouts.app')

@section('content')
<style>
    .data-table tbody tr td {
        color: #334155 !important; /* Mengubah warna teks data menjadi abu-abu gelap agar kontras */
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">Data Asuransi</h1>
        <p class="page-subtitle">Kelola daftar asuransi dengan tampilan yang lebih rapi dan responsif.</p>
    </div>
    <a href="{{ route('admin.asuransi.create') }}" class="btn-primary">Buat Asuransi</a>
</div>

@if(session('success'))
    <div style="margin-bottom:18px; padding:14px 16px; border-radius:12px; background:#dcfce7; color:#166534; border:1px solid #86efac;">
        {{ session('success') }}
    </div>
@endif

<div style="margin-bottom:18px; display:flex; flex-wrap:wrap; gap:12px; align-items:center; justify-content:space-between;">
    <form method="GET" action="{{ route('admin.asuransi.index') }}" style="display:flex; gap:8px; align-items:center; flex:1; min-width:260px;">
        <input type="text" name="search" value="{{ old('search', $search ?? '') }}" placeholder="Cari nama asuransi..."
            style="width:100%; max-width:360px; padding:10px 14px; border-radius:10px; border:1px solid #d1d5db; background:#fff; color:#111827;">
        <button type="submit" class="btn-primary" style="padding:10px 18px;">Cari</button>
    </form>
    @if(!empty($search))
        <a href="{{ route('admin.asuransi.index') }}" style="color:#0f172a; text-decoration:none; font-weight:600;">Reset</a>
    @endif
</div>

<div class="table-container">
    <div class="table-scroll">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th class="col-action">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i => $item)
                    <tr>
                        <td>{{ $items->firstItem() + $i }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->deskripsi }}</td>
                        <td>
                            <a href="{{ route('admin.asuransi.edit', $item) }}" class="btn-primary">Edit</a>
                            <form action="{{ route('admin.asuransi.destroy', $item) }}" method="POST" style="display:inline-flex; margin-left:8px;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-secondary" style="background:#ef4444; color:#fff; border:none;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center; padding:18px 12px; color: #000; background: #f5f5f5;">
                            Tidak ada data asuransi untuk ditampilkan.
                        </td>
                    </tr>
                @endempty
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top:16px;">{{ $items->links() }}</div>

@endsection