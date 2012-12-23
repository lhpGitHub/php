<?php

$data = array();
$data[] = array('herman', 'kocur, "rudy"', '7k');
$data[] = array('pafnucy', 'kot, "biały"', '5k');
$data[] = array('zgubek', 'pies, "żółty"', '6k');

//write
$fh_write = fopen('dane.csv', 'w');
foreach($data as $line) {
    fputcsv($fh_write, $line);
}
fclose($fh_write);



//read
$fh_read = fopen('dane.csv', 'r');
while($line = fgetcsv($fh_read)) {
    var_dump($line);
}
fclose($fh_read);