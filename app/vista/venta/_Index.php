<script>
    $(function() {
        $("#fecha_venta").datepicker({'dateFormat': 'yy/mm/dd'});
        $("#nuevo_cliente").click(function() {
            popup('index.php?controller=cliente&action=create', 860, 700);
        });
        $("#editar").click(function() {
            idcliente = $("#idcliente").val();
            if (idcliente == "") {
                document.getElementById('cliente').style.border = '1px  solid red';
            }
            else {
                popup('index.php?controller=cliente&action=edit&id=' + idcliente, 860, 500);
            }
        });
        $("#buscar").click(function() {
            popup('index.php?controller=cliente&action=buscador2', 860, 500);
        });
        $("#buscar_productos").click(function() {
            popup('index.php?controller=productos&action=mostrar_buscador', 860, 500);
        });
//        $.post('../web/index.php', 'controller=productos&action=mostrar_datos_det_temp', function(data) {
//            console.log(data);
//            $("#produc_agrega").empty().append(data);
//        });
        $("#save").click(function() {
            $("#frm").submit();
            return false;
        });
        
        $("#agregar").click(function() {
            idproductos = $("#idproductos").val();
            cantidad = $("#cantidad").val();
            precio = $("#precio").val();
            categoria = $("#categoria").val();
            if (cantidad == "") {
//          alert('ingrese la catidad');   
            $().informar('ingrese la catidad') ; 
            }
            else {
                $.post('../web/index.php', 'controller=productos&action=add_DetalleTemp_prod&idproductos=' + idproductos + '&cantidad=' + cantidad + '&precio=' + precio + '&categoria=' + categoria, function(data) {
                    console.log(data);
                    $("#produc_agrega").empty().append(data);
                });
            }
        });
        $("#idtipo_pago").change(function() {
            idtipo_pago = $(this).val();
            if (idtipo_pago == '1') {
                $(".tipo_comprob").css("display", "");
                $(".numero_comprobante").css("display", "");
                $(".numero_contrato").css("display", "none");
            }
            else {
                $(".tipo_comprob").css("display", "none");
                $(".numero_comprobante").css("display", "none");
                $(".numero_contrato").css("display", "");
            }
        });
        $("#cancelar_venta").click(function() {
            $.post('../web/index.php', 'controller=productos&action=delete_DetalleTemp_prod', function(data) {
                console.log(data);
                $("#produc_agrega").empty().append(data);
            });
        });
        $("#cantidad").keyup(function() {
            stock_bd = $("#stock_bd").val();
            cantidad = $(this).val();
            stock = stock_bd - cantidad;
            if (stock < 0) {
                alert('No Hay Suficientes Unidades');
            } else {
                document.getElementById('stock').value = stock;
            }
        });

    });
