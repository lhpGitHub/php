<?php
//header('Content-Type: text/plain; charset=UTF-8');

$a = array('k1'=>'mydlo',	'k2'=>'kurz',	'k3'=>'mydlo');
$b = array('k1'=>'szare',	'k2'=>'tlusty',	'k3'=>'fa');

$res = array_diff($a, $b);
var_dump($res);
echo "\n";

$c = $a;
$res = array_diff($a, $c);
var_dump((boolean)$res);
echo "\n";


?>