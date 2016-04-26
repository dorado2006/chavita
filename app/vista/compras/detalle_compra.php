<script>
    $(function() {
        $(".btndelete").click(function() {

            var data = $(this).attr('identrada');
            var separador = data.split(",");
            identrda = separador[0];
            fechaingreso = separador[3];
            Comp_pago = separador[1];
            numdocume = separador[2];
            $.post('../web/index.php', 'controller=compras&action=entrdadelete&identrda=' + identrda + '&fechaingreso=' + fechaingreso + '&Comp_pago=' + Comp_pago + '&numdocume=' + numdocume, function(data) {
                console.log(data);
                $("#cuerpo_compra").empty().append(data);
            });

        });


        $("#actualizar_estadoproducto").click(function() {

            var data = $('.btndelete').attr('identrada');
           
            var separador = data.split(",");
            identrda = separador[0];
            fechaingreso = separador[3];
            Comp_pago = separador[1];
            numdocume = separador[2];
            $.post('../web/index.php', 'controller=compras&action=actuestadoproducto&fechaingreso=' + fechaingreso + '&Comp_pago=' + Comp_pago + '&numdocume=' + numdocume, function(data) {
                console.log(data);
                $("#cuerpo_compra").empty().append(data);
            });
            
            $('.foco').val('');
            $('.txtocup').val('');
            
        });

    });
</script> 

<table border="1" width="100%" style="background: #92EA6E;font-size: 15px;font-family: Times New Roman; text-align: center">
    <tr style=" background-color: #EF662A ; font-size: 20px">
        <td colspan="5" ><b>DETALLE</b></td>

    </tr>
    <tr>
        <td style="width: 10%">CANTIDAD</td>
        <td style="width: 60%">DETALLE</td>
        <td style="width: 10%">PRECIO COMPRA</td>
        <td style="width: 10%">SUB TOTAL</td>
        <td style="width: 10%">ACCION</td>
    </tr>
    <?php
    $sumat = 0;
    foreach ($rows as $datos):
        $sumat = $sumat + $datos['subtotal'];
        ?>
        <tr>
            <td> <?php echo $datos['cantidad']; ?>   </td>    
            <td> <?php echo $datos['detalle']; ?>   </td>  
            <td> <?php echo $datos['precio_compra']; ?>   </td>  
            <td> <?php echo $datos['subtotal']; ?>   </td> 
            <td>
                <button class="btn btn-mini btn-danger btndelete" identrada="<?php echo $datos['identrada'] . "," . $datos['tipo_documeto'] . "," . $datos['numero_docum'] . "," . $datos['fecha_entrada']; ?>" > <span class="glyphicon glyphicon-trash eliminapago"></span></button>
                <button class="btn btn-mini btn-info"> <span class="glyphicon glyphicon-edit eliminapago"></span></button>

            </td>

        </tr>
    <?php endforeach; ?>

    <tr>
        <td></td>
        <td></td>
        <td>TOTAL</td>
        <td><?php echo $sumat; ?></td>

    </tr>
</table>

<div style="position: fixed;
     bottom: 245px;
     right:  50px;
     width: auto;
     height: auto;
     height: 50px;
     margin: auto;font-family: serif "> 
    <button class="btn btn-warning btn-sm" id="actualizar_estadoproducto" ><span class="glyphicon glyphicon-save">TERMINAR Y GUARDAR LA COMPRA</span></button></div>