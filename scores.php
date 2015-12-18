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
?>
Please select the match which you would like to view scores for:<br />
<form method="post">
<input type="hidden" name="meet_id" value="<?php echo $meet->id ?>" /><br />
<?php
foreach($matchup as $match) {
	echo "<input type='radio' name='match' value='{$match[0]->id}-{$match[1]->id}' />" . $match[0]->name . " vs. " . $match[1]->name . "<br />";
}
?>
<input type="submit" value="View Scores" />
<input type="submit" value="Enter Scores" />
</form>
<?php
showFooter();
?>