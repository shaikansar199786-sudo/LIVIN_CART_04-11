<?php
require_once 'c:/xampp/htdocs/livrcart/demoark/api/config/database.php';
$db = (new Database())->getConnection();
$stmt = $db->query("DESCRIBE category_discount_requests");
$cols = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($cols as $c) {
    echo $c['Field'] . " (" . $c['Type'] . ")\n";
}

