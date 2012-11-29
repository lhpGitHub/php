<?php
class BaseController {
	
	protected $view;

	function __construct() {
		$this->view = RequestRegistry::getView();
	}

	protected function redirect($uri) {
		$request = RequestRegistry::getRequest();
		header('Location: ' . $request->getAbsolutePath() . $uri);
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
	
	static function isNullAll() {
		$args = func_get_args();
		
		foreach ($args as $var)
			if(!is_null($var))
				return false;
		
		return true;
	}
	
	static function isNotNullAll() {
		$args = func_get_args();
		
		foreach ($args as $var)
			if(is_null($var))
				return false;
		
		return true;
	}
}