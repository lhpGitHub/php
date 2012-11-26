<?php
class HttpRequest extends Request {

	function __construct() {
		parent::__construct();
	}

	protected function ini() {
		
		$absolutePath = $this->getRelativePath();
		$uriRequest = substr($_SERVER['REQUEST_URI'], strlen($absolutePath));
		$ele = explode('/', strtolower(trim($uriRequest, "/")));		
		$controlerName = array_shift($ele);
		$actionName = array_shift($ele);
		$this->params = $ele;
		$this->controlerName = (empty($controlerName)) ? 'PersonController' : $controlerName.'Controller';
		$this->actionName = (empty($actionName)) ? 'do_read' : 'do_'.$actionName;
	}

	function setSuccess($sucessCode) {
		$sucessCodes = array (
			1 => 'success add record',
			2 => 'success delete record',
			3 => 'success update record',
			4 => 'success read record',
			5 => 'no record found'
		);
		
		$successMsg = $sucessCodes[$sucessCode];
		
		SessionRegistry::setFlashVars('msg', $successMsg);
	}
	
	function setError($errCode, $exception = null) {
		$errCodes = array (
			1 => 'wrong parameters',
			2 => 'database error'
		);
		
		$errMsg = $errCodes[$errCode];
		
		if(DEBUG)
			$errMsg .= ' ' . $exception;
		
		SessionRegistry::setFlashVars('msg', $errMsg);
	}

}