<?php
require_once("common.php");
protect();
showHeader();

$schoolID = Auth::schoolID();

//display error message if school has no players
if($schoolID != 0) {
	if(mysql_num_rows(mysql_query("SELECT * FROM player WHERE school_id=$schoolID")) == 0) {
		echo "<div class='error'>There are no players in your school.  Please create players by clicking <strong>Manage Players</strong> below.</div>";
	}
}
?>
<div id="menu">
	<h1>MENU</h1>
	<?php
	//displays administrator options if they are administrator
	if(Auth::schoolID() == 0) {
		echo "<div>You are <strong>Administrator</strong>.</div>";
	?>
	<a href="initialization.php"><div>Initialization</div></a>
	<a href="create_csv.php"><div>Download spreadsheet</div></a>
	<a href="change_password.php"><div>Change password</div></a>
	<?php
	} else {
		$school = Auth::getSchool();
		echo "<div>You are <strong>$school->name</strong>.</div>";
		echo "<a href=\"manage_players.php\"><div>Manage players</div></a>";
		echo "<a href=\"schedule.php\"><div>Enter / Edit scores</div></a>";
	}
	//check if they've gone through initialization
	if(mysql_num_rows(mysql_query("SELECT * FROM school")) > 0 && mysql_num_rows(mysql_query("SELECT * FROM meet")) > 0) {
	?>
	<a href="schedule.php"><div>View schedule</div></a>
	<a href="ranking.php"><div>View ranking</div></a>
	<a href="current_scores.php"><div>View the current scores</div></a>
	<a href="reset.php"><div>Reset</div></a>
	<?php
	} else {
		echo "<div>Please click initialization above.  You cannot access any functionalities until you have generated the matchups.</div>";
	}
	?>
	<a href="logout.php"><div>Logout</div></a>
</div>
<?php
showFooter();
?>
