<script>
    $(function () {

        $("#save").click(function () {
            // $("#frm").submit();
            var dataString = $('#frm').serialize();
            $.post('../web/index.php', dataString, function (data) {
                alertify.success(data.msj);
                cant = eval($("#cantidad").val());
                stock = eval($("#stock").val());
                $("#stock").val(eval(stock) + eval(cant));
            }, 'json');
            $('.actbot').removeClass("active").addClass("disabled");
            return false;
        });
          $("#upda").click(function () {
            // $("#frm").submit();
            var dataString = $('#frm').serialize();
            $.post('../web/index.php', dataString, function (data) {
                alertify.success(data.msj);
                cant = eval($("#cantidad").val());
                stock = eval($("#stock").val());
                $("#stock").val(eval(stock) + eval(cant));
            }, 'json');
            $('.actbot').removeClass("active").addClass("disabled");
            return false;
        });
        
        $("#condd").click(function () {
            con = $(this).val();
            if (con == 'DEVO_C') {
                $('.oculto').show();

            }
            else {
                $('.oculto').hide();
            }


        });
        ///actu_producto-------------------

        $('#cantidad').keyup(function () {
            cant = eval($(this).val());
            if (cant > 0) {
                $('.actbot').removeClass("disabled").addClass("active");
            }
            else {
                $('.actbot').removeClass("active").addClass("disabled");
                // alertify.error("LA CANTIDAD SOBRE PASA EL STOCK");
            }

        });
        
         $('.opciones_1').click(function () {
            if($(this).val()=='ingre_prod'){
                $('.oculto_up').show();
                $('.oculto_up_b').hide();
                  $('.re_only').attr('readonly','readonly');
            }
            else{
                $('.oculto_up').hide();
                $('.oculto_up_b').show();
                $('.re_only').removeAttr('readonly');
            }
             
         });

    });
</script>
<?php
//Ejemplo curso PHP aprenderaprogramar.com
//$time = time();
//echo date("d-m-Y (H:i:s)", $time);
?>
<div class="alert alert-danger">


    <div class="form-group" >
        <label for="cantidad" class="col-lg-6 control-label">QUE LO QUE QUIERES HACER??</label>

        <label class="col-lg-3">
            <input type="radio" name="opciones" class="opciones_1" value="ingre_prod" checked>
            INGRESAR PRODUCTO
        </label>
        <label class="col-lg-3">
            <input type="radio" name="opciones" class="opciones_1" value="upd_prod" >
            EDITAR PRODUCTO
        </label>
    </div>
</div>
<form action="../web/index.php" method="post" id="frm">
    <input type="hidden" name="controller" value="compras">
    <input type="hidden" name="action" value="guardar_producto"> 
    <input type="hidden" name="idproduc" value="<?php echo $rows[0]['idproductos'] ?>"> 
    <input type="hidden" name="updat" value="updat">
    <input type="hidden" name="updat_prod" value="updat_prod">
    <div class="form-group">
        <label for="CATEGORIA" class="col-lg-3 control-label">CATEGORIA</label>
        <div class="col-lg-9">
