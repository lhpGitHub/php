<?php
class PersonController {
	
	function do_create(Request $request) {
		$fName = $request->getParam(0);
		$lName = $request->getParam(1);

		$fName = 'aaaa';
		$lName = 'bbbbb';

		//var_dump($this->validateString(&$fName));
		//var_dump($this->validateString(&$lName));
		var_dump($this->do_create_ValidateParams(&$fName, &$lName));
		//var_dump($fName, $lName);

		return;
		
		if($this->do_create_ValidateParams(&$fName, &$lName)) {
			$personTO = new PersonTO(null, $fName, $lName);
			try {
				$dao = PersonDAO::getInstance();
				$dao->addPerson($personTO);
				$request->setSuccess(1);
				//$this->do_read(array());
			} catch(DomainException $err) {
				$request->setError(2, $err);
			} 
		} else {
			$request->setError(1);
		}
	}
	
	private function do_create_ValidateParams(&$fName, &$lName) {

		var_dump($fName, $this->validateString(&$fName));
		var_dump($lName, $this->validateString(&$lfName));


		if(!$this->validateString(&$fName))
			return false;
		
		if(!$this->validateString(&$lfName))
			return false;
		
		return true;
	}
	
	function do_read(Request $request) {
		try {
			$dao = PersonDAO::getInstance();
			$id = $request->getParam(0);
			if($this->validateInteger(&$id)) {
				$personTO = new PersonTO($id);
				$personIterator = $dao->getPersonById($personTO)->getIterator();
			} else {
				$personIterator = $dao->getAllPersons()->getIterator();
			}
			
			if($personIterator->count() > 0) {
				$request->setSuccess(4);
				foreach($personIterator as $person) {
					$request->setData(array('id'=>$person['id'], 'fName'=>$person['fName'], 'lName'=>$person['lName']), 'personListItem');
				}
			} else {
				$request->setSuccess(5);
			}
		} catch(DomainException $err) {
			$request->setError(2, $err);
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