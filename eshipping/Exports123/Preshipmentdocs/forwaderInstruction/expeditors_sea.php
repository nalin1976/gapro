<?php
require('../../../Fpdf/fpdf.php');
include("../../../Connector.php");
$pdf = new FPDF();
$docNo = $_GET['docNo'];

$sql_header = "SELECT
cdn_header.intCDNNo,
cdn_header.strInvoiceNo,
cdn_header.dtmDate,
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
cdn_detail.strStyleID,
Sum(cdn_detail.intNoOfCTns) AS intNoOfCTns,
Sum(cdn_detail.dblQuantity) AS dblQuantity,
cdn_detail.strDescOfGoods,
ROUND(Sum(cdn_detail.dblAmount),2) AS dblAmount,
cdn_detail.strFabrication,
Sum(cdn_detail.intCBM) AS intCBM,
city.strCity,
ROUND(sum(cdn_detail.dblGrossMass),2) AS dblGrossMass,
ROUND(SUM(cdn_detail.dblNetMass),2) AS dblNetMass,
cdn_detail.strHSCode,
cdn_detail.strBuyerPONo
FROM
cdn_header
INNER JOIN buyers ON buyers.strBuyerID = cdn_header.intConsignee
INNER JOIN buyers AS n ON n.strBuyerID = cdn_header.intConsignee
INNER JOIN cdn_detail ON cdn_detail.intCDNNo = cdn_header.intCDNNo
INNER JOIN city ON city.strCityCode = cdn_header.strPortOfDischarge
WHERE cdn_header.intCdnDocNo=$docNo
GROUP BY cdn_header.intCDNNo
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
	
$dtmDate = explode(" ",$row_header['dtmDate']);
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(10,10);
$pdf->Cell(195,35,'',1);
$defaultImage = "../../../images/expeditors1.jpg";
$pdf->Image($defaultImage,13,12,30,13);
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
$pdf->Cell(25,4,"FOR OCEAN FREIGHT",0);
/*$pdf->SetFont('Arial','',7);
$pdf->SetXY(155,40);
$pdf->Cell(25,4,"Invoice No:",0);*/

$pdf->SetXY(10,45);
$pdf->Cell(90,28,'',1);
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(11,46);
$pdf->Cell(25,4,"SHIPPER NAME AND ADDRESS:",0);
$pdf->SetFont('Arial','',8);
$pdf->SetXY(11,50);
$pdf->Cell(25,4,'EAM MALIBAN TEXTILES (PVT) LTD',0);
$pdf->SetXY(11,54);
$pdf->Cell(25,4,'NO 261, SIRI DHAMMA MAWATHA',0);
$pdf->SetXY(11,58);
$pdf->Cell(25,4,'COLOMBO 10',0);
$pdf->SetXY(11,62);
$pdf->Cell(25,4,'SRI LANKA',0);

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(100,45);
$pdf->Cell(40,4,'',1);
$pdf->SetXY(101,46);
$pdf->Cell(23,3,'PORT OF DISCHARGE',0);
$pdf->SetXY(140,45);

$pdf->SetFont('Arial','',8);
$pdf->Cell(65,4,$row_header['strCity'],1);
$pdf->SetFont('Arial','B',8);

$pdf->SetXY(100,49);
$pdf->Cell(40,4,'',1);
$pdf->SetXY(101,50);
$pdf->Cell(17,3,'FINAL DESTINATION',0);
$pdf->SetXY(140,49);
$pdf->Cell(65,4,'',1);
$pdf->SetXY(100,53);
$pdf->Cell(40,4,'',1);
$pdf->SetXY(101,54);
$pdf->Cell(20,3,'CARGO DELIVERED ON',0);
$pdf->SetXY(140,53);
$pdf->Cell(65,4,'',1);
$pdf->SetXY(100,57);
$pdf->Cell(40,4,'',1);
$pdf->SetXY(101,58);
$pdf->Cell(20,3,'VESSEL/VOYAGE',0);
$pdf->SetXY(140,57);
$pdf->Cell(65,4,'',1);
$pdf->SetXY(100,61);
$pdf->Cell(22,4,'',1);
$pdf->SetXY(101,62);
$pdf->MultiCell(21,3,'H.S. CODE#',0);
$pdf->SetXY(122,61);

