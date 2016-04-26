<?php

require_once '../app/ConBD.php';

class Main extends database {

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
    CONCAT_WS(' ',cliente.primer_nombre,cliente.segundo_nombre) as nombres,
    CONCAT_WS(' ',cliente.apellido_p,cliente.apellido_m) as apellidos,
    CONCAT_WS('-',cliente.telfcasa,cliente.telf1,cliente.telf2) as telefonos,
    cliente.dni,
    CASE WHEN(convenio.descripcion='ugel-tarapoto') THEN 'docente' END pertenece,
    CONCAT_WS('-',cliente.dir_actual,cliente.distrito)as direccion,
    CONCAT_WS('-',lugar_trabajo.codigo_ruc,lugar_trabajo.nombre,lugar_trabajo.direccion,lugar_trabajo.distrito)as trabaja


    FROM
    cliente
    INNER JOIN lugar_trabajo ON cliente.idcliente = lugar_trabajo.idcliente
    INNER JOIN convenio ON convenio.idconvenio = cliente.idconvenio
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

    function Buscar_cliente2($filtro, $criterio) {
        $tabl = "cliente.";
        if (empty($filtro)) {
            $filtro = 'dni';
        }
        //conexion a la base de datos
        $this->conectar();
        $query = $this->consulta("SELECT
        cliente.idcliente,
        cliente.dni,
        CONCAT_WS(' ',cliente.primer_nombre,cliente.segundo_nombre) AS nombres,
        cliente.sexo,
        concat(cliente.apellido_p,' ',cliente.apellido_m) AS apellidos,
        cliente.dir_actual,
        cliente.distrito,
        convenio.descripcion as convenio
        FROM
        cliente
        Inner Join convenio ON convenio.idconvenio = cliente.idconvenio
        WHERE " . $tabl . $filtro . " like '%" . $criterio . "%'  limit 0,150");
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

    function Buscar_productos($filtro, $criterio) {
        $tabl = "productos.";
        if ($filtro == "categoria") {
            $tabl = "categoria.";
        }
        if (empty($filtro)) {
            $filtro = "idproductos";
        }
        $this->conectar();
        $query = $this->consulta("SELECT
productos.idproductos,
productos.precio_venta,
productos.stock,
categoria_prod.categoria,
productos.nombre_pr,
productos.modelo,
productos.color
FROM
productos
INNER JOIN categoria_prod ON categoria_prod.idcategoria = productos.idproductos");
        $this->disconnect();
        if ($this->numero_de_filas($query) > 0) {
            while ($tsArray = $this->fetch_assoc($query))
                $data[] = $tsArray;
            return $data;
        } else {
            return '';
        }
    }

    function Buscar_cliente_ant($pos_condicion, $condicion) {
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
        CONCAT_WS(' ',cliente.primer_nombre,cliente.segundo_nombre) as nombres,
        CONCAT_WS(' ',cliente.apellido_p,cliente.apellido_m) as apellidos,
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

    function Buscar_miembros_ugel($filtro, $criterio) {
        $tabl = "ugel.";
        if (empty($condicion)) {
            $condicion = null;
        }
        if (empty($pos_condicion)) {
            $pos_condicion = "apellido_p";
        }
        //conexion a la base de datos
        $this->conectar();
        $query = $this->consulta("SELECT 
        ugel.idugel,
        ugel.nombres,
        ugel.apellido_p,ugel.apellido_m,
        concat(ugel.apellido_p,' ',ugel.apellido_m) AS apellidos,
        ugel.dni,
        ugel.codmod
        FROM
        ugel 
        WHERE " . $tabl . $filtro . " like '%" . $criterio . "%'  limit 0,150");
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

    function getList() {

        $query = "SELECT * FROM {$this->table} ";
        $this->conectar();
        $query = $this->consulta($query);
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

    function getList_where() {
        if ($this->selec !="") {
            $sel = $this->selec;
        } else {
            $sel = "*";
        }
        
        $query = "SELECT " . $sel . " FROM {$this->table}  WHERE {$this->condi}";

        $this->conectar();
        $query = $this->consulta($query);
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

    function getList_clemente() {

        $query = "SELECT idpersonal,primer_nombre FROM {$this->table} WHERE estado='1'";
        $this->conectar();
        $query = $this->consulta($query);
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

    function getList_clemente_val_nom() {

        $query = "SELECT CONCAT_WS('_',primer_nombre,idpersonal) as idper,primer_nombre  FROM {$this->table} WHERE estado='1'";
        $this->conectar();
        $query = $this->consulta($query);
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

    function get_modulo_padre() {

        $query = "select * from modulo where idpadre='0' and estado='1' ";
        $this->conectar();
        $query = $this->consulta($query);
        $this->disconnect();
        if ($this->numero_de_filas($query) > 0) { // existe -> datos correctos
            //se llenan los datos en un array
            while ($tsArray = $this->fetch_assoc($query))
                $data[] = $tsArray;
            return $data;
        } else {
            return 'vacia';
        }
    }

    function get_modulo_hijos($idmodulo) {

        $query = "
                SELECT
modulo.idmodulo,
modulo.descripcion,
modulo.url,
modulo.idpadre,
modulo.estado,
modulo_perfil.ind,
modulo_perfil.idmodulo,
modulo_perfil.idperfil
FROM
modulo
INNER JOIN modulo_perfil ON modulo.idmodulo = modulo_perfil.idmodulo
WHERE modulo_perfil.idperfil='".$_SESSION['idperfil']."' and modulo.idpadre='" . $idmodulo . "'
                 ";
        $this->conectar();
        $query = $this->consulta($query);
        $this->disconnect();
        if ($this->numero_de_filas($query) > 0) { // existe -> datos correctos
            //se llenan los datos en un array
            while ($tsArray = $this->fetch_assoc($query))
                $data[] = $tsArray;
            return $data;
        } else {
            return 'vacia';
        }
    }

}

?>