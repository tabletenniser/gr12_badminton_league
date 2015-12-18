<?php

function showHeader($plain = false) {
	if($plain) {
		require_once("header_wide.php");
	} else {
		require_once("header.php");
	}
}

function showFooter($plain = false) {
	if($plain) {
		require_once("footer_wide.php");
	} else {
		require_once("footer.php");
	}
}

function makeMatchup($id, $type, $homeSchoolID) {
	$rs2 = mysql_query("SELECT * FROM meet_school JOIN school ON meet_school.school_id=school.id WHERE meet_id=$id");
	$schools = array();
	while($school = mysql_fetch_object($rs2)) {
		if($school->id == $homeSchoolID) {
			$school->name = "<b>" . $school->name . "</b>";
			array_unshift($schools, $school);
		} else {
			//push it!
			array_push($schools, $school);
		}
	}
	$matchup = array();
	switch($type) {
	case "triple":
		$matchup[0][] = $schools[0];
		$matchup[0][] = $schools[1];
		$matchup[1][] = $schools[0];
		$matchup[1][] = $schools[2];
		$matchup[2][] = $schools[1];
		$matchup[2][] = $schools[2];
		break;
	case "double":
		$matchup[0][] = $schools[0];
		$matchup[0][] = $schools[1];
		$matchup[1][] = $schools[0];
		$matchup[1][] = $schools[2];
		break;
	case "single":
		$matchup[0][] = $schools[0];
		$matchup[0][] = $schools[1];
		break;
	}
	return $matchup;
}

function inMatchup($matchup, $school1_id, $school2_id) {
	foreach($matchup as $match) {
		if($match[0]->id == $school1_id && $match[1]->id == $school2_id || $match[1]->id == $school1_id && $match[0]->id == $school2_id) {
			return true;
		}
	}
	return false;
}

function protect($admin = false) {
	global $_SESSION;
	if(!isset($_SESSION['user_id'])) {
		header("Location: index.php");
	} else if ($admin && $_SESSION['school_id'] != 0) {
		die("Administrator only.");
	}
}

?>