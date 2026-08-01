<?php

namespace App\Http\Controllers;

use App\Models\Asuransi;
use Illuminate\Http\Request;

class AsuransiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = Asuransi::orderBy('nama');

        if (! empty($search)) {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        $items = $query->paginate(20)->withQueryString();

        return view('admin.asuransi.index', compact('items', 'search'));
    }

    public function create()
    {
        return view('admin.asuransi.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Asuransi::create($data);

        return redirect()->route('admin.asuransi.index')->with('success', 'Asuransi berhasil dibuat.');
    }

    public function edit(Asuransi $asuransi)
    {
        return view('admin.asuransi.edit', ['item' => $asuransi]);
    }

    public function update(Request $request, Asuransi $asuransi)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $asuransi->update($data);

        return redirect()->route('admin.asuransi.index')->with('success', 'Asuransi berhasil diperbarui.');
    }

    public function destroy(Asuransi $asuransi)
    {
        $asuransi->delete();
        return redirect()->route('admin.asuransi.index')->with('success', 'Asuransi dihapus.');
    }
}
