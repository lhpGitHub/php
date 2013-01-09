<?php
class Settings {
	
	/*constans*/
	const DEVE = 'develop';
	const PROD = 'production';
	/**/
	
	/*settings*/
	static $mode = self::PROD;
	static $debug = false;
	static $defaultController = 'person';
	static $defaultAction = 'read';
	
	
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
	
	static $dataBaseAccessType = DataBaseAccessFactory::MYSQLI;

	static $view = array(
		'dir' => 'views',
		'ext' => '.html',
		'layout' => 'layout'
	);
	/**/

	/*functions*/
	static function dbSett() {
		switch (self::$mode) {
			case self::DEVE: return self::$db_deve;
			case self::PROD: return self::$db_prod;
		}
	}
	/**/
		
}