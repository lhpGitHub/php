<?php namespace core\controller;

interface IDispatcher {

	public function dispatch($controllerName, $actionName);
	
}