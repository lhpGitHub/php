<?php
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
				$this->request = new HtmlRequest();
		}
		
		RequestRegistry::setRequest($this->request);
	}
	
	private function detectRequestSource() {
		return self::HTML;
	}
	
	function go() {
		session_start();
		$this->forward($this->request->getControlerName(), $this->request->getActionName());
		SessionRegistry::clearFlashVars();
	}
	
	function forward($controllerName, $actionName) {
		$controllerName	= $controllerName.'Controller';
		$actionName	= $this->actionPrefix.ucfirst($actionName);

		try {
			$c = new ReflectionClass($controllerName);
			$m = new ReflectionMethod($controllerName, $actionName);
			$m->invoke($c->newInstance());
		} catch(ReflectionException $err) {
			$this->request->error();
		}		
	}	
}