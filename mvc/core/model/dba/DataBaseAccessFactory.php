<?php namespace core\model\dba;

class DataBaseAccessFactory {
	
	const FAKE = 'fake';
	const PDO = 'pdo';
	const MYSQLI = 'mysqli';
	
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
			switch (\app\config\Settings::$dataBaseExt) {
				case self::FAKE:
					$ins->globalAccess = new DataBaseAccessFAKE();
					break;
				case self::PDO:
					$ins->globalAccess = new DataBaseAccessPDO();
					break;
				case self::MYSQLI:
					$ins->globalAccess = new DataBaseAccessMYSQLI();
					break;
				default:
					break;
			}
		}
		
		return $ins->globalAccess;
	}
	
}