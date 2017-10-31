<?php
include "../../../Connector.php";
require_once('../../../excel/Classes/PHPExcel.php');
require_once('../../../excel/Classes/PHPExcel/IOFactory.php');

$dateFrom	= $_GET["DateFrom"];
$dateTo	    = $_GET["DateTo"];
$buyerId	= $_GET["BuyerId"];
//echo $dateFrom;
$excel = new PHPExcel();
//$excel->createSheet(0);

$excel->setActiveSheetIndex(0);
$rowno = 6;
$no  = 1;
	$title = "FinalInv.xls";	
	$excel->getActiveSheet()->setTitle('Final Invoice Register');
	$excel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowno,"No");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowno,"Invoice
No");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowno,"Buyer
Name");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowno,"Factory");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowno,"Country");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowno,"Invoice Date");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowno,"Style No");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowno,"PO
NO");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowno,"PCS");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowno,"Gross Amt");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(10,$rowno,"Discount");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(11,$rowno,"Net Amt");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(12,$rowno,"Receipt No");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(13,$rowno,"Receipt Date");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(14,$rowno,"Discount No");
	$excel->getActiveSheet()->setCellValueByColumnAndRow(15,$rowno,"Discount Date");


	$sql = "SELECT
CIH.strInvoiceNo,
CIH.dtmInvoiceDate,
CID.strStyleID,
CID.strBuyerPONo,
CID.dblQuantity,
CIH.strCurrency,
SUM(CID.dblAmount+F.dblFreight+F.dblInsurance+F.dblDestCharge) AS grossAmount,
SUM(F.dblDiscount) AS discount,
SUM(CID.dblAmount+F.dblFreight+F.dblInsurance+F.dblDestCharge-F.dblDiscount) AS netAmount,
buyers_main.strMainBuyerName,
CIH.dtmDiscReceiptDate,
CIH.dtmDiscountDate,
customers.strMLocation
FROM
commercial_invoice_header AS CIH
INNER JOIN commercial_invoice_detail AS CID ON CIH.strInvoiceNo = CID.strInvoiceNo
INNER JOIN finalinvoice AS F ON CIH.strInvoiceNo = F.strInvoiceNo
INNER JOIN buyers ON buyers.strBuyerID = CIH.strBuyerID
INNER JOIN buyers_main ON buyers_main.intMainBuyerId = buyers.intMainBuyerId
INNER JOIN customers ON customers.strCustomerID = CIH.strCompanyID
GROUP BY CIH.strInvoiceNo, strBuyerPONo
";

		if($checkDate==1)
		$sql.= "and date(CIH.dtmInvoiceDate) >='$dateFrom' and date(CIH.dtmInvoiceDate) <='$dateTo' ";
			//echo $sql;
			$result = $db->RunQuery($sql);
			$totQuantity 	= 0;
			$totGrossAmount	= 0;
			$totDiscount	= 0;
			$totNetAmount	= 0;
			while($row = mysql_fetch_array($result))
			{
				$totQuantity		+= round($row["dblQuantity"],0);
				$totGrossAmount		+= round($row["grossAmount"],2);
				$totDiscount		+= round($row["discount"],2);
				$totNetAmount		+= round($row["netAmount"],2);
	  $rowno++;
	  
$excel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowno,$no++);
	  
$excel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowno,$row['strInvoiceNo']);
	  
$excel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowno,$row['strMainBuyerName']);
	  $excel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowno,$row['strMLocation']);
	  $excel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowno,'');
	  
$excel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowno,$row['dtmInvoiceDate']);
	  
$excel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowno,$row['strStyleID']);
	  
$excel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowno,$row['strBuyerPONo']);
	  
$excel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowno,number_format($row['dblQuantity'],0));
       
$excel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowno,number_format($row['grossAmount'],2));
	  
$excel->getActiveSheet()->setCellValueByColumnAndRow(10,$rowno,number_format($row['discount'],2));

$excel->getActiveSheet()->setCellValueByColumnAndRow(11,$rowno,number_format($row['netAmount'],2));

$excel->getActiveSheet()->setCellValueByColumnAndRow(12,$rowno,'');

$excel->getActiveSheet()->setCellValueByColumnAndRow(13,$rowno,$row['dtmDiscReceiptDate']);

$excel->getActiveSheet()->setCellValueByColumnAndRow(14,$rowno,'');

$excel->getActiveSheet()->setCellValueByColumnAndRow(15,$rowno,$row['dtmDiscReceiptDate']);
			}
			
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$title.'"');
header('Cache-Control: max-age=10');

$Writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5'); $Writer->save('php://output'); 

			
?>