<style>
    .analisis:hover{
        background-color:#4BBFF3;
        cursor:default;
    }

    .red {

        width: 24px;
        height: 24px;
        background:#ff0000; 
        -moz-border-radius: 12px; 
        -webkit-border-radius: 12px; 
        border:1px #000 solid
    }

    .green {
        width: 24px;
        height: 24px;
        background: green; 
        -moz-border-radius: 12px; 
        -webkit-border-radius: 12px; 
        border:1px #000 solid
    }
    .orange {
        width: 24px;
        height: 24px;
        background: orange; 
        -moz-border-radius: 12px; 
        -webkit-border-radius: 12px; 
        border:1px #000 solid
    }


</style>
<script>
    $(function() {

        $("#all").click(function() {

            var bandera = $(this).is(":checked");

            if (bandera == true) {
                //$('.alltodo').prop('checked', true);
                $(".alltodo:checkbox:not(:checked)").attr("checked", "checked");
            }
            else {
                $(".alltodo:checkbox:checked").removeAttr("checked");

            }


        });

        $(".analisis").click(function() {
            var ddni = $(this).attr("id");

            var cos = $('.trs' + ddni).attr("class");

            if (cos != undefined) {

                $('.' + ddni).prop('checked', true);


                $('.analisis').removeClass("trs" + ddni);
                // $('#nodiv'+ddni).css("display", "");
                $('#nodiv' + ddni).removeClass("nodiv");



            }
            else {

                $('.' + ddni).prop('checked', false);
                $('.analisis').addClass("trs" + ddni);
                $('#nodiv' + ddni).css("display", "none");
                $('#nodiv' + ddni).addClass("nodiv");
            }

        });






        // $(".nodiv").css("display", "none");


    });
</script>


<div id="cabtabla">
    <table id="Exportar_a_Excel" width="100%" border="1" style="font-size: 12px;" >
        <thead style="color: linen;font-size: 14px   ">

        <td  width="3%" style="padding-top:35px"></td>
       
        <td width="6%">DNI</td>
        <td width="22%">NOMBRES</td>
        <td width="22%">CREDITO</td>
        <td width="22%">AMORTIZA</td>
        <td width="9%">SALDO</td>
        <td width="7%">ULTIMA FECHA</td>

        </thead>
    </table>
</div>

<form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="cobranza" />
    <input type="hidden" name="action" value="por_sector" />
    <input type="hidden" name="seleccondic" value="<?php echo $rowscond['condi'] ?>" />
    <input type="hidden" name="seleccondicDistrito" value="<?php echo $rowscond['condi1'] ?>" />
    <input type="hidden" name="selec_op" value="<?php echo $rowscond['cond_wher'] ?> " />




    <div class="cuerpotabla1">
        <table width="100%" border="1" style="font-size: 12px;" >
            <tbody>
                <?php
                
                foreach ($rows as $key => $data):
                 
                    ?>
                    <tr class="analisis <?php echo "trs" . $data['dni'] ?>" <?php echo "id='" . $data['dni'] . "'" ?> >
                        <td width="3%" style="padding-top:15px"><?php echo ($key + 1) ?></td>
                       
                        <td width="6%"><?php echo $data['dni'] ?></td>
                        <td width="22%" ><?php echo $data['nombr'] ?></td>
                        <td width="22%" ><?php echo $data['tcredito'] ?></td>
                        <td width="22%" ><?php echo $data['abonar'] ?></td>
                        <td width="9%" ><?php echo "S/. " . $data['sall'] ?></td>
                        <td width="7%" ><?php echo $data['ultima_fechap'] ?></td>

                    </tr> 

                <?php endforeach; ?>  
                    

            </tbody>
        </table>
    </div>


</form>
