<?php

include("common.php");
showHeader();
protect(true);

if(isset($_POST['reset'])) {
	mysql_query("TRUNCATE school");
	mysql_query("TRUNCATE player");
	mysql_query("TRUNCATE score");
	mysql_query("TRUNCATE meet");
	mysql_query("TRUNCATE meet_player");
	echo "Database emptied.";
}

?>

<p>Are you sure you want to delete all players, schools and scores in the database?</p>
<form method="post">
<input type="hidden" name="reset" value="1" />
<input type="submit" value="Yes, I'm sure." />
</form>

<?php

showFooter();

?>