<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    public function index(Request $request)
    {
        // --- KODE SEMENTARA: PINJAM BROWSER UNTUK BIKIN TABEL ---
        \Illuminate\Support\Facades\DB::statement("
            CREATE TABLE IF NOT EXISTS perusahaan (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nama VARCHAR(255) NOT NULL,
                deskripsi TEXT NULL,
                overdue INT DEFAULT 28,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL
            )
        ");

        $search = $request->input('search');
        $query = \App\Models\Perusahaan::query();

        if ($search) {
            $query->where('nama', 'LIKE', "%{$search}%");
        }

        $items = $query->paginate(10);
        return view('admin.perusahaan.index', compact('items', 'search'));
    }

    public function create()
    {
        return view('admin.perusahaan.create');
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
        return view('admin.perusahaan.edit', ['item' => $perusahaan]);
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