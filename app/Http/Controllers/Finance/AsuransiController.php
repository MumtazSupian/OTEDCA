<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Asuransi;
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

        return view('finance.ar.asuransi.index', compact('items', 'search'));
    }

    public function create()
    {
        return view('finance.ar.asuransi.create');
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
        return view('finance.ar.asuransi.edit', ['item' => $asuransi]);
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
