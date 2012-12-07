<?php
class HelperFactory {
	
	static function getCollection($type, array $raw = null, Mapper $mapper = null) {
		$type = preg_replace('/(Object|Collection)?$/', '', $type).'Collection';
		$c = new ReflectionClass($type);
		return $c->newInstance($raw, $mapper);
	}
}