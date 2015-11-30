<?php
	session_start();

	if($_SESSION['validacion'] == 1){

		require "../Modelo/connect.php";
		if(!empty($_POST)){
			if(!empty($_POST['IdModulo'])){
				if(isset($_POST['editButton2'])){
					$IdModulo = trim($_POST["IdModulo"]);
					$Titulo = trim($_POST["titulo"]);
					$Texto = trim($_POST["texto"]);
					$GLOBALS['IdTipo'] = trim($_POST["IdTipo"]);
					$Modificado = $_SESSION['user'];
					$editQuery = "UPDATE Modulo 
								  SET Titulo='$Titulo',
								  	  Texto ='$Texto',
								      Modificado = '$Modificado'
								  WHERE  IdModulo ='$IdModulo' and IdTipo =$IdTipo ";

					if ($db->query($editQuery) === TRUE) {
						echo "<script>alert('modificado correctamente')</script>";
					} else {
					echo "Error: " . $editQuery . "<br>" . $db->error;
					}
				};

				if(isset($_POST['deleteButton'])){
					$IdModulo = trim($_POST["IdModulo"]);
					$GLOBALS['IdTipo'] = trim($_POST["IdTipo"]);
					$deleteQuery = "DELETE 
									FROM Modulo 
									WHERE IdModulo ='$IdModulo' and IdTipo =$IdTipo ";

					if ($db->query($deleteQuery) === TRUE) {
						echo "<script>alert('eliminado correctamente')</script>";
					} else {
					    echo "Error deleting record: " . $db->error;
					}
				};
			};
		};

		if(isset($_POST['editButton'])){
			if(!empty($_POST)){
				if(!empty($_POST['IdTipo'])){
					$GLOBALS['IdTipo']= trim($_POST["IdTipo"]);
					
				}else{
					$Tipo = trim($_POST["tipo"]);
					$data = $db->query("SELECT * FROM Educacion WHERE Tipo='$Tipo'");

					while($object = mysqli_fetch_object($data)){
						$tipo=$object;
					}
					$GLOBALS['IdTipo'] = $tipo->IdTipo;
					
				}
			};
		};

		if(!empty($_POST)){
			if(isset($_POST['modificar'])){
				$Icono = trim($_POST["icono"]);
				$Tipo = trim($_POST["tipo"]);
				$Modificado = trim($_SESSION["user"]);
				$GLOBALS['IdTipo']= trim($_POST["IdTipo"]);
				if(!empty($_POST['IdTipo'])){
					$editQuery = "UPDATE Educacion 
								  SET Icono='$Icono',
									  Tipo = '$Tipo',
									   Modificado = '$Modificado'
								   WHERE  IdTipo =$IdTipo ";
					if ($db->query($editQuery) === TRUE) {
						echo "<script>alert('modificado correctamente')</script>";
					} else {
						echo "Error: " . $editQuery . "<br>" . $db->error;
					}
				};
			};
		};
		if(!empty($_POST)){
			if(isset($_POST['crearTipo'])){
				$Icono = trim($_POST["Icono"]);
				$Tipo = trim($_POST["Tipo"]);
				$Username = trim($_SESSION["user"]);
				if(!empty($Icono) && !empty($Tipo) && !empty($Username)){
					$sql = "INSERT INTO Educacion (Icono, Tipo, Creador)
							VALUES ('$Icono', '$Tipo', '$Username')";
					if ($db->query($sql) === TRUE) {
						echo "<script> alert('Nuevo Modulo Creado Correctamente')</script>";
						$data = $db->query("SELECT * FROM Educacion WHERE Tipo='$Tipo'");

						while($object = mysqli_fetch_object($data)){
							$tipo=$object;
						}

						$GLOBALS['IdTipo'] = $tipo->IdTipo;
					} else {
						echo "Error: " . $sql . "<br>" . $db->error;
					}
				};
			};
		};

		if(!empty($_GET['idTipo'])){
			$GLOBALS['IdTipo'] = trim($_GET["idTipo"]);
			echo "HOLY SHIT";
		}


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Unidas Contigo Web Manager/Modulo Educativo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--Font-->
	<link href='http://fonts.googleapis.com/css?family=Josefin+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<!--- StyleSheet---->
	<link rel="stylesheet" href="CSS/default.css">
	<!--- Jquery---->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
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
						<li class="first"><a href="#">Educación</a></li>
						<li class="last"><a href="#">Modulo</a></li>         
					</ul>
				</div>
				<?php
					$data =mysqli_query($db,"SELECT Tipo,Icono,Creador FROM Educacion WHERE IdTipo='$IdTipo' LIMIT 1");
					$row = mysqli_fetch_assoc($data);
					$Tipo = $row['Tipo'];
					$Icono = $row['Icono'];
					$Creador = $row['Creador'];
					

				?>
				<div class="form-style-8">
					<h2>Tipo de Cancer</h2>
					<form action="Modulo.php" id="edit" name="form" onsubmit=" return validateForm()" method="POST">
						<img src="<?php echo $Icono; ?>">
						<input type="url" id="icono" name="icono" placeholder="<?php echo $Icono; ?>" onchange="validateLink(this)" required  readonly/>
						<input type="text" id="tipo" name="tipo" placeholder="<?php echo $Tipo; ?>" onchange="validateChar(this)" required readonly/>
						<input type="hidden" name="IdTipo" value="<?php echo $IdTipo?>">
						<label>Creado por : <?php echo $Creador; ?></label>
						<br>
						<br>
						<input type="submit" name="modificar" value="Editar Modulo" />
					</form>
				</div>
				<br>
				<br>
				<?php
					$data = $db->query("SELECT * FROM Modulo WHERE IdTipo=$IdTipo");
					$modulos = array();

					while($object = mysqli_fetch_object($data)){
						$modulos[]=$object;
					}

					//create table
					$table_str='<table id="t1">';
					$table_str.='<form id="form" action="CrearModulo.php" method="POST">';
					$table_str.='<thead>';
					$table_str.='<tr>';
					$table_str.='<th>#DeModulo</th>';
					$table_str.='<th>Titulo</th>';
					$table_str.='<th>Texto</th>';
					$table_str.='<th id="thButtons">Crear Nuevo</th>';
					$table_str.='<input form="form" type="hidden" name="idTipo" value="'.$IdTipo.'">';
					$table_str.='<th colspan="2" id="thButtons"><button name="addButton" class="addButton"></button></td>';
					$table_str.='</tr>';
					$table_str.='</thead>';
					$table_str.='</form>';
					$table_str.='<tbody>';
					$x = 1;
					foreach ($modulos as $modulo) {
						$table_str.='<form id="form'.$x.'" action="Modulo.php" method="POST" onsubmit="return confirm();">';
						$table_str.='<tr>';
						$table_str.='<td><input form="form'.$x.'" class="inputX" name="IdModulo" type="text", value="'.$modulo->IdModulo.'" readonly></td>';
						$table_str.='<td><input form="form'.$x.'" id="tit'.$x.'" class="input" name="titulo" type="text", value="'.$modulo->Titulo.'" onchange="validateChar(this)"></td>';
						$table_str.='<td><input form="form'.$x.'" id="tex'.$x.'" class="input" name="texto" type="text", value="'.$modulo->Texto.'" onchange="validateChar(this)"></td>';
						$table_str.='<input form="form'.$x.'" type="hidden" name="IdTipo" value="'.$IdTipo.'">';
						$table_str.='<td id="tdButtons"><button type"submit" name="editButton2" class="editButton"></button></td>';
						$table_str.='<td id="tdButtons"><button type"submit" name="deleteButton" class="deleteButton"></button></td>';
						$table_str.='</tr>';
						$table_str.='</form>';
						$x ++;
					}
					$table_str.='</table>';
					echo $table_str;
				?>
			</div>
		</div>
<!-- Latest compiled and minified JavaScript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script type="text/javascript">
	

   	$(".form-style-8").click(function(){
   		$(this).find("input").each(function(){
   			$(this).attr("readonly",false);
   		});
   	});
	</script>
		<div id="copyright" class = "container">Icons made by 
		<a href="http://www.flaticon.com/authors/google" title="Google">Google</a> 
		from 
		<a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a>
		is licensed by 
		<a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a>
		</div>
	</div>
	<script type="text/javascript">
	$("#t1 tr").click(function(){
		if($(this).attr("class")!="selected"){
   			$(this).addClass('selected').siblings().removeClass('selected');
   			
   			$("textarea.inputY").each(function() {
		   		$(this).removeClass("inputY").addClass("inputX")
		   		$(this).attr("rows", "1");
			}); 
    		$(this).find("textarea.inputX").each(function() {
    			$(this).removeClass("inputX");
    			$(this).attr("rows", "6");
		   		$(this).addClass('inputY').siblings().removeClass('inputX');
			});
			$("input.input2").each(function() {
		    	$(this).removeClass("input2").addClass("input")
			}); 
			$(this).find("input.input").each(function() {
				$(this).addClass('input2').siblings().removeClass('input');
			}); 
    	}
	});

	</script>
</body>
</html>
<script type="text/javascript">

	function validateLink(x){
		var TCode = x.value;
	    var id = x.id;
	    if(TCode.indexOf("'") > -1){
	    	document.getElementById(id).value= null;
	        alert('No se permite ciertos caracteres especiales');
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