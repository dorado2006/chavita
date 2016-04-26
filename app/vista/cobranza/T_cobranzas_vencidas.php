
<script >

    $(function() {
   $(".filt").click(function() { 
         
        bval = true;
        
        if (bval) {
            $("#frm").submit();
        }
        return false;
    });
    
    $(".botonExcel").click(function(event) {
		$("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
		$("#FormularioExportacion").submit();
});
    
    });
 
    
</script>


<div class="msj" style="background-color: #dff0d8;color: rgb(233, 101, 50);text-align: center"><b style="color: #093 ">FILTRAR</b> <strong><?php echo $_GET['cliente'];?></strong>
    <form id="frm" action="../web/index.php" method="post">
        <input type="hidden" name="controller" value="cobranza">
    <input type="hidden" name="action" value="cobranzas_vencidas">
    <table width="100%" style=" text-align: left; color:  #ff0000  ">
        <tr>
            <td>[1 - 5] Días<input type="radio" value="f1" name="filtro" class="filt"></td>
            <td>[6 - 10] Días <input type="radio" value="f2"  name="filtro" class="filt"></td>
            <td>[11 - 20] Días  <input type="radio" value="f3"  name="filtro" class="filt"></td>
            <td>[21 - 30] Días<input type="radio" value="f4"  name="filtro" class="filt"></td>
            <td>[31 - 45]Días <input type="radio" value="f5"  name="filtro" class="filt"></td>
            <td>[46 - 60] Días  <input type="radio" value="f6"  name="filtro" class="filt"></td>
            <td>[61 - 90] Días<input type="radio" value="f7"  name="filtro" class="filt"></td>
            <td>MÁS DE 90<input type="radio" value="f8"  name="filtro" class="filt"></td>
             
    </tr>
    </table>
        </form>
    <form action="../app/vista/cobranza/exportar_excel.php" method="post" target="_blank" id="FormularioExportacion">
                <p>Exportar<img src="../web/img/excel.gif " class="botonExcel" /></p>                
                <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
                </form>

</div>
<div id ="tabla">

<table width="100%" border="0" cellpadding="" cellspacing=""  class="tabla table-bordered table-hover" id="Exportar_a_Excel" >

    <tr>
        
        
        <th>nombres</th>
        <th>apellidos </th>
        <th>dni</th>
        <th>telefonos</th>
        <th>perfil</th>
        <th>direccion</th>
        <th width="100">Lug_trabajo</th>
        <th>fecha vencimiento</th>        
        <th>dias retrasado</th>


    </tr>
    
    <?php    function diferenciaDias($inicio, $fin)
                    {
                        $inicio = strtotime($inicio);
                        $fin =  strtotime($fin);
                        $dif = $fin - $inicio;
                        $diasFalt = (( ( $dif / 60 ) / 60 ) / 24);
                        return ceil($diasFalt);
                    }
                    
    foreach ($rows as $data):
        
        ?>		
        <tr>
            
                      
              <?php $fechaI=$data['fecha_vencimiento']; 
             // $fechaI=$data['fecha_abono'];
                        
               if (empty($_POST['filtro']) and empty($_POST['fn'])){
                   $dias=diferenciaDias($fechaI,date("Y-m-d"));
               if($dias>=-1){
               
               ?>
            
               <td><?php echo utf8_encode($data['nombres']);?></td>
	       <td><?php echo utf8_encode($data['apellidos']);?></td>
	       <td><?php echo $data['dni'];?></td>
               <td><?php  echo utf8_encode($data['telefonos']);?></td>
               <td><?php  echo utf8_encode($data['pertenece']);?></td>
               <td><?php  echo utf8_encode($data['direccion']);?></td>
               <td><?php echo utf8_encode($data['trabaja']);?></td>
               <td><?php echo "<h5>".$data['fecha_vencimiento']."</h5>"; ?></td>
              
               <td><?php echo "<h4>". $dias." Dias</h4>";?></td> 
                   
               <?php }}
                       
 else {
      $resta=diferenciaDias($fechaI,date("Y-m-d"));
      
     if($_POST['filtro']=='f1' and ($resta>=1 and $resta<=5)){
        $dias=diferenciaDias($fechaI,date("Y-m-d"));
        
         ?>
                 
         <td><?php echo utf8_encode($data['nombres']);?></td>
	       <td><?php echo utf8_encode($data['apellidos']);?></td>
	       <td><?php echo $data['dni'];?></td>
               <td><?php  echo utf8_encode($data['telefonos']);?></td>
               <td><?php  echo utf8_encode($data['pertenece']);?></td>
               <td><?php  echo utf8_encode($data['direccion']);?></td>
               <td><?php echo utf8_encode($data['trabaja']);?></td>
               <td><?php echo "<h5>".$data['fecha_vencimiento']."</h5>"; ?></td>
              
               <td><?php echo "<h4>". $dias." Dias</h4>";?></td> 
         
         
    <?php  
   
    
      }
     if($_POST['filtro']=='f2' and ($resta>=6 and $resta<=10)){
        
         ?>
                 
         <td><?php echo utf8_encode($data['nombres']);?></td>
	       <td><?php echo utf8_encode($data['apellidos']);?></td>
	       <td><?php echo $data['dni'];?></td>
               <td><?php  echo utf8_encode($data['telefonos']);?></td>
               <td><?php  echo utf8_encode($data['pertenece']);?></td>
               <td><?php  echo utf8_encode($data['direccion']);?></td>
               <td><?php echo utf8_encode($data['trabaja']);?></td>
               <td><?php echo "<h5>".$data['fecha_vencimiento']."</h5>"; ?></td>
              
               <td><?php echo "<h4>". diferenciaDias($fechaI,date("Y-m-d"))." Dias</h4>";?></td> 
         
         
    <?php }
     if($_POST['filtro']=='f3' and ($resta>=11 and $resta<=20)){
        
         ?>
                 
         <td><?php echo utf8_encode($data['nombres']);?></td>
	       <td><?php echo utf8_encode($data['apellidos']);?></td>
	       <td><?php echo $data['dni'];?></td>
               <td><?php  echo utf8_encode($data['telefonos']);?></td>
               <td><?php  echo utf8_encode($data['pertenece']);?></td>
               <td><?php  echo utf8_encode($data['direccion']);?></td>
               <td><?php echo utf8_encode($data['trabaja']);?></td>
               <td><?php echo "<h5>".$data['fecha_vencimiento']."</h5>"; ?></td>
              
               <td><?php echo "<h4>". diferenciaDias($fechaI,date("Y-m-d"))." Dias</h4>";?></td> 
         
         
    <?php }
     if($_POST['filtro']=='f4' and ($resta>=21 and $resta<=30)){
        
         ?>
                 
         <td><?php echo utf8_encode($data['nombres']);?></td>
	       <td><?php echo utf8_encode($data['apellidos']);?></td>
	       <td><?php echo $data['dni'];?></td>
               <td><?php  echo utf8_encode($data['telefonos']);?></td>
               <td><?php  echo utf8_encode($data['pertenece']);?></td>
               <td><?php  echo utf8_encode($data['direccion']);?></td>
               <td><?php echo utf8_encode($data['trabaja']);?></td>
               <td><?php echo "<h5>".$data['fecha_vencimiento']."</h5>"; ?></td>
              
               <td><?php echo "<h4>". diferenciaDias($fechaI,date("Y-m-d"))." Dias</h4>";?></td> 
         
         
    <?php }
     if($_POST['filtro']=='f5' and ($resta>=31 and $resta<=45)){
        
         ?>
                 
         <td><?php echo utf8_encode($data['nombres']);?></td>
	       <td><?php echo utf8_encode($data['apellidos']);?></td>
	       <td><?php echo $data['dni'];?></td>
               <td><?php  echo utf8_encode($data['telefonos']);?></td>
               <td><?php  echo utf8_encode($data['pertenece']);?></td>
               <td><?php  echo utf8_encode($data['direccion']);?></td>
               <td><?php echo utf8_encode($data['trabaja']);?></td>
               <td><?php echo "<h5>".$data['fecha_vencimiento']."</h5>"; ?></td>
              
               <td><?php echo "<h4>". diferenciaDias($fechaI,date("Y-m-d"))." Dias</h4>";?></td> 
         
         
    <?php }
     if($_POST['filtro']=='f6' and ($resta>=46 and $resta<=60)){
        
         ?>
                 
         <td><?php echo utf8_encode($data['nombres']);?></td>
	       <td><?php echo utf8_encode($data['apellidos']);?></td>
	       <td><?php echo $data['dni'];?></td>
               <td><?php  echo utf8_encode($data['telefonos']);?></td>
               <td><?php  echo utf8_encode($data['pertenece']);?></td>
               <td><?php  echo utf8_encode($data['direccion']);?></td>
               <td><?php echo utf8_encode($data['trabaja']);?></td>
               <td><?php echo "<h5>".$data['fecha_vencimiento']."</h5>"; ?></td>
              
               <td><?php echo "<h4>". diferenciaDias($fechaI,date("Y-m-d"))." Dias</h4>";?></td> 
         
         
    <?php }
     if($_POST['filtro']=='f7' and ($resta>=61 and $resta<=90)){
        
         ?>
                 
         <td><?php echo utf8_encode($data['nombres']);?></td>
	       <td><?php echo utf8_encode($data['apellidos']);?></td>
	       <td><?php echo $data['dni'];?></td>
               <td><?php  echo utf8_encode($data['telefonos']);?></td>
               <td><?php  echo utf8_encode($data['pertenece']);?></td>
               <td><?php  echo utf8_encode($data['direccion']);?></td>
               <td><?php echo utf8_encode($data['trabaja']);?></td>
               <td><?php echo "<h5>".$data['fecha_vencimiento']."</h5>"; ?></td>
              
               <td><?php echo "<h4>". diferenciaDias($fechaI,date("Y-m-d"))." Dias</h4>";?></td> 
         
         
    <?php }
    if($_POST['filtro']=='f8' and ($resta>90)){
        
         ?>
                 
         <td><?php echo utf8_encode($data['nombres']);?></td>
	       <td><?php echo utf8_encode($data['apellidos']);?></td>
	       <td><?php echo $data['dni'];?></td>
               <td><?php  echo utf8_encode($data['telefonos']);?></td>
               <td><?php  echo utf8_encode($data['pertenece']);?></td>
               <td><?php  echo utf8_encode($data['direccion']);?></td>
               <td><?php echo utf8_encode($data['trabaja']);?></td>
               <td><?php echo "<h5>".$data['fecha_vencimiento']."</h5>"; ?></td>
              
               <td><?php echo "<h4>". diferenciaDias($fechaI,date("Y-m-d"))." Dias</h4>";?></td> 
         
         
    <?php }
     

     
 }
                   
                   ?>

            
        </tr>
    <?php 
    
    endforeach; ?>

    
  
</table>
    </div>

       
