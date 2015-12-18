<?php
require_once("common.php");
showHeader(true);

$event = array();

require("class-event.php");

if(!isset($_GET['event_id'])) {
	$event_id = 0;
} else {
	$event_id = intval($_GET['event_id']);
}

$abbrev = $events[$event_id]->getAbbrev();

?>
<h1>Current score: <?php echo $events[$event_id]; ?></h1>
<form method="get">
	<select name="event_id" onChange="submit()">
		<?php
		foreach($events as $i=>$event) {
			if($i == $event_id) {
				echo "<option value='$i' selected=\"selected\">$event</option>";
			} else {
				echo "<option value='$i'>$event</option>";
			}
		}
		?>
	</select>
</form>
<hr/>

<?php
$leagues = array();
$rs = mysql_query("SELECT * FROM school ORDER BY league");
while($row = mysql_fetch_object($rs)) {
	$leagues[$row->league][] = $row;
}

foreach($leagues as $leagueNum=>$schools) {

?>
<h3>Pool #<?php echo ($leagueNum + 1) ?></h3>
<table id="view_scores">
<tr>
	<th rowspan="2"></th>
	<?php
	foreach($schools as $school) {
		echo "<th colspan=\"2\">$school->name</th>";
	}
	?>
</tr>
<tr>
	<?php
	foreach($schools as $school) {
		echo "<td>Level A</td>";
		echo "<td>Level B</td>";
	}
	?>
</tr>

<?php
foreach($schools as $school) {
	echo "<tr>";
	$q = "SELECT * FROM score WHERE school_id=$school->id AND event='$abbrev' ORDER BY level ASC";
	$rs = mysql_query($q);
	$scores = array();
	
	echo "<th class='leftcol'>$school->name";
	
	while($row = mysql_fetch_object($rs)) {
		$scores[$row->opponent_id][] = $row->points;
		$scoreID = $row->id;
	}
	
	echo "</th>";
	
	foreach($schools as $opponent) {
		if($school == $opponent) {
			echo "<td class='blocked'></td>";
			echo "<td class='blocked'></td>";
		} else if(isset($scores[$opponent->id])) {
			echo "<td>{$scores[$opponent->id][0]}</td>";
			echo "<td>{$scores[$opponent->id][1]}</td>";
		} else {
			echo "<td></td>";
			echo "<td></td>";
		}
	}
	echo "</tr>\n";
}
?>
</table>
<?php
}
showFooter(true);
?>