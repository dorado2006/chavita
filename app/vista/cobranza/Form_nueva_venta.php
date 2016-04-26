<script>

    $(function () {

        $("#fechaV").datepicker({'dateFormat': 'yy-mm-dd'});
        $("#fechaIP").datepicker({'dateFormat': 'yy-mm-dd'});
        $("#horav").timepicker();

        $("#n_meses").keyup(function () {

            var n_meses = $(this).val();
            var credito = $("#cuota").val();
            var totalcredito = credito * n_meses;

            $("#totalCredito").val(totalcredito);
        });

        $('#nuevo_venta').click(function () {

            verificar = $('.nesesario').val();

            if (confirm('¿AS LLENADO TODO LOS CAMPOS?'))
            {
                var dataString = $('#form_nueva_venta').serialize();

                // alert('Datos serializados: ' + dataString);
                $.post('../web/index.php', dataString, function (data) {
                    console.log(data);
                    //$("#detalle").empty().append(data);
                });
                $('#MyModal_bt4').modal('toggle');
            }
            else
            {
                return false;
            }


        });
         $("#buscar_productos").click(function() {
            popup('index.php?controller=productos&action=buscador_pro', 860, 500);
        });

        //-----------------------------------------
    });
</script>
<style>
    form#form_nueva_venta [required]{
        border:solid 1px red;
    } 
</style>
<form id="form_nueva_venta" method="post">
    <input type="hidden" name="controller" value="cobranza" />
    <input type="hidden" name="action" value="isert_venta" />
    <input type="hidden" name="dnicliente" value="<?php echo $obj[0]['dni']; ?>" />

    <div class="modal fade " id="MyModal_bt4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel2">NUEVA VENTA</h4>
                </div>
                <div class="modal-body" >
                    <table border="1" width="100%" id="actualizar_cliente" class="actualizar_cliente table"  style="background: #dff0d8">

                        <tr>
                            <td colspan="6" style=" background-color:  #FACAAD"><b>DATOS DEL CREDITO</b></td>
                        </tr>
                        <tr>
                            <td class="filas">FECHA DE VENTA</td>
                            <td class="filas"><input type="text" size="10" class="form-control" id="fechaV" name="fechaV" value="<?php echo date("Y-m-d"); ?>"  ></td>
                            <td class="filas" ></td>
                            <td class="filas" colspan="2"  style="text-align:right" >FECHA INICIAR  PAGO</td>
                            <td class="filas" >
                                <div style="width: 40%;float:left;"><input type="text" size="5" class="form-control" id="fechaIP" name="fechaIP" value="<?php echo date("Y-m-d"); ?>"  ></div>
                                <div style="text-align: right"> 
                                    Hora <select name="hora">
                                        <option>AM</option>
                                        <option>PM</option>
                                        <option>PD</option>                                        
                                    </select> 
                            </td>


                        </tr>
                        <tr>
                            <td class="filas">LETRA</td>
                            <td class="filas"><input type="text" name="cuota" id="cuota" class="nesesario" required></td>
                            <td class="filas">MESES</td>
                            <td class="filas"><input type="text" name="n_meses" size="5" id="n_meses" class="nesesario" required></td>
                            <td class="filas">TOTAL</td>
                            <td class="filas"><input type="text" name="totalCredito" id="totalCredito" class="nesesario" required></td>
                        </tr>
                        <tr>
                            <td class="filas" >CONDICION DE PAGO</td>
                            <td class="filas">
                                <select name="cond_pago" class="nesesario">
                                    <option value="slect">.....seleccione.....</option>
                                    <option value="DIRECTO">DIRECTO</option>
                                    <option value="PLANILLA">PLANILLA</option>
                                </select>
                            </td>
                            <td class="filas"></td>
                            <td class="filas"></td>
                            <td class="filas">PRODUCTO</td>
                            <td class="filas">
                               
                                <div class="col-lg-12">                            
                                    <div class="input-group">
<!--                                        <span class="input-group-addon" id="buscar_productos">
                                            <i class="form-control-feedback glyphicon glyphicon-search"></i></span>-->
                                        <input type="text" name="producto" id="producto" placeholder="Producto" class="nesesario" required autofocus size="25">
                                        
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="filas" >VENDEDOR</td>
                            <td class="filas"><?php echo $personal ?></td>
                            <td class="filas"></td>
                            <td class="filas"></td>
                            <td class="filas">ACUERDO</td>
                            <td class="filas" ><textarea name="acuerdoventa" style="margin: 0px; width: 300px; height: 70px;" class="nesesario"></textarea></td>

                        </tr>
                        <tr style="background-color:#FF7070;color: black  ">
                            <td class="filas" colspan="4">FRECUENCIA</td>
                            <td class="filas" colspan="2">
                                Diario<input type="radio" name="frecuenci_msj[]" value="DIARIO">
                                Semanal<input type="radio" name="frecuenci_msj[]" value="SEMANAL">
                                Quincenal<input type="radio" name="frecuenci_msj[]" value="QUINCENA">
                                Mensual<input type="radio" name="frecuenci_msj[]" value="MENSUAL">
                            </td>


                        </tr>


                        <tr>

                            <td colspan="5">                               

                            </td>
                            <td>PAGO EN: 
                                <select name="pagoen">
                                    <option>OFICINA</option>
                                    <option>CASA</option>
                                    <option>TRABAJO</option>
                                    <option>BANCO</option>
                                </select>   
                            </td>
                        </tr>
                        <tr>

                            <td colspan="6">
<!--                                <input type="submit" value="Enviar">-->
                                <button  class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal2" id="nuevo_venta" ><span class="glyphicon glyphicon-save"></span>Aceptar</button>

                            </td>
                        </tr>
                    </table>


                </div> <!-- termina el body -->                   
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</form>