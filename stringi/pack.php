<?php

$data = array();
$data[] = array('herman', 'kocur, "rudy"', '7k');
$data[] = array('pafnucy', 'kot, "biały"', '5k');
$data[] = array('zgubek', 'pies, "żółty"', '6k');

foreach($data as $line) {
	echo pack('A15A25A4', $line[0], $line[1], $line[2])."\n";
}

foreach($data as $line) {
	$v0 = str_pad(substr($line[0], 0, 15), 15, '.');
	$v1 = str_pad(substr($line[1], 0, 25), 25, '.');
	$v2 = str_pad(substr($line[2], 0, 4), 4, '.');
	
	print "\n".$v0.$v1.$v2;
}