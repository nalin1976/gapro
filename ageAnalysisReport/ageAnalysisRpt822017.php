<?php 
session_start();
 $backwardseperator = "../";
set_time_limit(0);
ignore_user_abort(1);
 
 $mainId1       = $_GET["mainId"];
 $subId         = $_GET["subCatId"];
 $matItem	= $_GET["ItemID"];
 $mainStores	= $_GET["mainStore"];
 $color 	= $_GET["color"];
 $size		= $_GET["size"];
 $txtmatItem    = $_GET["itemDesc"];
 $tdate         = date('Y-m-d');
 $subStoreID    = $_GET["subStoreId"];
 
 $report_companyId =$_SESSION["FactoryID"];
 
 $deci = 2; //no of decimal places
 $time = date('H:i:s');
 


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Style Age Analysis Report</title>
<link href="../css/erpstyle.css" type="text/css" rel="stylesheet" />

</head>

<body>
<?php 
include "../Connector.php";

?>
<table width="1150" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><table width="1050" border="0" cellspacing="0" cellpadding="0">
       <tr>
        <td><?php include $backwardseperator.'reportHeader.php'; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="head2BLCK">Style Age Analysis Report as at - <?php echo date('d-F-Y'); ?> <span class="normalfnt"><?php echo $time; ?></span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="1150" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
        <thead>
          <tr bgcolor="#CCCCCC" class="normalfntMid">
            <th width="50" >Store Location</th>  
            <th width="50" >Item Type</th>
            <th width="70" >SC No</th>
            <th width="70" >Style ID</th>
            <th width="70" >Buyer Name</th>
            <th width="70" >Buyer PO No</th>
            <th width="70" >Order Qty</th>
            <th width="70" >Order Status</th>
            <th width="149"  height="23">Item Description </th>            
            <th width="59" >Unit</th>
            <th width="60" nowrap>Qty(1-30)</th>
            <th width="65" nowrap>val(1-30)</th>
            <th width="69" nowrap>Qty(31-60)</th>
            <th width="76" nowrap>val(31-60)</th>
            <th width="67" nowrap>Qty(61-90)</th>
            <th width="73" nowrap>val(61-90)</th>
            <th width="64" nowrap>Qty(91-120)</th>
            <th width="85" nowrap>val(91-120)</th>
            <th width="52" nowrap>Qty(Over 120)</th>
            <th width="58" nowrap>Value(Over 120)</th>
            <th width="64" nowrap>Total Qty</th>
            <th width="66" nowrap>Total Val</th>
            <th width="66" nowrap>Item Code</th>
          </tr>
          </thead>
          <tbody>
          <?php 
		  //get base currency details
		  $baseCurrncy = getBaseCurrency();
		  $totQty = 0;
		  $totValue = 0;
		  //get items in the stock
		  
		 		  $sqlMainCat = "SELECT intID, strDescription FROM matmaincategory WHERE intID>0 ";
		 if($mainId1!='')
		  	$sqlMainCat .= " AND intID=$mainId1";
		$sqlMainCat .= " LIMIT 3";
		  
		  $resultMainCat = $db->RunQuery($sqlMainCat);
		  
		  while($rowMainCat = mysql_fetch_array($resultMainCat))
		  {
			  
			 $sumCatQty30 = 0;
			 $sumCatVal30 = 0;
			 
			 $sumCatQty60 = 0;
			 $sumCatVal60 = 0;
			 
			 $sumCatQty90 = 0;
			 $sumCatVal90 = 0;
			 
			 $sumCatQty120 = 0;
			 $sumCatVal120 = 0;
			 
			 $sumCatQtyOver120 = 0;
			 $sumCatValOver120 = 0;
			 
			 $sumRowQty = 0;
			 $sumRowVal = 0;
			  
		  	$mainId = $rowMainCat['intID'];
			
		?>
        
         <tr bgcolor="#CCCCCC" class="normalfntMid">
            <td  height="23" colspan="23" ><b><?php echo $rowMainCat['strDescription']; ?></b></td>
            </tr>
            
         <?php
         
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
    $sql .= " group by intSRNO, strItemDescription, stocktransactions_history.strBuyerPoNo, mainstores.strName ) B" ;
    
    //echo $sql;
         // ====================================================================
         // Change By - Nalin Jayakody
         // Change On - 01/26/2017
         // Change For - To enhance the report, adding buyer po wise and order status
         // ====================================================================
	/*	 $sql = "(SELECT
stocktransactions.intMatDetailId,
stocktransactions.strUnit,
matitemlist.strItemDescription,
specification.intSRNO,
specification.intStyleId,
buyers.strName
FROM
stocktransactions
Inner Join matitemlist ON stocktransactions.intMatDetailId = matitemlist.intItemSerial
Inner Join specification ON stocktransactions.intStyleId = specification.intStyleId
Inner Join orders ON specification.intStyleId = orders.intStyleId
Inner Join buyers ON orders.intBuyerID = buyers.intBuyerID
where stocktransactions.strMainStoresID>0 ";
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
	*/	
		//$sql .= " ) ";
	/*	$sql .= "
union 
(select mil.strItemDescription,st.intMatDetailId,mil.strUnit, sp.intSRNO, sp.intStyleId
from stocktransactions_temp st inner join  matitemlist mil on mil.intItemSerial= st.intMatDetailId inner join specification sp on sp.intStyleId = st.intStyleId inner join specificationdetails sd on sd.intStyleId = st.intStyleId and sd.strMatDetailID = st.intMatDetailId
where st.strMainStoresID>0  ";
		if($mainStores != '')
			$sql .=" and st.strMainStoresID =$mainStores ";			
		if($mainId!='')
			$sql .=" and mil.intMainCatID =$mainId ";	
		if($subId!='')
			$sql .=" and mil.intSubCatID =$subId ";
		if($matItem!='')
			$sql .=" and st.intMatDetailId =$matItem ";	
		if($color!='')
			$sql .=" and st.strColor ='$color' ";
		if($size!='')
			$sql .=" and st.strSize ='$size' ";	
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
			
	$sql .= " and st.intMatDetailId not in 
(select stt.intMatDetailId from stocktransactions stt inner join matitemlist mil on mil.intItemSerial= stt.intMatDetailId
 where stt.intMatDetailId = st.intMatDetailId ";
 		if($mainStores != '')
			$sql .=" and stt.strMainStoresID =$mainStores ";			
		if($mainId!='')
			$sql .=" and mil.intMainCatID =$mainId ";	
		if($subId!='')
			$sql .=" and mil.intSubCatID =$subId ";
		if($matItem!='')
			$sql .=" and stt.intMatDetailId =$matItem ";	
		if($color!='')
			$sql .=" and stt.strColor ='$color' ";
		if($size!='')
			$sql .=" and stt.strSize ='$size' ";	
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
 	$sql .= " )) "; */
	/*$sql .=" union
 (select mil.strItemDescription,st.intMatDetailId,mil.strUnit, sp.intSRNO, sp.intStyleId
from stocktransactions_leftover st inner join  matitemlist mil on mil.intItemSerial= st.intMatDetailId inner join specification sp on sp.intStyleId = st.intStyleId inner join specificationdetails sd on sd.intStyleId = st.intStyleId and sd.strMatDetailID = st.intMatDetailId
where st.strMainStoresID>0  ";
	if($mainStores != '')
			$sql .=" and st.strMainStoresID =$mainStores ";			
		if($mainId!='')
			$sql .=" and mil.intMainCatID =$mainId ";	
		if($subId!='')
			$sql .=" and mil.intSubCatID =$subId ";
		if($matItem!='')
			$sql .=" and st.intMatDetailId =$matItem ";	
		if($color!='')
			$sql .=" and st.strColor ='$color' ";
		if($size!='')
			$sql .=" and st.strSize ='$size' ";	
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
	$sql .= " and st.intMatDetailId not in 
(select stt.intMatDetailId from stocktransactions stt inner join matitemlist mil on mil.intItemSerial= stt.intMatDetailId
 where stt.intMatDetailId = st.intMatDetailId ";
 	if($mainStores != '')
			$sql .=" and stt.strMainStoresID =$mainStores ";			
		if($mainId!='')
			$sql .=" and mil.intMainCatID =$mainId ";	
		if($subId!='')
			$sql .=" and mil.intSubCatID =$subId ";
		if($matItem!='')
			$sql .=" and stt.intMatDetailId =$matItem ";	
		if($color!='')
			$sql .=" and stt.strColor ='$color' ";
		if($size!='')
			$sql .=" and stt.strSize ='$size' ";	
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
 	$sql .=" )  ) ";*/
 	/*$sql .= " union
 (select mil.strItemDescription,st.intMatDetailId,mil.strUnit
from bulkstock_view st inner join  matitemlist mil on mil.intItemSerial= st.intMatDetailId
where st.strMainStoresID>0 ";
	if($mainStores != '')
			$sql .=" and st.strMainStoresID =$mainStores ";			
		if($mainId!='')
			$sql .=" and mil.intMainCatID =$mainId ";	
		if($subId!='')
			$sql .=" and mil.intSubCatID =$subId ";
		if($matItem!='')
			$sql .=" and st.intMatDetailId =$matItem ";	
		if($color!='')
			$sql .=" and st.strColor ='$color' ";
		if($size!='')
			$sql .=" and st.strSize ='$size' ";	
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
	$sql .= " and st.intMatDetailId not in 
(select stt.intMatDetailId from stocktransactions stt inner join matitemlist mil on mil.intItemSerial= stt.intMatDetailId
 where stt.intMatDetailId = st.intMatDetailId ";
 if($mainStores != '')
			$sql .=" and stt.strMainStoresID =$mainStores ";			
		if($mainId!='')
			$sql .=" and mil.intMainCatID =$mainId ";	
		if($subId!='')
			$sql .=" and mil.intSubCatID =$subId ";
		if($matItem!='')
			$sql .=" and stt.intMatDetailId =$matItem ";	
		if($color!='')
			$sql .=" and stt.strColor ='$color' ";
		if($size!='')
			$sql .=" and stt.strSize ='$size' ";	
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
 	$sql .= " )  )";*/
 //$sql .= " order by intSRNO, strItemDescription ";
 /*$sql .= " group by intSRNO, strItemDescription, stocktransactions.strBuyerPoNo ";
 $sql .= " ) ";*/
 //echo $sql;
 
				$result = $db->RunQuery($sql);
				
				while($row = mysql_fetch_array($result))
					{
						$totRowQty1=0;
						$totRowVal =0;
						//$_dblTotOrderQty = 0;
						
						$matDetailID = $row["intMatDetailId"];
                                                $mainStores = $row["strMainID"];
                                                
						
		  ?>
          <?php 
$styleGRNstockQty30 = getStock30daysQty('stocktransactions',$row["intMatDetailId"],0,30,$tdate,$mainStores,$color,$size, $row['intStyleId'],$row["strBuyerPoNo"],$subStoreID);
//$styleGRNstockQty30 = 0;
//$bulkGRNstockQty30 = getStock30daysBulkQty('stocktransactions',$row["intMatDetailId"],0,30,$tdate,$mainStores,$color,$size);
//$bulkGRNstockQty30 = 0;
		
//$tempQty30 = getStock30daysQty('stocktransactions_temp',$row["intMatDetailId"],0,30,$tdate,$mainStores,$color,$size);
$tempQty30 = 0;

//$styleGRNleftQty30 =getStock30daysQty('stocktransactions_leftover',$row["intMatDetailId"],0,30,$tdate,$mainStores,$color,$size, $row['intStyleId']);
$styleGRNleftQty30 =getStock30daysQty('stocktransactions_history',$row["intMatDetailId"],0,30,$tdate,$mainStores,$color,$size, $row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);

//$styleGRNleftQty30 = 0;
//$bulkGRNleftQty30 = getStock30daysBulkQty('stocktransactions_leftover',$row["intMatDetailId"],0,30,$tdate,$mainStores,$color,$size);
	$bulkGRNleftQty30 = 0;		
//$bulkQty30 = getStock30daysQty('stocktransactions_bulk',$row["intMatDetailId"],0,30,$tdate,$mainStores,$color,$size);
			$bulkQty30 = 0;
			$totQty30 = $styleGRNstockQty30 + $tempQty30 + $styleGRNleftQty30+$bulkQty30+$bulkGRNstockQty30+$bulkGRNleftQty30;
			//echo number_format($totQty30,2);
			
			$totRowQty1 += $totQty30;	
			?>
            <?php 
			$styleGRNstockVal30 = getStockQtyValue('stocktransactions',$row["intMatDetailId"],0,30,$tdate,$mainStores,$color,$size,$row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
				//$styleGRNstockVal30 = 0;
//$bulkGRNstockVal30 = getStockBulkValue('stocktransactions',$row["intMatDetailId"],0,30,$tdate,$mainStores,$color,$size);
	//$bulkGRNstockVal30 = 0;	
//$tempVal30 = getStockQtyValue('stocktransactions_temp',$row["intMatDetailId"],0,30,$tdate,$mainStores,$color,$size);
$tempVal30 = 0;
$styleGRNleftVal30 = getStockQtyValue('stocktransactions_history',$row["intMatDetailId"],0,30,$tdate,$mainStores,$color,$size, $row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
//$styleGRNleftVal30 = 0;
//$bulkGRNleftVal30 = getStockBulkValue('stocktransactions_leftover',$row["intMatDetailId"],0,30,$tdate,$mainStores,$color,$size);
	$bulkGRNleftVal30 = 0;
			
//$bulkVal30 = getStockQtyValue('stocktransactions_bulk',$row["intMatDetailId"],0,30,$tdate,$mainStores,$color,$size);
	$bulkVal30 = 0;		
			$totVal30 = $styleGRNstockVal30 + $bulkGRNstockVal30 + $tempVal30+$styleGRNleftVal30+$bulkGRNleftVal30+$bulkVal30;
			//echo number_format($totVal30,4);
			
			$totRowVal += $totVal30;	
  ?>
  <?php 
$styleGRNstockQty60 = getStock30daysQty('stocktransactions',$row["intMatDetailId"],31,60,$tdate,$mainStores,$color,$size, $row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
	//$styleGRNstockQty60 = 0;
//$bulkGRNstockQty60 = getStock30daysBulkQty('stocktransactions',$row["intMatDetailId"],31,60,$tdate,$mainStores,$color,$size);
		//$bulkGRNstockQty60 = 0;
		
//$tempQty60 = getStock30daysQty('stocktransactions_temp',$row["intMatDetailId"],31,60,$tdate,$mainStores,$color,$size);
$tempQty60 = 0;

//$styleGRNleftQty60 = getStock30daysQty('stocktransactions_leftover',$row["intMatDetailId"],31,60,$tdate,$mainStores,$color,$size, $row['intStyleId']);
$styleGRNleftQty60 = getStock30daysQty('stocktransactions_history',$row["intMatDetailId"],31,60,$tdate,$mainStores,$color,$size, $row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
//$styleGRNleftQty60 = 0;
	
//$bulkGRNleftQty60 = getStock30daysBulkQty('stocktransactions_leftover',$row["intMatDetailId"],31,60,$tdate,$mainStores,$color,$size);
	$bulkGRNleftQty60 = 0;
	
//$bulkQty60 = getStock30daysQty('stocktransactions_bulk',$row["intMatDetailId"],31,60,$tdate,$mainStores,$color,$size);
			$bulkQty60 = 0;
			$qty60 = $styleGRNstockQty60 + $tempQty60 + $styleGRNleftQty60+$bulkQty60+$bulkGRNstockQty60+$bulkGRNleftQty60;
						//echo number_format($qty60,2);
				$totRowQty1 += $qty60;		
			?>
          <?php 
			$styleGRNstockVal60 = getStockQtyValue('stocktransactions',$row["intMatDetailId"],31,60,$tdate,$mainStores,$color,$size,$row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
//$styleGRNstockVal60 = 0;
//$bulkGRNstockVal60 = getStockBulkValue('stocktransactions',$row["intMatDetailId"],31,60,$tdate,$mainStores,$color,$size);
	//$bulkGRNstockVal60 = 0;
		
//$tempVal60 = getStockQtyValue('stocktransactions_temp',$row["intMatDetailId"],31,60,$tdate,$mainStores,$color,$size);
$tempVal60 =0;

$styleGRNleftVal60 = getStockQtyValue('stocktransactions_history',$row["intMatDetailId"],31,60,$tdate,$mainStores,$color,$size, $row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
//$styleGRNleftVal60 = 0;
//$bulkGRNleftVal60 = getStockBulkValue('stocktransactions_leftover',$row["intMatDetailId"],31,60,$tdate,$mainStores,$color,$size);
  $bulkGRNleftVal60 = 0;
  
//$bulkVal60 = getStockQtyValue('stocktransactions_bulk',$row["intMatDetailId"],31,60,$tdate,$mainStores,$color,$size);
			$bulkVal60 = 0;
			$totVal60 = $styleGRNstockVal60 + $bulkGRNstockVal60 + $tempVal60+$styleGRNleftVal60+$bulkGRNleftVal60+$bulkVal60;
			//echo number_format($totVal60,4);
			
			$totRowVal += $totVal60;	
  ?>
  <?php 
$styleGRNstockQty90 = getStock30daysQty('stocktransactions',$row["intMatDetailId"],61,90,$tdate,$mainStores,$color,$size,$row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
				//$styleGRNstockQty90 = 0;
//$bulkGRNstockQty90 = getStock30daysBulkQty('stocktransactions',$row["intMatDetailId"],61,90,$tdate,$mainStores,$color,$size);
	//$bulkGRNstockQty90 = 0;	
//$tempQty90 = getStock30daysQty('stocktransactions_temp',$row["intMatDetailId"],61,90,$tdate,$mainStores,$color,$size);
$tempQty90 = 0;
//$styleGRNleftQty90 = getStock30daysQty('stocktransactions_leftover',$row["intMatDetailId"],61,90,$tdate,$mainStores,$color,$size,$row['intStyleId']);
$styleGRNleftQty90 = getStock30daysQty('stocktransactions_history',$row["intMatDetailId"],61,90,$tdate,$mainStores,$color,$size,$row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
//$styleGRNleftQty90 = 0;
//$bulkGRNleftQty90 = getStock30daysBulkQty('stocktransactions_leftover',$row["intMatDetailId"],61,90,$tdate,$mainStores,$color,$size);
	$bulkGRNleftQty90 = 0;
			
//$bulkQty90 = getStock30daysQty('stocktransactions_bulk',$row["intMatDetailId"],61,90,$tdate,$mainStores,$color,$size);
	$bulkQty90 = 0;
	$qty90 = $styleGRNstockQty90 + $bulkGRNstockQty90 +$tempQty90 + $styleGRNleftQty90 +$bulkGRNleftQty90 +$bulkQty90;
	
						//echo number_format($qty90,2);
						$totRowQty1 += $qty90;
			?>
            <?php 
			$styleGRNstockVal90 = getStockQtyValue('stocktransactions',$row["intMatDetailId"],61,90,$tdate,$mainStores,$color,$size,$row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
			//$styleGRNstockVal90 = 0;
//$bulkGRNstockVal90 = getStockBulkValue('stocktransactions',$row["intMatDetailId"],61,90,$tdate,$mainStores,$color,$size);
	//$bulkGRNstockVal90 = 0;	
//$tempVal90 = getStockQtyValue('stocktransactions_temp',$row["intMatDetailId"],61,90,$tdate,$mainStores,$color,$size);
$tempVal90 = 0;

$styleGRNleftVal90 = getStockQtyValue('stocktransactions_history',$row["intMatDetailId"],61,90,$tdate,$mainStores,$color,$size, $row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
//$styleGRNleftVal90 = 0;

//$bulkGRNleftVal90 = getStockBulkValue('stocktransactions_leftover',$row["intMatDetailId"],61,90,$tdate,$mainStores,$color,$size);
	$bulkGRNleftVal90 = 0;
			
//$bulkVal90 = getStockQtyValue('stocktransactions_bulk',$row["intMatDetailId"],61,90,$tdate,$mainStores,$color,$size);
	$bulkVal90 = 0;		
			$totVal90 = $styleGRNstockVal90 + $bulkGRNstockVal90 + $tempVal90+$styleGRNleftVal90+$bulkGRNleftVal90+$bulkVal90;
			//echo number_format($totVal90,4);
			
			$totRowVal += $totVal90;	
  ?>
  <?php 
$styleGRNstockQty120 = getStock30daysQty('stocktransactions',$row["intMatDetailId"],91,120,$tdate,$mainStores,$color,$size, $row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
				//$styleGRNstockQty120 = 0;
//$bulkGRNstockQty120 = getStock30daysBulkQty('stocktransactions',$row["intMatDetailId"],91,120,$tdate,$mainStores,$color,$size);
	//$bulkGRNstockQty120 = 0;	
//$tempQty120 = getStock30daysQty('stocktransactions_temp',$row["intMatDetailId"],91,120,$tdate,$mainStores,$color,$size);
$tempQty120 = 0;
//$styleGRNleftQty120 = getStock30daysQty('stocktransactions_leftover',$row["intMatDetailId"],91,120,$tdate,$mainStores,$color,$size, $row['intStyleId']);
$styleGRNleftQty120 = getStock30daysQty('stocktransactions_history',$row["intMatDetailId"],91,120,$tdate,$mainStores,$color,$size, $row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
//$styleGRNleftQty120 = 0;
//$bulkGRNleftQty120 = getStock30daysBulkQty('stocktransactions_leftover',$row["intMatDetailId"],91,120,$tdate,$mainStores,$color,$size);
	$bulkGRNleftQty120 = 0;
			
//$bulkQty120 = getStock30daysQty('stocktransactions_bulk',$row["intMatDetailId"],91,120,$tdate,$mainStores,$color,$size);
	$bulkQty120 = 0;
		$qty120 =$styleGRNstockQty120 +$bulkGRNstockQty120+$tempQty120+$styleGRNleftQty120+$bulkGRNleftQty120+$bulkQty120;			
						
				//echo number_format($qty120,2);
				$totRowQty1 += $qty120;
			?>
            <?php 
			$styleGRNstockVal120 = getStockQtyValue('stocktransactions',$row["intMatDetailId"],91,120,$tdate,$mainStores,$color,$size,$row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
			//$styleGRNstockVal120 = 0;
//$bulkGRNstockVal120 = getStockBulkValue('stocktransactions',$row["intMatDetailId"],91,120,$tdate,$mainStores,$color,$size);
	//$bulkGRNstockVal120 = 0;
		
//$tempVal120 = getStockQtyValue('stocktransactions_temp',$row["intMatDetailId"],91,120,$tdate,$mainStores,$color,$size);
$tempVal120 = 0;

$styleGRNleftVal120 = getStockQtyValue('stocktransactions_history',$row["intMatDetailId"],91,120,$tdate,$mainStores,$color,$size, $row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
//$styleGRNleftVal120 = 0;

//$bulkGRNleftVal120 = getStockBulkValue('stocktransactions_leftover',$row["intMatDetailId"],91,120,$tdate,$mainStores,$color,$size);
	$bulkGRNleftVal120 = 0;
			
//$bulkVal120 = getStockQtyValue('stocktransactions_bulk',$row["intMatDetailId"],91,120,$tdate,$mainStores,$color,$size);
	$bulkVal120 = 0;		
			$totVal120 = $styleGRNstockVal120 + $bulkGRNstockVal120 + $tempVal120+$styleGRNleftVal120+$bulkGRNleftVal120+$bulkVal120;
			//echo number_format($totVal120,4);
			
			$totRowVal += $totVal120;	
  ?>
  <?php 
$styleGRNstockQty12 = getStock30daysQty('stocktransactions',$row["intMatDetailId"],120,120,$tdate,$mainStores,$color,$size,$row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
			//	$styleGRNstockQty12 = 0;
//$bulkGRNstockQty12 = getStock30daysBulkQty('stocktransactions',$row["intMatDetailId"],120,120,$tdate,$mainStores,$color,$size);
	//$bulkGRNstockQty12 = 0;
		
//$tempQty12 = getStock30daysQty('stocktransactions_temp',$row["intMatDetailId"],120,120,$tdate,$mainStores,$color,$size);
$tempQty12 = 0;

//$styleGRNleftQty12 = getStock30daysQty('stocktransactions_leftover',$row["intMatDetailId"],120,120,$tdate,$mainStores,$color,$size, $row['intStyleId']);
$styleGRNleftQty12 = getStock30daysQty('stocktransactions_history',$row["intMatDetailId"],120,120,$tdate,$mainStores,$color,$size, $row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
//$styleGRNleftQty12 = 0;
//$bulkGRNleftQty12 = getStock30daysBulkQty('stocktransactions_leftover',$row["intMatDetailId"],120,120,$tdate,$mainStores,$color,$size);
	$bulkGRNleftQty12 = 0;
			
//$bulkQty12 = getStock30daysQty('stocktransactions_bulk',$row["intMatDetailId"],120,120,$tdate,$mainStores,$color,$size);
	$bulkQty12 = 0;
$qtyS = $styleGRNstockQty12 + $bulkGRNstockQty12 + $tempQty12+$styleGRNleftQty12+$bulkGRNleftQty12+$bulkQty12;
$totRowQty1 += $qtyS;
						//echo number_format($qtyS,2);
			?>
            <?php 
			$styleGRNstockVal12 = getStockQtyValue('stocktransactions',$row["intMatDetailId"],120,120,$tdate,$mainStores,$color,$size,$row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
//$styleGRNstockVal12 = 0;
//$bulkGRNstockVal12 = getStockBulkValue('stocktransactions',$row["intMatDetailId"],120,120,$tdate,$mainStores,$color,$size);
	//$bulkGRNstockVal12 = 0;
		
//$tempVal12 = getStockQtyValue('stocktransactions_temp',$row["intMatDetailId"],120,120,$tdate,$mainStores,$color,$size);
$tempVal12 = 0;

$styleGRNleftVal12 = getStockQtyValue('stocktransactions_history',$row["intMatDetailId"],120,120,$tdate,$mainStores,$color,$size, $row['intStyleId'], $row["strBuyerPoNo"], $subStoreID);
//$styleGRNleftVal12 = 0;
//$bulkGRNleftVal12 = getStockBulkValue('stocktransactions_leftover',$row["intMatDetailId"],120,120,$tdate,$mainStores,$color,$size);
	$bulkGRNleftVal12 = 0;
			
//$bulkVal12 = getStockQtyValue('stocktransactions_bulk',$row["intMatDetailId"],120,120,$tdate,$mainStores,$color,$size);
	$bulkVal12 = 0;		
			$totVal12 = $styleGRNstockVal12 + $bulkGRNstockVal12 + $tempVal12+$styleGRNleftVal12+$bulkGRNleftVal12+$bulkVal12;
			//echo number_format($totVal12,4);
			
			$totRowVal += $totVal12;
			//$totQty += $totRowQty;
			//echo "Row Qty = $totRowQty1";
			//if($totRowVal>0)
			if($totRowQty1>0)
				
			{	
                            
                            $orderStatus = GetOrderStatus($row["intStatus"]);
                            $intDeliveryQty = GetBuyerPOQty($row["intStyleId"], $row["strBuyerPoNo"], $row["intQty"]);
                            $mainCategory = GetItemType($row["intMainCatID"]);
			
  ?>
          <tr bgcolor="#FFFFFF">
            <td class="normalfntMid" nowrap="nowrap"><?php echo $row["MainStores"]; ?>&nbsp;</td> 
            <td class="normalfntMid" nowrap="nowrap"><?php echo $mainCategory; ?>&nbsp;</td>            
            <td class="normalfntMid" nowrap="nowrap"><?php echo $row["intSRNO"]; ?>&nbsp;</td>
            <td class="normalfntMid" nowrap="nowrap"><?php echo $row["strStyle"]; ?>&nbsp;</td>            
            <td class="normalfnt" nowrap="nowrap"><?php echo $row["strName"]; ?>&nbsp;</td>     
            <td class="normalfnt" nowrap="nowrap"><?php echo $row["strBuyerPoNo"]; ?>&nbsp;</td>
            <td class="normalfntR" nowrap="nowrap" ><?php echo $intDeliveryQty; ?>&nbsp;</td>
            <td class="normalfnt" nowrap="nowrap"><?php echo $orderStatus; ?>&nbsp;</td>
            <td class="normalfnt" nowrap="nowrap" height="20"><a href="itemDetailPopUp.php?mainId=<?php echo $row['intMatDetailId']; ?>" target="_blank"><?php echo $row["strItemDescription"]; ?></a></td>
            <td class="normalfntMid" nowrap="nowrap"><?php echo $row["strUnit"]; ?></td>
            <td class="normalfntRite">
            <a href="qtyDetail.php?tbl=stocktransactions&matId=<?php echo $row["intMatDetailId"];?>&fromVal=1&toVal=30&toDate=<?php echo $tdate ?>&mainStores=<?php echo $mainStores; ?>&color=<?php echo $color; ?>&size=<?php echo $size; ?>" target="_blank">
            <?php
			
			$sumCatQty30 += $totQty30;
			 
			if(number_format($totQty30,2)>0)
				echo number_format($totQty30,2);
			else
				echo "-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$totRowQty +=$totQty30;	
			?>
            </a>
            </td>
            <td class="normalfntRite"><?php
			
			$sumCatVal30 += $totVal30;
			
			if(number_format($totVal30,2)!=0) 
				echo number_format($totVal30,2);
			else
				echo "-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			
				
  ?></td>
            <td class="normalfntRite">
			<a href="qtyDetail.php?tbl=stocktransactions&matId=<?php echo $row["intMatDetailId"];?>&fromVal=31&toVal=60&toDate=<?php echo $tdate ?>&mainStores=<?php echo $mainStores; ?>&color=<?php echo $color; ?>&size=<?php echo $size; ?>" target="_blank">
			<?php 
			
			$sumCatQty60+=$qty60;
			
					if(number_format($qty60,2)!=0)
						echo number_format($qty60,2);
					else
						echo "-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						$totRowQty += $qty60;		
			?>
            </a>
            </td>
            <td class="normalfntRite"><?php 
			
			$sumCatVal60+=$totVal60;
			
			if(number_format($totVal60,2)!=0)
				echo number_format($totVal60,2);
			else
				echo "-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				
  ?></td>
            <td class="normalfntRite"> 
			<a href="qtyDetail.php?tbl=stocktransactions&matId=<?php echo $row["intMatDetailId"];?>&fromVal=61&toVal=90&toDate=<?php echo $tdate ?>&mainStores=<?php echo $mainStores; ?>&color=<?php echo $color; ?>&size=<?php echo $size; ?>" target="_blank">
			<?php 
			
			$sumCatQty90 += $qty90;
			
					if(number_format($qty90,2)!=0)
						echo number_format($qty90,2);
					else
						echo "-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						$totRowQty += $qty90
			?>
            </a>
            </td>
            <td class="normalfntRite"><?php 
			
			$sumCatVal90 += $totVal90;
			
				if(number_format($totVal90,2)!=0)
					echo number_format($totVal90,2);
				else
					echo "-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				
  ?></td>
            <td class="normalfntRite">
			<a href="qtyDetail.php?tbl=stocktransactions&matId=<?php echo $row["intMatDetailId"];?>&fromVal=91&toVal=120&toDate=<?php echo $tdate ?>&mainStores=<?php echo $mainStores; ?>&color=<?php echo $color; ?>&size=<?php echo $size; ?>" target="_blank">
			<?php 	
			
			$sumCatQty120 += $qty120;
					
			if(number_format($qty120,2)!=0)			
				echo number_format($qty120,2);
			else
				echo "-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				$totRowQty += $qty120;
			?>
            </a></td>
            <td class="normalfntRite"><?php 
			
			$sumCatVal120 += $totVal120;
			
			if(number_format($totVal120,2)!=0)
				echo number_format($totVal120,2);
			else
				echo "-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				
  ?></td>
            <td class="normalfntRite">
            <a href="qtyDetail.php?tbl=stocktransactions&matId=<?php echo $row["intMatDetailId"];?>&fromVal=120&toVal=120&toDate=<?php echo $tdate ?>&mainStores=<?php echo $mainStores; ?>&color=<?php echo $color; ?>&size=<?php echo $size; ?>" target="_blank">
			<?php 
			
			$sumCatQtyOver120 += $qtyS;
					if(number_format($qtyS,2)!=0)
						echo number_format($qtyS,2);
					else
						echo "-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						$totRowQty +=$qtyS;
			?>
            </a></td>
            <td class="normalfntRite"><?php 
			
			$sumCatValOver120 += $totVal12;
			
			if(number_format($totVal12,2)!=0)
				echo number_format($totVal12,2);
			else
				echo "-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				
  ?></td>
            <td class="normalfntRite"><?php
			
			$sumRowQty +=$totRowQty;
			
			 if(number_format($totRowQty,2)!=0){ echo number_format($totRowQty,2);}else{ echo "-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; };
			$totQty += $totRowQty;
			$totRowQty =0;
			 ?></td>
            <td class="normalfntRite"><?php
			
			$sumRowVal+=$totRowVal;
			
			 if(number_format($totRowVal,2)!=0){ echo number_format($totRowVal,2);}else{ echo "-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; };
			$totValue += $totRowVal;
			$totRowVal =0;
			
			$totStock30 += $totQty30;
			$totStockVal30 += $totVal30;
			$totStock60 += $qty60;
			$totStockVal60 += $totVal60;
			$totStock90 += $qty90;
			$totStockVal90 += $totVal90;
			$totStock120 += $qty120;
			$totStockVal120 += $totVal120;
			$totStockS += $qtyS;
			$totStockValS += $totVal12;
						
			 ?></td>
             <td class="normalfntRite"><?php echo $row["intMatDetailId"]; ?></td>
          </tr>
          <?php 
			}
		  }
		   ?>
          <tr bgcolor="#EBEBEB" class="normalfntRite">
               <td class="normalfntMid" nowrap="nowrap" height="20" colspan="4"><b><?php echo $rowMainCat['strDescription'] ?> Total</b></td>
               <td class="normalfntMid">&nbsp;</td>
               <td class="normalfntMid">&nbsp;</td>
               <td class="normalfntMid">&nbsp;</td>
               <td class="normalfntMid">&nbsp;</td>
               <td class="normalfntMid">&nbsp;</td>
               <td class="normalfntMid">&nbsp;</td>
               <td><b><?php echo number_format($sumCatQty30,2); ?></b></td>
               <td><b><?php echo number_format($sumCatVal30,2); ?></b></td>
               <td><b><?php echo number_format($sumCatQty60,2); ?></b></td>
               <td><b><?php echo number_format($sumCatVal60,2); ?></b></td>
               <td><b><?php echo number_format($sumCatQty90,2); ?></b></td>
               <td><b><?php echo number_format($sumCatVal90,2); ?></b></td>
               <td><b><?php echo number_format($sumCatQty120,2); ?></b></td>
               <td><b><?php echo number_format($sumCatVal120,2); ?></b></td>
               <td><b><?php echo number_format($sumCatQtyOver120,2); ?></b></td>
               <td><b><?php echo number_format($sumCatValOver120,2); ?></b></td>
               <td><b><?php echo number_format($sumRowQty,2); ?></b></td>
               <td><b><?php echo number_format($sumRowVal,2); ?></b></td>
               <td class="normalfntMid">&nbsp;</td>
               
            </tr>
         <?php
		  }
		  ?>
           <tr bgcolor="#EBEBEB" class="normalfntRite">
            <td class="normalfntMid" nowrap="nowrap" height="20" colspan="4"><b>Grand Total</b></td>
             <td class="normalfntMid">&nbsp;</td>
             <td class="normalfntMid">&nbsp;</td>
             <td class="normalfntMid">&nbsp;</td>
             <td class="normalfntMid">&nbsp;</td>
             <td class="normalfntMid">&nbsp;</td>
             <td class="normalfntMid">&nbsp;</td>
             
           <td><b><?php echo number_format($totStock30,2); ?></b></td>
           <td><b><?php echo number_format($totStockVal30,2); ?></b></td>
            <td><b><?php echo number_format($totStock60,2); ?></b></td>
           <td><b><?php echo number_format($totStockVal60,2); ?></b></td>
           <td><b><?php echo number_format($totStock90,2); ?></b></td>
           <td><b><?php echo number_format($totStockVal90,2); ?></b></td>
           <td><b><?php echo number_format($totStock120,2); ?></b></td>
           <td><b><?php echo number_format($totStockVal120,2); ?></b></td>
           <td><b><?php echo number_format($totStockS,2); ?></b></td>
           <td><b><?php echo number_format($totStockValS,2); ?></b></td>
           <td><b><?php echo number_format($totQty,2); ?></b></td>
           <td><b><?php echo number_format($totValue,2); ?></b></td>
           <td class="normalfntMid">&nbsp;</td>
            </tr>
            </tbody>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<?php 
function getBaseCurrency()
{
	global $db;
	
	$sql=" select strCurrency from currencytypes c inner join systemconfiguration s on c.intCurID = s.intBaseCurrency";
	
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["strCurrency"];	
}

function getUSDValue($value,$currency)
{
	global $db;
	global $deci;
	$dollarRate = 1;
	$sql = "SELECT ER.rate FROM currencytypes CT inner join exchangerate ER on ER.currencyID=CT.intCurID WHERE CT.strCurrency = '". $currency . "' and ER.intStatus=1;";
	$rst = $db->RunQuery($sql);
	while($rw = mysql_fetch_array($rst))
	{
		$dollarRate = $rw["rate"];
		break;
	}
	return round(($value / $dollarRate),$deci);
}
//get Qty  details ------------------------------
function getStock30daysQty($tbl,$matDetailID,$dayFrom,$dayTo,$tdate,$mainStores,$color,$size,$prmStyleId, $prmBuyerPO, $prmSubStoreId)
{
	global $db;
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
	$row = mysql_fetch_array($result);
	//echo mysql_num_rows($result);
	return 	$row["qty"];					
}
function getStock30daysBulkQty($tbl,$matDetailID,$dayFrom,$dayTo,$tdate,$mainStores,$color,$size)
{
	global $db;
	
		//get style grn qty in stocktransactions and  stocktransactions_leftover
		$sql = "select  round(sum(st.dblQty),2) as qty 
from $tbl st inner join bulkgrnheader gh on gh.intBulkGrnNo=st.intGrnNo 
and gh.intYear = st.intGrnYear INNER JOIN bulkpurchaseorderheader ON gh.intBulkPoNo = bulkpurchaseorderheader.intBulkPoNo AND gh.intBulkPoYear = bulkpurchaseorderheader.intYear
where st.intMatDetailId=$matDetailID and bulkpurchaseorderheader.strBulkPOType!='1' and st.strGRNType='B' ";
	if($dayFrom == '120')
			$sql .= " and (TO_DAYS('$tdate')-TO_DAYS(gh.dtmConfirmedDate) > $dayFrom  )";
		else
			$sql .= " and (TO_DAYS('$tdate')-TO_DAYS(gh.dtmConfirmedDate) between $dayFrom and $dayTo )";
			
	if($mainStores != '')
		$sql .= " and  st.strMainStoresID='$mainStores' ";
	if($color != '')
		$sql .= " and  st.strColor='$color' ";	
	if($size != '')
		$sql .= " and  st.strSize='$size' ";
	
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return 	$row["qty"];					
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
function getStockBulkValue($tbl,$matDetailID,$dayFrom,$dayTo,$tdate,$mainStores,$color,$size)
{
	global $db;
	
		//get style grn qty in stocktransactions and  stocktransactions_leftover
		$sql = "SELECT
					round(sum(st.dblQty),2) AS qty,
					st.intMatDetailId,
					st.intGrnNo AS intGrnNo,
					st.intGrnYear AS intGrnYear,
					st.intStyleId,
					st.strGRNType,
					st.strColor,
					st.strSize
					FROM
					$tbl AS st
					INNER JOIN bulkgrnheader AS gh ON gh.intBulkGrnNo = st.intGrnNo AND gh.intYear = st.intGrnYear
					INNER JOIN bulkpurchaseorderheader ON gh.intBulkPoNo = bulkpurchaseorderheader.intBulkPoNo AND gh.intBulkPoYear = bulkpurchaseorderheader.intYear
					where st.intMatDetailId=$matDetailID  AND bulkpurchaseorderheader.strBulkPOType!='1'  and st.strGRNType='B' ";
	if($dayFrom == '120')
			$sql .= " and (TO_DAYS('$tdate')-TO_DAYS(gh.dtmConfirmedDate) > $dayFrom  )";
		else
			$sql .= " and (TO_DAYS('$tdate')-TO_DAYS(gh.dtmConfirmedDate) between $dayFrom and $dayTo )";
			
	if($mainStores != '')
		$sql .= " and  st.strMainStoresID='$mainStores' ";
	if($color != '')
		$sql .= " and  st.strColor='$color' ";	
	if($size != '')
		$sql .= " and  st.strSize='$size' ";
	$sql .= " group by st.intMatDetailId,intGrnNo,intGrnYear,st.strColor,st.strSize
having qty>0";
	$grnValue=0;
	$result = $db->RunQuery($sql);
	//if($dayFrom==1 && $dayTo==30)
			//echo $sql;
	//echo $sql;
	while($row = mysql_fetch_array($result))
	{
		$grnQty = $row["qty"];
		$grnValue += getGRNValue($grnQty,$row["intGrnNo"],$row["intGrnYear"],$row["strGRNType"],$row["intStyleId"],$row["intMatDetailId"],$row["strColor"],$row["strSize"]);
	}
	//echo $sql;
	return 	round($grnValue,4);					
}

function getGRNValue($grnQty,$grnNo,$grnYear,$grnType,$styleID,$matdetailID,$color,$size)
{
	global $db;
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
	$row = mysql_fetch_array($result);
	//echo $sql;
	$grnValue = $grnQty*$row["grnprice"]/$row["exRate"];
	return $grnValue;
}

function GetOrderStatus($prmStatus){
    
    $strStatus = "";
    
    switch($prmStatus){
        
        case "16":
            $strStatus = "Completed";
            break;
        
        default:
            $strStatus = "Running";
            break;
        
    }
    
    return $strStatus;
}

function GetBuyerPOQty($prmStyleCode, $prmBuyerPO, $prmOrderQty){
    
    $orderQty = 0;
    
    switch($prmBuyerPO){
        
        case "#Main Ratio#":
            $orderQty = $prmOrderQty;
        break;
    
        default:
          $orderQty =  GetRelavantBuyerPOQty($prmStyleCode, $prmBuyerPO);
        break;
        
    }
    
    
    return $orderQty;
}

function GetRelavantBuyerPOQty($prmStyleCode, $prmBuyerPO){
    
    global $db;
    
    $deliveryQty = 0;
    
    $sql = " SELECT deliveryschedule.dblQty, deliveryschedule.intBPO, style_buyerponos.strBuyerPoName
             FROM deliveryschedule INNER JOIN style_buyerponos ON deliveryschedule.intStyleId = style_buyerponos.intStyleId AND deliveryschedule.intBPO = style_buyerponos.strBuyerPONO
             WHERE deliveryschedule.intStyleId = '$prmStyleCode' AND style_buyerponos.strBuyerPoName = '$prmBuyerPO'";
    
    $result = $db->RunQuery($sql);
    
    while($row = mysql_fetch_array($result)){
       $deliveryQty =  $row["dblQty"];
    }
    
    return $deliveryQty;
}

function GetItemType($prmMainCat){
    
    $MainCategory = "";
    
    switch($prmMainCat){
        
        case "1":
            $MainCategory = "FABRIC";
            break;
        
         case "2":
            $MainCategory = "ACCE";
            break;
        
        case "3":
            $MainCategory = "PACKING";
            break;
        
    }
    
    return $MainCategory;
}
//-----------------------------------
?>
</body>
</html>
