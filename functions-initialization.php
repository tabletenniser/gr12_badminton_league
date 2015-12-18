<?php

function deleteUser($id) {
	return mysql_query("DELETE FROM user WHERE id=$id");
}

function addUser($schoolID, $password) {
	return mysql_query("INSERT INTO user (school_id, password) VALUES ($schoolID, '$password')");
}

function deleteSchool($id) {
	mysql_query("DELETE FROM user WHERE school_id=$id") or die(mysql_error());
	return mysql_query("DELETE FROM school WHERE id=$id");
}

function addSchool($name, $password) {
	mysql_query("INSERT INTO school (name) VALUES ('$name')");
	$schoolID = mysql_insert_id();
	return addUser($schoolID, $password);
}

?>