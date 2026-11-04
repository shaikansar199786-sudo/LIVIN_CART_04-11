<?php
$file = 'C:/xampp/htdocs/livrcart/demoark/Quote_Agreement_Handover_Package_QTN-klo-045vsp (7).pdf';
$content = file_get_contents($file);

preg_match_all('/stream\r?\n(.*?)\r?\nendstream/s', $content, $streams);

for ($i = 0; $i < min(12, count($streams[1])); $i++) {
    $stream = $streams[1][$i];
    $txt = @gzuncompress($stream);
    if ($txt === false) $txt = @gzinflate($stream);
    if ($txt === false) {
        echo "--- STREAM " . ($i + 1) . " (BINARY/IMAGE) ---\n\n";
        continue;
    }

    preg_match_all('/\((.*?)\)/', $txt, $matches);
    $textParts = [];
    foreach ($matches[1] as $m) {
        $clean = preg_replace('/[^\x20-\x7E]/', '', $m);
        if (strlen(trim($clean)) > 2) {
            $textParts[] = trim($clean);
        }
    }
    echo "--- STREAM " . ($i + 1) . " ---\n";
    echo implode(" | ", array_slice($textParts, 0, 15)) . "\n\n";
}
