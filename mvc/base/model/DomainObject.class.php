<?php
abstract class DomainObject {
	static function getCollection(array $raw = null, Mapper $mapper = null);
}