<?php
abstract class DomainObject {
	
	static function getCollection($type, array $raw = null, Mapper $mapper = null) {
		return HelperFactory::getCollection($type, $raw, $mapper);
	}
	
	function collection(array $raw = null, Mapper $mapper = null) {
		return self::getCollection(get_class($this), $raw, $mapper);
	}
}