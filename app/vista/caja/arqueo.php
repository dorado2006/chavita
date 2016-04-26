
<style>
    .ui-autocomplete .highlight {
        text-decoration: underline;
    }

</style>
<script>
    $(function () {

        $("#guardar").click(function () {

            var dataString = $('#frmsave').serialize();
           
            $.post('../web/index.php', dataString, function (data) {
                alertify.success(data.msj);

            }, 'json');
            return false;
        });
        $(".monedap").keyup(function () {

            money = $(this).val();
            adad = $(this).attr('pert');
            peso = eval($(this).attr('id'));
            mocaja = peso * eval(money);
            
            if (money.length==0) {
                $("#" + adad).val('0');
            }
            else {
                $("#" + adad).val(mocaja);
            }
            comp =eval($("#montocaj").val());
           
            
            $("#totalmoneda").val((calcular_total()).toFixed(2));
            if(comp == (calcular_total()).toFixed(2) ){ alertify.success("SU CAJA SI CUADRA...");}
           
            
        });



    });

    function calcular_total() {

        importe_total = 0
        $(".totxmoneda").each(
        function (index, value) {
            importe_total = importe_total + eval($(this).val());
        }
    );
        return importe_total;
    }
</script>
<?php //echo"<pre>";print_r($rowst); ?>

<input type="hidden" id="idperfil" value="<?php echo $_SESSION['idperfil'] ?>">



