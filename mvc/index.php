<?php

error_reporting(E_ALL);
define('DEBUG', FALSE);

function ctrl_autoloader($class) {
	@include 'controller/' . $class . '.class.php';
}
spl_autoload_register('ctrl_autoloader');

function domain_autoloader($class) {
	@include 'domain/' . $class . '.class.php';
}
spl_autoload_register('domain_autoloader');

$fc = new FrontController;
$fc->go();
?>
