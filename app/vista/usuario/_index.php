<style>
    .boton {
        //float:left;
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
</style>

<link href="../web/assets/css/bootstrap-responsive.min.css" rel="stylesheet" />
<link rel="stylesheet" href="../web/assets/css/font-awesome.min.css" />

<!--ace styles-->

<link rel="stylesheet" href="../web/assets/css/ace.min.css" />
<link rel="stylesheet" href="../web/assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="../web/assets/css/ace-skins.min.css" />
<script src="../web/assets/js/jquery.dataTables.min.js"></script>
<script src="../web/assets/js/jquery.dataTables.bootstrap.js"></script>


<script src='../web/js/funciones.js'></script>

<script>
    $(function() {

        var oTable1 = $('#sample-table-2').dataTable({
            "aoColumns": [
                {"bSortable": false},
                null, null, null, null, null,
                {"bSortable": false}
            ]});
        $("#nuev_usuario").click(function() {
            var idperfil = $('#idperfil').val();
            if (idperfil == 1 || idperfil == 4) {
                true;
            }
            else {
                alert("USTED NO TIENE PERMISO!!!");
                $('#MyModal_NU').modal('toggle');
            }


        });
        $("#agreganuevousuario").click(function() {

            dni = $('#dni').val();
            idp = $('#idperfil').val();
            ido = $('#idoficina').val();
            if (dni == '' || idp == '' || ido == '') {
                alert("INGRESE DATOS EN: DNI, PERFIL, OFICINA")

            }
            else {

                if (dni.length == 8) {
                    var dataString = $('#frm_nuevo_usuario').serialize();
                    // alert('Datos serializados: ' + dataString);
                    $.post('../web/index.php', dataString, function(data) {
                        console.log(data);
                        //$("#detalle").empty().append(data);
                    });
                    $('#MyModal_NU').modal('toggle');
                    $('.limpio').val(' ');
                }
                else {
                    alert(" EL DNI NO CUENTA CON 8 DIGITOS");


                }


            }


        });

        $("#save_uc").click(function() {
            var dataString = $('#frm_cambiar_uc').serialize();
            usuario = $('#usuario').val();
            pasword = $('#pasword').val();
            idpers = $('#idpers').val();
            // alert('Datos serializados: ' + dataString);
            $.post('../web/index.php', dataString + '&usuario=' + usuario + '&pasword=' + pasword + '&idpers=' + idpers, function(data) {
                console.log(data);
                //$("#detalle").empty().append(data);
            });
            $("#dialogo3").dialog("close");

        });

        $(".ver").click(function() {
           
            idp = $(this).attr('id');

            $.post('../web/index.php', 'controller=usuario&action=getpersonal&idp=' + idp, function(data) {
                console.log(data);
                $("#divnvo_ediusu").empty().append(data);
                $('#MyModal_editusua').modal('show');
            });

        });


        $(".iditarpsw").click(function() {
            data = $(this).attr('id');
            var separa = data.split(",");
            id = separa[0];
            usuario = separa[1];
            pasword = separa[2];
            $('#usuario').val(usuario);
            $('#pasword').val(pasword);
            $('#idpers').val(id);

            $('#dialogo3').prop('title', '');
            $("#dialogo3").dialog("open");

        });



        $("#dialogo3").dialog({
            autoOpen: false,
            width: 600,
            height: 250,
            show: "scale",
            hide: "scale",
            resizable: "false",
            position: "center",
            modal: "true"


        });
    });

</script>

<input type="hidden" id="idperfil" value="<?php echo $_SESSION['idperfil'] ?>">
<div id="divnvo_ediusu">

</div>

<div class="table-header">

    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#MyModal_NU" id="nuev_usuario" ><span class="glyphicon glyphicon-usd  "></span>NUEVO</button>
</div>
<table id="sample-table-1" align="center" >
    <thead>
        <tr>
            <th class="center">
                <label>
                    <input type="checkbox" />
                    <span class="lbl"></span>
                </label>
            </th>
            <th width="10%">DNI</th>
            <th width="15%">Personal</th>
            <th class="hidden-480">Telefonos</th>
            <th class="hidden-480">Oficina</th>

            <th class="hidden-phone">
                <i class="icon-time bigger-110 hidden-phone"></i>
                Cargo
            </th>


            <th></th>
        </tr>
    </thead>

    <tbody>

        <?php
        foreach ($rows as $valor):
            ?>
        <tr style="border-bottom: 1px solid #FACAAD">
                <td class="center">
                    <label>
                        <input type="checkbox" />
                        <span class="lbl"></span>
                    </label>
                </td>

                <td>
                    <?php echo $valor['dnipersonal']; ?>
                </td>
                <td><?php echo strtoupper(utf8_encode($valor['primer_nombre'] . " " . $valor['segundo_nombre'] . " " . $valor['apellido_p'] . " " . $valor['apellido_m'])); ?></td>
                <td class="hidden-480"><?php echo $valor['telefon']; ?></td>
                <td class="hidden-480"><?php echo $valor['ofici']; ?></td>
                <td class="hidden-phone"><?php echo strtoupper(utf8_encode($valor['descripcion'])); ?></td>
                <td class="td-actions">
                    <div class="hidden-phone visible-desktop action-buttons">
                        <?php if ($_SESSION['idperfil'] == 1 || $_SESSION['idperfil'] == 4) { ?> 
                            <a class="blue ver" href="#" id="<?php echo $valor['idpersonal'] ?>">
                                <i class="icon-zoom-in bigger-130"></i>
                            </a> 

                        <?php } else { ?>
                            <a class="red" href="#">
                                <i class="icon-zoom-in bigger-130"></i>
                            </a>

                            <?php
                        }
                        if ($_SESSION['idperfil'] == 1 || $_SESSION['idperfil'] == 4 || $valor['dnipersonal'] == $_SESSION['dnipersonal']) {
                            ?> 


                            <a class="green iditarpsw" href="#" id="<?php echo $valor['idpersonal'] . "," . $valor['usuario'] . "," . $valor['pasword'] ?>">
                                <i class="icon-pencil bigger-130" id="bootbox-regular"></i>
                            </a>

                            <?php
                        } else {
                            ?> 

                            <a class="red" href="#" >
                                <i class="icon-pencil bigger-130" id="bootbox-regular"></i>
                            </a>

                        <?php } ?>


                        <label>
                            <input name="switch-field-1" class="ace-switch ace-switch-6" type="checkbox">
                            <span class="lbl"></span>
                        </label>



                    </div>

                    <div class="hidden-desktop visible-phone">
                        <div class="inline position-relative">
                            <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-caret-down icon-only bigger-120"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-icon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
                                <li>
                                    <a href="#" class="tooltip-info" data-rel="tooltip" title="View">
                                        <span class="blue">
                                            <i class="icon-zoom-in bigger-120"></i>
                                        </span>
                                    </a>
                                </li>

                                <li>

                                    <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
                                        <span class="red">
                                            <i class="icon-edit bigger-120">11</i>
                                        </span>
                                    </a>

                                </li>

                                <li>
                                    <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                                        <span class="red">
                                            <i class="icon-trash bigger-120"></i>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <label>
                                        <input name="switch-field-1" class="ace-switch ace-switch-6" type="checkbox">
                                        <span class="lbl"></span>
                                    </label>
                                </li>

                            </ul>
                        </div>
                    </div>
                  
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div id="nuevo_personal">
    <!-- En este div cargar el formulario ;para actualizar Cliente-->
</div>
<form id="frm_cambiar_uc" method="post">
    <input type="hidden" name="controller" value="usuario" />
    <input type="hidden" name="action" value="cambiar_uc" />
    <div id="dialogo3" class="ventana"  title="[ Cambiar ]usuario-contraseña">
        <table cellpadding="2" cellspacing="50" >
            <tr><td>.</td>
                <td width="30" ><b>Usuario</b></td>
                <td width="30" >&nbsp;&nbsp;</td>
                <td width="30"><b>Contraseña</b></td>

            </tr>
            <tr>
                <td> <input type="hidden" name="idpers"  id="idpers" ></td>
                <td><input type="text" name="usuario" size="30" id="usuario"  title="USUARIO"></td>
                <td width="30" >&nbsp;&nbsp;</td>
                <td><input type="text" name="pasword" size="20" id="pasword"  title="CONTRASEÑA"></td>

            </tr>


        </table>
        <div id="save_uc" class=" guardar_reprogramacion boton ">Guardar</div>
    </div>
</form>
asasa

<form id="frm_nuevo_usuario" method="post">
    <input type="hidden" name="controller" value="usuario" />
    <input type="hidden" name="action" value="nuevousuario" />
    <!-- Inicio de Modal de Editar Cliente -->
    <div class="modal fade " id="MyModal_NU" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true" >
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
                            <td class="filas" colspan="5"><input type="text" name="dni" size="55" class="limpio" id="dni" placeholder="(*)"></td>


                        </tr>
                        <tr>
                            <td class="filas">Pimer Nombre</td>
                            <td class="filas"><input type="text" name="pnombre" class="limpio"></td>
                            <td class="filas">Segundo Nombre</td>
                            <td class="filas" ><input type="text" name="snombre" class="limpio" ></td>
                            <td class="filas" ></td>
                            <td class="filas"></td>
                        </tr>
                        <tr>
                            <td class="filas">Primer Apellido</td>
                            <td class="filas"><input type="text" name="papellido" class="limpio"></td>
                            <td class="filas" >Segundo Apellido</td>
                            <td class="filas"><input type="text" name="sapellido" class="limpio"></td>
                            <td class="filas"></td>
                            <td class="filas"></td>
                        </tr>

                        <tr>
                            <td class="filas" >Telefono1</td>
                            <td class="filas"><input type="text" name="tlf1" class="limpio" ></td>
                            <td class="filas">Telefono2</td>
                            <td class="filas"><input type="text" name="tlf2" class="limpio"></td>
                            <td class="filas"></td>
                            <td class="filas"></td>
                        </tr>
                        <tr>
                            <td class="filas" >Dirccion</td>
                            <td colspan="3" class="filas"><input type="text" name="direccion" size="55" class="limpio"></td>

                            <td class="filas"></td>
                            <td class="filas">
<!--                                <input type="text" name="distrito" >-->

                            </td>


                        </tr>
                        <tr>
                            <td class="filas" >Correo</td>
                            <td colspan="3" class="filas"><input type="text" name="correo" size="55"  class="limpio">

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
                            </td>

                            <td width="20%" >
                                OFICINA
                            </td>
                            <td ><?php echo $oficina; ?> </td>
                            <td colspan="2">

                            </td>

                        </tr>

                        <tr>
                            <td colspan="6" style=" background-color:  #FACAAD;"><b>Correo de Institucion</b></td>

                        </tr>
                        <tr>
                            <td class="filas">Usuario</td>
                            <td class="filas"><input type="text" name="usuario" ></td>
                            <td class="filas">Contraseña</td>
                            <td colspan="3" class="filas" ><input type="text" name="passwor" size="50" ></td>

                        </tr>
                        <tr>

                            <td class="filas" colspan="5" >En Actividade</td>



                        </tr>
                        <td colspan="6">
                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal2usua" id="agreganuevousuario" ><span class="glyphicon glyphicon-save"></span>Aceptar</button>
                        </td>
                        </tr>
                    </table>


                </div> <!-- termina el body -->                   
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</form>