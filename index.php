<?php
require_once("common.php");
	
if(isset($_POST['user_id'])) {
	$user_id = mysql_real_escape_string($_POST['user_id']);
	$pass = mysql_real_escape_string($_POST['pass']);
	$login = mysql_query("SELECT * FROM user WHERE id=$user_id AND password='$pass'") or die(mysql_error());
	if(mysql_num_rows($login) == 0) {
		$_SESSION['message'] = "Incorrect password";
	} else {
		$row = mysql_fetch_object($login);
		$_SESSION['user_id'] = $row->id;
		if(is_null($row->school_id)) {
			$_SESSION['school_id'] = 0;
		} else {
			$_SESSION['school_id'] = $row->school_id;
		}
	}
}

if(isset($_SESSION['user_id'])) {
	header("Location: menu.php");
}

showHeader();

?>
<h1 align="center">TDSB Badminton League</h1>
<hr />
<div align="center">
	<?php
		if(isset($_SESSION['message'])) {
			echo "<p class='error'>" . $_SESSION['message'] . "</p>";
			unset($_SESSION['message']);
		}
	?>
</div>
<div align="center">
	<h2>Coach Login</h2>
	<form method="post">
		<div>
		<?php
			$rs = mysql_query("SELECT user.id, school.name FROM school JOIN user ON user.school_id=school.id");
			if(mysql_num_rows($rs) > 0) {
		?>
			<strong>School:</strong>
			<select name="user_id">
		<?php while($row = mysql_fetch_object($rs)) { ?>
			<option value="<?php echo $row->id ?>"><?php echo $row->name ?></option>
		<?php } ?>
			</select>
		<?php
			} else {
				echo "-no schools available-";
			}
		?>
		</div>
		<div>
			<strong>Password:</strong>
			<input type = "password" name = "pass"/><br />
		</div>
		<input type = "submit" value="Login" />
	</form>
</div>


<div align="center">
	<h2>Admin Login</h2>
	<form method="post">
		<?php
		$rs = mysql_query("SELECT id FROM user WHERE school_id IS NULL");
		$row = mysql_fetch_object($rs);
		?>
		<input type="hidden" name="user_id" value="<?php echo $row->id ?>" />
		<div>
			<strong>Password</strong> <input type = "password" name = "pass" />
		</div>
		<input type = "submit" value="Login" />
	</form>
</div>
<?php

?>