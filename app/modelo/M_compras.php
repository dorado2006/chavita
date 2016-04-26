
<?php

/*
  CLASE PARA LA GESTION DE LOS UNIVERSITARIOS
 */
require_once '../app/ConBD.php';

class M_compras extends database {
    /* REALIZA UNA CONSULTA A LA BASE DE DATOS EN BUSCA DE  REGISTROS UNIVERSITARIOS DADOS COMO
      PARAMETROS LA "CARRERA" Y LA "CANTIDAD" DE REGISTROS A MOSTRAR
      INPUT:
      $carrera | nombre de la carrera a buscar
      $limit | cantidad de registros a mostrar
      OUTPUT:
      $data | Array con los registros obtenidos, si no existen datos, su valor es una cadena vacia
     */

    function index($dni) {

        $this->conectar();
        $query = $this->consulta("SELECT
        cliente.idcliente,
        CONCAT_WS(' ',cliente.primer_nombre,cliente.segundo_nombre) as nombres,
        CONCAT_WS(' ',cliente.apellido_p,cliente.apellido_m) AS apelli,
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
        INNER JOIN lugar_trabajo ON cliente.idcliente = lugar_trabajo.idcliente where cliente.dni='" . $dni . "'
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

    function buscprove() {
        $this->conectar();
        $query = $this->consulta("            
                SELECT
          proveedor.idproveedores,
          proveedor.empresa,
          proveedor.ruc,
          proveedor.direccion,
          CONCAT_WS(' ',proveedor.nombres,proveedor.apellidop,proveedor.apellidom) as representante,
          CONCAT_WS(' / ',proveedor.telefono1,proveedor.telefono2) as telef,
          proveedor.dni,
          proveedor.correo
          from proveedor
          WHERE proveedor.empresa LIKE '%" . $_REQUEST['busc'] . "%' or proveedor.ruc LIKE '%" . $_REQUEST['busc'] . "%' or  proveedor.nombres LIKE '%" . $_REQUEST['busc'] . "%'
           or proveedor.apellidop LIKE '%" . $_REQUEST['busc'] . "%'
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

    function buscarproducto() {
        $this->conectar();
        $query = $this->consulta("            
                SELECT
                   productos.idproductos,
                    productos.idcategoria,
                    productos.stock,
                    productos.modelo,
                    productos.marca,
                    productos.descripcion,
                    categoria.categoria
                    FROM
                    productos
                    INNER JOIN categoria ON productos.idcategoria = categoria.idcategoria
WHERE  productos.modelo LIKE '%" . $_REQUEST['busc'] . "%' or productos.marca LIKE '%" . $_REQUEST['busc'] . "%'
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

    function produ_salida() {
        $this->conectar();
        if ($_REQUEST['opciones'] == 'ALM.OFICINA') {
            $stock = "productos.stock_of=productos.stock_of - '" . $_REQUEST['cantidad'] . "'";
        } else {
            $stock = "productos.stock=productos.stock - '" . $_REQUEST['cantidad'] . "'";
        }
        $this->consulta("
           UPDATE productos 
SET
productos.precio_venta='" . $_REQUEST['preciosv'] . "',$stock
WHERE productos.idproductos='" . $_REQUEST['idproduc'] . "'
                
");

        $query4 = $this->consulta("SELECT
                        salida_almacen.idproductos,salida_almacen.insalida
                        FROM
                        salida_almacen
                        WHERE salida_almacen.idproductos='" . $_REQUEST['idproduc'] . "'
                                and salida_almacen.idvendedor='" . $_REQUEST['idpersonal'] . "'
                ");

        if (mysql_num_rows($query4) > 0) {
            $datos33 = array();
            while ($row = mysql_fetch_array($query4)) {
                $datos33[] = $row;
            }
            $insalida = $datos33[0]['insalida'];
            $this->consulta("UPDATE salida_almacen SET  
                       salida_almacen.cantidad=salida_almacen.cantidad + '" . $_REQUEST['cantidad'] . "',
                           salida_almacen.estado='1'
                      WHERE salida_almacen.idproductos='" . $_REQUEST['idproduc'] . "'
                      and salida_almacen.idvendedor='" . $_REQUEST['idpersonal'] . "'
                            ");
        } else {


            $query3 = $this->consulta("SELECT
                    COALESCE(max(salida_almacen.insalida),0) +1 as maxi
                    FROM
                    salida_almacen");
            $datos3 = array();
            while ($row = mysql_fetch_array($query3)) {
                $datos3[] = $row;
            }
            $insalida = $datos3[0]['maxi'];
            $query = $this->consulta("INSERT into  salida_almacen (
                    salida_almacen.insalida,
                    salida_almacen.idpersonal,
                    salida_almacen.idvendedor,
                    salida_almacen.idproductos,
                    salida_almacen.fecha_salida,
                    salida_almacen.cantidad,
                    salida_almacen.devolucion,
                    salida_almacen.vendidos,
                    salida_almacen.estado)
                    VALUES ( '" . $insalida . "',
                            '" . $_SESSION['idpersonal'] . "',
                            '" . $_REQUEST['idpersonal'] . "',
                            '" . $_REQUEST['idproduc'] . "',
                            NOW(),
                            '" . $_REQUEST['cantidad'] . "',
                                '0',
                                '0',
                            '1'
                                )                
                                    ");
        }
        $query2 = $this->consulta(" 
            INSERT INTO detalle_salida (
            detalle_salida.insalida,
            detalle_salida.idpersonal,
            detalle_salida.idvendedor,
            detalle_salida.fecha,
            detalle_salida.salida,
            detalle_salida.almacen,
            detalle_salida.estado)
            VALUES (
                '" . $insalida . "',
                    '" . $_SESSION['idpersonal'] . "',
                    '" . $_REQUEST['idpersonal'] . "',
                    NOW(),
                    '" . $_REQUEST['cantidad'] . "',
                        '" . $_REQUEST['opciones'] . "',
                        '1'
                    )

                    ");

        $this->disconnect();
    }

    function nuev_product() {
        $this->conectar();

        $query3 = $this->consulta("SELECT
                COALESCE(MAX(productos.idproductos),0) +1 as penul
                FROM
                productos ");
        $datos3 = array();
        while ($row = mysql_fetch_array($query3)) {
            $datos3[] = $row;
        }
        if ($_REQUEST['opciones'] == 'ALM.OFICINA') {
            $stockk_of = "'" . $_REQUEST['cantidad'] . "'";
            $stockk = 0;
        } else {
            $stockk_of = 0;
            $stockk = "'" . $_REQUEST['cantidad'] . "'";
        }
        $query = $this->consulta("
 INSERT INTO productos (
 productos.idproductos,
productos.idcategoria,
productos.nombre_pr,
productos.marca,
productos.modelo,
productos.descripcion,
productos.color,
productos.precio_venta,
productos.stock,
productos.stock_of,
productos.webite) 
 VALUES ('" . $datos3[0]['penul'] . "',
         '" . $_REQUEST['subcateg'] . "',
         '" . strtoupper(utf8_decode($_REQUEST['producto'])) . "',
         '" . strtoupper(utf8_decode($_REQUEST['marca'])) . "',
         '" . strtoupper(utf8_decode($_REQUEST['modelo'])) . "',
         '" . strtoupper(utf8_decode($_REQUEST['descripcion'])) . "',
         '" . strtoupper(utf8_decode($_REQUEST['color'])) . "',
         '" . strtoupper(utf8_decode($_REQUEST['preciosv'])) . "',
         $stockk,$stockk_of,
         '" . strtoupper(utf8_decode($_REQUEST['website'])) . "'
                
                )");
        $query2 = $this->consulta("        
        INSERT into detalle_almacen (
        detalle_almacen.idpersonal,
detalle_almacen.idproducto,
detalle_almacen.fecha,
detalle_almacen.entrada,
detalle_almacen.precio_compra,
detalle_almacen.condicion,
detalle_almacen.almacen,
detalle_almacen.estado) 
 VALUES ('" . $_SESSION['idpersonal'] . "',
        '" . $datos3[0]['penul'] . "',
        NOW(),
        '" . $_REQUEST['cantidad'] . "', 
        '" . $_REQUEST['preciocomp'] . "',
        'NUEVO', 
        '" . $_REQUEST['opciones'] . "',
      '1'
)

");

        $this->disconnect();
    }

    function update_producto1() {

        $this->conectar();
        $query = $this->consulta("
           UPDATE productos 
SET
productos.idcategoria='" . $_REQUEST['subcateg'] . "',
productos.nombre_pr='" . $_REQUEST['producto'] . "',
productos.marca='" . $_REQUEST['marca'] . "',
productos.modelo='" . $_REQUEST['modelo'] . "',
productos.descripcion='" . $_REQUEST['descrip'] . "',
productos.color='" . $_REQUEST['color'] . "',
productos.webite='" . $_REQUEST['website'] . "' 
WHERE productos.idproductos='" . $_REQUEST['idproduc'] . "'
                
");
        $this->disconnect();
    }

    function update_producto() {

        $this->conectar();

        if ($_REQUEST['opciones'] == 'ALM.OFICINA') {
            $stockk = "productos.stock_of=productos.stock_of + '" . $_REQUEST['cantidad'] . "'";
        } else {
            $stockk = "productos.stock=productos.stock + '" . $_REQUEST['cantidad'] . "'";
        }
        $query = $this->consulta("
           UPDATE productos 
            SET
            productos.precio_venta='" . $_REQUEST['preciosv'] . "',
            $stockk
            WHERE productos.idproductos='" . $_REQUEST['idproduc'] . "'
                
");

        $query2 = $this->consulta("        
        INSERT into detalle_almacen (
        detalle_almacen.idpersonal,
detalle_almacen.idproducto,
detalle_almacen.fecha,
detalle_almacen.entrada,
detalle_almacen.precio_compra,
detalle_almacen.condicion,
detalle_almacen.almacen,
detalle_almacen.dni_client,
detalle_almacen.estado) 
 VALUES ('" . $_SESSION['idpersonal'] . "',
        '" . $_REQUEST['idproduc'] . "',
        NOW(),
        '" . $_REQUEST['cantidad'] . "', 
        '" . $_REQUEST['preciocomp'] . "',
        '" . $_REQUEST['condd'] . "', 
            '" . $_REQUEST['opciones'] . "',
            '" . $_REQUEST['dnicliente'] . "', 
      '1'
)

");


        $this->disconnect();
    }

    //----------------------------- salidas-----------------

    function produxvendedor() {
        $this->conectar();
        $query = $this->consulta("            
               SELECT
CONCAT_WS('-',productos.nombre_pr,
productos.marca,
productos.modelo,
productos.descripcion,
productos.color) AS descri,
productos.idcategoria,
productos.idproductos,
productos.webite,
salida_almacen.cantidad,
salida_almacen.devolucion,
salida_almacen.vendidos,
salida_almacen.idvendedor,
salida_almacen.insalida
FROM
productos
INNER JOIN salida_almacen ON productos.idproductos = salida_almacen.idproductos
WHERE salida_almacen.idvendedor='" . $_REQUEST['idvendedor'] . "' AND salida_almacen.cantidad >0

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

    function histoxvendedor() {
        $this->conectar();
        if (empty($_REQUEST['estado'])) {
            $opc = "detalle_salida.idbloques='" . $_REQUEST['idbloque'] . "'";
        } else {
             $opc = "detalle_salida.estado='1'";
        }
        $query = $this->consulta("            
        
SELECT
CONCAT_WS(' ',
productos.nombre_pr,
productos.marca,
productos.modelo,
productos.color) AS prod,
detalle_salida.insalida,
detalle_salida.fecha,
detalle_salida.salida,
detalle_salida.vend,
detalle_salida.dev,
detalle_salida.almacen,
detalle_salida.idvendedor,
personal.primer_nombre
FROM
productos
INNER JOIN salida_almacen ON productos.idproductos = salida_almacen.idproductos
INNER JOIN detalle_salida ON salida_almacen.insalida = detalle_salida.insalida
INNER JOIN personal ON detalle_salida.idpersonal = personal.idpersonal
WHERE detalle_salida.idvendedor='" . $_REQUEST['idvendedor'] . "' 
    and $opc ORDER BY prod ASC,detalle_salida.salida DESC
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

    function bloquexvendedor() {
        $this->conectar();
        $query = $this->consulta("            
        SELECT
        bloque_salida.idbloques,
        bloque_salida.fecha,
        bloque_salida.idpersonal,
        bloque_salida.idvendedor
        FROM
        bloque_salida
        WHERE bloque_salida.idvendedor='" . $_REQUEST['idvendedor'] . "'
            ORDER BY bloque_salida.fecha DESC
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

    function todosprod() {
        $this->conectar();
        $query = $this->consulta("            
        SELECT
categoria_prod.categoria,
productos.nombre_pr,
productos.marca,
productos.modelo,
productos.descripcion,
productos.color,
productos.stock,
productos.stock_of,
productos.precio_venta
FROM
categoria_prod
INNER JOIN productos ON categoria_prod.idcategoria = productos.idcategoria
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
        //conexion a la base de datos  {"id":3460,"label":"alba","value":"alba"}
        $this->conectar();
        $query = $this->consulta("
           SELECT personal.idpersonal, UPPER(CONCAT_WS('  ',personal.primer_nombre,personal.segundo_nombre,personal.apellido_p )) as vendedor
             FROM personal
            WHERE personal.estado=1
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

    function get_buscaproducto() {
        //conexion a la base de datos  {"id":3460,"label":"alba","value":"alba"}
        $this->conectar();
        $query = $this->consulta("
       SELECT
categoria_prod.idcategoria,
categoria_prod.idpadre,
CONCAT_WS('  ',
categoria_prod.categoria,
productos.nombre_pr,
productos.marca,
productos.modelo,
productos.descripcion,
productos.color) as produc,
productos.stock,
productos.precio_venta,
productos.webite,
productos.idproductos
FROM
categoria_prod
INNER JOIN productos ON categoria_prod.idcategoria = productos.idcategoria
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

    function get_buscaproductoid() {
        //conexion a la base de datos  {"id":3460,"label":"alba","value":"alba"}
        $this->conectar();
        $query = $this->consulta("
       SELECT
categoria_prod.idcategoria,
categoria_prod.idpadre,
categoria_prod.categoria,
productos.nombre_pr,
productos.marca,
productos.modelo,
productos.descripcion,
productos.color,
productos.stock,
productos.stock_of,
productos.precio_venta,
productos.webite,
productos.idproductos
FROM
categoria_prod
INNER JOIN productos ON categoria_prod.idcategoria = productos.idcategoria
WHERE productos.idproductos='" . $_REQUEST['idprod'] . "'
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

    function get_buscacategoria() {
        //conexion a la base de datos  {"id":3460,"label":"alba","value":"alba"}
        $this->conectar();
        $query = $this->consulta("
    SELECT
categoria_prod.idcategoria,
categoria_prod.categoria,
categoria_prod.descripcion,
categoria_prod.url,
categoria_prod.idpadre,
categoria_prod.estado
FROM
categoria_prod
WHERE categoria_prod.idpadre='0' and estado='1'
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

    function get_bussubcacategoria($idcat) {
        //conexion a la base de datos  {"id":3460,"label":"alba","value":"alba"}
        $this->conectar();
        $query = $this->consulta("
    SELECT
categoria_prod.idcategoria,
categoria_prod.categoria,
categoria_prod.descripcion,
categoria_prod.idpadre,
categoria_prod.estado
FROM
categoria_prod
WHERE (categoria_prod.idpadre='" . $idcat . "'  or categoria_prod.idcategoria='" . $idcat . "')and estado='1'
ORDER BY categoria_prod.idpadre ASC
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

    function devoluxpersonal() {
        $this->conectar();

        if ($_REQUEST['cond'] == 'vendi') {
           
            $this->consulta("            
                     UPDATE salida_almacen SET  salida_almacen.vendidos=COALESCE(salida_almacen.vendidos,0) + '" . $_REQUEST['devol'] . "'
WHERE salida_almacen.insalida='" . $_REQUEST['idsalida'] . "'       
            ");

            $query2 = $this->consulta(" 
            INSERT INTO detalle_salida (
            detalle_salida.insalida,
            detalle_salida.idpersonal,            
             detalle_salida.idvendedor,
            detalle_salida.fecha,
            detalle_salida.vend,
            detalle_salida.estado)
            VALUES (
                '" . $_REQUEST['idsalida'] . "',
                    '" . $_SESSION['idpersonal'] . "',
                     '" . $_REQUEST['idvendedor'] . "',
                    NOW(),
                    '" . $_REQUEST['devol'] . "',
                        '1'
                    )

                    ");
        } else {
            $this->consulta("            
                     UPDATE salida_almacen SET  salida_almacen.devolucion=COALESCE(salida_almacen.devolucion,0) + '" . $_REQUEST['devol'] . "'
                WHERE salida_almacen.insalida='" . $_REQUEST['idsalida'] . "'       
            ");

            $query2 = $this->consulta(" 
            INSERT INTO detalle_salida (
            detalle_salida.insalida,
            detalle_salida.idpersonal,  
            detalle_salida.idvendedor,
            detalle_salida.fecha,
            detalle_salida.dev,
            detalle_salida.almacen,
            detalle_salida.estado)
            VALUES (
                '" . $_REQUEST['idsalida'] . "',
                     '" . $_SESSION['idpersonal'] . "',
                     '" . $_REQUEST['idvendedor'] . "',
                    NOW(),
                    '" . $_REQUEST['devol'] . "',
                        'ALM.OFICINA',
                        '1'
                    )

                    ");
//            if ($_REQUEST['opciones'] == 'ALM.OFICINA') {
//                $stockk = "productos.stock_of=productos.stock_of + '" . $_REQUEST['cantidad'] . "'";
//            } else {
//                $stockk = "productos.stock=productos.stock + '" . $_REQUEST['cantidad'] . "'";
//            }
            $this->consulta("
           UPDATE productos 
                SET productos.stock_of=productos.stock_of + '" . $_REQUEST['devol'] . "'
                WHERE productos.idproductos='" . $_REQUEST['idproduc'] . "'
                ");

            $this->consulta("        
        INSERT into detalle_almacen (
        detalle_almacen.idpersonal,
detalle_almacen.idproducto,
detalle_almacen.fecha,
detalle_almacen.entrada,
detalle_almacen.precio_compra,
detalle_almacen.condicion,
detalle_almacen.almacen,
detalle_almacen.dni_client,
detalle_almacen.estado) 
 VALUES ('" . $_SESSION['idpersonal'] . "',
        '" . $_REQUEST['idproduc'] . "',
        NOW(),
        '" . $_REQUEST['devol'] . "', 
        '0',
        'DEVO_P', 
            'ALM.OFICINA',
            '" . $_REQUEST['idvendedor'] . "', 
      '1'
)

");
        }

        $this->disconnect();
    }

    function reset_prod() {
        $this->conectar();
        $this->consulta("            
                       UPDATE salida_almacen 
SET salida_almacen.cantidad=0,
salida_almacen.devolucion=0,
salida_almacen.vendidos=0,
salida_almacen.estado=0
WHERE salida_almacen.idvendedor='" . $_REQUEST['idven'] . "'
            ");

        $query3 = $this->consulta("SELECT
            COALESCE(MAX(bloque_salida.idbloques),0) +1 as maxx
            FROM
            bloque_salida");
        $datos3 = array();
        while ($row = mysql_fetch_array($query3)) {
            $datos3[] = $row;
        }
        $this->consulta("    
        INSERT INTO bloque_salida(
        bloque_salida.idbloques,
bloque_salida.fecha,
bloque_salida.idpersonal,
bloque_salida.idvendedor) 
 VALUES('" . $datos3[0]['maxx'] . "',
               NOW(),
              '" . $_SESSION['idpersonal'] . "',
              '" . $_REQUEST['idven'] . "'
                )
                ");
        $this->consulta("
                UPDATE detalle_salida SET  detalle_salida.idbloques='" . $datos3[0]['maxx'] . "' 
                WHERE detalle_salida.idvendedor='" . $_REQUEST['idven'] . "' and detalle_salida.estado='1' 
                 
                ");
        $this->consulta("
                UPDATE detalle_salida SET  detalle_salida.estado='0'  
                WHERE detalle_salida.idvendedor='" . $_REQUEST['idven'] . "' and detalle_salida.idbloques='" . $datos3[0]['maxx'] . "' 
                 
                ");
        $this->disconnect();
    }

    function salida_almacen() {
        $this->conectar();
        $query = $this->consulta("INSERT INTO `salida_almacen` (`idpersonal`, `idproductos`, `idoficina`, `fecha_salida`, "
                . "`cantidad`, `tipodocuemto`,`num_documento`,`estado`) "
                . "VALUES ('" . $_SESSION['idpersonal'] . "', '" . $_REQUEST['idproducto'] . "', '1', '" . $_REQUEST['fechaingreso'] . "', '" . $_REQUEST['cantidad'] . "',"
                . " '2', '" . strtoupper(utf8_decode($_REQUEST['numdocume'])) . "','0')");

        $this->disconnect();
        //---- aptualiza estock  
        $this->conectar();
        $query2 = $this->consulta(" UPDATE productos set productos.stock = stock - '" . $_REQUEST['cantidad'] . "'  WHERE productos.idproductos = '" . $_REQUEST['idproducto'] . "' ");
        $queryupd = $this->consulta(" UPDATE `entrada_almacen` SET `estado`='2' WHERE `identrada`='" . $_REQUEST['identra'] . "' ");

        $this->disconnect();
    }

    function detallesalida() {
        $this->conectar();
        $query = $this->consulta("            
     SELECT
CONCAT_WS('-',categoria.categoria,productos.marca,productos.modelo,productos.descripcion) as detallepro,
salida_almacen.insalida,
salida_almacen.cantidad,
productos.idproductos,
salida_almacen.tipodocuemto,
salida_almacen.num_documento,
salida_almacen.fecha_salida,
salida_almacen.idpersonal
FROM
salida_almacen
INNER JOIN productos ON salida_almacen.idproductos = productos.idproductos
INNER JOIN categoria ON productos.idcategoria = categoria.idcategoria
WHERE  salida_almacen.fecha_salida ='" . $_REQUEST['fechaingreso'] . "' 
   and salida_almacen.num_documento='" . $_REQUEST['numdocume'] . "' and  salida_almacen.idpersonal='" . $_SESSION['idpersonal'] . "'                  

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

    function consultastock() {
        $this->conectar();
        $query = $this->consulta("            
SELECT
productos.idproductos,
productos.idcategoria,
productos.marca,
productos.modelo,
productos.stock
FROM
productos
WHERE productos.idproductos = '" . $_REQUEST['idproducto'] . "'
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

    function salida_delete() {
        $this->conectar();

        $query2 = $this->consulta(" UPDATE productos set productos.stock = stock + '" . $_REQUEST['cantidad'] . "'  WHERE productos.idproductos = '" . $_REQUEST['idproducto'] . "' ");
        $queryacentrada = $this->consulta(" UPDATE `entrada_almacen` SET `estado`='1' WHERE `identrada`='" . $_REQUEST['identrada'] . "' ");

        $this->disconnect();
        $this->conectar();

        $query = $this->consulta("
                DELETE FROM `salida_almacen` 
                WHERE `insalida`='" . $_REQUEST['idsalida'] . "'
                ");
        $this->disconnect();
    }

}
