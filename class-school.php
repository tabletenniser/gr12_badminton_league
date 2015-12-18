<?php

class School {
	public $id, $name;
	
	function School($id, $name) {
		$this->id = $id;
		$this->name = $name;
	}
	
	function getName() {
		return $this->name;
	}
	
	function getID() {
		return $this->id;
	}
	
	function __toString() {
		return $this->name;
	}
	
}

class SchoolList {
	private $schools;
	
	function addSchool(School $s) {
		array_push($this->schools, $s);
	}
	
	function __toString() {
		$s = "";
		foreach($this->schools as $school) {
			$s .= $school;
		}
		return $s;
	}
	
}
?>