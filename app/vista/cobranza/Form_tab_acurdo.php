<script>
    $(function() {

        $('.calificar_radius2').click(function() {
            idacuerdo = $(this).attr("idacuerdo");
            var dni_a = $('#dni_a').val();
            valor = $(this).attr("valor");
            $("#msg").html('<strong style="color:blue">Guardando ....</strong>');
            $.post('../web/index.php', 'controller=cobranza&action=actualizar_acuerdo&idacuerdo=' + idacuerdo + '&valor=' + valor + '&idcliente='+dni_a, function(data) {
                console.log(data);
                $("#msg").html('');
                $("#detall_acuerdo").empty().append(data);
            });

        });
        $('.eliminacuerdo2').click(function() {
            idacuerdo = $(this).attr("idacuerdo");
            valor = $(this).attr("valor");
            var dni_a = $('#dni_a').val();

            if (confirm('¿Estas seguro de Eliminar?')) {
                $("#msg").html('<strong style="color:blue">Guardando ....</strong>');
                $.post('../web/index.php', 'controller=cobranza&action=elimina_acuerdo&idacuerdo=' + idacuerdo + '&valor=' + valor, function(data) {
                    console.log(data);
                    $("#msg").html('');
                });
                $.post('../web/index.php', 'controller=cobranza&action=formulario_acuerdo_detall&idcliente=' + dni_a, function(data) {
                    console.log(data);
                    $("#detall_acuerdo").empty().append(data);
                });
            }
            else {

            }

        });
    });
</script>
<table border="1" width="100%" style="font-size: 12px" >
    <tr style="background-color:  #d6487e;font-family:  fantasy">

        <td style="text-align: right" colspan="11">[  0-50 ]&nbsp;&nbsp;[ 51-80 ]&nbsp;&nbsp;[ 81-100 ][%] </td>
    </tr>
    <tr style="background-color: #F39814">
        <th width="2%">Nº</th>       
        <th width="30%">ACUERDO</th>
        <th width="8%">F-VISITA</th>
        <th width="8%">F-PAGO</th>
        <th width="6%">Hora</th>                                
        <th width="10%">FRECUENCIA</th>
        <th width="8%">PAGO EN:</th>
        <th width="10%">PERSONAL</th>
         <th width="10%">FUENTE</th>
        <th width="10%">Califica</th>
    </tr>
    <?php foreach ($rows as $key => $data): ?>


        <tr>
            <td><?php echo ($key + 1); ?></td>            
            <td><?php echo $data['acuerdos']; ?></td>
            <td><?php echo $data['fecha_visita']; ?></td>
            <td><input type="hidden" id="<?php echo "fech".$key; ?>" value="<?php echo $data['fecha_verificacion']; ?>"><?php echo $data['fecha_verificacion']; ?></td>
            <td><?php echo $data['hora']; ?></td>
            <td><?php echo $data['frecuencia_msj']; ?></td>
            <td><?php echo $data['pagoen']; ?></td>
            <td><?php echo $data['personal']; ?></td>
            <td><?php echo $data['fuente']; ?></td>
            <td><?php if ($data['calificacion'] == 1) { ?>
                    1<input type="radio" idacuerdo="<?php echo $data['idacuerdos']; ?>" valor="1" name="<?php echo$key ?>cal[]" class="calificar_radius2" checked>2<input type="radio" idacuerdo="<?php echo $data['idacuerdos']; ?>" valor="2" name="<?php echo$key ?>cal[]" class="calificar_radius2" >3<input type="radio" idacuerdo="<?php echo $data['idacuerdos']; ?>" valor="3" name="<?php echo$key ?>cal[]" class="calificar_radius2" >
                <?php } elseif ($data['calificacion'] == 2) {
                    ?>
                    1<input type="radio" idacuerdo="<?php echo $data['idacuerdos']; ?>" valor="1" name="<?php echo$key ?>cal[]" class="calificar_radius2" >2<input type="radio" idacuerdo="<?php echo $data['idacuerdos']; ?>" valor="2" name="<?php echo$key ?>cal[]" class="calificar_radius2" checked>3<input type="radio" idacuerdo="<?php echo $data['idacuerdos']; ?>" valor="3" name="<?php echo$key ?>cal[]" class="calificar_radius2" >

                <?php } elseif ($data['calificacion'] == 3) {
                    ?>
                    1<input type="radio" idacuerdo="<?php echo $data['idacuerdos']; ?>" valor="1" name="<?php echo$key ?>cal[]" class="calificar_radius2" >2<input type="radio" idacuerdo="<?php echo $data['idacuerdos']; ?>" valor="2" name="<?php echo$key ?>cal[]" class="calificar_radius2" >3<input type="radio" idacuerdo="<?php echo $data['idacuerdos']; ?>" valor="3" name="<?php echo$key ?>cal[]" class="calificar_radius2" checked>

                <?php } else {
                    ?><input type="hidden" name="bandera" value="ok" id="bandera">
                    1<input type="radio" idacuerdo="<?php echo $data['idacuerdos']; ?>" valor="1" name="<?php echo$key ?>cal[]" class="calificar_radius2" >2<input type="radio" idacuerdo="<?php echo $data['idacuerdos']; ?>" valor="2" name="<?php echo$key ?>cal[]" class="calificar_radius2" >3<input type="radio" idacuerdo="<?php echo $data['idacuerdos']; ?>" valor="3" name="<?php echo$key ?>cal[]" class="calificar_radius2" >

                <?php } ?>
            </td>
            <td>
                <span class="glyphicon glyphicon-trash eliminacuerdo2" idacuerdo="<?php echo $data['idacuerdos']; ?>"></span>
            </td>
        </tr>
        <?php
    endforeach;
    ?>
</table>