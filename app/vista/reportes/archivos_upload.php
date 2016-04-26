<?php



	if( empty($_FILES['txtFile']['name']) == false )
	{
           
         $permitidos = array("application/excel","application/vnd.ms-excel", "application/x-excel",
             "application/x-msexcel","application/vnd.openxmlformats-officedocument.wordprocessingml.document",
             "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
           if (in_array($_FILES['txtFile']['type'], $permitidos)){
		if (is_uploaded_file($_FILES['txtFile']['tmp_name'])) 
		{	 $array = explode(".", $_FILES['txtFile']['name']);		
			if( move_uploaded_file($_FILES['txtFile']['tmp_name'], "import_ecxel/dni1.".$array[1]) == false )
				echo "No se ha podido el mover el archivo.";
			else
                               //rename("datos-2.txt", "datos---2.txt");
				echo "Archivo ".$_FILES['txtFile']['name']." SUBIDO Y MOVIDO AL DIRECTORIO.";
		} 
		else 
		{
		   echo "Posible ataque al subir el archivo [".$_FILES['txtFile']['nombre_tmp']."]";
		}
            }
            else{
                echo "archivo no permitido, tiene que ser un excel";
            }
	}
	else
	{
		echo "No se selecciono ningun archivo.";
	}

?>