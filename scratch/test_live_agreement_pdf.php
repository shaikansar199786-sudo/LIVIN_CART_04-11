<?php
require_once __DIR__ . '/../demoark/api/libs/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

// Load controller styles from QuoteController.php
$controllerFile = __DIR__ . '/../demoark/api/controllers/QuoteController.php';
$controllerCode = file_get_contents($controllerFile);

// Extract the $fullDocumentHtml wrapper CSS from QuoteController.php
preg_match('/<style>(.*?)<\/style>/s', $controllerCode, $styleMatch);
$css = $styleMatch[1] ?? '';

echo "Extracted CSS length from QuoteController.php: " . strlen($css) . "\n";
echo "Contains 30mm margin rule: " . (strpos($css, 'margin: 12mm 30mm 12mm 30mm') !== false ? "YES" : "NO") . "\n";
echo "Contains agreement container resets: " . (strpos($css, '.agreements-contract-wrapper') !== false ? "YES" : "NO") . "\n";

// Let's load last email payload or raw HTML payload
$payloadFile = __DIR__ . '/../demoark/api/last_email_payload.html';
if (file_exists($payloadFile)) {
    $rawHtml = file_get_contents($payloadFile);
    
    // Inject the updated style block from QuoteController.php
    $fullHtml = '<!DOCTYPE html><html><head><meta charset="UTF-8"><style>' . $css . '</style></head><body>' . $rawHtml . '</body></html>';
    
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    $options->set('defaultFont', 'DejaVu Sans');
    $options->set('dpi', 96);
    
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($fullHtml);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    $outFile = __DIR__ . '/../demoark/Quote_Agreement_Handover_Package_VERIFIED_NEW.pdf';
    file_put_contents($outFile, $dompdf->output());
    echo "Generated new PDF: " . $outFile . " (" . filesize($outFile) . " bytes)\n";
} else {
    echo "last_email_payload.html not found\n";
}
