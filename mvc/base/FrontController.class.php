<?php
class FrontController {
	
	static private $instance;
	
	static function getInstance() {
		if(!self::$instance)
			self::$instance = new self;
		
		return self::$instance;
	}
	
	private function __construct() {}
	
	function go() {

		session_start();
		$request = new HtmlRequest;
		RequestRegistry::setRequest($request);
		$view = new View;
		RequestRegistry::setView($view);
				
		$this->forward($request->getControlerName(), $request->getActionName());
		
		//$viewName = $this->forward($request->getControlerName(), $request->getActionName());
		//$request->sendView($viewName);
		
		SessionRegistry::clearFlashVars();
	}
	
	function forward($controllerName, $actionName) {
		
		//html - action
		//json - jsonAction
		$mode = 'html';
		$prefix;
		
		switch ($mode) {
			case 'json':
				$prefix = 'jsonAction';
				break;	
			
			default:
				$prefix = 'action';
		}
		
		$controllerName	= $controllerName.'Controller';
		$actionName	= $prefix.ucfirst($actionName);

		try {
			$c = new ReflectionClass($controllerName);
			$m = new ReflectionMethod($controllerName, $actionName);
		} catch(ReflectionException $err) {
			$header = 'HTTP/1.1 404 Not Found';
			header($header);
			echo $header;
			exit();
		}
		
		return $m->invoke($c->newInstance());
	}	
}