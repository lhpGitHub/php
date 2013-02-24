<?php
require_once 'printLine.php';
require_once 'readData.php';

$a = readData();
printLn('---wyciaganie kolumn z tablicy wielowymiarowej---');
printLn('dane:');
var_dump($a);
printLn('pobierz id:');
$r = getColumn($a, 'id');
var_dump($r);
printLn('pobierz body:');
$r = getColumn($a, 'body');
var_dump($r);
printLn('pobierz kolumne 1:');
$r = getColumn(array(array(1,2), array(3,4)), 1);
var_dump($r);

function getColumn($arr, $col) {
	return array_map(function($arr) use ($col) {
		return (is_array($arr) && isset($arr[$col])) ? $arr[$col] : NULL;
	}, $arr);
}

printLn(); printLn();
printLn('---zamiana miejscami kolumn i wierszy w tablicy dwuwymiarowej---');
printLn('tablica wejsciowa'); var_dump($a);
$r = arraySwap($a);
printLn('tablica wyjsciowa'); var_dump($r);

function arraySwap($arr) {
	$output = array();
	array_map(function($arr) use (&$output) {
		if(is_array($arr)) {
			array_walk($arr, function($v, $k) use (&$output){
				$output[$k][] = $v;
			});
		}
	}, $arr);
	return $output;
}


printLn(); printLn('---laczenie elementow tablic o tych samych kluczach---');
$a = array(1=>'a', 2=>'b', 3=>'c');
$b = array(1=>'c', 2=>'d', 3=>'e', 4=>'f');
$c = array(3=>'e', 4=>'f');
$callback = function($v1, $v2) { return $v1.$v2; };
printLn('tablice wejsciowe: '); 
printLn($a, 'pre');
printLn($b, 'pre');
printLn($c, 'pre');
$r = linkByKey($callback, $a, $b, $c);
printLn('tablica wynikowa:'); 
printLn($r, 'pre');

function linkByKey($linkFunc, $arr1, $arr2 /*[$arr3...]*/) {
	$args = func_get_args();
	$linkFunc = array_shift($args);
	if(!is_callable($linkFunc)) return FALSE;
	$output = array();
	foreach($args as $arr) {
		if(is_array($arr)) {
			array_map(function($v, $k) use (&$output, $linkFunc) {
				if(isset($output[$k])) {
					$output[$k] = $linkFunc($output[$k], $v);
				} else {
					$output[$k] = $v;
				}
			}, $arr, array_keys($arr));
		}
	}
	return $output;
}

printLn(); printLn('---przegladanie tablicy obiektow, wywolywanie wybranej metody i zapisanie wynikow do nowej tablicy');
class Pet {
	private $name, $age;
	function __construct($name, $age) {
		$this->name = $name;
		$this->age = $age;
	}
	public function getName() { return $this->name; }
	public function getAge() { return $this->age; }
}

$a = array(new Pet('Herman', 7), new Pet('Pafnucy', 8));
printLn('tablica obiektow'); printLn(print_r($a, 1), 'pre');
$r = method_caller($a, 'getName');
printLn('tablica wynikowa dla getName'); printLn($r, 'pre');
$r = method_caller($a, 'getAge');
printLn('tablica wynikowa dla getAge'); printLn($r, 'pre');

function method_caller($arr, $method) {
	return array_map(function($obj) use ($method) {
		return ($obj->$method());
	}, $arr);
	
}


printLn(); printLn('---map a typy inne niz tablice---');

class MyObject
 {
	 public $a = 1;
	 public $b = array('a','b');
	 private $c = 3;
 } 
$a = (array) new MyObject();
var_dump(is_array($a), $a);

array_map(function($v){
	echo print_r($v, TRUE).'<br/>';
},$a);


printLn(); printLn('---dostep do elementow ciagu znakow (i do tablicy) za pomoca nawiasow klamrowych {}---');
$p = array('a','b','c');
$p = 'abc';
$p = 123;
$k = 1;
var_dump($p{$k});

