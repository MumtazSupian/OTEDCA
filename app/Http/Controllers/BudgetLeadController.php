<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\BudgetLead;
use App\Models\SumberLead;

class BudgetLeadController extends Controller
{
    public function index()
    {
        $budgets = BudgetLead::with('sumber')->get();
        return view('Sales.leads.budget.index', compact('budgets'));
    }

    public function create()
    {
        $sumbers = SumberLead::all();
        return view('Sales.leads.budget.create', compact('sumbers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sumber_id' => 'required|exists:sumber_leads,id',
            'budget' => 'required|string',
            'bulan' => 'required|string',
        ]);

        BudgetLead::create([
            'sumber_id' => $request->sumber_id,
            'budget' => str_replace(['.', ','], '', $request->budget), // ensure formatting is stripped just in case
            'bulan' => $request->bulan,
        ]);

        return redirect('/sales/leads/budget')->with('success', 'Budget berhasil ditambahkan');
    }

    public function edit(BudgetLead $budget)
    {
        $sumbers = SumberLead::all();
        return view('Sales.leads.budget.edit', compact('budget', 'sumbers'));
    }

    public function update(Request $request, BudgetLead $budget)
    {
        $request->validate([
            'sumber_id' => 'required|exists:sumber_leads,id',
            'budget' => 'required|string',
            'bulan' => 'required|string',
        ]);

        $budget->update([
            'sumber_id' => $request->sumber_id,
            'budget' => str_replace(['.', ','], '', $request->budget),
            'bulan' => $request->bulan,
        ]);

        return redirect('/sales/leads/budget')->with('success', 'Budget berhasil diperbarui');
    }

    public function destroy(BudgetLead $budget)
    {
        $budget->delete();
        return redirect('/sales/leads/budget')->with('success', 'Budget berhasil dihapus');
    }
}
