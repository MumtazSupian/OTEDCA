<?php
try {
    $dsn = "mysql:host=127.0.0.1;port=3306;dbname=suzuki-ar.db;charset=utf8mb4";
    $pdo = new PDO($dsn, 'root', 'MSdcm123!', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $pdo->exec("INSERT INTO stocks (id, no_do, status, tanggal_do, tanggal_matching_do, created_at, updated_at) VALUES (82, 'DB620308', 'sold', NULL, '2026-07-03 00:00:00', '2026-07-04 08:52:53', '2026-07-04 08:52:53')");
    $pdo->exec("INSERT INTO stocks (id, no_do, status, tanggal_do, tanggal_matching_do, created_at, updated_at) VALUES (181, 'DB625029', 'sold', NULL, '2026-07-03 00:00:00', '2026-07-04 08:53:37', '2026-07-04 08:53:37')");

    echo "restored\n";
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . "\n";
}
