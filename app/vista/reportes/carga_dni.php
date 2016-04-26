

<script>
    $(function() {
        var oTable1 = $('#sample-table-2').dataTable();

    });

</script>

<?php 

if ($cond[0] == '1') { ?>
    <div style="background-color: yellow;color: red;width: 100%;text-align: center">
        <h1>Los Datos fueron cargados con exito.</h1></div>
    <?php
} else {
    ?>
    <div class="table-header">
        Lista de Clientes
    </div>


    <table id="sample-table-2" class="table table-striped  table-bordered table-hover">
   
        <thead style="color: linen;font-size: 14px   ">
            <tr>
                <td >DNI</td>
                <td class="chec1 apagado">Cliente</td>
                <td class="chec9 apagado">D-CASA</td>
                <td class="chec10 apagado">TELF'S Cliente</td>
                <td class="chec7 apagado">CENTRO TRABAJO</td>
                <td class="chec8 apagado">D.TRABAJO</td>
                <td class="chec11 apagado">TLF.TRABAJO</td>
                <td class="chec14 apagado">TIP.SERVIDOR</td>

                <td class="chec4 apagado">CREDITO</td>
                <td class="chec13 apagado">T.AMORTIZA</td>
                <td class="chec5 apagado">SALDO</td>            
                <td class="chec2 apagado">U.F.PAGO</td>
                <td  class="chec3 apagado">ULTIMO PAGO</td>

                <td class="chec6 apagado" colspan="6" style="text-align: center">ACUERDOS</td>

                <td class="chec12 apagado" colspan="7" style="text-align: center">DESCRIPCION DE CREDITO
                </td>


            </tr>

        </thead>
        <tbody style="font-size: 10px;font-family: Verdana, Arial, Helvetica;color: black">
            <tr>
                <td ></td>
                <td class="chec1 apagado"></td>
                <td class="chec9 apagado"></td>
                <td class="chec10 apagado"></td>
                <td class="chec7 apagado"></td>
                <td class="chec8 apagado"></td>
                <td class="chec11 apagado"></td>

                <td class="chec14 apagado"> </td>
                <td class="chec4 apagado"></td>
                <td class="chec13 apagado"></td>
                <td class="chec5 apagado"></td>            
                <td class="chec2 apagado"></td>
                <td  class="chec3 apagado"></td>


                <td class="chec6 apagado" style="background-color: #DF835A">ACUERDO</td>
                <td class="chec6 apagado" style="background-color: #E5BAA7">F.VISTA </td>
                <td class="chec6 apagado" style="background-color: #DF835A">F.PAGO</td>
                <td class="chec6 apagado" style="background-color: #E5BAA7">FUENTE</td>
                <td class="chec6 apagado" style="background-color: #DF835A">FRECUENCIA</td>
                <td class="chec6 apagado" style="background-color: #E5BAA7">PAGO EN</td>

                <td  class="chec12 apagado" style="background-color:#BFF2EB ">PRODUCTO</td>  
                <td class="chec12 apagado" style="background-color:#1AB8A2 ">CREDITO</td>
                <td  class="chec12 apagado"  style="background-color:#BFF2EB ">LETRA</td>
                <td  class="chec12 apagado" style="background-color:#1AB8A2 ">Nº MESES</td>
                <td  class="chec12 apagado" style="background-color:#BFF2EB ">VENDEDOR</td>
                <td  class="chec12 apagado" style="background-color:#1AB8A2 ">COND.PAGO</td>
                <td  class="chec12 apagado" style="background-color:#BFF2EB ">INICIO PAGO</td>


            </tr>
            <?php
//         $data['rowscl'] = $cobr->carga_dniclient();
//        $data['rowsamor'] = $cobr->carga_dniamor();
//        $data['rowsamor'] = $cobr->carga_dniacu();
//        $data['rowsprod'] = $cobr->carga_dniprod();
            //echo "<pre>";  print_r($rowsamor);exit;
            // echo $rowsamor['72254504'];exit;
            $aba = 0;
            $cont = 0;
            $conti = 0;
           
            foreach ($rows as $ke => $valor):
               
                ?>
                <tr>               
                    <td class="hidden-480" ><?php echo $rows[$aba]['dnicliente']; ?></td>
                    <td class="hidden-480  chec1 apagado"><?php echo $rows[$aba]['clint']; ?></td> 
                    <td class="hidden-480 chec9 apagado "><?php echo $rows[$aba]['dircliente']; ?></td> 
                    <td class="hidden-480 chec10 apagado "><?php echo $rows[$aba]['tlfcliente']; ?></td> 
                    <td class="hidden-480 chec7 apagado"><?php echo $rows[$aba]['centrotrab']; ?></td> 
                    <td class="hidden-480 chec8 apagado"><?php echo $rows[$aba]['direciontrabajo']; ?></td> 
                    <td class="hidden-480 chec11 apagado"><?php echo $rows[$aba]['tlfcentrtran']; ?></td> 
                    <td class="hidden-480 chec14 apagado"><?php echo $rows[$aba]['perfilcli']; ?></td> 

                    <td class="hidden-480 chec4 apagado"><?php echo $rows[$aba]['tcredito']; ?></td> 
                    <?php if ($rows[$aba]['tabono'] > 0) { ?> 
                        <td class="hidden-480  chec13 apagado"><?php echo $rows[$aba]['tabono']; ?></td>  
                    <?php } else { ?>
                        <td class="hidden-480  chec13 apagado"></td>   
                    <?php } ?>
                    <td class="hidden-480 chec5 apagado"><?php echo($rows[$aba]['tcredito'] - $rows[$aba]['tabono']); ?></td>  
                    <td class="hidden-480 chec2 apagado"><?php echo $rows[$aba]['fecha_up']; ?></td> 

                    <td class="hidden-480  chec3 apagado"><?php echo $rows[$aba]['amortiza']; ?></td> 

                    <td class="hidden-480 chec6 apagado"><?php echo $rows[$aba]['acuerdo']; ?></td> 
                    <td class="hidden-480 chec6 apagado "><?php echo $rows[$aba]['fecha_visita']; ?></td>
                    <td class="hidden-480 chec6 apagado"><?php echo $rows[$aba]['fecha_verif']; ?></td>
                    <td class="hidden-480 chec6 apagado"><?php echo $rows[$aba]['fuente']; ?></td>
                    <td class="hidden-480 chec6 apagado"><?php echo $rows[$aba]['frecuencia_msg']; ?></td>
                    <td class="hidden-480 chec6 apagado"><?php echo $rows[$aba]['pagoen']; ?></td>

                    <td class="chec12 apagado" colspan="7" >
                        <table border="1" width='100%' >
                            <tbody style="font-size: 11px;font-family: Verdana, Arial, Helvetica;color: black">

                                <?php
                                for ($i = $cont; $i < $cont + $rows[$aba]['tproductos']; $i++) {
                                    $conti = $conti + 1;
                                    ?>


                                    <tr>       
                                        <td width="15%" class="hidden-480" style="background-color:#BFF2EB "><?php echo $rows[$i]['producto']; ?></td>  
                                        <td  width="15%" class="hidden-480" style="background-color:#1AB8A2 "><?php echo $rows[$i]['credito']; ?></td>
                                        <td width="10%" class="hidden-480" style="background-color:#BFF2EB " ><?php echo $rows[$i]['letra']; ?></td>
                                        <td width="15%" class="hidden-480" style="background-color:#1AB8A2 "><?php echo $rows[$i]['num_cuotas']; ?></td>
                                        <td width="20%" class="hidden-480" style="background-color:#BFF2EB "><?php echo $rows[$i]['primer_nombre']; ?></td>
                                        <td width="15%" class="hidden-480" style="background-color:#1AB8A2 "><?php echo $rows[$i]['cond_pago']; ?></td>
                                        <td width="10%" class="hidden-480" style="background-color:#BFF2EB "><?php echo $rows[$i]['a_partir_de']; ?></td>
                                    </tr>


                                    <?php
                                }

                                $cont = $conti;
                                $aba = $conti;
                                if ($rows[$aba]['dnicliente'] == "") {
                                    exit;
                                }
                                ?> </tbody>
                        </table>
                    </td>  


                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php }
?>