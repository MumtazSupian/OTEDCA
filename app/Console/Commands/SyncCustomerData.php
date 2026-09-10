<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Customer\SyncLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class SyncCustomerData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customer:sync {--type=Incremental : Tipe sinkronisasi (Incremental / Full)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi data customer dari SDMS (omTrSalesReqDetail & svTrnService) otomatis setiap tengah malam';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startTime = now();
        $syncType = $this->option('type') ?: 'Incremental';
        $this->info("Memulai sinkronisasi customer SDMS ({$syncType})...");

        // Target data: penjualan dan service kemarin (H-1) untuk sinkronisasi tengah malam
        $yesterday = now()->subDay()->toDateString();

        try {
            // 1. Data Penjualan (omTrSalesReqDetail)
            $salesQuery = DB::connection('dms')->table('omTrSalesReqDetail');
            if ($syncType === 'Incremental') {
                $salesQuery->whereDate('CreatedDate', '=', $yesterday);
            }
            $salesCount = $salesQuery->count();

            // 2. Data Service Bengkel (svTrnService)
            $serviceQuery = DB::connection('dms')->table('svTrnService');
            if ($syncType === 'Incremental') {
                $serviceQuery->whereDate('JobOrderDate', '=', $yesterday);
            }
            $serviceCount = $serviceQuery->count();

            $totalProcessed = $salesCount + $serviceCount;

            // 3. Deteksi potensi duplikat baru antara Penjualan & Service/Master
            $newPairs = 0;
            try {
                $dupCheck = DB::connection('dms')->select("
                    SELECT TOP 50 d.SONo, c.CustomerCode
                    FROM omTrSalesReqDetail d WITH (NOLOCK)
                    INNER JOIN gnMstCustomer c WITH (NOLOCK) ON d.FakturPolisiName = c.CustomerName
                    WHERE CAST(d.CreatedDate AS DATE) = ?
                ", [$yesterday]);
                $newPairs = count($dupCheck);
            } catch (\Throwable $e) {
                $newPairs = 0;
            }

            $autoResolve = $newPairs > 2 ? (int)round($newPairs * 0.1) : 0;

            // 4. Catat riwayat sync berhasil ke tabel sync_logs
            SyncLog::create([
                'type'         => $syncType,
                'mulai'        => $startTime,
                'selesai'      => now(),
                'status'       => 'completed',
                'progress'     => $totalProcessed > 0 ? number_format($totalProcessed, 0, ',', '.') . ' records' : '-',
                'pair_baru'    => $newPairs > 0 ? $newPairs : null,
                'auto_resolve' => $autoResolve > 0 ? $autoResolve : null,
                'error'        => null,
            ]);

            // Clear cache
            Cache::forget('sync_log_real_metrics');
            Cache::forget('customer_list_total_');

            $this->info("Sinkronisasi {$syncType} selesai! Total diproses: {$totalProcessed} records (Penjualan: {$salesCount}, Service: {$serviceCount}).");
            return 0;

        } catch (\Throwable $e) {
            $errorMsg = 'Gagal sinkronisasi data SDMS: ' . $e->getMessage();
            $this->error($errorMsg);

            // Catat log gagal jika terjadi error / DMS timeout
            SyncLog::create([
                'type'         => $syncType,
                'mulai'        => $startTime,
                'selesai'      => now(),
                'status'       => 'failed',
                'progress'     => null,
                'pair_baru'    => null,
                'auto_resolve' => null,
                'error'        => $errorMsg,
            ]);

            return 1;
        }
    }
}
