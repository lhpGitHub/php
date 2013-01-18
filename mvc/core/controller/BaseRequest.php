<?php namespace core\controller;

abstract class BaseRequest {

	protected $controlerName, 
			  $actionName, 
			  $params;
	
	function __construct() {
		$this->ini();
	}
	
	abstract protected function ini();
	abstract public function getAbsolutePath();
	abstract public function getRelativePath();
	abstract public function redirect($uri);
	abstract public function setResponse($body);
	abstract function error();
	
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
