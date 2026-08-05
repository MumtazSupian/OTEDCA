<?php

namespace App\Http\Controllers\Sales\vsv\leasing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales\vsv\leasing\AktualReject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AktualRejectExport;

class AktualRejectController extends Controller
{
    private function getFilteredQuery()
    {
        $user = Auth::user();
        $pusatRoles = ['Admin', 'OM', 'Admin DCA', 'OM DCA'];
        $query = AktualReject::query();

        if (in_array($user->role, $pusatRoles)) {
            return $query;
        } elseif ($user->role === 'BM') {
            return $query->where('cabang', $user->cabang);
        } elseif ($user->role === 'SH') {
            return $query->where('user_id', $user->id);
        }
        return $query->where('cabang', $user->cabang);
    }

    public function index() {
        $data = $this->getFilteredQuery()->get();
        return view('sales.vsv.leasing.aktual_reject.index', compact('data'));
    }

    public function create() {
        // PERUBAHAN DI SINI: Menambahkan role pusat agar bisa akses form tambah
        // Role check relaxed for all authenticated users
        return view('sales.vsv.leasing.aktual_reject.create');
    }

    public function store(Request $request) {
        $user = Auth::user();
        $months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];
        $preparedData = [];

        foreach ($request->items as $month => $rows) {
            if (!in_array($month, $months)) continue;
            foreach ($rows as $row) {
                $leasingName = $row['leasing'] ?? null;
                $amount = (int)($row['amount'] ?? 0);
                if ($leasingName && $amount > 0) {
                    if (!isset($preparedData[$leasingName])) {
                        $preparedData[$leasingName] = array_fill_keys($months, 0);
                    }
                    $preparedData[$leasingName][$month] += $amount;
                }
            }
        }

        try {
            DB::transaction(function () use ($preparedData, $user, $request) {
                foreach ($preparedData as $leasing => $monthlyData) {
                    AktualReject::updateOrCreate(
                        [
                            'cabang' => $user->cabang,
                            'tahun' => $request->tahun,
                            'leasing' => $leasing,
                            'user_id' => $user->id
                        ],
                        array_merge($monthlyData, ['total' => array_sum($monthlyData)])
                    );
                }
            });
            return redirect()->route('leasing.aktual-reject.index')->with('success', 'Data Aktual Reject berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function edit($id) {
        $data = AktualReject::findOrFail($id);
        if (Auth::user()->role === 'SH' && $data->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Akses dilarang.');
        }
        return view('sales.vsv.leasing.aktual_reject.edit', compact('data'));
    }

    public function update(Request $request, $id) {
        $data = AktualReject::findOrFail($id);
        $months = ['jan','feb','mar','apr','mei','jun','jul','agu','sep','okt','nov','des'];
        $data->update(array_merge(
            $request->only(array_merge(['leasing', 'tahun'], $months)),
            ['total' => array_sum($request->only($months))]
        ));
        return redirect()->route('leasing.aktual-reject.index')->with('success', 'Data Reject diperbarui.');
    }

    public function destroy($id) {
        $data = AktualReject::findOrFail($id);
        if (Auth::user()->role === 'SH' && $data->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Akses dilarang.');
        }
        $data->delete();
        return redirect()->back()->with('success', 'Data dihapus.');
    }

    public function exportPdf() {
        $data = $this->getFilteredQuery()->get();
        return Pdf::loadView('leasing.aktual_reject.pdf', compact('data'))
            ->setPaper('a4', 'landscape')->download('Laporan-Aktual-Reject.pdf');
    }

    public function exportExcel() {
        return Excel::download(new AktualRejectExport, 'Aktual-Reject.xlsx');
    }
}