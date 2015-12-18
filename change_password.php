<?php
require("common.php");
showHeader();
protect(true);

function changePassword($id, $pass, $rePass){
	if ($pass==$rePass ){
		$temp = mysql_query("UPDATE user SET password = '$pass' WHERE id='$id'") or die(mysql_error());
		echo "Password successfully changed";
	}else{
		echo "Passwords entered do not match!";
	}
}
?>

<div align="center">
<form action="change_password.php" method="post">
<div>
	<h2>Change Password</h2>
		<?php

		
			$rs = mysql_query("SELECT * FROM user");
			
		?>
			<strong>User:</strong>
			<select name="user_id">
		<?php
				while($row = mysql_fetch_object($rs)) {
					if($row->school_id == null) {
						echo "<option value='$row->id'>Administrator</option>\n";
					} else {
						$school = mysql_fetch_object(mysql_query("SELECT name FROM school WHERE id=$row->school_id"));
						echo "<option value='$row->id'>$school->name</option>\n";
					}
				}
		?>
			</select>

		</div>
		<div>
			<strong>Enter New Password:</strong>
			<input type = "password" name = "newPass"/><br />
		</div>
		<div>
			<strong>Reenter New Password:</strong>
			<input type = "password" name = "reNewPass"/><br />
		</div>
		<input type = "submit" value="Change" />
	</form>
</div>
<?php
		if(isset($_POST['user_id'])) {
			$id=$_POST['user_id'];
			$newPass=$_POST['newPass'];
			$reNewPass=$_POST['reNewPass'];
			changePassword($id, $newPass, $reNewPass);
		}
		?>
<?php
showFooter();
?>