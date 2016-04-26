<?php
    
    function mensajeJs($msg, $pagina){
  
         if(trim($msg)==""){ die("<script> window.location='$pagina'; </script>");}		
	 if(trim($pagina)==""){ die("<script> alert('$msg'); </script>");}
	 
	 die("<script> alert('$msg'); window.location='$pagina';</script>");
    }
    
    function confirmar($msg, $pagina){
         if(trim($msg)==""){ die("<script> window.location='$pagina'; </script>");}		
	 if(trim($pagina)==""){ die("<script> alert('$msg'); </script>");}
	 
	 die("<script> confirm('$msg'); window.location='$pagina';</script>");
    }
      
  function volver($msg)
   {	 
	 die("<script> alert('$msg'); history.back(); </script>");
   }
  
  function fecha_es($fecha)	
  { // convierte la fecha en formato español 18/02/2000
	$dia=substr($fecha,8,2);
	$mes=substr($fecha,5,2);
	$anio=substr($fecha,0,4);	
	return $dia."/".$mes."/".$anio;
  }
  
  function fecha_en($fecha)	
  { // convierte la fecha en formato ingles 2000/02/18
	$dia=substr($fecha,0,2);
	$mes=substr($fecha,3,2);
	$anio=substr($fecha,6,4);	
	return $anio."/".$mes."/".$dia;	
  }
  
?>
