<?php
session_start();

include "authentication.inc";
include "Connector.php";
$xml = simplexml_load_file('config.xml');

$locationId =  $_SESSION["FactoryID"];

//error_reporting(E_ALL);
require_once 'excel/Classes/PHPExcel.php';
require_once 'excel/Classes/PHPExcel/IOFactory.php';

$styleArray = array('borders'=>array('allborders'=>array('style'=>PHPExcel_Style_Border::BORDER_THIN)));
$styleArrayFontBoldHeader = array('font'=>array('bold'=>true,'size'=>14));
$styleArrayLineHeader = array('font'=>array('bold'=>true,'size'=>10));
$styleArrayLineDetail = array('font'=>array('size'=>10));

$file = "bomreport.xls";

if (!file_exists($file)) {
    exit("Can't find $fileName");
}

$strStyleID = $_GET["styleID"];

$SQL="SELECT orders.strOrderNo,orders.intStyleId, orders.intQty, orders.reaExPercentage, buyers.strName, specification.intSRNO, orders.strDescription, useraccounts.Name, orders.intCompanyID
FROM ((orders INNER JOIN buyers ON orders.intBuyerID = buyers.intBuyerID) INNER JOIN specification ON orders.intStyleId = specification.intStyleId) INNER JOIN useraccounts ON orders.intUserID = useraccounts.intUserID
WHERE (((orders.intStyleId)='".$strStyleID."'));";
     // echo $SQL;
$result = $db->RunQuery($SQL);

while($row = mysql_fetch_array($result))
{
        $intQty			= $row["intQty"];
        $buyerName		= $row["strName"];
        $intSRNO		= $row["intSRNO"];
        $strDescription	= $row["strDescription"];
        $usrnme			= $row["Name"];
        $intCompanyID	= $row["intCompanyID"];
        $exPercentage 	= $row["reaExPercentage"];
        $orderNo		= $row["strOrderNo"];
}
$exQty = $intQty + ($intQty * $exPercentage / 100);

$objPHPExcel = PHPExcel_IOFactory::load($file);
$iStoresCell = 7;
$iHeaderRowNum = 9;
$i = 11;

$objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($styleArrayFontBoldHeader);
$objPHPExcel->getActiveSheet()->getStyle('B4')->applyFromArray($styleArrayLineHeader);
$objPHPExcel->getActiveSheet()->getStyle('B5')->applyFromArray($styleArrayLineHeader);
$objPHPExcel->getActiveSheet()->getStyle('B6')->applyFromArray($styleArrayLineHeader);
$objPHPExcel->getActiveSheet()->getStyle('H4')->applyFromArray($styleArrayLineHeader);
$objPHPExcel->getActiveSheet()->getStyle('H5')->applyFromArray($styleArrayLineHeader);
$objPHPExcel->getActiveSheet()->getStyle('H6')->applyFromArray($styleArrayLineHeader);
$objPHPExcel->getActiveSheet()->getStyle('B9')->applyFromArray($styleArrayLineHeader);
$objPHPExcel->getActiveSheet()->getStyle('B10')->applyFromArray($styleArrayLineHeader);
$objPHPExcel->getActiveSheet()->getStyle('D10')->applyFromArray($styleArrayLineHeader);
$objPHPExcel->getActiveSheet()->getStyle('F10')->applyFromArray($styleArrayLineHeader);

$objPHPExcel->getActiveSheet()->getStyle('C4')->applyFromArray($styleArrayLineDetail);
$objPHPExcel->getActiveSheet()->getStyle('C5')->applyFromArray($styleArrayLineDetail);
$objPHPExcel->getActiveSheet()->getStyle('C6')->applyFromArray($styleArrayLineDetail);
$objPHPExcel->getActiveSheet()->getStyle('I4')->applyFromArray($styleArrayLineDetail);
$objPHPExcel->getActiveSheet()->getStyle('I5')->applyFromArray($styleArrayLineDetail);
$objPHPExcel->getActiveSheet()->getStyle('I6')->applyFromArray($styleArrayLineDetail);


