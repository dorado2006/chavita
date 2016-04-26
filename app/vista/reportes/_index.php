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

    $(function () {

        $("#fecha_i").datepicker({'dateFormat': 'yy-mm-dd'});
        $("#fecha_f").datepicker({'dateFormat': 'yy-mm-dd'});
        $("#buscar").click(function () {
            var fecha_i = $('#fecha_i').val();
            var fecha_f = $('#fecha_f').val();
            var separador_fi = fecha_i.split("/");
            var fechai = separador_fi[0];
            var separador_ff = fecha_f.split("/");
            var fechaf = separador_ff[0];
            $('#exe').prop('href', '../app/vista/reportes/desExelrecibos.php?fechai=' + fechai + '&fechaf=' + fechaf);
            $.post('../web/index.php', 'controller=reportes&action=get_cierre_md&fechai=' + fechai + '&fechaf=' + fechaf, function (data) {
                console.log(data);
                $("#cuerporeporte").empty().append(data);
            });
        });
        $("#busquedasector").change(function () {

            var combinacion = $('#combinar').is(':checked');
            if (combinacion == false) {

                var condi1 = $("#busquedasector").val();
                cond_wher = 2;
                $.post('../web/index.php', 'controller=cobranza&action=reportes&condi1=' + condi1 + '&cond_wher=' + cond_wher, function (data) {
                    console.log(data);
                    $("#cuerporeporte").empty().append(data);
                });
            }
            else {

                var condi1 = $("#busquedasector").val();
                var condi = $("#busquedareporte").val();
                var cond_wher = 3;
                $.post('../web/index.php', 'controller=cobranza&action=reportes&condi=' + condi + '&cond_wher=' + cond_wher + '&condi1=' + condi1, function (data) {
                    console.log(data);
                    $("#cuerporeporte").empty().append(data);
                });
            }




        });
        $("#imprimir").click(function () {

            bval = true;
            if (bval) {
                $("#frm").submit();
            }
            return false;
        });
        var options = {
            chart: {
                renderTo: 'cuerporeporte',
                defaultSeriesType: 'column'
            },
            title: {
                text: 'Reptorte Anual De Recaudo En Soles'
            },
            xAxis: {
                categories: []
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Recaudo En Soles'
                }
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.x + '</b><br/><span style="color:' + this.series.color + '">' + this.series.name + '</span>: ' + this.y + ' Soles';
                }
            },
            series: [{}]
        };
        $("#Chart_reporte_Anual").click(function () {
            $.post('../web/index.php', 'controller=reportes&action=reportesGraficos', function (data) {
                i = 0;
//                   options.series[0].name = data[i]['mes'];
//                   options.series[0].data = [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6];

                options.series[0].name = '2014 - 2015 -2016';
                var datos = [];
                $.each(data, function () {
//                    alert(data[i]['credito_total']);
                    mes = mostrar_mes_letras(data[i]['mes']);
                    options.xAxis.categories[i] = mes;
                    datos[i] = eval(data[i]['credito_total']);
                    i = i + 1;
                });
                //er[0] = 40;
                //er[1] = 40;
                //er[2] = 46;
                //alert(er[0]);
                options.series[0].data = datos;
                var chart = new Highcharts.Chart(options);
            }, 'json');
        });


        //para el nuevo 
        var OptionCharXpersonal = {
            chart: {
                renderTo: 'cuerporeporte',
                type: 'column'
            },
            title: {
                text: 'Reporte de cobros Por Personal'
            },
            subtitle: {
                text: 'Reportes cobros por Personal'
            },
            xAxis: {
                categories: [
                    'Enero',
                    'Febrero',
                    'Marzo',
                    'Abril',
                    'Mayo',
                    'Junio',
                    'Julio',
                    'Agosto',
                    'Septiembre',
                    'Octubre',
                    'Noviembre',
                    'Dicienbre'
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Soles(Miles)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{}]

//            ,
//            series: [{
//                    name: 'Tokyo',
//                    data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]
//
//                }, {
//                    name: 'New York',
//                    data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]
//
//                }
        };

        $("#Chart_reporte_cobrador").click(function () {
            $.post("../web/index.php", "controller=reportes&action=reportesGraficosxpersonal", function (data) {
                if (data.resp == 1) {
                    console.log(data.msg);

                    // OptionCharXpersonal.series = data.msg;
                    OptionCharXpersonal.series = data.msg;
                    var chartXpersonal = new Highcharts.Chart(OptionCharXpersonal);

                }

            }, 'json');

        });

    });

    function mostrar_mes_letras(num) {
        switch (parseInt(num))
        {
            case 1:
                t = "Enero";
                break;
            case 2:
                t = "Febrero";
                break;
            case 3:
                t = "Marzo";
                break;
            case 4:
                t = "Abril";
                break;
            case 5:
                t = "Mayo";
                break;
            case 6:
                t = "Junio";
                break;
            case 7:
                t = "Julio";
                break;
            case 8:
                t = "Agosto";
                break;
            case 9:
                t = "Setiembre";
                break;
            case 10:
                t = "Octubre";
                break;
            case 11:
                t = "Noviembre";
                break;
            case 12:
                t = "Diciembre";
                break;
        }

        return t;
    }
</script>
<style media="print" type="text/css">
    #imprimir {visibility:hidden}
    //.cuerpotabla1{visibility:hidden}
    //#cabtabla{visibility: hidden}
    //#menu{visibility: hidden}
    //#cabezareporte{visibility:hidden}
    //#mmmcabecera{visibility: hidden}



</style>
<p class="alert alert-info">REPORTE DE RECAUDACION  MES/ DIA/ AÑO</p>
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
                <td width="5%" align="center"></td>
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
                    <a id="exe"><img src="../web/img/excel.gif " /></a>
                </td>
                <td width="5%"></td>

                <td width="5%"></td>

                <td> 
                <td align="center" colspan="2"> 

                    <div style=" border: solid 1px #005500"> <select>
                            <option>2014</option>
                            <option>2015</option>
                            <option>2016</option>
                        </select>
                        <button type="button" title="editar"   id="Chart_reporte_Anual" name="Chart_reporte_Anual" class="btn btn-primary">COBRANZA/ANUAL</button>
                        <button type="button" title="editar"   id="Chart_reporte_cobrador" name="Chart_reporte_Anual" class="btn btn-primary ">COBRANZA/COBRADOR</button>                
                    </div>
                </td>
<!--                <td align="center"> 
                    
                </td>-->
            </tr>
        </table>

    </div>
    <div id="cuerporeporte" style="padding: 1%">
        <script src="../web/js/highcharts.js"></script>
        <script src="http://code.highcharts.com/modules/exporting.js"></script>
        <!--<script src="../../js/modules/exporting.js"></script>-->


    </div>

    <div id="contenedor">

    </div>  
</div>
