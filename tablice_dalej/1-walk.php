<?php
require_once 'printLine.php';

$a = array();
$a[] = 'ciag znakow';
$a[] = 1;
$a[] = 2.5;
$a[] = TRUE;
$a[] = array('A', 'B', 'C'=>array('D', 'E'));
$a[] = new stdClass();
$file = fopen(__FILE__, 'r');
$a[] = $file;

$print = function($val, $key, $data) {
	
	switch (gettype($val)) {
		case 'object':
			$val = 'Object';
			break;
		
		case 'array':
			$val = 'Array';
			break;
	}
	
	printf('<pre>%s > k: %s, v:%s </pre>', $data, $key, $val);
};

printLn('array_walk_recursive, tablica zrodlowa przechowujaca dane roznych typow');
printLn('rekursywne przetwarzanie tablic zagniezdzonych');
array_walk_recursive($a, $print, 'walk recursive');

printLn(); printLn('array_walk, tablica zrodlowa przechowujaca dane roznych typow');
printLn('brak rekursywnego przetwarzania tablic zagniezdzonych');
array_walk($a, $print, 'walk');

fclose($file);

printLn(''); printLn('array_walk, zamiana zawartosci tablicy zrodlowej');
printLn('przekazanie do callbacka wartosci przez refernecje');
$a = array(2,4,6);
printLn('tablica zrodlowa przed operacja <pre>'.print_r($a, TRUE).'</pre>');
array_walk($a, function(&$v, $k){
	$v *= 2;
});
printLn('tablica zrodlowa po operacji <pre>'.print_r($a, TRUE).'</pre>');