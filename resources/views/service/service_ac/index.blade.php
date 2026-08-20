@extends('layouts.app')

@section('content')
<div class="monitoring-header" style="justify-content: space-between; padding: 15px;">
    <div><i class="fas fa-table"></i> DATA SOM - PERIODE: {{ request('periode', 'Terbaru') }}</div>
    <a href="{{ route('service.service-ac.data.create') }}" class="btn" style="background: white; color: #38c4c7; padding: 5px 15px; border-radius: 4px; text-decoration: none; font-size: 13px;"><i class="fas fa-plus"></i> Tambah Data</a>
</div>

@if(session('success'))
<div style="background: #d4edda; color: #155724; padding: 10px 15px; border-radius: 4px; margin-bottom: 20px;">
    {{ session('success') }}
</div>
@endif

<div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
    
    <div style="margin-bottom: 15px; display: flex; gap: 10px; align-items: center;">
        <form method="GET" action="{{ route('service.service-ac.data.index') }}" style="display: flex; gap: 10px;">
            <select name="periode" style="padding: 6px; border: 1px solid #ddd; border-radius: 4px;" onchange="this.form.submit()">
                <option value="">-- Pilih Periode --</option>
                @foreach($availableDates as $date)
                    <option value="{{ $date['value'] }}" {{ request('periode') == $date['value'] ? 'selected' : '' }}>
                        {{ $date['label'] }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
        <thead>
            <tr style="background: #f4f6f9; border-bottom: 2px solid #ddd; text-align: left;">
                <th style="padding: 10px;">Cabang</th>
                <th style="padding: 10px;">Periode</th>
                <th style="padding: 10px;">Entry (B/H/T)</th>
                <th style="padding: 10px;">Spooring (B/H/T)</th>
                <th style="padding: 10px;">AC (B/H/T)</th>
                <th style="padding: 10px; text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($soms as $som)
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 10px; font-weight: 600;">{{ $som->cabang }}</td>
                <td style="padding: 10px;">{{ $som->periode }}</td>
                <td style="padding: 10px;">{{ $som->unit_entry_bulan }} / {{ $som->unit_entry_hari_ini }} / {{ $som->unit_entry_target }}</td>
                <td style="padding: 10px;">{{ $som->unit_spooring_bulan }} / {{ $som->unit_spooring_hari_ini }} / {{ $som->unit_spooring_target }}</td>
                <td style="padding: 10px;">{{ $som->unit_ac_bulan }} / {{ $som->unit_ac_hari_ini }} / {{ $som->unit_ac_target }}</td>
                <td style="padding: 10px; text-align: center;">
                    <a href="{{ route('service.service-ac.data.edit', $som->id) }}" style="color: #2196f3; margin-right: 10px;"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('service.service-ac.data.destroy', $som->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin hapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; color: #f44336; cursor: pointer; padding: 0;"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding: 20px; text-align: center; color: #777;">Belum ada data untuk periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
