<?php
class DataBaseAccessMYSQLI extends DataBaseAccess {
	
	private $dbh;
	private $stmt;
	
	function __construct() {
		mysqli_report(MYSQLI_REPORT_STRICT);
	}
	
	function __destruct() {
		$this->dbh = null;
	}
	
	private function connect() {
		if(is_null($this->dbh)) {
			extract(Settings::dbSett());
			$this->dbh = new mysqli($host, $user, $pass, $db);
		}
	}

	protected function doExecute($sqlQuery, $values = null) {
		try {
			$this->connect();
			
			$sqlQuery = preg_replace('/:\w+/', '?', $sqlQuery);
			$stmt = $this->dbh->prepare($sqlQuery);
			if(!$stmt)
				throw new DataBaseException( __METHOD__ . ' ' . "Prepare failed: (" . $this->dbh->errno . ") " . $this->dbh->error);

			if(!$stmt->bind_param(.......))
				throw new DataBaseException( __METHOD__ . ' ' . "Binding parameters failed: (" . $this->dbh->errno . ") " . $this->dbh->error);
			
			if(!$stmt->execute())
				throw new DataBaseException( __METHOD__ . ' ' . "Execute failed: (" . $this->dbh->errno . ") " . $this->dbh->error);

			
//			if(is_array($values))
//				$stmt->execute($values);
//			else
//				$stmt->execute();
//			
//			$this->stmt = $stmt;
//			
//			$lastId = $this->dbh->lastInsertId();
//			if($lastId == 0) $lastId = NULL; 
//			$this->setLastInsertId($lastId);
//			$this->setLastRowCount($stmt->rowCount());

		} catch(mysqli_sql_exception $err) {
			throw new DataBaseException( __METHOD__ . ' ' . $err->getMessage());
		}
	}
	
	protected function doResult() {		
		try {
			//$this->setResult($this->stmt->fetchAll(PDO::FETCH_ASSOC));			
		} catch(PDOException $err) {
			throw new DataBaseException( __METHOD__ . ' ' . $err->getMessage());
		}
	}
}