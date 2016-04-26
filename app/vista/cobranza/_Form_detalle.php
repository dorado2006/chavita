<style>
    .boton {
        // float:left;
        margin-right:10px;
        margin-top:20px;
        width:130px;
        height:40px;
        background:#222;
        color:#fff;
        padding:10px 6px 0 6px;
        cursor:pointer;
        text-align:center;
    }

    .boton:hover{color:#01DF01}

    .ventana{

        display:none;     // <!-- -------------------------> es importante ocultar las ventanas previamente -->
        font-family:Arial, Helvetica, sans-serif;
        color:#808080;
        line-height:28px;
        font-size:15px;
        text-align:justify;


    }
    .container_table {
        width: 950px;
        // background: #3f96d4;
        // color: #555;*/
        border: 3px solid #ccc;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        -ms-border-radius: 10px;
        border-radius: 10px;
        border-top: 3px solid #ddd;
        padding: 1em 2em;
        margin: 0 auto;
        -webkit-box-shadow: 3px 7px 5px #000;
        -moz-box-shadow: 3px 7px 5px #000;
        -ms-box-shadow: 3px 7px 5px #000;
        box-shadow: 3px 7px 5px #000;
        color: #000;
        font-size: 0.99em;
        // background: #0080d2;
        font-family: Georgia, Times New Roman, serif;
        text-align: center;

    }
    .container_table_edp {
        width: 400px;
        // background: #3f96d4;
        // color: #555;*/
        border: 3px solid #ccc;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        -ms-border-radius: 10px;
        border-radius: 10px;
        border-top: 3px solid #ddd;
        padding: 1em 2em;
        margin: 0 auto;
        -webkit-box-shadow: 3px 7px 5px #000;
        -moz-box-shadow: 3px 7px 5px #000;
        -ms-box-shadow: 3px 7px 5px #000;
        box-shadow: 3px 7px 5px #000;
        color: #000;
        font-size: 0.89em;
        // background: #0080d2;
        font-family: Georgia, Times New Roman, serif;
        text-align: center;
        border-collapse: separate;
        border-spacing:  5px;

    }

    .msk{
        background-color: #BC1010;
        padding: 6px 12px;
        border-radius: 4px;
        color: white;
        font-weight: bold;
        margin-left: -80px;
        margin-top: 15px;
        position: absolute;
    }

</style>
<script>

    var idproceso;
    var idprocesoC;
    $(function () {

        $('.produ').click(function () {
            idproducto = $(this).attr("id");
            $.post('../web/index.php', 'controller=cobranza&action=fotos&idproc_cobr=' + idproducto, function (data) {
                console.log(data);
                $("#dialogofoto").empty().append(data);
            });

            // window.open('../app/vista/cobranza/viewfoto.php','','width=800,height=600,left=50,top=50,toolbar=yes');
            $("#dialogofoto").dialog("open");

        });
        $("#dialogofoto").dialog({
            autoOpen: false,
            width: 1200,
            height: 650,
            show: "scale",
            hide: "scale",
            resizable: "false",
            position: "center",
            modal: "true"


        });





        /* en esta parte alctualizamos la condicion de pago*/
        $(".encab6").click(function () {
            var idperfil = $('#idperfil').val();
            if (idperfil == 1 || idperfil == 4) {
                var idproceso_cobro = $(this).attr("id");
                var separa = idproceso_cobro.split(",");
                idproceso = separa[0];
                var condicion_pago = separa[1];

                $("#condp").html(condicion_pago);
                $('#dialogo2').prop('title', nombres);
                $("#dialogo2").dialog("open");
            } else {
                alert("USTED NO TIENE PERMISO PARA ESTA OPERACIÓN...Pida ayuda a su Administrador");
            }
        });
        $("#dialogo2").dialog({
            autoOpen: false,
            width: 500,
            height: 250,
            show: "scale",
            hide: "scale",
            resizable: "false",
            position: "center",
            modal: "true"



        });
        $("#guardar_condipago").click(function () {

            var cp = $("#condicion_pago").val();


            $.post('../web/index.php', 'controller=cobranza&action=condicion_pago&cp=' + cp + '&idpc=' + idproceso, function (data) {
                console.log(data);

            });

            $("#dialogo2").dialog("close");
        });
        $(".editventa").hover(
                function () {
                    $(this).focus().after("<span class='msk'>Modificar</span>");
                }, function () {
            $('.msk').remove();
        }
        );

        /* ahora trabajaremos con refinancimiento*/
        $(".editventa").click(function () {
            var idperfil = $('#idperfil').val();
            if (idperfil == 1 || idperfil == 4) {
                var idprocventa = $(this).attr('id');
                var sep = idprocventa.split(',');

                idprocventa1 = sep[0];
                idprodni = sep[1];

                $.post('../web/index.php', 'controller=cobranza&action=foreditcredito&idprocventa1=' + idprocventa1 + '&idprodni=' + idprodni, function (data) {
                    console.log(data);
                    $("#dialogo3").empty().append(data);
                });

                $("#dialogo3").dialog("open");
            } else {
                alert("USTED NO TIENE PERMISO PARA ESTA OPERACIÓN...Pida ayuda a su Administrador");
            }
        });

//------sacar resporte de pago----
        $(".cronogr").hover(
                function () {
                    $(this).focus().after("<span class='msk'>Reporte Pagos</span>");
                }, function () {
            $('.msk').remove();
        }
        );
        $(".cronogr").click(function () {

            var idperfil = $('#idperfil').val();

            if (idperfil == 1 || idperfil == 4 || idperfil == 3) {
                var idprocventa = $(this).attr('id');
                var sep = idprocventa.split(',');

                idve = sep[0];
                idprodni = sep[1];


                $.post('../web/index.php', 'controller=cobranza&action=mostra_cronograma&idve=' + idve + '&idprodni=' + idprodni + '&cond=1', function (data) {
                    console.log(data);
                    $("#crono").empty().append(data);
                });

                $("#crono").dialog("open");
            } else {
                alert("USTED NO TIENE PERMISO PARA ESTA OPERACIÓN...Pida ayuda a su Administrador");
            }
        });
//......................... pagos crongrama

        $(".pago_cronog").hover(
                function () {
                    $(this).focus().after("<span class='msk'>Cronograma</span>");
                }, function () {
            $('.msk').remove();
        }
        );

        $(".pago_cronog").click(function () {

            var idperfil = $('#idperfil').val();

            if (idperfil == 1 || idperfil == 4 || idperfil == 3) {
                var idprocventa = $(this).attr('id');
                var sep = idprocventa.split(',');

                idve = sep[0];
                idprodni = sep[1];


                $.post('../web/index.php', 'controller=cobranza&action=cronograma&idve=' + idve + '&idprodni=' + idprodni + '&cond=1', function (data) {
                    console.log(data);
                    $("#cronogra").empty().append(data);
                });

                $("#cronogra").dialog("open");
            } else {
                alert("USTED NO TIENE PERMISO PARA ESTA OPERACIÓN...Pida ayuda a su Administrador");
            }
        });
        ////.....................


        $(".enco_cobr").click(function () {
            //   alert($(this).attr("id"));

            $.post('../web/index.php', 'controller=cobranza&action=buscavendedorid&idvende=' + $(this).attr("id"), function (data) {
                console.log(data);
                alert("VENDEDOR: " + data.vendedor);

            }, 'json');

        });


        $("#dialogo3").dialog({
            autoOpen: false,
            width: 500,
            height: 480,
            show: "scale",
            hide: "scale",
            resizable: "false",
            position: "center",
            modal: "true"


        });
        $("#crono").dialog({
            autoOpen: false,
            width: 800,
            height: 600,
            show: "scale",
            hide: "scale",
            resizable: "false",
            position: "center",
            modal: "true"


        });

        $("#cronogra").dialog({
            autoOpen: false,
            width: 1000,
            height: 600,
            show: "scale",
            hide: "scale",
            resizable: "false",
            position: "center",
            modal: "true"


        });

        $('.eliminapago').click(function () {

            var str = $(this).attr("idpago");
            var res = str.split(",");
            idpago = res[0];
            monto = res[1];
            idventaa = res[2];
            valor = $(this).attr("valor");
            var dni_a = $('#dni_cliente').val();
            if (confirm('¿Estas seguro de Eliminar?')) {
                $("#msg").html('<strong style="color:blue">Guardando ....</strong>');
                $.post('../web/index.php', 'controller=cobranza&action=elimina_pago&idpago=' + idpago + '&monto=' + monto + '&idventaa=' + idventaa + '&dni_a=' + dni_a, function (data) {
                    console.log(data);
                    $("#msg").html('');
                });
                $.post('../web/index.php', 'controller=cobranza&action=cargar_datos_formulario_detalle&idcliente=' + dni_a, function (data) {
                    console.log(data);
                    $("#detalle").empty().append(data);
                });

                $('.' + id).html(saldo);
            } else {

            }

        });


        $('.actualizapago').click(function () {
            idpago = $(this).attr("idpago");
            alert(idpago);
            exit;
            //valor = $(this).attr("valor");
            var dni_a = $('#dni_a').val();

            if (confirm('¿Estas seguro de Eliminar?')) {
                $("#msg").html('<strong style="color:blue">Guardando ....</strong>');
                $.post('../web/index.php', 'controller=cobranza&action=elimina_pago&idpago=' + idpago, function (data) {
                    console.log(data);
                    $("#msg").html('');
                });
                //                $.post('../web/index.php', 'controller=cobranza&action=formulario_acuerdo_detall&idcliente=' + dni_a, function(data) {
                //                    console.log(data);
                //                    $("#detall_acuerdo").empty().append(data);
                //                });
            } else {

            }

        });


    });





</script>

<!--<div id="b1" class="boton">Dialogo modal</div>
<div id="b2" class="boton">Dialogo no modal</div>
<div id="b3" class="boton">Otra animación</div>
-->

<div id="dialogo" class="ventana" title="Dialogo Modal">

    <p>Esto es un dialogo modal, por lo que la web queda bloqueada mientras esta abierta</p>

</div>
<!-- modal pra cambiar de planilla a directo y visiversa-->

<div id="dialogo3" class="ventana"  title="Actualizar Pagos">

</div>
<div id="crono" class="ventana"  title="REPORTE PAGOS"></div>
<div id="cronogra" class="ventanax"  title="CRONOGRMA PAGOS"></div>





<div id="dialogofoto" title="FOTOS"></div>
<!-- inicio del div o ventana modal -->

<div id="detalle_formulario">
    <table class="container_table" border="1" style="margin-bottom: 20px;">
        <tr style=" background: #0080d2;"><td colspan="10">CREDITOS PENDIENTES</td></tr>
        <tr style=" background: #D5DA8C;">
            <td>N°</td>
            <td>FECHA IP</td>
            <td>CREDITO</td>
            <td>CUOTA</td>
            <td>TIEMPO</td>
            <td>AMORTIZACION</td>
            <td>SALDO</td>
            <td>PRODUCTO</td>
            <td>CONDICION</td>
            <td>ACCION</td>
        </tr>

        <?php
        $sumaApt = 0;
        $saldoL = 0;
        $cont = 0;
        $conta = 0;
        $conta1 = 0;
        $conta11 = 0;
        $sumacred = 0;
        $sumaamo = 0;

        foreach ($rows as $key => $data):
            $conta = $conta + 1;
            $sumacred = round($sumacred + $data['credito'], 2);
            ?>
            <tr>
                <td class="" ><b><?php echo $conta ?></b>     <?php if ($data['fecha_mov'] == date("Y-m-d") AND ( ($_SESSION['idperfil'] == 1 OR $_SESSION['idperfil'] == 4))) { ?>
                        <span class="glyphicon glyphicon-trash eliminapago" vidpago="<?php echo $data['idproceso_cobro'] + "," + $data['abono'] ?>"></span>
                   <!--<span class="glyphicon glyphicon-trash actualizapago" idpago="<?php //echo $data['idproceso_cobro']                ?>"></span>-->
                    <?php } ?>  </td>

                <td class="enco_cobr" id="<?php echo $data['idpersonal'] ?>"><b><?php echo $data['a_partir_de'] ?></b></td>
                <td class="" <?php echo "id='" . $data['idproceso_cobro'] . "," . $data['credito'] . "," . $data['letra'] . "," . $data['a_partir_de'] . "," . $data['num_cuotas'] . "'" ?> style="color:  #d14; cursor: pointer " >

                    <b><?php echo $data['credito'] ?></b></td>
                <td class="" ><b><?php echo $data['letra'] ?></b></td>
                <td><b><?php echo $data['tiempo'] ?></td>
                <td class="" style="color:rgb(56, 108, 187)" ><b><?php echo $data['abono'] ?></b> </td>
                <td class="" <?php echo "id='" . $data['idproceso_cobro'] . "," . $data['cond_pago'] . "'" ?> style="color: #d14;cursor:  pointer" >
                    <b> <?php echo $data['saldo'] ?> </b></td>
                <td class=" produ" style="color:  cornflowerblue" id="<?php echo $data['idproceso_cobro'] ?>" ><b><?php echo $data['producto'] ?></b> </td> 
                <td class="" <?php echo "id='" . $data['idproceso_cobro'] . "," . $data['cond_pago'] . "'" ?> style="color: #d14;cursor:  pointer" >
                    <b> <?php echo $data['cond_pago'] ?> </b></td>
                <td>
                    <span class="glyphicon glyphicon-edit editventa"  <?php echo "id='" . $data['idproceso_cobro'] . "," . $data['dni'] . "'" ?>  style="background:#F39814" ></span>
                    <span class="glyphicon glyphicon-list-alt cronogr" <?php echo "id='" . $data['idproceso_cobro'] . "," . $data['dni'] . "'" ?>  style="background:#F39814"></span>
                    <span class="glyphicon glyphicon-folder-open pago_cronog" <?php echo "id='" . $data['idproceso_cobro'] . "," . $data['dni'] . "'" ?>  style="background:#F39814"></span>

                </td>
            </tr>

        <?php endforeach; ?>
<!--      <tr>
      <td colspan="7"></td>
      <td> <button class="btn btn-info btn-sm"><span class="glyphicon glyphicon-pencil  "></span>Editar</button></td>
      <td> <button class="btn btn-success btn-sm"  id="new_venta" title="Nueva Venta" data-toggle="modal" data-target="#MyModal_bt4"><span class="glyphicon glyphicon-pencil  "></span>Historial</button></td>
  </tr>-->
    </table>


    <table class="container_table" >
        <tr style="background:#0080d2"><td colspan="6">ULTIMOS PAGOS POR PRODUCTO</td></tr>
        <tr style=" background: #D5DA8C;">
            <td>N°</td>
            <td>FECHA</td>
            <td>AMORTIZACION</td>
            <td>TIPO DODUMENTO</td>
            <td>PRODUCTO</td>
            <td>COBRADOR</td>

        </tr>    

        <?php
        foreach ($rows2 as $key => $data):

            $conta11 = $conta11 + 1;
            $sumaamo = round($sumaamo + $data['abonar'], 2);
            ?>
            <tr>
                <?php if ($data['fecha_mov'] == date("Y-m-d") AND ( ($_SESSION['idperfil'] == 1 ))) {
                    ?>

                    <td class="" style="background:#F39814"><?php echo $conta11 ?>
                        <span class="glyphicon glyphicon-trash eliminapago" idpago="<?php echo $data['idproceso_cobro'] . "," . $data['abonar'] . "," . $data['idventa'] ?>" style="background:#F39814"></span>

                    </td>	
                    <?php } elseif ($_SESSION['idperfil'] == 4) {
                    ?>
                    <td class="" style="background:#F39814"><?php echo $conta11 ?>
                        <span class="glyphicon glyphicon-trash eliminapago" idpago="<?php echo $data['idproceso_cobro'] . "," . $data['abonar'] . "," . $data['idventa'] ?>" style="background:#F39814"></span>

                    </td>   
                <?php } else {
                    ?>
                    <td class="" ><?php echo $conta11 ?> </td>
    <?php } ?>  

                <td class="enco_cobr" id="<?php echo $data['idpersonal'] ?>" ><?php echo $data['fecha_mov'] ?></td>
                <td class="" ><?php echo $data['abonar'] ?></td>
                <td class="" ><?php echo $data['nro_recibo'] ?></td>
                <td class="" ></td>

                <td class="" > </td>
                <td></td>
            </tr>

            <?php
        endforeach;
        ?>

</div>
<script>
    $("#tocredito").html("<?php echo "CREDITO: S/. " . $sumacred ?>");
    $("#toamo").html("<?php echo "ABONAR: S/. " . round($sumaamo, 2) ?>");
    $("#tosaldo").html("<?php echo "SALDO: S/. " . round(($sumacred - $sumaamo), 2) ?>");

</script>
        <!--<script>$("#total_prestamo").html("Éste Cliente Tiene:  "+<?php //echo $cont                     ?>+"  Creditos")</script>-->