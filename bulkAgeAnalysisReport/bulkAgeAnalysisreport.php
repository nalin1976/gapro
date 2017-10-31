<?php 
	session_start();
 $backwardseperator = "../";
 
 $mainId = $_GET["mainId"];
 $subId	= $_GET["subCatId"];
 $matItem		= $_GET["ItemID"];
 $mainStores	= $_GET["mainStore"];
 $color 	= $_GET["color"];
 $size		= $_GET["size"];
 $txtmatItem  = $_GET["itemDesc"];
 $tdate = date('Y-m-d');
 $Merchandiser = $_GET["Merchandiser"];
 $report_companyId =$_SESSION["FactoryID"];
 $mainCatName = $_GET["mainCatName"];
 $subCatName =$_GET["subCatName"];
 $itemName = $_GET["itemName"];
 $merchandName = $_GET["merchandName"];
 $storeName = $_GET["storeName"];
 $deci = 2; //no of decimal places
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Bulk Age Analysis Report</title>
<link href="../css/erpstyle.css" type="text/css" rel="stylesheet" />
</head>

<body>
<?php 
include "../Connector.php";

?>
<table width="1050" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><table width="1050" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php include $backwardseperator.'reportHeader.php'; ?></td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="head2BLCK">Bulk Age Analysis Report as at - <?php echo date('d-F-Y'); ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt">
          <tr>
          <?php if($mainStores != ''){?>
            <td width="9%" height="20"><b>Store</b></td>
            <td width="41%"><b>:</b>&nbsp;&nbsp; <?php echo $storeName; ?></td>
            <?php 
			}
			if($Merchandiser != '')
			{
			?>
            <td width="10%"><b>Merchandiser </b></td>
            <td width="40%"><b>:</b>&nbsp;&nbsp;<?php echo $merchandName; ?></td>
            <?php 
			}
			?>
          </tr>
          <tr>
           <?php if($mainId != ''){?>
            <td height="20"><b>Main Category</b></td>
            <td><b>:</b>&nbsp;&nbsp; <?php echo $mainCatName ?></td>
            <?php 
			}
			if($subId != '')
			{
			?>
            <td><b>Sub Category</b></td>
            <td><b>:</b>&nbsp;&nbsp;<?php echo $subCatName; ?></td>
            <?php 
			}
			?>
          </tr>
          <tr>
           <?php if($color != ''){?>
            <td height="20"><b>Color</b></td>
            <td><b>:</b>&nbsp;&nbsp;<?php echo $color; ?></td>
            <?php 
			}
			if($size != '')
			{
			?>
            <td><b>Size</b></td>
            <td><b>:</b>&nbsp;&nbsp;<?php echo $size; ?></td>
            <?php 
			}
			?>
          </tr>
          <tr>
           <?php if($matItem != ''){?>
          	<td height="20"><b>Item </b></td>
            <td colspan="3"><b>:</b>&nbsp;&nbsp;<?php echo getItemName($matItem); ?></td>
            <?php 
			}
			?>
          </tr>
          <tr>
          	<td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="1050" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
          <tr bgcolor="#CCCCCC">
            <td width="149" class="normalfnBLD1" height="23" >Item Decription </td>
            <td width="59" class="normalfnBLD1" align="center">Unit</td>
            <td width="60" class="normalfnBLD1" align="center">0-30</td>
            <td width="65" class="normalfnBLD1" align="center">val(0-30)</td>
            <td width="69" class="normalfnBLD1" align="center">31-60</td>
            <td width="76" class="normalfnBLD1" align="center">val(31-60)</td>
            <td width="67" class="normalfnBLD1" align="center">61-90</td>
            <td width="73" class="normalfnBLD1" align="center">val(61-90)</td>
            <td width="64" class="normalfnBLD1" align="center">91-120</td>
            <td width="85" class="normalfnBLD1" align="center">val(91-120)</td>
            <td width="52" class="normalfnBLD1" align="center">More</td>
            <td width="58" class="normalfnBLD1" align="center">Value</td>
            <td width="64" class="normalfnBLD1" align="center">Total</td>
            <td width="66" class="normalfnBLD1" align="center">Total Val</td>
          </tr>
          <?php 
		  //get base currency details
		  $baseCurrncy = getBaseCurrency();
		  $totQty = 0;
		  $totValue = 0;
		  //get items in the stock
		  $sql =" select mil.strItemDescription,st.intMatDetailId,st.strColor,st.strSize,round(sum(bulkQty),2) as bulkQty,mil.strUnit from bulkmerchandstockview st 
