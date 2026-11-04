<?php
$file = 'demoark/api/debug_quote.log';
if (!file_exists($file)) {
    echo "debug_quote.log does not exist.\n";
    exit;
}
$fp = fopen($file, 'r');
fseek($fp, max(0, filesize($file) - 15000));
$tail = fread($fp, 15000);
fclose($fp);
echo $tail;
