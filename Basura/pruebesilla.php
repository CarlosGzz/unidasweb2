<?php
	session_start();
	$GLOBALS["off"]=intval(0);

	if($_SESSION['validacion'] == 1){

		require "../Modelo/connect2.php";
	if(!empty($_POST)){
		if(!empty($_POST['idEvento'])){
			$IdEvento = trim($_POST["idEvento"]);
			$Nombre = trim($_POST["nombre"]);
			$Descripcion = trim($_POST["descripcion"]);
			$Lugar = trim($_POST["lugar"]);
			$FechaInicio = trim($_POST["fechaI"]);
			$Hora = trim($_POST["hora"]);
			$FechaFinal = trim($_POST["fechaF"]);

			if(isset($_POST['editButton'])){
				$editQuery = "UPDATE eventos 
							  SET Nombre='$Nombre',
							  	  Descripcion ='$Descripcion',
							      Lugar = '$Lugar',
							      FechaInicio = '$FechaInicio',
							      Hora = '$Hora',
							      FechaFinal ='$FechaFinal'
							  WHERE  IdEvento ='$IdEvento'";

				if ($db->query($editQuery) === TRUE) {
					echo "Evento $Nombre modificado correctamente";
				} else {
				echo "Error: " . $editQuery . "<br>" . $db->error;
				}
			};

			if(isset($_POST['deleteButton'])){
					$deleteQuery = "DELETE 
									FROM eventos 
									WHERE IdEvento ='$IdEvento'";

					if ($db->query($deleteQuery) === TRUE) {
					    echo " Evento $Nombre eliminado correctamente";
					} else {
					    echo "Error deleting record: " . $db->error;
					}
			};
		};
	};

	function fill($off){
		require "../Modelo/connect.php";
		$data = $db->query("SELECT * FROM eventos ORDER BY FechaInicio  LIMIT 10 OFFSET $off ");
				$events = array();
				while($object = mysqli_fetch_object($data)){
					$events[]=$object;
				}
				//create table
				$table_str='<table id="t1">';
				$table_str.='<thead>';
				$table_str.='<tr>';
				$table_str.='<th>Nombre del Evento</th>';
				$table_str.='<th>Descripción</th>';
				$table_str.='<th>Lugar</th>';
				$table_str.='<th>Fecha de Inicio</th>';
				$table_str.='<th>Hora</th>';
				$table_str.='<th>Fecha de Final</th>';
				$table_str.='<th id="thButtons">Crear Evento</th>';
				$table_str.='<th id="thButtons"><a href="CrearEvento.php"><button class="addButton")></button></a></td>';
				$table_str.='</tr>';
				$table_str.='</thead>';
				$table_str.='<tbody>';

				foreach ($events as $event) {
					$table_str.='<form id="form" action="pruebesilla.php" method="GET" onsubmit="return confirm();">';
					$table_str.='<tr>';
					$table_str.='<td><input id="input" name="nombre" type="text" value="'.$event->Nombre.'" ></td>';
					$table_str.='<td><input id="input" name="descripcion" type="text" value="'.$event->Descripcion.'" ></td>';
					$table_str.='<td><input id="input" name="lugar" type="text" value="'.$event->Lugar.'" ></td>';
					$table_str.='<td><input id="input" name="fechaI" type="date" value="'.$event->FechaInicio.'" ></td>';
					$table_str.='<td><input id="input" name="hora" type="time" value="'.$event->Hora.'" ></td>';
					$table_str.='<td><input id="input" name="fechaF" type="date" onchange="validateForm()" value="'.$event->FechaFinal.'" ></td>';
					$table_str.='<td id="tdButtons" type="submit"><button type"submit" name="editButton" class="editButton" onclick="validateForm()"></button></td>';
					$table_str.='<td id="tdButtons" type="submit"><button type"submit" name="deleteButton" class="deleteButton"></button></td>';
					$table_str.='<td><input id="input" name="idEvento" type="hidden" value="'.$event->IdEvento.'" ></td>';
					$table_str.='</tr>';
					$table_str.='</form>';
		
				}
				$table_str.='<tfoot>';
				$table_str.='<tr>';
				$table_str.='</tr>';
				$table_str.='</tfoot>';
				$table_str.='</table>';
				echo $table_str;

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
	<link rel="stylesheet" href="../Vista/CSS/default.css">
</head>
<!-- Body -->
<body>
	<div id="wrapper">
		<!--Header (Header and logo, Menu)-->
		<div id="header-wrapper">
			<div id="header" class="container">
				<div id="logo">
					<h1 id="titulo">Unidas Contigo A.C.</h1>
					<p style="margin-left:10px;"><small>web manager</small> </p>
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
			<div id="menu">
				<ul>
					<li class="current_page_item"><a href="Eventos.php">Eventos</a></li>
					<li><a href="Foros.php">Foros</a></li>
					<li><a href="Usuarios.php">Usuarios</a></li>
					<li><a href="Testimonios.html">Testimonios</a></li>
					<li><a href="Educacion.html">Educación</a></li>
					<li><a href="Infromacion.html">Información</a></li>
					<li><a href="Donacion.html">Donación</a></li>
				</ul>
			</div>
		</div>
		<!-- end #menu --> 

		<div id="page" class="container">
		<div id="content">
			<div id="breadcrumb2">
				<ul class="crumbs2">
					<li class="first"><a href="#">Eventos</a></li>          
				</ul>
			</div>
			<?php
				if(!empty($_POST)){
					if (isset($_POST['less'])) {
						if(!empty($_POST['off'])){
							$off= $_POST['off'];
							if($off<=0){
								$off=0;
							}else{
								$off-=10;
							}
						}
					}
					if (isset($_POST['more'])) {
						if(!empty($_POST['off']) or $_POST['off']==0) {
							$off= $_POST['off'];
							$result=$db->query("SELECT COUNT(*) as totalEventos FROM Eventos ");
							$totalEventos=mysqli_fetch_assoc($result);
							if($off<=$totalEventos['totalEventos']-11){
								$off+=10;
							}
						}
					}
				}
				fill($off);
			?>
			<span class="limits">
				<form method="POST" name="limits" class="limits" >
					<input name="off" value="<?php echo $off; ?>" type="hidden"></input>
					<button id="less" name="less" type="submit"><</button>
					<span id="lim"><?php echo $off+10; ?></span>
					<button id="more "name="more"type="submit"> ></button>
				</form>
			</span>
		<script type="text/javascript">
		function validateForm() {
			var fi = document.forms["form"]["fechaI"].value;
			var ff = document.forms["form"]["fechaF"].value;
			if (fi>ff){
		        alert("La fecha final no puede ser menor a la inicial");
			}  
		}
		</script>
		<div class="cd-popup" role="alert">
			<div class="cd-popup-container">
				<p id="popP">Are you sure you want to delete this element?</p>
				<button class="no">no</button></a>
				<a href="pruebesilla.php"><button onclick="return true" class="si">si</button></a>
				<a href="#0" class="cd-popup-close img-replace">Close</a>
			</div> <!-- cd-popup-container -->
		</div> <!-- cd-popup -->
	</div>
	</div>

<!-- Javascript & Jquery-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script type="text/javascript">
	$("#t1 tr").click(function(){
   		$(this).addClass('selected').siblings().removeClass('selected');
   	});
   	$('#form').onsubmit('click', function(event){
		event.preventDefault();
		$('.cd-popup').addClass('is-visible');
	});
	</script>
	<script src="../Controlador/JS/main.js"></script>

	<div id="copyright" class = "container">Icons made by 
		<a href="http://www.flaticon.com/authors/google" title="Google">Google</a> 
		from 
		<a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a>
		is licensed by 
		<a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a>
	</div>
</body>
</html>
<?php

	}else{
		header("Location: ..");
	}
?>