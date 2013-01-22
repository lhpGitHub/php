<?php namespace app\controllers;

use core\controller\ParamsCleaner as ParamsCleaner;
use core\model\orm\HelperFactory as HelperFactory;
use app\config\Settings as Settings;

class PersonController extends \core\controller\BaseController {
	
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
	private $requestType;

	function __construct() {
		parent::__construct();
		
		$this->requestType = $this->getRequestType();
		
		if($this->requestType == 'Http')
			$this->view = new \core\view\View();
	}
	
	private function getRequestType() {
		if($this->getRequest() instanceof \core\controller\HtmlRequest) {
			return 'Http';
		} else if($this->getRequest() instanceof \core\controller\CliRequest) {
			return 'Cli';
		}
	}

	function actionCreate() {
		$crud = new \app\controllers\person\PersonCrudControllerHtml();
		$crud->create();
		//call_user_func(array($this, 'actionCreate'.$this->requestType));
	}
	
	private function actionCreateCli() {
			
		try {
			list($fName, $lName, $fSend) = ParamsCleaner::getSanitizeParam($this->getRequest(), ParamsCleaner::STRING_TRIM, ParamsCleaner::STRING_TRIM, ParamsCleaner::INTEGER);
			if(!ParamsCleaner::isAllNotNull($fName, $lName)) throw new \core\exception\InvalidParamException;
			$this->insert($fName, $lName);
			$this->getRequest()->setResponse(self::RECORD_ADD);
			
		} catch(\core\exception\InvalidParamException $err) {
			$this->getRequest()->setResponse(self::WRONG_PARAM);
			
		} catch(\core\exception\DataBaseException $err) {
			$this->getRequest()->setResponse(self::DB_ERROR . (Settings::$debug ? ' '.$err->getMessage() : ''));
		}
	}
	
//	function actionCreateHttp() {
//		try {
//			list($fName, $lName, $fSend) = ParamsCleaner::getSanitizeParam($this->getRequest(), ParamsCleaner::STRING_TRIM, ParamsCleaner::STRING_TRIM, ParamsCleaner::INTEGER);
//			if(!ParamsCleaner::isAllNotNull($fName, $lName)) throw new \core\exception\InvalidParamException;
//			$this->insert($fName, $lName);
//			$this->setFlashBlockOverride('msg', self::RECORD_ADD);
//			$this->redirect('/person/read');
//			
//		} catch(\core\exception\InvalidParamException $err) {
//			if(ParamsCleaner::isNotNull($fSend)) $this->setFlashBlockOverride('msg', self::WRONG_PARAM);
//			$this->view->setViewVar('personForm', 'action', $this->getRequest()->getAbsolutePath().'/person/create/');
//			$this->view->setViewVar('personForm', 'fName', $fName);
//			$this->view->setViewVar('personForm', 'lName', $lName);
//			$this->view->menu = "<br/><a href=\"{$this->getRequest()->getAbsolutePath()}/person/read/\">BACK</a>";
//			$this->view->content = $this->view->getViewAsVar('personForm');
//			
//		} catch(\core\exception\DataBaseException $err) {
//			$this->setFlashBlockOverride('msg', self::DB_ERROR . (Settings::$debug ? ' '.$err->getMessage() : ''));
//		}
//	
//		$this->getRequest()->setResponse($this->view->render());
//	}
//	
//	private function insert($fName, $lName) {
//		$personObject = new \app\models\person\PersonObject();
//		$personObject->setFirstName($fName);
//		$personObject->setLastName($lName);
//		
//		$mapper = HelperFactory::getMapper('app\models\person\Person');
//		$mapper->insert($personObject);
//	}

	function actionRead() {
		try {
			list($id) = ParamsCleaner::getSanitizeParam($this->getRequest(), ParamsCleaner::INTEGER);
			$personData = $this->find($id);
			$this->setFlashBlockOverride('msg', self::RECORD_READ);
			
			$htmlCode = '';
			
			if($personData instanceof \app\models\person\PersonCollection) {
				foreach($personData as $personObj)
					$this->readViewHelper($htmlCode, $personObj);
			} else {
				$personObj = $personData;
				$this->readViewHelper($htmlCode, $personObj);
			}
			
			$this->view->content = $htmlCode;
			
		} catch(\core\exception\NoRecordException $err) {
			$this->setFlashBlockOverride('msg', self::RECORD_EMPTY);
			
		} catch(\core\exception\DataBaseException $err) {
			$this->setFlashBlockOverride('msg', self::DB_ERROR . (Settings::$debug ? ' '.$err->getMessage() : ''));
		}
		
		$this->view->menu = "<br/><a href=\"{$this->getRequest()->getAbsolutePath()}/person/create/\">ADD RECORD</a>";
		$this->getRequest()->setResponse($this->view->render());
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
		$mapper = HelperFactory::getMapper('app\models\person\Person');
		
		if(ParamsCleaner::isNotNull($id)) {
			$personData = $mapper->find($id);
		} else {
			$personData = $mapper->findAll();
		}
		
		if(!$personData) throw new \core\exception\NoRecordException;
		
		return $personData;
	}

