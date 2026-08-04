@extends('layouts.app')

@section('content')
<div class="page-header" style="margin-bottom: 24px;">
    <div>
        <h1 class="page-title">Edit Stock</h1>
        <p class="page-subtitle">Ubah data stock kendaraan.</p>
    </div>
</div>

<div style="background:#fff; border-radius:10px; border:1px solid #e2e8f0; padding:24px;">
    <form action="{{ route('admin.stocks.update', $stock) }}" method="POST">
        @csrf
        @method('PUT')
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(250px, 1fr)); gap:16px; margin-bottom:24px;">
            @php
                $fields = [
                    'no_do' => ['label' => 'NO DO', 'type' => 'text'],
                    'tanggal_do' => ['label' => 'TANGGAL DO', 'type' => 'date'],
                    'kode_mobil' => ['label' => 'KODE MOBIL', 'type' => 'text'],
                    'nama_mobil' => ['label' => 'NAMA MOBIL', 'type' => 'select', 'options' => $namaMobilOptions ?? []],
                    'varian' => ['label' => 'VARIAN', 'type' => 'select', 'options' => $varianOptions ?? []],
                    'warna' => ['label' => 'WARNA', 'type' => 'select', 'options' => $warnaOptions ?? []],
                    'tahun' => ['label' => 'TAHUN', 'type' => 'number'],
                    'chassis_code' => ['label' => 'CHASSIS CODE', 'type' => 'text'],
                    'norangka' => ['label' => 'NO RANGKA', 'type' => 'text'],
                    'enginecode' => ['label' => 'ENGINE CODE', 'type' => 'text'],
                    'nomesin' => ['label' => 'NO MESIN', 'type' => 'text'],
                    'faktur' => ['label' => 'FAKTUR', 'type' => 'text'],
                    'bln_naik_faktur' => ['label' => 'BLN NAIK FAKTUR', 'type' => 'text'],
                    'harga' => ['label' => 'HARGA', 'type' => 'number'],
                    'kpt_kf' => ['label' => 'KPT + KF', 'type' => 'number'],
                    'acs2' => ['label' => 'ACS2', 'type' => 'number'],
                    'subsidi' => ['label' => 'SUBSIDI', 'type' => 'number'],
                    'hpp' => ['label' => 'HPP', 'type' => 'number'],
                    'lokasi' => ['label' => 'LOKASI', 'type' => 'select', 'options' => $gudangOptions ?? []],
                    'estimasi_unit_masuk_gudang_dca' => ['label' => 'ESTIMASI MASUK GUDANG', 'type' => 'text'],
                    'status' => ['label' => 'STATUS', 'type' => 'select', 'options' => ['free' => 'Free', 'matching' => 'Matching', 'sold' => 'Sold']],
                    'lain_lain' => ['label' => 'LAIN-LAIN', 'type' => 'text'],
                    'penjualan' => ['label' => 'PENJUALAN', 'type' => 'text'],
                    'tanggal_matching_do' => ['label' => 'TANGGAL MATCHING/SOLD', 'type' => 'date'],
                    'cabang' => ['label' => 'CABANG', 'type' => 'select', 'options' => $cabangOptions ?? []],
                    'keterangan' => ['label' => 'KETERANGAN', 'type' => 'text'],
                ];
            @endphp

            @php
                $editableFields = [
                    'faktur', 'bln_naik_faktur', 'penjualan', 'tanggal_matching_do',
                    'cabang', 'status', 'keterangan', 'unit', 'lokasi', 'nama_mobil', 'varian', 'warna', 'norangka', 'nomesin', 'enginecode'
                ];
            @endphp

            @foreach($fields as $name => $field)
                @php
                    $isEditable = in_array($name, $editableFields);
                    $readonlyAttr = $isEditable ? '' : 'readonly';
                    $disabledAttr = $isEditable ? '' : 'disabled';
                    $bgColor = $isEditable ? '#fff' : '#f1f5f9';
                    
                    // Handle date fields - convert to YYYY-MM-DD format for HTML date input
                    $currentValue = old($name, $stock->$name ?? '');
                    if ($field['type'] === 'date' && $currentValue) {
                        try {
                            $currentValue = \Carbon\Carbon::parse($currentValue)->format('Y-m-d');
                        } catch (\Exception $e) {
                            $currentValue = '';
                        }
                    }
                @endphp
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label for="{{ $name }}" style="font-size:13px; font-weight:600; color:#475569;">{{ $field['label'] }}</label>
                    
                    @if(isset($field['type']) && $field['type'] === 'select')
                        @if(!$isEditable)
                            <input type="hidden" name="{{ $name }}" value="{{ $currentValue }}">
                        @endif
                        <select name="{{ $isEditable ? $name : '' }}" id="{{ $name }}" {{ $disabledAttr }} style="padding:10px 14px; border-radius:8px; border:1px solid #cbd5e1; outline:none; font-size:14px; color:#1e293b; width:100%; box-sizing:border-box; background:{{ $bgColor }};">
                            <option value="">-- Pilih {{ $field['label'] }} --</option>
                            @foreach($field['options'] as $val => $text)
                                <option value="{{ $val }}" @selected($currentValue == $val)>{{ $text }}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="{{ $field['type'] }}" name="{{ $name }}" id="{{ $name }}" value="{{ $currentValue }}"
                               {{ $readonlyAttr }} style="padding:10px 14px; border-radius:8px; border:1px solid #cbd5e1; outline:none; font-size:14px; color:#1e293b; width:100%; box-sizing:border-box; background:{{ $bgColor }};">
                    @endif
                    
                    @error($name)
                        <span style="color:#ef4444; font-size:12px;">{{ $message }}</span>
                    @enderror
                </div>
            @endforeach
        </div>

        <div style="display:flex; gap:12px; justify-content:flex-end; border-top:1px solid #e2e8f0; padding-top:20px;">
            <a href="{{ route('admin.stocks.index') }}" class="btn-secondary" style="background:#f1f5f9; color:#475569; border:1px solid #cbd5e1; padding:10px 20px; border-radius:8px; text-decoration:none; font-weight:500;">Batal</a>
            <button type="submit" class="btn-primary" style="padding:10px 24px; border-radius:8px;">Perbarui Data</button>
        </div>
    </form>
</div>
@endsection
