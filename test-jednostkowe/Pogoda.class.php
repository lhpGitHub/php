<?php
class Pogoda {

	function deszcz() {
		$this->snieg();
		return true;
	}
	
	function snieg() {
		return false;
	}
	
	function temperatura($val) {
		return $val*2;
	}
	
}