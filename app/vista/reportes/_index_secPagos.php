<style>
    #contreporte{border: 2px #000 groove;
                 padding-left: 1%;
                 padding-right: 1%;
                 margin-left:  1%;
                 margin-right: 1%
    }
    #cabezareporte{padding: 2px}

</style>

<script>
    $(function() {

        $("#fecha_i").datepicker({'dateFormat': 'yy-mm-dd'});
        $("#fecha_f").datepicker({'dateFormat': 'yy-mm-dd'});
        
         $("#buscar").click(function() {
       
            var fecha_i = $('#fecha_i').val();
            var fecha_f = $('#fecha_f').val(); 
            
            $.post('../web/index.php', 'controller=reportes&action=get_secpagos&fechai=' + fecha_i + '&fechaf=' + fecha_f, function(data) {
                console.log(data);
                $("#cuerporeporte").empty().append(data);
            });
        });
    });
</script>
<p class="alert alert-success" style="height: 10px;margin-top: -15px"><B>REPORTE DE SECUENCIA DE PAGOS PROGRESIVOS</b></p>
<div style="margin-top: -15px">
    <div id="contreporte">
        <div id="cabezareporte" class="cabezareporte" style="text-align: center">
            <table border="0">
                <tr>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">DESDE</span>

                            <input type="text" name="fecha_i" id="fecha_i"  value="<?php echo date("Y-m-d"); ?>"  size="10"> 
                        </div>

                    </td>
                    <td width="15%" align="center"></td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">HASTA</span>

                            <input type="text" name="fecha_f" id="fecha_f"  value="<?php echo date("Y-m-d"); ?>"  size="10"> 
                        </div>

                    </td>
                    <td>
                        <button class="btn btn-info btn-sm"  id="buscar" title="BUSCAR" data-toggle="modal" data-target="#MyModal_bt4"><span class="glyphicon glyphicon-pencil  "></span>BUSCAR</button>

                    </td>
                    <td width="5%"></td>

                    <td> 

                    <td>
                        <!--<a id="exe"><img src="../web/img/excel.gif " /></a>-->
                    </td>
                    <td width="5%"></td>

                    <td width="5%"></td>

                    <td> 
                    <td align="center"> 
                        <!--<button type="button" title="editar"   id="Chart_reporte_Anual" name="Chart_reporte_Anual" class="btn btn-primary ">Reporte Gráfico Del Año</button>-->
                    </td>
                </tr>
            </table>

        </div>
        <div id="cuerporeporte" style="padding: 1%">
     
        </div>
    </div>

</div>
