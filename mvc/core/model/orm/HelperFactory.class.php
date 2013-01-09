<?php
class HelperFactory {
	
	private static $mappers = array();

	static function getCollection($type, array $raw = null, Mapper $mapper = null) {
		$type = preg_replace('/(Object|Collection)?$/', '', $type).'Collection';
		$c = new ReflectionClass($type);
		return $c->newInstance($raw, $mapper);
	}
	
	static function getMapper($type) {
		$type = preg_replace('/(Object|Collection)?$/', '', $type).'Mapper';
		if(!isset(self::$mappers[$type])) {
			$c = new ReflectionClass($type);
			self::$mappers[$type] = $c->newInstance(DataBaseAccessFactory::globalAccess());	
		}
		return self::$mappers[$type];
	}
}