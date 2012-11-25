<?php
abstract class Request {

	const RECORD_ADD	= 1;
	const RECORD_DEL	= 2;
	const RECORD_UPD	= 3;
	const RECORD_READ	= 4;
	const RECORD_EMPTY	= 5;

	const WRONG_PARAM	= 1;
	const DB_ERROR		= 2;
	
	protected $controlerName;
	protected $actionName;
	protected $params;

	function __construct() {
		$this->ini();
	}
	
	abstract protected function ini();
	abstract function setData($data, $viewName = null);
	abstract function setSuccess($sucessCode);
	abstract function setError($errCode, $exception = null);
	abstract function send();

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
