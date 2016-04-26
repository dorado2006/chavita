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
        <td width="2%">All <input type="checkbox" name="" id="all"></td>
        <td width="6%">DNI</td>
        <td width="22%">NOMBRES</td>
        <td width="9%">SERVIDOR</td>
        <td width="7%">Credito</td>
        <td width="5%">Saldo</td>
        <td width="6%">Momento</td>
        <td width="6%">Amortiza</td>
        <td width="6%">Diferencia</td>
        <td width="8%">Inicio Pago</td>
        <td width="8%">Ultimo Pago</td>
        <td width="4%"></td>
        <td>Condición</td>
        </thead>
    </table>
</div>

<form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="cobranza" />
    <input type="hidden" name="action" value="por_sector_print" />
    <input type="text" name="seleccondic" value="<?php echo $rowscond['condi'] ?>" />
    <input type="text" name="seleccondicDistrito" value="<?php echo $rowscond['condi1'] ?>" />
    <input type="text" name="selec_op" value="<?php echo $rowscond['cond_wher'] ?> " />


    <?php

//echo"<pre>";print_r($rowscond);exit;
    function diferenciaDias($inicio, $fin) {
        $inicio = strtotime($inicio);
        $fin = strtotime($fin);
        $dif = $fin - $inicio;
        $diasFalt = (( ( $dif / 60 ) / 60 ) / 24);
        return ceil($diasFalt);
    }

    foreach ($rows as $key => $data):
        $fechaI = $data['a_partir_de'];
        $dias = diferenciaDias($fechaI, date("Y-m-d"));
        $conmese = round(($dias / 30) + 1);
        
        if ($data['a_partir_de'] > date("Y-m-d")) {
           $xporcentaje = 100;
           $ultimaFP="<FONT COLOR='green'><b>T N L T P</b></FONT>";
           $ahora=0;
           $diferencia=0;
           $amort=0;
        } else {
            
             $xporcentaje = (($data['abonar'] * 100) / $ahora);
             
              $ahora = ($conmese * $data['letra']);
             $diferencia = $ahora - $data['abonar'];
            
             if($data['abonar']==""){
                $amort =0;
                $ultimaFP="<FONT COLOR='red'><b>N C P </b></FONT>";
             }
             else{
                  $amort="S/. " . $data['abonar'] ;
                  $ultimaFP=$data['ultima_fechap'];
             }
        }

        $saldocredito = ($data['credito'] - $data['abonar']);
        ?>

        <div class="cuerpotabla1">
            <table width="100%" border="1" style="font-size: 12px;" >
                <tbody>
                    <?php
                    if ($xporcentaje >= 80 and $xporcentaje <= 100) {
                        ?>

                        <tr class="analisis <?php echo "trs" . $data['dni'] ?>" <?php echo "id='" . $data['dni'] . "'" ?> >
                            <td width="3%" style="padding-top:15px"><?php echo ($key + 1) ?></td>
                            <td width="2%" >
                                <input type="checkbox" name="pasarplanilla[]" class="<?php echo $data['dni'] ?> alltodo"  value="<?php echo $data['dni'] ?>" >
                            </td> 
                            <td width="6%"><?php echo $data['dni'] ?></td>
                            <td width="22%" ><?php echo $data['apellido_p'], " ", $data['nombres'] ?></td>
                            <td width="9%" ><?php echo $data['T_servidor'] ?></td>
                            <td width="7%" ><?php echo "S/. " . $data['credito'] ?></td>
                            <td width="5%" ><?php echo "S/. " . $saldocredito ?></td>
                            <td width="6%" ><?php echo "S/. " . $ahora ?></td>
                            <td width="6%"><?php echo $amort ?></td>
                            <td width="6%"><?php echo "S/. " . $diferencia ?></td>
                            <td width="8%"><?php echo $data['a_partir_de'] ?></td>
                            <td width="8%"><?php echo $ultimaFP ?></td>   
                            <td width="4%"> <div class="green"></div></td>
                            <td><?php echo $data['cond_pago'] ?></td>
                        </tr>  
                        <?php
                    }
                    if ($xporcentaje >= 50 and $xporcentaje <= 79) {
                        ?>
                        <tr class="analisis <?php echo "trs" . $data['dni'] ?>" <?php echo "id='" . $data['dni'] . "'" ?> >
                            <td width="3%" style="padding-top:15px"><?php echo ($key + 1) ?></td>
                            <td width="2%">
                                <input type="checkbox" name="pasarplanilla[]" class="<?php echo $data['dni'] ?> alltodo"  value="<?php echo $data['dni'] ?>" >
                            </td> 
                            <td width="6%"><?php echo $data['dni'] ?></td>
                            <td width="22%"><?php echo $data['apellido_p'], " ", $data['nombres'] ?></td>
                            <td width="9%"><?php echo $data['T_servidor'] ?></td>
                            <td width="7%"><?php echo "S/. " . $data['credito'] ?></td>
                            <td width="5%"><?php echo "S/. " . $saldocredito ?></td>
                            <td width="6%"><?php echo "S/. " . $ahora ?></td>
                            <td width="6%"><?php echo $amort ?></td>
                            <td width="6%"><?php echo "S/. " . $diferencia ?></td>
                            <td width="8%"><?php echo $data['a_partir_de'] ?></td>
                            <td width="8%"><?php echo $ultimaFP ?></td> 
                            <td width="4%"><div class="orange"></div></td>
                            <td><?php echo $data['cond_pago'] ?></td>
                        </tr> 
                        <?php
                    }
                    if ($xporcentaje >= 0 and $xporcentaje <= 49) {
                        ?>

                        <tr class="analisis <?php echo "trs" . $data['dni'] ?>" <?php echo "id='" . $data['dni'] . "'" ?> >
                            <td width="3%" style="padding-top:15px"><?php echo ($key + 1) ?></td>
                            <td width="2%">
                                <input type="checkbox" name="pasarplanilla[]" class="<?php echo $data['dni'] ?> alltodo"  value="<?php echo $data['dni'] ?>" >
                            </td> 
                            <td width="6%"><?php echo $data['dni'] ?></td>
                            <td width="22%"><?php echo $data['apellido_p'], " ", $data['nombres'] ?></td>
                            <td width="9%"><?php echo $data['T_servidor'] ?></td>
                            <td width="7%"><?php echo "S/. " . $data['credito'] ?></td>
                            <td width="5%"><?php echo "S/. " . $saldocredito ?></td>
                            <td width="6%"><?php echo "S/. " . $ahora ?></td>
                            <td width="6%"><?php echo $amort ?></td>
                            <td width="6%"><?php echo "S/. " . $diferencia ?></td>
                            <td width="8%"><?php echo $data['a_partir_de'] ?></td>
                            <td width="8%"><?php echo $ultimaFP ?></td> 
                            <td width="4%">
                                <div class="red"></div>

                            </td>
                            <td><?php echo $data['cond_pago'] ?></td>

                        </tr> 
                    <?php } ?>
                </tbody>
            </table>
        </div>

    <?php endforeach; ?> 

</form>
