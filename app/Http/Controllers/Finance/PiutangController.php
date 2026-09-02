<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Piutang;
use App\Models\Finance\Perusahaan;
use App\Exports\PiutangExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
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

        // ========================================================
        // [SCRIPT SEMENTARA PEMBERSIH DATA DUPLIKAT MASA LALU]
        // ========================================================
        try {
            $duplicates = DB::select("
                SELECT no_bukti, MIN(id) as keep_id
                FROM piutangs
                WHERE branch = ? AND no_bukti IS NOT NULL AND no_bukti != '-'
                GROUP BY no_bukti
                HAVING COUNT(*) > 1
            ", ['bp']);
            
            foreach ($duplicates as $dup) {
                Piutang::where('branch', 'bp')
                    ->where('no_bukti', $dup->no_bukti)
                    ->where('id', '!=', $dup->keep_id)
                    ->delete();
            }
        } catch (\Throwable $e) {}
        // ========================================================

        // 1. Bersihkan invoice nyasar selain 05 pada BP
        Piutang::where('branch', 'bp')
            ->where(function ($q) {
                $q->where('no_bukti', 'NOT LIKE', 'IC05%')
                  ->where('no_bukti', 'NOT LIKE', 'IA05%')
                  ->where('no_bukti', 'NOT LIKE', 'II05%')
                  ->where('no_bukti', 'NOT LIKE', '%05/%');
            })
            ->delete();

        // 2. Ambil data BP BELUM LUNAS dari DMS
        try {
            $dmsQuery = DB::connection('dms')->table('svTrnInvoice as s')
                ->join('svTrnService as srv', 's.InvoiceNo', '=', 'srv.InvoiceNo') // LOGIC BARU
                ->leftJoin('gnMstCustomer as c', 's.CustomerCode', '=', 'c.CustomerCode')
                ->leftJoin('svMstAsuransiBDR as asu', 'srv.AsuransiBdr', '=', 'asu.KodeAsuransi')
                ->leftJoin('gnMstCustomer as asu_cust', 'srv.AsuransiBdr', '=', 'asu_cust.CustomerCode')
                ->leftJoin(DB::raw('(SELECT InvoiceNo, MIN(ReceivableOutstand) as CurrentOutstand FROM arTrnBankKasTerimaInvoice WHERE BranchCode IN (\'641940101\', \'641940102\', \'641940103\', \'641940104\', \'641940105\') GROUP BY InvoiceNo) as b'), 's.InvoiceNo', '=', 'b.InvoiceNo')
                ->where(function($q) {
                    $q->whereNull('b.InvoiceNo')
                      ->orWhere('b.CurrentOutstand', '>', 0);
                })
                // CEGAH INVOICE YANG ADA DI arTrnDbCrNoteDtl DARI DITARIK KE APLIKASI
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                          ->from('arTrnDbCrNoteDtl as d')
                          ->whereColumn('d.InvoiceNo', 's.InvoiceNo');
                })
                ->where('s.InvoiceStatus', '2')
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
                ->select([
                    's.JobOrderNo as no_spk',
                    's.InvoiceNo as no_bukti',
                    's.JobOrderDate as tgl_bukti',
                    's.PoliceRegNo as no_polisi',
                    's.TotalSrvAmt as saldo_awal',
                    DB::raw("COALESCE(NULLIF(TRIM(asu.NamaAsuransi), ''), NULLIF(TRIM(asu_cust.CustomerName), ''), NULLIF(TRIM(asu_cust.CustomerGovName), ''), srv.AsuransiBdr) as nama_asuransi"),
                    DB::raw("COALESCE(NULLIF(TRIM(c.CustomerName), ''), NULLIF(TRIM(c.CustomerGovName), ''), '-') as nama_konsumen"),
                    'c.CustomerType as cust_type',
                    'c.CustomerGovName as perusahaan_name',
                ])
                ->orderByDesc('s.JobOrderDate');

            if (!empty($year) && is_numeric($year)) {
                $dmsQuery->whereYear('s.JobOrderDate', (int)$year);
            }

            $dmsRecords = $dmsQuery->get();

            $this->syncDmsToLocal($dmsRecords, 'bp');
            $this->syncMissingMasterData('bp');
            $this->syncDmsPayments('bp');
            $this->cleanupCancelledInvoices('bp');
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

        // ========================================================
        // [SCRIPT SEMENTARA PEMBERSIH DATA DUPLIKAT MASA LALU]
        // ========================================================
        try {
            $duplicates = DB::select("
                SELECT no_bukti, MIN(id) as keep_id
                FROM piutangs
                WHERE branch = ? AND no_bukti IS NOT NULL AND no_bukti != '-'
                GROUP BY no_bukti
                HAVING COUNT(*) > 1
            ", [$branch]);
            
            foreach ($duplicates as $dup) {
                Piutang::where('branch', $branch)
                    ->where('no_bukti', $dup->no_bukti)
                    ->where('id', '!=', $dup->keep_id)
                    ->delete();
            }
        } catch (\Throwable $e) {}
        // ========================================================

        // 1. Ambil data transaksi BELUM LUNAS dari DMS 
        if ($bCode) {
            try {
                $dmsQuery = DB::connection('dms')->table('svTrnInvoice as s')
                    ->join('svTrnService as srv', 's.InvoiceNo', '=', 'srv.InvoiceNo') // LOGIC BARU
                    ->leftJoin('gnMstCustomer as c', 's.CustomerCode', '=', 'c.CustomerCode')
                    ->leftJoin('svMstAsuransiBDR as asu', 'srv.AsuransiBdr', '=', 'asu.KodeAsuransi')
                    ->leftJoin('gnMstCustomer as asu_cust', 'srv.AsuransiBdr', '=', 'asu_cust.CustomerCode')
                    // LOGIC BARU: Menggunakan Left Join agar Invoice yang belum dibayar tetap masuk
                    ->leftJoin(DB::raw('(SELECT InvoiceNo, MIN(ReceivableOutstand) as CurrentOutstand FROM arTrnBankKasTerimaInvoice WHERE BranchCode IN (\'641940101\', \'641940102\', \'641940103\', \'641940104\', \'641940105\') GROUP BY InvoiceNo) as b'), 's.InvoiceNo', '=', 'b.InvoiceNo')
                    ->where(function($q) {
                        $q->whereNull('b.InvoiceNo')
                          ->orWhere('b.CurrentOutstand', '>', 0);
                    })
                    ->whereNotExists(function ($query) {
                        $query->select(DB::raw(1))
                              ->from('arTrnDbCrNoteDtl as d')
                              ->whereColumn('d.InvoiceNo', 's.InvoiceNo');
                    })
                    ->where('s.InvoiceStatus', '2')
                    ->where('s.BranchCode', $bCode)
                    ->whereNotNull('s.InvoiceNo')
                    ->where('s.InvoiceNo', '!=', '')
                    ->where(function ($q) {
                        $q->where('s.InvoiceNo', 'LIKE', 'IC%')
                          ->orWhere('s.InvoiceNo', 'LIKE', 'II%')
                          ->orWhere('s.InvoiceNo', 'LIKE', 'IA%');
                    })
                    ->select([
                        's.JobOrderNo as no_spk',
                        's.InvoiceNo as no_bukti',
                        's.JobOrderDate as tgl_bukti',
                        's.PoliceRegNo as no_polisi',
                        's.TotalSrvAmt as saldo_awal', // Menggunakan TotalSrvAmt
                        DB::raw("COALESCE(NULLIF(TRIM(asu.NamaAsuransi), ''), NULLIF(TRIM(asu_cust.CustomerName), ''), NULLIF(TRIM(asu_cust.CustomerGovName), ''), srv.AsuransiBdr) as nama_asuransi"),
                        DB::raw("COALESCE(NULLIF(TRIM(c.CustomerName), ''), NULLIF(TRIM(c.CustomerGovName), ''), '-') as nama_konsumen"),
                        'c.CustomerType as cust_type',
                        'c.CustomerGovName as perusahaan_name',
                    ])
                    ->orderByDesc('s.JobOrderDate');

                if (!empty($year) && is_numeric($year)) {
                    $dmsQuery->whereYear('s.JobOrderDate', (int)$year);
                }

                $dmsRecords = $dmsQuery->get();

                $this->syncDmsToLocal($dmsRecords, $branch);
                $this->syncMissingMasterData($branch);
                $this->syncDmsPayments($branch);
                $this->cleanupCancelledInvoices($branch); 
            } catch (\Throwable $e) {
                Log::error("Gagal connect / ambil data DMS svTrnInvoice untuk cabang {$branch}: " . $e->getMessage());
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

    private function cleanupCancelledInvoices(string $branch): void
    {
        try {
            $localInvoices = Piutang::where('branch', $branch)
                ->whereNotNull('no_bukti')
                ->where('no_bukti', '!=', '-')
                ->pluck('no_bukti')
                ->toArray();

            if (empty($localInvoices)) return;

            $cancelled = DB::connection('dms')->table('arTrnDbCrNoteDtl')
                ->whereIn('InvoiceNo', $localInvoices)
                ->pluck('InvoiceNo')
                ->toArray();

            if (!empty($cancelled)) {
                Piutang::where('branch', $branch)
                    ->whereIn('no_bukti', $cancelled)
                    ->delete();
            }
        } catch (\Throwable $e) {
            Log::error("Gagal cleanup arTrnDbCrNoteDtl: " . $e->getMessage());
        }
    }

    private function syncDmsToLocal($dmsRecords, string $branch): void
    {
        Piutang::where('branch', $branch)
            ->whereNotNull('no_bukti')
            ->where('no_bukti', '!=', '-')
            ->where(function ($q) {
                $q->where('no_bukti', 'NOT LIKE', 'IC%')
                  ->where('no_bukti', 'NOT LIKE', 'II%')
                  ->where('no_bukti', 'NOT LIKE', 'IA%');
            })
            ->delete();

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
            ->whereIn('no_bukti', $dmsRecords->pluck('no_bukti')->map(fn($v) => trim($v))->filter()->toArray())
            ->get()
            ->keyBy('no_bukti');

        foreach ($dmsRecords as $dms) {
            $spk = trim($dms->no_spk);
            if (empty($spk)) continue;

            $inv = trim($dms->no_bukti ?? '');
            if (empty($inv)) continue; 

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

            $namaAsuransi = $dms->nama_asuransi ?: ($kategoriSpk === 'ASURANSI' ? $dms->perusahaan_name : null);

            $local = $existing->get($inv);

            if (!$local) {
                $newLocal = Piutang::create([
                    'branch'          => $branch,
                    'no_spk'          => $spk,
                    'no_bukti'        => $inv ?: '-',
                    'tgl_bukti'       => $dms->tgl_bukti ? date('Y-m-d', strtotime($dms->tgl_bukti)) : now()->toDateString(),
                    'nama_konsumen'   => $namaKonsumen,
                    'tipe_konsumen'   => $tipeKonsumen,
                    'perusahaan_id'   => null,
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

                // Menyimpan rekaman yang baru ke dalam array existing agar menghindari insert ganda
                $existing->put($inv, $newLocal);

            } else {
                $updateMaster = [];
                if ($namaKonsumen !== '-' && $local->nama_konsumen !== $namaKonsumen) {
                    $updateMaster['nama_konsumen'] = $namaKonsumen;
                }
                if ($local->no_bukti === '-' || empty($local->no_bukti)) {
                    $updateMaster['no_bukti'] = $inv ?: '-';
                }
                if (!empty($dms->no_polisi) && $dms->no_polisi !== '-' && $local->no_polisi !== $dms->no_polisi) {
                    $updateMaster['no_polisi'] = $dms->no_polisi;
                }
                if ($local->tipe_konsumen !== $tipeKonsumen) {
                    $updateMaster['tipe_konsumen'] = $tipeKonsumen;
                    if ($tipeKonsumen === 'reguler' && !empty($local->perusahaan_id)) {
                        $updateMaster['perusahaan_id'] = null;
                    }
                }
                if ($local->spk_type !== $kategoriSpk) {
                    $updateMaster['spk_type'] = $kategoriSpk;
                }
                if ($kategoriSpk === 'ASURANSI' && empty($local->nama_asuransi) && $namaAsuransi) {
                    $updateMaster['nama_asuransi'] = $namaAsuransi;
                }

                // KOREKSI OTOMATIS: Timpa saldo_awal dengan nilai riil dari DMS jika berbeda
                if ($saldoAwal > 0 && $local->saldo_awal != $saldoAwal) {
                    $updateMaster['saldo_awal'] = $saldoAwal;
                }

                if (!empty($updateMaster)) {
                    $local->update($updateMaster);
                }
            }
        }
    }

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

            $dmsMasters = DB::connection('dms')->table('svTrnInvoice as s')
                ->join('svTrnService as srv', 's.InvoiceNo', '=', 'srv.InvoiceNo') // LOGIC BARU: JOIN UNTUK ASURANSI
                ->leftJoin('gnMstCustomer as c', 's.CustomerCode', '=', 'c.CustomerCode')
                ->leftJoin('svMstAsuransiBDR as asu', 'srv.AsuransiBdr', '=', 'asu.KodeAsuransi')
                ->leftJoin('gnMstCustomer as asu_cust', 'srv.AsuransiBdr', '=', 'asu_cust.CustomerCode')
                ->whereIn('s.InvoiceNo', $invoices)
                ->select([
                    's.InvoiceNo as no_bukti',
                    's.PoliceRegNo as no_polisi',
                    DB::raw("COALESCE(NULLIF(TRIM(asu.NamaAsuransi), ''), NULLIF(TRIM(asu_cust.CustomerName), ''), NULLIF(TRIM(asu_cust.CustomerGovName), ''), srv.AsuransiBdr) as nama_asuransi"),
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

            // LOGIC BARU: CHUNK per 1000 agar SQL Server tidak error "maximum of 2100 parameters"
            $payments = collect();
            foreach (array_chunk($invoices, 1000) as $chunk) {
                $chunkPayments = DB::connection('dms')->table('arTrnBankKasTerimaInvoice')
                    ->whereIn('BranchCode', ['641940101', '641940102', '641940103', '641940104', '641940105'])
                    ->whereIn('InvoiceNo', $chunk)
                    ->select(
                        'InvoiceNo',
                        DB::raw('SUM(PaymentAmt) as TotalPaymentAmt'),
                        DB::raw('MIN(ReceivableOutstand) as FinalOutstand'), 
                        DB::raw('MAX(ReceivableAmt) as RealSaldoAwal'), // Untuk fix koreksi DP/Diskon
                        DB::raw('MAX(CreatedDate) as LastPaymentDate'),
                        DB::raw('MAX(DocNo) as LastDocNo') // Ambil DocNo pelunasan
                    )
                    ->groupBy('InvoiceNo')
                    ->get();
                
                $payments = $payments->merge($chunkPayments);
            }

            $payments = $payments->keyBy('InvoiceNo');

            foreach ($unpaidLocals as $local) {
                $pay = $payments->get($local->no_bukti);
                if ($pay) {
                    $payAmt = (float)$pay->TotalPaymentAmt;
                    $finalOutstand = (float)$pay->FinalOutstand;
                    $realSaldoAwal = (float)($pay->RealSaldoAwal ?? 0);

                    // KOREKSI OTOMATIS: Update Saldo Awal ke nilai Invoice Murni
                    if ($realSaldoAwal > 0 && $local->saldo_awal != $realSaldoAwal) {
                        $local->saldo_awal = $realSaldoAwal;
                    }

                    if ($finalOutstand <= 0) {
                        $saldoAkhir = 0;
                    } else {
                        $saldoAkhir = max(0, (float)$local->saldo_awal + (float)$local->debet - $payAmt - (float)($local->kredit_2 ?? 0) - (float)($local->kredit_3 ?? 0));
                    }

                    $payDate = $pay->LastPaymentDate 
                        ? \Carbon\Carbon::parse($pay->LastPaymentDate)->format('Y-m-d')
                        : ($local->tgl_bukti_rek ?: now()->toDateString());
                    $docNo = $pay->LastDocNo ?: '-';

                    $local->update([
                        'saldo_awal'    => $local->saldo_awal, // Menyimpan koreksi Saldo Awal
                        'kredit'        => $payAmt,
                        'tgl_bukti_rek' => $payDate,
                        'no_bukti_rek'  => $docNo,
                        'keterangan'    => 'Pelunasan DMS',
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

    public function exportExcelBp(Request $request)
    {
        $year = $request->input('year');
        $query = Piutang::with('perusahaan')
            ->where('branch', 'bp')
            ->where('saldo_akhir', '>', 0)
            ->where(function ($q) {
                $q->where('no_bukti', 'LIKE', 'IC%')
                  ->orWhere('no_bukti', 'LIKE', 'II%')
                  ->orWhere('no_bukti', 'LIKE', 'IA%');
            });

        if (!empty($year) && is_numeric($year)) {
            $query->whereYear('tgl_bukti', (int)$year);
        }

        $records = $query->orderByDesc('tgl_bukti')->orderByDesc('id')->get();
        $branchTitle = 'BP';

        return Excel::download(new PiutangExport($records, $branchTitle), 'Rekapitulasi_Piutang_BP_' . date('Ymd_His') . '.xlsx');
    }

    public function exportPdfBp(Request $request)
    {
        $year = $request->input('year');
        $query = Piutang::with('perusahaan')
            ->where('branch', 'bp')
            ->where('saldo_akhir', '>', 0)
            ->where(function ($q) {
                $q->where('no_bukti', 'LIKE', 'IC%')
                  ->orWhere('no_bukti', 'LIKE', 'II%')
                  ->orWhere('no_bukti', 'LIKE', 'IA%');
            });

        if (!empty($year) && is_numeric($year)) {
            $query->whereYear('tgl_bukti', (int)$year);
        }

        $records = $query->orderByDesc('tgl_bukti')->orderByDesc('id')->get();
        $branchTitle = 'BP';
        $title = 'Rekapitulasi Piutang - BP';
        
        $totalSaldoAwal  = $records->sum('saldo_awal');
        $totalDebet      = $records->sum('debet');
        $totalKredit     = $records->sum(fn ($item) => ($item->kredit ?? 0) + ($item->kredit_2 ?? 0) + ($item->kredit_3 ?? 0));
        $totalSaldoAkhir = $records->sum('saldo_akhir');
        $totalSelisih    = $records->sum(function ($item) {
            $realKredit = ($item->kredit ?? 0) + ($item->kredit_2 ?? 0) + ($item->kredit_3 ?? 0);
            return ($item->saldo_awal + $item->debet - $realKredit) - $item->saldo_akhir;
        });

        $pdf = Pdf::loadView('Finance.ar.pdf', compact(
            'records', 'branchTitle', 'title', 'totalSaldoAwal', 'totalDebet', 'totalKredit', 'totalSaldoAkhir', 'totalSelisih', 'year'
        ))->setPaper('a3', 'landscape');

        return $pdf->download('Rekapitulasi_Piutang_BP_' . date('Ymd_His') . '.pdf');
    }

    public function exportExcelGr(Request $request, $branch)
    {
        $this->validateBranch($branch);
        $year = $request->input('year');

        $query = Piutang::with('perusahaan')
            ->where('branch', $branch)
            ->where('saldo_akhir', '>', 0)
            ->where(function ($q) {
                $q->where('no_bukti', 'LIKE', 'IC%')
                  ->orWhere('no_bukti', 'LIKE', 'II%')
                  ->orWhere('no_bukti', 'LIKE', 'IA%');
            });

        if (!empty($year) && is_numeric($year)) {
            $query->whereYear('tgl_bukti', (int)$year);
        }

        $records = $query->orderByDesc('tgl_bukti')->orderByDesc('id')->get();
        $branchTitle = 'GR ' . strtoupper($branch);

        return Excel::download(new PiutangExport($records, $branchTitle), 'Rekapitulasi_Piutang_GR_' . strtoupper($branch) . '_' . date('Ymd_His') . '.xlsx');
    }

    public function exportPdfGr(Request $request, $branch)
    {
        $this->validateBranch($branch);
        $year = $request->input('year');

        $query = Piutang::with('perusahaan')
            ->where('branch', $branch)
            ->where('saldo_akhir', '>', 0)
            ->where(function ($q) {
                $q->where('no_bukti', 'LIKE', 'IC%')
                  ->orWhere('no_bukti', 'LIKE', 'II%')
                  ->orWhere('no_bukti', 'LIKE', 'IA%');
            });

        if (!empty($year) && is_numeric($year)) {
            $query->whereYear('tgl_bukti', (int)$year);
        }

        $records = $query->orderByDesc('tgl_bukti')->orderByDesc('id')->get();
        $branchTitle = 'GR ' . strtoupper($branch);
        $title = 'Rekapitulasi Piutang - GR ' . strtoupper($branch);

        $totalSaldoAwal  = $records->sum('saldo_awal');
        $totalDebet      = $records->sum('debet');
        $totalKredit     = $records->sum(fn ($item) => ($item->kredit ?? 0) + ($item->kredit_2 ?? 0) + ($item->kredit_3 ?? 0));
        $totalSaldoAkhir = $records->sum('saldo_akhir');
        $totalSelisih    = $records->sum(function ($item) {
            $realKredit = ($item->kredit ?? 0) + ($item->kredit_2 ?? 0) + ($item->kredit_3 ?? 0);
            return ($item->saldo_awal + $item->debet - $realKredit) - $item->saldo_akhir;
        });

        $pdf = Pdf::loadView('Finance.ar.pdf', compact(
            'records', 'branchTitle', 'title', 'totalSaldoAwal', 'totalDebet', 'totalKredit', 'totalSaldoAkhir', 'totalSelisih', 'year'
        ))->setPaper('a3', 'landscape');

        return $pdf->download('Rekapitulasi_Piutang_GR_' . strtoupper($branch) . '_' . date('Ymd_His') . '.pdf');
    }
}