<?php
class FrontController {
	
	private $controlerName;
	private $actionName;
	private $params;
	
	function go() {

		$this->parse();
		
		try {
			$c = new ReflectionClass($this->controlerName);
			$m = new ReflectionMethod($this->controlerName, $this->actionName);
		} catch(ReflectionException $err) {
			header($header);
			echo $header;
			exit();
		}
		
		$response = $this->getResponseObject();
		$m->invoke($c->newInstance($response), $this->params);
		$response->send();
	}
	
	private function parse() {
		$ele = explode('/', trim($_SERVER["PATH_INFO"], "/"));
		$controlerName = array_shift($ele);
		$actionName = array_shift($ele);
		$this->params = $ele;
		$this->controlerName = (empty($controlerName)) ? 'PersonController' : $controlerName.'Controller';  
		$this->actionName = (empty($actionName)) ? 'do_read' : 'do_'.$actionName;  
	}
	
	private function getResponseObject() {
		return new HttpResponse;
	}
}