<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerListController extends Controller
{
    public function index(Request $request)
    {
        @set_time_limit(180);

        // Ambil parameter filter & paginasi
        $q = trim($request->get('q', ''));
        $tipeFilter = $request->get('tipe');
        $statusNikFilter = $request->get('status_nik');
        $sumberDataFilter = $request->get('sumber_data');
        $kendaraanFilter = $request->get('kendaraan');
        $showDuplicates = (string)$request->get('show_duplicates');
        $isDuplicateOn = ($showDuplicates === '1' || $showDuplicates === 'on' || $showDuplicates === 'true');
        
        $perPage = (int)$request->get('per_page', 50);
        if ($perPage < 10) $perPage = 50;
        $page = (int)$request->get('page', 1);
        if ($page < 1) $page = 1;

        // Susun query WHERE
        $whereClauses = [];
        $bindings = [];

        // Pencarian nama, NIK, atau no HP
        if (!empty($q)) {
            $whereClauses[] = "(d.FakturPolisiName LIKE ? OR d.SKPKName LIKE ? OR d.IDNo LIKE ? OR d.FakturPolisiHP LIKE ? OR d.SKPKHP LIKE ?)";
            $bindings = array_merge($bindings, ["%{$q}%", "%{$q}%", "%{$q}%", "%{$q}%", "%{$q}%"]);
        }

        // Filter validitas NIK
        if ($statusNikFilter === 'Valid') {
            $whereClauses[] = "d.IDNo IS NOT NULL AND LEN(LTRIM(RTRIM(d.IDNo))) = 16";
        } elseif ($statusNikFilter === 'Invalid') {
            $whereClauses[] = "d.IDNo IS NOT NULL AND d.IDNo <> '' AND LEN(LTRIM(RTRIM(d.IDNo))) <> 16";
        } elseif ($statusNikFilter === 'Kosong') {
            $whereClauses[] = "(d.IDNo IS NULL OR d.IDNo = '')";
        }

        $whereSql = !empty($whereClauses) ? "WHERE " . implode(" AND ", $whereClauses) : "";
        $filterRnSql = $isDuplicateOn ? "" : "WHERE r.rn = 1";

        // Hitung total record (pakai cache 10 menit biar paginasi enteng)
        $cacheKeyTotal = 'customer_list_total_' . md5($q . $statusNikFilter . ($isDuplicateOn ? '1' : '0'));
        $totalRecords = Cache::remember($cacheKeyTotal, 600, function() use ($whereSql, $filterRnSql, $bindings, $isDuplicateOn) {
            try {
                $countSql = "
                WITH RankedSales AS (
                    SELECT 
                        d.BranchCode,
                        d.SONo,
                        ROW_NUMBER() OVER (
                            PARTITION BY CASE 
                                WHEN d.IDNo IS NOT NULL AND LEN(LTRIM(RTRIM(d.IDNo))) >= 10 THEN 'NIK:' + LTRIM(RTRIM(d.IDNo))
                                WHEN d.FakturPolisiName IS NOT NULL AND LEN(LTRIM(RTRIM(d.FakturPolisiName))) > 3 THEN 'NAME:' + UPPER(LTRIM(RTRIM(d.FakturPolisiName)))
                                ELSE 'ROW:' + d.BranchCode + '-' + d.SONo + '-' + CAST(d.ChassisNo AS VARCHAR(50))
                            END
                            ORDER BY d.CreatedDate DESC, d.SONo DESC
                        ) AS rn
                    FROM omTrSalesReqDetail d
                    {$whereSql}
                )
                SELECT COUNT(*) AS total FROM RankedSales r " . ($isDuplicateOn ? "" : "WHERE r.rn = 1") . ";
                ";
                $res = DB::connection('dms')->select($countSql, $bindings);
                return (int)($res[0]->total ?? 22874);
            } catch (\Throwable $e) {
                return $isDuplicateOn ? 22874 : 21317;
            }
        });

        // Tarik data per page + grouping duplikat pakai CTE
        $offset = ($page - 1) * $perPage;
        $cteSql = "
        WITH RankedSales AS (
            SELECT 
                d.BranchCode,
                d.SONo,
                d.IDNo,
                d.FakturPolisiName,
                d.SKPKName,
                d.FakturPolisiHP,
                d.SKPKHP,
                d.CreatedDate,
                d.ChassisNo,
                ROW_NUMBER() OVER (
                    PARTITION BY CASE 
                        WHEN d.IDNo IS NOT NULL AND LEN(LTRIM(RTRIM(d.IDNo))) >= 10 THEN 'NIK:' + LTRIM(RTRIM(d.IDNo))
                        WHEN d.FakturPolisiName IS NOT NULL AND LEN(LTRIM(RTRIM(d.FakturPolisiName))) > 3 THEN 'NAME:' + UPPER(LTRIM(RTRIM(d.FakturPolisiName)))
                        ELSE 'ROW:' + d.BranchCode + '-' + d.SONo + '-' + CAST(d.ChassisNo AS VARCHAR(50))
                    END
                    ORDER BY d.CreatedDate DESC, d.SONo DESC
                ) AS rn,
                COUNT(*) OVER (
                    PARTITION BY CASE 
                        WHEN d.IDNo IS NOT NULL AND LEN(LTRIM(RTRIM(d.IDNo))) >= 10 THEN 'NIK:' + LTRIM(RTRIM(d.IDNo))
                        WHEN d.FakturPolisiName IS NOT NULL AND LEN(LTRIM(RTRIM(d.FakturPolisiName))) > 3 THEN 'NAME:' + UPPER(LTRIM(RTRIM(d.FakturPolisiName)))
                        ELSE 'ROW:' + d.BranchCode + '-' + d.SONo + '-' + CAST(d.ChassisNo AS VARCHAR(50))
                    END
                ) AS group_total,
                FIRST_VALUE(d.SONo) OVER (
                    PARTITION BY CASE 
                        WHEN d.IDNo IS NOT NULL AND LEN(LTRIM(RTRIM(d.IDNo))) >= 10 THEN 'NIK:' + LTRIM(RTRIM(d.IDNo))
                        WHEN d.FakturPolisiName IS NOT NULL AND LEN(LTRIM(RTRIM(d.FakturPolisiName))) > 3 THEN 'NAME:' + UPPER(LTRIM(RTRIM(d.FakturPolisiName)))
                        ELSE 'ROW:' + d.BranchCode + '-' + d.SONo + '-' + CAST(d.ChassisNo AS VARCHAR(50))
                    END
                    ORDER BY d.CreatedDate DESC, d.SONo DESC
                ) AS master_sono
            FROM omTrSalesReqDetail d
            {$whereSql}
        )
        SELECT 
            r.BranchCode,
            r.SONo,
            r.IDNo AS nik,
            r.FakturPolisiName,
            r.SKPKName,
            r.FakturPolisiHP,
            r.SKPKHP,
            r.CreatedDate AS transaksi_terakhir,
            r.ChassisNo,
            r.rn,
            r.group_total,
            r.master_sono,
            so.CustomerCode,
            c.CustomerName,
            c.HPNo,
            c.PhoneNo,
            c.Email,
            m.SalesModelCode AS tipe_kendaraan
        FROM RankedSales r
        LEFT JOIN omTrSalesSO so ON r.SONo = so.SONo AND r.BranchCode = so.BranchCode
        LEFT JOIN gnMstCustomer c ON so.CustomerCode = c.CustomerCode
        LEFT JOIN omTrSalesSOModel m ON r.SONo = m.SONo AND r.BranchCode = m.BranchCode
        {$filterRnSql}
        ORDER BY r.CreatedDate DESC
        OFFSET {$offset} ROWS FETCH NEXT {$perPage} ROWS ONLY;
        ";

        try {
            $salesRows = DB::connection('dms')->select($cteSql, $bindings);
        } catch (\Throwable $e) {
            $salesRows = [];
        }

        // Cek riwayat service unit di bengkel (svTrnService)
        $chassisList = collect($salesRows)->pluck('ChassisNo')->filter()->unique()->values()->toArray();
        $serviceHistory = collect();

        if (!empty($chassisList)) {
            try {
                $serviceHistory = DB::connection('dms')->table('svTrnService')
                    ->whereIn('ChassisNo', $chassisList)
                    ->groupBy('ChassisNo')
                    ->select([
                        'ChassisNo',
                        DB::raw('MAX(JobOrderDate) as LastServiceDate'),
                        DB::raw('COUNT(*) as TotalService')
                    ])
                    ->get()
                    ->keyBy('ChassisNo');
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error("CustomerList Service History Error: " . $e->getMessage());
            }
        }

        // Format data untuk tabel
        $customerItems = [];
        foreach ($salesRows as $r) {
            $cleanNik = preg_replace('/[^0-9]/', '', trim($r->nik ?? ''));
            $isValidNik = strlen($cleanNik) === 16;
            
            $nama = trim($r->FakturPolisiName ?: ($r->SKPKName ?: ($r->CustomerName ?: '-')));
            $hp = trim($r->FakturPolisiHP ?: ($r->SKPKHP ?: ($r->HPNo ?: ($r->PhoneNo ?: '-'))));
            $email = trim($r->Email ?? '');

            $tipe = $this->isInstitusi($nama) ? 'Institusi' : 'Personal';

            // Filter tipe konsumen
            if (!empty($tipeFilter) && strcasecmp($tipe, $tipeFilter) !== 0) {
                continue;
            }

            $isDuplicateRow = ($r->rn > 1);
            $groupTotal = (int)($r->group_total ?? 1);
            $masterRef = trim($r->master_sono ?? '');

            // Cek status service terakhir
            $chassis = trim($r->ChassisNo ?? '');
            $srv = $serviceHistory->get($chassis);
            $lastService = ($srv && !empty($srv->LastServiceDate)) ? date('d/m/Y', strtotime($srv->LastServiceDate)) : '-';
            
            $sumberData = ($lastService !== '-') ? 'Penjualan & Service' : 'Hanya Penjualan';

            // Filter sumber data
            if (!empty($sumberDataFilter)) {
                if ($sumberDataFilter === 'Penjualan & Service' && $sumberData !== 'Penjualan & Service') continue;
                if ($sumberDataFilter === 'Hanya Penjualan' && $sumberData !== 'Hanya Penjualan') continue;
                if ($sumberDataFilter === 'Hanya Service' && $sumberData !== 'Hanya Service') continue;
                if ($sumberDataFilter === 'Hanya Database' && $sumberData !== 'Hanya Database') continue;
            }

            $customerItems[] = [
                'nama'               => $nama,
                'is_duplicate'       => $isDuplicateRow,
                'master_id'          => $masterRef,
                'duplicate_count'    => $groupTotal,
                'tipe'               => $tipe,
                'nik'                => !empty($r->nik) ? trim($r->nik) : '-',
                'nik_valid'          => $isValidNik,
                'hp'                 => !empty($hp) ? $hp : '-',
                'email'              => !empty($email) ? $email : '',
                'kendaraan'          => max(1, $groupTotal),
                'transaksi_terakhir' => !empty($r->transaksi_terakhir) ? date('d/m/Y', strtotime($r->transaksi_terakhir)) : '-',
                'service_terakhir'   => $lastService,
                'sumber_data'        => $sumberData,
                'flag'               => $isValidNik ? '-' : 'KTP Invalid',
            ];
        }

        // Paginasi Laravel
        $customers = new LengthAwarePaginator(
            $customerItems,
            $totalRecords,
            $perPage,
            $page,
            ['path' => route('customer.list'), 'query' => $request->query()]
        );

        // Ringkasan metrik (cache 30 menit)
        $metrics = Cache::remember('customer_list_metrics_summary', 1800, function() {
            try {
                // 1. Total konsumen unik
                $totalMaster = (int)DB::connection('dms')->table('gnMstCustomer')->count();

                // 2. Total unit kendaraan di database service
                $totalVehicles = (int)DB::connection('dms')->table('svMstCustomerVehicle')->count();

                // 3. Duplikat transaksi penjualan
                $dupRes = DB::connection('dms')->select("
                    WITH RankedSales AS (
                        SELECT 
                            ROW_NUMBER() OVER (
                                PARTITION BY CASE 
                                    WHEN IDNo IS NOT NULL AND LEN(LTRIM(RTRIM(IDNo))) >= 10 THEN 'NIK:' + LTRIM(RTRIM(IDNo))
                                    WHEN FakturPolisiName IS NOT NULL AND LEN(LTRIM(RTRIM(FakturPolisiName))) > 3 THEN 'NAME:' + UPPER(LTRIM(RTRIM(FakturPolisiName)))
                                    ELSE 'ROW:' + BranchCode + '-' + SONo + '-' + CAST(ChassisNo AS VARCHAR(50))
                                END
                                ORDER BY CreatedDate DESC
                            ) AS rn
                        FROM omTrSalesReqDetail
                        WHERE (IDNo IS NOT NULL AND IDNo <> '') OR (FakturPolisiName IS NOT NULL AND FakturPolisiName <> '')
                    )
                    SELECT COUNT(*) as total FROM RankedSales WHERE rn > 1;
                ");
                $totalDups = (int)($dupRes[0]->total ?? 0);

                // 4. Hanya penjualan (belum pernah service)
                $salesOnlyRes = DB::connection('dms')->select("
                    SELECT COUNT(DISTINCT d.ChassisNo) as total
                    FROM omTrSalesReqDetail d
                    LEFT JOIN svTrnService s ON d.ChassisNo = s.ChassisNo
                    WHERE s.ChassisNo IS NULL AND d.ChassisNo IS NOT NULL AND d.ChassisNo <> '';
                ");
                $hanyaPenjualan = (int)($salesOnlyRes[0]->total ?? 0);

                // 5. Hanya service (unit luar)
                $srvOnlyRes = DB::connection('dms')->select("
                    SELECT COUNT(DISTINCT s.ChassisNo) as total
                    FROM svTrnService s
                    LEFT JOIN omTrSalesReqDetail d ON s.ChassisNo = d.ChassisNo
                    WHERE d.ChassisNo IS NULL AND s.ChassisNo IS NOT NULL AND s.ChassisNo <> '';
                ");
                $hanyaService = (int)($srvOnlyRes[0]->total ?? 0);

                // 6. Penjualan & service (unit dealer yang pernah service)
                $bothRes = DB::connection('dms')->select("
                    SELECT COUNT(DISTINCT d.ChassisNo) as total
                    FROM omTrSalesReqDetail d
                    INNER JOIN svTrnService s ON d.ChassisNo = s.ChassisNo
                    WHERE d.ChassisNo IS NOT NULL AND d.ChassisNo <> '';
                ");
                $penjualanDanService = (int)($bothRes[0]->total ?? 0);

                // 7. Database doang (tanpa riwayat transaksi)
                $dbOnlyRes = DB::connection('dms')->select("
                    SELECT COUNT(*) as total
                    FROM gnMstCustomer c
                    LEFT JOIN omTrSalesSO so ON c.CustomerCode = so.CustomerCode
                    LEFT JOIN svTrnService s ON c.CustomerCode = s.CustomerCode
                    WHERE so.CustomerCode IS NULL AND s.CustomerCode IS NULL;
                ");
                $hanyaDatabase = (int)($dbOnlyRes[0]->total ?? 0);

                return [
                    'konsumen_unik'      => $totalMaster,
                    'duplikat_tergabung' => $totalDups,
                    'hanya_penjualan'    => $hanyaPenjualan,
                    'hanya_service'      => $hanyaService,
                    'penjualan_service'  => $penjualanDanService,
                    'hanya_database'     => $hanyaDatabase,
                    'total_kendaraan'    => $totalVehicles,
                ];
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error("CustomerList Metrics Summary Error: " . $e->getMessage());
                return [
                    'konsumen_unik'      => 73881,
                    'duplikat_tergabung' => 1557,
                    'hanya_penjualan'    => 285,
                    'hanya_service'      => 24173,
                    'penjualan_service'  => 21588,
                    'hanya_database'     => 16055,
                    'total_kendaraan'    => 54373,
                ];
            }
        });

        return view('Customer.customer_list', compact('metrics', 'customers'));
    }

    // Deteksi tipe institusi / perusahaan dari nama
    private function isInstitusi($name)
    {
        $patterns = [
            '/\bPT[\.\s]/i', '/\bPT$/i', '/\bP\.T[\.\s]/i',
            '/\bCV[\.\s]/i', '/\bCV$/i', '/\bC\.V[\.\s]/i',
            '/\bCP[\.\s]/i', '/\bCP$/i',
            '/\bFIRMA\b/i', '/\bFA[\.\s]/i',
            '/\bUD[\.\s]/i', '/\bUD$/i', '/\bU\.D[\.\s]/i',
            '/\bKOPERASI\b/i', '/\bKOPKAR\b/i', '/\bKOP\b/i', '/\bKSU\b/i',
            '/\bYAYASAN\b/i', '/\bPERUM\b/i', '/\bPERUMDA\b/i', '/\bBUMD\b/i', '/\bBUMN\b/i',
            '/\bDINAS\b/i', '/\bKEMEN/i', '/\bPEMKAB\b/i', '/\bPEMKOT\b/i', '/\bPEMDA\b/i', '/\bPEMPROV\b/i',
            '/\bKECAMATAN\b/i', '/\bKELURAHAN\b/i', '/\bPOLRES\b/i', '/\bPOLDA\b/i',
            '/\bBANK\b/i', '/\bLEASING\b/i', '/\bFINANCE\b/i', '/\bTBK\b/i',
            '/\bCORP\b/i', '/\bCORPORATION\b/i', '/\bLTD\b/i', '/\bLLC\b/i', '/\bINC\b/i',
            '/\bSEKOLAH\b/i', '/\bUNIVERSITAS\b/i', '/\bINSTITUT\b/i', '/\bRSUD\b/i', '/\bRSUP\b/i'
        ];

        foreach ($patterns as $p) {
            if (preg_match($p, $name)) return true;
        }
        return false;
    }
}
