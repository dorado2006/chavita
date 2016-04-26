<?php

/*
  CLASE PARA LA GESTION DE LOS UNIVERSITARIOS
 */
require_once '../app/ConBD.php';

class M_reportes extends database {
    /* REALIZA UNA CONSULTA A LA BASE DE DATOS EN BUSCA DE  REGISTROS UNIVERSITARIOS DADOS COMO
      PARAMETROS LA "CARRERA" Y LA "CANTIDAD" DE REGISTROS A MOSTRAR
      INPUT:
      $carrera | nombre de la carrera a buscar
      $limit | cantidad de registros a mostrar
      OUTPUT:
      $data | Array con los registros obtenidos, si no existen datos, su valor es una cadena vacia
     */

    function _import_excel($condicion_p) {


        $this->conectar();
        // foreach ($condicion_p as $value => $dato) {

        $sql = " SELECT
cliente.dni as dni_cliente,
CONCAT_WS('.',perfil_cliente.abreviatura,perfil_cliente.descripcion) as percliente,
CONCAT_WS(' ',cliente.nombres,cliente.apellidos) as client,
CONCAT_WS('-',cliente.telfcasa,cliente.telf1,cliente.telf2) as telcliente,
CONCAT_WS('-',cliente.dir_actual,cliente.distrito) as dircliente,
CONCAT_WS(' ',lugar_trabajo.codigo_ruc,lugar_trabajo.nombre) as centrotrab,
CONCAT_WS('-',lugar_trabajo.telefono1,lugar_trabajo.telefono2,lugar_trabajo.telefono3) as tlftraba,
CONCAT_WS('-',lugar_trabajo.direccion,lugar_trabajo.distrito) as diretrabajo,
COUNT(a.credito) as n_productos,
Sum(a.credito) AS cred,
SUM(a.abono) as amortiza,
(SUM(a.credito) - SUM(a.abono)) as saldo,
max(a.fecha_mov) as ultimafepago,
case when ( cliente.dni=cliente.dni )  then 'ctrb' else 'N-C' end identificador
FROM
cliente
INNER JOIN lugar_trabajo ON cliente.idcliente = lugar_trabajo.idcliente
INNER JOIN perfil_cliente ON perfil_cliente.idperfil_cliente = cliente.idperfil_cliente
INNER JOIN proceso_cobro a ON cliente.dni = a.dni
GROUP BY a.dni  

UNION

SELECT
a.dni as dni_cliente,
a.fecha_mov as percliente,
a.abono as client,
case when ( a.dni=a.dni )  then 'ab' else 'N-C' end telcliente,
case when ( a.dni=a.dni )  then 'ab' else 'N-C' end dircliente,
case when ( a.dni=a.dni )  then 'ab' else 'N-C' end centrotrab,
case when ( a.dni=a.dni )  then 'ab' else 'N-C' end tlftraba,
case when ( a.dni=a.dni )  then 'ab' else 'N-C' end diretrabajo,
case when ( a.dni=a.dni )  then 'ab' else 'N-C' end n_productos,
case when ( a.dni=a.dni )  then 'ab' else 'N-C' end cred,
case when ( a.dni=a.dni )  then 'ab' else 'N-C' end amortiza,
case when ( a.dni=a.dni )  then 'ab' else 'N-C' end saldo,
case when ( a.dni=a.dni )  then 'ab' else 'N-C' end ultimafepago,
case when ( a.dni=a.dni )  then 'amor' else 'N-C' end identificador

FROM
proceso_cobro  a
WHERE a.fecha_mov =(SELECT MAX(b.fecha_mov) from proceso_cobro b WHERE b.dni=a.dni) and a.abono is not NULL


UNION

SELECT 
a.dnic as dni_cliente,
a.acuerdos as percliente,
a.fecha_verificacion as client,
case when ( a.dnic=a.dnic )  then 'ac' else 'N-C' end amortiza,
a.idpersonal as dircliente,
a.fuente as centrotrab,
a.descripcion as tlftraba,
a.fecha_visita as diretrabajo,
a.calificacion as n_productos,
a.ver_ocultar as cred,
a.frecuencia_msj as amortiza,
a.hora as saldo,
a.pagoen as ultimafepago,
case when ( a.dnic=a.dnic )  then 'acu' else 'N-C' end identificador
FROM
acuerdos a
WHERE a.fecha_verificacion=(SELECT MAX(b.fecha_verificacion) from acuerdos b WHERE b.dnic=a.dnic) 

UNION

SELECT
proceso_cobro.dni,
proceso_cobro.idproceso_cobro,
proceso_cobro.fecha_mov,
proceso_cobro.letra,
proceso_cobro.credito,
proceso_cobro.nro_cuota,
proceso_cobro.producto,
proceso_cobro.a_partir_de,
proceso_cobro.num_cuotas,
proceso_cobro.cond_pago,
proceso_cobro.acuerdo,
proceso_cobro.frecuencia_msg,
personal.primer_nombre,
case when ( proceso_cobro.dni=proceso_cobro.dni )  then 'prod' else 'N-C' end identificador
FROM
proceso_cobro
INNER JOIN personal ON personal.idpersonal = proceso_cobro.idpersonal
WHERE proceso_cobro.credito is not null
";
//            HAVING a.dni='00038075'
//    HAVING a.dni='00038075'        
// HAVING a.dnic='00038075'
//            HAVING proceso_cobro.dni='00038075'

        $query = $this->consulta($sql);

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

    function insertcarga_dni($condicion_p) {


        $this->conectar();
        $query2 = $this->consulta("TRUNCATE carga_dni");

        foreach ($condicion_p as $value => $dato) {
            $micond2 = " a.dni='" . $condicion_p[$value]['A'] . "'";
            if ($condicion_p[$value]['A'] != '') {
                $query = $this->consulta(" INSERT INTO `carga_dni` (`dni`) VALUES ('" . $condicion_p[$value]['A'] . "')");
            }
        }
        $this->disconnect();
    }

    function carga_dni() {

        $this->conectar();
        $sql = " SELECT
carga_dni.dni as dnicarga,
acuerdo_pago.dni as dniacuerdo,
acuerdo_pago.fecha_visita,
acuerdo_pago.fecha_verif,
acuerdo_pago.acuerdo,
acuerdo_pago.fuente,
acuerdo_pago.frecuencia_msg,
acuerdo_pago.hora,
acuerdo_pago.pagoen,
acuerdo_pago.fecha_up,
acuerdo_pago.amortiza,
acuerdo_pago.tcredito,
acuerdo_pago.tabono,
cliente.dni as dnicliente,
CONCAT_WS(' ',cliente.nombres,cliente.apellidos) as clint,
CONCAT_WS('-',cliente.telfcasa,cliente.telf1,cliente.telf2) as tlfcliente,
CONCAT_WS('-',cliente.dir_actual,cliente.distrito) as dircliente,
CONCAT_WS('.',perfil_cliente.abreviatura,perfil_cliente.descripcion) as perfilcli,
CONCAT_WS('-',lugar_trabajo.codigo_ruc,lugar_trabajo.nombre) as centrotrab,
CONCAT_WS('-',lugar_trabajo.telefono1,lugar_trabajo.telefono2,lugar_trabajo.telefono3) as tlfcentrtran,
CONCAT_WS('-',lugar_trabajo.direccion,lugar_trabajo.distrito) as direciontrabajo,
proceso_cobro.credito,
proceso_cobro.letra,
proceso_cobro.num_cuotas,
proceso_cobro.producto,
personal.primer_nombre,
acuerdo_pago.tproductos,
proceso_cobro.cond_pago,
proceso_cobro.a_partir_de
FROM
acuerdo_pago
INNER JOIN carga_dni ON carga_dni.dni = acuerdo_pago.dni
INNER JOIN cliente ON carga_dni.dni = cliente.dni
INNER JOIN perfil_cliente ON perfil_cliente.idperfil_cliente = cliente.idperfil_cliente
INNER JOIN lugar_trabajo ON cliente.idcliente = lugar_trabajo.idcliente
INNER JOIN proceso_cobro ON carga_dni.dni = proceso_cobro.dni
INNER JOIN personal ON personal.idpersonal = proceso_cobro.idpersonal
WHERE proceso_cobro.credito is not null
ORDER BY acuerdo_pago.dni ASC
 ";
        $query = $this->consulta($sql);

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

    function carga_dnicliente() {

        $this->conectar();
        $sql = " SELECT
acuerdo_pago.dni AS dniacuerdo,
acuerdo_pago.fecha_visita,
acuerdo_pago.fecha_verif,
acuerdo_pago.acuerdo,
acuerdo_pago.fuente,
acuerdo_pago.frecuencia_msg,
acuerdo_pago.hora,
acuerdo_pago.pagoen,
acuerdo_pago.fecha_up,
acuerdo_pago.amortiza,
acuerdo_pago.tcredito,
acuerdo_pago.tabono,
cliente.dni AS dnicliente,
CONCAT_WS(' ',cliente.nombres,cliente.apellidos) AS clint,
CONCAT_WS('-',cliente.telfcasa,cliente.telf1,cliente.telf2) AS tlfcliente,
CONCAT_WS('-',cliente.dir_actual,cliente.distrito) AS dircliente,
CONCAT_WS('.',perfil_cliente.abreviatura,perfil_cliente.descripcion) AS perfilcli,
CONCAT_WS('-',lugar_trabajo.codigo_ruc,lugar_trabajo.nombre) AS centrotrab,
CONCAT_WS('-',lugar_trabajo.telefono1,lugar_trabajo.telefono2,lugar_trabajo.telefono3) AS tlfcentrtran,
CONCAT_WS('-',lugar_trabajo.direccion,lugar_trabajo.distrito) AS direciontrabajo,
proceso_cobro.credito,
proceso_cobro.letra,
proceso_cobro.num_cuotas,
proceso_cobro.producto,
personal.primer_nombre,
acuerdo_pago.tproductos,
proceso_cobro.cond_pago,
proceso_cobro.a_partir_de
FROM
acuerdo_pago
INNER JOIN cliente ON cliente.dni =acuerdo_pago.dni
INNER JOIN perfil_cliente ON perfil_cliente.idperfil_cliente = cliente.idperfil_cliente
INNER JOIN lugar_trabajo ON cliente.idcliente = lugar_trabajo.idcliente
INNER JOIN proceso_cobro ON cliente.dni = proceso_cobro.dni
INNER JOIN personal ON personal.idpersonal = proceso_cobro.idpersonal
WHERE proceso_cobro.credito is not null
ORDER BY acuerdo_pago.dni ASC
 ";
        $query = $this->consulta($sql);

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

    function get_acuerdo_all($condi) {

        $this->conectar();
        $sql = "SELECT
acuerdos.idacuerdos,
acuerdos.fecha_visita,
acuerdos.acuerdos,
acuerdos.fecha_verificacion,
cliente.dni,
CONCAT_WS(' ',cliente.nombres,cliente.apellidos) AS nomcliente,
CONCAT_WS('',personal.primer_nombre,personal.segundo_nombre) AS persona,
acuerdos.calificacion,
acuerdos.frecuencia_msj,
acuerdos.hora,
acuerdos.pagoen,
CASE acuerdos.calificacion = '' WHEN '' then 'checked' END as cali
FROM
acuerdos
INNER JOIN cliente ON cliente.dni = acuerdos.dnic
INNER JOIN personal ON personal.idpersonal = acuerdos.idpersonal AND personal.dnipersonal = acuerdos.dnip
WHERE acuerdos.fecha_verificacion between '" . $condi['fechai'] . "' and '" . $condi['fechaf'] . "' 
ORDER BY acuerdos.fecha_verificacion DESC ";
        $query = $this->consulta($sql);

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

    function get_acuerdo_norecar() {

        $this->conectar();
        $sql = " SELECT
acuerdo_pago.dni,
acuerdo_pago.fecha_visita,
acuerdo_pago.fecha_verif as fecha_verificacion,
acuerdo_pago.acuerdo as acuerdos,
CONCAT_WS(' ',cliente.nombres,cliente.apellidos) AS nomcliente,
acuerdo_pago.fuente as persona,
acuerdo_pago.frecuencia_msg as frecuencia_msj,
acuerdo_pago.hora,
acuerdo_pago.pagoen
FROM
acuerdo_pago
INNER JOIN cliente ON acuerdo_pago.dni = cliente.dni
WHERE acuerdo_pago.fecha_verif = '" . date("Y-m-d") . "'
                ";
        $query = $this->consulta($sql);

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

    function get_rango_recibos() {

        $conp1 = str_pad($_REQUEST['rec1'], 6, "0", STR_PAD_LEFT);
        $conp2 = str_pad($_REQUEST['rec2'], 6, "0", STR_PAD_LEFT);

        $this->conectar();
        $sql = " SELECT
proceso_cobro.dni,
proceso_cobro.nro_recibo,
proceso_cobro.abono,
proceso_cobro.fecha_mov,
personal.primer_nombre,
CONCAT_WS(' ',cliente.nombres,cliente.apellidos) as cli
FROM
proceso_cobro
INNER JOIN personal ON personal.idpersonal = proceso_cobro.idpersonal
INNER JOIN cliente ON proceso_cobro.dni = cliente.dni
WHERE proceso_cobro.nro_recibo BETWEEN '" . $conp1 . "' and '" . $conp2 . "'
HAVING proceso_cobro.nro_recibo  is not null
order by proceso_cobro.nro_recibo ASC
                ";
        $query = $this->consulta($sql);

        $this->disconnect();
        if ($this->numero_de_filas($query) > 0) { // existe -> datos correctos
            //se llenan los datos en un array
            while ($tsArray = $this->fetch_assoc($query))
                $data[$tsArray['nro_recibo']] = $tsArray;
            return $data;
        } else {
            return '';
        }
    }

    function m_secpagos() {

        $this->conectar();
        $datos1 = array();
        $querydni = $this->consulta("
SELECT
carga_dni.dni,
cliente.dni AS dnicl,
CONCAT_WS(' ',cliente.apellidos,cliente.nombres) AS persona,
acuerdo_pago.unir
FROM
carga_dni
INNER JOIN cliente ON carga_dni.dni = cliente.dni
INNER JOIN acuerdo_pago ON carga_dni.dni = acuerdo_pago.dni
WHERE carga_dni.dni is not NULL");

        while ($rowdni = mysql_fetch_array($querydni)) {
            // -------------------- datos de acuerdo segun fecha maxima ------------    
            $query1 = $this->consulta("
            select
proceso_cobro.dni,
proceso_cobro.fecha_mov,
sum(proceso_cobro.abono) as abonar,
proceso_cobro.a_partir_de
FROM
proceso_cobro
WHERE (proceso_cobro.dni='" . $rowdni['dni'] . "') AND proceso_cobro.producto is null and proceso_cobro.fecha_mov BETWEEN '" . $_REQUEST['fechai'] . "' and '" . $_REQUEST['fechaf'] . "' 
GROUP BY proceso_cobro.fecha_mov  ");

            while ($row = mysql_fetch_array($query1)) {
                $datos1[$rowdni['dni'] . '_' . $rowdni['persona'] . '_' . $rowdni['unir']][$row['fecha_mov']] = $row;
            }
        }
        //echo '<pre>'; print_r($datos1);exit;
        $this->disconnect();
//        echo "<pre>";
//     print_r($datos1); exit;

        return $datos1;
    }

    function xcdm_secpagos() {

        $this->conectar();
        $sql = " SELECT
carga_dni.dni,
CONCAT_WS(' ',cliente.nombres,cliente.apellidos) as cliente
FROM
carga_dni
INNER JOIN cliente ON carga_dni.dni = cliente.dni
WHERE carga_dni.dni is not NULL
ORDER BY carga_dni.dni ASC
                ";
        $query = $this->consulta($sql);

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

    function get_data_reporte_anual() {
        $this->conectar();
        $sql = "select MONTH (proceso_cobro.fecha_mov) as mes ,
count(proceso_cobro.fecha_mov) as cantidad_cobros_agrupados,
sum(proceso_cobro.abono) as credito_total
from proceso_cobro
where (year (proceso_cobro.fecha_mov)='2014' or  year (proceso_cobro.fecha_mov)='2015'  or  year (proceso_cobro.fecha_mov)='2016') AND proceso_cobro.producto is NULL
GROUP BY  year (proceso_cobro.fecha_mov),MONTH (proceso_cobro.fecha_mov)";
        $query = $this->consulta($sql);

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

    function get_data_reporte_xpersonal_p() {
        $this->conectar();
        $sql = "SELECT
personal.idpersonal,
personal.primer_nombre
FROM
personal
INNER JOIN proceso_cobro ON personal.idpersonal = proceso_cobro.idpersonal
WHERE YEAR(proceso_cobro.fecha_mov)='2015' and proceso_cobro.abono is not null AND personal.estado='1'
GROUP BY personal.primer_nombre";
        $query = $this->consulta($sql);

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

    function get_data_reporte_xpersonal($idp) {
        $this->conectar();
        $sql = "SELECT
personal.idpersonal,
personal.primer_nombre,
MONTH(proceso_cobro.fecha_mov) as fech,
SUM(proceso_cobro.abono) as pago
FROM
personal
INNER JOIN proceso_cobro ON personal.idpersonal = proceso_cobro.idpersonal
WHERE  YEAR(proceso_cobro.fecha_mov)='2016' AND proceso_cobro.producto is NULL and personal.idpersonal='" . $idp . "'
GROUP BY YEAR(proceso_cobro.fecha_venta), MONTH(proceso_cobro.fecha_mov)
ORDER BY proceso_cobro.fecha_mov asc";
        $query = $this->consulta($sql);

        $this->disconnect();
        if ($this->numero_de_filas($query) > 0) { // existe -> datos correctos
            //se llenan los datos en un array
            $i=1;
            while ($tsArray = $this->fetch_assoc($query)) {
                while($i<=12){
                    if ($i == $tsArray['fech']) {
                        $data[] = $tsArray['pago'];
                       $i=$i+1;
                       break;
                    } else {
                        $data[] = 0;
                        $i=$i+1;
                        
                    }
                    
            }
        }
        while ($i<=12){
          $data[] = 0;  
          $i=$i+1;
        }
        return $data;
        } else {
            return '';
        }
    }

    function get_cierre_md($condi) {

        $this->conectar();
        $query = $this->consulta("
            select CONCAT_WS(' ',cliente.apellidos,cliente.nombres) as nombres,
                cliente.dni AS dni,proceso_cobro.dni AS dnip,
               sum(proceso_cobro.abono) as abono ,
               MAX(proceso_cobro.fecha_mov) as ultima_fecha
               from (cliente join proceso_cobro on((cliente.dni = proceso_cobro.dni))) 
               WHERE  (proceso_cobro.fecha_mov between '" . $condi['fechai'] . "' and '" . $condi['fechaf'] . "') 
                   and proceso_cobro.producto is null
                group by cliente.dni
               ORDER BY cliente.apellido_p ASC
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

    function set_vario_acuerdos($condicion_post) {


        $this->conectar();
        $querydni = $this->consulta("
SELECT
carga_dni.dni
FROM
carga_dni
WHERE carga_dni.dni is not NULL ");

        while ($rowdni = mysql_fetch_array($querydni)) {
            // -------------------- datos de acuerdo segun fecha maxima ------------    
            $query1 = $this->consulta("SELECT * FROM
                                    acuerdos
                                    WHERE acuerdos.dnic='" . $rowdni['dni'] . "'
                                    ORDER BY acuerdos.fecha_verificacion DESC
                                    ");
            $datos1 = array();
            $conta = -1;
            $contador = 0;
            while ($row = mysql_fetch_array($query1)) {
                $datos1[] = $row;
                $conta = $conta + 1;
                if ($datos1['' . $conta . '']['fecha_verificacion'] == $_REQUEST['fecha_limite']) {
                    $contador = $contador + 1;
                    break;
                }
            }
            if ($contador < 1) {
                // -------------------- la minima fecha para poder actualizar ------------   
                $query2 = $this->consulta("SELECT MIN(acuerdos.fecha_verificacion) as minfecha
                                    FROM
                                    acuerdos
                                    WHERE acuerdos.dnic='" . $rowdni['dni'] . "' ");
                $datos2 = array();
                while ($row = mysql_fetch_array($query2)) {
                    $datos2[] = $row;
                }
                // -------------------- contamos cuantos acuerdo tiene la persona ------------ 
                $query3 = $this->consulta("SELECT COUNT(acuerdos.idacuerdos) as cont
                                    FROM
                                    acuerdos
                                    WHERE acuerdos.dnic='" . $rowdni['dni'] . "' ");
                $datos3 = array();
                while ($row = mysql_fetch_array($query3)) {
                    $datos3[] = $row;
                }

                if ($datos3[0][cont] == 3) {
                    // -------------------- ejecutamos la actualizacion ------------ 


                    $query = $this->consulta("UPDATE `acuerdos` SET `idpersonal`=" . $_SESSION['idpersonal'] . ","
                            . " `dnip`='" . $_SESSION['dnipersonal'] . "', `acuerdos`='" . $condicion_post['txtacuerdo'] . "',"
                            . " `fecha_verificacion`='" . $condicion_post['fecha_limite'] . "',`fecha_visita`='" . $condicion_post['fecha_visita'] . "',"
                            . "`calificacion`='',`frecuencia_msj`='" . $condicion_post['frecuencia_msg'] . "',`hora`='" . $condicion_post['hora'] . "',`pagoen`='" . $condicion_post['pagoen'] . "',`fuente`='" . $condicion_post['idpersonal'] . "'"
                            . " WHERE (`dnic`='" . $rowdni['dni'] . "' and `fecha_verificacion`='" . $datos2[0]['minfecha'] . "')");
                } else {

                    $query = $this->consulta("INSERT INTO `acuerdos` (`idpersonal`, `dnic`, `dnip`, `acuerdos`,`fecha_verificacion`,`fecha_visita`,`frecuencia_msj`,`hora`,`pagoen`,`fuente`)"
                            . "VALUES (" . $_SESSION['idpersonal'] . ", '" . $rowdni['dni'] . "',"
                            . " '" . $_SESSION['dnipersonal'] . "', '" . utf8_decode($condicion_post['txtacuerdo']) . "',"
                            . " '" . $condicion_post['fecha_limite'] . "','" . $condicion_post['fecha_visita'] . "',"
                            . "'" . $condicion_post['frecuencia_msg'] . "','" . $condicion_post['hora'] . "','" . $condicion_post['pagoen'] . "','" . $condicion_post['idpersonal'] . "')");
                }
                //----------------------------poner datos a la nueva tabla acuerdo_pago
                // -------------------- buscamos si el dni esta o no ------------    
                $querya_p1 = $this->consulta(" SELECT
                                    COUNT(acuerdo_pago.dni) as midni
                                    FROM
                                    acuerdo_pago
                                    WHERE acuerdo_pago.dni='" . $rowdni['dni'] . "'  ");
                $datosa_p1 = array();
                while ($row = mysql_fetch_array($querya_p1)) {
                    $datosa_p1[] = $row;
                }

                if ($datosa_p1[0]['midni'] == 1) {

                    $query = $this->consulta(" UPDATE `acuerdo_pago` SET `fecha_visita`='" . $condicion_post['fecha_visita'] . "',
              `fecha_verif`='" . $condicion_post['fecha_limite'] . "', `acuerdo`='" . $condicion_post['txtacuerdo'] . "',
                  `fuente`='" . $condicion_post['idpersonal'] . "', `frecuencia_msg`='" . $condicion_post['frecuencia_msg'] . "',
                  `hora`='" . $condicion_post['hora'] . "', `pagoen`='" . $condicion_post['pagoen'] . "' WHERE `dni`='" . $rowdni['dni'] . "'  ");
                } else {
                    $query = $this->consulta("INSERT INTO `acuerdo_pago` (`dni`, `fecha_visita`, `fecha_verif`, `acuerdo`, `fuente`, `frecuencia_msg`, `hora`, `pagoen`)
                   VALUES ('" . $rowdni['dni'] . "' , '" . $condicion_post['fecha_visita'] . "',
                   '" . $condicion_post['fecha_limite'] . "', '" . utf8_decode($condicion_post['txtacuerdo']) . "', '" . $condicion_post['idpersonal'] . "',
                   '" . $condicion_post['frecuencia_msg'] . "', '" . $condicion_post['hora'] . "',
                   '" . $condicion_post['pagoen'] . "')");
                }
            }
        }
        $this->disconnect();
    }

    function _reprogramacion($condicion_post) {

        //conexion a la base de datos
//                echo"<pre>";print_r($condicion_post);exit;
        $this->conectar();

        $query = $this->consulta("update proceso_cobro set letra='" . $condicion_post['ncuota'] . "',credito='" . $condicion_post['ncredito'] . "',num_cuotas='" . $condicion_post['nmeses'] . "',a_partir_de='" . $condicion_post['nfecha'] . "' WHERE idproceso_cobro='" . $condicion_post['idprocesoC'] . "' ");

        //----------------------------poner datos a la nueva tabla acuerdo_pago
        // -------------------- buscamos si el dni esta o no ------------   
        $query2 = $this->consulta(" SELECT
                                        proceso_cobro.dni
                                        FROM
                                        proceso_cobro
                                        WHERE proceso_cobro.idproceso_cobro='" . $condicion_post['idprocesoC'] . "' ");
        $datos2 = array();
        while ($row = mysql_fetch_array($query2)) {
            $datos2[] = $row;
        }


        $querya_p1 = $this->consulta(" SELECT
                                    COUNT(acuerdo_pago.dni) as midni
                                    FROM
                                    acuerdo_pago
                                    WHERE acuerdo_pago.dni='" . $datos2[0]['dni'] . "' ");
        $datosa_p1 = array();
        while ($row = mysql_fetch_array($querya_p1)) {
            $datosa_p1[] = $row;
        }

        //--------------------------suma el total de credito
        $queryc_a1 = $this->consulta(" SELECT
                                    SUM(proceso_cobro.credito) as totcredito,
                                    SUM(proceso_cobro.abono) as totabono,
                                    COUNT(proceso_cobro.producto) as tpro
                                    FROM
                                    proceso_cobro
                                    WHERE proceso_cobro.dni='" . $datos2[0]['dni'] . "'  ");
        $datosc_a1 = array();
        while ($row = mysql_fetch_array($queryc_a1)) {
            $datosc_a1[] = $row;
        }

        //-------------------
        if ($datosa_p1[0]['midni'] == 1) {

            $query = $this->consulta("UPDATE `acuerdo_pago` SET `tcredito`='" . $datosc_a1[0]['totcredito'] . "',`tabono`='" . $datosc_a1[0]['totabono'] . "',`tproductos`='" . $datosc_a1[0]['tpro'] . "'
                                         WHERE `dni`='" . $datos2[0]['dni'] . "'");
        } else {
            $query = $this->consulta("INSERT INTO `acuerdo_pago` (`dni`,`tcredito`,`tabono`,`tproductos`) 
                                      VALUES ('" . $datos2[0]['dni'] . "','" . $datosc_a1[0]['totcredito'] . "','" . $datosc_a1[0]['totabono'] . "','" . $datosc_a1[0]['tpro'] . "')");
        }

        $this->disconnect();
    }

    function set_compara_acuer() {

        $this->conectar();
        $query = $this->consulta("
SELECT
acuerdo_pago.dni,
acuerdo_pago.fecha_up,
acuerdo_pago.tcredito,
acuerdo_pago.tabono,
acuerdo_pago.tproductos,
acuerdo_pago.frecuencia_msg,
acuerdo_pago.fecha_verif,
acuerdo_pago.pagoen
FROM
acuerdo_pago
WHERE acuerdo_pago.unir='d'
 ");
        $con = 0;
        $conn = 0;
        $fecha2 = $_REQUEST['fechcorre'];

        while ($row = mysql_fetch_array($query)) {
// $row es un array con todos los campos existentes en la tabla
            //echo $row['tabono'];
            if ($row['tabono'] < $row['tcredito']) {
//
//
                if ($row['fecha_up'] == date("Y-m-d")) {
                    $con = $con + 1;

////                    // actualizamos acuerdo hciendo chech al maximo 
                    $query_ab = $this->consulta("UPDATE `acuerdos` SET  `calificacion`='3' "
                            . " WHERE `dnic`='" . $row['dni'] . "' and `fecha_verificacion`='" . $row['fecha_up'] . "'");

                    if ($row['fecha_verif'] <= date("Y-m-d")) {
//                        //que se auto gener el diario y actualizando a la menor fecha del acuerdo
//                        // -------------------- datos de acuerdo segun fecha maxima ------------    
                        $query1 = $this->consulta("SELECT * FROM
                                    acuerdos
                                    WHERE acuerdos.dnic='" . $row['dni'] . "'
                                    ORDER BY acuerdos.fecha_verificacion DESC
                                    ");
                        $datos1 = array();
                        $conta = -1;
                        $contador = 0;
                        while ($row1 = mysql_fetch_array($query1)) {
                            $conta = $conta + 1;
                            $datos1[] = $row1;
                            if ($datos1['' . $conta . '']['fecha_verificacion'] == $_REQUEST['fechcorre']) {
                                $contador = $contador + 1;
                                break;
                            }
                        }
                        if ($contador < 1) {

////                        // -------------------- la minima fecha para poder actualizar ------------   
                            $query2 = $this->consulta("SELECT MIN(acuerdos.fecha_verificacion) as minfecha
                                    FROM
                                    acuerdos
                                    WHERE acuerdos.dnic='" . $row['dni'] . "' ");
                            $datos2 = array();
                            while ($row2 = mysql_fetch_array($query2)) {
                                $datos2[] = $row2;
                            }
////                        // -------------------- contamos cuantos acuerdo tiene la persona ------------ 
                            $query3 = $this->consulta("SELECT COUNT(acuerdos.idacuerdos) as cont
                                    FROM
                                    acuerdos
                                    WHERE acuerdos.dnic='" . $row['dni'] . "' ");
                            $datos3 = array();
                            while ($row3 = mysql_fetch_array($query3)) {
                                $datos3[] = $row3;
                            }

////
                            //$fecha2 = $_REQUEST['fechcorre']; 
                            // echo "fd".$fecha2; exit;
                            // date("Y-m-d", strtotime("+1 day"));
                            if ($datos3[0]['cont'] == 3) {
//                            // -------------------- ejecutamos la actualizacion ------------ 

                                $query_a = $this->consulta("UPDATE `acuerdos` SET `idpersonal`=" . $_SESSION['idpersonal'] . ", `dnic`='" . $datos1[0]['dnic'] . "',"
                                        . "`dnip`='" . $_SESSION['dnipersonal'] . "',`acuerdos`='" . $datos1[0]['acuerdos'] . "', `fecha_verificacion`='" . $fecha2 . "',"
                                        . "`fecha_visita`='" . $row['fecha_verif'] . "',`calificacion`=' ',"
                                        . "`frecuencia_msj`='" . $datos1[0]['frecuencia_msj'] . "', `hora`='" . $datos1[0]['hora'] . "',`pagoen`='" . $datos1[0]['pagoen'] . "',`fuente`='" . $datos1[0]['fuente'] . "'"
                                        . " WHERE `dnic`='" . $row['dni'] . "' and `fecha_verificacion`='" . $datos2[0]['minfecha'] . "'");
                            } else {

                                $query_a = $this->consulta("INSERT INTO `acuerdos` (`idpersonal`, `dnic`, `dnip`, `acuerdos`,`fecha_verificacion`,`fecha_visita`,`frecuencia_msj`,`hora`,`pagoen`,`fuente`)"
                                        . "VALUES (" . $_SESSION['idpersonal'] . ", '" . $row['dni'] . "',"
                                        . " '" . $_SESSION['dnipersonal'] . "', '" . utf8_decode($datos1[0]['acuerdos']) . "',"
                                        . " '" . $fecha2 . "','" . $row['fecha_verif'] . "',"
                                        . "'" . $datos1[0]['frecuencia_msj'] . "','" . $datos1[0]['hora'] . "','" . $datos1[0]['pagoen'] . "','" . $datos1[0]['fuente'] . "')");
//                           
                            }
                            $query_abc = $this->consulta(" UPDATE `acuerdo_pago` SET `fecha_visita`='" . $row['fecha_verif'] . "', `fecha_verif`='" . $fecha2 . "' WHERE `dni`='" . $row['dni'] . "'");
                        }
                    }
                }  //if ($row['fecha_up'] == date("Y-m-d")) { 
                else {

                    $conn = $conn + 1;

                    if ($row['fecha_verif'] <= date("Y-m-d")) {

                        //que se auto gener el diario y actualizando a la menor fecha del acuerdo
                        // -------------------- datos de acuerdo segun fecha maxima ------------    
                        $query1 = $this->consulta("SELECT * FROM
                                    acuerdos
                                    WHERE acuerdos.dnic='" . $row['dni'] . "'
                                    ORDER BY acuerdos.fecha_verificacion DESC
                                    LIMIT 1");
                        $datos1 = array();
                        $conta = -1;
                        $contador = 0;
                        while ($row1 = mysql_fetch_array($query1)) {
                            $conta = $conta + 1;
                            $datos1[] = $row1;
                            if ($datos1['' . $conta . '']['fecha_verificacion'] == $_REQUEST['fechcorre']) {
                                $contador = $contador + 1;
                                break;
                            }
                        }

                        if ($contador < 1) {

                            // -------------------- la minima fecha para poder actualizar ------------   
                            $query2 = $this->consulta("SELECT MIN(acuerdos.fecha_verificacion) as minfecha
                                    FROM
                                    acuerdos
                                    WHERE acuerdos.dnic='" . $row['dni'] . "' ");
                            $datos2 = array();
                            while ($row2 = mysql_fetch_array($query2)) {
                                $datos2[] = $row2;
                            }
                            // -------------------- contamos cuantos acuerdo tiene la persona ------------ 
                            $query3 = $this->consulta("SELECT COUNT(acuerdos.idacuerdos) as cont
                                    FROM
                                    acuerdos
                                    WHERE acuerdos.dnic='" . $row['dni'] . "' ");
                            $datos3 = array();
                            while ($row3 = mysql_fetch_array($query3)) {
                                $datos3[] = $row3;
                            }
                            //$fecha2 =$_REQUEST['fechcorre']; 
                            // echo "fd".$fecha2; exit;
                            //fechcorre date("Y-m-d", strtotime("+1 day"));
                            if ($datos3[0]["cont"] == 3) {
                                // -------------------- ejecutamos la actualizacion ------------ 

                                $query_a = $this->consulta("UPDATE `acuerdos` SET `idpersonal`=" . $_SESSION['idpersonal'] . ", `dnic`='" . $datos1[0]['dnic'] . "',"
                                        . "`dnip`='" . $_SESSION['dnipersonal'] . "',`acuerdos`='" . $datos1[0]['acuerdos'] . "', `fecha_verificacion`='" . $fecha2 . "',"
                                        . "`fecha_visita`='" . $row['fecha_verif'] . "',`calificacion`=' ',"
                                        . "`frecuencia_msj`='" . $datos1[0]['frecuencia_msj'] . "', `hora`='" . $datos1[0]['hora'] . "',`pagoen`='" . $datos1[0]['pagoen'] . "',`fuente`='" . $datos1[0]['fuente'] . "'"
                                        . " WHERE `dnic`='" . $row['dni'] . "' and `fecha_verificacion`='" . $datos2[0]['minfecha'] . "'");
                            } else {
//
                                $query_a = $this->consulta("INSERT INTO `acuerdos` (`idpersonal`, `dnic`, `dnip`, `acuerdos`,`fecha_verificacion`,`fecha_visita`,`frecuencia_msj`,`hora`,`pagoen`,`fuente`)"
                                        . "VALUES (" . $_SESSION['idpersonal'] . ", '" . $row['dni'] . "',"
                                        . " '" . $_SESSION['dnipersonal'] . "', '" . utf8_decode($datos1[0]['acuerdos']) . "',"
                                        . " '" . $fecha2 . "','" . $row['fecha_verif'] . "',"
                                        . "'" . $datos1[0]['frecuencia_msj'] . "','" . $datos1[0]['hora'] . "','" . $datos1[0]['pagoen'] . "','" . $datos1[0]['fuente'] . "')");
//                           
                            }
                            $query_abc = $this->consulta(" UPDATE `acuerdo_pago` SET `fecha_visita`='" . $row['fecha_verif'] . "', `fecha_verif`='" . $fecha2 . "' WHERE `dni`='" . $row['dni'] . "'");
                        }
                    }
                }  //if ($row['fecha_up'] == date("Y-m-d")) { 
            }
        }

        $this->disconnect();
    }

    function get_recibos($condi) {

        $this->conectar();
        $query = $this->consulta("
        SELECT
        proceso_cobro.dni,
        proceso_cobro.fecha_mov,
        proceso_cobro.documento,
        proceso_cobro.nro_recibo,
        proceso_cobro.abono
        FROM
        proceso_cobro
WHERE (proceso_cobro.fecha_mov BETWEEN '" . $condi['fechai'] . "' and '" . $condi['fechaf'] . "') and proceso_cobro.abono > 0
ORDER BY proceso_cobro.fecha_mov,proceso_cobro.nro_recibo ASC ");
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

    function get_cierre_gestor($condi) {

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
                WHERE  (proceso_cobro.fecha_mov between '" . $condi['fechai'] . "' and '" . $condi['fechaf'] . "')
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

    function get_deuda_cero($condi) {

        $this->conectar();
        
    $query = $this->consulta("SELECT
concat_ws('  ',cliente.apellidos,cliente.nombres) AS nombr,
cliente.dni AS dni,
proceso_cobro.dni AS dnip,
Sum(proceso_cobro.abono) AS abonar,
Max(proceso_cobro.fecha_mov) AS ultima_fechap,
acuerdo_pago.tcredito,
(acuerdo_pago.tcredito - Sum(proceso_cobro.abono)) as sall
FROM
(cliente
JOIN proceso_cobro ON ((cliente.dni = proceso_cobro.dni)))
INNER JOIN acuerdo_pago ON proceso_cobro.dni = acuerdo_pago.dni
WHERE proceso_cobro.credito is NULL
group by `cliente`.`dni`
HAVING  (ultima_fechap BETWEEN '" . $condi['fechai'] . "' and '" . $condi['fechaf'] . "') and acuerdo_pago.tcredito<= abonar
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

}

//cierre la clse de m reportes