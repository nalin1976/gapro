<?php
//$backwardseperator = "../../";
session_start();

include "../../Connector.php";

$locationId =  $_SESSION["FactoryID"];

$strStyleID = $_GET["styleID"];

ini_set('memory_limit', '-1');
//error_reporting(E_ALL);
require_once '../../excel/Classes/PHPExcel.php';
require_once '../../excel/Classes/PHPExcel/IOFactory.php';
require_once '../../classes/class_orders.php';
require_once '../../classes/class_orderrawmaterial.php';


$styleArray               = array('borders'=>array('allborders'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN)));
$styleArrayFontBoldHeader = array('font'=>array('bold'=>true,'size'=>14));
$styleArrayLineHeader     = array('font'=>array('bold'=>true,'size'=>10));
$styleArrayLineDetail     = array('font'=>array('size'=>10));

$OrderClass = new Orders();
$OrderRawMaterialClass = new OrdersRawMaetrial();

$file = "xclpi1.xlsx";

if (!file_exists($file)) {
    exit("Can't find $fileName");
}



$OrderClass->SetConnection($db);
$OrderRawMaterialClass->SetConnection($db);

// Get Order header details
$resOrderHeader = $OrderClass->GetOrderHeaderDetails($strStyleID);

while($row = mysql_fetch_array($resOrderHeader))
{
    $buyerName	= $row["strName"];
    $intSRNO	= $row["intSRNO"];
    $strDescription	= $row["strDescription"];
    $strStyleName   = $row["strStyle"];
    $strDivision    = $row["strDivision"];
    $strBuyingOffice = $row["BuyingOffice"];
    $buyerCode      = $row["buyerCode"];
        
}

//==================================================================

// Get Production location 
//==================================================================
$resProdLocation = $OrderClass->GetManufactureLocation($strStyleID);

while($rowLocation = mysql_fetch_array($resProdLocation)){
    $strManuLocation = $rowLocation["strName"];
}
//==================================================================
//echo "Catch 1.0 .<br />";


//$objPHPExcel = PHPExcel_IOFactory::load($file);
$objPHPExcel = PHPExcel_IOFactory::load($file);

$i = 15;

//echo "Catch 1.0 .<br />";


//$objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($styleArrayFontBoldHeader);
$objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($styleArrayLineHeader);
$objPHPExcel->getActiveSheet()->getStyle('B5')->applyFromArray($styleArrayLineHeader);
$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArrayLineHeader);
$objPHPExcel->getActiveSheet()->getStyle('H4')->applyFromArray($styleArrayLineHeader);
$objPHPExcel->getActiveSheet()->getStyle('H5')->applyFromArray($styleArrayLineHeader);
$objPHPExcel->getActiveSheet()->getStyle('H6')->applyFromArray($styleArrayLineHeader);
//$objPHPExcel->getActiveSheet()->getStyle('B9')->applyFromArray($styleArrayLineHeader);
//$objPHPExcel->getActiveSheet()->getStyle('B10')->applyFromArray($styleArrayLineHeader);
$objPHPExcel->getActiveSheet()->getStyle('D10')->applyFromArray($styleArrayLineHeader);
$objPHPExcel->getActiveSheet()->getStyle('F10')->applyFromArray($styleArrayLineHeader);

$objPHPExcel->getActiveSheet()->getStyle('C4')->applyFromArray($styleArrayLineDetail);
$objPHPExcel->getActiveSheet()->getStyle('C5')->applyFromArray($styleArrayLineDetail);
$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArrayLineDetail);
$objPHPExcel->getActiveSheet()->getStyle('I4')->applyFromArray($styleArrayLineDetail);
$objPHPExcel->getActiveSheet()->getStyle('I5')->applyFromArray($styleArrayLineDetail);
$objPHPExcel->getActiveSheet()->getStyle('I6')->applyFromArray($styleArrayLineDetail);
//echo "Catch 1.1 .<br />";
/*switch($buyerCode){
    
    case 'I03D' :
        $gdImage = imagecreatefromjpeg('../../images/decathlon.jpg');
        break;
}*/
//echo "Catch A";


$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
$objDrawing->setImageResource($gdImage);
$objDrawing->setCoordinates('M2');
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

//echo "Catch 2 .<br />";
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,3,$intSRNO);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,4,$buyerName);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,5,$strBuyingOffice);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,6,$strStyleName);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,7,$strDivision);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,8,$strDescription);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,9,$strManuLocation);

