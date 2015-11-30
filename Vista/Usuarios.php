<?php
	//Usuarios
	session_start();
	$GLOBALS["off"]=intval(0);

	if($_SESSION['validacion'] == 1){

		require "../Modelo/connect.php";
		if(!empty($_POST)){
			if(!empty($_POST['username'])){
				$Authorizado = trim($_POST["autorizado"]);
				$Nombre = trim($_POST["nombre"]);
				$Username = trim($_POST["username"]);
				$Correo = trim($_POST["correo"]);
				$Nacimiento = trim($_POST["nacimiento"]);
				$Prefijo = trim($_POST["prefijo"]);

				if(isset($_POST['checkButton'])){
					$authorizeQuery = "UPDATE Usuarios 
								  	   SET Authorizado = 1
								       WHERE  Username ='$Username' AND Correo='$Correo'";

					if ($db->query($authorizeQuery) === TRUE) {
						echo "<script>alert('Usuario ".$Nombre." fue autorizado correctamente')</script>";
					} else {
						echo "<script>alert('Error:  ". $authorizeQuery . "<br>" . $db->error."')</script>";
					}
				};

				if(isset($_POST['deleteButton'])){

					$deleteQuery = "DELETE 
									FROM Usuarios 
									WHERE  Username ='$Username' AND Correo='$Correo'";

					if ($db->query($deleteQuery) === TRUE) {
						echo "<script>alert('Usuario ".$Nombre." fue eliminado correctamente')</script>";
					} else {
					    echo "<script>alert('Error al borrar: ". $db->error."')</script>";
					}
				};
			};
		};

		function fill($off){
			require "../Modelo/connect.php";
			$data = $db->query("SELECT * FROM Usuarios WHERE Authorizado=0 AND Prefijo!='user' ");
			$users = array();
			while($object = mysqli_fetch_object($data)){
				$users[]=$object;
			}
			//create table
			$table_str='<table id="t1">';
			$table_str.='<thead>';
			$table_str.='<tr>';
			$table_str.='<th>Nombre de Usuario</th>';
			$table_str.='<th>Username</th>';
			$table_str.='<th>Correo</th>';
			$table_str.='<th>Fecha de Nacimiento</th>';
			$table_str.='<th>Tipo de usuario</th>';
			$table_str.='<th id="thButtons">Agregar Usuario</th>';
			$table_str.='<th id="thButtons"><a href="AgregarUsuario.php"><button class="addButton"></button></a></td>';	
			$table_str.='</tr>';
			$table_str.='</thead>';
			$table_str.='<tbody>';
			$v= "'Confirmar cambio o modificación'";
			foreach ($users as $user) {
				$table_str.='<form action="Usuarios.php" method="POST" onsubmit="return confirm('.$v.');">';
				$table_str.='<tr>';
				$table_str.='<td><input class="input" name="nombre" type="text", value="'.$user->Nombre.' '.$user->Apellido.'" readonly="readonly"></td>';
				$table_str.='<td><input class="input" name="username" type="text", value="'.$user->Username.'" readonly="readonly"></td>';
				$table_str.='<td><input class="input" name="correo" type="text", value="'.$user->Correo.'" readonly="readonly"></td>';
				$table_str.='<td><input class="input" name="nacimiento" type="date", value="'.$user->Nacimiento.'"readonly="readonly" ></td>';
				$table_str.='<td><input class="input" name="prefijo" type="text", value="'.$user->Prefijo.'"readonly="readonly" ></td>';
				$table_str.='<td id="tdButtons"><button type"submit" name="checkButton" class="checkButton"></button></td>';
				$table_str.='<td id="tdButtons"><button type"submit" name="deleteButton" class="deleteButton"></button></td>';
				$table_str.='<td><input id="input" name="autorizado" type="hidden", value="'.$user->Authorizado.'" ></td>';
				$table_str.='</tr>';
				$table_str.='</form>';
			}
			$table_str.='</tbody>';
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
	<title>Unidas Contigo Web Manager/Usuarios</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--Font-->
	<link href='http://fonts.googleapis.com/css?family=Josefin+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<!--- StyleSheet---->
	<link rel="stylesheet" href="CSS/default.css">
	<!--- ShortCut ICON---->
	<link rel="shortcut icon" href="http://viaggatore.com/unidascontigo/wp-content/uploads/2015/04/unidas-contigo-fav.png">
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
						<li class="first"><a href="#">Foros</a></li>           
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
							};
						};
						if (isset($_POST['more'])) {
							if(!empty($_POST['off']) or $_POST['off']==0) {
								$off= $_POST['off'];
								$result=$db->query("SELECT COUNT(*) as totalUsuarios FROM Usuarios WHERE Authorizado=0 AND Prefijo!='user'  ");
								$totalUsuarios=mysqli_fetch_assoc($result);
								if($off<=$totalUsuarios['totalUsuarios']-11){
									$off+=10;
								};
							};
						};
					};
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
			</div>
		</div>
<!-- Javascript & Jquery-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script type="text/javascript">
	$("#t1 tr").click(function(){
   		$(this).addClass('selected').siblings().removeClass('selected');
   	});

   	function validateForm() {
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
			elem.value = output;
		}
	}

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