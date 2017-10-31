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
ROUND(sum(invoicedetail.dblNetMass),2) AS dblNetMass1,
ROUND(sum(shipmentpldetail.dblTotNetNet),2) AS dblNetNetMass,
Sum(invoicedetail.intNoOfCTns) AS intNoOfCTns,
Sum(invoicedetail.intCBM) AS intCBM,
invoicedetail.strFabrication,
invoiceheader.strCollect,
city.strCity,
country.strCountry,
customers.strName AS shipperName,
customers.strMLocation AS shipperLocation,
customers.strAddress1 AS shipperAdd1,
customers.strAddress2 AS shipperAdd2,
customers.strCountry AS shipperCountry,
invoiceheader.strMarksAndNos
FROM
invoiceheader
INNER JOIN buyers ON buyers.strBuyerID = invoiceheader.strBuyerID
INNER JOIN invoicedetail ON invoicedetail.strInvoiceNo = invoiceheader.strInvoiceNo
INNER JOIN city ON city.strCityCode = invoiceheader.strFinalDest
INNER JOIN country ON country.strCountryCode = city.strCountryCode
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
		WHERE strPreDocNo='$docNo'
		GROUP BY invoiceheader.strInvoiceNo
		";

		$res_qty = $db->RunQuery($sql_qty);
		$M_Qty = mysql_fetch_array($res_qty);
		
	
		$dtmDate = explode(" ",$row_header['dtmInvoiceDate']);
	
	
$pdf->AddPage();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(45,8,'UPS Supply Chain Solutions');
$pdf->Ln(-1);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(45,8,'');
$pdf->cell(100,8,'SM');
$pdf->SetFont('Arial','',7);
$dateTime = date("m/d/Y h:i:s a", time());

$pdf->Cell(40,8,"Print Date/Time : ".date("m/d/Y h:i:s a",time())."");
$pdf->Ln(8);
$pdf->SetFont('Arial','B',14);
$pdf->SetX(50);
$pdf->Cell(40,10,"Air Freight Shipper's Letter  of Instruction");
$pdf->Ln(8);
$pdf->SetFont('Arial','B',10);
$pdf->SetX(25);
$pdf->Cell(40,8,"All Shippers tendering air freight shipments destined for or transiting the United States");
$pdf->Ln(4);
$pdf->SetX(60);
$pdf->Cell(40,8,"are strongly recommended to complete this from");
$defaultImage = "../../../images/ups1.jpg";
$pdf->Image($defaultImage,180,16,16,23);

$pdf->Ln(12);
$pdf->cell(150,34,'',1);

$pdf->Ln(1);
$pdf->SetFont('Arial','',8);
$pdf->Cell(20,8,"SHIPPER:");
$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,8,$row_header['shipperName']);
$pdf->SetFont('Arial','',8);
$pdf->Ln(1);
$pdf->SetX(30);
$pdf->Cell(20,8,"...........................................................................................................................................");
$pdf->Ln(3);
$pdf->SetX(30);
$pdf->SetFont('Arial','',6.2);
$pdf->Cell(18,8,"(AS TO APPEAR ON THE AWB)  Under U.S. CBP advance Manifest Rute, Shipper may not be a freight forwarder or consolidator");
$pdf->Ln(6);
$pdf->SetFont('Arial','',8);
$pdf->Cell(20,8,"ADDRESS:");
$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,8,$row_header['shipperName']);
$pdf->Ln(1);
$pdf->SetX(30);
$pdf->Cell(20,8,"...........................................................................................................................................");

$pdf->Ln(5);
$pdf->SetX(30);
$pdf->Cell(20,8,$row_header['shipperAdd1'].",".$row_header['shipperAdd2']);
$pdf->SetFont('Arial','',8);
$pdf->Ln(1);
$pdf->SetX(30);
$pdf->Cell(20,8,"...........................................................................................................................................");

