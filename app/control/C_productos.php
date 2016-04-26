<?php

require_once '../lib/Controller.php';
require_once '../lib/View.php';
require '../app/modelo/M_productos.php';
require '../app/modelo/M_venta.php';
require '../app/modelo/M_compras.php';

class C_productos extends Controller {

    public function index() {
        
    }

    public function mostrar_buscador() {
        $data = array();
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../app/vista/productos/B_productos.php');
        $view->setLayout('../app/templates/vacia.php');
        $view->render();
    }

    public function buscador_pro() {
        $data = array();
        $cobr1 = new M_compras();
        $view = new View();
        $ordenado = Array();
        $dataResponce_p = $cobr1->get_buscaproducto();
        foreach ($dataResponce_p as $key => $value) {
            // $ordenado['name'][$value['primer_nombre']] = $rep->get_data_reporte_xpersonal($value['idpersonal']);
            array_push($ordenado[$key]['value'] = $value['idproductos'], $ordenado[$key]['label'] = utf8_encode($value['produc']));
        }
        
        $data['rows'] = $ordenado;
       
        $view->setData($data);
        $view->setTemplate('../app/vista/productos/bus_producto.php');
        $view->setLayout('../app/templates/vacia.php');
        $view->render();
    }

    function buscar_producto() {
        $envio = $this->tabla_productos($_POST['filtro'], $_POST['criterio']);
        echo $envio;
    }

    function mostrar_datos_det_temp() {
        $obj = new M_productos();
        $categoria = $_POST['categoria'];
        $datos_detalle_temp = $obj->mostrar_datos_det_temp();
        $data = array();
        $data['rows'] = $datos_detalle_temp;
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../app/vista/productos/product_agre.php');
        $view->setLayout('../app/templates/vacia.php');
        $view->render();
    }

    function delete_DetalleTemp_prod() {
        $obj = new M_productos();
        $obj->delete_prod_det_temp($_POST);
        $datos_detalle_temp = $obj->mostrar_datos_det_temp();
        $data = array();
        $data['rows'] = $datos_detalle_temp;
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../app/vista/productos/product_agre.php');
        $view->setLayout('../app/templates/vacia.php');
        $view->render();
    }

    function add_DetalleTemp_prod() {
        $obj = new M_productos();
        $categoria = $_POST['categoria'];
        $verificador = $obj->verificador_producto_agregado($_POST['idproductos']);
        if ($verificador != "NULO") {
            echo "<script>alert('El producto ya fue agregado');</script>";
        } else {
            $obj->add_prod_det_temp($_POST);
        }
        $datos_detalle_temp = $obj->mostrar_datos_det_temp();
        $data = array();
        $data['rows'] = $datos_detalle_temp;
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../app/vista/productos/product_agre.php');
        $view->setLayout('../app/templates/vacia.php');
        $view->render();
    }

    public function pro_categoria() {
        $data = array();
        $view = new View();
        $data['tipocomprobante'] = $this->Select(array('id' => 'idcomprob_pago', 'name' => 'idcomprob_pago', 'table' => 'comprob_pago', 'code' => $obj->idcomprob_pago));
        $data['tipopago'] = $this->Select(array('id' => 'idtipo_pago', 'name' => 'idtipo_pago', 'table' => 'tipo_pago', 'code' => $obj->idtipo_pago));
        $view->setData($data);
        $view->setTemplate('../app/vista/venta/_Index.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

}

?>