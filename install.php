<?php
require("functions-general.php");
showHeader();

if(isset($_POST['db_host'])) {

	$db_user = $_POST['db_user'];
	$db_host = $_POST['db_host'];
	$db_pass = $_POST['db_pass'];
	$db_name = $_POST['db_name'];
	$pass = $_POST['pass'];

	$fh = fopen("config.php", 'w') or die("Cannot open config.php.  Check your permissions.");
	$data = "<?php\n";
	$data .= "define(\"DB_HOST\",\"$db_host\");\n";
	$data .= "define(\"DB_USER\",\"$db_user\");\n";
	$data .= "define(\"DB_PASS\",\"$db_pass\");\n";
	$data .= "define(\"DB_NAME\",\"$db_name\");\n";
	$data .= "?>";
	fwrite($fh, $data) or die("Cannot write to config.php.  Check your permissions.");
	fclose($fh);
	
	require_once("config.php");
	@mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("FATAL ERROR: Unable to connect to MySQL database.");
	@mysql_query("CREATE DATABASE IF NOT EXISTS `". DB_NAME."`") or die(mysql_error());
	@mysql_select_db(DB_NAME) or die("FATAL ERROR: Unable to select database.");
	
	$queries = array(
	'meet'=>"CREATE TABLE IF NOT EXISTS `meet` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `type` enum('triple','double','single') NOT NULL,
	  `home_school_id` int(11) NOT NULL,
	  `date` date NOT NULL,
	  `league` int(1) NOT NULL DEFAULT '0',
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
	",

	'meet_school'=>"CREATE TABLE IF NOT EXISTS `meet_school` (
	  `meet_id` int(11) NOT NULL,
	  `school_id` int(11) NOT NULL,
	  UNIQUE KEY `meet_id` (`meet_id`,`school_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1;",

	'player'=>"CREATE TABLE IF NOT EXISTS `player` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `name` varchar(100) NOT NULL,
	  `school_id` int(11) NOT NULL,
	  `gender` enum('M','F') NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;",

	'player_score'=>"CREATE TABLE IF NOT EXISTS `player_score` (
	  `score_id` int(11) NOT NULL,
	  `player_id` int(11) NOT NULL,
	  UNIQUE KEY `score_id` (`score_id`,`player_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1;",

	'ranking'=>"CREATE TABLE IF NOT EXISTS `ranking` (
	  `school_id` int(11) NOT NULL,
	  `event` enum('bs','gs','bd','gb','md') NOT NULL,
	  `level` enum('A','B') NOT NULL,
	  `points` int(4) NOT NULL,
	  UNIQUE KEY `school_id` (`school_id`,`event`,`level`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1;",

	'school'=>"CREATE TABLE IF NOT EXISTS `school` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `name` varchar(100) NOT NULL,
	  `league` int(1) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;",

	'score'=>"CREATE TABLE IF NOT EXISTS `score` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `school_id` int(11) NOT NULL,
	  `opponent_id` int(11) NOT NULL,
	  `points` int(11) NOT NULL,
	  `event` enum('bs','gs','bd','gd','md') NOT NULL,
	  `level` enum('A','B') NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;",

	'user'=>"CREATE TABLE IF NOT EXISTS `user` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `password` varchar(32) NOT NULL,
	  `school_id` int(11) DEFAULT NULL,
	  PRIMARY KEY (`id`),
	  UNIQUE KEY `school_id` (`school_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;"
	);
	
	foreach($queries as $tbl=>$q) {
		if(mysql_query($q)) {
			echo "Table `" . $tbl . "` created.<br />";
		} else {
			die(mysql_error());
		}
	}
	mysql_query("TRUNCATE TABLE `user`");
	mysql_query("INSERT INTO user (password) VALUES ('$pass')") or die(mysql_error());
	
	echo "<strong>Installation successful.</strong><hr />";
	
}

?>
<form method="post">
<table align="center">
<tr>
	<th colspan="2">MySQL</th>
</tr>
<tr>
	<td>MySQL Host:</td>
	<td><input type="text" name="db_host" /></td>
</tr>
<tr>
	<td>MySQL User:</td>
	<td><input type="text" name="db_user" /></td>
</tr>
<tr>
	<td>MySQL Password:</td>
	<td><input type="text" name="db_pass" /></td>
</tr>
<tr>
	<td>Database name: <br /><small>(name of database the data will be stored in, will be created if it does not exist)</small></td>
	<td><input type="text" name="db_name" /></td>
</tr>
<tr>
	<th colspan="2">Administrator Account</th>
</tr>
<tr>
	<td>Password: <br /><small>(password for admin account)</small></td>
	<td><input type="text" name="pass" /></td>
</tr>
<tr>
	<th colspan="2"><input type="submit" value="Install" /></th>
</tr>
</table>
</form>
<?php
showFooter();
?>