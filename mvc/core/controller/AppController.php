<?php namespace core\controller;

class AppController implements IDispatcher {
	
	function __construct() {}
	
	function dispatch($controllerName = null, $actionName = null) {
		
		$request = \core\registry\RequestRegistry::getRequest();
		if(is_null($controllerName)) $controllerName = $request->getControlerName();
		if(is_null($actionName)) $actionName = $request->getActionName();
		
		$controllerName = (empty($controllerName)) ? \app\config\Settings::$defaultController : $controllerName;
		$actionName = (empty($actionName)) ? \app\config\Settings::$defaultAction : $actionName;
		
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