<?php
require_once __DIR__ . '/../demoark/api/config/database.php';

$database = new Database();
$db = $database->getConnection();

$stmt = $db->prepare("SELECT * FROM quotes WHERE quote_id = 84");
$stmt->execute();
$quote = $stmt->fetch(PDO::FETCH_ASSOC);

echo "Quote 84: \n";
print_r($quote);

$stmtSec = $db->prepare("SELECT * FROM quote_sections WHERE quote_id = 84");
$stmtSec->execute();
$sections = $stmtSec->fetchAll(PDO::FETCH_ASSOC);

echo "\nSections count: " . count($sections) . "\n";
foreach ($sections as $s) {
    echo "Section: " . $s['section_name'] . " (ID: " . $s['section_id'] . ")\n";
    $stmtIt = $db->prepare("SELECT * FROM quote_items WHERE section_id = " . $s['section_id']);
    $stmtIt->execute();
    $items = $stmtIt->fetchAll(PDO::FETCH_ASSOC);
    echo "  Items count: " . count($items) . "\n";
    foreach ($items as $it) {
        echo "    - " . $it['particulars'] . " | Qty: " . $it['quantity'] . " | Rate: " . $it['rate'] . " | Amt: " . $it['amount'] . "\n";
    }
}
