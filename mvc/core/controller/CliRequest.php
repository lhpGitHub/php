<?php namespace core\controller;

class CliRequest extends BaseRequest {

	function __construct() {
		parent::__construct();
	}

	protected function ini() {
		array_shift($_SERVER['argv']);
		$this->restoreSession($_SERVER['argv']);
		$this->controlerName = array_shift($_SERVER['argv']);
		$this->actionName = array_shift($_SERVER['argv']);
		$this->params = $_SERVER['argv'];
	}
	
	function gender() {
		return parent::CLI;
	}
	
	private function restoreSession(&$argv) {
		if(current($argv) == '--sid') {
			array_shift($argv);
			$sid = array_shift($argv);
		}
		
		if(isset($sid))
			session_id ($sid);
	}


	function error() {
		$msg = 'Not Found';
		echo $msg;
		exit();
	}
	
	function getAbsolutePath() {
		return $_SERVER['SCRIPT_NAME'];
	}
	
	function getRelativePath() {
		return $_SERVER['SCRIPT_NAME'];
	}
	
	function redirect($uri) {
		echo 'Redirect Failed';
		die();
	}
	
	function setResponse($body) {
		printf('app [sid:%s] response: %s', session_id(), $body);
	}
}