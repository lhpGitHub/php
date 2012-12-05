<?php
class DataBaseAccessPDO extends DataBaseAccess {
	
	private $dbh;
	private $stmt;
	
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
			
			$this->stmt = $stmt;
			$this->setLastInsertId($this->dbh->lastInsertId());
			$this->setLastRowCount($stmt->rowCount());
			$this->clearResult();

		} catch(PDOException $err) {
			throw new DataBaseException( __METHOD__ . ' ' . $err->getMessage());
		}
	}
	
	function getResult($clearResult = true) {		
		try {
			$res = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
			if(!empty($res)) $this->setResult($res);
			
		} catch(PDOException $err) {
			throw new DataBaseException( __METHOD__ . ' ' . $err->getMessage());
		}
		
		return parent::getResult($clearResult);
	}
}