$pdf->SetFont('Arial','',8);
$pdf->Cell(83,4,$row_header['strHSCode'],1);
$pdf->SetXY(100,65);
$pdf->SetFont('Arial','B',8);

$pdf->Cell(22,4,'',1);
$pdf->SetXY(101,66);
$pdf->MultiCell(21,3,'L.C. #',0);
$pdf->SetXY(122,65);
$pdf->Cell(83,4,'',1);
$pdf->SetXY(100,69);
$pdf->Cell(22,4,'',1);
$pdf->SetXY(101,70);
$pdf->Cell(20,3,'INVOICE #',0);
$pdf->SetXY(122,69);
$pdf->SetFont('Arial','',8);
$pdf->Cell(83,4,$InvoiceNo,1);
$pdf->SetFont('Arial','B',8);

$pdf->SetXY(10,73);
$pdf->Cell(90,22,'',1);
$pdf->SetXY(11,74);
$pdf->Cell(25,4,"CONSIGNEE NAME AND ADDRES",0);

$pdf->SetFont('Arial','',8);
$pdf->SetXY(11,78);
$pdf->Cell(25,4,$row_header['consigneeName'],0);

$pdf->SetXY(11,82);
$pdf->Cell(25,4,$row_header['consigneeAddress1'],0);

$pdf->SetXY(11,86);
$pdf->Cell(25,4,$row_header['consigneeAddress2'],0);

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(100,73);
$pdf->Cell(105,22,'',1);
$pdf->SetXY(101,74);
$pdf->Cell(25,4,"ALSO NOTIFY:",0);

$pdf->SetFont('Arial','',8);
$pdf->SetXY(101,82);
$pdf->Cell(25,4,"",0);


$pdf->SetFont('Arial','B',8);
$pdf->SetXY(10,95);
$pdf->Cell(90,20,'',1);
$pdf->SetXY(11,96);
$pdf->Cell(19,4,'NOTIFY:',0);
$pdf->SetXY(11,104);
$pdf->SetFont('Arial','',8);
$pdf->Cell(19,4,'SAME AS CONSIGNEE:',0);
$pdf->SetFont('Arial','B',8);

$pdf->SetXY(100,95);

$pdf->Cell(105,20,'',1);
$pdf->SetXY(101,96);
$pdf->Cell(25,4,"SPECIAL INSTRUCTION",0);

$pdf->SetXY(10,115);
$pdf->Cell(43,9,'',1);
$pdf->SetXY(19,116);
$pdf->MultiCell(20,4,"MARKS AND NUMBERS",0,'C');

$pdf->SetFont('Arial','',8);
$pdf->SetXY(11,124);
$pdf->Cell(20,4,$marks['strMMLine1'],0);
$pdf->SetXY(11,128);
$pdf->Cell(20,4,$marks['strMMLine2'],0);
$pdf->SetXY(11,132);
$pdf->Cell(20,4,$marks['strMMLine3'],0);
$pdf->SetXY(11,136);
$pdf->Cell(20,4,$marks['strMMLine4'],0);
$pdf->SetXY(11,140);
$pdf->Cell(20,4,$marks['strMMLine5'],0);
$pdf->SetXY(11,144);
$pdf->Cell(20,4,$marks['strMMLine6'],0);

