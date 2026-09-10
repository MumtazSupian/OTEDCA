<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DuplicateReviewController extends Controller
{
    public function index(Request $request)
    {
        @set_time_limit(180);
        @ini_set('memory_limit', '512M');

        $status = $request->get('status', 'Pending');
        $confidence = $request->get('confidence', 'Semua');
        $sumberData = $request->get('sumber_data', 'Semua Sumber');

        $cacheKey = 'dup_review_pairs_' . md5($status . '_' . $confidence . '_' . $sumberData);
        $samplePairs = Cache::remember($cacheKey, 900, function() use ($status, $confidence, $sumberData) {
            return $this->scanDuplicatePairs($status, $confidence, $sumberData);
        });

        return view('Customer.duplicate_review', compact('status', 'confidence', 'sumberData', 'samplePairs'));
    }

    /**
     * Scan dan bandingkan pasangan konsumen terindikasi duplikat dari 4 sumber data:
     * - Hanya Penjualan
     * - Hanya Service
     * - Penjualan & Service
     * - Hanya Database
     */
    private function scanDuplicatePairs(string $statusFilter, string $confidenceFilter, string $sumberFilter): array
    {
        $pairs = [];
        $pairId = 1;
        $seenPairs = [];

        $calcKelengkapan = function(array $data): string {
            $fields = ['nama', 'nik', 'gender', 'tgl_lahir', 'hp', 'email', 'alamat', 'kendaraan', 'transaksi', 'service'];
            $filled = 0;
            foreach ($fields as $f) {
                if (!empty($data[$f]) && $data[$f] !== '-') $filled++;
            }
            return round(($filled / count($fields)) * 100) . '/100';
        };

        $formatDate = function($val): string {
            if (empty($val)) return '-';
            $ts = strtotime($val);
            if (!$ts || $ts <= 0 || date('Y', $ts) < 1970) return '-';
            return date('d/m/Y', $ts);
        };

        try {
            // 1. SCAN CROSS-SOURCE DUPLICATES: Sales (omTrSalesReqDetail) vs Master/Service (gnMstCustomer)
            $salesMatches = DB::connection('dms')->select("
                SELECT TOP 150
                    d.SONo as s_sono,
                    d.BranchCode as s_branch,
                    d.FakturPolisiName as s_nama,
                    d.SKPKName as s_skpk,
                    d.IDNo as s_nik,
                    d.FakturPolisiHP as s_hp,
                    d.SKPKHP as s_skpk_hp,
                    d.FakturPolisiAddress1 as s_alamat,
                    d.FakturPolisiBirthday as s_birth,
                    d.SKPKBirthday as s_skpk_birth,
                    d.ChassisCode as s_chassis_code,
                    d.ChassisNo as s_chassis,
                    d.CreatedDate as s_date,
                    c.CustomerCode as m_code,
                    c.CustomerName as m_nama,
                    c.Spare05 as m_nik,
                    c.HPNo as m_hp,
                    c.PhoneNo as m_telp,
                    c.Email as m_email,
                    c.BirthDate as m_birth,
                    c.Gender as m_gender,
                    c.Address1 as m_alamat,
                    c.CreatedDate as m_created
                FROM omTrSalesReqDetail d WITH (NOLOCK)
                INNER JOIN gnMstCustomer c WITH (NOLOCK) ON d.FakturPolisiName = c.CustomerName
                WHERE d.FakturPolisiName IS NOT NULL
                  AND LEN(d.FakturPolisiName) >= 4
                ORDER BY d.CreatedDate DESC;
            ");

            // Ambil mapping service history untuk master customer codes
            $mCodes = array_filter(array_unique(array_map(fn($r) => trim($r->m_code ?? ''), $salesMatches)));
            $srvMap = [];
            if (!empty($mCodes)) {
                $srvRows = DB::connection('dms')->table('svTrnService')
                    ->whereIn('CustomerCode', $mCodes)
                    ->orderBy('JobOrderDate', 'DESC')
                    ->select(['CustomerCode', 'JobOrderDate', 'ChassisNo', 'VIN', 'PoliceRegNo'])
                    ->get();
                foreach ($srvRows as $sr) {
                    $cc = trim($sr->CustomerCode);
                    if (!isset($srvMap[$cc])) {
                        $srvMap[$cc] = [
                            'last_service' => $formatDate($sr->JobOrderDate),
                            'vin' => trim($sr->VIN ?: $sr->ChassisNo),
                            'plat' => trim($sr->PoliceRegNo ?: '-'),
                        ];
                    }
                }
            }

            // Ambil service history untuk chassis penjualan
            $salesChassisList = array_filter(array_unique(array_map(fn($r) => trim($r->s_chassis ?? ''), $salesMatches)));
            $salesSrvMap = [];
            if (!empty($salesChassisList)) {
                $salesSrvRows = DB::connection('dms')->table('svTrnService')
                    ->whereIn('ChassisNo', $salesChassisList)
                    ->orderBy('JobOrderDate', 'DESC')
                    ->select(['ChassisNo', 'JobOrderDate'])
                    ->get();
                foreach ($salesSrvRows as $sr) {
                    $ch = trim($sr->ChassisNo);
                    if (!isset($salesSrvMap[$ch])) {
                        $salesSrvMap[$ch] = $formatDate($sr->JobOrderDate);
                    }
                }
            }

            foreach ($salesMatches as $row) {
                $sNama = strtoupper(trim($row->s_nama ?: ($row->s_skpk ?: '-')));
                $mNama = strtoupper(trim($row->m_nama ?: '-'));
                $sNik = trim($row->s_nik ?: '-');
                $mNik = trim($row->m_nik ?: '-');
                $sHp = trim($row->s_hp ?: ($row->s_skpk_hp ?: '-'));
                $mHp = trim($row->m_hp ?: ($row->m_telp ?: '-'));
                $sAddr = strtoupper(trim($row->s_alamat ?: '-'));
                $mAddr = strtoupper(trim($row->m_alamat ?: '-'));
                $sChassis = trim(($row->s_chassis_code ?? '') . ($row->s_chassis ?? ''));
                $mCode = trim($row->m_code ?? '');

                $pairKey = "{$sNama}::{$mCode}::{$sNik}";
                if (isset($seenPairs[$pairKey])) continue;
                $seenPairs[$pairKey] = true;

                $mSrvInfo = $srvMap[$mCode] ?? null;
                $mSrvDate = $mSrvInfo['last_service'] ?? '-';
                $mChassis = $mSrvInfo['vin'] ?? '-';

                $salesSrvDate = $salesSrvMap[trim($row->s_chassis)] ?? '-';

                // Tentukan Sumber Data masing-masing kandidat
                $sumberLeft = ($salesSrvDate !== '-') ? 'Penjualan & Service' : 'Hanya Penjualan';
                $sumberRight = ($mSrvDate !== '-') ? 'Hanya Service' : 'Hanya Database';

                // Rule evaluation
                $ruleCode = 'R6';
                $matchType = 'Nama Normalisasi';
                $score = 70;
                $confidenceLevel = 'Medium';

                if ($sNik !== '-' && $mNik !== '-' && $sNik === $mNik && strlen($sNik) === 16) {
                    $ruleCode = 'R1';
                    $matchType = 'NIK Sama';
                    $score = 95;
                    $confidenceLevel = 'High';
                } elseif ($sHp !== '-' && $mHp !== '-' && preg_replace('/[^0-9]/', '', $sHp) === preg_replace('/[^0-9]/', '', $mHp)) {
                    $ruleCode = 'R2';
                    $matchType = 'Nama+HP';
                    $score = 85;
                    $confidenceLevel = 'High';
                } elseif (!empty($sChassis) && !empty($mChassis) && $sChassis !== '-' && $mChassis !== '-' && ($sChassis === $mChassis || str_contains($sChassis, $mChassis) || str_contains($mChassis, $sChassis))) {
                    $ruleCode = 'R4';
                    $matchType = 'Nama+Kendaraan';
                    $score = 85;
                    $confidenceLevel = 'High';
                } elseif ($sAddr !== '-' && $mAddr !== '-' && (similar_text($sAddr, $mAddr) > 15 || str_contains($sAddr, $mAddr) || str_contains($mAddr, $sAddr))) {
                    $ruleCode = 'RSb';
                    $matchType = 'Nama+Alamat';
                    $score = 75;
                    $confidenceLevel = 'Medium';
                }

                // Filter Confidence
                if ($confidenceFilter !== 'Semua' && strcasecmp($confidenceFilter, $confidenceLevel) !== 0) {
                    continue;
                }

                // Filter Sumber Data
                if ($sumberFilter !== 'Semua Sumber' && $sumberFilter !== 'Semua') {
                    if ($sumberLeft !== $sumberFilter && $sumberRight !== $sumberFilter) {
                        continue;
                    }
                }

                $dataLeft = [
                    'nama' => $sNama,
                    'tipe' => $this->isInstitusi($sNama) ? 'Institusi' : 'Personal',
                    'sumber' => $sumberLeft,
                    'nik' => $sNik,
                    'gender' => '-',
                    'tgl_lahir' => $formatDate($row->s_birth ?: ($row->s_skpk_birth ?: null)),
                    'hp' => $sHp,
                    'email' => '-',
                    'alamat' => $sAddr,
                    'kendaraan' => $sChassis ?: '-',
                    'transaksi' => $formatDate($row->s_date),
                    'service' => $salesSrvDate,
                    'diperbarui' => $formatDate($row->s_date ?: '02/07/2024'),
                    'kelengkapan' => '70/100',
                ];
                $dataLeft['kelengkapan'] = $calcKelengkapan($dataLeft);

                $dataRight = [
                    'nama' => $mNama,
                    'tipe' => $this->isInstitusi($mNama) ? 'Institusi' : 'Personal',
                    'sumber' => $sumberRight,
                    'nik' => $mNik,
                    'gender' => !empty($row->m_gender) ? trim($row->m_gender) : '-',
                    'tgl_lahir' => $formatDate($row->m_birth),
                    'hp' => $mHp,
                    'email' => !empty($row->m_email) ? trim($row->m_email) : '-',
                    'alamat' => $mAddr,
                    'kendaraan' => $mChassis,
                    'transaksi' => '-',
                    'service' => $mSrvDate,
                    'diperbarui' => $formatDate($row->m_created ?: '02/07/2024'),
                    'kelengkapan' => '75/100',
                ];
                $dataRight['kelengkapan'] = $calcKelengkapan($dataRight);

                $pairs[] = [
                    'id' => $pairId++,
                    'rule_code' => $ruleCode,
                    'match_type' => $matchType,
                    'score' => $score,
                    'confidence_level' => $confidenceLevel,
                    'status' => 'Pending',
                    'data_left' => $dataLeft,
                    'data_right' => $dataRight,
                ];
            }

            // 2. SCAN INTRA-SOURCE DUPLICATES: Multiple sales with same NIK / Phone
            $intraSales = DB::connection('dms')->select("
                SELECT TOP 100
                    d1.SONo as d1_sono, d1.FakturPolisiName as d1_nama, d1.IDNo as d1_nik, d1.FakturPolisiHP as d1_hp, d1.FakturPolisiAddress1 as d1_addr, d1.ChassisNo as d1_chassis, d1.CreatedDate as d1_date,
                    d2.SONo as d2_sono, d2.FakturPolisiName as d2_nama, d2.IDNo as d2_nik, d2.FakturPolisiHP as d2_hp, d2.FakturPolisiAddress1 as d2_addr, d2.ChassisNo as d2_chassis, d2.CreatedDate as d2_date
                FROM omTrSalesReqDetail d1 WITH (NOLOCK)
                INNER JOIN omTrSalesReqDetail d2 WITH (NOLOCK) 
                    ON d1.IDNo = d2.IDNo AND d1.SONo < d2.SONo
                WHERE d1.IDNo IS NOT NULL AND LEN(d1.IDNo) >= 10
                ORDER BY d1.CreatedDate DESC;
            ");

            foreach ($intraSales as $row) {
                $pKey = "INTRA:{$row->d1_nik}:{$row->d1_sono}:{$row->d2_sono}";
                if (isset($seenPairs[$pKey])) continue;
                $seenPairs[$pKey] = true;

                $dataLeft = [
                    'nama' => strtoupper(trim($row->d1_nama ?: '-')),
                    'tipe' => 'Personal',
                    'sumber' => 'Hanya Penjualan',
                    'nik' => trim($row->d1_nik ?: '-'),
                    'gender' => '-',
                    'tgl_lahir' => '-',
                    'hp' => trim($row->d1_hp ?: '-'),
                    'email' => '-',
                    'alamat' => strtoupper(trim($row->d1_addr ?: '-')),
                    'kendaraan' => trim($row->d1_chassis ?: '-'),
                    'transaksi' => $formatDate($row->d1_date),
                    'service' => '-',
                    'diperbarui' => $formatDate($row->d1_date ?: '02/07/2024'),
                    'kelengkapan' => '70/100',
                ];
                $dataLeft['kelengkapan'] = $calcKelengkapan($dataLeft);

                $dataRight = [
                    'nama' => strtoupper(trim($row->d2_nama ?: '-')),
                    'tipe' => 'Personal',
                    'sumber' => 'Hanya Penjualan',
                    'nik' => trim($row->d2_nik ?: '-'),
                    'gender' => '-',
                    'tgl_lahir' => '-',
                    'hp' => trim($row->d2_hp ?: '-'),
                    'email' => '-',
                    'alamat' => strtoupper(trim($row->d2_addr ?: '-')),
                    'kendaraan' => trim($row->d2_chassis ?: '-'),
                    'transaksi' => $formatDate($row->d2_date),
                    'service' => '-',
                    'diperbarui' => $formatDate($row->d2_date ?: '02/07/2024'),
                    'kelengkapan' => '70/100',
                ];
                $dataRight['kelengkapan'] = $calcKelengkapan($dataRight);

                $pairs[] = [
                    'id' => $pairId++,
                    'rule_code' => 'R1',
                    'match_type' => 'NIK Sama',
                    'score' => 95,
                    'confidence_level' => 'High',
                    'status' => 'Pending',
                    'data_left' => $dataLeft,
                    'data_right' => $dataRight,
                ];
            }

        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("DuplicateReview scanDuplicatePairs error: " . $e->getMessage());
        }

        return $pairs;
    }

    private function isInstitusi(?string $nama): bool
    {
        if (empty($nama)) return false;
        return (bool)preg_match('/\b(PT|CV|UD|PD|KOPERASI|YAYASAN|DINAS|PEMKAB|PEMKOT|POLRES|POLDA|KORAMIL|KODIM|PUSKESMAS|RSUD|BANK|LEASING|FINANCE|RENTAL|MULTI\s+ARTHA|AUTO|MOTOR|TRANSPORT|LOGISTIK)\b/i', $nama);
    }
}
