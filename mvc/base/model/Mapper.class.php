<?php
abstract class Mapper {
	
	protected $dba;
	
	function __construct(DataBaseAccess $dba) {
		$this->dba = $dba;
	}
	
	abstract function findAll();
	abstract protected function doFindObject($id);
	abstract protected function doCreateObject(array $raw);
	abstract protected function doInsert(DomainObject $dmObj);
	abstract protected function doUpdate(DomainObject $dmObj);
	abstract protected function doDelete($id);
	abstract protected function getTargetClass();
	
	function find($id) {
		$dmObj = DomainObjectWatcher::getObject($this->getTargetClass(), $id);
		
		if(is_null($dmObj)) {
			$dmObj = $this->doFindObject($id);
			if(!is_null($dmObj)) DomainObjectWatcher::addObject($dmObj);
		}
		
		return $dmObj;
	}
	
	function createObject(array $raw) {
		
		$dmObj = DomainObjectWatcher::getObject($this->getTargetClass(), $raw['id']);
		
		if(is_null($dmObj)) {
			$dmObj = $this->doCreateObject($raw);
			DomainObjectWatcher::addObject($dmObj);
		}
		
		return $dmObj;
	}
	
	function insert(DomainObject $dmObj) {
		DomainObjectWatcher::addObject($dmObj);
		DomainObjectWatcher::addClean($dmObj);
		return $this->doInsert($dmObj);
	}
	
	function update(DomainObject $dmObj) {
		DomainObjectWatcher::addClean($dmObj);
		return $this->doUpdate($dmObj);
	}
	
	function delete($id) {
		DomainObjectWatcher::removeObject($this->getTargetClass(), $id);
		DomainObjectWatcher::addClean($dmObj);
		return $this->doDelete($id);
	}
}