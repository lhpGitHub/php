<?php

class PersonTO {
	
	private $data;
	
	function __construct() {
		$this->data = array();
	}
	
	function addPerson($id, $fName, $lName) {
		$this->data[] = array('id'=>$id, 'fName'=>$fName, 'lName'=>$lName);
	}
	
	function getIterator() {
		return new ArrayIterator($this->data);
	}
}

?>
