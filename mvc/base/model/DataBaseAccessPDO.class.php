<?php
class DataBaseAccessPDO extends DataBaseAccess {
	
	private $dbh;
	private $stmt;
	
	function __destruct() {
		$this->dbh = null;
	}
	
	private function connect() {
		if(is_null($this->dbh)) {
			extract(Settings::dbSett());
			$this->dbh = new PDO("$type:host=$host;dbname=$db;charset=UTF-8", $user, $pass);
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	}

	function execute($sqlQuery, $values = null) {
		try {
			$this->connect();
			$stmt = $this->dbh->prepare($sqlQuery);
			
			//printf("SQL QUERY: %s, / params: %s<br>", $stmt->queryString, print_r($values, true));
			
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