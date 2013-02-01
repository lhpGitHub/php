<?php

/***CONFIG***/
define('MAIN_PATH', './');

$settings = array(
	'debug'		=> TRUE,
	'defaultController' => 'Person',
	'defaultAction' => 'read',
	'authEnable' => TRUE,
	'authUserClass' => 'app\models\UserObject',
	'authAccessLevelsClass' => 'app\auth\AppAccessLevels',
	'dbExt' => 'mysqli', //[pdo, mysqli]
	'dbAccess' => array('type' => 'mysql', 'host' => 'localhost', 'db' => 'mvc', 'user' => 'root', 'pass' => ''),
	'viewDir' => 'app/views/',
	'viewExt' => '.html',
	'viewLayout' => 'layout' 
);
/***CONFIG END***/

error_reporting(E_ALL);
require_once MAIN_PATH.'core/Autoloader.php';
Autoloader::ini(MAIN_PATH);
\core\Config::set('mainPath', MAIN_PATH);
\core\Config::setSeveral($settings);
$fc = \core\FrontController::getInstance();
$fc->go();