<?php
// start the session
session_start();

// unset all session variables
$_SESSION = array();

// destroy the session
session_destroy();

// redirect to the login page
header("location: login.php");
exit;
?>