<div class="row ">
    <div class="col-lg-1">

    </div>
    <div class="col-lg-5">
        <div class="panel panel-info">
            <!--            <div class="panel-heading">ARQUEO DE PRODUCTOS POR VENDEDOR</div>-->
            <div class="panel-body">
                <form class="form-horizontal" role="form111">
                    <?php
                    $banco = 0;
                    $ingreso = 0;
                    $planilla = 0;
                    foreach ($rows as $key => $data):

                        if ($data['documento'] == 'BN') {
                            $banco = $banco + $data['ingre'];
                        } elseif ($data['documento'] == 'Recibo' || $data['documento'] == 'Factura' || $data['documento'] == 'Boleta') {
                            $ingreso = $ingreso + $data['ingre'];
                        } else {
                            $planilla = $planilla + $data['ingre'];
                        }
                    endforeach;
                    $fc = 0;
                    $entrada = 0;
                    foreach ($rows2 as $key => $data):

                        if ($data['tipo'] == 'FC') {
                            $fc = $fc + $data['entrada'];
                        } else {
                            $entrada = $entrada + $data['entrada'];
                        }
                    endforeach;
                    $totalcaja = number_format(($fc + $entrada + $ingreso) - $rows1[0]['sal'], 2);
                     $totalcaja_2 = ($fc + $entrada + $ingreso) - $rows1[0]['sal'];
                    ?> 

                    <hr>
                    <h4><u>ENTRADA</u></h4>
                    <div class="form-group">
                        <label for="concep" class="col-lg-5 control-label ">FONDE DE CAJA</label>

                        <div class="col-lg-4">                            
                            <div class="input-group">

                                <input type="text" name="concepto" class="form-control" id="concep" value="<?php echo $fc ?>" >
                                <span class="input-group-addon limpiar">
                                    <i class="form-control-feedback glyphicon">S/</i></span>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="concep" class="col-lg-5 control-label ">OTROS</label>

                        <div class="col-lg-4">                            
                            <div class="input-group">

                                <input type="text" name="concepto" class="form-control" id="concep" value="<?php echo $entrada ?>" >
                                <span class="input-group-addon limpiar">
                                    <i class="form-control-feedback glyphicon">S/</i></span>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="MONT" class="col-lg-5 control-label ">COBRANZAS</label>

                        <div class="col-lg-4">                            
                            <div class="input-group">

                                <input type="text" name="BUSCAR" class="form-control" id="MONT"  value="<?php echo $ingreso; ?>">
                                <span class="input-group-addon limpiar">
                                    <i class="form-control-feedback glyphicon">S/</i></span> </div>
                        </div>
                    </div>
                    <hr>
                    <h4><u>SALIDA</u></h4>
                    <div class="form-group">

                        <label for="MONT" class="col-lg-5 control-label ">EGRESOS</label>

                        <div class="col-lg-4">                            
                            <div class="input-group">

                                <input type="text" name="BUSCAR" class="form-control" id="MONT" value="<?php echo $rows1[0]['sal']; ?>" >
                                <span class="input-group-addon limpiar">
                                    <i class="form-control-feedback glyphicon">S/</i></span> </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="MONT" class="col-lg-5 control-label ">BANCOS</label>

                        <div class="col-lg-4">                            
                            <div class="input-group">

                                <input type="text" name="BUSCAR" class="form-control" id="MONT" value="<?php echo $banco; ?>">
                                <span class="input-group-addon limpiar">
                                    <i class="form-control-feedback glyphicon">S/</i></span> </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="MONT" class="col-lg-5 control-label ">PLANILLA</label>

                        <div class="col-lg-4">                            
                            <div class="input-group">

                                <input type="text" name="BUSCAR" class="form-control" id="MONT" value="<?php echo $planilla; ?>" >
                                <span class="input-group-addon limpiar">
                                    <i class="form-control-feedback glyphicon">S/</i></span> </div>
                        </div>
                    </div>

                    <hr>
                </form>
                <form class="form-horizontal" role="form" id="frmsave">
                    <input type="hidden" name="controller" value="caja">
                    <input type="hidden" name="action" value="cierrecaja"> 
                    <div class="form-group">
                        <label for="MONT" class="col-lg-4 control-label ">TOTAL EN CAJA</label>

                        <div class="col-lg-4">                            
                            <div class="input-group">

                                <input type="text" name="monto" class="form-control" id="montocaj" value="<?php echo $totalcaja; ?>" >
                                <input type="hidden" name="monto_caj" class="form-control" id="monto_caj" value="<?php echo $totalcaja_2; ?>" >
                                <span class="input-group-addon limpiar">
                                    <i class="form-control-feedback glyphicon">S/</i></span> </div>
                        </div>
                        <div class="col-lg-3">
                            <button type="button" class="btn btn-info" id="guardar">GUARDAR CAJA</button>
                        </div>

                    </div>


                </form>
            </div>
        </div>

    </div>
    <div class="col-lg-5">
        <div class="panel panel-info">
            <!--            <div class="panel-heading">ARQUEO DE PRODUCTOS POR VENDEDOR</div>-->
            <div class="panel-body">
                <form class="form-horizontal" role="form22">

                    <div class="form-group">
                        <label for="concep" class="col-lg-4 control-label ">
                            <IMG SRC="../web/assets/avatars/200soles.jpg" WIDTH="160" HEIGHT="50">
                        </label>

                        <div class="col-lg-2" style=" padding-top: 15px">  
                            <input type="text" name="concepto" class="form-control monedap" id="200" pert="totxmoneda200" placeholder="200 soles"  >
                            <input type="hidden" name="concepto" class="form-control totxmoneda" id="totxmoneda200"value="0" >
                        </div>
                        <label for="concep" class="col-lg-4 control-label " >
                            <IMG SRC="../web/assets/avatars/5soles.jpg" WIDTH="50" HEIGHT="50">
                        </label>

                        <div class="col-lg-2" style=" padding-top: 15px">  
                            <input type="text" name="concepto" class="form-control monedap" id="5" pert="totxmoneda5" placeholder="5 soles" >
                            <input type="hidden" name="concepto" class="form-control totxmoneda" id="totxmoneda5" value="0" >
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="concep" class="col-lg-4 control-label ">
                            <IMG SRC="../web/assets/avatars/100soles.jpg" WIDTH="160" HEIGHT="50">
                        </label>

                        <div class="col-lg-2" style=" padding-top: 15px" >  
                            <input type="text" name="concepto" class="form-control monedap" id="100"  pert="totxmoneda100" placeholder="100 soles" >
                            <input type="hidden" name="concepto" class="form-control totxmoneda" id="totxmoneda100" value="0">
                        </div>
                        <label for="concep" class="col-lg-4 control-label ">
                            <IMG SRC="../web/assets/avatars/2soles.jpg" WIDTH="50" HEIGHT="50">
                        </label>

                        <div class="col-lg-2" style=" padding-top: 15px">  
                            <input type="text" name="concepto" class="form-control monedap" id="2" pert="totxmoneda2" placeholder="2 soles" >
                            <input type="hidden" name="concepto" class="form-control totxmoneda" id="totxmoneda2" value="0">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="concep" class="col-lg-4 control-label ">
                            <IMG SRC="../web/assets/avatars/50soles.jpg" WIDTH="160" HEIGHT="50">
                        </label>

                        <div class="col-lg-2" style=" padding-top: 15px">  
                            <input type="text" name="concepto" class="form-control monedap" id="50" pert="totxmoneda50" placeholder="50 soles" >
                            <input type="hidden" name="concepto" class="form-control totxmoneda" id="totxmoneda50" value="0"> 
                        </div>
                        <label for="concep" class="col-lg-4 control-label ">
                            <IMG SRC="../web/assets/avatars/1sol.jpg" WIDTH="50" HEIGHT="50">
                        </label>

                        <div class="col-lg-2" style=" padding-top: 15px">  
                            <input type="text" name="concepto" class="form-control monedap" id="1" pert="totxmoneda1" placeholder="1 sol" >
                            <input type="hidden" name="concepto" class="form-control totxmoneda" id="totxmoneda1" value="0"> 
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="concep" class="col-lg-4 control-label ">
                            <IMG SRC="../web/assets/avatars/20soles.jpg" WIDTH="160" HEIGHT="50">
                        </label>

                        <div class="col-lg-2" style=" padding-top: 15px">  
                            <input type="text" name="concepto" class="form-control monedap" id="20" pert="totxmoneda20" placeholder="20 soles" >
                            <input type="hidden" name="concepto" class="form-control totxmoneda" id="totxmoneda20" value="0"> 
                        </div>
                        <label for="concep" class="col-lg-4 control-label ">
                            <IMG SRC="../web/assets/avatars/50centimos.jpg" WIDTH="50" HEIGHT="50">
                        </label>

                        <div class="col-lg-2" style=" padding-top: 15px">  
                            <input type="text" name="concepto" class="form-control monedap" id="0.50" pert="totxmoneda050"  placeholder="0.50" >
                            <input type="hidden" name="concepto" class="form-control totxmoneda" id="totxmoneda050" value="0"> 
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="concep" class="col-lg-4 control-label ">
                            <IMG SRC="../web/assets/avatars/10soles.jpg" WIDTH="160" HEIGHT="50">
                        </label>

                        <div class="col-lg-2" style=" padding-top: 15px">  
                            <input type="text" name="concepto" class="form-control monedap" id="10" pert="totxmoneda10" placeholder="10 soles">
                            <input type="hidden" name="concepto" class="form-control totxmoneda" id="totxmoneda10" value="0"> 
                        </div>
                        <label for="concep" class="col-lg-4 control-label ">
                            <IMG SRC="../web/assets/avatars/20centimos.jpg" WIDTH="50" HEIGHT="50">
                        </label>

                        <div class="col-lg-2" style=" padding-top: 15px">  
                            <input type="text" name="concepto" class="form-control monedap" id="0.20" pert="totxmoneda020" placeholder="0.20">
                            <input type="hidden" name="concepto" class="form-control totxmoneda" id="totxmoneda020" value="0"> 
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="concep" class="col-lg-4 control-label ">

                        </label>

                        <div class="col-lg-2">  

                        </div>
                        <label for="concep" class="col-lg-4 control-label ">
                            <IMG SRC="../web/assets/avatars/10centimos.jpg" WIDTH="50" HEIGHT="50">
                        </label>

                        <div class="col-lg-2" style=" padding-top: 15px">  
                            <input type="text" name="concepto" class="form-control monedap" id="0.10" pert="totxmoneda010" placeholder="0.10 " >
                            <input type="hidden" name="concepto" class="form-control totxmoneda" id="totxmoneda010" value="0"> 
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="concep" class="col-lg-4 control-label ">
                            TOTAL
                        </label>                    
                        <div class="col-lg-4">  
                            <input type="text" name="concepto" class="form-control" id="totalmoneda" value="0" >
                        </div>
                    </div>


                </form>
            </div>
        </div>

    </div>
</div>
