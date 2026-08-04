<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Sales\Stock;
use App\Models\Sales\Unit;
use App\Models\Sales\Warna;
use App\Models\Sales\Varian;
use App\Models\Sales\Gudang;
use App\Models\Sales\Cabang;
use Illuminate\Http\Request;
use App\Exports\StockExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class StockController extends Controller
{
    public function index(Request $request)
    {
        // Auto-update status 'matching' to 'free' if it's been more than 3 days
        Stock::where('status', 'matching')
             ->where('updated_at', '<', now()->subDays(3))
             ->update(['status' => 'free']);

        $query = $this->buildStockQuery($request);
        $search = $request->input('search');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mobil', 'LIKE', "%{$search}%")
                  ->orWhere('no_do', 'LIKE', "%{$search}%")
                  ->orWhere('norangka', 'LIKE', "%{$search}%");
            });
        }

        // Apply filters coming from header filter controls
        if ($request->filled('tanggal_do')) {
            $query->whereDate('tanggal_do', $request->input('tanggal_do'));
        }
        if ($request->filled('bulan')) {
            $bulan = $request->input('bulan');
            $query->whereMonth('tanggal_do', $bulan);
        }
        if ($request->filled('tahun_filter')) {
            $tahun = $request->input('tahun_filter');
            $query->whereYear('tanggal_do', $tahun);
        }
        if ($request->filled('nama_mobil')) {
            $query->where('nama_mobil', $request->input('nama_mobil'));
        }
        if ($request->filled('varian')) {
            $query->where('varian', $request->input('varian'));
        }
        if ($request->filled('warna')) {
            $query->where('warna', $request->input('warna'));
        }
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->input('tahun'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->filled('lokasi')) {
            $query->where('lokasi', $request->input('lokasi'));
        }
        if ($request->filled('cabang')) {
            $query->where('cabang', $request->input('cabang'));
        }

        $items = $query->orderByDesc('tanggal_do')->orderByDesc('id')->paginate(15)->appends($request->except('page'));

        $gudangOptions = Gudang::orderBy('nama')->pluck('nama', 'nama');
        $namaMobilOptions = Stock::select('nama_mobil')->distinct()->whereNotNull('nama_mobil')->orderBy('nama_mobil')->pluck('nama_mobil');
        $varianOptions = Stock::select('varian')->distinct()->whereNotNull('varian')->orderBy('varian')->pluck('varian');
        $warnaOptions = Stock::select('warna')->distinct()->whereNotNull('warna')->orderBy('warna')->pluck('warna');
        $tahunOptions = Stock::select('tahun')->distinct()->whereNotNull('tahun')->orderBy('tahun')->pluck('tahun');
        $statusOptions = Stock::select('status')->distinct()->whereNotNull('status')->orderBy('status')->pluck('status');
        $lokasiOptions = Stock::select('lokasi')->distinct()->whereNotNull('lokasi')->orderBy('lokasi')->pluck('lokasi');
        $cabangOptions = Stock::select('cabang')->distinct()->whereNotNull('cabang')->orderBy('cabang')->pluck('cabang');
        
        $bulanOptions = collect(range(1, 12))->mapWithKeys(function($bulan) {
            return [$bulan => str_pad($bulan, 2, '0', STR_PAD_LEFT)];
        });
        
        $tahunDoOptions = Stock::selectRaw('YEAR(tanggal_do) as tahun')->distinct()->whereNotNull('tanggal_do')->orderBy('tahun', 'desc')->pluck('tahun');

        $reportMode = false;

        return view('sales.stock.index', compact(
            'items', 'search', 'gudangOptions', 'namaMobilOptions', 'varianOptions', 'warnaOptions', 'tahunOptions', 'statusOptions', 'lokasiOptions', 'cabangOptions', 'bulanOptions', 'tahunDoOptions', 'reportMode'
        ));
    }

    public function report(Request $request)
    {
        $query = $this->buildStockQuery($request, true);
        $search = $request->input('search');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_mobil', 'LIKE', "%{$search}%")
                  ->orWhere('no_do', 'LIKE', "%{$search}%")
                  ->orWhere('norangka', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('tanggal_matching_do')) {
            $query->whereDate('tanggal_matching_do', $request->input('tanggal_matching_do'));
        }
        if ($request->filled('bulan')) {
            $bulan = $request->input('bulan');
            $query->whereMonth('tanggal_matching_do', $bulan);
        }
        if ($request->filled('tahun_filter')) {
            $tahun = $request->input('tahun_filter');
            $query->whereYear('tanggal_matching_do', $tahun);
        }
        if ($request->filled('nama_mobil')) {
            $query->where('nama_mobil', $request->input('nama_mobil'));
        }
        if ($request->filled('varian')) {
            $query->where('varian', $request->input('varian'));
        }
        if ($request->filled('warna')) {
            $query->where('warna', $request->input('warna'));
        }
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->input('tahun'));
        }
        if ($request->filled('lokasi')) {
            $query->where('lokasi', $request->input('lokasi'));
        }
        if ($request->filled('cabang')) {
            $query->where('cabang', $request->input('cabang'));
        }

        $items = $query->orderByDesc('tanggal_do')->orderByDesc('id')->paginate(15)->appends($request->except('page'));

        $gudangOptions = Gudang::orderBy('nama')->pluck('nama', 'nama');
        $namaMobilOptions = Stock::select('nama_mobil')->distinct()->whereNotNull('nama_mobil')->orderBy('nama_mobil')->pluck('nama_mobil');
        $varianOptions = Stock::select('varian')->distinct()->whereNotNull('varian')->orderBy('varian')->pluck('varian');
        $warnaOptions = Stock::select('warna')->distinct()->whereNotNull('warna')->orderBy('warna')->pluck('warna');
        $tahunOptions = Stock::select('tahun')->distinct()->whereNotNull('tahun')->orderBy('tahun')->pluck('tahun');
        $statusOptions = Stock::select('status')->distinct()->whereNotNull('status')->orderBy('status')->pluck('status');
        $lokasiOptions = Stock::select('lokasi')->distinct()->whereNotNull('lokasi')->orderBy('lokasi')->pluck('lokasi');
        $cabangOptions = Stock::select('cabang')->distinct()->whereNotNull('cabang')->orderBy('cabang')->pluck('cabang');
        
        $bulanOptions = collect(range(1, 12))->mapWithKeys(function($bulan) {
            return [$bulan => str_pad($bulan, 2, '0', STR_PAD_LEFT)];
        });
        
        $tahunDoOptions = Stock::selectRaw('YEAR(tanggal_matching_do) as tahun')->distinct()->whereNotNull('tanggal_matching_do')->orderBy('tahun', 'desc')->pluck('tahun');

        $reportMode = true;

        return view('sales.stock.index', compact(
            'items', 'search', 'gudangOptions', 'namaMobilOptions', 'varianOptions', 'warnaOptions', 'tahunOptions', 'statusOptions', 'lokasiOptions', 'cabangOptions', 'bulanOptions', 'tahunDoOptions', 'reportMode'
        ));
    }

    private function buildStockQuery(Request $request, bool $reportMode = false)
    {
        $query = Stock::query();
        $now = now();

        if ($reportMode) {
            $query->where('status', 'sold')
                  ->where(function ($q) use ($now) {
                      $q->whereYear('tanggal_matching_do', '<', $now->year)
                        ->orWhere(function ($q2) use ($now) {
                            $q2->whereYear('tanggal_matching_do', $now->year)
                               ->whereMonth('tanggal_matching_do', '<', $now->month);
                        });
                  });
        } else {
            $query->where(function ($q) use ($now) {
                $q->where('status', '!=', 'sold')
                  ->orWhere(function ($q2) use ($now) {
                      $q2->where('status', 'sold')
                         ->where(function ($sub) use ($now) {
                             $sub->where(function ($dateQuery) use ($now) {
                                     $dateQuery->whereYear('tanggal_do', $now->year)
                                               ->whereMonth('tanggal_do', $now->month);
                                 })
                                 ->orWhere(function ($matchingQuery) use ($now) {
                                     $matchingQuery->whereNotNull('tanggal_matching_do')
                                                   ->whereYear('tanggal_matching_do', $now->year)
                                                   ->whereMonth('tanggal_matching_do', $now->month);
                                 });
                         });
                  });
            });
        }

        if ($reportMode) {
            return $query->orderByDesc('tanggal_matching_do')->orderByDesc('id');
        }

        return $query->orderByDesc('tanggal_do')->orderByDesc('id');
    }

    public function create()
    {
        $namaMobilOptions = Unit::orderBy('nama')->pluck('nama', 'nama');
        $warnaOptions = Warna::orderBy('nama')->pluck('nama', 'nama');
        $varianOptions = Varian::orderBy('nama')->pluck('nama', 'nama');
        $gudangOptions = Gudang::orderBy('nama')->pluck('nama', 'nama');
        $cabangOptions = Cabang::orderBy('nama')->pluck('nama', 'nama');

        return view('sales.stock.create', compact('namaMobilOptions', 'warnaOptions', 'varianOptions', 'gudangOptions', 'cabangOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_do' => 'nullable|string|max:255',
            'tanggal_do' => 'nullable|date',
            'kode_mobil' => 'nullable|string|max:255',
            'nama_mobil' => 'nullable|string|max:255',
            'warna' => 'nullable|string|max:255',
            'tahun' => 'nullable|integer',
            'chassis_code' => 'nullable|string|max:255',
            'norangka' => 'nullable|string|max:255',
            'enginecode' => 'nullable|string|max:255',
            'nomesin' => 'nullable|string|max:255',
            'faktur' => 'nullable|string|max:255',
            'bln_naik_faktur' => 'nullable|string|max:255',
            'harga' => 'nullable|integer',
            'kpt_kf' => 'nullable|integer',
            'acs2' => 'nullable|integer',
            'subsidi' => 'nullable|integer',
            'hpp' => 'nullable|integer',
            'lokasi' => 'nullable|string|max:255',
            'estimasi_unit_masuk_gudang_dca' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'lain_lain' => 'nullable|string|max:255',
            'penjualan' => 'nullable|string|max:255',
            'tanggal_matching_do' => 'nullable|date',
            'cabang' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:255',
            'varian' => 'nullable|string|max:255',
        ]);

        $validated['hpp'] = ($validated['harga'] ?? 0) + ($validated['kpt_kf'] ?? 0) + ($validated['acs2'] ?? 0) - ($validated['subsidi'] ?? 0);

        Stock::create($validated);

        return redirect()->route('admin.stocks.index')
            ->with('success', 'Data stock berhasil ditambahkan.');
    }

    public function edit(Stock $stock)
    {
        $namaMobilOptions = Unit::orderBy('nama')->pluck('nama', 'nama');
        $warnaOptions = Warna::orderBy('nama')->pluck('nama', 'nama');
        $varianOptions = Varian::orderBy('nama')->pluck('nama', 'nama');
        $gudangOptions = Gudang::orderBy('nama')->pluck('nama', 'nama');
        $cabangOptions = Cabang::orderBy('nama')->pluck('nama', 'nama');

        return view('sales.stock.edit', compact('stock', 'namaMobilOptions', 'warnaOptions', 'varianOptions', 'gudangOptions', 'cabangOptions'));
    }

    public function update(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'no_do' => 'nullable|string|max:255',
            'tanggal_do' => 'nullable|date',
            'kode_mobil' => 'nullable|string|max:255',
            'nama_mobil' => 'nullable|string|max:255',
            'warna' => 'nullable|string|max:255',
            'tahun' => 'nullable|integer',
            'chassis_code' => 'nullable|string|max:255',
            'norangka' => 'nullable|string|max:255',
            'enginecode' => 'nullable|string|max:255',
            'nomesin' => 'nullable|string|max:255',
            'faktur' => 'nullable|string|max:255',
            'bln_naik_faktur' => 'nullable|string|max:255',
            'harga' => 'nullable|integer',
            'kpt_kf' => 'nullable|integer',
            'acs2' => 'nullable|integer',
            'subsidi' => 'nullable|integer',
            'hpp' => 'nullable|integer',
            'lokasi' => 'nullable|string|max:255',
            'estimasi_unit_masuk_gudang_dca' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'lain_lain' => 'nullable|string|max:255',
            'penjualan' => 'nullable|string|max:255',
            'tanggal_matching_do' => 'nullable|date',
            'cabang' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:255',
            'varian' => 'nullable|string|max:255',
        ]);

        $validated['hpp'] = ($validated['harga'] ?? 0) + ($validated['kpt_kf'] ?? 0) + ($validated['acs2'] ?? 0) - ($validated['subsidi'] ?? 0);

        $stock->update($validated);

        return redirect()->route('admin.stocks.index')
            ->with('success', 'Data stock berhasil diperbarui.');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();

        return redirect()->route('admin.stocks.index')
            ->with('success', 'Data stock berhasil dihapus.');
    }

    public function exportExcel(Request $request)
    {
        $items = $this->buildStockQuery($request)->orderByDesc('tanggal_do')->orderByDesc('id')->get();
        return Excel::download(new StockExport($items), 'stock.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $items = $this->buildStockQuery($request)->get();
        $title = 'Laporan Data Stock';
        $pdf = Pdf::loadView('sales.stock.pdf', compact('items', 'title'))->setPaper('a4', 'landscape');
        return $pdf->download('stock.pdf');
    }

    public function print(Request $request)
    {
        $items = $this->buildStockQuery($request)->orderByDesc('tanggal_do')->orderByDesc('id')->get();
        return view('sales.stock.print', compact('items'));
    }

    public function exportReportExcel(Request $request)
    {
        $items = $this->buildStockQuery($request, true)->orderByDesc('tanggal_do')->orderByDesc('id')->get();
        return Excel::download(new StockExport($items), 'stock-report.xlsx');
    }

    public function exportReportPdf(Request $request)
    {
        $items = $this->buildStockQuery($request, true)->orderByDesc('tanggal_do')->orderByDesc('id')->get();
        $title = 'Laporan Stock SOLD Bulan Lalu';
        $pdf = Pdf::loadView('sales.stock.pdf', compact('items', 'title'))->setPaper('a4', 'landscape');
        return $pdf->download('stock-report.pdf');
    }
}
