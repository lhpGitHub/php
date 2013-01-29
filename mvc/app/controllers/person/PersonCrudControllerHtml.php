<?php namespace app\controllers\person;

use core\controller\ParamsCleaner as ParamsCleaner;
use app\config\Settings as Settings;

class PersonCrudControllerHtml extends PersonCrudController {
	
	private $view;

	public function __construct() {
		$this->view = new \core\view\View();
	}
	
	protected function createExecute(array $params) {
		parent::createExecute($params);
		$this->setFlashBlockOverride('msg', self::RECORD_ADD);
		$this->redirect('/person/read');
	}

	protected function createParamFailed(array $params) {
		if(ParamsCleaner::isNotNull($params['fSend'])) $this->setFlashBlockOverride('msg', self::WRONG_PARAM);
		
		$this->view->setViewVar('personForm', 'action', $this->getRequest()->getAbsolutePath().'/person/create/');
		$this->view->setViewVar('personForm', 'fName', $params['fName']);
		$this->view->setViewVar('personForm', 'lName', $params['lName']);
		$this->view->menu = "<br/><a href=\"{$this->getRequest()->getAbsolutePath()}/person/read/\">BACK</a>";
		$this->view->content = $this->view->getViewAsVar('personForm');
		
		$this->getRequest()->setResponse($this->view->render());
	}
	
	protected function createDbError(\core\exception\DataBaseException $err) {
		$this->setFlashBlockOverride('msg', self::DB_ERROR . (Settings::$debug ? ' '.$err->getMessage() : ''));
		$this->getRequest()->setResponse($this->view->render());
	}
	
	protected function readExecute(array $params) {
		$this->view->content = parent::readExecute($params);
		$this->view->menu = "<br/><a href=\"{$this->getRequest()->getAbsolutePath()}/person/create/\">ADD RECORD</a>";
		$this->getRequest()->setResponse($this->view->render());
	}
	
	protected function readHelper(&$result, \app\models\person\PersonObject $personObject) {
		$this->view->setViewVar('personListItem', 'id', $personObject->getId());
		$this->view->setViewVar('personListItem', 'fName', $personObject->getFirstName());
		$this->view->setViewVar('personListItem', 'lName', $personObject->getLastName());
		$this->view->setViewVar('personListItem', 'aUpdate', $this->getRequest()->getAbsolutePath().'/person/update/'.$personObject->getId().'/');
		$this->view->setViewVar('personListItem', 'aDelete', $this->getRequest()->getAbsolutePath().'/person/delete/'.$personObject->getId().'/');
		$result .= $this->view->getViewAsVar('personListItem');
	}
	
	protected function readNoRecord() {
		$this->setFlashBlockOverride('msg', self::RECORD_EMPTY);
		$this->view->menu = "<br/><a href=\"{$this->getRequest()->getAbsolutePath()}/person/create/\">ADD RECORD</a>";
		$this->getRequest()->setResponse($this->view->render());
	}
	
	protected function readDbError(\core\exception\DataBaseException $err) {
		$this->setFlashBlockOverride('msg', self::DB_ERROR . (Settings::$debug ? ' '.$err->getMessage() : ''));
		$this->view->menu = "<br/><a href=\"{$this->getRequest()->getAbsolutePath()}/person/create/\">ADD RECORD</a>";
		$this->getRequest()->setResponse($this->view->render());
	}
}