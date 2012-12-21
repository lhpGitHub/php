<?php

class DataBaseAccessTest extends PHPUnit_Framework_TestCase {

	protected $dba;
	
	public function __construct($name = NULL, array $data = array(), $dataName = '') {
		parent::__construct($name, $data, $dataName);
		Settings::$mode = Settings::DEVE;
	}
	
	public function __destruct() {
		$this->dba = null;
	}

	protected function setUp() {
	}

	protected function tearDown() {
	}

	public function testFindAll() {
		$sql = 'SELECT * FROM person';
		$this->dba->execute($sql);
		$this->assertNull($this->dba->getLastInsertId());
		$this->assertEquals(2, $this->dba->getLastRowCount());
		$this->assertCount(2, $this->dba->result());
		
		$sql = 'SELECT * FROM personEmpty';
		$this->dba->execute($sql);
		$this->assertNull($this->dba->getLastInsertId());
		$this->assertEquals(0, $this->dba->getLastRowCount());
		$this->assertCount(0, $this->dba->result());
	}
	
	public function testFind() {
		$sql = 'SELECT * FROM person WHERE id = :id';
		$val = array('id' => 1);
		$this->dba->execute($sql, $val);
		$this->assertNull($this->dba->getLastInsertId());
		$this->assertEquals(1, $this->dba->getLastRowCount());
		$this->assertCount(1, $this->dba->result());
		
		$sql = 'SELECT * FROM person WHERE id = :id';
		$val = array('id' => 9999);
		$this->dba->execute($sql, $val);
		$this->assertNull($this->dba->getLastInsertId());
		$this->assertEquals(0, $this->dba->getLastRowCount());
		$this->assertCount(0, $this->dba->result());
	}
	
	public function testInsert() {
		$sql = "INSERT INTO person (fName, lName) VALUES (:fName, :lName)";
		$val = array('fName' => 'testFName', 'lName' => 'testLNAME');
		$this->dba->execute($sql, $val);
		//$this->assertNull($this->dba->getLastInsertId());
		//$this->assertEquals(1, $this->dba->getLastRowCount());
		//$this->assertCount(1, $this->dba->result());
	}
}