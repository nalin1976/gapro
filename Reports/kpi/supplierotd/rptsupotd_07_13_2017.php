<?php
session_start();
$backwardseperator = "../../../";
include "../../../authentication.inc";
include "../../../Connector.php"; 

require_once '../../../excel/Classes/PHPExcel.php';
require_once '../../../excel/Classes/PHPExcel/IOFactory.php';

$file = 'supotd.xls';
if (!file_exists($file)) {
    exit("Can't find - $file");
}

$styleCode      = $_GET["styleid"];
$supplierCode   = $_GET["supplierid"];
$poNumber       = $_GET["pono"];
$poYear         = $_GET["poyear"];
$selecCriteria  = $_GET["selection"];
$poDtFrom       = $_GET["pofrom"];
$poDtTo         = $_GET["poto"];

$rowNum     = 2;

$report_companyId =$_SESSION["FactoryID"];

$objPHPExcel = PHPExcel_IOFactory::load($file);


$sql = " SELECT purchaseorderheader.intYear, purchaseorderheader.intPONo, suppliers.strTitle, purchaseorderheader.dtmDate, purchaseorderheader.dtmETA, purchaseorderheader.dtmETD,
                    matitemlist.strItemDescription, matitemlist.intItemSerial, Sum(purchaseorderdetails.dblQty) AS OrderedQty,
            SUM((SELECT SUM(grndetails.dblQty) FROM grnheader INNER JOIN grndetails ON grnheader.intGrnNo = grndetails.intGrnNo AND grnheader.intGRNYear = grndetails.intGRNYear
             WHERE grnheader.intPoNo = purchaseorderheader.intPONo AND grnheader.intYear = purchaseorderheader.intYear AND 
                   grndetails.intStyleId = purchaseorderdetails.intStyleId AND grndetails.intMatDetailID = purchaseorderdetails.intMatDetailID AND
                   grndetails.strColor = purchaseorderdetails.strColor AND grndetails.strSize = purchaseorderdetails.strSize AND
                   grndetails.strBuyerPONO = purchaseorderdetails.strBuyerPONO AND grnheader.intStatus = 1 )) AS RcvdQty,
            (SELECT MIN(grnheader.dtmRecievedDate) FROM grnheader INNER JOIN grndetails ON grnheader.intGrnNo = grndetails.intGrnNo AND grnheader.intGRNYear = grndetails.intGRNYear
             WHERE grnheader.intPoNo = purchaseorderheader.intPONo AND grnheader.intYear = purchaseorderheader.intYear AND 
                   grndetails.intStyleId = purchaseorderdetails.intStyleId AND grndetails.intMatDetailID = purchaseorderdetails.intMatDetailID AND
                   grndetails.strColor = purchaseorderdetails.strColor AND grndetails.strSize = purchaseorderdetails.strSize AND
                   grndetails.strBuyerPONO = purchaseorderdetails.strBuyerPONO AND grnheader.intStatus = 1) AS First_GRN,
            specification.intSRNO, orders.strStyle, orders.strDescription, purchaseorderdetails.strUnit, purchaseorderheader.dtmADD, purchaseorderheader.dtmACD,
            (SELECT companies.strName FROM companies WHERE companies.intCompanyID = purchaseorderheader.intDelToCompID) AS Delivery_To

            FROM
            purchaseorderheader
            INNER JOIN purchaseorderdetails ON purchaseorderheader.intPONo = purchaseorderdetails.intPoNo AND purchaseorderheader.intYear = purchaseorderdetails.intYear
            INNER JOIN materialratio ON purchaseorderdetails.intStyleId = materialratio.intStyleId AND purchaseorderdetails.intMatDetailID = materialratio.strMatDetailID AND purchaseorderdetails.strColor = materialratio.strColor AND purchaseorderdetails.strSize = materialratio.strSize AND purchaseorderdetails.strBuyerPONO = materialratio.strBuyerPONO
            INNER JOIN specificationdetails ON materialratio.intStyleId = specificationdetails.intStyleId AND materialratio.strMatDetailID = specificationdetails.strMatDetailID
            INNER JOIN suppliers ON purchaseorderheader.strSupplierID = suppliers.strSupplierID
            INNER JOIN matitemlist ON specificationdetails.strMatDetailID = matitemlist.intItemSerial
            INNER JOIN specification ON specification.intStyleId = specificationdetails.intStyleId
            INNER JOIN orders ON orders.intStyleId = specification.intStyleId
            WHERE purchaseorderheader.intStatus = 10 AND purchaseorderheader.intYear = '$poYear' ";

