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
			$m->invoke($c->newInstanceArgs(), $this->params);
		} catch(Exception $err) {
			$this->error($err);
			return;
		}
	}
	
	private function parse() {
		$ele = explode('/', substr($_SERVER["PATH_INFO"], 1));
		$controlerName = array_shift($ele);
		$actionName = array_shift($ele);
		$this->params = $ele;
		$this->controlerName = (empty($controlerName)) ? 'PersonController' : $controlerName.'Controller';  
		$this->actionName = (empty($actionName)) ? 'do_read' : 'do_'.$actionName;  
	}
	
	function error($err) {
		
		if(DEBUG) {
			//echo ($err instanceof ReflectionException);
			echo $err->getMessage();
		} else {
			
			if($err instanceof ReflectionException)
				$header = 'HTTP/1.1 404 Not Found';
			else if($err instanceof DomainException)
				$header = 'HTTP/1.1 500 Internal Server Error';
			
			header($header);
			echo $header;
			exit();
		}
	}
}

?>
