<?php

class classA {
	private $a;
	public function setA($v) { $this->a = $v; }
	public function getA() { return $this->a; }
}

printf('tablica jest kopiowana<br>');
$tablica = range(0,3);
$a = new classA();
$a->setA($tablica);
$tablica = range('a','d');
var_dump($tablica, $a->getA());

printf('obiekt jest przekazywany przez referencje<br>');
$obiekt = new stdClass();
$obiekt->a = 1;
$a = new classA();
$a->setA($obiekt);
$obiekt->a = 2;
var_dump($obiekt, $a->getA());
