<?php

require_once '../app/modelo/Main.php';

class ControllerException extends Exception {
    
}

class Controller {

    public function __call($name, $arguments) {
        throw new ControllerException("Error! El método {$name}  no está definido.");
    }

    public function Select($p) {
        $obj = new Main();
        $obj->table = $p['table'];
        $data = array();

        $data['rows'] = $obj->getList();
        $data['name'] = $p['name'];
        $data['form'] = $p['form'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../app/vista/_Select.php');
        return $view->renderPartial();
    }
       public function Select_where($p) {
        $obj = new Main();
        $obj->table = $p['table'];
        $obj->condi = $p['cond'];
        $obj->selec = $p['selec'];
        
        $data = array();

        $data['rows'] = $obj->getList_where();
        $data['code'] = $p['code'];
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../app/vista/_Select.php');
        return $view->renderPartial();
    }
    public function getFiels($p){
        $obj = new Main();      
        $obj->table = $p['table'];
        $obj->campo = $p['campo'];
        $obj->idtable = $p['idtable'];
        $datos=$obj->geFliels();
        return $datos;
    }
        public function Select_clemente($p) {
        $obj = new Main();
        $obj->table = $p['table'];
        $data = array();

        $data['rows'] = $obj->getList_clemente();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../app/vista/_Select.php');
        return $view->renderPartial();
    }
    
   public function Select_clemente_val_nom($p) {
        $obj = new Main();
        $obj->table = $p['table'];
        $data = array();

        $data['rows'] = $obj->getList_clemente_val_nom();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['code'] = $p['code'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../app/vista/_Select.php');
        return $view->renderPartial();
    }
    public function crear_menu_modulos() {
        echo "<ul class='nav navbar-nav'> ";
        $obj = new Main();
        $data = array();
        $padre = $obj->get_modulo_padre();
        foreach ($padre as $f) {
            $descripcion = $f['descripcion'];
            $idmodulo = $f['idmodulo'];
            $url = $f['url'];
            $hijos = $obj->get_modulo_hijos($idmodulo);
            if (count($hijos) > 0) {
                echo "<li class='dropdown'><a href='#' class='dropdown-toggle ' data-toggle='dropdown'>$descripcion <b class='caret'></b></a>  <ul class='dropdown-menu'>";
                foreach ($hijos as $r) {
                    echo"<li><a href='" . $r['url'] . "'>" . $r['descripcion'] . "</a></li>";
                }
                echo "</ul></li>";
            } else {
                echo "<li><a  href='$urlraiz/$url'>" . $f['descripcion'] . "</a></li>";
            }
        }echo "</ul>";
    }

    public function tabla_miembros_ugel($filtro, $criterio) {
        $obj = new Main();
        $data = array();
        $data['rows'] = $obj->Buscar_miembros_ugel($filtro, $criterio);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../app/vista/cliente/tipoconvenio/_Miemb_U.php');
        return $view->renderPartial();
    }

    public function tabla_clientes($pos_condicion, $condicion) {
        $obj = new Main();
        $data = array();
        $data['rows'] = $obj->Buscar_cliente($pos_condicion, $condicion);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../app/vista/cliente/T_cliente.php');
        return $view->renderPartial();
    }

    public function tabla_clientes2($filtro, $criterio) {
        $obj = new Main();
        $data = array();
        $data['rows'] = $obj->Buscar_cliente2($filtro, $criterio);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../app/vista/cliente/T_cliente2.php');
        return $view->renderPartial();
    }

    public function tabla_productos($filtro, $criterio) {
        $obj = new Main();
        $data = array();
        $data['rows'] = $obj->Buscar_productos($filtro, $criterio);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../app/vista/productos/_Index.php');
        return $view->renderPartial();
    }

    public function Select_ajax($p) {
        $obj = new Main();
        $obj->table = $p['table'];
        $obj->filtro = $p['filtro'];
        $obj->criterio = $p['criterio'];
        $data = array();
        $data['rows'] = $obj->getList_ajax();
        $data['name'] = $p['name'];
        $data['id'] = $p['id'];
        $data['disabled'] = $p['disabled'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Select_ajax.php');
        return $view->renderPartial();
    }

    public function Pagination($p) {
        $data = array();
        $data['rows'] = $p['rows'];
        $data['query'] = $p['query'];
        $data['url'] = $p['url'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Pagination.php');
        return $view->renderPartial();
    }

    public function Combo_Search($options) {
        $data = array();
        $data['options'] = $options;
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_Combo_Search.php');
        return $view->renderPartial();
    }

    public function grilla($name, $columns, $rows, $options, $pag, $edit, $view, $select = false, $new = true) {
        $obj = new Main();
        $data = array();
        $data['nr'] = $obj->getnr();
        $data['cols'] = $columns;
        $data['rows'] = $rows;
        $data['edit'] = $edit;
        $data['view'] = $view;
        $data['select'] = $select;
        $data['name'] = $name;
        $data['pag'] = $pag;
        $data['new'] = $new;
        $data['combo_search'] = $this->Combo_Search($options);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_grilla.php');
        $view->setLayout('../template/Layout.php');
        return $view->renderPartial();
    }

}

?>
