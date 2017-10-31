<?php
require('../../../Fpdf/fpdf.php');
include("../../../Connector.php");
$pdf = new FPDF();
$docNo = $_GET['docNo'];

		$sql_header = "SELECT
		invoiceheader.strInvoiceNo,
		invoiceheader.strPreDocNo,
		invoiceheader.dtmInvoiceDate,
		invoiceheader.intInvoiceId,
		date(invoiceheader.dtmSailingDate) AS dtmSailingDate,
		invoiceheader.strCollect,
		buyers.strName AS consigneeName,
		buyers.strAddress1 AS consigneeAddress1,
		buyers.strAddress2 AS consigneeAddress2,
		buyers.strCountry AS consigneeCountry,
		buyers.strPhone AS consigneePhone,
		buyers.strFax AS consigneeFax,
		n.strName AS notifyName,
		n.strAddress1 AS notifyAddress1,
		n.strAddress2 AS notifyAddress2,
		n.strCountry AS notifyCountry,
		invoicedetail.strStyleID,
		Sum(invoicedetail.dblQuantity) AS dblQuantity1,
		invoicedetail.strDescOfGoods,
		ROUND(Sum(invoicedetail.dblAmount),2) AS dblAmount,
		invoicedetail.strFabrication,
		Sum(invoicedetail.intCBM) AS intCBM1,
		city.strCity,
		ROUND(sum(invoicedetail.dblGrossMass),2) AS dblGrossMass1,
		ROUND(SUM(invoicedetail.dblNetMass),2) AS dblNetMass1,
		ROUND(sum(shipmentpldetail.dblTotNetNet),2) AS dblNetNetMass,
		invoicedetail.strBuyerPONo,
		invoicedetail.intNoOfCTns,
customers.strName AS shipperName,
customers.strAddress1 AS shipperAdd1,
customers.strAddress2 AS shipperAdd2,
customers.strCountry AS shipperCountry,
buyers.strBuyerCode
		FROM
		invoiceheader
		INNER JOIN buyers ON buyers.strBuyerID = invoiceheader.strBuyerID
		INNER JOIN buyers AS n ON n.strBuyerID = invoiceheader.strBuyerID
		INNER JOIN invoicedetail ON invoicedetail.strInvoiceNo = invoiceheader.strInvoiceNo
		LEFT JOIN city ON city.strCityCode = invoiceheader.strPortOfLoading
		INNER JOIN customers ON customers.strCustomerID = invoiceheader.strCompanyID
		LEFT JOIN shipmentpldetail ON shipmentpldetail.strPLNo = invoicedetail.strPLNO
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
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(10,10);
$pdf->Cell(195,35,'',1);
$defaultImage = "../../../images/expeditors1.jpg";
$pdf->Image($defaultImage,13,12,40,13);
$pdf->SetXY(145,15);
$pdf->Cell(40,4,'EXPEDITORS LANKA (PVT) LTD'.$type,0);
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
$pdf->SetXY(170,40);
//$pdf->Cell(25,4,$row_header['strInvoiceNo'],0);
$pdf->Cell(25,4,$InvoiceNo,0);

