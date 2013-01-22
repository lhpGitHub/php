<?php namespace core\controller;

class ParamsCleaner {
	
	const STRING = 'String';
	const STRING_TRIM = 'StringTrim';
	const INTEGER = 'Integer';


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
	
	static function getSanitizeParamWithKey() {
		$arg = func_get_args();
		$sanitizeParams = array();
		$i = 0;
		$request = array_shift($arg);
		reset($arg);
		
		while ($key = current($arg)) {
			$type = next($arg);
			$func = 'validate'.$type;
			$sanitizeParams[$key] = call_user_func(array(__CLASS__, $func), $request->getParam($i++));
			next($arg);
		}
		
		return $sanitizeParams;
	}

	
	static function validateStringTrim($var) {
		$var = trim($var);
		return self::validateString($var);
	}
	
	static function validateString($var) {
		if(isset($var) && strlen($var)>0) {
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
	
	static function isAllNullArray($params) {
		if(empty($params))
			return true;
		
		foreach ($args as $params)
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
	
	static function isAllNotNullArray($params) {
		if(empty($params))
			return false;
		
		foreach ($params as $var)
			if(self::isNull($var))
				return false;
		
		return true;
	}
}