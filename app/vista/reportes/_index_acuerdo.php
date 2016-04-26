<style>
    #contreporte{border: 2px #000 groove;
                 padding-left: 1%;
                 padding-right: 1%;
                 margin-left:  1%;
                 margin-right: 1%
    }
    #cabezareporte{padding: 2px}


    span.redm {
        background: red;
        border-radius: 35px;
        -moz-border-radius: 35px;
        -webkit-border-radius: 35px;
        color: #ffffff;
        display: inline-block;
        font-weight: bold;
        line-height: 70px;
        margin-right: 15px;
        text-align: center;
        font-size: 10px;
        width: 70px; 
        cursor: pointer
    }


</style>
<script>
    $(function() {
        $("#fechacorr").datepicker({'dateFormat': 'yy-mm-dd'});
        $("#fecha_i").datepicker({'dateFormat': 'yy-mm-dd'});
        $("#fecha_f").datepicker({'dateFormat': 'yy-mm-dd'});

        $("#buscar").click(function() {
            var fecha_i = $('#fecha_i').val();
            var fecha_f = $('#fecha_f').val();


            var separador_fi = fecha_i.split("/");
            var fechai = separador_fi[0];


            var separador_ff = fecha_f.split("/");
            var fechaf = separador_ff[0];

            $('#exe').prop('href', '../app/vista/reportes/desExel.php?fechai=' + fechai + '&fechaf=' + fechaf);

            $.post('../web/index.php', 'controller=reportes&action=get_acuerdo_all&fechai=' + fechai + '&fechaf=' + fechaf, function(data) {
                console.log(data);
                $("#cuerporeporte").empty().append(data);
            });

        });

        $("#acuerdo_no").click(function() {

            $.post('../web/index.php', 'controller=reportes&action=get_acuerdo_all&fechai=1', function(data) {
                console.log(data);
                $("#cuerporeporte").empty().append(data);
            });
        });

        $("#calificar_diario").click(function() {
            $("#dialogo3").dialog("open");
        });
        $("#GENER").click(function() {
            

            var idperfil = $('#idperfil').val();

            if (idperfil == 1 || idperfil == 4 || idperfil == 3) {
                var r = confirm("ESTA SEGURO QUE QUIERE ACTUALIZAR LOS PAGOS DIARIOS!");
                if (r == true) {
                    
                    var fechcorre = $('#fechacorr').val();  
                    $("#cuerporeporte").empty().append("<img src='../web/img/progress2.gif' alt=''/>");

                    $.post('../web/index.php', 'controller=reportes&action=compara_acuer&fechcorre='+fechcorre, function(data) {
                        console.log(data);
                        //  $("#cuerporeporte").empty().append(data);
                        $("#cuerporeporte").empty().append("<h3><B>LA CALIFICACIÓN FUE EXITOSA<b></h3>");
                    });
                    
                $("#dialogo3").dialog("close");
            }
                else {
                    exit;
                }

            }
            else {
                alert("USTED NO TIENE PERMISO PARA ESTA OPERACIÓN...Pida ayuda a su Administrador");

            }


        });
        $("#exelee").click(function() {
            var fecha_i = $('#fecha_i').val();
            var fecha_f = $('#fecha_f').val();


            var separador_fi = fecha_i.split("/");
            var fechai = separador_fi[0];


            var separador_ff = fecha_f.split("/");
            var fechaf = separador_ff[0];

            $('#exe').prop('href', 'index.php?controller=reportes&action=get_acuerdo_allExel&fechai=' + fechai + '&fechaf=' + fechaf);
//
//                $.post('../web/index.php', 'controller=reportes&action=get_acuerdo_allExel&fechai='+fechai+'&fechaf='+fechaf, function(data) {
//                    console.log(data);
//                    $("#cuerporeporte").empty().append(data);
//                });


        });

        $("#imprimir").click(function() {

            bval = true;

            if (bval) {
                $("#frm").submit();
            }
            return false;
        });

        $("#dialogo3").dialog({
            autoOpen: false,
            width: 500,
            height: 150,
            show: "scale",
            hide: "scale",
            resizable: "false",
            position: "center",
            modal: "true"


        });





    });


</script>
<style media="print" type="text/css">
    #imprimir {visibility:hidden}
    //.cuerpotabla1{visibility:hidden}
    //#cabtabla{visibility: hidden}
    //#menu{visibility: hidden}
    //#cabezareporte{visibility:hidden}
    //#mmmcabecera{visibility: hidden}



</style>
<p class="alert alert-info">REPORTE DE ACUERDOS</p>
<input type="hidden" id="idperfil" value="<?php echo $_SESSION['idperfil'] ?>">
<div id="contreporte">
    <div id="cabezareporte" class="cabezareporte" style="text-align: center">
        <table border="0" width="100%">
            <tr>
                <td><b>DESDE</b></td>
                <td>

                    <input type="text" name="fecha_i" id="fecha_i"  value="<?php echo date("Y-m-d"); ?>"  size="10"> 
                </td>

                <td><b>HASTA</b></td>
                <td>

                    <input type="text" name="fecha_f" id="fecha_f"  value="<?php echo date("Y-m-d"); ?>"  size="10"> 
                </td>
                <td>...</td>
                <td>
                    <button class="btn btn-info btn-sm"  id="buscar" title="BUSCAR" data-toggle="modal" data-target="#MyModal_bt4"><span class="glyphicon glyphicon-pencil  "></span>BUSCAR</button>

                </td>
                <td width="5%"></td>

                <td> 

                <td>

                    <a id="exe"><img src="../web/img/excel.gif " /></a>
                </td>
                <td width="5%"></td>

                <td> 
                    ...
                </td>
                <td>
                    <button class="btn btn-success btn-sm"  id="calificar_diario" title="CALIFICAR" data-toggle="modal" data-target="#MyModal_btdi"><span class="glyphicon glyphicon-pencil  "></span>CALIFICAR DIARIOS</button>
                </td>
                <td>
                    <button class="btn btn-danger btn-sm"  id="acuerdo_no" title="ACUERDOS NO RECARGADOS" data-toggle="modal" data-target="#MyModal_btdi"><span class="glyphicon glyphicon-pencil  "></span>ACUERDOS NO RECARGADOS</button>
                <td>
            </tr>
        </table>

    </div>
    <div id="cuerporeporte" style="border: 1px #002a80 solid ; padding: 1%">



    </div>

</div>
<div id="dialogo3" class="ventana"  title="INGRES LA FECHA QUE DESE CORRER LOS DIARIOS">
    <table>
        <tr >
            <td> <input type="text" size="10"  id="fechacorr" name="fechacorr" value="<?php echo date("Y-m-d"); ?>"  >

            </td>
            <td> <input type="button" id="GENER" value="GENERAR">
            </td>
        </tr>
        
    </table>

</div>

