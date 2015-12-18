<?php
require_once("common.php");
require_once("functions-player.php");
protect();
showHeader();

$schoolID = Auth::schoolID();

if($schoolID == 0) {
	die("Please log in to a coach account to manage players.");
}

if(isset($_POST['name'])) {
	$name = mysql_real_escape_string($_POST['name']);
	$gender = mysql_real_escape_string($_POST['gender']);
	addPlayer($name, $gender, $schoolID);
}

if(isset($_POST['delete'])) {
	$id = mysql_real_escape_string($_POST['delete']);
	deletePlayer($id);
}

if($schoolID == 0) {
	$rs = mysql_query("SELECT * FROM player");
} else {
	$rs = mysql_query("SELECT * FROM player WHERE school_id=$schoolID");
}
if(mysql_num_rows($rs) > 0) {
echo <<<HELLO
<table width="250">
<tr>
	<th>Name</th>
	<th>Gender</th>
	<th>Actions</th>
</tr>
HELLO;
		while($row = mysql_fetch_object($rs)) {
			echo <<<PLAYER
<tr>
	<td>$row->name</td>
	<td>$row->gender</td>
	<td>
		<form method="post">
		<input type="hidden" name="delete" value="$row->id" />
		<input type="submit" value="Delete" />
		</form>
	</td>
</tr>
PLAYER;
		}
	echo "</table>";
} else {
	echo "No players.  Create some.";
}
?>
<hr />
<h3>Add a New Player</h3>
<form method="post">
Name: <input type="text" name="name" /><br />
Gender:
<input type="radio" checked name="gender" value="M" /> Male
<input type="radio" name="gender" value="F" /> Female<br />
<input type="submit" value="Add" />
</form>
<?php
showFooter();
?>