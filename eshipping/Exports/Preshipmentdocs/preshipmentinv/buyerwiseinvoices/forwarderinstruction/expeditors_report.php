<?php
require('../../../../../Fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(10,10);
$pdf->Cell(195,35,'',1);
$defaultImage = "../../../../../images/expeditors.png";
$pdf->Image($defaultImage,13,12,40,13);
$pdf->SetXY(145,15);
$pdf->Cell(40,4,'EXPEDITORS LANKA (PVT) LTD',0);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(153,19);
$pdf->Cell(25,4,'LEVEL 15, EAST TOWER,',0);
$pdf->SetXY(146,23);
$pdf->Cell(25,4,'WORLD TRADE CENTER, COLOMBO 01',0);
$pdf->SetXY(147,27);
$pdf->Cell(25,4,'TEL: 94-11-7400500 FAX:94-11-2328444',0);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(75,35);
$pdf->Cell(25,4,"SHIPPER'S LETTER OF INSTRUCTIONS",0);
$pdf->SetFont('Arial','B',9);
$pdf->SetXY(87,40);
$pdf->Cell(25,4,"FOR AIR FREIGHT",0);
$pdf->SetFont('Arial','',7);
$pdf->SetXY(155,40);
$pdf->Cell(25,4,"Invoice No:",0);

$pdf->SetXY(10,45);
$pdf->Cell(90,28,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(11,46);
$pdf->Cell(25,4,"CONSIGNEE NAME AND ADDRESS",0);

$pdf->SetXY(100,45);
$pdf->Cell(22,8,'',1);
$pdf->SetXY(101,46);
$pdf->MultiCell(23,3,'DESTINATION AIR PORT',0);
$pdf->SetXY(122,45);
$pdf->Cell(28,8,'',1);
$pdf->SetXY(150,45);
$pdf->Cell(18,8,'',1);
$pdf->SetXY(151,46);
$pdf->MultiCell(17,3,'PLACE OF DELIVERY',0);
$pdf->SetXY(168,45);
$pdf->Cell(37,8,'',1);
$pdf->SetXY(100,53);
$pdf->Cell(22,8,'',1);
$pdf->SetXY(101,54);
$pdf->MultiCell(20,3,'Cargo Ready Date',0);
$pdf->SetXY(122,53);
$pdf->Cell(83,8,'',1);
$pdf->SetXY(100,61);
$pdf->Cell(22,8,'',1);
$pdf->SetXY(101,62);
$pdf->MultiCell(20,3,'Documents Ready Date',0);
$pdf->SetXY(122,61);
$pdf->Cell(83,8,'',1);
$pdf->SetXY(100,69);
$pdf->Cell(22,8,'',1);
$pdf->SetXY(101,70);
$pdf->MultiCell(21,3,'Merchandiser Name',0);
$pdf->SetXY(122,69);
$pdf->Cell(83,8,'',1);
$pdf->SetXY(100,77);
$pdf->Cell(22,8,'',1);
$pdf->SetXY(101,78);
$pdf->MultiCell(21,3,'Brand Name',0);
$pdf->SetXY(122,77);
$pdf->Cell(83,8,'',1);
$pdf->SetXY(100,85);
$pdf->Cell(105,10,'',1);
$pdf->SetXY(135,88);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(50,3,'FREIGHT COLLECT',0);

$pdf->SetXY(10,73);
$pdf->Cell(90,22,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(11,74);
$pdf->Cell(25,4,"NOTIFY",0);

$pdf->SetXY(10,95);
$pdf->Cell(150,6,'',1);
$pdf->SetXY(11,96);
$pdf->Cell(25,4,"SPECIAL INSTRUCTION (E.G.LETTER OF CREDIT/CONSULAR REQUIREMENTS)",0);
$pdf->SetXY(160,95);
$pdf->Cell(45,6,'',1);

$pdf->SetXY(10,101);
$pdf->Cell(19,9,'',1);
$pdf->SetXY(11,102);
$pdf->MultiCell(18,4,"NO OF PACKAGES",0);
$pdf->SetXY(29,101);
$pdf->Cell(19,9,'',1);
$pdf->SetXY(30,102);
$pdf->MultiCell(19,4,"METHOD OF PACKING",0);
$pdf->SetXY(48,101);
$pdf->Cell(70,9,'',1);
$pdf->SetXY(58,102);
$pdf->Cell(19,4,"NATURE AND QUANTITY OF GOODS",0);
$pdf->SetXY(118,101);
$pdf->Cell(30,9,'',1);
$pdf->SetXY(119,102);
$pdf->MultiCell(20,4,"MARKS AND NUMBER",0);
$pdf->SetXY(148,101);
$pdf->Cell(30,9,'',1);
$pdf->SetXY(149,102);
$pdf->Cell(27,4,"MEASUREMENTS",0);
$pdf->SetFont('Arial','B',7);
$pdf->SetXY(149,106);
$pdf->Cell(27,4,"(Specify cms or Inc)",0);
$pdf->SetXY(178,101);
$pdf->Cell(27,9,'',1);
$pdf->SetXY(179,102);
$pdf->Cell(27,4,"WEIGHTS (KGS)",0);


$pdf->SetXY(10,110);
$pdf->Cell(19,55,'',1);

$pdf->SetXY(29,110);
$pdf->Cell(19,55,'',1);

$pdf->SetXY(48,110);
$pdf->Cell(70,55,'',1);

$pdf->SetXY(118,110);
$pdf->Cell(30,55,'',1);

$pdf->SetXY(148,110);
$pdf->Cell(30,55,'',1);


$pdf->SetXY(178,110);
$pdf->Cell(27,55,'',1);

$pdf->SetXY(10,165);
$pdf->Cell(195,80,'',1);
$pdf->SetXY(11,166);
$pdf->Cell(45,4,"DECLARED VALUE FOR CUSTOMS",0);
$pdf->Cell(50,3,'',1);
$pdf->SetXY(108,166);
$pdf->Cell(45,4,"DECLARED VALUE FOR CARRIAGE",0);
$pdf->Cell(50,3,'',1);
$pdf->SetFont('Arial','B',6);
$pdf->SetXY(152,169);
$pdf->Cell(45,4,"IF REQUIRED",0);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(11,172);
$pdf->Cell(22,4,"INSURE FOR",0);
$pdf->Cell(140,3,'',1);
$pdf->SetXY(11,176);
$pdf->Cell(32,4,"AMOUNT OF C.O.D",0);
$pdf->Cell(130,3,'',1);
$pdf->SetFont('Arial','B',6);
$pdf->SetXY(42,179);
$pdf->Cell(32,4,"IN WORDS",0);

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(10,184);
$pdf->Cell(28,8,'',1);
$pdf->SetXY(11,185);
$pdf->Cell(20,4,'CHARGES',0);
$pdf->SetXY(38,184);
$pdf->Cell(51.5,4,'',1);
$pdf->SetXY(38,184);
$pdf->Cell(20,4,'PAYABLE BY(TICK AS APPOPRIATE)',0);
$pdf->SetXY(38,188);
$pdf->Cell(15,4,'',1);
$pdf->SetXY(38,188);
$pdf->Cell(20,4,'SHIPPER',0);
$pdf->SetXY(53,188);
$pdf->Cell(36.5,4,'',1);
$pdf->SetXY(53,188);
$pdf->Cell(15,4,'CONSIGNEE',0);

$pdf->SetXY(10,192);
$pdf->Cell(28,4,'',1);
$pdf->SetXY(11,192);
$pdf->Cell(20,4,'AIR FREIGHT',0);
$pdf->SetXY(38,192);
$pdf->Cell(15,4,'',1);
$pdf->SetXY(53,192);
$pdf->Cell(36.5,4,'',1);

$pdf->SetXY(10,196);
$pdf->Cell(28,4,'',1);
$pdf->SetXY(11,196);
$pdf->Cell(20,4,'F.O.B.(Processing)',0);
$pdf->SetXY(38,196);
$pdf->Cell(15,4,'',1);
$pdf->SetXY(53,196);
$pdf->Cell(36.5,4,'',1);

$pdf->SetXY(10,200);
$pdf->Cell(28,4,'',1);
$pdf->SetXY(11,200);
$pdf->Cell(20,4,'INSURANCE',0);
$pdf->SetXY(38,200);
$pdf->Cell(15,4,'',1);
$pdf->SetXY(53,200);
$pdf->Cell(36.5,4,'',1);

$pdf->SetXY(10,204);
$pdf->Cell(28,4,'',1);
$pdf->SetXY(11,204);
$pdf->Cell(20,4,'AT DESTINATION',0);
$pdf->SetXY(38,204);
$pdf->Cell(15,4,'',1);
$pdf->SetXY(53,204);
$pdf->Cell(36.5,4,'',1);

$pdf->SetXY(100,184);
$pdf->Cell(65,4,'',1);
$pdf->SetXY(100,184);
$pdf->Cell(20,4,'DOCUMENT ATTACHED(Please Indicate)',0);
$pdf->SetXY(165,184);
$pdf->Cell(40,4,'',1);

$pdf->SetXY(100,188);
$pdf->Cell(65,4,'',1);
$pdf->SetXY(100,188);
$pdf->Cell(20,4,'CUSTOMS PRE ENTRY L88',0);
$pdf->SetXY(165,188);
$pdf->Cell(40,4,'',1);

$pdf->SetXY(100,192);
$pdf->Cell(65,4,'',1);
$pdf->SetXY(100,192);
$pdf->Cell(20,4,'COMMERCIAL INVOICES',0);
$pdf->SetXY(165,192);
$pdf->Cell(40,4,'',1);

$pdf->SetXY(100,196);
$pdf->Cell(65,4,'',1);
$pdf->SetXY(100,196);
$pdf->Cell(20,4,'CERTIFICATE OF ORIGIN/CONSULAR INVOICE',0);
$pdf->SetXY(165,196);
$pdf->Cell(40,4,'',1);

$pdf->SetXY(100,200);
$pdf->Cell(65,4,'',1);
$pdf->SetXY(100,200);
$pdf->Cell(20,4,'DOCUMENTS ATTACHED(Please Indicate)',0);
$pdf->SetXY(165,200);
$pdf->Cell(40,4,'',1);


$pdf->SetXY(100,204);
$pdf->Cell(65,4,'',1);
$pdf->SetXY(100,204);
$pdf->Cell(20,4,'DOCUMENTS ATTACHED(Please Indicate)',0);
$pdf->SetXY(165,204);
$pdf->Cell(40,4,'',1);

$pdf->SetXY(11,212);
$pdf->Cell(65,4,'For Googs destined for the EUROPEAN COMMUNITY :',0);
$pdf->SetXY(11,216);
$pdf->Cell(65,4,'Googs in free Circulation : YES/NO',0);

$pdf->SetXY(150,224);
$pdf->Cell(65,4,'SIGNATURE',0);


$pdf->SetXY(10,245);
$pdf->Cell(195,30,'',1);
$pdf->SetXY(11,246);
$pdf->Cell(65,4,'SHIPPER NAME AND ADDRESS :',0);

$pdf->SetFont('Arial','',7);
$pdf->SetXY(105,246);
$pdf->MultiCell(100,4,'The Shipper hereby declared that the above particulars are corredt and that he is aware of and accepts the Conditions of Trading referred to on the reverse side of this form',0);

$pdf->SetXY(155,258);
$pdf->Cell(65,4,'Signed on behalf of Shipper',0);

$pdf->SetXY(105,260);
$pdf->Cell(65,4,'By      :',0);
$pdf->SetXY(105,264);
$pdf->Cell(65,4,'Dated :',0);

$pdf->Output();
?>