<?php namespace core\controller;

class AuthController extends AppController {
	
	private $userLevels;
	private $user;

	function __construct() {
		$this->userLevels = $this->createUserLevels(\core\Config::get('authAccessLevelsClass'));
	}
	
	function __destruct() {
		\core\registry\SessionRegistry::getInstance()->setUser('User123');
	}
	
	public function dispatch($controllerName, $actionName) {
		
		if(is_null($this->user)) {
			$userClass = \core\Config::get('authUserClass');
			if(!$this->recoverUser($userClass)) {
				$this->createUser($userClass);
			}
		}
		
		if(!$this->makeAction($controllerName, $actionName)) {
			$this->invokeError();
			return;
		}
		
		if($this->checkPermissionLevel($controllerName, $actionName)) {
			$this->invokeAction();
		} else {
			\core\registry\RequestRegistry::getRequest()->errorUnauthorized();
		}
	}
	
	public function userLevels() {
		return $this->userLevels;
	}
	
	private function recoverUser($userClass) {
		$user = \core\registry\SessionRegistry::getInstance()->getUser();
		//var_dump($user);
		return FALSE;
	}
	
	private function createUser($userClass) {
		try {
			$c = new \ReflectionClass($userClass);
			$this->user = $c->newInstance();
		} catch(\Exception $err) {
			throw new \core\exception\AuthException(sprintf('Create user failed, class name [%s]', $userClass), 0);
		}
	}
	
	private function createUserLevels($userLevelsClass) {
		try {
			$c = new \ReflectionClass($userLevelsClass);
			return $c->newInstance();
		} catch(\Exception $err) {
			throw new \core\exception\AuthException(sprintf('Create user levels failed, class name [%s]', $userLevelsClass), 0);
		}
	}
	
	private function checkPermissionLevel($controllerName, $actionName) {
		return $this->userLevels()->checkUserLevel($controllerName, $actionName, 'GUEST');
	}
}