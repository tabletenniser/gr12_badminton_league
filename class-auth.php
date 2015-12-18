<?php

/**
 * Auth contains static methods that fetches the logged in user data.
 */

class Auth {
	static function schoolID() {
		global $_SESSION;
		return $_SESSION['school_id'];
	}
	static function userID() {
		global $_SESSION;
		return $_SESSION['user_id'];
	}
	
	static function getSchool() {
		$rs = mysql_query("SELECT * FROM school WHERE id=" . Auth::schoolID());
		return mysql_fetch_object($rs);
	}
}

?>