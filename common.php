<?php

session_start();

require_once("config.php");
if(!defined('DB_HOST')) {
	die("ERROR: config.php not configured.  Please run <a href='install.php'>install</a>.");
}
require_once("connect.php");
require_once("class-auth.php");
require_once("functions-general.php");

?>