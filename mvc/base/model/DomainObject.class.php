<?php
abstract class DomainObject {
	
	private $id;
	
	public function __construct($id = null) {
		$this->id = $id;
	}
	
	static function getCollection($type, array $raw = null, Mapper $mapper = null) {
		return HelperFactory::getCollection($type, $raw, $mapper);
	}
	
	function collection(array $raw = null, Mapper $mapper = null) {
		return self::getCollection(get_class($this), $raw, $mapper);
	}
	
	function setId($id) {
		$this->id = $id;
	}
	
	function getId() {
		return $this->id;
	}
}