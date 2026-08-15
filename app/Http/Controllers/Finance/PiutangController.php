<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Piutang;
use App\Models\Finance\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PiutangController extends Controller
{
    private const GR_BRANCHES = ['cinere', 'jatiasih', 'cianjur', 'ciawi'];

    private const BRANCH_CODE_MAP = [
        'ciawi'    => '641940101',
        'cianjur'  => '641940102',
        'cinere'   => '641940103',
        'jatiasih' => '641940104',
        'bp'       => '641940105',
        'cipanas'  => '641940106',
    ];

    /* =========================================================================
       BP (BODY & PAINT) SECTION - STRICT HANYA KODE CABANG 05 (IC05 / IA05 / II05)
       ========================================================================= */
    public function indexBp(Request $request)
    {
        /** @var \App\Models\Finance\User $user */
        $user = Auth::user();
        abort_if((! ($user->is_admin ?? false)) && $user->branch !== 'bp', 403, 'Unauthorized action.');

        $year = $request->input('year');

        // 1. Bersihkan invoice nyasar selain 05 pada BP
        Piutang::where('branch', 'bp')
            ->where(function ($q) {
                $q->where('no_bukti', 'NOT LIKE', 'IC05%')
                  ->where('no_bukti', 'NOT LIKE', 'IA05%')
                  ->where('no_bukti', 'NOT LIKE', 'II05%')
                  ->where('no_bukti', 'NOT LIKE', '%05/%');
            })
            ->delete();

        // 2. Ambil data BP BELUM LUNAS dari DMS (Semua tahun yang belum lunas)
        try {
            $dmsQuery = DB::connection('dms')->table('svTrnService as s')
                ->leftJoin('gnMstCustomer as c', 's.CustomerCode', '=', 'c.CustomerCode')
                ->leftJoin('arTrnBankKasTerimaInvoice as b', function ($join) {
                    $join->on('s.InvoiceNo', '=', 'b.InvoiceNo')
                         ->where('b.ProfitCenterCode', '=', '200');
                })
                ->where(function ($q) {
                    $q->where('s.InvoiceNo', 'LIKE', 'IC05%')
                      ->orWhere('s.InvoiceNo', 'LIKE', 'IA05%')
                      ->orWhere('s.InvoiceNo', 'LIKE', 'II05%')
                      ->orWhere(function ($sub) {
                          $sub->where('s.BranchCode', '641940105')
                              ->where(function ($sub2) {
                                  $sub2->where('s.InvoiceNo', 'LIKE', 'IC%')
                                       ->orWhere('s.InvoiceNo', 'LIKE', 'II%')
                                       ->orWhere('s.InvoiceNo', 'LIKE', 'IA%');
                              });
                      });
                })
                ->where(function ($q) {
                    $q->where('s.InvoiceNo', 'LIKE', '%05/%')
                      ->orWhere('s.InvoiceNo', 'LIKE', 'IC05%')
                      ->orWhere('s.InvoiceNo', 'LIKE', 'IA05%')
                      ->orWhere('s.InvoiceNo', 'LIKE', 'II05%');
                })
                ->whereNotNull('s.InvoiceNo')
                ->where('s.InvoiceNo', '!=', '')
                ->whereNull('b.InvoiceNo') // HANYA TRANSAKSI YANG BELUM LUNAS
                ->select([
                    's.JobOrderNo as no_spk',
                    's.InvoiceNo as no_bukti',
                    's.JobOrderDate as tgl_bukti',
                    's.PoliceRegNo as no_polisi',
                    's.TotalSrvAmount as saldo_awal',
                    's.AsuransiBdr as nama_asuransi',
                    DB::raw("COALESCE(NULLIF(TRIM(c.CustomerName), ''), NULLIF(TRIM(c.CustomerGovName), ''), '-') as nama_konsumen"),
                    'c.CustomerType as cust_type',
                    'c.CustomerGovName as perusahaan_name',
                ])
                ->orderByDesc('s.JobOrderDate');

            if (!empty($year) && is_numeric($year)) {
                $dmsQuery->whereYear('s.JobOrderDate', (int)$year);
            }

            $dmsRecords = $dmsQuery->get();

            // Sinkronkan data belum lunas, perbaiki nama kosong, & update pelunasan
            $this->syncDmsToLocal($dmsRecords, 'bp');
            $this->syncMissingMasterData('bp');
            $this->syncDmsPayments('bp');
        } catch (\Throwable $e) {
            Log::error("Gagal sinkronisasi data DMS BP: " . $e->getMessage());
        }

        // 3. Ambil data HANYA YANG BELUM LUNAS (saldo_akhir > 0)
        $queryLocal = Piutang::where('branch', 'bp')
            ->where('saldo_akhir', '>', 0)
            ->where(function ($q) {
                $q->where('no_bukti', 'LIKE', 'IC05%')
                  ->orWhere('no_bukti', 'LIKE', 'IA05%')
                  ->orWhere('no_bukti', 'LIKE', 'II05%')
                  ->orWhere('no_bukti', 'LIKE', '%05/%');
            });

        if (!empty($year) && is_numeric($year)) {
            $queryLocal->whereYear('tgl_bukti', (int)$year);
        }

        $records = $queryLocal->orderByDesc('tgl_bukti')->orderByDesc('id')->get();

        $totalSaldoAwal  = $records->sum('saldo_awal');
        $totalDebet      = $records->sum('debet');
        $totalKredit     = $records->sum(fn ($item) => ($item->kredit ?? 0) + ($item->kredit_2 ?? 0) + ($item->kredit_3 ?? 0));
        $totalSaldoAkhir = $records->sum('saldo_akhir');
        $totalSelisih    = $records->sum(function ($item) {
            $realKredit = ($item->kredit ?? 0) + ($item->kredit_2 ?? 0) + ($item->kredit_3 ?? 0);
            return ($item->saldo_awal + $item->debet - $realKredit) - $item->saldo_akhir;
        });

        return view('Finance.ar.bp.index', compact(
            'records', 'totalSaldoAwal', 'totalDebet', 'totalKredit', 'totalSaldoAkhir', 'totalSelisih', 'year'
        ));
    }

    public function storeBp(Request $request)
    {
        /** @var \App\Models\Finance\User $user */
        $user = Auth::user();
        abort_unless(($user->is_admin ?? false), 403, 'Unauthorized action.');

        return $this->store($request, 'bp');
    }

    public function editBp($id)
    {
        /** @var \App\Models\Finance\User $user */
        $user = Auth::user();
        abort_if((! ($user->is_admin ?? false)) && $user->branch !== 'bp', 403, 'Unauthorized action.');

        $record = Piutang::where('branch', 'bp')->findOrFail($id);

        return view('Finance.ar.bp.edit', compact('record', 'id'));
    }

    public function updateBp(Request $request, $id)
    {
        /** @var \App\Models\Finance\User $user */
        $user = Auth::user();
        abort_if((! ($user->is_admin ?? false)) && $user->branch !== 'bp', 403, 'Unauthorized action.');

        $record = Piutang::where('branch', 'bp')->findOrFail($id);

        $data = $this->validateData($request, true, $record, 'bp');
        
        unset($data['tgl_bukti'], $data['no_bukti'], $data['saldo_awal']);
        $data['saldo_awal'] = $record->saldo_awal;

        $data = $this->preserveHiddenPaymentStages($data, $record);
        $data = $this->normalizeNumericData($data);

        $data['kredit']   = $data['kredit_stage1'] ?? $record->kredit;
        $data['kredit_2'] = $data['kredit_stage2'] ?? $record->kredit_2;
        $data['kredit_3'] = $data['kredit_stage3'] ?? $record->kredit_3;

        $this->enforcePaymentRules($data, $record, 'bp');

        $data['saldo_akhir'] = $this->calculateSaldoAkhir($data, $record);

        $record->update($data);

        return redirect('/bp');
    }

    public function destroyBp($id)
    {
        /** @var \App\Models\Finance\User $user */
        $user = Auth::user();
        abort_unless(($user->is_admin ?? false), 403, 'Unauthorized action.');

        $record = Piutang::where('branch', 'bp')->findOrFail($id);
        $record->delete();

        return redirect('/bp');
    }

    /* =========================================================================
       GR (GENERAL REPAIR) SECTION - STRICT HANYA INVOICE IC, II, IA
       ========================================================================= */
    public function indexGr(Request $request, $branch)
    {
        $this->validateBranch($branch);
        $bCode = self::BRANCH_CODE_MAP[$branch] ?? null;

        $year = $request->input('year');

        // 1. Ambil data transaksi BELUM LUNAS dari DMS (Semua tahun yang belum lunas)
        if ($bCode) {
            try {
                $dmsQuery = DB::connection('dms')->table('svTrnService as s')
                    ->leftJoin('gnMstCustomer as c', 's.CustomerCode', '=', 'c.CustomerCode')
                    ->leftJoin('arTrnBankKasTerimaInvoice as b', function ($join) {
                        $join->on('s.InvoiceNo', '=', 'b.InvoiceNo')
                             ->where('b.ProfitCenterCode', '=', '200');
                    })
                    ->where('s.BranchCode', $bCode)
                    ->whereNotNull('s.InvoiceNo')
                    ->where('s.InvoiceNo', '!=', '')
                    ->where(function ($q) {
                        $q->where('s.InvoiceNo', 'LIKE', 'IC%')
                          ->orWhere('s.InvoiceNo', 'LIKE', 'II%')
                          ->orWhere('s.InvoiceNo', 'LIKE', 'IA%');
                    })
                    ->whereNull('b.InvoiceNo') // HANYA TRANSAKSI YANG BELUM LUNAS
                    ->select([
                        's.JobOrderNo as no_spk',
                        's.InvoiceNo as no_bukti',
                        's.JobOrderDate as tgl_bukti',
                        's.PoliceRegNo as no_polisi',
                        's.TotalSrvAmount as saldo_awal',
                        's.AsuransiBdr as nama_asuransi',
                        DB::raw("COALESCE(NULLIF(TRIM(c.CustomerName), ''), NULLIF(TRIM(c.CustomerGovName), ''), '-') as nama_konsumen"),
                        'c.CustomerType as cust_type',
                        'c.CustomerGovName as perusahaan_name',
                    ])
                    ->orderByDesc('s.JobOrderDate');

                if (!empty($year) && is_numeric($year)) {
                    $dmsQuery->whereYear('s.JobOrderDate', (int)$year);
                }

                $dmsRecords = $dmsQuery->get();

                // Sinkronkan data belum lunas, perbaiki nama kosong, & update pelunasan
                $this->syncDmsToLocal($dmsRecords, $branch);
                $this->syncMissingMasterData($branch);
                $this->syncDmsPayments($branch);
            } catch (\Throwable $e) {
                Log::error("Gagal connect / ambil data DMS svTrnService untuk cabang {$branch}: " . $e->getMessage());
            }
        }

        // 2. Ambil data HANYA YANG BELUM LUNAS (saldo_akhir > 0)
        $queryLocal = Piutang::with('perusahaan')
            ->where('branch', $branch)
            ->where('saldo_akhir', '>', 0)
            ->where(function ($q) {
                $q->where('no_bukti', 'LIKE', 'IC%')
                  ->orWhere('no_bukti', 'LIKE', 'II%')
                  ->orWhere('no_bukti', 'LIKE', 'IA%');
            });

        if (!empty($year) && is_numeric($year)) {
            $queryLocal->whereYear('tgl_bukti', (int)$year);
        }

        $records = $queryLocal->orderByDesc('tgl_bukti')->orderByDesc('id')->get();

        $totalSaldoAwal  = $records->sum('saldo_awal');
        $totalDebet      = $records->sum('debet');
        $totalKredit     = $records->sum(fn ($item) => ($item->kredit ?? 0) + ($item->kredit_2 ?? 0) + ($item->kredit_3 ?? 0));
        $totalSaldoAkhir = $records->sum('saldo_akhir');
        $totalSelisih    = $records->sum(function ($item) {
            $realKredit = ($item->kredit ?? 0) + ($item->kredit_2 ?? 0) + ($item->kredit_3 ?? 0);
            return ($item->saldo_awal + $item->debet - $realKredit) - $item->saldo_akhir;
        });

        $perusahaans = Perusahaan::orderBy('nama', 'asc')->get();

        return view("Finance.ar.gr.$branch.index", compact(
            'records', 'totalSaldoAwal', 'totalDebet', 'totalKredit', 'totalSaldoAkhir', 'totalSelisih', 'perusahaans', 'year'
        ));
    }

    public function storeGr(Request $request, $branch)
    {
        $this->validateBranch($branch);

        /** @var \App\Models\Finance\User $user */
        $user = Auth::user();
        abort_unless(($user->is_admin ?? false), 403, 'Unauthorized action.');

        return $this->store($request, $branch);
    }

    public function editGr($branch, $id)
    {
        $this->validateBranch($branch);

        $record = Piutang::where('branch', $branch)->findOrFail($id);
        $perusahaans = Perusahaan::orderBy('nama', 'asc')->get();

        return view("Finance.ar.gr.$branch.edit", compact('record', 'id', 'perusahaans'));
    }

    public function updateGr(Request $request, $branch, $id)
    {
        $this->validateBranch($branch);
        return $this->update($request, $branch, $id);
    }

    public function destroyGr($branch, $id)
    {
        $this->validateBranch($branch);

        /** @var \App\Models\Finance\User $user */
        $user = Auth::user();
        abort_unless(($user->is_admin ?? false), 403, 'Unauthorized action.');

        Piutang::where('branch', $branch)->findOrFail($id)->delete();

        return redirect("/gr/$branch");
    }

    /* =========================================================================
       HELPER METHODS (LOGIC SINKRONISASI DMS KE DB LOKAL & PERHITUNGAN)
       ========================================================================= */
    private function syncDmsToLocal($dmsRecords, string $branch): void
    {
        // 1. Bersihkan invoice selain IC, II, IA dari database lokal
        Piutang::where('branch', $branch)
            ->whereNotNull('no_bukti')
            ->where('no_bukti', '!=', '-')
            ->where(function ($q) {
                $q->where('no_bukti', 'NOT LIKE', 'IC%')
                  ->where('no_bukti', 'NOT LIKE', 'II%')
                  ->where('no_bukti', 'NOT LIKE', 'IA%');
            })
            ->delete();

        // 2. Khusus BP: bersihkan invoice selain kode cabang 05
        if ($branch === 'bp') {
            Piutang::where('branch', 'bp')
                ->where(function ($q) {
                    $q->where('no_bukti', 'NOT LIKE', 'IC05%')
                      ->where('no_bukti', 'NOT LIKE', 'IA05%')
                      ->where('no_bukti', 'NOT LIKE', 'II05%')
                      ->where('no_bukti', 'NOT LIKE', '%05/%');
                })
                ->delete();
        }

        if (empty($dmsRecords) || $dmsRecords->isEmpty()) {
            return;
        }

        $existing = Piutang::where('branch', $branch)
            ->whereIn('no_spk', $dmsRecords->pluck('no_spk')->toArray())
            ->get()
            ->keyBy('no_spk');

        foreach ($dmsRecords as $dms) {
            $spk = trim($dms->no_spk);
            if (empty($spk)) continue;

            $inv = trim($dms->no_bukti ?? '');
            $invPrefix = strtoupper(substr($inv, 0, 2));

            if (!in_array($invPrefix, ['IC', 'II', 'IA'], true)) {
                continue;
            }

            if ($branch === 'bp') {
                $invUpper = strtoupper($inv);
                if (!str_starts_with($invUpper, 'IC05') && !str_starts_with($invUpper, 'IA05') && !str_starts_with($invUpper, 'II05') && strpos($invUpper, '05/') === false) {
                    continue;
                }
            }

            $saldoAwal    = (float)($dms->saldo_awal ?? 0);
            $tipeKonsumen = ($dms->cust_type === 'C') ? 'perusahaan' : 'reguler';
            $namaKonsumen = trim($dms->nama_konsumen ?? '') ?: '-';
            
            $kategoriSpk = match ($invPrefix) {
                'IA' => 'ASURANSI',
                'IC' => 'REGULER',
                'II' => 'INTERNAL',
                default => 'REGULER'
            };

            // Nama asuransi hanya jika kategori SPK adalah ASURANSI atau ada data asuransi
            $namaAsuransi = $dms->nama_asuransi ?: ($kategoriSpk === 'ASURANSI' ? $dms->perusahaan_name : null);

            $local = $existing->get($spk);

            if (!$local) {
                Piutang::create([
                    'branch'          => $branch,
                    'no_spk'          => $spk,
                    'no_bukti'        => $inv ?: '-',
                    'tgl_bukti'       => $dms->tgl_bukti ? date('Y-m-d', strtotime($dms->tgl_bukti)) : now()->toDateString(),
                    'nama_konsumen'   => $namaKonsumen,
                    'tipe_konsumen'   => $tipeKonsumen,
                    'nama_asuransi'   => $namaAsuransi,
                    'spk_type'        => $kategoriSpk,
                    'saldo_awal'      => $saldoAwal,
                    'debet'           => 0,
                    'kredit'          => 0,
                    'kredit_2'        => 0,
                    'kredit_3'        => 0,
                    'tgl_bukti_rek'   => null,
                    'keterangan'      => null,
                    'tgl_bukti_rek_2' => null,
                    'keterangan_2'    => null,
                    'tgl_bukti_rek_3' => null,
                    'keterangan_3'    => null,
                    'saldo_akhir'     => $saldoAwal,
                    'no_polisi'       => $dms->no_polisi ?: '-',
                ]);
            } else {
                $updateMaster = [];
                if (($local->nama_konsumen === '-' || empty($local->nama_konsumen)) && $namaKonsumen !== '-') {
                    $updateMaster['nama_konsumen'] = $namaKonsumen;
                }
                if ($local->no_bukti === '-' || empty($local->no_bukti)) {
                    $updateMaster['no_bukti'] = $inv ?: '-';
                }
                if ($local->no_polisi === '-' || empty($local->no_polisi)) {
                    $updateMaster['no_polisi'] = $dms->no_polisi ?: '-';
                }
                if (empty($local->tipe_konsumen)) {
                    $updateMaster['tipe_konsumen'] = $tipeKonsumen;
                }
                if ($local->spk_type !== $kategoriSpk) {
                    $updateMaster['spk_type'] = $kategoriSpk;
                }
                if ($kategoriSpk === 'ASURANSI' && empty($local->nama_asuransi) && $namaAsuransi) {
                    $updateMaster['nama_asuransi'] = $namaAsuransi;
                }

                if (!empty($updateMaster)) {
                    $local->update($updateMaster);
                }
            }
        }
    }

    /**
     * Lengkapi nama konsumen, no polisi, dan tipe konsumen yang masih strip (-) dari DMS svTrnService & gnMstCustomer
     */
    private function syncMissingMasterData(string $branch): void
    {
        try {
            $missingLocals = Piutang::where('branch', $branch)
                ->where(function ($q) {
                    $q->where('nama_konsumen', '-')
                      ->orWhereNull('nama_konsumen')
                      ->orWhere('nama_konsumen', '')
                      ->orWhere('no_polisi', '-')
                      ->orWhereNull('no_polisi')
                      ->orWhere('no_polisi', '');
                })
                ->whereNotNull('no_bukti')
                ->where('no_bukti', '!=', '-')
                ->get();

            if ($missingLocals->isEmpty()) {
                return;
            }

            $invoices = $missingLocals->pluck('no_bukti')->filter()->unique()->toArray();
            if (empty($invoices)) {
                return;
            }

            $dmsMasters = DB::connection('dms')->table('svTrnService as s')
                ->leftJoin('gnMstCustomer as c', 's.CustomerCode', '=', 'c.CustomerCode')
                ->whereIn('s.InvoiceNo', $invoices)
                ->select([
                    's.InvoiceNo as no_bukti',
                    's.PoliceRegNo as no_polisi',
                    's.AsuransiBdr as nama_asuransi',
                    DB::raw("COALESCE(NULLIF(TRIM(c.CustomerName), ''), NULLIF(TRIM(c.CustomerGovName), ''), '-') as nama_konsumen"),
                    'c.CustomerType as cust_type',
                    'c.CustomerGovName as perusahaan_name',
                ])
                ->get()
                ->keyBy('no_bukti');

            foreach ($missingLocals as $local) {
                $master = $dmsMasters->get(trim($local->no_bukti));
                if ($master) {
                    $namaCust = trim($master->nama_konsumen ?? '') ?: '-';
                    $tipeKons = ($master->cust_type === 'C') ? 'perusahaan' : 'reguler';
                    $namaAsur = $master->nama_asuransi ?: ($local->spk_type === 'ASURANSI' ? $master->perusahaan_name : null);

                    $local->update([
                        'nama_konsumen' => ($namaCust !== '-') ? $namaCust : $local->nama_konsumen,
                        'no_polisi'     => $master->no_polisi ?: $local->no_polisi,
                        'tipe_konsumen' => $tipeKons,
                        'nama_asuransi' => $namaAsur ?: $local->nama_asuransi,
                    ]);
                }
            }
        } catch (\Throwable $e) {
            Log::error("Gagal sync missing master data DMS: " . $e->getMessage());
        }
    }

    /**
     * Sinkronisasi status pelunasan pembayaran dari tabel arTrnBankKasTerimaInvoice di DMS ke Database Lokal
     */
    private function syncDmsPayments(string $branch): void
    {
        try {
            $unpaidLocals = Piutang::where('branch', $branch)
                ->where(function ($q) {
                    $q->where('saldo_akhir', '>', 0)
                      ->orWhereNull('tgl_bukti_rek')
                      ->orWhere('kredit', 0);
                })
                ->whereNotNull('no_bukti')
                ->where('no_bukti', '!=', '-')
                ->get();

            if ($unpaidLocals->isEmpty()) {
                return;
            }

            $invoices = $unpaidLocals->pluck('no_bukti')->filter()->unique()->toArray();
            if (empty($invoices)) {
                return;
            }

            // Cari bukti pembayaran di DMS arTrnBankKasTerimaInvoice
            $payments = DB::connection('dms')->table('arTrnBankKasTerimaInvoice')
                ->where('ProfitCenterCode', '200')
                ->whereIn('InvoiceNo', $invoices)
                ->get()
                ->keyBy('InvoiceNo');

            foreach ($unpaidLocals as $local) {
                $paid = $payments->get(trim($local->no_bukti));
                if ($paid) {
                    $payAmt = (float)($paid->PaymentAmt ?? 0);
                    $payDate = $paid->CreatedDate 
                        ? date('Y-m-d', strtotime($paid->CreatedDate)) 
                        : ($paid->InvoiceDate ? date('Y-m-d', strtotime($paid->InvoiceDate)) : now()->toDateString());
                    $docNo = $paid->DocNo ?: '-';
                    $desc = $paid->Description ?: 'Pelunasan DMS';

                    $saldoAkhir = max(0, (float)$local->saldo_awal + (float)$local->debet - $payAmt - (float)($local->kredit_2 ?? 0) - (float)($local->kredit_3 ?? 0));

                    $local->update([
                        'kredit'        => $payAmt,
                        'tgl_bukti_rek' => $payDate,
                        'no_bukti_rek'  => $docNo,
                        'keterangan'    => $desc,
                        'saldo_akhir'   => $saldoAkhir,
                    ]);
                }
            }
        } catch (\Throwable $e) {
            Log::error("Gagal sync pembayaran DMS arTrnBankKasTerimaInvoice: " . $e->getMessage());
        }
    }

    private function validateBranch(string $branch): void
    {
        if (! in_array($branch, self::GR_BRANCHES, true)) {
            abort(404);
        }

        /** @var \App\Models\Finance\User $user */
        $user = Auth::user();
        abort_if((! ($user->is_admin ?? false)) && $user->branch !== $branch, 403, 'Unauthorized action.');
    }

    private function store(Request $request, string $branch)
    {
        $data = $this->validateData($request);

        if (($data['tipe_konsumen'] ?? '') === 'reguler') {
            $data['perusahaan_id'] = null;
        }

        $data = $this->normalizeNumericData($data);
        $data['branch'] = $branch;

        $data['debet'] = 0;
        $data['kredit'] = 0;
        $data['kredit_2'] = 0;
        $data['kredit_3'] = 0;
        unset($data['tgl_bukti_rek'], $data['no_bukti_rek'], $data['keterangan']);
        unset($data['tgl_bukti_rek_2'], $data['no_bukti_rek_2'], $data['keterangan_2']);
        unset($data['tgl_bukti_rek_3'], $data['no_bukti_rek_3'], $data['keterangan_3']);

        $data['saldo_akhir'] = isset($data['saldo_awal']) ? floatval($data['saldo_awal']) : 0;

        Piutang::create($data);

        return redirect($branch === 'bp' ? '/bp' : "/gr/$branch");
    }

    private function update(Request $request, string $branch, $id)
    {
        $record = Piutang::where('branch', $branch)->findOrFail($id);
        
        $data = $this->validateData($request, true, $record, $branch);

        if (($data['tipe_konsumen'] ?? '') === 'reguler') {
            $data['perusahaan_id'] = null;
        }

        unset($data['tgl_bukti'], $data['no_bukti'], $data['saldo_awal']);
        $data['saldo_awal'] = $record->saldo_awal;

        $data = $this->preserveHiddenPaymentStages($data, $record);
        $data = $this->normalizeNumericData($data);

        $data['kredit']   = $data['kredit_stage1'] ?? 0;
        $data['kredit_2'] = $data['kredit_stage2'] ?? 0;
        $data['kredit_3'] = $data['kredit_stage3'] ?? 0;

        $this->enforcePaymentRules($data, $record, $branch);

        $data['saldo_akhir'] = $this->calculateSaldoAkhir($data, $record);

        $record->update($data);

        return redirect($branch === 'bp' ? '/bp' : "/gr/$branch");
    }

    private function validateData(Request $request, bool $isUpdate = false, $record = null, ?string $branch = null): array
    {
        $numericKeys = ['saldo_awal', 'debet', 'kredit', 'saldo_akhir', 'kredit_stage1', 'kredit_stage2', 'kredit_stage3'];
        foreach ($numericKeys as $key) {
            if ($request->has($key) && $request->input($key) !== null) {
                $cleanValue = str_replace('.', '', $request->input($key));
                $cleanValue = str_replace(',', '.', $cleanValue);
                $request->merge([$key => $cleanValue]);
            }
        }

        $base = [
            'nama_konsumen'   => ['nullable', 'string', 'max:255'],
            'tipe_konsumen'   => ['nullable', 'string', 'in:reguler,perusahaan'],
            'perusahaan_id'   => ['nullable', 'exists:perusahaan,id'],
            'nama_asuransi'   => ['nullable', 'string', 'max:255'],
            'tgl_bukti'       => ['nullable', 'date'],
            'no_bukti'        => ['nullable', 'string', 'max:100'],
            'saldo_awal'      => ['nullable', 'numeric'],
            'debet'           => ['nullable', 'numeric'],
            'kredit'          => ['nullable', 'numeric'],
            'tgl_bukti_rek'   => ['nullable', 'date'],
            'no_bukti_rek'    => ['nullable', 'string', 'max:100'],
            'keterangan'      => ['nullable', 'string', 'max:255'],
            'kredit_stage1'   => ['nullable', 'numeric'],
            'tgl_bukti_rek_2' => ['nullable', 'date'],
            'no_bukti_rek_2'  => ['nullable', 'string', 'max:100'],
            'keterangan_2'    => ['nullable', 'string', 'max:255'],
            'kredit_stage2'   => ['nullable', 'numeric'],
            'tgl_bukti_rek_3' => ['nullable', 'date'],
            'no_bukti_rek_3'  => ['nullable', 'string', 'max:100'],
            'keterangan_3'    => ['nullable', 'string', 'max:255'],
            'kredit_stage3'   => ['nullable', 'numeric'],
            'no_polisi'       => ['nullable', 'string', 'max:100'],
            'no_polis'        => ['nullable', 'string', 'max:100'],
            'spk_type'        => ['nullable', 'string', 'in:ASURANSI,REGULER,INTERNAL'],
            'no_spk'          => ['nullable', 'string', 'max:100'],
            'saldo_akhir'     => ['nullable', 'numeric'],
        ];

        if ($isUpdate) {
            $base['no_spk']        = ['required', 'string', 'max:100'];
            $base['nama_konsumen'] = ['required', 'string', 'max:255'];
            $base['no_polisi']     = ['required', 'string', 'max:100'];
            $base['no_polis']      = [strtolower($branch ?? '') === 'bp' ? 'required' : 'nullable', 'string', 'max:100'];
            $base['spk_type']      = ['required', 'string', 'in:ASURANSI,REGULER,INTERNAL'];
            $base['tgl_bukti']     = ['required', 'date'];
            $base['no_bukti']      = ['required', 'string', 'max:100'];
            $base['saldo_awal']    = ['required', 'numeric'];
            $base['saldo_akhir']   = ['required', 'numeric'];
            $base['debet']         = ['nullable', 'numeric'];

            if ($record) {
                if (!$record->tgl_bukti_rek) {
                    $base['tgl_bukti_rek'] = ['required', 'date'];
                    $base['keterangan']    = ['required', 'string', 'max:255'];
                    $base['kredit_stage1'] = ['required', 'numeric'];
                } elseif ($record->tgl_bukti_rek && !$record->tgl_bukti_rek_2) {
                    $base['tgl_bukti_rek_2'] = ['required', 'date'];
                    $base['keterangan_2']    = ['required', 'string', 'max:255'];
                    $base['kredit_stage2']   = ['required', 'numeric'];
                } elseif ($record->tgl_bukti_rek_2 && !$record->tgl_bukti_rek_3 && ($record->spk_type === 'ASURANSI' || $request->input('spk_type') === 'ASURANSI')) {
                    $base['tgl_bukti_rek_3'] = ['required', 'date'];
                    $base['keterangan_3']    = ['required', 'string', 'max:255'];
                    $base['kredit_stage3']   = ['required', 'numeric'];
                }
            }
        }

        return $request->validate($base);
    }

    private function normalizeNumericData(array $data): array
    {
        $numericKeys = ['saldo_awal', 'debet', 'kredit', 'kredit_stage1', 'kredit_stage2', 'kredit_stage3'];
        foreach ($numericKeys as $key) {
            if (! isset($data[$key]) || $data[$key] === null || $data[$key] === '') {
                $data[$key] = 0;
            }
        }
        return $data;
    }

    private function calculateSaldoAkhir(array $data, $record = null): float
    {
        $saldoAwal = isset($data['saldo_awal']) ? floatval($data['saldo_awal']) : ($record ? floatval($record->saldo_awal) : 0);
        $debet     = isset($data['debet']) ? floatval($data['debet']) : ($record ? floatval($record->debet) : 0);
        
        $kredit1 = isset($data['kredit']) ? floatval($data['kredit']) : 0;
        $kredit2 = isset($data['kredit_2']) ? floatval($data['kredit_2']) : 0;
        $kredit3 = isset($data['kredit_3']) ? floatval($data['kredit_3']) : 0;

        return $saldoAwal + $debet - ($kredit1 + $kredit2 + $kredit3);
    }

    private function enforcePaymentRules(array &$data, Piutang $record, string $branch): void
    {
        if (array_key_exists('debet', $data)) {
            $newDebet = floatval($data['debet']);
            if ($record->debet && $newDebet !== floatval($record->debet)) {
                abort(422, 'Debet hanya bisa diinput sekali.');
            }
        }
    }

    private function preserveHiddenPaymentStages(array $data, Piutang $record): array
    {
        foreach ([
            'tgl_bukti_rek_2', 'no_bukti_rek_2', 'keterangan_2',
            'tgl_bukti_rek_3', 'no_bukti_rek_3', 'keterangan_3',
        ] as $field) {
            if (array_key_exists($field, $data) && ($data[$field] === null || $data[$field] === '')) {
                unset($data[$field]);
            }
        }
        return $data;
    }
}