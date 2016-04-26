<?php

//echo "<pre>";
//print_r($_SERVER); exit;
session_start();
//windows
require_once '../app/ConBD.php';
//linux
//require_once '/var/www/negocio_cultural/app/ConBD.php';

require("funciones.php");
$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

if (!isset($usuario)) {
    mensajeJS("Acceso Denegado", "../index.php");
}

$sql = "SELECT
personal.idpersonal,
personal.idperfil,
personal.idoficina,
CONCAT(personal.primer_nombre,' ',personal.apellido_p) as nombres,
personal.segundo_nombre,
personal.apellido_m,
personal.dnipersonal,
personal.pasword,
personal.usuario,
personal.estado,
perfil.idperfil,
perfil.descripcion as perfil,
oficina.idoficina,
oficina.idsucursal,
sucursal.descripcion,
sucursal.idsucursal,
oficina.descripcion as descoficina
FROM
personal
INNER JOIN perfil ON perfil.idperfil = personal.idperfil
INNER JOIN oficina ON oficina.idoficina = personal.idoficina
INNER JOIN sucursal ON sucursal.idsucursal = oficina.idsucursal
WHERE
personal.usuario ='$usuario' AND personal.pasword ='$clave'";

$db = new database();
$r = $db->consulta($sql);
if ($f = mysql_fetch_array($r)) {
    $_SESSION['idpersonal'] = $f['idpersonal'];
    $_SESSION['usuario'] = $usuario;
    $_SESSION['idperfil'] = $f['idperfil'];
    $_SESSION['nombre'] = $f['nombres'];
    $_SESSION['perfil'] = $f['perfil'];
    $_SESSION['idpersonal'] = $f['idpersonal'];
    $_SESSION['dnipersonal'] = $f['dnipersonal'];

    // mysql_query("update bibliotecario SET ultimoingreso='".date("Y-m-d H:i:s")."' where idbibliotecario=".$_SESSION['idbibliotecario']." ");
  
    mensajeJS("", "../web/index.php");
} else { 
    mensajeJs('Usuario o clave incorrecta', '../index.php');
}
?>
