<script> 
    $(function() {
        $(".ok").click(function() {
             cadena = $(this).val();
             var pedazo = cadena.split(",");
             idcliente = pedazo[0];
             nombres = pedazo[1];    
             convenio = pedazo[2];  
             opener.document.getElementById('idcliente').value = idcliente;
             opener.document.getElementById('cliente').value = nombres;
             opener.document.getElementById('convenio').value = convenio;   
             window.close();
        });
    });
</script>
<br>
<div class="table-responsive" style="overflow-y: auto; max-height: 300px;">
    <table width="100%" border="1" cellpadding="3" cellspacing="1"  class="table table-bordered table-hover">
        <tr class="danger">
            <td><strong>DNI</strong></td>
            <td><strong>NOMBRES</strong></td>  	
            <td><strong>APELLIDOS</strong></td>
            <!--<td><strong>SEXO</strong></td>-->
            <td><strong>DIRECCION</strong></td>
            <td><strong>DISTRITO</strong></td>
            <td><strong>ACCION</strong></td>


        </tr>
        <?php
        if (empty($rows)) {
            echo "<tr><td colspan='5' style='font-weight: bold;color:blue;text-align:center;'>Sin datos de coincidencia</td></tr>";
        } else {
            ?>
    <?php foreach ($rows as $data): ?>		
                <tr>
                    <td><?php echo strtoupper($data['dni']); ?></td>		   
                    <td><?php echo strtoupper($data['nombres']); ?></td>
                    <td title="APELLIDOS"><?php echo utf8_encode($data['apellidos']); ?></td>
                    <!--<td title="COD MODULAR"><?php // echo $data['sexo']; ?></td>-->
                    <td title="DIRECCION"><?php echo utf8_encode(strtoupper($data['dir_actual'])); ?></td>
                    <td title="DISTRITO"><?php echo utf8_encode($data['distrito']); ?></td>

                    <td align='center'>
                        <button class="btn btn-success glyphicon glyphicon-check ok"  name="ok" value="<?php echo $data['idcliente'].','.$data['nombres'].' '.$data['apellidos'].','.$data['convenio']; ?>">&nbsp;OK</button>
                    </td>
                </tr>
            <?php
            endforeach;
        }
        ?>
    </table>
</div>