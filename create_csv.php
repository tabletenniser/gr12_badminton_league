<?php

require_once("common.php");

protect(true);

header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=score.csv");
header("Pragma: no-cache");
header("Expires: 0");

require("class-event.php");
require("class-school.php");

function println($s = '') {
	echo $s . "\n";
}

foreach($events as $event) {
	
	println($event);
	println();
	
	$abbrev = $event->getAbbrev();
	$leagues = array();
	$rs = mysql_query("SELECT * FROM school ORDER BY league");
	while($row = mysql_fetch_object($rs)) {
		$leagues[$row->league][] = new School($row->id, $row->name);
	}

	foreach($leagues as $leagueNum=>$schools) {
		println("Pool #" . ($leagueNum + 1));
		println("," . implode(",,", $schools));
		$rowData = array();
		$rowData[] = " ";
		foreach($schools as $school) {
			$rowData[] = "A,B";
		}
		println(implode(",", $rowData));
				
		foreach($schools as $school) {
			$q = "SELECT * FROM score WHERE school_id=$school->id AND event='$abbrev' ORDER BY level ASC";
			$rs = mysql_query($q);
			$scores = array();
			
			$rowData = array();
			$rowData[] = $school->name;
			
			while($row = mysql_fetch_object($rs)) {
				$scores[$row->opponent_id][] = $row->points;
				$scoreID = $row->id;
			}
			
			foreach($schools as $opponent) {
				if($school == $opponent) {
					$rowData[] = "x";
					$rowData[] = "x";
				} else if(isset($scores[$opponent->id])) {
					$rowData[] = $scores[$opponent->id][0];
					$rowData[] = $scores[$opponent->id][1];
				} else {
					$rowData[] =  " ";
					$rowData[] = " ";
				}
			}
			println(implode(",", $rowData));
		}
		println();
	}
}

?>