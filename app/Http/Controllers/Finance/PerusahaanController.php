<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Perusahaan::query();

        if ($search) {
            $query->where('nama', 'LIKE', "%{$search}%");
        }

        $items = $query->paginate(10);
        return view('finance.ar.perusahaan.index', compact('items', 'search'));
    }

    public function create()
    {
        return view('finance.ar.perusahaan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'overdue' => 'required|integer|min:1',
        ]);

        Perusahaan::create($validated);

        return redirect()->route('admin.perusahaan.index')
            ->with('success', 'Data perusahaan berhasil ditambahkan.');
    }

    public function edit(Perusahaan $perusahaan)
    {
        return view('finance.ar.perusahaan.edit', ['item' => $perusahaan]);
    }

    public function update(Request $request, Perusahaan $perusahaan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'overdue' => 'required|integer|min:1',
        ]);

        $perusahaan->update($validated);

        return redirect()->route('admin.perusahaan.index')
            ->with('success', 'Data perusahaan berhasil diperbarui.');
    }

    public function destroy(Perusahaan $perusahaan)
    {
        $perusahaan->delete();

        return redirect()->route('admin.perusahaan.index')
            ->with('success', 'Data perusahaan berhasil dihapus.');
    }
}
