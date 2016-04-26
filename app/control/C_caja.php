<?php

require_once '../lib/View.php';
require '../app/modelo/M_caja.php';
require '../app/modelo/M_compras.php';
require_once '../lib/Controller.php';

class C_caja extends Controller {

    function index() {
        //echo '<pre>'; print_r($_POST);exit;
        $cobr = new M_caja();
        $view = new View();
        $data = array();
        // $data['categoria'] = $this->Select(array('id' => 'idcategoria', 'name' => 'idcategoria', 'table' => 'categoria', 'code' => $obj->idcategoria));
        //$view->setData($data);
        $view->setTemplate('../app/vista/caja/menucaja.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function apertura() {
        //echo '<pre>'; print_r($_POST);exit;
        $cobr = new M_caja();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->apertura_caja();
        $view->setData($data);
        $view->setTemplate('../app/vista/caja/apertura.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
        // radio nuevo tiempo #989013274  
    }

    function apertura_caja() {

        $cobr = new M_caja();
        $view = new View();
        $data = array();
        $cobr->apertura_caja1();
        
    }

    function salida_flujo() {

        $cobr = new M_compras();
        $cobr1 = new M_caja();
        $view = new View();
        $data = array();
        $ordenado = Array();
        //$data['t_documento'] = $this->Select(array('id' => 'idtipo_documento', 'name' => 'Comp_pago', 'table' => 'tipo_documento', 'code' => $obj->idtipo_documento));

        $dataResponce_p = $cobr->getbuscavendedorid();
        foreach ($dataResponce_p as $key => $value) {
            // $ordenado['name'][$value['primer_nombre']] = $rep->get_data_reporte_xpersonal($value['idpersonal']);
            array_push($ordenado[$key]['value'] = $value['idpersonal'], $ordenado[$key]['label'] = utf8_encode($value['vendedor']));
        }
        $data['rows'] = $ordenado;
        $data['rows1'] = $cobr1->get_descripcion();

        $view->setData($data);
        $view->setTemplate('../app/vista/caja/salida_caja.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function arqueo() {
        //echo '<pre>'; print_r($_POST);exit;
        $cobr = new M_caja();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->get_arqueo();
        $data['rows1'] = $cobr->get_arqueo_scaja();
        $data['rows2'] = $cobr->get_arqueo_fccaja();
        $view->setData($data);
        $view->setTemplate('../app/vista/caja/arqueo.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function entrada_flujo() {
        //echo '<pre>'; print_r($_POST);exit;
        $cobr_c = new M_caja();
        $view = new View();
        $data = array();
        $cobr = new M_compras();
        $ordenado = Array();
        //$data['t_documento'] = $this->Select(array('id' => 'idtipo_documento', 'name' => 'Comp_pago', 'table' => 'tipo_documento', 'code' => $obj->idtipo_documento));

        $dataResponce_p = $cobr->getbuscavendedorid();
        foreach ($dataResponce_p as $key => $value) {
            // $ordenado['name'][$value['primer_nombre']] = $rep->get_data_reporte_xpersonal($value['idpersonal']);
            array_push($ordenado[$key]['value'] = $value['idpersonal'], $ordenado[$key]['label'] = utf8_encode($value['vendedor']));
        }
        $data['rows'] = $ordenado;
        $data['rows1'] = $cobr_c->get_descripcion($cond = 1);
        $data['rows2'] = $cobr_c->index();

        $view->setData($data);
        $view->setTemplate('../app/vista/caja/entrada_caja.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function save_entrada_flujo() {

        $cobr = new M_caja();
        $view = new View();
        $data = array();
        $cobr->save_salida();
        print_r(json_encode(array("msj" => "SE GUARDO CON ÉXITO")));
    }

    function save_salida_flujo() {
        $cobr = new M_caja();
        $view = new View();
        $data = array();
        $cobr->save_salida();
        print_r(json_encode(array("msj" => "SE GUARDO CON ÉXITO")));
    }

    function cierrecaja() {
        $cobr = new M_caja();
        $view = new View();
        $data = array();
        $cobr->cierrecaja_arq();
        print_r(json_encode(array("msj" => "SE GUARDO CON ÉXITO")));
    }

    function aperturacaja() {
        $cobr = new M_caja();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->index();

        $view->setData($data);
        $view->setTemplate('../app/vista/caja/entrada_caja.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }
        function reportes() {
        //echo '<pre>'; print_r($_POST);exit;
        $cobr = new M_caja();
        $view = new View();
        $data = array();
        //$data['rows'] = $cobr->get_reportes();
       // $view->setData($data);
        $view->setTemplate('../app/vista/caja/reportes.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
        // radio nuevo tiempo #989013274  
    }
    
       function data_reporte() {
       
        $cobr = new M_caja();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->get_reportes();
        $view->setData($data);
        $view->setTemplate('../app/vista/caja/data_reporte.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
        // radio nuevo tiempo #989013274  
    }

}
