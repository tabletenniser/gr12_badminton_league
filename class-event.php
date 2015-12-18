<?php

/**
 * Event stores data pertaining to a certain Event ex. Girls Single
 */

class Event {
	private $level, $gender, $name, $numPlayers;
	function Event($name, $gender, $numPlayers) {
		$this->level = $level;
		$this->name = $name;
		$this->gender = $gender;
		$this->numPlayers = $numPlayers;
	}
	
	function getGender() {
		return $this->gender;
	}
	
	function getName() {
		return $this->name;
	}
	
	function getNumPlayers() {
		return $this->numPlayers;
	}
	
	function getAbbrev() {
		switch($this->gender) {
			case 'M':
				$s = 'b';
				break;
			case 'F':
				$s = 'g';
				break;
			default:
				$s = 'm';
				break;
		}
		
		if($this->numPlayers > 1) {
			return $s . 'd';
		} else {
			return $s . 's';
		}
		
	}
	function __toString() {
		return $this->getName();
	}
}

//Create an array of Events.

$events = array(
	new Event("Boys Singles", 'M', 1),
	new Event("Girls Singles", 'F', 1),
	new Event("Boys Doubles", 'M', 2),
	new Event("Girls Doubles", 'F', 2),
	new Event("Mixed Doubles", 'B', 2)
);

?>