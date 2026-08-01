<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use Illuminate\Http\Request;

class CabangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = Cabang::orderBy('nama');
        if (!empty($search)) {
            $query->where('nama', 'like', "%{$search}%");
        }
        $items = $query->paginate(20)->withQueryString();
        return view('admin.cabangs.index', compact('items', 'search'));
    }

    public function create()
    {
        return view('admin.cabangs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
        ]);
        Cabang::create($data);
        return redirect()->route('admin.cabangs.index')->with('success', 'Master Cabang berhasil dibuat.');
    }

    public function edit(Cabang $cabang)
    {
        return view('admin.cabangs.edit', ['item' => $cabang]);
    }

    public function update(Request $request, Cabang $cabang)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
        ]);
        $cabang->update($data);
        return redirect()->route('admin.cabangs.index')->with('success', 'Master Cabang berhasil diperbarui.');
    }

    public function destroy(Cabang $cabang)
    {
        $cabang->delete();
        return redirect()->route('admin.cabangs.index')->with('success', 'Master Cabang dihapus.');
    }
}
