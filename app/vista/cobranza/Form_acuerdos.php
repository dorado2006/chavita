<script>
    $(function () {
        $("#fecha_visita").datepicker({'dateFormat': 'yy-mm-dd'});
        $("#fecha_limite").datepicker({'dateFormat': 'yy-mm-dd'});
        $("#hora").timepicker();
        $('#btn_acep_acue').click(function () {


            var d = new Date();

            var month = d.getMonth() + 1;
            var day = d.getDate();

            var output = d.getFullYear() + '-' +
                    (('' + month).length < 2 ? '0' : '') + month + '-' +
                    (('' + day).length < 2 ? '0' : '') + day;

            var min_fecha = $('#fecha_limite').val();
            var f1 = $('#fech0').val();
            var f2 = $('#fech1').val();
            var f3 = $('#fech2').val();


            if (min_fecha < output) {
                alert("LA FECHA PAGO ES MENOR DE LO ACTUAL");
                exit;
            }
            if (min_fecha == f1 || min_fecha == f2 || min_fecha == f3) {
                alert("YA EXISTE UNA FECHA = FECHA PAGO");
                exit;
            }
            var dataString = $('#form_nuv_acuerdo').serialize();
            var dni_a = $('#dni_a').val();

            // alert('Datos serializados: ' + dataString);
            $.post('../web/index.php', dataString, function (data) {
                console.log(data);
                //$("#detalle").empty().append(data);
            });
            //$('#MyModal_acuerdo').modal('toggle');

            $.post('../web/index.php', 'controller=cobranza&action=formulario_acuerdo_detall&idcliente=' + dni_a, function (data) {
                console.log(data);
                $("#detall_acuerdo").empty().append(data);
            });
            //$('#cuerpo_acuerdo').hide();
            $('#MyModal_acuerdo').modal('toggle');

        });
        $('.calificar_radius').click(function () {
            var dni_a = $('#dni_a').val();
            idacuerdo = $(this).attr("idacuerdo");
            valor = $(this).attr("valor");
            $("#msg").html('<strong style="color:blue">Guardando ....</strong>');
            $.post('../web/index.php', 'controller=cobranza&action=actualizar_acuerdo&idacuerdo=' + idacuerdo + '&valor=' + valor + '&idcliente=' + dni_a, function (data) {
                console.log(data);
                $("#msg").html('');
                $("#detall_acuerdo").empty().append(data);
            });

        });

        $('.eliminacuerdo').click(function () {
            idacuerdo = $(this).attr("idacuerdo");
            valor = $(this).attr("valor");
            var dni_a = $('#dni_a').val();

            if (confirm('¿Estas seguro de Eliminar?')) {
                $("#msg").html('<strong style="color:blue">Guardando ....</strong>');
                $.post('../web/index.php', 'controller=cobranza&action=elimina_acuerdo&idacuerdo=' + idacuerdo + '&valor=' + valor, function (data) {
                    console.log(data);
                    $("#msg").html('');
                });
                $.post('../web/index.php', 'controller=cobranza&action=formulario_acuerdo_detall&idcliente=' + dni_a, function (data) {
                    console.log(data);
                    $("#detall_acuerdo").empty().append(data);
                });
            } else {

            }

        });

        $('#form-field-9').keyup(function () {
            var chars = $(this).val().length;
            var diff = 100 - chars;
            $('#conteo').html(diff + "/100")
        });

        $('#new_acuerdo').click(function () {
            $('#cuerpo_acuerdo_uni').hide();
            var bandera = $("#bandera").val();
            if (bandera == 'ok') {
                alert('LE FALTA CALIFICAR EL ULTIMO ACUERDO');

            } else {
                $('#cuerpo_acuerdo').show();
            }

        });

        $('#unir_acuerdo').click(function () {
            $('#cuerpo_acuerdo').hide();
            $('#cuerpo_acuerdo_uni').show();
        });

        $('#btn_acep_acue_uni').click(function () {
            var unir = $('#frecuencia_msg_uni').val();
            var dni = $('#dni_a').val();
            $.post('../web/index.php', 'controller=cobranza&action=unir_acuerdos&unir=' + unir + '&dni=' + dni, function (data) {
                console.log(data);
                // $("#detall_acuerdo").empty().append(data);
            });
            $('#MyModal_acuerdo').modal('toggle');
        });
        $('#baja').click(function () {

            var dni = $(this).val();

            if ($(this).attr('checked')) {
                $.post('../web/index.php', 'controller=cobranza&action=acuerdocambiaestado&estado=1&dni=' + dni, function (data) {
                    console.log(data);
                    // $("#detall_acuerdo").empty().append(data);
                    if (data.resp == 1) {
                        alertify.success(data.msg);

                    }
                  
                }, 'json');
            } else {
                $.post('../web/index.php', 'controller=cobranza&action=acuerdocambiaestado&estado=0&dni=' + dni, function (data) {
                    console.log(data);
                    // $("#detall_acuerdo").empty().append(data);
                    if (data.resp == 0) {
                        alertify.error(data.msg);

                    }
                  
                }, 'json');
            }

        });


        $('#recarga_acuerdo').click(function () {
            var bandera = $("#bandera").val();
            if (bandera == 'ok') {
                alert('LE FALTA CALIFICAR EL ULTIMO ACUERDO');
                exit;
            } else {
                //$('#cuerpo_acuerdo').show();   

                var dataString = $('#form_nuv_acuerdo').serialize();
                var dni_a = $('#dni_a').val();
                // alert('Datos serializados: ' + dataString);
                $.post('../web/index.php', dataString + '&bot_reg=re', function (data) {
                    console.log(data);
                    //$("#detalle").empty().append(data);
                });
                //$('#MyModal_acuerdo').modal('toggle');

                $.post('../web/index.php', 'controller=cobranza&action=formulario_acuerdo_detall&idcliente=' + dni_a, function (data) {
                    console.log(data);
                    $("#detall_acuerdo").empty().append(data);
                });
                $('#MyModal_acuerdo').modal('toggle');
            }

        });
    });
