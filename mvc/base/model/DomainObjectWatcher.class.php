<?php
class DomainObjectWatcher {

	private static $domainObjects = array();
	
	static function addObject(DomainObject $dObj) {
		$key = self::getKey(get_class($dObj), $dObj->getId());
		
		if(!isset(self::$domainObjects[$key]))
			self::$domainObjects[$key] = $dObj;
	}
	
	static function getObject($className, $id) {
		$key = self::getKey($className, $id);
		
		if(isset(self::$domainObjects[$key]))
			return self::$domainObjects[$key];
		else
			return NULL;
	}
	
	static function removeObject($className, $id) {
		$key = self::getKey($className, $id);
		unset(self::$domainObjects[$key]);
	}
	
	private static function getKey($className, $id) {
		return $className.$id;
	}
	
	function toString() {
		return '<pre>'.print_r(self::$domainObjects, true).'</pre>';
	}
}