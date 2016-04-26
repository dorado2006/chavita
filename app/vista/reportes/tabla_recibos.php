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

    $(function () {


        $("#all").click(function () {

            var bandera = $(this).is(":checked");

            if (bandera == true) {
                //$('.alltodo').prop('checked', true);
                $(".alltodo:checkbox:not(:checked)").attr("checked", "checked");
            }
            else {
                $(".alltodo:checkbox:checked").removeAttr("checked");

            }


        });

        $(".analisis").click(function () {
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

<?php //echo "<pre>"; print_r($rows); exit; ?>


<form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="cobranza" />
    <input type="hidden" name="action" value="por_sector" />
    <input type="hidden" name="seleccondic" value="<?php echo $rowscond['condi'] ?>" />
    <input type="hidden" name="seleccondicDistrito" value="<?php echo $rowscond['condi1'] ?>" />
    <input type="hidden" name="selec_op" value="<?php echo $rowscond['cond_wher'] ?> " />




    <div class="cuerpotabla1">
        <table width="100%" border="1" style="font-size: 12px;" >
            <thead style="color: linen;font-size: 14px   ">

            <td  width="3%" style="padding-top:35px"></td>
            <td ></td>
            <td ></td>
            <td ></td>
            <td >RECIBOS</td>
            <td ></td>
            <td ></td>


            </thead>
            <tbody>
                <?php
                $cont = 0;
                $recib = array();
                echo "<td colspan='7' style='background-color: #D8EF20'>Numero de Recibos No Registrados</td>";
                for ($i = $rango1; $i <= $rango2; $i++) {

                    $conp = str_pad($i, 6, "0", STR_PAD_LEFT);
                    ?>
                    <tr>
                        <?php
                        if ($rows[$conp]['nro_recibo'] == '') {
                            $cont = $cont + 1;
                            ?>

                            <td ><?php echo $cont; ?></td>
                            <?php
                            echo "<td colspan='3' style='background-color:  #709B92'></td>";
                            echo "<td colspan='3' style='background-color:  #709B92'>" . $conp . " </td>";
                        } else {
                            $recib[] = $rows[$conp]['nro_recibo'];
                        }
                        ?>
                    </tr>
                    <?php
                }
                echo "<tr style='background-color: #D8EF20'><td colspan='7'>RECIBOS REGISTRADOS</td></tr>";
                ?>
                    <tr style="background-color: #8fa6b3 ">
                    <td  width="3%" style="padding-top:35px"></td>
                    <td >DNI</td>
                    <td >CLIENTE</td>
                    <td >FECHA</td>
                    <td >RECIBOS</td>
                    <td >MONTO</td>
                    <td >PERSONAL</td>
                </tr>
                <?php
                
                $sumtotal = 0;
                foreach ($recib as $key => $det):
                    ?>
                    <tr><td><?php echo $key + 1; ?></td>
                        <td><?php echo $rows[$det]['dni']; ?></td>
                        <td><?php echo $rows[$det]['cli']; ?></td>
                        <td><?php echo $rows[$det]['fecha_mov']; ?></td>
                        <td><?php echo $rows[$det]['nro_recibo']; ?></td>
                        <td><?php
                            echo $rows[$det]['abono'];
                            $sumtotal = $sumtotal + $rows[$det]['abono'];
                            ?></td>
                        <td><?php echo $rows[$det]['primer_nombre']; ?></td>

                    </tr>

                    <?php
                endforeach;
                echo "<tr><td colspan='4'></td><td style='text-align: left'>SUMA TOTAL</td><td>S/. " . $sumtotal . "</td></tr>"
                ?>  


            </tbody>
        </table>
    </div>


</form>
