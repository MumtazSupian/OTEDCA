<?php

namespace App\Http\Controllers\Sales\vsv\rka;

use App\Http\Controllers\Controller;
use App\Models\Sales\vsv\rka\TargetSalesforce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\TargetSalesforceExport;

class TargetSalesforceController extends Controller
{
    private function getFilteredQuery()
    {
        $user = Auth::user();
        $pusatRoles = ['Admin', 'OM', 'Admin DCA', 'OM DCA'];
        
        // Tambahkan with('user') untuk optimasi pemanggilan nama penginput
        $query = TargetSalesforce::with('user');

        if (in_array($user->role, $pusatRoles)) {
            return $query;
        } elseif ($user->role === 'BM') {
            return $query->where('cabang', $user->cabang);
        } elseif ($user->role === 'SH') {
            return $query->where('user_id', $user->id);
        }

        return $query->where('cabang', $user->cabang);
    }

    public function index()
    {
        $data = $this->getFilteredQuery()->get();
        return view('sales.vsv.rka.target_salesforces.index', compact('data'));
    }

    public function create()
    {
        if (!in_array(Auth::user()->role, ['BM', 'SH', 'Admin', 'OM', 'Admin DCA', 'OM DCA'])) {
            return redirect()->route('rka.target-salesforces.index')->with('error', 'Akses ditolak.');
        }
        return view('sales.vsv.rka.target_salesforces.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['BM', 'SH', 'Admin', 'OM', 'Admin DCA', 'OM DCA'])) {
            return redirect()->route('rka.target-salesforces.index')->with('error', 'Akses dilarang.');
        }

        $months = ['jan','feb','mar','apr','mei','jun','jul','agu','sep','okt','nov','des'];
        
        $data = [
            'grading' => $request->grading, 
            'tahun'   => $request->tahun, 
            'cabang'  => $user->cabang,
            'user_id' => $user->id 
        ];

        $total = 0;
        foreach ($months as $m) {
            $value = $request->$m ?? 0;
            $data[$m] = $value;
            $total += $value;
        }
        $data['total'] = $total;

        TargetSalesforce::create($data);
        return redirect()->route('rka.target-salesforces.index')->with('success', 'Data berhasil disimpan');
    }

    public function edit($id)
    {
        $row = TargetSalesforce::findOrFail($id);
        $user = Auth::user();

        if ($user->role === 'SH' && $row->user_id != $user->id) {
            return redirect()->route('rka.target-salesforces.index')->with('error', 'Anda hanya boleh mengedit data milik sendiri.');
        }
        
        if ($user->role === 'BM' && $row->cabang != $user->cabang) {
            return redirect()->route('rka.target-salesforces.index')->with('error', 'Akses dilarang.');
        }

        return view('sales.vsv.rka.target_salesforces.edit', compact('row'));
    }

    public function update(Request $request, $id)
    {
        $row = TargetSalesforce::findOrFail($id);
        $user = Auth::user();

        if (($user->role === 'SH' && $row->user_id != $user->id) || ($user->role === 'BM' && $row->cabang != $user->cabang)) {
            return redirect()->route('rka.target-salesforces.index')->with('error', 'Akses dilarang.');
        }

        $months = ['jan','feb','mar','apr','mei','jun','jul','agu','sep','okt','nov','des'];
        $data = ['grading' => $request->grading, 'tahun' => $request->tahun];

        $total = 0;
        foreach ($months as $m) {
            $value = $request->$m ?? 0;
            $data[$m] = $value;
            $total += $value;
        }
        $data['total'] = $total;

        $row->update($data);
        return redirect()->route('rka.target-salesforces.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $row = TargetSalesforce::findOrFail($id);
        $user = Auth::user();

        if (($user->role === 'SH' && $row->user_id != $user->id) || ($user->role === 'BM' && $row->cabang != $user->cabang)) {
            return redirect()->route('rka.target-salesforces.index')->with('error', 'Akses dilarang.');
        }

        $row->delete();
        return redirect()->route('rka.target-salesforces.index')->with('success', 'Data berhasil dihapus');
    }

    public function exportPdf()
    {
        $data = $this->getFilteredQuery()->get();
        $pdf = Pdf::loadView('rka.target_salesforces.pdf', compact('data'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Target-Salesforce.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new TargetSalesforceExport, 'Target-Salesforce.xlsx');
    }
}