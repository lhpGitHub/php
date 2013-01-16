<?php namespace core;

class FrontController {
	
	const HTML		= 'html';
	const JSON		= 'json';
	const CONSOLE	= 'console';
	
	private static $instance;
	
	private $isIni = FALSE;
	private $actionPrefix;
	private $request;
	
	static function getInstance() {
		if(!self::$instance)
			self::$instance = new self;
		
		return self::$instance;
	}
	
	private function __construct() {
		
	}
	
	function __destruct() {
		\core\registry\SessionRegistry::getInstance()->clearFlashVars();
	}

	function go() {
		if(!$this->isIni) {
			$this->isIni = true;
			\core\registry\SessionRegistry::getInstance()->ini();
			$this->specifyRequestClient();
			$this->runAuthorization();
			\core\registry\RequestRegistry::setRequest($this->request);
			$this->forward($this->request->getControlerName(), $this->request->getActionName());
		}
	}
	
	function forward($controllerName, $actionName) {
		$controllerName	= ucfirst($controllerName.'Controller');
		$actionName	= $this->actionPrefix.ucfirst($actionName);

		try {
			$class = 'app\controllers\\'.$controllerName;
			$c = new \ReflectionClass($class);
			$m = new \ReflectionMethod($class, $actionName);
			$m->invoke($c->newInstance());
		} catch(\ReflectionException $err) {
			$this->request->error();
		}		
	}
	
	private function runAuthorization() {
		if(\app\config\Settings::$authEnable) {
			$auth = new \core\auth\Auth(\app\config\Settings::$authUserClass);
			\core\registry\RequestRegistry::setAuth($auth);
		}
			
	}

	private function specifyRequestClient() {
		switch ($this->detectRequestClient()) {
			case self::JSON:
				$this->actionPrefix = 'jsonAction';
				$this->request = NULL;
				break;	
			
			default:
				$this->actionPrefix = 'action';
				$this->request = new \core\controller\HtmlRequest();
		}
	}

	private function detectRequestClient() {
		return self::HTML;
	}
}