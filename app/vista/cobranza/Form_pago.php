<style>
    .error{
        background-color: #BC1010;
        padding: 6px 12px;
        border-radius: 4px;
        color: white;
        font-weight: bold;
        margin-left: 16px;
        margin-top: 6px;
        position: absolute;
    }
    .error:before{ /* Este es un truco para crear una flechita */
        content: '';
        border-top: 8px solid transparent;
        border-bottom: 8px solid transparent;
        border-right: 8px solid #BC1010;
        border-left: 8px solid transparent;
        left: -16px;
        position: absolute;
        top: 5px;
    }
</style>
<script>
    cont = $('#idventa option').length-1;
    
    if (cont == 1) {
        
        id = $("#idventa").val();
        $.post('../web/index.php', 'controller=cobranza&action=buscaprodu&idproccobro=' + id, function (data) {
           console.log(data);
            $("#Mcredito").val(data[0]['credito']);
            $("#Mabono").val(data[0]['abono']);
        }, 'json');
    }

    $(function () {
        $("#fecha_pago").datepicker({'dateFormat': 'yy-mm-dd'});
        $("#idventa").change(function () {
            id = $(this).val();
            $.post('../web/index.php', 'controller=cobranza&action=buscaprodu&idproccobro=' + id, function (data) {
                /// console.log(data);
                // $("#Nueva_Venta").empty().append(data);
                //  alert(data[0][0]);
                $("#Mcredito").val(data[0]['credito']);
                $("#Mabono").val(data[0]['abono']);
            }, 'json');
        });
        $("#save").click(function () {
            indice = document.getElementById("idventa").selectedIndex;
            indice_pe = document.getElementById("idpersonal").selectedIndex;
            $(".error").remove();
            if ($(".pago_letr").val() == "") {
                $(".pago_letr").focus().after("<span class='error'>Ingrese el Monto</span>");
                return false;
            }
            else if (indice == null || indice == 0) {
                $("#idventa").focus().after("<span class='error'>Eliga el Producto</span>");
                return false;
            }

            else if ($(".n_recibo").val() == "") {
                $(".n_recibo").focus().after("<span class='error'>Ingrese Numero de Recibo</span>");
                return false;
            }
       
            else { 

                var dataString = $('#nuev_pagop').serialize();
                dni_cliente = $("#dni_cliente").val();
                var su = parseInt($("#n_recibo").val()) + 1;
                var nurecibo = su.toString();
                while (nurecibo.length < 6) {
                    nurecibo = '0' + nurecibo;
                }

                $.post('../web/index.php', dataString + '&dni_cliente=' + dni_cliente + '&nurecibo=' + nurecibo, function (data) {
                    console.log(data);
                });
                $.post('../web/index.php', 'controller=cobranza&action=cargar_datos_formulario_detalle&idcliente=' + dni_cliente, function (data) {
                    console.log(data);
                    $("#detalle").empty().append(data);
                });
                $("#pago_letr").select();
                $("#for_pago").dialog("close");
                $("#buscador").val("");
                $("#buscador").focus();
            }


        });
//        $(document).keydown(function (e) {
//
//            if (e.keyCode == 13) { // left
//
//                var dataString = $('#nuev_pagop').serialize();
//                dni_cliente = $("#dni_cliente").val();
//                var su = parseInt($("#n_recibo").val()) + 1;
//                var nurecibo = su.toString();
//                while (nurecibo.length < 6) {
//                    nurecibo = '0' + nurecibo;
//                }
//                $.post('../web/index.php', dataString + '&dni_cliente=' + dni_cliente + '&nurecibo=' + nurecibo, function (data) {
//                    console.log(data);
//
//                });
//                $.post('../web/index.php', 'controller=cobranza&action=cargar_datos_formulario_detalle&idcliente=' + dni_cliente, function (data) {
//                    console.log(data);
//                    $("#detalle").empty().append(data);
//                });
//
//                $("#pago_letr").val('')
//                $("#for_pago").dialog("close");
//
//                $('.' + id).html(restoC);
//            }
//
//        });


    });</script>
<form id="nuev_pagop" method="post">
    <input type="hidden" name="controller" value="cobranza" />
    <input type="hidden" name="action" value="nuevo_pago" />
    <table border = "0" cellspacing = "1" cellpadding = "3"  class = "table table-bordered" >

        <tbody >

            <tr class = "success" >
                <td > AMORTIZACION 
                    <div id="mmx">
                        <input type="hidden" name="Mcredito" id= "Mcredito" >
                        <input type="hidden" name="Mabono" id= "Mabono" >

                    </div>
                </td>
                <td colspan = "2" >
                    <input type = "text" name="pago_letr" id= "pago_letr" class="pago_letr" size = "10" placeholder = "S/. Amortiza"  required >
                </td>

            </tr>
            <tr class = "success" >
                <td > PRODUCTO </td>
                <td colspan = "2" > <?php echo $productos ?> </td>

            </tr>
            <tr class = "success" >
                <td > DOCUMENTO </td>
                <td > <select name = "Comp_pago" id = "Comp_pago" class="Comp_pago">
                        <option value = "Recibo" > Recibo </option>
                        <option value = "Boleta" > Boleta </option>
                        <option value = "Factura" > Factura </option>  
                        <option value = "Des.Planilla" > Des.Planilla </option>
                        <option value = "BN" > BN </option>
                    </select></td >
                <td ><input type = "text" name = "n_recibo" id="n_recibo" class="n_recibo" size = "10" value="<?php echo $rows[0]['correlativo'] ?>" placeholder = "Nº de Recibo" maxlength = "6"  onblur = "ponerCeros(this)" > </td>

            </tr>
            <tr class = "success" >
                <td > ¿Quién Cobró? </td>
                <td colspan = "2" >
                    <?php echo $personal ?>

                </td>                          


            </tr>
            <tr class = "success" >
                <td > Fecha </td>
                <td colspan = "2" >
                    <input type = "text" size = "10" class = "form-control" id = "fecha_pago" name="fecha_pago" value = "<?php echo date("Y-m-d"); ?>" >
                </td>

            </tr>
            <tr >
                <td colspan = "2" > </td>                              

                <td >
<!--                    <input type="submit" value="Enviar" />-->
                    <input type="button" name="acept" value="Aceptar" id="save" class="btn btn-info btn-sm" >

                </td>

            </tr>
        </tbody>
    </table>
</form>