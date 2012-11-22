<?php

error_reporting(E_ALL);
define('DEBUG', TRUE);
setIncludePath('controller', 'domain', 'view');
spl_autoload_register('autoloader');

$fc = new FrontController;
$fc->go();

function autoloader($class) {
	require_once $class . '.class.php';
}

function setIncludePath() {
	$include_path = get_include_path().PATH_SEPARATOR;
	foreach(func_get_args() as $path) {
		$include_path .= $path.PATH_SEPARATOR;
	}
	set_include_path($include_path);
}