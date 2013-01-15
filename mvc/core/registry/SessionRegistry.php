<?php namespace core\registry;

class SessionRegistry {
	
	static $instance;

	private function __construct() {}
	
	static function getInstance() {
		if(!self::$instance) {
			self::$instance = new self;
		}
		
		return self::$instance;
	}
	
	static function setFlashVars($key, $var, $overwrite) {
		if(!isset($_SESSION['flashVars']))
			$_SESSION['flashVars'] = array();
		
		if($overwrite) {
			$_SESSION['flashVars'][$key] = $var;
		} else {
			if(!isset($_SESSION['flashVars'][$key]))
				$_SESSION['flashVars'][$key] = $var;
		}
	}
	
	static function getFlashVars($key) {
		if(isset($_SESSION['flashVars'][$key])) {
			$var = $_SESSION['flashVars'][$key];
			unset($_SESSION['flashVars'][$key]);
			return $var;
		}
		
		return NULL;
	}
	
	static function clearFlashVars() {
		unset($_SESSION['flashVars']);
	}
}