inner join matitemlist mil on mil.intItemSerial= st.intMatDetailId 
inner join bulkgrndetails bgd on bgd.intMatDetailID = st.intMatDetailId 
inner join bulkgrnheader bgh on bgh.intBulkGrnNo = bgd.intBulkGrnNo and bgh.intYear= bgd.intYear
inner join bulkpurchaseorderheader bpo on bpo.intBulkPoNo = bgh.intBulkPoNo and bpo.intYear = bgh.intBulkPoYear
and st.intBulkGrnNo = bgd.intBulkGrnNo and st.intBulkGrnYear = bgd.intYear
where st.strMainStoresID>0 

";
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
		if($Merchandiser !='')	
			$sql .= " and bpo.intMerchandiser='$Merchandiser' ";
		$sql .= " group by mil.strItemDescription,st.intMatDetailId,st.strColor,st.strSize ";
		
		$sql .= " having bulkQty > 0 ";
		
		$result = $db->RunQuery($sql);
				
				while($row = mysql_fetch_array($result))
						{
						
						$matDetailID = $row["intMatDetailId"];
		  ?>
          <tr bgcolor="#FFFFFF">
            <td class="normalfnt" nowrap="nowrap"><?php echo $row["strItemDescription"]; ?></td>
            <td class="normalfntMid"><?php echo $row["strUnit"]; ?></td>
            <td class="normalfntRite">
            <?php 
		$bulkQty30 = getStock30daysQty('stocktransactions_bulk',$row["intMatDetailId"],0,30,$tdate,$mainStores,$color,$size,$Merchandiser);
		echo ($bulkQty30 == '0.00'?'&nbsp;':number_format($bulkQty30,$deci));
		$totQty +=  $bulkQty30;
			?>
            </td>
            <td class="normalfntRite"><?php 
			$styleGRNstockVal30 = getStockQtyValue('stocktransactions_bulk',$row["intMatDetailId"],0,30,$tdate,$mainStores,$color,$size,$Merchandiser);
			echo ($styleGRNstockVal30==0?'&nbsp;':number_format($styleGRNstockVal30,$deci));
			$totValue += $styleGRNstockVal30;
  ?></td>
            <td class="normalfntRite"><?php 				
			$qty60 = getStock30daysQty('stocktransactions_bulk',$row["intMatDetailId"],31,60,$tdate,$mainStores,$color,$size,$Merchandiser);			
			$totQty += $qty60;
			echo ($qty60 == '0.00'?'&nbsp;':number_format($qty60,$deci));
			?></td>
            <td class="normalfntRite"><?php 
			$stockVal60 = getStockQtyValue('stocktransactions_bulk',$row["intMatDetailId"],31,60,$tdate,$mainStores,$color,$size,$Merchandiser);
			echo ($stockVal60==0?'&nbsp;':number_format($stockVal60,$deci));
			$totValue += $stockVal60;
			
  ?></td>
            <td class="normalfntRite"> <?php 
			$qty90 = getStock30daysQty('stocktransactions_bulk',$row["intMatDetailId"],61,90,$tdate,$mainStores,$color,$size,$Merchandiser);			
			$totQty += $qty90;
			echo ($qty90 == '0.00'?'&nbsp;':number_format($qty90,$deci));
			?></td>
            <td class="normalfntRite"><?php 
			$stockVal90 = getStockQtyValue('stocktransactions_bulk',$row["intMatDetailId"],61,90,$tdate,$mainStores,$color,$size,$Merchandiser);
			echo ($stockVal90==0?'&nbsp;':number_format($stockVal90,$deci));
			$totValue += $stockVal90;
  ?></td>
            <td class="normalfntRite"><?php 
				$qty120 = getStock30daysQty('stocktransactions_bulk',$row["intMatDetailId"],91,120,$tdate,$mainStores,$color,$size,$Merchandiser);			
			$totQty += $qty120;
			echo ($qty120 == '0.00'?'&nbsp;':number_format($qty120,$deci));
			?></td>
            <td class="normalfntRite"><?php 
			
			$stockVal120 = getStockQtyValue('stocktransactions_bulk',$row["intMatDetailId"],91,120,$tdate,$mainStores,$color,$size,$Merchandiser);
			echo ($stockVal120==0?'&nbsp;':number_format($stockVal120,$deci));
			$totValue += $stockVal120;
  ?></td>
            <td class="normalfntRite"><?php 
				$qty12 = getStock30daysQty('stocktransactions_bulk',$row["intMatDetailId"],120,120,$tdate,$mainStores,$color,$size,$Merchandiser);			
			$totQty += $qty12;
			echo ($qty12 == '0.00'?'&nbsp;':number_format($qty12,$deci));
			?></td>
            <td class="normalfntRite"><?php 
			$stockVal12 = getStockQtyValue('stocktransactions_bulk',$row["intMatDetailId"],120,120,$tdate,$mainStores,$color,$size,$Merchandiser);
			echo ($stockVal12==0?'&nbsp;':number_format($stockVal12,$deci));
			$totValue += $stockVal12;
  ?></td>
            <td class="normalfntRite"><?php echo ($totQty == '0.00'?'&nbsp;':number_format($totQty,$deci));
			$grand_totQty	+= $totQty;
			$totQty =0;
			 ?></td>
            <td class="normalfntRite"><?php echo ($totValue==0?'&nbsp;':number_format($totValue,$deci));
			$grand_totValue	+= $totValue;
			$totValue =0;
			 ?></td>
          </tr>
          <?php 
		  $grand_bulkQty30 			+= $bulkQty30;
		  $grand_styleGRNstockVal30	+= $styleGRNstockVal30;
		  $grand_qty60 				+= $qty60;
		  $grand_stockVal60			+= $stockVal60;
		  $grand_qty90				+= $qty90;
		  $grand_stockVal90			+= $stockVal90;
		  $grand_qty120				+= $qty120;
		  $grand_stockVal120		+= $stockVal120;
		  $grand_qty12				+= $qty12;
		  $grand_stockVal12			+= $stockVal12;
		  }
		  ?>
          <tr bgcolor="#FFFFFF">
            <td class="normalfnt" nowrap="nowrap"><b>Grand Total</b></td>
            <td class="normalfntMid">&nbsp;</td>
            <td class="normalfntRite"><b><?php echo number_format($grand_bulkQty30,2)?></b></td>
            <td class="normalfntRite"><b><?php echo number_format($grand_styleGRNstockVal30,2)?></b></td>
            <td class="normalfntRite"><b><?php echo number_format($grand_qty60,2)?></b></td>
            <td class="normalfntRite"><b><?php echo number_format($grand_stockVal60,2)?></b></td>
            <td class="normalfntRite"><b><?php echo number_format($grand_qty90,2)?></b></td>
            <td class="normalfntRite"><b><?php echo number_format($grand_stockVal90,2)?></b></td>
            <td class="normalfntRite"><b><?php echo number_format($grand_qty120,2)?></b></td>
            <td class="normalfntRite"><b><?php echo number_format($grand_stockVal120,2)?></b></td>
            <td class="normalfntRite"><b><?php echo number_format($grand_qty12,2)?></b></td>
            <td class="normalfntRite"><b><?php echo number_format($grand_stockVal12,2)?></b></td>
            <td class="normalfntRite"><b><?php echo number_format($grand_totQty,2)?></b></td>
            <td class="normalfntRite"><b><?php echo number_format($grand_totValue,2)?></b></td>
          </tr>
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
function getStock30daysQty($tbl,$matDetailID,$dayFrom,$dayTo,$tdate,$mainStores,$color,$size,$Merchandiser)
{
	global $db;
	
	$sql = " select round(COALESCE(sum(st.dblQty),0),2) as qty  
from stocktransactions_bulk st inner join bulkgrnheader gh on gh.intBulkGrnNo=st.intBulkGrnNo and gh.intYear = st.intBulkGrnYear 
inner join bulkpurchaseorderheader bph on bph.intBulkPoNo = gh.intBulkPoNo and bph.intYear = gh.intBulkPoYear
where st.intMatDetailId=$matDetailID   ";
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
	if($Merchandiser != '')	
		$sql .= " and  bph.intMerchandiser='$Merchandiser' ";
	//echo $sql;
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return 	$row["qty"];				
}

