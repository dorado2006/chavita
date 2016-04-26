<style>
    #feedback { font-size: 1.4em; }
    #selectable .ui-selecting { background: #FECA40; }
    #selectable .ui-selected { background: #F39814; color: white; }
    #selectable { list-style-type: none; margin: 0; padding: 0; }
    #selectable li { margin: 3px; padding: 0.4em;  }
    #leftcolumn_menu ol li:hover{cursor: pointer;color:#fff;background-image: url("../web/img/menu2.png");}

    .focused {
        border: 1px solid green;
    }
    .anula{border: 1px solid red;}
    .actualizar_cliente tr td{padding-top: 20px}

</style>
<script>
    var id;
    var saldo;
    var letra;
    var nombres;
    $(function () {

        $("#fecha_pago").datepicker({'dateFormat': 'yy-mm-dd'});

        $(".idcliente").click(function () {
            $(".idcliente").removeClass("ui-selected");
            $(this).addClass("ui-selected");
            var id_saldo = $(this).attr("name");

            var separador = id_saldo.split(",");
            id = separador[0];
            saldo = separador[1];
            letra = separador[2];
            nombres = separador[3];


            //$('#imprimir_p').prop('href', 'index.php?controller=cobranza&action=imprimir_cronograma&idprodni=' + id);
            $('#saldoC').html(saldo);
            $('#saldoL').html(letra);
            $('#dni_cliente').val(id);

            $.post('../web/index.php', 'controller=cobranza&action=cargar_datos_formulario&idcliente=' + id, function (data) {
                console.log(data);
                $("#content_menu_datos").empty().append(data);
            });
            $.post('../web/index.php', 'controller=cobranza&action=cargar_datos_formulario_detalle&idcliente=' + id, function (data) {
                console.log(data);
                $("#detalle").empty().append(data);
            });
            $.post('../web/index.php', 'controller=cobranza&action=formulario_editar_cliente&idcliente=' + id, function (data) {
                console.log(data);
                $("#editar_cliente").empty().append(data);
            });
            $.post('../web/index.php', 'controller=cobranza&action=formulario_nueva_venta&idcliente=' + id, function (data) {
                console.log(data);
                $("#Nueva_Venta").empty().append(data);
            });
            $.post('../web/index.php', 'controller=cobranza&action=formulario_acuerdo&idcliente=' + id, function (data) {
                console.log(data);
                $("#acuerdos").empty().append(data);
            });

        });


        $("#buscador").keyup(
                function ()
                {
                    var param = $("#buscador").attr("value");
                    $(".leftcolumn_menu").load('../app/vista/cobranza/busqueda.php', {parametro: param});

                });


        $("#editar").click(function () {
            idcliente = $("#idcliente").val();
            if (idcliente == "") {
                document.getElementById('cliente').style.border = '1px  solid red';
            }
            else {
                popup('index.php?controller=cliente&action=edit&id=' + idcliente, 860, 500);
            }
        });

        $("#pagoL").keyup(function () {
            //$("#pagoC").val("");
            var amrt = $(this).val();

            var sal_let = letra - amrt;
            var descC = saldo - amrt;
            var descL = saldoL - amrt;
            $('#descL1').val(sal_let);
            $('#descC1').val(descC);
            $('#descC').html(descC);
            $('#descL').html(sal_let);

        });
        $("#pago_letr").keyup(function () {
            pago_letr = $("#pago_letr").val();
            var restoC = saldo - pago_letr;
            $('#descC').html(restoC);


        });


        $("#nuev_pago111").click(function () {
            var dni = $('#dni_cliente').val();

            if (dni == "") {
                alert("Selecione un Cliente");
                $('#myModal1').modal('toggle');
            }
            else {
                var idperfil = $('#idperfil').val();
                if (idperfil == 1 || idperfil == 4) {
                    return true;

                }
                else {
                    alert("USTED NO TIENE PERMISO PARA ESTA OPERACIÓN...Pida ayuda a su Administrador");
                    $('#myModal1').modal('toggle');
                }
            }
        });
        $("#nv_cliente").click(function () {

            var idperfil = $('#idperfil').val();
            if (idperfil == 1 || idperfil == 4) {

                $.post('../web/index.php', 'controller=cobranza&action=formulario_nuevo_cliente', function (data) {
                    console.log(data);
                    $("#divnvo_cliente").empty().append(data);
                    $('#MyModal_bt1nv').modal('show');
                });

            }
            else {
                alert("USTED NO TIENE PERMISO PARA ESTA OPERACIÓN...Pida ayuda a su Administrador");
                $('#MyModal_bt1nv').modal('toggle');



            }

        });


        $("#editar_cl").click(function () {
            var dni = $('#dni_cliente').val();

            if (dni == "") {
                alert("Selecione un Cliente");
                $('#MyModal_bt1').modal('toggle');
            }
            else {
                var idperfil = $('#idperfil').val();
                if (idperfil == 1 || idperfil == 3 || idperfil == 4) {
                    return true;
                }
                else {
                    alert("USTED NO TIENE PERMISO PARA ESTA OPERACIÓN...Pida ayuda a su Administrador");
                    $('#MyModal_bt1').modal('toggle');
                }
            }
        });

        $("#new_venta").click(function () {
            var dni = $('#dni_cliente').val();

            if (dni == "") {
                alert("Selecione un Cliente");
                $('#MyModal_bt4').modal('toggle');
            }
            else {
                var idperfil = $('#idperfil').val();
                if (idperfil == 1 || idperfil == 4) {
                    return true;
                }
                else {
                    alert("USTED NO TIENE PERMISO PARA ESTA OPERACIÓN...Pida ayuda a su Administrador");
                    $('#MyModal_bt4').modal('toggle');
                }
            }
        });

        $("#bt_nuev_acuerdo").click(function () {
            var dni = $('#dni_cliente').val();
            $('#dni_a').val(dni);
            if (dni == "") {
                alert("Selecione un Cliente");
                $('#MyModal_acuerdo').modal('toggle');
            }
            else {
                var idperfil = $('#idperfil').val();
                if (idperfil == 1 || idperfil == 3 || idperfil == 4) {
                    return true;
                }
                else {
                    alert("USTED NO TIENE PERMISO PARA ESTA OPERACIÓN...Pida ayuda a su Administrador");
                    $('#MyModal_acuerdo').modal('toggle');
                }


            }
        });


        $("#nuev_Reprogramcion").click(function () {
            var dni = $('#dni_cliente').val();
            if (dni == "") {
                alert("Selecione un Cliente");
                $('#myModal2').modal('toggle');
            }
        });




        $('.focused').focus();

// actual code
        $(document).keydown(function (e) {
            if (e.keyCode == 38) { // left
                if ($('.focused').prev('.focusable').length)
                    $('.focused').removeClass('focused').prev('.focusable').focus().addClass('focused');
            }
            if (e.keyCode == 40) { // right
                if ($('.focused').next('.focusable').length)
                    $('.focused').removeClass('focused').next('.focusable').focus().addClass('focused');
            }
        });
//-----------------------------nuevo pago-----------------------
        $('#nuev_pago').click(function () {

            var dni = $('#dni_cliente').val();

            if (dni == "") {
                alert("Selecione un Cliente");

            }
            else {
                var idperfil = $('#idperfil').val();
                if (idperfil == 1 || idperfil == 4) {
                    idproducto = $(this).attr("id");
                    $.post('../web/index.php', 'controller=cobranza&action=pagos&dni=' + dni, function (data) {
                        console.log(data);
                        $("#for_pago").empty().append(data);
                    });

                    // window.open('../app/vista/cobranza/viewfoto.php','','width=800,height=600,left=50,top=50,toolbar=yes');
                    $("#for_pago").dialog("open");

                }
                else {
                    alert("USTED NO TIENE PERMISO PARA ESTA OPERACIÓN...Pida ayuda a su Administrador");

                }
            }


        });
        $("#for_pago").dialog({
            autoOpen: false,
            width: 500,
            height: 350,
            show: "scale",
            hide: "scale",
            resizable: "false",
            position: "center",
            modal: "true"


        });

        //----------------------------------------



    });
