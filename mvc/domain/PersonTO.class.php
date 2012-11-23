<?php
class PersonTO {
	
	private $data;
	
	function __construct($id = null, $fName = null, $lName = null) {
		$this->data = array();
		
		if(!is_null($id) || !is_null($fName) || !is_null($lName))
			$this->addPerson($id, $fName, $lName);
	}
	
	function addPerson($id, $fName, $lName) {
		$this->data[] = array('id'=>$id, 'fName'=>$fName, 'lName'=>$lName);
	}
	
	function getIterator() {
		return new ArrayIterator($this->data);
	}
}