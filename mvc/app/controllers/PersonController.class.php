<?php
class PersonController extends BaseController {
	
	const RECORD_ADD		= 'success add record';
	const RECORD_DEL		= 'success delete record';
	const RECORD_UPD		= 'success update record';
	const RECORD_NO_MODIFY	= 'no modify record';
	const RECORD_READ		= 'success read record';
	const RECORD_EMPTY		= 'no record found';

	const WRONG_ID			= 'wrong id';
	const WRONG_PARAM		= 'wrong parameters';
	const DB_ERROR			= 'database error';
	
	private $view;

	function __construct() {
		parent::__construct();
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
			$this->setFlashBlockOverride('msg', self::DB_ERROR . (Settings::$debug ? ' '.$err->getMessage() : ''));
		}
	
		$this->view->render();
	}
	
	function jsonActionCreate() {
		
	}
	
	private function insert($fName, $lName) {
		$personObject = new PersonObject();
		$personObject->setFirstName($fName);
		$personObject->setLastName($lName);
		
		$mapper = HelperFactory::getMapper('Person');
		$mapper->insert($personObject);
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
			$this->setFlashBlockOverride('msg', self::DB_ERROR . (Settings::$debug ? ' '.$err->getMessage() : ''));
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
		$personData = false;
		$mapper = HelperFactory::getMapper('Person');
		
		if(ParamsCleaner::isNotNull($id)) {
			$personData = $mapper->find($id);
		} else {
			$personData = $mapper->findAll();
		}
		
		if(!$personData) throw new NoRecordException;
		
		return $personData;
	}

	function actionUpdate() {
		list($id, $fName, $lName, $fSend) = ParamsCleaner::getSanitizeParam($this->getRequest(), ParamsCleaner::INTEGER, ParamsCleaner::STRING_TRIM, ParamsCleaner::STRING_TRIM, ParamsCleaner::INTEGER);
		
		try {
			if(ParamsCleaner::isNull($id)) throw new InvalidIdException;
			
			$mapper = HelperFactory::getMapper('Person');
			$personObject = $mapper->find($id);
			
			if(!$personObject) throw new InvalidIdException;
			
			if(!ParamsCleaner::isAllNotNull($fName, $lName)) throw new InvalidParamException;
			
			$personObject->setFirstName($fName);
			$personObject->setLastName($lName);
			if($mapper->update($personObject)) {
				$this->setFlashBlockOverride('msg', self::RECORD_UPD);
			} else {
				$this->setFlashBlockOverride('msg', self::RECORD_NO_MODIFY);
			}
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
			$this->setFlashBlockOverride('msg', self::DB_ERROR . (Settings::$debug ? ' '.$err->getMessage() : ''));
			
		}
		
		$this->view->render();
	}

	function jsonActionUpdate() {
		
	}
	
	function actionDelete() {
		try {
			list($id) = ParamsCleaner::getSanitizeParam($this->getRequest(), ParamsCleaner::INTEGER);
			if(ParamsCleaner::isNull($id)) throw new InvalidIdException;
			$mapper = HelperFactory::getMapper('Person');
			if(!$mapper->delete(new PersonObject($id))) throw new InvalidIdException;
			$this->setFlashBlockOverride('msg', self::RECORD_DEL);
			
		} catch(InvalidIdException $err) {
			$this->setFlashBlockOverride('msg', self::WRONG_ID);
			
		} catch(DataBaseException $err) {
			$this->setFlashBlockOverride('msg', self::DB_ERROR . (Settings::$debug ? ' '.$err->getMessage() : ''));
			
		}
		
		$this->redirect('/person/read');
	}
	
	function jsonActionDelete() {
		
	}
	
	function actionTestFunctionality() {
		echo 'actionTestFunctionality<br><br><pre>';
		
		Settings::$dataBaseAccessType = DataBaseAccessFactory::FAKE;
		
		$mapper = HelperFactory::getMapper('Person');
		
		$testData = array();
		$testData[] = array('fName'=>'pier', 'lName'=>'pierwszy');
		$testData[] = array('fName'=>'drug', 'lName'=>'drugi');
		$testData[] = array('fName'=>'trz', 'lName'=>'trzeci');
		
		$dba = DataBaseAccessFactory::globalAccess();
		$dba->loadData($testData);
		
		
		
//		$personA = new PersonObject();
//		$personA->setFirstName('unity');
//		$personA->setLastName('of work');
//		
//		$personA2 = new PersonObject();
//		$personA2->setFirstName('unity2');
//		$personA2->setLastName('of work2');
//		
		$personA3 = new PersonObject();
		$personA3->setFirstName('unity3');
		$personA3->setLastName('of work3');
		
		$personA0 = $mapper->find(0);
		$personA1 = $mapper->find(1);
		$personA2 = $mapper->find(2);
		$personA2->markDelete();
		
		$personA0->setFirstName('watcher');
		
		print_r($testData);
		
		DomainObjectWatcher::performOperations();

		//var_dump($personA0, $personA1, $personA3);
		print_r($testData);
	}
	
	private function helperTestFunctionality($id) {
	}
}