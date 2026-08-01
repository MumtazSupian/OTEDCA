<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$db = config('database.connections.' . config('database.default') . '.database');
$port = config('database.connections.' . config('database.default') . '.port');
$host = config('database.connections.' . config('database.default') . '.host');

echo "Host: {$host} | Port: {$port} | Database: {$db}" . PHP_EOL;
echo "in_units count: " . DB::table('in_units')->count() . PHP_EOL;

// Check ALL databases for in_units-like tables with data
$databases = DB::select('SHOW DATABASES');
foreach ($databases as $d) {
    $dbName = $d->Database;
    if (in_array($dbName, ['information_schema', 'mysql', 'performance_schema', 'sys'])) continue;
    
    try {
        $tables = DB::select("SELECT TABLE_NAME, TABLE_ROWS FROM information_schema.TABLES WHERE TABLE_SCHEMA = ? AND TABLE_ROWS > 0", [$dbName]);
        if (!empty($tables)) {
            echo PHP_EOL . "=== Database: {$dbName} (tables with data) ===" . PHP_EOL;
            foreach ($tables as $t) {
                echo "  {$t->TABLE_NAME}: ~{$t->TABLE_ROWS} rows" . PHP_EOL;
            }
        }
    } catch (\Exception $e) {
        // skip
    }
}
