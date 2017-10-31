<?php
 session_start();
include "../../../Connector.php";

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Bulk Stock Balance Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<?php 
			$mainId		= $_GET["mainId"];
			$subId		= $_GET["subId"];
			$matItem	= $_GET["maiItem"];
			$color		= $_GET["color"];
			$size		= $_GET["size"];
			$style		= $_GET["style"];
			$mainStores	= $_GET["mainStores"];
			$with0		= $_GET["with0"];
			$x			= $_GET["x"];
			$txtmatItem	= $_GET["txtmatItem"];
			$OrderType = $_GET["OrderType"];
			$Merchandiser = $_GET["Merchandiser"];
			
			$SQL = 	"SELECT  mainstores.strName FROM mainstores where strMainID=$mainStores";
			$result = $db->RunQuery($SQL);
			while($row = mysql_fetch_array($result))
				$sStores =  $row["strName"];
				
			if($sStores=='')
				$sStores = 'All';
			
?>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td height="38" class="head1" align="center">STOCK BALANCE REPORT ( <span><?php echo $sStores; ?> </span>)</td>
  </tr>
  <tr>
    <td><table width="800" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="258">Material</th>
        <th width="139">Color</th>
        <th width="126">Size</th>
        <th width="111">Bulk Stock Balance</th>
        <th width="150">Value</th>
      </tr>
      <?php 
	  $sql =" select mil.strItemDescription,st.intMatDetailId,st.strColor,st.strSize,sum(bulkQty) as bulkQty from bulkmerchandstockview st 
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
		
		if($with0=='false')
			$sql .= " having bulkQty > 0 ";
		else
			$sql .= " having bulkQty >= 0";	
				
		$result = $db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{
			$grnValue = getStockValue('stocktransactions_bulk',$row["intMatDetailId"],$row["strColor"],$row["strSize"],$mainStores,$subId,$Merchandiser);
			$totQty += 	$row["bulkQty"];
			$totValue += $grnValue;
			
			$strUrl  = "stockItemValueReport.php?&x=bulk&MatDetailID=".$row["intMatDetailId"].'&color='.urlencode($row["strColor"]).'&size='.urlencode($row["strSize"]).'&mainStores='.$mainStores.'&Merchandiser='.$Merchandiser;
	  ?>
      <tr bgcolor="#FFFFFF" class="normalfnt">
        <td height="20" nowrap><a  href="<?php echo $strUrl; ?>"  target="_blank" ><?php echo $row["strItemDescription"]; ?></a></td>
        <td nowrap><?php echo $row["strColor"]; ?></td>
        <td nowrap><?php echo $row["strSize"]; ?></td>
        <td class="normalfntRite"><?php echo number_format($row["bulkQty"],2); ?></td>
        <td class="normalfntRite"><?php echo number_format($grnValue,2); ?></td>
      </tr>
      <?php 
	  }
	  ?>
      <tr bgcolor="#EBEBEB" class="normalfntRite">
      <td colspan="3" class="normalfnt" height="20">&nbsp;&nbsp;<b>Grand Total</b></td>
      <td><b><?php echo number_format($totQty,2); ?></b></td>
      <td><b><?php echo number_format($totValue,2); ?></b></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php 
function getStockValue($tbl,$matDetailID,$color,$size,$mainStores,$subcategoryId,$Merchandiser)
{
	global $db;
	
		$sql = "select  round(sum(st.dblQty),2) as qty ,st.intMatDetailId,st.intBulkGrnNo as intGrnNo,st.intBulkGrnYear as intGrnYear,'style' as intStyleId, 'B' as strGRNType,st.strColor,st.strSize 
from  matitemlist mil inner join stocktransactions_bulk st on st.intMatDetailId= mil.intItemSerial
inner join bulkgrndetails bgd on bgd.intMatDetailID = st.intMatDetailId 
inner join bulkgrnheader bgh on bgh.intBulkGrnNo = bgd.intBulkGrnNo and bgh.intYear= bgd.intYear
inner join bulkpurchaseorderheader bpo on bpo.intBulkPoNo = bgh.intBulkPoNo and bpo.intYear = bgh.intBulkPoYear
and st.intBulkGrnNo = bgd.intBulkGrnNo and st.intBulkGrnYear = bgd.intYear
 where st.intMatDetailId ='$matDetailID' ";
 		if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
		if($subcategoryId != "")
		$sql .= " and  mil.intSubCatID='$subcategoryId'";	
		if($color != "")
		$sql .= " and st.strColor = '$color'";
		if($size != "")
		$sql .= " and st.strSize = '$size'";
		if($Merchandiser !='')	
			$sql .= " and bpo.intMerchandiser='$Merchandiser' ";
 		$sql .= " group by st.intMatDetailId,intGrnNo,intGrnYear,st.strColor,st.strSize
having qty>0";
		
	
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
	if($grnType == 'B')
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
 ?>
</body>
</html>
