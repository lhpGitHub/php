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

	function getAllPersons() {
		$stmt = $this->dbh->prepare("SELECT * FROM PERSON");
		return $this->getPersons($stmt);
	}

	function getPersonById(PersonTO $personTO) {
		$stmt = $this->dbh->prepare("SELECT * FROM PERSON WHERE id = :id");
		$person = $personTO->getIterator()->current();
		$stmt->bindParam(':id', $person['id']);
		return $this->getPersons($stmt);
	}
	
	private function getPersons($stmt) {
		if($stmt->execute()) {
			$personTO = new PersonTO();

			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
				$personTO->addPerson($row['id'], $row['fName'], $row['lName']);

			return $personTO;
		} else {
			throw new DomainException( __METHOD__ . ' DB Error');
		}
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