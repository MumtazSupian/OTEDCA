<?php
try {
    $dsn = "mysql:host=127.0.0.1;port=3306;dbname=suzuki-ar.db;charset=utf8mb4";
    $pdo = new PDO($dsn, 'root', 'MSdcm123!', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $now = new DateTime('now');
    $year = $now->format('Y');
    $month = $now->format('m');
    $stmt = $pdo->query("SELECT id,no_do,status,tanggal_do,tanggal_matching_do,updated_at FROM stocks WHERE LOWER(status)='sold' AND ((YEAR(tanggal_do)=$year AND MONTH(tanggal_do)=$month) OR (YEAR(tanggal_matching_do)=$year AND MONTH(tanggal_matching_do)=$month) OR (YEAR(updated_at)=$year AND MONTH(updated_at)=$month)) ORDER BY id");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo 'matched=' . count($rows) . "\n";
    foreach ($rows as $row) {
        echo $row['id'] . ' | ' . $row['no_do'] . ' | ' . $row['status'] . ' | ' . $row['tanggal_do'] . ' | ' . $row['tanggal_matching_do'] . ' | ' . $row['updated_at'] . "\n";
    }
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . "\n";
}
