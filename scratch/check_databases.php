<?php
require_once __DIR__ . '/../demoark/api/config/database.php';

$database = new Database();
$db = $database->getConnection();

echo "Columns of quotes table:\n";
$stmtCols = $db->query("DESCRIBE quotes");
print_r($stmtCols->fetchAll(PDO::FETCH_COLUMN));

echo "\nRecent quotes:\n";
$stmtQ = $db->query("SELECT * FROM quotes ORDER BY quote_id DESC LIMIT 5");
$recent = $stmtQ->fetchAll(PDO::FETCH_ASSOC);
foreach ($recent as $r) {
    echo "ID: " . $r['quote_id'] . " | Number: " . ($r['quote_number'] ?? 'N/A') . " | Project: " . ($r['project_id'] ?? 'N/A') . " | Total: " . ($r['total_amount'] ?? 'N/A') . "\n";
}
