<?php
$file = __DIR__ . '/verification_merged_package.pdf';
$content = file_get_contents($file);

preg_match_all('/stream\r?\n(.*?)\r?\nendstream/s', $content, $streams);

for ($i = 0; $i < min(5, count($streams[1])); $i++) {
    $stream = $streams[1][$i];
    $txt = @gzuncompress($stream);
    if ($txt === false) $txt = @gzinflate($stream);
    echo "=== STREAM " . ($i + 1) . " ===\n";
    if ($txt === false) {
        echo "[Raw binary image or compressed data]\n";
    } else {
        echo substr(strip_tags($txt), 0, 500) . "\n";
    }
}
