<?php

namespace App\Http\Controllers\Sales\vsv\evaluasi;

use App\Http\Controllers\Controller;
use App\Models\Sales\vsv\evaluasi\EvaluasiWiraniaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EvaluasiExport;
use Barryvdh\DomPDF\Facade\Pdf;

class EvaluasiWiraniagaController extends Controller
{
    private function getFilteredQuery()
    {
        $user = Auth::user();
        $pusatRoles = ['Admin', 'OM', 'Admin DCA', 'OM DCA'];
        $query = EvaluasiWiraniaga::query();

        if (in_array($user->role, $pusatRoles)) {
            return $query->orderBy('nama_sales');
        } elseif ($user->role === 'BM') {
            return $query->where('cabang', $user->cabang)->orderBy('nama_sales');
        } elseif ($user->role === 'SH') {
            return $query->where('user_id', $user->id)->orderBy('nama_sales');
        }
        return $query->where('cabang', $user->cabang)->orderBy('nama_sales');
    }

    public function index()
    {
        $data = $this->getFilteredQuery()->get();
        $grandTotal = $data->sum('total');
        return view('sales.vsv.evaluasi.index', compact('data', 'grandTotal'));
    }

    public function create()
    {
        return view('sales.vsv.evaluasi.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        $calculated = $this->calculateTotalAndGrading($request);
        $data['total'] = $calculated['total'];
        $data['grading'] = $calculated['grading'];
        $data['cabang'] = $user->cabang;
        $data['user_id'] = $user->id; 

        EvaluasiWiraniaga::create($data);
        return redirect()->route('evaluasi.index')->with('success', 'Data berhasil disimpan!');
    }

    public function edit($id)
    {
        $row = EvaluasiWiraniaga::findOrFail($id);
        $user = Auth::user();
        
        if ($user->role == 'SH' && $row->user_id != $user->id) {
            return redirect()->route('evaluasi.index')->with('error', 'Akses dilarang!');
        }

        if ($user->role == 'BM' && $row->cabang != $user->cabang) {
            return redirect()->route('evaluasi.index')->with('error', 'Akses dilarang!');
        }

        return view('sales.vsv.evaluasi.edit', compact('row'));
    }

    public function update(Request $request, $id)
    {
        $row = EvaluasiWiraniaga::findOrFail($id);
        $user = Auth::user();

        if ($user->role == 'SH' && $row->user_id != $user->id) {
            return redirect()->route('evaluasi.index')->with('error', 'Update ditolak.');
        }

        $data = $request->all();
        $calculated = $this->calculateTotalAndGrading($request);
        $data['total'] = $calculated['total'];
        $data['grading'] = $calculated['grading'];

        $row->update($data);
        return redirect()->route('evaluasi.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $row = EvaluasiWiraniaga::findOrFail($id);
        if (Auth::user()->role == 'SH' && $row->user_id != Auth::id()) {
            return redirect()->route('evaluasi.index')->with('error', 'Hapus ditolak.');
        }

        $row->delete();
        return redirect()->route('evaluasi.index')->with('success', 'Data berhasil dihapus');
    }

    private function calculateTotalAndGrading($request)
    {
        $months = [
            (int)$request->input('jan', 0),
            (int)$request->input('feb', 0),
            (int)$request->input('mar', 0),
            (int)$request->input('apr', 0),
            (int)$request->input('mei', 0),
            (int)$request->input('jun', 0),
        ];

        $total6Bulan = array_sum($months);
        $firstIdx = -1;
        foreach ($months as $idx => $val) {
            if ($val > 0) {
                $firstIdx = $idx;
                break;
            }
        }

        if ($firstIdx === -1) {
            return ['total' => 0, 'grading' => "TRAINEE -> EVALUASI"];
        }

        $data3BulanAwal = array_slice($months, $firstIdx, 3);
        $total3Awal = array_sum($data3BulanAwal);
        $avg3Awal = $total3Awal / count($data3BulanAwal);

        $data3BulanAkhir = array_slice($months, 3, 3);
        $total3Akhir = array_sum($data3BulanAkhir);
        $avg3Akhir = $total3Akhir / 3;

        $avg6 = $total6Bulan / (6 - $firstIdx);

        if ($avg6 >= 5 && $total6Bulan >= 31) {
            $grading = "PLATINUM";
        } elseif ($avg6 >= 4 && $total6Bulan >= 25) {
            $grading = "GOLD -> KADAR PLATINUM";
        } elseif ($avg3Awal >= 2 || $total3Awal >= 7 || $avg3Akhir >= 2 || $total3Akhir >= 6) {
            $grading = "SILVER -> KADAR GOLD";
        } elseif ($avg3Awal >= 1) {
            $grading = "TRAINEE -> KADAR SILVER";
        } else {
            $grading = "TRAINEE -> EVALUASI";
        }

        return ['total' => $total6Bulan, 'grading' => $grading];
    }

    public function exportExcel()
    {
        return Excel::download(new EvaluasiExport, 'evaluasi-wiraniaga.xlsx');
    }

    public function exportPdf()
    {
        $data = $this->getFilteredQuery()->get();
        $grandTotal = $data->sum('total');
        $pdf = Pdf::loadView('evaluasi.export_pdf', compact('data', 'grandTotal'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('evaluasi-wiraniaga.pdf');
    }
}