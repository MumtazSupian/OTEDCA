<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ResponLead;

class ResponLeadController extends Controller
{
    public function index()
    {
        $respons = ResponLead::all();
        return view('Sales.leads.respon.index', compact('respons'));
    }

    public function create()
    {
        return view('Sales.leads.respon.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_respon' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        ResponLead::create([
            'nama_respon' => $request->nama_respon,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect('/sales/leads/respon')->with('success', 'Respon berhasil ditambahkan');
    }

    public function edit(ResponLead $respon)
    {
        return view('Sales.leads.respon.edit', compact('respon'));
    }

    public function update(Request $request, ResponLead $respon)
    {
        $request->validate([
            'nama_respon' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $respon->update([
            'nama_respon' => $request->nama_respon,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect('/sales/leads/respon')->with('success', 'Respon berhasil diperbarui');
    }

    public function destroy(ResponLead $respon)
    {
        $respon->delete();
        return redirect('/sales/leads/respon')->with('success', 'Respon berhasil dihapus');
    }
}
