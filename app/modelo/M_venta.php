<?php

require_once '../app/ConBD.php';

class M_venta extends database {

    function index($query, $p, $c) {
        $sql = "select  * from cliente 
                where " . $c . " like :query";
        $param = array(array('key' => ':query', 'value' => "%$query%", 'type' => 'STR'));
        $data['total'] = $this->getTotal($sql, $param);
        $data['rows'] = $this->getRow($sql, $param, $p);
        $data['rowspag'] = $this->getRowPag($data['total'], $p);
        return $data;
    }

    function insert_cronogrmas($_P) {
       echo "<pre>"; print_r($_P);exit;
        $this->conectar();
        $query1 = $this->consulta("update venta set num_cuota='" . $_P['n_letras'] . "',monto_cuota='" . $_P['monto_letra'] . "',condicion_pago='" . $_P['idcondicion_pago'] . "',a_partir_de='" . $_P['fecha_inicio_pago'] . "' where venta.idventa='" . $_P['idventa'] . "'"); //uodate into venta 
        foreach ($_P['nro_cuota'] as $key => $r) {
//            $query2 = $this->consulta("insert into proceso_cobro (idventa,idpersonal,idclienete,idcondicion_pago,fecha_recuerdo,fecha_vencimiento,nro_cuota,nro_recibo,estado)values('" . $_P['idventa'] . "','" . $_SESSION['idpersonal'] . "','" . $_P['idcliente'] . "','" . $_P['idcondicion_pago'] . "','" . date('Y/m/d', strtotime($_P['fecha_vencimiento'][$key] . " - 1 day")) . "','" . $_P['fecha_vencimiento'][$key] . "','" . $_P['nro_cuota'][$key] . "','" . $_P['idnumero_comprobante'] . "','1')");
            $query2 = $this->consulta("insert into proceso_cobro (idventa,idpersonal,idclienete,idcondicion_pago,nro_cuota,nro_recibo,estado)values('" . $_P['idventa'] . "','" . $_SESSION['idpersonal'] . "','" . $_P['idcliente'] . "','" . $_P['idcondicion_pago'] . "','" . $_P['nro_cuota'][$key] . "','" . $_P['idnumero_comprobante'] . "','1')");
        }
//        $query3 = $this->consulta("insert into acuerdos (idventa,idproceso_cobro,acuerdos,fecha_recordatorio,fecha_final)values('" . $_P['n_letras'] . "','" . $_P['monto_letra'] . "','" . $_P['idcondicion_pago'] . "','" . $_P['fecha_inicio_pago'] . "' where venta.idventa=".$_P['idventa']."','1')"); 
        $regresoData['exito'] = true;
        return $regresoData;
    }

    function insert($_P) {
        $this->conectar();
        $query = $this->consulta("insert into venta (idpersonal,idcliente,idtipo_pago,total,fecha_venta)values('" . $_SESSION['idpersonal'] . "','" . $_P['idcliente'] . "','" . $_P['idtipo_pago'] . "','" . $_P['total'] . "','" . $_P['fecha_venta'] . "')"); //inser into venta 
        $idventa = $this->retornadato("SELECT MAX(idventa)  from venta");
        $get_table_detalle_temp = $this->consulta("SELECT
        detalletemporal.idproductos,
        detalletemporal.cantidad,
        detalletemporal.precio,
        detalletemporal.cantidad*detalletemporal.precio as subtotal
        FROM
        detalletemporal
        where detalletemporal.usuario='" . $_SESSION['usuario'] . "'");
        $regresoData['idventa'] = $idventa;
        if ($this->numero_de_filas($get_table_detalle_temp) > 0) { // existe -> datos correctos
            while ($tsArray = $this->fetch_assoc($get_table_detalle_temp))
                $data[] = $tsArray;
            foreach ($data as $f) {
                $idproductos = $f['idproductos'];
                $cantidad = $f['cantidad'];
                $subtotal = $f['subtotal'];
                $query = $this->consulta("insert into descripcion_venta (idventa,idproductos,cantidad,subtotal) values('" . $idventa . "','" . $idproductos . "','" . $cantidad . "','" . $subtotal . "')");
            }
            $query = $this->consulta("delete from detalletemporal where detalletemporal.usuario='" . $_SESSION['usuario'] . "'"); //Vaciamos detalle temporal tras  haver concluido venta
            $this->disconnect();
            $regresoData['exito'] = true;
            return $regresoData;
        } else {
            $regresoData['exito'] = false;
            return $regresoData;
        }
    }

    function Buscar_cliente($pos_condicion, $condicion) {
        $tabl = "cliente.";
        if (empty($condicion)) {
            $condicion = null;
        }
        if (empty($pos_condicion)) {
            $pos_condicion = "apellido_p";
        }
        //conexion a la base de datos
        $this->conectar();
        $query = $this->consulta("SELECT
        cliente.idcliente,
        concat(cliente.primer_nombre,' ',cliente.segundo_nombre) as nombres,
        concat(cliente.apellido_p,' ',cliente.apellido_m) as apellidos,
        cliente.fecha_inscripcion,
        cliente.dni,
        cliente.cant_hijos,
        cliente.dir_actual,
        cliente.estado_civil
        FROM
        cliente
        WHERE " . $tabl . $pos_condicion . " like '" . $condicion . "%'
        ORDER BY
        cliente.apellido_p ASC
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

    function get_ventas($pos) {
//and (proceso_cobro.cond_pago='DIRECTO' OR proceso_cobro.cond_pago='PLANILLA')
        $this->conectar();
        $query = $this->consulta("SELECT
                cliente.dni,
                CONCAT_WS(' ',nombres,apellidos) as nombre,
                proceso_cobro.fecha_mov,
                proceso_cobro.credito,
                proceso_cobro.letra,
                proceso_cobro.num_cuotas,
                proceso_cobro.producto,
                proceso_cobro.cond_pago,
                CONCAT_WS(' ',personal.primer_nombre,personal.segundo_nombre) as vendedor
                FROM
                proceso_cobro
                INNER JOIN cliente ON cliente.dni = proceso_cobro.dni
                INNER JOIN personal ON personal.idpersonal = proceso_cobro.idpersonal
                WHERE (proceso_cobro.fecha_mov BETWEEN '".$pos['fechai']."' and '".$pos['fechaf']."') 
                    AND  proceso_cobro.producto !=''
                ORDER BY proceso_cobro.fecha_mov ASC
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

?>