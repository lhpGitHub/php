<?php
class PersonController {
	
	private $response;
	
	function __construct($response) {
		$this->response = $response;
	}
	
	function do_create(array $params) {
		if($this->do_create_ValidateParams(&$params)) {
			$personTO = new PersonTO(null, $params[0], $params[1]);
			try {
				$dao = PersonDAO::getInstance();
				$dao->addPerson($personTO);
				$this->response->setSuccess(1);
				$this->do_read(array());
			} catch(DomainException $err) {
				$this->response->setError(2, $err);
			} 
		} else {
			$this->response->setError(1);
		}
	}
	
	private function do_create_ValidateParams(&$params) {
		$err = false;
		
		if(!$this->validateString($params[0]))
			$err = true;
		
		if(!$this->validateString($params[1]))
			$err = true;
		
		return !$err;
	}
	
	function do_read(array $params) {
		try {
			$dao = PersonDAO::getInstance();
			
			if($this->validateInteger($params[0])) {
				$personTO = new PersonTO($params[0], null, null);
				$personIterator = $dao->getPersonById($personTO)->getIterator();
			} else {
				$personIterator = $dao->getAllPersons()->getIterator();
			}
			
			if($personIterator->count() > 0) {
				$this->response->setSuccess(4);
				foreach($personIterator as $person) {
					$this->response->setData(array('id'=>$person['id'], 'fName'=>$person['fName'], 'lName'=>$person['lName']), 'personListItem');
				}
			} else {
				$this->response->setSuccess(5);
			}
		} catch(DomainException $err) {
			$this->response->setError(2, $err);
		} 
	}
	
	function do_update(array $params) {
		echo __METHOD__;
		print_r($params);
	}
	
	function do_delete(array $params) {
		echo __METHOD__;
		print_r($params);
	}
	
	private function validateString(&$var) {
		if(isset($var) && !empty($var)) {
			settype($var, 'string');
			return true;
		}
		else {
			return false;
		}
	}
	
	private function validateInteger(&$var) {
		if(isset($var)) {
			settype($var, 'integer');
			return true;
		}
		else {
			return false;
		}
	}
		
}