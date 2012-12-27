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
	}
	
	public function testFindAllNoResult() {
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
	}
	
	public function testFindWrongId() {
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
		$this->assertEquals(3, $this->dba->getLastInsertId());
		$this->assertEquals(1, $this->dba->getLastRowCount());
		$this->setExpectedException('DataBaseException');
		$this->assertCount(1, $this->dba->result());
	}
	
	public function testUpdate() {
		$sql = "UPDATE person SET fName=:fName, lName=:lName WHERE id=:id";
		$val = array('id' => 1, 'fName' => 'testFName'.rand(), 'lName' => 'testLName'.rand());
		$this->dba->execute($sql, $val);
		$this->assertNull($this->dba->getLastInsertId());
		$this->assertEquals(1, $this->dba->getLastRowCount());
		$this->setExpectedException('DataBaseException');
		$this->assertCount(1, $this->dba->result());
	}
	
	public function testUpdateWrongId() {
		$sql = "UPDATE person SET fName=:fName, lName=:lName WHERE id=:id";
		$val = array('id' => 9999, 'fName' => 'testFName'.rand(), 'lName' => 'testLName'.rand());
		$this->dba->execute($sql, $val);
		$this->assertNull($this->dba->getLastInsertId());
		$this->assertEquals(0, $this->dba->getLastRowCount());
		$this->setExpectedException('DataBaseException');
		$this->assertCount(1, $this->dba->result());
	}
	
	public function testUpdateNoModify() {
		$sql = "UPDATE person SET fName=:fName, lName=:lName WHERE id=:id";
		$val = array('id' => 1, 'fName'=>'pier', 'lName'=>'pierwszy');
		$this->dba->execute($sql, $val);
		$this->assertNull($this->dba->getLastInsertId());
		$this->assertEquals(0, $this->dba->getLastRowCount());
		$this->setExpectedException('DataBaseException');
		$this->assertCount(1, $this->dba->result());
	}
	
	public function testDelete() {
		$sql = "DELETE FROM person WHERE id = :id";
		$val = array('id' => 1, 'fName'=>'pier', 'lName'=>'pierwszy');
		$this->dba->execute($sql, $val);
		$this->assertNull($this->dba->getLastInsertId());
		$this->assertEquals(0, $this->dba->getLastRowCount());
		$this->setExpectedException('DataBaseException');
		$this->assertCount(1, $this->dba->result());
	}
}