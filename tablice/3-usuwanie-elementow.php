<?php

$a = range('a','g');
print '<br/>tablica poczatkowa<br/>';
print_r($a);
print '<br>--------------------';

print '<br/>usuniecie 2 i 4 elementu<br/>';
unset($a[2], $a[4]);
print_r($a);
print '<br>--------------------';

print '<br/>przenumerowanie indeksow w tabeli<br/>';
$a = array_values($a);
print_r($a);
print '<br>--------------------';

print '<br/>usuniecie dwoch kolejnych elementow 0 i 1<br/>';
array_splice($a, 0, 2);
print_r($a);
print '<br>--------------------';

print '<br/>zamiany tablicy asocjacyjnej na numeryczna przez zwrocenie tablicy numerycznej zawierajacej wartosci z tablicy oryginalnej<br/>';
$b = array('listopad'=>'jesien', 'grudzien'=>'zima', 'maj'=>'wiosna');
print_r($b);
print '<br>';
print_r(array_values($b));
print '<br>--------------------';

print '<br/>zwrocenie tablicy numerycznej zawierajacej klucze z tablicy oryginalnej<br/>';
print_r($b);
print '<br>';
print_r(array_keys($b));
print '<br>--------------------';

print '<br/>zwrocenie kluczy pod ktorymi sa znajduja sie szukane wartosci<br/>';
print_r($b);
print '<br>';
print_r(array_keys($b, 'zima'));
print '<br>--------------------';
?>
