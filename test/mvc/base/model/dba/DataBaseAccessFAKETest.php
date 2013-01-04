<?php
require 'DataBaseAccessTest.php';

class DataBaseAccessFAKETest extends DataBaseAccessTest {

	public function __construct($name = NULL, array $data = array(), $dataName = '') {
		parent::__construct($name, $data, $dataName);
		parent::$dba = new DataBaseAccessFAKE();
		
		$testData = array(1=>array('fName'=>'pier', 'lName'=>'pierwszy'));
		$testData[] = array('fName'=>'drug', 'lName'=>'drugi');
		parent::$dba->loadData('person', $testData);
		
		$testDataEmpty = array();
		parent::$dba->loadData('personEmpty', $testDataEmpty);
	}
}