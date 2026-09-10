<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

ini_set('memory_limit', '-1');
@set_time_limit(300);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>⚡ Sync Log Migration & Fix - OTE DCA</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: #0f172a;
            color: #e2e8f0;
            padding: 40px 20px;
            margin: 0;
        }
        .container {
            max-width: 750px;
            margin: 0 auto;
            background: #1e293b;
            border-radius: 12px;
            padding: 28px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.4);
            border: 1px solid #334155;
        }
        h1 {
            font-size: 20px;
            color: #38bdf8;
            margin-top: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-title {
            font-size: 15px;
            font-weight: 700;
            color: #f1f5f9;
            margin: 20px 0 8px 0;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        pre {
            background: #020617;
            padding: 14px;
            border-radius: 8px;
            color: #a5f3fc;
            font-family: Consolas, "Courier New", Courier, monospace;
            font-size: 13px;
            overflow-x: auto;
            white-space: pre-wrap;
            border: 1px solid #334155;
            margin: 8px 0;
        }
        .alert-success {
            background: #064e3b;
            border: 1px solid #059669;
            color: #a7f3d0;
            padding: 12px 16px;
            border-radius: 8px;
            margin-top: 8px;
            font-size: 13.5px;
            line-height: 1.5;
        }
        .alert-error {
            background: #450a0a;
            border: 1px solid #dc2626;
            color: #fecaca;
            padding: 12px 16px;
            border-radius: 8px;
            margin-top: 8px;
            font-size: 13.5px;
        }
        .btn-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #334155;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #2563eb;
            color: #fff;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            font-size: 13px;
            transition: background 0.2s;
        }
        .btn:hover {
            background: #1d4ed8;
        }
        .btn-green {
            background: #059669;
        }
        .btn-green:hover {
            background: #047857;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>⚡ Sync Log Migration - OTE DCA</h1>
    <hr style="border: 0; border-top: 1px solid #334155; margin: 15px 0 20px 0;">

    <?php
    try {
        // ==========================================
        // 1. MIGRASI TABEL SYNC_LOGS
        // ==========================================
        echo "<div class='section-title'>📦 Migrasi Tabel Sync Logs (<code>sync_logs</code>)</div>";
        Artisan::call('migrate', [
            '--path'  => 'database/migrations/2026_09_10_101051_create_sync_logs_table.php',
            '--force' => true,
        ]);
        $outSync = Artisan::output();
        echo "<pre>" . ($outSync ?: "Migrasi sync_logs diproses.") . "</pre>";

        // Fallback jika belum terbuat
        if (!Schema::hasTable('sync_logs')) {
            Schema::create('sync_logs', function ($table) {
                $table->id();
                $table->string('type')->default('Incremental');
                $table->dateTime('mulai')->nullable();
                $table->dateTime('selesai')->nullable();
                $table->string('status')->default('completed');
                $table->string('progress')->nullable();
                $table->integer('pair_baru')->nullable();
                $table->integer('auto_resolve')->nullable();
                $table->text('error')->nullable();
                $table->timestamps();
            });
        }

        if (Schema::hasTable('sync_logs')) {
            $total = DB::table('sync_logs')->count();
            echo "<div class='alert-success'>✅ <strong>Tabel <code>sync_logs</code> AKTIF & SIAP DIGUNAKAN!</strong><br>";
            echo "• Total Data: <strong>{$total} riwayat log</strong><br>";
            echo "• Struktur Kolom: <code>id, type, mulai, selesai, status, progress, pair_baru, auto_resolve, error, created_at, updated_at</code></div>";
        } else {
            echo "<div class='alert-error'>⚠️ Tabel <code>sync_logs</code> belum berhasil dibuat.</div>";
        }

        // ==========================================
        // 2. OPTIMIZE & CLEAR CACHE
        // ==========================================
        echo "<div class='section-title' style='margin-top: 25px;'>🧹 Bersihkan Cache Aplikasi</div>";
        Artisan::call('optimize:clear');
        echo "<p style='color: #64748b; font-size: 12px;'>Cache konfigurasi, route, dan view telah dibersihkan otomatis.</p>";

    } catch (\Throwable $e) {
        echo "<div class='alert-error'>";
        echo "<strong>❌ Terjadi Error:</strong><br>";
        echo htmlspecialchars($e->getMessage());
        echo "</div>";
        echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    }
    ?>

    <div class="btn-group">
        <a href="/customer/sync-log" class="btn btn-green">👉 Buka Menu Sync Log</a>
        <a href="/customer/list" class="btn">👉 Buka Customer List</a>
    </div>
</div>

</body>
</html>