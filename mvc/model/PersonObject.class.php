<?php
class PersonObject extends DomainObject {
	
	private $fName,
		    $lName;
	
	function setFirstName($val) {
		$this->fName = $val;
		$this->markDirty();
	}
	
	function getFirstName() {
		return $this->fName;
	}
	
	function setLastName($val) {
		$this->lName = $val;
		$this->markDirty();
	}
	
	function getLastName() {
		return $this->lName;
	}
	
	function __toString() {
		return sprintf('Person Object ID:%s, %s %s', $this->getId(), $this->fName, $this->lName);
	}
}