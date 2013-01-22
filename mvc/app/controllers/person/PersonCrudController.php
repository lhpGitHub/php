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
}