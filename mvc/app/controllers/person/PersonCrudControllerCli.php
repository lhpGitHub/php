<?php namespace app\controllers\person;

class PersonCrudControllerCli extends PersonCrudController {
	
	public function __construct() {
		parent::__construct();
	}
	
	protected function idFailed(\core\exception\InvalidIdException $err) {
		$this->getRequest()->setResponse(self::WRONG_ID);
	}
	
	protected function dbError(\core\exception\DataBaseException $err) {
		$this->getRequest()->setResponse(self::DB_ERROR . (\core\Config::get('debug') ? ' '.$err->getMessage() : ''));
	}
	
	/***CREATE***/
	protected function createExecute(array $params) {
		parent::createExecute($params);
		$this->getRequest()->setResponse(self::RECORD_ADD);
	}

	protected function createParamFailed(array $params) {
		$this->getRequest()->setResponse(self::WRONG_PARAM);
	}
	
	
	/***READ***/
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
	
	/***UPDATE***/
	protected function updateExecute(array $params) {
		if(parent::updateExecute($params)) {
			$this->getRequest()->setResponse(self::RECORD_UPD);
		} else {
			$this->getRequest()->setResponse(self::RECORD_NO_MODIFY);
		}
	}
	
	protected function updateParamFailed(array $params) {
		$this->getRequest()->setResponse(self::WRONG_PARAM);
	}
	
	/***DELETE***/
	protected function deleteExecute(array $params) {
		parent::deleteExecute($params);
		$this->getRequest()->setResponse(self::RECORD_DEL);
	}
}