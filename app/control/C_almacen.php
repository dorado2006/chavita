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
        $data['categoria'] = $this->Select(array('id' => 'idcategoria', 'name' => 'idcategoria', 'table' => 'categoria', 'code' => $obj->idcategoria));
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
}