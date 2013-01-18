<?php namespace core\view;

use app\config\Settings as Settings;

class View {
	
	private $templateData;
	private $viewsData;

	function __construct() {
		$dynamicVar = array();
		$data = array();
	}
	
	function __set($name, $value) {
		$this->templateData[$name] = $value;
	}
	
	function __get($name) {
		if(isset($this->templateData[$name])) 
			return $this->templateData[$name];
		
		return NULL;
	}
	
	function getViewAsVar($viewName) {
		if(isset($this->viewsData[$viewName]))
			extract($this->viewsData[$viewName]);
		
		ob_start();
		include(Settings::$mainPath . Settings::$view['dir'] . $viewName . Settings::$view['ext']);
		return ob_get_clean();
	}
	
	function setViewVar($viewName, $key, $value) {
		if(!isset($this->viewsData[$viewName]))
			$this->viewsData[$viewName] = array();
		
		$this->viewsData[$viewName][$key] = $value;
	}
	
	function render() {
		if(is_array($this->templateData))
			extract($this->templateData);
		
		ob_start();
		include(Settings::$mainPath . Settings::$view['dir'] . Settings::$view['layout'] . Settings::$view['ext']);
		return ob_get_clean();
	}
}