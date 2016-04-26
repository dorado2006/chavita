<script>
    $(function() {
        $('#update_usu').click(function() {
            var dataString = $('#frm_update_usuario').serialize();

            // alert('Datos serializados: ' + dataString);
            $.post('../web/index.php', dataString, function(data) {
                console.log(data);
                //$("#detalle").empty().append(data);
            });
            $('#MyModal_editusua').modal('toggle');


        });


    });
</script>


<form id="frm_update_usuario" method="post">
    <input type="hidden" name="controller" value="usuario" />
    <input type="hidden" name="action" value="updateusua" />
    <input type="hidden" name="idcliente" value="<?php echo $obj[0]['idpersonal']; ?>" />
    <!-- Inicio de Modal de Editar Cliente -->
    <div class="modal fade " id="MyModal_editusua" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel2">Nuevo Personal</h4>
                </div>
                <div class="modal-body" >
                    <table border="0" width="100%" id="actualizar_cliente" class="actualizar_cliente table"  style="background: #dff0d8;font-size: 15px;font-family: Times New Roman">

                        <tr>
                            <td colspan="6" style=" background-color:  #FACAAD"><b>Datos Personales</b></td>
                        </tr>
                        <tr>
                            <td class="filas" >Dni</td>
                            <td class="filas" colspan="5"><input type="text" name="dni" size="55" class="limpio" id="dni" value="<?php echo strtoupper(utf8_encode($obj[0]['dnipersonal'])); ?>" readonly=""></td>


                        </tr>
                        <tr>
                            <td class="filas">Pimer Nombre</td>
                            <td class="filas"><input type="text" name="pnombre" class="limpio" value="<?php echo strtoupper(utf8_encode($obj[0]['primer_nombre'])); ?>"></td>
                            <td class="filas">Segundo Nombre</td>
                            <td class="filas" ><input type="text" name="snombre" class="limpio" value="<?php echo strtoupper(utf8_encode($obj[0]['segundo_nombre'])); ?>"></td>
                            <td class="filas" ></td>
                            <td class="filas"></td>
                        </tr>
                        <tr>
                            <td class="filas">Primer Apellido</td>
                            <td class="filas"><input type="text" name="papellido" class="limpio" value="<?php echo strtoupper(utf8_encode($obj[0]['apellido_p'])); ?>"></td>
                            <td class="filas" >Segundo Apellido</td>
                            <td class="filas"><input type="text" name="sapellido" class="limpio" value="<?php echo strtoupper(utf8_encode($obj[0]['apellido_m'])); ?>"></td>
                            <td class="filas"></td>
                            <td class="filas"></td>
                        </tr>

                        <tr>
                            <td class="filas" >Telefono1</td>
                            <td class="filas"><input type="text" name="tlf1" class="limpio" value="<?php echo strtoupper(utf8_encode($obj[0]['telf1'])); ?>"></td>
                            <td class="filas">Telefono2</td>
                            <td class="filas"><input type="text" name="tlf2" class="limpio" value="<?php echo strtoupper(utf8_encode($obj[0]['telf2'])); ?>"></td>
                            <td class="filas"></td>
                            <td class="filas"></td>
                        </tr>
                        <tr>
                            <td class="filas" >Dirccion</td>
                            <td colspan="3" class="filas"><input type="text" name="direccion" size="55" class="limpio" value="<?php echo strtoupper(utf8_encode($obj[0]['dir_actual'])); ?>"></td>

                            <td class="filas"></td>
                            <td class="filas">
<!--                                <input type="text" name="distrito" >-->

                            </td>


                        </tr>
                        <tr>
                            <td class="filas" >Correo</td>
                            <td colspan="3" class="filas"><input type="text" name="correo" size="55"  class="limpio" value="<?php echo strtoupper(utf8_encode($obj[0]['correo'])); ?>">

                            </td>

                            <td class="filas"></td>
                            <td class="filas">
<!--                                <input type="text" name="distrito" >-->

                            </td>


                        </tr>


                        <tr>
                            <td colspan="6" style=" background-color:  #FACAAD;"><b>Perfil Personal</b></td>

                        </tr>

                        <tr>
                            <td width="20%" >Perfil</td>
                            <td width="20%" >
                                <?php echo $personal; ?>

                                <select name="idperfil" id="busquedasector">
                                    <option value="sele">Selecciana</option> 
                                    <?php
                                    foreach ($rows_perfil as $key => $data):
                                        if ($data['idperfil'] == strtoupper($obj[0]['idperfil'])) {
                                            ?>

                                            <option value="<?php echo strtoupper(utf8_encode($data['idperfil'])) ?>" selected="selected"><?php echo strtoupper(utf8_encode($data['descripcion'])) ?></option>

                                            <?php
                                        } else {
                                            ?>
                                            <option value="<?php echo strtoupper(utf8_encode($data['idperfil'])) ?>" ><?php echo strtoupper(utf8_encode($data['descripcion'])) ?></option>

                                            <?php
                                        }
                                    endforeach;
                                    ?>
                                </select>

                            </td>

                            <td width="20%" >

                            </td>
                            <td > </td>
                            <td colspan="2">

                            </td>

                        </tr>

                        <tr>
                            <td colspan="6" style=" background-color:  #FACAAD;"><b>Correo de Institucion</b></td>

                        </tr>
                        <tr>
                            <td class="filas">Usuario</td>
                            <td class="filas"><input type="text" name="usuario" value="<?php echo strtoupper(utf8_encode($obj[0]['usuario'])); ?>" ></td>
                            <td class="filas">Contraseña</td>
                            <td colspan="3" class="filas" ><input type="text" name="passwor" size="50" value="<?php echo strtoupper(utf8_encode($obj[0]['pasword'])); ?>" ></td>

                        </tr>
                        <tr>

                            <td class="filas" colspan="5" >En Actividade</td>



                        </tr>
                        <td colspan="6">
                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal2usua" id="update_usu" ><span class="glyphicon glyphicon-save"></span>Aceptar</button>
                        </td>
                        </tr>
                    </table>


                </div> <!-- termina el body -->                   
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</form>