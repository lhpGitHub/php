<?php namespace core\controller;

abstract class BaseRequest {

	const HTML = 'html';
	const CLI = 'cli';
	const JSON = 'json';

	protected $controlerName, 
			  $actionName, 
			  $params;
	
	function __construct() {
		$this->ini();
	}
	
	protected abstract function ini();
	public abstract function gender();
	public abstract function redirect($uri);
	public abstract function setResponse($body);
	
	function getControlerName() {
		return $this->controlerName;
	}

	function getActionName() {
		return $this->actionName;
	}

	/**
	 * zwraca wartość parametru żądania, którego wartość jest ustalana na podstawie klucza
	 * 
	 * klucz może być ciągiem znaków lub indeksem numerycznym
	 * 
	 * przykład użycia:
	 * 
	 * <code>
	 * BaseRequest::getParam('nazwaKlucza');
	 * BaseRequest::getParam(0);
	 * </code> 
	 * 
	 * @param   mixed $key klucz
	 * @return  mixed zwraca wartość parametru jeśli klucz istnieje, NULL w przeciwnym przypadku
    */
	function getParam($key) {
		if(isset($this->params[$key])) {
			return $this->params[$key];
		} else {
			$params = array_values($this->params);
			if(isset($params[$key])) {
				return $params[$key];
			}
		}
		return null;
	}
	
	function setParam($offset, $value) {
		$this->params[$offset] = $value;
	}
	
	function getAbsolutePath() {
		$pathinfo = pathinfo($_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']);
		return 'http://'.$pathinfo['dirname'];
	}
	
	function getRelativePath() {
		$pathinfo = pathinfo($_SERVER['SCRIPT_NAME']);
		return $pathinfo['dirname'];
	}
	
	function errorNotFound() {
		header('HTTP/1.1 404 Not Found');
		exit();
	}
	
	function errorUnauthorized() {
		header('HTTP/1.1 401 Unauthorized');
		exit();
	}
	
	function errorMethodNotAllowed() {
		header('HTTP/1.1 405 Method Not Allowed');
		exit();
	}
	
	function errorBadRequest() {
		header('HTTP/1.1 400 Bad Request');
		exit();
	}
}
