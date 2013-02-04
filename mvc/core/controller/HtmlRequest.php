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

	function redirect($uri) {
		header('Location: ' . $this->getAbsolutePath() . $uri);
		die;
	}
	
	function setResponse($body) {
		echo $body;
	}
	
	function errorNotFound() {
		\core\registry\RequestRegistry::getAppController()->dispatchError('404');
		exit();
	}
	
	function errorUnauthorized() {
		\core\registry\RequestRegistry::getAppController()->dispatchError('401');
		exit();
	}
}