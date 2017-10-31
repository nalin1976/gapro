<?php
session_start();

set_time_limit(0);

include "../Connector.php";

/*ini_set("display_errors", 1);
ini_set('memory_limit', '-1');
error_reporting(E_ALL);*/
require_once '../excel/Classes/PHPExcel.php';
require_once '../excel/Classes/PHPExcel/IOFactory.php';

$file = 'xlsAgeAnalysis.xls';
if (!file_exists($file)) {
	exit("Can't find - $file");
}

$styleArray = array(
  'font' => array(
    'size' => 10
  )
);

$styleArrayTotal = array(
  'font' => array(
    'size' => 10, 
    'bold' => true  
  )
);

$styleArrayHeader = array(
  'font' => array(
    'size' => 18, 
    'bold' => true  
  )
);



$mainId1         = $_GET["mainId"];
$subId          = $_GET["subCatId"];
$matItem	= $_GET["ItemID"];
$mainStores	= $_GET["mainStore"];
$color          = $_GET["color"];
$size		= $_GET["size"];
$txtmatItem     = $_GET["itemDesc"];
$tdate          = date('Y-m-d');
$subStoreID     = $_GET["subStoreId"];
$buyerId        = $_GET["buyerId"];

$report_companyId =$_SESSION["FactoryID"];

$objPHPExcel = PHPExcel_IOFactory::load($file);

# Variable declaration
$totalQty   = 0;
$totalValue = 0;

$totalQty30 = 0;
$totalQty60 = 0;
$totalQty90 = 0;
$totalQty120 = 0;
$totalQty120Over = 0;

$totalVal30 = 0;
$totalVal60 = 0;
$totalVal90 = 0;
$totalVal120 = 0;
$totalVal120Over = 0;



$rowNum     = 6;
#---------------------------

$objPHPExcel->getActiveSheet()->getStyle("K3")->applyFromArray($styleArrayHeader);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,3,$tdate);


$sqlMainCat = "SELECT intID, strDescription FROM matmaincategory WHERE intID>0 ";
if($mainId1!='')
    $sqlMainCat .= " AND intID=$mainId1";
$sqlMainCat .= " LIMIT 3";
		  
$resultMainCat = $db->RunQuery($sqlMainCat);

