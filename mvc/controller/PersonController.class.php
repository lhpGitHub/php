<?php
class PersonController {
	
	function do_create() {
		$request = RequestRegistry::getRequest();
		$fName = $this->validateString($request->getParam(0));
		$lName = $this->validateString($request->getParam(1));

		if($this->isNotNull($fName, $lName)) {
			$personTO = new PersonTO(null, $fName, $lName);
			try {
				$dao = PersonDAO::getInstance();
				$dao->addPerson($personTO);
				$request->setSuccess(Request::RECORD_ADD);
				$request->setParam(0, null);
				$this->do_read($request);
			} catch(DomainException $err) {
				$request->setError(Request::DB_ERROR, $err);
			} 
		} else {
			$request->setError(Request::WRONG_PARAM);
			$request->setData(array(
				'action'=>$request->getAbsolutePath().'/person/create/',
				'fName'=>$fName,
				'lName'=>$lName,
				'aRead'=>$request->getAbsolutePath().'/person/read/'
			), 'personForm');
		}
	}
	
	function do_read() {

		$request = RequestRegistry::getRequest();
		
		try {
			$dao = PersonDAO::getInstance();
			$id = $this->validateInteger($request->getParam(0));
			
			if($this->isNotNull($id)) {
				$personTO = new PersonTO($id);
				$personIterator = $dao->getPersonById($personTO)->getIterator();
			} else {
				$personIterator = $dao->getAllPersons()->getIterator();
			}
			
			if($personIterator->count() > 0) {
				$request->setSuccess(Request::RECORD_READ);
				$persons = array();
				
				foreach($personIterator as $person)
					$persons[] = array('id'=>$person['id'], 'fName'=>$person['fName'], 'lName'=>$person['lName']);
				
				$request->setData('persons', $persons);
				
			} else {
				$request->setSuccess(Request::RECORD_EMPTY);
			}

		} catch(DomainException $err) {
			$request->setError(Request::DB_ERROR, $err);
		}
		
		return 'personList';
	}
	
	function do_update() {
		$request = RequestRegistry::getRequest();
		$id = $this->validateInteger($request->getParam(0));
		$fName = $this->validateString($request->getParam(1));
		$lName = $this->validateString($request->getParam(2));
		$fSend = $this->validateInteger($request->getParam(3));
		
		try
		{
			$dao = PersonDAO::getInstance();
			$personTO = new PersonTO($id);
			$personIterator = $dao->getPersonById($personTO)->getIterator();
			$person = $personIterator->current();	
			
			if($this->isNotNull($id, $person)) {
				
				if($this->isNotNull($fName, $lName)) {
					$person = new PersonTO($id, $fName, $lName);
					$dao->updatePerson($person);
					$request->setSuccess(Request::RECORD_UPD);
					$request->setParam(0, null);
					$this->do_read($request);
				} else {
					$request->setError(Request::WRONG_PARAM);
					if(!$this->isNotNull($fSend)) extract($person);
					$request->setData(array(
						'action'=>$request->getAbsolutePath().'/person/update/'.$id.'/',
						'fName'=>$fName,
						'lName'=>$lName,
						'aRead'=>$request->getAbsolutePath().'/person/read/'
					), 'personForm');
				}
				
			} else {
				$request->setError(Request::WRONG_PARAM);
			}
			
		} catch (DomainException $err) {
			$request->setError(Request::DB_ERROR);
		}
		
	}
	
	function do_delete() {
		$request = RequestRegistry::getRequest();
		$id = $this->validateInteger($request->getParam(0));
		
		try
		{
			if($this->isNotNull($id)) {
				$dao = PersonDAO::getInstance();
				$personTO = new PersonTO($id);
				
				if($dao->removePerson($personTO) == 1) {
					$request->setSuccess(Request::RECORD_DEL);
					$request->setParam(0, null);
					$this->do_read($request);
				} else {
					$request->setError(Request::WRONG_PARAM);
				}
				
			} else {
				$request->setError(Request::WRONG_PARAM);
			}
			
		} catch (DomainException $err) {
			$request->setError(Request::DB_ERROR);
		}
	}
	
	private function validateString($var) {
		if(isset($var) && !empty($var)) {
			settype($var, 'string');
			return $var;
		}
		else {
			return NULL;
		}
	}
	
	private function validateInteger($var) {
		if(isset($var)) {
			settype($var, 'integer');
			return $var;
		}
		else {
			return NULL;
		}
	}
	
	private function isNotNull() {
		$args = func_get_args();
		
		foreach ($args as $var)
			if(is_null($var))
				return false;
		
		return true;
	}
		
}