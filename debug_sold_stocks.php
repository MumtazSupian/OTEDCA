<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=suzuki-ar.db', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->query("SELECT id, no_do, status, tanggal_do, tanggal_matching_do FROM stocks WHERE LOWER(status) = 'sold' ORDER BY tanggal_do DESC");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Total Sold Stocks: " . count($results) . PHP_EOL;
    echo str_repeat("-", 150) . PHP_EOL;
    foreach ($results as $row) {
        echo "ID: " . $row['id'] . 
             ", NO_DO: " . $row['no_do'] . 
             ", Status: " . $row['status'] . 
             ", Tanggal DO: " . $row['tanggal_do'] . 
             ", Tanggal Matching: " . $row['tanggal_matching_do'] . PHP_EOL;
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
