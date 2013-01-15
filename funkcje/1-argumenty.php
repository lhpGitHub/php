<?php

$a = range('a','c');
print '<br/>przekazanie tablicy do funkcji';
print '<br/>oryginal przed: '; print_r($a);
print '<br/>w funkcji: '; a($a);
print '<br/>oryginal po: '; print_r($a);
print '<br/>--------------------';


$b = 'abc';
print '<br/>przekazanie string do funkcji';
print '<br/>oryginal przed: '; print_r($b);
print '<br/>w funkcji: '; b($b);
print '<br/>oryginal po: '; print_r($b);
print '<br/>--------------------';


$c = 1;
print '<br/>przekazanie integer do funkcji';
print '<br/>oryginal przed: '; print_r($c);
print '<br/>w funkcji: '; c($c);
print '<br/>oryginal po: '; print_r($c);
print '<br/>--------------------';


function a(array $array) {
	$array[] = 'd';
	print_r($array);
}

function b($string) {
	$string = $string.'d';
	print_r($string);
}

function c($integer) {
	$integer++;
	print_r($integer);
}
?>
