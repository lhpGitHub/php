<?php
class InvalidIdException extends Exception {
	
	function __construct($message = null, $code = 0) {
		parent::__construct($message, $code);
	}
}