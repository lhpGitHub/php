<?php
class PersonController {
	
	function do_create(Request $request) {
		$fName = $request->getParam(0);
		$lName = $request->getParam(1);

		if($this->do_create_ValidateParams(&$fName, &$lName)) {
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
	
	private function do_create_ValidateParams(&$fName, &$lName) {
		if(!$this->validateString(&$fName))
			return false;
		
		if(!$this->validateString(&$lName))
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
				$request->setSuccess(Request::RECORD_READ);
				foreach($personIterator as $person) {
					$request->setData(array(
						'aUpdate'=>$request->getAbsolutePath().'/person/update/'.$person['id'].'/',
						'aDelete'=>$request->getAbsolutePath().'/person/delete/'.$person['id'].'/',
						'id'=>$person['id'],
						'fName'=>$person['fName'],
						'lName'=>$person['lName']
					),'personListItem');
				}
			} else {
				$request->setSuccess(Request::RECORD_EMPTY);
			}

			$request->setData(array('aCreate'=>$request->getAbsolutePath().'/person/create/'),'personList');

		} catch(DomainException $err) {
			$request->setError(Request::DB_ERROR, $err);
		} 
	}
	
	function do_update(Request $request) {
		$id = $request->getParam(0);
		$fName = $request->getParam(1);
		$lName = $request->getParam(2);
		$fSend = $this->validateInteger($request->getParam(3));
		
		try
		{
			$dao = PersonDAO::getInstance();
			$personTO = new PersonTO($id);
			$personIterator = $dao->getPersonById($personTO)->getIterator();
			$person = $personIterator->current();	
			
			if($this->validateInteger(&$id) && !is_null($person)) {
				
				if($this->validateString(&$fName) && $this->validateString(&$lName)) {
					$person = new PersonTO($id, $fName, $lName);
					$dao->updatePerson($person);
					$request->setSuccess(Request::RECORD_UPD);
					$request->setParam(0, null);
					$this->do_read($request);
				} else {
					$request->setError(Request::WRONG_PARAM);
					if(!$fSend) extract($person);
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
	
	function do_delete(Request $request) {
		$id = $request->getParam(0);
		
		try
		{
			if($this->validateInteger(&$id)) {
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