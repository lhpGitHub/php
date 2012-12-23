<?php

$data = array();
$data[] = array('herman', 'kocur, "rudy"', '7k');
$data[] = array('pafnucy', 'kot, "biały"', '5k');
$data[] = array('zgubek', 'pies, "żółty"', '6k');

ob_start();
$fh = fopen('php://output', 'w');
foreach($data as $line) {
    fputcsv($fh, $line);
}
fclose($fh);
$output = ob_get_contents();
ob_end_clean();
var_dump($output);