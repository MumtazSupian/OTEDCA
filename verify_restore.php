<?php
try {
    $dsn = "mysql:host=127.0.0.1;port=3306;dbname=suzuki-ar.db;charset=utf8mb4";
    $pdo = new PDO($dsn, 'root', 'MSdcm123!', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM stocks WHERE no_do='DB620308' OR no_do='DB625029'");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo 'total=' . $row['total'] . "\n";
    $stmt = $pdo->query("SELECT id,no_do,status,tanggal_do,tanggal_matching_do,created_at,updated_at FROM stocks WHERE no_do='DB620308' OR no_do='DB625029' ORDER BY id");
    foreach ($stmt as $row) {
        echo $row['id'] . ' | ' . $row['no_do'] . ' | ' . $row['status'] . ' | ' . $row['tanggal_do'] . ' | ' . $row['tanggal_matching_do'] . ' | ' . $row['created_at'] . ' | ' . $row['updated_at'] . "\n";
    }
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . "\n";
}
