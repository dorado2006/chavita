<?php

require_once '../lib/Controller.php';
require_once '../lib/View.php';
require '../app/modelo/M_cliente.php';

class C_cliente extends Controller {

    public function index() {
        $data = array();
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../app/vista/cliente/vistanew.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
        
        
    }

    function create() {
        $data = array();
        $data['tipoconvenio'] = $this->Select(array('id' => 'idconvenio', 'name' => 'idconvenio', 'table' => 'convenio', 'code' => $obj->idconvenio));
        $data['perfil_cliente'] = $this->Select(array('id' => 'idperfil_cliente', 'name' => 'idperfil_cliente', 'table' => 'perfil_cliente', 'code' => $obj->idperfil_cliente));

        $view = new View();
        $view->setData($data);
        $view->setTemplate('../app/vista/cliente/_Form.php');
        $view->setLayout('../app/templates/list.php');
        $view->render();
    }

    function mostrar_miembros_ugel() {
        $envio = $this->tabla_miembros_ugel($_POST['filtro'], $_POST['criterio']);
        echo $envio;
    }

    function mostrar_grilla_convenios() {
        $idconvenio = $_POST['idconvenio'];
        $data = array();
        $view = new View();
        $view->setData($data);
        if ($idconvenio == 1) {
            $view->setTemplate('../app/vista/cliente/tipoconvenio/_Ugel.php');
            $view->setLayout('../app/templates/vacia.php');
            $view->render();
        } else {
            $view->setTemplate('../app/vista/cliente/tipoconvenio/_Policia.php');
            $view->setLayout('../app/templates/vacia.php');
            $view->render();
        }
    }

    function edit() {
        $obj = new M_cliente();
        $obj = $obj->edit($_GET['id']);
        $data = array();
        $data['obj'] = $obj;
        $data['tipoconvenio'] = $this->Select(array('id' => 'idconvenio', 'name' => 'idconvenio', 'table' => 'convenio', 'code' => $obj['idconvenio']));
        $data['perfil_cliente'] = $this->Select(array('id' => 'idperfil_cliente', 'name' => 'idperfil_cliente', 'table' => 'perfil_cliente', 'code' => $obj['idconvenio']));

        $view = new View();
        $view->setData($data);
        $view->setTemplate('../app/vista/cliente/_Form.php');
        $view->setLayout('../app/templates/list.php');
        $view->render();
    }

    public function save() {
        $obj = new M_cliente();
        if ($_POST['idcliente'] == '') {
            $p = $obj->insert($_POST);
            if ($p[0]) {
                header('Location: index.php?controller=tipo_documento');
            } else {
                $data = array();
                $view = new View();
                $data['msg'] = $p[1];
                $data['url'] = 'index.php?controller=tipo_documento';
                $view->setData($data);
                $view->setTemplate('../view/_Error_App.php');
                $view->setLayout('../template/Layout.php');
                $view->render();
            }
        } else {
            $p = $obj->update($_POST);
            if ($p[0]) {
                header('Location: index.php?controller=tipo_documento');
            } else {
                $data = array();
                $view = new View();
                $data['msg'] = $p[1];
                $data['url'] = 'index.php?controller=tipo_documento';
                $view->setData($data);
                $view->setTemplate('../view/_Error_App.php');
                $view->setLayout('../template/Layout.php');
                $view->render();
            }
        }
    }

    function buscar_cliente() {
        $envio = $this->tabla_clientes($_POST['pos_condicion'], $_POST['condicion']);
        echo $envio;
    }
    function buscar_cliente2() {
        $envio = $this->tabla_clientes2($_POST['filtro'], $_POST['criterio']);
        echo $envio;
    }

    function principal() {
        $pagina = $this->load_template();
        //$html = $this->load_page('app/views/default/modules/m.principal.php');
        //$pagina = $this->replace_content('/\#CONTENIDO\#/ms' ,$html , $pagina);

        $this->view_page($pagina);
    }


    function load_template() {
        $pagina = $this->load_page('../app/templates/layout.php');
//              $pagina = require '/../templates/layout.php';
        /* $header = $this->load_page('app/views/default/sections/s.header.php');
          $pagina = $this->replace_content('/\#HEADER\#/ms' ,$header , $pagina);
          $pagina = $this->replace_content('/\#TITLE\#/ms' ,$title , $pagina);
          $menu_left = $this->load_page('app/views/default/sections/s.menuizquierda.php');
          $pagina = $this->replace_content('/\#MENULEFT\#/ms' ,$menu_left , $pagina); */
        return $pagina;
    }

    function buscador() {
        $data = array();
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../app/vista/cliente/B_cliente.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }
    function buscador2() {
        $data = array();
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../app/vista/cliente/B_cliente2.php');
        $view->setLayout('../app/templates/vacia.php');
        $view->render();
    }


    private function load_page($page) {
        return file_get_contents($page);
    }

    /* METODO QUE ESCRIBE EL CODIGO PARA QUE SEA VISTO POR EL USUARIO
      INPUT
      $html | codigo html
      OUTPUT
      HTML | codigo html
     */

    private function view_page($html) {
        echo $html;
    }

    /* PARSEA LA PAGINA CON LOS NUEVOS DATOS ANTES DE MOSTRARLA AL USUARIO
      INPUT
      $out | es el codigo html con el que sera reemplazada la etiqueta CONTENIDO
      $pagina | es el codigo html de la pagina que contiene la etiqueta CONTENIDO
      OUTPUT
      HTML 	| cuando realiza el reemplazo devuelve el codigo completo de la pagina
     */

    private function replace_content($in = '/\#CONTENIDO\#/ms', $out, $pagina) {
        return preg_replace($in, $out, $pagina);
    }

}

?>