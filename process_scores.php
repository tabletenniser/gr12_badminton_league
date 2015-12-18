<?php

require_once("common.php");

showHeader();

//processing data from enter_scores.php

if(isset($_POST['school1_id'])) {
	
	$school1ID = mysql_real_escape_string($_POST['school1_id']);
	$school2ID = mysql_real_escape_string($_POST['school2_id']);
	
	for($i = 0; $i < 2; $i++) {
		if($i == 0) {
			$level = 'A';
		} else {
			$level = 'B';
		}
		
		foreach($_POST['level' . $level . '_players'] as $event=>$schools) {
			
			//echo "<h1>$event school A gains {$_POST['level' . $level . '_points'][$event][0]}, school B gains {$_POST['levelA_points'][$event][1]}</h1>";
			foreach($schools as $k=>$players) {
				
				if($k == 0) {
					$sID = $school1ID;
					$oID = $school2ID;
					$pts = $_POST['level' . $level . '_points'][$event][0];
				} else {
					$sID = $school2ID;
					$oID = $school1ID;
					$pts = $_POST['level' . $level . '_points'][$event][1];
				}
				
				$isInsert = true;
				
				$rs = mysql_query("SELECT * FROM score WHERE school_id = $sID AND opponent_id=$oID AND level = '$level' AND event='$event'");
				if(mysql_num_rows($rs) == 0) {
					mysql_query("INSERT INTO score (school_id, opponent_id, level, event, points) VALUES ($sID, $oID, '$level', '$event', $pts)");
					$scoreID = mysql_insert_id();
				} else {
					$score = mysql_fetch_object($rs);
					$scoreID = $score->id;
					mysql_query("UPDATE score SET points = $pts WHERE id=$scoreID");
					$isInsert = false;
				}
				
				foreach($players as $playerID) {
					//echo "<li>$playerID - $k</li>";
					if($isInsert) {
						mysql_query("INSERT INTO player_score (score_id, player_id) VALUES ($scoreID, $playerID)");
					} else {
						mysql_query("UPDATE player_score SET player_id = $playerID WHERE score_id=$scoreID");
					}
				}
			}
		}
	}
	echo "Scores entered successfully.";
}

showFooter();

?>