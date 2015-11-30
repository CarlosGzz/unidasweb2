<?php
	//Index
	session_start();
	session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
</head>
<meta charset="UTF-8">
	<title>Unidas Contigo Web Manager/Foros</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--Font-->
	<link href='http://fonts.googleapis.com/css?family=Josefin+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<!--- StyleSheet---->
	<link rel="stylesheet" href="../unidasweb2/Vista/CSS/intro.css">
	<!--- ShortCut ICON---->
	<link rel="shortcut icon" href="http://viaggatore.com/unidascontigo/wp-content/uploads/2015/04/unidas-contigo-fav.png">
<html>
<body>
	<div class="login-block">
		<div class="logo"><img src="http://viaggatore.com/unidascontigo/wp-content/uploads/2015/01/logo-uc-trans.png" alt="Logo"></div>
	    <h1>Login</h1>
	    <form action="../unidasweb2/Controlador/login.php" method="POST" name="form">
	    	<p id="mensaje" style="color: red;"></p>
		    <input type="text" maxlength="15" class="user" value="" placeholder="Username" id="user" name="user" onchange="validateChar(this)" required>
		    <input type="password" maxlength="20" class="pass" value="" placeholder="Password" id="pass" name="pass" onchange="validateChar(this)" required >
		    <button type="button" id="envia">Iniciar Sesion</button>
		</form>
	</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="../unidasweb2/Controlador/JS/operaciones.js"></script>
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