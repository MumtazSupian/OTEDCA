<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Artisan;

echo "<h2>🔧 Memulai Paksa Eksekusi Command Email</h2>";
echo "<hr>";

try {
    // 1. Bersihkan sumbatan cache terlebih dahulu
    echo "⏳ Membersihkan cache scheduler...<br>";
    Artisan::call('cache:clear');
    Artisan::call('schedule:clear-cache');
    echo "✅ Cache bersih!<br><br>";

    // 2. Panggil LANGSUNG command email-mu tanpa lewat scheduler Windows
    echo "⏳ Memaksa menjalankan command 'app:send-stock-email' langsung...<br>";
    
    // Kita set memory limit unlimited khusus untuk eksekusi script ini agar dompdf tidak crash
    ini_set('memory_limit', '-1');
    
    $status = Artisan::call('app:send-stock-email'); 
    
    echo "<h3>Hasil Output Sistem:</h3>";
    echo "<pre style='background: #f4f4f4; padding: 15px; border-radius: 5px; color: #333;'>";
    $output = Artisan::output();
    echo empty($output) ? "Command sukses dipicu (Status Code: $status)." : $output;
    echo "</pre>";
    
    echo "<br><strong style='color: green;'>🚀 Selesai! Jika berhasil, cek inbox email atau cek laravel.log sekarang, pasti jam log-nya sudah berubah ke jam sekarang!</strong>";

} catch (\Exception $e) {
    echo "<br><strong style='color: red;'>❌ Terjadi Error di Dalam Sistem:</strong><br>";
    echo "<pre style='background: #fff0f0; padding: 15px; border: 1px solid #ffcccc; color: #cc0000; border-radius: 5px;'>";
    echo $e->getMessage();
    echo "</pre>";
}