<?php
require_once 'printLine.php';

printLn('---wyliczanie sredniej z wartosci w tablicy---');
$a = array(2,4,2);
printLn('tablica wejsciowa:'); printLn($a);
$r = average($a);
printLn(sprintf("srednia to: %.2f", $r));

function average(array $arr) {
	$r = array_reduce($arr, function($tmpVal, $val){
		return $tmpVal + $val;
	});
	return $r/count($arr);
}