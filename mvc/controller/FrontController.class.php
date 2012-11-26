<?php
class FrontController {

	function go() {

		session_start();
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

		$viewName = $m->invoke($c->newInstance());
		$this->sendView($request, $viewName);
		
		SessionRegistry::clearFlashVars();
	}
	
	private function sendView($request, $viewName) {
		ob_start();
		include('viewHtml/' . $viewName . '.html');
		$content = ob_get_clean();
		include('viewHtml/layout.html');
	}

}