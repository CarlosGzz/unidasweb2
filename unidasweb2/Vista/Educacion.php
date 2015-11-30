<?php
	session_start();
	$GLOBALS["off"]=intval(0);

	if($_SESSION['validacion'] == 1){

		require "../Modelo/connect.php";

		 if(!empty($_POST)){
		 	if(!empty($_POST['IdTipo'])){
				$IdTipo = trim($_POST["IdTipo"]);


				if(isset($_POST['deleteButton'])){

					$deleteQuery = "DELETE 
									FROM Educacion 
									WHERE IdTipo ='$IdTipo'";

					if ($db->query($deleteQuery) === TRUE) {
						echo "<script>alert('eliminado correctamente')</script>";
					} else {
					    echo "Error deleting record: " . $db->error;
					}
				};
			};
		};
		function fill($off){
			require "../Modelo/connect.php";
			$data = $db->query("SELECT * FROM Educacion");
			$tipos = array();

			while($object = mysqli_fetch_object($data)){
				$tipos[]=$object;
			}

			//create table
			$table_str='<table id="t1">';
			$table_str.='<thead>';
			$table_str.='<tr>';
			$table_str.='<th>Icono</th>';
			$table_str.='<th>Tipo de Cancer</th>';
			$table_str.='<th>#Modulos</th>';
			$table_str.='<th id="thButtons">Crear Nuevo</th>';
			$table_str.='<th colspan="2" id="thButtons"><a href="CrearTipo.php"><button class="addButton")></button></a></td>';
			$table_str.='</tr>';
			$table_str.='</thead>';
			$table_str.='<tbody>';
			$x = 1;
			foreach ($tipos as $tipo) {
				$IdTipo = $tipo->IdTipo;
				echo $IdTipo;
				$result=$db->query("SELECT COUNT(*) as numModulos FROM Modulo WHERE IdTipo=$IdTipo ");
				$numModulos=mysqli_fetch_assoc($result);

				$table_str.='<form action="" id="form'.$x.'" name="form'.$x.'" method="POST" >';
				$table_str.='<tr>';
				$table_str.='<td><img src="'.$tipo->Icono.'" ></td>';
				$table_str.='<td><input form="form'.$x.'" class="input" name="tipo" type="text", value="'.$tipo->Tipo.'" readonly/></td>';
				$table_str.='<td>'.$numModulos['numModulos'].'</td>';
				$table_str.='<td id="tdButtons"><button form="form'.$x.'" id="b1" type="submit" name="editButton" class="editButton"></td>';
				$table_str.='<td id="tdButtons"><button form="form'.$x.'" id="b2" type="submit" name="deleteButton" class="deleteButton"></button></td>';
				$table_str.='<td><input id="input" name="IdTipo" type="hidden", value="'.$tipo->IdTipo.'" ></td>';
				$table_str.='</tr>';
				$table_str.='</form>';
				$x ++;
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
	<title>Unidas Contigo Web Manager/Educación</title>
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
								$result=$db->query("SELECT COUNT(*) as totalEducacion FROM Educacion");
								$totalEducacion=mysqli_fetch_assoc($result);
								if($off<=$totalEducacion['totalEducacion']-11){
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
	</div>
<!-- Latest compiled and minified JavaScript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script type="text/javascript">
	$("#t1 tr").click(function(){
   		$(this).addClass('selected').siblings().removeClass('selected');
   		$(this).find("#b1").click(function() {
	  		$f = $(this).attr("form");
	  		form=document.getElementById($f);
		    form.action="Modulo.php";
		    form.submit();
	  	});
  		$(this).find("#b2").click(function() {
	  		$f = $(this).attr("form");
	  		form=document.getElementById($f);
		    form.action="Educacion.php";
		    form.submit();
	  	});
   	});
	</script>
</body>
</html>
<?php

	}else{
		header("Location: ..");
	}
?>