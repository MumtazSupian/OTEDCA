<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Mulai import ote_dca.sql ke database...\n";
$sqlFile = __DIR__ . '/ote_dca.sql';

if (!file_exists($sqlFile)) {
    die("Error: File ote_dca.sql tidak ditemukan di folder ini!\n");
}

$sql = file_get_contents($sqlFile);
Illuminate\Support\Facades\DB::unprepared($sql);

echo "SUKSES! Database berhasil di-import sepenuhnya ke server.\n";
