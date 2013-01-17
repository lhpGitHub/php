<?php

/*--------config--------*/
define('MAIN_PATH', './');
define('ASSETS_PATH', './');
define('APP_ENV', 'devlop'); //[develop, production]
define('DB_EXT', 'pdo'); //[pdo, mysqli]
define('DEBUG', TRUE);
define('DEFAULT_CONTROLLER', 'Person');
define('DEFAULT_ACTION', 'read');
define('AUTH_ENABLE', TRUE);
/*----------------------*/

error_reporting(E_ALL);
require_once MAIN_PATH.'core/Autoloader.php';
Autoloader::ini(MAIN_PATH);
use app\config\Settings as Settings;
Settings::$mainPath = MAIN_PATH;
Settings::$assetsPath = ASSETS_PATH;
Settings::$debug = DEBUG;
Settings::$env = APP_ENV;
Settings::$dataBaseExt = DB_EXT;
Settings::$defaultController = DEFAULT_CONTROLLER;
Settings::$defaultAction = DEFAULT_ACTION;
Settings::$authEnable = AUTH_ENABLE;
$fc = \core\FrontController::getInstance();
$fc->go();