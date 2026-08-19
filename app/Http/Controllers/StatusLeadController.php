<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\StatusLead;

class StatusLeadController extends Controller
{
    public function index()
    {
        $statuses = StatusLead::all();
        return view('Sales.leads.status.index', compact('statuses'));
    }

    public function create()
    {
        return view('Sales.leads.status.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_status' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        StatusLead::create([
            'nama_status' => $request->nama_status,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect('/sales/leads/status')->with('success', 'Status berhasil ditambahkan');
    }

    public function edit(StatusLead $status)
    {
        return view('Sales.leads.status.edit', compact('status'));
    }

    public function update(Request $request, StatusLead $status)
    {
        $request->validate([
            'nama_status' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $status->update([
            'nama_status' => $request->nama_status,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect('/sales/leads/status')->with('success', 'Status berhasil diperbarui');
    }

    public function destroy(StatusLead $status)
    {
        $status->delete();
        return redirect('/sales/leads/status')->with('success', 'Status berhasil dihapus');
    }
}
