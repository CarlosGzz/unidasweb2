<?php
	//Crear Modulo
	session_start();

	if($_SESSION['validacion'] == 1){

		require "../Modelo/connect.php";
		if(!empty($_POST)){
			if(!empty($_POST['idTipo'])){
				if(isset($_POST['addButton'])){
					$GLOBALS['IdTipo']= trim($_POST['idTipo']);
				};
			};
		};

		if(!empty($_POST)){
			if(isset($_POST['crearModulo2'])){
				$Titulo = trim($_POST["titulo"]);
				$Texto = trim($_POST["texto"]);
				$Username = trim($_SESSION["user"]);
				$GLOBALS['IdTipo'] = trim($_POST["idTipo"]);

				if(!empty($Titulo) && !empty($Texto) && !empty($IdTipo)){
					$sql = "INSERT INTO Modulo (Titulo, Texto, Creador, IdTipo)
							VALUES ('$Titulo', '$Texto', '$Username', '$IdTipo')";
					if ($db->query($sql) === TRUE) {
						echo "<script> alert('Nuevo Modulo Creado Correctamente')</script>";
					} else {
						"<script>alert('Error:  ". $sql . "<br>" . $db->error."')</script>";
					}
					$db->close();
				};
			};
		};
		

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Unidas Contigo Web Manager/Crear Modulo de Educación</title>
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
					<li class="current_page_item"><a href="Educacion.php">Educación</a></li>
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
					<li class="first"><a href="Educacion.php">Educación</a></li>
					<li><a href="Modulo.php?idTipo=<?php echo $IdTipo; ?>">Tipo</a></li>
					<li class="last"><a href="#">Crear Modulo</a></li>         
				</ul>
			</div>
				<div class="form-style-8">
					<h2>Modulo</h2>
					<form action="CrearModulo.php" name="form" method="POST">
						<input maxlength="140" id="tit" type="text" name="titulo" placeholder="Titulo" onchange="validateChar(this)" required />
					    <input maxlength="140" id="tex" type="text" name="texto" placeholder="Texto" onchange="validateChar(this)" required />
					    <input type="submit" name="crearModulo2" value="Crear Modulo" />
					    <input type="hidden" name="idTipo" value="<?php echo $IdTipo; ?>">
				  	</form>
				</div>

			</div>
		</div>
	</div>

<!-- Latest compiled and minified JavaScript -->
	<script type="text/javascript">

   	function validateChar(x){
		var TCode = x.value;
		var id = x.id;
		var regex = new RegExp("^[a-zA-Z0-9\\-\\s]+$");
		if(TCode.indexOf("'") > -1){
	    	document.getElementById
	    	document.getElementById(id).value= null;
	        alert('No se permite ingresar caracteres especiales');
	        return;
	    }
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
	   	if(TCode.indexOf("ñ") > -1){
	    	TCode = TCode.replaceAll("ñ","");
	    }
	    if(TCode.indexOf("ü") > -1){
	    	TCode = TCode.replaceAll("ü","");
	    }
	    if(TCode.indexOf(":") > -1){
	    	TCode = TCode.replaceAll(":","");
	    }
	    if(TCode.indexOf(",") > -1){
	    	TCode = TCode.replaceAll(",","");
	    }
	    if(TCode.indexOf("#") > -1){
	    	TCode = TCode.replaceAll("#","");
	    }
	    if(TCode.indexOf("(") > -1){
	    	TCode = TCode.replaceAll("(","");
	    }
	    if(TCode.indexOf(")") > -1){
	    	TCode = TCode.replaceAll(")","");
	    }
	    var accentRegex=new RegExp("[A-zÀ-ú]");
		if( accentRegex.test( TCode ) ) {
			TCode = TCode.replaceAll(accentRegex,"");
		}
	   	if(TCode==""){
	   		return ;		
		}
		if( !regex.test( TCode ) ) {
			document.getElementById
	    	document.getElementById(id).value= null;
	        alert('No se permite ingresar caracteres especiales');
	    }
	}
	String.prototype.replaceAll = function(target, replacement) {
  		return this.split(target).join(replacement);
	}

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