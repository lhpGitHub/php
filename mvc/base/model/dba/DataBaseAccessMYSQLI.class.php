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

			if(is_array($values)) {
				
				$types = $this->getParamsTypes($values);
				$bind_params[] = $types;
				foreach($values as &$value)
					$bind_params[] = $value;
				
				var_dump($bind_params);
				 
				if(call_user_func_array(array($stmt,'bind_param'), $bind_params))	
					throw new DataBaseException( __METHOD__ . ' ' . "Binding parameters failed: (" . $this->dbh->errno . ") " . $this->dbh->error). " types: " . $types;
			}
			
			if(!$stmt->execute())
				throw new DataBaseException( __METHOD__ . ' ' . "Execute failed: (" . $this->dbh->errno . ") " . $this->dbh->error);
			
			$this->stmt = $stmt;
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
	
	private function getParamsTypes(array $params) {
		$res = '';
		
		foreach($params as $val) {
			switch (gettype($val)) {
				case 'integer':
					$res .= 'i';
					break;

				case 'double':
				case 'float':
					$res .= 'd';
					break;
				
				case 'string':
					$res .= 's';
					break;
				
				default:
					$res .= '-undefined-';
					break;
			}
		}
		
		return $res;
	}
}