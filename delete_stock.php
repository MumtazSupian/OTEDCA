<?php
try {
    $dsn = "mysql:host=127.0.0.1;port=3306;dbname=suzuki-ar.db;charset=utf8mb4";
    $pdo = new PDO($dsn, 'root', 'MSdcm123!', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $ids = [181, 82];
    $in = implode(',', $ids);
    $rows = $pdo->exec("DELETE FROM stocks WHERE id IN ($in)");
    echo "deleted=$rows\n";
    $stmt = $pdo->query("SELECT id,no_do,status,tanggal_do,tanggal_matching_do FROM stocks WHERE id IN ($in)");
    $found = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "remaining=" . count($found) . "\n";
    foreach ($found as $row) {
        echo implode(' | ', [$row['id'], $row['no_do'], $row['status'], $row['tanggal_do'], $row['tanggal_matching_do']]) . "\n";
    }
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . "\n";
}
