<?php

namespace App\Http\Controllers\Sales\vsv;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth; 

class UserController extends Controller
{
    private function isAdmin()
    {
        if (Auth::user()->role !== 'Admin') {
            abort(403, 'Akses Terlarang: Hanya Admin yang dapat mengakses halaman ini.');
        }
    }

    public function index()
    {
        $this->isAdmin(); 
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('sales.vsv.users.index', compact('users'));
    }

    public function create()
    {
        $this->isAdmin(); 
        return view('sales.vsv.users.create');
    }

    public function store(Request $request)
    {
        $this->isAdmin(); 
        
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'cabang'   => 'required|string',
            'role'     => 'required|string|in:Admin,OM,BM,SH',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), 
            'cabang'   => $request->cabang, 
            'role'     => $request->role,   
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $this->isAdmin(); // Cek Admin
        $user = User::findOrFail($id);
        return view('sales.vsv.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->isAdmin(); 
        $user = User::findOrFail($id);

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'cabang' => 'required|string',
            'role'   => 'required|string|in:Admin,OM,BM,SH',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $dataToUpdate = [
            'name'   => $request->name,
            'email'  => $request->email,
            'cabang' => $request->cabang,
            'role'   => $request->role,
        ];

        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
        }

        $user->update($dataToUpdate);

        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $this->isAdmin(); 
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}