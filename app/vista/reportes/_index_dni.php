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
    .ace-settings-box {
        display: none;
        float: left;
        width: 400px;
        padding: 0 14px;
        background-color: #FFF;
        border: 2px solid #5cb85c;
        position: absolute; 
        left: 960px; 
        top: 110px; 
        filter:alpha(opacity=0)
    }
    .ace-settings-box label{font-size: 10px;}
    .encendido{}
    .apagado{display: none}
    .de{float: left;width:200px}



</style>
<script>
    $(function() {
        $("#fecha_visita").datepicker({'dateFormat': 'yy-mm-dd'});
        $("#fecha_limite").datepicker({'dateFormat': 'yy-mm-dd'});

        $("#ejecutasql").click(function() {

            $.post('../web/index.php', 'controller=reportes&action=import_ecxel', function(data) {
                console.log(data);
                $("#cuerporeporte").empty().append(data);
            });


        });
        $("#ejecutasqlbus").click(function() {

            $('#cuerporeporte').show();
            $('#acuerdo').hide();
            // $('#exe').prop('href', '../app/vista/reportes/desExel.php?fechai=' + fechai + '&fechaf=' + fechaf);

            $.post('../web/index.php', 'controller=reportes&action=carga_dnibusc', function(data) {
                console.log(data);
                $("#cuerporeporte").empty().append(data);
            });


        });
        
         $("#ejecutasqlbuscliente").click(function() {

            $('#cuerporeporte').show();
            $('#acuerdo').hide();
            // $('#exe').prop('href', '../app/vista/reportes/desExel.php?fechai=' + fechai + '&fechaf=' + fechaf);

            $.post('../web/index.php', 'controller=reportes&action=carga_dnibusccliente', function(data) {
                console.log(data);
                $("#cuerporeporte").empty().append(data);
            });


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

        $("#varios_acu").click(function() {
            $('#cuerporeporte').hide();
            $('#acuerdo').show();


        });
        $("#btn_acep_acue").click(function() {
            var d = new Date();

            var month = d.getMonth() + 1;
            var day = d.getDate();

            var output = d.getFullYear() + '-' +
                    (('' + month).length < 2 ? '0' : '') + month + '-' +
                    (('' + day).length < 2 ? '0' : '') + day;

            var min_fecha = $('#fecha_limite').val();


            if (min_fecha < output) {
                alert("LA FECHA PAGO ES MENOR DE LO ACTUAL");
                exit;
            }
            var dataString = $('#form_nuv_acuerdo').serialize();
            $.post('../web/index.php', dataString, function(data) {
                console.log(data);
                //$("#detalle").empty().append(data);
            });
            //$('#MyModal_acuerdo').modal('toggle');
            $('#acuerdo').hide();
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
<script type="text/javascript">
    function subirArchivos() {
        $("#cuerporeporte").empty().append("<img src='../web/img/progress2.gif' alt=''/>");
        $("#txtFile").upload('../app/vista/reportes/archivos_upload.php',
                {
                    txtFile: 'hola'
                },
        function(respuesta) {
            //Subida finalizada.
            //$("#barra_de_progreso").val(0);

            //alert(respuesta);
        }, function(progreso, valor) {
            //Barra de progreso.
            $("#barra_de_progreso").val(1);
        }
        );
    }
    $(document).ready(function() {
        $("#botonocultamuestra").click(function() {
            $("#divocultamuestra").each(function() {
                displaying = $(this).css("display");
                if (displaying == "block") {
                    $(this).fadeOut('slow', function() {
                        $(this).css("display", "none");
                    });
                } else {
                    $(this).fadeIn('slow', function() {
                        $(this).css("display", "block");
                    });
                }
            });
        });

        $("#boton_subir").on('click', function() {

            subirArchivos();
            //  name="frmUpload" action="../app/vista/reportes/archivos_upload.php" method="post" enctype="multipart/form-data">
            $.post('../web/index.php', 'controller=reportes&action=import_ecxel', function(data) {
                console.log(data);
                $("#cuerporeporte").empty();
                //$("#cuerporeporte").empty().append("<img src='../web/img/progress2.gif' alt=''/>");

            });
        });
    });
</script>
<script type="text/javascript">

    function borra(T) {

//                var eco = "#" + T + "{display: none;}"
        //                       alert(T); exit;
//                document.getElementById("foxtrot").innerHTML = eco;

        if ($('#' + T).is(':checked')) {
            // alert("Está activado");
            $('.' + T).removeClass("apagado");

        } else {

            $('.' + T).addClass("apagado");
        }

    }
</script>


<div style=" background-color: #e3f2e1; text-align: center;color: blue"> <h5><b>FILTRO POR DNI`S</b></h5></div>
<div id="contreporte">
    <div id="cabezareporte" class="cabezareporte" style="text-align: center">
        <table border="1" width="100%">
            <tr>
                <td style=" width: 45%">

                    <form action="javascript:void(0);">
                        <!--name="frmUpload" action="../app/vista/reportes/archivos_upload.php" method="post" enctype="multipart/form-data">-->

                        <div style=" float: left ; width: 80%" > <input type="file" name="txtFile" id="txtFile" /></div>
                        <div style="width:20%;float: right"> 

                            <input type="submit" id="boton_subir" value="Subir" class="btn btn-success"  />
                        </div>

                    </form>


                </td>


                <td>
<!--                    <button class="btn btn-info btn-sm"  id="ejecutasql" title="BUSCAR" data-toggle="modal" data-target="#MyModal_bt4"><span class="glyphicon glyphicon-pencil  "></span>import</button>-->
                    <button class="btn btn-info btn-sm"  id="ejecutasqlbus" title="BUSCAR" data-toggle="modal" data-target="#MyModal_bt4"><span class="glyphicon glyphicon-pencil  "></span>BUSCAR/SUBIDOS</button>

                </td>
                <td width="5%"><button class="btn btn-primary btn-sm"  id="ejecutasqlbuscliente" title="BUSCAR TODOS LOS CLIENTE" data-toggle="modal" data-target="#MyModal_bt4"><span class="glyphicon glyphicon-list-alt  "></span>BUSCAR/TODOS/CLIENTES</button></td>
                <td> 
                    <div class="btn-group">
                        <button type="button" class="btn btn-success" id="botonocultamuestra">
                            Filtrar Por:<span class="caret"></span>
                        </button>

                    </div>


                    <div class="ace-settings-box" id="divocultamuestra">

                        <div class="de"> <div>
                                <input type="checkbox" class="ace-checkbox-22" value="chec1" id="chec1"  onclick=borra(this.value) />
                                <label class="lbl" for="chec1"> CLIENTE</label>
                            </div>

                            <div>
                                <input type="checkbox" class="ace-checkbox-2" value="chec2" id="chec2"  onclick=borra(this.value) />
                                <label class="lbl" for="chec2">U. F. PAGO</label>
                            </div>

                            <div>
                                <input type="checkbox" class="ace-checkbox-2" value="chec3" id="chec3"  onclick=borra(this.value) />
                                <label class="lbl" for="chec3"> U.PAGO</label>
                            </div>

                            <div>
                                <input type="checkbox" class="ace-checkbox-2" value="chec4" id="chec4"  onclick=borra(this.value) />
                                <label class="lbl" for="chec4"> T. CRÉDITO</label>
                            </div>
                            <div>
                                <input type="checkbox" class="ace-checkbox-2" value="chec5" id="chec5"  onclick=borra(this.value) />
                                <label class="lbl" for="chec5">SALDO</label>
                            </div>
                            <div>
                                <input type="checkbox" class="ace-checkbox-2" value="chec6" id="chec6"  onclick=borra(this.value) />
                                <label class="lbl" for="chec6">ACUERDOS</label>
                            </div>
                            <div>
                                <input type="checkbox" class="ace-checkbox-2" value="chec7" id="chec7"  onclick=borra(this.value)  />
                                <label class="lbl" for="chec7">C.TRABAJO</label>
                            </div>

                        </div>
                        <div class="iz"> <div>
                                <input type="checkbox" class="ace-checkbox-2" value="chec8" id="chec8"  onclick=borra(this.value) />
                                <label class="lbl" for="chec8"> DIRECCION C. TRABAJO</label>
                            </div>

                            <div>
                                <input type="checkbox" class="ace-checkbox-2" value="chec9" id="chec9"  onclick=borra(this.value)  />
                                <label class="lbl" for="chec9"> DOMICILIO CLIENTE</label>
                            </div>
                            <div>
                                <input type="checkbox" class="ace-checkbox-2" value="chec10" id="chec10"  onclick=borra(this.value) />
                                <label class="lbl" for="chec10">TLF-CLIENTE</label>
                            </div>
                            <div>
                                <input type="checkbox" class="ace-checkbox-2" value="chec11" id="chec11"  onclick=borra(this.value) />
                                <label class="lbl" for="chec11">TLF.C.TRABAJO</label>
                            </div>
                            <div>
                                <input type="checkbox" class="ace-checkbox-2"  value="chec12" id="chec12"  onclick=borra(this.value) />
                                <label class="lbl" for="chec12">DESC.CREDITO</label>
                            </div>
                            <div>
                                <input type="checkbox" class="ace-checkbox-2"  value="chec13" id="chec13"  onclick=borra(this.value) />
                                <label class="lbl" for="chec13">T.AMORTIZA</label>
                            </div>
                            <div>
                                <input type="checkbox" class="ace-checkbox-2"  value="chec14" id="chec14"  onclick=borra(this.value) />
                                <label class="lbl" for="chec14">TIP.SERVIDOR</label>
                            </div>
                        </div>



                    </div>

                </td>               
                <td width="5%"></td>
                <td>

                </td>
                <td width="5%">


                </td>
                <td>
                    <button class="btn btn-danger btn-sm"  id="varios_acu" title="BUSCAR" data-toggle="modal" data-target="#MyModal_bt4"><span class="glyphicon glyphicon-list-alt  "></span>CARGAR ACUERDOS A VARIOS</button>
                </td>

            </tr>
            
        </table>

    </div>
    <div id="cuerporeporte" style="border: 1px #002a80 solid ; padding: 1%"> </div>

    <form id="form_nuv_acuerdo" method="post">
        <input type="hidden" name="controller" value="reportes" />
        <input type="hidden" name="action" value="vario_acuerdos" />
        <div id="acuerdo" style="display:none">  
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
                    <td>

                        <textarea  name="txtacuerdo"></textarea>
                    </td>

                    <td>
                        <select name="frecuencia_msg">
                            <option>DIARIO</option>
                            <option>SEMANAL</option>
                            <option>QUINCENAL</option>
                            <option>MENSUAL</option>

                        </select>

                    </td>
                    <td>
                        <select name="pagoen">
                            <option>OFICINA</option>
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
                        <select name="hora">
                            <option>AM</option>
                            <option>PM</option>
                            <option>PD</option>                                        
                        </select> 

                    </td>


                    <td >
                        <?php echo $personal ?>

                    </td>

                </tr>
                <tr>
                    <td colspan="7">
                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal2" id="btn_acep_acue" ><span class="glyphicon glyphicon-save"></span>Aceptar</button>

                    </td>

                </tr>
            </table></div>
    </form>


</div>
