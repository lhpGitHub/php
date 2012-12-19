<?php
class DataBaseAccessFAKE extends DataBaseAccess {
	
	private $lastInsertId = 0;
	private $data;

	function loadData($data) {
		$this->data = $data;
	}
	
	function __destruct() {}

	function execute($sqlQuery, $values = null) {
		printf("SQL QUERY: %s, / params: %s<br>", $sqlQuery, print_r($values, true));
		
		$this->setLastInsertId($this->lastInsertId++);
	}
	
	protected function result($clearResult = true) {		
		
	}
}