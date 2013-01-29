<?php namespace app\controllers\person;

use core\controller\ParamsCleaner as ParamsCleaner;
use app\config\Settings as Settings;

class PersonCrudControllerCli extends PersonCrudController {
	
	public function __construct() {
		
	}
	
	protected function createExecute(array $params) {
		parent::createExecute($params);
		$this->getRequest()->setResponse(self::RECORD_ADD);
	}

	protected function createParamFailed(array $params) {
		$this->getRequest()->setResponse(self::WRONG_PARAM);
	}
	
	protected function createDbError(\core\exception\DataBaseException $err) {
		$this->getRequest()->setResponse(self::DB_ERROR . (Settings::$debug ? ' '.$err->getMessage() : ''));
	}
	
	protected function readExecute(array $params) {
		$result = self::RECORD_READ.PHP_EOL.parent::readExecute($params);
		$this->getRequest()->setResponse($result);
	}
	
	protected function readHelper(&$result, \app\models\person\PersonObject $personObject) {
		$result .= sprintf("ID:%d\t%s %s", 
			$personObject->getId(),
			$personObject->getFirstName(),
			$personObject->getlastName()).PHP_EOL;
	}
	
	protected function readNoRecord() {
		$this->getRequest()->setResponse(self::RECORD_EMPTY);
	}
	
	protected function readDbError(\core\exception\DataBaseException $err) {
		$this->getRequest()->setResponse(self::DB_ERROR . (Settings::$debug ? ' '.$err->getMessage() : ''));
	}
}