$pdf->SetXY(10,45);
$pdf->Cell(90,28,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(11,46);
$pdf->Cell(25,4,"CONSIGNEE NAME AND ADDRESS",0);

$pdf->SetFont('Arial','',8);
$pdf->SetXY(11,50);
$pdf->Cell(25,4,$row_header['consigneeName'],0);

$pdf->SetXY(11,54);
$pdf->Cell(25,4,$row_header['consigneeAddress1'],0);

$pdf->SetXY(11,58);
$pdf->Cell(25,4,$row_header['consigneeAddress2'],0);

$pdf->SetXY(11,62);
$pdf->Cell(25,4,$row_header['consigneeCountry'],0);



$pdf->SetXY(100,45);
$pdf->Cell(22,8,'',1);
$pdf->SetXY(101,46);
$pdf->MultiCell(23,3,'DESTINATION AIR PORT',0);

$pdf->SetXY(122,45);
$pdf->Cell(28,8,$row_header['strCity'],1);
$pdf->SetXY(150,45);
$pdf->Cell(18,8,'',1);
$pdf->SetXY(151,46);
$pdf->MultiCell(17,3,"PLACE OF DELIVERY",0);
$pdf->SetXY(170,46);
$pdf->MultiCell(21,3,$row_header['consigneeCountry'],0);             
$pdf->SetXY(168,45);
$pdf->Cell(37,8,'',1);
$pdf->SetXY(100,53);
$pdf->Cell(22,8,'',1);
$pdf->SetXY(101,54);
$pdf->MultiCell(20,3,'Cargo Ready Date',0);
$pdf->SetXY(122,53);
$pdf->Cell(83,8,$dtmDate[0],1);
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
$pdf->SetXY(101,80);
$pdf->MultiCell(21,3,'Brand Name',0);
$pdf->SetXY(123,80);
$pdf->MultiCell(51,3,$row_header['strBuyerCode'],0);                     //   <--------------------BRAND NAME-----------------------
$pdf->SetXY(122,77);
$pdf->Cell(83,8,'',1);
$pdf->SetXY(100,85);
$pdf->Cell(105,10,'',1);
$pdf->SetXY(135,88);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(50,3,"FREIGHT:".$row_header['strCollect'],0);

$pdf->SetXY(10,73);
$pdf->Cell(90,22,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(11,74);
$pdf->Cell(25,4,"NOTIFY",0);
$pdf->SetXY(11,78);
$pdf->Cell(25,4,"",0);
$pdf->SetXY(11,82);
$pdf->Cell(25,4,"Same As Consignee",0);

$pdf->SetXY(10,95);
$pdf->Cell(150,6,'',1);
$pdf->SetXY(11,96);
$pdf->Cell(25,4,"SPECIAL INSTRUCTION (E.G.LETTER OF CREDIT/CONSULAR REQUIREMENTS)",0);
$pdf->SetXY(160,95);
$pdf->Cell(45,6,'',1);

$pdf->SetXY(10,101);
$pdf->Cell(19,9,'',1);
$pdf->SetXY(11,102);
$pdf->MultiCell(18,4,"NO OF CTNS",0);
$pdf->SetXY(29,101);
$pdf->Cell(19,9,'',1);
$pdf->SetXY(30,102);
$pdf->MultiCell(19,4,"No Of PCS",0);
$pdf->SetXY(48,101);
$pdf->Cell(65,9,'',1);
$pdf->SetXY(58,102);
$pdf->Cell(19,4,"NATURE AND QUANTITY OF GOODS",0);
$pdf->SetXY(113,101);
$pdf->Cell(35,9,'',1);
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
$pdf->SetXY(10,114);
$pdf->Cell(19,4,$row_header['intNoOfCTns'],0);


$pdf->SetXY(29,110);
$pdf->Cell(19,55,'',1);
$pdf->SetXY(29,114);
$pdf->Cell(19,4,$M_Qty['dblQuantity'],0);

$pdf->SetXY(48,110);
$pdf->Cell(65,55,'',1);
$pdf->SetXY(48,114);
$pdf->Cell(70,4,$row_header['strDescOfGoods'],0);
$pdf->SetXY(48,118);
$pdf->Cell(70,4,$row_header['strFabrication'],0);
$pdf->SetXY(48,122);
$pdf->Cell(70,4,"PO NO",0);
$pdf->SetXY(58,122);
$pdf->Cell(70,4,$row_header['strBuyerPONo'],0);
$pdf->SetXY(48,126);
$pdf->Cell(70,4,"STYLE NO",0);
$pdf->SetXY(68,126);
$pdf->Cell(70,4,$row_header['strStyleID'],0);
$pdf->SetXY(48,130);
$pdf->Cell(70,4,"Cargo Redy Date",0);
$pdf->SetXY(70,130);
$pdf->Cell(72,4,$row_header['dtmSailingDate'],0);


$pdf->SetXY(118,110);
$pdf->Cell(30,55,'',0);
$pdf->SetXY(118,114);
$pdf->Cell(30,4,'',0);
$pdf->SetXY(112.5,114);
$pdf->Cell(30,4,$marks['strMMLine1'],0);
$pdf->SetXY(112.5,118);
$pdf->Cell(30,4,$marks['strMMLine2'],0);
$pdf->SetXY(112.5,122);
$pdf->Cell(30,4,$marks['strMMLine3'],0);
$pdf->SetXY(112.5,126);
$pdf->Cell(30,4,$marks['strMMLine4'],0);
$pdf->SetXY(112.5,130);
$pdf->Cell(30,4,$marks['strMMLine5'],0);
$pdf->SetXY(112.5,134);
$pdf->Cell(30,4,$marks['strSMLine1'],0);
$pdf->SetXY(112.5,138);
$pdf->Cell(30,4,$marks['strSMLine2'],0);
$pdf->SetXY(112.5,142);
$pdf->Cell(30,4,$marks['strSMLine3'],0);
$pdf->SetXY(112.5,146);
$pdf->Cell(30,4,$marks['strSMLine4'],0);
$pdf->SetXY(112.5,150);
$pdf->Cell(30,4,$marks['strSMLine5'],0);
$pdf->SetXY(112.5,154);
$pdf->Cell(30,4,$marks['strSMLine6'],0);



$pdf->SetXY(148,110);
$pdf->Cell(30,55,'',1);
$pdf->SetXY(152,114);
$pdf->Cell(30,4,$M_Qty['intCBM'],0);
$pdf->SetXY(152,118);
$pdf->Cell(30,4,"CBM",0);



$pdf->SetXY(178,110);
$pdf->Cell(27,55,'',1);
$pdf->SetFont('Arial','U',8);
$pdf->SetXY(178,114);
$pdf->Cell(27,4,'Gross WT',0);                          //  <-----------------WEIGHT-------------------
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(184,118);
$pdf->Cell(27,4,$M_Qty['dblGrossMass'],0);

$pdf->SetXY(178,122);
$pdf->Cell(27,4,'',0);

$pdf->SetFont('Arial','U',8);
$pdf->SetXY(178,126);
$pdf->Cell(27,4,'Net WT',0);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(184,130);
$pdf->Cell(27,4,$M_Qty['dblNetMass'],0);

$pdf->SetFont('Arial','U',8);
$pdf->SetXY(178,136);
$pdf->Cell(27,4,'N.N WT',0);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(184,140);
$pdf->Cell(27,4,$row_header['dblNetNetMass'],0);        //   <--------------------NN WEIGHT---------------




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
$pdf->SetFont('Arial','B',6);
$pdf->SetXY(11,246);
$pdf->Cell(65,4,'SHIPPER NAME AND ADDRESS :',0);
$pdf->SetXY(11,250);
$pdf->SetFont('Arial','',8);
$pdf->Cell(27,4,$row_header['shipperName'],0);
$pdf->SetXY(11,253);
$pdf->Cell(27,4,$row_header['shipperAdd1'],0);
$pdf->SetXY(11,256);
$pdf->Cell(27,4,$row_header['shipperAdd2'],0);
$pdf->SetXY(11,259);
$pdf->Cell(27,4,$row_header['shipperCountry'],0);

$pdf->SetFont('Arial','',7);
$pdf->SetXY(105,246);
$pdf->MultiCell(100,4,'The Shipper hereby declared that the above particulars are corredt and that he is aware of and accepts the Conditions of Trading referred to on the reverse side of this form',0);

$pdf->SetXY(155,258);
$pdf->Cell(65,4,'Signed on behalf of Shipper',0);

$pdf->SetXY(105,260);
$pdf->Cell(65,4,'By      :',0);
$pdf->SetXY(105,264);
$pdf->Cell(65,4,'Dated :',0);
}
$pdf->Output();
?>