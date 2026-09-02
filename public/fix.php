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
    <title>🚀 Migrate Tabel Faktur - OTE DCA</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: #0f172a;
            color: #e2e8f0;
            padding: 40px 20px;
            margin: 0;
        }
        .container {
            max-width: 700px;
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
        pre {
            background: #020617;
            padding: 16px;
            border-radius: 8px;
            color: #a5f3fc;
            font-family: Consolas, "Courier New", Courier, monospace;
            font-size: 13px;
            overflow-x: auto;
            white-space: pre-wrap;
            border: 1px solid #334155;
            margin: 15px 0;
        }
        .alert-success {
            background: #064e3b;
            border: 1px solid #059669;
            color: #a7f3d0;
            padding: 14px 18px;
            border-radius: 8px;
            margin-top: 15px;
            font-size: 14px;
            line-height: 1.5;
        }
        .alert-error {
            background: #450a0a;
            border: 1px solid #dc2626;
            color: #fecaca;
            padding: 14px 18px;
            border-radius: 8px;
            margin-top: 15px;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            background: #2563eb;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            font-size: 13px;
            margin-top: 15px;
        }
        .btn:hover {
            background: #1d4ed8;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>🚀 Migrasi Database: Tabel <code>fakturs</code></h1>
    <hr style="border: 0; border-top: 1px solid #334155; margin: 15px 0 20px 0;">

    <?php
    try {
        echo "<p style='color: #94a3b8;'>⏳ Menjalankan migrasi file: <code>2026_09_02_000000_create_fakturs_table.php</code>...</p>";

        // Eksekusi spesifik file migrasi faktur
        Artisan::call('migrate', [
            '--path'  => 'database/migrations/2026_09_02_000000_create_fakturs_table.php',
            '--force' => true,
        ]);
        
        $output = Artisan::output();

        echo "<pre>" . ($output ?: "Command selesai dijalankan.") . "</pre>";

        // Validasi apakah tabel fakturs sudah terbentuk di database
        if (Schema::hasTable('fakturs')) {
            $columns = Schema::getColumnListing('fakturs');
            echo "<div class='alert-success'>";
            echo "🎉 <strong>BERHASIL!</strong> Tabel <code>fakturs</code> sudah aktif di database!<br>";
            echo "<small style='color: #6ee7b7;'>Kolom: " . implode(', ', $columns) . "</small>";
            echo "</div>";
        } else {
            echo "<div class='alert-error'>⚠️ Tabel <code>fakturs</code> belum ditemukan setelah migrasi. Coba jalankan ulang.</div>";
        }

        // Bersihkan cache aplikasi agar route & model fresh
        Artisan::call('optimize:clear');
        echo "<p style='color: #64748b; font-size: 12px; margin-top: 10px;'>🧹 Cache aplikasi telah dibersihkan otomatis.</p>";

    } catch (\Throwable $e) {
        echo "<div class='alert-error'>";
        echo "<strong>❌ Terjadi Error:</strong><br>";
        echo htmlspecialchars($e->getMessage());
        echo "</div>";
        echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    }
    ?>

    <a href="/sales/faktur" class="btn">👉 Buka Menu Faktur</a>
</div>

</body>
</html>