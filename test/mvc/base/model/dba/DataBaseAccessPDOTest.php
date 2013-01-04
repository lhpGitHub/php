<?php

/*--
-- Database: `mvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fName` text COLLATE macce_bin,
  `lName` text COLLATE macce_bin,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=macce COLLATE=macce_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `personempty`
--

CREATE TABLE IF NOT EXISTS `personempty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fName` text COLLATE macce_bin,
  `lName` text COLLATE macce_bin,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=macce COLLATE=macce_bin AUTO_INCREMENT=1 ;*/

require 'DataBaseAccessTest.php';

class DataBaseAccessPDOTest extends DataBaseAccessTest {

	public function __construct($name = NULL, array $data = array(), $dataName = '') {
		parent::__construct($name, $data, $dataName);
		Settings::$dataBaseAccessType = DataBaseAccessFactory::PDO;
		parent::$dba = new DataBaseAccessPDO();
	}
}