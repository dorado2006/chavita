
<script>
    $("#erick").datepicker({'dateFormat': 'yy-mm-dd'});
    $(function () {
        $("#guardar_reprogramacion").click(function () {
            var dataString = $('#edit_credi').serialize();
            var condipappp = $("#idcondpago option:selected").html();
            condipap = condipappp.replace(/\s+/g, '');
            dni_cliente = $("#dnicl").val();

            $.post('../web/index.php', dataString + '&condipap=' + condipap, function (data) {
                console.log(data);

            });
            $.post('../web/index.php', 'controller=cobranza&action=cargar_datos_formulario_detalle&idcliente=' + dni_cliente, function (data) {
                console.log(data);
                $("#detalle").empty().append(data);
            });

            $("#dialogo3").dialog("close");
        });
    });

</script>
<form id="edit_credi" method="post">
    <input type="hidden" name="controller" value="cobranza" />
    <input type="hidden" name="action" value="reprogramacion" />
    <input type="hidden" name="dnicl" size="10" id="dnicl" value="<?php echo $rows[0]['dni'] ?>" >

    <table class="container_table_edp" border="1">
        <tr>             
            <td style=" text-align: left; width: 40%">FECHA COMPRA</td>
            <td><input type="text" name="fechc" size="10" id="fechc" value="<?php echo $rows[0]['fecha_mov'] ?>" readonly>
                <input type="hidden" name="idproce" size="10" id="idproce" value="<?php echo $rows[0]['idproceso_cobro'] ?>" >
            </td>
        </tr>
        <tr>             
            <td style=" text-align: left; width: 40%">CREDITO</td>
            <td><input type="text" name="credit" size="10" id="credit" value="<?php echo $rows[0]['credito'] ?>" ></td>
        </tr>
        <tr>             
            <td style=" text-align: left; width: 40%">CUOTA</td>
            <td><input type="text" name="cuat" size="10" id="cuat" value="<?php echo $rows[0]['letra'] ?>" ></td>
        </tr>
        <tr>             
            <td style=" text-align: left; width: 40%">MESES</td>
            <td><input type="text" name="mesess" size="10" id="mesess" value="<?php echo $rows[0]['num_cuotas'] ?>" ></td>
        </tr>
        <tr>
            <td style=" text-align: left; width: 40%">FRECUENCIA</td>
            <td class="filas"> 
                <?php if ($rows[0]['frecuencia_msg'] == 'DIARIO') { ?>
                    D<input type="radio" name="frecuenci_msj[]" value="DIARIO" checked>
                    S<input type="radio" name="frecuenci_msj[]" value="SEMANAL">
                    Q<input type="radio" name="frecuenci_msj[]" value="QUINCENA">
                    M<input type="radio" name="frecuenci_msj[]" value="MENSUAL">
                <?php } elseif ($rows[0]['frecuencia_msg'] == 'SEMANAL') {
                    ?>
                    D<input type="radio" name="frecuenci_msj[]" value="DIARIO">
                    S<input type="radio" name="frecuenci_msj[]" value="SEMANAL" checked>
                    Q<input type="radio" name="frecuenci_msj[]" value="QUINCENA">
                    M<input type="radio" name="frecuenci_msj[]" value="MENSUAL">
                <?php } elseif ($rows[0]['frecuencia_msg'] == 'QUINCENAL') {
                    ?>
                    D<input type="radio" name="frecuenci_msj[]" value="DIARIO">
                    S<input type="radio" name="frecuenci_msj[]" value="SEMANAL">
                    Q<input type="radio" name="frecuenci_msj[]" value="QUINCENA" checked>
                    M<input type="radio" name="frecuenci_msj[]" value="MENSUAL">
                <?php } elseif ($rows[0]['frecuencia_msg'] == 'MENSUAL') {
                    ?>
                    D<input type="radio" name="frecuenci_msj[]" value="DIARIO">
                    S<input type="radio" name="frecuenci_msj[]" value="SEMANAL">
                    Q<input type="radio" name="frecuenci_msj[]" value="QUINCENA">
                    M<input type="radio" name="frecuenci_msj[]" value="MENSUAL" checked>
                <?php
                } else {
                    ?>
                    D<input type="radio" name="frecuenci_msj[]" value="DIARIO">
                    S<input type="radio" name="frecuenci_msj[]" value="SEMANAL">
                    Q<input type="radio" name="frecuenci_msj[]" value="QUINCENA">
                    M<input type="radio" name="frecuenci_msj[]" value="MENSUAL">
                <?php }
                ?>



            </td>
        </tr>
        <tr>             
            <td style=" text-align: left; width: 40%">AMORTIZACION</td>
            <td><input type="text" name="amort" size="10" id="amort" value="<?php echo $rows[0]['abono'] ?>" readonly></td>
        </tr>
        <tr>             
            <td style=" text-align: left; width: 40%">SALDO</td>
            <td><input type="text" name="sald" size="10" id="sald" value="<?php echo $rows[0]['saldo'] ?>" readonly></td>
        </tr>
        <tr>             
            <td style=" text-align: left; width: 40%">PRODUCTO</td>
            <td><input type="text" name="prod"  id="prod" value="<?php echo $rows[0]['producto'] ?>" readonly></td>
        </tr>
        <tr>             
            <td style=" text-align: left; width: 40%">CONDICION</td>
            <td>    <?php echo $condpago ?></td>

        </tr>
        <tr>             
            <td style=" text-align: left; width: 40%">FECH INICIO PAGO</td>
            <td><input type="text" size="10" class="form-control" id="erick" name="fecha_pago" value="<?php echo $rows[0]['a_partir_de'] ?>"  ></td>
        </tr>


    </table>
    <div id="guardar_reprogramacion" class=" guardar_reprogramacion boton ">Guardar</div>
</form>