<?php namespace core\controller;

class AppController {
	
	private $controller;
	private $action;

	function __construct() {}
	
	function dispatch($controllerName, $actionName) {
		
		if($this->makeAction($controllerName, $actionName)) {
			return $this->invokeAction();
		} else {
			$this->invokeError();
		}
	}
	
	protected function makeAction($controllerName, $actionName) {
		
		if($this->searchAction('app\controllers\\', $controllerName, $actionName)) 
			return TRUE;
		
		if($this->searchAction('core\controllers\\', $controllerName, $actionName)) 
			return TRUE;
		
		return FALSE;
	}
	
	private function searchAction($pathToControllers, $controllerName, $actionName) {
		
		$controllerName = $pathToControllers.ucfirst($controllerName.'Controller');
		$actionName = 'action'.ucfirst($actionName);
		
		try {
			$this->controller = new \ReflectionClass($controllerName);
		} catch (\core\exception\FileNotExistsException $err) {
			return FALSE;
		}
		
		try {
			$this->action = new \ReflectionMethod($controllerName, $actionName);
		} catch(\ReflectionException $err) {
			return FALSE;
		}
		
		return TRUE;
	}

	protected function invokeAction() {
		try {
			return $this->action->invoke($this->controller->newInstance());
		} catch(\ReflectionException $err) {
			return FALSE;
		} 
	}
	
	protected function invokeError() {
		\core\registry\RequestRegistry::getRequest()->errorNotFound();
	}
}