<br>
<!--<table border="0" cellspacing="3" cellpadding="0" class="tabla" width="100%">-->
    <table width="100%" border="1" cellpadding="3" cellspacing="1"  class="tabla table-bordered table-hover">
    
		 <tr>
	    	<th>id</th>
	    	
	    	<th>nombres</th>
	    	<th>apellidos </th>
                <th>dni</th>
                <th>telefonos</th>
                <th>perfil</th>
                <th>direccion</th>
                <th width="100">Lug_trabajo</th>
                <th>Accion</th>
              
                
		  </tr>
                  <?php if(empty($rows)){echo "<tr><td colspan='9' style='font-weight: bold;color:blue;text-align:center;'>Sin datos de coincidencia</td></tr>";} else {?>
	   <?php foreach ($rows as $data): ?>		
	   <tr>
	       <td><?php echo ($data['idcliente']);?></td>		   
               <td><?php echo utf8_encode($data['nombres']);?></td>
	       <td><?php echo utf8_encode($data['apellidos']);?></td>
	       <td><?php echo $data['dni'];?></td>
               <td><?php  echo utf8_encode($data['telefonos']);?></td>
               <td><?php  echo utf8_encode($data['pertenece']);?></td>
               <td><?php  echo utf8_encode($data['direccion']);?></td>
               <td><?php echo utf8_encode($data['trabaja']);?></td>
               
               <td align='center'>
                  
                <a href="../web/index.php?controller=cobranza&action=buscar_ventas_credito&idcliente=<?php echo ($data['idcliente']);?>&cliente=<?php echo utf8_encode($data['nombres'])." - ".utf8_encode($data['apellidos']); ?>" class='btn btn-mini btn-success glyphicon glyphicon-shopping-cart'>COMPRAS</a>
              
                <!--<a href='?id=$id' class='btn btn-mini btn-warning' >ver </a>-->
               <!-- <a href='javascript:void(0)' onclick='eliminar($id);' class='btn btn-mini btn-danger'>Eliminar</a> -->
            </td>
</tr>
                  <?php endforeach; }?>
	</table>