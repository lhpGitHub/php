<?php
require_once 'printLine.php';
require_once 'readData.php';

printLn(); printLn('---wyszukiwanie podtablicy z kluczem o okreslonej wartosci---');
printLn('tablica wejsciowa:');
$a = readData();
var_dump($a);
$r = searchByKey($a, 'title', 'title_2');
printLn('wynik:');
var_dump($r);


function searchByKey($data, $key, $val) {
	return array_filter($data, function($arr) use ($key, $val) {
		return (is_array($arr) && isset($arr[$key]) && $arr[$key] == $val);
	});
}

printLn(); printLn('---usunicie przy pomocy filter wartosci dajacych FALSE z wyjatkiem zera---');
printLn('tablica wejsciowa:');
$a = array('a', NULL, -1, 0, FALSE, '');
var_dump($a);
$r = array_filter($a, 'strlen');
printLn('wynik:');
var_dump($r);

printLn(); printLn('---odwrocenie dzialania, w tab zwracanej tylko elementy nie przechodzace przez filtr---');
printLn('tablica wejsciowa:');
$a = array('a', NULL, -1, 0, FALSE, '');
var_dump($a);

function array_filter_reverse(array $arr, callable $callback = NULL) {
	return array_diff(	$arr, 
						is_null($callback) ? 
							array_filter($arr) : 
							array_filter($arr, $callback)
			);
}

$r = array_filter_reverse($a);
printLn('wynik:');
var_dump($r);


printLn(); printLn('---dodawanie tablic operatorem + jest mozliwe');
$a = array('a', 'b', 'c');
$b = array('d', 'e', 'f', 'g');
printLn('tablice wejsciowe'); printLn($a, 'pre'); printLn($b, 'pre');
$r = $a + $b;
printLn('tablice wynikowa'); printLn($r, 'pre');


printLn(); printLn('---wyszukiwanie wartosci wiekszych od zadanej---');
$a = range(0,10);
printLn('tablica wejsciowa:'); printLn($a);
printLn('znajdz wieksze od 4, wynik:'); printLn(findGreatherThan($a, 4));

function findGreatherThan(array $arr, $val){
	return array_filter($arr, function($crrVal) use ($val){
		return ($crrVal > $val);
	});
}

