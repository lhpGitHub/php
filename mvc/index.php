<?php
error_reporting(E_ALL); 
define('DEBUG', TRUE);
setIncludePath('base', 'base/registry', 'base/controller', 'base/view', 'base/exception', 'base/model/dba', 'base/model/domainObject', 'config', 'controller', 'view', 'model');
spl_autoload_register('autoloader');

Settings::$mode = Settings::DEVE;

$fc = FrontController::getInstance();
$fc->go();

function autoloader($class) {
	@include_once $class . '.class.php';
}

function setIncludePath() {
	$include_path = get_include_path().PATH_SEPARATOR;
	foreach(func_get_args() as $path) {
		$include_path .= $path.PATH_SEPARATOR;
	}
	set_include_path($include_path);
}