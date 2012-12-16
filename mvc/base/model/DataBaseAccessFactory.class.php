<?php
class DataBaseAccessFactory {
	
	const NATIVE = 'native';
	const PDO = 'pdo';
	
	static private $instance;
	private $globalAccess;
	
	private function __construct() {}
	
	static function getInstance() {
		if(is_null(self::$instance)) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	static function globalAccess() {
		$ins = self::getInstance();
		if(is_null($ins->globalAccess)) {
			$dbSett = Settings::dbSett();
			switch ($dbSett['drv']) {
				case self::PDO:
					$ins->globalAccess = new DataBaseAccessPDO();
					break;
				default:
					break;
			}
		}
		return $ins->globalAccess;
	}
	
}