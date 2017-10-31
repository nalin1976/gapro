<?php
require('../../../Fpdf/fpdf.php');
include("../../../Connector.php");
$pdf = new FPDF();
$docNo = $_GET['docNo'];

	$sql_header = "
		SELECT
invoiceheader.strInvoiceNo,
invoiceheader.strPreDocNo,
invoiceheader.dtmInvoiceDate,
invoiceheader.intInvoiceId,
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
Sum(invoicedetail.dblQuantity) AS dblQuantity,
invoicedetail.strDescOfGoods,
ROUND(Sum(invoicedetail.dblAmount),2) AS dblAmount,
invoicedetail.strFabrication,
Sum(invoicedetail.intCBM) AS intCBM,
city.strCity,
ROUND(sum(invoicedetail.dblGrossMass),2) AS dblGrossMass,
ROUND(SUM(invoicedetail.dblNetMass),2) AS dblNetMass,
invoicedetail.strBuyerPONo,
invoicedetail.intNoOfCTns,
invoiceheader.strMarksAndNos,
invoiceheader.strCollect,
invoiceheader.strPortOfLoading,
customers.strName AS shipperName,
customers.strAddress1 AS shipperAdd1,
customers.strAddress2 AS shipperAdd2,
customers.strCountry AS shipperCountry
FROM
invoiceheader
INNER JOIN buyers ON buyers.strBuyerID = invoiceheader.strBuyerID
INNER JOIN buyers AS n ON n.strBuyerID = invoiceheader.strBuyerID
INNER JOIN invoicedetail ON invoicedetail.strInvoiceNo = invoiceheader.strInvoiceNo
LEFT JOIN city ON city.strCityCode = invoiceheader.strPortOfLoading
INNER JOIN customers ON customers.strCustomerID = invoiceheader.strCompanyID
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
	
		$dtmDate = explode(" ",$row_header['dtmInvoiceDate']);

$pdf->AddPage();



$pdf->SetFont('Arial','B',9);
$pdf->SetXY(9,13);
$pdf->Cell(10,10,"SHIPPERS LETTERS OF INSTRUCTION",0);

