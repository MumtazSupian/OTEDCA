<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpvLead;

class SpvLeadController extends Controller
{
    public function index($cabang)
    {
        $users = SpvLead::where('cabang', $cabang)->get();
        // Map model fields to user-like fields for the generic view
        $users->map(function($u) {
            $u->name = $u->nama;
            return $u;
        });
        $role = 'spv';
        return view('Sales.leads.shared.role_index', compact('users', 'cabang', 'role'));
    }

    public function create($cabang)
    {
        $role = 'spv';
        return view('Sales.leads.shared.role_create', compact('cabang', 'role'));
    }

    public function store(Request $request, $cabang)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
        ]);
        SpvLead::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'cabang' => $cabang
        ]);
        return redirect('/sales/leads/'.$cabang.'/spv')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($cabang, $id)
    {
        $user = SpvLead::findOrFail($id);
        $role = 'spv';
        return view('Sales.leads.shared.role_edit', compact('user', 'cabang', 'role'));
    }

    public function update(Request $request, $cabang, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
        ]);
        
        $user = SpvLead::findOrFail($id);
        $user->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);
        return redirect('/sales/leads/'.$cabang.'/spv')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($cabang, $id)
    {
        SpvLead::destroy($id);
        return redirect('/sales/leads/'.$cabang.'/spv')->with('success', 'Data berhasil dihapus');
    }
}
