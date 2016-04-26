<?php

require_once '../lib/Controller.php';
require_once '../lib/View.php';
require '../app/modelo/M_venta.php';

class C_venta extends Controller {

    public function index() {
        $data = array();
        $view = new View();
        $data['tipocomprobante'] = $this->Select(array('id' => 'idcomprob_pago', 'name' => 'idcomprob_pago', 'table' => 'comprob_pago', 'code' => $obj->idcomprob_pago));
        $data['tipopago'] = $this->Select(array('id' => 'idtipo_pago', 'name' => 'idtipo_pago', 'table' => 'tipo_pago', 'code' => $obj->idtipo_pago));
        $view->setData($data);
        $view->setTemplate('../app/vista/venta/_Index.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }
    public function ejemplo(){
        $datos=$this->getFiels(array("table"=>"cliente","campo"=>"idcliente","idtable"=>"2"));print_r($datos);
    }

    public function cronograma_pagos($idventa) { 
        $view = new View();
        $data = array();
        $data['condicion_pago'] = $this->Select(array('id' => 'idcondicion_pago', 'name' => 'idcondicion_pago', 'table' => 'condicion_pago', 'code' => $obj->idcondicion_pago));
        $data['idventa'] = $idventa;
        $view->setData($data);
        $view->setTemplate('../app/vista/venta/cronograma_pagos.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    public function generar_cronograma() {
        $view = new View();
        $view->setData($_POST);
        $view->setTemplate('../app/vista/venta/pagos.php');
        $view->setLayout('../app/templates/lay.php');
        $view->render();
    }

    public function save_cronograma_pagos() {
        $obj = new M_venta();
        $view = new View();
        $p = $obj->insert_cronogrmas($_POST);
        if ($p['exito']) {
            header('Location: index.php?controller=venta');
        }
        else{echo "<script>alert('Problemas de guardado');window.location='index.php';</scipt>";}
    }

    public function save() {
        $obj = new M_venta();
        if ($_POST['idventa'] == '') {
            $p = $obj->insert($_POST);
            if ($p['exito']) {
                $this->cronograma_pagos($p['idventa']);
//                header('Location: index.php?controller=venta');
            } else {
                $data = array();
                $view = new View();
                $data['msg'] = $p[1];
                $data['url'] = 'index.php?controller=venta';
                $view->setData($data);
                $view->setTemplate('../app/vista/_Error_App.php');
                $view->setLayout('../template/Layout.php');
                $view->render();
            }
        } else {
            $p = $obj->update($_POST);
            if ($p) {
                header('Location: index.php?controller=venta');
            } else {
                $data = array();
                $view = new View();
                $data['msg'] = $p[1];
                $data['url'] = 'index.php?controller=venta';
                $view->setData($data);
                $view->setTemplate('../app/vista/_Error_App.php');
                $view->setLayout('../template/Layout.php');
                $view->render();
            }
        }
    }
    
        function reporte_ventas() {
        $cobr = new M_venta();
        $view = new View();
        //$data = array();
        //$data['rows'] = $cobr->nuevo_cliente($_POST);
        //$view->setData($data);
        $view->setTemplate('../app/vista/venta/index_reporte_venta.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }
    
         function get_ventas() {
        $cobr = new M_venta();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->get_ventas($_POST);
        $view->setData($data);
        $view->setTemplate('../app/vista/venta/carga_reporte_ventas.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

}

?>