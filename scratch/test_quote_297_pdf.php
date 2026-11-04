<?php
require_once __DIR__ . '/../demoark/api/config/database.php';
require_once __DIR__ . '/../demoark/api/helpers/SimplePdfBuilder.php';
require_once __DIR__ . '/../demoark/api/libs/dompdf/autoload.inc.php';

$db = (new Database())->getConnection();
$qStmt = $db->prepare("SELECT * FROM quotes WHERE quote_id = 297");
$qStmt->execute();
$qRow = $qStmt->fetch(PDO::FETCH_ASSOC);

if (!$qRow) {
    die("Quote 297 not found\n");
}

$sStmt = $db->prepare("SELECT * FROM quote_sections WHERE quote_id = 297 ORDER BY display_order, section_id ASC");
$sStmt->execute();
$sections = $sStmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($sections as &$sec) {
    $iStmt = $db->prepare("SELECT * FROM quote_items WHERE section_id = :sid ORDER BY display_order, item_id ASC");
    $iStmt->execute(['sid' => $sec['section_id']]);
    $sec['items'] = $iStmt->fetchAll(PDO::FETCH_ASSOC);
}
$qRow['sections'] = $sections;

echo "Building HTML...\n";
$html = SimplePdfBuilder::buildPdfHtml($qRow);

file_put_contents(__DIR__ . '/quote297_generated.html', $html);
echo "Saved HTML (" . strlen($html) . " bytes)\n";

echo "Rendering Dompdf...\n";
$pdf = SimplePdfBuilder::generateQuotePdfBinary($qRow);

$targetPdfPath = 'c:/xampp/htdocs/livrcart/Production_Email_Attachment_Quote297.pdf';
file_put_contents($targetPdfPath, $pdf);
echo "Saved PDF to $targetPdfPath (" . strlen($pdf) . " bytes)\n";

// Count pages
$pageCount = preg_match_all("/\/Page\W/", $pdf, $dummy);
echo "Total PDF pages: $pageCount\n";
