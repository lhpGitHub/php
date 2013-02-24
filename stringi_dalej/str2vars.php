<?php
require_once 'printLine.php';
$stri = '/bizuteria/kolczyki/3/5';
$patt = '/bizuteria/{cat}/{id}/5';
printLn("string do sprawdzenia:");
printLn($stri, 'pre');
printLn("wzorzec:");
printLn($patt, 'pre');
$r = str2var($stri, $patt, $vars);
printLn("dopasowany:");
var_dump($r);
printLn("uzyskane zmienne:");
var_dump($vars);



function str2var($str, $patt, &$output = NULL, $deli = '/') {
	$matching = TRUE;
	array_map(function($patt, $str) use (&$matching, &$output) {
			if($matching) {
				if(!is_null($str) && preg_match('/^{([^{}]+)}$/', $patt, $m)) {
					$output[$m[1]] = $str;
				} else if($patt !== $str) {
					$matching = FALSE;
				}
			}
	},	explode($deli, trim($patt, $deli)), 
		explode($deli, trim($str, $deli))
	);
	if(!$matching) $output = NULL;
	return $matching;
}