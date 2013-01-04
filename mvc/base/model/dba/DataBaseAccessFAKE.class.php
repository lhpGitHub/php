<?php
class DataBaseAccessFAKE extends DataBaseAccess {
	
	private $lastInsertId = array();
	public $data = array();

	function loadData($tableName, &$data) {
		$this->data[$tableName] = &$data;
		$this->lastInsertId[$tableName] = count($data);
	}
	
	function __destruct() {}

	protected function doExecute($sqlQuery, $values = null) {
		list($queryType, $tableName) = $this->parseSqlQuery($sqlQuery);
		
		if(!is_null($queryType) && !is_null($tableName))
			return $this->$queryType($tableName, $values);

		throw new DataBaseException( 'SQL QUERY parse error' );
	}
	
	private function parseSqlQuery($sqlQuery) {
		$queryType = NULL;
		$tableName = NULL;
		
		preg_match('/^(SELECT|INSERT|UPDATE|DELETE)/i', $sqlQuery, $matches);
		
		switch (strtoupper($matches[0])) {
			case 'SELECT':
				$queryType = 'select';
				if(preg_match('/FROM (\w+)/i', $sqlQuery, $matches))	
					$tableName = $matches[1];
				break;

			case 'INSERT':
				$queryType = 'insert';
				if(preg_match('/INTO (\w+)/i', $sqlQuery, $matches))
					$tableName = $matches[1];
				break;
			
			case 'UPDATE':
				$queryType = 'update';
				if(preg_match('/UPDATE (\w+)/i', $sqlQuery, $matches))
					$tableName = $matches[1];
				break;
			
			case 'DELETE':
				$queryType = 'delete';
				if(preg_match('/FROM (\w+)/i', $sqlQuery, $matches))
					$tableName = $matches[1];
				break;
		}
		
		return array($queryType, $tableName);
	}

		protected function doResult() {	
		if(!$this->isResult())
			throw new DataBaseException( __METHOD__ );
	}
	
	private function findById($tableName, $id) {
		if(isset($this->data[$tableName][$id]))
			return array(array_merge(array('id'=>$id), $this->data[$tableName][$id]));
		else
			return false;
	}

	private function findAll($tableName) {
		$res = array();
		reset($this->data[$tableName]);
		
		while (list($id, $val) = each($this->data[$tableName]))
			$res[] = array_merge(array('id'=>$id), $val);
		
		if(!empty($res))
			return $res;
		else
			return false;
	}

	private function select($tableName, $val) {
		$searchId = (is_array($val) && isset($val['id'])) ? $val['id'] : NULL;
		
		if(is_null($searchId)) {
			$res = $this->findAll($tableName);
		} else {
			$res = $this->findById($tableName, $searchId);
		}
		
		if($res) {
			$this->setLastRowCount(count($res));
			$this->setResult($res);
		} else {
			$this->setLastRowCount(0);
			$this->setResult(array());
		}
		
		$this->setLastInsertId(NULL);
	}
	
	private function insert($tableName, $val) {
		$this->lastInsertId[$tableName]++;
		$id = $this->lastInsertId[$tableName];
		$this->data[$tableName][$id] = $val;
		$this->setLastInsertId($id);
		$this->setLastRowCount(1);
		$this->setResult(NULL);
	}
	
	private function update($tableName, $val) {
		$updateId = $val['id'];
		
		if($this->findById($tableName, $updateId)) {
			$this->data[$tableName][$updateId] = $val;
			$this->setLastRowCount(1);
		} else {
			$this->setLastRowCount(0);
		}

		$this->setLastInsertId(NULL);
		$this->setResult(NULL);
	}
	
	private function delete($tableName, $val) {
		$deleteId = $val['id'];
		
		if($this->findById($tableName, $deleteId)) {
			unset($this->data[$tableName][$deleteId]);
			$this->setLastRowCount(1);
		} else {
			$this->setLastRowCount(0);
		}
		
		$this->setLastInsertId(NULL);
		$this->setResult(NULL);
	}
}