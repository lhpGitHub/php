<?php
class DataBaseAccessFAKE extends DataBaseAccess {
	
	private $lastInsertId = 0;
	private $data;

	function loadData(&$data) {
		$this->data = &$data;
		$this->lastInsertId = count($this->data);
	}
	
	function __destruct() {}

	protected function doExecute($sqlQuery, $values = null) {
		$this->clearBuffer();
		
		if(preg_match('/^SELECT(.)?/', $sqlQuery))
			$this->select($values);
		else if(preg_match('/^INSERT(.)?/', $sqlQuery))
			$this->insert($values);
		else if(preg_match('/^UPDATE(.)?/', $sqlQuery))
			$this->update($values);
		else if(preg_match('/^DELETE(.)?/', $sqlQuery))
			$this->delete($values);

	}
	
	protected function doResult() {		
		
	}
	
	private function findById($id) {
		if(isset($this->data[$id]))
			return array(array_merge(array('id'=>$id), $this->data[$id]));
		else
			return NULL;
	}

	private function findAll() {
		$res = array();
		
		while (list($id, $val) = each($this->data))
			$res[] = array_merge(array('id'=>$id), $val);
		
		if(!empty($res))
			return $res;
		else
			return NULL;
	}

	private function select($val) {
		$searchId = (is_array($val) && isset($val['id'])) ? $val['id'] : NULL;
		
		if(is_null($searchId)) {
			$res = $this->findAll();
		} else {
			$res = $this->findById($searchId);
		}
		
		if(is_null($res)) {
			$this->setLastRowCount(0);
		} else {
			$this->setLastRowCount(count($res));
			$this->setResult($res);
		}
	}
	
	private function insert($val) {
		$id = $this->lastInsertId++;
		
		$this->data[$id] = $val;
		$this->setLastInsertId($id);
		$this->setLastRowCount(1);
	}
	
	private function update($val) {
		$updateId = $val['id'];
		
		if(!is_null($this->findById($updateId))) {
			$this->data[$updateId] = $val;
			$this->setLastRowCount(1);
		}
	}
	
	private function delete($val) {
		$deleteId = $val['id'];
		
		if(!is_null($this->findById($deleteId))) {
			unset($this->data[$deleteId]);
			$this->setLastRowCount(1);
		}
	}
}