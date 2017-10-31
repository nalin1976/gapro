<?php
include "../../Connector.php";
require_once('../../excel/Classes/PHPExcel.php');
require_once('../../excel/Classes/PHPExcel/IOFactory.php');

$checkDate	= $_GET["CheckDate"];
$dateFrom	= $_GET["DateFrom"];
$dateTo	    = $_GET["DateTo"];
$buyerId	= $_GET["BuyerId"];
$invoNoFrom	= $_GET["InvoNoFrom"];
$InvoNoTo	= $_GET["InvoNoTo"];

$vessalName = $_GET['vessalName'];
$cdnDocNo = $_GET['cdnDocNo'];
//echo $dateFrom;
$excel = new PHPExcel();
//$excel->createSheet(0);

$excel->setActiveSheetIndex(0);
$rowno = 6;
$no  = 1;
	$title = "FCLReport.xls";	
	$excel->getActiveSheet()->setTitle('FCL');
	$excel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowno,"No");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowno,"Entry
No");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowno,"Style No");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowno,"PO No");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowno,"CTN");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowno,"Qty");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowno,"Item");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowno,"Gross
Wt");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowno,"Factory");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowno,"Invoice No");


		  	$sql = "SELECT
ROUND(SUM(cdn_detail.dblQuantity),2) AS dblQuantity,
Sum(cdn_detail.intNoOfCTns) AS intNoOfCTns,
ROUND(SUM(cdn_detail.dblGrossMass),2) AS dblGrossMass,
cdn_detail.strDescOfGoods,
cdn_detail.strBuyerPONo,
cdn_header.strVessel,
cdn_detail.strStyleID,
cdn_header.strCustomesEntry,
customers.strMLocation,
cdn_header.strInvoiceNo
FROM
cdn_header
INNER JOIN cdn_detail ON cdn_detail.intCDNNo = cdn_header.intCDNNo
INNER JOIN invoiceheader ON invoiceheader.strInvoiceNo = cdn_header.strInvoiceNo
INNER JOIN customers ON customers.strCustomerID = invoiceheader.intManufacturerId
WHERE cdn_header.intCDNNo!='' 
					 ";
	if($cdnDocNo!="")
		$sql .= "and cdn_header.intCdnDocNo='$cdnDocNo' ";
		
	if($checkDate==1)
		$sql .= "and cdn_header.strVessel = '$vessalName' ";
		
	/*if($invoNoFrom!="")
		$sql .= "and CIH.dtmInvoiceDate >='$dateFrom' and date(CIH.dtmInvoiceDate) <='$dateTo' ";*/
		
		$sql .= "GROUP BY cdn_header.intCDNNo";
$result = $db->RunQuery($sql);
while($row = mysql_fetch_array($result))
{
	  $rowno++;
	  
$excel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowno,$no++);
	  
$excel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowno,$row['strCustomesEntry']);
	  

	  $excel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowno,$row['strStyleID']);
	  $excel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowno,$row['strBuyerPONo']);
	  $excel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowno,$row['intNoOfCTns']);
	  
$excel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowno,$row['dblQuantity']);
	  
$excel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowno,$row['strDescOfGoods']);
	  
$excel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowno,$row['dblGrossMass']);
	  
$excel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowno,$row['strMLocation']);

$excel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowno,$row['strInvoiceNo']);
			}
			
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$title.'"');
header('Cache-Control: max-age=10');

$Writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5'); $Writer->save('php://output'); 

			
?>