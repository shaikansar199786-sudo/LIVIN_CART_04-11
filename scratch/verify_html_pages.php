<?php
require_once __DIR__ . '/../demoark/api/libs/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$file = __DIR__ . '/verification_merged_package.pdf';
$content = file_get_contents($file);

// Find each page stream or text block
// We can test splitting by page objects or streams in Dompdf
preg_match_all('/\/Type\s*\/Page\b.*?\n/s', $content, $pageRefs, PREG_OFFSET_CAPTURE);
echo "Found " . count($pageRefs[0]) . " page references in PDF structure.\n\n";

// Let's check page breaks in HTML source
$htmlFile = __DIR__ . '/../demoark/api/last_email_payload.html';
if (file_exists($htmlFile)) {
    $html = file_get_contents($htmlFile);
    echo "Checking HTML structure for page IDs:\n";
    echo "pdf-page-1 present: " . (strpos($html, 'id="pdf-page-1"') !== false ? "YES" : "NO") . "\n";
    echo "pdf-page-2 present: " . (strpos($html, 'id="pdf-page-2"') !== false ? "YES" : "NO") . "\n";
    echo "pdf-page-3 present: " . (strpos($html, 'id="pdf-page-3"') !== false ? "YES" : "NO") . "\n";
    echo "pdf-page-4 present: " . (strpos($html, 'id="pdf-page-4"') !== false ? "YES" : "NO") . "\n";
    echo "agreements-contract-wrapper present: " . (strpos($html, 'agreements-contract-wrapper') !== false ? "YES" : "NO") . "\n";
}
