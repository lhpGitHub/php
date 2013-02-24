<?php
require_once 'printLine.php';

$a = array('1'=>'a', '2'=>'b', '3'=>'c', '4'=>'a', '5'=>'b', '6'=>'c');
printLn('usuwanie elementow z tablicu po kluczu i po wartosci');
printLn('tablica przed'); printLn($a, 'pre');
$a = delByVal($a, 'a');
$a = delByKey($a, 2);
printLn('tablic po'); printLn($a, 'pre');

function delByVal($a, $val) {
	if(is_array($a)) {
		$r = array();
		array_walk($a, function($v, $k) use (&$r, $val) {
			if($val != $v) $r[$k] = $v;
		});
		return $r;
	}
	return FALSE;
}

function delByKey($a, $key) {
	if(is_array($a)) { 
		$r = array();
		array_walk($a, function($v, $k) use (&$r, $key) {
			if($key != $k) $r[$k] = $v;
		});
		return $r;
	}
	return FALSE;
}

$a = array('1'=>'aa', '2'=>'b', '3'=>1, '4'=>'a', '5'=>'b', '6'=>'cc');
printLn();
printLn('usuwanie elementow wykorzystujac zewnetrzna funkcja porownujaca');
printLn('tab wejsciowa'); printLn($a, 'pre');
//$r = delByFunc($a, function ($v) { return strtolower($v) === 'b'; });
$r = delByFunc($a, 'is_string');
printLn('tab wyjsciowa'); printLn($r, 'pre');
function delByFunc($a, $func) {
	if(is_array($a) && is_callable($func)) {
		$r = array();
		array_walk($a, function($v, $k) use (&$r, $func){
			if(!$func($v)) $r[$k] = $v;
		});
		return $r;
	}
	return FALSE;
}

//$a = array('1'=>'aa', '2'=>'b', '3'=>array('a', 'b', 'c'), '4'=>'a', '5'=>'b', '6'=>'cc');
$a = 'kilka slow na byle jaki temat';
$a = preg_match_all('/(\w)/', $a, $b);
$a = $b[0];
printLn(); printLn('zliczanie identycznych elementow w tablicy');
printLn('tablica zrodlowa');
printLn($a, 'pre');
$r = countElements($a);
printLn('tablica z liczba elementow w tablicy zrodlowej'); 
printLn($r, 'pre');
function countElements($a) {
	$r = array();
	array_walk_recursive($a, function($v) use (&$r){
		(!isset($r[$v])) ? $r[$v] = 1 : $r[$v]++;
	});
	return $r;
}

$a = array('a', 'b', 'c', 'a', 'b', 'd');
printLn(); printLn('usuwanie duplikatow z tablicy');
printLn('tablica wejsciowa'); printLn($a, 'pre');
$r = delDuplicates($a);
printLn('tablica wyjsciowa'); printLn($r, 'pre');

function delDuplicates($a) {
	if(is_array($a)) {
		$r = array();
		array_walk($a, function($v) use (&$r) {
			if(!isset($r[$v])) {
				$r[$v] = 1;
			}
		});
		return array_keys($r);
	}
	return FALSE;
}