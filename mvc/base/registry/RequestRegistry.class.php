<?php
class RequestRegistry {
	
	static $instance;
	private static $request;
	private static $view;
	private static $mappers = array();

	private function __construct() {}
	
	static function getInstance() {
		if(!self::$instance) {
			self::$instance = new self;
		}
		
		return self::$instance;
	}
	
	static function setRequest(BaseRequest $request) {
		self::$request = $request;
	}
	
	static function getRequest() {
		return self::$request;
	}
	
	static function setView(View $view) {
		self::$view = $view;
	}
	
	static function getView() {
		return self::$view;
	}
	
	static function setMapper($key, Mapper $mapper) {
		self::$mappers[$key] = $mapper;
	}
	
	static function getMapper($key) {
		if(isset(self::$mappers[$key]))
			return self::$mappers[$key];
		else
			return NULL;
	}
}