<?php
class BaseController {
	
	function __construct() {
		
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
}