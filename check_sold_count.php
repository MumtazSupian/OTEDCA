<?php
try {
    $dsn = "mysql:host=127.0.0.1;port=3306;dbname=suzuki-ar.db;charset=utf8mb4";
    $pdo = new PDO($dsn, 'root', 'MSdcm123!', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $stmt = $pdo->query("SELECT id,no_do,status,tanggal_do,tanggal_matching_do FROM stocks WHERE LOWER(status)='sold'");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $now = new DateTime('now');
    $count = 0;
    foreach ($rows as $row) {
        $dateValue = $row['tanggal_matching_do'] ?: $row['tanggal_do'];
        if ($dateValue) {
            $date = DateTime::createFromFormat('Y-m-d', $dateValue);
            if (! $date) {
                $date = new DateTime($dateValue);
            }
            if ($date && (int)$date->format('Y') === (int)$now->format('Y') && (int)$date->format('m') === (int)$now->format('m') && $date <= $now) {
                $count++;
                echo $row['id'].' | '.$row['no_do'].' | '.$row['tanggal_do'].' | '.$row['tanggal_matching_do']."\n";
            }
        }
    }
    echo 'current_month_sold_count=' . $count . "\n";
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . "\n";
}
