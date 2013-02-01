<?php namespace core\registry;

class RequestRegistry {
	
	static $instance;
	private static $request;
	private static $appController;

	private function __construct() {}
	
	static function getInstance() {
		if(!self::$instance) {
			self::$instance = new self;
		}
		
		return self::$instance;
	}
	
	static function setRequest(\core\controller\BaseRequest $request) {
		self::$request = $request;
	}
	
	static function getRequest() {
		return self::$request;
	}
	
	static function setAppController(\core\controller\AppController $appController) {
		self::$appController = $appController;
	}
	
	static function getAppController() {
		return self::$appController;
	}
}