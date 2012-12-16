<?php
class Settings {
	
	const DEVE = 'develop';
	const PROD = 'production';

	static $mode;
	
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
		return ((self::$mode === self::DEVE) ? self::$db_deve : self::$db_prod);
	}
		
}