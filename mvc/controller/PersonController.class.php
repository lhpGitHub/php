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
			list($fName, $lName, $fSend) = $this->getSanitizeParam('String' , 'String' , 'Integer');
			
			if(!self::isAllNotNull($fName, $lName)) throw new InvalidParamException;
			$this->insert($fName, $lName);
			$this->setFlashBlockOverride('msg', self::RECORD_ADD);
			$this->redirect('/person/read');
			
		} catch(InvalidParamException $err) {
			if(self::isNotNull($fSend)) $this->setFlashBlockOverride('msg', self::WRONG_PARAM);
			$this->view->setViewVar('personForm', 'action', $this->getRequest()->getAbsolutePath().'/person/create/');
			$this->view->setViewVar('personForm', 'fName', $fName);
			$this->view->setViewVar('personForm', 'lName', $lName);
			$this->view->menu = "<br/><a href=\"{$this->getRequest()->getAbsolutePath()}/person/read/\">BACK</a>";
			$this->view->content = $this->view->getViewAsVar('personForm');
			
		} catch(DataBaseException $err) {
			$this->setFlashBlockOverride('msg', self::DB_ERROR . (DEBUG ? ' '.$err->getMessage() : ''));
		}
	
		$this->view->render();
	}
	
	function jsonActionCreate() {
		
	}
	
	private function insert($fName, $lName) {
		$personObject = new PersonObject();
		$personObject->fName = $fName;
		$personObject->lName = $lName;
		
		$mapper = RequestRegistry::getMapper('person');
		$mapper->insert($personObject);
	}

	function actionRead() {
		try {
			list($id) = $this->getSanitizeParam('Integer');
			
			$personData = $this->find($id);
			$this->setFlashBlockOverride('msg', self::RECORD_READ);
			
			$htmlCode = '';
			
			if($personData instanceof PersonCollection) {
				foreach($personData as $personObj)
					$this->readViewHelper(&$htmlCode, $personObj);
			} else {
				$this->readViewHelper(&$htmlCode, $personData);
			}
			
			$this->view->content = $htmlCode;
			
		} catch(NoRecordException $err) {
			$this->setFlashBlockOverride('msg', self::RECORD_EMPTY);
			
		} catch(DataBaseException $err) {
			$this->setFlashBlockOverride('msg', self::DB_ERROR . (DEBUG ? ' '.$err->getMessage() : ''));
		}
		
		$this->view->menu = "<br/><a href=\"{$this->getRequest()->getAbsolutePath()}/person/create/\">ADD RECORD</a>";
		$this->view->render();
	}
	
	private function readViewHelper(&$html, $personObject) {
		$this->view->setViewVar('personListItem', 'id', $personObject->id);
		$this->view->setViewVar('personListItem', 'fName', $personObject->fName);
		$this->view->setViewVar('personListItem', 'lName', $personObject->lName);
		$this->view->setViewVar('personListItem', 'aUpdate', $this->getRequest()->getAbsolutePath().'/person/update/'.$personObject->id.'/');
		$this->view->setViewVar('personListItem', 'aDelete', $this->getRequest()->getAbsolutePath().'/person/delete/'.$personObject->id.'/');
		$html .= $this->view->getViewAsVar('personListItem');
	}
	
	function jsonActionRead() {
		
	}
	
	private function find($id) {
		
		$mapper = RequestRegistry::getMapper('person');

		if(self::isNotNull($id)) {
			$personData = $mapper->find($id);
		} else {
			$personData = $mapper->findAll();
		}
		
		if(is_null($personData)) throw new NoRecordException;
		
		return $personData;
	}

	function actionUpdate() {
		list($id, $fName, $lName, $fSend) = $this->getSanitizeParam('Integer', 'String' , 'String' , 'Integer');
		
		try {
			if(self::isNull($id)) throw new InvalidIdException;
			
			$mapper = RequestRegistry::getMapper('person');
			$personObject = $mapper->find($id);
			
			if(is_null($personObject)) throw new InvalidIdException;
			
			if(!self::isAllNotNull($fName, $lName)) throw new InvalidParamException;
			
			$personObject->fName = $fName;
			$personObject->lName = $lName;
			$mapper->update($personObject);
			$this->setFlashBlockOverride('msg', self::RECORD_UPD);
			$this->redirect('/person/read');
			
		} catch(InvalidIdException $err) {
			$this->setFlashBlockOverride('msg', self::WRONG_ID);
			$this->redirect('/person/read');
			
		} catch(InvalidParamException $err) {
			if(self::isNull($fSend)) {
				$id = $personObject->id;
				$fName = $personObject->fName;
				$lName = $personObject->lName;
			} else {
				$this->setFlashBlockOverride('msg', self::WRONG_PARAM);
			}
			
			$this->view->setViewVar('personForm', 'action', $this->getRequest()->getAbsolutePath().'/person/update/'.$id.'/');
			$this->view->setViewVar('personForm', 'fName', $fName);
			$this->view->setViewVar('personForm', 'lName', $lName);
			$this->view->menu= "<br/><a href=\"{$this->getRequest()->getAbsolutePath()}/person/read/\">BACK</a>";
			$this->view->content = $this->view->getViewAsVar('personForm');
			
		} catch(DataBaseException $err) {
			$this->setFlashBlockOverride('msg', self::DB_ERROR . (DEBUG ? ' '.$err->getMessage() : ''));
			
		}
		
		$this->view->render();
	}

	function jsonActionUpdate() {
		
	}
	
	function actionDelete() {
		try {
			list($id) = $this->getSanitizeParam('Integer');
			if(self::isNull($id)) throw new InvalidIdException;
			
			$personObject = new PersonObject();
			$personObject->id = $id;
			$mapper = RequestRegistry::getMapper('person');
			if($mapper->delete($personObject) !== 1) throw new InvalidIdException;
			
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
}