$pdf->SetXY(10,20);
$pdf->Cell(45,10,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(10,20);
$pdf->Cell(10,17,"PORT OF LOADING",0);

$pdf->SetXY(55,20);
$pdf->Cell(20,10,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(56,16);
$pdf->Cell(60,20,$row_header['strPortOfLoading'],0);

$pdf->SetXY(75,20);
$pdf->Cell(15,10,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(70,14);
$pdf->Cell(63,17,"",0);

$pdf->SetXY(90,20);
$pdf->Cell(70,10,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(90,20);
$pdf->Cell(10,17,"SHIP CANCEL DATE",0);

$pdf->SetXY(160,20);
$pdf->Cell(40,10,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(160,20);
$pdf->Cell(63,17,"DATE OF BOOKING",0);
///
$pdf->SetXY(10,30);
$pdf->Cell(45,10,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(10,30);
$pdf->Cell(10,17,"PORT OF DISCHARGE",0);

$pdf->SetXY(55,30);
$pdf->Cell(20,10,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(58,26);
$pdf->Cell(63,17,"",0);

$pdf->SetXY(75,30);
$pdf->Cell(15,10,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(70,24);
$pdf->Cell(63,17,"",0);

$pdf->SetXY(90,30);
$pdf->Cell(70,10,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(90,30);
$pdf->Cell(100,17,"HAWB    NO: CMBOO.......................",0);

$pdf->SetXY(160,30);
$pdf->Cell(40,10,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(160,30);
$pdf->Cell(63,17,"2012/......../........",0);
///
$pdf->SetXY(10,40);
$pdf->Cell(80,30,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(10,26);
$pdf->Cell(10,37,"CONSIGNEE:",0);

$pdf->SetFont('Arial','',8);
$pdf->SetXY(30,43);
$pdf->Cell(25,4,$row_header['consigneeName'],0);

$pdf->SetFont('Arial','',8);
$pdf->SetXY(30,47);
$pdf->Cell(25,4,$row_header['consigneeAddress1'],0);

$pdf->SetFont('Arial','',8);
$pdf->SetXY(30,51);
$pdf->Cell(25,4,$row_header['consigneeAddress2'],0);

$pdf->SetFont('Arial','',8);
$pdf->SetXY(30,55);
$pdf->Cell(25,4,$row_header['consigneeCountry'],0);

$pdf->SetXY(90,40);
$pdf->Cell(110,30,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(64,24);
$pdf->Cell(63,17,"",0);

//$pdf->SetXY(100,25);
$defaultImage = "../../../images/hell.jpg";            //<---------------------IMAGE------
$pdf->Image($defaultImage,97,41,100,25);
///
$pdf->SetXY(10,70);
$pdf->Cell(80,30,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(10,55);
$pdf->Cell(10,37,"SHIPPER:",0);

$pdf->SetFont('Arial','',8);
$pdf->SetXY(28,72);
$pdf->Cell(25,4,$row_header['shipperName'],0);

$pdf->SetFont('Arial','',8);
$pdf->SetXY(29,76);
$pdf->Cell(25,4,$row_header['shipperAdd1'],0);

$pdf->SetFont('Arial','',8);
$pdf->SetXY(28,80);
$pdf->Cell(25,4,$row_header['shipperAdd2'],0);

$pdf->SetFont('Arial','',8);
$pdf->SetXY(28,84);
$pdf->Cell(25,4,$row_header['shipperCountry'],0);

$pdf->SetXY(90,70);
$pdf->Cell(110,40,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(64,24);
$pdf->Cell(63,17,"",0);

$pdf->SetFont('Arial','',6);
$pdf->SetXY(110,72);
$pdf->MultiCell(70,3,"Your are herby requested to authorized upon of the consignment described herein to prepare and sign the airway bill and other necessary document on our behalf and dispatch the consignment in accordance with your conditions of contract and for which  we guarantee payment of all charges and advances.We also certify that the contents of this consignment are properly described and have no corrosive, flammable poisonous or other hazardous characteristics",0);

/*$pdf->Cell(100,10,"Your are herby requested to  authorized  upon of the ",0);
$pdf->SetXY(110,72);
$pdf->Cell(100,10,"consignment described herein to prepare and sign  ",0);
$pdf->SetXY(110,74);
$pdf->Cell(100,10,"the airway bill and other necessary document on our   ",0);
$pdf->SetXY(110,76);
$pdf->Cell(100,10,"behalf and dispatch the consignment in accordance  ",0);
$pdf->SetXY(110,78);
$pdf->Cell(100,10,"with your conditions of contract and for which we  ",0);
$pdf->SetXY(110,80);
$pdf->Cell(100,10,"guarantee payment of all charges and advances.We  ",0);
$pdf->SetXY(110,82);
$pdf->Cell(100,10,"also certify that the contents of this consignment are  ",0);
$pdf->SetXY(110,84);
$pdf->Cell(100,10,"properly described and have no corrosive, flammable   ",0);
$pdf->SetXY(110,86);
$pdf->Cell(100,10,"poisonous or other hazardous characteristics",0);*/

$pdf->SetFont('Arial','B',9);
$pdf->SetXY(96,100);
$pdf->Cell(100,10,"HELLMANN CONTACT :  TEL: 2316700 - 30 , FAX 2303378",0);
///


$pdf->SetXY(10,100);
$pdf->Cell(80,20,'',1);
$pdf->SetFont('Arial','',7);
$pdf->SetXY(10,84);
$pdf->Cell(10,37,"ALSO NOTIFY PARTY: ",0);

$pdf->SetXY(90,110);
$pdf->Cell(110,10,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(90,107);
$pdf->Cell(63,17,"VENDOR EXPORT INVOICE NO :  EXP  /       ",0);

$pdf->SetFont('Arial','',8);
$pdf->SetXY(150,113);
$pdf->Cell(25,4,$row_header['strInvoiceNo'],0);
///

$pdf->SetXY(10,120);
$pdf->Cell(50,10,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(10,116);
$pdf->Cell(10,17,"MARKS & NOS ",0);

$pdf->SetFont('Arial','',6);
$pdf->SetXY(10,135);
$pdf->MultiCell(25,4,$row_header['strMarksAndNos'],0);          //  <----------------------------------------

$pdf->SetXY(60,120);
$pdf->Cell(20,10,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(65,115);
$pdf->Cell(60,20,"PKGS",0);

$pdf->SetFont('Arial','',8);
$pdf->SetXY(66,140);
$pdf->MultiCell(25,4,$row_header['intNoOfCTns'],0);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(66,140);
$pdf->Cell(10,17,"CTNS",0);

$pdf->SetXY(80,120);
$pdf->Cell(80,10,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(100,116);
$pdf->Cell(10,17,"DESCRIPTION OF GOODS",0);

$pdf->SetFont('Arial','',8);
$pdf->SetXY(90,140);
$pdf->Cell(75,4,$row_header['dblQuantity']."PCS",0);

$pdf->SetFont('Arial','',8);
$pdf->SetXY(110,140);
$pdf->Cell(75,4,$row_header['strDescOfGoods'],0);

$pdf->SetFont('Arial','',8);
$pdf->SetXY(110,145);
$pdf->Cell(75,4,$row_header['strFabrication'],0);

$pdf->SetXY(80,155);
$pdf->Cell(30,5,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(80,149);
$pdf->Cell(10,17,"ORDER NO      :",0);
$pdf->SetXY(110,155);
$pdf->Cell(50,5,'',1);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(110,155);
$pdf->Cell(75,4,$row_header['strBuyerPONo'],0);

$pdf->SetXY(80,160);
$pdf->Cell(30,5,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(80,155);
$pdf->Cell(10,17,"STYLE NO      :",0);
$pdf->SetXY(110,160);
$pdf->Cell(50,5,'',1);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(110,160);
$pdf->Cell(75,4,$row_header['strStyleID'],0);

$pdf->SetXY(80,175);
$pdf->Cell(30,5,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(80,169);
$pdf->Cell(10,17,"CARGO READY:",0);
$pdf->SetXY(110,175);
$pdf->Cell(50,5,$dtmDate[0],1);


$pdf->SetXY(80,185);
$pdf->Cell(30,5,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(80,179);
$pdf->Cell(10,17,"FREIGHT",0);
$pdf->SetXY(110,185);
$pdf->Cell(50,5,'',1);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(110,185);
$pdf->Cell(75,4,$row_header['strCollect'],0);



$pdf->SetXY(160,120);
$pdf->Cell(40,10,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(160,116);
$pdf->Cell(63,17,"GROSS WEIGHT",0);
///
$pdf->SetXY(10,130);
$pdf->Cell(50,70,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(10,17);
$pdf->Cell(10,17," ",0);

$pdf->SetXY(60,130);
$pdf->Cell(20,75,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(64,14);
$pdf->Cell(60,20,"",0);

$pdf->SetXY(80,130);
$pdf->Cell(80,70,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(100,17);
$pdf->Cell(10,17,"",0);

$pdf->SetXY(160,130);
$pdf->Cell(40,30,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(160,138);
$pdf->Cell(63,17,$row_header['dblGrossMass']."KGS",0);

$pdf->SetXY(160,160);
$pdf->Cell(40,10,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(160,78);
$pdf->Cell(150,175,"NO OF CBM",0);

$pdf->SetXY(160,170);
$pdf->Cell(40,30,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(160,98);
$pdf->Cell(160,175,$row_header['intCBM']."CBM",0);
///
$pdf->SetXY(10,200);
$pdf->Cell(50,5,'',1);

$pdf->SetXY(80,200);
$pdf->Cell(120,5,'',1);
///
$pdf->SetFont('Arial','B',9);
$pdf->SetXY(9,203);
$pdf->Cell(10,10,"PAYMENT TERMS FOR ACCOUTING PURPOSE ",0);

$pdf->SetXY(10,210);
$pdf->Cell(50,20,'FREIGHT CHARGES ',1);

$pdf->SetXY(60,210);
$pdf->Cell(20,10,'COLLECT',1);

$pdf->SetXY(60,220);
$pdf->Cell(20,10,'PREPAID ',1);

$pdf->SetXY(80,210);
$pdf->Cell(30,10,'',1);

$pdf->SetXY(80,220);
$pdf->Cell(30,10,'',1);

$pdf->SetXY(110,210);
$pdf->Cell(50,20,'OTHER CHARGES ',1);

$pdf->SetXY(160,210);
$pdf->Cell(40,10,'COLLECT',1);

$pdf->SetXY(160,220);
$pdf->Cell(40,10,'PREPAID',1);
///
$pdf->SetFont('Arial','B',9);
$pdf->SetXY(9,228);
$pdf->Cell(10,10,"HANDLING INFORMATION",0);
///
$pdf->SetXY(10,235);
$pdf->Cell(190,30,'',1);
///
$pdf->SetFont('Arial','B',5);
$pdf->SetXY(9,263);
$pdf->Cell(10,10,"I/WE DO DECLARE THAT THE ABOVE PARTICULARS ARE TRUE AND CORRECT, ALSO WE DO RESPONSIBLE FOR ALL INFORMATION PROVIDED ABOVE ..",0);

}



$pdf->Output();
?>