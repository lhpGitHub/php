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
	
	protected function createDbError() {
		$this->setFlashBlockOverride('msg', self::DB_ERROR . (Settings::$debug ? ' '.$err->getMessage() : ''));
		$this->getRequest()->setResponse($this->view->render());
	}
}