if($styleCode != '-1') {
    $sql .= " AND specificationdetails.intStyleId = '$styleCode' ";
}

if($supplierCode != '-1'){
    $sql .= " AND suppliers.strSupplierID = '$supplierCode' ";
}

if($poNumber != ""){
    $sql .= " AND purchaseorderheader.intPONo LIKE '%$poNumber%' ";
}    

switch($selecCriteria){
    
    case 1:
        
        if($poDtFrom != ""){
            $sql .= " AND purchaseorderheader.dtmDate >= '$poDtFrom'";
        }
        
        if($poDtTo != ""){
            $sql .= " AND purchaseorderheader.dtmDate <= '$poDtTo'";
        }
        break;
        
    case 2:
        
        if($poDtFrom != ""){
            $sql .= " AND purchaseorderheader.dtmETA >= '$poDtFrom'";
        }
        
        if($poDtTo != ""){
            $sql .= " AND purchaseorderheader.dtmETA <= '$poDtTo'";
        }
        break;
        
       
    
}
               

$sql .= " GROUP BY specification.intSRNO, orders.strStyle, orders.strDescription, purchaseorderheader.intYear, purchaseorderheader.intPONo, suppliers.strTitle, purchaseorderheader.dtmDate, matitemlist.strItemDescription,
          matitemlist.intItemSerial, purchaseorderheader.dtmETA,purchaseorderdetails.strUnit ";
    
//echo $sql;    
$result = $db->RunQuery($sql);

while($row = mysql_fetch_array($result)){
    
    $scNo               = $row["intSRNO"];
    $styleId            = $row["strStyle"];
    $styleDescription   = $row["strDescription"];
    $poNo               = $row["intYear"]."/".$row["intPONo"];
    $supplierName       = $row["strTitle"];
    $itemDescription    = $row["strItemDescription"];
    $uom                = $row["strUnit"];
    $orderedQty         = $row["OrderedQty"];
    $receivedQty        = $row["RcvdQty"];
    $poDate             = date("Y-m-d",strtotime($row["dtmDate"]));
    $poETADate          = date("Y-m-d",strtotime($row["dtmETA"]));
    $grnDate            = date("Y-m-d",strtotime($row["First_GRN"]));
    $dtADD              = date("Y-m-d",strtotime($row["dtmADD"]));
    $dtACD              = date("Y-m-d",strtotime($row["dtmACD"]));
    $dtETD              = date("Y-m-d",strtotime($row["dtmETD"]));
    $deliveryTo         = $row["Delivery_To"];
    
    
    $poETADate = ($poETADate == "1970-01-01"? "-":$poETADate);
    $grnDate = ($grnDate == "1970-01-01"? "-":$grnDate);
    $dtADD = ($dtADD == "1970-01-01"? "-": $dtADD);
    $dtACD = ($dtACD == "1970-01-01"? "-": $dtACD);
    
    
    $dayReached = 0;
    /*
     * Comment By - Nalin Jayakody
     * Comment On - 07/07/2017
     * Comment For - Calculate 'number of days taken to reached' by Actual Delivery Date instead of ETA date and take PI date as ETD date instead of ETA
     *               Request by Sarathsiri
     * ====================================================================
     */    
    //$dayReached = abs(strtotime($poETADate) - strtotime($grnDate));
    /* ==================================================================== */
    $dayReached = abs(strtotime($dtETD) - strtotime($dtADD));
    $dayReached = floor($dayReached / (60*60*24));
    
    $dayReached = ($dayReached > 500 ? 0: $dayReached);
    $dblRcvdOrdered = round(($receivedQty / $orderedQty) * 100,2);
    
    
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowNum,$scNo);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$rowNum,$styleId);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowNum,$styleDescription);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowNum,$poNo);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowNum,$supplierName);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowNum,$itemDescription);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowNum,$uom);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowNum,$orderedQty);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowNum,$receivedQty);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowNum,$dblRcvdOrdered);    
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$rowNum,$poDate);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$rowNum,$dtETD);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$rowNum,$grnDate);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$rowNum,$dayReached);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$rowNum,$deliveryTo);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$rowNum,$dtADD);
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16,$rowNum,$dtACD);
    
    $rowNum++;
}

// Save excel file in the local machine
// ==========================================
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$file.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output'); 
echo 'done';
exit;

?>
