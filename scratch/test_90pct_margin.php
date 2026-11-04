<?php
require_once __DIR__ . '/../demoark/api/libs/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$css = '
@page {
  size: A4 portrait;
  margin: 12mm 15mm 12mm 15mm;
}
* {
  box-sizing: border-box !important;
}
html, body {
  margin: 0 !important;
  padding: 0 !important;
  background-color: #ffffff !important;
  font-family: "DejaVu Sans", Arial, sans-serif;
  font-size: 9pt;
  color: #0f172a;
}

/* Force 90% centered width for all contract page containers so left & right side whitespace margins are guaranteed on every page */
.merged-package-wrapper,
.agreements-print-preview,
.agreements-contract-wrapper,
.contract-wrapper,
.contract-document,
.agreements-contract-wrapper .page,
.contract-wrapper .page,
div.page {
  width: 90% !important;
  max-width: 90% !important;
  margin: 0 auto !important;
  padding: 0 !important;
  border: none !important;
  box-shadow: none !important;
}

/* Tables inside padded containers */
table {
  width: 100% !important;
  max-width: 100% !important;
  table-layout: fixed !important;
  border-collapse: collapse !important;
}

/* Letterhead alignment: convert flex or table-cell rows to 100% table with fixed column widths */
div[style*="display: table"], div[style*="display:flex"], div[style*="display: flex"] {
  display: table !important;
  width: 100% !important;
  table-layout: fixed !important;
}

/* Fix right-aligned text in letterhead cell so it leaves padding on the right */
div[style*="text-align: right"], td[style*="text-align: right"], p[style*="text-align: right"] {
  padding-right: 4px !important;
  word-wrap: break-word !important;
  overflow-wrap: break-word !important;
}

p, td, th, div, span, h1, h2, h3, h4 {
  word-wrap: break-word !important;
  overflow-wrap: break-word !important;
  word-break: break-word !important;
}
';

$payloadFile = __DIR__ . '/../demoark/api/last_email_payload.html';
if (file_exists($payloadFile)) {
    $rawHtml = file_get_contents($payloadFile);
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
    
    $outFile = __DIR__ . '/../demoark/Quote_Agreement_Handover_TEST_CENTERED.pdf';
    file_put_contents($outFile, $dompdf->output());
    echo "Generated PDF: " . $outFile . " (" . filesize($outFile) . " bytes)\n";
} else {
    echo "last_email_payload.html not found\n";
}
