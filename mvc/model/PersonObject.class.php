<?php
class PersonObject extends DomainObject {
	
	static function getCollection(array $raw = null, Mapper $mapper = null) {
		return new PersonCollection($raw, $mapper);
	}
	
	public $id,
		   $fName,
		   $lName;
	
}