<!--            <input type="text" name="categoria" class="form-control" id="CATEGORIA"  value="<?php echo $rows[0]['categoria'] ?>"
                   placeholder="PRODUCTO" readonly>-->
            <select class="form-control re_only" name="subcateg" readonly>
                <?php
                $con = 0;

                foreach ($rows2 as $categoria):
                    foreach ($categoria as $subcategoria):
                        if ($subcategoria['idcategoria'] == $rows2[$con][0][0]) {
                            ?>
                            <optgroup label="<?php echo $subcategoria['categoria']; ?>">
                                <?php
                            } else {
                                if ($rows[0]['idcategoria'] != $subcategoria['idcategoria']) {
                                    ?>
                                    <option  value="<?php echo $subcategoria['idcategoria'] ?>"><?php echo $subcategoria['categoria'] ?></option>
                                <?php } else {
                                    ?>
                                    <option selected="selected" value="<?php echo $subcategoria['idcategoria'] ?>"><?php echo $subcategoria['categoria'] ?></option>
                                <?php }
                            }
                            ?>
                        </optgroup>
                        <?php
                    endforeach;
                    $con++;
                endforeach;
                ?>

            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="PRODUCTO" class="col-lg-3 control-label">PRODUCTO</label>
        <div class="col-lg-9">
            <input type="text" name="producto" class="form-control re_only" id="PRODUCTO"  value="<?php echo $rows[0]['nombre_pr'] ?>"
                   placeholder="PRODUCTO" readonly >
        </div>
    </div>
    <div class="form-group">
        <label for="descripcion" class="col-lg-3 control-label">DESCRIPCION</label>
        <div class="col-lg-4">
            <textarea class="form-control re_only" rows="2" id="descripcion" name="descrip" readonly ><?php echo $rows[0]['descripcion'] ?></textarea>

        </div>
        <label for="COLOR" class="col-lg-1 control-label">COLOR</label>
        <div class="col-lg-2">
            <input name="color" class="form-control re_only" id="descripcion" value="<?php echo $rows[0]['color'] ?>"  placeholder="COLOR" readonly>
        </div>
    </div>
    <div class="form-group">
        <label for="marca" class="col-lg-3 control-label">MARCA</label>
        <div class="col-lg-4">
            <input name="marca" class="form-control re_only" id="marca" value="<?php echo $rows[0]['marca'] ?>"  placeholder="MARCA" readonly>
        </div>
        <label for="modelo" class="col-lg-1 control-label">MODEL</label>
        <div class="col-lg-4">
            <input name="modelo" class="form-control re_only" id="modelo" value="<?php echo $rows[0]['modelo'] ?>"  placeholder="MODELO" readonly>
        </div>

    </div>
    
    <div class="oculto_up" >
        <div  style="background-color: #d9edf7">
        <div class="form-group">
            <label for="condd" class="col-lg-3 control-label">CONDICION</label>
            <div class="col-lg-9">
                <select class="form-control" name="condd" id="condd">
                    <option value="NUEVO">NUEVO</option>
                    <option value="FALLA">FALLA</option>
                    <option value="DEVO_C">DEVOLUCION CLIENTE</option>

                </select>
            </div>
        </div>

        <div class="form-group oculto" style="display:none;">
            <label for="dnicliente" class="col-lg-3 control-label">DNI CLIENTE</label>
            <div class="col-lg-9">
                <input name="dnicliente" class="form-control" id="dnicliente"  placeholder="DNI">
            </div>
        </div>
        <div class="form-group">
            <label for="cantidad" class="col-lg-3 control-label">CANTIDAD</label>
            <div class="col-lg-3">
                <input name="cantidad" class="form-control" id="cantidad"  placeholder="CANTIDAD">
            </div>
            <label class="col-lg-3">
                <input type="radio" name="opciones" id="opciones_1" value="ALM.OFICINA" checked>
                ALM.OFICINA
            </label>
            <label class="col-lg-3">
                <input type="radio" name="opciones" id="opciones_1" value="ALM.ALMACEN" checked>
                ALM.ALMACEN
            </label>
        </div>

        <div class="form-group">
            <label for="preciosv" class="col-lg-3 control-label">PRECIOS DE VENTA</label>
            <div class="col-lg-9">
                <input name="preciosv" class="form-control" id="preciosv" value="<?php echo $rows[0]['precio_venta'] ?>"  placeholder="ejem. 180x12-200x8....">
            </div>
        </div>
    </div>
        <div class="form-group">
            <label for="stock" class="col-lg-3 control-label">STOCK</label>        
            <label for="stockof" class="col-lg-3 control-label">OFICINA</label>
            <div class="col-lg-2">
                <input name="stock" class="form-control" id="stockof" value="<?php echo $rows[0]['stock_of'] ?>"  placeholder="STOCK" readonly>
            </div>
            <label for="stockalm" class="col-lg-2 control-label">ALMACEN</label>
            <div class="col-lg-2">
                <input name="stock" class="form-control" id="stockalm" value="<?php echo $rows[0]['stock'] ?>"  placeholder="STOCK" readonly>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="website" class="col-lg-3 control-label">WEB</label>
        <div class="col-lg-9">
            <input name="website" class="form-control re_only" id="website" value="<?php echo $rows[0]['webite'] ?>"  placeholder="SITIO WEB" readonly>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-6">
        </div>

        <div class="col-lg-2 oculto_up">
            <button type="submit" class="btn btn-success disabled actbot" id="save">ACTUALIZAR</button>

        </div>
        <div class="col-lg-2 oculto_up_b" style="display:none;">
            <button type="submit" class="btn btn-danger " id="upda">ACTUALIZAR</button>
        </div>
    </div>

</form>