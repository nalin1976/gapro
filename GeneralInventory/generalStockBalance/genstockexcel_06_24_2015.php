<?php
session_start();
include "../../Connector.php" ;

$companyId = $_GET["factoryCode"];
$dt_date = $_GET["dtdate"];
$mainCode = $_GET["mainCode"];

error_reporting(E_ALL);
require_once '../../excel/Classes/PHPExcel.php';
require_once '../../excel/Classes/PHPExcel/IOFactory.php';

//		get template
$fileName = 'generalStockReport.xls';
if (!file_exists($fileName)) {
	exit("Can't find $fileName");
}

$objPHPExcel = PHPExcel_IOFactory::load($fileName);

$i = 6;

$sql = " SELECT
genmatmaincategory.strDescription,
genmatsubcategory.StrCatName,
genmatitemlist.strItemCode,
genmatitemlist.strItemDescription,
mainstores.strName,
genmatitemlist.strUnit,
Sum(genstocktransactions.dblQty) AS StockBalQty
FROM
genmatmaincategory
Inner Join genmatitemlist ON genmatmaincategory.intID = genmatitemlist.intMainCatID
Inner Join genmatsubcategory ON genmatsubcategory.intSubCatNo = genmatitemlist.intSubCatID
Inner Join genstocktransactions ON genmatitemlist.intItemSerial = genstocktransactions.intMatDetailId
Inner Join mainstores ON mainstores.strMainID = genstocktransactions.strMainStoresID
WHERE mainstores.intCompanyId = '$companyId'";

if($mainCode != '')
	$sql .= " and genmatmaincategory.intID = '$mainCode'";

if($dt_date != '')
	$sql .= " and genstocktransactions.dtmDate <= '$dt_date'";
	
	
$sql .= " GROUP BY
genmatmaincategory.strDescription,
genmatsubcategory.StrCatName,
genmatitemlist.strItemCode,
genmatitemlist.strItemDescription,
mainstores.strName,
genmatitemlist.strUnit
HAVING
Sum(genstocktransactions.dblQty) >0";

//echo $sql;

if($dt_date!='')
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,3,$dt_date);
else
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,3,date("Y-m-d"));	

$result = $db->RunQuery($sql);

while($row_results=mysql_fetch_array($result)){
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$row_results['strDescription']);		
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$row_results['StrCatName']);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$row_results['strItemCode']);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$row_results['strItemDescription']);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$row_results['strName']);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$row_results['strUnit']);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,$row_results['StockBalQty']);
	//$objPHPExcel->getDefaultStyle()->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	
	//$objPHPExcel->getActiveSheet()->getStyle("A".$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	
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
	//======================================================================================================
	
	$i++;
	
}

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i+2,"Physically checked By: ………………………………");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i+4,"Signature of Store Keeper : ………………………");


$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i+2,"Signature of Head of Stores  : .........................");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i+4,"Signature of Auditor : .......................");


$ti=date('H:i:s'); $ti1=strtotime("+330 minutes", strtotime($ti)); 
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i+8,"Date :".date("Y-m-d")."  ". date("H:i:s", $ti1)."   User ID :".GetUserName());

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