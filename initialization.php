<?php
require_once("common.php");
require_once("functions-initialization.php");
protect(true);

showHeader();

switch($_POST['submit']) {
	case 'Add':
		$school_name = mysql_real_escape_string($_POST['school_name']);
		$password = mysql_real_escape_string($_POST['password']);
		if(addSchool($school_name, $password)) {
			echo "School added.";
		} else {
			echo "Error adding school.";
		}
		break;
	case 'Delete':
		$school_id = mysql_real_escape_string($_POST['delete_school']);
		if(deleteSchool($school_id)) {
			echo "School deleted.";
		} else {
			echo "Error deleting school.";
		}
		break;
}

?>
<h1>Initialization</h1>
<?php

$rs = mysql_query("SELECT * FROM school JOIN user WHERE user.school_id=school.id ORDER BY school.name");

if(mysql_num_rows($rs) > 0) {
	echo <<<TABLE
	<table>
	<tr>
	<th>#</th>
	<th>School</td>
	<th>Password</th>
	<th></th>
	</tr>
TABLE;
	$i = 1;
	while($row = mysql_fetch_object($rs)) {
	echo <<<ROW
	<tr>
		<td>$i</td>
		<td>$row->name</td>
		<td>$row->password</td>
		<td>
		<form method="post">
		<input type="hidden" name="delete_school" value="$row->school_id" />
		<input type="submit" name="submit" value="Delete" />
		</form>
		</td>
	</tr>
ROW;
		$i++;
	}
	echo "</table>";
} else {
	echo "There are currently no schools.  Please add some...";
}
?>

</table>
<hr />
<h3>Add a School</h3>
<form method="post">
	<label for="school_name">Name: </label><input type="text" name="school_name" /><br />
	<label for="password">Password: </label><input type="password" name="password" /><br />
	<input type="submit" name="submit" value="Add" />
</form>

<hr />

<script type="text/javascript">
function submitForm() {
	var go = confirm('This will DELETE your current schedule and scores. This is COMPLETELY IRREVERSIBLE!');
	if(go) {
		var form = document.getElementById('gmform');
		form.submit();
	}
}
</script>

<form method="post" action="generate_matchups.php" id="gmform">
	<input type="hidden" name="generate_matchups" value="1" />
	<input type="button" value="Generate Meets" onClick="submitForm()" />
</form>
<?php
showFooter();
?>