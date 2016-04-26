<script>
    $(function () {

        $("#save").click(function () {
            if ($('#idpersonal').val().trim() === '') {
                alertify.error("ELIGA AL VENDEDOR");
            } else {
                cant = eval($("#cantidad").val());
                stock = eval($("#stock").val());

                var dataString = $('#frm').serialize();
                $.post('../web/index.php', dataString, function (data) {
                    alertify.success(data.msj);
                }, 'json');
              
                $("#stock").val(eval(stock) - eval(cant));
                $('.actbot').removeClass("active").addClass("disabled");
            }
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

        $('#cantidad').keyup(function () {
            cant = eval($(this).val());           
            opciones=$('input:radio[name=opciones]:checked').val();
            
            if(opciones=='ALM.OFICINA'){
                stock = eval($("#stockof").val());
            }
            else{
               stock = eval($("#stockalm").val()); 
            }
            if (cant <= stock && cant > 0) {
                $('.actbot').removeClass("disabled").addClass("active");
            }
            else {
                $('.actbot').removeClass("active").addClass("disabled");
                alertify.error("LA CANTIDAD SOBRE PASA EL STOCK");
            }

        });

    });
</script>
<?php
//Ejemplo curso PHP aprenderaprogramar.com
$time = time();
echo date("d-m-Y (H:i:s)", $time);
?>
<form action="../web/index.php" method="post" id="frm">
    <input type="hidden" name="controller" value="compras">
    <input type="hidden" name="action" value="producto_salida"> 
    <input type="hidden" name="idproduc" value="<?php echo $rows[0]['idproductos'] ?>"> 
    <input type="hidden" name="updat" value="updat">
    <div class="form-group">
        <label for="CATEGORIA" class="col-lg-3 control-label">CATEGORIA</label>
        <div class="col-lg-9">
            <input type="text" name="categoria" class="form-control" id="CATEGORIA"  value="<?php echo $rows[0]['categoria'] ?>"
                   placeholder="PRODUCTO" readonly>

        </div>
    </div>
    <div class="form-group">
        <label for="PRODUCTO" class="col-lg-3 control-label">PRODUCTO</label>
        <div class="col-lg-9">
            <input type="text" name="producto" class="form-control" id="PRODUCTO"  value="<?php echo $rows[0]['nombre_pr'] ?>"
                   placeholder="PRODUCTO" readonly>
        </div>
    </div>
    <div class="form-group">
        <label for="descripcion" class="col-lg-3 control-label">DESCRIPCION</label>
        <div class="col-lg-4">
            <textarea class="form-control" rows="2" id="descripcion" readonly><?php echo $rows[0]['descripcion'] ?></textarea>

        </div>
        <label for="COLOR" class="col-lg-1 control-label">COLOR</label>
        <div class="col-lg-2">
            <input name="color" class="form-control" id="descripcion" value="<?php echo $rows[0]['color'] ?>"  placeholder="COLOR" readonly>
        </div>
    </div>
    <div class="form-group">
        <label for="marca" class="col-lg-3 control-label">MARCA</label>
        <div class="col-lg-4">
            <input name="marca" class="form-control" id="marca" value="<?php echo $rows[0]['marca'] ?>"  placeholder="MARCA" readonly>
        </div>
        <label for="modelo" class="col-lg-1 control-label">MODEL</label>
        <div class="col-lg-4">
            <input name="modelo" class="form-control" id="modelo" value="<?php echo $rows[0]['modelo'] ?>"  placeholder="MODELO" readonly>
        </div>
    </div>
    <div  style="background-color: #d9edf7">
    <div class="form-group">
        <label for="condd" class="col-lg-3 control-label">VENDEDOR</label>
        <div class="col-lg-9">
            <?php echo $personal ?>
        </div>
    </div>

    <div class="form-group">
        <label for="cantidad" class="col-lg-3 control-label">CANTIDAD</label>
        <div class="col-lg-3">
            <input name="cantidad" class="form-control" id="cantidad"  placeholder="CANTIDAD">
        </div>
        <label class="col-lg-3">
            <input type="radio" name="opciones" class="opciones_1" value="ALM.OFICINA" checked >
            ALM.OFICINA
        </label>
        <label class="col-lg-3">
            <input type="radio" name="opciones" class="opciones_1" value="ALM.ALMACEN"  >
            ALM.ALMACEN
        </label>
    </div>
    </div>

    <div class="form-group">
        <label for="preciosv" class="col-lg-3 control-label">PRECIOS DE VENTA</label>
        <div class="col-lg-9">
            <input name="preciosv" class="form-control" id="preciosv" value="<?php echo $rows[0]['precio_venta'] ?>"  placeholder="ejem. 180x12M-200x8S...." readonly>
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
    <div class="form-group">
        <label for="website" class="col-lg-3 control-label">WEB</label>
        <div class="col-lg-2">
<!--            <input name="website" class="form-control" id="website" value="<?php //echo $rows[0]['webite']      ?>"  placeholder="STOCK" readonly>-->
            <h4>      <a href="<?php echo $rows[0]['webite'] ?>" target="_blank" 
                         ><span class="label label-info">MOSTRAR IMAGEN</span></a></h4>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-6">
        </div>

        <div class="col-lg-2">
            <button type="submit" class="btn btn-success disabled actbot" id="save">ACTUALIZAR</button>
        </div>
    </div>

</form>
