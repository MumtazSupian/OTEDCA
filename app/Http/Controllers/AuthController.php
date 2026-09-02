<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        $inputEmail = strtolower(trim($request->email));
        $user = \App\Models\User::whereRaw('LOWER(email) = ?', [$inputEmail])->first();

        $isPasswordValid = false;

        if ($user) {
            $rawPass = trim($user->password ?? '');
            if (
                strtoupper(md5($request->password)) === strtoupper($rawPass) ||
                $request->password === $rawPass
            ) {
                $isPasswordValid = true;
            } else {
                try {
                    if (
                        \Illuminate\Support\Facades\Hash::check($request->password, $rawPass) ||
                        \Illuminate\Support\Facades\Hash::check(strtoupper(md5($request->password)), $rawPass) ||
                        \Illuminate\Support\Facades\Hash::check(strtolower(md5($request->password)), $rawPass)
                    ) {
                        $isPasswordValid = true;
                    }
                } catch (\Throwable $e) {}
            }
        }

        // Live fallback ke DB Kantor (DMS) jika password lokal belum update / user baru di-reset
        if (!$isPasswordValid) {
            try {
                $dmsUser = \Illuminate\Support\Facades\DB::connection('dms')->table('sysUser')
                    ->whereRaw('LOWER(UserId) = ?', [$inputEmail])
                    ->where('IsActive', 1)
                    ->first();

                if ($dmsUser) {
                    $dmsPass = trim($dmsUser->Password ?? '');
                    if (
                        strtoupper(md5($request->password)) === strtoupper($dmsPass) ||
                        $request->password === $dmsPass ||
                        \Illuminate\Support\Facades\Hash::check($request->password, $dmsPass) ||
                        \Illuminate\Support\Facades\Hash::check(strtoupper(md5($request->password)), $dmsPass)
                    ) {
                        $branchMap = [
                            '641940101' => 'ciawi',
                            '641940102' => 'cianjur',
                            '641940103' => 'cinere',
                            '641940104' => 'jatiasih',
                            '641940105' => 'bp',
                            '641940106' => 'cipanas',
                        ];
                        $cabang = $branchMap[trim($dmsUser->BranchCode ?? '')] ?? null;

                        if (!$user) {
                            $user = new \App\Models\User();
                            $user->email = $inputEmail;
                        }

                        $user->name = trim($dmsUser->FullName) ?: trim($dmsUser->UserId);
                        $user->password = $dmsPass;
                        if ($cabang) {
                            $user->branch = $cabang;
                            $user->cabang = $cabang;
                        }

                        if ($inputEmail === 'dcahounit' || str_contains($inputEmail, 'hounit')) {
                            $user->role = 'ho_unit';
                            $user->is_admin = 0;
                            $user->is_admin_stock = 1;
                        } elseif (str_contains($inputEmail, 'adh')) {
                            $user->role = 'adh';
                            $user->is_admin = 0;
                            $user->is_admin_stock = 0;
                        }

                        $user->save();
                        $isPasswordValid = true;
                    }
                }
            } catch (\Throwable $e) {
                // Ignore DMS connection issue and fallback to invalid credentials
            }
        }

        if ($user && $isPasswordValid) {
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            if ($user->role === 'ho_unit' || strtolower($user->email ?? '') === 'dcahounit') {
                return redirect()->route('sales.dashboard');
            }

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
