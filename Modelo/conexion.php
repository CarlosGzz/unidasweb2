<?php

	class conexion{

		private $conexion ;
		private $server = "localhost";
		private $username = "root";
		private $password = "kobyjzt";
		private $dbname = "UnidasBD";
		private $user;
		private $pass;



		public function __construct(){
			// Create connection
			$this->conexion = new mysqli($this->server, $this->username, $this->password, $this->dbname );
			// Check connection
			if ($this->conexion->connect_error) {
				die("Connección fallida: Lo sentimos estamos teniendo problemas".$this->conexion->connect_error);
			}
		}

		public function cerrar(){
			
			$this->conexion->close();

		}

		public function login($user, $pass){
			
			$this->user = $user;
			$this->pass = $pass;

			$query = "SELECT username, contrasena, nombre, apellido, authorizado 
					  FROM Usuarios 
					  WHERE username= '".$this->user."' and contrasena='".$this->pass."' and prefijo='admin'";

			
			$consulta = $this->conexion->query($query);
			if($row = mysqli_fetch_array($consulta)){
				if($row['authorizado']==1){
					session_start(); 

					$_SESSION['validacion'] = 1 ; 
					$_SESSION['user']= $row['username'];
					$_SESSION['nom']= $row['nombre'];
					$_SESSION['ape']= $row['apellido'];

					echo "../unidasweb2/Vista/Eventos.php";

				}else{
					echo "2";
				}

			} else {

				session_start();
				$_SESSION['validacion']=0;
				echo "1";
			}
		}
	}
?>