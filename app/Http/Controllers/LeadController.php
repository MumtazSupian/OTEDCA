<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Lead;
use App\Models\SumberLead;
use App\Models\UnitLead;
use App\Models\StatusLead;
use App\Models\ResponLead;
use App\Models\SpvLead;
use App\Models\SalesLead;

class LeadController extends Controller
{
    public function index(Request $request, $cabang)
    {
        $search = $request->input('search');
        
        $query = Lead::where('cabang', $cabang)->latest();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('no_hp', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%");
            });
        }
        
        $leads = $query->paginate(10)->appends(['search' => $search]);
        return view("Sales.leads.{$cabang}.index", compact('leads', 'cabang'));
    }

    public function create($cabang)
    {
        $sumbers = SumberLead::all();
        $units = UnitLead::all();
        $statuses = StatusLead::all();
        $respons = ResponLead::all();
        $spvs = SpvLead::where('cabang', $cabang)->get();
        $salesList = SalesLead::where('cabang', $cabang)->get();
        $role = 'leads';

        return view("Sales.leads.{$cabang}.create", compact(
            'cabang', 'role', 'sumbers', 'units', 'statuses', 'respons', 'spvs', 'salesList'
        ));
    }

    public function store(Request $request, $cabang)
    {
        $request->validate([
            'no_hp' => 'required|string|max:20|unique:leads,no_hp',
            'tanggal' => 'required|date',
            // other fields can be validated here
        ], [
            'no_hp.unique' => 'nomor hp sudah di gunakan',
        ]);

        Lead::create([
            'no_hp' => $request->no_hp,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'tanggal' => $request->tanggal,
            'cabang' => $cabang,
            'sumber_id' => $request->sumber_id,
            'unit_id' => $request->unit_id,
            'status_id' => $request->status_id,
            'respon_id' => $request->respon_id,
            'spv_id' => $request->spv_id,
            'sales_id' => $request->sales_id,
            'update_1' => $request->update_1,
            'update_2' => $request->update_2,
            'update_3' => $request->update_3,
        ]);

        return redirect("/sales/leads/{$cabang}/leads")->with('success', 'Lead berhasil ditambahkan');
    }

    public function edit($cabang, $id)
    {
        $lead = Lead::findOrFail($id);
        $sumbers = SumberLead::all();
        $units = UnitLead::all();
        $statuses = StatusLead::all();
        $respons = ResponLead::all();
        $spvs = SpvLead::where('cabang', $cabang)->get();
        $salesList = SalesLead::where('cabang', $cabang)->get();
        $role = 'leads';

        return view("Sales.leads.shared.edit", compact(
            'lead', 'cabang', 'role', 'sumbers', 'units', 'statuses', 'respons', 'spvs', 'salesList'
        ));
    }

    public function update(Request $request, $cabang, $id)
    {
        $request->validate([
            'no_hp' => 'required|string|max:20|unique:leads,no_hp,' . $id,
            'tanggal' => 'required|date',
        ], [
            'no_hp.unique' => 'nomor hp sudah di gunakan',
        ]);

        $lead = Lead::findOrFail($id);
        $lead->update([
            'no_hp' => $request->no_hp,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'tanggal' => $request->tanggal,
            'sumber_id' => $request->sumber_id,
            'unit_id' => $request->unit_id,
            'status_id' => $request->status_id,
            'respon_id' => $request->respon_id,
            'spv_id' => $request->spv_id,
            'sales_id' => $request->sales_id,
            'update_1' => $request->update_1,
            'update_2' => $request->update_2,
            'update_3' => $request->update_3,
        ]);

        return redirect("/sales/leads/{$cabang}/leads")->with('success', 'Lead berhasil diupdate');
    }

    public function destroy($cabang, $id)
    {
        Lead::destroy($id);
        return redirect("/sales/leads/{$cabang}/leads")->with('success', 'Lead berhasil dihapus');
    }
}
