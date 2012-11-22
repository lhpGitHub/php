<?php
class ViewManager {

	private $views = array();

	function bindView($viewName, $viewData) {
		extract($viewData);
		ob_start();
		include('viewHtml/' . $viewName . '.html');
		$this->views[] = ob_get_clean();
	}

	function render() {
		$this->views = join('', $views);
		include('viewHtml/layout.html');
	}
}