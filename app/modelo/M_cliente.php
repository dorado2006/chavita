<?php
require_once '../app/ConBD.php';

class M_cliente extends database{
    function index($query,$p,$c){
        $sql = "select  * from cliente 
                where ".$c." like :query";         
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );        
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );        
        return $data;
    }
     function edit($id){ 
      $this->conectar();
      $query = $this->consulta("select * from cliente where cliente.idcliente=$id");
      $this->disconnect();
      $datos = $this->fetch_assoc($query);
      return $datos;
     }
     function insert($_P ) {
        $this->conectar();         
         $query = $this->consulta("insert into cliente (idconvenio,primer_nombre,segundo_nombre,apellido_p,apellido_m,dni,fecha_inscripcion,fecha_nacimiento,cant_hijos,correo,estado_civil,sexo,telfcasa,telf1,telf2,dir_actual,barrio,distrito,provincia,departamento)"
         . " values(".$_P['idconvenio'].",'".$_P['primer_nombre']."','".$_P['segundo_nombre']."','".$_P['apellido_p']."','".$_P['apellido_m']."','".$_P['dni']."','".date("Y-m-d")."','".$_P['fecha_nacimiento']."','"
                 . $_P['cant_hijos']."','". $_P['correo']."','".$_P['estado_civil']."','".$_P['sexo']."','".$_P['telfcasa']."','".$_P['telf1']."','".$_P['telf2']."','".$_P['dir_actual']."','".$_P['barrio']."','".$_P['distrito']."','".$_P['provincia']."','".$_P['departamento']."');"); 
        
        $cant = $this->consulta("SELECT MAX(idcliente) as tam from cliente");   
        $this->disconnect();
        $tsArray = $this->fetch_assoc($cant);$cant=(int)$tsArray['tam']; 
        echo "<script>opener.document.getElementById('idcliente').value=$cant;window.close(); </script>";
    }
    function update($_P ) {
        $sql = $this->Query("p_tipo_documento(:p1,:p2,1)");
        $stmt = $this->db->prepare($sql);
        if($_P['idpadre']==""){$_P['idpadre']=null;}
        $stmt->bindValue(':p1', $_P['idtipo_documento'] , PDO::PARAM_INT);
        $stmt->bindValue(':p2', $_P['descripcion'] , PDO::PARAM_STR);   
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
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
        CONCAT_WS(' ',cliente.primer_nombre,cliente.segundo_nombre) as nombres,
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

}

?>