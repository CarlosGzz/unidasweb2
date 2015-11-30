
//validacion Login
$( document ).ready(function() {
    $('#envia').click(function(){
    	var userx = $('.user').val();
      	var passx = $('.pass').val();
   
      	if(userx != '' && passx != ''){
 
       	$.ajax({
       		url: '../unidasweb2/Controlador/login.php',
         	method: 'POST',
          	data: {user: userx, pass: passx},
          	success: function(msg){
          		if(msg=='1'){
          			$('#mensaje').html('Datos incorrectos');
          		} else if(msg=='2'){
          			$('#mensaje').html('Administrador no autorizado');
          		}else{
          			window.location = msg;
          		}
      		}
        });
       } else{
       	$('#mensaje').html('Ingrese los datos');
      }
  });

});
