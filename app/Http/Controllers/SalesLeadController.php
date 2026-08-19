<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesLead;

class SalesLeadController extends Controller
{
    public function index($cabang)
    {
        $users = SalesLead::where('cabang', $cabang)->get();
        // Map model fields to user-like fields for the generic view
        $users->map(function($u) {
            $u->name = $u->nama;
            return $u;
        });
        $role = 'sales';
        return view('Sales.leads.shared.role_index', compact('users', 'cabang', 'role'));
    }

    public function create($cabang)
    {
        $role = 'sales';
        return view('Sales.leads.shared.role_create', compact('cabang', 'role'));
    }

    public function store(Request $request, $cabang)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
        ]);
        SalesLead::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'cabang' => $cabang
        ]);
        return redirect('/sales/leads/'.$cabang.'/sales')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($cabang, $id)
    {
        $user = SalesLead::findOrFail($id);
        $role = 'sales';
        return view('Sales.leads.shared.role_edit', compact('user', 'cabang', 'role'));
    }

    public function update(Request $request, $cabang, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
        ]);
        
        $user = SalesLead::findOrFail($id);
        $user->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);
        return redirect('/sales/leads/'.$cabang.'/sales')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($cabang, $id)
    {
        SalesLead::destroy($id);
        return redirect('/sales/leads/'.$cabang.'/sales')->with('success', 'Data berhasil dihapus');
    }
}
