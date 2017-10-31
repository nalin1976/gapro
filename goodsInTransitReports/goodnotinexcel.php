<?php

session_start();
include "../Connector.php" ;

$mainStoresCode = $_GET["storescode"];
$GatePassNo		= $_GET["GatePassNo"];
$chkBox			= $_GET["chkBox"];
$mainStores 	= $_GET["mainStore"];

$i=6;

error_reporting(E_ALL);
require_once '../excel/Classes/PHPExcel.php';
require_once '../excel/Classes/PHPExcel/IOFactory.php';

//		get template
$fileName = 'gatepassnotinReport.xls';
if (!file_exists($fileName)) {
	exit("Can't find $fileName");
}

$objPHPExcel = PHPExcel_IOFactory::load($fileName);

$dt_date = date("Y-m-d");

$SQL1="SELECT
gatepassdetails.intGatePassNo,
gatepassdetails.intGPYear,
orders.strStyle,
materialratio.materialRatioID,
gatepassdetails.intMatDetailId,
gatepassdetails.strColor,
gatepassdetails.strSize,
gatepassdetails.dblQty,
gatepassdetails.dblBalQty,
(gatepassdetails.dblQty-gatepassdetails.dblBalQty)AS TIqty,
mainstores.strName,
mainTo.strName AS transTo,
mainFrom.dtmDate,
matitemlist.strItemDescription,
stocktransactions.dblQty AS tranQty
FROM gatepassdetails Left Join stocktransactions ON gatepassdetails.intGatePassNo = stocktransactions.intDocumentNo AND gatepassdetails.intGPYear = stocktransactions.intDocumentYear AND gatepassdetails.intStyleId = stocktransactions.intStyleId AND gatepassdetails.strBuyerPONO = stocktransactions.strBuyerPoNo AND gatepassdetails.intMatDetailId = stocktransactions.intMatDetailId AND gatepassdetails.strColor = stocktransactions.strColor AND gatepassdetails.strSize = stocktransactions.strSize Inner Join mainstores ON stocktransactions.strMainStoresID = mainstores.strMainID Inner Join gatepass AS mainFrom ON mainFrom.intGatePassNo = gatepassdetails.intGatePassNo AND mainFrom.intGPYear = gatepassdetails.intGPYear Inner Join mainstores AS mainTo ON mainTo.strMainID = mainFrom.strTo Inner Join matitemlist ON matitemlist.intItemSerial = gatepassdetails.intMatDetailId
Inner Join orders ON orders.intStyleId = gatepassdetails.intStyleId
Inner Join materialratio ON materialratio.intStyleId = gatepassdetails.intStyleId AND materialratio.strMatDetailID = gatepassdetails.intMatDetailId AND materialratio.strColor = gatepassdetails.strColor AND materialratio.strSize = gatepassdetails.strSize AND materialratio.strBuyerPONO = gatepassdetails.strBuyerPONO
WHERE 
mainFrom.intStatus = '1'";

if($mainStoresCode != ""){
$SQL1.=" AND stocktransactions.strMainStoresID = '$mainStoresCode'";
}
if($chkBox == '0'){
$SQL1.=" AND gatepassdetails.dblBalQty> '0'";
}
if($chkBox == '1'){
$SQL1.=" AND gatepassdetails.dblQty =  gatepassdetails.dblBalQty";
}
if($GatePassNo != ''){
$SQL1.=" AND gatepassdetails.intGatePassNo = '$GatePassNo'";
}
$SQL1.=" ORDER BY gatepassdetails.intGatePassNo";


$result = $db->RunQuery($SQL1);

//echo $SQL1;

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,2,$dt_date);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,3,$mainStores);

while($row = mysql_fetch_array($result)){
	
	if(number_format($row['dblBalQty'],2)>0){
	
		$gpNo 	= $row['intGPYear']."/".$row['intGatePassNo'];
		
		$gpQty	= $row['dblQty'];
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$gpNo);		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$row['dtmDate']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$row['strItemDescription']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$row['materialRatioID']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$row['strStyle']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,$row['strColor']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$row['strSize']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,$gpQty);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i,$row['transTo']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$i,$row['TIqty']);	
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$i,$row['dblBalQty']);
		
		//======================================================================================================
		// Row Formatting
		//======================================================================================================	
		$objPHPExcel->getActiveSheet()->getStyle("A".$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle("A".$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->getStyle("B".$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle("B".$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->getStyle("C".$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle("C".$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->getStyle("D".$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle("D".$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->getStyle("E".$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle("E".$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->getStyle("F".$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle("F".$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->getStyle("G".$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle("G".$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->getStyle("H".$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle("H".$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->getStyle("I".$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle("I".$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->getStyle("J".$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle("J".$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->getStyle("K".$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle("K".$i)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	//======================================================================================================
		
		$i++;
	}	
}


$ti=date('H:i:s'); $ti1=strtotime("+330 minutes", strtotime($ti)); 
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i+3,"Date :".date("Y-m-d")."  ". date("H:i:s", $ti1)."   User ID :".GetUserName());

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$fileName.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
echo 'done';
exit;


function GetUserName(){
	
	global $db;
	
	$SQL = "select Name from useraccounts where intUserID  =" . $_SESSION["UserID"] ;
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		return $row["Name"];
	}	
	
}

?>