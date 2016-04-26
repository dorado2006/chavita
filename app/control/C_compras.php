<?php

require_once '../lib/View.php';
require '../app/modelo/M_compras.php';
require_once '../lib/Controller.php';

class C_compras extends Controller {

    function index() {
        //echo '<pre>'; print_r($_POST);exit;
        $cobr = new M_compras();
        $view = new View();
        $data = array();
        $ordenado = Array();
        //$data['t_documento'] = $this->Select(array('id' => 'idtipo_documento', 'name' => 'Comp_pago', 'table' => 'tipo_documento', 'code' => $obj->idtipo_documento));

        $dataResponce_p = $cobr->get_buscaproducto();
        foreach ($dataResponce_p as $key => $value) {
            // $ordenado['name'][$value['primer_nombre']] = $rep->get_data_reporte_xpersonal($value['idpersonal']);
            array_push($ordenado[$key]['value'] = $value['idproductos'], $ordenado[$key]['label'] = utf8_encode($value['produc']));
        }
        $data['rows'] = $ordenado;

        $view->setData($data);
        $view->setTemplate('../app/vista/compras/Index.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function nuevacategoria() {

        $cobr = new M_compras();
        $view = new View();
        $data = array();
        $cobr->nuevacategoria($_REQUEST);
        $data['categoria'] = $this->Select(array('id' => 'idcategoria', 'name' => 'idcategoria', 'table' => 'categoria', 'code' => $obj->idcategoria));
        $view->setData($data);
        $view->setTemplate('../app/vista/compras/recargarcategoria.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function guardar_producto() {


        $cobr = new M_compras();
        $view = new View();
        $data = array();
        if ($_REQUEST['updat'] == 'updat') {
            // print_r($_REQUEST);exit;
            $cobr->update_producto($_REQUEST);
        } elseif ($_REQUEST['updat_prod'] == 'updat_prod') {
            $cobr->update_producto1($_REQUEST);
        } else {
            $cobr->nuev_product($_REQUEST);
        }
        print_r(json_encode(array("msj" => "SE GUARDO CON ÉXITO")));
//        //$data['categoria'] = $this->Select(array('id' => 'idcategoria', 'name' => 'idcategoria', 'table' => 'categoria', 'code' => $obj->idcategoria));
//        $view->setData($data);
//        $view->setTemplate('../app/vista/compras/recargarcategoria.php');
//        $view->setLayout('../app/templates/vacia_clemente.php');
//        $view->render();
    }

    function actu_producto() {


        $cobr = new M_compras();
        $view = new View();
        $data = array();
        $cobr->update_producto1($_REQUEST);

        print_r(json_encode(array("msj" => "SE GUARDO CON ÉXITO")));
//        //$data['categoria'] = $this->Select(array('id' => 'idcategoria', 'name' => 'idcategoria', 'table' => 'categoria', 'code' => $obj->idcategoria));
//        $view->setData($data);
//        $view->setTemplate('../app/vista/compras/recargarcategoria.php');
//        $view->setLayout('../app/templates/vacia_clemente.php');
//        $view->render();
    }

    function producto_salida() {
        //print_r($_REQUEST);exit;

        $cobr = new M_compras();
        $view = new View();
        $data = array();

        $cobr->produ_salida($_REQUEST);
        print_r(json_encode(array("msj" => "SE GUARDO CON ÉXITO")));
      
        //$data['categoria'] = $this->Select(array('id' => 'idcategoria', 'name' => 'idcategoria', 'table' => 'categoria', 'code' => $obj->idcategoria));
//        $view->setData($data);
//        $view->setTemplate('../app/vista/compras/recargarcategoria.php');
//        $view->setLayout('../app/templates/vacia_clemente.php');
//        $view->render();
    }

    function b_vendedor() {

        $cobr = new M_compras();
        $view = new View();
        $data = array();
        //$data['personal'] = $this->Select_clemente_val_nom(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $obj->idpersonal));

        $data['rows'] = $cobr->buscprove($_REQUEST);
        $view->setData($data);
        $view->setTemplate('../app/vista/compras/buscproveed.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function buscarproducto() {

        $cobr = new M_compras();
        $view = new View();
        $data = array();
        //$data['personal'] = $this->Select_clemente_val_nom(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $obj->idpersonal));
        $data['rows'] = $cobr->buscarproducto($_REQUEST);
        $view->setData($data);
        $view->setTemplate('../app/vista/compras/buscproducto.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function entrada_almacen() {
        //echo "<pre>";        print_r($_REQUEST);exit;
        $cobr = new M_compras();
        $view = new View();
        $data = array();
        //$data['personal'] = $this->Select_clemente_val_nom(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $obj->idpersonal));
        $cobr->entr_almacen($_REQUEST);
        $data['rows'] = $cobr->select_entrada_almacen($_REQUEST);
        $view->setData($data);
        $view->setTemplate('../app/vista/compras/detalle_compra.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function devolucion() {
        //print_r($_REQUEST);exit;
        $cobr = new M_compras();
        $view = new View();
        $data = array();
        $cobr->devoluxpersonal($_REQUEST);
        $view->setData($data);
        $view->setTemplate('../app/vista/compras/detalle_compra.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }
    function reset_prodxvend() {
        //print_r($_REQUEST);exit;
        $cobr = new M_compras();
        $view = new View();
        $data = array();
        $cobr->reset_prod($_REQUEST);
       print_r(json_encode(array("msj" => "SE GUARDO CON ÉXITO")));
    }
    function nuevoproveedor() {

        // echo '<pre>'; print_r($_REQUEST);exit;
        $cobr = new M_compras();
        $view = new View();
        $data = array();
        //$data['personal'] = $this->Select_clemente_val_nom(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $obj->idpersonal));
        $data['rows'] = $cobr->nuevoproveedor($_REQUEST);
        $view->setData($data);
        $view->setTemplate('../app/vista/compras/buscproducto.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function nuevoproducto() {

        $cobr = new M_compras();
        $view = new View();
        $data = array();
        //$data['personal'] = $this->Select_clemente_val_nom(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $obj->idpersonal));
        $data['rows'] = $cobr->nuevoproducto($_REQUEST);
        $view->setData($data);
        $view->setTemplate('../app/vista/compras/buscproducto.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function actuestadoproducto() {

        $cobr = new M_compras();
        $view = new View();
        $data = array();
        //$data['personal'] = $this->Select_clemente_val_nom(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $obj->idpersonal));
        $cobr->actuestadoproducto($_REQUEST);
//        $view->setData($data);
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function actuestasalida() {
        //echo '<pre>';         print_r($_REQUEST); 
        $cobr = new M_compras();
        $view = new View();
        $data = array();
        //$data['personal'] = $this->Select_clemente_val_nom(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $obj->idpersonal));
        $cobr->actuestasalida($_REQUEST);
//        $view->setData($data);
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    //----------------------------------salidas-----------------------------

    function salida() {

        $cobr = new M_compras();
        $view = new View();
        $data = array();
        $ordenado = Array();
        //$data['t_documento'] = $this->Select(array('id' => 'idtipo_documento', 'name' => 'Comp_pago', 'table' => 'tipo_documento', 'code' => $obj->idtipo_documento));


        $dataResponce_p = $cobr->get_buscaproducto();
        foreach ($dataResponce_p as $key => $value) {
            // $ordenado['name'][$value['primer_nombre']] = $rep->get_data_reporte_xpersonal($value['idpersonal']);
            array_push($ordenado[$key]['value'] = $value['idproductos'], $ordenado[$key]['label'] = utf8_encode($value['produc']));
        }
        $data['rows'] = $ordenado;
        //print_r($data);exit;
        $view->setData($data);
        $view->setTemplate('../app/vista/compras/salida.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }
      function salida_refresh() {

        $cobr = new M_compras();
        $view = new View();
        $data = array();
        $ordenado = Array();
        //$data['t_documento'] = $this->Select(array('id' => 'idtipo_documento', 'name' => 'Comp_pago', 'table' => 'tipo_documento', 'code' => $obj->idtipo_documento));


        $dataResponce_p = $cobr->get_buscaproducto();
        foreach ($dataResponce_p as $key => $value) {
            // $ordenado['name'][$value['primer_nombre']] = $rep->get_data_reporte_xpersonal($value['idpersonal']);
            array_push($ordenado[$key]['value'] = $value['idproductos'], $ordenado[$key]['label'] = utf8_encode($value['produc']));
        }
        $data['rows'] = $ordenado;
        //print_r($data);exit;
        $view->setData($data);
        $view->setTemplate('../app/vista/compras/salida.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function reportes() {
        $cobr = new M_compras();
        $view = new View();
        $data = array();
        $ordenado = Array();
//        //$data['t_documento'] = $this->Select(array('id' => 'idtipo_documento', 'name' => 'Comp_pago', 'table' => 'tipo_documento', 'code' => $obj->idtipo_documento));
//
//        $dataResponce_p = $cobr->getbuscavendedorid();
//        foreach ($dataResponce_p as $key => $value) {
//            // $ordenado['name'][$value['primer_nombre']] = $rep->get_data_reporte_xpersonal($value['idpersonal']);
//            array_push($ordenado[$key]['value'] = $value['idpersonal'], $ordenado[$key]['label'] = utf8_encode($value['vendedor']));
//        }
//        $data['rows'] = $ordenado;
        $view->setData($data);
        $view->setTemplate('../app/vista/compras/reportes.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }
       function reportes_pxp() {
        $cobr = new M_compras();
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
        $view->setData($data);
        $view->setTemplate('../app/vista/compras/b_prod_personal.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }
      function reportes_hist() {
        $cobr = new M_compras();
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
        $view->setData($data);
        $view->setTemplate('../app/vista/compras/b_historial.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function salidaxvende() {

        $cobr = new M_compras();
        $view = new View();
        $data = array();
        //$data['personal'] = $this->Select_clemente_val_nom(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $obj->idpersonal));

        $data['rows'] = $cobr->produxvendedor();
        $view->setData($data);
        $view->setTemplate('../app/vista/compras/dta_reporter.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }
    
       function historiaxvende() {

        $cobr = new M_compras();
        $view = new View();
        $data = array();
        //$data['personal'] = $this->Select_clemente_val_nom(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $obj->idpersonal));

        $data['rows'] = $cobr->histoxvendedor();
        $view->setData($data);
        $view->setTemplate('../app/vista/compras/historialxvende.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }
        function histor_bloque() {

        $cobr = new M_compras();
        $view = new View();
        $data = array();
        //$data['personal'] = $this->Select_clemente_val_nom(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $obj->idpersonal));

        $data['rows'] = $cobr->bloquexvendedor();
        $view->setData($data);
        $view->setTemplate('../app/vista/compras/historialxbloque.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function form_actproduc() {

        $cobr = new M_compras();
        $view = new View();
        $data = array();
        //$data['personal'] = $this->Select_clemente_val_nom(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $obj->idpersonal));

        $data['rows'] = $cobr->get_buscaproductoid($_REQUEST);
        //print_r($data);exit;

        $dataResponce_p = $cobr->get_buscacategoria();

        foreach ($dataResponce_p as $key => $value) {
            // $ordenado['name'][$value['primer_nombre']] = $rep->get_data_reporte_xpersonal($value['idpersonal']);
            array_push($ordenado[] = $cobr->get_bussubcacategoria($value['idcategoria']));
        }
        $data['rows2'] = $ordenado;
        $view->setData($data);
        $view->setTemplate('../app/vista/compras/actualiza_producto.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function form_salida() {

        $cobr = new M_compras();
        $view = new View();
        $data = array();
        //$data['personal'] = $this->Select_clemente_val_nom(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $obj->idpersonal));
        $data['personal'] = $this->Select_clemente(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $obj->idpersonal));
        $data['rows'] = $cobr->get_buscaproductoid($_REQUEST);
        //print_r($data);exit;
        $view->setData($data);
        $view->setTemplate('../app/vista/compras/form_salida.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function form_nuevproduc() {

        $cobr = new M_compras();
        $view = new View();
        $data = array();
        // $data['rows'] = $cobr->get_buscacategoria();
        $ordenado = Array();
        //$data['t_documento'] = $this->Select(array('id' => 'idtipo_documento', 'name' => 'Comp_pago', 'table' => 'tipo_documento', 'code' => $obj->idtipo_documento));

        $dataResponce_p = $cobr->get_buscacategoria();

        foreach ($dataResponce_p as $key => $value) {
            // $ordenado['name'][$value['primer_nombre']] = $rep->get_data_reporte_xpersonal($value['idpersonal']);
            array_push($ordenado[] = $cobr->get_bussubcacategoria($value['idcategoria']));
        }
        $data['rows'] = $ordenado;
        //echo "<pre>";    print_r($data);exit;
        $view->setData($data);
        $view->setTemplate('../app/vista/compras/nuevo_producto.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function buscanumeracion() {

        $cobr = new M_compras();
        $view = new View();
        $data = array();

        $data['rows'] = $cobr->salida_buscanumeracion($_REQUEST);
        $view->setData($data);
        $view->setTemplate('../app/vista/compras/numeracion.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function todosproduc() {

        $cobr = new M_compras();
        $view = new View();
        $data = array();
        //$data['personal'] = $this->Select_clemente_val_nom(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $obj->idpersonal));

        $data['rows'] = $cobr->todosprod($_REQUEST);

        $view->setData($data);
        $view->setTemplate('../app/vista/compras/todoslosprod.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function repiteprodxserie() {

        $cobr = new M_compras();
        $view = new View();
        $data = array();
        //$data['personal'] = $this->Select_clemente_val_nom(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $obj->idpersonal));

        $data['rows'] = $cobr->repite_prodxserie($_REQUEST);

        $view->setData($data);
        $view->setTemplate('../app/vista/compras/existeserie.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function salida_almacen() {
//        echo '<pre>';         print_r($_REQUEST); 
        $cobr = new M_compras();
        $view = new View();
        $data = array();
        //$data['personal'] = $this->Select_clemente_val_nom(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $obj->idpersonal));

        $cobr->salida_almacen($_REQUEST);
        $data['rows'] = $cobr->detallesalida($_REQUEST);
        $view->setData($data);
        $view->setTemplate('../app/vista/compras/detallesalida.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function salidadelete() {
        // echo '<pre>';             print_r($_REQUEST);exit;
        $cobr = new M_compras();
        $view = new View();
        $data = array();
        $data['rowst'] = $cobr->salida_delete($_REQUEST);
        $data['rows'] = $cobr->detallesalida($_REQUEST);
        $view->setData($data);
        $view->setTemplate('../app/vista/compras/detallesalida.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function controlstock() {
        // echo '<pre>';             print_r($_REQUEST);
        $cobr = new M_compras();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->consultastock($_REQUEST);
        $view->setData($data);
        $view->setTemplate('../app/vista/compras/consulstock.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

}
