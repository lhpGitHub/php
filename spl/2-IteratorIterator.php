<?php

$a = range('a', 'd');
$i = new IteratorIterator(new ArrayObject($a));

$i->rewind();
echo $i->current(); echo '<br>';
$i->next();
$i->next();
$i->next();
$i->next();

echo '<br>';
echo '<br>';

var_dump($i->current()); echo '<br>';
var_dump($i->key()); echo '<br>';


echo "<br><br>--------petla foreach--------<br>";
foreach($i as $k=>$v) {
	echo "$k => $v<br>";
}
echo "<br>--------+++++++++++++--------<br>";

echo "<br><br>--------petla while--------<br>";
$i->rewind();
while($i->current()) {
	echo "{$i->key()} => {$i->current()}<br>";
	$i->next();
}
echo "<br>--------+++++++++++++--------<br>";



?>