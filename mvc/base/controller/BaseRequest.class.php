<?php
abstract class BaseRequest {

	protected $controlerName, 
			  $actionName, 
			  $params;
	
	/*private $data = array();*/

	function __construct() {
		$this->ini();
	}
	
	abstract protected function ini();
	
	/*function setData($key, $val) {
		$this->data[$key] = $val;
	}
	
	function getData($key) {
		if(isset($this->data[$key]))
			return $this->data[$key];
		
		return NULL;
	}*/
	
	function getAbsolutePath() {
		$pathinfo = pathinfo($_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']);
		return 'http://'.$pathinfo['dirname'];
	}
	
	function getRelativePath() {
		$pathinfo = pathinfo($_SERVER['SCRIPT_NAME']);
		return $pathinfo['dirname'];
	}
	
	function getControlerName() {
		return $this->controlerName;
	}

	function getActionName() {
		return $this->actionName;
	}

	function getParam($offset) {
		if(isset($this->params[$offset])) {
			return $this->params[$offset];
		}
		return null;
	}
	
	function setParam($offset, $value) {
		$this->params[$offset] = $value;
	}
}
