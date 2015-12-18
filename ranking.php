<?php
require_once("common.php");
showHeader();

?>
<b>
<font size="20" >Ranking</font> 
</b>
<br/>
<form action="ranking.php" method="post">
Event:
<select name="ranking_type">
<option value='o'>Overall</option>
<option value='go'>Girls Overall</option>
<option value='bo'>Boys Overall</option>
<option value='bs'>Boys Single</option>
<option value='gs'>Girls Single</option>
<option value='bd'>Boys Double</option>
<option value='gd'>Girls Double</option>
<option value='md'>Mixed Double</option>
</select>
Level:
<select name="level">
<option value='o'>Overall</option>
<option value='A'>A</option>
<option value='B'>B</option>
</select>
Pool:
<select name="pool">
<option value='0'>1</option>
<option value='1'>2</option>
</select>
<input type="submit" value="Rank" />
</form>
<?php

// store data in temporary variables from the html
if(isset($ranking_type)) {
	$ranking_type=$_POST['ranking_type'];
	$level=$_POST['level'];
	$pool=$_POST['pool'];
} else {
	$ranking_type = "o";
	$level = 'A';
	$pool = 0;
}
echo "<br/><strong>Type:</strong> ";
if ($ranking_type=="o"){
	echo "Overall";
}else if($ranking_type=="bo"){
	echo "Boys Overall";
}else if($ranking_type=="bo"){
	echo "Girls Overall";
}else{
	echo $ranking_type;
}
if ($level=="o"){
	echo "Level: Overall";
}else{
	echo "  <strong>Level: </strong>" . $level;
}
if ($pool=="0"){
	echo "  <strong>Pool:</strong> 1<br/>";
}else{
	echo "  <strong>Pool:</strong> 2<br/>";
}
		

	displayRanking($ranking_type,$level,$pool);

	function displayRanking($event, $level, $pool){
		mysql_query("TRUNCATE ranking");
		$count=0;
		$result=mysql_query("SELECT * FROM school");
		
		$schools = array();
		
		while($row = mysql_fetch_object($result)) {
			$schools[] = $row;
		}
		
		$numOfSchools = mysql_num_rows($result);
		
		while ($count<$numOfSchools){
		$count++;
		
		if ($event=="o" && $level=="o"){
			$result = mysql_query("SELECT*FROM score JOIN school ON score.school_id=school.id WHERE score.school_id='$count' AND school.league='$pool'");
		}else if($event=="bo" && $level=="o"){
			$result= mysql_query("SELECT*FROM score JOIN school ON score.school_id=school.id WHERE school_id='$count' AND event='bs' AND school.league='$pool' OR event='bd' AND school_id='$count' AND school.league='$pool'");
		}else if($event=="go" && $level=="o"){
			$result= mysql_query("SELECT*FROM score JOIN school ON score.school_id=school.id WHERE school_id='$count' AND event='gs' AND school.league='$pool' OR event='gd'AND school_id='$count' AND school.league='$pool'");
		}else if($event=="bo"){
			$result= mysql_query("SELECT*FROM score JOIN school ON score.school_id=school.id WHERE school_id='$count' AND event='bs' AND level='$level' AND school.league='$pool' OR event='bd'AND school_id='$count' AND level='$level' AND school.league='$pool'");
		}else if($event=="go"){
			$result= mysql_query("SELECT*FROM score JOIN school ON score.school_id=school.id WHERE school_id='$count' AND event='gs' AND level='$level' AND school.league='$pool' OR event='gd'AND school_id='$count' AND level='$level' AND school.league='$pool'");
		}else if($level=="o"){
			$result= mysql_query("SELECT*FROM score JOIN school ON score.school_id=school.id WHERE school_id='$count' AND event='$event' AND school.league='$pool'");
		}else if($event=="o"){
			$result= mysql_query("SELECT*FROM score JOIN school ON score.school_id=school.id WHERE school_id='$count' AND level='$level' AND school.league='$pool'");
		}else{
			$result= mysql_query("SELECT*FROM score JOIN school ON score.school_id=school.id WHERE school_id='$count' AND level='$level' AND event='$event' AND school.league='$pool'");
		}
			$pointOfSchool[$count]=0;
			while($rank=mysql_fetch_array($result)){
				$pointOfSchool[$count]+=$rank["points"];
			}
			if($event=='go' || $event=='bo'){
				if($level=='o'){
					$result= mysql_query("SELECT*FROM score JOIN school ON score.school_id=school.id WHERE school_id='$count' AND event='md' AND school.league='$pool'");
				}else{
					$result= mysql_query("SELECT*FROM score JOIN school ON score.school_id=school.id WHERE school_id='$count' AND level='$level' AND event='md' AND school.league='$pool'");
				}
					while($rank=mysql_fetch_array($result)){
						$pointOfSchool[$count]+=$rank["points"]/2;
				}
			}
			
			mysql_query("INSERT INTO ranking(school_id, points) VALUES({$schools[$count]->id},$pointOfSchool[$count])");
		}
?>	
<br/>
<br/>
<table border = "1">
<tr>
<th>Rank</th>
<th>School</th>
<th>Points</th>
</tr>
<tr>
<?php
$result=mysql_query("SELECT*FROM ranking ORDER BY points DESC");
$ranking=0;

	while($rank=mysql_fetch_array($result)){
		$ranking++;
		echo "<tr>";
		echo "<th>".$ranking."</th>";
		$school_id =$rank['school_id'];

	$rs = mysql_query("SELECT*FROM school WHERE id=$school_id");
	$row=mysql_fetch_array($rs);

			$school_name = $row['name'];
		

		echo "<td>".$school_name."</td>";
		echo "<td>".$rank['points']."</td>";
		echo "</tr>";
		
	}
echo "</table>";
	}

showFooter();
?>