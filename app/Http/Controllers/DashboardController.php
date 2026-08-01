<?php

namespace App\Http\Controllers;

use App\Models\Piutang;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (! empty($user) && ($user->is_admin ?? false)) {
            $records = Piutang::orderByDesc('id')->get();
        } else {
            // Ditambahkan fallback ?? '' agar tidak error jika branch kosong/null
            $records = Piutang::where('branch', $user->branch ?? '')->orderByDesc('id')->get();
        }

        $branchFilter = strtolower(request()->query('branch', ''));
        $allowedBranches = ['bp', 'cinere', 'jatiasih', 'cianjur', 'ciawi'];
        $selectedBranch = in_array($branchFilter, $allowedBranches, true) ? $branchFilter : null;
        $filteredRecords = $selectedBranch ? $records->where('branch', $selectedBranch) : $records;

        $totalPiutang = $records->sum('saldo_akhir');
        $totalKonsumen = $records->map(function ($r) {
            return $r->no_spk ?: $r->nama_konsumen;
        })->filter()->unique()->count();
        
        $totalAsuransi = $records->where('spk_type', 'ASURANSI')->count();
        $totalDebet = $records->sum('debet');
        $totalKredit = $records->sum('kredit');
        
        $bpInsuranceTotals = Piutang::where('branch', 'bp')
            ->where('spk_type', 'ASURANSI')
            ->whereNotNull('nama_asuransi')
            ->where('nama_asuransi', '<>', '')
            ->selectRaw('nama_asuransi, COUNT(*) as total')
            ->groupBy('nama_asuransi')
            ->orderByDesc('total')
            ->get();
            
        $grBranchCount = $records->where('branch', '!=', 'bp')->pluck('branch')->unique()->count();
        $totalSelisih = $records->sum(function ($item) {
            return ($item->saldo_awal + $item->debet - $item->kredit) - $item->saldo_akhir;
        });
        
        $branchSummaries = $records->groupBy('branch')->map(function ($group, $branch) {
            return [
                'count' => $group->count(),
                'saldo_akhir' => $group->sum('saldo_akhir'),
                'debet' => $group->sum('debet'),
                'kredit' => $group->sum('kredit'),
            ];
        })->sortByDesc(function ($summary) {
            return $summary['count'];
        })->toArray();

        $totalStock = 0;
        $stockByStatus = [];
        $stockByMobil = collect();

        if (! empty($user) && (($user->is_admin ?? false) || ($user->is_admin_stock ?? false))) {
            $parseStockDate = function ($value) {
                // Jika sudah Carbon instance (dari model cast), return langsung
                if ($value instanceof \Carbon\Carbon) {
                    return $value;
                }

                if (empty($value) || ! is_string($value)) {
                    return null;
                }

                $value = trim($value);
                if ($value === '' || preg_match('/^\d+$/', $value)) {
                    return null;
                }

                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
                    return \Carbon\Carbon::createFromFormat('Y-m-d', $value);
                }

                if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $value)) {
                    return \Carbon\Carbon::createFromFormat('d-m-Y', $value);
                }

                if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $value)) {
                    return \Carbon\Carbon::createFromFormat('d/m/Y', $value);
                }

                try {
                    return \Carbon\Carbon::parse($value);
                } catch (\Exception $e) {
                    return null;
                }
            };

            $soldStocks = Stock::whereRaw('LOWER(status) = ?', ['sold'])->get();
            $currentMonthSold = $soldStocks->filter(function ($stock) use ($parseStockDate) {
                $dateValue = $stock->tanggal_matching_do ?: $stock->tanggal_do;
                $date = $parseStockDate($dateValue);

                return $date
                    && $date->month === now()->month
                    && $date->year === now()->year
                    && $date->lessThanOrEqualTo(now());
            })->count();

            $totalStock = Stock::whereRaw('LOWER(status) IN (?, ?)', ['free', 'matching'])->count();
            $stockByStatus = Stock::selectRaw('LOWER(status) as status_lower, COUNT(*) as total')
                ->groupBy('status_lower')
                ->pluck('total', 'status_lower')
                ->toArray();

            $stockByStatus['sold'] = $currentMonthSold;
            $stockByStatus['free'] = $stockByStatus['free'] ?? 0;
            $stockByStatus['matching'] = $stockByStatus['matching'] ?? 0;
            $stockByStatus['sold'] = $stockByStatus['sold'] ?? 0;

            $imageMap = [
                'NEW CARRY'     => 'Suzuki-Carry.png',
                'APV'           => 'Suzuki-Apv.png',
                'ERTIGA-HYBRID' => 'Suzuki-Ertiga-Hybrid.png', 
                'NEW XL-7'      => 'XL7_Hybrid.png',         
                'GRAND-VITARA'  => 'Grand-Vitara.png',
                'JIMMY'         => 'Jimmy.png',
                'FRONX'         => 'suzuki-fronx.png',
                'S-PRESSO'      => 'Suzuki-Spresso.png',             
            ];

            $normalizeMobilName = function ($namaMobil) {
                $namaMobil = trim(strtoupper($namaMobil ?? ''));
                if ($namaMobil === '') {
                    return '';
                }

                if (str_contains($namaMobil, 'JIMNY')) {
                    return 'JIMMY';
                }

                if (str_contains($namaMobil, 'ERTIGA')) {
                    return 'ERTIGA-HYBRID';
                }

                if (str_contains($namaMobil, 'NEW CARRY') || str_contains($namaMobil, 'CARRY')) {
                    return 'NEW CARRY';
                }

                if (str_contains($namaMobil, 'APV')) {
                    return 'APV';
                }

                if (str_contains($namaMobil, 'GRAND') && str_contains($namaMobil, 'VITARA')) {
                    return 'GRAND-VITARA';
                }

                if (str_contains($namaMobil, 'XL-7') || str_contains($namaMobil, 'XL7')) {
                    return 'NEW XL-7';
                }

                if (str_contains($namaMobil, 'FRONX')) {
                    return 'FRONX';
                }

                if (str_contains($namaMobil, 'S-PRESSO') || str_contains($namaMobil, 'SPRESSO')) {
                    return 'S-PRESSO';
                }

                return $namaMobil;
            };

            $rawStocks  = Stock::whereIn('status', ['free', 'matching'])
                ->whereNotNull('nama_mobil')
                ->where('nama_mobil', '!=', '')
                ->get();
            $groupedByMobil = $rawStocks->groupBy(function ($item) use ($normalizeMobilName) {
                return $normalizeMobilName($item->nama_mobil);
            });

            // Bangun dari imageMap agar semua mobil selalu tampil (walaupun stok = 0)
            $stockByMobil = collect($imageMap)->map(function ($imageFile, $namaMobil) use ($groupedByMobil) {
                $group = $groupedByMobil->get($namaMobil, collect());

                $varianCounts = $group->filter(fn($item) => !empty($item->getRawOriginal('varian')))
                    ->groupBy(fn($item) => $item->getRawOriginal('varian'))
                    ->map(fn($g) => $g->count());

                $warnaCounts = $group->filter(fn($item) => !empty($item->getRawOriginal('warna')))
                    ->groupBy(fn($item) => $item->getRawOriginal('warna'))
                    ->map(fn($g) => $g->count());

                return (object)[
                    'nama_mobil'    => $namaMobil,
                    'total'         => $group->count(),
                    'varian_counts' => $varianCounts,
                    'warna_counts'  => $warnaCounts,
                    'varians'       => $varianCounts->keys(),
                    'warnas'        => $warnaCounts->keys(),
                    'image'         => $imageFile,
                ];
            })->sortByDesc('total')->values();
        }

        return view('dashboard', [
            'records' => $records,
            'totalPiutang' => $totalPiutang,
            'totalKonsumen' => $totalKonsumen,
            'totalAsuransi' => $totalAsuransi,
            'totalDebet' => $totalDebet,
            'totalKredit' => $totalKredit,
            'bpInsuranceTotals' => $bpInsuranceTotals,
            'grBranchCount' => $grBranchCount,
            'totalSelisih' => $totalSelisih,
            'branchSummaries' => $branchSummaries,
            'summaryBranches' => $branchSummaries,
            'selectedBranch' => $selectedBranch,
            'recentRecords' => $selectedBranch ? $filteredRecords : $records->take(10),
            'selectedRecords' => $filteredRecords,
            'totalStock' => $totalStock,
            'stockByStatus' => $stockByStatus,
            'stockByMobil' => $stockByMobil,
        ]);
    }
}
