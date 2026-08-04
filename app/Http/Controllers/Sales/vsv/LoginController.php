<?php

namespace App\Http\Controllers\Sales\vsv;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

   public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'cabang'   => 'required',
            'role'     => 'required',
        ]);

        $user = User::where('name', $request->username)->first();

        if ($user) {
            // Cek Cabang (Dibuat Case-Insensitive dengan strtoupper)
            if (strtoupper($user->cabang) !== strtoupper($request->cabang)) {
                return back()->withErrors(['username' => "Akun tidak terdaftar untuk cabang {$request->cabang}!"])->withInput();
            }

            // Cek Role (Dibuat Case-Insensitive agar sinkron dengan Database)
            $userRoleDB = strtoupper($user->role);
            $roleRequest = strtoupper($request->role);

            if (in_array($roleRequest, ['ADMIN', 'OM'])) {
                if (!in_array($userRoleDB, ['ADMIN', 'OM'])) {
                    return back()->withErrors(['username' => "Akses ditolak! Anda bukan Admin/OM."])->withInput();
                }
            } else {
                if ($userRoleDB !== $roleRequest) {
                    return back()->withErrors(['username' => "Akses ditolak! Role Anda bukan {$request->role}."])->withInput();
                }
            }
        }

        // Gunakan Auth::attempt untuk verifikasi password yang di-hash
        if (Auth::attempt(['name' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['username' => 'Username atau Password salah!'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
