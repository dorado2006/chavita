<script>
    $(function() {
        $("#fecha_inicio_x").datepicker({'dateFormat': 'yy/mm/dd'});
         $("#fecha_inicio_pago").datepicker({'dateFormat': 'yy-mm-dd'});
          $("#fecha_inicio").datepicker({'dateFormat': 'yy-mm-dd'});
        $("#n_letras").keyup(function() {
            total = $("#total").val();
            n_letras = $(this).val();
            monto_letra = total / n_letras;

            monto_letra = monto_letra.toFixed(2);
            if (n_letras > 0)
            {
                document.getElementById('monto_letra').value = monto_letra;
            }
            else {
                document.getElementById('monto_letra').value = '';
            }
        });
        $("#generar").click(function() {
            
            condicion_pago = $('#idcondicion_pago').find(":selected").text();
            monto_letra = $("#monto_letra").val();
            n_letras = $("#n_letras").val();
            abonar_p = $("#abonar_p").val();            
            fecha_inicio_pago = $("#fecha_inicio_pago").val();
            c_dias = $("#c_dias").val();
            idcondicion_pago = $("#idcondicion_pago").val();
            if(idcondicion_pago==""){ $("#cp").addClass("has-error");exit;}
            else{$("#cp").removeClass("has-error");}
            if (fecha_inicio_pago == "") {
                $("#fi").addClass("has-error");
            }
            else {
                $("#fi").removeClass("has-error");
                $.post('../web/index.php', 'controller=venta&action=generar_cronograma&monto_letra=' + monto_letra + '&n_letras=' + n_letras + '&fecha_inicio_pago=' + fecha_inicio_pago + '&c_dias=' + c_dias + '&condicion_pago=' + condicion_pago+'&abonar_p='+abonar_p, function(data) {
                    console.log(data);
                    $("#cronograma").empty().append(data);
                });
            }
        });
        $("#save").click(function() {
            $("#frm").submit();
            return false;
        });

    });
</script>
<div align="center" class="contenidopadding"> 
    <form action="../web/index.php" method="post" id="frm">
        <input type="hidden" name="controller" value="cobranza">
        <input type="hidden" name="action" value="imprimir_cronog_pago">     
        <table width="100%" border="1" cellpadding="3" cellspacing="1"  class="table table-bordered">
            <tr>
                <td colspan="4" align="center" class="success"><strong>Cronograma De Pagos De <?php echo $_POST['cliente']; ?></strong></td>
            <input type="hidden" id="idventa" name="idventa" value="<?php echo $idventa; ?>">
             <input type="hidden" id="dnic" name="idprodni" value="<?php echo $rows1[0]['dni']; ?>">
             <input type="hidden" id="idve" name="idve" value="<?php echo $rows1[0]['idproceso_cobro']; ?>">
             <input type="hidden" id="cond" name="cond" value="1">
             
             
            
            <input type="hidden" id="idcliente" name="idcliente" value="<?php echo $_POST['idcliente']; ?>">
            </tr>
            <tr>
                <td align="left">

                    <div class="form-group col-lg-4"> 
                        <div class="input-group"> 
                            <span class="input-group-addon">Total De Venta S/.</span>   
                            <input type="text" title="Nombre Del Cliente" name="total" id="total"  class="form-control" value="<?php echo $rows1[0]['credito']; ?>" >                      
                        </div>
                    </div>
                    <div class="form-group col-sm-3"> 
                        <div class="input-group"> 
                            <span class="input-group-addon">Nº Letras</span>   
                            <input type="text" title="Nº Letras" name="n_letras" id="n_letras" value="<?php echo $rows1[0]['num_cuotas']; ?>"  class="form-control">                      
                        </div>
                    </div>
                    <div class="form-group col-lg-4"> 
                        <div class="input-group"> 
                            <span class="input-group-addon">Monto/Letra S/.</span>   
                            <input type="text" title="Monto De Cada Letra" name="monto_letra" id="monto_letra" value="<?php echo $rows1[0]['letra']; ?>"  class="form-control" >                      
                        </div>
                    </div>     
        
                </td>         
            </tr>
             <tr>
                <td align="left">
                     <div class="form-group col-lg-4"> 
                        <div class="input-group"> 
                            <span class="input-group-addon">Pago:</span>   
                      <?php echo $rows1[0]['frecuencia_msg'] ?>                          
                                                 
                        </div>
                    </div>
                   

                    <div class="form-group col-lg-4"> 
                        <div class="input-group"> 
                            <span class="input-group-addon">Cuantos Dias</span>   
                            <input type="text" title="Cantidad De Dias Por Letra" name="c_dias" id="c_dias" value="<?php echo $rows1[0]['frecuen']; ?>" class="form-control" >                       
                        </div>
                    </div>
                    <div class="form-group col-sm-3"> 
                        <div class="input-group"> 
                            <span class="input-group-addon">Amortiza</span>   
                            <input type="text" title="Nº Letras" name="abonar_p" id="abonar_p" value="<?php echo $rows1[0]['abo']; ?>"  class="form-control">                      
                        </div>
                    </div>
                       
                </td>         
            </tr>
            <tr>
                <td>
                    <div align="center">
                        <div style="width: 90%">
                         
                            <div class="form-group col-lg-4" id="fi"> 
                                <div class="input-group"> 
                                    <span class="input-group-addon">Fecha Inicio Pago</span>
<!--                                    <input type="text" class="form-control"  type="text" id="fecha_inicio_x" name="fecha_inicio_pago"   >-->
                                  </div>
                            </div>
                                    <input type = "text" size = "10" class = "form-control" id = "fecha_inicio_pago" name="fecha_pago" value = "<?php echo $rows1[0]['a_partir_de']; ?>" >
                             
                            <div class="form-group col-lg-2"> 
                                <div class="input-group"> 
                                    <button type="button" class="btn btn-danger glyphicon glyphicon-repeat" id="generar">&nbsp;GENERAR</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>   
            </tr>
            
            <tr>
                <td align="center">
                    <div id="cronograma" style="width:70%;">
                        <table  border="1" cellpadding="3" cellspacing="1" id="t_cronograma_pagos" name="t_cronograma_pagos" class="table table-bordered">
                            <thead class="ui-widget ui-widget-content">
                                <tr class="ui-widget-header" >                            
                                    <th width="3%">CUOTA</th>
                                    <th width="40%">FECHAS DE PAGO</th>         
                                    <th width="30%">CONDICION PAGO</th>
                                    <th width="27%">MONTO S/.</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="4">CRONOGRAMA</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="center">
                    <a class="btn btn-success glyphicon glyphicon-floppy-saved" id="save" name="save" >&nbsp;ACEPTAR</a>
                    <a class="btn btn-warning glyphicon glyphicon-remove " id="cancelar_venta" name="cancelar_venta" style="margin-left: 30px;">&nbsp;CANCELAR</a>
                </td>
            </tr>
        </table>       
    </form>
</div>