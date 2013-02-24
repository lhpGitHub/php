<?php
require_once 'printLine.php';

$get = "first=value1&second=value2&third=value3";
printLn('ciag do parsowania '.$get);
$r = parseQueryString($get);
printLn('tablica wznikowa:');
var_dump($r);

function parseQueryString($str) {
	$elements = explode('&', trim($str, '&'));
	$output = array();
	$check = function(&$v) { return (isset($v) && !empty($v)); };
	array_walk($elements, function($element) use(&$output, $check) {
		$a = explode('=', $element);
		if($check($a[0]) && $check($a[1])) {
			$output[$a[0]] = $a[1]; 
		}
	});
	return $output;
}