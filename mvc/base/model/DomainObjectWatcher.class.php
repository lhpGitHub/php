<?php
class DomainObjectWatcher {

	private static $all = array();
	private static $new = array();
	private static $dirty = array();
	private static $delete = array();
	
	static function addObject(DomainObject $dObj) {
		$key = self::getKey($dObj);
		
		if(!isset(self::$all[$key]))
			self::$all[$key] = $dObj;
	}
	
	static function getObject($className, $id) {
		$key = self::getKey($className, $id);
		
		if(isset(self::$all[$key]))
			return self::$all[$key];
		else
			return NULL;
	}
	
	static function removeObject(DomainObject $dObj) {
		$key = self::getKey($dObj);
		unset(self::$all[$key]);
	}
	
	static function addNew(DomainObject $dObj) {
		self::$new[] = $dObj;
	}
		
	static function addDirty(DomainObject $dObj) {
		if(!in_array($dObj, self::$new)) {
			$key = self::getKey($dObj);
			self::$dirty[$key] = $dObj;
		}
	}
	
	static function addDelete(DomainObject $dObj) {
		self::removeArrayElement(self::$new, $dObj);
		$key = self::getKey($dObj);
		unset(self::$dirty[$key]);
		self::$delete[$key] = $dObj;
	}
	
	static function addClean(DomainObject $dObj) {
		$key = self::getKey($dObj);
		self::removeArrayElement(self::$new, $dObj);
		unset(self::$dirty[$key]);
		unset(self::$delete[$key]);
	}
	
	static function performOperations() {
		
		reset(self::$new);
		reset(self::$dirty);
		reset(self::$delete);
		
		while($dObj = current(self::$new)) {
			printf("INSERT %s<br>", $dObj);
			
			$dObj->mapper()->insert($dObj);
			
			next(self::$new);
		}
		
		while($dObj = current(self::$dirty)) {
			printf("UPDATE %s<br>", $dObj);
			next(self::$dirty);
		}
		
		while($dObj = current(self::$delete)) {
			printf("DELETE %s<br>", $dObj);
			next(self::$delete);
		}
	}

	static function getKey() {
		$args = func_get_args();
		
		if($args[0] instanceof DomainObject) {
			$dObj = $args[0];
			return get_class($dObj).$dObj->getId();
			
		} else if(!is_null($args[0]) && !is_null($args[1])) {
			$className = $args[0]; $id = $args[1];
			return $className.$id;
			
		}
		
		throw new InvalidArgumentException('key generation error');
	}
	
	static function removeArrayElement(&$array, $element) {
		reset($array);
		while(list($key, $val) = each($array)) {
			if($val === $element) unset($array[$key]);
		}
	}  

	function toString() {
		return '<pre>'.print_r(self::$all, true).'</pre>';
	}
}