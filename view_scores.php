<?php

require_once("common.php");
require_once("class-event.php");
require_once("functions-scores.php");
protect();
showHeader();

if(!isset($_GET['meet_id'])) {
	die();
}

$loggedInSchoolID = Auth::schoolID();
$meet_id = mysql_real_escape_string($_GET['meet_id']);

//verify if user is the home school of this meet
$rs = mysql_query("SELECT * FROM meet WHERE id=$meet_id");
if(mysql_num_rows($rs) == 0) {
	die("This meet exists not.");
} else {
	$meet = mysql_fetch_object($rs);
}

//makematchup
$matchup = makeMatchup($meet->id, $meet->type, $meet->home_school_id);

if(isset($_GET['match'])) {
	$match = mysql_real_escape_string($_GET['match']);
	list($school1_id, $school2_id) = explode("-", $match);
} else {
	?>
	Please select the match which you would like to view scores for:<br />
	<form method="get">
	<input type="hidden" name="meet_id" value="<?php echo $meet->id ?>" /><br />
	<?php
	foreach($matchup as $match) {
		echo "<input type='radio' name='match' value='{$match[0]->id}-{$match[1]->id}' />" . $match[0]->name . " vs. " . $match[1]->name . "<br />";
	}
	?>
	<input type="submit" value="Select" />
	</form>
	<?php
	showFooter();
	die();
}

//verify if the matchup exists
if(!inMatchup($matchup, $school1_id, $school2_id)) {
	die("This match does not exist");
}

//get school1 and school2
$rs = mysql_query("SELECT * FROM school WHERE (id=$school1_id OR id=$school2_id)");
$school1 = mysql_fetch_object($rs);
$school2 = mysql_fetch_object($rs);


echo "$school1->name vs. $school2->name";

?>

<hr />

<table id="score_form">

<tr>
	<th>Level</th>
	<th>Event</th>
	<th>School</th>
	<th>Player Names</th>
	<th>Score</th>
</tr>

<?php
for($i = 0; $i < 2; $i++) {

$level = ($i == 0 ? 'A' : 'B');

foreach($events as $event) {

$abbrev = $event->getAbbrev();
?>

<!-- ROW SINGLE MEET -->
<?php $score = fetchScore($school1->id, $school2->id, $level, $abbrev); ?>
<tr>
	<?php
	if($event == $events[0]) {
		echo "<th rowspan='10'>";
		echo "<h1>$level</h1>";
		echo "</th>";
	}
	?>
	<th rowspan="2"><?php echo $event ?></th>
	<td><?php echo $school1->name ?></td>
	<td>
	<?php showPlayers($score->id); ?>
	</td>
	<td>
	<?php showScore($score->id); ?>
	</td>
</tr>
<?php $score = fetchScore($school2->id, $school1->id, $level, $abbrev); ?>
<tr>
	<td><?php echo $school2->name ?></td>
	<td>
	<?php showPlayers($score->id); ?>
	</td>
	<td>
	<?php showScore($score->id); ?>
	</td>
</tr>

<!-- ROW END -->
<?php
	}
}
?>
</table>
<?php
showFooter();
?>