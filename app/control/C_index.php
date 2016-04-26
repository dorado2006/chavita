<?php

require_once '../lib/Controller.php';

 class C_Index extends Controller
 {

     public function Index ()
     {      
                  
         $params = array(
             'mensaje' => 'Bienvenido al Sistemas de NC',
             'fecha' => date('d-m-yyy'),
         );
         require '../app/templates/layout.php';
     }
    public function crear_menu(){      
        $envio = $this->crear_menu_modulos();
        echo $envio;
     }
 }
?>
