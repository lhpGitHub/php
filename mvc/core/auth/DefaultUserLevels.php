<?php namespace core\auth;

class DefaultUserLevels extends UserLevels {
	
	static $GUEST = 0;
	static $REGIS = 1;
	static $ADMIN = 2;
	
	function __construct() {
		$defaultRequiredUserLevel = self::$ADMIN;
		$actionsRequiredUserLevel = array();
		parent::__construct($defaultRequiredUserLevel, $actionsRequiredUserLevel);
	}
}