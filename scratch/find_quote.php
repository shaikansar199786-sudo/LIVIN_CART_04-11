<?php
require_once __DIR__ . '/../demoark/api/config/database.php';

$database = new Database();
$db = $database->getConnection();

$dbs = ['updted_liveicart', 'cart_final', 'demoarks', 'jimiss', 'livecart', 'livecart_nows'];

foreach ($dbs as $dbName) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=$dbName;charset=utf8", 'root', '');
        $stmt = $pdo->query("SELECT * FROM quotes WHERE quote_number LIKE '%84%' OR subtitle LIKE '%frit%' OR extra_data LIKE '%frit%' LIMIT 5");
        if ($stmt) {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($rows)) {
                echo "FOUND IN DATABASE: $dbName\n";
                foreach ($rows as $r) {
                    echo "  Quote ID: {$r['quote_id']}, Number: {$r['quote_number']}, Subtitle: {$r['subtitle']}, Project: {$r['project_id']}, Total: {$r['total_amount']}\n";
                }
            }
        }
    } catch (Exception $e) {}
}
