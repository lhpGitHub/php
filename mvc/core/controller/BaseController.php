<?php namespace core\controller;

class BaseController {
	
	function __construct() {
		
	}

	protected function getRequest() {
		return \core\registry\RequestRegistry::getRequest();
	}
	
	protected function redirect($uri) {
		header('Location: ' . $this->getRequest()->getAbsolutePath() . $uri);
		die;
	}
	
	protected function forward($controllerName, $actionName) {
		\core\FrontController::getInstance()->forward($controllerName, $actionName);
	}
	
	protected function setFlash($key, $var) {
		\core\registry\SessionRegistry::setFlashVars($key, $var, true);
	}
	
	protected function setFlashBlockOverride($key, $var) {
		\core\registry\SessionRegistry::setFlashVars($key, $var, false);
	}
	
	protected function getFlash($key) {
		return \core\registry\SessionRegistry::getFlashVars($key);
	}	
}