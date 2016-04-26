<script>
    var dni;
    var evacl;
    $(function() {
  $('.geoloco').prop('href',"javascript:window.open('../app/gelocalizacion/index.php?idcliente=<?php echo $obj[0]['idcliente']; ?>','','width=800,height=600,left=50,top=50,toolbar=yes');void 0");
 
        $(".calificacion").click(function() {
            var idperfil = $('#idperfil').val();
            if (idperfil == 1 || idperfil == 4 ) {  
            var dnicli = $(this).attr("id");
            var separa1 = dnicli.split(",");
            dni = separa1[0];
            evacl = separa1[1];
            $("#condp").html(evacl);
            //$('#evaluacion_cli').prop('title','te amo'); 
            $("#evaluacion_cli").dialog("open");
        }
         else {
               alert("USTED NO TIENE PERMISO PARA ESTA OPERACIÓN...Pida ayuda a su Administrador");
            }
        });
        $(".evaluacion_cli").dialog({
            autoOpen: false,
            width: 500,
            height: 250,
            show: "scale",
            hide: "scale",
            resizable: "false",
            position: "center",
            modal: "true",
            title: "CLIENTE: " + nombres

        });

        $("#guardar_evaluacion").click(function() {

            var eva = $("#evaluacion").val();
            $.post('../web/index.php', 'controller=cobranza&action=evaluacion&mieval=' + eva + '&dnic=' + dni, function(data) {
                console.log(data);

            });

            $("#evaluacion_cli").dialog("close");
        });

    });
</script>

<div id="evaluacion_cli" class="evaluacion_cli"  title='<script></script>'>

    <p>Este Cliente Tiene la Condicion de Pago: <a id="condp"></a></p>
    <ul><li>Sí Desea, Puede Cambiar La Condicion de Pago del Cliente.</li></ul>
    <select name="evaluacion" id="evaluacion" class="condicion_pago">

        <option value="BUENO">BUENO</option>
        <option value="REGULAR">REGULAR</option>
        <option value="MALO">MALO</option>
    </select>

    <div id="guardar_evaluacion" class="guardar_evaluacion boton ">Guardar</div>
</div>
<table border="0" style="font-size: 12px;font-family: Times New Roman">
    <tr><td width="10%">
            <input type="hidden" name="idcliente" id="idcliente" value="<?php echo $obj[0]['idcliente']; ?>">    
            <label  for="nombres">CLIENTE</label>
        </td>
        <td>
            <input type="text" placeholder="Nombres" name="nombres" id="nombres" value="<?php echo strtoupper(utf8_encode($obj[0]['apelli'] . " " . $obj[0]['nombres'])); ?>" size="45" >     
        </td>
        <td>&nbsp;&nbsp;</td>
        <td width="10%">
            <label  for="direccion">DOMICILIO</label>
        </td>
        <td>
            <input type="text" placeholder="Direccion" name="direccion" id="direccion" value="<?php echo strtoupper(utf8_encode($obj[0]['direccion'])); ?>"  size="65" >
        </td>
    </tr>
    <tr>

        <td><label  for="dni">DNI</label></td>
        <td><input type="text" placeholder="dni" name="dni" id="dni" value="<?php echo $obj[0]['dni']; ?>"  size="45" class="cl"></td>
        <td></td>
        <td><label  for="telf">TELEFONOS</label></td>
        <td><input type="text" placeholder="Telefono" name="telf" id="telf" value="<?php echo $obj[0]['telfcasa'] . " / " . $obj[0]['telf1'] . " / " . $obj[0]['telf2']; ?>" size="65" class="cl">
        </td>

    </tr>
    <tr>

        <td><label  for="lugar_tarabajo">LABORA</label></td>
        <td> <input type="text" placeholder="Lugar Trabajo" name="lugar_tarabajo"  value="<?php echo strtoupper(utf8_encode($obj[0]['codigo_ruc'] . ":" . $obj[0]['lugartrabajo'])); ?>" size="45" id="lugar_tarabajo" class="cl">
        </td>
        <td></td>
        <td>  <label  for="direcion_tra">DIRECCIÓN</label>
        </td>
        <td> <input type="text" placeholder="Direccion de trabajo" name="direcion_tra" value="<?php echo strtoupper(utf8_encode($obj[0]['trabaja_dir'])); ?>"  size="65" id="direcion_tra" class="cl">
        </td>
    </tr> 
    <tr>
        <td ><label>TIPO DE SERVIDOR:</label> </td>
        <?php if($obj[0]['tipo_servidor'] == "Part.Particular"){ ?>
            <td style="color:  #D65417;  font-size: 14px;padding-left: 2%" >PARTICULAR</td> 
     <?php   }
        else{ ?>
          <td style="color:  #D65417;  font-size: 14px;padding-left: 2%" ><?php echo strtoupper(utf8_encode($obj[0]['tipo_servidor'])) ?></td>   
     <?php   }
        ?>
       
        <td></td>
        <td style="color:  #d14; cursor: pointer; font-size: 14px">
            <div class="calificacion" <?php echo "id='" . $obj[0]['dni'] . "," . $obj[0]['calificacion'] . "'" ?> style="color: #d14;cursor:  pointer" >
                <b> CALIFICACIÓN</b></div>
        </td>
        <td  style="color:  #D65417; font-size: 14px;padding-left: 1%">
            <div style=" width: 80%;float:left;">.<?php echo "  " . utf8_encode($obj[0]['calificacion']) ?> </div>            
            <div style="background-color: <?php echo $obj[0]['corcl'] ?>; width: 10%; position:  relative;float:left;">D</div>
        <div style="  width: 10%;float:left; background-color: <?php echo $obj[0]['cortra'] ?>" >T </div>
        </td>
    </tr>

</table>



