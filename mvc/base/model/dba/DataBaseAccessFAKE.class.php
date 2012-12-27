<?php
class DataBaseAccessFAKE extends DataBaseAccess {
	
	private $lastInsertId = 1;
	private $data = array();

	function loadData(&$data) {
		$this->data = &$data;
		$this->lastInsertId = count($this->data)+1;
	}
	
	function __destruct() {}

	protected function doExecute($sqlQuery, $values = null) {
		
		var_dump($sqlQuery);
		
//		$sql = "SELECT * FROM person ORDER BY id";
//		$sql = "INSERT INTO person (fName, lName) VALUES (:fName, :lName)";
//		$sql = "UPDATE person SET fName=:fName, lName=:lName WHERE id=:id";
//		$sql = "DELETE FROM person WHERE id = :id";
//		
		
		preg_match('/^(SELECT|INSERT|UPDATE|DELETE)(.*)/', $sqlQuery, $matches);
		
		var_dump($matches);
		
		
		if(preg_match('/^SELECT(.*)/', $sqlQuery)) {
			return $this->select($values);
		} else if(preg_match('/^INSERT(.*)/', $sqlQuery)) {
			return $this->insert($values);
		} else if(preg_match('/^UPDATE(.*)/', $sqlQuery)) {
			return $this->update($values);
		} else if(preg_match('/^DELETE(.*)/', $sqlQuery)) {
			return $this->delete($values);
		}

		throw new DataBaseException( 'SQL QUERY parse error' );
	}
	
	protected function doResult() {	
		if(!$this->isResult())
			throw new DataBaseException( __METHOD__ );
	}
	
	private function findById($id) {
		if(isset($this->data[$id]))
			return array(array_merge(array('id'=>$id), $this->data[$id]));
		else
			return false;
	}

	private function findAll() {
		$res = array();
		reset($this->data);
		
		while (list($id, $val) = each($this->data))
			$res[] = array_merge(array('id'=>$id), $val);
		
		if(!empty($res))
			return $res;
		else
			return false;
	}

	private function select($val) {
		$searchId = (is_array($val) && isset($val['id'])) ? $val['id'] : NULL;
		
		if(is_null($searchId)) {
			$res = $this->findAll();
		} else {
			$res = $this->findById($searchId);
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
	
	private function insert($val) {
		$id = $this->lastInsertId++;
		
		$this->data[$id] = $val;
		$this->setLastInsertId($id);
		$this->setLastRowCount(1);
		$this->setResult(NULL);
	}
	
	private function update($val) {
		$updateId = $val['id'];
		
		if($this->findById($updateId) && array_diff($this->data[$updateId], $val)) {
			$this->data[$updateId] = $val;
			$this->setLastRowCount(1);
		} else {
			$this->setLastRowCount(0);
		}

		$this->setLastInsertId(NULL);
		$this->setResult(NULL);
	}
	
	private function delete($val) {
		$deleteId = $val['id'];
		
		if($this->findById($deleteId)) {
			unset($this->data[$deleteId]);
			$this->setLastRowCount(1);
		} else {
			$this->setLastRowCount(0);
		}
		
		$this->setLastInsertId(NULL);
		$this->setResult(NULL);
	}
}