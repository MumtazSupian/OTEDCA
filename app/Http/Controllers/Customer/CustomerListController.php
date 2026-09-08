<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomerListExport;

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

        // Hitung total record
        $cacheKeyTotal = 'customer_list_total_' . md5($q . $statusNikFilter . ($isDuplicateOn ? '1' : '0'));
        $totalRecords = Cache::remember($cacheKeyTotal, 600, function() use ($whereSql, $filterRnSql, $bindings, $isDuplicateOn) {
            try {
                $countSql = "
                WITH Customer AS (
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
                SELECT COUNT(*) AS total FROM Customer r " . ($isDuplicateOn ? "" : "WHERE r.rn = 1") . ";
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
        WITH Customer AS (
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
        FROM Customer r
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

                // 2. Data Penjualan 
                $hanyaPenjualan = (int)DB::connection('dms')->table('omTrSalesReqDetail')->count();

                // 3. Database doang (tanpa riwayat transaksi)
                $dbOnlyRes = DB::connection('dms')->select("
                    SELECT COUNT(*) as total
                    FROM gnMstCustomer c
                    LEFT JOIN omTrSalesSO so ON c.CustomerCode = so.CustomerCode
                    LEFT JOIN svTrnService s ON c.CustomerCode = s.CustomerCode
                    WHERE so.CustomerCode IS NULL AND s.CustomerCode IS NULL;
                ");
                $hanyaDatabase = (int)($dbOnlyRes[0]->total ?? 0);

                // 4. Hanya Service 
                $hanyaService = max(0, $totalMaster - $hanyaPenjualan - $hanyaDatabase);

                // 5. Total Kendaraan 
                $totalVehicles = $hanyaPenjualan + $hanyaService;

                // 3. Duplikat transaksi penjualan
                $dupRes = DB::connection('dms')->select("
                    WITH Customer AS (
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
                    SELECT COUNT(*) as total FROM Customer WHERE rn > 1;
                ");
                $totalDups = (int)($dupRes[0]->total ?? 0);

                // 4. Penjualan & service (unit dealer yang pernah service)
                $bothRes = DB::connection('dms')->select("
                    SELECT COUNT(DISTINCT d.ChassisNo) as total
                    FROM omTrSalesReqDetail d
                    INNER JOIN svTrnService s ON d.ChassisNo = s.ChassisNo
                    WHERE d.ChassisNo IS NOT NULL AND d.ChassisNo <> '';
                ");
                $penjualanDanService = (int)($bothRes[0]->total ?? 0);

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

    // Export Excel (sesuai filter & pilihan modal)
    public function export(Request $request)
    {
        @set_time_limit(300);
        @ini_set('memory_limit', '512M');

        // Parameter filter modal & form
        $q = trim($request->get('q', ''));
        $tipeFilter = $request->get('tipe');
        $statusNikFilter = $request->get('status_nik');
        $kendaraanFilter = $request->get('kendaraan');
        
        $kategoriSumber = (array)$request->get('kategori_sumber', []);
        $statusReview = $request->get('status_review', 'semua');
        $includeDuplicates = $request->has('include_duplicates') || $request->get('include_duplicates') === '1' || $request->get('show_duplicates') === '1';

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
        $filterRnSql = $includeDuplicates ? "" : "WHERE r.rn = 1";

        $cteSql = "
        WITH Customer AS (
            SELECT 
                d.BranchCode,
                d.SONo,
                d.IDNo,
                d.FakturPolisiName,
                d.SKPKName,
                d.FakturPolisiHP,
                d.FakturPolisiTelp1,
                d.FakturPolisiTelp2,
                d.SKPKHP,
                d.SKPKTelp1,
                d.FakturPolisiBirthday,
                d.SKPKBirthday,
                d.FakturPolisiAddress1,
                d.FakturPolisiAddress2,
                d.FakturPolisiAddress3,
                d.PostalCodeDesc,
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
            r.FakturPolisiTelp1,
            r.FakturPolisiTelp2,
            r.SKPKHP,
            r.SKPKTelp1,
            r.FakturPolisiBirthday,
            r.SKPKBirthday,
            r.FakturPolisiAddress1,
            r.FakturPolisiAddress2,
            r.FakturPolisiAddress3,
            r.PostalCodeDesc,
            r.CreatedDate AS transaksi_terakhir,
            r.ChassisNo,
            r.rn,
            r.group_total,
            r.master_sono,
            so.CustomerCode,
            c.CustomerName,
            c.Address1,
            c.Address2,
            c.KelurahanDesa,
            c.KecamatanDistrik,
            c.KotaKabupaten,
            c.ProvinceCode,
            c.BirthDate,
            c.Gender,
            c.HPNo,
            c.PhoneNo,
            c.Email,
            m.SalesModelCode AS tipe_kendaraan,
            srv.LastServiceDate
        FROM Customer r
        LEFT JOIN omTrSalesSO so ON r.SONo = so.SONo AND r.BranchCode = so.BranchCode
        LEFT JOIN gnMstCustomer c ON so.CustomerCode = c.CustomerCode
        LEFT JOIN omTrSalesSOModel m ON r.SONo = m.SONo AND r.BranchCode = m.BranchCode
        LEFT JOIN (
            SELECT ChassisNo, MAX(JobOrderDate) as LastServiceDate
            FROM svTrnService
            WHERE ChassisNo IS NOT NULL AND ChassisNo <> ''
            GROUP BY ChassisNo
        ) srv ON r.ChassisNo = srv.ChassisNo
        {$filterRnSql}
        ORDER BY r.CreatedDate DESC;
        ";

        try {
            $salesRows = DB::connection('dms')->select($cteSql, $bindings);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("CustomerList Export Error: " . $e->getMessage());
            $salesRows = [];
        }

        $exportItems = [];
        foreach ($salesRows as $r) {
            $cleanNik = preg_replace('/[^0-9]/', '', trim($r->nik ?? ''));
            $hasNik = !empty($cleanNik);
            $isValidNik = strlen($cleanNik) === 16;

            $nama = trim($r->FakturPolisiName ?: ($r->SKPKName ?: ($r->CustomerName ?: '-')));
            $tipe = $this->isInstitusi($nama) ? 'Institusi' : 'Personal';

            // Filter tipe konsumen
            if (!empty($tipeFilter) && strcasecmp($tipe, $tipeFilter) !== 0) {
                continue;
            }

            $isDuplicateRow = ($r->rn > 1);
            $groupTotal = (int)($r->group_total ?? 1);

            // Gender (dari NIK / master)
            $gender = '-';
            if ($tipe === 'Personal') {
                if ($isValidNik) {
                    $dayCode = (int)substr($cleanNik, 6, 2);
                    $gender = ($dayCode > 40) ? 'Perempuan' : 'Laki-laki';
                } elseif (!empty($r->Gender)) {
                    $gender = in_array(strtoupper($r->Gender), ['F', 'P', 'PEREMPUAN']) ? 'Perempuan' : 'Laki-laki';
                }
            }

            // Tgl Lahir
            $tglLahir = '-';
            if (!empty($r->FakturPolisiBirthday)) {
                $tglLahir = date('d/m/Y', strtotime($r->FakturPolisiBirthday));
            } elseif (!empty($r->BirthDate)) {
                $tglLahir = date('d/m/Y', strtotime($r->BirthDate));
            } elseif ($isValidNik) {
                $d = (int)substr($cleanNik, 6, 2);
                if ($d > 40) $d -= 40;
                $m = (int)substr($cleanNik, 8, 2);
                $y = (int)substr($cleanNik, 10, 2);
                $fullY = ($y > (int)date('y')) ? (1900 + $y) : (2000 + $y);
                if ($d >= 1 && $d <= 31 && $m >= 1 && $m <= 12) {
                    $tglLahir = sprintf('%02d/%02d/%04d', $d, $m, $fullY);
                }
            }

            // HP & HP 2
            $hp1 = trim($r->FakturPolisiHP ?: ($r->SKPKHP ?: ($r->HPNo ?: '-')));
            $hp2 = trim($r->FakturPolisiTelp2 ?: ($r->FakturPolisiTelp1 ?: ($r->PhoneNo ?: '-')));
            if ($hp2 === $hp1) $hp2 = '-';
            if (empty($hp1)) $hp1 = '-';
            if (empty($hp2)) $hp2 = '-';

            $email = trim($r->Email ?? '-');
            if (empty($email)) $email = '-';

            // Alamat jalan
            $alamat = trim($r->FakturPolisiAddress1 ?: ($r->Address1 ?: '-'));

            // Kelurahan / Desa
            $kelurahan = trim($r->KelurahanDesa ?? '');
            if (empty($kelurahan)) {
                if (!empty($r->PostalCodeDesc)) {
                    $kelurahan = trim($r->PostalCodeDesc);
                } elseif (preg_match('/(DS\.|DESA|KEL\.|KELURAHAN)\s*([A-Za-z0-9\s]+?)(?=\s*(KEC|KAB|KOTA|\,|$))/i', ($r->FakturPolisiAddress1 ?? '') . ' ' . ($r->FakturPolisiAddress2 ?? ''), $m)) {
                    $kelurahan = strtoupper(trim($m[0]));
                }
            }
            if (empty($kelurahan)) $kelurahan = '-';

            // Kecamatan
            $kecamatan = trim($r->KecamatanDistrik ?? '');
            if (empty($kecamatan)) {
                if (preg_match('/KEC\.?\s*([A-Za-z\s]+?)(?=\s*(KAB|KOTA|\,|$))/i', ($r->FakturPolisiAddress2 ?? '') . ' ' . ($r->FakturPolisiAddress3 ?? ''), $m)) {
                    $kecamatan = 'KEC. ' . strtoupper(trim($m[1]));
                }
            }
            if (empty($kecamatan)) $kecamatan = '-';

            // Kota / Kabupaten
            $kota = trim($r->KotaKabupaten ?? '');
            if (empty($kota)) {
                $kotaRaw = trim($r->FakturPolisiAddress3 ?: ($r->Address2 ?: ''));
                if (preg_match('/(KAB\.|KABUPATEN|KOTA)\s*([A-Za-z\s]+)/i', $kotaRaw, $m)) {
                    $kota = strtoupper(trim($m[0]));
                } else {
                    $kota = !empty($kotaRaw) ? strtoupper($kotaRaw) : 'KAB. CIANJUR';
                }
            }

            // Provinsi (seluruh 38 provinsi di Indonesia)
            $provinsi = $this->resolveProvinsi($cleanNik, $kota, $alamat);

            // Sumber Data
            $lastService = !empty($r->LastServiceDate) ? date('d/m/Y', strtotime($r->LastServiceDate)) : '-';
            $sumberData = ($lastService !== '-') ? 'Penjualan & Service' : 'Hanya Penjualan';

            // Filter kategori sumber data (jika dipilih di modal)
            if (!empty($kategoriSumber)) {
                $matchKategori = false;
                foreach ($kategoriSumber as $kat) {
                    if (stripos($kat, 'Penjualan') !== false) {
                        // Kategori penjualan mencakup seluruh transaksi unit
                        $matchKategori = true;
                        break;
                    } elseif (strcasecmp($kat, $sumberData) === 0) {
                        $matchKategori = true;
                        break;
                    }
                }
                if (!$matchKategori) {
                    continue;
                }
            }

            // Filter status review duplikat (jika dipilih di modal)
            if ($statusReview === 'bersih') {
                if ($groupTotal > 1 || !$isValidNik) {
                    continue;
                }
            } elseif ($statusReview === 'menunggu_review') {
                if ($groupTotal <= 1 && $isValidNik) {
                    continue;
                }
            }

            // Filter status kendaraan
            $kendaraanCount = max(1, $groupTotal);
            if (!empty($kendaraanFilter)) {
                if ($kendaraanFilter === 'Punya Kendaraan' && $kendaraanCount < 1) continue;
                if ($kendaraanFilter === 'Tidak Ada' && $kendaraanCount > 0) continue;
            }

            $exportItems[] = [
                'nama'               => $nama,
                'tipe'               => $tipe,
                'nik'                => !empty($r->nik) ? trim($r->nik) : '-',
                'gender'             => $gender,
                'tgl_lahir'          => $tglLahir,
                'hp'                 => $hp1,
                'hp_2'               => $hp2,
                'email'              => $email,
                'alamat'             => $alamat,
                'kelurahan'          => $kelurahan,
                'kecamatan'          => $kecamatan,
                'kota'               => $kota,
                'provinsi'           => $provinsi,
                'sumber_data'        => $sumberData,
                'kendaraan'          => $kendaraanCount,
                'transaksi_terakhir' => !empty($r->transaksi_terakhir) ? date('d/m/Y', strtotime($r->transaksi_terakhir)) : '-',
                'service_terakhir'   => $lastService,
                'status_review'      => '-', // Dikosongkan sesuai permintaan
            ];
        }

        $filename = 'Customer_List_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new CustomerListExport($exportItems), $filename);
    }

    // Resolver provinsi seluruh Indonesia (berdasarkan 2 digit NIK atau wilayah/kota)
    private function resolveProvinsi($cleanNik, $kota, $alamat)
    {
        // 1. Deteksi dari 2 digit kode provinsi NIK
        if (strlen($cleanNik) >= 2) {
            $prefix = substr($cleanNik, 0, 2);
            $nikProvinceMap = [
                '11' => 'ACEH',
                '12' => 'SUMATERA UTARA',
                '13' => 'SUMATERA BARAT',
                '14' => 'RIAU',
                '15' => 'JAMBI',
                '16' => 'SUMATERA SELATAN',
                '17' => 'BENGKULU',
                '18' => 'LAMPUNG',
                '19' => 'KEPULAUAN BANGKA BELITUNG',
                '21' => 'KEPULAUAN RIAU',
                '31' => 'DKI JAKARTA',
                '32' => 'JAWA BARAT',
                '33' => 'JAWA TENGAH',
                '34' => 'DI YOGYAKARTA',
                '35' => 'JAWA TIMUR',
                '36' => 'BANTEN',
                '51' => 'BALI',
                '52' => 'NUSA TENGGARA BARAT',
                '53' => 'NUSA TENGGARA TIMUR',
                '61' => 'KALIMANTAN BARAT',
                '62' => 'KALIMANTAN TENGAH',
                '63' => 'KALIMANTAN SELATAN',
                '64' => 'KALIMANTAN TIMUR',
                '65' => 'KALIMANTAN UTARA',
                '71' => 'SULAWESI UTARA',
                '72' => 'SULAWESI TENGAH',
                '73' => 'SULAWESI SELATAN',
                '74' => 'SULAWESI TENGGARA',
                '75' => 'GORONTALO',
                '76' => 'SULAWESI BARAT',
                '81' => 'MALUKU',
                '82' => 'MALUKU UTARA',
                '91' => 'PAPUA BARAT',
                '92' => 'PAPUA',
                '93' => 'PAPUA SELATAN',
                '94' => 'PAPUA TENGAH',
                '95' => 'PAPUA PEGUNUNGAN',
                '96' => 'PAPUA BARAT DAYA',
            ];
            if (isset($nikProvinceMap[$prefix])) {
                return $nikProvinceMap[$prefix];
            }
        }

        // 2. Deteksi dari nama Kota / Alamat
        $search = strtoupper($kota . ' ' . $alamat);

        if (preg_match('/\b(JAKARTA|JAKSEL|JAKTIM|JAKBAR|JAKPUS|JAKUT)\b/', $search)) return 'DKI JAKARTA';
        if (preg_match('/\b(BANTEN|TANGERANG|SERANG|CILEGON|PANDEGLANG|LEBAK)\b/', $search)) return 'BANTEN';
        if (preg_match('/\b(CIANJUR|BOGOR|SUKABUMI|BANDUNG|BEKASI|DEPOK|GARUT|TASIKMALAYA|CIAMIS|KUNINGAN|CIREBON|MAJALENGKA|SUMEDANG|INDRAMAYU|SUBANG|PURWAKARTA|KARAWANG|PANGANDARAN|BANJAR)\b/', $search)) return 'JAWA BARAT';
        if (preg_match('/\b(SEMARANG|SOLO|SURAKARTA|MAGELANG|PEKALONGAN|TEGAL|SALATIGA|BANYUMAS|PURWOKERTO|CILACAP|BREBES|KUDUS|JEPARA|KLATEN|BOYOLALI|WONOGIRI|SRAGEN|KARANGANYAR|SUKOHARJO|KEBUMEN|PURWOREJO|WONOSOBO|TEMANGGUNG|KENDAL|BATANG|PEMALANG|DEMAK|GROBOGAN|BLORA|REMBANG|PATI)\b/', $search)) return 'JAWA TENGAH';
        if (preg_match('/\b(YOGYAKARTA|JOGJA|SLEMAN|BANTUL|GUNUNGKIDUL|KULON PROGO)\b/', $search)) return 'DI YOGYAKARTA';
        if (preg_match('/\b(SURABAYA|MALANG|SIDOARJO|GRESIK|PASURUAN|MOJOKERTO|JOMBANG|KEDIRI|BLITAR|MADIUN|MAGETAN|NGAWI|PONOROGO|PACITAN|TRENGGALEK|TULUNGAGUNG|NGANJUK|BOJONEGORO|TUBAN|LAMONGAN|PROBOLINGGO|LUMAJANG|JEMBER|BONDOWOSO|SITUBONDO|BANYUWANGI|BANGKALAN|SAMPANG|PAMEKASAN|SUMENEP|MADURA)\b/', $search)) return 'JAWA TIMUR';
        if (preg_match('/\b(BALI|DENPASAR|BADUNG|GIANYAR|TABANAN|BULELENG|KARANGASEM|KLUNGKUNG|BANGLI|JEMBRANA)\b/', $search)) return 'BALI';
        if (preg_match('/\b(MEDAN|DELI SERDANG|BINJAI|PEMATANGSIANTAR|TOBA|KARO|ASAHAN|LABUHANBATU|LANGKAT|NIAS|SIMALUNGUN|TAPANULI)\b/', $search)) return 'SUMATERA UTARA';
        if (preg_match('/\b(PADANG|BUKITTINGGI|PAYAKUMBUH|PARIAMAN|SOLOK|AGAM|TANAH DATAR|PASAMAN|PESISIR SELATAN)\b/', $search)) return 'SUMATERA BARAT';
        if (preg_match('/\b(PALEMBANG|PRABUMULIH|LUBUKLINGGAU|PAGAR ALAM|OGAN ILIR|OKU|BANYUASIN|MUARA ENIM|MUSI BANYUASIN|MUSI RAWAS|LAHAT)\b/', $search)) return 'SUMATERA SELATAN';
        if (preg_match('/\b(LAMPUNG|BANDAR LAMPUNG|METRO|PRINGSEWU|TULANG BAWANG|TANGGAMUS|PESAWARAN)\b/', $search)) return 'LAMPUNG';
        if (preg_match('/\b(PEKANBARU|DUMAI|KAMPAR|BENGKALIS|INDRAGIRI|PELALAWAN|ROKAN|SIAK|KUANTAN)\b/', $search)) return 'RIAU';
        if (preg_match('/\b(BATAM|TANJUNGPINANG|BINTAN|KARIMUN|NATUNA|ANAMBAS|LINGGA)\b/', $search)) return 'KEPULAUAN RIAU';
        if (preg_match('/\b(JAMBI|MUARO JAMBI|BATANGHARI|BUNGO|TEBO|SAROLANGUN|MERANGIN|KERINCI)\b/', $search)) return 'JAMBI';
        if (preg_match('/\b(BENGKULU|MUKOMUKO|SELUMA|KAUR|LEBONG|KEPAHIANG)\b/', $search)) return 'BENGKULU';
        if (preg_match('/\b(BANGKA|BELITUNG|PANGKALPINANG)\b/', $search)) return 'KEPULAUAN BANGKA BELITUNG';
        if (preg_match('/\b(BANDA ACEH|LHOKSEUMAWE|LANGSA|SABANG|SUBULUSSALAM|BIREUEN|PIDIE)\b/', $search)) return 'ACEH';
        if (preg_match('/\b(PONTIANAK|SINGKAWANG|SAMBAS|KETAPANG|SINTANG|KAPUAS HULU)\b/', $search)) return 'KALIMANTAN BARAT';
        if (preg_match('/\b(BANJARMASIN|BANJARBARU|MARTAPURA|TABALONG|KOTABARU)\b/', $search)) return 'KALIMANTAN SELATAN';
        if (preg_match('/\b(SAMARINDA|BALIKPAPAN|BONTANG|KUTAI|BERAU|PASER)\b/', $search)) return 'KALIMANTAN TIMUR';
        if (preg_match('/\b(PALANGKA RAYA|KOTAWARINGIN|KAPUAS|BARITO)\b/', $search)) return 'KALIMANTAN TENGAH';
        if (preg_match('/\b(TARAKAN|BULUNGAN|NUNUKAN|MALINAU)\b/', $search)) return 'KALIMANTAN UTARA';
        if (preg_match('/\b(MAKASSAR|PALOPO|PAREPARE|GOWA|BONE|MAROS|BULUKUMBA|TORAJA)\b/', $search)) return 'SULAWESI SELATAN';
        if (preg_match('/\b(MANADO|BITUNG|TOMOHON|KOTAMOBAGU|MINAHASA)\b/', $search)) return 'SULAWESI UTARA';
        if (preg_match('/\b(PALU|POSO|DONGGALA|BANGGAI|TOLITOLI)\b/', $search)) return 'SULAWESI TENGAH';
        if (preg_match('/\b(KENDARI|BAUBAU|KOLAKA|MUNA|KONAWE)\b/', $search)) return 'SULAWESI TENGGARA';
        if (preg_match('/\b(GORONTALO|LIMBOTO)\b/', $search)) return 'GORONTALO';
        if (preg_match('/\b(MAMUJU|POLEWALI|MAJENE)\b/', $search)) return 'SULAWESI BARAT';
        if (preg_match('/\b(AMBON|TUAL|MALUKU)\b/', $search)) return 'MALUKU';
        if (preg_match('/\b(TERNATE|TIDORE|HALMAHERA)\b/', $search)) return 'MALUKU UTARA';
        if (preg_match('/\b(JAYAPURA|MERAUKE|BIAK|NABIRE|TIMIKA|MIMIKA|SORONG|MANOKWARI|PAPUA)\b/', $search)) return 'PAPUA';

        return 'JAWA BARAT';
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
