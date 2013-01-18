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
			\core\registry\RequestRegistry::getAppController()->dispatch();
			\core\registry\SessionRegistry::getInstance()->clearFlashVars();
		}
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
		
		if(\app\config\Settings::$authEnable) {
			$dispatcher = new \core\controller\AuthController($dispatcher);
		}
		
		\core\registry\RequestRegistry::setAppController($dispatcher);
	}
}