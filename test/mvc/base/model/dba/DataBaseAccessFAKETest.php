<?php
require 'DataBaseAccessTest.php';

class DataBaseAccessFAKETest extends DataBaseAccessTest {

	public function __construct($name = NULL, array $data = array(), $dataName = '') {
		parent::__construct($name, $data, $dataName);
		Settings::$dataBaseAccessType = DataBaseAccessFactory::FAKE;
		
		$testData = array(1=>array('fName'=>'pier', 'lName'=>'pierwszy'));
		$testData[] = array('fName'=>'drug', 'lName'=>'drugi');
		
		parent::$dba = new DataBaseAccessFAKE();
		parent::$dba->loadData('person', $testData);
		
		$testDataEmpty = array();
		parent::$dba->loadData('personEmpty', $testDataEmpty);
	}
}