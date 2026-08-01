<?php
try {
    $dsn = "mysql:host=127.0.0.1;port=3306;dbname=suzuki-ar.db;charset=utf8mb4";
    $pdo = new PDO($dsn, 'root', 'MSdcm123!', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $stmt = $pdo->query("SELECT id,no_do,status,tanggal_do,tanggal_matching_do FROM stocks WHERE status='sold' AND ((YEAR(tanggal_do)=2026 AND MONTH(tanggal_do)=7) OR (YEAR(tanggal_matching_do)=2026 AND MONTH(tanggal_matching_do)=7)) ORDER BY id");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo 'count=' . count($rows) . "\n";
    foreach ($rows as $row) {
        echo $row['id'] . ' | ' . $row['no_do'] . ' | ' . $row['status'] . ' | ' . $row['tanggal_do'] . ' | ' . $row['tanggal_matching_do'] . "\n";
    }
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . "\n";
}
