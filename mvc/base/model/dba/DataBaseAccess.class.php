<?php
abstract class DataBaseAccess {
	
	private $lastInsertId;
	private $lastRowCount;
	private $result;
	
	abstract function execute($sqlQuery, $values = null);
	abstract protected function result($clearResult = true);
	
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

	function getResult($clearResult = true) {
		$this->result($clearResult);
		$res = $this->result;
		if($clearResult) $this->clearResult();
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