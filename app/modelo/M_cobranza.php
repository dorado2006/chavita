<?php

/*
  CLASE PARA LA GESTION DE LOS UNIVERSITARIOS
 */
require_once '../app/ConBD.php';

class M_cobranza extends database {
    /* REALIZA UNA CONSULTA A LA BASE DE DATOS EN BUSCA DE  REGISTROS UNIVERSITARIOS DADOS COMO
      PARAMETROS LA "CARRERA" Y LA "CANTIDAD" DE REGISTROS A MOSTRAR
      INPUT:
      $carrera | nombre de la carrera a buscar
      $limit | cantidad de registros a mostrar
      OUTPUT:
      $data | Array con los registros obtenidos, si no existen datos, su valor es una cadena vacia
     */

    function imprimir_cronograma_cliente() {

        $this->conectar();
        $query = $this->consulta("SELECT
        cliente.idcliente,
        cliente.nombres,
        cliente.apellidos,
        cliente.dni,
        cliente.telfcasa,
        cliente.telf1,
        cliente.telf2,
        CONCAT_WS(' ',cliente.dir_actual,cliente.distrito)AS direccion ,
        convenio.descripcion,
        lugar_trabajo.nombre AS lugartrabajo,        
        CONCAT_WS(' -',lugar_trabajo.direccion,lugar_trabajo.distrito) AS trabaja_dir,
        lugar_trabajo.codigo_ruc
        FROM
        cliente
        INNER JOIN convenio ON cliente.idconvenio = convenio.idconvenio
        INNER JOIN lugar_trabajo ON cliente.idcliente = lugar_trabajo.idcliente where cliente.dni='" . $_REQUEST['idprodni'] . "'
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

    function imprimir_cronograma_detalle_cretito() {

        $this->conectar();
        if ($_REQUEST['cond'] == 1) {
            $var = " and (proceso_cobro.idventa= '" . $_REQUEST['idve'] . "'or  proceso_cobro.idproceso_cobro='" . $_REQUEST['idve'] . "')";
        } else {
            $var = '';
        }
        $query = $this->consulta("
          SELECT   
proceso_cobro.idproceso_cobro,
proceso_cobro.dni,
proceso_cobro.credito,
proceso_cobro.fecha_mov,
proceso_cobro.letra,
proceso_cobro.producto,
proceso_cobro.cond_pago,
proceso_cobro.a_partir_de,
proceso_cobro.num_cuotas,
proceso_cobro.abono,
proceso_cobro.documento,
proceso_cobro.nro_recibo,
proceso_cobro.frecuencia_msg,
CASE WHEN proceso_cobro.frecuencia_msg='DIARIO' THEN '1' WHEN proceso_cobro.frecuencia_msg='SEMANAL'  THEN '7' 
WHEN proceso_cobro.frecuencia_msg='QUINCENA' THEN '15'  ELSE '30' END as 	frecuen,
TIMESTAMPDIFF(DAY, proceso_cobro.a_partir_de, CURDATE()) AS distrasc
FROM
proceso_cobro
where proceso_cobro.dni='" . $_REQUEST['idprodni'] . "' $var
    ORDER BY proceso_cobro.fecha_mov
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

    function generar_cronograma($condicion) {

        //conexion a la base de datos
        $this->conectar();
        $query = $this->consulta("
            SELECT
                venta.idventa,
                venta.total,
                venta.monto_cuota,
                venta.num_cuota,
                venta.fecha_venta,
                venta.a_partir_de,
                venta.condicion_pago,
                cliente.idcliente,
                cliente.dni,
                venta.idcliente
                FROM
                venta
                INNER JOIN cliente ON cliente.idcliente = venta.idcliente
                ORDER BY cliente.dni ASC

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

    function buscarventa() {

        //conexion a la base de datos
        $this->conectar();
        $query = $this->consulta("
           SELECT
proceso_cobro.idproceso_cobro,
proceso_cobro.fecha_mov,
proceso_cobro.letra,
proceso_cobro.credito,
( SELECT sum(pa.abono)
FROM
proceso_cobro as pa
WHERE pa.dni='" . $_REQUEST['idprodni'] . "' and pa.idventa='" . $_REQUEST['idve'] . "' ) as abo,

proceso_cobro.dni,
proceso_cobro.cond_pago,
proceso_cobro.frecuencia_msg,
CASE WHEN proceso_cobro.frecuencia_msg='DIARIO' THEN '1' WHEN proceso_cobro.frecuencia_msg='SEMANAL'  THEN '7' 
WHEN proceso_cobro.frecuencia_msg='QUINCENA' THEN '15'  ELSE '30' END as 	frecuen,
proceso_cobro.producto,
proceso_cobro.num_cuotas,
proceso_cobro.a_partir_de
FROM
proceso_cobro
WHERE proceso_cobro.dni='" . $_REQUEST['idprodni'] . "' and proceso_cobro.idproceso_cobro='" . $_REQUEST['idve'] . "' 
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

    function actualizar__acuerdo($param) {
        $this->conectar();
        $query = $this->consulta("UPDATE `acuerdos` SET `calificacion`='" . $param['valor'] . "' WHERE (`idacuerdos`=" . $param['idacuerdo'] . ")");
        $this->disconnect();
    }

    function elimina_acuerdo($param) {
        $this->conectar();
        $query = $this->consulta("DELETE FROM `acuerdos` WHERE (`idacuerdos`=" . $param['idacuerdo'] . ")");
        $this->disconnect();
    }

    function elimina_pago($param) {
        $this->conectar();
        $query = $this->consulta("DELETE FROM `proceso_cobro` WHERE (`idproceso_cobro`=" . $param['idpago'] . ") and `dni`='" . $param['dni_a'] . "'");
        $this->consulta("update proceso_cobro set proceso_cobro.abono =proceso_cobro.abono  - '" . $param['monto'] . "',proceso_cobro.saldo =proceso_cobro.saldo  + '" . $param['monto'] . "'  WHERE proceso_cobro.idproceso_cobro='" . $param['idventaa'] . "' and proceso_cobro.dni ='" . $param['dni_a'] . "'");


        $query3 = $this->consulta("
            SELECT
            proceso_cobro.idproceso_cobro,
            proceso_cobro.idventa,
            proceso_cobro.idpersonal,
            proceso_cobro.fecha_mov,
            proceso_cobro.letra,
            proceso_cobro.credito,
            proceso_cobro.abono,
            proceso_cobro.saldo
            FROM
            proceso_cobro
            WHERE proceso_cobro.idproceso_cobro='" . $param['idventaa'] . "'");

        $datos3 = array();
        while ($row = mysql_fetch_array($query3)) {
            $datos3[] = $row;
        }

        if ($datos3[0]['abono'] < $datos3[0]['credito']) {

            $query_apdabon = $this->consulta("update proceso_cobro set proceso_cobro.cond_pago='DIRECTO',proceso_cobro.estado='1'  WHERE proceso_cobro.idproceso_cobro='" . $param['idventaa'] . "' and proceso_cobro.dni ='" . $param['dni_a'] . "'");
            $query_apx = $this->consulta("update proceso_cobro set proceso_cobro.estado='1'  WHERE proceso_cobro.idventa='" . $param['idventaa'] . "' and  proceso_cobro.producto is NULL and proceso_cobro.dni ='" . $param['dni_a'] . "'");
        }
        $this->disconnect();
    }

    function m_unir_acuerdos() {
        $this->conectar();
        $query = $this->consulta("UPDATE `acuerdo_pago` SET `unir`='" . $_REQUEST['unir'] . "' WHERE `dni`='" . $_REQUEST['dni'] . "'");
        $this->disconnect();
    }

    function formulario_acuerdo($condicion) {
//echo '<pre>'; print_r($condicion);exit;
        //conexion a la base de datos
        $this->conectar();
        $query = $this->consulta("
            SELECT
acuerdos.idacuerdos,
acuerdos.idpersonal,
acuerdos.dnip,
acuerdos.acuerdos,
acuerdos.descripcion,
acuerdos.fecha_verificacion,
acuerdos.fecha_visita,
acuerdos.frecuencia_msj,
acuerdos.hora,
acuerdos.pagoen,
acuerdos.fuente,
CASE WHEN acuerdos.estado='1' THEN 'checked' ELSE '0' end as estadoo,
personal.dnipersonal,CONCAT_WS(' ',personal.primer_nombre,personal.segundo_nombre) as personal,
CONCAT_WS(' ',cliente.nombres,cliente.apellidos) as datclientes,
cliente.dni,
acuerdos.calificacion

FROM
acuerdos
INNER JOIN personal ON personal.idpersonal = acuerdos.idpersonal
INNER JOIN cliente ON cliente.dni = acuerdos.dnic
WHERE cliente.dni='" . $condicion['idcliente'] . "'
ORDER BY acuerdos.fecha_verificacion DESC 
LIMIT 5 ");
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

    function generar_actu_pagos() {

        //conexion a la base de datos
        $this->conectar();


        $query = $this->consulta("
  SELECT
auxpagos.dnicli,
auxpagos.cond_pgo,
auxpagos.monto,
auxpagos.numcuota,
auxpagos.fechapago,
auxpagos.num_recibo
FROM
auxpagos
WHERE auxpagos.monto >=1
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

    function correlativo() {

        //conexion a la base de datos
        $this->conectar();


        $query = $this->consulta("
 SELECT
correlativo.idcorre,
correlativo.correlativo,
correlativo.idpersonal as cobrador
FROM
correlativo
WHERE correlativo.idcorre='" . $_SESSION['idpersonal'] . "'");
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

    function busca_produc() {

        //conexion a la base de datos
        $this->conectar();


        $query = $this->consulta("
SELECT
proceso_cobro.idproceso_cobro,
proceso_cobro.idventa,
proceso_cobro.idpersonal,
proceso_cobro.fecha_mov,
proceso_cobro.letra,
proceso_cobro.credito,
proceso_cobro.abono,
proceso_cobro.saldo
FROM
proceso_cobro
WHERE proceso_cobro.idproceso_cobro='" . $_REQUEST['idproccobro'] . "'");
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

    function foreditcred() {

        //conexion a la base de datos
        $this->conectar();
        $query = $this->consulta("SELECT
        proceso_cobro.idproceso_cobro,
        proceso_cobro.idventa,
        proceso_cobro.fecha_mov,
        proceso_cobro.letra,
        proceso_cobro.credito,
        proceso_cobro.abono,
        proceso_cobro.resto,
        proceso_cobro.saldo,
        proceso_cobro.dni,
        proceso_cobro.a_partir_de,
        proceso_cobro.producto,
        proceso_cobro.cond_pago,
        proceso_cobro.frecuencia_msg,
        proceso_cobro.num_cuotas,
        cnd_pago.id,
        cnd_pago.cond_pago
FROM
proceso_cobro
INNER JOIN cnd_pago ON proceso_cobro.cond_pago = cnd_pago.cond_pago
WHERE proceso_cobro.idproceso_cobro='" . $_REQUEST['idprocventa1'] . "' and proceso_cobro.dni='" . $_REQUEST['idprodni'] . "'");
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

    function fotos() {

        //conexion a la base de datos
        $this->conectar();
        $query = $this->consulta("
SELECT proceso_cobro.dni,proceso_cobro.idproceso_cobro from proceso_cobro 
WHERE proceso_cobro.idproceso_cobro = '" . $_REQUEST['idproc_cobr'] . "'
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

    function set_acuerdos_exel($condicion_post) {


        $this->conectar();
        $querydni = $this->consulta("
                SELECT
                auxpagos.dnicli as dni,
                auxpagos.fechapago,
                auxpagos.acuerdo,
                auxpagos.fuente
                FROM
                auxpagos
                WHERE auxpagos.dnicli is not NULL ");

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
                if ($datos1['' . $conta . '']['fecha_verificacion'] == $rowdni['fechapago']) {
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
                            . " `dnip`='" . $_SESSION['dnipersonal'] . "', `acuerdos`='" . $rowdni['acuerdo'] . "',"
                            . " `fecha_verificacion`='" . $rowdni['fechapago'] . "',`fecha_visita`='" . date("Y-m-d") . "',"
                            . "`calificacion`='',`fuente`='" . $rowdni['fuente'] . "'"
                            . " WHERE (`dnic`='" . $rowdni['dni'] . "' and `fecha_verificacion`='" . $datos2[0]['minfecha'] . "')");

                    $query_ab = $this->consulta("UPDATE `acuerdos` SET  `calificacion`='1' "
                            . " WHERE `dnic`='" . $rowdni['dni'] . "' and `fecha_verificacion`='" . date("Y-m-d") . "'");
                } else {

                    $query = $this->consulta("INSERT INTO `acuerdos` (`idpersonal`, `dnic`, `dnip`, `acuerdos`,`fecha_verificacion`,`fecha_visita`,`fuente`)"
                            . "VALUES (" . $_SESSION['idpersonal'] . ", '" . $rowdni['dni'] . "',"
                            . " '" . $_SESSION['dnipersonal'] . "', '" . utf8_decode($rowdni['acuerdo']) . "',"
                            . " '" . $rowdni['fechapago'] . "','" . date("Y-m-d") . "',"
                            . "'" . $rowdni['fuente'] . "')");
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

                    $query = $this->consulta(" UPDATE `acuerdo_pago` SET `fecha_visita`='" . date("Y-m-d") . "',
              `fecha_verif`='" . $rowdni['fechapago'] . "', `acuerdo`='" . $rowdni['acuerdo'] . "',
                  `fuente`='" . $rowdni['fuente'] . "' WHERE `dni`='" . $rowdni['dni'] . "'  ");
                } else {
                    $query = $this->consulta("INSERT INTO `acuerdo_pago` (`dni`, `fecha_visita`, `fecha_verif`, `acuerdo`, `fuente`)
                   VALUES ('" . $rowdni['dni'] . "' , '" . date("Y-m-d") . "',
                   '" . $rowdni['fechapago'] . "', '" . utf8_decode($rowdni['acuerdo']) . "', '" . $rowdni['fuente'] . "')");
                }
            }
        }
        $this->disconnect();
    }

    function generatu() {

        //conexion a la base de datos WHERE proceso_cobro.cond_pago='cancelado'  and acuerdo_pago.tproductos=1
        //WHERE proceso_cobro.cond_pago='planilla' or proceso_cobro.cond_pago='directo'
        $this->conectar();
        $query = $this->consulta("
SELECT
proceso_cobro.dni,
max(proceso_cobro.fecha_mov) as abo,
acuerdo_pago.fecha_up as tabo
FROM
proceso_cobro
INNER JOIN acuerdo_pago ON proceso_cobro.dni = acuerdo_pago.dni
WHERE proceso_cobro.producto is NULL
GROUP BY proceso_cobro.dni
HAVING abo != tabo

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

    function reportes($condicion_p, $op) {

        if ($op == 1) {
            $micond = "reporte2_condicion.cond_pago='" . $condicion_p['condi'] . "'";
        } else {
            if ($op == 3) {
                $micond = "reporte2_condicion.cond_pago='" . $condicion_p['condi'] . "' and reporte2_condicion.distrito='" . $condicion_p['condi1'] . "'";
            } else {
                $micond = "reporte2_condicion.distrito='" . $condicion_p['condi1'] . "'
             AND (reporte2_condicion.cond_pago='PLANILLA' 
            OR reporte2_condicion.cond_pago='DIRECTO') ";
            }
        }
        //conexion a la base de datos
        $this->conectar();
        $query = $this->consulta("
           SELECT
reporte2_condicion.apellido_p,
reporte2_condicion.nombres,
reporte2_condicion.direcion_cliente,
reporte2_condicion.telefonos_cliente,
reporte2_condicion.codigo_ruc,
reporte2_condicion.nombre,
reporte2_condicion.direccion,
reporte2_condicion.distrito,
reporte2_condicion.T_servidor,
reporte2_condicion.dni,
reporte1_condi.credito,
reporte1_condi.abonar,
reporte1_condi.letra,
reporte2_condicion.cond_pago,
reporte1_condi.ultima_fechap,
reporte2_condicion.a_partir_de
FROM
 reporte2_condicion
INNER JOIN reporte1_condi ON reporte2_condicion.dni = reporte1_condi.dni 
where $micond
ORDER BY reporte2_condicion.apellido_p ASC

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

    function print_sector($condicion_p, $op) {

        $op = $op;
        $cond = $condicion_p['seleccondic'];
        $cond_distri = $condicion_p['seleccondicDistrito'];


        foreach ($_POST['pasarplanilla'] as $value) {
            //echo"<pre>";print_r($condicion_p);exit;

            if ($op == 1) {

                $micond = "reporte2_condicion.cond_pago='" . $cond . "' and reporte2_condicion.dni='" . $value . "'";
            } else {
                if ($op == 3) {
                    $micond = "reporte2_condicion.cond_pago='" . $cond . "' and reporte2_condicion.distrito='" . $cond_distri . "' and reporte2_condicion.dni='" . $value . "'";
                } else {
                    $micond = "reporte2_condicion.distrito='" . $cond_distri . "'
             AND (reporte2_condicion.cond_pago='PLANILLA' 
            OR reporte2_condicion.cond_pago='DIRECTO') and reporte2_condicion.dni='" . $value . "'";
                }
            }
            //conexion a la base de datos
            $this->conectar();
            $query = " SELECT
reporte2_condicion.apellido_p,
reporte2_condicion.nombres,
reporte2_condicion.direcion_cliente,
reporte2_condicion.telefonos_cliente,
reporte2_condicion.codigo_ruc,
reporte2_condicion.nombre,
reporte2_condicion.direccion,
reporte2_condicion.distrito,
reporte2_condicion.T_servidor,
reporte2_condicion.dni,
reporte1_condi.credito,
reporte1_condi.abonar,
reporte2_condicion.num_cuotas,
reporte1_condi.letra,
reporte2_condicion.cond_pago,
reporte1_condi.ultima_fechap,
reporte2_condicion.a_partir_de
FROM
 reporte2_condicion
INNER JOIN reporte1_condi ON reporte2_condicion.dni = reporte1_condi.dni 
where $micond
ORDER BY reporte2_condicion.apellido_p ASC";

            $query = $this->consulta($query);
            $this->disconnect();

            //se llenan los datos en un array

            $tsArray = $this->fetch_assoc($query);
            $data[] = $tsArray;
            //return $data;
        }
        // print_r($data);echo "<br>";exit;
        return $data;
    }

    function lugar_trb_distritos() {

        //conexion a la base de datos
        $this->conectar();
        $query = $this->consulta("SELECT 
lugar_trabajo.distrito
FROM
lugar_trabajo
GROUP BY lugar_trabajo.distrito
ORDER BY lugar_trabajo.distrito ASC
        
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

    function distrito() {
//ubigeo_geografico.coddpto=22
        //ubigeo_geografico.coddpto=16  loreto
        //conexion a la base de datos
        $this->conectar();
        $query = $this->consulta("SELECT
ubigeo_geografico.codubigeo,
ubigeo_geografico.coddpto,
ubigeo_geografico.codprov,
ubigeo_geografico.coddist,
ubigeo_geografico.nombre
FROM
ubigeo_geografico
WHERE ubigeo_geografico.coddpto=22 and ubigeo_geografico.codprov !=0 and ubigeo_geografico.coddist !=0 
ORDER BY ubigeo_geografico.codprov ASC 
        
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

    function provincias() {

        //conexion a la base de datos
        $this->conectar();
        $query = $this->consulta("SELECT
ubigeo_geografico.codubigeo,
ubigeo_geografico.coddpto,
ubigeo_geografico.codprov,
ubigeo_geografico.coddist,
ubigeo_geografico.nombre
FROM
ubigeo_geografico
WHERE  ubigeo_geografico.codprov !=0 and ubigeo_geografico.coddist=0 
ORDER BY ubigeo_geografico.nombre ASC
        
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

    function departamentos() {

        //conexion a la base de datos
        $this->conectar();
        $query = $this->consulta("SELECT
ubigeo_geografico.codubigeo,
ubigeo_geografico.coddpto,
ubigeo_geografico.codprov,
ubigeo_geografico.coddist,
ubigeo_geografico.nombre
FROM
ubigeo_geografico
WHERE  ubigeo_geografico.codprov=0 and ubigeo_geografico.coddist=0
ORDER BY ubigeo_geografico.nombre ASC
        
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

    function tipo_servidor() {

        //conexion a la base de datos
        $this->conectar();
        $query = $this->consulta("SELECT
perfil_cliente.idperfil_cliente,
CONCAT_WS('.',perfil_cliente.abreviatura,perfil_cliente.descripcion)as tiposervidor
FROM
perfil_cliente
        
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

    function condicion_pago($condicion_post) {

        //conexion a la base de datos
//                echo"<pre>";print_r($condicion_post);exit;
        $this->conectar();

        $query = $this->consulta("update proceso_cobro set cond_pago='" . $condicion_post['cp'] . "' WHERE idproceso_cobro='" . $condicion_post['idpc'] . "' ");
        $this->disconnect();
    }

    function evaluacion($condicion_post) {

        //conexion a la base de datos
//                echo"<pre>";print_r($condicion_post);exit;
        $this->conectar();

        $query = $this->consulta(" UPDATE `cliente` SET `calificacion`='" . $condicion_post['mieval'] . "' WHERE (`dni`='" . $condicion_post['dnic'] . "')");
        $this->disconnect();
    }

    function actualizar_cliente($condicion_post) {

        //conexion a la base de datos
//                echo"<pre>";print_r($condicion_post);exit;
        $this->conectar();

        $query = $this->consulta("UPDATE `cliente` SET `nombres`='" . utf8_decode($condicion_post['pnombre']) . "',`idperfil_cliente`='" . $condicion_post['tiposervidor'] . "', "
                . " `apellidos`='" . utf8_decode($condicion_post['papellido']) . "',"
                . " `dni`='" . $condicion_post['dni'] . "', "
                . "`telfcasa`='" . utf8_decode($condicion_post['tlf1']) . "', "
                . "`telf1`='" . utf8_decode($condicion_post['tlf2']) . "', `telf2`='" . utf8_decode($condicion_post['tlf3']) . "',"
                . " `dir_actual`='" . utf8_decode($condicion_post['Direcliente']) . "',"
                . " `distrito`='" . utf8_decode($condicion_post['distritocliente']) . "'"
                . " WHERE (`idcliente`='" . $condicion_post['idcliente'] . "')");


        $query = $this->consulta("UPDATE `lugar_trabajo` SET `codigo_ruc`='" . utf8_decode($condicion_post['num_ruc']) . "',"
                . " `nombre`='" . utf8_decode($condicion_post['nom_lug_trab']) . "', "
                . "`direccion`='" . utf8_decode($condicion_post['dire_lug_tra']) . "',"
                . " `distrito`='" . utf8_decode($condicion_post['distritocliente_LT']) . "'"
                . "WHERE (`idcliente`='" . $condicion_post['idcliente'] . "')");
        $this->disconnect();
    }

    function nuevo_cliente($condicion_post) {

        //conexion a la base de datos
//                echo"<pre>";print_r($condicion_post);exit;


        $this->conectar();
        $query = $this->consulta("INSERT INTO `cliente` (`idconvenio`, `idperfil_cliente`,"
                . "`nombres`,"
                . "`apellidos`, `dni`, `fecha_inscripcion`,"
                . "`telfcasa`, `telf1`, `telf2`, `dir_actual`, "
                . "`distrito`, `codigo_modular`) "
                . "VALUES ('1', '" . $condicion_post['tiposervidor'] . "',"
                . "'" . utf8_decode($condicion_post['pnombre']) . "', "
                . "'" . utf8_decode($condicion_post['papellido']) . "',"
                . "'" . $condicion_post['dni'] . "',"
                . "CURDATE(), '" . utf8_decode($condicion_post['tlf1']) . "', '" . utf8_decode($condicion_post['tlf2']) . "',"
                . " '" . utf8_decode($condicion_post['tlf3']) . "', '" . utf8_decode($condicion_post['Direcliente']) . "',"
                . "'" . utf8_decode($condicion_post['distritocliente']) . "', '" . utf8_decode($condicion_post['codmodular']) . "')");

        $query = $this->consulta("SELECT idcliente from cliente WHERE cliente.dni='" . $condicion_post['dni'] . "'");
        $datos = array();

        while ($row = mysql_fetch_array($query)) {

            $datos[] = $row;
        }


        $query = $this->consulta("INSERT INTO `lugar_trabajo` (`idcliente`, `codigo_ruc`, `nombre`, `direccion`, `distrito`)
        VALUES ('" . $datos[0]['idcliente'] . "', '" . utf8_decode($condicion_post['num_ruc']) . "',"
                . " '" . utf8_decode($condicion_post['nom_lug_trab']) . "',"
                . " '" . utf8_decode($condicion_post['dire_lug_tra']) . "', "
                . "'" . utf8_decode($condicion_post['distritocliente_LT']) . "')");

        $this->disconnect();
    }

    function isert_venta($condicion_post) {

        //conexion a la base de datos
//                echo"<pre>";print_r($condicion_post);exit;
        $this->conectar();

        $query = $this->consulta("INSERT INTO `proceso_cobro` (`idpersonal`, `fecha_mov`, `letra`, "
                . "`credito`, `dni`, `producto`, `a_partir_de`, `num_cuotas`, `cond_pago`, `fecha_venta`,`acuerdo`,`frecuencia_msg`,`hora`,`pagoen`,`estado`) "
                . "VALUES ('" . $condicion_post['idpersonal'] . "', '" . $condicion_post['fechaV'] . "', "
                . "'" . $condicion_post['cuota'] . "', '" . $condicion_post['totalCredito'] . "', "
                . "'" . $condicion_post['dnicliente'] . "', '" . $condicion_post['producto'] . "',"
                . " '" . $condicion_post['fechaIP'] . "', '" . $condicion_post['n_meses'] . "', "
                . "'" . $condicion_post['cond_pago'] . "', '" . $condicion_post['fechaV'] . "','" . $condicion_post['acuerdoventa'] . "','" . $condicion_post['frecuenci_msj'][0] . "','" . $condicion_post['hora'] . "','" . $condicion_post['pagoen'] . "','1')");


        $query = $this->consulta("SELECT personal.dnipersonal,personal.primer_nombre from personal  WHERE personal.idpersonal='" . $condicion_post['idpersonal'] . "'");
        $datos = array();

        while ($row = mysql_fetch_array($query)) {

            $datos[] = $row;
        }


        $query = $this->consulta("INSERT INTO `acuerdos` (`idpersonal`, `dnic`, `dnip`, `acuerdos`,`fecha_verificacion`,`fecha_visita`,"
                . "`ver_ocultar`,`frecuencia_msj`,`hora`,`pagoen`,`fuente`)"
                . "VALUES (" . $_SESSION['idpersonal'] . ", '" . $condicion_post['dnicliente'] . "',"
                . " '" . $_SESSION['dnipersonal'] . "', '" . utf8_decode($condicion_post['acuerdoventa']) . "',"
                . " '" . $condicion_post['fechaIP'] . "','" . $condicion_post['fechaV'] . "','1',"
                . "'" . $condicion_post['frecuenci_msj'][0] . "','" . $condicion_post['hora'] . "',"
                . "'" . $condicion_post['pagoen'] . "','" . $datos[0]['primer_nombre'] . "')");

        //----------------------------poner datos a la nueva tabla acuerdo_pago
        // -------------------- buscamos si el dni esta o no ------------   


        $querya_p1 = $this->consulta(" SELECT
                                    COUNT(acuerdo_pago.dni) as midni
                                    FROM
                                    acuerdo_pago
                                    WHERE acuerdo_pago.dni='" . $condicion_post['dnicliente'] . "' ");
        $datosa_p1 = array();
        while ($row = mysql_fetch_array($querya_p1)) {
            $datosa_p1[] = $row;
        }

        //--------------------------suma el total de credito
        $queryc_a1 = $this->consulta(" SELECT
(SELECT SUM(pp.abono) FROM proceso_cobro as pp
WHERE pp.dni='" . $condicion_post['dnicliente'] . "'  and pp.producto is NULL  ) as totabono,
SUM(proceso_cobro.credito) as  totcredito,
COUNT(proceso_cobro.producto) as tpro
FROM
proceso_cobro
WHERE proceso_cobro.dni='" . $condicion_post['dnicliente'] . "' and proceso_cobro.producto !='' ");
        $datosc_a1 = array();
        while ($row = mysql_fetch_array($queryc_a1)) {
            $datosc_a1[] = $row;
        }

        //-------------------------- ultimos acuerdos
        $queryc_acu = $this->consulta("   SELECT
a.acuerdos,
a.dnic,
a.fecha_verificacion,
a.idacuerdos,
a.fecha_visita,
a.frecuencia_msj,
a.hora,
a.pagoen,
a.fuente
FROM
acuerdos AS a
WHERE a.fecha_verificacion=(SELECT MAX(b.fecha_verificacion) from acuerdos b WHERE b.dnic=a.dnic) and a.dnic = '" . $condicion_post['dnicliente'] . "' ");
        $datosc_ac = array();
        while ($row = mysql_fetch_array($queryc_acu)) {
            $datosc_ac[] = $row;
        }


        //-------------------
        if ($datosa_p1[0]['midni'] == 1) {
            if ($datosc_ac[0]['frecuencia_msj'] == 'DIARIO') {
                $query = $this->consulta("UPDATE `acuerdo_pago` SET `fecha_visita`='" . $datosc_ac[0]['fecha_visita'] . "', `fecha_verif`='" . $datosc_ac[0]['fecha_verificacion'] . "',"
                        . " `acuerdo`='" . $datosc_ac[0]['acuerdos'] . "', `fuente`='" . $datosc_ac[0]['fuente'] . "',"
                        . "`frecuencia_msg`='" . $datosc_ac[0]['frecuencia_msj'] . "', `hora`='" . $datosc_ac[0]['hora'] . "', "
                        . "`pagoen`='" . $datosc_ac[0]['pagoen'] . "' ,`tcredito`='" . $datosc_a1[0]['totcredito'] . "',`tabono`='" . $datosc_a1[0]['totabono'] . "',`tproductos`='" . $datosc_a1[0]['tpro'] . "',unir='d'
                                         WHERE `dni`='" . $condicion_post['dnicliente'] . "'");
            } else {
                $query = $this->consulta("UPDATE `acuerdo_pago` SET `fecha_visita`='" . $datosc_ac[0]['fecha_visita'] . "', `fecha_verif`='" . $datosc_ac[0]['fecha_verificacion'] . "',"
                        . " `acuerdo`='" . $datosc_ac[0]['acuerdos'] . "', `fuente`='" . $datosc_ac[0]['fuente'] . "',"
                        . "`frecuencia_msg`='" . $datosc_ac[0]['frecuencia_msj'] . "', `hora`='" . $datosc_ac[0]['hora'] . "', "
                        . "`pagoen`='" . $datosc_ac[0]['pagoen'] . "' ,`tcredito`='" . $datosc_a1[0]['totcredito'] . "',`tabono`='" . $datosc_a1[0]['totabono'] . "',`tproductos`='" . $datosc_a1[0]['tpro'] . "'
        WHERE `dni`='" . $condicion_post['dnicliente'] . "'");
            }
        } else {
            if ($datosc_ac[0]['frecuencia_msj'] == 'DIARIO') {
                $query = $this->consulta("INSERT INTO `acuerdo_pago` (`dni`, `fecha_visita`, `fecha_verif`, `acuerdo`,"
                        . " `fuente`,`frecuencia_msg`, `hora`, `pagoen`,`tcredito`,`tabono`,`tproductos`,`unir`) "
                        . "  VALUES ('" . $datosc_ac[0]['dnic'] . "','" . $datosc_ac[0]['fecha_visita'] . "',"
                        . "'" . $datosc_ac[0]['fecha_verificacion'] . "','" . utf8_decode($datosc_ac[0]['acuerdos']) . "',"
                        . "'" . $datosc_ac[0]['fuente'] . "','" . $datosc_ac[0]['frecuencia_msj'] . "',"
                        . "'" . $datosc_ac[0]['hora'] . "','" . $datosc_ac[0]['pagoen'] . "',"
                        . "'" . $datosc_a1[0]['totcredito'] . "','" . $datosc_a1[0]['totabono'] . "',"
                        . "'" . $datosc_a1[0]['tpro'] . "','d')");
            } else {
                $query = $this->consulta("INSERT INTO `acuerdo_pago` (`dni`, `fecha_visita`, `fecha_verif`, `acuerdo`,"
                        . " `fuente`,`frecuencia_msg`, `hora`, `pagoen`,`tcredito`,`tabono`,`tproductos`) "
                        . "  VALUES ('" . $datosc_ac[0]['dnic'] . "','" . $datosc_ac[0]['fecha_visita'] . "',"
                        . "'" . $datosc_ac[0]['fecha_verificacion'] . "','" . utf8_decode($datosc_ac[0]['acuerdos']) . "',"
                        . "'" . $datosc_ac[0]['fuente'] . "','" . $datosc_ac[0]['frecuencia_msj'] . "',"
                        . "'" . $datosc_ac[0]['hora'] . "','" . $datosc_ac[0]['pagoen'] . "',"
                        . "'" . $datosc_a1[0]['totcredito'] . "','" . $datosc_a1[0]['totabono'] . "',"
                        . "'" . $datosc_a1[0]['tpro'] . "')");
            }
        }



        $this->disconnect();
    }

    function set_nuevo_acuedo_automat($condicion_post) {

        //conexion a la base de datos
//               echo"<pre>";print_r($condicion_post);exit;
        $this->conectar();

        // -------------------- datos de acuerdo segun fecha maxima ------------    
        $query1 = $this->consulta("SELECT * FROM
                                    acuerdos
                                    WHERE acuerdos.dnic='" . $condicion_post['dni_a'] . "'
                                    ORDER BY acuerdos.fecha_verificacion DESC
                                    LIMIT 1");
        $datos1 = array();
        while ($row = mysql_fetch_array($query1)) {
            $datos1[] = $row;
        }
        // -------------------- la minima fecha para poder actualizar ------------   
        $query2 = $this->consulta("SELECT MIN(acuerdos.fecha_verificacion) as minfecha
                                    FROM
                                    acuerdos
                                    WHERE acuerdos.dnic='" . $condicion_post['dni_a'] . "' ");
        $datos2 = array();
        while ($row = mysql_fetch_array($query2)) {
            $datos2[] = $row;
        }
        // -------------------- contamos cuantos acuerdo tiene la persona ------------ 
        $query3 = $this->consulta("SELECT COUNT(acuerdos.idacuerdos) as cont
                                    FROM
                                    acuerdos
                                    WHERE acuerdos.dnic='" . $condicion_post['dni_a'] . "' ");
        $datos3 = array();
        while ($row = mysql_fetch_array($query3)) {
            $datos3[] = $row;
        }
        $fe = $datos1[0]['fecha_verificacion'];
        if ($datos1[0]['frecuencia_msj'] == 'DIARIO') {
            $fe2 = date("Y-m-d", strtotime($fe . "+ 1 day"));
        } elseif ($datos1[0]['frecuencia_msj'] == 'SEMANAL') {
            $fe2 = date("Y-m-d", strtotime($fe . "+ 1 week"));
        } elseif ($datos1[0]['frecuencia_msj'] == 'QUINCENAL') {
            $fe2 = date("Y-m-d", strtotime($fe . "+ 15 day"));
        } elseif ($datos1[0]['frecuencia_msj'] == 'MENSUAL') {
            $fe2 = date("Y-m-d", strtotime($fe . "+ 1 month"));
        } else {
            echo "<script>alert(NO APLICA PARA ACUERDOS)</script>";
        }




        if ($datos3[0][cont] == 3) {
            // -------------------- ejecutamos la actualizacion ------------ 
            $query = $this->consulta("UPDATE `acuerdos` SET `idpersonal`=" . $_SESSION['idpersonal'] . ", `dnic`='" . $condicion_post['dni_a'] . "',"
                    . "`dnip`='" . $_SESSION['dnipersonal'] . "',"
                    . "  `acuerdos`='" . $datos1[0]['acuerdos'] . "',"
                    . " `fecha_verificacion`='" . $fe2 . "', `fecha_visita`='" . $datos1[0]['fecha_verificacion'] . "',"
                    . "`calificacion`='', `frecuencia_msj`='" . $datos1[0]['frecuencia_msj'] . "', `hora`='" . $datos1[0]['hora'] . "',`pagoen`='" . $datos1[0]['pagoen'] . "',`fuente`='" . $datos1[0]['fuente'] . "'"
                    . "WHERE (`dnic`='" . $condicion_post['dni_a'] . "' and `fecha_verificacion`='" . $datos2[0]['minfecha'] . "')");
        } else {
            $query = $this->consulta("INSERT INTO `acuerdos` (`idpersonal`, `dnic`, `dnip`, `acuerdos`,`fecha_verificacion`,`fecha_visita`,`calificacion`,`frecuencia_msj`,`hora`,`pagoen`,`fuente`)"
                    . " VALUES ('" . $_SESSION['idpersonal'] . "', '" . $condicion_post['dni_a'] . "',"
                    . "'" . $_SESSION['dnipersonal'] . "',"
                    . "  '" . utf8_decode($datos1[0]['acuerdos']) . "',"
                    . " '" . $fe2 . "', '" . $datos1[0]['fecha_verificacion'] . "',"
                    . "'', '" . $datos1[0]['frecuencia_msj'] . "', '" . $datos1[0]['hora'] . "', '" . $datos1[0]['pagoen'] . "','" . $datos1[0]['fuente'] . "')");
        }
        //----------------------------poner datos a la nueva tabla acuerdo_pago
        // -------------------- buscamos si el dni esta o no ------------    
        $querya_p1 = $this->consulta(" SELECT
                                    COUNT(acuerdo_pago.dni) as midni
                                    FROM
                                    acuerdo_pago
                                    WHERE acuerdo_pago.dni='" . $condicion_post['dni_a'] . "'  ");
        $datosa_p1 = array();
        while ($row = mysql_fetch_array($querya_p1)) {
            $datosa_p1[] = $row;
        }

        if ($datosa_p1[0]['midni'] == 1) {

            $query = $this->consulta(" UPDATE `acuerdo_pago` SET `fecha_visita`='" . $datos1[0]['fecha_verificacion'] . "',
              `fecha_verif`='" . $fe2 . "', `acuerdo`='" . $datos1[0]['acuerdos'] . "',
                  `fuente`='" . $datos1[0]['fuente'] . "', `frecuencia_msg`='" . $datos1[0]['frecuencia_msj'] . "',
                  `hora`='" . $datos1[0]['hora'] . "', `pagoen`='" . $datos1[0]['pagoen'] . "' WHERE `dni`='" . $condicion_post['dni_a'] . "'  ");
        } else {
            $query = $this->consulta("INSERT INTO `acuerdo_pago` (`dni`, `fecha_visita`, `fecha_verif`, `acuerdo`, `fuente`, `frecuencia_msg`, `hora`, `pagoen`)
                   VALUES ('" . $condicion_post['dni_a'] . "' , '" . $datos1[0]['fecha_verificacion'] . "', '" . $fe2 . "', '" . $datos1[0]['acuerdos'] . "', '" . $datos1[0]['fuente'] . "', '" . $datos1[0]['frecuencia_msj'] . "', '" . $datos1[0]['hora'] . "','" . $datos1[0]['pagoen'] . "')");
        }


        $this->disconnect();
    }

    function set_nuevo_acuedo($condicion_post) {

        //conexion a la base de datos
        //     echo"<pre>";print_r($condicion_post);exit;
        $this->conectar();

        // -------------------- datos de acuerdo segun fecha maxima ------------    
        $query1 = $this->consulta("SELECT * FROM
                                    acuerdos
                                    WHERE acuerdos.dnic='" . $condicion_post['dni_a'] . "'
                                    ORDER BY acuerdos.fecha_verificacion DESC
                                    ");
        $datos1 = array();
        $conta = -1;
        while ($row = mysql_fetch_array($query1)) {
            $conta = $conta + 1;
            $datos1[] = $row;
            //         echo $datos1[''.$conta.'']['fecha_verificacion'];
            if ($datos1['' . $conta . '']['fecha_verificacion'] == $_REQUEST['fecha_limite']) {
                echo 'la fecha reepite';
                exit;
            }
        }


        // -------------------- la minima fecha para poder actualizar ------------   
        $query2 = $this->consulta("SELECT MIN(acuerdos.fecha_verificacion) as minfecha
                                    FROM
                                    acuerdos
                                    WHERE acuerdos.dnic='" . $condicion_post['dni_a'] . "' ");
        $datos2 = array();
        while ($row = mysql_fetch_array($query2)) {
            $datos2[] = $row;
        }
        // -------------------- contamos cuantos acuerdo tiene la persona ------------ 
        $query3 = $this->consulta("SELECT COUNT(acuerdos.idacuerdos) as cont
                                    FROM
                                    acuerdos
                                    WHERE acuerdos.dnic='" . $condicion_post['dni_a'] . "' ");
        $datos3 = array();
        while ($row = mysql_fetch_array($query3)) {
            $datos3[] = $row;
        }

        if ($datos3[0][cont] == 3) {
            // -------------------- ejecutamos la actualizacion ------------ 


            $query = $this->consulta("UPDATE `acuerdos` SET `idpersonal`=" . $_SESSION['idpersonal'] . ",`dnic`= '" . $condicion_post['dni_a'] . "',"
                    . " `dnip`='" . $_SESSION['dnipersonal'] . "', `acuerdos`='" . $condicion_post['txtacuerdo'] . "',"
                    . " `fecha_verificacion`='" . $condicion_post['fecha_limite'] . "',`fecha_visita`='" . $condicion_post['fecha_visita'] . "',"
                    . "`calificacion`='',`frecuencia_msj`='" . $condicion_post['frecuencia_msg'] . "',`hora`='" . $condicion_post['hora'] . "',`pagoen`='" . $condicion_post['pagoen'] . "',`fuente`='" . $condicion_post['idpersonal'] . "'"
                    . " WHERE (`dnic`='" . $condicion_post['dni_a'] . "' and `fecha_verificacion`='" . $datos2[0]['minfecha'] . "')");
        } else {

            $query = $this->consulta("INSERT INTO `acuerdos` (`idpersonal`, `dnic`, `dnip`, `acuerdos`,`fecha_verificacion`,`fecha_visita`,`frecuencia_msj`,`hora`,`pagoen`,`fuente`)"
                    . "VALUES (" . $_SESSION['idpersonal'] . ", '" . $condicion_post['dni_a'] . "',"
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
                                    WHERE acuerdo_pago.dni='" . $condicion_post['dni_a'] . "'  ");
        $datosa_p1 = array();
        while ($row = mysql_fetch_array($querya_p1)) {
            $datosa_p1[] = $row;
        }


        $porciones = explode("_", $condicion_post['idpersonal']);
        echo $porciones[0]; // porción1
        echo $porciones[1]; // porción2

        if ($datosa_p1[0]['midni'] == 1) {

            $query = $this->consulta(" UPDATE `acuerdo_pago` SET `fecha_visita`='" . $condicion_post['fecha_visita'] . "',
              `fecha_verif`='" . $condicion_post['fecha_limite'] . "', `acuerdo`='" . $condicion_post['txtacuerdo'] . "',
                  `fuente`='" . $porciones[0] . "', `frecuencia_msg`='" . $condicion_post['frecuencia_msg'] . "',
                  `hora`='" . $condicion_post['hora'] . "', `pagoen`='" . $condicion_post['pagoen'] . "', `idpersonal`='" . $porciones[1] . "',`asignador`='" . $_SESSION['idpersonal'] . "' WHERE `dni`='" . $condicion_post['dni_a'] . "'  ");
        } else {
            $query = $this->consulta("INSERT INTO `acuerdo_pago` (`dni`, `fecha_visita`, `fecha_verif`, `acuerdo`, `fuente`, `frecuencia_msg`, `hora`, `pagoen`,`idpersonal`,`asignador`)
                   VALUES ('" . $condicion_post['dni_a'] . "' , '" . $condicion_post['fecha_visita'] . "',
                   '" . $condicion_post['fecha_limite'] . "', '" . utf8_decode($condicion_post['txtacuerdo']) . "', '" . $condicion_post['idpersonal'] . "',
                   '" . $condicion_post['frecuencia_msg'] . "', '" . $condicion_post['hora'] . "',
                   '" . $condicion_post['pagoen'] . "','" . $porciones[1] . "','" . $_SESSION['idpersonal'] . "')");
        }

        $this->disconnect();
    }

    function reprogramacion($condicion_post) {

        $this->conectar();
        if ($_REQUEST['idcondpago'] == '3' || $_REQUEST['idcondpago'] == '4') {

            $querytr = $this->consulta("UPDATE proceso_cobro SET proceso_cobro.estado='0' WHERE proceso_cobro.dni='" . $_REQUEST['dnicl'] . "' and (proceso_cobro.idproceso_cobro='" . $condicion_post['idproce'] . "'  OR proceso_cobro.idventa='" . $condicion_post['idproce'] . "' )");
        }

        $query = $this->consulta("update proceso_cobro set letra='" . $condicion_post['cuat'] . "',credito='" . $condicion_post['credit'] . "',num_cuotas='" . $condicion_post['mesess'] . "',a_partir_de='" . $condicion_post['fecha_pago'] . "',cond_pago='" . $condicion_post['condipap'] . "',frecuencia_msg='" . $condicion_post['frecuenci_msj'][0] . "' WHERE idproceso_cobro='" . $condicion_post['idproce'] . "' ");

        //----------------------------poner datos a la nueva tabla acuerdo_pago
        // -------------------- buscamos si el dni esta o no ------------   
        $query2 = $this->consulta(" SELECT
                                        proceso_cobro.dni
                                        FROM
                                        proceso_cobro
                                        WHERE proceso_cobro.idproceso_cobro='" . $condicion_post['idproce'] . "' ");
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
        $queryc_a1 = $this->consulta("  SELECT
(SELECT SUM(pp.abono) FROM proceso_cobro as pp
WHERE pp.dni='" . $datos2[0]['dni'] . "'  and pp.producto is NULL  ) as totabono,
SUM(proceso_cobro.credito) as  totcredito,
COUNT(proceso_cobro.producto) as tpro
FROM
proceso_cobro
WHERE proceso_cobro.dni='" . $datos2[0]['dni'] . "' and proceso_cobro.producto !=''");
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

    function save($condicion_post, $idventa, $idpersonal) {

        //conexion a la base de datos
//                echo"<pre>";print_r($condicion_post);exit;
        $this->conectar();

        foreach ($condicion_post['deuda'] as $key => $r) {
            $query = $this->consulta("update proceso_cobro set idpersonal='" . $condicion_post[idpersonal][$key] . "' ,deuda_anterior='" . $condicion_post[deuda][$key] . "',abono='" . $condicion_post[pagoreal][$key] . "',resto='" . $condicion_post[resto][$key] . "',fecha_abono='" . $condicion_post[fecha][$key] . "',idcondicion_pago='" . $condicion_post[cond_pago][$key] . "',nro_recibo='" . $condicion_post[nro_recibo][$key] . "' WHERE idventa='$idventa' and nro_cuota='" . ($key + 1) . "'");
            $this->disconnect();
        }
        /*
          if($cont== count($condicion_post['deuda'])){echo"<script>alert('LA OPERACION SE REALIZO CON EXITO')</script>";}
          else { echo"<script>alert('ERROR: No se pudo realizar la OPERACION')</script>";}
         */
    }

    function nuevo_pago($condicion_post) {

//echo $condicion_post['id_cronograma_pago'];
//echo $condicion_post['id_venta'];
//exit;
        //conexion a la base de datos
        $this->conectar();


        $query = $this->consulta("
               INSERT INTO proceso_cobro (idventa,idpersonal, fecha_mov, abono,documento, nro_recibo,dni,estado) 
               VALUES ('" . $condicion_post['idventa'] . "','" . $condicion_post['idpersonal'] . "','" . $condicion_post['fecha_pago'] . "', "
                . "'" . $condicion_post['pago_letr'] . "','" . $condicion_post['Comp_pago'] . "',"
                . "'" . $condicion_post['n_recibo'] . "','" . $condicion_post['dni_cliente'] . "','1')");
        if (($_REQUEST['Mabono'] + $_REQUEST['pago_letr']) >= $_REQUEST['Mcredito']) {
            $query_apdabon = $this->consulta("update proceso_cobro set proceso_cobro.abono =COALESCE(proceso_cobro.abono,0)  + '" . $condicion_post['pago_letr'] . "',proceso_cobro.saldo =COALESCE(proceso_cobro.saldo,proceso_cobro.credito)  - '" . $condicion_post['pago_letr'] . "',proceso_cobro.cond_pago='CANCELADO',proceso_cobro.estado='0'   WHERE proceso_cobro.idproceso_cobro='" . $condicion_post['idventa'] . "' and proceso_cobro.dni='" . $condicion_post['dni_cliente'] . "'");
            $query_apx = $this->consulta("update proceso_cobro set proceso_cobro.estado='0'  WHERE proceso_cobro.idventa='" . $condicion_post['idventa'] . "' and proceso_cobro.dni='" . $condicion_post['dni_cliente'] . "' and  proceso_cobro.producto is NULL");
        } else {
            $query_apdabon = $this->consulta("update proceso_cobro set proceso_cobro.abono =COALESCE(proceso_cobro.abono,0)  + '" . $condicion_post['pago_letr'] . "',proceso_cobro.saldo =COALESCE(proceso_cobro.saldo,proceso_cobro.credito)  - '" . $condicion_post['pago_letr'] . "'  WHERE proceso_cobro.idproceso_cobro='" . $condicion_post['idventa'] . "' and proceso_cobro.dni='" . $condicion_post['dni_cliente'] . "'");
        }

        //  $query_apdabon = $this->consulta("update proceso_cobro set proceso_cobro.abono =COALESCE(proceso_cobro.abono,0)  + '" . $condicion_post['pago_letr'] . "',proceso_cobro.saldo =COALESCE(proceso_cobro.saldo,proceso_cobro.credito)  - '" . $condicion_post['pago_letr'] . "'  WHERE proceso_cobro.idproceso_cobro='" . $condicion_post['idventa'] . "'");
        $this->consulta("update correlativo set correlativo.correlativo='" . $condicion_post['nurecibo'] . "',correlativo.idpersonal='" . $condicion_post['idpersonal'] . "'  WHERE correlativo.idcorre='" . $_SESSION['idpersonal'] . "' ");

//  echo "update proceso_cobro set proceso_cobro.abono =COALESCE(proceso_cobro.abono,0)  + '" . $condicion_post['idventa'] . "' WHERE proceso_cobro.idproceso_cobro='" . $condicion_post['idventa'] . "'";exit;
        //----------------------------poner datos a la nueva tabla acuerdo_pago
        // -------------------- buscamos si el dni esta o no ------------    
        $querya_p1 = $this->consulta(" SELECT
                                    COUNT(acuerdo_pago.dni) as midni
                                    FROM
                                    acuerdo_pago
                                    WHERE acuerdo_pago.dni='" . $condicion_post['dni_cliente'] . "'  ");
        $datosa_p1 = array();
        while ($row = mysql_fetch_array($querya_p1)) {
            $datosa_p1[] = $row;
        }


        //--------------------------suma el total de credito
        $queryc_a1 = $this->consulta(" SELECT
(SELECT SUM(pp.credito) FROM proceso_cobro as pp
WHERE pp.dni='" . $condicion_post['dni_cliente'] . "'  and pp.producto !='') as totcredito,
SUM(proceso_cobro.abono) as totabono
FROM
proceso_cobro
WHERE proceso_cobro.dni='" . $condicion_post['dni_cliente'] . "'  and proceso_cobro.producto is NULL
                                   ");
        $datosc_a1 = array();
        while ($row = mysql_fetch_array($queryc_a1)) {
            $datosc_a1[] = $row;
        }

        //-------------------
        if ($datosa_p1[0]['midni'] == 1) {

            $query = $this->consulta("UPDATE `acuerdo_pago` SET `fecha_up`='" . $condicion_post['fecha_pago'] . "',
                     `amortiza`='" . $condicion_post['pago_letr'] . "',`tcredito`='" . $datosc_a1[0]['totcredito'] . "',`tabono`='" . $datosc_a1[0]['totabono'] . "'
                                         WHERE `dni`='" . $condicion_post['dni_cliente'] . "'");
        } else {
            $query = $this->consulta("INSERT INTO `acuerdo_pago` (`dni`, `fecha_up`, `amortiza`,`tcredito`,`tabono`) 
                                      VALUES ('" . $condicion_post['dni_cliente'] . "', '" . $condicion_post['fecha_pago'] . "', 
                          '" . $condicion_post['pago_letr'] . "','" . $datosc_a1[0]['totcredito'] . "','" . $datosc_a1[0]['totabono'] . "')");
        }

        $this->disconnect();

        /*
          if($cont== count($condicion_post['deuda'])){echo"<script>alert('LA OPERACION SE REALIZO CON EXITO')</script>";}
          else { echo"<script>alert('ERROR: No se pudo realizar la OPERACION')</script>";}
         */
    }

    function cargar_datos_formulario($_P) {

        $this->conectar();
        $query = $this->consulta("
         SELECT
cliente.idcliente,
 cliente.nombres,
cliente.apellidos AS apelli,
cliente.dni,
cliente.telfcasa,
cliente.telf1,
cliente.telf2,
CONCAT_WS(' ',cliente.dir_actual,cliente.distrito) AS direccion,
convenio.descripcion,
lugar_trabajo.nombre AS lugartrabajo,
CONCAT_WS(' -',lugar_trabajo.direccion,lugar_trabajo.distrito) AS trabaja_dir,
CONCAT_WS('.',perfil_cliente.abreviatura,perfil_cliente.descripcion) as tipo_servidor,
cliente.calificacion,
lugar_trabajo.codigo_ruc,
CASE WHEN  cliente.cord_cli != '' THEN  '#F5F10A' ELSE '#2008FA' end as  corcl,
CASE WHEN  lugar_trabajo.coord_lt !='' THEN  '#F5F10A' ELSE '#2008FA' end as  cortra
FROM
cliente
INNER JOIN convenio ON cliente.idconvenio = convenio.idconvenio
INNER JOIN lugar_trabajo ON cliente.idcliente = lugar_trabajo.idcliente
INNER JOIN perfil_cliente ON perfil_cliente.idperfil_cliente = cliente.idperfil_cliente

   where cliente.dni='" . $_P['idcliente'] . "'
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

    function formulario_editar_cliente($_P) {

        $this->conectar();
        $query = $this->consulta("
         SELECT
cliente.idcliente,
cliente.idperfil_cliente,
cliente.nombres,
cliente.apellidos,
cliente.dni,
cliente.telfcasa,
cliente.telf1,
cliente.telf2,
cliente.dir_actual,
cliente.distrito as distrito_cliente,
convenio.descripcion,
lugar_trabajo.nombre AS lugartrabajo,
lugar_trabajo.direccion,
lugar_trabajo.distrito as distritoL_T,
perfil_cliente.abreviatura,
perfil_cliente.descripcion,
cliente.calificacion,
lugar_trabajo.codigo_ruc
FROM
cliente
INNER JOIN convenio ON cliente.idconvenio = convenio.idconvenio
INNER JOIN lugar_trabajo ON cliente.idcliente = lugar_trabajo.idcliente
INNER JOIN perfil_cliente ON perfil_cliente.idperfil_cliente = cliente.idperfil_cliente

        where cliente.dni='" . $_P['idcliente'] . "'
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

    function cargar_datos_formulario_detalle($idcliente1) {

        $this->conectar();
        $query = $this->consulta("

  SELECT   
proceso_cobro.idproceso_cobro,
proceso_cobro.dni,
proceso_cobro.credito as credito,
proceso_cobro.abono as abonar,
proceso_cobro.fecha_mov,
proceso_cobro.letra,
proceso_cobro.abono,
proceso_cobro.saldo,
proceso_cobro.producto,
CONCAT_WS('.',proceso_cobro.documento,proceso_cobro.nro_recibo) as nro_recibo,
proceso_cobro.cond_pago,
proceso_cobro.a_partir_de,
CONCAT_WS('  ',proceso_cobro.num_cuotas,proceso_cobro.frecuencia_msg) as tiempo,
proceso_cobro.idpersonal
FROM
proceso_cobro
where proceso_cobro.dni='" . $idcliente1 . "' and proceso_cobro.producto !=''");

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

    function datos_formulario_detalle($idcliente1) {

        $this->conectar();
        $query = $this->consulta("SELECT   
proceso_cobro.idproceso_cobro,
proceso_cobro.idventa,
proceso_cobro.dni,
proceso_cobro.credito as credito,
proceso_cobro.abono as abonar,
proceso_cobro.fecha_mov,
proceso_cobro.letra,
proceso_cobro.producto,
CONCAT_WS('.',proceso_cobro.documento,proceso_cobro.nro_recibo) as nro_recibo,
proceso_cobro.cond_pago,
proceso_cobro.a_partir_de,
proceso_cobro.num_cuotas,
proceso_cobro.idpersonal
FROM
proceso_cobro
where proceso_cobro.dni='" . $idcliente1 . "' and (proceso_cobro.producto =''   or proceso_cobro.producto is NULL)
ORDER BY proceso_cobro.fecha_mov DESC ");
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

    function gestor_cobranza($cliente) {


        //conexion a la base de datos
        $this->conectar();
        /* $query = $this->consulta("
          SELECT
          cliente.idcliente AS idcliente,
          CONCAT_WS(' ',cliente.apellido_p ,cliente.apellido_m,cliente.primer_nombre,cliente.segundo_nombre) AS nombres,
          cliente.dni AS dni,
          proceso_cobro.dni AS dnip,
          Sum(proceso_cobro.credito) AS credito,
          Sum(proceso_cobro.abono) AS abonar,
          Sum(proceso_cobro.letra) AS letra
          FROM
          cliente
          INNER JOIN proceso_cobro ON cliente.dni = proceso_cobro.dni
          GROUP BY cliente.dni
          ORDER BY cliente.apellido_p ASC

          "); */
        $query = $this->consulta("
             SELECT
cliente.idcliente AS idcliente,
CONCAT_WS(' ',cliente.apellidos,cliente.nombres) AS nombres,
cliente.dni AS dni,
proceso_cobro.cond_pago,
proceso_cobro.dni AS Estado,
Sum(proceso_cobro.credito) AS credito,
Sum(proceso_cobro.abono) AS abonar,
Sum(proceso_cobro.letra) AS letra
FROM
cliente
INNER JOIN proceso_cobro ON cliente.dni = proceso_cobro.dni
GROUP BY cliente.dni


UNION

SELECT
cliente.idcliente AS idcliente,
CONCAT_WS(' ',cliente.apellidos,cliente.nombres) AS nombres,
cliente.dni AS dni,
proceso_cobro.cond_pago,
case when ( proceso_cobro.dni=cliente.dni )  then 'rep' else 'N-C' end Estado,
case when ( proceso_cobro.dni=cliente.dni )  then 'rep' else '0' end credito ,
case when ( proceso_cobro.dni=cliente.dni )  then 'rep' else '0' end abonar ,
case when ( proceso_cobro.dni=cliente.dni )  then 'rep' else '0' end letra 
FROM
cliente
LEFT JOIN proceso_cobro ON cliente.dni = proceso_cobro.dni
HAVING  Estado = 'N-C'

 
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

    function busqueda_online($cliente) {

        echo $cliente;
        //conexion a la base de datos
        $this->conectar();
        if (isset($cliente)) {
            $parametro = trim($cliente);
            if ($parametro != "") {
                $query = $this->consulta("
                SELECT
                ventas_saldo.idcliente,
                CONCAT_WS(' ',ventas_saldo.apellido_p,ventas_saldo.apellido_m,ventas_saldo.primer_nombre,ventas_saldo.segundo_nombre) as nombres,
                Count(ventas_saldo.idventa) AS num_ventas,
                Sum(ventas_saldo.total) AS total_compras,
                Sum(ventas_saldo.amortiza) AS total_amortiza,
                ventas_saldo.dni
                FROM
                ventas_saldo
                  WHERE ventas_saldo.primer_nombre LIKE '%" . $parametro . "%'
                GROUP BY
                ventas_saldo.idcliente,
                ventas_saldo.primer_nombre,
                ventas_saldo.segundo_nombre,
                ventas_saldo.apellido_p,
                ventas_saldo.apellido_m,
                ventas_saldo.dni
                ORDER BY ventas_saldo.apellido_p ASC
 
                ");
                //$this->disconnect();
            }
        }
        if ($this->numero_de_filas($query) > 0) { // existe -> datos correctos
            //se llenan los datos en un array
            while ($tsArray = $this->fetch_assoc($query))
                $data[] = $tsArray;

            return $data;
        } else {
            return '';
        }
    }

    function cobranzas_vencidas() {

        //conexion a la base de datos
        $this->conectar();
        $query = $this->consulta("
SELECT  
                proceso_cobro.idproceso_cobro,
                proceso_cobro.idventa,
                proceso_cobro.fecha_vencimiento,
                proceso_cobro.dias_atrasados,
                proceso_cobro.letra,
                proceso_cobro.abono,
                proceso_cobro.fecha_abono,
                proceso_cobro.estado,
                proceso_cobro.idcondicion_pago,
                proceso_cobro.nro_recibo,
                proceso_cobro.nro_cuota,
                CONCAT_WS(' ',cliente.nombres) as nombres,
    CONCAT_WS(' ',cliente.apellido_p,cliente.apellido_m) as apellidos,
    CONCAT_WS('-',cliente.telfcasa,cliente.telf1,cliente.telf2) as telefonos,
    cliente.dni,
    CONCAT_WS('-',cliente.dir_actual,cliente.distrito)as direccion,
    CONCAT_WS('-',lugar_trabajo.codigo_ruc,lugar_trabajo.nombre,lugar_trabajo.direccion,lugar_trabajo.distrito)as trabaja,
venta.condicion_pago
                FROM
                proceso_cobro
                INNER JOIN venta ON venta.idventa = proceso_cobro.idventa
                INNER JOIN cliente ON cliente.idcliente = venta.idcliente
                INNER JOIN lugar_trabajo ON cliente.idcliente = lugar_trabajo.idcliente
                WHERE (proceso_cobro.abono<1 or proceso_cobro.abono is NULL) and (venta.condicion_pago !='cancelado' and venta.condicion_pago!='anulado') and venta.idtipo_pago=2
                GROUP BY proceso_cobro.idventa
                ORDER BY cliente.apellido_p asc                

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

    function getbuscavendedorid() {

        //conexion a la base de datos
        $this->conectar();
        $query = $this->consulta("
             SELECT  personal.primer_nombre,personal.segundo_nombre,personal.apellido_p 
             FROM personal 
             where personal.idpersonal='" . $_REQUEST['idvende'] . "';
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

    function cobranzas_pagadas11() {

        //conexion a la base de datos
        $this->conectar();
        $query = $this->consulta("
                SELECT  
                proceso_cobro.idproceso_cobro,
                proceso_cobro.idventa,
                proceso_cobro.fecha_recuerdo,
                proceso_cobro.fecha_inicio,
                proceso_cobro.fecha_vencimiento,
                proceso_cobro.dias_atrasados,
                proceso_cobro.letra,
                proceso_cobro.abono,
                proceso_cobro.fecha_abono,
                proceso_cobro.estado,
                proceso_cobro.idcondicion_pago,
                proceso_cobro.nro_recibo,
                proceso_cobro.nro_cuota,
                CONCAT_WS(' ',cliente.primer_nombre,cliente.segundo_nombre) as nombres,
    CONCAT_WS(' ',cliente.apellido_p,cliente.apellido_m) as apellidos,
    CONCAT_WS('-',cliente.telfcasa,cliente.telf1,cliente.telf2) as telefonos,
    cliente.dni,
    CONCAT_WS('-',cliente.dir_actual,cliente.distrito)as direccion,
    CONCAT_WS('-',lugar_trabajo.codigo_ruc,lugar_trabajo.nombre,lugar_trabajo.direccion,lugar_trabajo.distrito)as trabaja
                FROM
                proceso_cobro
                INNER JOIN venta ON venta.idventa = proceso_cobro.idventa
                INNER JOIN cliente ON cliente.idcliente = venta.idcliente
                INNER JOIN lugar_trabajo ON cliente.idcliente = lugar_trabajo.idcliente
                WHERE proceso_cobro.abono<1 or proceso_cobro.abono is NULL
                GROUP BY proceso_cobro.idventa
                ORDER BY cliente.apellido_p asc
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

    function get_index_asign() {


        $this->conectar();
        if (empty($_REQUEST['color'])) {
            if (empty($_REQUEST['sesi'])) {
                $secion = "WHERE acuerdo_pago.idpersonal='" . $_SESSION['idpersonal'] . "'and acuerdo_pago.estado='1' HAVING saldo>1 or saldo is NULL";
            } else {
                $secion = "WHERE acuerdo_pago.idpersonal='" . $_REQUEST['sesi'] . "' and acuerdo_pago.estado='1' HAVING saldo>1 or saldo is NULL";
            }
        } else {

            $secion = "WHERE acuerdo_pago.idpersonal='" . $_REQUEST['sesi'] . "' and acuerdo_pago.estado='1' HAVING (saldo>1 or saldo is NULL) and colo='" . $_REQUEST['color'] . "'";
        }
        $query = $this->consulta("
SELECT
acuerdo_pago.dni,
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
(acuerdo_pago.tcredito - acuerdo_pago.tabono) as saldo,
acuerdo_pago.tproductos,
acuerdo_pago.unir,
acuerdo_pago.idpersonal,
CONCAT_WS(' ',cliente.apellidos,cliente.nombres) as nomcliente,
CASE WHEN acuerdo_pago.estado='1' THEN 'checked' ELSE '0' end as estadoo,
CASE WHEN acuerdo_pago.fecha_verif=CURDATE() THEN 'warning' WHEN acuerdo_pago.fecha_verif < CURDATE() THEN 'danger'  ELSE 'success' END as colo
FROM
acuerdo_pago
INNER JOIN cliente ON acuerdo_pago.dni = cliente.dni
$secion  
    ORDER BY acuerdo_pago.fecha_verif ASC
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

    function get_index_asign_menu() {


        $this->conectar();

        if ($_REQUEST['cond'] == 'sinasig') {
            $secion = "WHERE (acuerdo_pago.idpersonal<=0 or acuerdo_pago.idpersonal is NULL) and acuerdo_pago.estado='1' ";
        } elseif ($_REQUEST['cond'] == 'activos') {
            $secion = "WHERE acuerdo_pago.idpersonal>0 and acuerdo_pago.estado='1'";
        } else {
            $secion = " WHERE  acuerdo_pago.estado='0'";
        }

        $query = $this->consulta("
SELECT
acuerdo_pago.dni,
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
(acuerdo_pago.tcredito - acuerdo_pago.tabono) as saldo,
acuerdo_pago.tproductos,
acuerdo_pago.unir,
acuerdo_pago.idpersonal,
CONCAT_WS(' ',cliente.apellidos,cliente.nombres) as nomcliente,
CASE WHEN acuerdo_pago.estado='1' THEN 'checked' ELSE '0' end as estadoo,
CASE WHEN acuerdo_pago.fecha_verif=CURDATE() THEN 'warning' WHEN acuerdo_pago.fecha_verif < CURDATE() THEN 'danger'  ELSE 'success' END as colo
FROM
acuerdo_pago
INNER JOIN cliente ON acuerdo_pago.dni = cliente.dni
$secion
HAVING (saldo>1 or saldo is NULL)
    ORDER BY acuerdo_pago.fecha_verif ASC
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

    function asign_meta() {

        //conexion a la base de datos
        $this->conectar();
        $query = $this->consulta("
SELECT
proceso_cobro.credito,
proceso_cobro.letra,
acuerdo_pago.dni,
proceso_cobro.frecuencia_msg,
proceso_cobro.num_cuotas,
CASE WHEN proceso_cobro.frecuencia_msg ='DIARIO' THEN  proceso_cobro.letra*30 WHEN proceso_cobro.frecuencia_msg ='SEMANAL' THEN proceso_cobro.letra*4 
WHEN proceso_cobro.frecuencia_msg ='QUINCENAL' THEN  proceso_cobro.letra*2 ELSE proceso_cobro.letra end as  sum_cuota
FROM
acuerdo_pago
INNER JOIN proceso_cobro ON acuerdo_pago.dni = proceso_cobro.dni
WHERE acuerdo_pago.idpersonal='" . $_SESSION['idpersonal'] . "' and proceso_cobro.credito !=' '
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

    function get_asign_frec() {

        //conexion a la base de datos
        $this->conectar();
        $query = $this->consulta("
            SELECT
            frecuencia.frecuencia
            FROM
            frecuencia");
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

    function get_index_asign_upd() {
        $this->conectar();
        if (!empty($_REQUEST['id_frec'])) {
            $frecu = $_REQUEST['id_frec'];
        } else {
            $frecu = $_REQUEST['fr1'];
        }

        if (!empty($_REQUEST['id_pagoen'])) {
            $pagoe = $_REQUEST['id_pagoen'];
        } else {
            $pagoe = $_REQUEST['pr2'];
        }

        if (!empty($_REQUEST['idpersonal'])) {
            $idp = $_REQUEST['idpersonal'];
            $asig = ",acuerdo_pago.asignador='" . $_SESSION['idpersonal'] . "'";
        } else {
            $idp = $_REQUEST['idperbusca'];
            $asig = ",acuerdo_pago.asignador='" . $_SESSION['idpersonal'] . "'";
        }

        $query = $this->consulta("UPDATE acuerdo_pago
    SET acuerdo_pago.fecha_verif='" . $_REQUEST['fecha_next'] . "',
    acuerdo_pago.acuerdo='" . $_REQUEST['acuerdo'] . "', 
    acuerdo_pago.frecuencia_msg='" . $frecu . "',
    acuerdo_pago.pagoen='" . $pagoe . "',
     acuerdo_pago.idpersonal='" . $idp . "'$asig
      
    WHERE acuerdo_pago.dni='" . $_REQUEST['dni'] . "'");
        $this->disconnect();
    }

    function acuerdo_update_cobra($condicion_post) {

        //conexion a la base de datos
//               echo"<pre>";print_r($condicion_post);exit;
        $this->conectar();

        // -------------------- datos de acuerdo segun fecha maxima ------------    
        $query1 = $this->consulta("SELECT * FROM
                                    acuerdos
                                    WHERE acuerdos.dnic='" . $condicion_post['dni'] . "'
                                    ORDER BY acuerdos.fecha_verificacion DESC
                                    ");
        $datos1 = array();
        $conta = -1;
        while ($row = mysql_fetch_array($query1)) {
            $conta = $conta + 1;
            $datos1[] = $row;
            //         echo $datos1[''.$conta.'']['fecha_verificacion'];
            if ($datos1['' . $conta . '']['fecha_verificacion'] == $condicion_post['fecha_next']) {
                print_r(json_encode(array("resp" => 0, "msg" => 'ya cuenta un acuerdo con la misma fecha')));
                exit;
            }
        }


        // -------------------- la minima fecha para poder actualizar ------------   
        $query2 = $this->consulta("SELECT MIN(acuerdos.fecha_verificacion) as minfecha
                                    FROM
                                    acuerdos
                                    WHERE acuerdos.dnic='" . $condicion_post['dni'] . "' ");
        $datos2 = array();
        while ($row = mysql_fetch_array($query2)) {
            $datos2[] = $row;
        }
        // -------------------- contamos cuantos acuerdo tiene la persona ------------ 
        $query3 = $this->consulta("SELECT COUNT(acuerdos.idacuerdos) as cont
                                    FROM
                                    acuerdos
                                    WHERE acuerdos.dnic='" . $condicion_post['dni'] . "' ");
        $datos3 = array();
        while ($row = mysql_fetch_array($query3)) {
            $datos3[] = $row;
        }

        if ($datos3[0][cont] == 3) {
            // -------------------- ejecutamos la actualizacion ------------ 
            if (!empty($condicion_post['id_frec'])) {
                $frecu = $condicion_post['id_frec'];
            } else {
                $frecu = $condicion_post['fr1'];
            }

            if (!empty($condicion_post['id_pagoen'])) {
                $pagoe = $condicion_post['id_pagoen'];
            } else {
                $pagoe = $condicion_post['pr2'];
            }

            if (!empty($condicion_post['idpersonal'])) {
                $idp = $condicion_post['idpersonal'];
                $asig = ",acuerdo_pago.asignador='" . $_SESSION['idpersonal'] . "'";
            } else {
                $idp = $_SESSION['idpersonal'];
            }
            $queryper = $this->consulta(" 
            SELECT
            personal.primer_nombre,personal.idpersonal
            FROM personal WHERE personal.idpersonal='" . $_SESSION['idpersonal'] . "'");
            $datospers = array();
            while ($row = mysql_fetch_array($queryper)) {
                $datospers[] = $row;
            }

            $query = $this->consulta("UPDATE `acuerdos` SET `idpersonal`=" . $_SESSION['idpersonal'] . ",`dnic`= '" . $condicion_post['dni'] . "',"
                    . " `dnip`='" . $_SESSION['dnipersonal'] . "', `acuerdos`='" . $condicion_post['acuerdo'] . "',"
                    . " `fecha_verificacion`='" . $condicion_post['fecha_next'] . "',`fecha_visita`='" . date("Y-m-d") . "',"
                    . "`calificacion`='',`frecuencia_msj`='" . $frecu . "',`pagoen`='" . $pagoe . "',`fuente`='" . $datospers[0]['primer_nombre'] . "'"
                    . " WHERE (`dnic`='" . $condicion_post['dni'] . "' and `fecha_verificacion`='" . $datos2[0]['minfecha'] . "')");
        } else {

            $query = $this->consulta("INSERT INTO `acuerdos` (`idpersonal`, `dnic`, `dnip`, `acuerdos`,`fecha_verificacion`,`fecha_visita`,`frecuencia_msj`,`pagoen`,`fuente`)"
                    . "VALUES (" . $_SESSION['idpersonal'] . ", '" . $condicion_post['dni'] . "',"
                    . " '" . $_SESSION['dnipersonal'] . "', '" . utf8_decode($condicion_post['acuerdo']) . "',"
                    . " '" . $condicion_post['fecha_next'] . "','" . date("Y-m-d") . "',"
                    . "'" . $frecu . "','" . $pagoe . "','" . $datospers[0]['primer_nombre'] . "')");
        }
        //----------------------------poner datos a la nueva tabla acuerdo_pago
        // -------------------- buscamos si el dni esta o no ------------   


        print_r(json_encode(array("resp" => 1, "msg" => 'Bien')));
        exit;



        $this->disconnect();
    }

    function acuerdo_cambi_estado() {
    
        //conexion a la base de datos
        $this->conectar();
        $this->consulta("
            UPDATE acuerdos SET acuerdos.estado='0' WHERE acuerdos.dnic='".$_REQUEST["dni"]."'");
        $this->consulta("
           UPDATE acuerdo_pago SET acuerdo_pago.estado='0' WHERE acuerdo_pago.dni='".$_REQUEST["dni"]."'");
        $this->disconnect();
    }
     function acuerdo_cambi_estadoone() {
    
        //conexion a la base de datos
        $this->conectar();
        $this->consulta("
            UPDATE acuerdos SET acuerdos.estado='1' WHERE acuerdos.dnic='".$_REQUEST["dni"]."'");
        $this->consulta("
           UPDATE acuerdo_pago SET acuerdo_pago.estado='1' WHERE acuerdo_pago.dni='".$_REQUEST["dni"]."'");
        $this->disconnect();
    }

    // cobranzas_pagadas
}

?>