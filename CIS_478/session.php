<?php

// start a new session
session_start();

// if the user has a valid account created and has already logged in, redirect them to the logged in page
if (isset($_SESSION["username"]) && $_SESSION["username"] == true){
	header ("location: successful_login.php");
	exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>

<body>

</body>
