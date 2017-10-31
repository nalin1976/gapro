<?php
session_start();
include "../../Connector.php" ;
include "../../helasite/ConnectorHelaSite.php";

$_scno = '';
$_styleno = '';

$iStyleId = $_GET['StyleNo'];
$booWith0 = $_GET['with0'];
$iMainStores = $_GET['mainStores'];
	
error_reporting(E_ALL);
require_once '../../excel/Classes/PHPExcel.php';
require_once '../../excel/Classes/PHPExcel/IOFactory.php';

$styleArray = array('borders'=>array('allborders'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN)));
$styleArrayFontBold = array('font'=>array('bold'=>true));

//		get template
$file = 'orderrecociliation.xls';
if (!file_exists($file)) {
	exit("Can't find $fileName");
}

#==== Get Order header information ==========================
#============================================================
	
$sqlOrderHeader = " SELECT specification.intSRNO, orders.strStyle, buyers.strName, useraccounts.Name 
FROM
orders
Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID
Inner Join specification ON orders.intStyleId = specification.intStyleId
Inner Join useraccounts ON orders.intCoordinator = useraccounts.intUserID
WHERE
orders.intStyleId = '$iStyleId'";

$resOrderHeader = $db->RunQuery($sqlOrderHeader);

while($rowOrderHeader=mysql_fetch_array($resOrderHeader)){
	
	$_scno = $rowOrderHeader['intSRNO'];
	$_styleno = $rowOrderHeader['strStyle'];
	$_sbuyername = $rowOrderHeader['strName'];
	$_smerchant = $rowOrderHeader['Name'];
	
}
#============================================================================	

$dtShipDate = GetLastShipCompletedDate($_scno);


$objPHPExcel = PHPExcel_IOFactory::load($file);
$iStoresCell = 7;
$iHeaderRowNum = 9;
$i = 10;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,1,"LEFT OVER STOCKS REPORT ");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,3,"SC : $_scno ");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,3,"Style No : $_styleno ");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,4,"Buyer Name : $_sbuyername ");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,5,"Last Shippment Flaged : $dtShipDate ");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,6,"Merchandiser : $_smerchant");



#============================================================================	
# Get stores locations for style	
#============================================================================	

$sqlStores = " SELECT DISTINCT mainstores.strName, mainstores.strMainID, mainstores.intCompanyId
FROM
stocktransactions
Inner Join mainstores ON stocktransactions.strMainStoresID = mainstores.strMainID
WHERE
stocktransactions.intStyleId = '$iStyleId'
GROUP BY  mainstores.strMainID, mainstores.strName, mainstores.intCompanyId
HAVING SUM(dblQty)>0";

$resStores = $db->RunQuery($sqlStores);