// ====================================================================
// Get garment size raio to create size header column
// ====================================================================
$iColNum = 4;
$iArrayPos = 0;

$arrSizes = array();
$arrColors = array();
$arrBPO = array();

// ====================================================================
$sql = " SELECT DISTINCT styleratio.strSize FROM styleratio WHERE styleratio.intStyleId = '$strStyleID' AND styleratio.intStatus = 1 ";

$resSizeRatio = $db->RunQuery($sql);

while($rowSizes = mysql_fetch_array($resSizeRatio)){
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColNum,12,$rowSizes["strSize"]);
    $arrSizes[$iArrayPos] = array($iColNum => $rowSizes["strSize"]);    
    $iArrayPos++;
    $iColNum++;
}
// ====================================================================

//=====================================================================
$sql = " SELECT DISTINCT styleratio.strColor FROM styleratio WHERE styleratio.intStyleId = '$strStyleID' AND styleratio.intStatus = 1 ";
$resColorRatio = $db->RunQuery($sql);
$iArrayPos = 0;
while($rowColors = mysql_fetch_array($resColorRatio)){
    
    $arrColors[$iArrayPos] = $rowColors["strColor"];    
    $iArrayPos++;
}
//=====================================================================

// Get style ratio details and add to the 
//================================

 $resBPOList = $OrderClass->GetDeliveryDetails($strStyleID);

while($rowBPOList = mysql_fetch_array($resBPOList)){
    
    $strBPONo        = $rowBPOList["intBPO"];
    $dtEstimatedDate = $rowBPOList["estimatedDate"];
    
    $objPHPExcel->getActiveSheet()->insertNewRowBefore($i+1);
    
    foreach($arrColors as $valColors){
        
        $dblTotPcs = 0;
        
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$strBPONo);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$valColors);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$i,$dtEstimatedDate);
        
        $resRatio = $OrderClass->GetRatioDetails($strStyleID,$strBPONo,$valColors);
        
        while($rowRatio = mysql_fetch_array($resRatio)){
            
            $strSize = $rowRatio["strSize"];
            $ratioQty = $rowRatio["dblQty"];
            
            $iColPos = array_search($strSize, $arrSizes);
            //print_r($arrSizes);
            for($x = 0; $x<count($arrSizes); $x++){

                $arrSub = $arrSizes[$x];

                foreach($arrSub as $key=>$value){
                    if($value == $strSize){
                        $iColPos = $key;
                    }
                }
                
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iColPos,$i,$ratioQty);
            } 
            
            $dblTotPcs += $ratioQty;
        }
        
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$i,$dblTotPcs);
    }
    $i++;
} 
//=====================================================

// Adding Fabric details
//=====================================================
$resFabricDetails = $OrderRawMaterialClass->GetFabricDetails($strStyleID);
$i += 4;
while($rowFabric = mysql_fetch_array($resFabricDetails)){
    
    $objPHPExcel->getActiveSheet()->insertNewRowBefore($i+1);
    
    $strFabricType = $rowFabric["strItemDescription"];
    $strFabricColor = $rowFabric["strColor"];
    $strFabricConPc = $rowFabric["dblYYConsumption"];
    
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$strFabricType);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$i,$strFabricColor);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$i,$strFabricConPc);
    $i++;
    
}
//=====================================================

// Adding Accessories details
// =====================================================
$i +=3;
$resAccessories = $OrderRawMaterialClass->GetAccosseries($strStyleID);

while($rowAccessories = mysql_fetch_array($resAccessories)){
    
    $objPHPExcel->getActiveSheet()->insertNewRowBefore($i+1);
    
    $strAccessoryName = $rowAccessories["strItemDescription"];
    
    
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$strAccessoryName);
    
    $i++;
    
}
$i +=4;
//=====================================================
// Adding Accessories details
// =====================================================

$resPacking = $OrderRawMaterialClass->GetPacking($strStyleID);

while($rowPacking = mysql_fetch_array($resPacking)){
    
    $objPHPExcel->getActiveSheet()->insertNewRowBefore($i+1);
    
    $strPackItem = $rowPacking["strItemDescription"];
    
    
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$strPackItem);
    
    $i++;
    
}



header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$file.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
echo 'done';
exit;



    
    function getExcelColumnName($num) {
        
     $numeric = ($num - 1) % 26;

     $letter = chr(65 + $numeric);

     $num2 = intval(($num - 1) / 26);

      if ($num2 > 0) {

          return getExcelColumnName($num2) . $letter;

      } else {

          return $letter;

      }

    }
    
   


?>
