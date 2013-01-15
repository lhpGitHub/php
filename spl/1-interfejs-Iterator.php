<?php

class MyIterator implements Iterator {
	
	private $data;
	private $current;
	
	function __construct() {
		$this->data = array();
		$this->current = 0;
	}
	
	function addValue($v) {
		$this->data[] = $v;
	}
	
	function setValues(array $v) {
		$this->data = $v;
	}
	
	function key() {
		var_dump(__METHOD__);
		return $this->current;
	}

	function next() {
		var_dump(__METHOD__);
		$this->current++;
	}
	
	function valid() {
		var_dump(__METHOD__);
		return isset($this->data[$this->current]);
	}
	
	public function current() {
		var_dump(__METHOD__);
		return $this->data[$this->current];
	}
	
	function rewind() {
		var_dump(__METHOD__);
		$this->current = 0;
	}
}

$mi = new MyIterator();
$mi->addValue('abc');
$mi->addValue('def');
$mi->addValue('ghi');

echo $mi->current(); echo '<br>';
echo $mi->next(); echo '<br>';
echo $mi->current(); echo '<br>';
echo $mi->rewind(); echo '<br>';
echo $mi->current(); echo '<br>';
echo $mi->next(); echo '<br>';
echo $mi->next(); echo '<br>';
echo $mi->next(); echo '<br>';
echo $mi->next(); echo '<br>';
echo $mi->next(); echo '<br>';
echo $mi->next(); echo '<br>';
var_dump($mi->current()); echo '<br>';
echo $mi->key(); echo '<br>';


echo "<br><br>--------petla foreach--------<br>";
foreach($mi as $k=>$v) {
	echo "$k => $v<br>";
}
echo "<br>--------+++++++++++++--------<br>";

echo "<br><br>--------petla while--------<br>";
$mi->rewind();
while($mi->current()) {
	echo "{$mi->key()} => {$mi->current()}<br>";
	$mi->next();
}
echo "<br>--------+++++++++++++--------<br>";



?>