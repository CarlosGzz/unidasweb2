<?php
	include("../Modelo/conexion.php");
	$user =$_POST['user'];
	$pass =$_POST['pass'];
	$db = new conexion;

	$db->login($user, $pass);
	$db->cerrar();


?>