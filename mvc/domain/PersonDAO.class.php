<?php

class PersonDAO {
	
	static private $instance;
	private $dbh;
	
	private function __construct() {
		try {
			$this->dbh = new PDO('mysql:host=localhost;dbname=mvc;charset=UTF-8', 'root', '');
		} catch(PDOException $err) {
			throw new DomainException( __METHOD__ . ' ' . $err->getMessage());
		}
	}
	
	function __destruct() {
		$this->dbh = null;
	}


	function getInstance() {
		if(!self::$instance)
			self::$instance = new PersonDAO;
		
		return self::$instance;
	}
	
	function getPersons() {
		$stmt = $this->dbh->prepare("SELECT * FROM PERSON");
		
		if($stmt->execute()) {
			$personTO = new PersonTO();

			while ($row = $stmt->fetch())
				$personTO->addPerson($row[0], $row[1], $row[2]);

			return $personTO;
		} else {
			throw new DomainException( __METHOD__ . ' DB Error');
		}
	}
	
	function getPerson(PersonTO $personTO) {
		
	}
	
	function addPerson(PersonTO $personTO) {
		$stmt = $this->dbh->prepare("INSERT INTO person (fName, lName) VALUES (:fName, :lName)");
		$stmt->bindParam(':fName', $fName);
		$stmt->bindParam(':lName', $lName);
		
		$personIterator = $personTO->getIterator();
		
		foreach($personIterator as $person) {
			$fName = $person['fName'];
			$lName = $person['lName'];
			if(!$stmt->execute())
				throw new DomainException( __METHOD__ . ' DB Error');
		}
	}
	
	function updatePerson(PersonTO $personTO) {
		
	}
	
	function removePerson(PersonTO $personTO) {
		
	}
	
}

?>