while($rowStores=mysql_fetch_array($resStores)){
		
	$iStoresId = $rowStores['strMainID'];
	$sStores = $rowStores['strName'];
	$iCompanyId = $rowStores['intCompanyId'];
	
	$objPHPExcel->getActiveSheet()->getStyle('A'.$iHeaderRowNum)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$iHeaderRowNum)->applyFromArray($styleArrayFontBold);		
	$objPHPExcel->getActiveSheet()->getStyle('B'.$iHeaderRowNum)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$iHeaderRowNum)->applyFromArray($styleArrayFontBold);	
	$objPHPExcel->getActiveSheet()->getStyle('C'.$iHeaderRowNum)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$iHeaderRowNum)->applyFromArray($styleArrayFontBold);	
	$objPHPExcel->getActiveSheet()->getStyle('D'.$iHeaderRowNum)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('D'.$iHeaderRowNum)->applyFromArray($styleArrayFontBold);	
	$objPHPExcel->getActiveSheet()->getStyle('E'.$iHeaderRowNum)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('E'.$iHeaderRowNum)->applyFromArray($styleArrayFontBold);	
	$objPHPExcel->getActiveSheet()->getStyle('F'.$iHeaderRowNum)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('F'.$iHeaderRowNum)->applyFromArray($styleArrayFontBold);	
	$objPHPExcel->getActiveSheet()->getStyle('G'.$iHeaderRowNum)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('G'.$iHeaderRowNum)->applyFromArray($styleArrayFontBold);	
	$objPHPExcel->getActiveSheet()->getStyle('H'.$iHeaderRowNum)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('H'.$iHeaderRowNum)->applyFromArray($styleArrayFontBold);	
	$objPHPExcel->getActiveSheet()->getStyle('I'.$iHeaderRowNum)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('I'.$iHeaderRowNum)->applyFromArray($styleArrayFontBold);	
	$objPHPExcel->getActiveSheet()->getStyle('J'.$iHeaderRowNum)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('J'.$iHeaderRowNum)->applyFromArray($styleArrayFontBold);	
	$objPHPExcel->getActiveSheet()->getStyle('K'.$iHeaderRowNum)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('K'.$iHeaderRowNum)->applyFromArray($styleArrayFontBold);	
	$objPHPExcel->getActiveSheet()->getStyle('L'.$iHeaderRowNum)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('L'.$iHeaderRowNum)->applyFromArray($styleArrayFontBold);	
	$objPHPExcel->getActiveSheet()->getStyle('M'.$iHeaderRowNum)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('M'.$iHeaderRowNum)->applyFromArray($styleArrayFontBold);	
	$objPHPExcel->getActiveSheet()->getStyle('N'.$iHeaderRowNum)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('N'.$iHeaderRowNum)->applyFromArray($styleArrayFontBold);	
	$objPHPExcel->getActiveSheet()->getStyle('O'.$iHeaderRowNum)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('O'.$iHeaderRowNum)->applyFromArray($styleArrayFontBold);	
	$objPHPExcel->getActiveSheet()->getStyle('P'.$iHeaderRowNum)->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('P'.$iHeaderRowNum)->applyFromArray($styleArrayFontBold);	
	
	$objPHPExcel->getActiveSheet()->getStyle('A'.$iHeaderRowNum)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D9D9D9'))));	
	$objPHPExcel->getActiveSheet()->getStyle('B'.$iHeaderRowNum)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D9D9D9'))));
	$objPHPExcel->getActiveSheet()->getStyle('C'.$iHeaderRowNum)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D9D9D9'))));
	$objPHPExcel->getActiveSheet()->getStyle('D'.$iHeaderRowNum)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D9D9D9'))));
	$objPHPExcel->getActiveSheet()->getStyle('E'.$iHeaderRowNum)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D9D9D9'))));
	$objPHPExcel->getActiveSheet()->getStyle('F'.$iHeaderRowNum)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D9D9D9'))));
	$objPHPExcel->getActiveSheet()->getStyle('G'.$iHeaderRowNum)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D9D9D9'))));
	$objPHPExcel->getActiveSheet()->getStyle('H'.$iHeaderRowNum)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D9D9D9'))));
	$objPHPExcel->getActiveSheet()->getStyle('I'.$iHeaderRowNum)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D9D9D9'))));
	$objPHPExcel->getActiveSheet()->getStyle('J'.$iHeaderRowNum)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D9D9D9'))));
	$objPHPExcel->getActiveSheet()->getStyle('K'.$iHeaderRowNum)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D9D9D9'))));
	$objPHPExcel->getActiveSheet()->getStyle('L'.$iHeaderRowNum)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D9D9D9'))));
	$objPHPExcel->getActiveSheet()->getStyle('M'.$iHeaderRowNum)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D9D9D9'))));
	$objPHPExcel->getActiveSheet()->getStyle('N'.$iHeaderRowNum)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D9D9D9'))));
	$objPHPExcel->getActiveSheet()->getStyle('O'.$iHeaderRowNum)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D9D9D9'))));
	$objPHPExcel->getActiveSheet()->getStyle('P'.$iHeaderRowNum)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'D9D9D9'))));
		
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$iStoresCell,"Stores : $sStores ");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$iHeaderRowNum,"Material Description");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$iHeaderRowNum,"Size");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$iHeaderRowNum,"Color");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$iHeaderRowNum,"UOM");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$iHeaderRowNum,"Avg. PO Price");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$iHeaderRowNum,"Ordered Qty");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$iHeaderRowNum,"Recieved Qty");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$iHeaderRowNum,"Recieved/Ordered (%)");	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$iHeaderRowNum,"Return to Supplier");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$iHeaderRowNum,"Transfer IN Qty ");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$iHeaderRowNum,"Transfer OUT Qty");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$iHeaderRowNum,"Issued QTY");	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$iHeaderRowNum,"Stock In Hand");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$iHeaderRowNum,"Stock In Hand/Recieved (%)");	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$iHeaderRowNum,"Value");
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$iHeaderRowNum,"Comments");
	
	#=======================================================================
	# Get the item details by the stores location
	#========================================================================
	
	$sqlItem = " SELECT DISTINCT matitemlist.strItemDescription, materialratio.strColor, materialratio.strSize, specificationdetails.strUnit, ".
		       "                 matitemlist.intItemSerial, materialratio.strBuyerPONO, Sum(stocktransactions.dblQty) AS StockQty, ".
			   "		         matitemlist.intItemSerial ".
		       " FROM  matitemlist Inner Join specificationdetails ON matitemlist.intItemSerial = specificationdetails.strMatDetailID ".
		       "       Inner Join materialratio ON specificationdetails.intStyleId = materialratio.intStyleId AND ".
			   "       specificationdetails.strMatDetailID = materialratio.strMatDetailID Inner Join stocktransactions ON ".
			   "       materialratio.intStyleId = stocktransactions.intStyleId AND materialratio.strMatDetailID = ". 
			   "       stocktransactions.intMatDetailId AND materialratio.strColor = stocktransactions.strColor AND materialratio.strSize = ".
			   "       stocktransactions.strSize AND materialratio.strBuyerPONO = stocktransactions.strBuyerPoNo ".
			   " WHERE specificationdetails.intStyleId =  '$iStyleId' AND specificationdetails.intStatus =  '1' AND ".
			   "	   stocktransactions.strMainStoresID =  '$iStoresId' ".
			   " GROUP BY matitemlist.strItemDescription, materialratio.strColor, materialratio.strSize, specificationdetails.strUnit, ".
			   "       matitemlist.intItemSerial, materialratio.strBuyerPONO ".
			   " HAVING ROUND(Sum(stocktransactions.dblQty),2)>0 ".
			   " ORDER BY matitemlist.intMainCatID ASC ";
		
	$resItemDetails = $db->RunQuery($sqlItem);
	
	while($rowItems = mysql_fetch_array($resItemDetails)){
		
		$_dblRcvPercentage = 0;
		$_dblBalPercentage = 0;
		
		$_itemcode = $rowItems['intItemSerial'];
		$_itemdescription = $rowItems['strItemDescription'];	
		$_color = $rowItems['strColor'];	
		$_size = $rowItems['strSize'];	
		$_buyerpono = $rowItems['strBuyerPONO'];	
		$_dblStockInHand = $rowItems['StockQty'];	
		
		#====== Get PO Price ===================================
		$_dblPOPrice = 	GetPOPrice($iStyleId,$_itemcode,$_color,$_size,$_buyerpono,$iCompanyId);
		#=======================================================
		
		#====== Get PO QTY ===================================
		$_dblPOQty = GetPOQty($iStyleId,$_itemcode,$_color,$_size,$_buyerpono,$iCompanyId);
		#=======================================================
		
		#====== Get Received QTY ===================================
		$_dblRcvdQty = GetRecivedQty($iStyleId,$_itemcode,$_color,$_size,$_buyerpono,$iStoresId);
		#=======================================================
		
		#====== Get Interjob transfer IN QTY ===================================
		$_dblTRInQty = GetTransferInQty($iStyleId,$_itemcode,$_color,$_size,$_buyerpono,$iStoresId);
		#=======================================================
		
		#====== Get Interjob transfer OUT QTY ===================================
		$_dblTROutQty = GetTransferOutQty($iStyleId,$_itemcode,$_color,$_size,$_buyerpono,$iStoresId)*-1;
		#=======================================================
		
		#====== Get Issued QTY ===================================
		$_dblIssuedQty = GetIssuedQty($iStyleId,$_itemcode,$_color,$_size,$_buyerpono,$iStoresId)*-1;
		#=======================================================
		
		
		#====== Get Return to supplier QTY ===================================
		$_dblRetSupQty = GetReturnToSupQty($iStyleId,$_itemcode,$_color,$_size,$_buyerpono,$iStoresId)*-1;
		#=======================================================
		
		$_dblStockValue = (float)$_dblPOPrice * (float)$_dblStockInHand;
		
		if($_dblRcvdQty>0)
			$_dblRcvPercentage = ($_dblRcvdQty/$_dblPOQty)*100;
		if($_dblRcvdQty>0)	
			$_dblBalPercentage = ($_dblStockInHand/$_dblRcvdQty)*100;
		
		#============================================================================
		# Draw borders of the cells
		#============================================================================
		
		$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('H'.$i)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('M'.$i)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('N'.$i)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('O'.$i)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('P'.$i)->applyFromArray($styleArray);
		
		$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode("#,###.00");
		$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode("#,###.00");
		$objPHPExcel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode("#,###.00");
		$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getNumberFormat()->setFormatCode("#,###.00");
		$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getNumberFormat()->setFormatCode("#,###.00");
		$objPHPExcel->getActiveSheet()->getStyle('K'.$i)->getNumberFormat()->setFormatCode("#,###.00");
		$objPHPExcel->getActiveSheet()->getStyle('L'.$i)->getNumberFormat()->setFormatCode("#,###.00");
		$objPHPExcel->getActiveSheet()->getStyle('M'.$i)->getNumberFormat()->setFormatCode("#,###.00");
		$objPHPExcel->getActiveSheet()->getStyle('N'.$i)->getNumberFormat()->setFormatCode("#,###.00");
		$objPHPExcel->getActiveSheet()->getStyle('O'.$i)->getNumberFormat()->setFormatCode("#,###.00");
		
		#============================================================================
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,$_itemdescription);		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$_size);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$_color);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$rowItems['strUnit']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$_dblPOPrice);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,$_dblPOQty);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$_dblRcvdQty);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,number_format($_dblRcvPercentage,0)."%");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i,$_dblRetSupQty);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$i,$_dblTRInQty);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$i,$_dblTROutQty);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$i,$_dblIssuedQty);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$i,$_dblStockInHand);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$i,number_format($_dblBalPercentage,0)."%");
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$i,$_dblStockValue);
		
		$i++;
		
	}
	
	
	$iStoresCell = $i + 3;
	$iHeaderRowNum = $iStoresCell + 3;
	
	$i = $iHeaderRowNum + 1;
		
}
$ti=date('H:i:s'); $ti1=strtotime("+330 minutes", strtotime($ti)); 
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$i-3,"Date :".date("Y-m-d")."  ". date("H:i:s", $ti1)."   User ID :".GetUserName());


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$file.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
echo 'done';
exit;



