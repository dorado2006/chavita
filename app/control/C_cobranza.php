<?php

require_once '../lib/View.php';
require '../app/modelo/M_cobranza.php';
require_once '../lib/Controller.php';
require '../app/modelo/M_compras.php';

class C_cobranza extends Controller {

    function formulario_acuerdo() {

        //echo '<pre>'; print_r($_POST);exit;
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $data['personal'] = $this->Select_clemente_val_nom(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $obj->idpersonal));
        $data['rows'] = $cobr->formulario_acuerdo($_POST);
        $view->setData($data);
        $view->setTemplate('../app/vista/cobranza/Form_acuerdos.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function unir_acuerdos() {

        //echo '<pre>'; print_r($_POST);exit;
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->m_unir_acuerdos($_REQUEST);
        //$view->setData($data);
        //$view->setTemplate('../app/vista/cobranza/Form_acuerdos.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function fotos() {

        //echo '<pre>'; print_r($_POST);exit;
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();

        $data['rows'] = $cobr->fotos($_REQUEST);
        $view->setData($data);
        $view->setTemplate('../app/vista/cobranza/subida_archivos/viewfoto.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function pagos() {

//       echo $_POST['dni']; exit;
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->correlativo($_POST);
        $data['personal'] = $this->Select_clemente(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $data['rows'][0]['cobrador']));
        $data['productos'] = $this->Select_where(array('id' => 'idventa', 'name' => 'idventa', 'selec' => 'proceso_cobro.idproceso_cobro,proceso_cobro.producto', 'table' => 'proceso_cobro', 'cond' => 'proceso_cobro.dni=' . $_POST['dni'] . ' and proceso_cobro.estado ="1" and proceso_cobro.producto !=""', 'code' => $obj->id_frec));

        $view->setData($data);
        $view->setTemplate('../app/vista/cobranza/Form_pago.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function buscaprodu() {

//       echo $_POST['dni']; exit;
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $data = $cobr->busca_produc($_REQUEST);

        print_r(json_encode($data));
    }

    function foreditcredito() {

//       echo $_POST['dni']; exit;
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->foreditcred($_POST);
        $data['condpago'] = $this->Select(array('id' => 'idcondpago', 'name' => 'idcondpago', 'table' => 'cnd_pago', 'code' => $data['rows'][0]['id']));

        $view->setData($data);
        $view->setTemplate('../app/vista/cobranza/Form_ed_cridito.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function actualizar_acuerdo() {
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $cobr->actualizar__acuerdo($_POST);
        $data['rows'] = $cobr->formulario_acuerdo($_POST);
        $view->setData($data);
        $view->setTemplate('../app/vista/cobranza/Form_tab_acurdo.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function elimina_acuerdo() {
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->elimina_acuerdo($_POST);
        $view->setData($data);
        $view->setTemplate('../app/vista/cobranza/Form_acuerdos.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function elimina_pago() {
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $cobr->elimina_pago($_POST);

        $idcliente = $_POST['idcliente'];
        //$data['rows'] = $cobr->cargar_datos_formulario_detalle($idcliente);
        $view->setData($data);
        $view->setTemplate('../app/vista/cobranza/_Form_detalle.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function formulario_acuerdo_detall() {

        //echo '<pre>'; print_r($_POST);exit;
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->formulario_acuerdo($_POST);
        $view->setData($data);
        $view->setTemplate('../app/vista/cobranza/Form_tab_acurdo.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function nuevo_acuerdo() {

        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        if ($_POST['bot_reg'] == 're') {

            $data['rows'] = $cobr->set_nuevo_acuedo_automat($_POST);
        } else {

            $data['rows'] = $cobr->set_nuevo_acuedo($_POST);
        }
        $view->setData($data);
        header("Location: index.php?controller=cobranza&action=gestor_cobranza");
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function actualizar_cliente() {
        //echo '<pre>'; print_r($_POST);exit;
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->actualizar_cliente($_POST);
        $view->setData($data);
        // echo "<script> alert('Datos Guardados Correctamenteee');</script>";
        header("Location: index.php?controller=cobranza&action=gestor_cobranza");
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function nuevo_cliente() {
        //echo '<pre>'; print_r($_POST);exit;
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->nuevo_cliente($_POST);
        $view->setData($data);
        // echo "<script> alert('Datos Guardados Correctamenteee');</script>";
        header("Location: index.php?controller=cobranza&action=gestor_cobranza");
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function isert_venta() {
        //echo '<pre>'; print_r($_POST);exit;
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->isert_venta($_POST);
        $view->setData($data);
        // echo "<script> alert('Datos Guardados Correctamenteee');</script>";
        header("Location: index.php?controller=cobranza&action=gestor_cobranza");
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function nuevo_pago() {

        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->nuevo_pago($_POST);
        $view->setData($data);
        echo "<script> alert('Datos Guardados Correctamenteee');</script>";
        header("Location: index.php?controller=cobranza&action=gestor_cobranza");
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function busqueda_online() {

        $cliente = $_POST['idcliente'];

        $cobr = new M_cobranza();

        $view = new View();
        $data = array();
        $data['rows'] = $cobr->busqueda_online($cliente);
        $view->setData($data);
        $view->setTemplate('../app/vista/cobranza/_Form_busqueda.php');
        $view->setLayout('../app/templates/vaci_cleme.php');
        $view->render();
    }

    function cargar_datos_formulario() {

        $obj = new M_cobranza();
        $view = new View();
        $obj = $obj->cargar_datos_formulario($_POST);
        $data = array();
        $data['obj'] = $obj;
        $view->setData($data);
        $view->setTemplate('../app/vista/cobranza/_Form_cliente.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function cargar_datos_formulario_detalle() {

        $idcliente = $_POST['idcliente'];

        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $data['personal'] = $this->Select_clemente(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $obj->idpersonal));

        $data['rows'] = $cobr->cargar_datos_formulario_detalle($idcliente);
        $data['rows2'] = $cobr->datos_formulario_detalle($idcliente);
        //$data['rows_cro'] = $cobr->imprimir_cronograma_cliente($idcliente);
        $data['rows_deta'] = $cobr->imprimir_cronograma_detalle_cretito($idcliente);

        $view->setData($data);
        $view->setTemplate('../app/vista/cobranza/_Form_detalle.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function buscavendedorid() {

        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->getbuscavendedorid();
//        echo "<pre>";
//        print_r($data['rows'][0][0]); exit;
        print_r(json_encode(array("vendedor" => $data['rows'][0][0])));
    }

    function formulario_editar_cliente() {
//        echo $_POST['idcliente'];
//        exit;
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();


        $data['obj'] = $cobr->formulario_editar_cliente($_POST);
        $data['rows1'] = $cobr->lugar_trb_distritos();
        $data['rows2'] = $cobr->tipo_servidor();
        $data['rows_dp'] = $cobr->departamentos();
        $data['rows_prov'] = $cobr->provincias();
        $data['rows_dist'] = $cobr->distrito();


        $view->setData($data);
        $view->setTemplate('../app/vista/cobranza/Form_editar_cliente.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function formulario_nuevo_cliente() {
//        echo $_POST['idcliente'];
//        exit;
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();



        $data['rows1'] = $cobr->lugar_trb_distritos();
        $data['rows2'] = $cobr->tipo_servidor();
        $data['rows_dp'] = $cobr->departamentos();
        $data['rows_prov'] = $cobr->provincias();
        $data['rows_dist'] = $cobr->distrito();


        $view->setData($data);
        $view->setTemplate('../app/vista/cobranza/Form_nuevo_cliente.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function formulario_nueva_venta() {
        //
        $cobr = new M_cobranza();
        $cobr1 = new M_compras();
        $view = new View();
        $data = array();
        $data['personal'] = $this->Select_clemente(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $obj->idpersonal));

        $data['obj'] = $cobr->formulario_editar_cliente($_POST);

        $ordenado = Array();
        $dataResponce_p = $cobr1->get_buscaproducto();
        foreach ($dataResponce_p as $key => $value) {
            // $ordenado['name'][$value['primer_nombre']] = $rep->get_data_reporte_xpersonal($value['idpersonal']);
            array_push($ordenado[$key]['value'] = $value['idproductos'], $ordenado[$key]['label'] = utf8_encode($value['produc']));
        }
        $data['rows'] = $ordenado;


        $view->setData($data);
        $view->setTemplate('../app/vista/cobranza/Form_nueva_venta.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function imprimir_cronograma() {
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
//        $data['personal'] = $this->Select_clemente(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $obj->idpersonal));

        $data['rows'] = $cobr->imprimir_cronograma_cliente($_REQUEST);
        $data['rows1'] = $cobr->imprimir_cronograma_detalle_cretito($_REQUEST);

        $view->setData($data);

        $view->setTemplate('../app/vista/cobranza/imprimir_cronograma.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function imprimir_cronog_pago() {

        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
//        $data['personal'] = $this->Select_clemente(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $obj->idpersonal));

        $data['rows'] = $cobr->imprimir_cronograma_cliente($_REQUEST);
        $data['rows2'] = $cobr->imprimir_cronograma_detalle_cretito($_REQUEST);
        $data['rows1'] = $_REQUEST;


        $view->setData($data);

        $view->setTemplate('../app/vista/cobranza/imprime_crono_pago.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function imprim_cron_par() {
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
//        $data['personal'] = $this->Select_clemente(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $obj->idpersonal));

        $data['rows'] = $cobr->imprimir_cronograma_cliente($_REQUEST);
        $data['rows1'] = $cobr->imprimir_cronograma_detalle_cretito($_REQUEST);

        $view->setData($data);

        $view->setTemplate('../app/vista/cobranza/imprimir_cronograma.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function gestor_cobranza() {

        $cobr = new M_cobranza();

        $view = new View();
        $data = array();
//        $data['personal'] = $this->Select_clemente(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'code' => $obj->idpersonal));
//        $data['personal1'] = $this->Select_where(array('id' => 'idventa', 'name' => 'idventa','selec' => 'proceso_cobro.idproceso_cobro,proceso_cobro.producto', 'table' => 'proceso_cobro', 'cond' => 'proceso_cobro.dni="42384851" and proceso_cobro.producto !=""', 'code' => $obj->id_frec));
        // $data['rows'] = $cobr->gestor_cobranza($_GET['idventa']);
        $view->setData($data);
        $view->setTemplate('../app/vista/cobranza/venta_cobranza.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function condicion_pago() {
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->condicion_pago($_POST);
        $view->setData($data);
        echo "<script> alert('Datos Guardados Correctamenteee');</script>";
        header("Location: index.php?controller=cobranza&action=gestor_cobranza");
        //$view->setTemplate( '../app/vista/cobranza/genera.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function genera() {

        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->generatu();
        //funcion exel
        // $cobr->set_acuerdos_exel();
        $view->setData($data);
        // header("Location: index.php?controller=cobranza&action=gestor_cobranza");
        $view->setTemplate('../app/vista/cobranza/genera.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function reportes() {
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        if ((empty($_POST['condi']))and ( empty($_POST['condi1']))) {
            $data['rows'] = $cobr->lugar_trb_distritos($_POST);
            $view->setData($data);
            $view->setTemplate('../app/vista/cobranza/reportes.php');
            $view->setLayout('../app/templates/layout.php');
            $view->render();
        } else {
            if ($_POST['cond_wher'] == 1) {

                $data['rows'] = $cobr->reportes($_POST, $op = 1);
                $data['rowscond'] = $_POST;
                $view->setData($data);
                // header("Location: index.php?controller=cobranza&action=gestor_cobranza");

                $view->setTemplate('../app/vista/cobranza/reporte_cargadatos.php');
                $view->setLayout('../app/templates/vacia_clemente.php');
                $view->render();
            } else {
                if ($_POST['cond_wher'] == 3 or $_POST['cond_wher'] == 4) {

                    $data['rows'] = $cobr->reportes($_POST, $op = 3);
                    $data['rowscond'] = $_POST;
                    $view->setData($data);
                    // header("Location: index.php?controller=cobranza&action=gestor_cobranza");

                    $view->setTemplate('../app/vista/cobranza/reporte_cargadatos.php');
                    $view->setLayout('../app/templates/vacia_clemente.php');
                    $view->render();
                } else {

                    $data['rows'] = $cobr->reportes($_POST, $op = 2);
                    $data['rowscond'] = $_POST;
                    $view->setData($data);
                    // header("Location: index.php?controller=cobranza&action=gestor_cobranza");

                    $view->setTemplate('../app/vista/cobranza/reporte_cargadatos.php');
                    $view->setLayout('../app/templates/vacia_clemente.php');
                    $view->render();
                }
            }
        }
    }

    function por_sector_distrito() {
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();

        $data['rows'] = $cobr->lugar_trb_distritos();
        $view->setData($data);
        // header("Location: index.php?controller=cobranza&action=gestor_cobranza");

        $view->setTemplate('../app/vista/cobranza/por_sector.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function por_sector_print() {
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        // echo"<pre>";print_r($_POST);exit;

        if ($_POST['selec_op'] == 1) {
            // echo '<pre>';          print_r($_POST);exit;

            $data['rows'] = $cobr->print_sector($_POST, $op = 1);

            //echo "ss"; print_r($data['rowscont']);exit;
            $view->setData($data);


            // header("Location: index.php?controller=cobranza&action=gestor_cobranza");

            $view->setTemplate('../app/vista/cobranza/print_sector.php');
            $view->setLayout('../app/templates/lay_imprecion.php');
            $view->render();
        } else {
            if ($_POST['selec_op'] == 3 or $_POST['selec_op'] == 4) {

                $data['rows'] = $cobr->print_sector($_POST, $op = 3);
                $view->setData($data);
                // header("Location: index.php?controller=cobranza&action=gestor_cobranza");

                $view->setTemplate('../app/vista/cobranza/print_sector.php');
                $view->setLayout('../app/templates/lay_imprecion.php');
                $view->render();
            } else {
                $data['rows'] = $cobr->print_sector($_POST, $op = 2);

                $view->setData($data);
                // header("Location: index.php?controller=cobranza&action=gestor_cobranza");

                $view->setTemplate('../app/vista/cobranza/print_sector.php');
                $view->setLayout('../app/templates/lay_imprecion.php');
                $view->render();
            }
        }
    }

    function por_sector_imprimir() {
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();


        $data['rows'] = $cobr->por_sector($_POST);
        $view->setData($data);
        // header("Location: index.php?controller=cobranza&action=gestor_cobranza");

        $view->setTemplate('../app/vista/cobranza/por_sector_cargadatos.php');
        $view->setLayout('../app/templates/lay_imprecion.php');
        $view->render();
    }

    function evaluacion() {
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->evaluacion($_POST);
        $view->setData($data);
        echo "<script> alert('Datos Guardados Correctamenteee');</script>";
        header("Location: index.php?controller=cobranza&action=gestor_cobranza");
        // $view->setTemplate( '../app/vista/cobranza/genera.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function reprogramacion() {
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->reprogramacion($_POST);
        $view->setData($data);
        echo "<script> alert('Datos Guardados Correctamenteee');</script>";
        header("Location: index.php?controller=cobranza&action=gestor_cobranza");
        // $view->setTemplate( '../app/vista/cobranza/genera.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function mostra_cronograma() {

        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->imprimir_cronograma_cliente($_REQUEST);
        $data['rows1'] = $cobr->imprimir_cronograma_detalle_cretito($_REQUEST);

        $view->setData($data);
        $view->setTemplate('../app/vista/cobranza/mostrar-cronograma.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function cronograma() {

        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->imprimir_cronograma_cliente($_REQUEST);
        $data['rows1'] = $cobr->buscarventa($_REQUEST);

        $view->setData($data);
        $view->setTemplate('../app/vista/cobranza/cronograma_pagos.php');
        $view->setLayout('../app/templates/vacia_clemente.php');
        $view->render();
    }

    function save() {

        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->save($_POST, $_POST['idventa'], $_SESSION['idpersonal']);
        $view->setData($data);
        echo "<script> alert('Datos Guardados Correctamente');</script>";
//$view->setTemplate( '../../index.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function cobranzas_vencidas() {

        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->cobranzas_vencidas();
        $view->setData($data);
//echo "<script> alert('Datos Guardados Correctamente');</script>";
        $view->setTemplate('../app/vista/cobranza/T_cobranzas_vencidas.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function index_asig() {

        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->get_index_asign();
        $data['idperbusca'] = $_REQUEST['sesi'];
        $data['meta'] = $cobr->asign_meta();
        $data['frecuencia'] = $this->Select(array('id' => 'id_frec', 'name' => 'id_frec', 'table' => 'frecuencia', 'code' => $obj->id_frec));
        $data['pago_en'] = $this->Select(array('id' => 'id_pagoen', 'name' => 'id_pagoen', 'table' => 'pago_en', 'code' => $obj->id_frec));
        if ($_SESSION['idperfil'] == 5) {
            $data['asig'] = $this->Select_where(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'cond' => 'personal.variante="pi"', 'code' => $obj->id_frec));
        } else {
            $data['asig'] = $this->Select_where(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'cond' => '(personal.variante="si" OR personal.idperfil=5) AND personal.estado=1', 'code' => $obj->id_frec));
        }
        $view->setData($data);
//echo "<script> alert('Datos Guardados Correctamente');</script>";

        if (empty($_REQUEST['fech'])) {
            $view->setTemplate('../app/vista/cobranza/index_asig.php');
            $view->setLayout('../app/templates/layout.php');
        } else {
            $view->setTemplate('../app/vista/cobranza/index_asig_data.php');
            $view->setLayout('../app/templates/vacia_clemente.php');
        }

        $view->render();
    }

    function index_asig_upd() {
//  echo "<pre>";print_r($_REQUEST);exit;

        $cobr = new M_cobranza();
        $view = new View();
        $data = array();

        if (!empty($_REQUEST["chechc"])) {
            if (empty($_REQUEST["idpersonal"])) {
                if (empty($_REQUEST["idperbusca"]) or $_REQUEST["idperbusca"] < 1) {
                    print_r(json_encode(array("resp" => 3, "msg" => 'ASIGNE A UNA PERSONA')));
                    exit;
                } else {
                    $cobr->acuerdo_cambi_estadoone();
                    $cobr->get_index_asign_upd();
                    $cobr->acuerdo_update_cobra($_POST);
                }
            } else {
                $cobr->acuerdo_cambi_estadoone();
                $cobr->get_index_asign_upd();
                $cobr->acuerdo_update_cobra($_POST);
            }
        } else {
            $cobr->acuerdo_cambi_estado();
            print_r(json_encode(array("resp" => 1, "msg" => 'BIEN')));
            exit;
        }



        $view->setData($data);
        //echo "<script> alert('Datos Guardados Correctamente');</script>";
        $view->setTemplate('../app/vista/cobranza/index_asig.php');
        $view->setLayout('../app/templates/layout.php');
        $view->render();
    }

    function index_asig_color() {

        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->get_index_asign();
        $data['idperbusca'] = $_REQUEST['sesi'];
        $data['meta'] = $cobr->asign_meta();
        $data['frecuencia'] = $this->Select(array('id' => 'id_frec', 'name' => 'id_frec', 'table' => 'frecuencia', 'code' => $obj->id_frec));
        $data['pago_en'] = $this->Select(array('id' => 'id_pagoen', 'name' => 'id_pagoen', 'table' => 'pago_en', 'code' => $obj->id_frec));
        if ($_SESSION['idperfil'] == 5) {
            $data['asig'] = $this->Select_where(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'cond' => 'personal.variante="pi"', 'code' => $obj->id_frec));
        } else {
            $data['asig'] = $this->Select_where(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'cond' => '(personal.variante="si" OR personal.idperfil=5) AND personal.estado=1', 'code' => $obj->id_frec));
        }
        $view->setData($data);

        $view->setTemplate('../app/vista/cobranza/index_asig_data.php');
        $view->setLayout('../app/templates/vacia_clemente.php');

        $view->render();
    }

    function index_asig_nuevascon() {

        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        $data['rows'] = $cobr->get_index_asign_menu();
        $data['idperbusca'] = $_REQUEST['sesi'];
        $data['meta'] = $cobr->asign_meta();
        $data['frecuencia'] = $this->Select(array('id' => 'id_frec', 'name' => 'id_frec', 'table' => 'frecuencia', 'code' => $obj->id_frec));
        $data['pago_en'] = $this->Select(array('id' => 'id_pagoen', 'name' => 'id_pagoen', 'table' => 'pago_en', 'code' => $obj->id_frec));
        if ($_SESSION['idperfil'] == 5) {
            $data['asig'] = $this->Select_where(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'cond' => 'personal.variante="pi"', 'code' => $obj->id_frec));
        } else {
            $data['asig'] = $this->Select_where(array('id' => 'idpersonal', 'name' => 'idpersonal', 'table' => 'personal', 'cond' => '(personal.variante="si" OR personal.idperfil=5) AND personal.estado=1', 'code' => $obj->id_frec));
        }
        $view->setData($data);

        $view->setTemplate('../app/vista/cobranza/index_asig_data.php');
        $view->setLayout('../app/templates/vacia_clemente.php');

        $view->render();
    }

    function acuerdocambiaestado() {
      
        $cobr = new M_cobranza();
        $view = new View();
        $data = array();
        if ($_REQUEST['estado'] == '0') {
            $cobr->acuerdo_cambi_estado();
            print_r(json_encode(array("resp" => 0, "msg" => 'SE DESACTIVO')));
            
        } else {
            $cobr->acuerdo_cambi_estadoone();
            print_r(json_encode(array("resp" => 1, "msg" => 'SE ACTIVADO')));
           
        }
    }

    /* METODO QUE MUESTRA LA PAGINA PRINCIPAL CUANDO NO EXISTEN NUEVAS ORDENES
      OUTPUT
      HTML | codigo html de la pagina
     */

    function principal() {
        $pagina = $this->load_template();
        //$html = $this->load_page('app/views/default/modules/m.principal.php');
        //$pagina = $this->replace_content('/\#CONTENIDO\#/ms' ,$html , $pagina);

        $this->view_page($pagina);
    }

    /* METODO QUE MUESTRA LA PAGINA HISTORIA DE BOLIVIA, ES UNA PAGINA ESTATICA
      OUTPUT
      HTML | codigo html de la pagina
     */



    /* METODO QUE CARGA LAS PARTES PRINCIPALES DE LA PAGINA WEB
      INPUT
      $title | titulo en string del header
      OUTPIT
      $pagina | string que contiene toda el cocigo HTML de la plantilla
     */

    function load_template() {
        $pagina = $this->load_page('../app/templates/layout.php');
        /* $header = $this->load_page('app/views/default/sections/s.header.php');
          $pagina = $this->replace_content('/\#HEADER\#/ms' ,$header , $pagina);
          $pagina = $this->replace_content('/\#TITLE\#/ms' ,$title , $pagina);
          $menu_left = $this->load_page('app/views/default/sections/s.menuizquierda.php');
          $pagina = $this->replace_content('/\#MENULEFT\#/ms' ,$menu_left , $pagina); */
        return $pagina;
    }

    /* METODO QUE MUESTRA EN PANTALLA EL FORMULARIO DE BUSQUEDA
      HTML | codigo html de la pagina  con el buscador incluido
     */

    function buscador() {
        $pagina = $this->load_template('Busqueda de registros');
        $buscador = $this->load_page('app/views/default/modules/m.buscador.php');
        $pagina = $this->replace_content('/\#CONTENIDO\#/ms', $buscador, $pagina);
        $this->view_page($pagina);
    }

    /* METODO QUE CARGA UNA PAGINA DE LA SECCION VIEW Y LA MANTIENE EN MEMORIA
      INPUT
      $page | direccion de la pagina
      OUTPUT
      STRING | devuelve un string con el codigo html cargado
     */

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