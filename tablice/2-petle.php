<?php

$a = range(1,10);
print '<br/>petla foreach, operowanie na kopi tablicy<br/>';
foreach($a as $k => $v) {
	echo "$k => $v; ";
	$a[10] = 'dodatkowy element na koncu tablicy, ktory nie jest uwzgledniony podczas iteracji foreach';
}
print '<br>'; print 'oryginalna tablica:'; print_r($a); print '<br>--------------------';

$a = range(1,10);
print '<br/>petla for, operowanie na oryginalnej tablicy<br/>';
for($i=0, $ele=count($a); $i<$ele; $i++) {
	echo "$i => $a[$i]; ";
}
print '<br>--------------------';

$a = range(1,10);
print '<br/>petla while, operowanie na oryginalnej tablicy<br/>';
while(list($k, $v) = each($a)) {
	echo "$k => $v; ";
	$a[10] = 'dodatkowy element na koncu tablicy, ktory bedzie uwzgledniony podczas iteracji while';
}
print '<br>--------------------';

$b = array('listopad'=>'jesien', 'grudzien'=>'zima', 'maj'=>'wiosna');
print '<br/>petla foreach na tablicy asocjacyjnej<br/>';
foreach ($b as $k=>$v) {
	echo "$k => $v; ";
}
print '<br>--------------------';

print '<br/>petla for na tablicy asocjacyjnej<br/>';
for (reset($b); $k = key($b), $v=current($b); next($b)) {
	echo "$k => $v; ";
}
print '<br>--------------------';

print '<br/>petla while na tablicy asocjacyjnej<br/>';
reset($b);
while(list($k, $v) = each($b)) {
	echo "$k => $b[$k]; ";
}
print '<br>--------------------';
?>