//07090972
    function ponerCeros(obj) {

        while (obj.value.length < 6)
            obj.value = '0' + obj.value;
    }
//    
//    function mayuscula(campo){
//        
//                $(campo).keyup(function() {
//                               $(this).val($(this).val().toUpperCase());
//                });
//    }
//    onkeyup="this.value=this.value.toUpperCase()" 


</script>
<div id="for_pago" title="NUEVO PAGO"></div>

<!--varibles ineditas-->
<input type="hidden" id="idperfil" value="<?php echo $_SESSION['idperfil'] ?>">
<input type="hidden" name="dni_cliente" id="dni_cliente" value="">

<!-- modal de Pagos-->
<div class="modal fade" id="myModal1qwt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2">---</h4>
            </div>
            <div class="modal-body">
                <div id="div_info"></div>

                <!-- aqui  cuerpo del modal-->  

            </div> <!-- termina el body -->                   
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- fin del div o ventana modal -->
<!-- Fin modal de Pagos-->


<!-- modal de  Reprogramcion-->

<div id="editar_cliente">
    <!-- En este div cargar el formulario ;para actualizar Cliente-->
</div>
<!-- Inicio de Modal de nueva venta -->
<div id="Nueva_Venta">
    <!-- En este div cargar el formulario ;para Realizar nueva venta de clientes previamente inscritos-->   
