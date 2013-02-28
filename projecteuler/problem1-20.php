<?php
require_once 'printLine.php';

printLn('---Multiples of 3 and 5---');
$time_start = microtime(true);
$i = 1;
$r = 0;
while(($b = 3*$i++) < 1000) {
	$r += $b;
}
$i = 1;
while(($b = 5*$i++) < 1000) {
	if($b % 3 != 0)
		$r += $b;
}
$time_end = microtime(true);
$t = $time_end - $time_start;
printLn("result: $r, time: $t");

printLn('<br>'); printLn('---Even Fibonacci numbers---');
$time_start = microtime(true);
$a = array(1,1);
$t = 0;
$r = 0;
while (TRUE) {
	$t = $a[0] + $a[1];
	
	if($t>=4000000) break;
	
	$a[0] = $a[1];
	$a[1] = $t;
	
	if(!($t%2))
		$r += $t;
}
$time_end = microtime(true);
$t = $time_end - $time_start;
printLn("result: $r, time: $t");

printLn('<br>'); printLn('---Largest prime factor---');
$time_start = microtime(true);
$a = 600851475143;
$b = round($a/2);
printf('%d %d<br>', $a, $b);
$r = NULL;
while($a == 0) {
	if($a % $b)
		printf('%d <br>', $b);
	$b--;
}
$time_end = microtime(true);
$t = $time_end - $time_start;
printLn("result: $r, time: $t");


printLn('<br>'); printLn('---Largest palindrome product---');
$time_start = microtime(true);
var_dump(isPalindrome(68137186));

$time_end = microtime(true);
$t = $time_end - $time_start;

function isPalindrome($number) {
	$numberStr = (string) $number;
	$len = strlen($numberStr);
	for($i=0, $j=$len-1, $k=round($len/2, 0, PHP_ROUND_HALF_DOWN); $i<$k; $i++, $j--) {
		if($numberStr{$i} != $numberStr{$j})
			return FALSE;
	}
	return TRUE;
}


printLn("result: $r, time: $t");
