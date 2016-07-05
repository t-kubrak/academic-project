<?php

$servername = "localhost";

$username = "giftgoals";

$password = "AlgonquinGG16!";

$dbase = "giftgoals";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbase);
if (!$conn){
	die( "System is currently unavailable, please try later.");
}

?>