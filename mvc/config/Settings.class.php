<?php
class Settings {
	
	const TEST = 'test';
	const DEVE = 'develop';
	const PROD = 'production';

	static $mode;
	
	private static $db_test = array(
		'drv'	=> DataBaseAccessFactory::FAKE,
		'type'	=> 'mysql',
		'host'	=> 'localhost',
		'db'	=> 'mvc',
		'user'	=> 'root',
		'pass'	=> ''
	);
	
	private static $db_deve = array(
		'drv'	=> DataBaseAccessFactory::PDO,
		'type'	=> 'mysql',
		'host'	=> 'localhost',
		'db'	=> 'mvc',
		'user'	=> 'root',
		'pass'	=> ''
	);
	
	private static $db_prod = array(
		'drv'	=> DataBaseAccessFactory::PDO,
		'type'	=> 'mysql',
		'host'	=> 'localhost',
		'db'	=> 'mvc',
		'user'	=> 'root',
		'pass'	=> ''
	);

	static $view = array(
		'dir' => 'view',
		'ext' => '.html',
		'layout' => 'layout'
	);

	static function dbSett() {
		switch (self::$mode) {
			case self::TEST: return self::$db_test;
			case self::DEVE: return self::$db_deve;
			case self::PROD: return self::$db_prod;
		}
	}
		
}