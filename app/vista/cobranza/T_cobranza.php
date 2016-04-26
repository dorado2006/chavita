
<script >

    $(function() {
        $(".pago").keyup(function() {
            var ind = $(this).attr("name");
            var prox = eval(ind) + 1;
            var pago = $(this).val();
            var idventa = $('.idv' + ind).val();

            var deuda = $('.d' + ind).val();

            var deudaprox = $('.l' + prox).val();

            if (ind == 0) {
                deuda = deudaprox
            }
            if (eval(pago) > eval(deuda)) {
                alert("SIRVASE A PASAR LA DIFERENCIA DE ESTA CUOTA A LA SGT CUOTA");
            }




            //var pago=  $(".p"+ind).val();
            var result = deuda - pago;
            var resultprox = eval(deudaprox) + eval(result);
            var idpersonal = $("#idper").val();

            $('.r' + ind).val(result);
            $('.d' + prox).val(resultprox);
            $('.pr' + ind).val(pago);
            $('.f' + ind).val(fecha);
            $('.idp' + ind).val(idpersonal);
            $("#idventa").val(idventa);


        });

        $("#save").click(function() {

            bval = true;

            if (bval) {
                $("#frm").submit();
            }
            return false;
        });

    });


</script>

<div class="msj" style="background-color: #dff0d8;color: rgb(233, 101, 50);text-align: center"><b style="color: #093 ">CLIENTE: </b> <strong><?php echo $_GET['cliente']; ?></strong></div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="margin: 0 0 5px 150px">
                                  <tr>
                                      
                                    <td >Buscar  <input name="criterio3" type="text" id="criterio3" class="input-xlarge" />
                                        <input type="button" class="btn btn-info" name="buscar" id="buscar" value="Buscar" onclick="cargardatos('gridprestamo.php','gridprestamo','criterio='+$('#criterio3').val()),'no'" />
                                   </td>
                                  </tr>
                                </table>-->
            </div>
            <div class="modal-body">

                <div id="gridprestamo">
                    <table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="margin: 0 0 5px 150px">
                        <tr>

<td >ACUERDOS DE ESTA CUOTA  <!--<input name="criterio3" type="text" id="criterio3" class="input-xlarge" />
<!--<input type="button" class="btn btn-info" name="Ingresar" id="buscar" value="Buscar" onclick="cargardatos('gridprestamo.php','gridprestamo','criterio='+$('#criterio3').val()),'no'" />
                                --></td>
                        </tr>
                        <tr><td>1.</td></tr>
                        <tr><td>2.</td></tr>
                        <tr><td>3.</td></tr>
                    </table>   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


</div>
<form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="cobranza" />
    <input type="hidden" name="action" value="save" />
    <table width="100%" border="1" cellpadding="3" cellspacing="1"  class="tabla table-bordered table-hover">
        <tr>
            <!--<th>ID</th>-->
            <th>Nº cuota</th>
            <th>Letra</th>
            <th><span class="glyphicon glyphicon-circle-arrow-left"></span>Deuda</th>
            <th style=" background-color: #EB1537" > <span class="glyphicon  glyphicon-usd glyphicon-pencil"></span>pago
                <span class="glyphicon glyphicon-pencil"></span>
            </th>
            <th>Deud pendnte</th>
            <th style=" background-color: #EB1537">Fecha <span class="glyphicon glyphicon-pencil"></</th>

            <th>vencimiento</th>
            <th style=" background-color: #EB1537">Nº Recibo <span class="glyphicon glyphicon-pencil"></</th>
            <th style=" background-color: #EB1537" >Cond.Pago <span class="glyphicon glyphicon-pencil"></</th>
            <th>Accion</th>


        </tr>
        <tr>
            <td colspan="11"><input type="hidden" name="idper"  class="idper" id="idper" value="<?php echo $_SESSION['idpersonal'] ?>" ></td></tr>
