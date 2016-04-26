
<script >

    $(function () {

        $('.filt').hide();

        $('#exe').click(function () {
            fech = $("#fecha_f").val();
            fechai = "vacia";
            sesi1 = $('#idpersonal').val();
            if (sesi1 == "") {
                sesi = $("#fecha_f").attr('sesio');
            } else {
                sesi = sesi1;
            }

            $('#exe').prop('href', '../app/vista/reportes/desExel.php?fechai=' + fechai + '&fechaf=' + fech + '&sesi=' + sesi);
//            $.post('../web/index.php', 'controller=cobranza&action=index_asig&fech=' + fech, function (data) {
//                console.log(data);
//                $(".contenedor").empty().append(data);
//            });
        });
        $('#idpersonal').change(function () {
            $(".apertura1").addClass("active");
            $(".btn_acuerdesact").removeClass("active");
            $(".btn_acuactivos").removeClass("active");
            $(".btn_snasig").removeClass("active");

            $(".btn_naranja").removeClass("active");
            $(".btn_verde").removeClass("active");
            $(".btn_rojo").removeClass("active");

            fech = $("#fecha_f").val();
            fechai = "vacia";
            sesi = $(this).val();
            // $('#exe').prop('href', '../app/vista/reportes/desExel.php?fechai=' + fechai + '&fechaf=' + fech + '&sesi=' + sesi);
            $.post('../web/index.php', 'controller=cobranza&action=index_asig&fech=' + fech + '&sesi=' + sesi, function (data) {
                console.log(data);
                $(".contenedor").empty().append(data);
            });
            $('.filt').show()();
        });
    });</script>

