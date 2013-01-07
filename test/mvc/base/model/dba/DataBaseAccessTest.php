<?php

class DataBaseAccessTest extends PHPUnit_Framework_TestCase {

	protected static $dba;
	private static $firstRecordId;
	private static $secondRecordId;
	private static $thridRecordId;


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
	
	public function testInsertFirstRecord() {
		$sql = "INSERT INTO personTest (fName, lName) VALUES (:fName, :lName)";
		$val = array('fName' => 'first', 'lName' => 'test');
		self::$dba->execute($sql, $val);
		self::$firstRecordId = self::$dba->getLastInsertId();
		
		$this->assertGreaterThanOrEqual(1, self::$dba->getLastInsertId());
		$this->assertEquals(1, self::$dba->getLastRowCount());
		$this->setExpectedException('DataBaseException');
		$this->assertCount(1, self::$dba->result());
	}
	
	public function testInsertSecondRecord() {
		$sql = "INSERT INTO personTest (fName, lName) VALUES (:fName, :lName)";
		$val = array('fName' => 'second', 'lName' => 'test');
		self::$dba->execute($sql, $val);
		self::$secondRecordId = self::$dba->getLastInsertId();
		
		$this->assertGreaterThanOrEqual(1, self::$dba->getLastInsertId());
		$this->assertEquals(1, self::$dba->getLastRowCount());
		$this->setExpectedException('DataBaseException');
		$this->assertCount(1, self::$dba->result());
	}
	
	public function testInsertThridRecord() {
		$sql = "INSERT INTO personTest (fName, lName) VALUES (:fName, :lName)";
		$val = array('fName' => 'thrid', 'lName' => 'test');
		self::$dba->execute($sql, $val);
		self::$thridRecordId = self::$dba->getLastInsertId();
		
		$this->assertGreaterThanOrEqual(1, self::$dba->getLastInsertId());
		$this->assertEquals(1, self::$dba->getLastRowCount());
		$this->setExpectedException('DataBaseException');
		$this->assertCount(1, self::$dba->result());
	}

	public function testFindAll() {
		$sql = 'SELECT * FROM personTest';
		self::$dba->execute($sql);
		$this->assertNull(self::$dba->getLastInsertId());
		$this->assertGreaterThanOrEqual(3, self::$dba->getLastRowCount());
		$this->assertGreaterThanOrEqual(3, self::$dba->result());
	}
//	
//	public function testFindAllNoResult() {
//		$sql = 'SELECT * FROM personEmpty';
//		self::$dba->execute($sql);
//		$this->assertNull(self::$dba->getLastInsertId());
//		$this->assertEquals(0, self::$dba->getLastRowCount());
//		$this->assertCount(0, self::$dba->result());
//	}
//	
//	public function testFind() {
//		$sql = 'SELECT * FROM personTest WHERE id = :id';
//		$val = array('id' => self::$firstRecordId);
//		self::$dba->execute($sql, $val);
//		$this->assertNull(self::$dba->getLastInsertId());
//		$this->assertEquals(1, self::$dba->getLastRowCount());
//		$this->assertCount(1, self::$dba->result());
//	}
//	
//	public function testFindWrongId() {
//		$sql = 'SELECT * FROM personTest WHERE id = :id';
//		$val = array('id' => 9999);
//		self::$dba->execute($sql, $val);
//		$this->assertNull(self::$dba->getLastInsertId());
//		$this->assertEquals(0, self::$dba->getLastRowCount());
//		$this->assertCount(0, self::$dba->result());
//	}
//	
	public function testUpdate() {
		$sql = "UPDATE personTest SET fName=:fName, lName=:lName WHERE id=:id";
		$val = array('fName' => rand(), 'lName' => rand(), 'id' => self::$firstRecordId);
		self::$dba->execute($sql, $val);
		$this->assertNull(self::$dba->getLastInsertId());
		$this->assertEquals(1, self::$dba->getLastRowCount());
		$this->setExpectedException('DataBaseException');
		$this->assertCount(1, self::$dba->result());
	}
	
	public function testUpdateWrongId() {
		$sql = "UPDATE personTest SET fName=:fName, lName=:lName WHERE id=:id";
		$val = array('fName' => rand(), 'lName' => rand(), 'id' => 9999);
		self::$dba->execute($sql, $val);
		$this->assertNull(self::$dba->getLastInsertId());
		$this->assertEquals(0, self::$dba->getLastRowCount());
		$this->setExpectedException('DataBaseException');
		$this->assertCount(1, self::$dba->result());
	}
	
	public function testUpdateNoModify() {
		$sql = "UPDATE personTest SET fName=:fName, lName=:lName WHERE id=:id";
		$val = array('fName'=>'second', 'lName'=>'test', 'id' => self::$secondRecordId);
		self::$dba->execute($sql, $val);
		$this->assertNull(self::$dba->getLastInsertId());
		$this->assertEquals(0, self::$dba->getLastRowCount());
		$this->setExpectedException('DataBaseException');
		$this->assertCount(1, self::$dba->result());
	}
	
	public function testUpdateTwoRecords() {
		$sql = "UPDATE personTest SET fName=:fName WHERE lName=:lName";
		$val = array('fName'=>'udpate two record', 'lName'=>'test');
		self::$dba->execute($sql, $val);
		$this->assertNull(self::$dba->getLastInsertId());
		$this->assertEquals(2, self::$dba->getLastRowCount());
		$this->setExpectedException('DataBaseException');
		$this->assertCount(1, self::$dba->result());
	}
	
	public function testDelete() {
		$sql = "DELETE FROM personTest WHERE id = :id";
		$val = array('id' => self::$firstRecordId);
		self::$dba->execute($sql, $val);
		$this->assertNull(self::$dba->getLastInsertId());
		$this->assertEquals(1, self::$dba->getLastRowCount());
		$this->setExpectedException('DataBaseException');
		$this->assertCount(1, self::$dba->result());
	}
	
	public function testDeleteWrongId() {
		$sql = "DELETE FROM personTest WHERE id = :id";
		$val = array('id' => 9999);
		self::$dba->execute($sql, $val);
		$this->assertNull(self::$dba->getLastInsertId());
		$this->assertEquals(0, self::$dba->getLastRowCount());
		$this->setExpectedException('DataBaseException');
		$this->assertCount(1, self::$dba->result());
	}
	
	public function testDeleteTwoRecords() {
		$sql = "DELETE FROM personTest WHERE lName=:lName";
		$val = array('lName' => 'test');
		self::$dba->execute($sql, $val);
		$this->assertNull(self::$dba->getLastInsertId());
		$this->assertEquals(2, self::$dba->getLastRowCount());
		$this->setExpectedException('DataBaseException');
		$this->assertCount(1, self::$dba->result());
	}
}