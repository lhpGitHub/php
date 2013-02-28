<?php
require_once 'printLine.php';

printLn('---znalezienie w tablicach czesci wspolnej---');
$a = array('identyfikator', 'czas-rejestracji', 'imie', 'nazwisko');
printLn('tablice wej:'); printLn($a);
$r = array_intersect($a, array('identyfikator', 'czas-rejestracji'));
printLn('tablice wyj:'); printLn($r);

