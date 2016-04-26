<script>
    $(function() {
        
           $('.conpara').click(function() {
               
           $('#msgdni').empty();
           $('#mstiposerv').empty();
           
               });
        $('#nv_clientesv').click(function() {

            var dni = $('#dni').val();
            var tiposervidor = $('#tiposervidor').val();


            if ((dni == "") || (dni.length != 8)) {

                // alert("llene estos dni");
                $('#msgdni').empty();
                if (dni == "") {
                    $('#msgdni').append("INGRESE DNI");
                }
                else {
                    $('#msgdni').append(" EL DNI NO CUENTA CON 8 DIGITOS");
                }

            }

            else {
                if (tiposervidor == "sele") {

                    $('#mstiposerv').empty();
                    $('#mstiposerv').append("INGRESE TIPO DE CLIENTE");

                }
                else {
                    var dataString = $('#form_nv_cliente').serialize();

                    // alert('Datos serializados: ' + dataString);
                    $.post('../web/index.php', dataString, function(data) {
                        console.log(data);
                        //$("#detalle").empty().append(data);
                    });
                    $('#MyModal_bt1nv').modal('toggle');
                }

            }





        });




    });
</script>
   
<form id="form_nv_cliente" method="post">
    <input type="hidden" name="controller" value="cobranza" />
    <input type="hidden" name="action" value="nuevo_cliente" />

    <!-- Inicio de Modal de Editar Cliente -->
    <div class="modal fade " id="MyModal_bt1nv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel2"> NUEVO CLIENTE</h4>
                </div>
                <div class="modal-body" >
                    <table border="1" width="100%" id="actualizar_cliente" class="actualizar_cliente table"  style="background: #dff0d8;font-size: 15px;font-family: Times New Roman">

                        <tr>
                            <td colspan="6" style=" background-color:  #FACAAD"><b>Datos Personales</b></td>
                        </tr>
                        <tr>
                            <td class="filas">Nombres</td>
                            <td class="filas" colspan="3"><input type="text" name="pnombre"  size="50%"value="<?php echo strtoupper(utf8_encode($obj[0]['nombres'])); ?>" ></td>
                           
                            <td class="filas" ></td>
                            <td class="filas"></td>
                        </tr>
                        <tr>
                            <td class="filas">Apellidos</td>
                            <td class="filas" colspan="3"><input type="text" name="papellido" size="50%" value="<?php echo strtoupper(utf8_encode($obj[0]['apellidos'])); ?>"></td>
                            <td class="filas"></td>
                            <td class="filas"></td>
                        </tr>
                        <tr>
                            <td class="filas" >Dni</td>
                            <td class="filas"><input type="text" name="dni" id="dni" value="<?php echo $obj[0]['dni']; ?>" placeholder="(*)" class="conpara"></td>
                            <td class="filas" colspan="2"><div id="msgdni" style=" background-color: yellow; color: red"></div></td>

                            <td class="filas"></td>
                            <td class="filas"></td>
                        </tr>
                        <tr>
                            <td class="filas" >Telefono1</td>
                            <td class="filas"><input type="text" name="tlf1" value="<?php echo strtoupper(utf8_encode($obj[0]['telfcasa'])); ?>" ></td>
                            <td class="filas">Telefono2</td>
                            <td class="filas"><input type="text" name="tlf2" value="<?php echo strtoupper(utf8_encode($obj[0]['telf1'])); ?>"></td>
                            <td class="filas">Telefono3</td>
                            <td class="filas"><input type="text" name="tlf3" value="<?php echo strtoupper(utf8_encode($obj[0]['telf2'])); ?>"></td>
                        </tr>
                        <tr>
                            <td class="filas" >Dirccion</td>
                            <td colspan="3" class="filas"><input type="text" name="Direcliente" size="55" value="<?php echo strtoupper(utf8_encode($obj[0]['dir_actual'])); ?>" ></td>

                            <td class="filas">Distrito</td>
                            <td class="filas">

                                <select name="distritocliente" id="busquedasector">
                                    <option value="sele">Selecciana</option> 
                                    <?php
                                    foreach ($rows_dist as $key => $data):
                                        if ($data['nombre'] == strtoupper($obj[0]['distrito_cliente'])) {
                                            ?>

                                            <option value="<?php echo strtoupper(utf8_encode($data['nombre'])) ?>" selected="selected"><?php echo strtoupper(utf8_encode($data['nombre'])) ?></option>

                                            <?php
                                        } else {
                                            ?>
                                            <option value="<?php echo strtoupper(utf8_encode($data['nombre'])) ?>" ><?php echo strtoupper(utf8_encode($data['nombre'])) ?></option>

                                            <?php
                                        }
                                    endforeach;
                                    ?>
                                </select>

                            </td>


                        </tr>
