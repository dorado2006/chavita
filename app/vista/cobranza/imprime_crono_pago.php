<?php

require('../lib/fpdf/fpdf.php');

class PDF extends FPDF {

    var $col = 0;
    var $salto = 0;

    function SetCol($col) {
        // Move position to a column
        $this->col = $col;
        $x = 10 + $col * 70;
        $this->SetLeftMargin($x);
        $this->SetX($x);
    }

    function AcceptPageBreak() {
        if ($this->col < 3) {
            // Go to next column
            $this->SetCol($this->col + 1);
            if ($this->salto == 1) {
                $this->SetY(10);
            } else {
                $this->SetY(60);
            }

            return false;
        } else {
            $this->salto = 1;
            // Regrese a la primera columna y emita un salto de página
            $this->SetCol(0);
            return true;
        }
    }

    function Footer() {
        // Go to 1.5 cm from bottom
        $this->SetY(-15);
        // Select Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Print current and total page numbers
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

}

$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();


$pdf->AddPage();

//Cabecera de página
//Logo
//Arial bold 15
$pdf->SetFont('Arial', 'B', 12);
//Movernos a la derecha
$pdf->Cell(80);

//Título
// $str = utf8_decode('NEGOIACIÓN CULTURAL IMPORT E.I.R.L');
$pdf->Cell(120, 6, utf8_decode('NEGOIACIÓN CULTURAL IMPORT E.I.R.L'), 0, 0, 'C');
//Salto de línea
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(280, 5, utf8_decode('Telefono:(042)527146  Rpm:#969918903  
Dirección: Ramires Hurtado #469-Tarapoto(Referencia: Al Costado UGEL-Tarapoto) '), 1, 0, 'C');
$pdf->Ln(6);
//cuerpo
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20);
$pdf->Cell(80, 5, utf8_decode('DETALLE DE CREDITO'), 1, 0, 'C');
$pdf->Cell(160, 5, utf8_decode($rows[0]['nombres'] . " " . $rows[0]['apellidos']), 1, 0, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 5, utf8_decode('N'), 1, 0, 'C');
$pdf->Cell(40, 5, utf8_decode('FECHA COMPRA'), 1, 0, 'C');
$pdf->Cell(40, 5, utf8_decode('CREDITO'), 1, 0, 'C');
$pdf->Cell(40, 5, utf8_decode('LETRA'), 1, 0, 'C');
$pdf->Cell(40, 5, utf8_decode('MESES'), 1, 0, 'C');
$pdf->Cell(40, 5, utf8_decode('PRODUCTO'), 1, 0, 'C');
$pdf->Cell(40, 5, utf8_decode('INICIO PAGO'), 1, 0, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);
$sumaA = 0;
//echo '<pre>';print_r($rows1); exit;
foreach ($rows2 as $key => $data):



    if (!empty($data['producto'])) {
        $ind = $ind + 1;
        $sumaT = $sumaT + $data['credito'];


        $pdf->Cell(20, 5, $ind, 1, 0, 'C');
        $pdf->Cell(40, 5, $data['fecha_mov'], 0, 0, 'C');
        $pdf->Cell(40, 5, $data['credito'], 0, 0, 'C');
        $pdf->Cell(40, 5, $data['letra'], 0, 0, 'C');
        $pdf->Cell(40, 5, $data['num_cuotas'] . "-" . substr($data['frecuencia_msg'], 0, 1), 0, 0, 'C');
        $pdf->Cell(40, 5, $data['producto'], 0, 0, 'C');
        $pdf->Cell(40, 5, $data['a_partir_de'], 0, 0, 'C');
        $pdf->Ln(5);
    } else {
        $sumaA = $sumaA + $data['abono'];
    }
    $saldo = $sumaT - $sumaA;
endforeach;

$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(20, 5, utf8_decode(''), 1, 0, 'C');
$pdf->Cell(40, 5, utf8_decode('TOTAL CREDITO'), 1, 0, 'C');
$pdf->Cell(40, 5, 'S/.' . $sumaT, 1, 0, 'C');
$pdf->Cell(40, 5, 'AMORTIZA', 1, 0, 'C');
$pdf->Cell(40, 5, $sumaA, 1, 0, 'C');
$pdf->Cell(40, 5, utf8_decode('SALDO:'), 1, 0, 'C');
$pdf->Cell(40, 5, round($saldo, 2), 1, 0, 'C');
$pdf->Ln(8);

$pdf->SetFont('Arial', 'B', 8);
 $pdf->Cell(60, 5, str_pad("N-", 10) . str_pad("FECHA", 20) . str_pad("AMTZ", 15).str_pad("CUOTA", 15), 1, 1);

foreach ($rows1['nro_cuota'] as $key => $data):
    if (empty($data['cond_pago'])) {
        $pdf->Cell(60, 5, str_pad($key+1, 10) . str_pad($rows1['fecha_vencimiento'][$key], 20) . str_pad(substr($rows1['estado'][$key], 15)) .str_pad($rows1['abonoletr'][$key], 15). str_pad($rows1['montlet'][$key], 12), 1, 1);
    }
endforeach;
$pdf->Output();
?>