$pdf->SetXY(11,152);
$pdf->Cell(20,4,$marks['strSMLine1'],0);
$pdf->SetXY(11,156);
$pdf->Cell(20,4,$marks['strSMLine2'],0);
$pdf->SetXY(11,160);
$pdf->Cell(20,4,$marks['strSMLine3'],0);
$pdf->SetXY(11,164);
$pdf->Cell(20,4,$marks['strSMLine4'],0);
$pdf->SetXY(11,168);
$pdf->Cell(20,4,$marks['strSMLine5'],0);
$pdf->SetXY(11,172);
$pdf->Cell(20,4,$marks['strSMLine6'],0);

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(53,115);
$pdf->Cell(27,9,'',1);
$pdf->SetXY(56,116);
$pdf->MultiCell(19,4,"NO OF CTNS/PCS",0,'C');

$pdf->SetFont('Arial','',8);
$pdf->SetXY(55,128);
$pdf->Cell(19,4,$row_header['dblQuantity'].' PCS',0);

$pdf->SetXY(55,136);
$pdf->Cell(19,4,$row_header['intNoOfCTns'].' CTNS',0);

$pdf->SetXY(80,115);
$pdf->Cell(74,9,'',1);
$pdf->SetXY(87,116);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(19,4,"NATURE AND QUANTITY OF GOODS",0,'C');
$pdf->SetXY(82,124);

$pdf->SetFont('Arial','',8);
$pdf->Cell(70,4,$row_header['strDescOfGoods'],0);
$pdf->SetXY(82,128);
$pdf->Cell(70,4,$row_header['strFabrication'],0);
$pdf->SetXY(82,136);
$pdf->Cell(70,4,"PO NO: ",0);
$pdf->SetXY(99,136);
$pdf->Cell(70,4,$row_header['strBuyerPONo'],0);
$pdf->SetXY(82,140);
$pdf->Cell(70,4,"STYLE NO: ",0);
$pdf->SetXY(99,140);
$pdf->Cell(70,4,$row_header['strStyleID'],0);

$pdf->SetXY(154,115);
$pdf->Cell(25,9,'',1);
$pdf->SetXY(154,116);

$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(26,4,"MEASUREMENTS AND CBM",0,'C');
$pdf->SetFont('Arial','',8);
$pdf->SetXY(154,128);
$pdf->Cell(30,4,$row_header['intCBM'],0);
$pdf->SetXY(164,128);
$pdf->Cell(30,4,"CBM",0);

$pdf->SetXY(179,115);
$pdf->Cell(26,9,'',1);
$pdf->SetXY(179,116);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(27,4,"WEIGHTS (KGS)",0,'C');

$pdf->SetFont('Arial','',8);
$pdf->SetXY(179,128);
$pdf->Cell(27,4,'GROSS WT',0);
$pdf->SetXY(179,132);
$pdf->Cell(27,4,$row_header['dblGrossMass'],0);

$pdf->SetXY(179,140);
$pdf->Cell(27,4,'NET WT',0);
$pdf->SetXY(179,144);
$pdf->Cell(27,4,$row_header['dblNetMass'],0);

$pdf->SetXY(10,124);
$pdf->Cell(43,60,'',1);

$pdf->SetXY(53,124);
$pdf->Cell(27,60,'',1);

$pdf->SetXY(80,124);
$pdf->Cell(74,60,'',1);

$pdf->SetXY(154,124);
$pdf->Cell(25,60,'',1);

$pdf->SetXY(179,124);
$pdf->Cell(26,60,'',1);


$pdf->SetFont('Arial','B',8);
$pdf->SetXY(10,184);
$pdf->Cell(195,80,'',1);

$pdf->SetXY(10,188);
$pdf->Cell(60,4,'',1);
$pdf->SetXY(10,188);
$pdf->Cell(20,4,'DOCUMENTS ATTACHED (Please Indicate)',0);

$pdf->SetXY(70,188);
$pdf->Cell(20,4,'',1);
$pdf->SetXY(70,188);
$pdf->Cell(20,4,'ORIGINAL',0);

$pdf->SetXY(90,188);
$pdf->Cell(20,4,'',1);
$pdf->SetXY(90,188);
$pdf->Cell(20,4,'COPIES',0);


