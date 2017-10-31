<?php
session_start();
include "Connector.php" ;

error_reporting(E_ALL);
require_once 'excel/Classes/PHPExcel.php';
require_once 'excel/Classes/PHPExcel/IOFactory.php';

$iDeliveryLocation = $_GET['delTo'];


$iStyleId = $_GET['scno'];
$iSupplierId = $_GET['supplier'];
$iStatus = $_GET['status'];
$delfrom = $_GET['delFrom'];
$delto = $_GET['delTo'];

$file = 'purchaseorderrpt.xls';
if (!file_exists($file)) {
	exit("Can't find $file");
}

$arrDateFrom = preg_split('/[\s,\/\/]/',$delfrom);
$arrDateTo = preg_split('/[\s,\/\/]/',$delto);

$delfrom = $arrDateFrom[2]."-".$arrDateFrom[1]."-".$arrDateFrom[0];
$delto = $arrDateTo[2]."-".$arrDateTo[1]."-".$arrDateTo[0];

$styleArray = array('borders'=>array('allborders'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN)));
$styleArrayFontBold = array('font'=>array('bold'=>true));


$iRow = 5;



$objPHPExcel = PHPExcel_IOFactory::load($file);

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,1,"PURCHASE ORDER DETAILS REPORT ");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,2,"Delivery From : $delfrom To : $delto ");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,4,"PO Number");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,4,"Supplier");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,4,"SC NO");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,4,"Style ID");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,4,"Main Category");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,4,"Item Description");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,4,"Color");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,4,"Size");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,4,"Item Qty");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,4,"Item Value");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,4,"Delivery Date");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,4,"Delivery To");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,4,"Created User");


$sql = " SELECT purchaseorderheader.intYear, purchaseorderheader.intPONo, specification.intSRNO, orders.strStyle, suppliers.strTitle, ".
       "        matitemlist.strItemDescription, purchaseorderdetails.strColor, purchaseorderdetails.strSize, purchaseorderdetails.dblQty, ".
	   "        purchaseorderdetails.dblUnitPrice, purchaseorderheader.dtmDeliveryDate, useraccounts.Name AS POUser, ".
	   "        (SELECT strComCode FROM companies WHERE intCompanyID = purchaseorderheader.intDelToCompID ) AS delTo, ".
	   "        matmaincategory.strDescription".
       " FROM   purchaseorderheader Inner Join purchaseorderdetails ON purchaseorderheader.intPONo = purchaseorderdetails.intPoNo AND ".
	   "        purchaseorderheader.intYear = purchaseorderdetails.intYear Inner Join materialratio ON purchaseorderdetails.intStyleId = ".
	   "        materialratio.intStyleId AND purchaseorderdetails.intMatDetailID = materialratio.strMatDetailID AND ". 
	   "        purchaseorderdetails.strColor = materialratio.strColor AND purchaseorderdetails.strSize = materialratio.strSize AND ".
	   "        purchaseorderdetails.strBuyerPONO = materialratio.strBuyerPONO Inner Join specificationdetails ON " .
	   "        materialratio.intStyleId = specificationdetails.intStyleId AND materialratio.strMatDetailID = " .
	   "        specificationdetails.strMatDetailID Inner Join specification ON specificationdetails.intStyleId = specification.intStyleId ".
	   "        Inner Join orders ON specification.intStyleId = orders.intStyleId Inner Join suppliers ON purchaseorderheader.strSupplierID = ".
	   "        suppliers.strSupplierID Inner Join matitemlist ON purchaseorderdetails.intMatDetailID = matitemlist.intItemSerial ".
	   "        Inner Join useraccounts ON purchaseorderheader.intUserID = useraccounts.intUserID ".
	   "        Inner Join matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID ".
	   " WHERE  purchaseorderheader.intStatus =  '$iStatus' AND purchaseorderheader.dtmDeliveryDate BETWEEN  '$delfrom' AND '$delto' ";
	   
	   	if($iStyleId !='Select One')
	   		$sql .= " AND orders.intStyleId = '$iStyleId' ";
		
		if($iSupplierId != 'Select One')
			$sql .= " AND suppliers.strSupplierID = '$iSupplierId' ";
		
		
	   		$sql .= " ORDER BY purchaseorderheader.intPONo ASC ";
	   
  //echo $sql;

		$resPurchaseOrderDetails = $db->RunQuery($sql);
		
		//echo mysql_num_rows($resPurchaseOrderDetails);
		
		while($rowDetails = mysql_fetch_array($resPurchaseOrderDetails)){
			
			$_dblItemValue = 0;
			$_dblItemValue = (float)($rowDetails['dblQty'] * $rowDetails['dblUnitPrice']);
			
			$arrPODeliveryDate = preg_split('/[\s,-]/', $rowDetails['dtmDeliveryDate']);
			$_dtDelivery = $arrPODeliveryDate[2]."/".$arrPODeliveryDate[1]."/".$arrPODeliveryDate[0]; 
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$iRow,$rowDetails['intYear']."/".$rowDetails['intPONo']);		
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$iRow,$rowDetails['strTitle']);		
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$iRow,$rowDetails['intSRNO']);		
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$iRow,$rowDetails['strStyle']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$iRow,$rowDetails['strDescription']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$iRow,$rowDetails['strItemDescription']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$iRow,$rowDetails['strColor']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$iRow,$rowDetails['strSize']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$iRow,$rowDetails['dblQty']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$iRow,$_dblItemValue);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$iRow,$_dtDelivery);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$iRow,$rowDetails['delTo']);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$iRow,$rowDetails['POUser']);
			
			//echo $rowDetails['intYear']."/".$rowDetails['intPONo']."<br />"; 
			
			$iRow++;	
		}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$file.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
echo 'done';
exit;


?>