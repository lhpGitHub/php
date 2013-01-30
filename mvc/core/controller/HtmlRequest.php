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
		
		$this->controlerName = array_shift($ele);
		$this->actionName = array_shift($ele);
		$this->params = $ele;
	}
	
	function gender() {
		return parent::HTML;
	}

	function error() {
		$header = 'HTTP/1.1 404 Not Found';
		header($header);
		echo $header;
		exit();
	}
	
	function getAbsolutePath() {
		$pathinfo = pathinfo($_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']);
		return 'http://'.$pathinfo['dirname'];
	}
	
	function getRelativePath() {
		$pathinfo = pathinfo($_SERVER['SCRIPT_NAME']);
		return $pathinfo['dirname'];
	}
	
	function redirect($uri) {
		header('Location: ' . $this->getAbsolutePath() . $uri);
		die;
	}
	
	function setResponse($body) {
		echo $body;
	}
}