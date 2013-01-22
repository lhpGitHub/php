<?php namespace core\controller;

abstract class BaseCrudController extends BaseController {

	const RECORD_ADD		= 'success add record';
	const RECORD_DEL		= 'success delete record';
	const RECORD_UPD		= 'success update record';
	const RECORD_NO_MODIFY	= 'no modify record';
	const RECORD_READ		= 'success read record';
	const RECORD_EMPTY		= 'no record found';
	const WRONG_ID			= 'wrong id';
	const WRONG_PARAM		= 'wrong parameters';
	const DB_ERROR			= 'database error';
	
	protected abstract function createGetParam();
	protected abstract function createCheckParam(array $params);
	protected abstract function createExecute(array $params);
	protected abstract function createParamFailed(array $params);
	protected abstract function createDbError();
	
	public function create() {
		try {
			$params = $this->createGetParam();
			$paramsCorrect = $this->createCheckParam($params);
			if(!$paramsCorrect) throw new \core\exception\InvalidParamException;
			$this->createExecute($params);			
		} catch(\core\exception\InvalidParamException $err) {
			$this->createParamFailed($params);
		} catch(\core\exception\DataBaseException $err) {
			$this->createDbError();
		}
	}
	
	
	
}