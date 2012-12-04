<?php
class PersonCollection extends Collection {
	
	protected function getMyClass() {
		return __CLASS__;
	}
	
	protected function getTargetClass() {
		return 'PersonObject';
	}
	
}