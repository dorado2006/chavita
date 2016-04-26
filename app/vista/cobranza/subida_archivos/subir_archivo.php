<?php

require_once '../../../ConBD.php';
$db = new database();
print_r($_FILES);
print_r($_REQUEST);


if (isset($_FILES['txtFile'])) {
    


    $extension = pathinfo($_FILES['txtFile']['name'], PATHINFO_EXTENSION);
	$time = time();
        echo $time;
    $nombre = "{$_POST['dnicli']}_$time.$extension";
   
       if (move_uploaded_file($_FILES['txtFile']['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/negocio_cultural/copia_contrato/$nombre")) {
        echo 1;
             $db->conectar();
        $query = $db->consulta("INSERT INTO `tbl_fotos` (`idproceso_cobro`, `nombre`,`tipo`, `status`) "
                . "VALUES ('".$_POST['idproc_cobr']."', '".$nombre."', '".$extension."', '1') ");
        $db->disconnect();
    } else {
        echo 0;
    }
    
    
}
?>

