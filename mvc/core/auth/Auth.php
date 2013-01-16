<?php namespace core\auth;

class Auth {
	
	private $user;

	function __construct($userClass) {
		if(!$this->recoverUser($userClass)) {
			$this->createUser($userClass);
		}
	}
	
	function __destruct() {
		\core\registry\SessionRegistry::getInstance()->setUser('User123');
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