<?php
	$servername = "localhost";
	$username = "root";
	$password = "kobyjzt";
	$dbname = "UnidasBD";

	// Create connection
	$db = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($db->connect_error) {
		die("Connección fallida: Lo sentimos estamos teniendo problemas" . $db->connect_error);
	}
?>