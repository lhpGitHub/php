<?php
class PersonCollection extends Collection {
	
	function __construct(array $raw = null, Mapper $mapper = null) {
		parent::__construct($raw, $mapper);
	}

	protected function getMyClass() {
		return __CLASS__;
	}
	
	protected function getTargetClass() {
		return 'PersonObject';
	}
	
}