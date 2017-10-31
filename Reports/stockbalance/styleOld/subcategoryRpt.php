<?php
 session_start();
include "../../../Connector.php";
$backwardseperator = "../../../";

$mainId		= $_GET["mainId"];
$subId		= $_GET["subId"];
$matItem	= $_GET["maiItem"];
$color		= $_GET["color"];
$size		= $_GET["size"];
$style		= $_GET["style"];
$mainStores	= $_GET["mainStores"];
$with0		= $_GET["with0"];
$x			= $_GET["x"];
$CompanyID  	= $_SESSION["FactoryID"];
$withLeftVal = $_GET["withLeftVal"];
$report_companyId = $CompanyID;
$checkDate  = $_GET["checkDate"];
$dfrom		= $_GET["dfrom"];
$dTo		= $_GET["dTo"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>GaPro | Style Stock Balance - Sub Category Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet"/>
</head>

<body>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php include $backwardseperator.'reportHeader.php'?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
   <?PHP
			$SQL = 	"SELECT  mainstores.strName FROM mainstores where strMainID=$mainStores";
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
				$sStores =  $row["strName"];
				
			if($sStores=='')
				$sStores = 'All';	
				
			switch($x)
			{
				case 'all':
				{
					$reportType = 'All';
					break;
				}
				case 'running':
				{
					$reportType = 'Running';
					break;
				}
				case 'leftOvers':
				{
					$reportType = 'Leftover';
					break;
				}
				case 'bulk':
				{
					$reportType = 'Bulk';
					break;
				}
			}	
		?>
    <td class="head1" height="30" align="center">STOCK BALANCE REPORT ( <span><?php echo $sStores; ?></span> ) - <?php echo $reportType; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="800" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
       <tr bgcolor="#CCCCCC" class="normalfntMid"> 
        <th width="131" height="25">Sub Category</th>
        <?php 
		  if($x == 'all' || $x == "running")
			{
		  ?>
        <th width="67">Stock Qty</th>
        <th width="66"> Value</th>
        <th width="94">Not Trim Inspected Qty</th>
        <th width="48">Value</th>
        <?php 
		  }
		  if($x == 'all' || $x == "bulk")
			{
		  ?>
        <th width="50">Bulk Qty</th>
        <th width="57">Value</th>
         <?php 
		  }
		  if($x == 'all' || $x == "leftOvers")
			{
		  ?>
        <th width="60">Leftover Qty</th>
        	<?php if($withLeftVal=='true') {?>
        <th width="54">Value</th>
        <?php 
			}
		}
		?>
        <th width="67">Total Qty</th>
         <th width="72">Total Value</th>
      </tr>
      <?php 
	  $sql = "(select ms.StrCatName,ms.intSubCatNo,sum(st.dblQty) as StockQty,
	(select  sum(stt.dblQty)
	from  stocktransactions_temp stt   inner join matitemlist mil on stt.intMatDetailId= mil.intItemSerial
	inner join grnheader gh on gh.intGrnNo= stt.intGrnNo and gh.intGRNYear=stt.intGrnYear
	 inner join matsubcategory mss on mss.intSubCatNo = mil.intSubCatID 
	where stt.strType='GRN' and gh.intStatus=1   
	and stt.intMatDetailId= mil.intItemSerial and mss.intSubCatNo =ms.intSubCatNo";
	
	if($mainId != "")
		$sql .= " and mil.intMainCatID = '$mainId'";
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($mainStores != "")
		$sql .= " and stt.strMainStoresID = '$mainStores'";	
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($style != "")
		$sql .= " and stt.intStyleId = '$style'";
	if($color != "")
		$sql .= " and stt.strColor = '$color'";
	if($size != "")
		$sql .= " and stt.strSize = '$size'";
	if($checkDate == 'true')
	{
		$sql .=" and date(stt.dtmDate) between '$dfrom' and '$dTo' ";		
	}	
	$sql .= " ) as tempQty,
	(select  sum(st.dblQty)
	from  matitemlist mil inner join stocktransactions_bulk st on st.intMatDetailId= mil.intItemSerial
	 inner join matsubcategory msb on msb.intSubCatNo = mil.intSubCatID 
	where msb.intSubCatNo = ms.intSubCatNo ";
	
	if($mainId != "")
		$sql .= " and mil.intMainCatID = '$mainId'";
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
	
	if($style != "")
		$sql .= " and st.intStyleId = '$style'";
	if($color != "")
		$sql .= " and st.strColor = '$color'";
	if($size != "")
		$sql .= " and st.strSize = '$size'";	
	if($checkDate == 'true')
	{
		$sql .=" and date(st.dtmDate) between '$dfrom' and '$dTo' ";		
	}		
	$sql .= " ) as bulkQty,
	(select  sum(st.dblQty)
	from  stocktransactions_leftover st  inner join matitemlist mil on st.intMatDetailId= mil.intItemSerial
	 inner join matsubcategory msl on  msl.intSubCatNo = mil.intSubCatID 
	where msl.intSubCatNo=ms.intSubCatNo ";
	
	if($mainId != "")
		$sql .= " and mil.intMainCatID = '$mainId'";
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($style != "")
		$sql .= " and st.intStyleId = '$style'";
	if($color != "")
		$sql .= " and st.strColor = '$color'";
	if($size != "")
		$sql .= " and st.strSize = '$size'";	
	if($checkDate == 'true')
	{
		$sql .=" and date(st.dtmDate) between '$dfrom' and '$dTo' ";		
	}		
	$sql .= " ) as leftoverQty
	from matsubcategory ms inner join matitemlist mil on
	ms.intSubCatNo = mil.intSubCatID 
	inner join stocktransactions st on st.intMatDetailId= mil.intItemSerial
	where st.strMainStoresID>0 ";
	
	//start check running stock conditions (stocktransactions) 
	if($mainId != "")
		$sql .= " and mil.intMainCatID = '$mainId'";
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($style != "")
		$sql .= " and st.intStyleId = '$style'";
	if($color != "")
		$sql .= " and st.strColor = '$color'";
	if($size != "")
		$sql .= " and st.strSize = '$size'";	
	if($checkDate == 'true')
	{
		$sql .=" and date(st.dtmDate) between '$dfrom' and '$dTo' ";		
	}		
	//end check running stock conditions (stocktransactions) 					
	$sql .= " group by ms.StrCatName)
	union 
	(
	select  mss.StrCatName,mss.intSubCatNo,0,sum(st.dblQty) as StockQty,0,0
	from  stocktransactions_temp st   inner join matitemlist mil on st.intMatDetailId= mil.intItemSerial
	inner join grnheader gh on gh.intGrnNo= st.intGrnNo and gh.intGRNYear=st.intGrnYear
	 inner join matsubcategory mss on mss.intSubCatNo = mil.intSubCatID 
	where st.strType='GRN' and gh.intStatus=1 ";
	
	if($mainId != "")
		$sql .= " and mil.intMainCatID = '$mainId'";
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($style != "")
		$sql .= " and st.intStyleId = '$style'";
	if($color != "")
		$sql .= " and st.strColor = '$color'";
	if($size != "")
		$sql .= " and st.strSize = '$size'";
	if($checkDate == 'true')
	{
		$sql .=" and date(st.dtmDate) between '$dfrom' and '$dTo' ";		
	}		
	$sql .= " and mss.intSubCatNo not in
	(
	select ms.intSubCatNo from matsubcategory ms inner join matitemlist mil on
	ms.intSubCatNo = mil.intSubCatID 
	inner join stocktransactions st on st.intMatDetailId= mil.intItemSerial
	where st.strMainStoresID>0 ";
	if($mainId != "")
		$sql .= " and mil.intMainCatID = '$mainId'";
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($style != "")
		$sql .= " and st.intStyleId = '$style'";
	if($color != "")
		$sql .= " and st.strColor = '$color'";
	if($size != "")
		$sql .= " and st.strSize = '$size'";
	if($checkDate == 'true')
	{
		$sql .=" and date(st.dtmDate) between '$dfrom' and '$dTo' ";		
	}	
	$sql .=" ) 
	group by mss.StrCatName 
	)
	union 
	(
	select  ms.StrCatName,ms.intSubCatNo,0,0,sum(st.dblQty) as StockQty,0
	from  matitemlist mil inner join stocktransactions_bulk st on st.intMatDetailId= mil.intItemSerial
	 inner join matsubcategory ms on ms.intSubCatNo = mil.intSubCatID 
	where st.strMainStoresID>0 ";
	
	if($mainId != "")
		$sql .= " and mil.intMainCatID = '$mainId'";
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId' ";
	if($checkDate == 'true')
	{
		$sql .=" and date(st.dtmDate) between '$dfrom' and '$dTo' ";		
	}	
	$sql .= " and ms.intSubCatNo not in (select ms.intSubCatNo from matsubcategory ms inner join matitemlist mil on
	ms.intSubCatNo = mil.intSubCatID 
	inner join stocktransactions st on st.intMatDetailId= mil.intItemSerial
	where st.strMainStoresID>0 ";
	
	
	if($mainId != "")
		$sql .= " and mil.intMainCatID = '$mainId'";
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($checkDate == 'true')
	{
		$sql .=" and date(st.dtmDate) between '$dfrom' and '$dTo' ";		
	}	
	$sql .= " ) ";	
	$sql .= " group by ms.StrCatName 
	)
	union 
	(
	select  ms.StrCatName,ms.intSubCatNo,0,0,0,sum(st.dblQty) as StockQty
	from  matitemlist mil inner join stocktransactions_leftover st on st.intMatDetailId= mil.intItemSerial
	 inner join matsubcategory ms on ms.intSubCatNo = mil.intSubCatID 
	where st.strMainStoresID>0 "; 
	if($mainId != "")
		$sql .= " and mil.intMainCatID = '$mainId'";
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($style != "")
		$sql .= " and st.intStyleId = '$style'";
	if($color != "")
		$sql .= " and st.strColor = '$color'";
	if($checkDate == 'true')
	{
		$sql .=" and date(st.dtmDate) between '$dfrom' and '$dTo' ";		
	}	
	if($size != "")
		$sql .= " and st.strSize = '$size'";
	$sql .= " and ms.intSubCatNo not in (select ms.intSubCatNo from matsubcategory ms inner join matitemlist mil on
	ms.intSubCatNo = mil.intSubCatID 
	inner join stocktransactions st on st.intMatDetailId= mil.intItemSerial" ;
	if($mainId != "")
		$sql .= " and mil.intMainCatID = '$mainId'";
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
	if($subId != "")
		$sql .= " and mil.intSubCatID = '$subId'";	
	if($style != "")
		$sql .= " and st.intStyleId = '$style'";
	if($color != "")
		$sql .= " and st.strColor = '$color'";
	if($size != "")
		$sql .= " and st.strSize = '$size'";
	if($checkDate == 'true')
	{
		$sql .=" and date(st.dtmDate) between '$dfrom' and '$dTo' ";		
	}	
	$sql .= " )
	group by ms.StrCatName 
	)
	order by StrCatName";
	//echo $sql;
	$result = $db->RunQuery($sql);
	$totQty =0;
	$totValue =0;
	while($row = mysql_fetch_array($result))
	{
		$subCatTotQty=0;
		
		$subcatStockValue = getSubcategoryStockValue($row["intSubCatNo"],'stocktransactions',$mainStores,$style,$color,$size);
		$tempValue = getSubcategoryStockValue($row["intSubCatNo"],'stocktransactions_temp',$mainStores,$style,$color,$size);
		$bulkValue = getSubcategoryStockValue($row["intSubCatNo"],'stocktransactions_bulk',$mainStores,$style,$color,$size);
		$leftoverValue = getSubcategoryStockValue($row["intSubCatNo"],'stocktransactions_leftover',$mainStores,$style,$color,$size);
		
		
		$totStockQty += $row["StockQty"];
		$totStockVal += $subcatStockValue;
		$totTempQty += $row["tempQty"];
		$totTempValue += $tempValue;
		$totBulkQty += $row["bulkQty"];
		$totBulkValue += $bulkValue;
		$totLQty += $row["leftoverQty"];
		$totLValue += $leftoverValue;
		
		switch($x)
			{
				case 'all':
				{
					$subCatTotQty= $row["StockQty"]+$row["tempQty"]+$row["bulkQty"]+$row["leftoverQty"];
					$subcatTotValue = $subcatStockValue + $tempValue +$bulkValue;
					if($withLeftVal=='true')
						$subcatTotValue += $leftoverValue;
					break;
				}
				case 'running':
				{
					$subCatTotQty= $row["StockQty"]+$row["tempQty"];
					$subcatTotValue = $subcatStockValue + $tempValue;
					break;
				}
				case 'leftOvers':
				{
					$subCatTotQty= $row["leftoverQty"];
					$subcatTotValue = $leftoverValue;					
					break;
				}
				case 'bulk':
				{
					$subCatTotQty= $row["bulkQty"];
					$subcatTotValue = $bulkValue;
					break;
				}
			}	
		
		$totQty += $subCatTotQty;
		$totValue += $subcatTotValue;
	  ?>
      <tr bgcolor="#FFFFFF" class="normalfntRite">
        <td height="20" class="normalfnt" nowrap="nowrap">&nbsp;<?php echo $row["StrCatName"]; ?>&nbsp;</td>
         <?php 
		  if($x == 'all' || $x == "running")
			{
		  ?>
        <td nowrap="nowrap">&nbsp;<?php  echo ($row["StockQty"] == 0?'': number_format($row["StockQty"],2)); ?>&nbsp;</td>
        <td nowrap="nowrap">&nbsp;<?php echo ($subcatStockValue == 0?'':number_format($subcatStockValue,4)); ?>&nbsp;</td>
        <td nowrap="nowrap">&nbsp;<?php  echo ($row["tempQty"] == 0?'': number_format($row["tempQty"],2)); ?>&nbsp;</td>
        <td nowrap="nowrap">&nbsp;<?php echo ($tempValue == 0?'':number_format($tempValue,4)); ?>&nbsp;</td>
         <?php 
		  }
		  if($x == 'all' || $x == "bulk")
			{
		  ?>
        <td nowrap="nowrap">&nbsp;<?php  echo ($row["bulkQty"] == 0?'': number_format($row["bulkQty"],2)); ?>&nbsp;</td>
         <td nowrap="nowrap">&nbsp;<?php echo ($bulkValue == 0?'':number_format($bulkValue,4)); ?>&nbsp;</td>
           <?php 
		  }
		  if($x == 'all' || $x == "leftOvers")
			{
		  ?>
           <td nowrap="nowrap">&nbsp;<?php  echo ($row["leftoverQty"] == 0?'': number_format($row["leftoverQty"],2)); ?>&nbsp;</td>
           <?php if($withLeftVal=='true') {?>
         <td nowrap="nowrap">&nbsp;<?php echo ($leftoverValue == 0?'':number_format($leftoverValue,4)); ?>&nbsp;</td> 
         <?php 
		 	}
		 }
		 ?>
         <td nowrap="nowrap">&nbsp;<?php echo number_format($subCatTotQty,2); ?>&nbsp;</td>
        <td nowrap="nowrap">&nbsp;<?php echo number_format($subcatTotValue,4); ?>&nbsp;</td>
      </tr>
      <?php 
	 } 
	  ?>
       <tr bgcolor="#EBEBEB" class="normalfntRite">
        <td height="20" class="normalfnt" nowrap="nowrap"><B>&nbsp;Grand Total&nbsp;</B></td>
         <?php 
		  if($x == 'all' || $x == "running")
			{
		  ?>
        <td height="20"nowrap="nowrap">&nbsp;<b><?php echo ($totStockQty == 0?'':number_format($totStockQty,2)) ?></b>&nbsp;</td>
        <td height="20"nowrap="nowrap">&nbsp;<b><?php echo ($totStockVal == 0?'':number_format($totStockVal,4)) ?></b>&nbsp;</td>
        <td height="20"nowrap="nowrap">&nbsp;<b><?php echo ($totTempQty == 0?'':number_format($totTempQty,2)) ?></b>&nbsp;</td>
        <td height="20"nowrap="nowrap">&nbsp;<b><?php echo ($totTempValue == 0?'':number_format($totTempValue,4)) ?></b>&nbsp;</td>
         <?php 
		  }
		  if($x == 'all' || $x == "bulk")
			{
		  ?>
        <td height="20"nowrap="nowrap">&nbsp;<b><?php echo ($totBulkQty == 0?'':number_format($totBulkQty,2)) ?></b>&nbsp;</td>
        <td height="20"nowrap="nowrap">&nbsp;<b><?php echo ($totBulkValue == 0?'':number_format($totBulkValue,4)) ?></b>&nbsp;</td>
         <?php 
		  }
		  if($x == 'all' || $x == "leftOvers")
			{
		  ?>
        <td height="20"nowrap="nowrap">&nbsp;<b><?php echo ($totLQty == 0?'':number_format($totLQty,2)) ?></b>&nbsp;</td>
        <?php if($withLeftVal=='true') {?>
        <td height="20"nowrap="nowrap">&nbsp;<b><?php echo ($totLValue == 0?'':number_format($totLValue,4)) ?></b>&nbsp;</td>    	
        <?php
			} 
		}
		?>			
        <td height="20"nowrap="nowrap">&nbsp;<b><?php echo ($totQty == 0?'':number_format($totQty,2)) ?></b>&nbsp;</td>
        <td height="20"nowrap="nowrap">&nbsp;<b><?php echo ($totValue == 0?'':number_format($totValue,4)) ?></b>&nbsp;</td>      
       </tr> 
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php 
function getSubcategoryStockValue($subcategoryId,$tbl,$mainStores,$style,$color,$size)
{
	global $db;
	if($tbl != 'stocktransactions_bulk')
	{
		$sql = "select  round(sum(st.dblQty),2) as qty ,st.intMatDetailId,st.intGrnNo,st.intGrnYear ,st.intStyleId,st.strGRNType,st.strColor,st.strSize
from  matitemlist mil inner join $tbl st on st.intMatDetailId= mil.intItemSerial";
		if($tbl == 'stocktransactions_temp')
			$sql .= " inner join grnheader gh on gh.intGrnNo= st.intGrnNo and gh.intGRNYear=st.intGrnYear and gh.intStatus=1 and st.strType='GRN' ";
		$sql .= " where mil.intSubCatID='$subcategoryId'";
	if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
	if($style != "")
		$sql .= " and st.intStyleId = '$style'";
	if($color != "")
		$sql .= " and st.strColor = '$color'";
	if($size != "")
		$sql .= " and st.strSize = '$size'";
		$sql .=" group by st.intMatDetailId,st.intGrnNo,st.intGrnYear,intStyleId,st.strGRNType,st.strColor,st.strSize
having qty>0 ";
//echo $sql;
	}
	else
	{
		$sql = "select  round(sum(st.dblQty),2) as qty ,st.intMatDetailId,st.intBulkGrnNo as intGrnNo,st.intBulkGrnYear as intGrnYear,'style' as intStyleId, 'B' as strGRNType,st.strColor,st.strSize 
from  matitemlist mil inner join stocktransactions_bulk st on st.intMatDetailId= mil.intItemSerial
 where mil.intSubCatID='$subcategoryId' ";
 		if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
		if($color != "")
		$sql .= " and st.strColor = '$color'";
		if($size != "")
		$sql .= " and st.strSize = '$size'";
 		$sql .= " group by st.intMatDetailId,intGrnNo,intGrnYear,st.strColor,st.strSize
having qty>0";
	}	
	
	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$grnQty = $row["qty"];
		$grnValue += getGRNValue($grnQty,$row["intGrnNo"],$row["intGrnYear"],$row["strGRNType"],$row["intStyleId"],$row["intMatDetailId"],$row["strColor"],$row["strSize"]);
	}
	return round($grnValue,4);
}

function getGRNValue($grnQty,$grnNo,$grnYear,$grnType,$styleID,$matdetailID,$color,$size)
{
	global $db;
	if($grnType == 'S')
	{
		$sql = " select distinct gd.dblInvoicePrice as grnprice,gh.dblExRate as exRate
from grnheader gh inner join grndetails gd on
gh.intGrnNo = gd.intGrnNo and gh.intGRNYear = gd.intGRNYear
where gh.intGrnNo='$grnNo' and gh.intGRNYear='$grnYear' and gd.intMatDetailID='$matdetailID' 
  and gd.strColor ='$color' and  gd.strSize = '$size' ";
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
	
	$grnValue = $grnQty*$row["grnprice"]/$row["exRate"];
	return $grnValue;
}
?>
</body>
</html>
