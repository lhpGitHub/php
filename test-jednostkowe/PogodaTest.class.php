<?php

class PogodaTest extends PHPUnit_Framework_TestCase {

	private $pogoda;
	
	function setUp() {
		parent::setUp();
		$this->pogoda = new Pogoda();
	}
	
	function tearDown() {
		parent::tearDown();
	}
	
	function testDeszcz() {
		$expected = true;
		$received = $this->pogoda->deszcz();
		$this->assertEquals($expected, $received);
	}
}