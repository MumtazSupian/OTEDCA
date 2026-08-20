@extends('layouts.app')

@section('content')
<div class="monitoring-header">
    <i class="fas fa-edit"></i> EDIT DATA SOM
</div>

@if(session('error'))
<div style="background: #f8d7da; color: #721c24; padding: 10px 15px; border-radius: 4px; margin-bottom: 20px;">
    {{ session('error') }}
</div>
@endif

<div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); max-width: 800px;">
    <form action="{{ route('service.service-ac.data.update', $serviceAc->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="display: flex; gap: 20px; margin-bottom: 20px;">
            <div style="flex: 1;">
                <label style="display: block; font-weight: 600; font-size: 13px; margin-bottom: 5px;">Cabang</label>
                <select name="cabang" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; background: #eee; pointer-events: none;">
                    <option value="{{ $serviceAc->cabang }}">{{ $serviceAc->cabang }}</option>
                </select>
            </div>
            <div style="flex: 1;">
                <label style="display: block; font-weight: 600; font-size: 13px; margin-bottom: 5px;">Periode (Tgl Awal Bulan)</label>
                <input type="date" name="periode" value="{{ old('periode', $serviceAc->periode) }}" required readonly style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; background: #eee;">
            </div>
        </div>

        <h4 style="margin: 20px 0 10px; color: #2196f3; border-bottom: 1px solid #eee; padding-bottom: 5px;">UNIT ENTRY SERVICE</h4>
        <div style="display: flex; gap: 15px; margin-bottom: 15px;">
            <div style="flex: 1;">
                <label style="font-size: 12px; color: #555;">Bulan</label>
                <input type="number" name="unit_entry_bulan" value="{{ old('unit_entry_bulan', $serviceAc->unit_entry_bulan) }}" style="width: 100%; padding: 6px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            <div style="flex: 1;">
                <label style="font-size: 12px; color: #555;">Hari Ini</label>
                <input type="number" name="unit_entry_hari_ini" value="{{ old('unit_entry_hari_ini', $serviceAc->unit_entry_hari_ini) }}" style="width: 100%; padding: 6px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            <div style="flex: 1;">
                <label style="font-size: 12px; color: #555;">Target</label>
                <input type="number" name="unit_entry_target" value="{{ old('unit_entry_target', $serviceAc->unit_entry_target) }}" style="width: 100%; padding: 6px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
        </div>

        <h4 style="margin: 20px 0 10px; color: #ff9800; border-bottom: 1px solid #eee; padding-bottom: 5px;">UNIT SPOORING BALANCING</h4>
        <div style="display: flex; gap: 15px; margin-bottom: 15px;">
            <div style="flex: 1;">
                <label style="font-size: 12px; color: #555;">Bulan</label>
                <input type="number" name="unit_spooring_bulan" value="{{ old('unit_spooring_bulan', $serviceAc->unit_spooring_bulan) }}" style="width: 100%; padding: 6px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            <div style="flex: 1;">
                <label style="font-size: 12px; color: #555;">Hari Ini</label>
                <input type="number" name="unit_spooring_hari_ini" value="{{ old('unit_spooring_hari_ini', $serviceAc->unit_spooring_hari_ini) }}" style="width: 100%; padding: 6px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            <div style="flex: 1;">
                <label style="font-size: 12px; color: #555;">Target</label>
                <input type="number" name="unit_spooring_target" value="{{ old('unit_spooring_target', $serviceAc->unit_spooring_target) }}" style="width: 100%; padding: 6px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
        </div>

        <h4 style="margin: 20px 0 10px; color: #4caf50; border-bottom: 1px solid #eee; padding-bottom: 5px;">UNIT AC</h4>
        <div style="display: flex; gap: 15px; margin-bottom: 25px;">
            <div style="flex: 1;">
                <label style="font-size: 12px; color: #555;">Bulan</label>
                <input type="number" name="unit_ac_bulan" value="{{ old('unit_ac_bulan', $serviceAc->unit_ac_bulan) }}" style="width: 100%; padding: 6px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            <div style="flex: 1;">
                <label style="font-size: 12px; color: #555;">Hari Ini</label>
                <input type="number" name="unit_ac_hari_ini" value="{{ old('unit_ac_hari_ini', $serviceAc->unit_ac_hari_ini) }}" style="width: 100%; padding: 6px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            <div style="flex: 1;">
                <label style="font-size: 12px; color: #555;">Target</label>
                <input type="number" name="unit_ac_target" value="{{ old('unit_ac_target', $serviceAc->unit_ac_target) }}" style="width: 100%; padding: 6px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
        </div>

        <div>
            <button type="submit" style="background: #2196f3; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">Update Data</button>
            <a href="{{ route('service.service-ac.data.index') }}" style="display: inline-block; padding: 10px 20px; color: #666; text-decoration: none; margin-left: 10px;">Batal</a>
        </div>
    </form>
</div>
@endsection
