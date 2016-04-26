
    <?php /*
$fecha1 = "2011-01-10";
$fecha2 = "2011-06-22";

for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 month"))){
    echo $i . "<br />";
 //aca puedes comparar $i a una fecha en la bd y guardar el resultado en un arreglo

}*/
?>
    
   <?php 
   
  
   /*
    foreach ($rows as $key=>$data): 
        $da=$data['num_cuota'];
        $fecha1 = $data['a_partir_de']; // new DateTime('".$data["fecha_venta"]."'); 
       
    
        for($i=1;$i<=$da;$i++){
         $aux=$fecha1;
         if($i!=1){$aux=$fecha2;}
         $fecha2 =date("Y-m-t", strtotime($aux."+28 day"));
         
         echo '<br>';
        
        }
        endforeach;*/
   $suma=0;
   $idcli=64;
   foreach ($rows as $key=>$data): 
       $suma=$suma+$data['monto'];
  // echo "UPDATE `acuerdo_pago` SET `idpersonal`='".$data['fuente']."' WHERE `dni`='".$data['dnicli']."';";
/*    ECHO "UPDATE `cliente` SET `apellidos`='".$data['app']."' WHERE (`dni`='".$data['dni']."');";
   //    echo "UPDATE `acuerdo_pago` SET `tabono`='".$data['amortiza']."' WHERE `dni`='".$data['dni']."' ;";
   /* 
  // echo "INSERT INTO `acuerdos` (`idpersonal`, `dnic`, `dnip`, `acuerdos`, `fecha_verificacion`, `fecha_visita`, `frecuencia_msj`, `pagoen`, `fuente`) VALUES ('13', '".$data['dni']."', '42010854', 'VIAJE A PICOTA', '2015-03-18', '2015-04-01', 'MENSUAL', 'TRABAJO', 'RONEL');";
   echo "UPDATE `acuerdo_pago` SET `fecha_visita`='2015-03-18', `fecha_verif`='2015-04-01', `acuerdo`='VIAJE A PICOTA', `fuente`='RONEL', `frecuencia_msg`='MENSUAL', `pagoen`='TRABAJO' WHERE `dni`='".$data['dni']."';";
  
    echo "INSERT INTO `proceso_cobro` (`idpersonal`, `fecha_mov`, `letra`, `credito`, `dni`, `producto`,"
   . " `a_partir_de`, `num_cuotas`, `cond_pago`, `fecha_venta`)"
   . " VALUES ('".$data['vend']."','".$data['fecha']."',"
              . " '".$data['cuota']."', '".$credito."',"
              . " '".$data['dni']."', '".$data['producto']."',"
              . " '".$data['a_partir_de']."', '".$data['meses']."',"
              . " '".$data['cond.pago']."', '".$data['fecha']."');";
       //  nuevos clientes
        echo "INSERT INTO `cliente` (`idconvenio`, `idperfil_cliente`, `primer_nombre`,"
       . " `segundo_nombre`, `apellido_p`, `apellido_m`, "
           . "`dni`, `fecha_inscripcion`, `telfcasa`, `telf1`,"
           . " `dir_actual`, `distrito`)  VALUES ('1','".$data['tipo_servidor']."', '".$data['primer_nombre']."', '".$data['segund_nombre']."',"
           . " '".$data['apellido_p']."','".$data['apellido_m']."','".$data['dni']."',"
           . "'".$data['fecha']."','".$data['tel1']."','".$data['telf1']."','".utf8_encode($data['domicilio'])."','".utf8_encode($data['distrito_dom'])."');";
   
       
      
   // pagos por planilla
   
         echo "INSERT INTO `proceso_cobro` (`idventa`,`idpersonal`, `fecha_mov`, `abono`, `nro_recibo`, `dni`) "
   . "VALUES (".$data['idproceso_cobro'].",'6',  '2016-02-19', ".$data['monto'].", 'Des.Planilla', '".$data['dni']."');";
 */
  // echo "update proceso_cobro set proceso_cobro.abono =COALESCE(proceso_cobro.abono,0)  + '" . $data['monto'] . "',proceso_cobro.saldo =COALESCE(proceso_cobro.saldo,proceso_cobro.credito)  - '" . $data['monto'] . "'  WHERE proceso_cobro.idproceso_cobro='" . $data['idproceso_cobro'] . "' and proceso_cobro.dni='".$data['dni']."';";
