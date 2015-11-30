<?php
	//Eventos
	session_start();
	$GLOBALS["off"]=intval(0);

	if($_SESSION['validacion'] == 1){

		require "../Modelo/connect.php";
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
					$editQuery = "UPDATE Eventos 
								  SET Nombre='$Nombre',
								  	  Descripcion ='$Descripcion',
								      Lugar = '$Lugar',
							    	  FechaInicio = '$FechaInicio',
							      	Hora = '$Hora',
							      	FechaFinal ='$FechaFinal'
							  	WHERE  IdEvento ='$IdEvento'";

					if ($db->query($editQuery) === TRUE) {
						echo "<script>alert('Modificado correctamente')</script>";
					} else {
						echo "<script>alert('Error:  ". $editQuery . "<br>" . $db->error."')</script>";
					}
				};

				if(isset($_POST['deleteButton'])){

					$deleteQuery = "DELETE 
									FROM Eventos 
									WHERE IdEvento ='$IdEvento'";

					if ($db->query($deleteQuery) === TRUE) {	
						echo "<script>alert('Eliminado correctamente')</script>";
					} else {
					    echo "<script>alert('Error al borrar: ". $db->error."')</script>";
					}
				};
			};
		};

		function fill($off){
			require "../Modelo/connect.php";
			$data = $db->query("SELECT * FROM Eventos ORDER BY FechaInicio  LIMIT 10 OFFSET $off ");
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
			$table_str.='<th>Fecha de Inicio<p id="format">(MM/DD/AAAA)</p></th>';
			$table_str.='<th>Hora</th>';
			$table_str.='<th>Fecha de Final<p id="format">(MM/DD/AAAA)</p></th>';
			$table_str.='<th id="thButtons">Crear Evento</th>';
			$table_str.='<th id="thButtons"><a href="CrearEvento.php"><button class="addButton")></button></a></td>';
			$table_str.='</tr>';
			$table_str.='</thead>';
			$table_str.='<tbody>';
			$x = 1;
			$v= "'Confirmar cambio o modificación'";
			foreach ($events as $event) {
				$table_str.='<form id="form'.$x.'" action="Eventos.php" method="POST" onsubmit="return confirm('.$v.');">';
				$table_str.='<tr>';
				$table_str.='<td><input name="nombre" id="nom'.$x.'" class="input" type="text" value="'.$event->Nombre.'" onchange="validateChar(this)"  ></td>';
				$table_str.='<td><textarea id="desc'.$x.'" class="inputX" name="descripcion" type="text" value="" onchange="validateChar(this)" required>'.$event->Descripcion.'</textarea></td>';
				$table_str.='<td><textarea id="lugar'.$x.'" class="inputX" name="lugar" type="text" value="" onchange="validateChar(this)">'.$event->Lugar.'</textarea></td>';
				$table_str.='<td><input id="fechaI'.$x.'" class="input" name="fechaI" type="date" value="'.$event->FechaInicio.'" onchange="validateForm2(this,fechaF'.$x.', form'.$x.')" ></td>';	
				$table_str.='<td><input class="input" name="hora" type="time" value="'.$event->Hora.'" ></td>';
				$table_str.='<td><input id="fechaF'.$x.'" class="input" name="fechaF" type="date" value="'.$event->FechaFinal.'" onchange="validateForm2(fechaI'.$x.',this, form'.$x.')" ></td>';
				$table_str.='<td id="tdButtons" type="submit"><button type"submit" name="editButton" class="editButton" onclick="validateForm()"></button></td>';
				$table_str.='<td id="tdButtons" type="submit"><button type"submit" name="deleteButton" class="deleteButton"></button></td>';
				$table_str.='<td><input id="input" name="idEvento" type="hidden" value="'.$event->IdEvento.'" ></td>';
				$table_str.='</tr>';
				$table_str.='</form>';
				$x++;
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
	<link rel="stylesheet" href="CSS/default.css">
	<!--- ShortCut ICON---->
	<link rel="shortcut icon" href="http://viaggatore.com/unidascontigo/wp-content/uploads/2015/04/unidas-contigo-fav.png">
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
				<form method="POST" action="Eventos.php" name="limits" class="limits" >
					<input name="off" value="<?php echo $off; ?>" type="hidden"></input>
					<button id="less" name="less" type="submit"><</button>
					<span id="lim"><?php echo $off+10; ?></span>
					<button id="more "name="more"type="submit"> ></button>
				</form>
			</span>
		</div>
	</div>
	</div>

<!-- Javascript & Jquery-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script type="text/javascript">
	var  x=0;
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
	<script type="text/javascript">

   	function validateForm2(x,y,z) {
   		var fi = document.forms[z.id][x.id].value;
		var ff = document.forms[z.id][y.id].value;
		var d = new Date();

		var month = d.getMonth()+1;
		var day = d.getDate();
		var output = d.getFullYear() + '-' +
		    ((''+month).length<2 ? '0' : '') + month + '-' +
		    ((''+day).length<2 ? '0' : '') + day;
			
		if (fi<output){
			alert("La fecha inicial no puede ser en el pasado");
			var elem = document.getElementById(x.id);
			elem.value = output;
			if (fi<output){
				alert("La fecha final no puede ser menor a la inicial");
				var elem = document.getElementById(y.id);
				elem.value = output;
			}
		}
		if (fi>ff){
			alert("La fecha final no puede ser menor a la inicial");
			var elem = document.getElementById(y.id);
			elem.value = fi;
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