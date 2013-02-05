<?php namespace core\controller;

class JsonRequest extends BaseRequest {

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
		
		$this->controlerName = array_shift($ele);
		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->params = $ele;
			$this->actionName = 'read';
		} else {
			$this->params = $this->decodeParam();
			$this->handleAction($_SERVER['REQUEST_METHOD']);
		}
	}
	
	private function handleAction($requestMethod) {
		switch ($requestMethod) {
			case 'PUT':
				$this->actionName = 'create';
				break;
			
			case 'POST':
				$this->actionName = 'update';
				break;
			
			case 'DELETE':
				$this->actionName = 'delete';
				break;

			default:
				$this->errorMethodNotAllowed();
		}
	}
	
	private function decodeParam() {
		return json_decode(file_get_contents('php://input'), TRUE);
	}

	function gender() {
		return parent::JSON;
	}
	
	function redirect($uri) {
		echo 'Redirect Failed';
		die();
	}
	
	function setResponse($body) {
		printf('app [sid:%s] response: %s', session_id(), $body);
	}
}