function GetPOPrice($prmStyleId, $prmItemCode, $prmColor, $prmSize, $prmBuyerPONo, $prmDeliveryCompanyId){
	
	global $db;
	
	$_dblPOPrice = 0;
	
	$sqlPOPrice = " SELECT Avg(purchaseorderdetails.dblUnitPrice) AS PO_PRICE ".
	              " FROM   purchaseorderdetails Inner Join purchaseorderheader ON purchaseorderdetails.intPoNo = purchaseorderheader.intPONo AND ".
				  "        purchaseorderdetails.intYear = purchaseorderheader.intYear ".
				  " WHERE  purchaseorderheader.intStatus =  '10' AND purchaseorderdetails.intStyleId =  '$prmStyleId' AND ".
				  "        purchaseorderdetails.intMatDetailID =  '$prmItemCode' AND purchaseorderdetails.strColor =  '$prmColor' AND ".
                  "        purchaseorderdetails.strSize =  '$prmSize' AND purchaseorderdetails.strBuyerPONO =  '$prmBuyerPONo'";
				   //AND    purchaseorderheader.intDelToCompID = '$prmDeliveryCompanyId'";
	//echo $sqlPOPrice;			  
	$resPOPrice = $db->RunQuery($sqlPOPrice);
	
	while($rowPOPrice = mysql_fetch_array($resPOPrice)){
		$_dblPOPrice = $rowPOPrice['PO_PRICE'];	
	}
	
	return $_dblPOPrice;	
}


