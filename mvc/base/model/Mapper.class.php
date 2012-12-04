<?php
abstract class Mapper {
	
	protected $dba;
	
	function __construct(DataBaseAccess $dba) {
		$this->dba = $dba;
	}
	
	abstract function find($id);
	abstract function findAll();
	abstract function createObject(array $raw);
	abstract function insert(DomainObject $dmObj);
	abstract function update(DomainObject $dmObj);
	abstract function delete($id);
}