$pdf->Ln(3);
$pdf->SetX(30);
$pdf->SetFont('Arial','',6);
$pdf->Cell(18,8,"Under U.S. CBP Advance Manifest Rute, Shipper Address may not be located in the U.S. or be a P.O. Box");
$pdf->Ln(6);
$pdf->SetFont('Arial','',8);
$pdf->Cell(20,8,"TELEPHONE:");
$pdf->Cell(20,8,"0112668000");
$pdf->Ln(1);
$pdf->SetX(30);
$pdf->Cell(20,8,"...........................................");
$pdf->Ln(-1);
$pdf->SetX(90);
$pdf->Cell(20,8,"FAX:");
$pdf->Cell(20,8,"2699513");
$pdf->Ln(1);
$pdf->SetX(100);
$pdf->Cell(20,8,"...........................................");

$pdf->Ln(-28);
$pdf->SetX(160);
$pdf->cell(45,10,'',1);
$pdf->SetX(160);
$pdf->Cell(20,8,"SHIPPER No");
$pdf->SetFont('Arial','B',8);
$pdf->Cell(17,8,$InvoiceNo,0);
$pdf->SetFont('Arial','',8);
$pdf->Ln(10);
$pdf->SetX(160);
$pdf->Cell(45,10,'',1);
$pdf->SetX(160);
$pdf->Cell(17,8,"SHIPPER REFERENCE");
$pdf->Ln(10);
$pdf->SetX(160);
$pdf->Cell(45,10,'',1);
$pdf->SetX(160);
$pdf->Cell(17,8,"CUSTOMER REFERENCE");
$pdf->Ln(10);
$pdf->SetX(160);
$pdf->Cell(45,35,'',1);
$pdf->SetX(160);
$pdf->Cell(17,8,"P.O. NUMBER");
$pdf->Ln(3);
$pdf->SetX(160);
$pdf->Cell(17,8,"");
$pdf->Ln(1);
$pdf->SetX(160);
$pdf->Cell(17,8,"...................................................");
$pdf->Ln(3);
$pdf->SetX(160);
$pdf->Cell(17,8,"");
$pdf->Ln(1);
$pdf->SetX(160);
$pdf->Cell(17,8,"...................................................");
$pdf->Ln(3);
$pdf->SetX(160);
$pdf->Cell(17,8,"");
$pdf->Ln(1);
$pdf->SetX(160);
$pdf->Cell(17,8,"...................................................");
$pdf->Ln(3);
$pdf->SetX(160);
$pdf->Cell(17,8,"");
$pdf->Ln(1);
$pdf->SetX(160);
$pdf->Cell(17,8,"...................................................");
$pdf->Ln(3);
$pdf->SetX(160);
$pdf->Cell(17,8,"");
$pdf->Ln(1);
$pdf->SetX(160);
$pdf->Cell(17,8,"...................................................");
$pdf->Ln(3);
$pdf->SetX(160);
$pdf->Cell(17,8,"");
$pdf->Ln(1);
$pdf->SetX(160);
$pdf->Cell(17,8,"...................................................");
$pdf->Ln(4);
$pdf->SetX(160);
$pdf->Cell(17,8,"...................................................");


$pdf->Ln(7);
$pdf->SetX(160);
$pdf->Cell(45,10,'',1);
$pdf->SetX(160);
$pdf->Cell(17,8,"CARGO READY DATE");
$pdf->Ln(10);
$pdf->SetX(160);
$pdf->Cell(45,21,'',1);
$pdf->SetX(160);
$pdf->Cell(17,8,"WE THE SHIPPER HAVE");
$pdf->Ln(3);
$pdf->SetX(160);
$pdf->Cell(17,8,"FORWARDED TO YOU THE");
$pdf->Ln(3);
$pdf->SetX(160);
$pdf->Cell(17,8,"SHIPMENT DESCRIBED");
$pdf->Ln(5);
$pdf->SetX(160);
$pdf->Cell(17,8,"BY TRUCK");
$pdf->SetX(181);
$pdf->Cell(17,8,"REFERENCE NO");
$pdf->Ln(3);
$pdf->SetX(178);
$pdf->Cell(2,2,"",1);
$pdf->Ln(-0.1);
$pdf->SetX(160);
$pdf->Cell(17,8,"OTHER");
$pdf->SetX(181);
$pdf->Cell(17,8,"..........................");
$pdf->Ln(3);
$pdf->SetX(178);
$pdf->Cell(2,2,"",1);