</script>
<div align="center" class="contenidopadding">    
    <form action="../web/index.php" method="post" id="frm">
        <input type="hidden" name="controller" value="venta">
        <input type="hidden" name="action" value="save"> 
        <table width="60%" border="1" cellpadding="3" cellspacing="1"  class="table table-bordered">
            <tr>
                <td colspan="3" align="center" class="success"><strong>Resgistro De Ventas</strong></td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="form-group col-sm-3"> 
                        <div class="input-group"> 
                            <span class="input-group-addon">Fecha</span>                     
                            <input type="text" class="form-control" id="fecha_venta" name="fecha_venta" value="<?php echo date("Y-m-d"); ?>" size="20" >
                        </div> 
                    </div>
                    <div class="form-group col-sm-3"> 
                        <div class="input-group"> 
                            <span class="input-group-addon">Tipo de pago</span>                     
                            <?php echo $tipopago; ?>
                        </div> 
                    </div>
                    <div class="form-group col-sm-3">                  
                        <div class="tipo_comprob" style="display: none;">
                            <div class="input-group"> 
                                <span class="input-group-addon">Tipo Comprobante</span>
                                <?php echo $tipocomprobante; ?>
                            </div> 
                        </div>
                        <div class="numero_contrato" style="display: none;">
                            <div class="input-group"> 
                                <span class="input-group-addon">Nº Contrato</span>
                                <input type="text" class="form-control" id="idnumero_contrato"  name="idnumero_contrato" size="10">
                            </div>
                        </div>

                    </div>
                    <div class="form-group col-sm-3"> 
                        <div class="numero_comprobante" style="display: none;">
                            <div class="input-group"> 
                                <span class="input-group-addon">NºComprobante</span>                     
                                <input type="text" class="form-control" id="idnumero_comprobante"  name="idnumero_comprobante" size="10">
                            </div> 
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="left" width="75%">
                    <div class="form-group col-sm-7"> 
                        <div class="input-group"> 
                            <span class="input-group-addon">cliente</span>   
                            <input type="text" title="Nombre Del Cliente" name="cliente" id="cliente"  class="form-control" size="30" readonly="">                      
                        </div>
                    </div>
                    <div class="form-group col-sm-5"> 
                        <input type="hidden" name="idcliente" id="idcliente">
                        <button type="button" title="buscar"   id="buscar" name="buscar" class="btn btn-primary glyphicon glyphicon-search"></button>
                        <button type="button"  id="nuevo_cliente" name="nuevo_cliente" class="btn btn-primary glyphicon glyphicon-user">&nbsp;Nuevo</button>
                        <button type="button" title="editar"   id="editar" name="editar" class="btn btn-primary glyphicon glyphicon-pencil"></button>                   
                    </div>
                </td>
                <td width="13%" align="center">Convenio</td> 
                <td align="center" > <input type="text" title="Convenio" name="convenio" id="convenio"  class="form-control" size="30" ></td>
            </tr>
            <tr>
                <td  colspan="3">  
                    <div class="form-group col-sm-3"> 
                        <div class="input-group"> 
                            <span class="input-group-addon">Producto</span>
                            <input type="text" class="form-control" id="nombre_producto" name="nombre_producto"  size="30">
                        </div>
                    </div>
                    <div class=" form-group col-sm-1">
                        <div class="input-group"> 
                            <button type="button" class="btn btn-success btn-sm glyphicon glyphicon-search" id="buscar_productos"> Buscar</button>
                            <input type="hidden" id="idproductos" name="idproductos">
                            <input type="hidden" id="categoria" name="categoria">
                        </div>
                    </div>
                    <div class="col-sm-8"> 

                        <div class="form-group col-lg-3"> 
                            <div class="input-group"> 
                                <span class="input-group-addon">Cantidad</span>
                                <input type="text" class="form-control"  type="text" id="cantidad" name="cantidad"  size="3" maxlength="3">
                            </div>
                        </div>
                        <div class="form-group col-sm-4"> 
                            <div class="input-group"> 
                                <span class="input-group-addon">Precio S/.</span>
                                <input type="text" class="form-control"  type="text" id="precio" name="precio"  size="10">
                            </div>
                        </div>
                        <div class=" form-group col-sm-3"> 
                            <div class="input-group">
                                <span class="input-group-addon">Stock</span>
                                <input type="text" class="form-control" placeholder="Stock" id="stock" name="stock"  size="1"> 
                                <input type="hidden" id="stock_bd" name="stock_bd" value="">
                            </div>   
                        </div> 
                        <div class=" col-sm-2"> 
                            <button type="button" class="btn btn-success btn-sm glyphicon glyphicon-check " id="agregar" name="agregar" >&nbsp;AGREGAR</button> 
                        </div> 
                    </div>
                </td>
            </tr> 
            <tr>
                <td colspan="3"><strong>Lista De Productos Agregados</strong>
                    <div id="produc_agrega"name="produc_agrega" align="center">
                        <iframe id="iframe_podcuc_agrega" name="iframe_podcuc_agrega" src="index.php?controller=productos&action=mostrar_datos_det_temp" width="100%" height="120%"  marginwidth="0" noresize scrolling="No" frameborder="0">
                        </iframe>
                        <!--<br><br><strong>Cargandooo Carrito....</strong><br><br>-->
                    </div>
                </td> 

            </tr>
            <tr>
                <td colspan="3" align="center">
                    <a class="btn btn-success glyphicon glyphicon-floppy-saved" id="save" name="save" >&nbsp;ACEPTAR</a>
                    <a class="btn btn-warning glyphicon glyphicon-remove " id="cancelar_venta" name="cancelar_venta" style="margin-left: 30px;">&nbsp;CANCELAR</a>
                </td>
            </tr>
        </table>
    </form>
</div>