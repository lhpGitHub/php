<?php

class PogodaTest extends TestCase {

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