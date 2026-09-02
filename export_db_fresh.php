<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$outputFile = __DIR__ . '/ote_dca.sql';

try {
    $pdo = Illuminate\Support\Facades\DB::connection()->getPdo();
} catch (\Exception $e) {
    echo "MySQL connection error: " . $e->getMessage() . "\n";
    exit(1);
}

$tables = [];
$stmt = $pdo->query("SHOW FULL TABLES WHERE Table_type = 'BASE TABLE'");
while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
    $tables[] = $row[0];
}

$sqlDump = "-- ========================================================\n";
$sqlDump .= "-- Database Dump for OTE DCA (ALL DATA INCLUDED)\n";
$sqlDump .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
$sqlDump .= "-- ========================================================\n\n";
$sqlDump .= "SET FOREIGN_KEY_CHECKS=0;\n";
$sqlDump .= "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';\n";
$sqlDump .= "SET time_zone = '+00:00';\n\n";

foreach ($tables as $table) {
    $sqlDump .= "-- --------------------------------------------------------\n";
    $sqlDump .= "-- Table structure for `$table`\n";
    $sqlDump .= "-- --------------------------------------------------------\n";
    $sqlDump .= "DROP TABLE IF EXISTS `$table`;\n";
    
    $createStmt = $pdo->query("SHOW CREATE TABLE `$table`")->fetch(PDO::FETCH_NUM);
    $sqlDump .= $createStmt[1] . ";\n\n";

    $rows = $pdo->query("SELECT * FROM `$table`")->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($rows)) {
        $sqlDump .= "-- Dumping data for table `$table` (" . count($rows) . " rows)\n";
        $columns = array_keys($rows[0]);
        $colNames = implode('`, `', $columns);

        $chunkSize = 100;
        $chunks = array_chunk($rows, $chunkSize);

        foreach ($chunks as $chunk) {
            $sqlDump .= "INSERT INTO `$table` (`$colNames`) VALUES\n";
            $valRows = [];
            foreach ($chunk as $r) {
                $escapedVals = [];
                foreach ($r as $val) {
                    if (is_null($val)) {
                        $escapedVals[] = "NULL";
                    } else {
                        $escapedVals[] = $pdo->quote($val);
                    }
                }
                $valRows[] = "(" . implode(", ", $escapedVals) . ")";
            }
            $sqlDump .= implode(",\n", $valRows) . ";\n";
        }
        $sqlDump .= "\n";
    }
}

$sqlDump .= "SET FOREIGN_KEY_CHECKS=1;\n";

file_put_contents($outputFile, $sqlDump);
echo "SUCCESS! Created $outputFile with " . count($tables) . " tables, size: " . round(filesize($outputFile) / 1024, 2) . " KB\n";
