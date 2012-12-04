<?php
class PersonMapper extends Mapper {
	
	function __construct(DataBaseAccess $dba) {
		parent::__construct($dba);
	}
	
	function find($id) {
		$sql = "SELECT * FROM person WHERE id = :id";
		$value = array('id' => $id);
		$this->dba->execute($sql, $value);
		
		if($this->dba->getLastRowCount() === 1) {
			$res = $this->dba->getResult();
			return $this->createObject($res[0]);
		} else {
			return NULL;
		}
	}
	
	function findAll() {
		$sql = "SELECT * FROM person ORDER BY id";
		$this->dba->execute($sql);
		
		if($this->dba->getLastRowCount() > 0) {
			$collection = new PersonCollection();
			
			foreach($this->dba->getResult() as $raw)
				$collection->add($this->createObject($raw));

			return $collection;
			
		} else {
			return NULL;
		}
	}
	
	function createObject(array $raw) {
		$obj = new PersonObject();
		$obj->id = $raw['id'];
		$obj->fName = $raw['fName'];
		$obj->lName = $raw['lName'];
		
		return $obj;
	}
	
	function insert(DomainObject $dmObj) {
		
	}
	
	function update(DomainObject $dmObj) {
		
	}
	
	function delete($id) {
		
	}
	
}