while($rowMainCat = mysql_fetch_array($resultMainCat))
{
    
    $strMainItem = $rowMainCat["strDescription"];
    $mainId      = $rowMainCat['intID'];
    
    $sql = "SELECT * FROM ";
         
         $sql .= "(SELECT
stocktransactions.intMatDetailId,
stocktransactions.strUnit,
matitemlist.strItemDescription,
specification.intSRNO,
specification.intStyleId,
buyers.strName,
orders.intStatus,
orders.strStyle,
stocktransactions.strBuyerPoNo,
orders.intQty,
mainstores.strName AS MainStores,
matitemlist.intMainCatID,
mainstores.strMainID
FROM
stocktransactions
Inner Join matitemlist ON stocktransactions.intMatDetailId = matitemlist.intItemSerial
Inner Join specification ON stocktransactions.intStyleId = specification.intStyleId
Inner Join orders ON specification.intStyleId = orders.intStyleId
Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID
INNER JOIN mainstores on mainstores.strMainID = stocktransactions.strMainStoresID
where stocktransactions.strMainStoresID>0 "; //AND stocktransactions.intStyleId = 3463
		if($mainStores != '')
			$sql .=" and stocktransactions.strMainStoresID =$mainStores ";			
		if($mainId!='')
			$sql .=" and matitemlist.intMainCatID =$mainId ";	
		if($subId!='')
			$sql .=" and matitemlist.intSubCatID =$subId ";
		if($matItem!='')
			$sql .=" and stocktransactions.intMatDetailId =$matItem ";	
		if($color!='')
			$sql .=" and stocktransactions.strColor ='$color' ";
		if($size!='')
			$sql .=" and stocktransactions.strSize ='$size' ";	
		if($txtmatItem!='')
			$sql .=" and matitemlist.strItemDescription like '%$txtmatItem%' ";
                if($subStoreID!='')
                        $sql .=" and stocktransactions.strSubStores = $subStoreID ";
                if($buyerId != '')
                        $sql .= " and buyers.intBuyerID = $buyerId";
    $sql .= " group by intSRNO, strItemDescription, stocktransactions.strBuyerPoNo, mainstores.strName) A" ;
    
    $sql .= " UNION ";
    $sql .= "SELECT * FROM ";
    
    $sql .= "( SELECT
stocktransactions_history.intMatDetailId,
stocktransactions_history.strUnit,
matitemlist.strItemDescription,
specification.intSRNO,
specification.intStyleId,
buyers.strName,
orders.intStatus,
orders.strStyle,
stocktransactions_history.strBuyerPoNo,
orders.intQty,
mainstores.strName AS MainStores,
matitemlist.intMainCatID,
mainstores.strMainID
FROM
stocktransactions_history
Inner Join matitemlist ON stocktransactions_history.intMatDetailId = matitemlist.intItemSerial
Inner Join specification ON stocktransactions_history.intStyleId = specification.intStyleId
Inner Join orders ON specification.intStyleId = orders.intStyleId
Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID
INNER JOIN mainstores on mainstores.strMainID = stocktransactions_history.strMainStoresID
where stocktransactions_history.strMainStoresID>0 "; //AND stocktransactions_history.intStyleId = 3463
    if($mainStores != '')
			$sql .=" and stocktransactions_history.strMainStoresID =$mainStores ";			
		if($mainId!='')
			$sql .=" and matitemlist.intMainCatID =$mainId ";	
		if($subId!='')
			$sql .=" and matitemlist.intSubCatID =$subId ";
		if($matItem!='')
			$sql .=" and stocktransactions_history.intMatDetailId =$matItem ";	
		if($color!='')
			$sql .=" and stocktransactions_history.strColor ='$color' ";
		if($size!='')
			$sql .=" and stocktransactions_history.strSize ='$size' ";	
		if($txtmatItem!='')
			$sql .=" and matitemlist.strItemDescription like '%$txtmatItem%' ";
                if($subStoreID!='')
                        $sql .=" and stocktransactions_history.strSubStores = $subStoreID ";
                if($buyerId != '')
                        $sql .= " and buyers.intBuyerID = $buyerId";
    $sql .= " group by intSRNO, strItemDescription, stocktransactions_history.strBuyerPoNo, mainstores.strName ) B" ;
    
    $result = $db->RunQuery($sql);
    
    while($row = mysql_fetch_array($result)){
        
        $totRowQty1 = 0;
        $totRowVal  = 0;
        $totQty30   = 0;
        $totQty60   = 0;
        $totQty90   = 0;
        $totQty120   = 0;
        $totQty120More   = 0;
        $totLineQty = 0;
        
        $totQtyVal30 = 0;
        $totQtyVal60 = 0;
        $totQtyVal90 = 0;
        $totQtyVal20 = 0;
        $totQtyVal20More = 0;
        $totLineValue = 0;        

        $matDetailID        = $row["intMatDetailId"];
        $mainStores         = $row["strMainID"];
        $strUOM             = $row["strUnit"];
        $strItemDescription = $row["strItemDescription"];
        $strBuyerPO         = $row["strBuyerPoNo"];
        $strBuyerName       = $row["strName"];
        $strStyleId         = $row["strStyle"];
        $strSCNo            = $row["intSRNO"];
        $strMainStores      = $row["MainStores"];
        
        $dblOrderQty        = $row["intQty"];
        
        
        # Get 30 days old stock qty
        # =======================================
        $styleGRNstockQty30 = getStock30daysQty('stocktransactions',$row["intMatDetailId"],0,30,$tdate,$mainStores,$color,$size, $row['intStyleId'],$row["strBuyerPoNo"],$subStoreID);
        $styleGRNleftQty30 =getStock30daysQty('stocktransactions_history',$row["intMatDetailId"],0,30,$tdate,$mainStores,$color,$size, $row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
        # =======================================
        
        # Get 60 days old stock qty
        # =======================================
        $styleGRNstockQty60 = getStock30daysQty('stocktransactions',$row["intMatDetailId"],31,60,$tdate,$mainStores,$color,$size, $row['intStyleId'],$row["strBuyerPoNo"],$subStoreID);
        $styleGRNleftQty60 =getStock30daysQty('stocktransactions_history',$row["intMatDetailId"],31,60,$tdate,$mainStores,$color,$size, $row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
        # =======================================
        
        # Get 90 days old stock qty
        # =======================================
        $styleGRNstockQty90 = getStock30daysQty('stocktransactions',$row["intMatDetailId"],61,90,$tdate,$mainStores,$color,$size, $row['intStyleId'],$row["strBuyerPoNo"],$subStoreID);
        $styleGRNleftQty90 =getStock30daysQty('stocktransactions_history',$row["intMatDetailId"],61,90,$tdate,$mainStores,$color,$size, $row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
        # =======================================
        
        # Get 120 days old stock qty
        # =======================================
        $styleGRNstockQty120 = getStock30daysQty('stocktransactions',$row["intMatDetailId"],91,120,$tdate,$mainStores,$color,$size, $row['intStyleId'],$row["strBuyerPoNo"],$subStoreID);
        $styleGRNleftQty120 =getStock30daysQty('stocktransactions_history',$row["intMatDetailId"],91,120,$tdate,$mainStores,$color,$size, $row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
        # =======================================
        
        # Get 120 days or more old stock qty
        # =======================================
        $styleGRNstockQty120More = getStock30daysQty('stocktransactions',$row["intMatDetailId"],120,120,$tdate,$mainStores,$color,$size, $row['intStyleId'],$row["strBuyerPoNo"],$subStoreID);
        $styleGRNleftQty120More =getStock30daysQty('stocktransactions_history',$row["intMatDetailId"],120,120,$tdate,$mainStores,$color,$size, $row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
        # =======================================
        
        
        
        
        
        # Get 30 days old stock value
        # =======================================
        $styleGRNstockVal30 = getStockQtyValue('stocktransactions',$row["intMatDetailId"],0,30,$tdate,$mainStores,$color,$size,$row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
        $styleGRNleftVal30 = getStockQtyValue('stocktransactions_history',$row["intMatDetailId"],0,30,$tdate,$mainStores,$color,$size, $row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
        # =======================================
        
        # Get 60 days old stock value
        # =======================================
        $styleGRNstockVal60 = getStockQtyValue('stocktransactions',$row["intMatDetailId"],31,60,$tdate,$mainStores,$color,$size,$row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
        $styleGRNleftVal60 = getStockQtyValue('stocktransactions_history',$row["intMatDetailId"],31,60,$tdate,$mainStores,$color,$size, $row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
        # =======================================
        
        # Get 90 days old stock value
        # =======================================
        $styleGRNstockVal90 = getStockQtyValue('stocktransactions',$row["intMatDetailId"],61,90,$tdate,$mainStores,$color,$size,$row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
        $styleGRNleftVal90 = getStockQtyValue('stocktransactions_history',$row["intMatDetailId"],61,90,$tdate,$mainStores,$color,$size, $row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
        # =======================================
        
        # Get 120 days old stock value
        # =======================================
        $styleGRNstockVal20 = getStockQtyValue('stocktransactions',$row["intMatDetailId"],91,120,$tdate,$mainStores,$color,$size,$row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
        $styleGRNleftVal120 = getStockQtyValue('stocktransactions_history',$row["intMatDetailId"],91,120,$tdate,$mainStores,$color,$size, $row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
        # =======================================
        
        # Get 120 days or more old stock value
        # =======================================
        $styleGRNstockVal120More = getStockQtyValue('stocktransactions',$row["intMatDetailId"],120,120,$tdate,$mainStores,$color,$size,$row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
        $styleGRNleftVal120More = getStockQtyValue('stocktransactions_history',$row["intMatDetailId"],120,120,$tdate,$mainStores,$color,$size, $row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
        # =======================================
        
        $totQty30       = $styleGRNstockQty30 + $styleGRNleftQty30;
        $totQty60       = $styleGRNstockQty60 + $styleGRNleftQty60;
        $totQty90       = $styleGRNstockQty90 + $styleGRNleftQty90;
        $totQty120      = $styleGRNstockQty120 + $styleGRNleftQty120;
        $totQty120More  = $styleGRNstockQty120More + $styleGRNleftQty120More;
        
        $totQtyVal30    = $styleGRNstockVal30 + $styleGRNleftVal30;
        $totQtyVal60    = $styleGRNstockVal60 + $styleGRNleftVal60; 
        $totQtyVal90    = $styleGRNstockVal90 + $styleGRNleftVal90;
        $totQtyVal20    = $styleGRNstockVal20 + $styleGRNleftVal120;
        $totQtyVal120More = $styleGRNstockVal120More + $styleGRNleftVal120More;
        
        $totLineQty = $totQty30 + $totQty60 + $totQty90 + $totQty120 + $totQty120More;
        $totLineValue = $totQtyVal30 + $totQtyVal60 + $totQtyVal90 + $totQtyVal20 + $totQtyVal120More;
        
        if($totLineQty > 0){
            
            $objPHPExcel->getActiveSheet()->getStyle("A".$rowNum.":V".$rowNum)->applyFromArray($styleArray);
        
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$rowNum,$strMainStores);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$rowNum,$strMainItem);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$rowNum,$strSCNo);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$rowNum,$strStyleId);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$rowNum,$strBuyerName);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$rowNum,$strBuyerPO);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$rowNum,$dblOrderQty);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$rowNum,$strItemDescription);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$rowNum,$strUOM);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$rowNum,$totQty30);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$rowNum,$totQtyVal30);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$rowNum,$totQty60);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$rowNum,$totQtyVal60);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$rowNum,$totQty90);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$rowNum,$totQtyVal90);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16,$rowNum,$totQty120);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17,$rowNum,$totQtyVal20);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18,$rowNum,$totQty120More);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19,$rowNum,$totQtyVal120More);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20,$rowNum,$totLineQty);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21,$rowNum,$totLineValue);


            $totalQty30 += $totQty30;
            $totalQty60 += $totQty60;
            $totalQty90 += $totQty90;
            $totalQty120 += $totQty120;
            $totalQty120Over += $totQty120More;

            $totalVal30 += $totQtyVal30;
            $totalVal60 += $totQtyVal60;
            $totalVal90 += $totQtyVal90;
            $totalVal120 += $totQtyVal20;
            $totalVal120Over += $totQtyVal120More;


            $rowNum++;

        }
        
        
        
    }
    
    $rowNum++;
    
    $objPHPExcel->getActiveSheet()->getStyle("A".$rowNum.":V".$rowNum)->applyFromArray($styleArrayTotal);
    $objPHPExcel->getActiveSheet()->getStyle("A".$rowNum.":V".$rowNum)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$rowNum,number_format($totalQty30,2));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$rowNum,number_format($totalVal30,2));    
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$rowNum,number_format($totalQty60,2));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$rowNum,number_format($totalVal60,2));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$rowNum,number_format($totalQty90,2));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$rowNum,number_format($totalVal90,2));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16,$rowNum,number_format($totalQty120,2));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17,$rowNum,number_format($totalVal120,2));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18,$rowNum,number_format($totalQty120Over,2));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19,$rowNum,number_format($totalVal120Over,2));
    
    $grandTotalQty = $totalQty30 + $totalQty60 + $totalQty90 + $totalQty120 + $totalQty120Over;
    $grandTotalVal = $totalVal30 + $totalVal60 + $totalVal90 + $totalVal120 + $totalVal120Over;
            
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20,$rowNum,number_format($grandTotalQty,2));
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21,$rowNum,number_format($grandTotalVal,2));
    
    
    
    
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
// ==========================================

