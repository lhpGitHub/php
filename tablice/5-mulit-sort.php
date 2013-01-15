<?php
header('Content-Type: text/plain; charset=UTF-8');

$a = array('k1'=>'mydlo',	'k2'=>'kurz',	'k3'=>'mydlo');
$b = array('k1'=>'szare',	'k2'=>'tlusty',	'k3'=>'fa');

array_multisort($a, $b);


print_r($a);
echo "\n";
print_r($b);

?>