<?php
	session_start();

	if($_SESSION['validacion'] == 1){

		require "../Modelo/connect.php";
		if(!empty($_POST)){
			$IdDonacion = trim($_POST["IdDonacion"]);
			$Titulo = trim($_POST["titulo"]);
			$Texto = trim($_POST["texto"]);
			$Modifico = trim($_SESSION["user"]);

			if(!empty($IdDonacion) && !empty($Titulo) && !empty($Texto) && !empty($Modifico)){

				if(isset($_POST['editButton'])){
					$editQuery = "UPDATE Donacion 
								  SET Titulo='$Titulo',
								  	  Texto ='$Texto',
								      Modifico = '$Modifico'
								  WHERE  idDonacion ='$IdDonacion'";

					if ($db->query($editQuery) === TRUE) {
						echo "<script>alert('Modificado correctamente')</script>";
					} else {
					echo "<script>alert(' ". $editQuery . "<br>" . $db->error .")</script>";
					}
				};
			}
		}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Unidas Contigo Web Manager/Donacion</title>
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
					<li><a href="Usuarios.php">Usuarios</a></li>
					<li><a href="Testimonios.php">Testimonios</a></li>
					<li><a href="Educacion.php">Educación</a></li>
					<li><a href="Informacion.php">Información</a></li>
					<li class="current_page_item"><a href="Donacion.php">Donación</a></li>
				</ul>
			</div>
		</div>
		<!-- end #menu --> 
		<div id="page" class="container">
			<div id="content">
				<div id="breadcrumb2">
					<ul class="crumbs2">
						<li class="first"><a href="#">Donación</a></li>          
					</ul>
				</div>
				<?php
					$data = $db->query("SELECT * FROM Donacion");
					$secciones = array();

					while($object = mysqli_fetch_object($data)){
						$secciones[]=$object;
					}

					//create table
					$table_str='<div>';
					$x = 1;
					foreach ($secciones as $seccion) {
						$table_str.='<form style="float:center;" action="Donacion.php" name="form'.$x.'" method="POST">';
						$table_str.='<div class="form-style-8">';
						$table_str.='<button type="submit" name="editButton" class="editButton2" display="block"></button>';
						$table_str.='<h2><input style="color:white;" type="text" id="tit'.$x.'" name="titulo" value="'.$seccion->Titulo.'" onchange="validateChar(this)" required></h2>';
						$table_str.='<textarea id="tex'.$x.'" name="texto" placeholder="Texto sobre Donacion" onclick="adjust_textarea(this)" onchange="validateChar(this)" required>'.$seccion->Texto.'</textarea>';
						$table_str.='<label>Creado por : '.$seccion->Creador.' </label><br>';
						$table_str.='<label>Modificado por : '.$seccion->Modifico.' </label>';
						$table_str.='<input type="hidden" name="IdDonacion" value="'.$seccion->idDonacion.'"">';
						$table_str.='</form>';
						$table_str.='</div>';
						$table_str.='<br>';
						$table_str.='<br>';
						$x++;
					}
					$table_str.='</div>';
					echo $table_str;
				?>
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
</body>
</html>
<script type="text/javascript">
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