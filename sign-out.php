<?php
session_start();
$_SESSION = array();
session_destroy();
$success = "You have been logged out.";
header("location:index.php");
exit;
?>