$pdf->SetXY(10,192);
$pdf->Cell(60,4,'',1);
$pdf->SetXY(10,192);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(70,192);
$pdf->Cell(20,4,'',1);
$pdf->SetXY(70,192);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(90,192);
$pdf->Cell(20,4,'',1);
$pdf->SetXY(90,192);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(10,196);
$pdf->Cell(60,4,'',1);
$pdf->SetXY(10,196);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(70,196);
$pdf->Cell(20,4,'',1);
$pdf->SetXY(70,192);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(90,196);
$pdf->Cell(20,4,'',1);
$pdf->SetXY(90,196);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(10,200);
$pdf->Cell(60,4,'',1);
$pdf->SetXY(10,200);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(70,200);
$pdf->Cell(20,4,'',1);
$pdf->SetXY(70,200);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(90,200);
$pdf->Cell(20,4,'',1);
$pdf->SetXY(90,200);
$pdf->Cell(20,4,'',0);

//

$pdf->SetXY(10,204);
$pdf->Cell(60,4,'',1);
$pdf->SetXY(10,200);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(70,204);
$pdf->Cell(20,4,'',1);
$pdf->SetXY(70,200);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(90,204);
$pdf->Cell(20,4,'',1);
$pdf->SetXY(90,204);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(10,208);
$pdf->Cell(60,4,'',1);
$pdf->SetXY(10,208);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(70,208);
$pdf->Cell(20,4,'',1);
$pdf->SetXY(70,208);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(90,208);
$pdf->Cell(20,4,'',1);
$pdf->SetXY(90,208);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(10,212);
$pdf->Cell(60,4,'',1);
$pdf->SetXY(10,212);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(70,212);
$pdf->Cell(20,4,'',1);
$pdf->SetXY(70,212);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(90,212);
$pdf->Cell(20,4,'',1);
$pdf->SetXY(90,212);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(10,216);
$pdf->Cell(60,4,'',1);
$pdf->SetXY(10,216);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(70,216);
$pdf->Cell(20,4,'',1);
$pdf->SetXY(70,216);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(90,216);
$pdf->Cell(20,4,'',1);
$pdf->SetXY(90,216);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(10,220);
$pdf->Cell(60,4,'',1);
$pdf->SetXY(10,220);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(70,220);
$pdf->Cell(20,4,'',1);
$pdf->SetXY(70,220);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(90,220);
$pdf->Cell(20,4,'',1);
$pdf->SetXY(90,220);
$pdf->Cell(20,4,'',0);


$pdf->SetXY(10,224);
$pdf->Cell(60,4,'',1);
$pdf->SetXY(10,224);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(70,224);
$pdf->Cell(20,4,'',1);
$pdf->SetXY(70,224);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(90,224);
$pdf->Cell(20,4,'',1);
$pdf->SetXY(90,224);
$pdf->Cell(20,4,'',0);

$pdf->SetXY(115,230);
$pdf->Cell(30,4,'',1);
$pdf->SetXY(115,230);
$pdf->Cell(20,4,'OTHER',0);
$pdf->SetXY(115,234);
$pdf->Cell(30,4,'',1);
$pdf->SetXY(115,234);
$pdf->Cell(20,4,'OCEAN FREIGH',0);
$pdf->SetXY(115,238);
$pdf->Cell(30,4,'',1);
$pdf->SetXY(115,238);
$pdf->Cell(20,4,'HAZAROUS',0);

$pdf->SetXY(145,230);
$pdf->Cell(30,4,'',1);
$pdf->SetXY(145,230);
$pdf->Cell(20,4,'REMARKS (YES/NO)',0);
$pdf->SetXY(145,234);
$pdf->Cell(30,4,'',1);
$pdf->SetXY(145,238);
$pdf->Cell(30,4,'',1);


$pdf->SetXY(10,260);
$pdf->Cell(195,4,'',1);


}
$pdf->Output();
?>