$pdf->Ln(-57.8);
$pdf->cell(150,31,'',1);
$pdf->Ln(-1.6);
$pdf->SetFont('Arial','',8);
$pdf->Cell(20,8,"CONSIGNEE:");
$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,8,$row_header['consigneeName']);
$pdf->SetFont('Arial','',8);
$pdf->Ln(1);
$pdf->SetX(30);
$pdf->Cell(20,8,"...........................................................................................................................................");
$pdf->Ln(5);
$pdf->SetX(30);
$pdf->SetFont('Arial','',6.3);
$pdf->MultiCell(130,4,"(AS TO APPEAR ON THE AWB) Name of party to whom cargo will be deliverde. Under U.S. CBP Advance Manifest Rute. Consignee may not be s freight forwarder of customs broker.");
$pdf->Ln(-2);
$pdf->SetFont('Arial','',8);
$pdf->Cell(20,8,"ADDRESS:");
$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,8,$row_header['consigneeName']);
$pdf->SetFont('Arial','',8);
$pdf->Ln(1);
$pdf->SetX(30);
$pdf->Cell(20,8,"...........................................................................................................................................");
$pdf->Ln(5);
$pdf->SetX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,8,$row_header['consigneeAddress1'].",".$row_header['consigneeAddress2']);
$pdf->SetFont('Arial','',8);
$pdf->Ln(1);
$pdf->SetX(30);
$pdf->Cell(20,8,"...........................................................................................................................................");
$pdf->Ln(3);
$pdf->SetX(30);
$pdf->SetFont('Arial','',6 	);
$pdf->Cell(18,8,"Under U.S. CBP Advance Manifest Rule, Cnee. Address for U.S. HAWB destination cargo must be located in U.S may not be a P.O.Box");
$pdf->Ln(4);
$pdf->SetFont('Arial','',8);
$pdf->Cell(20,8,"TELEPHONE:");
$pdf->Cell(20,8,$row_header['consigneePhone']);
$pdf->Ln(1);
$pdf->SetX(30);
$pdf->Cell(20,8,"...........................................");
$pdf->Ln(-1);
$pdf->SetX(90);
$pdf->Cell(20,8,"FAX:");
$pdf->Cell(20,8,$row_header['consigneeFax']);
$pdf->Ln(1);
$pdf->SetX(100);
$pdf->Cell(20,8,"...........................................");


$pdf->Ln(7);
$pdf->cell(150,29.5,'',1);
$pdf->Ln(-1);
$pdf->SetFont('Arial','',5);
$pdf->Cell(18,8,"IN THE CASE OF LETTER OF CREDIT SHIPMENTS TC THE U.S. PLEASE CONFIRM THE NOTIFY PARTY FOR CBP AIR AMS COMPLIANCF.");
$pdf->SetFont('Arial','',8);
$pdf->Ln(6);
$pdf->MultiCell(20,3,"NOTIFY PARTY");
$pdf->Ln(-6);
$pdf->SetX(30);
$pdf->Cell(20,8,"");
$pdf->Ln(1.8);
$pdf->SetX(30);
$pdf->cell(85,5,'.................................................................................................................................');
$pdf->Ln(6);
$pdf->Cell(20,3,"ADDRESS");
$pdf->Ln(-3);
$pdf->SetX(30);
$pdf->Cell(20,8,"");
$pdf->Ln(2);
$pdf->SetX(30);
$pdf->cell(85,5,'.................................................................................................................................');
$pdf->Ln(2);
$pdf->SetX(30);
$pdf->Cell(20,8,"");
$pdf->Ln(2);
$pdf->SetX(30);
$pdf->cell(85,5,'.................................................................................................................................');
$pdf->Ln(13.8);
$pdf->cell(85,5,'',1);
$pdf->SetFont('Arial','',8);

