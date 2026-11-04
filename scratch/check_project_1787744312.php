<?php
require 'demoark/api/config/database.php';
$db = (new Database())->getConnection();

echo "=== PROJECT ===\n";
$stmt = $db->query("SELECT * FROM projects WHERE project_id = 1787744312 OR project_code = '1787744312'");
$p = $stmt->fetch(PDO::FETCH_ASSOC);
print_r($p);

echo "=== LEADS ===\n";
$stmt = $db->query("SELECT lead_id, client_name, total_budget, initial_quote_amount, status FROM leads WHERE lead_id = 1787744312 OR manual_client_id = '1787744312' OR client_name = '" . ($p['client_name'] ?? '') . "'");
$l = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($l);

echo "=== QUOTES ===\n";
$stmt = $db->query("SELECT quote_id, quote_number, version, save_type, is_initial, status, total_amount, extra_data FROM quotes WHERE project_id = 1787744312 OR project_id = '1787744312' ORDER BY quote_id ASC");
$qs = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($qs as &$q) {
    $ex = json_decode($q['extra_data'], true);
    $q['extra_is_initial'] = $ex['is_initial_quote'] ?? 'none';
    $q['extra_is_final'] = $ex['is_final_version'] ?? 'none';
    unset($q['extra_data']);
}
print_r($qs);
