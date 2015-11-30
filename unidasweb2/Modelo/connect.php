<?php
	define('HOST','fdb7.biz.nf');
  define('USER','1982557_unidasbd');
  define('PASS','unidasbd1');
  define('DB','1982557_unidasbd');
  $con = mysqli_connect(HOST,USER,PASS,DB);
        
	
	// Create connection
	$db = new mysqli(HOST,USER,PASS,DB);
	// Check connection
	if ($db->connect_error) {
		die("Connección fallida: Lo sentimos estamos teniendo problemas" . $db->connect_error);
	}
?>