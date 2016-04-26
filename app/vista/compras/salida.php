<style>
    .ui-autocomplete .highlight {
        text-decoration: underline;
    }
    .bgmenualma{background-color: #3676D6}
</style>
<script>
    $(function () {

        function highlightText(text, $node) {
            var searchText = $.trim(text).toLowerCase(), currentNode = $node.get(0).firstChild, matchIndex, newTextNode, newSpanNode;
            while ((matchIndex = currentNode.data.toLowerCase().indexOf(searchText)) >= 0) {
                newTextNode = currentNode.splitText(matchIndex);
                currentNode = newTextNode.splitText(searchText.length);
                newSpanNode = document.createElement("span");
                newSpanNode.className = "highlight";
                currentNode.parentNode.insertBefore(newSpanNode, currentNode);
                newSpanNode.appendChild(newTextNode);
            }
        }
        var data = <?php echo json_encode($rows); ?>;

        $("#autocomplete1").autocomplete({
            source: data
        });
        $("#tags").autocomplete({
            source: data,
            focus: function (event, ui) {
                // prevent autocomplete from updating the textbox
                event.preventDefault();
                // manually update the textbox
                $(this).val(ui.item.label);
            },
            select: function (event, ui) {
                // prevent autocomplete from updating the textbox
                event.preventDefault();
                // manually update the textbox and hidden field
                $(this).val(ui.item.label);
                $("#tagsaa").val(ui.item.value);
                $.post("../web/index.php", "controller=compras&action=form_salida&idprod=" + ui.item.value, function (data) {

                    console.log(data.msg);
                    $("#mostrar_data").empty().append(data);

                });
            }
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            var $a = $("<a></a>").text(item.label);
            highlightText(this.term, $a);
            return $("<li></li>").append($a).appendTo(ul);
        };

        $("#nuevo").click(function () {

            $.post("../web/index.php", "controller=compras&action=form_nuevproduc", function (data) {

                console.log(data.msg);
                $("#mostrar_data").empty().append(data);

            });
        });
        $(".limpiar").click(function () {
            $("#tags").val("");
            $("#tags").focus();
        });
    });
</script>
<!--<div class="row">
    <div class="col-sm-1"></div>
    <fieldset class="fieldset2 col-sm-3">
        <legend style="margin-bottom: 0px;">MOVIMIENTO</legend>
        <ul class="nav nav-tabs">
            <li ><a href="#" class="bgmenualma" ><img src="../web/assets/avatars/entrada.jpg" alt=""/></a></li>
            <li ><a href="#" class="bgmenualma" ><img src="../web/assets/avatars/salida.jpg" alt=""/></a></li>

        </ul>
    </fieldset>
    
    <fieldset class="fieldset col-sm-3" style="margin-bottom: 20px;">
        <legend style="margin-bottom: 0px;">PRODUCTO</legend>
        <ul class="nav nav-tabs">
            <li ><a href="#" class="bgmenualma" ><img src="../web/assets/avatars/NUEVO.jpg" alt=""/></a></li>
            <li ><a href="#" class="bgmenualma" ><img src="../web/assets/avatars/EDITAR.jpg" alt=""/></a></li>

        </ul>
    </fieldset>
      
    <fieldset class="fieldset col-sm-5" style="margin-bottom: 20px;">
        <legend style="margin-bottom: 0px;">REPORTES</legend>
        <ul class="nav nav-tabs">
            <li ><a href="#" class="bgmenualma" ><img src="../web/assets/avatars/entrada.jpg" alt=""/></a></li>
            <li ><a href="#" class="bgmenualma" ><img src="../web/assets/avatars/salida.jpg" alt=""/></a></li>
 <li ><a href="#" class="bgmenualma" ><img src="../web/assets/avatars/entrada.jpg" alt=""/></a></li>
            <li ><a href="#" class="bgmenualma" ><img src="../web/assets/avatars/salida.jpg" alt=""/></a></li>
        </ul>
    </fieldset>
</div>-->
<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-6 ">
        <div class="panel panel-success">
            <div class="panel-heading">REGISTRAR SALIDA</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group" buscad>
                        <label for="tags" class="col-lg-3 control-label ">BUSCAR</label>
                        <div class="col-lg-9">                            
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="form-control-feedback glyphicon glyphicon-search"></i></span>
                                <input type="text" name="BUSCAR" class="form-control" id="tags" placeholder="INGRESE EL PRODUCTO">
                                <span class="input-group-addon limpiar">
                                    <i class="form-control-feedback glyphicon glyphicon-remove"></i></span>

                            </div>
                        </div>
                    </div>
                    <div  id="mostrar_data"></div>
                </form>
            </div>
        </div>
    </div>
    <!--    <div class="col-lg-5">
            <div class="panel panel-info">
                <div class="panel-heading">SALIDA DE PRODUCTOS POR VENDEDOR</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label for="BUSCAR" class="col-lg-3 control-label ">BUSCAR VENDEDOR</label>
                            <div class="col-lg-9">                            
                                <div class="input-group">
                                    <input type="text" name="BUSCAR" class="form-control" id="BUSCAR">
                                    <span class="input-group-btn">
                                        <button class="btn btn-success btn-sm" type="button" id="BUSCAR">Buscar</button>
                                    </span>
                                </div>
                            </div>
                        </div>
    
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="2">
                                    <tr class="active">
                                        <th width="5%">CANT.</th>
                                        <th width="75%">DESCRIPCION</th>
                                        <th width="20%">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>John</td>
                                        <td>Doe</td>
                                        <td>john@example.com</td>
                                    </tr>
                                    <tr>
                                        <td>Mary</td>
                                        <td>Moe</td>
                                        <td>mary@example.com</td>
                                    </tr>
                                    <tr>
                                        <td>July</td>
                                        <td>Dooley</td>
                                        <td>july@example.com</td>
                                    </tr>
                                </tbody>
    
                            </table>
                        </div>
    
                    </form>
                </div>
            </div>
    
        </div>-->
</div>





<!--
<style>
    #contreporte{border: 1px #000 groove;
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
        width: 95%;
        padding: 0 14px;
        background-color: #FFF;
        //border: 2px solid #5cb85c;
        position: absolute; 
        left: 16px; 
        top: 210px; 
        filter:alpha(opacity=0)
    }
    .ace-settings-box label{font-size: 10px;}

    .ace-settings-boxprod {
        display: none;
        float: left;
        width: 95%;
        padding: 0 14px;
        background-color: #FFF;
        //border: 2px solid #5cb85c;
        position: absolute; 
        left: 16px; 
        top: 335px; 
        filter:alpha(opacity=0)
    }

    .ace-settings-boxserie {
        display: none;
        float: left;
        width: 40%;
        padding: 0 14px;
        background-color: #FFF;
        //border: 2px solid #5cb85c;
        position: absolute; 
        left: 500px; 
        top: 360px; 
        filter:alpha(opacity=0)
    }

    #newcategoria {
        display: none;
        float: left;

    }

    #cuerpo_compra {
        width: 100%;
        height: 40%;
        overflow-y: scroll;

    }
    .txtocup{
        background-color: #CCfccf;
        color: rgb(17, 184, 178);
        font-weight:  bold;
        text-align: center;
    }

    .buscador{

        background-position: left center;

        padding-left: 50px;
        background-image: url(../web/img/buscar.png);

        height: 30px;

        background-repeat: no-repeat;

    }