</div>
<div id="divnvo_cliente">   
</div>

<div id="acuerdos">   
</div>




<!-- fin del div o ventana modal -->
<!-- Fin modal de Reprogrmar-->

<div id="leftcolumn">
    <div class="input-group" id="lefenabezado" style="height: 10%">

        (Nombre/AP/DNI)[<font size="3" color="red">ANUL</font>][<font size="3" color="green">CANC</font>]
        <input type="search"  size="30" placeholder="Buscar Apellido" id="buscador" >&nbsp;
        <button class="btn btn-warning btn-sm"   id="nv_cliente" ><span class="glyphicon glyphicon-plus-sign  ">&nbsp;NUEVO</span></button>

        <!---->
        <div id="resultado" style="border: solid black 1px;"></div>

    </div>
    <div>
        <div id="lefnombres">Nombres</div><div id="lefsaldo">Saldo</div>

    </div>
    <!--HHHH.............................-------------------------->
    <div class="leftcolumn_menu" id="leftcolumn_menu">
        <ol  id="selectable" >
            <?php
            $num_cli = 0;
            $sum_saldo = 0;
            foreach ($rows as $key => $data):
                if (!empty($rows)) {
                    $saldo = round(($data['credito'] - $data['abonar']), 2);
                    $num_cli = $num_cli + 1;
                    if ($saldo <= 0) {
                        ?>
                        <li class="idcliente sugerencias focused ui-widget-content"  >                    
                            <span   id="sugerencias1">
                                <?php echo "<a  name='" . $data['dni'] . "," . $saldo . "' class='idcliente' id='linkmodi'> " . strtoupper(utf8_encode($data['nombres'])) . "</a>"; ?></span>
                            <span id="sugerencias2"><?php echo $saldo; ?></span>      
                        </li>
                        <?php
                    } else {

                        if ($data['cond_pago'] == 'ANULADO') {
                            ?>
                            <li class="idcliente sugerencias anula ui-widget-content"  >                    
                                <span   id="sugerencias1">
                                    <?php echo "<a  name='" . $data['dni'] . "," . $saldo . "' class='idcliente' id='linkmodi'> " . strtoupper(utf8_encode($data['nombres'])) . "</a>"; ?></span>
                                <span id="sugerencias2"><?php echo $saldo; ?></span>      
                            </li>

                            <?php
                        } else {
                            ?>

                            <li class="idcliente  focusable  sugerencias ui-widget-content " <?php echo "name='" . $data['dni'] . "," . $saldo . "," . $data['letra'] . "," . $data['nombres'] . "'"; ?> >

                                <span   id="sugerencias1">
                                    <?php echo strtoupper(utf8_encode($data['nombres'])); ?></span>

                                <span id="sugerencias2" class="<?php echo $data['dni']; ?>" ><?php echo $saldo; ?>
                                    <input type="hidden" name="cond_pago" class="cond_pago" value="<?php echo $data['cond_pago']; ?>">   
                                </span>      

                            </li>
                            <?php
                            $sum_saldo = $sum_saldo + $saldo;
                        }
                    }
                } else {
                    echo 'Noy Datos Para Mostrar';
                }
            endforeach;
            ?>

        </ol>
    </div>

    <div style="height: 10%"><div id="lefnombres">(<?php echo $num_cli; ?>) Clientes</div><div id="lefsaldo"><?php echo round($sum_saldo, 2) ?></div></div>

</div>

