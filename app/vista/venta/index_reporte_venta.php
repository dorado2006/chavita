<style>
    #contreporte{border: 2px #000 groove;
                 padding-left: 1%;
                 padding-right: 1%;
                 margin-left:  1%;
                 margin-right: 1%
    }
    #cabezareporte{padding: 2px}


    span.redm {
        background: red;
        border-radius: 35px;
        -moz-border-radius: 35px;
        -webkit-border-radius: 35px;
        color: #ffffff;
        display: inline-block;
        font-weight: bold;
        line-height: 70px;
        margin-right: 15px;
        text-align: center;
        font-size: 10px;
        width: 70px; 
        cursor: pointer
    }


</style>
<script>
    $(function() {
        $("#buscar").click(function() {
            var fecha_i = $('#fecha_i').val();
            var fecha_f = $('#fecha_f').val();
            $.post('../web/index.php', 'controller=venta&action=get_ventas&fechai=' + fecha_i + '&fechaf=' + fecha_f, function(data) {
                console.log(data);
                $("#cuerporeporte").empty().append(data);
            });
        });

        $(".botonExcel").click(function(event) {
            $("#datos_a_enviar").val($("<div>").append($("#Exportar_a_Excel").eq(0).clone()).html());
            $("#FormularioExportacion").submit();
        });

        $("#busquedasector").change(function() {

            var combinacion = $('#combinar').is(':checked');
            if (combinacion == false) {

                var condi1 = $("#busquedasector").val();

                cond_wher = 2;
                $.post('../web/index.php', 'controller=cobranza&action=reportes&condi1=' + condi1 + '&cond_wher=' + cond_wher, function(data) {
                    console.log(data);
                    $("#cuerporeporte").empty().append(data);
                });
            }
            else {

                var condi1 = $("#busquedasector").val();
                var condi = $("#busquedareporte").val();
                var cond_wher = 3;
                $.post('../web/index.php', 'controller=cobranza&action=reportes&condi=' + condi + '&cond_wher=' + cond_wher + '&condi1=' + condi1, function(data) {
                    console.log(data);
                    $("#cuerporeporte").empty().append(data);
                });

            }




        });


        $("#imprimir").click(function() {

            bval = true;

            if (bval) {
                $("#frm").submit();
            }
            return false;
        });







    });


</script>
<style media="print" type="text/css">
    #imprimir {visibility:hidden}
    //.cuerpotabla1{visibility:hidden}
    //#cabtabla{visibility: hidden}
    //#menu{visibility: hidden}
    //#cabezareporte{visibility:hidden}
    //#mmmcabecera{visibility: hidden}



</style>
<h5><B>REPORTE DE VENTAS DIA/ MES/ AÑO</B></h5>
<div id="contreporte">
    <div id="cabezareporte" class="cabezareporte" style="text-align: center">
        <table border="0">
            <tr>
                <td><b>DESDE</b></td>
                <td>
                    <input type="date"  name="fecha_i" id="fecha_i">
                </td>
                <td width="15%" align="center"></td>
                <td><b>HASTA</b></td>
                <td>
                    <input type="date" name="fecha_f" id="fecha_f">
                </td>
                <td>
                    <button class="btn btn-info btn-sm"  id="buscar" title="BUSCAR" ><span class="glyphicon glyphicon-pencil  "></span>BUSCAR</button>

                </td>
                <td width="5%"></td>

                <td> 

                <td><form action="../app/vista/cobranza/exportar_excel.php" method="post" target="_blank" id="FormularioExportacion">
                        <p style=" cursor: pointer">Exportar<img src="../web/img/excel.gif " class="botonExcel" /></p>                
                        <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
                    </form>
                </td>
                <td width="5%"></td>

                <td> 
                    <button  id="imprimir"> <img src="../web/img/printButton.png" alt="" /></button>
                </td>
            </tr>
        </table>

    </div>
    <div id="cuerporeporte" style="border: 1px #002a80 solid ; padding: 1%">



    </div>
</div>