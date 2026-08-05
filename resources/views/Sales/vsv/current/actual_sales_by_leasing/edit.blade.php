@extends('layouts.app')

@section('title', 'Edit Actual Sales By Leasing')

@section('content')
<div style="padding: 40px 20px; display: flex; flex-direction: column; align-items: center; min-height: 100vh;">

    <div style="text-align: center; margin-bottom: 30px;">
        <h2 style="font-weight:800; color:#1e293b; font-weight:800; letter-spacing:1px; text-transform:uppercase; margin:0;">
            ✏️ EDIT ACTUAL SALES BY LEASING
        </h2>
        <div style="width: 50px; height: 4px; background: #dc2626; margin: 10px auto; border-radius: 10px;"></div>
        <p style="color: #64748b; font-size: 14px;">Perbarui data realisasi penjualan berdasarkan mitra leasing</p>
    </div>

    <div style="background: white; width: 100%; box-sizing: border-box; max-width: 850px; padding: 35px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
        <form id="editForm" action="{{ route('current.actual-sales-by-leasing.update', $row->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display: grid; width: 100%; box-sizing: border-box; box-sizing: border-box;  grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 10px;">
                <div>
                    <label style="display: block; font-weight: 700; color: #2d3748; margin-bottom: 8px; font-size: 13px; text-transform: uppercase;">
                        Nama Leasing
                    </label>
                    <select name="leasing_name" id="leasing_name" style="width: 100%; box-sizing: border-box; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; color: #4a5568; outline: none; transition: 0.3s; cursor: pointer;">
                        @foreach ($leasingOptions as $l)
                            <option value="{{ $l }}" {{ $row->leasing_name == $l ? 'selected' : '' }}>
                                {{ ucwords(str_replace('_', ' ', $l)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; font-weight: 700; color: #2d3748; margin-bottom: 8px; font-size: 13px; text-transform: uppercase;">
                        Tahun
                    </label>
                    <input type="number" name="tahun" id="tahun" value="{{ $row->tahun }}"
                           style="width: 100%; box-sizing: border-box; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; color: #4a5568; outline: none; transition: 0.3s;">
                </div>
            </div>

            <div style="margin: 25px 0 15px 0; border-bottom: 2px dashed #edf2f7;"></div>

            <p style="text-align:center; color: #718096; font-size: 13px; margin-bottom: 15px;">
                Mengupdate data untuk Cabang: <strong style="color: #2d3748;">{{ $row->cabang }}</strong>
            </p>

            <label style="display: block; font-weight: 800; color: #dc2626; margin-bottom: 15px; font-size: 14px; text-transform: uppercase; text-align: center;">
                Data Penjualan Per Bulan
            </label>

            @php $months = ['jan','feb','mar','apr','mei','jun','jul','agu','sep','okt','nov','des']; @endphp

            <div style="display: grid; width: 100%; box-sizing: border-box; box-sizing: border-box;  grid-template-columns: repeat(4, 1fr); gap: 15px;">
                @foreach ($months as $m)
                    <div style="background: #f7fafc; padding: 10px; border-radius: 12px; border: 1px solid #edf2f7;">
                        <label style="display: block; font-weight: 700; color: #718096; margin-bottom: 5px; font-size: 11px; text-align: center;">
                            {{ strtoupper($m) }}
                        </label>
                        <input type="number" name="{{ $m }}" value="{{ $row->$m }}"
                               style="width: 100%; box-sizing: border-box; padding: 8px; border: 1px solid #cbd5e0; border-radius: 8px; font-size: 14px; text-align: center; color: #2d3748; outline: none;">
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 35px; display: flex; gap: 15px;">
                <a href="{{ route('current.actual-sales-by-leasing.index') }}"
                   style="flex: 1; padding: 14px; background: #edf2f7; color: #4a5568; text-align: center; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 14px; transition: 0.3s;"
                   onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#edf2f7'">
                    Batal
                </a>
                <button type="button" onclick="confirmUpdate()"
                        style="flex: 2; padding: 14px; background:#dc2626; color: #dc2626; font-weight: 800; color: #1e293b; font-weight:800; border: none; border-radius: 12px; font-weight: 700; font-size: 14px; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 12px rgba(30, 136, 229, 0.3);"
                        onmouseover="this.style.background='#1565c0'; this.style.transform='translateY(-2px)'"
                        onmouseout="this.style.background='#1e88e5'; this.style.transform='translateY(0)'">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmUpdate() {
        const leasing = document.getElementById('leasing_name').value;
        const tahun = document.getElementById('tahun').value;

        // Validasi diubah tanpa user_id
        if (!leasing || !tahun) {
            Swal.fire({
                icon: 'warning', 
                title: 'Data Tidak Lengkap', 
                text: 'Pastikan Nama Leasing dan Tahun sudah diisi.', 
                confirmButtonColor: '#1e88e5', 
                customClass: { popup: 'rounded-4' }
            });
            return;
        }

        Swal.fire({
            title: 'Simpan Perubahan?',
            text: "Pastikan data realisasi leasing sudah benar.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1e88e5',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Update!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: { popup: 'rounded-4' }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ title: 'Memproses...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
                document.getElementById('editForm').submit();
            }
        });
    }
</script>

<style>
    input:focus, select:focus {
        border-color: #3182ce !important;
        box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
    }
</style>
@endsection