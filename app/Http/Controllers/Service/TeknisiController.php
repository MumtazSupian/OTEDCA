<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Teknisi;

class TeknisiController extends Controller
{
    public function index()
    {
        $teknisis = Teknisi::all();
        return view('service.service_ac.ac.teknisi.index', compact('teknisis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Teknisi::create([
            'nama' => $request->nama,
        ]);

        return redirect()->back()->with('success', 'Teknisi berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $teknisi = Teknisi::findOrFail($id);
        $teknisi->update([
            'nama' => $request->nama,
        ]);

        return redirect()->back()->with('success', 'Teknisi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $teknisi = Teknisi::findOrFail($id);
        $teknisi->delete();

        return redirect()->back()->with('success', 'Teknisi berhasil dihapus');
    }
}
