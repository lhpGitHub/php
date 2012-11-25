<?php
class FrontController {

	function go() {

		$request = new HttpRequest;
		RequestRegistry::setRequest($request);
		
		try {
			$c = new ReflectionClass($request->getControlerName());
			$m = new ReflectionMethod($request->getControlerName(), $request->getActionName());
		} catch(ReflectionException $err) {
			$header = 'HTTP/1.1 404 Not Found';
			header($header);
			echo $header;
			exit();
		}

		$m->invoke($c->newInstance());
		$request->send();
	}

}