<?php
session_start();
include "../../../Connector.php";

$mainId	= '';

//global $objPHPExcel;
error_reporting(E_ALL);
require_once '../../../excel/Classes/PHPExcel.php';
require_once '../../../excel/Classes/PHPExcel/IOFactory.php';

//		get template
$file = 'stock.xls';
if (!file_exists($file)) {
	exit("Can't find $fileName");
}
$objPHPExcel = PHPExcel_IOFactory::load($file);
//////////////////////////////////////////////// end of load template //////////////////////////////////

$mainId		= $_GET["mainId"];
$subId		= $_GET["subId"];
$matItem	= $_GET["maiItem"];
$color		= $_GET["color"];
$size		= $_GET["size"];
$style		= $_GET["style"];
$mainStores	= $_GET["mainStores"];
$with0		= $_GET["with0"];
$x			= $_GET["x"];
$dfrom		= $_GET["dfrom"];
$dTo		= $_GET["dTo"];
			//concat(specification.intSRNO,'-',matitemlist.intItemSerial) as materialRatioID,
#==========================================================
/* Date - 11/17/2014
   Changed By - Nalin Jayakody
   Description - Round function add the query for avoid to display 
				 qty<0.00001 unnecessary fractional parts
 */
#==========================================================			
			
$SQL = 	"SELECT
materialratio.materialRatioID,
matitemlist.strItemDescription,
mainstores.strName,
stocktransactions.strColor,
stocktransactions.strSize,
Round(Sum(stocktransactions.dblQty),2) AS balance,
matmaincategory.strDescription,
stocktransactions.strUnit,
buyers.strName AS BuyerName
FROM
materialratio
Inner Join matitemlist ON matitemlist.intItemSerial = materialratio.strMatDetailID
Inner Join stocktransactions ON materialratio.intStyleId = stocktransactions.intStyleId AND materialratio.strMatDetailID = stocktransactions.intMatDetailId AND materialratio.strColor = stocktransactions.strColor AND materialratio.strSize = stocktransactions.strSize AND materialratio.strBuyerPONO = stocktransactions.strBuyerPoNo
Inner Join mainstores ON stocktransactions.strMainStoresID = mainstores.strMainID
Inner Join matmaincategory ON matmaincategory.intID = matitemlist.intMainCatID
Inner Join orders ON materialratio.intStyleId = orders.intStyleId
Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID
WHERE
stocktransactions.strMainStoresID =  '$mainStores'";
		    if($mainId!='')
				$SQL1 .=" and matitemlist.intMainCatID =$mainId ";	
			if($subId!='')
				$SQL1 .=" and matitemlist.intSubCatID =  '$subId' ";
			if($matItem!='')
				$SQL1 .=" and stocktransactions.intMatDetailId =$matItem ";	
			if($color!='')
				$SQL1 .=" and stocktransactions.strColor ='$color' ";
			if($dfrom!='')
				$SQL1 .=" and DATE(stocktransactions.dtmDate) >='$dfrom' ";
			if($dTo!='')
				$SQL1 .=" and DATE(stocktransactions.dtmDate) <='$dTo' ";
			if($size!='')
				$SQL1 .=" and stocktransactions.strSize ='$size' ";	
			if($style!='')
				$SQL1 .=" and stocktransactions.intStyleId ='$style' ";			
			if($x=='running')
				$SQL1 .=" and orders.intStatus=11 ";
			if($x=='leftOvers')
				$SQL1 .=" and orders.intStatus=13 ";
				
			/*$SQL2 = " GROUP BY
						st.strStyleNo,
						st.intMatDetailId,
						st.strBuyerPoNo,
						st.strColor,
						st.strSize
					ORDER BY
					specification.intSRNO,matitemlist.strItemDescription,st.strColor,st.strSize ASC";*/
			$SQL2 = " GROUP BY materialratio.materialRatioID, matitemlist.strItemDescription, mainstores.strName, stocktransactions.strColor, 
stocktransactions.strSize,
matmaincategory.strDescription	";

			if($with0 == 'false'){
			 $SQL3 = " HAVING Round(Sum(stocktransactions.dblQty),2) >= 1 ";
				
			}
					
			$SQL = $SQL.$SQL1.$SQL2.$SQL3;	
			
//echo $SQL;			
					
$result = $db->RunQuery($SQL);
$i=6;

$objPHPExcel->getActiveSheet()->insertNewRowBefore($i+1,mysql_num_rows($result)+1);

while($row = mysql_fetch_array($result))
{
	
	if($row['balance']<0)
		$balance = 0;
	else
		$balance = $row['balance'];
	
	if(!($with0=="false" && $balance ==0))
	{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$row['strDescription']);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$row['materialRatioID']);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$row['BuyerName']);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$row['strItemDescription']);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$row['strColor']);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,$row['strSize']);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$row['strName']);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i,$row['strUnit']);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$i,$balance);
	$i++;
	}
}

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,3,date('Y-m-d'));
///////////////////////////////////////////////// download file //////////////////////////
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$file.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
echo 'done';
exit;
?>