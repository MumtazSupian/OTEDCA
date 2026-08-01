@extends('layouts.app')

@section('content')
<style>
    /* Kontainer untuk memaksa form berada tepat di tengah halaman */
    .form-center-wrapper {
        display: flex;
        justify-content: center; /* Mengetengahkan secara horizontal */
        align-items: center;     /* Mengetengahkan secara vertikal */
        width: 100%;
        min-height: 70vh;        /* Memberi ruang vertikal agar terlihat pas di tengah */
        padding: 20px 0;
    }

    /* Desain Kartu Utama yang Lebar & Elegan */
    .bright-card-large {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        width: 100%;
        max-width: 950px; /* Lebar maksimal yang ideal dan proporsional */
    }
    
    /* Grid System untuk membagi 2 kolom input */
    .form-grid-two-col {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }

    /* Input tertentu mengambil 1 baris penuh di bawah */
    .full-width-field {
        grid-column: span 2;
    }
    
    /* Desain Teks Label */
    .field-label {
        font-size: 14px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 8px;
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    /* Memaksa input box berwarna putih bersih dan teks gelap */
    .custom-input {
        background: #ffffff !important;
        color: #0f172a !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 10px !important;
        padding: 12px 16px !important;
        width: 100%;
        font-size: 15px;
        transition: all 0.2s ease-in-out;
        box-sizing: border-box;
    }
    
    /* Efek fokus saat input diklik */
    .custom-input:focus {
        border-color: #2563eb !important;
        outline: none;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15) !important;
        background: #f8fafc !important;
    }

    /* Box Khusus untuk Checkbox Admin */
    .checkbox-container {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        font-size: 15px;
        color: #1e293b !important;
        font-weight: 500;
        padding: 12px 16px;
        background: #f8fafc;
        border-radius: 10px;
        border: 1px dashed #cbd5e1;
        width: fit-content;
    }

    /* Baris Tombol di bagian bawah */
    .form-actions-container {
        display: flex;
        gap: 16px;
        justify-content: flex-end;
        margin-top: 32px;
        border-top: 1px solid #f1f5f9;
        padding-top: 24px;
    }

    /* Responsive untuk resolusi layar handphone / kecil */
    @media (max-width: 768px) {
        .form-grid-two-col {
            grid-template-columns: 1fr;
        }
        .full-width-field {
            grid-column: span 1;
        }
    }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">Buat User</h1>
        <p class="page-subtitle">Tambahkan pengguna baru ke dalam sistem manajemen.</p>
    </div>
</div>

<div class="form-center-wrapper">
    
    <div class="bright-card-large">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            
            <div class="form-grid-two-col">
                
                <div class="form-group">
                    <label class="field-label">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="custom-input" placeholder="Masukkan nama lengkap user" required>
                    @error('name')
                        <span style="color: #ef4444; font-size: 13px; margin-top: 6px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="field-label">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="custom-input" placeholder="contoh@domain.com" required>
                    @error('email')
                        <span style="color: #ef4444; font-size: 13px; margin-top: 6px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="field-label">Password Keamanan</label>
                    <input type="password" name="password" class="custom-input" placeholder="Minimal 8 karakter" required>
                    @error('password')
                        <span style="color: #ef4444; font-size: 13px; margin-top: 6px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="field-label">Cabang / Branch</label>
                    <input type="text" name="branch" value="{{ old('branch') }}" class="custom-input" placeholder="Masukkan nama kantor cabang">
                    @error('branch')
                        <span style="color: #ef4444; font-size: 13px; margin-top: 6px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-actions-container">
                <a href="{{ route('admin.users.index') }}" class="btn-secondary" style="border: 1px solid #cbd5e1; padding: 12px 24px; border-radius: 10px; font-weight: 500;">
                    Batal
                </a>
                <button type="submit" class="btn-primary" style="padding: 12px 28px; border-radius: 10px; font-weight: 600;">
                    Simpan Pengguna Baru
                </button>
            </div>
        </form>
    </div>

</div>
@endsection