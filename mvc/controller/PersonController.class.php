<?php

class PersonController extends BaseController {
	
	function do_create(array $params) {
		$personTO = new PersonTO();
		
		$this->validateParams();
		
		
		$personTO->addPerson(null, $params[0], $params[1]);
		
		$dao = PersonDAO::getInstance();
		$dao->addPerson($personTO);
	}
	
	function do_read(array $params) {
		$dao = PersonDAO::getInstance();
		$personTO = $dao->getPersons();
		$personIterator = $personTO->getIterator();
		$views = array();
		
		foreach($personIterator as $person)
			$views[] = $this->getView('personListItem', array('id'=>$person['id'], 'fName'=>$person['fName'], 'lName'=>$person['lName']));
		
		$this->render($views);
	}
	
	function do_update(array $params) {
		echo __METHOD__;
		print_r($params);
	}
	
	function do_delete(array $params) {
		echo __METHOD__;
		print_r($params);
	}
	
	private function validateParams() {
		echo 'TODO > '.__METHOD__;
	}
		
}

?>
