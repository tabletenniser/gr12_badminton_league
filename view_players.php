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
$schools = array();
$rs = mysql_query("SELECT * FROM school");
while($row = mysql_fetch_object($rs)) {
	$schools[] = $row;
}
?>

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
	//$scores = array();
	
	echo "<th>$school->name</th>";
	
	foreach($schools as $opponent) {
	
		$q = "SELECT * FROM score WHERE school_id=$school->id AND opponent_id=$opponent->id AND event='$abbrev' ORDER BY level ASC";
		$rs = mysql_query($q);
	
		//echo mysql_num_rows($rs);
		if($school == $opponent) {
			echo "<td class='disabled'></td>";
			echo "<td class='disabled'></td>";
		} else if(mysql_num_rows($rs) >= 2) {
			while($row = mysql_fetch_object($rs)) {
				echo "<td>";
				$scoreID = $row->id;
				$rsp = mysql_query("SELECT * FROM player_score JOIN player ON player.id=player_id WHERE score_id=$scoreID");
				while($player = mysql_fetch_object($rsp)) {
					echo "<small>$player->name</small>";
				}
				echo "</td>";
			}
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
showFooter(true);
?>