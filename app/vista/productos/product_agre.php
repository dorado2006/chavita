<script>
    $(function() {
        $(".cancelar").click(function() {
            iddetalletemporal = $(this).val();
            $.post('../web/index.php', 'controller=productos&action=delete_DetalleTemp_prod&iddetalletemporal=' + iddetalletemporal, function(data) {
                console.log(data);
                $("#produc_agrega").empty().append(data);
            });
            parent.document.getElementById('iframe_podcuc_agrega').contentWindow.location.reload(true);
        });

    });
</script>
<br>
<div class="table-responsive" style="overflow-y: auto; max-height: 250px;">
    <table width="100%" border="1" cellpadding="3" cellspacing="1"  class="table table-bordered table-hover">
        <tr class="info">
            <td><strong>CATEGORIA</strong></td> 
            <td><strong>NOMBRE</strong></td>  	
            <td><strong>CANTIDAD</strong></td>
            <td><strong>PRECIO</strong></td>
            <td><strong>SUBTOTAL S/.</strong></td>
            <td align="center"><strong>ACCION</strong></td>

        </tr>
        <?php
        if (empty($rows)) {
            echo "<tr><td colspan='6' style='font-weight: bold;color:blue;text-align:center;'>No Hay Productos Agregados</td></tr>";
        } else { $total=0;
            ?>
            <?php foreach ($rows as $data):  $Total=$Total+$data['subtotal'];?>		
                <tr>
                    <td><?php echo strtoupper($data['categoria']); ?></td>		   
                    <td><?php echo strtoupper($data['nombre']); ?></td>
                    <td><?php echo $data['cantidad']; ?></td>
                    <td align="right"><?php echo strtoupper($data['precio']); ?></td>
                    <td align="right"><?php echo $data['subtotal']; ?></td>

                    <td align='center'>
                        <button type="button" class="btn btn-success glyphicon glyphicon-check cancelar"  name="cancelar" value="<?php echo $data['iddetalletemporal'] ;?> ">&nbsp;CANCELAR</button>
                    </td>
                </tr>
                <?php
            endforeach;
        }
        ?>
        <tr align="right">
            <td colspan="4" ><strong>Total S/.</strong></td>
            <td><input type="hidden" id="total" name="total"value="<?php echo $Total;?>"><strong><?php echo $Total;?></strong></td>
        </tr>       
    </table>
</div>