# ============================================================
# Function section
function getStock30daysQty($tbl,$matDetailID,$dayFrom,$dayTo,$tdate,$mainStores,$color,$size,$prmStyleId, $prmBuyerPO, $prmSubStoreId)
{
	global $db;
        
        $dbl30DaysQty = 0;
        
	if($tbl != 'stocktransactions_bulk')
	{
		//get style grn qty in stocktransactions and  stocktransactions_leftover
		$sql = "select  round(sum(st.dblQty),2) as qty 
		from $tbl st inner join grnheader gh on gh.intGrnNo=st.intGrnNo 
		 and gh.intGRNYear = st.intGrnYear
		where st.intMatDetailId=$matDetailID   and st.strGRNType='S' and st.intStyleId=$prmStyleId and st.strBuyerPoNo = '$prmBuyerPO' ";
		if($dayFrom == '120')
			$sql .= " and 	(TO_DAYS('$tdate')-TO_DAYS(dtmConfirmedDate) > $dayFrom  ) "; //having sum(st.dblQty)>0.05
		else
			$sql .= " and 	(TO_DAYS('$tdate')-TO_DAYS(dtmConfirmedDate) between $dayFrom and $dayTo )";
		if($tbl == 'stocktransactions_temp')
			$sql .= " and gh.intStatus =1 and st.strType = 'GRN' ";		
		
	}
	else
	{
		$sql = " select round(sum(st.dblQty),2) as qty
					FROM
					stocktransactions_bulk AS st
					INNER JOIN bulkgrnheader AS gh ON gh.intBulkGrnNo = st.intBulkGrnNo AND gh.intYear = st.intBulkGrnYear
					INNER JOIN bulkpurchaseorderheader ON gh.intBulkPoNo = bulkpurchaseorderheader.intBulkPoNo AND gh.intBulkPoYear = bulkpurchaseorderheader.intYear
					where st.intMatDetailId=$matDetailID AND bulkpurchaseorderheader.strBulkPOType!='1' ";
		if($dayFrom == '120')
			$sql .= " and (TO_DAYS('$tdate')-TO_DAYS(gh.dtmConfirmedDate) > $dayFrom  )";
		else
			$sql .= " and (TO_DAYS('$tdate')-TO_DAYS(gh.dtmConfirmedDate) between $dayFrom and $dayTo )";
	}		
	if($mainStores != '')
            $sql .= " and  st.strMainStoresID='$mainStores' ";
	if($color != '')
            $sql .= " and  st.strColor='$color' ";	
	if($size != '')
            $sql .= " and  st.strSize='$size' ";
        if($prmSubStoreId != '')
            $sql .= " and  st.strSubStores='$prmSubStoreId' ";
	
	/*==================================================================
	  Comment on  - 09/30/2014 - Nalin Jayakody
	  Description - to avoid to get qtys less than or equal 0.05
	*/
	 //$sql.=" having sum(st.dblQty)>0 ";	
	 /*==================================================================*/
	 $sql.=" having sum(st.dblQty)>0.2 ";	
	//	echo $sql ."<br />";
	/*if($matDetailID==3429 && $dayFrom == '120')
		echo $sql;*/
	$result = $db->RunQuery($sql);
	//echo print_r($result);
	//$row = mysql_fetch_array($result);
	
        while($row = mysql_fetch_array($result)){
             return $row["qty"];
        }
        
        //return $dbl30DaysQty;
						
}

