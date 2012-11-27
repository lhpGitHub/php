<?php
class HtmlRequest extends BaseRequest {

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
		$this->controlerName = (empty($controlerName)) ? 'person' : $controlerName;
		$this->actionName = (empty($actionName)) ? 'read' : $actionName;
	}
	
	function sendView($viewName) {
		$request = $this;
		ob_start();
		include('view/' . $viewName . '.php');
		$content = ob_get_clean();
		include('view/layout.html');
	}

}