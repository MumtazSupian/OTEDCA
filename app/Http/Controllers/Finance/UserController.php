<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $items = User::orderBy('branch')->paginate(20);
        return view('finance.ar.users.index', compact('items'));
    }

    public function create()
    {
        return view('finance.ar.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'branch' => 'nullable|string',
            'is_admin' => 'sometimes|boolean',
        ]);

        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'User dibuat.');
    }

    public function edit(User $user)
    {
        return view('finance.ar.users.edit', ['item' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'branch' => 'nullable|string',
            'is_admin' => 'sometimes|boolean',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User dihapus.');
    }
}
