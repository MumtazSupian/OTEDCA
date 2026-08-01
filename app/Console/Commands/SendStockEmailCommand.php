<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Stock;
use App\Mail\StockNotificationMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendStockEmailCommand extends Command
{
    protected $signature = 'app:send-stock-email';
    protected $description = 'Send email for all stocks created on the previous day to all recipients';

    public function handle()
    {
        $this->info('Mulai mengecek semua data stock yang diinput kemarin...');

        $penerimaTanpaHarga = [
            'it@dutacendana.com',
            'bm.cwi@suzukidutacendana.com',
            'bm.cjr@suzukidutacendana.com',
            'bm.cnr@suzukidutacendana.com',
            'bm.jts@suzukidutacendana.com',
            'adh.cwi@suzukidutacendana.com',
            'adh.cjr@suzukidutacendana.com',
            'adh.cnr@suzukidutacendana.com',
            'adh.jts@suzukidutacendana.com',
            'shcwi.dca@gmail.com',
            'shcjr.dca@gmail.com',
            'shcnr.dca@gmail.com',
            'shbks.dca@gmail.com',
            'stock@suzukidutacendana.com',
            'ahmadmad122131@gmail.com'
        ];

        $penerimaDenganHarga = [
            'it@dutacendana.com',
            'om@suzukidutacendana.com',
            'vwilliam@dutacendana.com',
            'fineke99@gmail.com',
            'stock@suzukidutacendana.com',
            'm.rizky@smkwikrama.sch.id'
        ];

        $parseStockDate = function ($value) {
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

        // Get all stocks but filter out sold items that are not in the current month
        $stocks = Stock::all()->filter(function ($stock) use ($parseStockDate) {
            $status = strtolower(trim($stock->status ?? ''));
            if ($status !== 'sold') {
                return true;
            }

            $dateValue = $stock->tanggal_matching_do ?: $stock->tanggal_do;
            $date = $parseStockDate($dateValue);

            return $date
                && $date->month === now()->month
                && $date->year === now()->year
                && $date->lessThanOrEqualTo(now());
        })->values();

        if ($stocks->isEmpty()) {
            $this->info('Tidak ada data stock di tabel.');
            return;
        }

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

        $dashboardData = [
            'totalStock' => $totalStock,
            'stockByStatus' => $stockByStatus,
        ];

        Mail::mailer('smtp_stock')
            ->to($penerimaTanpaHarga)
            ->send(new StockNotificationMail($stocks, false, $dashboardData));

        Mail::mailer('smtp_stock')
            ->to($penerimaDenganHarga)
            ->send(new StockNotificationMail($stocks, true, $dashboardData));

        $this->info("Email stock sukses dikirim (Total: {$stocks->count()} unit). ");
        $this->info('Selesai memproses email stock.');
    }
}
