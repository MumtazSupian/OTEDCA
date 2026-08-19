<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\UnitLead;

class UnitLeadController extends Controller
{
    public function index()
    {
        $units = UnitLead::all();
        return view('Sales.leads.unit.index', compact('units'));
    }

    public function create()
    {
        return view('Sales.leads.unit.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_unit' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        UnitLead::create([
            'nama_unit' => $request->nama_unit,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect('/sales/leads/unit')->with('success', 'Unit berhasil ditambahkan');
    }

    public function edit(UnitLead $unit)
    {
        return view('Sales.leads.unit.edit', compact('unit'));
    }

    public function update(Request $request, UnitLead $unit)
    {
        $request->validate([
            'nama_unit' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $unit->update([
            'nama_unit' => $request->nama_unit,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect('/sales/leads/unit')->with('success', 'Unit berhasil diperbarui');
    }

    public function destroy(UnitLead $unit)
    {
        $unit->delete();
        return redirect('/sales/leads/unit')->with('success', 'Unit berhasil dihapus');
    }
}
