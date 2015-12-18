<?php

/**
 * Shows a dropdown of players matching a specific gender from a specific school.
 */
 
function showPlayersDropdown($selectName, $gender, $schoolID) {
	if($gender == 'B') {
		$rs = mysql_query("SELECT * FROM player WHERE school_id=$schoolID");
	} else {
		$rs = mysql_query("SELECT * FROM player WHERE gender='$gender' AND school_id=$schoolID");
	}
	if(mysql_num_rows($rs) == 0) {
		echo "-no players available-";
		return false;
	} else  {
		echo "<select name='$selectName'>";
		while($row = mysql_fetch_object($rs)) {
			echo "<option value='$row->id'>$row->name</option>";
		}
		echo "</select>";
		return true;
	}
}

/**
 * Shows a dropdown of scores depending on leve.
 */

function showScoreDropdown($selectName, $level) {
	echo "<select name='$selectName'>";
	echo "<option value='0'>0</option>";
	echo "<option value='1'>1</option>";
	if($level == 'A') {
		echo "<option value='4'>4</option>";
	} else {
		echo "<option value='2'>2</option>";
	}
	echo "</select>";
}

/**
 * Shows the score associated with $scoreID.
 */

function showScore($scoreID) {
	if($scoreID == null) {
		echo "-no data-";
		return;
	}
	$rs = mysql_query("SELECT * FROM score WHERE id=$scoreID");
	$row = mysql_fetch_object($rs);
	echo $row->points;
}

/**
 * Shows the players associated with $scoreID.
 */

function showPlayers($scoreID) {
	if($scoreID == null) {
		echo "-no data-";
		return;
	}
	$rs = mysql_query("SELECT name FROM player JOIN player_score ON player_id=player.id WHERE score_id=$scoreID") or die(mysql_error());
	while($row = mysql_fetch_object($rs)) {
		echo $row->name . "<br />";
	}
}

/**
 * Returns an object containing information of the score record that matches the criteria specified: school1, school2, level and event.
 */

function fetchScore($school1ID, $school2ID, $level, $event) {
	$rs = mysql_query("SELECT id FROM score WHERE school_id=$school1ID AND opponent_id=$school2ID AND level='$level' AND event='$event'");
	if(mysql_num_rows($rs) > 0) {
		$score = mysql_fetch_object($rs);
	} else {
		$score = null;
	}
	return $score;
}

?>