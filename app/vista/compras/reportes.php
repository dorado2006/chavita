<style>
    .ui-autocomplete .highlight {
        text-decoration: underline;
    }
    .bgmenualma{background-color: #3676D6}
</style>
<script>
    $(function () {
       
   

        $(".reporte1").click(function () {
           
            $.post("../web/index.php", "controller=compras&action=reportes_pxp", function (data) {

                console.log(data.msg);
                $(".cuerpo-reporte").empty().append(data);

            });
            $(this).addClass( "active" );
             $(".historia").removeClass( "active" );
              $(".todprodu").removeClass( "active" );
        });

        $(".historia").click(function () {
    
            $.post("../web/index.php", "controller=compras&action=reportes_hist", function (data) {

                console.log(data.msg);
                $(".cuerpo-reporte").empty().append(data);

            });
            $(this).addClass( "active" );
            $(".reporte1").removeClass( "active" );
            $(".todprodu").removeClass( "active" );
        });
        
          $(".todprodu").click(function () {
    
            $.post("../web/index.php", "controller=compras&action=todosproduc", function (data) {

                console.log(data.msg);
                $(".cuerpo-reporte").empty().append(data);

            });
            $(this).addClass( "active" );
            $(".reporte1").removeClass( "active" );
            $(".historia").removeClass( "active" );
        });
    });
</script>
<?php //echo"<pre>";print_r($rowst); ?>

<ul class="nav nav-tabs " style=" margin-left: 5px">
    <li class="reporte1"><a href="#" class="bgmenualma">PROD. VENDEDOR</a></li>
    <li class=""><a href="#" class="bgmenualma">STOCK MINIMO</a></li>
    <li class=""><a href="#" class="bgmenualma">PROD. MAS VENDIDOS</a></li>
    <li><a href="#" class="bgmenualma">PROD. FALLADOS</a></li>
    <li class="todprodu"><a href="#" class="bgmenualma">TODOS PROD.</a></li>
    <li class="historia"><a href="#" class="bgmenualma">HIST. VENDEDOR</a></li>
</ul>
<input type="hidden" id="idperfil" value="<?php echo $_SESSION['idperfil'] ?>">



<div class="cuerpo-reporte" style=" margin: 0px 5px 0px 5px">
</div>
