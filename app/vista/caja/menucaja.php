<style>
    .ui-autocomplete .highlight {
        text-decoration: underline;
    }
    .bgmenualma{background-color: #227179}
</style>
<script>
    $(function () {



        $(".apertura").click(function () {

            $.post("../web/index.php", "controller=caja&action=apertura", function (data) {

                console.log(data.msg);
                $(".cuerpo-reporte").empty().append(data);

            });
            $(this).addClass("active");
            $(".caja_entrada").removeClass("active");
            $(".caja_salida").removeClass("active");
            $(".arqueo").removeClass("active");
            $(".reportes").removeClass("active");
        });

        $(".arqueo").click(function () {

            $.post("../web/index.php", "controller=caja&action=arqueo", function (data) {

                console.log(data.msg);
                $(".cuerpo-reporte").empty().append(data);

            });
            $(this).addClass("active");
            $(".caja_entrada").removeClass("active");
            $(".caja_salida").removeClass("active");
            $(".apertura").removeClass("active");
            $(".reportes").removeClass("active");
        });

        $(".caja_salida").click(function () {

            $.post("../web/index.php", "controller=caja&action=salida_flujo", function (data) {

                console.log(data.msg);
                $(".cuerpo-reporte").empty().append(data);

            });
            $(this).addClass("active");
            $(".arqueo").removeClass("active");
            $(".caja_entrada").removeClass("active");
            $(".apertura").removeClass("active");
            $(".reportes").removeClass("active");

        });
        $(".caja_entrada").click(function () {

            $.post("../web/index.php", "controller=caja&action=entrada_flujo", function (data) {

                console.log(data.msg);
                $(".cuerpo-reporte").empty().append(data);

            });
            $(this).addClass("active");
            $(".arqueo").removeClass("active");
            $(".caja_salida").removeClass("active");
            $(".apertura").removeClass("active");
            $(".reportes").removeClass("active");

        });
        $(".reportes").click(function () {

            $.post("../web/index.php", "controller=caja&action=reportes", function (data) {

                console.log(data.msg);
                $(".cuerpo-reporte").empty().append(data);

            });
            $(this).addClass("active");
            $(".arqueo").removeClass("active");
            $(".caja_salida").removeClass("active");
            $(".apertura").removeClass("active");
            $(".caja_entrada").removeClass("active");

        });
    });
</script>
<?php //echo"<pre>";print_r($rowst); ?>

<ul class="nav nav-tabs " style=" margin-left: 5px">
    <li class="apertura"><a href="#" class="bgmenualma">APERTURA CAJA</a></li>
    <li class="caja_entrada"><a href="#" class="bgmenualma">INGRESO FLUJO</a></li>
    <li class="caja_salida"><a href="#" class="bgmenualma">SALIDA FLUJO</a></li>
    <li class="arqueo"><a href="#" class="bgmenualma">ARQUEO CAJA</a></li>
    <!--   <li class=""><a href="#" class="bgmenualma">CIERRE DE CAJA</a></li>-->
    <li class="reportes"><a href="#" class="bgmenualma">REPORTES</a></li>
</ul>
<input type="hidden" id="idperfil" value="<?php echo $_SESSION['idperfil'] ?>">



<div class="cuerpo-reporte" style=" margin: 0px 5px 0px 5px">
</div>
