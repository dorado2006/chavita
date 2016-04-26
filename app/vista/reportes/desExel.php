<?php

/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */
/** Error reporting */
////--------------------------------------------
//$conexion = mysql_connect ("localhost", "root", "");
// mysql_select_db ("ncprueba", $conexion);   

$conexion = new mysqli('localhost', 'root', '', 'ncprueba', 3308);

//print_r($_REQUEST);exit;

if($_REQUEST['fechai']=='vacia'){
    
$sql = "   
SELECT
acuerdo_pago.acuerdo as acuerdos,
acuerdo_pago.fecha_verif as fecha_verificacion,
cliente.dni,
CONCAT_WS(' ',cliente.nombres,cliente.apellidos) AS nomcliente,
CONCAT_WS('',personal.primer_nombre,personal.segundo_nombre) AS persona,
acuerdo_pago.frecuencia_msg as frecuencia_msj,
acuerdo_pago.pagoen,
acuerdo_pago.fuente,
CONCAT_WS(' / ',cliente.telfcasa,cliente.telf1,cliente.telf2) as tel_cli,
cliente.dir_actual,
cliente.distrito as distr_cli,
CONCAT_WS(' _',lugar_trabajo.url,lugar_trabajo.nombre) as lug_trab,
lugar_trabajo.direccion,
lugar_trabajo.distrito,
proceso_cobro.producto,
proceso_cobro.letra,
(SELECT b.primer_nombre FROM personal as b WHERE b.idpersonal=proceso_cobro.idpersonal) as vendedor
FROM
acuerdo_pago
INNER JOIN cliente ON cliente.dni = acuerdo_pago.dni
INNER JOIN personal ON personal.idpersonal = acuerdo_pago.idpersonal 
INNER JOIN lugar_trabajo ON cliente.idcliente = lugar_trabajo.idcliente
INNER JOIN proceso_cobro ON acuerdo_pago.dni = proceso_cobro.dni
WHERE (acuerdo_pago.fecha_verif = '".$_REQUEST['fechaf']."' and acuerdo_pago.idpersonal='" . $_REQUEST['sesi'] . "') and   (proceso_cobro.producto is not null) and (proceso_cobro.cond_pago='DIRECTO' OR proceso_cobro.cond_pago='PLANILLA')
ORDER BY acuerdo_pago.fecha_verif DESC";   
}
else {
$sql = "
    SELECT
acuerdo_pago.dni,
acuerdo_pago.fecha_verif,
acuerdo_pago.acuerdo,
acuerdo_pago.frecuencia_msg,
acuerdo_pago.pagoen,
acuerdo_pago.tcredito,
acuerdo_pago.tabono,
acuerdo_pago.tproductos,
acuerdo_pago.idpersonal,
acuerdo_pago.estado,
proceso_cobro.producto,
proceso_cobro.cond_pago,
proceso_cobro.letra,
CONCAT_WS(' ',cliente.apellidos,cliente.nombres) AS cliente,
CONCAT_WS('/',cliente.telfcasa,cliente.telf1,cliente.telf2) AS telefono,
CONCAT_WS('-',cliente.dir_actual,cliente.distrito) AS domicilio,
personal.primer_nombre
FROM
acuerdo_pago
INNER JOIN proceso_cobro ON acuerdo_pago.dni = proceso_cobro.dni
INNER JOIN cliente ON acuerdo_pago.dni = cliente.dni
INNER JOIN personal ON acuerdo_pago.idpersonal = personal.idpersonal
WHERE acuerdo_pago.fecha_verif between '" . $_REQUEST['fechai'] . "' and '" . $_REQUEST['fechaf'] . "' and proceso_cobro.producto !='' AND
(proceso_cobro.cond_pago='DIRECTO' OR proceso_cobro.cond_pago='PLANILLA') and acuerdo_pago.tabono<acuerdo_pago.tcredito AND
acuerdo_pago.estado=1
ORDER BY acuerdo_pago.idpersonal ";

}
$resultado = $conexion->query($sql);


//$resultado = mysql_query ($sql, $conexion) or die (mysql_error ());

	
//date_default_timezone_set('America/Mexico_City');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../../../lib/Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");

//cabecera
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1' , 'DNI')
            ->setCellValue('B1' ,'CLIENTE')
            ->setCellValue('C1' , 'DIRECCION')
            ->setCellValue('D1' , 'PRODUCTO')
            ->setCellValue('E1' , 'LETRA')
            ->setCellValue('F1' , 'TELEFONOS')
            ->setCellValue('G1' , 'FRECUENCIA')        
            ->setCellValue('H1' , 'ACUERDO')
            ->setCellValue('I1' , 'PAGO EN.')
            ->setCellValue('J1' , 'COBRADOR');
// Add some data

$i = 2; //Numero de fila donde se va a comenzar a rellenar
while ($fila = $resultado->fetch_array()) {
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $i, utf8_encode($fila['dni']))
            ->setCellValue('B' . $i, utf8_encode($fila['cliente']))
            ->setCellValue('C' . $i, utf8_encode($fila['domicilio']))
            ->setCellValue('D' . $i, utf8_encode($fila['producto']))
            ->setCellValue('E' . $i, utf8_encode($fila['letra']))
            ->setCellValue('F' . $i, utf8_encode($fila['telefono']))
            ->setCellValue('G' . $i, utf8_encode($fila['frecuencia_msg']))
            ->setCellValue('H' . $i, utf8_encode($fila['acuerdo']))
            ->setCellValue('I' . $i, utf8_encode($fila['pagoen']))
            ->setCellValue('J' . $i, utf8_encode($fila['primer_nombre']));
    $i++;
}


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="01simple.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
