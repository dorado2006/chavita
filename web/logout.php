<?php session_start();	  
	  unset($_SESSION['usuario']);	  
	  session_destroy();
	  
	  die(utf8_decode("<script> alert('Sesión Finalizada');
			     		  window.location='../index.php';
				</script>"));
?>