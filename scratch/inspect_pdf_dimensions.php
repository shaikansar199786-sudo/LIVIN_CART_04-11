<?php
function inspectTextCoords($pdfPath) {
    $content = file_get_contents($pdfPath);
    preg_match_all('/stream\r?\n(.*?)\r?\nendstream/s', $content, $streams);

    echo "=== TEXT X COORDINATES FOR: " . basename($pdfPath) . " ===\n";
    $p = 1;
    foreach ($streams[1] as $idx => $stream) {
        $txt = @gzuncompress($stream);
        if ($txt === false) $txt = @gzinflate($stream);
        if ($txt === false) continue;

        // Dompdf text positioning lines: e f Tm or 1 0 0 1 e f cm
        preg_match_all('/1\s+0\s+0\s+1\s+([0-9\.]+)\s+([0-9\.]+)\s+cm\s+BT\s+([0-9\.]+)\s+([0-9\.]+)\s+Td/s', $txt, $matches);
        if (empty($matches[0])) {
            preg_match_all('/BT\s+([0-9\.]+)\s+([0-9\.]+)\s+Td/s', $txt, $matches);
            $xList = array_map('floatval', $matches[1] ?? []);
        } else {
            $xList = [];
            for ($i = 0; $i < count($matches[1]); $i++) {
                $xList[] = floatval($matches[1][$i]) + floatval($matches[3][$i]);
            }
        }

        if (!empty($xList)) {
            $minX = min($xList);
            $maxX = max($xList);
            echo "Page Stream $p: Text min X = " . round($minX, 1) . " pt (" . round($minX / 2.83465, 1) . " mm) | max X = " . round($maxX, 1) . " pt (" . round($maxX / 2.83465, 1) . " mm)\n";
            $p++;
        }
    }
}

inspectTextCoords(__DIR__ . '/../demoark/Quote_Agreement_Handover_Package_VERIFIED_NEW.pdf');
