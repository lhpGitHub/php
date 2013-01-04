<?php

class DataBaseAccessTest extends PHPUnit_Framework_TestCase {

	protected static $dba;
	private static $lastInsertId;


	public function __construct($name = NULL, array $data = array(), $dataName = '') {
		parent::__construct($name, $data, $dataName);
		Settings::$mode = Settings::DEVE;
	}
	
	public function __destruct() {
		self::$dba = null;
	}

	protected function setUp() {
	}

	protected function tearDown() {
	}
	
	public function testInsert() {
		$sql = "INSERT INTO person (fName, lName) VALUES (:fName, :lName)";
		$val = array('fName' => 'testFName', 'lName' => 'testLNAME');
		self::$dba->execute($sql, $val);
		self::$lastInsertId = self::$dba->getLastInsertId();
		
		$this->assertGreaterThanOrEqual(1, self::$dba->getLastInsertId());
		$this->assertEquals(1, self::$dba->getLastRowCount());
		$this->setExpectedException('DataBaseException');
		$this->assertCount(1, self::$dba->result());
	}

	public function testFindAll() {
		$sql = 'SELECT * FROM person';
		self::$dba->execute($sql);
		$this->assertNull(self::$dba->getLastInsertId());
		$this->assertGreaterThanOrEqual(1, self::$dba->getLastRowCount());
		$this->assertGreaterThanOrEqual(1, self::$dba->result());
	}
	
	public function testFindAllNoResult() {
		$sql = 'SELECT * FROM personEmpty';
		self::$dba->execute($sql);
		$this->assertNull(self::$dba->getLastInsertId());
		$this->assertEquals(0, self::$dba->getLastRowCount());
		$this->assertCount(0, self::$dba->result());
	}
	
	public function testFind() {
		$sql = 'SELECT * FROM person WHERE id = :id';
		$val = array('id' => self::$lastInsertId);
		self::$dba->execute($sql, $val);
		$this->assertNull(self::$dba->getLastInsertId());
		$this->assertEquals(1, self::$dba->getLastRowCount());
		$this->assertCount(1, self::$dba->result());
	}
	
	public function testFindWrongId() {
		$sql = 'SELECT * FROM person WHERE id = :id';
		$val = array('id' => 9999);
		self::$dba->execute($sql, $val);
		$this->assertNull(self::$dba->getLastInsertId());
		$this->assertEquals(0, self::$dba->getLastRowCount());
		$this->assertCount(0, self::$dba->result());
	}
	
	public function testUpdate() {
		$sql = "UPDATE person SET fName=:fName, lName=:lName WHERE id=:id";
		$val = array('id' => self::$lastInsertId, 'fName' => 'testFName'.rand(), 'lName' => 'testLName'.rand());
		self::$dba->execute($sql, $val);
		$this->assertNull(self::$dba->getLastInsertId());
		$this->assertEquals(1, self::$dba->getLastRowCount());
		$this->setExpectedException('DataBaseException');
		$this->assertCount(1, self::$dba->result());
	}
	
	public function testUpdateWrongId() {
		$sql = "UPDATE person SET fName=:fName, lName=:lName WHERE id=:id";
		$val = array('id' => 9999, 'fName' => 'testFName'.rand(), 'lName' => 'testLName'.rand());
		self::$dba->execute($sql, $val);
		$this->assertNull(self::$dba->getLastInsertId());
		$this->assertEquals(0, self::$dba->getLastRowCount());
		$this->setExpectedException('DataBaseException');
		$this->assertCount(1, self::$dba->result());
	}
	
	public function testUpdateNoModify() {
		$sql = "UPDATE person SET fName=:fName, lName=:lName WHERE id=:id";
		$val = array('id' => self::$lastInsertId, 'fName'=>'pier', 'lName'=>'pierwszy');
		self::$dba->execute($sql, $val);
		$this->assertNull(self::$dba->getLastInsertId());
		$this->assertEquals(1, self::$dba->getLastRowCount());
		$this->setExpectedException('DataBaseException');
		$this->assertCount(1, self::$dba->result());
	}
	
	public function testDelete() {
		$sql = "DELETE FROM person WHERE id = :id";
		$val = array('id' => self::$lastInsertId);
		self::$dba->execute($sql, $val);
		$this->assertNull(self::$dba->getLastInsertId());
		$this->assertEquals(1, self::$dba->getLastRowCount());
		$this->setExpectedException('DataBaseException');
		$this->assertCount(1, self::$dba->result());
	}
	
	public function testDeleteWrongId() {
		$sql = "DELETE FROM person WHERE id = :id";
		$val = array('id' => 9999);
		self::$dba->execute($sql, $val);
		$this->assertNull(self::$dba->getLastInsertId());
		$this->assertEquals(0, self::$dba->getLastRowCount());
		$this->setExpectedException('DataBaseException');
		$this->assertCount(1, self::$dba->result());
	}
}