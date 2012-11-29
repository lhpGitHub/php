<?php
class PersonDAO {
	
	static private $instance;
	private $dbh;
	
	private function __construct() {
		try {
			$this->dbh = new PDO('mysql:host=localhost;dbname=mvc;charset=UTF-8', 'root', '');
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		} catch(PDOException $err) {
			throw new DomainException( __METHOD__ . ' ' . $err->getMessage());
		}
	}

	function __destruct() {
		$this->dbh = null;
	}

	static function getInstance() {
		if(!self::$instance)
			self::$instance = new self;
		
		return self::$instance;
	}

	function getAllPersons() {
		$stmt = $this->dbh->prepare("SELECT * FROM person ORDER BY id");
		return $this->getPersons($stmt); 
	}

	function getPersonById(PersonTO $personTO) {
		$stmt = $this->dbh->prepare("SELECT * FROM person WHERE id = :id");
		$person = $personTO->getIterator()->current();
		$stmt->bindParam(':id', $person['id']);
		return $this->getPersons($stmt);
	}
	
	private function getPersons($stmt) {
		try {
			$stmt->execute();
			$personTO = new PersonTO();
			
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
				$personTO->addPerson($row['id'], $row['fName'], $row['lName']);

			return $personTO;
			
		} catch(PDOException $err) {
			throw new DataBaseException( __METHOD__ . ' ' . $err->getMessage());
		}
	}

	function addPerson(PersonTO $personTO) {
		try {
			$stmt = $this->dbh->prepare("INSERT INTO person (fName, lName) VALUES (:fName, :lName)");
			$stmt->bindParam(':fName', $fName);
			$stmt->bindParam(':lName', $lName);

			$personIterator = $personTO->getIterator();

			foreach($personIterator as $person) {
				$fName = $person['fName'];
				$lName = $person['lName'];
				$stmt->execute();
			}

			return $stmt->rowCount();
			
		} catch(PDOException $err) {
			throw new DataBaseException( __METHOD__ . ' ' . $err->getMessage());
		}
	}

	function updatePerson(PersonTO $personTO) {
		try {
			$person = $personTO->getIterator()->current();
			$stmt = $this->dbh->prepare("UPDATE person SET fName=:fName, lName=:lName WHERE id=:id");
			$stmt->bindParam(':id', $person['id']);
			$stmt->bindParam(':fName', $person['fName']);
			$stmt->bindParam(':lName', $person['lName']);

			$stmt->execute();
			return $stmt->rowCount();
			
		} catch(PDOException $err) {
			throw new DataBaseException( __METHOD__ . ' ' . $err->getMessage());
		}
	}

	function removePerson(PersonTO $personTO) {
		try {
			$person = $personTO->getIterator()->current();
			$stmt = $this->dbh->prepare("DELETE FROM person WHERE id = :id");
			$stmt->bindParam(':id', $person['id']);

			$stmt->execute();
			return $stmt->rowCount();
			
		} catch(PDOException $err) {
			throw new DataBaseException( __METHOD__ . ' ' . $err->getMessage());
		}
	}

}