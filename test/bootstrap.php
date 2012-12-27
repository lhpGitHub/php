<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @author Xeon
 */
// TODO: check include path
ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.dirname(__FILE__).'/../rozne');
ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.dirname(__FILE__).'/../mvc/config');
ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.dirname(__FILE__).'/../mvc/base/exception');
ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.dirname(__FILE__).'/../mvc/base/model/dba');

// put your code here

require 'Pogoda.php';
require 'Settings.class.php';
require 'DataBaseException.class.php';
require 'DataBaseAccessFactory.class.php';
require 'DataBaseAccess.class.php';
require 'DataBaseAccessPDO.class.php';
require 'DataBaseAccessFAKE.class.php';

?>
