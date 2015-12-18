<?php

require_once("common.php");
unset($_SESSION['user_id']);
unset($_SESSION['school_id']);
$_SESSION['message'] = "Good-bye.";
header("Location: index.php");

?>