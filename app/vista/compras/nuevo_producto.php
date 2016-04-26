<script>
    $(function () {

        $("#save").click(function () {
            //$("#frm").submit();
            var dataString = $('#frm').serialize();
            $.post('../web/index.php', dataString, function (data) {
                alertify.success(data.msj);
            }, 'json');
           $('.actbot').removeClass("active").addClass("disabled");
            
            return false;
        });
        
        
        $('#cantidad').keyup(function () {
            cant = eval($(this).val());
            if (cant>0) {
                $('.actbot').removeClass("disabled").addClass("active");
            }
            else {
                $('.actbot').removeClass("active").addClass("disabled");
               // alertify.error("LA CANTIDAD SOBRE PASA EL STOCK");
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
    <input type="hidden" name="action" value="guardar_producto">  
    <div class="form-group">
        <label for="CATEGORIA" class="col-lg-3 control-label">CATEGORIA</label>
        <div class="col-lg-9">

            <select class="form-control" name="subcateg">
                <?php
                $con = 0;

                foreach ($rows as $categoria):
                    foreach ($categoria as $subcategoria):
                        if ($subcategoria['idcategoria'] == $rows[$con][0][0]) {
                            ?>
                            <optgroup label="<?php echo $subcategoria['categoria']; ?>">
                            <?php } else { ?>
                                <option value="<?php echo $subcategoria['idcategoria'] ?>"><?php echo $subcategoria['categoria'] ?></option>
                            <?php } ?>
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
            <input type="text" name="producto" class="form-control" id="PRODUCTO"  value="<?php echo $rows[0]['nombre_pr'] ?>"
                   placeholder="PRODUCTO">
        </div>
    </div>
    <div class="form-group">
        <label for="descripcion" class="col-lg-3 control-label">DESCRIPCION</label>
        <div class="col-lg-4">
            <textarea class="form-control" rows="2" name="descripcion" id="descripcion"><?php echo $rows[0]['descripcion'] ?></textarea>

        </div>
        <label for="COLOR" class="col-lg-1 control-label">COLOR</label>
        <div class="col-lg-2">
            <input name="color" class="form-control" id="descripcion" value="<?php echo $rows[0]['color'] ?>"  placeholder="COLOR">
        </div>
    </div>
    <div class="form-group">
        <label for="marca" class="col-lg-3 control-label">MARCA</label>
        <div class="col-lg-4">
            <input name="marca" class="form-control" id="marca" value="<?php echo $rows[0]['marca'] ?>"  placeholder="MARCA">
        </div>
        <label for="modelo" class="col-lg-1 control-label">MODEL</label>
        <div class="col-lg-4">
            <input name="modelo" class="form-control" id="modelo" value="<?php echo $rows[0]['modelo'] ?>"  placeholder="MODELO">
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
    <!--    <div class="form-group">
            <label for="stock" class="col-lg-3 control-label">STOCK</label>
            <div class="col-lg-9">
                <input name="stock" class="form-control" id="stock" value="<?php echo $rows[0]['stock'] ?>"  placeholder="STOCK">
            </div>
        </div>-->
    <div class="form-group">
        <label for="website" class="col-lg-3 control-label">WEB</label>
        <div class="col-lg-9">
            <input name="website" class="form-control" id="website" value="<?php echo $rows[0]['stock'] ?>"  placeholder="SITIO WEB">
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-6">
        </div>
        <div class="col-lg-3">
            <button type="submit" class="btn btn-success disabled actbot" id="save">GUARDAR</button>

        </div>

    </div>
</form>