<?php

error_reporting(E_ALL);
ini_set("display_errors", 1); 
define('DEBUG', TRUE);
setIncludePath('base', 'controller', 'domain', 'view');
spl_autoload_register('autoloader');

$fc = new FrontController;
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