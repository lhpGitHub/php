<?php
abstract class Collection implements Iterator {
	
	private $obj = array(),
			$cursor = 0;
	
	protected abstract function getMyClass();
	protected abstract function getTargetClass();
	
	function add(DomainObject $obj) {
		$class = $this->getTargetClass();
		if($obj instanceof $class)
			$this->obj[] = $obj;
		else
			throw new InvalidCollectionElementException('attempted add Element:'.get_class($obj).' to Collection:'.$this->getMyClass());
	}
	
	private function getRow($index) {
		if(isset($this->obj[$index]))
			return $this->obj[$index];
		else
			return NULL;
	} 

	function current() {
		return $this->getRow($this->cursor);
	}
	
	function key() {
		return $this->cursor;
	}

	function next() {
		$row = $this->current();
		$this->cursor++;
		return $row;
	}
	
	function rewind() {
		$this->cursor = 0;
	}
	
	function valid() {
		return (!is_null($this->current()));
	}
}