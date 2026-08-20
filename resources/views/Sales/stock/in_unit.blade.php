@extends('layouts.app')

@section('content')
@php
    $isRestrictedBranch = in_array(strtolower(auth()->user()->branch ?? ''), ['inunit_jatiasih', 'inunit_cinere'] );
@endphp
<div class="page-header" style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Data IN UNIT</h1>
        <p class="page-subtitle">Data kedatangan unit dari gudang ke cabang.</p>
    </div>
    @if(!$isRestrictedBranch && auth()->user()->role !== 'adh')
    <div>
        <a href="{{ route('admin.in-units.create') }}" class="btn btn-primary" style="background: #dc2626; color: #ffffff !important; font-weight:800; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 600;">+ Tambah Data</a>
    </div>
    @endif
</div>

@if(session('success'))
<div style="background: #dcfce7; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; border: 1px solid #bbf7d0;">
    {{ session('success') }}
</div>
@endif

<div style="background:#fff; border-radius:10px; border:1px solid #e2e8f0; padding:24px; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; font-size: 12px; min-width: 1100px;">
        <thead>
            <tr>
                <th rowspan="2" style="border: 1px solid #cbd5e1; padding: 8px 10px; text-align: center; background: #e2e8f0; font-weight: 700; vertical-align: middle;">Nama Driver</th>
                <th rowspan="2" style="border: 1px solid #cbd5e1; padding: 8px 10px; text-align: center; background: #e2e8f0; font-weight: 700; vertical-align: middle;">Tanggal</th>
                <th colspan="4" style="border: 1px solid #cbd5e1; padding: 8px 10px; text-align: center; background: #dbeafe; font-weight: 700;">Unit Yang Diambil</th>
                <th rowspan="2" style="border: 1px solid #cbd5e1; padding: 8px 10px; text-align: center; background: #e2e8f0; font-weight: 700; vertical-align: middle;">Lokasi Pengambilan</th>
                <th rowspan="2" style="border: 1px solid #cbd5e1; padding: 8px 10px; text-align: center; background: #e2e8f0; font-weight: 700; vertical-align: middle;">Cabang</th>
                <th colspan="2" style="border: 1px solid #cbd5e1; padding: 8px 10px; text-align: center; background: #dcfce7; font-weight: 700;">Kedatangan Unit</th>
                <th rowspan="2" style="border: 1px solid #cbd5e1; padding: 8px 10px; text-align: center; background: #e2e8f0; font-weight: 700; vertical-align: middle; width: 100px;">Aksi</th>
            </tr>
            <tr>
                <th style="border: 1px solid #cbd5e1; padding: 8px 10px; text-align: center; background: #dbeafe; font-weight: 700;">Type</th>
                <th style="border: 1px solid #cbd5e1; padding: 8px 10px; text-align: center; background: #dbeafe; font-weight: 700;">Warna</th>
                <th style="border: 1px solid #cbd5e1; padding: 8px 10px; text-align: center; background: #dbeafe; font-weight: 700;">Rangka</th>
                <th style="border: 1px solid #cbd5e1; padding: 8px 10px; text-align: center; background: #dbeafe; font-weight: 700;">Mesin</th>
                <th style="border: 1px solid #cbd5e1; padding: 8px 10px; text-align: center; background: #dcfce7; font-weight: 700;">Cekits</th>
                <th style="border: 1px solid #cbd5e1; padding: 8px 10px; text-align: center; background: #dcfce7; font-weight: 700;">Jam</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inUnits as $unit)
                <tr>
                    <td style="border: 1px solid #cbd5e1; padding: 6px 10px; text-align: center;">{{ $unit->nama_driver }}</td>
                    <td style="border: 1px solid #cbd5e1; padding: 6px 10px; text-align: center; white-space: nowrap;">{{ $unit->tanggal ? $unit->tanggal->format('d-M-Y') : '-' }}</td>
                    <td style="border: 1px solid #cbd5e1; padding: 6px 10px;">{{ $unit->type }}</td>
                    <td style="border: 1px solid #cbd5e1; padding: 6px 10px;">{{ $unit->warna }}</td>
                    <td style="border: 1px solid #cbd5e1; padding: 6px 10px; text-align: center;">{{ $unit->no_rangka ?? '-' }}</td>
                    <td style="border: 1px solid #cbd5e1; padding: 6px 10px; text-align: center;">{{ $unit->no_mesin ?? '-' }}</td>
                    <td style="border: 1px solid #cbd5e1; padding: 6px 10px; text-align: center;">{{ $unit->lokasi_pengambilan ?? '-' }}</td>
                    <td style="border: 1px solid #cbd5e1; padding: 6px 10px; text-align: center;">{{ $unit->cabang ? $unit->cabang->nama : '-' }}</td>
                    <td style="border: 1px solid #cbd5e1; padding: 6px 10px; text-align: center;">{{ $unit->cekits ?? '-' }}</td>
                    <td style="border: 1px solid #cbd5e1; padding: 6px 10px; text-align: center;">{{ $unit->jam_kedatangan ?? '-' }}</td>
                    <td style="border: 1px solid #cbd5e1; padding: 6px 10px; text-align: center;">
                        <div style="display: flex; gap: 6px; justify-content: center;">
                            <a href="{{ route('admin.in-units.edit', $unit->id) }}" style="color: #0284c7; text-decoration: none; font-size: 11px; background: #e0f2fe; padding: 3px 8px; border-radius: 4px;">Edit</a>
                            @if(!$isRestrictedBranch && auth()->user()->role !== 'adh')
                            <form action="{{ route('admin.in-units.destroy', $unit->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: #e11d48; font-size: 11px; background: #ffe4e6; padding: 3px 8px; border-radius: 4px; border: none; cursor: pointer;">Hapus</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" style="text-align: center; padding: 24px; color: #64748b;">Belum ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
