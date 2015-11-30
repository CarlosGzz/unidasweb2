<?php
	session_start();

	if($_SESSION['validacion'] == 1){

?>

<!DOCTYPE html>

<html>
<head>
	<meta charset="UTF-8">
	<title>Unidas Contigo Web Manager/CrearTestimonios</title>
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
					<li><a href="Eventos.php">Eventos</a></li>
					<li><a href="Foros.php">Foros</a></li>
					<li><a href="Usuarios.php">Usuarios</a></li>
					<li class="current_page_item"><a href="Testimonios.php">Testimonios</a></li>
					<li><a href="Educacion.php">Educación</a></li>
					<li><a href="Informacion.php">Información</a></li>
					<li><a href="Donacion.php">Donación</a></li>
				</ul>
			</div>
		</div>
		<!-- end #menu --> 

		<div id="page" class="container">
			<div id="content">
				<div id="breadcrumb2">
					<ul class="crumbs2">
						<li class="first"><a href="Testimonios.php">Testimonio</a></li>
						<li class="last"><a href="#">Crear Testimonio</a></li>           
					</ul>
				</div>
				<div class="form-style-8">
					<h2>Crear Testimonio</h2>
					<form action="CrearTestimonio.php" name="form" onsubmit="return confirm()" method="POST">
					    <input type="text" id="nombre" name="nombre" placeholder="Nombre de la Persona"  onchange="validateChar(this)" required />
					    <textarea maxlength="200" id="frase" name="frase" placeholder="Frase Inspiracional" onkeyup="adjust_textarea(this)" onchange="validateChar(this)"required></textarea>
					    <textarea maxlength="600" id="testimonio" name="testimonio" placeholder="Testimonio" onkeyup="adjust_textarea(this)" onchange="validateChar(this)"required></textarea>
					    <input type="submit" name="crearTestimonio" value="Crear Testimonio" />
				  	</form>
				</div>
				<?php
					require "../Modelo/connect.php";
					if(!empty($_POST)){
						$Nombre = trim($_POST["nombre"]);
						$Frase = trim($_POST["frase"]);
						$Testimonio = trim($_POST["testimonio"]);
						$Username = trim($_SESSION["user"]);
						
						if(!empty($Nombre) && !empty($Frase) && !empty($Testimonio)){

							$sql = "INSERT INTO Testimonios (NombrePersona, Frase, Testimonio, Creador)
							VALUES ('$Nombre', '$Frase', '$Testimonio', '$Username')";
							if ($db->query($sql) === TRUE) {
								echo "<script> alert('Nuevo Testimonio Creado Correctamente')</script>";
							} else {
								echo "Error: " . $sql . "<br>" . $db->error;
							}
						}
				   }  
				    $db->close();
				   ?>
			
			</div>
		</div>
	</div>

<!-- Latest compiled and minified JavaScript -->
	<div id="copyright" class = "container">Icons made by 
		<a href="http://www.flaticon.com/authors/google" title="Google">Google</a> 
		from 
		<a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a>
		is licensed by 
		<a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a>
	</div>

</body>
</html>
<script type="text/javascript">
	function adjust_textarea(h) {
    	h.style.height = "20px";
    	h.style.height = (h.scrollHeight)+"px";
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
<?php

	}else{
		header("Location: ..");
	}
?>