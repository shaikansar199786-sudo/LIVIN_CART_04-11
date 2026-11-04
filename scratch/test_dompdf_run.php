<?php
require_once __DIR__ . '/../demoark/api/libs/dompdf/autoload.inc.php';

$options = new \Dompdf\Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'DejaVu Sans');

$dompdf = new \Dompdf\Dompdf($options);
$dompdf->loadHtml('<html><body><h1>Livincart Test</h1><p>Testing Dompdf functionality</p></body></html>');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$out = $dompdf->output();
echo "SUCCESS! Dompdf generated PDF size: " . strlen($out) . " bytes\n";
