<?php
$file = __DIR__ . '/../demoark/Quote_Agreement_Handover_TEST_CENTERED.pdf';
$content = file_get_contents($file);
preg_match_all('/stream\r?\n(.*?)\r?\nendstream/s', $content, $streams);

foreach ($streams[1] as $idx => $stream) {
    $txt = @gzuncompress($stream);
    if ($txt === false) $txt = @gzinflate($stream);
    if ($txt === false) continue;
    
    // Split into BT ... ET text blocks
    preg_match_all('/BT\s+(.*?)\s+ET/s', $txt, $btBlocks);
    foreach ($btBlocks[1] as $block) {
        // Extract X coordinate from Td
        if (preg_match('/([0-9\.]+)\s+([0-9\.]+)\s+Td/', $block, $tdMatch)) {
            $x = floatval($tdMatch[1]);
            if ($x > 450) { // Anything starting after X = 450pt (very close to or beyond right margin)
                preg_match_all('/\((.*?)\)/', $block, $strMatches);
                $str = implode('', $strMatches[1] ?? []);
                if (!empty($str)) {
                    echo "Page " . ($idx + 1) . " (X = $x pt): " . $str . "\n";
                }
            }
        }
    }
}
