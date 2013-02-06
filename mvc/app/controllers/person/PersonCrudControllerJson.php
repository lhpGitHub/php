<?php namespace app\controllers\person;

class PersonCrudControllerJson extends PersonCrudController {
	
	public function __construct() {
		parent::__construct();
	}
	
	protected function idFailed(\core\exception\InvalidIdException $err) {
		$warning = self::WRONG_ID;
		$this->getRequest()->errorBadRequest($warning);
	}
	
	protected function dbError(\core\exception\DataBaseException $err) {
		$warning = self::DB_ERROR . (\core\Config::get('debug') ? ' '.$err->getMessage() : '');
		$this->getRequest()->errorInternalServer($warning);
	}
	
	/***CREATE***/
	protected function createExecute(array $params) {
		parent::createExecute($params);
		$this->getRequest()->successCreated();
	}

	protected function createParamFailed(array $params) {
		$warning = self::WRONG_PARAM;
		$this->getRequest()->errorBadRequest($warning);
	}
	
	/***READ***/
	protected function readExecute(array $params) {
		$result = json_encode(parent::readExecute($params));
		$this->getRequest()->sendResponse($result);
	}
	
	protected function readHelper(&$result, \app\models\person\PersonObject $personObject) {
		if(!is_array($result)) {
			$result = array();
		}
		
		$result[$personObject->getId()] = array('fName' => $personObject->getFirstName(), 'lName' => $personObject->getLastName());
	}
	
	protected function readNoRecord() {
		$warning = self::RECORD_EMPTY;
		$this->getRequest()->successNoContent($warning);
	}
	
	/***UPDATE***/
	protected function updateExecute(array $params) {
		if(parent::updateExecute($params)) {
			$warning = self::RECORD_UPD;
		} else {
			$warning = self::RECORD_NO_MODIFY;
		}
		
		$this->getRequest()->successOk($warning);
	}
	
	protected function updateParamFailed(array $params) {
		$warning = self::WRONG_PARAM;
		$this->getRequest()->errorBadRequest($warning);
	}
	
	/***DELETE***/
	protected function deleteExecute(array $params) {
		parent::deleteExecute($params);
		$this->getRequest()->successOk();
	}
}