$pdf->Ln(1.5);
$pdf->SetXY(11,138);
$pdf->Cell(2,2,"",1);
$pdf->SetXY(14,135);
$pdf->Cell(20,8,"CONSOLIDATE");
$pdf->SetXY(38,138);
$pdf->Cell(2,2,"",1);
$pdf->SetXY(41,135);
$pdf->Cell(20,8,"DIRECT");
$pdf->SetXY(55,135);
$pdf->Cell(23,8,"SERVICE LEVEL:");
$pdf->Cell(20,8,"....................");
$pdf->SetXY(95,137);
$pdf->cell(110,5,'',1);
$pdf->SetXY(95,135);
$pdf->Cell(20,8,"SHIPPER MUST CHECK");
$pdf->SetXY(130,138);
$pdf->Cell(2,2,"",1);
$pdf->SetXY(133,135);
$pdf->Cell(20,8,"PREPAID");
$pdf->SetXY(149,138);
$pdf->Cell(2,2,"",1);

$pdf->SetXY(152,135);
$pdf->Cell(20,8,"COLLECT");
$pdf->SetXY(168,138);
$pdf->Cell(2,2,"",1);
$pdf->SetXY(171,135);
$pdf->Cell(22,8,"C.O.D.AMOUNT");
$pdf->Cell(20,8,".............");

$pdf->SetXY(10,142);
$pdf->cell(85,5,'',1);
$pdf->SetXY(10,141);
$pdf->Cell(20,8,"ORIGIN AIRPORT");
//$pdf->SetXY(60,141);
//$pdf->Cell(20,8,"COLOMBO");

$pdf->SetXY(95,142);
$pdf->cell(110,5,'',1);
$pdf->SetXY(95,141);
$pdf->Cell(20,8,"PLACE OF RECEIP");
$pdf->SetXY(125,143.5);
$pdf->Cell(2,2,"",1);

$pdf->SetXY(10,147);
$pdf->cell(85,5,'',1);
$pdf->SetXY(10,146);
$pdf->Cell(20,8,"DESTINATION AIRPORT");

//$pdf->SetXY(60,146);
//$pdf->Cell(20,8,$row_header['strCity']);

$pdf->SetXY(95,147);
$pdf->cell(110,5,'',1);
$pdf->SetXY(95,146);
$pdf->Cell(20,8,"PLACE OF DELIVERY/FINAL DESTINATION");

//$pdf->SetXY(160,146);
//$pdf->Cell(20,8,$row_header['strCountry']);

$pdf->SetXY(10,152);
$pdf->cell(20,14,'',1);
$pdf->SetXY(10,153);
$pdf->Multicell(20,3,'TENDERED QUANTITY');
//$pdf->SetFont('Arial','',6);
$pdf->SetXY(20,172);
$pdf->Cell(20,8,"PLTS");
//$pdf->SetFont('Arial','B',8);
$pdf->SetXY(20,176);
$pdf->Cell(20,8,$M_Qty['dblQuantity']);  
$pdf->SetXY(20,179);
$pdf->Cell(20,8,"(PCS)",0);

$pdf->SetXY(30,152);
$pdf->cell(35,14,'',1);
$pdf->SetXY(30,153);
$pdf->cell(20,3,'MANIFEST QUANTITY U.');
$pdf->SetXY(30,156);
$pdf->cell(20,3,'S.CBP Advance Manifest');
$pdf->SetXY(30,159);
$pdf->cell(20,3,'Manifest Rufe requlres sm');
$pdf->SetXY(30,162);
$pdf->cell(20,3,'allest externam pkg level');
$pdf->SetXY(53,172);
$pdf->Cell(40,8,"PLTS");
//$pdf->SetFont('Arial','B',8);intNoOfCTns
$pdf->SetXY(53,176);
$pdf->Cell(20,8,$row_header['intNoOfCTns']);  //<----------------------------------------------------
$pdf->SetXY(53,179);
$pdf->Cell(20,8,"(PCS)",0);

