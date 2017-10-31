<?php
require('../../../../../Fpdf/fpdf.php');
$pdf = new FPDF();

$pdf->AddPage();
$pdf->SetFont('Arial','B',9);

$pdf->Cell(45,6,'');
$pdf->Ln(-1);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(45,6,'');
$pdf->cell(100,8,'');
$pdf->SetFont('Arial','',7);
$dateTime = date("m/d/Y h:i:s a", time());

$pdf->Cell(40,8,"Print Date/Time : ".date("m/d/Y h:i:s a",time())."");
$pdf->Ln(4);
$pdf->SetFont('Arial','',10);
$pdf->SetX(50);
$pdf->Cell(40,10,"SHIPPERS INSTRUCTIONS DISPATCH AND ISSUING B/L /HAWB");

$pdf->Ln(8);
$pdf->cell(96,6,'',1);
$pdf->Ln(1);
$pdf->SetFont('Arial','',8);
$pdf->Cell(30,6,"REQUESTED ROUTING:");
$pdf->SetFont('Arial','',8);

$pdf->Ln(5.1);
$pdf->cell(96,6,'',1);
$pdf->Ln(1);
$pdf->SetFont('Arial','',8);
$pdf->Cell(30,6,"REQUESTED BOOKING:");
$pdf->SetFont('Arial','',8);

$pdf->Ln(5.1);
$pdf->cell(48,8,'',1);
$pdf->Ln(1);
$pdf->SetFont('Arial','',8);
$pdf->Cell(30,6,"PORT OF LOADING");
$pdf->SetFont('Arial','',8);


$pdf->Ln(-1);
$pdf->SetX(58);
$pdf->cell(48,8,'',1);
$pdf->SetX(58);
$pdf->Ln(1);
$pdf->SetX(58);
$pdf->Cell(30,6,"PORT OF DISCHARGE");
$pdf->SetFont('Arial','',8);


$pdf->Ln(7);
$pdf->cell(96,8,'',1);
$pdf->Ln(1);
$pdf->SetFont('Arial','',8);
$pdf->Cell(100,6,"REQUESTED BOOKING:");
$pdf->SetFont('Arial','',8);

$pdf->Output();
//echo "abc";
?>