// UPDATE proceso_cobro SET proceso_cobro.idventa='1dd' WHERE proceso_cobro.dni='05386405' and proceso_cobro.producto is NULL

   //echo "UPDATE proceso_cobro SET proceso_cobro.idventa='".$data['idproceso_cobro']."' WHERE proceso_cobro.dni='".$data['dni']."' and  proceso_cobro.producto is NULL;";
       echo "UPDATE `acuerdo_pago` SET `fecha_up`='".$data['abo']."' WHERE `dni`='".$data['dni']."' ;";   
 /*     echo "UPDATE `acuerdo_pago` SET `fecha_up`='2016-02-19', `amortiza`='".$data['monto']."', `tabono`=COALESCE(tabono,0) + '".$data['monto']."' WHERE `dni`='".$data['dni']."' ;";
 //   echo "UPDATE `acuerdo_pago` SET `fecha_up`='2015-11-19', `amortiza`='".$data['monto']."', `tabono`= '".$data['abonoa']."' WHERE `dni`='".$data['dni']."' ;";
// echo "UPDATE `acuerdo_pago` SET `idpersonal`='6' WHERE `dni`='".$data['dni']."';";
  /*   
   echo " INSERT INTO `tbl_fotos` (`idproceso_cobro`, `nombre`, `tipo`, `status`) VALUES ('".$data['idproceso_cobro']."', '".$data['cliente'].".JPG', 'JPG', '1'); ";
   
     echo "INSERT INTO `lugar_trabajo` (`idcliente`, `codigo_ruc`, `nombre`, `direccion`, `distrito`) 
           VALUES ('$idcli', '".$data['n_i_e']."', '".$data['colegio_ct']."', '".utf8_encode($data['direccion_colegio'])."', '".$data['distrito_col_ct']."');";
  
   // ------ actualizar los acuerdos
       //echo "UPDATE `acuerdo_pago` SET `fecha_up`='".$data['fecha_mov']."', `amortiza`='".$data['abono']."' WHERE `dni`='".$data['dni']."';";
  echo "UPDATE `acuerdo_pago` SET `fecha_visita`='".$data['fecha_visita']."', "
   . "`fecha_verif`='".$data['fecha_verificacion']."', `acuerdo`='".$data['acuerdos']."', "
   . "`fuente`='".$data['fuente']."', `frecuencia_msg`='".$data['frecuencia_msj']."', `hora`='".$data['hora']."',"
   . " `pagoen`='".$data['pagoen']."' "
          . "WHERE `dni`='".$data['dnic']."' ;";
   /*
       $credito=$data['cuota'] * $data['meses']; 
       echo "INSERT INTO `proceso_cobro` (`idpersonal`,`fecha_mov`, `letra`, "
       . "`credito`, `dni`, `producto`, "
           . "`a_partir_de`, `num_cuotas`, `cond_pago`, `fecha_venta`,`frecuencia_msg`)"
           . " VALUES ('1','".$data['fecha']."', '".$data['cuota']."', '".$data['total']."',"
               . " '".$data['dni']."','".$data['producto']."','".$data['a_partir_de']."',"
               . "'".$data['meses']."','".$data['cond.pago']."','".$data['fecha']."','MENSUAL');";
   */
     //echo "INSERT INTO `proceso_cobro` (`idcondicion_pago`, `fecha_mov`, `abono`, `dni`) VALUES ('1','2014-09-19', '".$data['monto']."','".$data['dnicli']."');";
     //echo " UPDATE `proceso_cobro` SET `abono`='".$data['monto']."', `nro_recibo`='".$data['num_recibo']."' WHERE (`fecha_mov`='2014-08-21' AND `nro_recibo`='desc-plani' and `dni`='".$data['dnicli']."') ; ";
   echo '<br>';
// echo " UPDATE `proceso_cobro` SET `idcondicion_pago`='".$data['cond_pgo']."', `abono`='".$data['monto']."', `fecha_abono`='".$data['fechapago']."', `nro_recibo`='".$data['num_recibo']."' WHERE (`nro_cuota`='".$data['numcuota']."') AND (`dnicliente`='".$data['dnicli']."'); ";
       // echo "INSERT INTO `proceso_cobro` (`idpersonal`,`fecha_mov`, `abono`, `nro_recibo`, `dni`) VALUES ('".$data['idpersonal']."','".$data['fecha_mov']."','".$data['abono']."','".$data['nro_recibo']."','".$data['dni']."');";
         //echo '<br>';
       
       //planilla
        
        
        endforeach;
   echo $suma;
        ?>		
       