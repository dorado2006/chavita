<?php

require_once '../../../ConBD.php';
$db = new database();
$db->conectar();
$query = $db->consulta("
         SELECT
tbl_fotos.id_files,
tbl_fotos.idproceso_cobro,
tbl_fotos.nombre,
tbl_fotos.descripcion,
tbl_fotos.tipo,
tbl_fotos.`status`
FROM
tbl_fotos
WHERE tbl_fotos.idproceso_cobro='".$_REQUEST['idproc']."' ");
$db->disconnect();


$archivos = array();
 while ($row = mysql_fetch_array($query)) {

    $id_files=$row['id_files'];
    $idproceso_cobro=$row['idproceso_cobro'];
    $nombre=$row['nombre'];
    $descripcion=$row['descripcion'];
    $tipo=$row['tipo'];
    $status=$row['status'];
    
    
 
    $archivos[] = array('id_files'=>$id_files,'idproceso_cobro'=>$idproceso_cobro,'nombre'=>$nombre,
        'descripcion'=>$descripcion,'tipo'=>$tipo,'status'=>$status);
}


echo json_encode($archivos);

?>
