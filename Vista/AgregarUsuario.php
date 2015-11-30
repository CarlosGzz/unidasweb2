<?php
	session_start();

	if($_SESSION['validacion'] == 1){
		
		require "../Modelo/connect.php";
		if(!empty($_POST)){
			if(!empty($_POST['Username'])){
				$Nombre = $_POST["nombre"];
				$Apellido = $_POST["apellido"];
				$Username = $_POST["username"];
				$Nacimiento = $_POST["nacimiento"];
				$Correo = $_POST["correo"];
				$Contraseña = $_POST["contraseña"];
				$Prefijo	= $_POST["prefijo"];
				if(empty($_POST["autorizado"]))
					$Authorizado =0;
				else
					$Authorizado = 1;
				$sql = "INSERT INTO Usuarios 
						(Username, Contrasena, Nombre, Apellido, Nacimiento, Correo, Prefijo, Authorizado)
						VALUES 
						('$Username', '$Contraseña', '$Nombre', '$Apellido', '$Nacimiento', '$Correo', '$Prefijo', '$Authorizado')";
				if ($db->query($sql) === TRUE) {
					echo "<script> alert('Nuevo Usuario Creado Exitosamente')</script>";
				} else {
					echo "Error: " . $sql . "<br>" . $db->error;
				}	
				$db->close();
			}
		}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Unidas Contigo Web Manager/AgregarUsuario</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--Font-->
	<link href='http://fonts.googleapis.com/css?family=Josefin+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<!--- StyleSheet---->
	<link rel="stylesheet" href="CSS/default.css">
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
					<li class="current_page_item"><a href="Usuarios.php">Usuarios</a></li>
					<li><a href="Testimonios.php">Testimonios</a></li>
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
						<li class="first"><a href="Usuarios.php">Usuarios</a></li>
						<!--<li><a href="#">mas</a></li>
						<li><a href="#">mas</a></li>--> 
						<li class="last"><a href="#">Agregar Usuario</a></li>             
					</ul>
				</div>
				<div class="form-style-8">
					<h2>Agregar Usuario</h2>
					<form action="AgregarUsuario.php" name="form" onsubmit=" return validateForm()" method="POST">
					    <input type="text" id="nombre" name="nombre" maxlength="45" placeholder="Nombre" onchange="validateChar(this)"required />
					    <input type="text" id="apellido" name="apellido" maxlength="45" placeholder="Apellido" onchange="validateChar(this)" required />
					    <label for="nacimiento">Fecha de Nacimiento</label>
					    <input type="date" name="nacimiento" placeholder="Fecha De Nacimiento" onchange="validateForm()" required />
					    <input type="email" id="correo" name="correo" maxlength="45" placeholder="Correo" onchange="validateChar(this)" required/>
					    <input type="text" id="username" name="username" maxlength="10" placeholder="Username" onchange="validateChar(this)" required/>
					    <input type="password" id="password" name="contraseña" maxlength="20" placeholder="Contraseña" onchange="validateChar(this)" required/>
					    <input type="radio" name="prefijo" value="doc" required value="doc">Doctor
						<input type="radio" name="prefijo" value="admin" >Administrador
						<input type="radio" name="prefijo" value="user" >Usuario	
						<br><br>
						<input type="checkbox" name="autorizado" >Autorizado	
						<br><br>
					    <input type="submit" name="agregarUsuario" value="Crear Usuario" />
				  	</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	function adjust_textarea(h) {
    	h.style.height = "20px";
    	h.style.height = (h.scrollHeight)+"px";
	}
	
	function validateForm() {
			
		var nac = document.forms["form"]["nacimiento"].value;
		var d = new Date();
		var month = d.getMonth()+1;
		var day = d.getDate();
		var output = d.getFullYear() + '-' +
		    ((''+month).length<2 ? '0' : '') + month + '-' +
		    ((''+day).length<2 ? '0' : '') + day;
			
		if (nac>output){
			alert("La fecha de nacimiento no puede ser en el futuro");
			var elem = document.getElementById("nacimiento");
			elem.value = output;
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
<?php

	}else{
		header("Location: ..");
	}
?>