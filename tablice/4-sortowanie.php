<?php
header('Content-Type: text/html; charset=UTF-8');

$a = array('k10'=>'10rosja', 'k11'=>'Łśrr', 'k12'=>'lhp', 1=>'Łąka', 'k1'=>'1polska', 'k2'=>'2niemcy');

print '<br/>tablica poczatkowa:<br/>';
print_r($a);
print '<br>--------------------';

$b = $a;
print '<br/>tablica posortowana funkcja sort():<br/>';
sort($b); print_r($b);
print '<br>--------------------';

$b = $a;
print '<br/>tablica posortowana funkcja asort():<br/>';
asort($b); print_r($b);
print '<br>--------------------';

$b = $a;
print '<br/>tablica posortowana funkcja natsort():<br/>';
natsort($b); print_r($b);
print '<br>--------------------';

$b = $a;
print '<br/>tablica posortowana funkcja natcasesort():<br/>';
natcasesort($b); print_r($b);
print '<br>--------------------';

$b = $a;
print '<br/>tablica posortowana funkcja ksort():<br/>';
ksort($b); print_r($b);
print '<br>--------------------';

$b = $a;
print '<br/>tablica posortowana funkcja usort():<br/>';
usort($b, 'polishAlphabetStrcmp'); print_r($b);
print '<br>--------------------';

print '<br/>tablica oryginalna:<br/>';
print_r($a);
print '<br>--------------------';




function polishAlphabetStrcmp($strA, $strB) {

	$polishAlphabet = 'AĄBCĆDEĘFGHIJKLŁMNŃOÓPRSŚTUWYZŹŻaąbcćdeęfghijklłmnńoóprsśtuwyzźż';
	$lenPolishAlphabet = mb_strlen($polishAlphabet, 'UTF-8');
	$len = min(mb_strlen($strA), mb_strlen($strB));
	
	for($i=0; $i<$len; $i++) {
		
		$s1 = $s2 = 0;
		
		for($j=0; $j<$lenPolishAlphabet; $j++)
		{
			if(mb_substr($strA, $i, 1, 'UTF-8') == mb_substr($polishAlphabet, $j, 1, 'UTF-8')) {
				$s1 = $j;
				break;
			}
		}
		
		for($j=0; $j<$lenPolishAlphabet; $j++)
		{
			if(mb_substr($strB, $i, 1, 'UTF-8') == mb_substr($polishAlphabet, $j, 1, 'UTF-8')) {
				$s2 = $j;
				break;
			}
		}
		
		if($s1 < $s2)
			return -1;
		else if($s1 > $s2)
			return 1;
	}
	
	return 0;
}

?>
