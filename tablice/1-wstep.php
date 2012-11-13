<?php

$a = array('jablko', 'banan', 'gruszka');
print '<br/>tablica A<br/>';
displayArray($a);

$b = array(1 => 'jablko', 'cytrus'=>'banan', 'gruszka');
$b[] = 'wisnia';
print '<br/>tablica B<br/>';
displayArray($b);

print '<br/>listowanie tablicy do zmiennych<br/>';
list($a, $b) = array('poziomka', 'truskawka');
print "$a, $b";


function displayArray($a) {
	foreach($a as $k => $v) {
		print "$k => $v<br/>";
	}
}
?>
