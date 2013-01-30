<?php namespace core\controller;

abstract class BaseRequest {

	const HTML = 'html';
	const CLI = 'cli';
	const JSON = 'json';

	protected $controlerName, 
			  $actionName, 
			  $params;
	
	function __construct() {
		$this->ini();
	}
	
	protected abstract function ini();
	public abstract function gender();
	public abstract function getAbsolutePath();
	public abstract function getRelativePath();
	public abstract function redirect($uri);
	public abstract function setResponse($body);
	public abstract function error();
	
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
