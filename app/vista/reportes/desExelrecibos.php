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
$sql = "
     SELECT
proceso_cobro.dni,
proceso_cobro.fecha_mov,
proceso_cobro.documento,
proceso_cobro.nro_recibo,
proceso_cobro.abono,
CONCAT_WS(' ',cliente.nombres,cliente.apellidos) AS cliente,
proceso_cobro.idpersonal,
personal.primer_nombre
FROM
proceso_cobro
INNER JOIN cliente ON cliente.dni = proceso_cobro.dni
INNER JOIN personal ON personal.idpersonal = proceso_cobro.idpersonal
WHERE (proceso_cobro.fecha_mov BETWEEN '" . $_REQUEST['fechai'] . "' and '" . $_REQUEST['fechaf'] . "') and proceso_cobro.producto is NULL
ORDER BY proceso_cobro.fecha_mov,proceso_cobro.nro_recibo ASC";
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
        ->setCellValue('A1', 'DNI')
        ->setCellValue('B1', 'CLIENTE')
        ->setCellValue('C1', 'FECHA')
        ->setCellValue('D1', 'DOCUMENTO')
        ->setCellValue('E1', 'N RECIBO')
        ->setCellValue('F1', 'MONTO') 
        ->setCellValue('G1', 'PERSONAL') ;
// Add some data

$i = 2; //Numero de fila donde se va a comenzar a rellenar
while ($fila = $resultado->fetch_array()) {
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $i, utf8_encode($fila['dni']))
            ->setCellValue('B' . $i, utf8_encode($fila['cliente']))
            ->setCellValue('C' . $i, utf8_encode($fila['fecha_mov']))
            ->setCellValue('D' . $i, utf8_encode($fila['documento']))
            ->setCellValue('E' . $i, utf8_encode($fila['nro_recibo']))
            ->setCellValue('F' . $i, utf8_encode($fila['abono']))
            ->setCellValue('G' . $i, utf8_encode($fila['primer_nombre']));
    $i++;
}


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('recibos');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="recibos.xlsx"');
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
