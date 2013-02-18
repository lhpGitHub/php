<?php

$zmienna = 123;

$funkcja = function($arg) use ($zmienna) {
	printf('arg: %d, zew: %d', $arg, $zmienna);
};

var_dump($funkcja);

echo '<br>wywolanie funkcja()<br>';
$funkcja(456);

echo '<br>wywolanie funkcja->__invoke()<br>';
$funkcja->__invoke(456);