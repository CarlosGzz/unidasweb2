<?php
	//Foros
	session_start();
	$GLOBALS["off"]=intval(0);

	if($_SESSION['validacion'] == 1){

		require "../Modelo/connect.php";
		if(!empty($_POST)){
			if(!empty($_POST['IdForo'])){
				$IdForo = trim($_POST["IdForo"]);
				
				if(isset($_POST['checkButton'])){
					$editQuery = "UPDATE Foros 
								  SET Flag=0
								  WHERE  idForos ='$IdForo' ";

					if ($db->query($editQuery) === TRUE) {
						echo "<script>alert('Foro aceptado, se han quitado los flags correctamente')</script>";
					} else {
						echo "<script>alert('Error:  ". $editQuery . "<br>" . $db->error."')</script>";
					}
				};

				if(isset($_POST['deleteButton'])){

					$deleteQuery = "DELETE 
									FROM Foros 
									WHERE idForos ='$IdForo'";

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
			$data = $db->query("SELECT * FROM Foros WHERE flag>0  LIMIT 10 OFFSET $off ");
			$foros = array();
			while($object = mysqli_fetch_object($data)){
				$foros[]=$object;
			}
			//create table

			$result=$db->query("SELECT COUNT(*) as totalReportes FROM Foros WHERE flag > 0 ");
			$totalReportes=mysqli_fetch_assoc($result);
				
				
			$table_str='<table id="t1">';
			$table_str.='<thead>';
			$table_str.='<tr>';
			$table_str.='<th>Titulo</th>';
			$table_str.='<th>Username</th>';
			$table_str.='<th>Descripcion</th>';
			$table_str.='<th>#Upvotes</th>';
			$table_str.='<th>#Downvotes</th>';
			$table_str.='<th>Fecha y Hora</th>';
			$table_str.='<th colspan="3" id="thButtons">Total Reportes:'.$totalReportes['totalReportes'].'</th>';	
			$table_str.='</tr>';
			$table_str.='</thead>';
			$table_str.='<tbody>';
			$v= "'Confirmar eliminacion o aceptar foro'";
			foreach ($foros as $foro) {
				$table_str.='<tr>';
				$table_str.='<form action="Foros.php" method="POST" onsubmit="return confirm('.$v.');">';
				$table_str.='<td class="foros">'.$foro->Titulo.'</td>';
				$table_str.='<td>'.$foro->Username.'</td>';
				$table_str.='<td class="foros">'.$foro->Descripcion.'</td>';
				$table_str.='<td>'.$foro->Upvotes.'</td>';
				$table_str.='<td>'.$foro->Downvotes.'</td>';
				$table_str.='<td>'.$foro->FechaCrear.'</td>';
				$table_str.='<td id="tdButtons"><button name="checkButton" class="checkButton"></button></td>';
				$table_str.='<td id="tdButtons"><button name="deleteButton" class="deleteButton"></button></td>';
				$table_str.='<td><input id="input" name="IdForo" type="hidden", value="'.$foro->idForos.'" ></td>';
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
	<title>Unidas Contigo Web Manager/Foros</title>
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
					<li class="current_page_item"><a href="Foros.php">Foros</a></li>
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
							}
						}
						if (isset($_POST['more'])) {
							if(!empty($_POST['off']) or $_POST['off']==0) {
								$off= $_POST['off'];
								$result=$db->query("SELECT COUNT(*) as totalReportes FROM Foros WHERE flag > 0 ");
								$totalReportes=mysqli_fetch_assoc($result);
								if($off<=$totalReportes['totalReportes']-11){
									$off+=10;
								}
							}
						}
					}
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
   		$('td.foros2').removeClass('foros2').addClass('foros');
   		$(this).children('td.foros').removeClass('foros').addClass('foros2');
	});
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