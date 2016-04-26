<style>
    .ui-autocomplete .highlight {
        text-decoration: underline;
    }

</style>
<script>
    $(function () {
        $("#apertucaja").click(function () {
            monto = $(this).attr('monto');
            $.post('../web/index.php', 'controller=caja&action=apertura_caja&monto=' + monto, function (data) {
                alertify.success(data.msj);
                
            }, 'json');

            //return false;
            window.location="index.php?controller=caja&action=index";

        });

    });



</script>


<div class="row">
    <div class="col-lg-1"></div>
    <div class="col-lg-10">
        <div class="panel panel-info">
            <!--            <div class="panel-heading">ARQUEO DE PRODUCTOS POR VENDEDOR</div>-->
            <div class="panel-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <div class="col-lg-2"> </div>
                        <?php if (empty($rows) || ($rows[0]['apf'] != $rows[0]['api'])) { ?>
                            <label for="tags" class="col-lg-6 control-label " style=" text-align: center"><pre><h4>POR FAVOR APERTURE CAJA.</h4>
                                        <H5>USTED CERRO CAJA CON: S/.<?php echo $rows[0]['entrada'] ?></H5>
                                        <a id="apertucaja" monto="<?php echo $rows[0]['entrada'] ?>"><h3>CLIC PARA APERTURAR CAJA</h3></a></pre>
                            </label>
                        <?php } else { ?>
                            <label for="tags" class="col-lg-6 control-label " style=" text-align: center">
                                <pre><h4>NO PUEDE APERTURAR MAS DE UNA VEZ POR DIA.!!!</h4></pre>
                            </label>
                        <?php } ?>
                    </div>


                </form>
            </div>
        </div>

    </div>
</div>
