@extends('layouts.app')

@section('title', 'TAMBAH AKTUAL REJECT')

@section('content')
<div style="padding: 40px 20px; display: flex; flex-direction: column; align-items: center; min-height: 100vh;">
    
    {{-- Header Section --}}
    <div style="text-align: center; margin-bottom: 30px;">
        <h2 style="font-weight: 800; color: #1e293b !important; font-size: 24px; text-transform: uppercase; margin: 0; letter-spacing: 1px;">
            TAMBAH AKTUAL REJECT
        </h2>
        <div style="width: 60px; height: 4px; background: #dc2626; margin: 10px auto; border-radius: 10px;"></div>
        <p style="color: #64748b; font-size: 14px;">Input data transaksi leasing per bulan dengan mudah dan cepat</p>
    </div>

    <div style="background: white; width: 100%; box-sizing: border-box; max-width: 1200px; padding: 35px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.15);">
        
        <form id="leasingCreateForm" action="{{ route('leasing.aktual-reject.store') }}" method="POST">
            @csrf
            
            <div style="display: grid; width: 100%; box-sizing: border-box; grid-template-columns: 1fr; gap: 20px; margin-bottom: 10px;">
                <div>
                    <label style="display: block; font-weight: 700; color: #2d3748; margin-bottom: 8px; font-size: 13px; text-transform: uppercase;">Tahun</label>
                    <input type="number" name="tahun" value="{{ date('Y') }}" required
                        style="width: 100%; box-sizing: border-box; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; color: #4a5568;">
                </div>
            </div>

            <div style="margin: 20px 0; border-bottom: 2px dashed #edf2f7;"></div>
            <p style="text-align:center; color: #475569; font-size: 13px; font-weight: 600; margin-bottom: 25px;">
                Menginput data untuk Cabang: <strong style="color: #dc2626 !important; font-weight: 800;">{{ Auth::user()->cabang ?: (Auth::user()->name ?: "Admin AR Stock / Pusat") }}</strong>
            </p>

            {{-- 12 Month Grid Cards --}}
            <div style="display: grid; width: 100%; box-sizing: border-box; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
                @php
                    $monthList = [
                        'jan' => 'JANUARI', 'feb' => 'FEBRUARI', 'mar' => 'MARET',
                        'apr' => 'APRIL', 'mei' => 'MEI', 'jun' => 'JUNI',
                        'jul' => 'JULI', 'agu' => 'AGUSTUS', 'sep' => 'SEPTEMBER',
                        'okt' => 'OKTOBER', 'nov' => 'NOVEMBER', 'des' => 'DESEMBER'
                    ];
                @endphp

                @foreach($monthList as $mKey => $mName)
                    <div style="background: #ffffff; padding: 20px; border-radius: 15px; border: 1.5px solid #e2e8f0; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
                        <div style="background: #ebf8ff; color: #2b6cb0; padding: 10px; border-radius: 8px; font-weight: 800; text-transform: uppercase; text-align: center; margin-bottom: 15px; letter-spacing: 1px; font-size: 13px;">
                            {{ $mName }}
                        </div>
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; border-bottom: 2px solid #edf2f7; padding-bottom: 6px;">
                                <span style="font-size: 12px; font-weight: 700; color: #4a5568;">LIST LEASING</span>
                                <button type="button" onclick="addLeasingRow('{{ $mKey }}')"
                                    style="background: #dc2626; color: #ffffff !important; font-weight: 800; border: none; width: 28px; height: 28px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 18px;">+</button>
                            </div>

                            <div id="container-{{ $mKey }}"></div>

                            <div id="empty-{{ $mKey }}" style="text-align: center; font-style: italic; color: #a0aec0; font-size: 12px; padding: 10px 0;">
                                Belum ada data leasing (Klik + untuk tambah)
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Submit Buttons --}}
            <div style="margin-top: 35px; display: flex; gap: 15px;">
                <a href="{{ route('leasing.aktual-reject.index') }}" 
                   style="flex: 1; padding: 14px; background: #edf2f7; color: #4a5568; text-align: center; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 14px;">Batal</a>
                
                <button type="button" onclick="confirmLeasingSubmit()" 
                        style="flex: 2; padding: 14px; background: #dc2626; color: #ffffff !important; font-weight: 800; border: none; border-radius: 12px; font-size: 15px; text-transform: uppercase; cursor: pointer; box-shadow: 0 4px 14px rgba(220, 38, 38, 0.3);">
                    SIMPAN DATA
                </button>
            </div>
            
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let rowCounters = {};

    function addLeasingRow(month) {
        if (!rowCounters[month]) rowCounters[month] = 0;
        const idx = rowCounters[month]++;
        const container = document.getElementById('container-' + month);
        const emptyMsg = document.getElementById('empty-' + month);
        if (emptyMsg) emptyMsg.style.display = 'none';

        const rowDiv = document.createElement('div');
        rowDiv.className = 'leasing-input-row';
        rowDiv.style.cssText = 'display: flex; align-items: center; gap: 8px; margin-bottom: 8px;';
        rowDiv.innerHTML = `
            <div style="flex: 1; min-width: 0;">
                <select name="items[${month}][${idx}][leasing]" required style="width: 100%; border-radius: 6px; border: 1px solid #cbd5e1; height: 36px; font-size: 12px; color: #1e293b; padding: 0 6px;">
                    <option value="" disabled selected>Pilih Leasing</option>
                    @foreach(['Suzuki Finance','BCA Finance','KKB BCA','Mandiri Tunas Finance','KKB MANDIRI','BSI','Mandiri Utama Finance','Indomobil Finance','Adira Finance','BNI Finance','MAYBANK','Oto Multiartha Finance','NIAGA Finance','Clipan Finance','Lain - Lain'] as $l)
                        <option value="{{ $l }}">{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <div style="width: 85px; flex-shrink: 0;">
                <input type="number" name="items[${month}][${idx}][amount]" placeholder="Qty" min="1" required style="width: 100%; border-radius: 6px; border: 1px solid #cbd5e1; height: 36px; font-size: 13px; padding: 0 6px; text-align: center;">
            </div>
            <div style="flex-shrink: 0;">
                <button type="button" onclick="removeLeasingRow(this, '${month}')" style="width: 30px; height: 30px; background: #ef4444; color: #ffffff !important; font-weight: 800; border: none; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 16px;">×</button>
            </div>
        `;
        container.appendChild(rowDiv);
    }

    function removeLeasingRow(btn, month) {
        const row = btn.closest('.leasing-input-row');
        if (row) row.remove();
        const container = document.getElementById('container-' + month);
        if (container && container.children.length === 0) {
            const emptyMsg = document.getElementById('empty-' + month);
            if (emptyMsg) emptyMsg.style.display = 'block';
        }
    }

    function confirmLeasingSubmit() {
        const rows = document.querySelectorAll('.leasing-input-row');
        if (rows.length === 0) {
            Swal.fire({
                title: 'Peringatan',
                text: 'Mohon klik tombol (+) pada minimal satu bulan untuk menambah data Leasing terlebih dahulu!',
                icon: 'warning',
                confirmButtonColor: '#dc2626'
            });
            return;
        }

        Swal.fire({
            title: 'Simpan Data Leasing?',
            text: 'Pastikan data yang diinput sudah sesuai.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Cek Kembali'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('leasingCreateForm').submit();
            }
        });
    }
</script>
@endsection