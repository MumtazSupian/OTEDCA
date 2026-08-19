<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SumberLead;

class SumberLeadController extends Controller
{
    public function index()
    {
        $sumbers = SumberLead::all();
        return view('Sales.leads.sumber.index', compact('sumbers'));
    }

    public function create()
    {
        return view('Sales.leads.sumber.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sumber' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        SumberLead::create([
            'nama_sumber' => $request->nama_sumber,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect('/sales/leads/sumber')->with('success', 'Sumber berhasil ditambahkan');
    }

    public function edit(SumberLead $sumber)
    {
        return view('Sales.leads.sumber.edit', compact('sumber'));
    }

    public function update(Request $request, SumberLead $sumber)
    {
        $request->validate([
            'nama_sumber' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $sumber->update([
            'nama_sumber' => $request->nama_sumber,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect('/sales/leads/sumber')->with('success', 'Sumber berhasil diperbarui');
    }

    public function destroy(SumberLead $sumber)
    {
        $sumber->delete();
        return redirect('/sales/leads/sumber')->with('success', 'Sumber berhasil dihapus');
    }
}
