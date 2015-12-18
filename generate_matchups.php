<?php
require_once("common.php");

define('TRIALS', 1000);

function isDone(){
	global $numOfSchools, $count, $match;

	 for ($i=0;$i<$numOfSchools;$i++){
		for ($j=$i+1; $j<$numOfSchools;$j++){
		   if($i!=$j && $match[$i][$j]==-1){
			  return -1;
			  
		   }
		}		
	 }
	return 0;
}

function displayTriMeet($pool){
	global $numOfSchools, $count, $match, $schools;
	for ($i=0;$i<TRIALS;$i++){
		$a=rand(0,$numOfSchools);
		$b=rand(0,$numOfSchools);
		$c=rand(0,$numOfSchools);
		if ($a<$b && $b<$c){
		   if($match[$a][$b]==-1 && $match[$a][$c]==-1 && $match[$b][$c]==-1){
			  $match[$a][$b]=0;
			  $match[$a][$c]=0;
			  $match[$b][$c]=0;

	echo $a."-".$b."-".$c."<br/>";
			  
			  mysql_query("INSERT INTO meet(type) VALUES ('triple')");
			  $meet_id = mysql_insert_id();
			  mysql_query("INSERT INTO meet_school(meet_id,school_id)VALUES($meet_id," . $schools[$a]->id . ")");
			  mysql_query("INSERT INTO meet_school(meet_id,school_id)VALUES($meet_id," . $schools[$b]->id . ")");
			  mysql_query("INSERT INTO meet_school(meet_id,school_id)VALUES($meet_id," . $schools[$c]->id . ")");
			  

			  return 0;
		   }
		}
	 }
	 return -1;
}

function displayDoubleDualMeet($pool){
global $numOfSchools, $count, $match, $schools;
	 for ($i=0;$i<TRIALS;$i++){
		$a=rand(0,$numOfSchools);
		$b=rand(0,$numOfSchools);
		$c=rand(0,$numOfSchools);
		
		if ($a<$b && $b<$c){
		   if($match[$a][$b]==-1 && $match[$a][$c]==-1){
			  $match[$a][$b]=0;
			  $match[$a][$c]=0;
			  
			  mysql_query("INSERT INTO meet(type,home_school) VALUES ('double'," . $schools[$a]->id . ")");
			  $meet_id = mysql_insert_id();
			  mysql_query("INSERT INTO meet_school(meet_id,school_id) VALUES($meet_id," . $schools[$a]->id . ")");
			  mysql_query("INSERT INTO meet_school(meet_id,school_id)VALUES($meet_id," . $schools[$b]->id . ")");
			  mysql_query("INSERT INTO meet_school(meet_id,school_id)VALUES($meet_id," . $schools[$c]->id . ")");
			  
	echo $a."-(".$b."-".$c.")<br/>";
			  return 0;
		   }
		}
	 }
	 return -1;
}


function displayDualMeet($pool){
	global $numOfSchools, $count, $match, $schools;
	 for ($i=0;$i<TRIALS;$i++){
	   $a=rand(0,$numOfSchools);
	   $b=rand(0,$numOfSchools);
		
		if ($a<$b){
		   if($match[$a][$b]==-1){
			  $match[$a][$b]=0;
							
			  mysql_query("INSERT INTO meet(type) VALUES ('single')");
			  $meet_id = mysql_insert_id();
			  mysql_query("INSERT INTO meet_school(meet_id,school_id)VALUES($meet_id," . $schools[$a]->id . ")");
			  mysql_query("INSERT INTO meet_school(meet_id,school_id)VALUES($meet_id," . $schools[$b]->id . ")");
							
	echo $a."-".$b."<br/>";
			  return 0;
		   }
		}
	 }
	 return -1;
}

mysql_query("TRUNCATE meet");
mysql_query("TRUNCATE meet_school");
mysql_query("TRUNCATE score");
mysql_query("TRUNCATE player_score");

$count=0;
$match = array();

if(isset($_POST['num_pools'])) {
	$numPools = intval($_POST['num_pools']);
} else {
	$numPools = 1;
}

//split into two pools
if(0 > 1) {
	$result=mysql_query("SELECT id FROM school");
	$numOfSchools = mysql_num_rows($result);
	
	$poolSize = floor($numOfSchools/$numPools);
	
	for($i = 1; $i < $numPools; $i++) {
		for($j = 0; $j < $poolSize; $j++) {
			$school = mysql_fetch_object($result);
			mysql_query("UPDATE school SET league=$i WHERE id=$school->id");
		}
	}
} else {
	mysql_query("UPDATE school SET league=0 WHERE league!=0");
}

//generate matchups
//for($league = 0; $league < $numPools; $league++) {
	$result=mysql_query("SELECT * FROM school");
	$numOfSchools = mysql_num_rows($result);
	$schools = array();
	$match = array();
	$count = 0;
	while($school = mysql_fetch_object($result)) {
			$schools[] = $school;
	}

	for ($i=0;$i<$numOfSchools;$i++){
		for ($j=$i+1; $j<$numOfSchools;$j++){
			$match[$i][$j]=-1;
		}
	}

	while (isDone()==-1){
		if (displayTriMeet($league)==0){
			$count++;
		}
		else if(displayDoubleDualMeet($league)==0){
			$count++;
		}
		else if(displayDualMeet($league)==0){
			$count++;
		}
	}
	//echo $count;
//}
      
showHeader();

echo "Schedule generated.";

showFooter();
?>