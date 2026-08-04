<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Sales\Unit;
use App\Models\Sales\Varian;
use Illuminate\Http\Request;

class VarianController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = Varian::with('unit')->orderBy('nama');

        if (! empty($search)) {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        $items = $query->paginate(20)->withQueryString();

        return view('sales.varian.index', compact('items', 'search'));
    }

    public function create()
    {
        $units = Unit::orderBy('nama')->get();
        return view('sales.varian.create', compact('units'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'unit_id'   => 'required|exists:units,id',
        ]);

        Varian::create($data);

        return redirect()->route('admin.varians.index')->with('success', 'Master Varian berhasil dibuat.');
    }

    public function edit(Varian $varian)
    {
        $units = Unit::orderBy('nama')->get();
        return view('sales.varian.edit', ['item' => $varian, 'units' => $units]);
    }

    public function update(Request $request, Varian $varian)
    {
        $data = $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'unit_id'   => 'required|exists:units,id',
        ]);

        $varian->update($data);

        return redirect()->route('admin.varians.index')->with('success', 'Master Varian berhasil diperbarui.');
    }

    public function destroy(Varian $varian)
    {
        $varian->delete();
        return redirect()->route('admin.varians.index')->with('success', 'Master Varian dihapus.');
    }
}