	function actionUpdate() {
		list($id, $fName, $lName, $fSend) = ParamsCleaner::getSanitizeParam($this->getRequest(), ParamsCleaner::INTEGER, ParamsCleaner::STRING_TRIM, ParamsCleaner::STRING_TRIM, ParamsCleaner::INTEGER);
		try {
			if(ParamsCleaner::isNull($id)) throw new \core\exception\InvalidIdException;
			
			$mapper = HelperFactory::getMapper('app\models\person\Person');
			$personObject = $mapper->find($id);
			
			if(!$personObject) throw new \core\exception\InvalidIdException;
			
			if(!ParamsCleaner::isAllNotNull($fName, $lName)) throw new \core\exception\InvalidParamException;
			
			$personObject->setFirstName($fName);
			$personObject->setLastName($lName);
			if($mapper->update($personObject)) {
				$this->setFlashBlockOverride('msg', self::RECORD_UPD);
			} else {
				$this->setFlashBlockOverride('msg', self::RECORD_NO_MODIFY);
			}
			$this->redirect('/person/read');
			
		} catch(\core\exception\InvalidIdException $err) {
			$this->setFlashBlockOverride('msg', self::WRONG_ID);
			$this->redirect('/person/read');
			
		} catch(\core\exception\InvalidParamException $err) {
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
			
		} catch(\core\exception\DataBaseException $err) {
			$this->setFlashBlockOverride('msg', self::DB_ERROR . (Settings::$debug ? ' '.$err->getMessage() : ''));
			
		}
		
		$this->getRequest()->setResponse($this->view->render());
	}

	function jsonActionUpdate() {
		
	}
	
	function actionDelete() {
		try {
			list($id) = ParamsCleaner::getSanitizeParam($this->getRequest(), ParamsCleaner::INTEGER);
			if(ParamsCleaner::isNull($id)) throw new \core\exception\InvalidIdException;
			$mapper = HelperFactory::getMapper('app\models\person\Person');
			if(!$mapper->delete(new \app\models\person\PersonObject($id))) throw new \core\exception\InvalidIdException;
			$this->setFlashBlockOverride('msg', self::RECORD_DEL);
			
		} catch(\core\exception\InvalidIdException $err) {
			$this->setFlashBlockOverride('msg', self::WRONG_ID);
			
		} catch(\core\exception\DataBaseException $err) {
			$this->setFlashBlockOverride('msg', self::DB_ERROR . (Settings::$debug ? ' '.$err->getMessage() : ''));
			
		}
		
		$this->redirect('/person/read');
	}
	
	function jsonActionDelete() {
		
	}
	
	function actionTestFunctionality() {
		echo 'actionTestFunctionality<br><br><pre>';
		
//		try {
//			\app\lib\PersonPhone::init();
//		} catch (\core\exception\FileNotExistsException $err) {
//			echo $err->getMessage();
//		}
		
		Settings::$dataBaseExt = \core\model\dba\DataBaseAccessFactory::FAKE;
		
		$mapper = HelperFactory::getMapper('app\models\person\Person');
		
		$testData = array(1=>array('fName'=>'pier', 'lName'=>'pierwszy'));
		$testData[] = array('fName'=>'drug', 'lName'=>'drugi');
		
		$dba = \core\model\dba\DataBaseAccessFactory::globalAccess();
		$dba->loadData('person', $testData);
		
		
		
//		$personA = new \app\models\PersonObject();
//		$personA->setFirstName('unity');
//		$personA->setLastName('of work');
//		
//		$personA2 = new \app\models\PersonObject();
//		$personA2->setFirstName('unity2');
//		$personA2->setLastName('of work2');
//		
		$personA3 = new \app\models\person\PersonObject();
		$personA3->setFirstName('trz');
		$personA3->setLastName('trzeci');
		
		$personA0 = $mapper->find(1);
		$personA1 = $mapper->find(2);
		$personA1->markDelete();
		
		$personA0->setFirstName('pier-modify');
		
		print_r($testData);
		
		\core\model\orm\DomainObjectWatcher::performOperations();

		var_dump($personA0, $personA1, $personA3);
		print_r($testData);
	}
	
	private function helperTestFunctionality($id) {
	}
}