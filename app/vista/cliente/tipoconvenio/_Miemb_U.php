<script>
    $(function() {
        $(".ok").click(function() {
             cadena = $(this).val();
             var pedazo = cadena.split(",");
             idugel = pedazo[0];
             nombres = pedazo[1];
             var nomb=nombres.split(" ");
             primer_nombre=nomb[0];
             segundo_nombre=nomb[1];
             if(segundo_nombre!= null){document.getElementById('segundo_nombre').value = segundo_nombre;}
             apellido_p = pedazo[2];
             apellido_m = pedazo[3];
             dni = pedazo[4];
             
             document.getElementById('primer_nombre').value = primer_nombre;
             document.getElementById('apellido_p').value = apellido_p;
             document.getElementById('apellido_m').value = apellido_m;
             document.getElementById('dni').value = dni;
             $("#adicional").css("display", "none");
             
        });
    });
</script>
<br>
<div class="table-responsive" style="overflow-y: auto; max-height: 300px;">
    <table width="100%" border="1" cellpadding="3" cellspacing="1"  class="table table-bordered table-hover">
        <tr class="danger">
            <td><strong>NOMBRES</strong></td>
            <td><strong>APPELLIDOS</strong></td>  	
            <td><strong>DNI</strong></td>
            <td><strong>COD MODULAR</strong></td>
            <td><strong>Accion</strong></td>


        </tr>
        <?php
        if (empty($rows)) {
            echo "<tr><td colspan='5' style='font-weight: bold;color:blue;text-align:center;'>Sin datos de coincidencia</td></tr>";
        } else {
            ?>
    <?php foreach ($rows as $data): ?>		
                <tr>
                    <td><?php echo strtoupper($data['nombres']); ?></td>		   
                    <td><?php echo strtoupper($data['apellidos']); ?></td>
                    <td title="DNI"><?php echo $data['dni']; ?></td>
                    <td title="COD MODULAR"><?php echo $data['codmod']; ?></td>

                    <td align='center'>
                        <button type="button" class="btn btn-success glyphicon glyphicon-check ok"  name="ok" value="<?php echo strtoupper($data['idugel'].",".$data['nombres'].",".$data['apellido_p'].",".$data['apellido_m'].",".$data['dni']); ?>">&nbsp;OK</button>
                    </td>
                </tr>
            <?php
            endforeach;
        }
        ?>
    </table>
</div>