<?php
$file = __DIR__ . '/../demoark/Quote_Agreement_Handover_TEST_CENTERED.pdf';
$content = file_get_contents($file);
preg_match_all('/stream\r?\n(.*?)\r?\nendstream/s', $content, $streams);

echo "=== EXACT MARGINS (LEFT & RIGHT) FOR: " . basename($file) . " ===\n";
$page = 1;
foreach ($streams[1] as $idx => $stream) {
    $txt = @gzuncompress($stream);
    if ($txt === false) $txt = @gzinflate($stream);
    if ($txt === false) continue;
    
    // Check transform or Td coordinates
    preg_match_all('/BT\s+([0-9\.]+)\s+([0-9\.]+)\s+Td/s', $txt, $tdMatches);
    $xVals = array_map('floatval', $tdMatches[1] ?? []);
    
    // Also check strings inside TJ / Tj
    preg_match_all('/\((.*?)\)\s*Tj/', $txt, $tjMatches);
    $textSnippets = $tjMatches[1] ?? [];
    
    if (!empty($xVals)) {
        $minX = min($xVals);
        $maxX = max($xVals);
        // Total page width A4 = 595.28 pt
        // Left margin in mm = (minX + 42.5 pt) / 2.83465
        // Right margin in mm = 210mm - ((maxX + 42.5 pt) / 2.83465)
        $leftMarginMm = round(($minX + 42.5) / 2.83465, 1);
        $rightMarginMm = round(210 - (($maxX + 42.5) / 2.83465), 1);
        
        echo "Page $page:\n";
        echo "  Left Margin: {$leftMarginMm} mm | Right Margin: {$rightMarginMm} mm\n";
        
        // Print snippet of rightmost text
        $sample = implode(" | ", array_slice(array_filter($textSnippets), 0, 3));
        echo "  Sample text: " . substr($sample, 0, 90) . "\n\n";
        $page++;
    }
}