function GetPOQty($prmStyleId, $prmItemCode, $prmColor, $prmSize, $prmBuyerPONo, $prmDeliveryCompanyId){
	
	global $db;
	
	$_dblPOQty = 0;
	
	$sqlPOQty = " SELECT SUM(purchaseorderdetails.dblQty) AS PO_QTY ".
	              " FROM   purchaseorderdetails Inner Join purchaseorderheader ON purchaseorderdetails.intPoNo = purchaseorderheader.intPONo AND ".
				  "        purchaseorderdetails.intYear = purchaseorderheader.intYear ".
				  " WHERE  purchaseorderheader.intStatus =  '10' AND purchaseorderdetails.intStyleId =  '$prmStyleId' AND ".
				  "        purchaseorderdetails.intMatDetailID =  '$prmItemCode' AND purchaseorderdetails.strColor =  '$prmColor' AND ".
                  "        purchaseorderdetails.strSize =  '$prmSize' AND purchaseorderdetails.strBuyerPONO =  '$prmBuyerPONo' AND ".
				  "        purchaseorderheader.intDelToCompID = '$prmDeliveryCompanyId'";
	//echo $sqlPOPrice;			  
	$resPOQty = $db->RunQuery($sqlPOQty);
	
	while($rowPOPrice = mysql_fetch_array($resPOQty)){
		$_dblPOQty = $rowPOPrice['PO_QTY'];	
	}
	
	return $_dblPOQty;	
}

