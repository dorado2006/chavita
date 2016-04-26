<script>


</script>

<script>
    var clidesc = 0;
    $(function() {

        $('.numdiv').dblclick(function() {

            clidesc = clidesc + 1;
            var mn = $(this).attr("class");
            var nn = mn.split(" ");

            var idenum = $(this).attr("id");
            var indicador = 1;

            if (clidesc == 1) {
                $(this).remove();

                // i = $(this).parent().parent().index();
                //$('#detalle tbody tr:eq(' + i + ')').remove();




                while (indicador <= (nn[2] - clidesc)) {
                    if (nn[1] == indicador) {
                        $('.enu' + (indicador + 1)).html(indicador);
                        $('.enu' + (indicador + 1)).prop("id", "idnumer" + indicador);
                        $('.' + (indicador + 1)).prop("id", indicador);
                        indicador = indicador + 1;
                    }
                    else {
                        if (indicador < nn[1]) {
                            $('.enu' + indicador).html((indicador));
                            $('.enu' + indicador).prop("id", "idnumer" + indicador);
                            $('.' + (indicador)).prop("id", indicador);
                            indicador = indicador + 1;
                        }
                        else {
                            $('.enu' + indicador).html((indicador - 1));
                            $('.enu' + indicador).prop("id", "idnumer" + (indicador - 1));
                            $('.' + (indicador)).prop("id", (indicador - 1));

                            indicador = indicador + 1;
                        }

                    }



                }
            }
            else {
                indicador = 1;
                $(this).remove();

                while (indicador <= (nn[2] - clidesc)) {
                    if (idenum == indicador) {
                        $('#idnumer' + (indicador + 1)).html(indicador);
                        $('#idnumer' + (indicador + 1)).prop("id", "idnumer" + indicador);
                        $('#' + (indicador + 1)).prop("id", indicador);
                        indicador = indicador + 1;
                    }
                    else {
                        if (indicador < idenum) {
                            $('#idnumer' + indicador).html((indicador));
                            $('#idnumer' + (indicador)).prop("id", "idnumer" + indicador);
                            $('#' + (indicador)).prop("id", indicador);
                            indicador = indicador + 1;
                        }
                        else {
                            $('#idnumer' + indicador).html((indicador - 1));
                            $('#idnumer' + (indicador)).prop("id", "idnumer" + (indicador - 1));
                            $('#' + (indicador)).prop("id", (indicador - 1));
                            indicador = indicador + 1;
                        }

                    }



                }



            }


        });


    });
</script>
<?php //echo "hola<pre"; print_r($rows) ;exit();?>
<div style="padding-left: 5%; padding-right: 5%;padding-top: 3% ">
    <?php

    function diferenciaDias($inicio, $fin) {
        $inicio = strtotime($inicio);
        $fin = strtotime($fin);
        $dif = $fin - $inicio;
        $diasFalt = (( ( $dif / 60 ) / 60 ) / 24);
        return ceil($diasFalt);
    }

    foreach ($rows as $key => $data):


        $ind = count($rows);


        $fechaI = $data['ultima_fechap'];
        $dias = diferenciaDias($fechaI, date("Y-m-d"));
        $conmese = round(($dias / 30) + 1);
        $saldo = ($data['credito'] - $data['abonar']);
        // if ($saldo >= 0.1) {
        ?>


        <div class="numdiv <?php echo ($key + 1) . " " . $ind; ?>" style="border-top: 3px #037345 solid;margin: 5px">
            <div  class="<?php echo "enu" . ($key + 1); ?>" style=" float: left"><h4><?php echo ($key + 1) ?></div>
            <div style=" width:90%;font-size: 5px;font-family: Times New Roman; border: 1px #000000 solid;margin-top: 5px" >
                <table border="0" width="70%"  style="font-size: 10px;font-family: Times New Roman" >


                    <tr>
                        <td width="10%">
                            <label  for="dni">CLIENTE</label> </td>
                        <td width="2%">:</td>
                        <td width="33%"><?php echo utf8_encode($data['apellido_p'] . " " . $data['nombres']); ?></td>
                        <td width="10%">
                            <label  for="dni">DIRECCIÓN</label>
                        </td>
                        <td width="2%">:</td>
                        <td width="33%"><?php echo utf8_encode($data['direcion_cliente']); ?></td>

                    </tr>
                    <tr>
                        <td>
                            <label  for="telf">LABORA</label> 
                        </td>
                        <td>:</td><td><?php echo utf8_encode($data['codigo_ruc'] . " " . $data['nombre']); ?></td>
                        <td>
                            <label  for="telf">DIRECCIÓN</label> 
                        </td>
                        <td>:</td><td><?php echo utf8_encode($data['direccion'] . "-" . $data['distrito']); ?></td>
                    </tr>
                    <tr>
                        <td>
                            <label  for="telf">TELEFONOS</label> 
                        </td>
                        <td>:</td>
                        <td><?php echo $data['telefonos_cliente']; ?></td> 
                        <td>
                            <label  for="telf">Cond.Pago</label> 
                        </td>
                        <td>:</td>
                        <td><?php echo $data['cond_pago']; ?></td>
                    </tr> 

                </table>
            </div>
            <table border="0" width="90%"  style="font-size: 10px;font-family: Times New Roman" >
                <tr>
                    <td colspan="7" style="text-align: center;"><b>DETALLES DE CREDITOS</b></td>   
                </tr>

                <tr style=" border:1px  solid #003bb3">
                    <td width="5%"></td>
                    <td width="10%"> <label  for="dni">INICIO PAGO</label> </td>
                    <td width="10%"><label>CREDITO</label></td>
                    <td width="15%" ><label>LETRA</label></td>
                    <td width="10%" ><label>Nº Meses</label></td>                        
                    <td width="15%"><label>AMORTIZA</label></td>
                    <td width="10%" ><label>SALDO</label></td>
                    <td width="10%" ><label>ULT.F PAGO</label></td>
                    <td width="15%" style="border-right:1px  solid #0088cc" ><label>MESES ATRAZADOS</label></td>

                </tr>

                <tr style=" border:1px  solid #0088cc">
                    <td></td>
                    <td>  <?php echo $data['a_partir_de'] ?></td>
                    <td><?php echo $data['credito'] ?></td>
                    <td><?php echo $data['letra'] ?></td>
                    <td><?php echo $data['num_cuotas'] ?></td>                        
                    <td><?php echo $data['abonar'] ?></td>
                    <td ><?php echo $saldo ?></td>
                    <td ><?php echo $data['ultima_fechap'] ?></td>
                    <td style="border-right:1px  solid #0088cc"><?php echo ($conmese-1) . " Meses" ?></td>

                </tr>


            </table>


        </div>
        <?php
        //}

    endforeach;
    ?>

</div>

