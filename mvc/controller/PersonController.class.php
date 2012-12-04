<?php
class PersonController extends BaseController {
	
	const RECORD_ADD	= 'success add record';
	const RECORD_DEL	= 'success delete record';
	const RECORD_UPD	= 'success update record';
	const RECORD_READ	= 'success read record';
	const RECORD_EMPTY	= 'no record found';

	const WRONG_ID	= 'wrong id';
	const WRONG_PARAM	= 'wrong parameters';
	const DB_ERROR		= 'database error';
	
	function __construct() {
		parent::__construct();
	}


	function actionCreate() {
		try {
			$request = $this->getRequest();
			$fName = self::validateString($request->getParam(0));
			$lName = self::validateString($request->getParam(1));
			$fSend = self::validateInteger($request->getParam(2));
			if(!self::isNotNullAll($fName, $lName)) throw new InvalidParamException;
			$this->create($fName, $lName);
			$this->setFlashBlockOverride('msg', self::RECORD_ADD);
			$this->redirect('/person/read');
			
		} catch(InvalidParamException $err) {
			if(self::isNotNullAll($fSend)) $this->setFlashBlockOverride('msg', self::WRONG_PARAM);
			$this->view->setViewVar('personForm', 'action', $request->getAbsolutePath().'/person/create/');
			$this->view->setViewVar('personForm', 'fName', $fName);
			$this->view->setViewVar('personForm', 'lName', $lName);
			$this->view->menu = "<br/><a href=\"{$request->getAbsolutePath()}/person/read/\">BACK</a>";
			$this->view->content = $this->view->getViewAsVar('personForm');
			
		} catch(DataBaseException $err) {
			$this->setFlashBlockOverride('msg', self::DB_ERROR . (DEBUG ? ' '.$err->getMessage() : ''));
		}
	
		$this->view->render();
	}
	
	function jsonActionCreate() {
		
	}
	
	private function create($fName, $lName) {
		$dao = PersonDAO::getInstance();
		$dao->addPerson(new PersonTO(null, $fName, $lName));
	}

	function actionRead() {
		try {
			$request = $this->getRequest();
			$id = self::validateInteger($request->getParam(0));
			$personData = $this->read($id);
			$this->setFlashBlockOverride('msg', self::RECORD_READ);
			
			$htmlCode = '';
			
			if($personData instanceof PersonCollection) {
				foreach($personData as $personObj)
					$this->readViewHelper(&$htmlCode, $personObj, $request);
			} else {
				$this->readViewHelper(&$htmlCode, $personData, $request);
			}
			
			$this->view->menu = "<br/><a href=\"{$request->getAbsolutePath()}/person/create/\">ADD RECORD</a>";
			$this->view->content = $htmlCode;
			
		} catch(NoRecordException $err) {
			$this->setFlashBlockOverride('msg', self::RECORD_EMPTY);
			
		} catch(DataBaseException $err) {
			$this->setFlashBlockOverride('msg', self::DB_ERROR . (DEBUG ? ' '.$err->getMessage() : ''));
		}
		
		$this->view->render();
	}
	
	private function readViewHelper(&$html, $personObject, $request) {
		$this->view->setViewVar('personListItem', 'id', $personObject->id);
		$this->view->setViewVar('personListItem', 'fName', $personObject->fName);
		$this->view->setViewVar('personListItem', 'lName', $personObject->lName);
		$this->view->setViewVar('personListItem', 'aUpdate', $request->getAbsolutePath().'/person/update/'.$personObject->id.'/');
		$this->view->setViewVar('personListItem', 'aDelete', $request->getAbsolutePath().'/person/delete/'.$personObject->id.'/');
		$html .= $this->view->getViewAsVar('personListItem');
	}
	
	function jsonActionRead() {
		
	}
	
	private function read($id) {
		
		$mapper = RequestRegistry::getMapper('person');

		if(self::isNotNull($id)) {
			$person = $mapper->find($id);
		} else {
			$person = $mapper->findAll();
		}
		
		if(is_null($person)) throw new NoRecordException;
		
		return $person;
	}

	function actionUpdate() {
		$request = $this->getRequest();
		$id = self::validateInteger($request->getParam(0));
		$fName = self::validateString($request->getParam(1));
		$lName = self::validateString($request->getParam(2));
		$fSend = self::validateInteger($request->getParam(3));
		
		try {
			if(self::isNullAll($id)) {
				throw new InvalidIdException;
			}
			
			try {
				$person = $this->read($id)->current();
			} catch (NoRecordException $err) {
				throw new InvalidIdException;
			}
			
			if(!self::isNotNullAll($fName, $lName)) {
				throw new InvalidParamException;
			}
			
			$this->update($id, $fName, $lName);
			$this->setFlashBlockOverride('msg', self::RECORD_UPD);
			$this->redirect('/person/read');
			
		} catch(InvalidIdException $err) {
			$this->setFlashBlockOverride('msg', self::WRONG_ID);
			$this->redirect('/person/read');
			
		} catch(InvalidParamException $err) {
			if(self::isNullAll($fSend)) {
				extract($person);
			} else {
				$this->setFlashBlockOverride('msg', self::WRONG_PARAM);
			}
			$this->view->setViewVar('personForm', 'action', $request->getAbsolutePath().'/person/update/'.$id.'/');
			$this->view->setViewVar('personForm', 'fName', $fName);
			$this->view->setViewVar('personForm', 'lName', $lName);
			$this->view->menu= "<br/><a href=\"{$request->getAbsolutePath()}/person/read/\">BACK</a>";
			$this->view->content = $this->view->getViewAsVar('personForm');
			
		} catch(DataBaseException $err) {
			$this->setFlashBlockOverride('msg', self::DB_ERROR . (DEBUG ? ' '.$err->getMessage() : ''));
			
		}
		
		$this->view->render();
	}
	
	function jsonActionUpdate() {
		
	}
	
	private function update($id, $fName, $lName) {
		$dao = PersonDAO::getInstance();
		$dao->updatePerson(new PersonTO($id, $fName, $lName));
	}

	function actionDelete() {
		try {
			$request = $this->getRequest();
			$id = self::validateInteger($request->getParam(0));
			$this->delete($id);
			$this->setFlashBlockOverride('msg', self::RECORD_DEL);
			
		} catch(InvalidIdException $err) {
			$this->setFlashBlockOverride('msg', self::WRONG_ID);
			
		} catch(DataBaseException $err) {
			$this->setFlashBlockOverride('msg', self::DB_ERROR . (DEBUG ? ' '.$err->getMessage() : ''));
			
		}
		
		$this->redirect('/person/read');
	}
	
	function jsonActionDelete() {
		
	}
	
	private function delete($id) {
		$dao = PersonDAO::getInstance();
		
		if(self::isNullAll($id) || $dao->removePerson(new PersonTO($id)) == 0) {
			throw new InvalidIdException;
		}
	}
}