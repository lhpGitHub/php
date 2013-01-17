<?php namespace core\controller;

class AuthController implements IDispatcher {
	
	private $appController;
	private $user;

	function __construct(IDispatcher $appController) {
		$this->appController = $appController;
	}
	
	function __destruct() {
		\core\registry\SessionRegistry::getInstance()->setUser('User123');
	}
	
	function dispatch($controllerName = null, $actionName = null) {
		
		$userClass = \app\config\Settings::$authUserClass;
		
		if(!$this->recoverUser($userClass)) {
			$this->createUser($userClass);
		}
		
		return $this->appController->dispatch($controllerName, $actionName);
	}
	
	private function recoverUser($userClass) {
		$user = \core\registry\SessionRegistry::getInstance()->getUser();
		var_dump($user);
		return TRUE;
	}
	
	private function createUser($userClass) {
		try {
			$c = new \ReflectionClass($userClass);
			$this->user = $c->newInstance();
		} catch(\ReflectionException $err) {
			throw new \core\exception\AuthException(sprintf('Create user failed, class name [%s]', $userClass), 0);
		}
	}
}