<?php
class Settings {
	
	const DEVE = 'develop';
	const PROD = 'production';

	static $mode;
	
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
	
	static $dataBaseAccessType = DataBaseAccessFactory::PDO;

	static $view = array(
		'dir' => 'view',
		'ext' => '.html',
		'layout' => 'layout'
	);

	static function dbSett() {
		switch (self::$mode) {
			case self::DEVE: return self::$db_deve;
			case self::PROD: return self::$db_prod;
		}
	}
		
}