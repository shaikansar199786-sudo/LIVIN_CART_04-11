<?php
$pdo = new PDO("mysql:host=localhost;dbname=jimiss;charset=utf8", 'root', '');
$stmt = $pdo->query("SELECT * FROM quotes ORDER BY quote_id DESC LIMIT 5");
if ($stmt) {
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Recent quotes in jimiss:\n";
    foreach ($rows as $r) {
        print_r($r);
    }
}
