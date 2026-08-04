<link rel="icon" type="image/jpeg" href="{{ asset('assets/img/suzuki-icon.jpeg') }}">
<link rel="shortcut icon" type="image/jpeg" href="{{ asset('assets/img/suzuki-icon.jpeg') }}">

<div style="background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%); min-height: 100vh; display: flex; justify-content: center; align-items: center; font-family: 'Inter', system-ui, -apple-system, sans-serif; margin: 0; padding: 20px;">
    <div
        style="background: #ffffff; width: 100%; max-width: 500px; border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15); overflow: hidden; display: flex; flex-direction: column;">

        <div
            style="background: #001e50; padding: 25px 40px; display: flex; justify-content: space-between; align-items: center; border-bottom: 4px solid #ef4444;">
            <div>
                <h1 style="color: #ffffff; font-size: 24px; font-weight: 900; margin: 0; letter-spacing: 1px;">DCA SYSTEM
                </h1>
                <p style="font-size: 13px; color: #475569; margin: 0; font-weight: 500;">Vehicle Sales Volume Report</p>
            </div>
            <div style="text-align: right;">
                <p
                    style="font-size: 10px; color: #ffffff; opacity: 0.8; text-transform: uppercase; letter-spacing: 2px; margin: 0;">
                    PT. Duta Cendana Adimandiri</p>
                <div style="font-size: 11px; color: #ef4444; font-weight: bold; margin-top: 4px;">OFFICIAL LOGIN</div>
            </div>
        </div>

        <form action="{{ url('/login') }}" method="POST" style="padding: 30px 40px;">
            @csrf

            @if ($errors->any())
                <div
                    style="background: #fef2f2; color: #dc2626; padding: 12px 15px; margin-bottom: 20px; font-size: 13px; border-radius: 8px; border: 1px solid #fee2e2; display: flex; align-items: center; gap: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z" />
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <div style="display: flex; flex-direction: column; gap: 20px;">

                <div>
                    <label
                        style="display: block; font-size: 12px; font-weight: 800; margin-bottom: 8px; color: #475569; text-transform: uppercase;">Cabang</label>
                    <select name="cabang" required
                        style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; background: #f8fafc; font-size: 15px; outline: none; cursor: pointer; color: #1e293b;">
                        <option value="" disabled selected>Pilih Cabang</option>
                        <option value="Cianjur" {{ old('cabang') == 'Cianjur' ? 'selected' : '' }}>CIANJUR</option>
                        <option value="Ciawi" {{ old('cabang') == 'Ciawi' ? 'selected' : '' }}>CIAWI</option>
                        <option value="Cinere" {{ old('cabang') == 'Cinere' ? 'selected' : '' }}>CINERE</option>
                        <option value="Cipanas" {{ old('cabang') == 'Cipanas' ? 'selected' : '' }}>CIPANAS</option>
                        <option value="Jatiasih" {{ old('cabang') == 'Jatiasih' ? 'selected' : '' }}>JATIASIH</option>
                        <option value="HO" {{ old('cabang') == 'HO' ? 'selected' : '' }}>HO</option>
                    </select>
                </div> 

                <div>
                    <label
                        style="display: block; font-size: 12px; font-weight: 800; margin-bottom: 8px; color: #475569; text-transform: uppercase;">Role</label>
                    <select name="role" required
                        style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; background: #f8fafc; font-size: 15px; outline: none; color: #1e293b; cursor: pointer;">
                        <option value="" disabled selected>Pilih Role</option>
                        <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin (Administrator)</option>
                        <option value="OM" {{ old('role') == 'OM' ? 'selected' : '' }}>OM (Operation Manager)</option>
                        <option value="BM" {{ old('role') == 'BM' ? 'selected' : '' }}>BM (Branch Manager)</option>
                        <option value="SH" {{ old('role') == 'SH' ? 'selected' : '' }}>SH (Sales Head)</option>
                    </select>
                </div>

                <div>
                    <label
                        style="display: block; font-size: 12px; font-weight: 800; margin-bottom: 8px; color: #475569; text-transform: uppercase;">User</label>
                    <input type="text" name="username" value="{{ old('username') }}" required
                        placeholder="Masukkan Username"
                        style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; background: #f8fafc; box-sizing: border-box; font-size: 15px; outline: none; color: #1e293b;">
                </div>

                <div>
                    <label
                        style="display: block; font-size: 12px; font-weight: 800; margin-bottom: 8px; color: #475569; text-transform: uppercase;">Password</label>
                    <input type="password" name="password" required placeholder="••••••••"
                        style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; background: #f8fafc; box-sizing: border-box; font-size: 15px; outline: none; color: #1e293b;">
                </div>
            </div>

            <div
                style="display: flex; align-items: center; gap: 20px; margin-top: 30px; border-top: 1px solid #f1f5f9; padding-top: 25px;">
                <button type="submit"
                    style="flex: 2; background: #ef4444; color: #1e293b; font-weight:800; padding: 15px; border: none; border-radius: 10px; font-weight: 800; cursor: pointer; font-size: 15px; text-transform: uppercase; letter-spacing: 1px; transition: all 0.3s ease; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);"
                    onmouseover="this.style.background='#dc2626'; this.style.transform='translateY(-2px)';"
                    onmouseout="this.style.background='#ef4444'; this.style.transform='translateY(0)';">
                    Masuk ke System
                </button>
                <div
                    style="flex: 1; font-size: 10px; color: #475569; line-height: 1.4; border-left: 2px solid #e2e8f0; padding-left: 15px;">
                    Gunakan kredensial yang telah didaftarkan oleh Admin pusat.
                </div>
            </div>
        </form>
    </div>
</div>