<style>
    .ui-autocomplete .highlight {
        text-decoration: underline;
    }
    .bgmenualma{background-color: #227179}
</style>
<script>
    $(function () {

        $(".btn_rojo").click(function () {

            sesi = $('#idpersonal').val();
            $.post("../web/index.php", "controller=cobranza&action=index_asig_color&color=danger&sesi=" + sesi, function (data) {

                console.log(data.msg);
                $(".contenedor").empty().append(data);

            });
            $(this).addClass("active");
            $(".btn_naranja").removeClass("active");
            $(".btn_verde").removeClass("active");

        });

        $(".btn_naranja").click(function () {

            sesi = $('#idpersonal').val();
            $.post("../web/index.php", "controller=cobranza&action=index_asig_color&color=warning&sesi=" + sesi, function (data) {

                console.log(data.msg);
                $(".contenedor").empty().append(data);

            });
            $(this).addClass("active");
            $(".btn_rojo").removeClass("active");
            $(".btn_verde").removeClass("active");

        });
        $(".btn_verde").click(function () {
            sesi = $('#idpersonal').val();
            $.post("../web/index.php", "controller=cobranza&action=index_asig_color&color=success&sesi=" + sesi, function (data) {

                console.log(data.msg);
                $(".contenedor").empty().append(data);

            });
            $(this).addClass("active");
            $(".btn_naranja").removeClass("active");
            $(".btn_rojo").removeClass("active");

        });
        $(".btn_snasig").click(function () {
            $('.filt').hide();
            $.post("../web/index.php", "controller=cobranza&action=index_asig_nuevascon&cond=sinasig", function (data) {

                console.log(data.msg);
                $(".contenedor").empty().append(data);

            });
            $(this).addClass("active");
            $(".btn_acuerdesact").removeClass("active");
            $(".btn_acuactivos").removeClass("active");
            $(".apertura1").removeClass("active");

        });
        $(".btn_acuactivos").click(function () {
            $('.filt').hide();
            $.post("../web/index.php", "controller=cobranza&action=index_asig_nuevascon&cond=activos", function (data) {

                console.log(data.msg);
                $(".contenedor").empty().append(data);

            });
            $(this).addClass("active");
            $(".btn_acuerdesact").removeClass("active");
            $(".btn_snasig").removeClass("active");
            $(".apertura1").removeClass("active");

        });
        $(".btn_acuerdesact").click(function () {
            $('.filt').hide();
            $.post("../web/index.php", "controller=cobranza&action=index_asig_nuevascon&cond=desact", function (data) {

                console.log(data.msg);
                $(".contenedor").empty().append(data);

            });
            $(this).addClass("active");
            $(".btn_acuactivos").removeClass("active");
            $(".btn_snasig").removeClass("active");
            $(".apertura1").removeClass("active");

        });

    });
</script>
<div class="row">
    <div class=" col-lg-1"></div>
    <div class=" col-lg-4">

        <ul class="nav nav-tabs " style=" margin-left: 5px">
            <li class="apertura1"><a href="#" class="bgmenualma"><?php
                    if ($_SESSION['idperfil'] != '5') {
                        echo $asig;
                    }
                    ?></a></li>
            <li class="btn_verde filt"><a href="#" class="btn-success">FILTRO</a></li>
            <li class="btn_naranja filt"><a href="#" class="btn-warning">FILTRO</a></li>
            <li class="btn_rojo filt"><a href="#" class="btn-danger">FILTRO</a></li>
            <!--   <li class=""><a href="#" class="bgmenualma">CIERRE DE CAJA</a></li>-->
            <!--    <li class="reportes1"><a href="#" class="bgmenualma">REPORTES</a></li>-->
        </ul>
    </div>
    <div class=" col-lg-1"></div>
    <div class=" col-lg-7">
        <ul class="nav nav-tabs " style=" margin-left: 5px">

            <li class="btn_snasig "><a href="#" class="bgmenualma">SIN ASIGNAR</a></li>
            <li class="btn_acuactivos "><a href="#" class="bgmenualma">ACUERDOS ACTIVOS</a></li>
            <li class="btn_acuerdesact"><a href="#" class="bgmenualma">ACUERDOS DESACTIVADOS</a></li>
            <!--   <li class=""><a href="#" class="bgmenualma">CIERRE DE CAJA</a></li>-->
            <!--    <li class="reportes1"><a href="#" class="bgmenualma">REPORTES</a></li>-->
        </ul>
    </div>

</div>
</div>

<!--

<div class="row">
    <div class=" col-lg-1"></div>
    <div class=" col-lg-10 cuerpo-reporte" style=" margin: 0px 5px 0px 5px">
    </div>
    <div class=" col-lg-1"></div>
</div>-->

<!--
<div id="cabezareporte" class="cabezareporte" style="text-align: center">

    <table border="0" align="center" width="98%" id="latabla">
        <tr>
            <td>Busqueda por Personal </td>
            <td> <div>
<?php
if ($_SESSION['idperfil'] != '5') {
    echo $asig;
}
?>
                </div></td>

            <td style="font-family:fantasy ;text-align: right;padding-right: 10px"><b >De que Fecha quieres Exportar</b></td>
            <td>

                <input type="text" name="fecha_f" id="fecha_f" class="fecc" sesio= '<?php echo $_SESSION['idpersonal'] ?>' value="<?php echo date("Y-m-d"); ?>"  size="10"> 
            </td>

            <td>
                <button class="btn btn-info btn-sm"  id="buscar" sesio= '<?php //echo $_SESSION['idpersonal']                      ?>' title="BUSCAR" data-toggle="modal" data-target="#MyModal_bt4"><span class="glyphicon glyphicon-pencil  "></span>BUSCAR</button>

            </td>


            <td>

                <a id="exe" ><img src="../web/img/excel.gif " /></a>
            </td>
            <td width="30%" style="font-family:fantasy ;text-align: right;padding-right: 10px"> <?php
$suma = 0;
foreach ($meta as $key => $data):
    $suma = $suma + $data['sum_cuota'];
endforeach;
?>                
                <span style="background-color: yellow ;font-family:serif " >Meta: S/ <?php echo $suma ?></span> </td>


        </tr>
    </table>
</div>-->
<div class="row">
    <div class=" col-lg-1"></div>
    <div class=" col-lg-10 contenedor"> 

    </div>
    <div class=" col-lg-1"></div>
</div>

