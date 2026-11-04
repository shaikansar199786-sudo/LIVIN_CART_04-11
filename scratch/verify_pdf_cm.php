<?php
$content = file_get_contents(__DIR__ . '/../demoark/Quote_Agreement_Handover_Package_VERIFIED_NEW.pdf');
preg_match_all('/stream\r?\n(.*?)\r?\nendstream/s', $content, $streams);

foreach ($streams[1] as $idx => $stream) {
    $txt = @gzuncompress($stream);
    if ($txt === false) $txt = @gzinflate($stream);
    if ($txt === false) continue;
    
    preg_match_all('/1\s+0\s+0\s+1\s+([0-9\.]+)\s+([0-9\.]+)\s+cm/', $txt, $cmMatches);
    if (!empty($cmMatches[1])) {
        $cmX = floatval($cmMatches[1][0]);
        $cmY = floatval($cmMatches[2][0]);
        echo "Stream " . ($idx + 1) . " Transformation Matrix CM: X = " . round($cmX, 2) . " pt (" . round($cmX / 2.83465, 1) . " mm), Y = " . round($cmY, 2) . " pt (" . round($cmY / 2.83465, 1) . " mm)\n";
    }
}
