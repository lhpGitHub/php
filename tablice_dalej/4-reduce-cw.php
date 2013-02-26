<?php
require_once 'printLine.php';

printLn('---wyliczanie sredniej z wartosci w tablicy---');
$a = array(2,4,2);
printLn('tablica wejsciowa:'); printLn($a);
$r = average($a);
printLn(sprintf("srednia to: %.2f", $r));

function average(array $arr) {
	$r = array_reduce($arr, function($tmpVal, $val){
		return $tmpVal + $val;
	});
	return $r/count($arr);
}

printLn(); printLn('---zastosowanie reduce na tablic tablic---');
$a = array(	array('time' => 2, 'distance' => 4),
			array('time' => 4, 'distance' => 10),
		  );
printLn('tablica wej:'); print_r($a);
$i = count($a);
$r = array_reduce($a, function($tmpArr, $arr) use($i) {
	$tmpArr['time'] += $arr['time'];
	$tmpArr['distance'] += $arr['distance'];
	
	if(!isset($tmpArr['__i'])) 
		$tmpArr['__i'] = 1; 
	else 
		$tmpArr['__i']++; 
	
	if(!isset($tmpArr['__s']))
		$tmpArr['__s'] = 0;
	
	$tmpArr['__s'] += $arr['distance'] / $arr['time'];

	if($tmpArr['__i'] == $i) {
		$tmpArr['averageSpeed'] = $tmpArr['__s'] / $tmpArr['__i'];
		$tmpArr['totalTime'] = $tmpArr['time'];
		$tmpArr['totalDistance'] = $tmpArr['distance'];
		unset($tmpArr['__i'], $tmpArr['__s'], $tmpArr['time'], $tmpArr['distance']);
	}
	return $tmpArr;
}, array('time' => 0, 'distance' => 0));
printLn(); printLn('tablica z wynikiem:'); print_r($r);


printLn(); printLn('------');
