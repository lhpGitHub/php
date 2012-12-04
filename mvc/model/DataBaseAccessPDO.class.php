<?php
class DataBaseAccessPDO extends DataBaseAccess {
	
	private $dbh;
	
	function __construct() {
		try {
			$this->dbh = new PDO('mysql:host=localhost;dbname=mvc;charset=UTF-8', 'root', '');
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		} catch(PDOException $err) {
			throw new DataBaseException( __METHOD__ . ' ' . $err->getMessage());
		}
	}

	function __destruct() {
		$this->dbh = null;
	}
	
	function execute($sqlQuery, $values = null) {
		try {
			
			$stmt = $this->dbh->prepare($sqlQuery);
			
			if(is_array($values))
				$stmt->execute($values);
			else
				$stmt->execute();
			
			$this->setLastInsertId($this->dbh->lastInsertId());
			$this->setLastRowCount($stmt->rowCount());
			$this->setResult($stmt->fetchAll(PDO::FETCH_ASSOC));

		} catch(PDOException $err) {
			throw new DataBaseException( __METHOD__ . ' ' . $err->getMessage());
		}
	}
}