<?php
require_once 'printLine.php';
$a = array(1);
$b = array('a', 'b', 'c');
$r = array_map(function($aVal, $bVal){
	if(is_null($aVal)) $aVal = 'NULL';
	if(is_null($bVal)) $bVal = 'NULL';
	return array($aVal => $bVal);
}, $a, $b);

printLn('wywolanie map na dwoch tablicach o roznej dlugosci');
printLn(sprintf("tablica wej a, elementow:%d", count($a))); printLn($a, 'pre');
printLn(sprintf("tablica wej b, elementow:%d", count($b))); printLn($b, 'pre');
printLn("tablica wyj"); printLn(print_r($r, TRUE), 'pre');

$a = array(1, 2, 3);
$b = array('a', 'b', 'c');
$c = array('alfa', 'beta', 'gamma');
printLn(); printLn('wykorzystanie funkcji map do laczenia tablic, callback = NULL');
printLn('tablice wejsciowe'); printLn($a, 'pre'); printLn($b, 'pre'); printLn($c, 'pre');
$r = array_map(NULL, $a, $b, $c);
printLn('tablica wyjsciowa'); var_dump($r); 