$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,3," BILL OF MATERIAL - ITEM STATUS  ");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,4," STYLE NO");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,4,$orderNo);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,5," SC : ");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,5,$intSRNO);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,6," ORDER QTY :  ");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,6, $intQty);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,4," DESCRIPTION ");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,4,$strDescription); 
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,5," MERCHANDISER ");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,5,$usrnme);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,6," BUYER ");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,6,$buyerName);


$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,9,"Delivery Schedule  ");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,10,"Delivery Date  ");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,10,"BuyerPONo  ");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,10,"Qty  ");

$sql = "select dtDateofDelivery,dblQty,dbExQty, intBPO from deliveryschedule where intStyleId = '$strStyleID' order by dtDateofDelivery;";
$result = $db->RunQuery($sql); 	
$totqty = 0;

while($row = mysql_fetch_array($result)){
    
    $delDate   = $row["dtDateofDelivery"];
    $strBpoNo  = $row["intBPO"];
    $dblDelQty = $row["dblQty"];
            
    
    $objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($styleArrayLineDetail);
    $objPHPExcel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($styleArrayLineDetail);
    $objPHPExcel->getActiveSheet()->getStyle('F'.$i)->applyFromArray($styleArrayLineDetail);
    
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,date("jS F Y", strtotime($delDate)));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$strBpoNo);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,$dblDelQty);
    
    $i++;
    
}

$i = $i+3;

