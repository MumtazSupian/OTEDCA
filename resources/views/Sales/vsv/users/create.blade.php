@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div style="padding: 40px 20px; display: flex; flex-direction: column; align-items: center; min-height: 100vh; background-color: #0f172a;">

    <div style="text-align: center; margin-bottom: 30px;">
        <h2 style="font-weight:800; color:#1e293b; font-weight:800; letter-spacing:1px; text-transform:uppercase; margin:0;">
            TAMBAH USER BARU
        </h2>
        <div style="width: 50px; height: 4px; background: #319795; margin: 10px auto; border-radius: 10px;"></div>
    </div>

    <div style="background: white; width: 100%; box-sizing: border-box; max-width: 700px; padding: 35px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
        
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div style="display: grid; width: 100%; box-sizing: border-box; box-sizing: border-box;  grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="grid-column: span 2;">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-input" required placeholder="Contoh: Budi Santoso">
                </div>

                <div style="grid-column: span 2;">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-input" required placeholder="email@suzuki.com">
                </div>

                <div>
                    <label class="form-label">Cabang Dealer</label>
                    <select name="cabang" class="form-input" required>
                        <option value="" disabled selected>Pilih Cabang...</option>
                        <option value="Cianjur" {{ (isset($user) && $user->cabang == 'Cianjur') ? 'selected' : '' }}>Cianjur</option>
                        <option value="Ciawi" {{ (isset($user) && $user->cabang == 'Ciawi') ? 'selected' : '' }}>Ciawi</option>
                        <option value="Cinere" {{ (isset($user) && $user->cabang == 'Cinere') ? 'selected' : '' }}>Cinere</option>
                        <option value="Cipanas" {{ (isset($user) && $user->cabang == 'Cipanas') ? 'selected' : '' }}>Cipanas</option>
                        <option value="Jatiasih" {{ (isset($user) && $user->cabang == 'Jatiasih') ? 'selected' : '' }}>Jatiasih</option>
                        <option value="HO" {{ (isset($user) && $user->cabang == 'HO') ? 'selected' : '' }}>HO</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Role / Jabatan</label>
                    <select name="role" class="form-input" required>
                        <option value="" disabled selected>Pilih Role...</option>
                        <option value="Admin">Admin</option>
                        <option value="OM">Operation Manager (OM)</option>
                        <option value="BM">Branch Manager (BM)</option>
                        <option value="SH">Sales Head (SH)</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input" required placeholder="Minimal 6 karakter">
                </div>

                <div>
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-input" required placeholder="Ulangi Password">
                </div>
            </div>

            <div style="margin-top: 30px; display: flex; gap: 15px;">
                <a href="{{ route('users.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-save">Simpan User</button>
            </div>
        </form>
    </div>
</div>

<style>
    .form-label { display: block; font-weight: 700; color: #2d3748; margin-bottom: 8px; font-size: 12px; text-transform: uppercase; }
    .form-input { width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px; outline: none; transition: 0.3s; color: #4a5568; background-color: #1e293b; font-weight:800; }
    .form-input:focus { border-color: #319795; box-shadow: 0 0 0 3px rgba(49, 151, 149, 0.2); }
    
    .btn-save { flex: 2; padding: 14px; background: #319795; color: #1e293b; font-weight:800; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; transition: 0.3s; }
    .btn-save:hover { background: #285e61; }
    
    .btn-cancel { flex: 1; padding: 14px; background: #edf2f7; color: #4a5568; text-align: center; border-radius: 10px; text-decoration: none; font-weight: 700; transition: 0.3s; }
    .btn-cancel:hover { background: #e2e8f0; }
</style>
@endsection