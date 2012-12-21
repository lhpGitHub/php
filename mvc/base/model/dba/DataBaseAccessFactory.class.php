<?php
class DataBaseAccessFactory {
	
	const FAKE = 'fake';
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
			switch (Settings::$dataBaseAccessType) {
				case self::FAKE:
					$ins->globalAccess = new DataBaseAccessFAKE();
					break;
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