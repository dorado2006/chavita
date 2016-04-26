
<style type="text/css"> 
    .tab_class  { 

        border-collapse: separate;
        border-spacing:  5px;
        border: solid 1px #5544DD;

    } 
    .tdclass  { 
        font-family: Arial, Helvetica; 
        font-size: 09pt; 
        border-collapse: separate;
        border-spacing:  5px;

    } 

    th { 
        border : 1px solid black; 
        font : bold 09pt Arial, Helvetica, sans-serif; 
        padding : 1px; 
    }

</style> 
<script type="text/javascript">
    function imprSelec(muestra)
    {
        var ficha = document.getElementById(muestra);
        var ventimp = window.open(' ', 'popimpr');
        ventimp.document.write(ficha.innerHTML);
        ventimp.document.close();
        ventimp.print();
        ventimp.close();
    }
</script>
<form action="javascript:ventanaSecundaria('index.php?controller=cobranza&action=imprim_cron_par&idprodni=<?php echo $rows1[0]['dni'] ?>&idve=<?php echo $rows1[0]['idproceso_cobro'] ?>&cond=1')" name="frmGen" method ="post"> 
    <div id="muestra"> 
        <table align="CENTER" cellpadding="0,5" cellspacing="0" width="*" border="0" class="tab_class"> 

            <tr>
                <td class="tdclass" align="CENTER" class="titulo" colspan="7">
                    <p>NEGOIACIÓN CULTURAL IMPORT E.I.R.L</p>
                </td>
            </tr>
            <tr>
                <td class="tdclass" align="CENTER" class="titulo" colspan="7">
                    <p>Telefono:(042)527146 Rpm:#969918903
                        Dirección: Ramires Hurtado #469-Tarapoto</p>
                </td>
            </tr>
            <tr>
                <th align="CENTER" class="titulo" colspan="7">
                    Estado de Cuenta
                </th>
            </tr>

            <tr>
                <td class="tdclass" align="center" colspan="7">

                    <b><?php echo utf8_decode($rows[0]['nombres'] . " " . $rows[0]['apellidos']) ?></b>
                </td>
            </tr>       

            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Glosa</th>
                <th>Doc.</th>
                <th>Num.</th>
                <th>Debito</th>  
                <th>Credito</th>

            </tr>
            <?php

            function dias_transcurridos($credi, $abono, $dtrans, $condnum, $letra, $conletr) {

                $pagdia = $letra / $condnum;
                $totaldiascre = (int) ($credi / $pagdia);
                $d_equabono = (int) ($abono / $pagdia);
                $montoreal = $dtrans * $pagdia;
                $montoatrasd = $montoreal - $abono;
                $diasatrasados = ($montoatrasd / $pagdia) / $condnum;
                $numero = round($diasatrasados, 2);
                $deudasol = $numero * $pagdia;
                $enter = (int) $numero;
                $decim = (int) ((round($numero - $enter, 2)) * $condnum);

                if ($dtrans < $totaldiascre) {


                    if ($d_equabono < $dtrans) {


                        $diasatrconv = "Ud. Se está Retrasando con  " . round(($montoatrasd),2) . "  Nuevos Soles con, " . $enter . " " . $conletr . "  y " . $decim . " dias de Atraso";
                    } else {

                        $diasatrconv = "Felicitaciones. Ud. Hasta este Momento No Adeuda Nada";
                    }
                } else {
                    $diasatrconv = "Ud.A Excedido del Tiempo de Su Credito. tiene una deuda de " . round(($credi - $abono),2) . "  Nuevos Soles con, " . $enter . " " . $conletr . "  y " . $decim . " dias de Atraso";
                }


                return $diasatrconv;
            }

            $credito = 0;
            $amort = 0;
            $deudarealp = 0;
            foreach ($rows1 as $key => $data):

                if (!empty($data['cond_pago'])) {
                    $credito = $credito + $data['credito'];

                    if ($data['abono'] < $data['credito']) {
                        $datras = dias_transcurridos($data['credito'], $data['abono'], $data['distrasc'], $data['frecuen'], $data['letra'], $data['frecuencia_msg']);
                    } else {
                        $datras = "Ud.f4 tiene una deuda de 0.00 Nuevos Soles, con 0  " . $data['frecuencia_msg'] . " y 0 dias de Atraso";
                    }
                    ?>
                    <tr>
                        <td class="tdclass" align="right"><?php echo $key + 1 ?></td>
                        <td class="tdclass" align="center"><?php echo $data['fecha_mov'] ?></td>
                        <td class="tdclass" align="center"><?php echo $data['producto'] . " --" . $data['num_cuotas'] . $data['frecuencia_msg'] ?></td>
                        <td class="tdclass" align="center"><?php echo $data['documento'] ?></td>
                        <td class="tdclass" align="center"><?php echo $data['nro_recibo'] ?></td>
                        <td class="tdclass" align="center"><?php echo $data['credito'] ?></td>
                        <td class="tdclass" align="center"></td>    

                    </tr>    
                    <?php
                } else {
                    $amort = $amort + $data['abono'];
                    ?>
                    <tr>
                        <td class="tdclass" align="right"><?php echo $key + 1 ?></td>
                        <td class="tdclass" align="center"><?php echo $data['fecha_mov'] ?></td>
                        <td class="tdclass" align="center"><?php echo $data['producto'] . " --" . $data['num_cuotas'] . $data['frecuencia_msg'] ?></td>
                        <td class="tdclass" align="center"><?php echo $data['documento'] ?></td>
                        <td class="tdclass" align="center"><?php echo $data['nro_recibo'] ?></td>
                        <td class="tdclass" align="center"><?php echo $data['credito'] ?></td>
                        <td class="tdclass" align="center"><?php echo $data['abono'] ?></td>    

                    </tr>            
                <?php } endforeach; ?>
            <tr>
                <td class="tdclass" align="right" colspan="4"></td >
                <th class="tdclass" align="center">Sumas</th>
                <th class="tdclass" align="center"><?php echo $credito ?></th>
                <th class="tdclass" align="center"><?php echo $amort ?></th>

            </tr> 
            <tr>
                <?php
                $saldofin = 0;
                $saldofin = round(($credito - $amort),2);
                ?>
                <td class="tdclass" align="right" colspan="4"></td>
                <th class="tdclass" align="center">Saldo T</th>
                <?php if ($saldofin >= 0) { ?>
                    <th class="tdclass" align="center"><?php echo $saldofin ?></th>
                    <th class="tdclass" align="center">0.00</th> 
                <?php } else {
                    ?>
                    <th class="tdclass" align="center">0.00</th>
                    <th class="tdclass" align="center"><?php echo round(($amort - $credito),2) ?></th>

                <?php } ?>



            </tr> 
            <tr>
                <th class="tdclass" align="center" colspan="7">

                    <?php echo $datras ?>


                </th>
            </tr>

            <tr>
                <td class="tdclass" align="center" colspan="7">
                    <br/>

                    <br/>
                </td>
            </tr>
        </table>

    </div>



    <!--<a href="javascript:imprSelec('muestra')" class="btn">Imprimir</a>-->

    <a class="btn btn-info btn-sm " id="imprimir" href="index.php?controller=cobranza&action=imprim_cron_par&idprodni=<?php echo $rows1[0]['dni'] ?>&idve=<?php echo $rows1[0]['idproceso_cobro'] ?>&cond=1">
        <span class="glyphicon glyphicon-print  "></span> IMPRIMIR ESTADO</a>
</form>