function getStockQtyValue($tbl,$matDetailID,$dayFrom,$dayTo,$tdate,$mainStores,$color,$size,$prmStyleId, $prmBuyerPO, $prmSubStoreId)
{
	global $db;
	if($tbl != 'stocktransactions_bulk')
	{
		//get style grn qty in stocktransactions and  stocktransactions_leftover
		$sql = "select  round(sum(st.dblQty),2) as qty,st.intMatDetailId,st.intGrnNo,st.intGrnYear ,st.intStyleId,st.strGRNType,st.strColor,st.strSize 
		from $tbl st inner join grnheader gh on gh.intGrnNo=st.intGrnNo 
		 and gh.intGRNYear = st.intGrnYear
		where st.intMatDetailId=$matDetailID and st.intStyleId=$prmStyleId AND st.strBuyerPoNo = '$prmBuyerPO' ";
		if($dayFrom == '120')
			$sql .= " and 	(TO_DAYS('$tdate')-TO_DAYS(gh.dtmConfirmedDate) > $dayFrom  )";
		else
			$sql .= " and 	(TO_DAYS('$tdate')-TO_DAYS(gh.dtmConfirmedDate) between $dayFrom and $dayTo )";
		if($tbl == 'stocktransactions_temp')
			$sql .= " and gh.intStatus =1 and st.strType = 'GRN' ";
	}
	else
	{
		$sql = " SELECT
					round(sum(st.dblQty),2) AS qty,
					st.intMatDetailId,
					st.intBulkGrnNo AS intGrnNo,
					st.intBulkGrnYear AS intGrnYear,
					'style' AS intStyleId,
					'B' AS strGRNType,
					st.strColor,
					st.strSize
					from stocktransactions_bulk st inner join bulkgrnheader gh on gh.intBulkGrnNo=st.intBulkGrnNo and gh.intYear =st.intBulkGrnYear 					INNER JOIN bulkpurchaseorderheader ON gh.intBulkPoNo = bulkpurchaseorderheader.intBulkPoNo AND gh.intBulkPoYear = bulkpurchaseorderheader.intYear
where st.intMatDetailId=$matDetailID  AND bulkpurchaseorderheader.strBulkPOType!='1' ";
		if($dayFrom == '120')
			$sql .= " and (TO_DAYS('$tdate')-TO_DAYS(gh.dtmConfirmedDate) > $dayFrom  )";
		else
			$sql .= " and (TO_DAYS('$tdate')-TO_DAYS(gh.dtmConfirmedDate) between $dayFrom and $dayTo )";
	}		
	if($mainStores != '')
		$sql .= " and  st.strMainStoresID='$mainStores' ";
	if($color != '')
		$sql .= " and  st.strColor='$color' ";	
	if($size != '')
		$sql .= " and  st.strSize='$size' ";
        if($prmSubStoreId != '')
            $sql .= " and  st.strSubStores='$prmSubStoreId' ";
        
	if($tbl != 'stocktransactions_bulk')
/*==================================================================
	  Comment on  - 09/30/2014 - Nalin Jayakody
	  Description - to avoid to get qtys less than or equal 0.05
*/	
/*		$sql .=" group by st.intMatDetailId,st.intGrnNo,st.intGrnYear,intStyleId,st.strGRNType,st.strColor,st.strSize
having qty > 0 "; */

/*================================================================== */
		$sql .=" group by st.intMatDetailId,st.intGrnNo,st.intGrnYear,intStyleId,st.strGRNType,st.strColor,st.strSize
having sum(st.dblQty)> 0.1 ";

	else
		$sql .= " group by st.intMatDetailId,st.intBulkGrnNo,st.intBulkGrnYear,st.strColor,st.strSize
having sum(st.dblQty)>0.1";	



//if($dayFrom==31 && $dayTo==60)
	//echo $sql;
	$grnValue = 0;
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$grnQty = $row["qty"];
		$grnValue += getGRNValue($grnQty,$row["intGrnNo"],$row["intGrnYear"],$row["strGRNType"],$row["intStyleId"],$row["intMatDetailId"],$row["strColor"],$row["strSize"]);
	}
	return 	round($grnValue,4);					
}