$pdf->SetXY(65,152);
$pdf->cell(15,14,'',1);
$pdf->SetXY(65,153);
$pdf->Multicell(15,3,'GROSS WT.');
$pdf->SetXY(67,160);
$pdf->cell(15,3,'(KG)','C');
$pdf->SetXY(67,174);
$pdf->cell(15,3,$M_Qty['dblGrossMass']);

$pdf->SetXY(80,152);
$pdf->cell(15,14,'',1);
$pdf->SetXY(80,153);
$pdf->Multicell(15,3,'DIMENSIONS');
$pdf->SetXY(80,159);
$pdf->cell(15,3,'LxWxH','C');
$pdf->SetXY(82,174);
$pdf->cell(15,3,$row_header['intCBM']);    //   <-----------------------------------------------------

$pdf->SetXY(95,152);
$pdf->cell(90,14,'',1);
$pdf->SetXY(95,153);
$pdf->cell(70,3,'PRECISE DESCRIPTION OF GOODS');
$pdf->cell(15,3,'Subject');
$pdf->SetXY(110,159);
$pdf->cell(70,3,'U.S CDP Advance Manifest Rufe guidelines');

$pdf->SetXY(98,173);
$pdf->Cell(75,4,$row_header['strDescOfGoods']);   
$pdf->SetXY(98,177);
$pdf->Cell(75,4,$row_header['strFabrication'],0);
$pdf->SetXY(98,181);
$pdf->Cell(75,4,"Style No:".$row_header['strStyleID'],0);
$pdf->SetXY(98,185);
$pdf->Cell(75,4,"Order No:".$row_header['strBuyerPONo'],0);
$pdf->SetXY(98,189);
$pdf->Cell(75,4,"CARGO READY DATE:".$dtmDate[0],0);
$pdf->SetXY(98,194);
$pdf->Cell(75,4,"FREIGHT:".$row_header['strCollect'],0);



$pdf->SetXY(185,152);
$pdf->cell(20,14,'',1);
$pdf->SetXY(185,153);
$pdf->cell(20,3,'HTS NUMBER');
$pdf->SetXY(186,156);
$pdf->cell(20,3,'(OPTIONAL)');


$pdf->SetXY(10,166);
$pdf->cell(10,45,'',1);

$pdf->SetXY(20,166);
$pdf->cell(10,45,'',1);

$pdf->SetXY(30,166);
$pdf->cell(20,45,'',1);

$pdf->SetXY(50,166);
$pdf->cell(15,45,'',1);

$pdf->SetXY(65,166);
$pdf->cell(15,45,'',1);

$pdf->SetXY(80,166);
$pdf->cell(15,45,'',1);

$pdf->SetXY(95,166);
$pdf->cell(90,45,'',1);

$pdf->SetXY(185,166);
$pdf->cell(20,45,'',1);

$pdf->SetXY(10,211);
$pdf->cell(55,5,'',1);
$pdf->SetXY(10,213);
$pdf->cell(20,3,'INCOTERMS');
$pdf->SetXY(10,216);
$pdf->cell(55,5,'',1);
$pdf->SetXY(10,218);
$pdf->cell(20,3,'FREIGHT PAYABLE AT');
$pdf->SetXY(10,221);
$pdf->cell(55,5,'',1);
$pdf->SetXY(10,223);
$pdf->cell(20,3,'VALUE FOR CARRIAFE');
$pdf->SetXY(10,226);
$pdf->cell(55,5,'',1);
$pdf->SetXY(10,228);
$pdf->cell(20,3,'VALUE FOR CUSTOMS');
$pdf->SetXY(10,231);
$pdf->cell(55,8,'',1);
$pdf->SetXY(10,233);
$pdf->cell(20,3,'SHIPPER REQUESTS INSURANCE:');
$pdf->SetXY(12,236);
$pdf->cell(2,2,'',1);
$pdf->cell(8,2,'YES');
$pdf->cell(2,2,'',1);
$pdf->cell(5,2,'NO');
$pdf->cell(10,2,'AMOUNT:');

