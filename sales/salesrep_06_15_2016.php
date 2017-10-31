<?php

session_start();
$buyer		= $_GET["Buyer"];
$delDfrom	= $_GET["delDfrom"];
$delDto		= $_GET["delDto"];

$dblTotValue = 0;


include "../Connector.php" ;
include "../d2dConnector.php";

//error_reporting(E_ALL);
require_once '../excel/Classes/PHPExcel.php';
require_once '../excel/Classes/PHPExcel/IOFactory.php';


require_once('../classes/class_sales.php');
require_once('../classes/class_buyer.php');
require_once('../classes/class_common.php');

$class_sales 	= new salesmonitoring();
$class_buyer 	= new Buyer();
$class_common 	= new CommonPHP();

$d2dConnectClass = new ClassConnectD2D();

$file = 'salesmonitoring.xls';
if (!file_exists($file)) {
	exit("Can't find $fileName");
}

$class_buyer->SetConnection($db);
$BuyerName = $class_buyer->GetBuyerNameByCode($buyer);

if($buyer != "-1"){
	$BuyerName = "All Buyers";
}

$objPHPExcel = PHPExcel_IOFactory::load($file);

$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

$dtFormatFrom 	= $class_common->GetFormatDate($delDfrom);
$dtFormatTo		= $class_common->GetFormatDate($delDto);

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,1,"");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,2,"Sales & Monotoring Report");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,3, $BuyerName);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,5,"FROM - ".$dtFormatFrom."  TO - ".$dtFormatTo);

$class_sales->SetConnection($db);
$resDeliList = $class_sales->getDeliveries($buyer, $dtFormatFrom, $dtFormatTo, -1);

$rowId = 8;

while($row = mysql_fetch_array($resDeliList)){

	$strAuthoUser 	= "";
	$strConfirmUser = ""; 

	$dtAuthoTime  	= "";
	$dtConfirmTime  = "";


	$weekno = $class_sales->getMonthWeekNo($row["dtmHandOverDate"]);

	//$FGStock = $class_sales->GetShippedStatusFromD2D($row["intSRNO"],  $row["intBPO"], $d2dConnectClass);
        $FGStock = $class_sales->GetFinishGoodsQty($row["intSRNO"],  $row["intBPO"], $d2dConnectClass);
        
	$resAuthoUser = $class_sales->GetOrderAuthorizedUser($row["intStyleId"], $row["intBPO"]);
	$resConfirmUser = $class_sales->GetOrderConfirmUser($row["intStyleId"], $row["intBPO"]); 


	if(stripos($resAuthoUser,'/')>0){

		$arrAuthoUser = explode('/',$resAuthoUser);
		$strAuthoUser = $arrAuthoUser[0];
		$dtAuthoTime  = $arrAuthoUser[1];
	}else{
		$strAuthoUser = $resAuthoUser;
	}


	if(stripos($resConfirmUser,'/')>0){

		$arrConfirmUser = explode('/',$resConfirmUser);
		$strConfirmUser = $arrConfirmUser[0];
		$dtConfirmTime  = $arrAuthoUser[1];
	}else{
		$strConfirmUser = $resConfirmUser;
	}


 
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowId,$weekno);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowId,$row["strStyle"]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowId,$row["intSRNO"]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowId,$row["intBPO"]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowId,number_format($row["dblQty"]));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowId,number_format($FGStock));
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowId,$row["dblFOB"]);
        
        if(($strAuthoUser != "Not Authorised") && ($strConfirmUser != "Not Confirmed")){
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowId,number_format(($row["dblQty"] * $row["dblFOB"]),2));
            $dblTotValue += ($row["dblQty"] * $row["dblFOB"]);
	}else{
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowId,0);
	}
        
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowId,$row["dtmHandOverDate"]);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowId,$row["strName"]);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$rowId,$strAuthoUser);
	//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowId,$dtAuthoTime);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$rowId,$strConfirmUser);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$rowId,$dtConfirmTime);

	

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$rowId,$row["ProdLocation"]);


	$rowId++;
}

$rowId ++;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowId,number_format($dblTotValue,2));

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$file.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
echo 'done';
exit;




?>