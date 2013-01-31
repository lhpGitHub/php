<?php namespace app\auth;

class AppUserLevels extends \core\auth\UserLevels {
	
	static $GUEST = 0;
	static $ADMIN = 1;
	
	function __construct() {
		
		$defaultRequiredUserLevel = self::$ADMIN;
		
		$actionsRequiredUserLevel = array(
			'person-create'	=> self::$ADMIN,
			'person-read'	=> self::$GUEST,
			'person-update'	=> self::$ADMIN,
			'person-delete'	=> self::$ADMIN
		);
		
		parent::__construct($defaultRequiredUserLevel, $actionsRequiredUserLevel);
	}
}