<?php foreach ($rows as $valor => $data):

    if ($data['abono'] != 0) {
        ?>
                <tr >

        <!--<td><?php //echo $data['idproceso_cobro'];  ?><input type="hidden" name="idpersonal[]"    id="deuda" class="<?php // echo "idp" . $valor  ?>" value="<?php // echo $data['idpersonal'];  ?>" ></td>-->
                    <td style=" background-color: #78DD80"><?php echo $data['nro_cuota']; ?>
                        <input type="hidden" name="idventa1"  class="<?php echo "idv" . $valor ?>" id="idventa1" value="<?php echo $data['idventa']; ?>" >
                        <input type="hidden" name="idpersonal[]"    id="deuda" class="<?php echo "idp" . $valor ?>" value="<?php echo $data['idpersonal']; ?>" ></td> 
                    <td style=" background-color: #78DD80"><input type="text" name="letra[]" size="4"  disabled="" id="deuda" class="<?php echo "l" . $valor ?>" value="<?php echo $data['letra']; ?>"  ></td>
                    <td style=" background-color: #78DD80"><input type="text" name="deuda[]" size="4"   id="deuda" class="<?php echo "d" . $valor ?>" value="<?php echo $data['deuda_anterior']; ?>" readonly="" ></td>
                    <td style=" background-color: #78DD80" >
                        <span class="glyphicon  glyphicon-usd glyphicon-pencil"></span>
                        <input type="text" name="<?php echo $valor ?>" size="3"  class="pago" id="pago" value="<?php echo $data['abono']; ?>" >
                        <input type="hidden" name="pagoreal[]"  class="<?php echo "pr" . $valor ?>" id="pagoreal" value="<?php echo $data['abono']; ?>" ></td> 
                    <td style=" background-color: #78DD80"><input type="text" name="resto[]"  size="5"  class="<?php echo "r" . $valor ?>" id="resto" value="<?php echo $data['resto']; ?>" readonly="" ></td>
                    <td style=" background-color: #78DD80"><input type="text" name="fecha[]"  size="10"  class="<?php echo "f" . $valor ?>" id="resto" value="<?php echo $data['fecha_abono']; ?>"  ></td>

                    <td style=" background-color: #78DD80"><?php echo $data['fecha_vencimiento']; ?></td>
                    <td style=" background-color: #78DD80"><input type="text" name="nro_recibo[]" size="7" value="<?php echo $data['nro_recibo']; ?>"></td>
                    <td style=" background-color: #78DD80">
                        <select name="cond_pago[]" id="cond_pago">
        <?php
        $idd = $data['idcondicion_pago'];
        if ($idd == "2") {
            $a = 'selected';
        } else
            $a = '';
        ?>
                            <option value="1" <?php echo "$a"; ?> > <?php $idd ?>Directo</option>
                            <option value="2"   <?php echo "$a"; ?> ><?php $idd ?>Planilla</option>                    

                        </select></td>

                    <td align='center'>
                        <!-- <a href='?id=$id' class='btn btn-mini btn-warning'>Confirmar</a> --> 
                        <input type="button" id="mostrar" value="Acuerdos" class="btn btn-info" data-toggle="modal" data-target="#myModal">
                        <!--<a href='?id=$id' class='btn btn-mini btn-warning'>Acuerdos</a>
                        <!--<a href='javascript:void(0)' onclick='eliminar($id);' class='btn btn-mini btn-danger'>Eliminar</a> -->
                    </td>
                </tr>

    <?php }
    else {
        ?>

                <tr>

        <!--<td><?php //echo $data['idproceso_cobro'];  ?><input type="hidden" name="idpersonal[]"    id="deuda" class="<?php // echo "idp" . $valor  ?>" value="<?php // echo $data['idpersonal'];  ?>" ></td>-->
                    <td><?php echo $data['nro_cuota']; ?>
                        <input type="hidden" name="idventa1"  class="<?php echo "idv" . $valor ?>" id="idventa1" value="<?php echo $data['idventa']; ?>" >
                        <input type="hidden" name="idpersonal[]"    id="deuda" class="<?php echo "idp" . $valor ?>" value="<?php echo $data['idpersonal']; ?>" ></td> 
                    <td><input type="text" name="letra[]" size="4"  disabled="" id="deuda" class="<?php echo "l" . $valor ?>" value="<?php echo $data['letra']; ?>"  ></td>
                    <td><input type="text" name="deuda[]" size="4"   id="deuda" class="<?php echo "d" . $valor ?>" value="<?php echo $data['deuda_anterior']; ?>" readonly="" ></td>
                    <td>
                        <span class="glyphicon  glyphicon-usd glyphicon-pencil"></span>
                        <input type="text" name="<?php echo $valor ?>" size="3"  class="pago" id="pago" value="" >
                        <input type="hidden" name="pagoreal[]"  class="<?php echo "pr" . $valor ?>" id="pagoreal" value="" ></td> 
                    <td><input type="text" name="resto[]"  size="5"  class="<?php echo "r" . $valor ?>" id="resto" value="" readonly="" ></td>
                    <td><input type="text" name="fecha[]"  size="10"  class="<?php echo "f" . $valor ?>" id="resto" value=""  ></td>

                    <td><?php echo $data['fecha_vencimiento']; ?></td>

                    <td><input type="text" name="nro_recibo[]" size="7" <?php echo $data['nro_recibo']; ?>></td>
                    <td><select name="cond_pago[]" id="cond_pago">
                            <option value="1">Directo</option>
                            <option value="2">Planilla</option>                    

                        </select></td>

                    <td align='center'>
                        <!-- <a href='?id=$id' class='btn btn-mini btn-warning'>Confirmar</a> --> 
                        <input type="button" id="mostrar" value="Acuerdos" class="btn btn-info" data-toggle="modal" data-target="#myModal">
                        <!--<a href='?id=$id' class='btn btn-mini btn-warning'>Acuerdos</a>
                        <!--<a href='javascript:void(0)' onclick='eliminar($id);' class='btn btn-mini btn-danger'>Eliminar</a> -->
                    </td>
                </tr>

        <?php
    }




endforeach;
?>
        <tr>

            <td colspan="11" style=" background-color: #69f8a0; text-align: center">
                <input type="hidden" name="idventa"  class="idventa" id="idventa" value="" >
                <button type="button" class="btn btn-default btn-mini btn-danger" id="save">
                    <span class="glyphicon glyphicon-saved"></span> GUARDAR
                </button>
            </td>
        </tr>
    </table>
</form>

