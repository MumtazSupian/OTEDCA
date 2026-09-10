<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class PromoController extends Controller
{
    public function index(Request $request)
    {
        // khusus it
        $u = auth()->user();
        $uRole = strtolower(trim($u->role ?? ''));
        $uEmail = strtolower(trim($u->email ?? ''));
        $uName = strtolower(trim($u->name ?? ''));
        $isItUser = ($u && $uEmail !== 'dcasr' && ($u->is_it || $u->is_admin || str_contains($uRole, 'it') || str_contains($uEmail, 'it') || str_contains($uName, 'it') || in_array($uEmail, ['mumtazit', 'heruit', 'rizkyit', 'it']) || in_array($uRole, ['admin', 'it', 'superadmin'])));

        if (!$isItUser) {
            abort(403, 'Akses menu ini khusus IT saja.');
        }

        @set_time_limit(180);

        // cabang
        $cabang = strtoupper(trim($request->get('cabang', 'CIAWI')));
        if (!in_array($cabang, ['CIAWI', 'CIANJUR', 'CINERE', 'JATIASIH', 'CIPANAS'])) {
            $cabang = 'CIAWI';
        }

        $bulan = (int)$request->get('bulan', date('n'));
        if ($bulan < 1 || $bulan > 12) $bulan = (int)date('n');
        
        $tahun = $request->filled('tahun') ? (int)$request->get('tahun') : (int)date('Y');

        $search = trim($request->get('q', ''));

        // Daftar Cabang
        $branchList = [
            'CIAWI'    => 'Ciawi',
            'CIANJUR'  => 'Cianjur',
            'CINERE'   => 'Cinere',
            'JATIASIH' => 'Jatiasih',
            'CIPANAS'  => 'Cipanas',
        ];

        $branchCodesMap = [
            'CIAWI'    => ['641940101'],
            'CIANJUR'  => ['641940102'],
            'CINERE'   => ['641940103'],
            'JATIASIH' => ['641940104'],
            'CIPANAS'  => ['641940106'],
        ];

        // Daftar Tahun Tersedia (dari data awal database s/d tahun terbaru berjalan)
        $currentYear = (int)date('Y');
        $availableYears = range($currentYear + 1, 2011);

        // query ke svTrnInvoice 
        $promos = collect();
        $grandTotalHarga = 0;
        $totalRecords = 0;
        $errorMessage = null;

        try {
            $baseQuery = DB::connection('dms')->table('svTrnInvoice as inv')
                ->leftJoin('svTrnService as s', function($join) {
                    $join->on('inv.JobOrderNo', '=', 's.JobOrderNo')
                         ->on('inv.BranchCode', '=', 's.BranchCode');
                })
                ->leftJoin('gnMstEmployee as e', function($join) {
                    $join->on('s.ForemanID', '=', 'e.EmployeeID')
                         ->on('s.BranchCode', '=', 'e.BranchCode');
                })
                ->where(function($q) {
                    $q->where('inv.ServiceRequestDesc', 'LIKE', '%PROMO%')
                      ->orWhere('inv.ServiceRequestDesc', 'LIKE', '%Promo%');
                });

            // Cabang
            if (isset($branchCodesMap[$cabang])) {
                $codes = $branchCodesMap[$cabang];
                $baseQuery->whereIn('inv.BranchCode', $codes);
            }

            // Filter Bulan & Tahun 
            $startDate = sprintf('%04d-%02d-01', $tahun, $bulan);
            $endDate = date('Y-m-t', strtotime("$tahun-$bulan-01"));
            $baseQuery->where('inv.InvoiceDate', '>=', $startDate)
                      ->where('inv.InvoiceDate', '<=', $endDate);

            // Filter Pencarian
            if (!empty($search)) {
                $baseQuery->where(function($q) use ($search) {
                    $q->where('inv.JobOrderNo', 'LIKE', "%{$search}%")
                      ->orWhere('inv.InvoiceNo', 'LIKE', "%{$search}%")
                      ->orWhere('e.EmployeeName', 'LIKE', "%{$search}%")
                      ->orWhere('s.ForemanID', 'LIKE', "%{$search}%")
                      ->orWhere('inv.ServiceRequestDesc', 'LIKE', "%{$search}%");
                });
            }

            // Ambil Seluruh Data 
            $promos = $baseQuery->select([
                'inv.JobOrderNo as no_spk',
                'inv.InvoiceNo as no_invoice',
                's.ForemanID as foreman_id',
                'e.EmployeeName as foreman_nama',
                'inv.ServiceRequestDesc as promo',
                'inv.InvoiceDate as tanggal_dibuat',
                'inv.TotalSrvAmt as harga',
                'inv.BranchCode as branch_code',
            ])
            ->orderBy('inv.InvoiceDate', 'DESC')
            ->get();

            $totalRecords = count($promos);
            $grandTotalHarga = (float)$promos->sum('harga');

        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            \Illuminate\Support\Facades\Log::error("PromoController Query Error: " . $e->getMessage());
        }

        return view('Service.promo', compact(
            'promos',
            'cabang',
            'bulan',
            'tahun',
            'search',
            'branchList',
            'availableYears',
            'grandTotalHarga',
            'totalRecords',
            'errorMessage'
        ));
    }
}
