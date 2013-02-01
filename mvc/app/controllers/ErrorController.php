<?php namespace app\controllers;

class ErrorController extends \core\controllers\ErrorController {
	
	function __construct() {
		parent::__construct();
	}
	
	function action401() {
		echo 'nie masz odpowiednich praw dostepu do tego zasobu';
	}

	function action404() {
		$header = 'HTTP/1.1 404 Not Found';
		header($header);
		echo 'zasob niedostepny (app controller)';
	}
}