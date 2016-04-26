
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
        <td width="9%">AMORTIZA</td>
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
                $suma = 0;
                foreach ($rows as $key => $data):
                    $suma = $suma + $data['abono'];
                    ?>
                    <tr class="analisis <?php echo "trs" . $data['dni'] ?>" <?php echo "id='" . $data['dni'] . "'" ?> >
                        <td width="3%" style="padding-top:15px"><?php echo ($key + 1) ?></td>

                        <td width="6%"><?php echo $data['dni'] ?></td>
                        <td width="22%" ><?php echo $data['nombres'] ?></td>
                        <td width="9%" ><?php echo "S/. " . $data['abono'] ?></td>
                        <td width="7%" ><?php echo $data['ultima_fecha'] ?></td>

                    </tr> 

                <?php endforeach; ?>  
                <tr style=" background-color: #b92c28; font-size: 40px ">
                    <td width="3%" style="padding-top:15px"></td>

                    <td width="6%"></td>
                    <td width="22%" >TOTAL</td>
                    <td width="9%" ><?php echo "S/. " . $suma ?></td>
                    <td width="7%" ></td> 
                </tr>


            </tbody>
        </table>
    </div>
    <div style="position: fixed;
         bottom: 300px;
         left:  30px;
         width: auto;
         height: auto;
         height: 50px;
         margin: auto;font-family: serif ">
        <table border="1" style="background-color: #FE9  ">
            <tr><td width="100">NOMBRE</td><td width="130">TOTAL RECAUDADO</td><td>Nº DE VISITAS</td></tr>
           <?php  foreach ($rows1 as $key => $data): ?>
             <tr><td><?php echo $data['primer_nombre'] ?></td><td><?php echo $data['abono'] ?></td>
             <td><?php echo $data['item'] ?></td>
             </tr>
            <?php endforeach; ?>  
        </table>
      
    </div>
    
       <div style="position: fixed;
         bottom: 0;
         right: 0;
         width: 350px;
         height: 50px;
         background-color: #91E783;margin: auto;font-size: 20px;color: blue;font-family: fantasy ">
        <?php echo " Total :  S/. " . $suma ?></div>

</form>
