<?php
function deletePlayer($id) {
	return mysql_query("DELETE FROM player WHERE id=$id");
}

function addPlayer($name, $gender, $schoolID) {
	mysql_query("INSERT INTO player (name, gender, school_id) VALUES ('$name', '$gender', $schoolID)");
}
?>