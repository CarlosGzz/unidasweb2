<?php
	//Crear Modulo Seccion
	session_start();

	if($_SESSION['validacion'] == 1){

		require "../Modelo/connect.php";

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Unidas Contigo Web Manager/CrearSección</title>
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
						<li class="first"><a href="Usuarios.php">Usuarios</a></li>
						<li class="last"><a href="#">Crear Modulo de Sección</a></li>             
					</ul>
				</div>
				<div class="form-style-8">
					<h2>Crear Seccion</h2>
					<form action="CrearModuloSeccion.php" name="form" method="POST">
					    <input type="text" id="tit" name="titulo" maxlength="45" placeholder="Titulo de Modulo" onchange="validateChar(this)" required />
					    <textarea type="text" id="tex" name="texto" maxlength="200" placeholder="Contenido del Modulo Informativo" onchange="validateChar(this)" required ></textarea>
					    <?php
					    $data = $db->query("SELECT * FROM InformacionSeccion");
						$secciones = array();
						while($object = mysqli_fetch_object($data)){
							$secciones[]=$object;
						}

						$table_str='<div>';
						foreach ($secciones as $seccion) {
							$table_str.='<input type="radio" name="id" value="'.$seccion->IdSeccion.'" >'.$seccion->Titulo.'  ';
						}
						$table_str.='<div>';
						$table_str.='<br>';
						echo $table_str;
					    ?>
					    <input type="submit" name="crearModulo" value="Crear Usuario" />
				  	</form>
				</div>
				</form>
				<?php
					require "../Modelo/connect.php";
					if(!empty($_POST)){
						$Titulo = $_POST["titulo"];
				      	$Texto = $_POST["texto"];
				      	$IdSeccion = $_POST["id"];
				      	$Username = $_SESSION["user"];
				      	if(!empty($_POST["titulo"]) && !empty($_POST["texto"]) && !empty($_POST["id"])){
					      	if(isset($_POST['crearModulo'])){

			      				$sql = "INSERT INTO Informacion 
			      						(Titulo, Texto, Creador, IdSeccion)
			      						VALUES 
			      						('$Titulo','$Texto','$Username', '$IdSeccion' )";

			      				if ($db->query($sql) === TRUE) {
			          			echo "<script> alert('Nuevo Modulo Creado Exitosamente')</script>";
			      				} else {
			          			echo "Error: " . $sql . "<br>" . $db->error;
			      				}
			      			}
			      		}
	   				}   
      				$db->close();
				?>
			</div>
		</div>
	</div>
</body>
</html>
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
	};
</script>
<?php

	}else{
		header("Location: ..");
	}
?>