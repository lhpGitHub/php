<?php

class MyObservedObject implements SplObserver {
	
	private $id;
	
	public function __construct($id) {
		$this->id = $id;
	}
	
	function update(SplSubject $subject) {
		echo __METHOD__ . " {$this->id}<br>";
	}
	
	function __toString() {
		return $this->id;
	}
}

class MySubjectObject implements SplSubject {
	
	private $observedObj = array();
	
	function attach(SplObserver $observer) {
		$this->observedObj[(string)$observer] = $observer;
	}
	
	function detach(SplObserver $observer) {
		unset($this->observedObj[(string)$observer]);
	}
	
	function notify() {
		
	}
	
	function update() {
		foreach($this->observedObj as $observer) {
			$observer->update($this);
		}
	}
	
	function __toString() {
		$s = '';
		
		foreach($this->observedObj as $k => $v)
			$s .= "$k => $v<br>";
		
		return $s;
	}
}

$o1 = new MyObservedObject('id1');
$o2 = new MyObservedObject('id2');
$o3 = new MyObservedObject('id3');

$subject = new MySubjectObject();
$subject->attach($o1);
$subject->attach($o2);
$subject->attach($o3);

echo $subject;

$subject->detach($o2);
echo $subject;

$subject->update();


?>