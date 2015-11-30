<?php
error_reporting(0);

	$servername = "us-cdbr-iron-east-03.cleardb.net";
	$username = "beb3bc414324dd";
	$password = "97741eec";
	$dbname = "heroku_0da25f9d8cd62f7";

	echo $servername."  ".$username."  ". $password."   ".$dbname;
	// Create connection
	$db = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($db->connect_error) {
		die("Connección fallida: Lo sentimos estamos teniendo problemas" . $db->connect_error);
	}

$datos = array();

if($eventos = $db->query("SELECT * FROM Eventos")){
	if($eventos->num_rows){
		while($fila = $eventos->fetch_object()){
			$datos[] = $fila;
		}
		$eventos->free();
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Prueba 2</title>
</head>
<body>
	<?php
	if(!count($datos)){
		echo 'No hay Eventos';
	}else{

	?>
	<table>
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Descripcion</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($datos as $dato) {
			?>
			<tr>
				<td><?php echo escape($dato->Nombre);?></td>
				<td><?php echo escape($dato->Descripcion);?></td>
			</tr>
			<?php }?>
		</tbody>
	</table>
	<?php }?>

</body>
</html>