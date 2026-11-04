<?php
require 'demoark/api/config/Database.php';
$db = (new Database())->getConnection();
$stmt = $db->prepare('SELECT * FROM quotes WHERE quote_id = 297');
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

echo "Quote ID: " . $row['quote_id'] . "\n";
echo "Quote Number: " . $row['quote_number'] . "\n";
echo "Total Amount: " . $row['total_amount'] . "\n";
echo "Extra Data:\n";
$extra = json_decode($row['extra_data'], true);
print_r($extra);
