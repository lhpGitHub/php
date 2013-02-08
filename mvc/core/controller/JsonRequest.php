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
		
		$this->controllerName = array_shift($ele);
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
				header('Allow: PUT, GET, POST, DELETE');
				$this->errorMethodNotAllowed();
		}
	}
	
	private function decodeParam() {
		$param = json_decode(file_get_contents('php://input'), TRUE);
		
		if(!$param)
			$this->errorBadRequest();
		
		return $param;
	}

	function gender() {
		return parent::JSON;
	}
	
	function getContentType() {
		return 'application/json';
	}
	
	function redirect($uri) {
		throw new \Exception(sprintf("Redirect method not allowed in class [%s]", __CLASS__));
	}
	
	function sendResponse($body) {
		header('Content-type: application/json');
		echo $body;
	}
}