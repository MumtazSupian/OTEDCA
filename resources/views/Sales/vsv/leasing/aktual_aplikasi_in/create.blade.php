@extends('layouts.app')

@section('title', 'Tambah Aplikasi In ')

@section('content')
<div style="padding: 40px 20px; display: flex; flex-direction: column; align-items: center; min-height: 100vh;">
    
    {{-- Header Section --}}
    <div style="text-align: center; margin-bottom: 30px;">
        <h2 style="font-weight:800; color:#1e293b; font-weight:800; letter-spacing:1px; text-transform:uppercase; margin:0;">
            TAMBAH APLIKASI IN (AKTUAL)
        </h2>
        <div style="width: 50px; height: 4px; background: #dc2626; margin: 10px auto; border-radius: 10px;"></div>
        <p style="color: #64748b; font-size: 14px;">Input data aplikasi masuk per leasing per bulan</p>
    </div>

    <div style="background: white; width: 100%; max-width: 1200px; padding: 35px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
        
        <form id="createAppInForm" action="{{ route('leasing.aktual-aplikasi-in.store') }}" method="POST" x-data="appInForm()">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr; gap: 20px; margin-bottom: 10px;">
                <div>
                    <label style="display: block; font-weight: 700; color: #2d3748; margin-bottom: 8px; font-size: 13px; text-transform: uppercase;">Tahun</label>
                    <input type="number" name="tahun" value="{{ date('Y') }}" required
                        style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 14px; color: #4a5568;">
                </div>
            </div>

            <div style="margin: 25px 0 15px 0; border-bottom: 2px dashed #edf2f7;"></div>
            <p style="text-align:center; color: #718096; font-size: 12px; margin-bottom: 15px;">
                Menginput data untuk Cabang: <strong style="color: #2d3748;">{{ Auth::user()->cabang }}</strong>
            </p>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 20px;">
                <template x-for="month in months" :key="month">
                    
                    <div style="background: #ffff; padding: 20px; border-radius: 15px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                        
                        <div style="background: #ebf8ff; color: #2b6cb0; padding: 10px; border-radius: 8px; font-weight: 800; text-transform: uppercase; text-align: center; margin-bottom: 15px; letter-spacing: 1px;">
                            <span x-text="month"></span>
                        </div>

                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; border-bottom: 2px solid #edf2f7; padding-bottom: 5px;">
                                <span style="font-size: 13px; font-weight: 700; color: #4a5568;">LIST LEASING</span>
                                <button type="button" @click="addRow(month)"
                                    style="background: #dc2626; color: #ffffff !important; font-weight:800; border: none; width: 24px; height: 24px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: bold;">+</button>
                            </div>

                            <template x-for="(item, index) in data[month]" :key="item.id">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                    
                                    <div style="flex: 1;">
                                        <select x-model="item.leasing" 
                                                :name="'items[' + month + '][' + index + '][leasing]'"
                                                class="form-control" required
                                                style="width: 100%; border-radius: 6px; border: 1px solid #e2e8f0; height: 35px; font-size: 12px; color: #2d3748;">
                                            <option value="" disabled selected>Pilih Leasing</option>
                                            @foreach(['Suzuki Finance','BCA Finance','KKB BCA','Mandiri Tunas Finance','KKB MANDIRI','BSI','Mandiri Utama Finance','Indomobil Finance','Adira Finance','BNI Finance','MAYBANK','Oto Multiartha Finance','NIAGA Finance','Clipan Finance','Lain - Lain'] as $l)
                                                <option value="{{ $l }}">{{ $l }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div style="width: 80px; flex-shrink: 0;">
                                        <input type="number" x-model="item.amount" 
                                               :name="'items[' + month + '][' + index + '][amount]'"
                                               placeholder="Qty" min="0" required
                                               style="width: 100%; border-radius: 6px; border: 1px solid #e2e8f0; height: 35px; font-size: 13px; padding: 0 5px; text-align: center;">
                                    </div>

                                    <div style="flex-shrink: 0;">
                                        <button type="button" @click="removeRow(month, index)"
                                            style="width: 30px; height: 30px; background: #fc8181; color: #1e293b; font-weight:800; border: none; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s;"
                                            onmouseover="this.style.background='#e53e3e'" 
                                            onmouseout="this.style.background='#fc8181'">
                                            <span style="font-weight: bold;">×</span>
                                        </button>
                                    </div>

                                </div>
                            </template>

                            <div x-show="data[month].length === 0" style="text-align: center; font-style: italic; color: #a0aec0; font-size: 11px; padding: 5px;">
                                Belum ada data leasing
                            </div>
                        </div>

                    </div>
                </template>
            </div>

            <div style="margin-top: 35px; display: flex; gap: 15px;">
                <a href="{{ route('leasing.aktual-aplikasi-in.index') }}" style="flex: 1; padding: 14px; background: #edf2f7; color: #4a5568; text-align: center; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 14px;">Batal</a>
                <button type="button" @click="confirmSubmit()" style="flex: 2; padding: 14px; background: #1a202c; color: #1e293b; font-weight:800; border: none; border-radius: 12px; font-weight: 700; font-size: 14px; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">Simpan Data</button>
            </div>
            
        </form>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function appInForm() {
        const months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        
        // Inisialisasi data kosong untuk setiap bulan
        let initialData = {};
        months.forEach(m => {
            initialData[m] = [];
        });

        return {
            months: months,
            data: initialData,

            // Tambah Baris Baru
            addRow(month) {
                this.data[month].push({
                    id: Date.now() + Math.random(), 
                    leasing: '', 
                    amount: ''
                });
            },

            // Hapus Baris
            removeRow(month, index) {
                this.data[month].splice(index, 1);
            },

            // Validasi & Submit
            confirmSubmit() {
                let hasData = false;
                
                // Cek apakah minimal ada 1 data terisi di bulan apapun
                for (const m of this.months) {
                    for (const row of this.data[m]) {
                        if (row.leasing && row.amount > 0) {
                            hasData = true;
                            break;
                        }
                    }
                    if (hasData) break;
                }

                if (!hasData) {
                    Swal.fire('Peringatan', 'Mohon isi setidaknya satu data Leasing dengan jumlah > 0', 'warning');
                    return;
                }

                Swal.fire({
                    title: 'Simpan Data Aplikasi?',
                    text: "Pastikan semua data per bulan sudah benar.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3182ce',
                    cancelButtonColor: '#e53e3e',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Cek Kembali'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('createAppInForm').submit();
                    }
                });
            }
        }
    }
</script>
@endsection