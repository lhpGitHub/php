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
	
	private $personMapper;
	private $view;

	function __construct() {
		parent::__construct();
		$this->personMapper = HelperFactory::getMapper('Person');
		$this->view = new View();
	}

	function actionCreate() {
		try {
			list($fName, $lName, $fSend) = ParamsCleaner::getSanitizeParam($this->getRequest(), ParamsCleaner::STRING_TRIM, ParamsCleaner::STRING_TRIM, ParamsCleaner::INTEGER);
			
			if(!ParamsCleaner::isAllNotNull($fName, $lName)) throw new InvalidParamException;
			$this->insert($fName, $lName);
			$this->setFlashBlockOverride('msg', self::RECORD_ADD);
			$this->redirect('/person/read');
			
		} catch(InvalidParamException $err) {
			if(ParamsCleaner::isNotNull($fSend)) $this->setFlashBlockOverride('msg', self::WRONG_PARAM);
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
		$personObject->setFirstName($fName);
		$personObject->setLastName($lName);
		
		$this->personMapper->insert($personObject);
	}

	function actionRead() {
		try {
			list($id) = ParamsCleaner::getSanitizeParam($this->getRequest(), ParamsCleaner::INTEGER);
			
			$personData = $this->find($id);
			$this->setFlashBlockOverride('msg', self::RECORD_READ);
			
			$htmlCode = '';
			
			if($personData instanceof PersonCollection) {
				foreach($personData as $personObj)
					$this->readViewHelper($htmlCode, $personObj);
			} else {
				$personObj = $personData;
				$this->readViewHelper($htmlCode, $personObj);
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
		$this->view->setViewVar('personListItem', 'id', $personObject->getId());
		$this->view->setViewVar('personListItem', 'fName', $personObject->getFirstName());
		$this->view->setViewVar('personListItem', 'lName', $personObject->getLastName());
		$this->view->setViewVar('personListItem', 'aUpdate', $this->getRequest()->getAbsolutePath().'/person/update/'.$personObject->getId().'/');
		$this->view->setViewVar('personListItem', 'aDelete', $this->getRequest()->getAbsolutePath().'/person/delete/'.$personObject->getId().'/');
		$html .= $this->view->getViewAsVar('personListItem');
	}
	
	function jsonActionRead() {
		
	}
	
	private function find($id) {
		
		if(ParamsCleaner::isNotNull($id)) {
			$personData = $this->personMapper->find($id);
		} else {
			$personData = $this->personMapper->findAll();
		}
		
		if(is_null($personData)) throw new NoRecordException;
		
		return $personData;
	}

	function actionUpdate() {
		list($id, $fName, $lName, $fSend) = ParamsCleaner::getSanitizeParam($this->getRequest(), ParamsCleaner::INTEGER, ParamsCleaner::STRING_TRIM, ParamsCleaner::STRING_TRIM, ParamsCleaner::INTEGER);
		
		try {
			if(ParamsCleaner::isNull($id)) throw new InvalidIdException;
			
			$personObject = $this->personMapper->find($id);
			
			if(is_null($personObject)) throw new InvalidIdException;
			
			if(!ParamsCleaner::isAllNotNull($fName, $lName)) throw new InvalidParamException;
			
			$personObject->setFirstName($fName);
			$personObject->setLastName($lName);
			$this->personMapper->update($personObject);
			$this->setFlashBlockOverride('msg', self::RECORD_UPD);
			$this->redirect('/person/read');
			
		} catch(InvalidIdException $err) {
			$this->setFlashBlockOverride('msg', self::WRONG_ID);
			$this->redirect('/person/read');
			
		} catch(InvalidParamException $err) {
			if(ParamsCleaner::isNull($fSend)) {
				$id = $personObject->getId();
				$fName = $personObject->getFirstName();
				$lName = $personObject->getLastName();
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
			list($id) = ParamsCleaner::getSanitizeParam($this->getRequest(), ParamsCleaner::INTEGER);
			if(ParamsCleaner::isNull($id)) throw new InvalidIdException;
			if($this->personMapper->delete(new PersonObject($id)) !== 1) throw new InvalidIdException;
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
	
	function actionTestFunctionality() {
		echo 'actionTestFunctionality<br><br>';
		
		
		$personA = new PersonObject();
		$personA->setFirstName('unity');
		$personA->setLastName('of work');
		
		$personA2 = new PersonObject();
		$personA2->setFirstName('unity2');
		$personA2->setLastName('of work2');
		
		
//		$personB = $this->personMapper->find(1);
//		$personB->setFirstName('A');
//		$personB->setLastName('B');
//		$personB = $this->personMapper->find(1);
//		
//		$personC = $this->personMapper->find(3);
//		$personC->setFirstName('A');
		
		DomainObjectWatcher::performOperations();
		
//		echo '<br><br>mapper test<br><br>';
//		
//		
//		$m1 = HelperFactory::getMapper('Person');
//		print_r($m1);
//		$m2 = $personA->mapper();
//		print_r($m2);
//		
//		var_dump($m1 === $m2);
	}
	
	private function helperTestFunctionality($id) {
	}
}