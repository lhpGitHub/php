<?php
class BaseController {
	
	protected $view;

	function __construct() {
		$this->view = RequestRegistry::getView();
	}
	
	protected function getRequest() {
		return RequestRegistry::getRequest();
	}
	
	protected function redirect($uri) {
		header('Location: ' . $this->getRequest()->getAbsolutePath() . $uri);
		die;
	}
	
	protected function forward($controllerName, $actionName) {
		FrontController::getInstance()->forward($controllerName, $actionName);
	}
	
	protected function setFlash($key, $var) {
		SessionRegistry::setFlashVars($key, $var, true);
	}
	
	protected function setFlashBlockOverride($key, $var) {
		SessionRegistry::setFlashVars($key, $var, false);
	}
	
	protected function getFlash($key) {
		return SessionRegistry::getFlashVars($key);
	}
	
	protected function getSanitizeParam() {
		$request = $this->getRequest();
		$sanitizeParams = array();
		$i = 0;
		
		foreach(func_get_args() as $type) {
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