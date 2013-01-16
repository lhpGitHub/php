<?php namespace app\config;

use core\model\dba\DataBaseAccessFactory as DataBaseAccessFactory;

class Settings {
	
	/*constans*/
	const DEVE = 'develop';
	const PROD = 'production';
	/**/
	
	/*settings*/
	static $env = self::PROD;
	static $debug = false;
	static $defaultController = '';
	static $defaultAction = '';
	static $mainPath = '';
	static $assetsPath = '';
	static $authEnable = TRUE;
	static $authUserClass = 'app\models\UserObject';
	
	
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
	
	static $dataBaseExt = DataBaseAccessFactory::MYSQLI;

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