$pdf->SetXY(65,211);
$pdf->cell(60,28,'',1);
$pdf->SetXY(75,212);
$pdf->cell(20,3,'SPECIAL INSTRUCTIONS');

$pdf->SetXY(125,211);
$pdf->cell(80,5,'',1);
$pdf->SetXY(125,212.8);
$pdf->SetFont('Arial','U',8);
$pdf->cell(48,3,'HAZARDOUS MATERIALS:');
$pdf->SetFont('Arial','',8);
$pdf->cell(2,2,'',1);
$pdf->cell(10,2,'YES');
$pdf->cell(2,2,'',1);
$pdf->cell(10,2,'NO');

$pdf->SetXY(125,216);
$pdf->cell(80,47,'',1);
$pdf->SetFont('Arial','U',8);
$pdf->SetXY(125,218);
$pdf->cell(48,3,'DOCUMENTS ATTACHED');
$pdf->SetXY(135,223);
$pdf->cell(2,2,'',1);
$pdf->cell(10,2,'COMMERCIAL INVOICE');
$pdf->SetXY(135,227);
$pdf->cell(2,2,'',1);
$pdf->cell(10,2,'PACKING LIST');
$pdf->SetXY(135,231);
$pdf->cell(2,2,'',1);
$pdf->cell(10,2,'HAZADOUS/RESTER. ARTICLE CERTIFICATE');
$pdf->SetXY(135,235);
$pdf->cell(2,2,'',1);
$pdf->cell(10,2,'CERTIFICATE OF ORIGIN');
$pdf->SetXY(135,239);
$pdf->cell(2,2,'',1);
$pdf->cell(10,2,'EXPORT LICENSE');
$pdf->SetXY(135,243);
$pdf->cell(2,2,'',1);
$pdf->cell(10,2,'CONSULAR DOCUMENTATION');
$pdf->SetXY(135,247);
$pdf->cell(2,2,'',1);
$pdf->cell(10,2,'INSURANCE CERTIFICATE');
$pdf->SetXY(135,251);
$pdf->cell(2,2,'',1);
$pdf->cell(10,2,'FUMIGATION CERTIFICATE/EXPORTER STMT');
$pdf->SetXY(135,255);
$pdf->cell(2,2,'',1);
$pdf->cell(15,2,'OTHER');
$pdf->SetFont('Arial','',8);
$pdf->cell(20,2,'...........................');

$pdf->SetXY(10,239);
$pdf->cell(115,8,'',1);
$pdf->SetXY(10,240.5);
$pdf->cell(20,2,'IEGALIZATION - DOCUMENTS REQUIRED');
$pdf->SetXY(10,247);
$pdf->cell(115,16,'',1);
$pdf->SetXY(10,248);
$pdf->SetFont('Arial','I',8);
$pdf->cell(20,2,'PLEASE CHECK ONE');
$pdf->SetFont('Arial','',8);
$pdf->SetXY(11,251);
$pdf->cell(2,2,'',1);
$pdf->Multicell(100,3,'CONTAINS NO SOLD WOOD PACKAGING MATERIALS (VENDOR TO SUBMIT EXPORTER STATEMENT)');
$pdf->SetXY(11,257.4);
$pdf->cell(2,2,'',1);
$pdf->Multicell(100,3,'CONTAINS SOLD WOOD PACKAGING MATERIALS (VENDOR TO SUBMIT FUMIGATION CERTIFICATE)');
$pdf->SetFont('Arial','',6);
$pdf->SetXY(10,263);
$pdf->cell(195,10,'',1);
$pdf->SetXY(11,264);
$pdf->Multicell(190,2,"The undersigned duty authorized person hereby certifies that the information provided herein is true and correct acknowledges that UPS Supply Chain Solutions, Inc., UPS Air Freight Services, and their specifically authorized agents re");
$pdf->SetXY(11,268.5);
$pdf->SetFont('Arial','',8);
$pdf->cell(100,2,'NAME');
$pdf->cell(60,2,'SIGNATURE');
$pdf->cell(40,2,'DATE');
}
$pdf->Output();
//echo "abc";
?>