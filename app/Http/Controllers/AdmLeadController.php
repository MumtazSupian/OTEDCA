<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;

class AdmLeadController extends Controller
{
    public function index($cabang)
    {
        $leads = Lead::where('cabang', $cabang)->get();
        $role = 'adm';
        return view('Sales.leads.shared.adm_index', compact('leads', 'cabang', 'role'));
    }

    public function create($cabang)
    {
        $role = 'adm';
        return view('Sales.leads.shared.adm_create', compact('cabang', 'role'));
    }

    public function store(Request $request, $cabang)
    {
        $request->validate([
            'no_hp' => 'required|string|max:20',
            'tanggal' => 'required|date',
        ]);
        Lead::create([
            'no_hp' => $request->no_hp,
            'tanggal' => $request->tanggal,
            'cabang' => $cabang
        ]);
        return redirect('/sales/leads/'.$cabang.'/adm')->with('success', 'Lead berhasil ditambahkan');
    }

    public function edit($cabang, $id)
    {
        $lead = Lead::findOrFail($id);
        $role = 'adm';
        return view('Sales.leads.shared.adm_edit', compact('lead', 'cabang', 'role'));
    }

    public function update(Request $request, $cabang, $id)
    {
        $request->validate([
            'no_hp' => 'required|string|max:20',
            'tanggal' => 'required|date',
        ]);
        
        $lead = Lead::findOrFail($id);
        $lead->update([
            'no_hp' => $request->no_hp,
            'tanggal' => $request->tanggal,
        ]);
        return redirect('/sales/leads/'.$cabang.'/adm')->with('success', 'Lead berhasil diupdate');
    }

    public function destroy($cabang, $id)
    {
        Lead::destroy($id);
        return redirect('/sales/leads/'.$cabang.'/adm')->with('success', 'Lead berhasil dihapus');
    }
}
