<?php
require('../../../../../Fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();

$docNo = $_GET['docNo'];

$sql_inv = "SELECT strInvoiceNo FROM invoiceheader WHERE intForDocNo='$docNo'";
$result_inv = $db->RunQuery($sql_inv);

while($row_inv = mysql_fetch_array($result_inv))
{
	
	$invoiceNo = $row_inv['strInvoiceNo'];
	
	$sql_header = "SELECT
						invoiceheader.strInvoiceNo,
						invoiceheader.dtmInvoiceDate,
						buyers.strName AS consigneeName,
						buyers.strAddress1 AS consigneeAddress1,
						buyers.strAddress2 AS consigneeAddress2,
						buyers.strCountry AS consigneeCountry,
						buyers.strPhone AS consigneePhone,
						buyers.strFax AS consigneeFax,
						invoicedetail.strStyleID,
						invoicedetail.strBuyerPONo,
						invoicedetail.strDescOfGoods,
						Sum(invoicedetail.dblQuantity) AS dblQuantity,
						ROUND(sum(invoicedetail.dblAmount),2) AS dblAmount,
						ROUND(sum(invoicedetail.dblGrossMass),2) AS dblGrossMass,
						ROUND(sum(invoicedetail.dblNetMass),2) AS dblNetMass,
						Sum(invoicedetail.intNoOfCTns) AS intNoOfCTns,
						invoicedetail.strFabrication,
						invoiceheader.strCollect,
						city.strCity,
						country.strCountry
						FROM
						invoiceheader
						INNER JOIN buyers ON buyers.strBuyerID = invoiceheader.strBuyerID
						INNER JOIN invoicedetail ON invoicedetail.strInvoiceNo = invoiceheader.strInvoiceNo
						INNER JOIN city ON city.strCityCode = invoiceheader.strFinalDest
						INNER JOIN country ON country.strCountryCode = city.strCountryCode
						WHERE invoiceheader.strInvoiceNo='$invoiceNo'
						";
	$result_header = $db->RunQuery($sql_header);
	$row_header = mysql_fetch_array($result_header);

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(60,12);
$pdf->Cell(40,4,'SHIPPERS INSTRUCTIONS DISPATCH AND ISSUING B/L /HAWB',0);
$pdf->SetXY(10,16);
$pdf->Cell(95,4,'',1);
$pdf->SetXY(10,16);
$pdf->Cell(20,4,'REQUESTED ROUTING:',0);
$pdf->SetXY(105,16);
$pdf->Cell(95,80,'',1);
$pdf->SetXY(105,16);
$pdf->Cell(20,4,'ATTN:',0);

$pdf->SetXY(108,22);
$pdf->Cell(80,4,'',1);
$pdf->SetXY(108,22);
$pdf->Cell(20,4,'MWAB:',0);
$pdf->SetXY(108,26);
$pdf->Cell(80,4,'',1);
$pdf->SetXY(108,26);
$pdf->Cell(20,4,'HWAB:',0);

$defaultImage = "../../../../../images/bax.JPG";
$pdf->Image($defaultImage,108,35,50,8);

$pdf->SetXY(108,48);
$pdf->Cell(20,4,'LEVEL 30, WEST TOWER,',0);
$pdf->SetXY(108,52);
$pdf->Cell(20,4,'WORLD TRADE CENTER, COLOMBO 01',0);
$pdf->SetXY(108,56);
$pdf->Cell(20,4,'SRI LANKA',0);
$pdf->SetXY(108,60);
$pdf->Cell(20,4,'TEL:94 11 4728300 FAX: 94 11 4728324',0);
$pdf->SetXY(108,64);
$pdf->Cell(20,4,'E-MAIL : colombo@baxglobal.com',0);

$pdf->SetFont('Arial','B',7);
$pdf->SetXY(108,72);
$pdf->MultiCell(90,4,'We hereby request and authorize Bax Global Private Limited or nominee upon receipt of the consignment described herein to prepare and sign the Airway bill and other necesary documents on our behalf and dispatch the consignment in accordance with your conditions of Concrate.We also hereby agree to reimburse Bax Global All charges pertaining to this shipment.',0);

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(10,20);
$pdf->Cell(95,4,'',1);
$pdf->SetXY(10,20);
$pdf->Cell(20,4,'REQUESTED ROUTING:',0);

$pdf->SetXY(10,24);
$pdf->Cell(47,6,'',1);
$pdf->SetXY(10,24);
$pdf->Cell(20,4,'PORT OF LOADING',0);

$pdf->SetXY(57,24);
$pdf->Cell(48,6,'',1);
$pdf->SetXY(57,24);
$pdf->Cell(20,4,'PORT OF DISCHARGE',0);

$pdf->SetXY(10,30);
$pdf->Cell(95,6,'',1);
$pdf->SetXY(10,30);
$pdf->Cell(20,4,'Invoice No',0);


$pdf->SetFont('Arial','BI',8);
$pdf->SetXY(10,36);
$pdf->Cell(95,20,'',1);
$pdf->SetXY(10,36);
$pdf->Cell(20,4,'CONSIGNEE',0);

$pdf->SetFont('Arial','BI',8);
$pdf->SetXY(10,56);
$pdf->Cell(95,20,'',1);
$pdf->SetXY(10,56);
$pdf->Cell(20,4,'SHIPPER',0);

$pdf->SetFont('Arial','BI',8);
$pdf->SetXY(10,76);
$pdf->Cell(95,20,'',1);
$pdf->SetXY(10,76);
$pdf->Cell(20,4,'ALSO NOTIFY',0);

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(10,96);
$pdf->Cell(40,8,'',1);
$pdf->SetXY(20,96);
$pdf->MultiCell(20,4,'MARKS AND NUMBERS',0,'C');

$pdf->SetXY(50,96);
$pdf->Cell(23,8,'',1);
$pdf->SetXY(50,96);
$pdf->MultiCell(23,4,'NO AND KIND OF PACKAGES',0);

$pdf->SetXY(73,96);
$pdf->Cell(73,8,'',1);
$pdf->SetXY(95,96);
$pdf->MultiCell(23,4,'DESCRIPTION OF GOODS',0,'C');

$pdf->SetXY(146,96);
$pdf->Cell(20,8,'',1);
$pdf->SetXY(146,96);
$pdf->MultiCell(20,4,'GROSS WEIGHT',0,'C');

$pdf->SetXY(166,96);
$pdf->Cell(34,8,'',1);
$pdf->SetXY(170,96);
$pdf->MultiCell(25,4,'MEASUREMENT',0,'C');

$pdf->SetXY(10,104);
$pdf->Cell(40,80,'',1);

$pdf->SetXY(50,104);
$pdf->Cell(23,80,'',1);

$pdf->SetXY(73,104);
$pdf->Cell(73,80,'',1);

$pdf->SetXY(146,104);
$pdf->Cell(20,80,'',1);

$pdf->SetXY(166,104);
$pdf->Cell(34,80,'',1);

$pdf->SetXY(10,184);
$pdf->Cell(190,8,'',1);
$pdf->SetXY(10,184);
$pdf->Cell(20,4,'DOCUMENTS',0);
$pdf->SetXY(10,188);
$pdf->Cell(20,4,'ACCOMPANYING SHIPMENT:',0);

$pdf->SetXY(10,192);
$pdf->Cell(55,10,'',1);
$pdf->SetXY(10,195);
$pdf->MultiCell(20,3,'FREIGHT CHARGES',0);

$pdf->SetXY(40,192);
$pdf->Cell(4,3,'',1);
$pdf->SetXY(46,192);
$pdf->Cell(20,3,'PREPAID',0);

$pdf->SetXY(40,199);
$pdf->Cell(4,3,'',1);
$pdf->SetXY(46,199);
$pdf->Cell(20,3,'COLLECT',0);

$pdf->SetXY(65,192);
$pdf->Cell(55,10,'',1);
$pdf->SetXY(65,193);
$pdf->MultiCell(20,3,'OTHER CHARGES AT ORIIN',0);

$pdf->SetXY(95,192);
$pdf->Cell(4,3,'',1);
$pdf->SetXY(101,192);
$pdf->Cell(20,3,'PREPAID',0);

$pdf->SetXY(95,199);
$pdf->Cell(4,3,'',1);
$pdf->SetXY(101,199);
$pdf->Cell(20,3,'COLLECT',0);

$pdf->SetXY(120,192);
$pdf->Cell(80,10,'',1);
$pdf->SetXY(120,193);
$pdf->Cell(20,3,'INSURANCE-AMOUNT REQUESTED',0);

$pdf->SetXY(10,202);
$pdf->Cell(110,4,'',1);
$pdf->SetXY(40,202);
$pdf->Cell(20,4,'DECLARED VALUES',0);

$pdf->SetXY(10,206);
$pdf->Cell(55,8,'',1);
$pdf->SetXY(10,206);
$pdf->Cell(20,4,'FOR CUSTOMS',0);

$pdf->SetXY(65,206);
$pdf->Cell(55,8,'',1);
$pdf->SetXY(65,206);
$pdf->Cell(20,4,'FOR CARRIAGE',0);

$pdf->SetXY(120,202);
$pdf->Cell(80,12,'',1);
$pdf->SetXY(120,202);
$pdf->Cell(20,4,'SHIPPERS C.O.D AMOUNT',0);

$pdf->SetXY(10,214);
$pdf->Cell(190,8,'',1);
$pdf->SetXY(10,214);
$pdf->Cell(20,4,'HANDLING INFORMATION',0);

$pdf->SetFont('Arial','BU',8);
$pdf->SetXY(10,222);
$pdf->Cell(20,4,'REMARKS:',0);

$pdf->SetFont('Arial','BI',7);
$pdf->SetXY(10,226);
$pdf->MultiCell(80,4,'I/We declare that above particulars are correct and complete and accept full responsibility for such declarations.',0);

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(150,230);
$pdf->Cell(20,4,'DATE:',0);
}
$pdf->Output();
?>