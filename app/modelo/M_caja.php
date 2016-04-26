<?php

/*
  CLASE PARA LA GESTION DE LOS UNIVERSITARIOS
 */
require_once '../app/ConBD.php';

class M_caja extends database {
    /* REALIZA UNA CONSULTA A LA BASE DE DATOS EN BUSCA DE  REGISTROS UNIVERSITARIOS DADOS COMO
      PARAMETROS LA "CARRERA" Y LA "CANTIDAD" DE REGISTROS A MOSTRAR
      INPUT:
      $carrera | nombre de la carrera a buscar
      $limit | cantidad de registros a mostrar
      OUTPUT:
      $data | Array con los registros obtenidos, si no existen datos, su valor es una cadena vacia
     */

    function index() {

        $this->conectar();
        $query = $this->consulta("
            SELECT
                Sum(proceso_cobro.abono) AS abono,
                proceso_cobro.idpersonal,
                personal.primer_nombre,
                COUNT(proceso_cobro.abono) as item
                FROM
                proceso_cobro
                INNER JOIN personal ON personal.idpersonal = proceso_cobro.idpersonal
                WHERE  proceso_cobro.fecha_mov=CURDATE()
                    and proceso_cobro.producto is null
                GROUP BY proceso_cobro.idpersonal
        ");
        $this->disconnect();
        if ($this->numero_de_filas($query) > 0) { // existe -> datos correctos
            //se llenan los datos en un array
            while ($tsArray = $this->fetch_assoc($query))
                $data[] = $tsArray;
            return $data;
        } else {
            return '';
        }
    }

    function get_descripcion($cond) {

        $this->conectar();
        if ($cond == 1) {
            $dat = "WHERE (caja_detalle.tipo='ENTRADA' or caja_detalle.tipo='FC')   and caja_detalle.estado=1";
        } else {
            $dat = "WHERE caja_detalle.tipo='SALIDA'  and caja_detalle.estado=1";
        }
        $query = $this->consulta("
            SELECT
caja_detalle.id_detallecaja as value,
caja_detalle.detall as label,
caja_detalle.tipo,
caja_detalle.estado
FROM
caja_detalle
$dat
        ");
        $this->disconnect();
        if ($this->numero_de_filas($query) > 0) { // existe -> datos correctos
            //se llenan los datos en un array
            while ($tsArray = $this->fetch_assoc($query))
                $data[] = $tsArray;
            return $data;
        } else {
            return '';
        }
    }

    function save_salida() {
        $this->conectar();

        $query3 = $this->consulta("SELECT
                COALESCE(MAX(caja.idcaja),0) +1 as idmax
                FROM
                caja ");
        $datos3 = array();
        while ($row = mysql_fetch_array($query3)) {
            $datos3[] = $row;
        }
        if ($_REQUEST['entrada'] == 1) {
            $cond = "caja.entrada,";
        } else {
            $cond = "caja.salida,";
        }

        $this->consulta("
           INSERT INTO caja (
caja.idcaja,
caja.fecha,
caja.personal_a,
caja.personal_benf,
$cond
caja.id_detallecaja,
caja.estado )
VALUES (
        '" . $datos3[0]['idmax'] . "',
             NOW(),
        '" . $_SESSION['idpersonal'] . "',       
        '" . $_REQUEST['id_personal'] . "', 
        '" . $_REQUEST['monto'] . "',
        '" . $_REQUEST['id_descrip'] . "', 
                '1')
                ");

        $this->disconnect();
    }

    function get_arqueo() {

        $this->conectar();
        $query = $this->consulta("
           SELECT
proceso_cobro.fecha_mov,
sum(proceso_cobro.abono) as ingre,
proceso_cobro.documento
FROM
proceso_cobro
WHERE proceso_cobro.producto is null and proceso_cobro.fecha_mov=CURDATE()
GROUP BY proceso_cobro.documento
        ");
        $this->disconnect();
        if ($this->numero_de_filas($query) > 0) { // existe -> datos correctos
            //se llenan los datos en un array
            while ($tsArray = $this->fetch_assoc($query))
                $data[] = $tsArray;
            return $data;
        } else {
            return '';
        }
    }

    function get_arqueo_scaja() {

        $this->conectar();
        $query = $this->consulta("
SELECT
caja.idcaja,
caja.fecha,
sum(caja.salida) as sal,
caja_detalle.tipo
FROM
caja
INNER JOIN caja_detalle ON caja_detalle.id_detallecaja = caja.id_detallecaja
WHERE DATE_FORMAT(caja.fecha,'%y-%m-%d')=CURDATE() AND caja.estado=1 and caja_detalle.tipo='SALIDA'
        ");
        $this->disconnect();
        if ($this->numero_de_filas($query) > 0) { // existe -> datos correctos
            //se llenan los datos en un array
            while ($tsArray = $this->fetch_assoc($query))
                $data[] = $tsArray;
            return $data;
        } else {
            return '';
        }
    }

    function get_arqueo_fccaja() {

        $this->conectar();
        $query = $this->consulta("
SELECT
caja.idcaja,
caja.fecha,
caja_detalle.tipo,
caja.entrada
FROM
caja
INNER JOIN caja_detalle ON caja_detalle.id_detallecaja = caja.id_detallecaja
WHERE DATE_FORMAT(caja.fecha,'%y-%m-%d')=CURDATE() AND caja.estado=1 and caja_detalle.tipo !='SALIDA'
        ");
        $this->disconnect();
        if ($this->numero_de_filas($query) > 0) { // existe -> datos correctos
            //se llenan los datos en un array
            while ($tsArray = $this->fetch_assoc($query))
                $data[] = $tsArray;
            return $data;
        } else {
            return '';
        }
    }

    function apertura_caja() {

        $this->conectar();
        $query = $this->consulta("
SELECT
caja.idcaja,
DATE_FORMAT(caja.fecha,'%Y-%m-%d') as apf,
CURDATE() as api,
caja_detalle.tipo,
caja.entrada
FROM
caja
INNER JOIN caja_detalle ON caja_detalle.id_detallecaja = caja.id_detallecaja
WHERE  caja.estado=2
        ");
        $this->disconnect();
        if ($this->numero_de_filas($query) > 0) { // existe -> datos correctos
            //se llenan los datos en un array
            while ($tsArray = $this->fetch_assoc($query))
                $data[] = $tsArray;
            return $data;
        } else {
            return '';
        }
    }

    function get_reportes() {

        $this->conectar();
        $query = $this->consulta("
SELECT
caja.idcaja,
caja.fecha,
caja.personal_a,
caja.personal_benf,
caja.entrada,
caja.salida,
caja.id_detallecaja,
caja.estado,
caja_detalle.id_detallecaja,
caja_detalle.detall,
caja_detalle.tipo,
caja_detalle.estado,
personal.primer_nombre
FROM
caja_detalle
INNER JOIN caja ON caja_detalle.id_detallecaja = caja.id_detallecaja
INNER JOIN personal ON personal.idpersonal = caja.personal_benf
WHERE (DATE_FORMAT(caja.fecha,'%Y-%m-%d') BETWEEN  '" . $_REQUEST['fechai'] . "' and '" . $_REQUEST['fechaf'] . "' ) and caja.estado=1
        ");
        $this->disconnect();
        if ($this->numero_de_filas($query) > 0) { // existe -> datos correctos
            //se llenan los datos en un array
            while ($tsArray = $this->fetch_assoc($query))
                $data[] = $tsArray;
            return $data;
        } else {
            return '';
        }
    }

    function cierrecaja_arq() {
       
        $this->conectar();

        $query3 = $this->consulta("SELECT
                COALESCE(MAX(caja.idcaja),0) +1 as idmax
                FROM
                caja ");
        $datos3 = array();
        while ($row = mysql_fetch_array($query3)) {
            $datos3[] = $row;
        }
        $query1 = $this->consulta("SELECT
caja.idcaja,
caja.fecha,
caja.estado,
caja.entrada
FROM
caja
WHERE caja.estado=2 and DATE_FORMAT(caja.fecha,'%y-%m-%d')=CURDATE() and caja.id_detallecaja=12");

        if ($this->numero_de_filas($query1) < 1) { // existe -> datos correctos
            $this->consulta("
           INSERT INTO caja (
caja.idcaja,
caja.fecha,
caja.personal_a,
caja.personal_benf,
caja.entrada,
caja.id_detallecaja,
caja.estado )
VALUES (
        '" . $datos3[0]['idmax'] . "',
             NOW(),
        '" . $_SESSION['idpersonal'] . "',       
       '" . $_SESSION['idpersonal'] . "',
        '" . $_REQUEST['monto_caj'] . "',
        '12', 
                '2')
                ");
        } else {
            $datos1 = array();
            while ($row = mysql_fetch_array($query1)) {
                $datos1[] = $row;
            }

            $this->consulta("
           UPDATE caja SET caja.fecha=  NOW(),caja.entrada='" . $_REQUEST['monto_caj'] . "' 
WHERE caja.idcaja='" . $datos1[0]['idcaja'] . "' ");
        }
        $this->disconnect();
    }

    function apertura_caja1() {
        $this->conectar();

        $query3 = $this->consulta("SELECT
                COALESCE(MAX(caja.idcaja),0) +1 as idmax
                FROM
                caja ");
        $datos3 = array();
        while ($row = mysql_fetch_array($query3)) {
            $datos3[] = $row;
        }
        if (!empty($_REQUEST['monto'])) {
            $query1 = $this->consulta("SELECT
caja.idcaja,
caja.fecha,
caja.estado,
caja.entrada
FROM
caja
WHERE caja.estado=2  and caja.id_detallecaja=12");
            $datos2 = array();
            while ($row = mysql_fetch_array($query1)) {
                $datos2[] = $row;
            }
            $this->consulta("
           UPDATE caja SET caja.estado='3',
           caja.fecha=now(),
          caja.personal_a='" . $_SESSION['idpersonal'] . "',
          caja.personal_benf='" . $_SESSION['idpersonal'] . "'
            WHERE caja.idcaja='" . $datos2[0]['idcaja'] . "' ");
            $datas = $_REQUEST['monto'];
        } else {
            $datas = 0;
        }
        $estado = 0;
        for ($i = 0; $i < 2; $i++) {
            $idcorr = $datos3[0]['idmax'] + $i;
            $estado = $estado + 1;
            $this->consulta("
           INSERT INTO caja (
caja.idcaja,
caja.fecha,
caja.personal_a,
caja.personal_benf,
caja.entrada,
caja.id_detallecaja,
caja.estado )
VALUES (
        $idcorr,
             NOW(),
        '" . $_SESSION['idpersonal'] . "',       
       '" . $_SESSION['idpersonal'] . "',
                $datas,       
                 '12', 
                '" . $estado . "')
                ");
        }

        $this->disconnect();
    }

}
