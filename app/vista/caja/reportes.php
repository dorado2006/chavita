

<script>

    $(function () {
        $("#fecha_i").datepicker({'dateFormat': 'yy-mm-dd'});
        $("#fecha_f").datepicker({'dateFormat': 'yy-mm-dd'});
        $(".buscar").click(function () {
      
            var fecha_i = $('#fecha_i').val();
            var fecha_f = $('#fecha_f').val();
            var separador_fi = fecha_i.split("/");
            var fechai = separador_fi[0];
            var separador_ff = fecha_f.split("/");
            var fechaf = separador_ff[0];
            
            $.post('../web/index.php', 'controller=caja&action=data_reporte&fechai=' + fechai + '&fechaf=' + fechaf, function (data) {
                console.log(data);
                $("#cuerporeporte").empty().append(data);
            });
        });

      

    });

</script>
<!--<table class="table table-bordered">-->
<div class="row" style="padding-top: 10px" >
    <div class="col-lg-5"></div>
    <div class="col-lg-7">
        <div class="col-lg-7">                            
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="form-control-feedback ">DESDE</i></span>
                <input type="text" class="form-control"  name="fecha_i" size="20" id="fecha_i"  value="<?php echo date("Y-m-d"); ?>" >
                <span class="input-group-addon limpiar">
                    <i class="form-control-feedback ">HASTA</i></span>
                <input type="text" class="form-control"  name="fecha_i" size="20" id="fecha_f"  value="<?php echo date("Y-m-d"); ?>" >
                <span class="input-group-addon buscar">
                    <i class="form-control-feedback glyphicon glyphicon-search"></i></span>

            </div>
        </div>  
    </div>
</div>
<div class="row">
    <div class="col-lg-1"></div>
    <div class="col-lg-10" id="cuerporeporte">
        
    </div>
</div>