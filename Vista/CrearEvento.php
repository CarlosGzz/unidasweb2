<?php
	session_start();

	if($_SESSION['validacion'] == 1){
		require "../Modelo/connect.php";
		if(!empty($_POST)){
			$Nombre = trim($_POST["nombre"]);
			$Descripcion = trim($_POST["descripcion"]);
			$Lugar = trim($_POST["lugar"]);
			$FechaInicio = trim($_POST["fechaI"]);
			$FechaFinal = trim($_POST["fechaF"]);
			$Username = trim($_SESSION['user']);

			if(!empty($Nombre) && !empty($Descripcion) && !empty($Lugar) && !empty($FechaInicio) && !empty($FechaFinal) && !empty($Username)){
				$sql = "INSERT INTO Eventos (Nombre, Descripcion, Lugar, FechaInicio, FechaFinal, Username)
				VALUES ('$Nombre', '$Descripcion', '$Lugar', '$FechaInicio', '$FechaFinal','$Username')";
				if ($db->query($sql) === TRUE) {
					echo "<script> alert('Nuevo Evento Guardado')</script>";
				} else {
					echo "Error: " . $sql . "<br>" . $db->error;
				}
			}else{
				echo"Error No hay o Faltan Datos";
			};
		}; 
		$db->close();
				  

?>

<!DOCTYPE html>

<html>
<head>
	<meta charset="UTF-8">
	<title>Unidas Contigo Web Manager/Crear Eventos</title>
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
						<li class="first"><a href="Eventos.php">Eventos</a></li>
						<li class="last"><a href="#">Crear Evento</a></li>           
					</ul>
				</div>
				<div class="form-style-8">
					<h2>Crear Evento</h2>
					<form action="CrearEvento.php" name="form" onsubmit=" return validateForm()" method="POST">
					    <input type="text" maxlength="140" id="nombre" name="nombre" placeholder="Nombre Del Evento" onchange="validateChar(this)" required />
					    <textarea name="descripcion" id="descripcion" maxlenght="400" placeholder="Descripcion" onkeyup="adjust_textarea(this)" onchange="validateChar(this)" required></textarea>
					    <input type="text" maxlength="140" id="lugar" name="lugar" placeholder="Direccion del Evento" onchange="validateChar(this)" />
					    Fecha Inicial<input type="date" id="fechaI" name="fechaI" placeholder="Fecha Inicial (YYYY-MM-DD)" onchange="return validateForm2()" required />
					    <input type="time" name="hora" value="12:00" required />
					    Fecha Final<input type="date" id="fechaF" name="fechaF" placeholder="Fecha Final(YYYY-MM-DD)" onchange="return validateForm2()" required />
					    <input type="submit" name="crearEvento" value="Crear Evento" />
				  	</form>
				</div>
			</div>
		</div>
	</div>

<!-- Latest compiled and minified JavaScript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script type="text/javascript">
	//auto expand textarea
	function adjust_textarea(h) {
    	h.style.height = "20px";
    	h.style.height = (h.scrollHeight)+"px";
	}
	</script>
	<script type="text/javascript">
		function validateForm() {
			var fi = document.forms["form"]["fechaI"].value;
			var ff = document.forms["form"]["fechaF"].value;
			if (fi>ff){
				alert("La fecha final no puede ser menor a la inicial");
				return false;
			}
		}
		function validateForm2() {
			
			var fi = document.forms["form"]["fechaI"].value;
			var ff = document.forms["form"]["fechaF"].value;
			var d = new Date();

			var month = d.getMonth()+1;
			var day = d.getDate();

			var output = d.getFullYear() + '-' +
			    ((''+month).length<2 ? '0' : '') + month + '-' +
			    ((''+day).length<2 ? '0' : '') + day;
			
			if (fi<output){
				alert("La fecha inicial no puede ser en el pasado");
				var elem = document.getElementById("fechaI");
				elem.value = output;

			}
			if (fi>ff){
				alert("La fecha final no puede ser menor a la inicial");
				var elem = document.getElementById("fechaF");
				elem.value = fi;
			}
		}
		function validateChar(x){
		    var TCode = x.value;
		    var id = x.id;
		    var regex = new RegExp("^[a-zA-Z0-9\\-\\s]+$");
		    if(TCode.indexOf("@") > -1){
		    	TCode = TCode.replaceAll("@","");
		    }
		    if(TCode.indexOf("?") > -1){
		    	TCode = TCode.replaceAll("?","")
		    }
		    if(TCode.indexOf("!") > -1){
		    	TCode = TCode.replaceAll("!","");
		    }
		    if(TCode.indexOf("¡") > -1){
		    	TCode = TCode.replaceAll("¡","");
		    }
		    if(TCode.indexOf("¿") > -1){
		    	TCode = TCode.replaceAll("¿","");
		    }
		    if(TCode.indexOf(".") > -1){
		    	TCode = TCode.replaceAll(".","");
		    }
		    if(TCode==""){
		    	return ;
		    }
		    if( !regex.test( TCode ) ) {
		    	document.getElementById(id).value= null;
		        alert('No se permite ingresar caracteres especiales');
		    }
		}
		String.prototype.replaceAll = function(target, replacement) {
  			return this.split(target).join(replacement);
		};

	</script>
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