function getStockQtyValue($tbl,$matDetailID,$dayFrom,$dayTo,$tdate,$mainStores,$color,$size,$Merchandiser)
{
	global $db;
	
		$sql = " select round(sum(st.dblQty),2) as qty,st.intMatDetailId,st.intBulkGrnNo as intGrnNo,st.intBulkGrnYear as intGrnYear,'style' as intStyleId, 'B' as strGRNType,st.strColor,st.strSize   
from stocktransactions_bulk st inner join bulkgrnheader gh on gh.intBulkGrnNo=st.intBulkGrnNo and gh.intYear = st.intBulkGrnYear 
inner join bulkpurchaseorderheader bph on bph.intBulkPoNo = gh.intBulkPoNo and bph.intYear = gh.intBulkPoYear
where st.intMatDetailId=$matDetailID   ";
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
	if($Merchandiser != '')	
		$sql .= " and  bph.intMerchandiser='$Merchandiser' ";	
	if($tbl != 'stocktransactions_bulk')
		$sql .=" group by st.intMatDetailId,st.intGrnNo,st.intGrnYear,intStyleId,st.strGRNType,st.strColor,st.strSize
having qty > 0 ";
	else
		$sql .= " group by st.intMatDetailId,intGrnNo,intGrnYear,st.strColor,st.strSize
having qty>0";	
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

function getItemName($matItem)
{
	global $db;
	$sql = " select strItemDescription from matitemlist where intItemSerial='$matItem' ";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["strItemDescription"];
}
?>
</body>
</html>