function getGRNValue($grnQty,$grnNo,$grnYear,$grnType,$styleID,$matdetailID,$color,$size)
{
	global $db;
        
        $grnValue = 0;
        
	if($grnType == 'S')
	{
		$sql = " select gd.dblInvoicePrice as grnprice,gh.dblExRate as exRate
from grnheader gh inner join grndetails gd on
gh.intGrnNo = gd.intGrnNo and gh.intGRNYear = gd.intGRNYear
where gh.intGrnNo='$grnNo' and gh.intGRNYear='$grnYear' and gd.intMatDetailID='$matdetailID' 
 and gd.intStyleId='$styleID' and gd.strColor ='$color' and  gd.strSize = '$size' ";
	}
	else if($grnType == 'B')
	{
		$sql = " select gd.dblRate as grnprice,gh.dblRate as exRate
from bulkgrnheader gh inner join bulkgrndetails gd on
gh.intBulkGrnNo = gd.intBulkGrnNo and gh.intYear = gd.intYear
where gh.intBulkGrnNo='$grnNo'  and gh.intYear='$grnYear' and intMatDetailID='$matdetailID' and gd.strColor='$color' and gd.strSize = '$size'";
	}
	
	$result = $db->RunQuery($sql);
	//$row = mysql_fetch_array($result);
	//echo $sql."<br />";
	//$grnValue = $grnQty*$row["grnprice"]/$row["exRate"];
	//return $grnValue;
        
        while($row = mysql_fetch_array($result)){
           $grnValue = $grnQty*$row["grnprice"]/$row["exRate"]; 
        }
        
        return $grnValue;
}

# ============================================================

?>

