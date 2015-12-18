<?php
//connect to database;
@mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("FATAL ERROR: Unable to connect to MySQL database.");
//select database
@mysql_select_db(DB_NAME) or die("FATAL ERROR: Unable to select database " . DB_NAME);
?>