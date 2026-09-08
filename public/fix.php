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
    <title>🚀 Database Fix & Migration - OTE DCA</title>
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
    <h1>🚀 Database Fixer & Migration - OTE DCA</h1>
    <hr style="border: 0; border-top: 1px solid #334155; margin: 15px 0 20px 0;">

    <?php
    try {
        // ==========================================
        // 1. MIGRASI TABEL FAKTUR
        // ==========================================
        echo "<div class='section-title'>📦 1. Migrasi Tabel Faktur (<code>fakturs</code>)</div>";
        Artisan::call('migrate', [
            '--path'  => 'database/migrations/2026_09_02_000000_create_fakturs_table.php',
            '--force' => true,
        ]);
        $outFaktur = Artisan::output();
        echo "<pre>" . ($outFaktur ?: "Migrasi fakturs diproses.") . "</pre>";

        if (Schema::hasTable('fakturs')) {
            echo "<div class='alert-success'>✅ <strong>Tabel <code>fakturs</code> AKTIF!</strong></div>";
        } else {
            echo "<div class='alert-error'>⚠️ Tabel <code>fakturs</code> belum ditemukan.</div>";
        }

        // ==========================================
        // 2. MIGRASI DAN PERBAIKAN ENUM/KOLOM (PLAN & ACTUAL ACTIVITIES)
        // ==========================================
        echo "<div class='section-title' style='margin-top: 25px;'>🎯 2. Perbaikan Tabel Activity (Plan & Actual)</div>";
        
        // A. Jalankan migration file
        Artisan::call('migrate', [
            '--path'  => 'database/migrations/2026_09_03_000001_add_target_do_to_activities_tables.php',
            '--force' => true,
        ]);
        $outAct = Artisan::output();
        echo "<pre>" . ($outAct ?: "Migrasi activities diproses.") . "</pre>";

        // B. Eksekusi langsung ALTER TABLE untuk merubah ENUM ke VARCHAR & jam default & target_do
        if (Schema::hasTable('plan_activities')) {
            DB::statement("ALTER TABLE `plan_activities` MODIFY COLUMN `type_unit` VARCHAR(255) NULL");
            DB::statement("ALTER TABLE `plan_activities` MODIFY COLUMN `activity` VARCHAR(255) NULL");
            DB::statement("ALTER TABLE `plan_activities` MODIFY COLUMN `jenis_activity` VARCHAR(255) NULL");
            DB::statement("ALTER TABLE `plan_activities` MODIFY COLUMN `jenis_unit` VARCHAR(255) NULL");
            DB::statement("ALTER TABLE `plan_activities` MODIFY COLUMN `jam` TIME NULL DEFAULT '00:00:00'");
            
            if (!Schema::hasColumn('plan_activities', 'target_do')) {
                DB::statement("ALTER TABLE `plan_activities` ADD COLUMN `target_do` INT(11) NOT NULL DEFAULT 0 AFTER `target_spk`");
            }
        }

        if (Schema::hasTable('actual_activities')) {
            DB::statement("ALTER TABLE `actual_activities` MODIFY COLUMN `type_unit` VARCHAR(255) NULL");
            DB::statement("ALTER TABLE `actual_activities` MODIFY COLUMN `activity` VARCHAR(255) NULL");
            DB::statement("ALTER TABLE `actual_activities` MODIFY COLUMN `jenis_activity` VARCHAR(255) NULL");
            DB::statement("ALTER TABLE `actual_activities` MODIFY COLUMN `jenis_unit` VARCHAR(255) NULL");
            DB::statement("ALTER TABLE `actual_activities` MODIFY COLUMN `jam` TIME NULL DEFAULT '00:00:00'");
            
            if (!Schema::hasColumn('actual_activities', 'target_do')) {
                DB::statement("ALTER TABLE `actual_activities` ADD COLUMN `target_do` INT(11) NOT NULL DEFAULT 0 AFTER `target_spk`");
            }
        }

        echo "<div class='alert-success'>🎉 <strong>BERHASIL!</strong><br>
        • Kolom <code>type_unit</code> & <code>activity</code> diubah menjadi <code>VARCHAR(255)</code>.<br>
        • Kolom <code>jam</code> diberi default <code>'00:00:00'</code> (bebas error missing default).<br>
        • Kolom <code>target_do</code> aktif di tabel <code>plan_activities</code> dan <code>actual_activities</code>.</div>";

        // ==========================================
        // 3. OPTIMIZE & CLEAR CACHE
        // ==========================================
        Artisan::call('optimize:clear');
        echo "<p style='color: #64748b; font-size: 12px; margin-top: 15px;'>🧹 Cache konfigurasi, route, dan view telah dibersihkan otomatis.</p>";

    } catch (\Throwable $e) {
        echo "<div class='alert-error'>";
        echo "<strong>❌ Terjadi Error:</strong><br>";
        echo htmlspecialchars($e->getMessage());
        echo "</div>";
        echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    }
    ?>

    <div class="btn-group">
        <a href="/activity/plan" class="btn btn-green">👉 Buka Activity Plan</a>
        <a href="/activity/actual" class="btn btn-green">👉 Buka Activity Actual</a>
        <a href="/sales/faktur" class="btn">👉 Buka Menu Faktur</a>
    </div>
</div>

</body>
</html>