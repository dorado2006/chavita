<!--<div align='left'>
<?php //echo "<pre>"; print_r($rows); exit; ?>
</div>-->
<div class="cuerpotabla1">
    <table width="100%" border="1" style="font-size: 12px;" >
        <thead style="color: linen;font-size: 14px   ">

        <td  width="1%" style="padding-top:35px;font-size:8px "></td>
        <td width="6%">DNI</td>
        <td width="18%">CLIENTE</td>
        <?php
        $t = 0;
        $i = $fechas['f1'];
        $conjfechas = array();
        do {
            $conjfechas[] = $i;
            $date = date_create($i);
            echo "<td width='5%' style='font-size:12px '>" . date_format($date, "d-m-y") . "</td>";
            $i = date("Y-m-d", strtotime($i . "+ 1 day"));
            $t++;
        } while ($i <= $fechas['f2']);
        ?>

        <td >AMORT</td>


        </thead>
        <tbody>

            <?php
            $cont = 0;


            foreach ($rows as $key2 => $datat):
                $cont = $cont + 1;
                $sumato = 0;

                $datop = $key2;
                $separacion = explode("_", $datop);
                ?>
                <tr>
                    <td ><?php echo $separacion[2] ?></td>


                    <td ><?php echo $separacion[0] ?></td>
                    <td ><?php echo $separacion[1] ?></td>

                    <?php foreach ($conjfechas as $keyf => $rfechar) {
                        ?>
                        <td ><?php
                // echo '<pre>';
                //print_r($rows[$key2][$conjfechas[$keyf]]['abonar']);
                $pagos = $rows[$key2][$conjfechas[$keyf]]['abonar'];
                $sumato = $sumato + $rows[$key2][$conjfechas[$keyf]]['abonar'];
                if ($pagos == '') {
                    echo "<div align='center' style='color: #d9534f '>";
                    echo "<span class='glyphicon glyphicon-remove' ></span>";
                } else {
                    echo "<div align='center' style='background-color: #5bc0de '>";
                    print_r($rows[$key2][$conjfechas[$keyf]]['abonar']);
                }
//                                print_r($conjfechas);
                echo "</div>";
                        ?></td>  

                        <?php
                    }
                    echo "<td>S/. " . $sumato . "</td></tr>";
                endforeach;
                ?> 
            <tr><td colspan="3"> <?php echo "TOTAL DE CLIENTES : " . count($rows); ?></td></tr>
        </tbody>
    </table>
</div>
