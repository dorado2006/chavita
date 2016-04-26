<?php
require_once '../app/ConBD.php';

class M_productos extends database{

    function verificador_producto_agregado($idproductos){
        $this->conectar();         
        $id = $this->retornadato("select idproductos from detalletemporal where idproductos='$idproductos' and detalletemporal.usuario='".$_SESSION['usuario']."'");    
        $this->disconnect();
        return $id;
    }
    function add_prod_det_temp($_P){
        $this->conectar();         
        $tabla="detalletemporal";
         $query = $this->consulta("INSERT INTO ".$tabla."(idproductos,cantidad,precio,usuario) VALUES(".$_P['idproductos'].",".$_P['cantidad'].",".$_P['precio'].",'".$_SESSION['usuario']."');");    
        $this->disconnect();
        
    }
    function delete_prod_det_temp($_P){
        $this->conectar();         
        $tabla="detalletemporal";
        if(!empty($_P['iddetalletemporal'])){
         $query = $this->consulta("DELETE FROM ".$tabla." WHERE detalletemporal.iddetalletemporal=".$_P['iddetalletemporal']." and detalletemporal.usuario='".$_SESSION['usuario']."'");    
        }
        else{ $query = $this->consulta("DELETE FROM ".$tabla." WHERE detalletemporal.usuario='".$_SESSION['usuario']."'");    }
         $this->disconnect();
        
    }
    function mostrar_datos_det_temp(){
        $this->conectar();         
        $query = $this->consulta("SELECT
        categoria.categoria,
        productos.nombre,
        detalletemporal.iddetalletemporal,
        detalletemporal.cantidad,
        detalletemporal.precio,
        detalletemporal.cantidad *detalletemporal.precio as subtotal
        FROM
        detalletemporal
        Inner Join productos ON productos.idproductos = detalletemporal.idproductos
        Inner Join categoria ON categoria.idcategoria = productos.idcategoria where detalletemporal.usuario='".$_SESSION['usuario']."'");    
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