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
	
	private function __construct() {
		switch ($this->detectRequestSource()) {
			case self::JSON:
				$this->actionPrefix = 'jsonAction';
				$this->request = NULL;
				break;	
			
			default:
				$this->actionPrefix = 'action';
				$this->request = new \core\controller\HtmlRequest();
		}
		
		\core\registry\RequestRegistry::setRequest($this->request);
	}
	
	private function detectRequestSource() {
		return self::HTML;
	}
	
	function go() {
		session_start();
		$this->forward($this->request->getControlerName(), $this->request->getActionName());
		\core\registry\SessionRegistry::clearFlashVars();
	}
	
	function forward($controllerName, $actionName) {
		$controllerName	= ucfirst($controllerName.'Controller');
		$actionName	= $this->actionPrefix.ucfirst($actionName);

		try {
			$class = 'app'.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$controllerName;
			$c = new \ReflectionClass($class);
			$m = new \ReflectionMethod($class, $actionName);
			$m->invoke($c->newInstance());
		} catch(\ReflectionException $err) {
			$this->request->error();
		}		
	} 
}