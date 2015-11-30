<?php
	$servername = "us-cdbr-iron-east-03.cleardb.net";
	$username = "beb3bc414324dd";
	$password = "97741eec";
	$dbname = "heroku_0da25f9d8cd62f7";

	// Create connection
	$db = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($db->connect_error) {
		die("Connección fallida: Lo sentimos estamos teniendo problemas" . $db->connect_error);
	}

	
?>