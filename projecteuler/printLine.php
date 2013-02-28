<?php

function printLn($toPrint = '', $wrapp = NULL) {
	
	if(is_array($toPrint)) {
		$s = arrayToString($toPrint);
	} else if(is_string($toPrint) || is_numeric($toPrint)) {
		$s = $toPrint;
	} else {
		throw new Exception('arg must be array or string');
	}
	
	if(is_null($wrapp)) {
		printf('%s <br>', $s);
	}else{
		printf('<%s>%s <br></%s>', $wrapp, $s, $wrapp);
	}
}

function arrayToString($a) {
	$s = '';

	array_walk_recursive($a, function($val, $key) use (&$s) {
		$s .= sprintf(' | [%s=>%s]', $key, $val);
	});
	
	return substr($s, 2);
}