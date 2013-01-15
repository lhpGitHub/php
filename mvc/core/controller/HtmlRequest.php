<?php namespace core\controller;

class HtmlRequest extends BaseRequest {

	function __construct() {
		parent::__construct();
	}

	protected function ini() {
		
		if(count($_GET) > 0) {
			$ele = array_values($_GET);
		} else {
			$relativePath = $this->getRelativePath();
			$uriRequest = substr($_SERVER['REQUEST_URI'], strlen($relativePath));
			$ele = explode('/', strtolower(trim($uriRequest, "/")));
		}
		
		if(count($_POST) > 0) $ele = array_merge($ele, array_values($_POST));
		
		$controlerName = array_shift($ele);
		$actionName = array_shift($ele);
		$this->params = $ele;
		$this->controlerName = (empty($controlerName)) ? \app\config\Settings::$defaultController : $controlerName;
		$this->actionName = (empty($actionName)) ? \app\config\Settings::$defaultAction : $actionName;
	}
	
	function error() {
		$header = 'HTTP/1.1 404 Not Found';
		header($header);
		echo $header;
		exit();
	}
	
}