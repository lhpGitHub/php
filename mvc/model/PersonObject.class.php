<?php
class PersonObject extends DomainObject {
	
	public $fName,
		   $lName;
	
	function __toString() {
		return sprintf('Person Object ID:%s, %s %s', $this->getId(), $this->fName, $this->lName);
	}
}