<!-- end: columna izquierda  -->		 
<!-- contenido -->
<div id="ringtderechacolum">
    <div id="content_menu"> 
        <button class="btn btn-info btn-sm"  id="editar_cl" title="Editar Cliente" data-toggle="modal" data-target="#MyModal_bt1"><span class="glyphicon glyphicon-pencil  "></span>EDITAR CLIENTE</button>
        <!--<button type="button" title="editar"   id="editar" name="editar" class="btn btn-info glyphicon glyphicon-pencil ">Editar Cliente</button>--> 
        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal1xx" id="nuev_pago" ><span class="glyphicon glyphicon-usd  "></span>NUEVO PAGO</button>
        <button class="btn btn-info btn-sm"  id="bt_nuev_acuerdo" title="Editar Cliente" data-toggle="modal" data-target="#MyModal_acuerdo"><span class="glyphicon glyphicon-pencil  "></span>ACUERDOS</button>
        <button class="btn btn-info btn-sm"  id="new_venta" title="Nueva Venta" data-toggle="modal" data-target="#MyModal_bt4"><span class="glyphicon glyphicon-pencil  "></span>NUEVA VENTA</button>

        <a class="btn btn-info btn-sm " id="imprimir" href=""><span class="glyphicon glyphicon-print  "></span> IMPRIMIR ESTADO</a>
        <a class="btn btn-info btn-sm geoloco" id="tierra" href=""><span class="glyphicon glyphicon-globe  "></span>  MAPA</a>
        <a class="btn btn-info btn-sm subfoto" id="subfoto" href=""><span class="glyphicon glyphicon-globe  "></span>  foto</a>


    </div>
    <div id="content_menu_datos">

        <table border="0" style="font-size: 15px;font-family: Times New Roman">
            <tr><td width="50%">

                    <label  for="nombres">CLIENTE</label>
                </td>
                <td>
                    <input type="text" placeholder="Nombres" name="nombres" id="nombres"  size="45" >     
                </td>
                <td>&nbsp;&nbsp;</td>
                <td width="15%">
                    <label  for="direccion">DOMICILIO</label>
                </td>
                <td>
                    <input type="text" placeholder="Direccion" name="direccion" id="direccion"  size="50" >
                </td>
            </tr>
            <tr>

                <td><label  for="dni">DNI</label></td>
                <td><input type="text" placeholder="dni" name="dni" id="dni"   size="45"></td>
                <td></td>
                <td><label  for="telf">TELEFONOS</label></td>
                <td><input type="text" placeholder="Telefonos" name="telf" id="telf"  size="50">
                </td>

            </tr>
            <tr>

                <td><label  for="lugar_tarabajo">LABORA</label></td>
                <td> <input type="text" placeholder="Lugar Trabajo" name="lugar_tarabajo"   size="45" id="lugar_tarabajo">
                </td>
                <td></td>
                <td>  <label  for="direcion_tra">DIRECCIÓN</label>
                </td>
                <td> <input type="text" placeholder="Direccion de trabajo" name="direcion_tra"   size="50" id="direcion_tra">
                </td>
            </tr> 
            <tr>
                <td ><label>TIPO DE SERVIDOR:</label></td>
                <td style="color:  #D65417;  font-size: 20px;padding-left: 2%" ></td>
                <td></td>
                <td style="color:  #d14;  font-size: 20px">
                    <div class="calificacion"  style="color: #d14" >
                        <b> CALIFICACIÓN</b></div>
                </td>
                <td  style="color:  #D65417; font-size: 20px;padding-left: 1%">
                </td>
            </tr>

        </table>
    </div>
    <div id="content">


        <div id="detalle">
            <!--        <div class="encab1">Fecha</div>	
                  <div class="encab2">Credito</div>
                  <div class="encab3">Descuento</div>
                  <div class="encab4">Saldo</div>
                  <div class="encab5">Obsevación</div>
                  <div class="encab6">sss</div>-->


        </div>

        <table style="width: 100%; border: 2px solid #002a80; padding-right: 17px ;float: left ; background-color: #000000;color:  #ffffff ">

            <tr>
                <td class="encab2">TOTALES</td>
                <td  id="tocredito"> </td>

                <td  id="toamo"> </td>
                <td id="tosaldo"> </td>

            </tr>
        </table>
    </div>






</div>
</div>
<!-- end: contenido -->	
<!-- modales -->

<!-- fin de modales -->

