<?php
require_once __DIR__ . '/../demoark/api/libs/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$htmlFile = __DIR__ . '/../demoark/api/last_email_payload.html';
if (!file_exists($htmlFile)) {
    echo "No last_email_payload.html found\n";
    exit(1);
}

$html = file_get_contents($htmlFile);

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$canvas = $dompdf->getCanvas();
$pageCount = $canvas->get_page_count();

echo "Total Pages Generated: " . $pageCount . "\n";

$outputPdf = __DIR__ . '/verification_merged_package.pdf';
file_put_contents($outputPdf, $dompdf->output());
echo "Saved PDF to " . $outputPdf . "\n";
