<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Sales\Gudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = Gudang::orderBy('nama');
        if (!empty($search)) {
            $query->where('nama', 'like', "%{$search}%");
        }
        $items = $query->paginate(20)->withQueryString();
        return view('sales.gudang.index', compact('items', 'search'));
    }

    public function create()
    {
        return view('sales.gudang.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
        ]);
        Gudang::create($data);
        return redirect()->route('admin.gudangs.index')->with('success', 'Master Gudang berhasil dibuat.');
    }

    public function edit(Gudang $gudang)
    {
        return view('sales.gudang.edit', ['item' => $gudang]);
    }

    public function update(Request $request, Gudang $gudang)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
        ]);
        $gudang->update($data);
        return redirect()->route('admin.gudangs.index')->with('success', 'Master Gudang berhasil diperbarui.');
    }

    public function destroy(Gudang $gudang)
    {
        $gudang->delete();
        return redirect()->route('admin.gudangs.index')->with('success', 'Master Gudang dihapus.');
    }
}
