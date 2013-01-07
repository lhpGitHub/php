<?php
class DataBaseAccessMYSQLI extends DataBaseAccess {
	
	private $dbh;
	private $stmt;
	
	function __construct() {
		mysqli_report(MYSQLI_REPORT_STRICT);
	}
	
	function __destruct() {
		if($this->dbh)
			$this->dbh->close();
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
			$this->statementClose();
			
			$sqlQuery = preg_replace('/:\w+/', '?', $sqlQuery);
			$this->stmt = $this->dbh->prepare($sqlQuery);
			
			if(!$this->stmt)
				throw new DataBaseException( __METHOD__ . ' ' . "Prepare failed: (" . $this->dbh->errno . ") " . $this->dbh->error);

			if(!$this->bindParams($values))
				throw new DataBaseException( __METHOD__ . ' ' . "Binding parameters failed: (" . $this->dbh->errno . ") " . $this->dbh->error . " types: " . $types);
			
			if(!$this->stmt->execute())
				throw new DataBaseException( __METHOD__ . ' ' . "Execute failed: (" . $this->dbh->errno . ") " . $this->dbh->error);
			
			
			
			>> tu, znalezc sposob na dynamiczny odczyt wynikow za pomoca metody fetch()
			$this->stmt->store_result();
			var_dump($this->stmt->fetch());
			
			
			
			
			$lastId = $this->dbh->insert_id;
			if($lastId == 0) $lastId = NULL; 
			$this->setLastInsertId($lastId);
			
			//$lastRowCount = $this->stmt->num_rows;
			$lastRowCount = $this->stmt->affected_rows;
			if($lastRowCount < 0) $lastRowCount = 0;
			$this->setLastRowCount($lastRowCount);
			
		} catch(mysqli_sql_exception $err) {
			throw new DataBaseException( __METHOD__ . ' ' . $err->getMessage());
		}
	}
	
	protected function doResult() {		
		
		if($result = $this->stmt->get_result()) {
			$this->setResult($result->fetch_all(MYSQLI_ASSOC));
			$result->free();
		}
		
		$this->statementClose();
			
		if(!$result)
			throw new DataBaseException( __METHOD__ . " Getting result set failed.");
	}

	private function bindParams($values) {
		if(is_array($values)) {
			$bind_params = array();
			$types = $this->getParamsTypes($values);
			$bind_params[] = $types;

			foreach($values as $key => $value) {
				$bind_params[] = &$values[$key];
			}

			if(!call_user_func_array(array($this->stmt,'bind_param'), $bind_params))	
				return false;
		}
		
		return true;
	}


	private function statementClose() {
		if($this->stmt) {
			$this->stmt->free_result();
			$this->stmt->close();
			$this->stmt = null;
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