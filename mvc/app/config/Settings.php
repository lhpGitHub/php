<?php namespace app\config;

use core\model\dba\DataBaseAccessFactory as DataBaseAccessFactory;

class Settings {
	
	const DEVE = 'develop';
	const PROD = 'production';
	
	const USER_LEVEL_GUEST = 0;
	const USER_LEVEL_REGIS = 1;
	const USER_LEVEL_ADMIN = 2;
	
	/*settings*/
	static $env = self::PROD;
	static $debug = false;
	static $defaultController = '';
	static $defaultAction = '';
	static $mainPath = '';
	static $assetsPath = '';
	static $authEnable = TRUE;
	static $authUserClass = 'app\models\UserObject';
	static $dataBaseExt = DataBaseAccessFactory::MYSQLI;
	
	private static $db_deve = array(
		'type'	=> 'mysql',
		'host'	=> 'localhost',
		'db'	=> 'mvc',
		'user'	=> 'root',
		'pass'	=> ''
	);
	
	private static $db_prod = array(
		'type'	=> 'mysql',
		'host'	=> 'localhost',
		'db'	=> 'mvc',
		'user'	=> 'root',
		'pass'	=> ''
	);

	static $defaultRequiredUserLevel = self::USER_LEVEL_ADMIN;
	
	static $actionsRequiredUserLevel = array(
		'person-read'	=> self::USER_LEVEL_GUEST,
		'person-update'	=> self::USER_LEVEL_REGIS
	);

	static $view = array(
		'dir' => 'app/views/',
		'ext' => '.html',
		'layout' => 'layout'
	);
	/**/

	/*functions*/
	static function dbSett() {
		switch (self::$env) {
			case self::DEVE:	return self::$db_deve;
			case self::PROD:	return self::$db_prod;
			default:			return self::$db_prod;
		}
	}
	/**/
		
}