<!--                        <tr>
                            <td class="filas" >Departamento</td>
                            <td class="filas" >
                                <select name="dpt_cliente"  id="dpt_cliente">
                                    <option value="sele">Selecciana</option> 
                        <?php
                        /*  foreach ($rows_dp as $key => $data):
                          if ($data['codubigeo'] == $obj[0]['distrito_cliente']) {
                          ?>

                          <option value="<?php echo $data['codubigeo'] ?>" selected="selected"><?php echo $data['nombre'] ?></option>

                          <?php
                          } else {
                          ?>
                          <option value="<?php echo $data['codubigeo'] ?>" ><?php echo $data['nombre'] ?></option>

                          <?php }
                          endforeach; */
                        ?>
                                </select> 
                            </td>
                            <td class="filas" >Provincia</td>
                            <td class="filas" >
                                 <select name="prov_cliente" id="busquedasector">
                                    <option value="sele">Selecciana</option> 
                        <?php
                        //  foreach ($rows_prov as $key => $data):
                        //    if ($data['codprov'] == $obj[0]['distrito_cliente']) {
                        ?>

                                            <option value="<?php //echo $data['codprov']    ?>" selected="selected"><?php echo $data['nombre'] ?></option>

                        <?php
                        //} else {
                        ?>
                                            <option value="<?php //echo $data['codprov']    ?>" ><?php //echo utf8_decode($data['nombre'])    ?></option>

                        <?php
                        //}
                        //endforeach;
                        ?>
                                </select> 
                            </td>
                            <td class="filas" >Distrito</td>
                            <td class="filas" >
                                <select name="dist_cliente" id="busquedasector">
                                    <option value="sele">Selecciana</option> 
                        <?php
                        // foreach ($rows_dist as $key => $data):
                        // if ($data['codprov'] == $obj[0]['distrito_cliente']) {
                        ?>

                                            <option value="<?php //echo $data['codprov']    ?>" selected="selected"><?php //echo $data['nombre']    ?></option>

                        <?php
//} else {
                        ?>
                                            <option value="<?php //echo $data['codprov']    ?>" ><?php // echo utf8_decode($data['nombre'])    ?></option>

                        <?php
// }
// endforeach;
                        ?>
                                </select>
                            </td>
                            
                        </tr>-->

                        <tr>
                            <td colspan="6" style=" background-color:  #FACAAD;"><b>Perfil Cliente</b></td>

                        </tr>

                        <tr>
                            <td width="20%" >Tipo Servidor</td>
                            <td width="20%" >
                                <select name="tiposervidor" id="tiposervidor" class="conpara">
                                    <option value="sele">Selecciana</option>  
                                    <?php
                                    foreach ($rows2 as $key => $data):
                                        if ($data['idperfil_cliente'] == $obj[0]['idperfil_cliente']) {
                                            ?>

                                            <option value="<?php echo $data['idperfil_cliente'] ?>" selected="selected"><?php echo $data['tiposervidor'] ?></option>

                                            <?php
                                        } else {
                                            ?>
                                            <option value="<?php echo $data['idperfil_cliente'] ?>" ><?php echo $data['tiposervidor'] ?></option>

                                            <?php
                                        }
                                    endforeach;
                                    ?>
                                </select>(*)
                            </td>


                            <td colspan="2">
                                <div id="mstiposerv" style=" background-color: yellow; color: red"></div>
                            </td>
                            <td>Codigo Modular

                            </td>
                            <td> <input type="text" name="codmodular" placeholder="Codigo Mudular"></td>

                        </tr>

                        <tr>
                            <td colspan="6" style=" background-color:  #FACAAD;"><b>Datos de Lugar de Trabajo</b></td>

                        </tr>
                        <tr>
                            <td class="filas">Numero/Ruc</td>
                            <td class="filas"><input type="text" name="num_ruc" value="<?php echo strtoupper(utf8_encode($obj[0]['codigo_ruc'])); ?>"></td>
                            <td class="filas">Nombre Centro</td>
                            <td colspan="3" class="filas" ><input type="text" name="nom_lug_trab" size="50" value="<?php echo strtoupper(utf8_encode($obj[0]['lugartrabajo'])); ?> " ></td>

                        </tr>
                        <tr>

                            <td class="filas" >Dirccion</td>
                            <td colspan="3" class="filas"><input type="text" name="dire_lug_tra" size="50" value="<?php echo strtoupper(utf8_encode($obj[0]['direccion'])); ?>"></td>


                            <td class="filas">Distrito</td>
                            <td class="filas">
                                <select name="distritocliente_LT" id="busquedasector">
                                    <option value="sele">Selecciana</option> 
                                    <?php
                                    foreach ($rows_dist as $key => $data):
                                        if ($data['nombre'] == strtoupper($obj[0]['distritoL_T'])) {
                                            ?>

                                            <option value="<?php echo strtoupper(utf8_encode($data['nombre'])) ?>" selected="selected"><?php echo strtoupper(utf8_encode($data['nombre'])) ?></option>

                                            <?php
                                        } else {
                                            ?>
                                            <option value="<?php echo strtoupper(utf8_encode($data['nombre'])) ?>" ><?php echo strtoupper(utf8_encode($data['nombre'])) ?></option>

                                            <?php
                                        }
                                    endforeach;
                                    ?>
                                </select>
                            </td>


                        </tr>
                        <td colspan="6">
                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal211" id="nv_clientesv" ><span class="glyphicon glyphicon-save"></span>Aceptar</button>
                            Dato: Los Campos (*) Son Obligatorios
                        </td>
                        </tr>
                    </table>


                </div> <!-- termina el body -->                   
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</form>