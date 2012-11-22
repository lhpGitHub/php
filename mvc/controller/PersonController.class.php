<?php
class PersonController {
	
	function do_create(array $params) {
		$personTO = new PersonTO();
		
		$this->validateParams();
		
		
		$personTO->addPerson(null, $params[0], $params[1]);
		
		$dao = PersonDAO::getInstance();
		$dao->addPerson($personTO);
	}
	
	function do_read(array $params) {
		$dao = PersonDAO::getInstance();
		$personIterator = $dao->getPersons()->getIterator();
		$viewManager = new ViewManager;
		
		foreach($personIterator as $person)
			$viewManager->bindView('personListItem', array('id'=>$person['id'], 'fName'=>$person['fName'], 'lName'=>$person['lName']));
		
		$viewManager->render();
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