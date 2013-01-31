<?php namespace core\controller;

class AppController implements IDispatcher {
	
	function __construct() {}
	
	function dispatch($controllerName, $actionName) {
		
		$controllerClass = 'app\controllers\\'.ucfirst($controllerName.'Controller');
		$actionName = 'action'.ucfirst($actionName);
		
		try {
			$c = new \ReflectionClass($controllerClass);
		} catch (\core\exception\FileNotExistsException $err) {
			\core\registry\RequestRegistry::getRequest()->error();
			return FALSE;
		}
		
		try {
			$m = new \ReflectionMethod($controllerClass, $actionName);
			return $m->invoke($c->newInstance());
		} catch(\ReflectionException $err) {
			\core\registry\RequestRegistry::getRequest()->error();
			return FALSE;
		} 
	}
}