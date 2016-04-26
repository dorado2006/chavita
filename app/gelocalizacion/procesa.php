<?php

//echo '<pre>';print_r($_REQUEST);exit;
//Conexion a la bd
$cn = mysql_connect("localhost:3308", "root", "");
mysql_select_db("ncprueba", $cn);

if ($_GET['action'] == 'addUbicacion') {
     //mysql_query(" UPDATE `cliente` SET `cord_cli`='" . $_POST['coor'] . "', `zoom_cli`='" . $_POST['zoom'] . "' WHERE `idcliente`='" . $_POST['idcliente'] . "' ", $cn);
    if ($_GET['condi'] == '1') {

        //Agregamos la Ubicacion
        // echo  " UPDATE `cliente` SET `cord_cli`='" . $_POST['coor'] . "', `zoom_cli`='" . $_POST['zoom'] . "' WHERE `idcliente`='" . $_POST['idcliente'] . "' ";
        mysql_query(" UPDATE `cliente` SET `cord_cli`='" . $_POST['coor'] . "', `zoom_cli`='" . $_POST['zoom'] . "' WHERE `idcliente`='" . $_POST['idcliente'] . "' ", $cn);
    } else {
        //Agregamos la Ubicacion
        mysql_query("UPDATE `lugar_trabajo` SET `coord_lt`='" . $_POST['coor'] . "', `zoom_lt`='" . $_POST['zoom'] . "' WHERE `idcliente`='" . $_POST['idcliente'] . "' ", $cn);
    }
} elseif ($_GET['action'] == 'listUbicaciones') {
   $query = mysql_query("SELECT
cliente.idcliente,
cliente.dni,
cliente.cord_cli,
cliente.zoom_cli,
lugar_trabajo.coord_lt,
lugar_trabajo.zoom_lt
FROM
cliente
INNER JOIN lugar_trabajo ON cliente.idcliente = lugar_trabajo.idcliente
WHERE cliente.idcliente='" . $_GET['idcliente'] . "' " , $cn);
    while ($row = mysql_fetch_array($query)) {
        echo "<div class='item_dir'>" . $row["dni"] . " <a href='javascript:;' onclick=ver_mapa('" . $row["cord_cli"] . "','" . $row["zoom_cli"] . "')>VER DOMICILIO</a></div>";
        echo "<div class='item_dir'>" . $row["dni"] . " <a href='javascript:;' onclick=ver_mapa('" . $row["coord_lt"] . "','" . $row["zoom_lt"] . "')>VER LUGAR DE TRABAJO</a></div>";
    }
}
?>