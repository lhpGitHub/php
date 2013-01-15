<?php namespace core;

class FrontController {
	
	const HTML		= 'html';
	const JSON		= 'json';
	const CONSOLE	= 'console';
	
	static private $instance;
	
	private $actionPrefix;
	private $request;
	
	static function getInstance() {
		if(!self::$instance)
			self::$instance = new self;
		
		return self::$instance;
	}
	
	private function __construct() {}
	
	function go() {
		session_start();
		$this->specifySource();
		\core\registry\RequestRegistry::setRequest($this->request);
		$this->forward($this->request->getControlerName(), $this->request->getActionName());
		\core\registry\SessionRegistry::clearFlashVars();
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
	
	private function specifySource() {
		switch ($this->detectRequestSource()) {
			case self::JSON:
				$this->actionPrefix = 'jsonAction';
				$this->request = NULL;
				break;	
			
			default:
				$this->actionPrefix = 'action';
				$this->request = new \core\controller\HtmlRequest();
		}
	}


	private function detectRequestSource() {
		return self::HTML;
	}
}