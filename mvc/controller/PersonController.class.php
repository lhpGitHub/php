<?php
class PersonController extends BaseController {
	
	const RECORD_ADD	= 'success add record';
	const RECORD_DEL	= 'success delete record';
	const RECORD_UPD	= 'success update record';
	const RECORD_READ	= 'success read record';
	const RECORD_EMPTY	= 'no record found';

	const WRONG_PARAM	= 'wrong parameters';
	const DB_ERROR		= 'database error';
	
	function actionCreate() {
		try {
			$request = RequestRegistry::getRequest();
			$this->create($request);
			$this->setFlashBlockOverride('msg', self::RECORD_ADD);
			$this->redirect('/person/read');
			
		} catch(DomainException $err) {
			$this->setFlashBlockOverride('msg', self::DB_ERROR);
			
		} catch(InvalidArgumentException $err) {
			$this->setFlashBlockOverride('msg', self::WRONG_PARAM);
		}  
	
		return 'personForm';
	}
	
	function jsonActionCreate() {
		return self::VIEW_NONE;
	}
	
	private function create($request) {
		$fName = self::validateString($request->getParam(0));
		$lName = self::validateString($request->getParam(1));
		
		if(self::isNotNull($fName, $lName)) {
			$dao = PersonDAO::getInstance();
			$dao->addPerson(new PersonTO(null, $fName, $lName));
		} else {
			$request->setData('person', array('fName'=>$fName, 'lName'=>$lName));
			throw new InvalidArgumentException;
		}
	}


	function actionRead() {
		try {
			$request = RequestRegistry::getRequest();
			$this->read($request);
			$this->setFlashBlockOverride('msg', self::RECORD_READ);
			
		} catch(DomainException $err) {
			$this->setFlashBlockOverride('msg', self::DB_ERROR);
			
		} catch(LengthException $err) {
			$this->setFlashBlockOverride('msg', self::RECORD_EMPTY);
		}  
		
		return 'personList';
	}
	
	function jsonActionRead() {
		return self::VIEW_NONE;
	}
	
	private function read($request) {
		$dao = PersonDAO::getInstance();
		$id = $this->validateInteger($request->getParam(0));
		
		if(self::isNotNull($id)) {
			$personIterator = $dao->getPersonById(new PersonTO($id))->getIterator();
		} else {
			$personIterator = $dao->getAllPersons()->getIterator();
		}
		
		if($personIterator->count() > 0) {
			$persons = array();

			foreach($personIterator as $person)
				$persons[] = array('id'=>$person['id'], 'fName'=>$person['fName'], 'lName'=>$person['lName']);

			$request->setData('persons', $persons);

		} else {
			throw new LengthException;
		}
	}


	function actionUpdate() {
		$request = RequestRegistry::getRequest();
		$id = $this->validateInteger($request->getParam(0));
		$fSend = $this->validateInteger($request->getParam(3));
		
		try { //check id
			if(self::isNull($id)) throw new LengthException;
			$this->read($request);
		} catch(LengthException $err) {
			$this->setFlashBlockOverride('msg', self::WRONG_PARAM);
			$this->redirect('/person/read');
		}
		
		try {
			if(self::isNull($fSend)) {
				$request->setData('person', array_pop($request->getData('persons')));
			} else {
				$this->update($id, $request);
				$this->setFlashBlockOverride('msg', self::RECORD_UPD);
				$this->redirect('/person/read');
			}
			
		} catch(DomainException $err) {
			$this->setFlashBlockOverride('msg', self::DB_ERROR);
			
		} catch(InvalidArgumentException $err) {
			$this->setFlashBlockOverride('msg', self::WRONG_PARAM);
		}	
		
		return 'personForm';
	}
	
	function jsonActionUpdate() {
		$request = RequestRegistry::getRequest();
		$id = $this->validateInteger($request->getParam(0));
		
		try { //check id
			if(self::isNull($id)) throw new LengthException;
			$this->read($request);
		} catch(LengthException $err) {

		}
		
		return self::VIEW_NONE;
	}
	
	private function update($id, $request) {
		$fName = $this->validateString($request->getParam(1));
		$lName = $this->validateString($request->getParam(2));

		if(self::isNotNull($fName, $lName)) {
			$dao = PersonDAO::getInstance();
			$dao->updatePerson(new PersonTO($id, $fName, $lName));
		} else {
			$request->setData('person', array('id'=>$id, 'fName'=>$fName, 'lName'=>$lName));
			throw new InvalidArgumentException;
		}
	}

	function actionDelete() {
		try {
			$request = RequestRegistry::getRequest();
			$this->delete($request);
			$this->setFlashBlockOverride('msg', self::RECORD_DEL);
			
		} catch(DomainException $err) {
			$this->setFlashBlockOverride('msg', self::DB_ERROR);
			
		} catch(InvalidArgumentException $err) {
			$this->setFlashBlockOverride('msg', self::WRONG_PARAM);
		} 
		
		$this->redirect('/person/read');
	}
	
	function jsonActionDelete() {
		return self::VIEW_NONE;
	}
	
	private function delete($request) {
		$dao = PersonDAO::getInstance();
		$id = self::validateInteger($request->getParam(0));
		
		if(self::isNull($id) || $dao->removePerson(new PersonTO($id)) == 0) {
			throw new InvalidArgumentException;
		}
	}
}