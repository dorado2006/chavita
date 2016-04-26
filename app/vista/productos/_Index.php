<script>
    $(function() {
        $(".ok").click(function() {
            cadena = $(this).val();
            var pedazo = cadena.split(",");
            idproductos = pedazo[0];
            nombre = pedazo[1];
            precio = pedazo[2];
            categoria = pedazo[3];
            stock=pedazo[4];
            opener.document.getElementById('nombre_producto').value = nombre;
            opener.document.getElementById('idproductos').value = idproductos;
            opener.document.getElementById('precio').value = precio;
            opener.document.getElementById('categoria').value = categoria;
            opener.document.getElementById('stock').value = stock;
            opener.document.getElementById('stock_bd').value = stock;
            window.close();
        });
    });
</script>
<br>
<div class="table-responsive" style="overflow-y: auto; max-height: 300px;">
    <table width="100%" border="1" cellpadding="3" cellspacing="1"  class="table table-bordered table-hover">
        <tr class="info">
            <td><strong>CATEGORIA</strong></td> 
            <td><strong>NOMBRE</strong></td>  	
            <td><strong>PRECIO DE VENTA</strong></td>
            <td><strong>STOCK</strong></td>
            <td><strong>COMISION S/.</strong></td>
            <td align="center"><strong>ACCION</strong></td>

        </tr>
        <?php
        if (empty($rows)) {
            echo "<tr><td colspan='6' style='font-weight: bold;color:blue;text-align:center;'>Sin datos de coincidencia</td></tr>";
        } else {
            ?>
            <?php foreach ($rows as $data): ?>		
                <tr>
                    <td><?php echo strtoupper($data['categoria']); ?></td>		   
                    <td><?php echo strtoupper($data['nombre']); ?></td>
                    <td><?php echo $data['precio_venta']; ?></td>
                    <td><?php echo strtoupper($data['stock']); ?></td>
                    <td><?php echo $data['comision_venta']; ?></td>

                    <td align='center'>
                        <button class="btn btn-success glyphicon glyphicon-check ok"  name="ok" value="<?php echo $data['idproductos'] . ',' . $data['nombre'] . ',' . $data['precio_venta']. ',' . $data['categoria'].','.$data['stock']; ?>">&nbsp;OK</button>
                    </td>
                </tr>
                <?php
            endforeach;
        }
        ?>
    </table>
</div>