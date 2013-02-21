<?php

function printLn($toPrint = '') {
	
	if(is_array($toPrint)) {
		$s = arrayToString($toPrint);
	} else if(is_string($toPrint)) {
		$s = $toPrint;
	} else {
		throw new Exception('content faild');
	}
	
	printf('%s <br>', $s);
}

function arrayToString($a) {
	$s = '';

	array_walk_recursive($a, function($val, $key) use (&$s) {
		$s .= sprintf('k: %s, v:%s | ', $key, $val);
	});
	
	return $s;
}