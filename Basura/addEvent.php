<?php
  require "connect.php";

      $Nombre = $_POST["nombre"];
      $Descripcion = $_POST["descripcion"];
      $Lugar = $_POST["lugar"];
      $FechaInicio = $_POST["fechaI"];
      $FechaFinal = $_POST["fechaF"];
      $Username = $_POST["username"];

      echo "nombre :$Nombre
              descripcion: $Descripcion
              lugar: $Lugar";


      $sql = "INSERT INTO Eventos (Nombre, Descripcion, Lugar, FechaInicio, FechaFinal, Username)
      VALUES ('$Nombre', '$Descripcion', '$Lugar', '$FechaInicio', '$FechaFinal','$Username')";


      if ($db->query($sql) === TRUE) {
          echo "New record created successfully";
      } else {
          echo "Error: " . $sql . "<br>" . $db->error;
      }
      $db->close();
   
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
   <!--- Jquery---->
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
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
         </div>
      </div>
      <!-- end #head-wrapper--> 
      <div id="menu-wrapper">
         <div id="menu">
            <ul>
               <li class="current_page_item"><a href="Eventos.php">Eventos</a></li>
               <li><a href="Foros.php">Foros</a></li>
               <li><a href="Usuarios.php">Usuarios</a></li>
               <li><a href="Testimonios.html">Testimonios</a></li>
               <li><a href="Educacion.html">Educación</a></li>
               <li><a href="Infromacion.html">Información</a></li>
               <li><a href="Donacion.html">Donación</a></li>
            </ul>
         </div>
      </div>
      <!-- end #menu --> 

      <div id="page" class="container">
      <div id="content">
         <div id="breadcrumb2">
            <ul class="crumbs2">
               <li class="first"><a href="Eventos.php">Eventos</a></li>
               <li class="last"><a href="#">Crear Evento</a></li>           
            </ul>
         </div>
         <div>
            <h1>Evento Creado</h1>

         </div>
      
      </div>
   </div>
   </div>

<!-- Latest compiled and minified JavaScript -->
   <script type="text/javascript">
   function highlight(e) {
      if (selected[0]) selected[0].className = '';
         e.target.parentNode.className = 'selected';

   }
   var table = document.getElementById('t1'),
    selected = table.getElementsByClassName('selected');
    table.onclick = highlight;
   </script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
   <div id="copyright" class = "container">Icons made by 
      <a href="http://www.flaticon.com/authors/google" title="Google">Google</a> 
      from 
      <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a>
      is licensed by 
      <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a>
   </div>
</body>
</html>