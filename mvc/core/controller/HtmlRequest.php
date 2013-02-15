<?php namespace core\controller;

class HtmlRequest extends BaseRequest {
	
	function __construct() {
		parent::__construct();
	}

	protected function ini() {
		
		if(count($_GET) > 0) {
			$ele = array_values($_GET);
		} else {
			$params = $this->uriExtractParams();
		}
		
		if(count($_POST) > 0) $params = array_merge($params, $_POST);
		
		$this->controllerName = array_shift($params);
		$this->actionName = array_shift($params);
		$this->params = $params;
	}
	
	function gender() {
		return parent::HTML;
	}
	
	function getContentType() {
		return 'text/html';
	}

	function redirect($uri) {
		header('Location: ' . $this->getAbsolutePath() . $uri);
		die;
	}
	
	function errorNotFound($warning = null) {
		\core\registry\RequestRegistry::getAppController()->dispatchError('404');
		exit();
	}
	
	function errorUnauthorized($warning = null) {
		\core\registry\RequestRegistry::getAppController()->dispatchError('401');
		exit();
	}
}