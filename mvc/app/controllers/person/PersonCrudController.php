<?php namespace app\controllers\person;

use core\controller\ParamsCleaner as ParamsCleaner;
use core\model\orm\HelperFactory as HelperFactory;


abstract class PersonCrudController extends \core\controller\BaseCrudController {
	
	protected function createGetParam() {
		$params = ParamsCleaner::getSanitizeParamWithKey($this->getRequest(), 
			'fName', ParamsCleaner::STRING_TRIM, 
			'lName', ParamsCleaner::STRING_TRIM, 
			'fSend', ParamsCleaner::INTEGER);
		
		return $params;
	}
	
	protected function createCheckParam(array $params) {
		return ParamsCleaner::isAllNotNull($params['fName'], $params['lName']);
	}

	protected function createExecute(array $params) {
		$personObject = new \app\models\person\PersonObject();
		$personObject->setFirstName($params['fName']);
		$personObject->setLastName($params['lName']);
		$mapper = HelperFactory::getMapper('app\models\person\Person');
		$mapper->insert($personObject);
	}
	
	protected function readGetParam() {
		$params = ParamsCleaner::getSanitizeParamWithKey($this->getRequest(), 
			'id', ParamsCleaner::INTEGER);
		
		return $params;
	}
	
	protected function readExecute(array $params) {
		$personData = false;
		$mapper = HelperFactory::getMapper('app\models\person\Person');
		
		if(ParamsCleaner::isNotNull($params['id'])) {
			$personData = $mapper->find($params['id']);
		} else {
			$personData = $mapper->findAll();
		}
		
		if(!$personData) throw new \core\exception\NoRecordException;
		
		$result = '';
		
		if($personData instanceof \app\models\person\PersonCollection) {
			foreach($personData as $personObj)
				$this->readHelper($result, $personObj);
		} else {
			$personObj = $personData;
			$this->readHelper($result, $personObj);
		}
		
		return $result;
	}
	
	protected abstract function readHelper(&$result, \app\models\person\PersonObject $personObject);
	
}