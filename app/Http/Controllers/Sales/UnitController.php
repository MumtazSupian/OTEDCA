<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Sales\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = Unit::orderBy('nama');

        if (! empty($search)) {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        $items = $query->paginate(20)->withQueryString();

        return view('sales.unit.index', compact('items', 'search'));
    }

    public function create()
    {
        return view('sales.unit.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Unit::create($data);

        return redirect()->route('admin.units.index')->with('success', 'Master Unit berhasil dibuat.');
    }

    public function edit(Unit $unit)
    {
        return view('sales.unit.edit', ['item' => $unit]);
    }

    public function update(Request $request, Unit $unit)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $unit->update($data);

        return redirect()->route('admin.units.index')->with('success', 'Master Unit berhasil diperbarui.');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('admin.units.index')->with('success', 'Master Unit dihapus.');
    }
}