</style>

<script>
    $(function() {

        $("#buspr").keyup(function() {
            var busc = $(this).val();

            $.post('../web/index.php', 'controller=compras&action=salida_buscaroficina&busc=' + busc, function(data) {
                console.log(data);
                $("#divocultamuestra").empty().append(data);
            });

            $("#divocultamuestra").css("display", "block");


        });

        $("#busproducto").keyup(function() {
            var busc = $(this).val();

            $.post('../web/index.php', 'controller=compras&action=buscarproducto&busc=' + busc, function(data) {
                console.log(data);
                $("#divocultamuestraprod").empty().append(data);
            });

            $("#divocultamuestraprod").css("display", "block");

        });

        $("#buscserie").keyup(function() {
            var busc = $(this).val();
            var idproduc = $('#idproducto').val();


            $.post('../web/index.php', 'controller=compras&action=salida_prodxserie&busc=' + busc + '&idproduc=' + idproduc, function(data) {
                console.log(data);
                $("#divocultamuestraserie").empty().append(data);
            });

            $("#divocultamuestraserie").css("display", "block");

        });


        $("#idtipo_documento").change(function() {

            var idtipod = $(this).val();

            $.post('../web/index.php', 'controller=compras&action=buscanumeracion&idtipod=' + idtipod, function(data) {
                console.log(data);
                $("#numeracion").empty().append(data);
            });

        });


        $("#agregasalida").click(function() {
            var idproducto = eval($("#idproducto").val());
            var stok = eval($("#stock").val());
            var cant = eval($("#cant").val());
            //idoficina = $('#idprovedor').val();
            serie = $('#identra').val();
            tip_do = $('#idtipo_documento').val();

            if (cant >= 1 && cant<=stok) {

                if (idproducto == '' || serie == '' || tip_do == '') {
                    alert("VERIFICA QUE ESTE ELEGIDO: TIP_DOCUMENTO,PRODUCTO");
                }
                else {

                    var dataString = $('#form_entrdaalmacen').serialize();
                    // alert('Datos serializados: ' + dataString);
                    $.post('../web/index.php', dataString, function(data) {
                        console.log(data);
                        $("#cuerpo_compra").empty().append(data);
                    });
//
//                    $.post('../web/index.php', 'controller=compras&action=controlstock&idproducto=' + idproducto, function(data) {
//                        console.log(data);
//                        $("#controstock").empty().append(data);
//                    });
                    $('.vacio').val('');
                    $('#cant').val('1');

//
////
//                    var quedastock = stok - cant;
//                    $("#stock").val(quedastock);

                }


            }
            else {
                alert("LA CANTIDAD DEBE SER:  1<= CANTIDAD <= STOCK");
            }
//            $.post('../web/index.php', 'controller=compras&action=controlstock&idproducto=' + idproducto, function(data) {
//                console.log(data);
//
//                $("#controstock").empty().append(data);
//
//            });



        });


        $("#nuevoproveed").click(function() {

            var dataString = $('#form_producto').serialize();
            $.post('../web/index.php', dataString, function(data) {
                console.log(data);
                //$("#detalle").empty().append(data);
            });
            $('#MyModal_nuev_proev').modal('toggle');

        });


        $("#nuevoproducto").click(function() {

            var dataString = $('#form_producto').serialize();
            $.post('../web/index.php', dataString, function(data) {
                console.log(data);
                //$("#detalle").empty().append(data);
            });
            $('#MyModal_nuev_producto').modal('toggle');

        });

        $("#nuevacategoria").click(function() {


            $("#newcategoria").css("display", "block");


        });



        $("#activarnumer").click(function() {
            alert("INGRESE LA NUMERACION QUE SE QUEDO. !SI TE EQUIVOCASTE CON ESTE BOTON..ACTUALIZA F5!");
            $('.actreanly').attr('readonly', false);
        });

        $("#ingresancateg").click(function() {

            var dataString = $('#form_nuevacategoria').serialize();
            var ctg = $('#nucateg').val();
            var ctgdesc = $('#nuecatgdesc').val();

            $.post('../web/index.php', 'controller=compras&action=nuevacategoria&categ=' + ctg + '&desccatego=' + ctgdesc, function(data) {
                console.log(data);
                $("#cargacatego").empty().append(data);
            });
            $("#newcategoria").css("display", "none");

        });

        $("#fechaingreso").datepicker({'dateFormat': 'yy-mm-dd'});

        $(".foco").focus(function() {
            $(this).css("background-color", "#cccccc");
        });
        $(".foco").blur(function() {
            $(this).css("background-color", "#F4B6BB");
        });

    });


