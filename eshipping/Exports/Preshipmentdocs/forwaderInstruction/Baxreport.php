<?php
require('../../../Fpdf/fpdf.php');
include("../../../Connector.php");
$pdf = new FPDF();
$docNo = $_GET['docNo'];

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
Sum(invoicedetail.dblQuantity) AS dblQuantity1,
ROUND(sum(invoicedetail.dblAmount),2) AS dblAmount,
ROUND(sum(invoicedetail.dblGrossMass),2) AS dblGrossMass1,
ROUND(sum(invoicedetail.dblNetMass),2) AS dblNetMass,
Sum(invoicedetail.intNoOfCTns) AS intNoOfCTns1,
Sum(invoicedetail.intCBM) AS intCBM1,
invoicedetail.strFabrication,
invoiceheader.strCollect,
city.strCity,
country.strCountry,
customers.strName AS shipperName,
customers.strMLocation AS shipperLocation,
customers.strAddress1 AS shipperAdd1,
customers.strAddress2 AS shipperAdd2,
customers.strCountry AS shipperCountry,
invoiceheader.strMarksAndNos,
cartoon.strCartoon
FROM
invoiceheader
INNER JOIN buyers ON buyers.strBuyerID = invoiceheader.strBuyerID
INNER JOIN invoicedetail ON invoicedetail.strInvoiceNo = invoiceheader.strInvoiceNo
INNER JOIN city ON city.strCityCode = invoiceheader.strFinalDest
INNER JOIN country ON country.strCountryCode = city.strCountryCode
INNER JOIN customers ON customers.strCustomerID = invoiceheader.strCompanyID
LEFT JOIN shipmentpldetail ON shipmentpldetail.strPLNo = invoicedetail.strPLNO
LEFT JOIN cartoon ON cartoon.intCartoonId = shipmentpldetail.strCTN
		WHERE strPreDocNo='$docNo'
		GROUP BY invoiceheader.strInvoiceNo
		
		";

		$result_header = $db->RunQuery($sql_header);

