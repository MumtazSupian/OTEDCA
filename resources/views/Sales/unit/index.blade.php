@extends('layouts.app')

@section('content')
<div class="page-header" style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
    <div>
        <h1 class="page-title" style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">Data Unit</h1>
        <p class="page-subtitle" style="font-size: 13px; color: #64748b; margin: 0;">Kelola daftar Unit dengan tampilan yang rapi.</p>
    </div>
    <a href="{{ route('admin.units.create') }}" class="btn-primary" style="background: #dc2626; color: #ffffff !important; font-weight: 700; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-size: 13px; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 4px rgba(220,38,38,0.2);">+ Buat Unit</a>
</div>

@if(session('success'))
    <div style="margin-bottom: 20px; padding: 14px 18px; border-radius: 10px; background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; font-size: 13px; font-weight: 600;">
        {{ session('success') }}
    </div>
@endif

<div style="margin-bottom: 20px; display: flex; flex-wrap: wrap; gap: 12px; align-items: center; justify-content: space-between;">
    <form method="GET" action="{{ route('admin.units.index') }}" style="display: flex; gap: 8px; align-items: center; width: 100%; max-width: 420px;">
        <input type="text" name="search" value="{{ old('search', $search ?? '') }}" placeholder="Cari nama Unit..."
            style="flex: 1; padding: 10px 16px; border-radius: 8px; border: 1px solid #cbd5e1; background: #fff; color: #1e293b; font-size: 13px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#dc2626'" onblur="this.style.borderColor='#cbd5e1'">
        <button type="submit" style="background: #dc2626; color: #fff; padding: 10px 20px; border-radius: 8px; border: none; font-size: 13px; font-weight: 700; cursor: pointer;">Cari</button>
        @if(!empty($search))
            <a href="{{ route('admin.units.index') }}" style="color: #64748b; text-decoration: none; font-size: 13px; font-weight: 600; padding: 6px 8px;">Reset</a>
        @endif
    </form>
</div>

<div style="background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden; width: 100%;">
    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
        <thead>
            <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                <th style="padding: 14px 18px; font-weight: 700; color: #475569; width: 80px; text-align: center; text-transform: uppercase; font-size: 11px; letter-spacing: 0.05em;">NO</th>
                <th style="padding: 14px 18px; font-weight: 700; color: #475569; text-transform: uppercase; font-size: 11px; letter-spacing: 0.05em;">NAMA UNIT</th>
                <th style="padding: 14px 18px; font-weight: 700; color: #475569; text-transform: uppercase; font-size: 11px; letter-spacing: 0.05em;">DESKRIPSI</th>
                <th style="padding: 14px 18px; font-weight: 700; color: #475569; width: 180px; text-align: center; text-transform: uppercase; font-size: 11px; letter-spacing: 0.05em;">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $i => $item)
                <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s ease;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 14px 18px; text-align: center; color: #64748b; font-weight: 600;">{{ $items->firstItem() + $i }}</td>
                    <td style="padding: 14px 18px; color: #1e293b; font-weight: 600;">{{ $item->nama }}</td>
                    <td style="padding: 14px 18px; color: #64748b;">{{ $item->deskripsi ?: '-' }}</td>
                    <td style="padding: 14px 18px; text-align: center;">
                        <div style="display: inline-flex; gap: 8px; align-items: center; justify-content: center;">
                            <a href="{{ route('admin.units.edit', $item) }}" style="display: inline-flex; align-items: center; background: #e0f2fe; color: #0284c7; padding: 6px 14px; border-radius: 6px; font-size: 12px; font-weight: 700; text-decoration: none; transition: all 0.15s ease;" onmouseover="this.style.background='#bae6fd'" onmouseout="this.style.background='#e0f2fe'">Edit</a>
                            <form action="{{ route('admin.units.destroy', $item) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus unit {{ $item->nama }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="display: inline-flex; align-items: center; background: #fee2e2; color: #dc2626; padding: 6px 14px; border-radius: 6px; font-size: 12px; font-weight: 700; border: none; cursor: pointer; transition: all 0.15s ease;" onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fee2e2'">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="padding: 36px 18px; text-align: center; color: #94a3b8; font-size: 13px;">Tidak ada Data Unit yang ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 20px;">
    {{ $items->appends(['search' => $search])->links() }}
</div>

@endsection
