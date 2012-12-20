<?php
abstract class DataBaseAccess {
	
	private $lastInsertId;
	private $lastRowCount;
	private $result;
	
	abstract protected function doExecute($sqlQuery, $values = null);
	abstract protected function doResult();
	
	function execute($sqlQuery, $values = null) {
		$this->doExecute($sqlQuery, $values);
	}
	
	protected function setLastInsertId($id) {
		$this->lastInsertId = $id;
	}

	function getLastInsertId() {
		return $this->lastInsertId;
	}
	
	protected function setLastRowCount($lastRowCount) {
		$this->lastRowCount = $lastRowCount;
	}

	function getLastRowCount() {
		return $this->lastRowCount;
	}
	
	protected function setResult(array $result) {
		$this->result = $result;
	}

	function result($cacheResult = false) {
		$this->doResult();
		$res = $this->result;
		if(!$cacheResult) $this->clearResult();
		return $res;
	}
	
	function clearResult() {
		$this->result = NULL;
	}
	
	function clearLastInsertId() {
		$this->lastInsertId = NULL;
	}
	
	function clearLastRowCount() {
		$this->lastRowCount = NULL;
	}
	
	function clearBuffer() {
		$this->clearResult();
		$this->clearLastInsertId();
		$this->clearLastRowCount();
	}
}