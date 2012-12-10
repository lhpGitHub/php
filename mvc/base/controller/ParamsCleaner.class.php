<?php
class ParamsCleaner {
	
	static function getSanitizeParam() {
		$arg = func_get_args();
		$sanitizeParams = array();
		$i = 0;
		$request = array_shift($arg);
				
		foreach($arg as $type) {
			$func = 'validate'.$type;
			$sanitizeParams[] = call_user_func(array(__CLASS__, $func), $request->getParam($i++));
		}
		return $sanitizeParams;
	}

	
	static function validateString($var) {
		if(isset($var) && !empty($var)) {
			settype($var, 'string');
			return $var;
		}
		else {
			return NULL;
		}
	}
	
	static function validateInteger($var) {
		if(isset($var)) {
			settype($var, 'integer');
			return $var;
		}
		else {
			return NULL;
		}
	}
	
	static function isNull($var) {
		return is_null($var);
	}

	static function isNotNull($var) {
		return !is_null($var);
	}

	static function isAllNull() {
		$args = func_get_args();
		
		foreach ($args as $var)
			if(self::isNotNull($var))
				return false;
		
		return true;
	}
	
	static function isAllNotNull() {
		$args = func_get_args();
		
		foreach ($args as $var)
			if(self::isNull($var))
				return false;
		
		return true;
	}
}