</script>
<script type="text/javascript">
    $('#form_prov').quickValidate({
        'errorRequired': '$name is a required field'
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


<div id="contreporte">
    <div id="cabezareporte" class="cabezareporte" style="text-align: center">

        <form id="form_proveedor" method="post">
            <input type="hidden" name="controller" value="compras" />
            <input type="hidden" name="action" value="nuevoproveedor" />
             Inicio de Modal de Editar Cliente 
            <div class="modal fade " id="MyModal_nuev_proev" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true" >
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel2">NUEVO PROVEEDOR</h4>
                        </div>
                        <div class="modal-body" >
                            <table border="0" width="100%" id="actualizar_cliente" class="actualizar_cliente table"  style="background: #CCfccf;font-size: 15px;font-family: Times New Roman">

                                <tr>
                                    <td colspan="7" style=" background-color:  #FACAAD"><b>DATOS DEL PROVEEDOR</b></td>
                                </tr>
                                <tr>
                                    <td>EMPRESA</td>
                                    <td colspan="4"><input type="text" style=" width: 95%" name="empresa" class="foco"></td>
                                    <td>RUC</td>
                                    <td><input type="text" style=" width: 90%" name="ruc" class="foco"></td>

                                </tr>
                                <tr>
                                    <td>DIRECCIÓN</td>
                                    <td colspan="4" ><input type="text" style=" width: 95%" name="direccion" class="foco"></td>                                    
                                    <td></td>
                                    <td></td>

                                </tr>
                                <tr>
                                    <td>NOMBRES</td>
                                    <td colspan="4" ><input type="text" style=" width: 95%" name="proveed" class="foco"></td>
                                    <td>DNI</td>
                                    <td><input type="text" style=" width: 90%" name="dni" class="foco"></td>

                                </tr>
                                <tr>
                                    <td>APELLIDO P</td>
                                    <td colspan="4" ><input type="text" style=" width: 95%" name="apellidop" class="foco"></td>
                                    <td></td>
                                    <td></td>

                                </tr>
                                <tr>
                                    <td>APELLIDO M </td>
                                    <td colspan="4" ><input type="text" style=" width: 95%" name="apellidom" class="foco"></td>
                                    <td></td>
                                    <td></td>

                                </tr>

                                <tr>
                                    <td>CORREO</td>
                                    <td colspan="4" ><input type="text" style=" width: 95%" name="correo" class="foco"></td>

                                    <td></td>
                                    <td></td>
                                </tr> 
                                <tr>
                                    <td>TELEFONO1</td>
                                    <td><input type="text" style=" width: 90%" name="tlf1" class="foco"></td>
                                    <td>TELEFONO2</td>
                                    <td><input type="text" style=" width: 90%" name="tlf2" class="foco"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="7">
                                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#myMod" id="nuevoproveed" ><span class="glyphicon glyphicon-save"></span>Aceptar</button>

                                    </td>
                                </tr>
                            </table>

                        </div>  termina el body                    
                    </div> /.modal-content 
                </div> /.modal-dialog 
            </div> /.modal 
        </form>


        <form id="form_entrdaalmacen" method="post" >
            <input type="hidden" name="controller" value="compras" />
            <input type="hidden" name="action" value="salida_almacen" />
            <table border="0" width="100%"  style="background: #CCfccf;font-size: 15px;font-family: Times New Roman;padding-top: 79px">

                <tr style=" background-color:  #FACAAD; font-size: 15px">
                    <td colspan="6" ><b>DATOS GENERALES</b></td>
                    <td><div><button class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModnum" id="activarnumer" ><span class="glyphicon glyphicon-save"></span>COMPLETAR SALIDA INTERRUMPIDA</button></div></td>

                </tr>
                <tr>
                    <td colspan="2" style="width: 40%"><input type="search" name="mibusca" id="buspr" placeholder="BUSCAR OFICINA" style=" width: 90%" class="buscador"></td>
                    <td colspan="2" style="width: 10%" >
                        <button class="btn btn-info btn-sm"  id="editar_cl" title="Editar Cliente" data-toggle="modal" data-target="#MyModal_nuev_proev"><span class="glyphicon glyphicon-pencil  "></span>NUEVO</button>

                    </td>
                    <td colspan="5"  style=" text-align:left"> 

                        <b> FECHA:</b><input type="text" id="fechaingreso" name="fechaingreso"  value="<?php echo date("Y-m-d"); ?>" size="10" class="foco"> 
                    </td>  
                    <td>  
                        <b> TIPO DOCUM:</b></td>
                    <td>
<?php //echo $t_documento; ?>

                    </td>
                    <td  style=" text-align: center">
                        <div id="numeracion"> 
                            <b>Nº DOCUMENTO</b><input type="text" size="5" name="numdocume" class="foco actreanly" readonly value="<?php echo $rows[0]['num_estado_isalmacen']; ?>"  id="num_docm">
                        </div>
                    </td>

                </tr>
                <tr>
                    <td  style="width: 5%"><b>SUCURSAL</b></td>
                    <td colspan="2"><input type="text" id="empresa" style="width: 100%" class="txtocup" readonly=""></td>
                    <td style="width: 5%;text-align: right"><b>OFICINA</b></td>
                    <td><input type="text" name="ruc" id="ruc" class="txtocup" readonly=""></td>
                    <td>   <input type="hidden" name="idoficina" id="idprovedor" class="novacio"></td>
                    <td></td>

                </tr>

                <tr>
                    <td colspan="7">&nbsp;</td>


                </tr>         

            </table>

            <table border="0" width="100%" style="background: #CCfccf;font-size: 15px;font-family: Times New Roman">

                <tr>
                    <td colspan="7" style=" background-color:  #FACAAD ; font-size: 15px"><b>DATOS DEL PRODUCTO</b></td>

                </tr>
                <tr>
                    <td colspan="2" style=" width: 31%"><input type="search" name="mibusca" id="busproducto" placeholder="BUSCAR PRODUCTO" style=" width: 90%" class="buscador"></td>
                    <td colspan="5">                       
                    </td>

                </tr>
                <tr>
                    <td><b>CATEGORIA</b></td>
                    <td><input type="text" style=" width: 90%" id="categ" class="txtocup vacio" readonly=""></td>
                    <td><b>MARCA</b></td>
                    <td><input type="text" style=" width: 90%" id="marca" class="txtocup vacio" readonly=""></td>
                    <td><b>MODELO</b></td>
                    <td><input type="text" style=" width: 90%" id="modelo" class="txtocup vacio" readonly=""></td>
                    <td><input type="hidden" name="idproducto" id="idproducto" class="vacio novacio"></td>
                </tr>
                <tr>
                    <td>
                        <b>STOCK</b>
                    </td>
                    <td>
                        <div id="controstock"> 
                            <input type="text" style=" width: 90%" name="STOCK"  id="stock" class="txtocup vacio" >
                        </div>
                    </td> 
                     <b>SERIE</b></td>
                   <td><input type="text" style=" width: 90%" name="serie" class="foco vacio" id="buscserie" placeholder="BUSCAR SERIE">
                        <input type="hidden" name="identra" id="identra" class="vacio novacio">
                                   
                    <td ><b>CANTIDAD</b></td>
                    <td><input type="text"   name="cantidad" class="focot" id="cant"  value="1"></td>
                    <td>
                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModee"  id="agregasalida" ><span class="glyphicon glyphicon-shopping-cart"></span>AGREGAR</button>
                    </td>
                    <td colspan="2"></td>
                </tr>
                <tr><td colspan="7">&nbsp;</td></tr>


            </table>
        </form>



        <div class="ace-settings-box" id="divocultamuestra"> 

        </div>
        <div class="ace-settings-boxprod" id="divocultamuestraprod"> 

        </div>
        <div class="ace-settings-boxserie" id="divocultamuestraserie"> 

        </div>

    </div>
    <div id="cuerpo_compra" style="border: 1px #002a80 solid ">



    </div>
</div>-->
