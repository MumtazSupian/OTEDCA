<?php

namespace App\Http\Controllers\Sales\faktur;

use App\Http\Controllers\Controller;
use App\Models\Sales\faktur\Faktur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FakturController extends Controller
{
    private $cabangList = ['Ciawi', 'Cianjur', 'Cinere', 'Jatiasih', 'Cipanas'];

    private function getAvailableBranches($user)
    {
        $isPusat = ($user->is_admin ?? false) || 
                   in_array(strtolower(trim($user->branch ?? '')), ['admin', 'pusat']) || 
                   in_array(strtolower(trim($user->role ?? '')), ['admin', 'om', 'admin dca', 'om dca', 'ho_unit']);

        if ($isPusat) {
            return $this->cabangList;
        }

        $userCabang = $user->cabang ?: ($user->branch ?: 'Ciawi');
        return [ucfirst(strtolower($userCabang))];
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $isPusat = ($user->is_admin ?? false) || 
                   in_array(strtolower(trim($user->branch ?? '')), ['admin', 'pusat']) || 
                   in_array(strtolower(trim($user->role ?? '')), ['admin', 'om', 'admin dca', 'om dca', 'ho_unit']);

        $availableBranches = $this->getAvailableBranches($user);

        $bulanMap = Faktur::BULAN_MAP;
        $tipeKendaraanList = Faktur::TIPE_KENDARAAN_LIST;

        $selectedTahun = (int)$request->input('tahun', now()->year);
        $selectedBulan = strtolower($request->input('bulan', ''));
        $selectedCabang = $request->input('cabang', '');
        $selectedTipe = $request->input('tipe_kendaraan', '');
        $search = $request->input('search', '');

        $query = Faktur::query();

        if ($selectedTahun) {
            $query->where('tahun', $selectedTahun);
        }

        if ($selectedBulan && in_array($selectedBulan, $bulanMap)) {
            $query->where('bulan', $selectedBulan);
        }

        if (!$isPusat) {
            $userCabang = $user->cabang ?: ($user->branch ?: 'Ciawi');
            $query->where('cabang', $userCabang);
        } elseif (!empty($selectedCabang)) {
            $query->where('cabang', $selectedCabang);
        }

        if (!empty($selectedTipe)) {
            $query->where('tipe_kendaraan', $selectedTipe);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('tipe_kendaraan', 'like', '%' . $search . '%')
                  ->orWhere('cabang', 'like', '%' . $search . '%')
                  ->orWhere('keterangan', 'like', '%' . $search . '%');
            });
        }

        // Stats calculations
        $totalFakturAll = (int)(clone $query)->sum('jumlah');
        $totalRows = (clone $query)->count();

        $items = $query->orderBy('tahun', 'desc')
            ->orderBy('bulan_angka', 'desc')
            ->orderBy('cabang', 'asc')
            ->orderBy('tipe_kendaraan', 'asc')
            ->paginate(15)
            ->withQueryString();

        return view('Sales.faktur.index', compact(
            'items',
            'isPusat',
            'availableBranches',
            'bulanMap',
            'tipeKendaraanList',
            'selectedTahun',
            'selectedBulan',
            'selectedCabang',
            'selectedTipe',
            'search',
            'totalFakturAll',
            'totalRows'
        ));
    }

    public function create()
    {
        $user = Auth::user();
        $availableBranches = $this->getAvailableBranches($user);
        $tipeKendaraanList = Faktur::TIPE_KENDARAAN_LIST;
        $bulanMap = Faktur::BULAN_MAP;
        $bulanNamaLengkap = Faktur::BULAN_NAMA_LENGKAP;

        return view('Sales.faktur.create', compact(
            'availableBranches',
            'tipeKendaraanList',
            'bulanMap',
            'bulanNamaLengkap'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'tipe_kendaraan' => 'required|string|max:100',
            'bulan'          => 'required|string',
            'tahun'          => 'required|integer|min:2020|max:2035',
            'cabang'         => 'required|string|max:100',
            'jumlah'         => 'required|integer|min:0',
            'keterangan'     => 'nullable|string|max:500',
        ]);

        $bulanStr = strtolower($validated['bulan']);
        $bulanAngka = (int)array_search($bulanStr, Faktur::BULAN_MAP);
        if (!$bulanAngka) {
            $bulanAngka = (int)date('n');
            $bulanStr = Faktur::BULAN_MAP[$bulanAngka] ?? 'jan';
        }

        // Upsert if record for same cabang, tipe_kendaraan, bulan, tahun already exists
        $existing = Faktur::where('cabang', $validated['cabang'])
            ->where('tipe_kendaraan', $validated['tipe_kendaraan'])
            ->where('bulan', $bulanStr)
            ->where('tahun', $validated['tahun'])
            ->first();

        if ($existing) {
            $existing->update([
                'jumlah'     => $validated['jumlah'],
                'keterangan' => $validated['keterangan'] ?? $existing->keterangan,
                'user_id'    => $user->id,
            ]);

            return redirect()->route('sales.faktur.index')->with('success', "Data Faktur {$validated['tipe_kendaraan']} periode " . strtoupper($bulanStr) . " {$validated['tahun']} berhasil diperbarui.");
        }

        Faktur::create([
            'user_id'        => $user->id,
            'cabang'         => $validated['cabang'],
            'tipe_kendaraan' => $validated['tipe_kendaraan'],
            'tahun'          => $validated['tahun'],
            'bulan'          => $bulanStr,
            'bulan_angka'    => $bulanAngka,
            'jumlah'         => $validated['jumlah'],
            'keterangan'     => $validated['keterangan'],
        ]);

        return redirect()->route('sales.faktur.index')->with('success', "Data Faktur {$validated['tipe_kendaraan']} periode " . strtoupper($bulanStr) . " {$validated['tahun']} berhasil ditambahkan.");
    }

    public function edit(string $id)
    {
        $item = Faktur::findOrFail($id);
        $user = Auth::user();
        $availableBranches = $this->getAvailableBranches($user);
        $tipeKendaraanList = Faktur::TIPE_KENDARAAN_LIST;
        $bulanMap = Faktur::BULAN_MAP;
        $bulanNamaLengkap = Faktur::BULAN_NAMA_LENGKAP;

        return view('Sales.faktur.edit', compact(
            'item',
            'availableBranches',
            'tipeKendaraanList',
            'bulanMap',
            'bulanNamaLengkap'
        ));
    }

    public function update(Request $request, string $id)
    {
        $item = Faktur::findOrFail($id);
        $user = Auth::user();

        $validated = $request->validate([
            'tipe_kendaraan' => 'required|string|max:100',
            'bulan'          => 'required|string',
            'tahun'          => 'required|integer|min:2020|max:2035',
            'cabang'         => 'required|string|max:100',
            'jumlah'         => 'required|integer|min:0',
            'keterangan'     => 'nullable|string|max:500',
        ]);

        $bulanStr = strtolower($validated['bulan']);
        $bulanAngka = (int)array_search($bulanStr, Faktur::BULAN_MAP);
        if (!$bulanAngka) {
            $bulanAngka = (int)date('n');
            $bulanStr = Faktur::BULAN_MAP[$bulanAngka] ?? 'jan';
        }

        $item->update([
            'user_id'        => $user->id,
            'cabang'         => $validated['cabang'],
            'tipe_kendaraan' => $validated['tipe_kendaraan'],
            'tahun'          => $validated['tahun'],
            'bulan'          => $bulanStr,
            'bulan_angka'    => $bulanAngka,
            'jumlah'         => $validated['jumlah'],
            'keterangan'     => $validated['keterangan'],
        ]);

        return redirect()->route('sales.faktur.index')->with('success', "Data Faktur {$item->tipe_kendaraan} berhasil diperbarui.");
    }

    public function destroy(string $id)
    {
        $item = Faktur::findOrFail($id);
        $item->delete();

        return redirect()->route('sales.faktur.index')->with('success', "Data Faktur {$item->tipe_kendaraan} berhasil dihapus.");
    }
}
