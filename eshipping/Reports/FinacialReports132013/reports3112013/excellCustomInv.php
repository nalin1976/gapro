<?php
include "../../../Connector.php";
require_once('../../../excel/Classes/PHPExcel.php');
require_once('../../../excel/Classes/PHPExcel/IOFactory.php');

$checkDate	= $_GET["CheckDate"];
$dateFrom	= $_GET["DateFrom"];
$dateTo	    = $_GET["DateTo"];
$buyerId	= $_GET["BuyerId"];
$invoNoFrom	= $_GET["InvoNoFrom"];
$InvoNoTo	= $_GET["InvoNoTo"];



//echo $dateFrom;
$excel = new PHPExcel();
//$excel->createSheet(0);

$excel->setActiveSheetIndex(0);
$rowno = 6;
$no  = 1;
	$title = "CustomInv.xls";	
	$excel->getActiveSheet()->setTitle('Custom Invoice Register');
	$excel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowno,"No");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowno,"Invoice
No");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowno,"Factory");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowno,"Country");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowno,"Buyer");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowno,"Invoice Date");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowno,"Style No");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowno,"PO
NO");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowno,"PCS");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowno,"Currency");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(10,$rowno,"Gross Amt");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(11,$rowno,"CDN Quantity");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(12,$rowno,"CDN Amt");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(13,$rowno,"Final Inv Quantity");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(14,$rowno,"Final Inv Amt");



		  	$sql = "SELECT
					CIH.strInvoiceNo,
					MB.strMainBuyerName,
					date(CIH.dtmInvoiceDate) AS dtmInvoiceDate,
					CID.strStyleID,
					CID.strBuyerPONo,
					SUM(CID.dblQuantity) AS dblQuantity,
					CIH.strCurrency,
					MB.strCountry,
					CIH.strCompanyID,
					customers.strMLocation,
					SUM(CID.dblAmount) AS dblAmount,
					SUM(CID.dblGrossMass) AS grossAmount,
					B.strCountry AS buyerCountry
					FROM
					invoiceheader AS CIH
					INNER JOIN invoicedetail AS CID ON CIH.strInvoiceNo = CID.strInvoiceNo
					INNER JOIN buyers AS B ON B.strBuyerID = CIH.strBuyerID
					INNER JOIN buyers_main AS MB ON MB.intMainBuyerId = B.intMainBuyerId
					INNER JOIN customers ON customers.strCustomerID = CIH.intManufacturerId
where B.intMainBuyerId <> '' 
					 ";
	if($buyerId!="")
		$sql .= "and B.intMainBuyerId='$buyerId' ";
		
	if($checkDate==1)
		$sql .= "and date(CIH.dtmInvoiceDate) >='$dateFrom' and date(CIH.dtmInvoiceDate) <='$dateTo' ";
		
	/*if($invoNoFrom!="")
		$sql .= "and CIH.dtmInvoiceDate >='$dateFrom' and date(CIH.dtmInvoiceDate) <='$dateTo' ";*/
		
		$sql .= "GROUP BY CIH.strInvoiceNo ORDER BY CIH.strInvoiceNo";
$result = $db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
	
	$dtmDate = $row['dtmInvoiceDate'];
	
	$dtmDateArr = explode("-",$row['dtmInvoiceDate']);
	
	$formatDate = $dtmDateArr[2]."/".$dtmDateArr[1]."/".$dtmDateArr[0];
	
	$invoiceNo=$row["strInvoiceNo"];
	
	$sql_cdn="SELECT
				cdn_header.strInvoiceNo,
				ROUND(SUM(cdn_detail.dblQuantity),2) AS cdnQuantity,
				ROUND(SUM(cdn_detail.dblAmount),2) AS cdnAmount
				FROM
				cdn_header
				INNER JOIN cdn_detail ON cdn_detail.intCDNNo = cdn_header.intCDNNo
				WHERE cdn_header.strInvoiceNo = '$invoiceNo'
				GROUP BY cdn_header.strInvoiceNo
				 ";
				 
	$result_cdn = $db->RunQuery($sql_cdn);
	$row_cdn = mysql_fetch_array($result_cdn);
	
	$sql_Finv="SELECT
				ROUND(SUM(commercial_invoice_detail.dblQuantity),2) AS finvQuantity,
				ROUND(SUM(commercial_invoice_detail.dblAmount),2) AS finvAmount
				FROM
				commercial_invoice_header
				INNER JOIN commercial_invoice_detail ON commercial_invoice_detail.strInvoiceNo = commercial_invoice_header.strInvoiceNo
				WHERE commercial_invoice_header.strInvoiceNo = '$invoiceNo'
				GROUP BY commercial_invoice_header.strInvoiceNo
				 ";
				 
	$result_Finv = $db->RunQuery($sql_Finv);
	$row_Finv = mysql_fetch_array($result_Finv);
	
	
	
				$totQuantity		+= round($row["dblQuantity"],0);
				$totGrossAmount		+= round($row["grossAmount"],2);
				$totDiscount		+= round($row["discount"],2);
				$totNetAmount		+= round($row["netAmount"],2);
	  $rowno++;
	  
$excel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowno,$no++);
	  
$excel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowno,$row['strInvoiceNo']);
	  

	  $excel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowno,$row['strMLocation']);
	  $excel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowno,$row['buyerCountry']);
	  $excel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowno,$row['strMainBuyerName']);
	  
$excel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowno,$formatDate);
	  
$excel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowno,$row['strStyleID']);
	  
$excel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowno,$row['strBuyerPONo']);
	  
$excel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowno,$row['dblQuantity']);

$excel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowno,$row['strCurrency']);
       
$excel->getActiveSheet()->setCellValueByColumnAndRow(10,$rowno,$row['dblAmount']);

$excel->getActiveSheet()->setCellValueByColumnAndRow(11,$rowno,$row_cdn["cdnQuantity"]);

$excel->getActiveSheet()->setCellValueByColumnAndRow(12,$rowno,$row_cdn["cdnAmount"]);

$excel->getActiveSheet()->setCellValueByColumnAndRow(13,$rowno,$row_Finv["finvQuantity"]);

$excel->getActiveSheet()->setCellValueByColumnAndRow(14,$rowno,$row_Finv["finvAmount"]);
			}
			
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$title.'"');
header('Cache-Control: max-age=10');

$Writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5'); $Writer->save('php://output'); 

			
?>