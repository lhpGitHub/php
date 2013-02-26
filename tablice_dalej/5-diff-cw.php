<?php
require_once 'printLine.php';

printLn('---usuniecie z tablicy niepotrzebnych elementow---');
$a = array('identyfikator', 'czas-rejestracji', 'imie', 'nazwisko');
printLn('tablice wej:'); printLn($a);
$r = array_diff($a, array('identyfikator', 'czas-rejestracji'));
printLn('tablice wyj:'); printLn($r);

printLn(); printLn('---usuwanie elementu z tablice po wartosci elementu ---');
$a = range('a','d');
printLn('tablica wej:'); printLn($a);
removeByVal($a, 'b');
printLn('tablica wyj:'); printLn($a);

function removeByVal(array &$arr, $value) {
	$arr = array_diff($arr, array($value));
}

printLn(); printLn('---zwracanie roznicy tablic obiektow---');
class A {
	private $a;
	public function __construct($a) {
		$this->a = $a;
	}
}
$a = array(new A('abc'), new A('abcd'), new A('def'));
$b = array($a[0]);

var_dump(array_values(array_obj_diff($a, $b)));

function array_obj_diff($arr1, $arr2) {
	$callback = function(&$v){ $v = serialize($v); };
	array_walk($arr1, $callback);
	array_walk($arr2, $callback);
	$r = array_diff($arr1, $arr2);
	array_walk($r, function(&$v){
		$v = unserialize($v);
	});
	return $r;
}

printLn(); printLn('---przypisanie do zmiennej z jednoczesnym sprawdzeniem w instrukcji if');
$a = 'abcdef';
if(($bb = strpos($a, 'c')) != 2) {
	printLn('instrukcje gdy prawda');
} else {
	printLn('instrukcje gdy falsz');
}
printLn('bb zawiera');
var_dump($bb);