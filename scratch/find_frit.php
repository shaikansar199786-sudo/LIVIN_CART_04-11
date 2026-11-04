<?php
$dbs = ['updted_liveicart', 'jimiss', 'demoarks', 'cart_final'];
foreach ($dbs as $db) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=$db;charset=utf8", 'root', '');
        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        foreach ($tables as $t) {
            $stmt = $pdo->query("SELECT * FROM `$t` WHERE 1");
            if ($stmt) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    foreach ($row as $k => $v) {
                        if (is_string($v) && stripos($v, 'frit_cehck') !== false) {
                            echo "FOUND IN $db -> $t.$k: $v\n";
                            print_r($row);
                            break 2;
                        }
                    }
                }
            }
        }
    } catch (Exception $e) {}
}
