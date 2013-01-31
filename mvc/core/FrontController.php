<?php namespace core;

class FrontController {
	
	const HTTP		= 'http';
	const JSON		= 'json';
	const CLI		= 'cli';
	
	private static $instance;
	
	private $isIni = FALSE;
	
	static function getInstance() {
		if(!self::$instance)
			self::$instance = new self;
		
		return self::$instance;
	}
	
	private function __construct() {}
	
	function go() {
		if(!$this->isIni) {
			$this->isIni = true;
			$this->createRequestObject();
			\core\registry\SessionRegistry::getInstance()->ini();
			$this->createAppController();
			$this->dispatch();
			\core\registry\SessionRegistry::getInstance()->clearFlashVars();
		}
	}
	
	private function dispatch() {
		$request = \core\registry\RequestRegistry::getRequest();
		$controllerName = $request->getControlerName();
		$actionName = $request->getActionName();
		$controllerName = (empty($controllerName)) ? \core\Config::get('defaultController') : $controllerName;
		$actionName = (empty($actionName)) ? \core\Config::get('defaultAction') : $actionName;

		\core\registry\RequestRegistry::getAppController()->dispatch($controllerName, $actionName);
	}

		private function createRequestObject() {
		switch ($this->detectRequestClient()) {
			
			case self::JSON:
				$this->request = \core\registry\RequestRegistry::setRequest(NULL);
				break;	
			
			case self::CLI:
				$this->request = \core\registry\RequestRegistry::setRequest(new \core\controller\CliRequest());
				break;	
			
			default:
				$this->request = \core\registry\RequestRegistry::setRequest(new \core\controller\HtmlRequest());
		}
	}
	
	private function detectRequestClient() {
		
		if(PHP_SAPI == 'cli') {
			return self::CLI;
		}
		
		return self::HTTP;
	}
	
	private function createAppController() {
		
		$dispatcher = new \core\controller\AppController();
		
		if(\core\Config::get('authEnable')) {
			$dispatcher = new \core\controller\AuthController($dispatcher);
		}
		
		\core\registry\RequestRegistry::setAppController($dispatcher);
	}
}