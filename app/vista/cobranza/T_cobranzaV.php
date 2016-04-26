 

<div class="msj" style="background-color: #dff0d8;color: rgb(233, 101, 50);text-align: center"><b style="color: #093 ">CLIENTE: </b> <strong><?php echo $_GET['cliente'];?></strong></div>

<table width="100%" border="1" cellpadding="3" cellspacing="1"  class="tabla table-bordered table-hover"  >

    <tr>
        <th></th>
        <th>id</th>
        <th>fecha venta</th>        
        <th>Nº cuotas</th>
        <th>cuota</th>
        <th>total </th>
        <th>AMORTIZA</th>
        <th>resto</th>
        <th>Estado</th>
        <th>vendedor</th>
        <th>Accion</th>


    </tr>
    
    <?php  $amortiza=0;$resto=0;
    foreach ($rows as $data):
        $resto=$data['total']-$data['amortiza'];
        ?>		
        <tr>
            <td><input type="checkbox"></td>
            <td><?php echo $data['idventa']; ?></td>
            <td><?php echo $data['fecha_venta']; ?></td>            
            <td><?php echo $data['num_cuota']; ?></td>
            <td><?php echo $data['monto_cuota']; ?></td>
            <td><?php echo $data['total']; ?></td>
            <td><?php echo $data['amortiza']; ?></td>
            <td><?php echo $resto ?></td>            
            <td><?php echo $data['estado']; ?></td>
            <td><?php echo $data['vendedor']; ?></td>

            <td align='center'>
                <a href="../web/index.php?controller=cobranza&action=buscar_pagare&idventa=<?php echo ($data['idventa']); ?>&cliente=<?php echo $_GET['cliente']; ?>" class='btn btn-mini btn-success glyphicon glyphicon-usd'>&nbsp;Pagar</a>
                <!-- <a href='?id=$id' class='btn btn-mini btn-warning'>Editar </a>
                 <a href='javascript:void(0)' onclick='eliminar($id);' class='btn btn-mini btn-danger'>Eliminar</a> -->
            </td>
        </tr>
    <?php 
    $total=$total+$data['total'];
    $amortiza=$amortiza+$data['amortiza'];
    $restot=$total-$amortiza;
    endforeach; ?>
    <tr>
   <td colspan="3" style=" color: #ffffff; background-color: #093;text-spacing: 205px"><b>TOTALES</b> </td>
   <td colspan="3" style=" color: #ffffff; background-color: #093;text-spacing: 205px"><b><?php echo "$total";?></b> </td>
<td colspan="1" style=" color: #ffffff; background-color: #093;text-spacing: 205px"><b><?php echo "$amortiza" ?> </b> </td>
<td colspan="1" style=" color: #ffffff; background-color: #093;text-spacing: 205px"><b><?php echo "$restot" ?></b> </td>
<td colspan="3" style=" color: #ffffff; background-color: #093;text-spacing: 205px"><b></b> </td>

    </tr>
    
  
</table>
<input type="button" value="REPROGRAMAR">
