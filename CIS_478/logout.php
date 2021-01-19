<?php

// Initialize the session
session_start();
 
// Refresh all of the session variables
$_SESSION = array();
 
// End the session
session_destroy();
 
// Redirect to home page
header("location: index.php");

exit;

?>