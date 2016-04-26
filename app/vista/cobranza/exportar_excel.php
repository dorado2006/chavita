<?php
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Reporte_cobranza.xls");
header("Pragma: no-cache");
header("Expires: 0");
$dados_recebido = iconv('utf-8','iso-8859-1',$_POST['datos_a_enviar']);

  echo $_POST['datos_a_enviar'];
?>