<?php
$monto_letra = $_POST['monto_letra'];
$n_letras = $_POST['n_letras'];
$fecha_inicio_pago = $_POST['fecha_inicio_pago'];
$c_dias = $_POST['c_dias'];
$condicion_pago = $_POST['condicion_pago'];
$abonar_p = $_POST['abonar_p'];
//echo $monto_letra."-".$n_letras."-".$fecha_inicio_pago."-".$c_dias
?>
<table width="100%" border="1" cellpadding="3" cellspacing="1" id="t_cronograma_pagos" name="t_cronograma_pagos" class="table table-bordered">
    <thead class="ui-widget ui-widget-content">
        <tr class="ui-widget-header" >                            
            <th width="3%">CUOTA</th>
            <th width="20%">F.PAGO</th>         
            <th width="30%">ESTADO</th>
            <th width="27%">AMORTIZA S/.</th>
            <th width="20%">CUOTA S/.</th>


        </tr>
    </thead>
    <tbody>
        <?php
        $fech_pago = $fecha_inicio_pago;
        $montoab = (int) ($abonar_p / $monto_letra);
        $montopeq = (int) ((($abonar_p/ $monto_letra) - $montoab) * $monto_letra);
        $cont = 1;
        for ($i = 0; $i < $n_letras; $i++) {
            $filas = "<tr>";
            $filas = $filas . "<td align='center'><input type='hidden'name='nro_cuota[]' value='" . ($i + 1) . "'>" . ($i + 1) . "</td>";
            $filas = $filas . "<td><input type='hidden' name='fecha_vencimiento[]'  value='" . $fech_pago . "'>" . $fech_pago . "</td>";
            if ($cont <= $montoab) {
                $filas = $filas . "<td><input type='hidden' name='estado[]'  value='CANCELADO'>CANCELADO</td>";
                $filas = $filas . "<td><input type='hidden' name='abonoletr[]'  value='".$monto_letra."'> $monto_letra </td>";

                $cont++;
            } else {
                if ($cont == ($montoab + 1)) {
                     $filas = $filas . "<td></td>";
                    $filas = $filas . "<td><input type='hidden' name='abonoletr[]'  value='".$montopeq.".00'>$montopeq.00</td>"; 
                    $cont ++;
                } else {
                    $filas = $filas . "<td></td>";
                    $filas = $filas . "<td></td>";
                }
            }
           // $filas = $filas . "<td><input type='text' id='monto_venta' style='text-align:right;' class='form-control' onKeypress='if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;' value='" . $monto_letra . "'></td>";
  $filas = $filas . "<td><input type='hidden' name='montlet[]'  value='".$monto_letra."'>$monto_letra</td>";

            $filas = $filas . "</tr>";
            echo $filas;
            $fech_pago = date("Y/m/d", strtotime($fech_pago . "+ " . $c_dias . " day"));
        }
        ?>
        <tr style="text-align: right;">
            <td colspan="3"><strong>TOTAL</strong></td>
              <td><strong>S/.<?php echo (int)($abonar_p); ?></strong></td>
            <td><strong>S/.<?php echo (int)($n_letras * $monto_letra); ?></strong></td>
        </tr>

    </tbody>
</table> 