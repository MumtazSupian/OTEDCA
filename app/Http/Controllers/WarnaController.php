<?php

namespace App\Http\Controllers;

use App\Models\Warna;
use Illuminate\Http\Request;

class WarnaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = Warna::orderBy('nama');

        if (! empty($search)) {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        $items = $query->paginate(20)->withQueryString();

        return view('admin.warnas.index', compact('items', 'search'));
    }

    public function create()
    {
        return view('admin.warnas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Warna::create($data);

        return redirect()->route('admin.warnas.index')->with('success', 'Master Warna berhasil dibuat.');
    }

    public function edit(Warna $warna)
    {
        return view('admin.warnas.edit', ['item' => $warna]);
    }

    public function update(Request $request, Warna $warna)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $warna->update($data);

        return redirect()->route('admin.warnas.index')->with('success', 'Master Warna berhasil diperbarui.');
    }

    public function destroy(Warna $warna)
    {
        $warna->delete();
        return redirect()->route('admin.warnas.index')->with('success', 'Master Warna dihapus.');
    }
}
