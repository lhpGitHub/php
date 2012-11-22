<?php

class BaseController {
	
	protected function getView($viewName, $viewData) {
		extract($viewData);
		ob_start();
		include('view/' . $viewName . '.html');
		return ob_get_clean();
	}
	
	protected function render($views) {
		$views = join('', $views);
		include('view/layout.html');
	}
	
}

?>
