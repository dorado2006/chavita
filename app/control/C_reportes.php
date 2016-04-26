<?php

require_once '../lib/View.php';
require '../app/modelo/M_reportes.php';
require_once '../lib/Controller.php';
require_once '../lib/Classes/PHPExcel.php';

class C_reportes extends Controller {

    function cierre_mes() {

        $cobr = new M_reportes();
        $view = new View();
        $data = array();
        //$data['rows'] = $cobr->actualizar_cliente($_POST);
        $view->setData($data);
        $view->setTemplate('../app/vista/reportes/_index.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function control_recibos() {
        $cobr = new M_reportes();
        $view = new View();
        $data = array();
        //$data['rows'] = $cobr->actualizar_cliente($_POST);
        $view->setData($data);
        $view->setTemplate('../app/vista/reportes/_index_contrrecibos.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function rango_recibos() {

        $cobr = new M_reportes();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->get_rango_recibos();

        $data['rango1'] = $_REQUEST['rec1'];
        $data['rango2'] = $_REQUEST['rec2'];
        $view->setData($data);
        $view->setTemplate('../app/vista/reportes/tabla_recibos.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function import_ecxel() {

        require '../app/vista/reportes/import_ecxel.php';

        $cobr = new M_reportes();
        $view = new View();
        $data = array();
        $cobr->insertcarga_dni($sheetData);
        $data['cond'] = '1';
        $view->setData($data);
        $view->setTemplate('../app/vista/reportes/carga_dni.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function carga_dnibusc() {


        $cobr = new M_reportes();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->carga_dni();
        $view->setData($data);
        $view->setTemplate('../app/vista/reportes/carga_dni.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function carga_dnibusccliente() {


        $cobr = new M_reportes();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->carga_dnicliente();
        $view->setData($data);
        $view->setTemplate('../app/vista/reportes/carga_dni.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function deuda_cero() {

        $cobr = new M_reportes();
        $view = new View();
        //$data = array();
        //$data['rows'] = $cobr->nuevo_cliente($_POST);
        //$view->setData($data);
        $view->setTemplate('../app/vista/reportes/_index_cero.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function get_cierre_md() {

        $cobr = new M_reportes();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->get_cierre_md($_POST);
        $data['rows1'] = $cobr->get_cierre_gestor($_POST);
        $view->setData($data);
        $view->setTemplate('../app/vista/reportes/carga_data.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function compara_acuer() {

        $cobr = new M_reportes();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->set_compara_acuer($_POST);

        //$view->setData($data);
        // $view->setTemplate('../app/vista/reportes/carga_data.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function get_recibos() {

        $cobr = new M_reportes();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->get_cierre_md($_POST);
        $view->setData($data);
        $view->setTemplate('../app/vista/reportes/carga_data.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function get_deuda_cero() {

        $cobr = new M_reportes();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->get_deuda_cero($_POST);
        $view->setData($data);

        // echo "<script> alert('Datos Guardados Correctamenteee');</script>";
        // header("Location: index.php?controller=cobranza&action=gestor_cobranza");
        $view->setTemplate('../app/vista/reportes/carga_datacero.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function nuevo_pago() {

        $cobr = new M_reportes();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->nuevo_pago($_POST);
        $view->setData($data);
        $view->setTemplate('../app/vista/reportes/_index.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function acuerdos() {

        $cobr = new M_reportes();
        $view = new View();
        $data = array();
        // $data['rows'] = $cobr->nuevo_pago($_POST);
        $view->setData($data);
        $view->setTemplate('../app/vista/reportes/_index_acuerdo.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function _index_dni() {

        $cobr = new M_reportes();
        $view = new View();
        $data = array();
        $data['personal'] = $this->Select_clemente_val_nom(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $obj->idpersonal));
        $view->setData($data);
        $view->setTemplate('../app/vista/reportes/_index_dni.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function vario_acuerdos() {

        $cobr = new M_reportes();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->set_vario_acuerdos($_POST);
        $view->setData($data);
        $view->setTemplate('../app/vista/reportes/_index_dni.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function get_acuerdo_all() {

        $cobr = new M_reportes();
        $view = new View();
        $data = array();
        if ($_POST['fechai'] == 1) {
            $data['rows'] = $cobr->get_acuerdo_norecar();
        } else {
            $data['rows'] = $cobr->get_acuerdo_all($_POST);
        }
        $view->setData($data);
        $view->setTemplate('../app/vista/reportes/carga_acuerdos.php');
        echo $view->renderPartial();
    }

    function _index_secpagos() {

        $cobr = new M_reportes();
        $view = new View();
        $data = array();
        //$data['rows'] = $cobr->actualizar_cliente($_POST);
        $view->setData($data);
        $view->setTemplate('../app/vista/reportes/_index_secPagos.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function get_secpagos() {


        $cobr = new M_reportes();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->m_secpagos();
        // $data['rowsdni'] = $cobr->xcdm_secpagos();

        $data['fechas'] = array("f1" => $_REQUEST['fechai'], "f2" => $_REQUEST['fechaf']);
        $view->setData($data);
        $view->setTemplate('../app/vista/reportes/datos_secpago.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function carga() {

        $cobr = new M_reportes();
        $view = new View();
        $data = array();
        //$data['rows'] = $cobr->actualizar_cliente($_POST);
        $view->setData($data);
        $view->setTemplate('../app/vista/reportes/_index_secPagos.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function get_acuerdo_allExel() {

        $cobr = new M_reportes();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->get_acuerdo_all($_POST);
        $view->setData($data);
        include '../app/vista/reportes/desExel.php';
        echo "<script>document.location.href='../app/vista/reportes/desExel.php';</script>";
        //$view->setTemplate('../app/vista/reportes/desExel.php');
        //$view->setLayout('../app/templates/vacia_clemente.php');
        //$view->render();
    }

    function reportesGraficos() {
        $rep = new M_reportes();
        $resp = $rep->get_data_reporte_anual();
        print_r(json_encode($resp));
    }
//
//    function reportesGraficosxpersonal() {
//        $responce = Array();
//        $rep = new M_reportes();
//        $responce['resp'] = 1;
//        $dataResponce = $rep->get_data_reporte_xpersonal();
//        $mes = 1;
//        $c = 0;
//        for ($j = 0; $j < $tamanou; $j++) {
//            for ($i = 1; $i <= 12; $i++) {
//                
//            }
//        }
//
//        foreach ($dataResponce as $key => $value) {
//            $mesi = $mes;
//            if ($mes != $value['fech']) {
//                $c = 0;
//                $mes = $mes + 1;
//            } else {
//                $c = $c + 1;
//            }
//
//
//            //normal en el rango en el grupo
//            if ($value['pago'] == null) {
//                $value['pago'] = 0;
//            }
//            $ordenado[$c]['name'] = $value['primer_nombre'];
//            $ordenado[$c]['data'][$mes - 1] = $value['pago'];
////            }
////          
//        }
//        $responce['msg'] = $ordenado;
//        
//        print_r(json_encode($responce));
//    }
    function reportesGraficosxpersonal() {
        $responce = Array();
        $ordenado = Array();
        $rep = new M_reportes();
        $responce['resp'] = 1;
        $dataResponce_p = $rep->get_data_reporte_xpersonal_p();
        // $dataResponce = $rep->get_data_reporte_xpersonal();

        foreach ($dataResponce_p as $key => $value) {

         // $ordenado['name'][$value['primer_nombre']] = $rep->get_data_reporte_xpersonal($value['idpersonal']);
         array_push($ordenado[$key]['name']=$value['primer_nombre'],$ordenado[$key]['data'] = $rep->get_data_reporte_xpersonal($value['idpersonal']));
            
           
        }
     //  echo '<pre>';  print_r($ordenado);exit;

        $responce['msg'] = $ordenado;
        print_r(json_encode($responce,JSON_NUMERIC_CHECK));
    }

}

//cierra la clase reportes