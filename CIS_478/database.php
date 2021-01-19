<?php

$serverName = 'localhost';
$dBUsername = 'johnsomj02';
$dBPassword = 'CIS478project';
$dBName = 'johnsomj02';

// Create connection
$link = new mysqli($serverName,$dBUsername, $dBPassword, $dBName);

// Check connection
if (!$link) {
  die("Connection failed: " . mysqli_connect_error());
}
?>