while($row_header = mysql_fetch_array($result_header))
{
	
		$InvoiceNo = $row_header["strInvoiceNo"];
		
		$sql_invoice = "SELECT
		commercialinvformat.strMMLine1,
		commercialinvformat.strMMLine2,
		commercialinvformat.strMMLine3,
		commercialinvformat.strMMLine4,
		commercialinvformat.strMMLine5,
		commercialinvformat.strMMLine6,
		commercialinvformat.strMMLine7,
		commercialinvformat.strSMLine1,
		commercialinvformat.strSMLine2,
		commercialinvformat.strSMLine3,
		commercialinvformat.strSMLine4,
		commercialinvformat.strSMLine5,
		commercialinvformat.strSMLine6,
		commercialinvformat.strSMLine7
		FROM
		invoiceheader
		INNER JOIN commercialinvformat ON commercialinvformat.intCommercialInvId = invoiceheader.strInvFormat
		WHERE invoiceheader.strInvoiceNo='$InvoiceNo'";

		$res_inv = $db->RunQuery($sql_invoice);
		$marks = mysql_fetch_array($res_inv);
		
		
		
				$sql_qty = "SELECT
		invoiceheader.strInvoiceNo,
		invoiceheader.strPreDocNo,
		invoicedetail.strStyleID,
		Sum(invoicedetail.dblQuantity) AS dblQuantity,
		invoicedetail.strDescOfGoods,
		ROUND(Sum(invoicedetail.dblAmount),2) AS dblAmount,
		invoicedetail.strFabrication,
		Sum(invoicedetail.intCBM) AS intCBM,
		ROUND(sum(invoicedetail.dblGrossMass),2) AS dblGrossMass,
		ROUND(SUM(invoicedetail.dblNetMass),2) AS dblNetMass,
		invoicedetail.strBuyerPONo,
		invoicedetail.intNoOfCTns
		FROM
		invoiceheader
		INNER JOIN invoicedetail ON invoicedetail.strInvoiceNo = invoiceheader.strInvoiceNo
		WHERE strPreDocNo='$docNo' AND invoiceheader.strInvoiceNo='$InvoiceNo'
		GROUP BY invoiceheader.strInvoiceNo
		";

		$res_qty = $db->RunQuery($sql_qty);
		$M_Qty = mysql_fetch_array($res_qty);
	
		$dtmDate = explode(" ",$row_header['dtmInvoiceDate']);


$pdf->AddPage();
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
$pdf->SetXY(120,16);
$pdf->Cell(20,4,'ISURU',0);

$pdf->SetXY(108,22);
$pdf->Cell(80,4,'',1);
$pdf->SetXY(108,22);
$pdf->Cell(20,4,'MWAB:',0);
$pdf->SetXY(108,26);
$pdf->Cell(80,4,'',1);
$pdf->SetXY(108,26);
$pdf->Cell(20,4,'HWAB:',0);

$defaultImage = "../../../images/bax.jpg";
$pdf->Image($defaultImage,108,31,60,20);

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
$pdf->Cell(20,4,'REQUESTED BOOKING:',0);

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
$pdf->SetXY(30,30);
$pdf->Cell(25,4,$InvoiceNo,0);                      // <------------------INVOICE NO--------------------------


$pdf->SetFont('Arial','BI',8);
$pdf->SetXY(10,36);
$pdf->Cell(95,20,'',1);
$pdf->SetXY(10,36);
$pdf->Cell(20,4,'CONSIGNEE',0);
$pdf->SetXY(10,40);
$pdf->Cell(25,4,$row_header['consigneeName'],0);
$pdf->SetXY(10,43);
$pdf->Cell(25,4,$row_header['consigneeAddress1'],0);
$pdf->SetXY(10,46);
$pdf->Cell(25,4,$row_header['consigneeAddress2'],0);
$pdf->SetXY(10,49);
$pdf->Cell(25,4,$row_header['consigneeCountry'],0);

$pdf->SetFont('Arial','BI',8);
$pdf->SetXY(10,56);
$pdf->Cell(95,20,'',1);
$pdf->SetXY(10,56);
$pdf->Cell(20,4,'SHIPPER',0);
$pdf->SetXY(10,60);
$pdf->Cell(25,4,$row_header['shipperName'],0);
$pdf->SetXY(10,63);
$pdf->Cell(25,4,$row_header['shipperAdd1'],0);
$pdf->SetXY(10,66);
$pdf->Cell(25,4,$row_header['shipperAdd2'],0);
$pdf->SetXY(10,69);
$pdf->Cell(25,4,$row_header['shipperCountry'],0);

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
$pdf->SetXY(20,110);
$pdf->MultiCell(25,4,$row_header['strMarksAndNos'],0);  //<---------------MARKS AND NUMBERS--------------

$pdf->SetXY(50,96);
$pdf->Cell(23,8,'',1);
$pdf->SetXY(50,96);
$pdf->MultiCell(23,4,'NO AND KIND OF PACKAGES',0);
$pdf->SetXY(50,110);
$pdf->MultiCell(25,4,$M_Qty['intNoOfCTns']."  "."Cartons",0);

$pdf->SetXY(73,96);
$pdf->Cell(73,8,'',1);
$pdf->SetXY(95,96);
$pdf->MultiCell(23,4,'DESCRIPTION OF GOODS',0,'C');
$pdf->SetXY(75,110);
$pdf->Cell(75,4,$M_Qty['dblQuantity']." "."Pcs of",0);
$pdf->SetXY(75,114);
$pdf->Cell(75,4,$row_header['strDescOfGoods'],0);
$pdf->SetXY(75,118);
$pdf->Cell(75,4,$row_header['strFabrication'],0);
$pdf->SetXY(75,124);
$pdf->Cell(75,4,"ORDER NO"."      ".$row_header['strBuyerPONo'],0);
$pdf->SetXY(75,128);
$pdf->Cell(75,4,"STYLE NO"."      ".$row_header['strStyleID'],0);
$pdf->SetXY(75,134);
$pdf->Cell(75,4,"Cargo Ready Date:"."      ".$dtmDate[0],0);
$pdf->SetXY(75,140);
$pdf->Cell(75,4,"FREIGHT:"."     ".$row_header['strCollect'],0);

$pdf->SetXY(146,96);
$pdf->Cell(20,8,'',1);
$pdf->SetXY(146,96);
$pdf->MultiCell(20,4,'GROSS WEIGHT',0,'C');
$pdf->SetXY(146,102);
$pdf->Cell(63,17,$M_Qty['dblGrossMass']."KGS",0);

$pdf->SetXY(166,96);
$pdf->Cell(34,8,'',1);
$pdf->SetXY(170,96);
$pdf->MultiCell(25,4,'MEASUREMENT',0,'C');
$pdf->SetXY(170,105);
$pdf->Cell(10,11,$M_Qty['intCBM']." "."CBM",0);
$pdf->SetFont('','U');                                      //          <--------------------CTN Mesurement---strCartoon
$pdf->SetXY(166,140);
$pdf->MultiCell(30,4,'CTN Mesurement',0,'C');

$pdf->SetFont('Arial','',8);
$pdf->SetXY(168,150);
$pdf->Cell(10,11,$row_header['strCartoon'],0);

$pdf->SetFont('Arial','B',8);
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