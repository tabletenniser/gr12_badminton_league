<?php
require_once("common.php");
protect(true);

if(isset($_GET['meet_id'])) {
	$meet_id = mysql_real_escape_string($_GET['meet_id']);
} else {
	die();
}

if(isset($_POST['home_school_id'])) {

	$meet = mysql_fetch_object(mysql_query("SELECT * FROM meet WHERE id=$meet_id"));
	
	list($year, $month, $day) = explode("-", $meet->date);
	
	$homeSchoolID = mysql_real_escape_string($_POST['home_school_id']);
	mysql_query("UPDATE meet SET home_school_id=$homeSchoolID WHERE id=$meet_id");
	header("Location: schedule.php?year=$year&month=$month");
}

showHeader();

?>
<p><b>Select a home school:</b></p>
<form method="post">
<?php
$rs = mysql_query("SELECT * FROM meet_school JOIN school ON school.id=school_id WHERE meet_id = $meet_id");
while($row = mysql_fetch_object($rs)) {
?>
<input type="radio" name="home_school_id" value="<?php echo $row->school_id ?>" /><?php echo $row->name ?> <br />
<?php
}
?>
<input type="submit" value="Enter" />
</form>
<?php
showFooter();
?>
