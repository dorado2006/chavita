<?php @session_start(); 
	  if(!isset($_SESSION['usuario'])){
	  
	  		die(utf8_decode("<script> alert('Su sesión a expirado. Debe iniciar sesión');
			     		  window.location='../index.php';
				</script>"));
	  }
	  
	  if(trim($_SESSION['usuario'])==""){
	  
	  		die(utf8_decode("<script> alert('Su sesión a expirado. Debe iniciar sesión');
			     		  window.location='../index.php';
				</script>"));
	  } 
?>