<?php
	//Informacion
	session_start();

	if($_SESSION['validacion'] == 1){

		require "../Modelo/connect.php";
		if(!empty($_POST)){
			if(!empty($_POST["idSeccion"])){
			$Titulo1 = trim($_POST["titulo1"]);
			$IdSeccion = trim($_POST["idSeccion"]);}

			if(!empty($Titulo1) && !empty($IdSeccion)){

				if(isset($_POST['editButton'])){
					$editQuery = "UPDATE InformacionSeccion 
								  SET Titulo='$Titulo1'
								  WHERE  IdSeccion ='$IdSeccion' ";

					if ($db->query($editQuery) === TRUE) {
						echo "<script>alert('modificado correctamente')</script>";
					} else {
					echo "Error: " . $editQuery . "<br>" . $db->error;
					}
				};

				if(isset($_POST['deleteButton'])){

					$deleteQuery = "DELETE 
									FROM InformacionSeccion 
								 	WHERE  IdSeccion ='$IdSeccion' ";

					if ($db->query($deleteQuery) === TRUE) {
						echo "<script>alert('eliminado correctamente')</script>";
					} else {
					    echo "Error deleting record: " . $db->error;
					}
				};
			};

			if(!empty($_POST['titulo2']) && !empty($_POST['texto']) && !empty($_POST['idInfo'])){
				$Titulo2 = trim($_POST["titulo2"]);
				$Texto = trim($_POST["texto"]);
				$IdInfo = trim($_POST["idInfo"]);
				$Modifico = trim($_SESSION["user"]);

				if(isset($_POST['editButton2'])){
					$editQuery = "UPDATE Informacion 
								  SET Titulo='$Titulo2',
								  	  Texto='$Texto',
								  	  Modifico='$Modifico'
								  WHERE  IdInfo ='$IdInfo' ";
					if ($db->query($editQuery) === TRUE) {
						echo "<script>alert('modificado correctamente')</script>";
					} else {
					echo "Error: " . $editQuery . "<br>" . $db->error;
					}
				};

				if(isset($_POST['deleteButton2'])){

					$deleteQuery = "DELETE 
									FROM Informacion 
								 	WHERE  IdInfo ='$IdInfo' ";

					if ($db->query($deleteQuery) === TRUE) {
						echo "<script>alert('eliminado correctamente')</script>";
					} else {
					    echo "Error deleting record: " . $db->error;
					}
				};
			};
		};

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Unidas Contigo Web Manager/Informacion</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--Font-->
	<link href='http://fonts.googleapis.com/css?family=Josefin+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<!--- StyleSheet---->
	<link rel="stylesheet" href="CSS/default.css">
	<!--- ShortCut ICON---->
	<link rel="shortcut icon" href="http://viaggatore.com/unidascontigo/wp-content/uploads/2015/04/unidas-contigo-fav.png">
	<!--- Jquery---->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!---Extra Styiling---->
</head>
<body>
	<div id="wrapper">
		<div id="header-wrapper">
			<div id="header" class="container">
				<div id="logo">
					<h1 id="titulo">Unidas Contigo A.C.</h1>
					<p style="margin-left:10px;"><small>web manager</small></p>
				</div>
				<div id="session">
					<?php
					    $sestring=" <span id='session'>".$_SESSION['user']." <br>";
						$sestring.=" ".$_SESSION['nom']." ".$_SESSION['ape']." <br></span>";
						echo $sestring;
					?>
					<a href=".."> Cerrar Session </a>
				</div>
			</div>
		</div>
		<!-- end #head-wrapper--> 
		<div id="menu-wrapper">
			<div id="menu" >
				<ul>
					<li><a href="Eventos.php">Eventos</a></li>
					<li><a href="Foros.php">Foros</a></li>
					<li><a href="Usuarios.php">Usuarios</a></li>
					<li><a href="Testimonios.php">Testimonios</a></li>
					<li><a href="Educacion.php">Educación</a></li>
					<li class="current_page_item"><a href="Informacion.php">Información</a></li>
					<li><a href="Donacion.php">Donación</a></li>
				</ul>
			</div>
		</div>
		<!-- end #menu --> 
		<div id="page" class="container">
		<div id="content">
			<div id="breadcrumb2">
				<ul class="crumbs2">
					<li class="first"><a href="#">Información</a></li>          
				</ul>
			</div>
			<?php
				$data = $db->query("SELECT * FROM InformacionSeccion");
				$secciones = array();
				while($object = mysqli_fetch_object($data)){
					$secciones[]=$object;
				}


				//create table
				$table_str='<div>';
				$x=0;
				$v= "'Confirmar cambio o modificación'";

				foreach ($secciones as $seccion) {
					$table_str.='<form action="Informacion.php"  method="POST" onsubmit="return confirm('.$v.');">';
					$table_str.='<table id="t2" name="table'.$x.'">';
					$table_str.='<tbody>';
					$table_str.='<tr id="Padre">';
					$table_str.='<td><input id="input" class="input" name="titulo1" type="text", value="'.$seccion->Titulo.'" ></td>';
					$table_str.='<td id="tdButtons"><button type"submit" name="editButton" class="editButton"></button></td>';
					$table_str.='<td id="tdButtons"><button type"submit" name="deleteButton" class="deleteButton"></button></td>';
					$table_str.='<td id="arrow" class="arrowUP"><input id="input" name="idSeccion" type="hidden", value="'.$seccion->IdSeccion.'" ></td>';
					$table_str.='</tr>';
					$idSec= $seccion->IdSeccion;

					$data = $db->query("SELECT * FROM Informacion WHERE IdSeccion=$idSec");
					$informacion = array();
					while($object = mysqli_fetch_object($data)){
						$informacion[]=$object;
					}
					$y=0;

					foreach ($informacion as $info){
						$table_str.='<form action="Informacion.php" method="POST" onsubmit="return confirm('.$v.');">
										<tr class="hide" id="Hijo">
											<td colspan="2"><input id="input" class="input" name="titulo2" type="text" value="'.$info->Titulo.'" ></td>
											<td id="tdButtons"><button type"submit" name="editButton2" class="editButton"></button></td>
											<td id="tdButtons"><button type"submit" name="deleteButton2" class="deleteButton"></button></td>
										</tr>
										<tr class="hide" id="Hijo2">
											<td colspan="3"><textarea rows="6" id="input" name="texto" type="text" >'.$info->Texto.'</textarea></td>
											<td><input id="input" name="idInfo" type="hidden" value="'.$info->IdInfo.'" ></td>
										</tr>
									</form>';
						$y++;
					}
					$table_str.='</form>';
					$table_str.='</table>';
					$x++;
				}
				echo $table_str;
			?>
		</div>
		<br>
		<br>
		<a href=CrearSeccion.php><button class="but">Añadir Seccón</button></a>
		<br>
		<br>
		<a href=CrearModuloSeccion.php><button class="but">Añadir Modulo</button></a>
		
	</div>
	</div>
<!-- Latest compiled and minified JavaScript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script type="text/javascript">
	$("table").click(function(){

		$("#t2 tr#Padre").removeClass('selected');
		$("table").find("tr#Hijo").each(function(){
	   		$(this).addClass('hide');
		});

	   	$(this).find("#Padre").addClass('selected');
	   	$(this).find("tr#Hijo").each(function(){
	   		$(this).removeClass('hide');
	   	});

	   	$("tr#Hijo").click(function(){
	   		$("table").find("tr#Hijo2").each(function(){
	   			$(this).addClass('hide');
	   		});
	   		$(this).closest('tr').next('tr').removeClass('hide');
	   	});

   	});
	</script>
</body>
</html>
<?php

	}else{
		header("Location: ..");
	}
?>