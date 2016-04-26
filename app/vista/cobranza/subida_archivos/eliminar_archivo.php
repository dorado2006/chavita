<?php 
 

 require_once '../../../ConBD.php';
$db = new database();

if (isset($_POST['archivo'])) {
    $archivo = $_POST['archivo'];
    
    if (file_exists($_SERVER['DOCUMENT_ROOT']."/negocio_cultural/copia_contrato/$archivo")) {
        unlink($_SERVER['DOCUMENT_ROOT']."/negocio_cultural/copia_contrato/$archivo");    
               
$db->conectar();
$query = $db->consulta("DELETE FROM `tbl_fotos` WHERE `id_files`= '".$_POST['idfoto']."' ");
$db->disconnect();
        echo 1;
    } else {
        echo 0;
    }
 
}
?>