$sql = "select distinct strBuyerPONO from styleratio where intStyleId = '$strStyleID' AND (intStatus != '0' or intStatus IS NULL);";
$resultbpo = $db->RunQuery($sql); 	
while($rowbpo = mysql_fetch_array($resultbpo)){
    
    $sizearray = array();
    
    $strBuyerPONo = $rowbpo["strBuyerPONO"];
    
    $objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($styleArrayLineHeader);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,"STYLE RATIO - ".$strBuyerPONo);
    $i++;
    
    $objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($styleArrayLineHeader);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,"Color/Size");
    
    $sqlsize = "select distinct strSize from styleratio where intStyleId = '$strStyleID' and strBuyerPONO = '" . $rowbpo["strBuyerPONO"] . "'  AND (intStatus != '0' or intStatus IS NULL);";
    $resultsize = $db->RunQuery($sqlsize); 
    
    $loop = 0;
    $iCol = 2;
    while($rowsize = mysql_fetch_array($resultsize))
    {
        $sizearray[$loop] = $rowsize["strSize"]; 
        $colName = getExcelColumnName($iCol+1);
        $objPHPExcel->getActiveSheet()->getStyle($colName.(string)$i)->applyFromArray($styleArrayLineHeader);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iCol,$i,$rowsize["strSize"]);
        $iCol ++;
        $loop++;
    }
    
    $colName = getExcelColumnName($iCol+1);
    $objPHPExcel->getActiveSheet()->getStyle($colName.(string)$i)->applyFromArray($styleArrayLineHeader);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iCol,$i,"Total");
    
    $sqlcolor = "select distinct strColor from styleratio where intStyleId = '$strStyleID' and strBuyerPONO = '". $strBuyerPONo . "' AND (intStatus != '0' or intStatus IS NULL);";
    $resultcolor = $db->RunQuery($sqlcolor); 
    while($rowcolor = mysql_fetch_array($resultcolor))
    {
        $rowtot = 0;
        $iCol = 2;
        $i++;
        
        $objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($styleArrayLineDetail);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$rowcolor["strColor"]);
        
        foreach ($sizearray as $size)
        {
            $sql = "select dblQty from styleratio where intStyleId = '$strStyleID' and strBuyerPONO = '" . $strBuyerPONo . "' and strColor = '".$rowcolor["strColor"]."' and strSize = '$size' AND (intStatus != '0' or intStatus IS NULL);";
            
            $resultqty = $db->RunQuery($sql); 
            while($rowqty= mysql_fetch_array($resultqty))
            {
                $rowtot += $rowqty["dblQty"];
                $colName = getExcelColumnName($iCol+1);
                $objPHPExcel->getActiveSheet()->getStyle($colName.(string)$i)->applyFromArray($styleArrayLineDetail);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iCol,$i,$rowqty["dblQty"]);
                $iCol++;
            }
            
        }
        
        $colName = getExcelColumnName($iCol+1);
        $objPHPExcel->getActiveSheet()->getStyle($colName.(string)$i)->applyFromArray($styleArrayLineDetail);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iCol,$i,$rowtot);
        
    }
    
    $i = $i+3;
    $objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($styleArrayLineHeader);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,"Item Details");
    $i++;
    
    $objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($styleArrayLineHeader);
    $objPHPExcel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($styleArrayLineHeader);
    $objPHPExcel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($styleArrayLineHeader);
    $objPHPExcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($styleArrayLineHeader);
    $objPHPExcel->getActiveSheet()->getStyle('F'.$i)->applyFromArray($styleArrayLineHeader);
    $objPHPExcel->getActiveSheet()->getStyle('G'.$i)->applyFromArray($styleArrayLineHeader);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$i)->applyFromArray($styleArrayLineHeader);
    $objPHPExcel->getActiveSheet()->getStyle('I'.$i)->applyFromArray($styleArrayLineHeader);
    $objPHPExcel->getActiveSheet()->getStyle('J'.$i)->applyFromArray($styleArrayLineHeader);
    $objPHPExcel->getActiveSheet()->getStyle('K'.$i)->applyFromArray($styleArrayLineHeader);
    $objPHPExcel->getActiveSheet()->getStyle('L'.$i)->applyFromArray($styleArrayLineHeader);
    $objPHPExcel->getActiveSheet()->getStyle('M'.$i)->applyFromArray($styleArrayLineHeader);
    
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,"Item");
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,"Buyer PO");
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,"Color");
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,"Size");
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,"UOM");
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,"Con/Pc");
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,"Waste %");
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i,"Required Qty");
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$i,"Orderd + Allo Qty");
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$i,"Bal To Order");
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$i,"Received Qty");
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$i,"Balance Qty");
    $i++;
    $SQL_Category="SELECT DISTINCT matmaincategory.strDescription, matmaincategory.intID
                   FROM (specificationdetails INNER JOIN matitemlist ON specificationdetails.strMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID
                   WHERE (((specificationdetails.intStyleId)='". $strStyleID."')) AND (specificationdetails.intStatus != '0' or specificationdetails.intStatus IS NULL)
                   ORDER BY matmaincategory.intID; ";
    
    $result_Category= $db->RunQuery($SQL_Category);
    while($row_Category = mysql_fetch_array($result_Category)){
        
        $objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($styleArrayLineHeader);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$row_Category["strDescription"]);
        
        $sqlItem=" SELECT materialratio.intStyleId,  materialratio.strBuyerPONO, materialratio.strColor, materialratio.serialNo, materialratio.strSize, materialratio.dblQty,materialratio.dblRecutQty, materialratio.dblBalQty, specificationdetails.strUnit, specificationdetails.sngConPc, matitemlist.strItemDescription, specificationdetails.sngWastage, matitemlist.intItemSerial
                   FROM ((materialratio INNER JOIN matitemlist ON materialratio.strMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID) INNER JOIN specificationdetails ON materialratio.intStyleId = specificationdetails.intStyleId AND materialratio.strMatDetailID = specificationdetails.strMatDetailID
                   WHERE (((materialratio.intStyleId)='". $strStyleID."') AND ((matmaincategory.intID)=".$row_Category["intID"].")) AND (materialratio.intStatus != '0' or materialratio.intStatus IS NULL)
                         Order by matitemlist.strItemDescription,materialratio.strColor, materialratio.strSize, materialratio.serialNo;";
        $i++;
        $result_Description= $db->RunQuery($sqlItem);
	while($row_Descrip = mysql_fetch_array($result_Description)){
            
            $dblToReceivedQty = 0;
                            
            $dblGRNQty       = GetReceivedQty($row_Descrip["intStyleId"], $row_Descrip["intItemSerial"], $row_Descrip["strColor"], $row_Descrip["strSize"], $row_Descrip["strBuyerPONO"], $locationId, $db);
            $dblRcvdQtyOther = GetReceivedQtyToOtherLocation($row_Descrip["intStyleId"], $row_Descrip["intItemSerial"], $row_Descrip["strColor"], $row_Descrip["strSize"], $row_Descrip["strBuyerPONO"], $locationId, $db);
            $dblBalQty       = GetBalanceQty($row_Descrip["intStyleId"], $row_Descrip["intItemSerial"], $row_Descrip["strColor"], $row_Descrip["strSize"], $row_Descrip["strBuyerPONO"], $locationId, $db);
            $dblGPInQty      = GetGatePassInQty($row_Descrip["intStyleId"], $row_Descrip["intItemSerial"], $row_Descrip["strColor"], $row_Descrip["strSize"], $row_Descrip["strBuyerPONO"], $locationId, $db);

            $dblJobInQty     = GetInterJobInQty($row_Descrip["intStyleId"], $row_Descrip["intItemSerial"], $row_Descrip["strColor"], $row_Descrip["strSize"], $row_Descrip["strBuyerPONO"], $locationId, $db);

            $dblToReceivedQty = $dblGRNQty + $dblJobInQty + $dblGPInQty;
            
            $objPHPExcel->getActiveSheet()->getStyle("B".$i)->applyFromArray($styleArrayLineDetail);
            $objPHPExcel->getActiveSheet()->getStyle("C".$i)->applyFromArray($styleArrayLineDetail);
            $objPHPExcel->getActiveSheet()->getStyle("D".$i)->applyFromArray($styleArrayLineDetail);
            $objPHPExcel->getActiveSheet()->getStyle("E".$i)->applyFromArray($styleArrayLineDetail);
            $objPHPExcel->getActiveSheet()->getStyle("F".$i)->applyFromArray($styleArrayLineDetail);
            $objPHPExcel->getActiveSheet()->getStyle("G".$i)->applyFromArray($styleArrayLineDetail);
            $objPHPExcel->getActiveSheet()->getStyle("H".$i)->applyFromArray($styleArrayLineDetail);
            $objPHPExcel->getActiveSheet()->getStyle("I".$i)->applyFromArray($styleArrayLineDetail);
            $objPHPExcel->getActiveSheet()->getStyle("J".$i)->applyFromArray($styleArrayLineDetail);
            $objPHPExcel->getActiveSheet()->getStyle("K".$i)->applyFromArray($styleArrayLineDetail);
            $objPHPExcel->getActiveSheet()->getStyle("L".$i)->applyFromArray($styleArrayLineDetail);
            $objPHPExcel->getActiveSheet()->getStyle("M".$i)->applyFromArray($styleArrayLineDetail);
            
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$i,$row_Descrip["strItemDescription"]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$i,$row_Descrip["strBuyerPONO"]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,$row_Descrip["strColor"]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,$row_Descrip["strSize"]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,$row_Descrip["strUnit"]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,$row_Descrip["sngConPc"]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,$row_Descrip["sngWastage"]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i,$row_Descrip["dblQty"]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$i,$row_Descrip["dblQty"] - $row_Descrip["dblBalQty"]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$i,$row_Descrip["dblBalQty"]);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$i,$dblToReceivedQty);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$i,$dblBalQty);
            $i++;
            
        }
	$i++;		
    }
    
}