</script>


<form id="form_nuv_acuerdo" method="post">
    <input type="hidden" name="controller" value="cobranza" />
    <input type="hidden" name="action" value="nuevo_acuerdo" />
    <input type="hidden" name="dni_a"  id="dni_a" value="" />
    <!-- Inicio de Modal de Editar Cliente -->
    <div class="modal fade " id="MyModal_acuerdo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true" >
        <div class="modal-dialog modal-x-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel2">Acuerdos 
                        <button class="btn btn-info btn-sm"  id="new_acuerdo" title="Nuevo Acuerdo" data-toggle="modal" data-target="#MyModal_acuerdo111" ><span class="glyphicon glyphicon-pencil  "></span>Nuevo</button>
                        <button class="btn btn-info btn-sm"  id="recarga_acuerdo" title="GENERE EL EL ACUERDO,EXEPCION DE FRECUENCIA VARIADO" data-toggle="modal" data-target="#MyModal_acuerdo111"><span class="glyphicon glyphicon-pencil  "></span>Recargar Acuerdo</button>
                        <button class="btn btn-danger btn-sm"  id="unir_acuerdo" title="PUEDE UNIR LOS ACUERDOS EN UNO SOLO" data-toggle="modal" data-target="#MyModal_acuerdo111"><span class="glyphicon glyphicon-magnet  "></span>UNIR  Acuerdo</button>
                        <label>BAJA</label><input type="checkbox" name="chechc" id="baja" value="<?php echo $rows[0]['dni'] ?>" <?php echo $rows[0]['estadoo'] ?>>

                    </h4>
                </div>
                <div class="modal-body" >
                    <div id="cuerpo_acuerdo" style="display:none">
                        <table border="1" width="100%" id="actualizar_cliente" class="actualizar_cliente table"  style="background: #dff0d8;font-size: 15px;font-family: Times New Roman">
                            <tr >
                                <td colspan="7" style=" background-color:  #FACAAD"><b>Datos del Nuevo Acuerdo</b></td>
                            </tr>
                            <tr><td><b>ACUERDO</b></td>
                                <td ><b>FRECUENCIA</b> </td>
                                <td><b>PAGO EN:</b></td> 
                                <td><b>FECHA VISITA</b>   
                                <td><b>FECHA PAGO</b> 
                                <td><b>HORA</b> </td> 
                                <td ><B>FUENTE</b></td>

                            </tr>
                            <tr>


                                <?php
                                $ab = 0;
                                foreach ($rows as $key => $data): $ab = 1;
                                    ?>
                                    <td>


                                        <textarea size = "10" name = "txtacuerdo"><?php echo $data['acuerdos'];
                                    ?></textarea>
                                    </td>



                                    <td>
                                        <select name="frecuencia_msg" style="background-color: rgb(239, 244, 165)">
                                            <?php if ($data['frecuencia_msj'] == 'DIARIO') { ?>
                                                <option selected="selected">DIARIO</option> 
                                                <option >SEMANAL</option>
                                                <option >QUINCENAL</option> 
                                                <option >MENSUAL</option> 
                                            <?php } ?>


                                            <?php if ($data['frecuencia_msj'] == 'SEMANAL') { ?>
                                                <option selected="selected">SEMANAL</option> 
                                                <option >DIARIO</option>
                                                <option >QUINCENAL</option> 
                                                <option >MENSUAL</option> 
                                            <?php } ?>
                                            <?php if ($data['frecuencia_msj'] == 'QUINCENAL') { ?>
                                                <option selected="selected">QUINCENAL</option> 
                                                <option >SEMANAL</option>
                                                <option >DIARIO</option> 
                                                <option >MENSUAL</option> 
                                            <?php } ?>
                                            <?php if ($data['frecuencia_msj'] == 'MENSUAL') { ?>
                                                <option selected="selected">MENSUAL</option> 
                                                <option >SEMANAL</option>
                                                <option >QUINCENAL</option> 
                                                <option >DIARIO</option> 
                                            <?php } else {
                                                ?>
                                                <option >DIARIO</option> 
                                                <option >SEMANAL</option>
                                                <option >MENSUAL</option>                                                 
                                                <option >QUINCENAL</option
                                            <?php }
                                            ?>


                                        </select>

                                    </td>
                                    <td>
                                        <select name="pagoen" style="background-color: rgb(239, 244, 165)">

                                            <?php if ($data['pagoen'] == 'OFICINA') { ?>
                                                <option selected="selected">OFICINA</option>
                                                <option>CASA</option>
                                                <option>TRABAJO</option>
                                                <option>BANCO</option>
                                            <?php } ?>

                                            <?php if ($data['pagoen'] == 'CASA') { ?>
                                                <option>OFICINA</option>
                                                <option selected="selected">CASA</option>
                                                <option>TRABAJO</option>
                                                <option>BANCO</option>
                                            <?php } ?>

                                            <?php if ($data['pagoen'] == 'TRABAJO') { ?>
                                                <option>OFICINA</option>
                                                <option>CASA</option>
                                                <option selected="selected">TRABAJO</option>
                                                <option>BANCO</option>
                                            <?php } ?>

                                            <?php if ($data['pagoen'] == 'BANCO') { ?>
                                                <option>OFICINA</option>
                                                <option>CASA</option>
                                                <option>TRABAJO</option>
                                                <option selected="selected">BANCO</option>
                                            <?php } else {
                                                ?>
                                                <option>OFICINA</option>
                                                <option>CASA</option>
                                                <option>TRABAJO</option>
                                                <option>BANCO</option>
                                            <?php }
                                            ?>


                                        </select>   

                                    </td>

                                    <td>
                                        <input type="text" name="fecha_visita" id="fecha_visita"  value="<?php echo date("Y-m-d"); ?>"  size="10"> 
                                    </td>
                                    <td>
                                        <input type="text" name="fecha_limite" id="fecha_limite"  value="<?php echo date("Y-m-d"); ?>" size="10">
                                    </td>

                                    <td>
                                        <!--<input type="text"  id="hora"  size="5">-->
                                        <select name="hora" >

                                            <option >AM</option>
                                            <option>PM</option>
                                            <option>PD</option>   



                                        </select> 

                                    </td>


                                    <td >

                                        <?php print_r($personal) ?>

                                    </td>
                                    <?php
                                    break;
                                endforeach;
                                if ($ab == '0') {
                                    ?>


                                    <td>


                                        <textarea size = "10" name = "txtacuerdo"><?php echo $data['acuerdos'];
                                    ?></textarea>
                                    </td>



                                    <td>
                                        <select name="frecuencia_msg" style="background-color: rgb(239, 244, 165)">

                                            <option selected="selected">DIARIO</option> 
                                            <option >SEMANAL</option>
                                            <option >QUINCENAL</option> 
                                            <option >MENSUAL</option> 


                                        </select>

                                    </td>
                                    <td>
                                        <select name="pagoen" style="background-color: rgb(239, 244, 165)">

                                            <option >OFICINA</option>
                                            <option>CASA</option>
                                            <option>TRABAJO</option>
                                            <option>BANCO</option>


                                        </select>   

                                    </td>

                                    <td>
                                        <input type="text" name="fecha_visita" id="fecha_visita"  value="<?php echo date("Y-m-d"); ?>"  size="10"> 
                                    </td>
                                    <td>
                                        <input type="text" name="fecha_limite" id="fecha_limite"  value="<?php echo date("Y-m-d"); ?>" size="10">
                                    </td>

                                    <td>
                                        <!--<input type="text"  id="hora"  size="5">-->
                                        <select name="hora" >

                                            <option >AM</option>
                                            <option>PM</option>
                                            <option>PD</option>   



                                        </select> 

                                    </td>


                                    <td >

                                        <?php print_r($personal) ?>

                                    </td>
                                <?php } ?>
                            </tr>

                            <tr>
                                <td colspan="7">
                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal2" id="btn_acep_acue" ><span class="glyphicon glyphicon-save"></span>Aceptar</button>

                                </td>

                            </tr>
                        </table>
                        <span id="msg"> </span>
                    </div>

                    <div id="cuerpo_acuerdo_uni" style="display:none">
                        <table border="1" width="100%" id="actualizar_cliente" class="actualizar_cliente table"  style="background: #dff0d8;font-size: 15px;font-family: Times New Roman">
                            <tr >
                                <td colspan="7" style=" background-color:  #FACAAD"><b>UNIR ACUERDOS EN UNO SOLO.</b></td>
                            </tr>
                            <tr><td><b>LAS COBRANZAS DE VARIOS PRODUCTOS SE PUEDEN UNIR EN:</b></td>
                                <td> <select name="frecuencia_msg_uni" id="frecuencia_msg_uni">
                                        <option value="d">DIARIO</option>
                                        <option value="s">SEMANAL</option>
                                        <option value="q">QUINCENAL</option>
                                        <option value="m">MENSUAL</option>
                                    </select></td>
                            </tr>


                            <tr>
                                <td colspan="7">
                                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal2" id="btn_acep_acue_uni" ><span class="glyphicon glyphicon-save"></span>Aceptar</button>

                                </td>

                            </tr>
                        </table>
                        <span id="msg"> </span>
                    </div>
                    <div id="detall_acuerdo">
                        <?php // print_r($rows);exit;          ?>
                        <table border="1" width="100%" style="font-size: 12px">
                            <tr style="background-color:  #d6487e;font-family:  fantasy">

                                <td style="text-align: right" colspan="11">[  0-50 ]&nbsp;&nbsp;[ 51-80 ]&nbsp;&nbsp;[ 81-100 ][%] </td>
                            </tr>
                            <tr style="background-color:#F39814;text-height: 5px;text-justify:  inherit ">
                                <th width="2%">Nº</th>                                
                                <th width="30%">ACUERDO</th>
                                <th width="8%">F-VISITA</th>
                                <th width="8%">F-PAGO</th>
                                <th width="6%">Hora</th>                                
                                <th width="10%">FRECUENCIA</th>
                                <th width="8%">PAGO EN:</th>
                                <th width="10%">PERSONAL</th>
                                <th width="10%">FUENTE</th>
                                <th width="10%">Califica</th>
                                <th ></th>
                            </tr>
                            <?php foreach ($rows as $key => $data): ?>


                                <tr>
                                    <td><?php echo ($key + 1); ?></td>                                    
                                    <td><?php echo $data['acuerdos']; ?></td>
                                    <td><?php echo $data['fecha_visita']; ?></td>
                                    <td><input type="hidden" id="<?php echo "fech" . $key; ?>" value="<?php echo $data['fecha_verificacion']; ?>"><?php echo $data['fecha_verificacion']; ?></td>
                                    <td><?php echo $data['hora']; ?></td>
                                    <td><?php echo $data['frecuencia_msj']; ?></td>
                                    <td><?php echo $data['pagoen']; ?></td>
                                    <td><?php echo $data['personal']; ?></td>
                                    <td><?php echo $data['fuente']; ?></td>
                                    <td><?php if ($data['calificacion'] == 1) { ?>
                                            1<input type="radio" idacuerdo="<?php echo $data['idacuerdos']; ?>" valor="1" name="<?php echo$key ?>cal[]" class="calificar_radius" checked>2<input type="radio" idacuerdo="<?php echo $data['idacuerdos']; ?>" valor="2" name="<?php echo$key ?>cal[]" class="calificar_radius" >3<input type="radio" idacuerdo="<?php echo $data['idacuerdos']; ?>" valor="3" name="<?php echo$key ?>cal[]" class="calificar_radius" >
                                        <?php } elseif ($data['calificacion'] == 2) { ?>
                                            1<input type="radio" idacuerdo="<?php echo $data['idacuerdos']; ?>" valor="1" name="<?php echo$key ?>cal[]" class="calificar_radius" >2<input type="radio" idacuerdo="<?php echo $data['idacuerdos']; ?>" valor="2" name="<?php echo$key ?>cal[]" class="calificar_radius" checked>3<input type="radio" idacuerdo="<?php echo $data['idacuerdos']; ?>" valor="3" name="<?php echo$key ?>cal[]" class="calificar_radius" >

                                        <?php } elseif ($data['calificacion'] == 3) {
                                            ?>
                                            1<input type="radio" idacuerdo="<?php echo $data['idacuerdos']; ?>" valor="1" name="<?php echo$key ?>cal[]" class="calificar_radius" >2<input type="radio" idacuerdo="<?php echo $data['idacuerdos']; ?>" valor="2" name="<?php echo$key ?>cal[]" class="calificar_radius" >3<input type="radio" idacuerdo="<?php echo $data['idacuerdos']; ?>" valor="3" name="<?php echo$key ?>cal[]" class="calificar_radius" checked>

                                        <?php } else {
                                            ?><input type="hidden" name="bandera" value="ok" id="bandera">
                                            1<input type="radio" idacuerdo="<?php echo $data['idacuerdos']; ?>" valor="1" name="<?php echo$key ?>cal[]" class="calificar_radius" >2<input type="radio" idacuerdo="<?php echo $data['idacuerdos']; ?>" valor="2" name="<?php echo$key ?>cal[]" class="calificar_radius" >3<input type="radio" idacuerdo="<?php echo $data['idacuerdos']; ?>" valor="3" name="<?php echo$key ?>cal[]" class="calificar_radius" >

                                        <?php } ?>
                                    </td>

                                    <td>
                                        <span class="glyphicon glyphicon-trash eliminacuerdo" idacuerdo="<?php echo $data['idacuerdos']; ?>"></span>
                                    </td>
                                </tr>
                                <?php
                            endforeach;
                            ?>
                        </table>
                    </div>

                </div> <!-- termina el body -->                   
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</form>