function GetRecivedQty($prmStyleId, $prmItemCode, $prmColor, $prmSize, $prmBuyerPONo, $prmMainStoresId){
	
	global $db;
	
	$_dblReceivedQty = 0;
	
	$sqlReceivedQty = " SELECT SUM(stocktransactions.dblQty) AS RCVD_QTY ".
					  " FROM   stocktransactions ".
					  " WHERE  stocktransactions.strMainStoresID = '$prmMainStoresId' AND stocktransactions.intStyleId = '$prmStyleId' AND ".
					  "        stocktransactions.intMatDetailId = '$prmItemCode' AND stocktransactions.strColor = '$prmColor' AND ".
					  "        stocktransactions.strSize = '$prmSize' AND stocktransactions.strBuyerPoNo = '$prmBuyerPONo' AND ".
					  "        stocktransactions.strType = 'GRN' ";
	//echo $sqlReceivedQty;				  
	$resRcvdQty = $db->RunQuery($sqlReceivedQty);
	
	while($rowRcvdQty = mysql_fetch_array($resRcvdQty)){
		$_dblReceivedQty = $rowRcvdQty['RCVD_QTY'];	
	}
	
	return $_dblReceivedQty;	
 
}

function GetTransferInQty($prmStyleId, $prmItemCode, $prmColor, $prmSize, $prmBuyerPONo, $prmMainStoresId){
	
	global $db;
	
	$_dblTrInQty = 0;
	
	$sqlTrInQty = " SELECT SUM(stocktransactions.dblQty) AS TRIN_QTY ".
					  " FROM   stocktransactions ".
					  " WHERE  stocktransactions.strMainStoresID = '$prmMainStoresId' AND stocktransactions.intStyleId = '$prmStyleId' AND ".
					  "        stocktransactions.intMatDetailId = '$prmItemCode' AND stocktransactions.strColor = '$prmColor' AND ".
					  "        stocktransactions.strSize = '$prmSize' AND stocktransactions.strBuyerPoNo = '$prmBuyerPONo' AND ".
					  "        stocktransactions.strType = 'IJTIN' ";
	//echo $sqlReceivedQty;				  
	$resTrInQty = $db->RunQuery($sqlTrInQty);
	
	while($rowTrInQty = mysql_fetch_array($resTrInQty)){
		$_dblReceivedQty = $rowTrInQty['TRIN_QTY'];	
	}	
	return $_dblTrInQty;	
}