header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$file.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
echo 'done';
exit;


function GetReceivedQty($prmStyleID, $prmItemId, $prmColor, $prmSize, $prmBuyerPO, $prmFactoryId, $db){
        
        $dblReceivedQty = 0;
        
        $sql = " SELECT Sum(grndetails.dblQty) As RcvdQty 
                 FROM grnheader INNER JOIN grndetails ON grnheader.intGrnNo = grndetails.intGrnNo AND grnheader.intGRNYear = grndetails.intGRNYear
                 WHERE grnheader.intStatus = 1 AND grndetails.intStyleId = '$prmStyleID' AND grndetails.intMatDetailID = '$prmItemId' AND
                       grndetails.strColor = '$prmColor' AND grndetails.strSize = '$prmSize' AND grndetails.strBuyerPONO = '$prmBuyerPO' AND
                       grnheader.intCompanyID = '$prmFactoryId' ";
        
        $result= $db->RunQuery($sql);
        
        while($row = mysql_fetch_array($result)){
            
            $dblReceivedQty = $row["RcvdQty"];
            
        }
        
        return $dblReceivedQty;
        
    }
    
    function GetReceivedQtyToOtherLocation($prmStyleID, $prmItemId, $prmColor, $prmSize, $prmBuyerPO, $prmFactoryId, $db){
        
        $dblReceivedQty = 0;
        
        $sql = " SELECT Sum(grndetails.dblQty) As RcvdQty 
                 FROM grnheader INNER JOIN grndetails ON grnheader.intGrnNo = grndetails.intGrnNo AND grnheader.intGRNYear = grndetails.intGRNYear
                 WHERE grnheader.intStatus = 1 AND grndetails.intStyleId = '$prmStyleID' AND grndetails.intMatDetailID = '$prmItemId' AND
                       grndetails.strColor = '$prmColor' AND grndetails.strSize = '$prmSize' AND grndetails.strBuyerPONO = '$prmBuyerPO' AND
                       grnheader.intCompanyID <> '$prmFactoryId' ";
        
        $result= $db->RunQuery($sql);
        
        while($row = mysql_fetch_array($result)){
            
            $dblReceivedQty = $row["RcvdQty"];
            
        }
        
        return $dblReceivedQty;
        
    }
    
    function GetBalanceQty($prmStyleID, $prmItemId, $prmColor, $prmSize, $prmBuyerPO, $prmFactoryId, $db){
        
        $dblBalanceQty = 0;
        
        $sql = " SELECT Sum(stocktransactions.dblQty) AS BalanceQty
                 FROM stocktransactions INNER JOIN mainstores ON stocktransactions.strMainStoresID = mainstores.strMainID
                 WHERE stocktransactions.intStyleId = '$prmStyleID' AND stocktransactions.intMatDetailId = '$prmItemId' AND
                       stocktransactions.strColor = '$prmColor' AND stocktransactions.strSize = '$prmSize' AND
                       stocktransactions.strBuyerPoNo = '$prmBuyerPO' AND mainstores.intCompanyId = '$prmFactoryId' ";
        
        $result= $db->RunQuery($sql);
        
        while($row = mysql_fetch_array($result)){  
            
            $dblBalanceQty = $row["BalanceQty"];     
            
        }
        
        return $dblBalanceQty;
    }
    
    function GetInterJobInQty($prmStyleID, $prmItemId, $prmColor, $prmSize, $prmBuyerPO, $prmFactoryId, $db){
        
        $dblInterJobInQty = 0;
        
        $sql = " SELECT Sum(stocktransactions.dblQty) AS InterJobInQty
                 FROM stocktransactions INNER JOIN mainstores ON stocktransactions.strMainStoresID = mainstores.strMainID
                 WHERE stocktransactions.intStyleId = '$prmStyleID' AND stocktransactions.intMatDetailId = '$prmItemId' AND
                       stocktransactions.strColor = '$prmColor' AND stocktransactions.strSize = '$prmSize' AND
                       stocktransactions.strBuyerPoNo = '$prmBuyerPO' AND mainstores.intCompanyId = '$prmFactoryId' AND
                       stocktransactions.strType = 'IJTIN' ";
        
        $result= $db->RunQuery($sql);
        
        while($row = mysql_fetch_array($result)){  
            
            $dblInterJobInQty = $row["InterJobInQty"];     
            
        }
        
        return $dblInterJobInQty;
    }
    
    function GetGatePassInQty($prmStyleID, $prmItemId, $prmColor, $prmSize, $prmBuyerPO, $prmFactoryId, $db){
        
        $dblGPInQty = 0;
        
        $sql = " SELECT Sum(stocktransactions.dblQty) AS GPInQty
                 FROM stocktransactions INNER JOIN mainstores ON stocktransactions.strMainStoresID = mainstores.strMainID
                 WHERE stocktransactions.intStyleId = '$prmStyleID' AND stocktransactions.intMatDetailId = '$prmItemId' AND
                       stocktransactions.strColor = '$prmColor' AND stocktransactions.strSize = '$prmSize' AND
                       stocktransactions.strBuyerPoNo = '$prmBuyerPO' AND mainstores.intCompanyId = '$prmFactoryId' AND
                       stocktransactions.strType = 'TI' ";
        
        $result= $db->RunQuery($sql);
        
        while($row = mysql_fetch_array($result)){  
            
            $dblGPInQty = $row["GPInQty"];     
            
        }
        
        return $dblGPInQty;
    }
    
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
