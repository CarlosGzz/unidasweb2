<?php

	function get_products(){
		$servername = "localhost";
		$username = "root";
		$password = "kobyjzt";

		// Create connection
		$conn = new mysqli($servername, $username, $password);

		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		$db = mysqli_select_db($conn,'UnidasBD');
		if(!$db){
			die('cannot connect to database');
		}
		$query="select * from eventos";
		$data = mysqli_query($conn, $query);

		$products =array();

		while($object = mysqli_fetch_object($data)){
			$products[]=$object;
		}
		mysqli_close($conn);
		return $products;
	}

	function get_table(){
		//create table
		$products = get_products();
		$table_str='<table id="t1">';
		$table_str.='<thead>';
		$table_str.='<tr>';
		$table_str.='<th>Nombre del Evento</th>';
		$table_str.='<th>Descripción</th>';
		$table_str.='<th>Lugar</th>';
		$table_str.='<th>Fecha de Inicio</th>';
		$table_str.='<th>Fecha de Final</th>';
		$table_str.='<th id="thButtons">Crear Evento</th>';
		$table_str.='<th id="thButtons"><a href="CrearEvento.php"><button class="addButton"></button></a></td>';		
		$table_str.='</tr>';
		$table_str.='</thead>';
		$table_str.='<tbody>';


		foreach ($products as $product) {
			$table_str.='<tr>';
			$table_str.='<td>'.$product->Nombre.'</td>';
			$table_str.='<td>'.$product->Descripcion.'</td>';
			$table_str.='<td>'.$product->Lugar.'</td>';
			$table_str.='<td>'.$product->FechaInicio.'</td>';
			$table_str.='<td>'.$product->FechaFinal.'</td>';
			$table_str.='<td id="tdButtons"><button class="editButton"></button></td>';
			$table_str.='<td id="tdButtons"><button class="deleteButton onclick="deleteFromDB()"></button></td>';
			$table_str.='</tr>';
		}
		$table_str.='</tbody>';
		$table_str.='<tfoot>';
		$table_str.='<tr>';
		$table_str.='</tr>';
		$table_str.='</tfoot>';
		$table_str.='</table>';
		return $table_str;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Unidas Contigo Web Manager/Eventos</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--Font-->
	<link href='http://fonts.googleapis.com/css?family=Josefin+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<!--- StyleSheet---->
	<link rel="stylesheet" href="CSS/default.css">
	<!--- Jquery---->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>
<!-- Body -->
<body>
	<?php echo get_table();?>
</body>
</html>