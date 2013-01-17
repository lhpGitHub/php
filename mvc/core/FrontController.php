<?php namespace core;

class FrontController {
	
	const HTML		= 'html';
	const JSON		= 'json';
	const CONSOLE	= 'console';
	
	private static $instance;
	
	private $isIni = FALSE;
	
	static function getInstance() {
		if(!self::$instance)
			self::$instance = new self;
		
		return self::$instance;
	}
	
	private function __construct() {
		\core\registry\SessionRegistry::getInstance()->ini();
	}
	
	function __destruct() {
		\core\registry\SessionRegistry::getInstance()->clearFlashVars();
	}

	function go() {
		if(!$this->isIni) {
			$this->isIni = true;
			$this->createRequestObject();
			$this->createAppController();
			\core\registry\RequestRegistry::getAppController()->dispatch();
		}
	}
	
	private function createRequestObject() {
		switch ($this->detectRequestClient()) {
			case self::JSON:
				$this->request = \core\registry\RequestRegistry::setRequest(NULL);
				break;	
			
			default:
				$this->request = \core\registry\RequestRegistry::setRequest(new \core\controller\HtmlRequest());
		}
	}
	
	private function detectRequestClient() {
		return self::HTML;
	}
	
	private function createAppController() {
		
		$dispatcher = new \core\controller\AppController();
		
		if(\app\config\Settings::$authEnable) {
			$dispatcher = new \core\controller\AuthController($dispatcher);
		}
		
		\core\registry\RequestRegistry::setAppController($dispatcher);
	}
}