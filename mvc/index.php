<?php
error_reporting(E_ALL); 
define('DEBUG', TRUE);
setIncludePath('core', 'core/registry', 'core/controller', 'core/view', 'core/exception', 'core/model/dba', 'core/model/orm', 'app/config', 'app/controllers', 'app/views', 'app/models');
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