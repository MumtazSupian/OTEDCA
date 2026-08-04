@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div style="padding: 40px 20px; display: flex; flex-direction: column; align-items: center; min-height: 100vh; background-color: #0f172a;">

    <div style="text-align: center; margin-bottom: 30px;">
        <h2 style="font-weight:800; color:#1e293b; font-weight:800; letter-spacing:1px; text-transform:uppercase; margin:0;">
            EDIT USER
        </h2>
        <div style="width: 50px; height: 4px; background: #d69e2e; margin: 10px auto; border-radius: 10px;"></div>
    </div>

    <div style="background: white; width: 100%; max-width: 700px; padding: 35px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
        
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="grid-column: span 2;">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-input" value="{{ $user->name }}" required>
                </div>

                <div>
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-input" value="{{ $user->email }}" required>
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

                <div style="grid-column: span 2;">
                    <label class="form-label">Role / Jabatan</label>
                    <select name="role" class="form-input" required>
                        <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="OM" {{ $user->role == 'OM' ? 'selected' : '' }}>Operation Manager (OM)</option>
                        <option value="BM" {{ $user->role == 'BM' ? 'selected' : '' }}>Branch Manager (BM)</option>
                        <option value="SH" {{ $user->role == 'SH' ? 'selected' : '' }}>Sales Head (SH)</option>
                    </select>
                </div>

                <div style="grid-column: span 2; border-top: 1px dashed #e2e8f0; margin-top: 10px; padding-top: 20px;">
                    <p style="font-size: 12px; color: #718096; margin-bottom: 15px; font-style: italic;">
                        *Kosongkan password jika tidak ingin mengganti password user.
                    </p>
                </div>

                <div>
                    <label class="form-label">Password Baru (Opsional)</label>
                    <input type="password" name="password" class="form-input" placeholder="********">
                </div>

                <div>
                    <label class="form-label">Ulangi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-input" placeholder="********">
                </div>
            </div>

            <div style="margin-top: 30px; display: flex; gap: 15px;">
                <a href="{{ route('users.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-save" style="background: #d69e2e;">Update User</button>
            </div>
        </form>
    </div>
</div>

<style>
    .form-label { display: block; font-weight: 700; color: #2d3748; margin-bottom: 8px; font-size: 12px; text-transform: uppercase; }
    .form-input { width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px; outline: none; transition: 0.3s; color: #4a5568; }
    .form-input:focus { border-color: #d69e2e; box-shadow: 0 0 0 3px rgba(214, 158, 46, 0.2); }
    
    .btn-save { flex: 2; padding: 14px; color: #1e293b; font-weight:800; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; transition: 0.3s; }
    .btn-save:hover { opacity: 0.9; }
    
    .btn-cancel { flex: 1; padding: 14px; background: #edf2f7; color: #4a5568; text-align: center; border-radius: 10px; text-decoration: none; font-weight: 700; transition: 0.3s; }
    .btn-cancel:hover { background: #e2e8f0; }
</style>
@endsection