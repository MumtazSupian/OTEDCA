<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleLookupController extends Controller
{
    public function index(Request $request)
    {
        @set_time_limit(180);
        @ini_set('memory_limit', '512M');

        $mode = $request->get('mode', 'konsumen'); // 'konsumen/kendaraan'
        $keyword = trim($request->get('q', ''));
        $selectedChassis = $request->get('chassis', '');
        $selectedPlate = $request->get('plate', '');
        $selectedCustomerCode = $request->get('cust_code', '');

        $results = [];
        $selectedVehicles = [];
        $selectedDetail = null;

        // Cari jika keyword TIDAK kosong ATAU ada parameter spesifik yang diminta
        if (!empty($keyword) || !empty($selectedChassis) || !empty($selectedPlate) || !empty($selectedCustomerCode)) {
            if ($mode === 'kendaraan') {
                if (!empty($keyword)) {
                    $results = $this->searchVehicles($keyword);
                }
                
                // Jika ada kendaraan yang dipilih atau ambil hasil pertama
                $targetChassis = $selectedChassis ?: ($results[0]['vin'] ?? '');
                $targetPlate = $selectedPlate ?: ($results[0]['plat'] ?? '');
                
                if (!empty($targetChassis) || !empty($targetPlate)) {
                    $detail = $this->getVehicleDetail($targetChassis, $targetPlate);
                    if ($detail) {
                        $selectedVehicles[] = $detail;
                        $selectedDetail = $detail;
                    }
                }
            } else {
                // Konsumen
                if (!empty($keyword)) {
                    $results = $this->searchConsumers($keyword);
                }

                // Target konsumen yang dipilih
                $targetCust = null;
                if (!empty($selectedCustomerCode)) {
                    foreach ($results as $res) {
                        if (($res['customer_code'] ?? '') === $selectedCustomerCode || ($res['nik'] ?? '') === $selectedCustomerCode || ($res['nama'] ?? '') === $selectedCustomerCode) {
                            $targetCust = $res;
                            break;
                        }
                    }
                }
                if (!$targetCust && count($results) > 0) {
                    $targetCust = $results[0];
                }

                if ($targetCust) {
                    // Ambil SEMUA kendaraan milik konsumen secara langsung (jika > 1 mobil, munculkan semua card langsung)
                    $allChassis = !empty($targetCust['all_chassis']) ? $targetCust['all_chassis'] : ($targetCust['chassis_list'] ?? []);
                    if (!empty($allChassis)) {
                        foreach ($allChassis as $ch) {
                            $detail = $this->getVehicleDetail($ch, '', $targetCust);
                            if ($detail) {
                                $selectedVehicles[] = $detail;
                            }
                        }
                    }
                    if (empty($selectedVehicles)) {
                        $fallback = $this->getConsumerVehicleFallbackDetail($targetCust);
                        $selectedVehicles[] = $fallback;
                    }
                    $selectedDetail = $selectedVehicles[0] ?? null;
                }
            }
        }

        // Jika request via AJAX / JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'mode' => $mode,
                'keyword' => $keyword,
                'results' => $results,
                'selectedVehicles' => $selectedVehicles,
                'selectedDetail' => $selectedDetail
            ]);
        }

        return view('Customer.vehicle_lookup', compact('mode', 'keyword', 'results', 'selectedVehicles', 'selectedDetail', 'selectedChassis', 'selectedPlate', 'selectedCustomerCode'));
    }

    /**
     * Cari Data Konsumen dari gnMstCustomer dan omTrSalesReqDetail
     */
    private function searchConsumers(string $keyword): array
    {
        if (empty($keyword)) return [];

        $cleanKw = trim($keyword);
        $baseKw = trim(preg_replace('/\b(S\.?H\.?|M\.?H\.?|S\.?E\.?|S\.?T\.?|Drs\.?|Dr\.?|H\.?|Hj\.?)\b/i', '', str_replace(',', ' ', $cleanKw)));
        $baseKw = trim(preg_replace('/\s+/', ' ', $baseKw));
        $consumers = [];

        try {
            // 1. Cari di data Penjualan (omTrSalesReqDetail)
            $salesList = DB::connection('dms')->table('omTrSalesReqDetail as d')
                ->where(function($w) use ($cleanKw, $baseKw) {
                    $w->where('d.FakturPolisiName', 'LIKE', "%{$cleanKw}%")
                      ->orWhere('d.SKPKName', 'LIKE', "%{$cleanKw}%")
                      ->orWhere('d.IDNo', 'LIKE', "%{$cleanKw}%")
                      ->orWhere('d.FakturPolisiHP', 'LIKE', "%{$cleanKw}%")
                      ->orWhere('d.SKPKHP', 'LIKE', "%{$cleanKw}%");
                    if (!empty($baseKw) && strlen($baseKw) >= 3 && $baseKw !== $cleanKw) {
                        $w->orWhere('d.FakturPolisiName', 'LIKE', "%{$baseKw}%")
                          ->orWhere('d.SKPKName', 'LIKE', "%{$baseKw}%");
                    }
                })
                ->select([
                    'd.BranchCode',
                    'd.SONo',
                    'd.IDNo as nik',
                    'd.FakturPolisiName as nama',
                    'd.SKPKName as nama_skpk',
                    'd.FakturPolisiHP as hp',
                    'd.SKPKHP as hp_skpk',
                    'd.FakturPolisiAddress1 as alamat',
                    'd.ChassisCode',
                    'd.ChassisNo as chassis',
                    'd.CreatedDate as tgl_beli'
                ])
                ->orderBy('d.CreatedDate', 'DESC')
                ->limit(50)
                ->get();

            // Ambil juga semua transaksi penjualan lain yang memiliki NIK sama
            $foundNiks = array_values(array_unique(array_filter($salesList->pluck('nik')->toArray(), function($n) {
                return !empty($n) && $n !== '-' && strlen($n) >= 6;
            })));

            if (!empty($foundNiks)) {
                $extraSales = DB::connection('dms')->table('omTrSalesReqDetail as d')
                    ->whereIn('d.IDNo', $foundNiks)
                    ->select([
                        'd.BranchCode',
                        'd.SONo',
                        'd.IDNo as nik',
                        'd.FakturPolisiName as nama',
                        'd.SKPKName as nama_skpk',
                        'd.FakturPolisiHP as hp',
                        'd.SKPKHP as hp_skpk',
                        'd.FakturPolisiAddress1 as alamat',
                        'd.ChassisCode',
                        'd.ChassisNo as chassis',
                        'd.CreatedDate as tgl_beli'
                    ])
                    ->get();

                $salesList = $salesList->merge($extraSales)->unique(function($item) {
                    return ($item->SONo ?? '') . ($item->chassis ?? '');
                });
            }

            // 2. Cari di data Master (gnMstCustomer)
            $masterList = DB::connection('dms')->table('gnMstCustomer as c')
                ->where(function($w) use ($cleanKw, $baseKw, $foundNiks) {
                    $w->where('c.CustomerName', 'LIKE', "%{$cleanKw}%")
                      ->orWhere('c.CustomerCode', 'LIKE', "%{$cleanKw}%")
                      ->orWhere('c.HPNo', 'LIKE', "%{$cleanKw}%")
                      ->orWhere('c.PhoneNo', 'LIKE', "%{$cleanKw}%")
                      ->orWhere('c.Spare05', 'LIKE', "%{$cleanKw}%");
                    if (!empty($baseKw) && strlen($baseKw) >= 3 && $baseKw !== $cleanKw) {
                        $w->orWhere('c.CustomerName', 'LIKE', "%{$baseKw}%");
                    }
                    if (!empty($foundNiks)) {
                        $w->orWhereIn('c.Spare05', $foundNiks);
                    }
                })
                ->select([
                    'c.CustomerCode',
                    'c.CustomerName as nama',
                    'c.HPNo as hp',
                    'c.PhoneNo as telp',
                    'c.Address1 as alamat',
                    'c.Spare05 as nik',
                    'c.CreatedDate'
                ])
                ->orderBy('c.CreatedDate', 'DESC')
                ->limit(50)
                ->get();

            // Kumpulkan dan deduplikasi konsumen
            $grouped = [];

            $normalizeName = function($name) {
                $n = strtoupper(trim($name ?? ''));
                $n = preg_replace('/\b(S\.?H\.?|M\.?H\.?|S\.?E\.?|S\.?T\.?|Drs\.?|Dr\.?|H\.?|Hj\.?)\b/i', '', str_replace([',', '.'], ' ', $n));
                return trim(preg_replace('/\s+/', ' ', $n));
            };

            foreach ($salesList as $s) {
                $fakturName = trim($s->nama ?: '');
                $skpkName = trim($s->nama_skpk ?: '');
                $nik = trim($s->nik ?: '-');
                $fakturHp = trim($s->hp ?: '-');
                $skpkHp = trim($s->hp_skpk ?: '-');
                $chassis = trim($s->chassis ?: '');
                $fullChassis = trim(($s->ChassisCode ?? '') . $chassis);
                $targetChassis = $fullChassis ?: $chassis;

                // 1. Entry Konsumen Pemilik (Faktur Polisi, e.g. EMA LISTIANI)
                if (!empty($fakturName)) {
                    $norm = $normalizeName($fakturName);
                    $key = !empty($nik) && $nik !== '-' ? "NIK:{$nik}" : "NAME:{$norm}";

                    if (!isset($grouped[$key])) {
                        $grouped[$key] = [
                            'customer_code' => $s->SONo ?? '',
                            'cust_codes' => [$s->SONo ?? ''],
                            'nama' => strtoupper($fakturName),
                            'nik' => $nik,
                            'hp' => $fakturHp !== '-' ? $fakturHp : $skpkHp,
                            'alamat' => trim($s->alamat ?: '-'),
                            'chassis_list' => [],
                            'source' => 'Sales',
                            'data_count' => 1,
                        ];
                    } else {
                        $grouped[$key]['data_count'] = ($grouped[$key]['data_count'] ?? 1) + 1;
                        if (strlen($fakturName) > strlen($grouped[$key]['nama'])) {
                            $grouped[$key]['nama'] = strtoupper($fakturName);
                        }
                        if ($grouped[$key]['nik'] === '-' && !empty($nik) && $nik !== '-') {
                            $grouped[$key]['nik'] = $nik;
                        }
                        if (!empty($s->SONo) && !in_array($s->SONo, $grouped[$key]['cust_codes'])) {
                            $grouped[$key]['cust_codes'][] = $s->SONo;
                        }
                    }
                    if (!empty($targetChassis) && !in_array($targetChassis, $grouped[$key]['chassis_list'])) {
                        $grouped[$key]['chassis_list'][] = $targetChassis;
                    }
                }

                // 2. Entry Konsumen Pembeli (SKPK, e.g. DOLI SURYATMAN) jika nama berbeda
                if (!empty($skpkName) && strtoupper($skpkName) !== strtoupper($fakturName)) {
                    $normSkpk = $normalizeName($skpkName);
                    $keySkpk = "NAME:{$normSkpk}";
                    if (!isset($grouped[$keySkpk])) {
                        $grouped[$keySkpk] = [
                            'customer_code' => $s->SONo ?? '',
                            'cust_codes' => [$s->SONo ?? ''],
                            'nama' => strtoupper($skpkName),
                            'nik' => '-',
                            'hp' => $skpkHp !== '-' ? $skpkHp : $fakturHp,
                            'alamat' => trim($s->alamat ?: '-'),
                            'chassis_list' => [],
                            'source' => 'Sales',
                            'data_count' => 1,
                        ];
                    } else {
                        $grouped[$keySkpk]['data_count'] = ($grouped[$keySkpk]['data_count'] ?? 1) + 1;
                    }
                    if (!empty($targetChassis) && !in_array($targetChassis, $grouped[$keySkpk]['chassis_list'])) {
                        $grouped[$keySkpk]['chassis_list'][] = $targetChassis;
                    }
                }
            }

            foreach ($masterList as $m) {
                $nama = trim($m->nama ?: '-');
                $hp = trim($m->hp ?: ($m->telp ?: '-'));
                $nik = trim($m->nik ?: '-');
                if ($nik === '' || strlen($nik) < 6) $nik = '-';
                $norm = $normalizeName($nama);

                $matchedKey = null;
                if ($nik !== '-' && isset($grouped["NIK:{$nik}"])) {
                    $matchedKey = "NIK:{$nik}";
                }
                if (!$matchedKey) {
                    foreach ($grouped as $k => $g) {
                        if ($g['nik'] !== '-' && $nik !== '-' && $g['nik'] === $nik) {
                            $matchedKey = $k;
                            break;
                        }
                        if ($normalizeName($g['nama']) === $norm) {
                            $matchedKey = $k;
                            break;
                        }
                    }
                }

                if ($matchedKey) {
                    $grouped[$matchedKey]['data_count'] = ($grouped[$matchedKey]['data_count'] ?? 1) + 1;
                    if (!in_array($m->CustomerCode, $grouped[$matchedKey]['cust_codes'])) {
                        $grouped[$matchedKey]['cust_codes'][] = $m->CustomerCode;
                    }
                    if ($grouped[$matchedKey]['nik'] === '-' && $nik !== '-') {
                        $grouped[$matchedKey]['nik'] = $nik;
                    }
                } else {
                    $key = $nik !== '-' ? "NIK:{$nik}" : "NAME:{$norm}";
                    $grouped[$key] = [
                        'customer_code' => $m->CustomerCode,
                        'cust_codes' => [$m->CustomerCode],
                        'nama' => strtoupper($nama),
                        'nik' => $nik,
                        'hp' => $hp,
                        'alamat' => trim($m->alamat ?: '-'),
                        'chassis_list' => [],
                        'source' => 'Master',
                        'data_count' => 1,
                    ];
                }
            }

            // Hitung total unit kendaraan per konsumen secara batch (berdasarkan SEMUA cust_codes)
            $allCustCodes = [];
            foreach ($grouped as $g) {
                foreach ($g['cust_codes'] ?? [$g['customer_code']] as $cc) {
                    if (!empty($cc)) $allCustCodes[] = $cc;
                }
            }
            $allCustCodes = array_unique(array_filter($allCustCodes));

            $srvChassisMap = [];
            if (!empty($allCustCodes)) {
                $srvRows = DB::connection('dms')->table('svTrnService')
                    ->whereIn('CustomerCode', $allCustCodes)
                    ->whereNotNull('ChassisNo')
                    ->where('ChassisNo', '<>', '')
                    ->select(['CustomerCode', 'ChassisCode', 'ChassisNo', 'VIN'])
                    ->get();
                foreach ($srvRows as $sr) {
                    $cCode = trim($sr->CustomerCode);
                    $fullVin = trim($sr->VIN ?: (($sr->ChassisCode ?? '') . ($sr->ChassisNo ?? '')));
                    $ch = $fullVin ?: trim($sr->ChassisNo);
                    if (!empty($ch)) {
                        $srvChassisMap[$cCode][] = $ch;
                    }
                }
            }

            foreach ($grouped as $k => $c) {
                $cCodes = $c['cust_codes'] ?? [$c['customer_code']];
                $chassisArr = array_unique(array_filter($c['chassis_list']));

                $srvChassis = [];
                foreach ($cCodes as $cc) {
                    if (!empty($srvChassisMap[$cc])) {
                        $srvChassis = array_merge($srvChassis, $srvChassisMap[$cc]);
                    }
                }

                $allChassis = array_unique(array_merge($chassisArr, $srvChassis));
                $grouped[$k]['total_unit'] = max(1, count($allChassis));
                $grouped[$k]['all_chassis'] = array_values($allChassis);
                $grouped[$k]['data_count'] = max($grouped[$k]['data_count'] ?? 1, count(array_unique($cCodes)));
            }

            $consumers = array_values($grouped);

        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("VehicleLookup searchConsumers error: " . $e->getMessage());
        }

        return $consumers;
    }

    /**
     * Cari Data Kendaraan (Plat / VIN / Mesin) untuk Tabel Panel Kiri
     * Format kolom: VIN | Plat | Type | Pemilik Saat Ini | ID
     */
    private function searchVehicles(string $keyword): array
    {
        if (empty($keyword)) return [];

        $cleanKw = trim($keyword);
        $noSpaceKw = str_replace(' ', '', $cleanKw);
        $vehicles = [];

        try {
            // Cari di svTrnService
            $srvVehicles = DB::connection('dms')->table('svTrnService as s')
                ->leftJoin('gnMstCustomer as c', 's.CustomerCode', '=', 'c.CustomerCode')
                ->where(function($w) use ($cleanKw, $noSpaceKw) {
                    $w->where('s.PoliceRegNo', 'LIKE', "%{$cleanKw}%")
                      ->orWhereRaw("REPLACE(s.PoliceRegNo, ' ', '') LIKE ?", ["%{$noSpaceKw}%"])
                      ->orWhere('s.ChassisNo', 'LIKE', "%{$cleanKw}%")
                      ->orWhereRaw("REPLACE(s.ChassisNo, ' ', '') LIKE ?", ["%{$noSpaceKw}%"])
                      ->orWhere('s.VIN', 'LIKE', "%{$cleanKw}%")
                      ->orWhere('s.EngineNo', 'LIKE', "%{$cleanKw}%");
                })
                ->select([
                    's.PoliceRegNo as plat',
                    's.ChassisNo as vin',
                    's.VIN as full_vin',
                    's.EngineNo as no_mesin',
                    's.BasicModel as model',
                    's.ColorCode as warna',
                    's.JobOrderDate',
                    's.CustomerCode as cust_code',
                    'c.CustomerName as stnk_nama',
                    'c.HPNo as hp'
                ])
                ->orderBy('s.JobOrderDate', 'DESC')
                ->limit(50)
                ->get();

            // Group by VIN / Plat
            $grouped = [];
            foreach ($srvVehicles as $v) {
                $plat = strtoupper(trim($v->plat ?: '-'));
                $vin = trim($v->full_vin ?: ($v->vin ?: '-'));
                $key = $vin !== '-' ? $vin : $plat;

                if (!isset($grouped[$key])) {
                    $modelDesc = $this->resolveModelDesc($v->model);
                    $cCode = trim($v->cust_code ?? '');
                    $formattedId = !empty($cCode) ? '#' . (is_numeric($cCode) ? ltrim($cCode, '0') : $cCode) : '#-';

                    $grouped[$key] = [
                        'vin' => $vin,
                        'plat' => $plat,
                        'type' => $modelDesc,
                        'pemilik' => strtoupper(trim($v->stnk_nama ?: '-')),
                        'id' => $formattedId,
                        'model' => $modelDesc,
                        'no_mesin' => trim($v->no_mesin ?: '-'),
                        'warna' => strtoupper(trim($v->warna ?: 'WHITE')),
                        'hp' => trim($v->hp ?: '-'),
                        'status' => 'Terdaftar Servis',
                    ];
                }
            }

            // Juga cek di omTrSalesReqDetail jika belum ada
            $salesVehicles = DB::connection('dms')->table('omTrSalesReqDetail as d')
                ->leftJoin('omTrSalesSOModel as m', function($j) {
                    $j->on('d.SONo', '=', 'm.SONo')->on('d.BranchCode', '=', 'm.BranchCode');
                })
                ->where(function($w) use ($cleanKw, $noSpaceKw) {
                    $w->where('d.ChassisNo', 'LIKE', "%{$cleanKw}%")
                      ->orWhereRaw("(d.ChassisCode + d.ChassisNo) LIKE ?", ["%{$cleanKw}%"])
                      ->orWhereRaw("REPLACE((d.ChassisCode + d.ChassisNo), ' ', '') LIKE ?", ["%{$noSpaceKw}%"]);
                })
                ->select([
                    'd.ChassisCode',
                    'd.ChassisNo',
                    'd.SONo',
                    'd.FakturPolisiName as stnk_nama',
                    'd.SKPKName as pembeli_nama',
                    'd.FakturPolisiHP as hp',
                    'm.SalesModelCode as model'
                ])
                ->limit(20)
                ->get();

            foreach ($salesVehicles as $sv) {
                $vin = trim($sv->ChassisNo ?: '-');
                $fullVin = trim(($sv->ChassisCode ?? '') . ($sv->ChassisNo ?? ''));
                $key = $fullVin !== '' ? $fullVin : $vin;

                if (!isset($grouped[$key]) && !isset($grouped[$vin]) && $vin !== '-') {
                    $modelDesc = $this->resolveModelDesc($sv->model);
                    $sono = trim($sv->SONo ?? '');
                    $formattedId = !empty($sono) ? '#' . (is_numeric($sono) ? ltrim($sono, '0') : substr($sono, -5)) : '#-';
                    $pemilik = strtoupper(trim($sv->stnk_nama ?: ($sv->pembeli_nama ?: '-')));

                    $grouped[$key] = [
                        'vin' => $fullVin ?: $vin,
                        'plat' => '-',
                        'type' => $modelDesc,
                        'pemilik' => $pemilik,
                        'id' => $formattedId,
                        'model' => $modelDesc,
                        'no_mesin' => '-',
                        'warna' => 'WHITE',
                        'hp' => trim($sv->hp ?: '-'),
                        'status' => 'Unit Penjualan',
                    ];
                }
            }

            $vehicles = array_values($grouped);

        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("VehicleLookup searchVehicles error: " . $e->getMessage());
        }

        return $vehicles;
    }

    //Ambil Spesifikasi Kendaraan Lengkap & Riwayat Service
    private function getVehicleDetail(string $chassisNo, string $policeRegNo = '', array $parentCustomer = null): array
    {
        $spec = [
            'model' => 'Suzuki Unit',
            'tahun' => date('Y'),
            'vin' => $chassisNo,
            'plat' => $policeRegNo ?: '-',
            'no_mesin' => '-',
            'warna' => 'WHITE',
            'stnk_nama' => $parentCustomer['nama'] ?? '-',
        ];

        $keterkaitans = [];
        $services = [];

        try {
            $cleanChassis = trim($chassisNo);

            // 1. Ambil data transaksi service dari svTrnService
            $srvRows = DB::connection('dms')->table('svTrnService as s')
                ->leftJoin('gnMstCustomer as c', 's.CustomerCode', '=', 'c.CustomerCode')
                ->where(function($w) use ($cleanChassis, $policeRegNo) {
                    if (!empty($cleanChassis)) {
                        $w->where('s.ChassisNo', $cleanChassis)
                          ->orWhere('s.VIN', $cleanChassis)
                          ->orWhere('s.VIN', 'LIKE', "%{$cleanChassis}%")
                          ->orWhere('s.ChassisNo', 'LIKE', "%{$cleanChassis}%");
                    }
                    if (!empty($policeRegNo) && $policeRegNo !== '-') {
                        $w->orWhere('s.PoliceRegNo', $policeRegNo);
                    }
                })
                ->select([
                    's.CompanyCode',
                    's.BranchCode',
                    's.JobOrderNo',
                    's.JobOrderDate',
                    's.CreatedDate',
                    's.LastUpdateDate',
                    's.ServiceRequestDesc',
                    's.ForemanID',
                    's.Odometer',
                    's.PoliceRegNo',
                    's.BasicModel',
                    's.EngineNo',
                    's.ColorCode',
                    's.ChassisCode',
                    's.ChassisNo',
                    's.VIN',
                    'c.CustomerCode',
                    'c.CustomerName',
                    'c.HPNo',
                    'c.PhoneNo'
                ])
                ->orderBy('s.JobOrderDate', 'DESC')
                ->get();

            // 2. Ambil data penjualan dari omTrSalesReqDetail & omTrSalesSOModel
            $salesInfo = DB::connection('dms')->table('omTrSalesReqDetail as d')
                ->leftJoin('omTrSalesSOModel as m', function($j) {
                    $j->on('d.SONo', '=', 'm.SONo')->on('d.BranchCode', '=', 'm.BranchCode');
                })
                ->where(function($w) use ($cleanChassis) {
                    if (!empty($cleanChassis)) {
                        $w->where('d.ChassisNo', $cleanChassis)
                          ->orWhere('d.ChassisNo', 'LIKE', "%{$cleanChassis}%")
                          ->orWhereRaw("(d.ChassisCode + d.ChassisNo) LIKE ?", ["%{$cleanChassis}%"]);
                    }
                })
                ->select([
                    'd.FakturPolisiName',
                    'd.SKPKName',
                    'd.FakturPolisiHP',
                    'd.SKPKHP',
                    'd.CreatedDate',
                    'd.ChassisCode',
                    'd.ChassisNo',
                    'm.SalesModelCode',
                    'm.SalesModelYear'
                ])
                ->orderBy('d.CreatedDate', 'DESC')
                ->first();

            // Tentukan data spesifikasi dasar
            if ($srvRows->isNotEmpty()) {
                $latestSrv = $srvRows->first();
                $spec['model'] = $this->resolveModelDesc($latestSrv->BasicModel);
                $spec['tahun'] = !empty($latestSrv->JobOrderDate) ? date('Y', strtotime($latestSrv->JobOrderDate)) : date('Y');
                $spec['vin'] = trim($latestSrv->VIN ?: (($latestSrv->ChassisCode ?? '') . ($latestSrv->ChassisNo ?? '')));
                $spec['plat'] = strtoupper(trim($latestSrv->PoliceRegNo ?: $policeRegNo));
                // NO. MESIN HANYA DARI FIELD EngineNo
                $spec['no_mesin'] = trim($latestSrv->EngineNo ?? '-');
                $spec['warna'] = strtoupper(trim($latestSrv->ColorCode ?: 'WHITE'));
                
                // Susun Riwayat Service (SPK) tanpa duplikasi
                $seenSpk = [];
                foreach ($srvRows as $row) {
                    $spkNo = trim($row->JobOrderNo ?? '');
                    $spkKey = $spkNo ?: (($row->CompanyCode ?? '') . '-' . ($row->BranchCode ?? '') . '-' . ($row->JobOrderDate ?? '') . '-' . ($row->Odometer ?? ''));
                    if (!empty($spkKey) && isset($seenSpk[$spkKey])) {
                        continue;
                    }
                    $seenSpk[$spkKey] = true;

                    $tglSpk = !empty($row->CreatedDate) ? date('d/m/Y', strtotime($row->CreatedDate)) : (!empty($row->JobOrderDate) ? date('d/m/Y', strtotime($row->JobOrderDate)) : '-');
                    $tglBilling = !empty($row->LastUpdateDate) ? date('d/m/Y', strtotime($row->LastUpdateDate)) : $tglSpk;
                    $sa = $this->resolveSAName($row->ForemanID, null);
                    $km = is_numeric($row->Odometer) ? number_format((float)$row->Odometer, 0, ',', '.') : ($row->Odometer ?: '-');

                    $services[] = [
                        'no_wo' => $spkNo ?: '-',           // No. SPK
                        'tgl_wo' => $tglSpk,                // Tgl SPK
                        'tgl_billing' => $tglBilling,
                        'kategori' => trim($row->ServiceRequestDesc ?: 'General Service'),
                        'sa' => $sa,
                        'km' => $km,
                    ];
                }
            } elseif ($salesInfo) {
                $spec['model'] = $this->resolveModelDesc($salesInfo->SalesModelCode);
                $spec['tahun'] = !empty($salesInfo->SalesModelYear) ? trim($salesInfo->SalesModelYear) : (!empty($salesInfo->CreatedDate) ? date('Y', strtotime($salesInfo->CreatedDate)) : date('Y'));
                $spec['vin'] = trim(($salesInfo->ChassisCode ?? '') . ($salesInfo->ChassisNo ?? $cleanChassis));
                $spec['plat'] = $policeRegNo ?: '-';
                $spec['no_mesin'] = '-';
                $spec['warna'] = 'WHITE';
            }

            // Tentukan Pemilik Terupdate / STNK A/N
            $latestOwnerName = '-';
            $salesDate = $salesInfo && !empty($salesInfo->CreatedDate) ? strtotime($salesInfo->CreatedDate) : 0;
            $srvDate = $srvRows->isNotEmpty() && !empty($srvRows->first()->JobOrderDate) ? strtotime($srvRows->first()->JobOrderDate) : 0;

            if ($parentCustomer && !empty($parentCustomer['nama']) && $parentCustomer['nama'] !== '-') {
                $latestOwnerName = strtoupper(trim($parentCustomer['nama']));
            } elseif ($salesInfo && $salesDate >= $srvDate) {
                $latestOwnerName = strtoupper(trim($salesInfo->FakturPolisiName ?: ($salesInfo->SKPKName ?: '-')));
            } elseif ($srvRows->isNotEmpty()) {
                $latestOwnerName = strtoupper(trim($srvRows->first()->CustomerName ?: '-'));
            }

            $spec['stnk_nama'] = $latestOwnerName;

            // Susun Keterkaitan Konsumen 
            $seenCust = [];
            $ketList = [];

            // 1. Tambahkan dari Penjualan (omTrSalesReqDetail)
            if ($salesInfo) {
                $fakturName = strtoupper(trim($salesInfo->FakturPolisiName ?: ''));
                $fakturHp = trim($salesInfo->FakturPolisiHP ?: '');
                $skpkName = strtoupper(trim($salesInfo->SKPKName ?: ''));
                $skpkHp = trim($salesInfo->SKPKHP ?: '');
                $tglBeli = !empty($salesInfo->CreatedDate) ? date('d/m/Y', strtotime($salesInfo->CreatedDate)) : date('d/m/Y');
                $rawDate = !empty($salesInfo->CreatedDate) ? strtotime($salesInfo->CreatedDate) : time();

                // Pemilik dari Faktur Polisi / STNK
                $pemilikName = $fakturName ?: ($skpkName ?: '-');
                $pemilikHp = $fakturHp ?: ($skpkHp ?: '-');
                if ($pemilikName !== '-' && !empty($pemilikName)) {
                    $seenCust[$pemilikName] = true;
                    $ketList[] = [
                        'peran' => 'Pemilik',
                        'sumber' => 'SDMS',
                        'konsumen' => $pemilikName,
                        'hp' => $pemilikHp,
                        'periode' => "{$tglBeli} – sekarang",
                        '_raw_date' => $rawDate + 1,
                    ];
                }

                // Pembeli dari SKPK 
                $pembeliName = $skpkName ?: ($fakturName ?: '-');
                $pembeliHp = $skpkHp ?: ($fakturHp ?: '-');
                if ($pembeliName !== '-' && !empty($pembeliName)) {
                    $seenCust[$pembeliName] = true;
                    $ketList[] = [
                        'peran' => 'Pembeli',
                        'sumber' => 'SDMS',
                        'konsumen' => $pembeliName,
                        'hp' => $pembeliHp,
                        'periode' => "{$tglBeli} – sekarang",
                        '_raw_date' => $rawDate,
                    ];
                }
            }

            // 2. Tambahkan dari svTrnService 
            if ($srvRows->isNotEmpty()) {
                foreach ($srvRows as $row) {
                    $srvCustName = strtoupper(trim($row->CustomerName ?: '-'));
                    $srvCustHp = trim($row->HPNo ?: ($row->PhoneNo ?: '-'));
                    $srvDateStr = !empty($row->JobOrderDate) ? date('d/m/Y', strtotime($row->JobOrderDate)) : date('d/m/Y');
                    $rawSrvDate = !empty($row->JobOrderDate) ? strtotime($row->JobOrderDate) : 0;

                    if ($srvCustName !== '-' && !empty($srvCustName) && !isset($seenCust[$srvCustName])) {
                        $seenCust[$srvCustName] = true;
                        $ketList[] = [
                            'peran' => 'Pemilik',
                            'sumber' => 'SDMS',
                            'konsumen' => $srvCustName,
                            'hp' => $srvCustHp,
                            'periode' => "{$srvDateStr} – sekarang",
                            '_raw_date' => $rawSrvDate,
                        ];
                    }
                }
            }

            // 3. Jika parent customer belum ada di list, tambahkan juga
            if ($parentCustomer && !empty($parentCustomer['nama']) && !isset($seenCust[strtoupper(trim($parentCustomer['nama']))])) {
                $pName = strtoupper(trim($parentCustomer['nama']));
                $pHp = trim($parentCustomer['hp'] ?? '-');
                $ketList[] = [
                    'peran' => 'Pemilik',
                    'sumber' => 'SDMS',
                    'konsumen' => $pName,
                    'hp' => $pHp,
                    'periode' => date('d/m/Y') . ' – sekarang',
                    '_raw_date' => time(),
                ];
            }

            // Urutkan keterkaitan dari tanggal terbaru ke terlama
            usort($ketList, function($a, $b) {
                return ($b['_raw_date'] ?? 0) <=> ($a['_raw_date'] ?? 0);
            });

            // Hapus temporary key _raw_date
            $keterkaitans = array_map(function($item) {
                unset($item['_raw_date']);
                return $item;
            }, $ketList);

        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("VehicleLookup getVehicleDetail error: " . $e->getMessage());
        }

        return [
            'type' => 'vehicle_specs',
            'specs' => $spec,
            'keterkaitans' => $keterkaitans,
            'services' => $services,
            'total_wo' => count($services),
            'total_keterkaitan' => count($keterkaitans),
        ];
    }

    //Fallback detail untuk konsumen tanpa catatan chassis spesifik
    private function getConsumerVehicleFallbackDetail(array $customer): array
    {
        $nama = strtoupper(trim($customer['nama'] ?? '-'));
        $hp = trim($customer['hp'] ?? '-');

        return [
            'type' => 'vehicle_specs',
            'specs' => [
                'model' => 'Suzuki Unit',
                'tahun' => date('Y'),
                'vin' => '-',
                'plat' => '-',
                'no_mesin' => '-',
                'warna' => 'WHITE',
                'stnk_nama' => $nama,
            ],
            'keterkaitans' => [
                [
                    'peran' => 'Pemilik',
                    'sumber' => 'SDMS',
                    'konsumen' => $nama,
                    'hp' => $hp,
                    'periode' => date('d/m/Y') . ' – sekarang',
                ]
            ],
            'services' => [],
            'total_wo' => 0,
            'total_keterkaitan' => 1,
        ];
    }

    private static $saNameCache = [];

    //Resolve Service Advisor Name
    private function resolveSAName(?string $foremanId, ?string $employeeName): string
    {
        if (!empty($employeeName)) {
            return trim($employeeName);
        }
        if (!empty($foremanId)) {
            $cleanId = trim($foremanId, "' \t\n\r\0\x0B");
            if (isset(self::$saNameCache[$cleanId])) {
                return self::$saNameCache[$cleanId];
            }
            $varId = str_replace('.00.', '.0', $cleanId);
            try {
                $emp = DB::connection('dms')->table('gnMstEmployee')
                    ->where('EmployeeID', $cleanId)
                    ->orWhere('EmployeeID', $varId)
                    ->first();
                if ($emp && !empty($emp->EmployeeName)) {
                    return self::$saNameCache[$cleanId] = trim($emp->EmployeeName);
                }
            } catch (\Throwable $e) {}

            return self::$saNameCache[$cleanId] = $cleanId;
        }

        return '-';
    }

    private static $modelDescCache = [];

    //Resolve Vehicle Model Description
    private function resolveModelDesc(?string $basicModel): string
    {
        if (empty($basicModel)) return 'Suzuki Unit';
        $basicModel = trim($basicModel);

        if (isset(self::$modelDescCache[$basicModel])) {
            return self::$modelDescCache[$basicModel];
        }

        try {
            $cleanBasic = explode('-', $basicModel)[0];
            $modelInfo = DB::connection('dms')->table('omMstModel')
                ->where('SalesModelCode', $basicModel)
                ->orWhere('BasicModel', $basicModel)
                ->orWhere('BasicModel', $cleanBasic)
                ->orWhere('BasicModel', substr($cleanBasic, 0, 6))
                ->select('SalesModelDesc')
                ->first();

            if ($modelInfo && !empty($modelInfo->SalesModelDesc)) {
                return self::$modelDescCache[$basicModel] = trim($modelInfo->SalesModelDesc);
            }
        } catch (\Throwable $e) {}

        return self::$modelDescCache[$basicModel] = $basicModel;
    }
}
