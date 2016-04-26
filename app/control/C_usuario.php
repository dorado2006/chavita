<?php

require_once '../lib/View.php';
require '../app/modelo/M_usuario.php';
require_once '../lib/Controller.php';

class C_usuario extends Controller {

    function index() {

        $cobr = new M_usuario();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->get_personal();
        $data['personal'] = $this->Select(array('id' => 'idperfil', 'name' => 'idperfil', 'table' => 'perfil', 'code' => $obj->idperfil));
        $data['oficina'] = $this->Select(array('id' => 'idoficina', 'name' => 'idoficina', 'table' => 'oficina', 'code' => $obj->idoficina));

        $view->setData($data);
        $view->setTemplate('../app/vista/usuario/_index.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function nuevousuario() {

        $cobr = new M_usuario();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->nuevousuario($_REQUEST);
        // $view->setData($data);
        $view->setTemplate('../app/vista/usuario/_Form_personal.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function cambiar_uc() {
        
      $cobr = new M_usuario();
        $view = new View();
        $data = array();
        $cobr->cambiar_uc($_REQUEST);
        // $view->setData($data);
        $view->setTemplate('../app/vista/usuario/_Form_personal.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }
    
  function getpersonal() {
    
      $cobr = new M_usuario();
        $view = new View();
        $data = array();
        $data['obj'] = $cobr->get_personalcondi($_REQUEST);
        $data['rows_perfil'] = $cobr->get_perfil();
         $view->setData($data);
        $view->setTemplate('../app/vista/usuario/_Form_personal.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }
    
    
    function updateusua() {
      $cobr = new M_usuario();
        $view = new View();
        $data = array();
        $cobr->update_usus($_REQUEST);
         //$view->setData($data);
       // $view->setTemplate('../app/vista/usuario/_Form_personal.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }
}
