@extends('layouts.app')

@section('content')
<style>
    .data-table tbody tr td {
        color: #334155 !important;
    }
    .data-table thead th {
        background: #f3f4f6;
        color: #111827;
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">Data Cabang</h1>
        <p class="page-subtitle">Kelola daftar Cabang dengan tampilan yang rapi.</p>
    </div>
    <a href="{{ route('admin.cabangs.create') }}" class="btn-primary">Buat Cabang</a>
</div>

@if(session('success'))
    <div style="margin-bottom:18px; padding:14px 16px; border-radius:12px; background:#dcfce7; color:#166534; border:1px solid #86efac;">
        {{ session('success') }}
    </div>
@endif

<div style="margin-bottom:18px; display:flex; flex-wrap:wrap; gap:12px; align-items:center; justify-content:space-between;">
    <form method="GET" action="{{ route('admin.cabangs.index') }}" style="display:flex; gap:8px; align-items:center; flex:1; min-width:260px;">
        <input type="text" name="search" value="{{ old('search', $search ?? '') }}" placeholder="Cari nama Cabang..."
            style="width:100%; max-width:360px; padding:10px 14px; border-radius:10px; border:1px solid #d1d5db; background:#fff; color:#111827;">
        <button type="submit" class="btn-primary" style="padding:10px 18px;">Cari</button>
    </form>
    @if(!empty($search))
        <a href="{{ route('admin.cabangs.index') }}" style="color:#0f172a; text-decoration:none; font-weight:600;">Reset</a>
    @endif
</div>

<div class="overflow-x-auto rounded-lg shadow-sm" style="background:#fff; border:1px solid #e5e7eb;">
    <table class="min-w-full data-table">
        <thead>
            <tr>
                <th class="px-4 py-2 text-left">No</th>
                <th class="px-4 py-2 text-left">Nama Cabang</th>
                <th class="px-4 py-2 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $index => $item)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $items->firstItem() + $index }}</td>
                    <td class="px-4 py-2">{{ $item->nama }}</td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('admin.cabangs.edit', $item) }}" class="btn-primary" style="padding:6px 12px;">Edit</a>
                        <form action="{{ route('admin.cabangs.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus Cabang ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-primary" style="background:#ef4444; padding:6px 12px;">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="px-4 py-2 text-center">Tidak ada data Cabang.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $items->appends(['search' => $search])->links() }}
</div>

@endsection
