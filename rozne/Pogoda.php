<?php
class Pogoda {

	function deszcz() {
		return true;
	}
	
	function snieg() {
		return false;
	}
	
	function temperatura($val) {
		return $val*2;
	}
	
}