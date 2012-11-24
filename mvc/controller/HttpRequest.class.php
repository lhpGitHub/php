<?php
class HttpRequest extends Request {

	private $controlerName;
	private $actionName;
	private $params;

	private $views = array();
	
	function __construct() {
		$this->ini();
	}

	private function ini() {
		$ele = explode('/', trim($_SERVER["PATH_INFO"], "/"));
		$controlerName = array_shift($ele);
		$actionName = array_shift($ele);
		$this->params = $ele;
		$this->controlerName = (empty($controlerName)) ? 'PersonController' : $controlerName.'Controller';
		$this->actionName = (empty($actionName)) ? 'do_read' : 'do_'.$actionName;
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

	function setData($data, $viewName = null) {
		extract($data);
		ob_start();
		include('viewHtml/' . $viewName . '.html');
		$this->views[] = ob_get_clean();
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

		ob_start();
		include('viewHtml/success.html');
		$this->views[] = ob_get_clean();
	}
	
	function setError($errCode, $exception = null) {
		$errCodes = array (
			1 => 'wrong parameters',
			2 => 'database error'
		);
		
		$errMsg = $errCodes[$errCode];
		
		if(!DEBUG)
			$exception = null;
			
		ob_start();
		include('viewHtml/error.html');
		$this->views[] = ob_get_clean();
	}

	function send() {
		$views = join('', $this->views);
		include('viewHtml/layout.html');
	}
}