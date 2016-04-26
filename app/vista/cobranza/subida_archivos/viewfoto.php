
<script type="text/javascript">

    function subirArchivos() {

        $("#txtFile").upload('../app/vista/cobranza/subida_archivos/subir_archivo.php',
                {
                    txtFile: 'hola',
                    idproc_cobr: $("#boton_subir").attr('idpro_cobr'),
                    dnicli: $("#boton_subir").attr('idclient')
                },
        function (respuesta) {


            mostrarRespuesta('El archivo ha sido subido correctamente.', true);


            mostrarArchivos($("#boton_subir").attr('idpro_cobr'));
            //Subida finalizada.
            //$("#barra_de_progreso").val(0);

            //alert(respuesta);
        }, function (progreso, valor) {
            //Barra de progreso.
            $("#barra_de_progreso").val(1);
        }
        );
    }
    function subirArchivos12() {
        // dataString = $('#formuploadajax').serialize();

        $("#archivo").load('../app/vista/cobranza/subida_archivos/subir_archivo.php',
                {
                    nombre_archivo: $("#nombre_archivo").val(),
                    idproc_cobr: $("#boton_subir").attr('idpro_cobr'),
                    dnicli: $("#boton_subir").attr('idclient')
                },
        function (respuesta) {
            //Subida finalizada.
            $("#barra_de_progreso").val(0);

            if (respuesta === 1) {
                mostrarRespuesta('El archivo ha sido subido correctamente.', true);
                $("#nombre_archivo, #archivo").val('');
            } else {
                mostrarRespuesta('El archivo NO se ha podido subir.', false);
            }
            mostrarArchivos($("#boton_subir").attr('idpro_cobr'));
        }, function (progreso, valor) {
            //Barra de progreso.
            $("#barra_de_progreso").val(valor);
        });


    }
    function eliminarArchivos(archivo, idfoto) {

        $.ajax({
            url: '../app/vista/cobranza/subida_archivos/eliminar_archivo.php',
            type: 'POST',
            timeout: 10000,
            data: {archivo: archivo,
                idfoto: idfoto
            },
            error: function () {
                mostrarRespuesta('Error al intentar eliminar el archivo.', false);
            },
            success: function (respuesta) {
                if (respuesta == 1) {
                    mostrarRespuesta('El archivo ha sido eliminado.', true);
                } else {
                    mostrarRespuesta('Error al intentar eliminar el archivo.', false);
                }
                idpro = $("#idpro").attr("idpro_c");
                mostrarArchivos(idpro);
            }
        });
    }
    function mostrarArchivos(idproc) {

        $.ajax({
            url: '../app/vista/cobranza/subida_archivos/mostrar_archivos.php?idproc=' + idproc,
            dataType: 'JSON',
            success: function (respuesta) {

                if (respuesta) {
                    var html = '';
                    for (var i = 0; i < respuesta.length; i++) {
                        html += '<div class="row"> <span class="col-lg-2"> ' + respuesta[i]['nombre'] + ' </span> <div class="col-lg-2"> <a class="eliminar_archivo btn btn-danger" id="' + respuesta[i]['id_files'] + '" href="javascript:void(0);"> Eliminar </a> </div> </div> <hr />';
                        html += '<div class="row"><div class="col-lg-12">  <img src="../copia_contrato/' + respuesta[i]['nombre'] + '" width="1300" height="1800" alt="00884153_1425486741"/>'
                        ' </div> </div >'
                    }
                    $("#archivos_subidos").html(html);
                }
            }
        });
    }
    function mostrarRespuesta(mensaje, ok) {
        $("#respuesta").removeClass('alert-success').removeClass('alert-danger').html(mensaje);
        if (ok) {
            $("#respuesta").addClass('alert-success');
        } else {
            $("#respuesta").addClass('alert-danger');
        }
    }
    $(document).ready(function () {

        idpro = $("#idpro").attr("idpro_c");
        mostrarArchivos(idpro);

        $("#boton_subir").on('click', function () {

            subirArchivos();
        });
        $("#archivos_subidos").on('click', '.eliminar_archivo', function () {
            var archivo = $(this).parents('.row').eq(0).find('span').text();
            idfoto = $(this).attr('id');
            archivo = $.trim(archivo);
            eliminarArchivos(archivo, idfoto);
        });




    });
</script>
<div class="container">

    <form action="javascript:void(0);">
        <!--name="frmUpload" action="../app/vista/reportes/archivos_upload.php" method="post" enctype="multipart/form-data">-->
        <div id="respuesta" class="alert"></div>
        <div style=" float: left ; width: 80% ; border: 1px solid red " >
            <input type="file" name="txtFile" id="txtFile" />
            <input type="hidden" name="idpr" id="idpro" idpro_c="<?php echo $rows[0]['idproceso_cobro'] ?>" />
        </div>
        <div style="width:20%;float: right"> 

            <input type="submit" id="boton_subir" value="Subir" class="btn btn-success" idpro_cobr="<?php echo $rows[0]['idproceso_cobro'] ?>" idclient="<?php echo $rows[0]['dni'] ?>"  />
        </div>

    </form>


    <!--  <div id="respuesta" class="alert"></div>
      <form action="javascript:void(0);"   >
          <div class="row">
              <div class="col-lg-2"> 
                  <label> Nombre el archivo: </label> 
              </div>
              <div class="col-lg-2">
                  <input type="text" name="nombre_archivo" id="nombre_archivo" />
                  <input type="hidden" name="idpr" id="idpro" idpro_c="<?php //echo $rows[0]['idproceso_cobro']  ?>" />
  
              </div>
              <div class="col-lg-2">
                  <input type="file" name="archivo" id="archivo" />
              </div>                    
          </div>
          <hr />-->
    <!--        <div class="row">
                <div class="col-lg-2">
                    <input type="submit" id="boton_subir" value="Subir" class="btn btn-success" idpro_cobr="<?php //echo $rows[0]['idproceso_cobro']  ?>" idclient="<?php //echo $rows[0]['dni']  ?>"  />
                </div>
                <div class="col-lg-4">
                    <progress id="barra_de_progreso" value="0" max="100"></progress>
                </div>
            </div>
        </form>-->
    <hr />
    <div id="archivos_subidos"></div>
</div>