function GetTransferOutQty($prmStyleId, $prmItemCode, $prmColor, $prmSize, $prmBuyerPONo, $prmMainStoresId){
	
	global $db;
	
	$_dblTrOutQty = 0;
	
	$sqlTrOutQty = " SELECT SUM(stocktransactions.dblQty) AS TROUT_QTY ".
					  " FROM   stocktransactions ".
					  " WHERE  stocktransactions.strMainStoresID = '$prmMainStoresId' AND stocktransactions.intStyleId = '$prmStyleId' AND ".
					  "        stocktransactions.intMatDetailId = '$prmItemCode' AND stocktransactions.strColor = '$prmColor' AND ".
					  "        stocktransactions.strSize = '$prmSize' AND stocktransactions.strBuyerPoNo = '$prmBuyerPONo' AND ".
					  "        stocktransactions.strType = 'IJTOUT' ";
	//echo $sqlReceivedQty;				  
	$resTrOutQty = $db->RunQuery($sqlTrOutQty);
	
	while($rowTrOutQty = mysql_fetch_array($resTrOutQty)){
		$_dblTrOutQty = $rowTrOutQty['TROUT_QTY'];	
	}	
	return $_dblTrOutQty;	
}

function GetIssuedQty($prmStyleId, $prmItemCode, $prmColor, $prmSize, $prmBuyerPONo, $prmMainStoresId){
	
	global $db;
	
	$_dblIssuedQty = 0;
	
	$sqlIssuedQty = " SELECT SUM(stocktransactions.dblQty) AS ISSUED_QTY ".
					  " FROM   stocktransactions ".
					  " WHERE  stocktransactions.strMainStoresID = '$prmMainStoresId' AND stocktransactions.intStyleId = '$prmStyleId' AND ".
					  "        stocktransactions.intMatDetailId = '$prmItemCode' AND stocktransactions.strColor = '$prmColor' AND ".
					  "        stocktransactions.strSize = '$prmSize' AND stocktransactions.strBuyerPoNo = '$prmBuyerPONo' AND ".
					  "        stocktransactions.strType = 'ISSUE' ";
	//echo $sqlReceivedQty;				  
	$resIssuedQty = $db->RunQuery($sqlIssuedQty);
	
	while($rowIssuedQty = mysql_fetch_array($resIssuedQty)){
		$_dblIssuedQty = $rowIssuedQty['ISSUED_QTY'];	
	}	
	return $_dblIssuedQty;	
}

function GetReturnToSupQty($prmStyleId, $prmItemCode, $prmColor, $prmSize, $prmBuyerPONo, $prmMainStoresId){
	
	global $db;
	
	$_dblRetSupQty = 0;
	
	$sqlRetSupQty = " SELECT SUM(stocktransactions.dblQty) AS RETSUP_QTY ".
					  " FROM   stocktransactions ".
					  " WHERE  stocktransactions.strMainStoresID = '$prmMainStoresId' AND stocktransactions.intStyleId = '$prmStyleId' AND ".
					  "        stocktransactions.intMatDetailId = '$prmItemCode' AND stocktransactions.strColor = '$prmColor' AND ".
					  "        stocktransactions.strSize = '$prmSize' AND stocktransactions.strBuyerPoNo = '$prmBuyerPONo' AND ".
					  "        stocktransactions.strType = 'SRTSUP' ";
	//echo $sqlReceivedQty;				  
	$resRetSupQty = $db->RunQuery($sqlRetSupQty);
	
	while($rowRetSupQty = mysql_fetch_array($resRetSupQty)){
		$_dblRetSupQty = $rowRetSupQty['RETSUP_QTY'];	
	}	
	return $_dblRetSupQty;	
}
 	   
function GetLastShipCompletedDate($prmSCNo){
	
	global $dbHelaSite;
	
	$sql = "SELECT compledDate FROM d2d_master_style_main WHERE scNumber = '$prmSCNo'";
	
	$resShipComDate = $dbHelaSite->RunQuery($sql);
	
	while($row = mysql_fetch_array($resShipComDate)){
		
		return $row['compledDate'];
	}
	
}

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