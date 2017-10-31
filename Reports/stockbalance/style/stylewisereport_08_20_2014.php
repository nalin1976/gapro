<?php
 session_start();
include "../../../Connector.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Style Stock Balance - Item Wise Report</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style4 {
	font-size: xx-large;
	color: #FF0000;
}
.style3 {
	font-size: xx-large;
	color: #FF0000;
}
-->

</style>

</head>

<body>
<?PHP
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
			$StyleNo = $_GET["StyleNo"];
			$OrderType = $_GET["OrderType"];
			$withLeftVal = $_GET["withLeftVal"];
			?>
<table width="800" border="0" align="center" >
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="75%" style="font-family: Arial;	font-size: 16pt;	color: #000000;font-weight: bold;" ><?php
		$SQL_alldetails="SELECT * FROM 
						companies
						Inner Join useraccounts ON companies.intCompanyID = useraccounts.intCompanyID
						WHERE
						useraccounts.intUserID =  '".$_SESSION["UserID"]."'";
		


$result_alldetails = $db->RunQuery($SQL_alldetails);

		
		while($row = mysql_fetch_array($result_alldetails))
		{		
		$intGrnNo=$row["intGrnNo"];
		$intGRNYear=$row["intGRNYear"];
		$intGRNYearnew= substr($intGRNYear, -2);
		$strInvoiceNo=$row["strInvoiceNo"];
		$strSupAdviceNo=$row["strSupAdviceNo"];
		$dtmAdviceDate=$row["dtmAdviceDate"];
		$dtmAdviceDateNew= substr($dtmAdviceDate,-19,10);
		$dtmAdviceDateNewDate= substr($dtmAdviceDateNew,-2);
		$dtmAdviceDateNewYear=substr($dtmAdviceDateNew,-10,4);
		$dtmAdviceDateNewmonth1=substr($dtmAdviceDateNew,-5);
		$dtmAdviceDateNewMonth=substr($dtmAdviceDateNewmonth1,-5,2);
		$strBatchNO=$row["strBatchNO"];
		$dtmConfirmedDate=$row["dtmConfirmedDate"];
		$dtmConfirmedDateNew= substr($dtmConfirmedDate,-19,10);
		$dtmConfirmedDateNewDate= substr($dtmConfirmedDateNew,-2);
		$dtmConfirmedDateNewYear=substr($dtmConfirmedDateNew,-10,4);
		$dtmConfirmedDateNewmonth1=substr($dtmConfirmedDateNew,-5);
		$dtmConfirmedDateNewMonth=substr($dtmConfirmedDateNewmonth1,-5,2);
		$strName=$row["strName"];
		$comAddress1=$row["strAddress1"];
		$comAddress2=$row["strAddress2"];
		$comStreet=$row["strStreet"];
		$comCity=$row["strCity"];
		$comCountry=$row["strCountry"];
		$comZipCode=$row["strZipCode"];
		$strPhone=$row["strPhone"];
		$comEMail=$row["strEMail"];
		$comFax=$row["strFax"];
		$comWeb=$row["strWeb"];
		$strTitle=$row["strTitle"];
		$strAddress1=$row["strAddress1"];
		$strAddress2=$row["strAddress2"];
		$strStreet=$row["strStreet"];
		$strCity=$row["strCity"];
		$strCountry=$row["strCountry"];
		$ConfirmedPerson=$row["ConfirmedPerson"];
		$ShippingMode=$row["ShippingMode"];
		$ShippingTerm=$row["ShippingTerm"];
		$PmntMode=$row["PmntMode"];
		$PmntTerm=$row["PmntTerm"];
		$dtmDeliveryDate=$row["dtmDeliveryDate"];
		$dtmDeliveryDateNew= substr($dtmDeliveryDate,-19,10);
		$dtmDeliveryDateNewDate= substr($dtmDeliveryDateNew,-2);
		$dtmDeliveryDateNewYear=substr($dtmDeliveryDateNew,-10,4);
		$dtmDeliveryDateNewmonth1=substr($dtmDeliveryDateNew,-5);
		$dtmDeliveryDateNewmonth=substr($dtmDeliveryDateNewmonth1,-5,2);
		$intPONo=$row["intPONo"];
		$intYear=$row["intYear"];
		$intYearnew= substr($intYear,-2);
		$strPINO=$row["strPINO"];
		$preparedperson=$row["preparedperson"];
		$grnStatus = $row["grnStatus"];
		$dtmRecievedDate = $row["dtmRecievedDate"];
		$merchandiser=$row["merchandiser"];
		}
		?></td>
<p class="head2BLCK"><?php echo $strName; ?></p>
<p class="normalfntMid">
		  <?php echo $comAddress1." ".$comAddress2." ".$comStreet."<br>".$comCity." ".$comCountry.".<br>"."Tel:".$comPhone." ".$comZipCode." Fax: ".$comFax."<br> E-Mail: ".$comEMail." Web: ".$comWeb;?></p>		  
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="head2BLCK">
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
			}	
		?>
        <td width="91%" height="38" class="head1">STOCK BALANCE REPORT ( <span><?php echo $sStores; ?></span> ) - <?php echo $reportType; ?></td>
        </tr>
    </table></td>
  </tr>
 
  <tr>
    <td><table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
        <tr bgcolor="#CCCCCC" class="normalfntMid">
          <th width="13%" >Style No </th>
          <th width="13%" >Order No </th>
          <th width="5%" >SCNo</th> 
          <th width="21%" height="22" >Material</th>
          <th width="7%" >Color</th>
          <th width="8%" >Size</th>
           <?php 
		  if($x == 'all' || $x == "running")
			{
		  ?>
          <th width="8%" >Stock Balance </th>
          <th width="12%" >Stock Balance Value </th>
          <th width="8%" >Not Trim Inspected Qty </th>
          <th width="12%" > Value </th>
          <?php 
		  }
		  	if($x == 'all' || $x == "leftOvers")
			{
		  ?>
          <th width="13%" >Leftover Stock Balance</th>
          	<?php if($withLeftVal=='true') {?>
           <th width="13%" >Leftover Stock Value</th>
           <?php }?>
          <?php 
		  }
		  ?>
           <th width="12%" >Total Qty</th>
           <th width="12%" >Total Value</th>
        </tr>
		<?php
		$check	= false;
		
		if($x=='leftOvers')
			$tbl='stocktransactions_leftover';
		else
			$tbl = 'stocktransactions';	
		
		$sql = "(select o.strOrderNo,o.strStyle,
		(select intSRNO from specification where specification.intStyleId=st.intStyleId)As ScNo,
		mil.strItemDescription,st.intMatDetailId,st.strColor,st.strSize,st.intStyleId, sum(st.stockQty) as stockQty,
(select sum(temp.tempQty) from tempstock_view temp 
inner join  matitemlist mil on mil.intItemSerial= temp.intMatDetailId
inner join orders o on o.intStyleId = temp.intStyleId
where st.intMatDetailId = temp.intMatDetailId and st.strColor = temp.strColor and st.strSize = temp.strSize and st.intStyleId = temp.intStyleId";
		if($mainStores != '')
			$sql .=" and temp.strMainStoresID =$mainStores ";			
		if($mainId!='')
			$sql .=" and mil.intMainCatID =$mainId ";	
		if($subId!='')
			$sql .=" and mil.intSubCatID =$subId ";
		if($matItem!='')
			$sql .=" and temp.intMatDetailId =$matItem ";	
		if($color!='')
			$sql .=" and temp.strColor ='$color' ";
		if($size!='')
			$sql .=" and temp.strSize ='$size' ";	
		if($style!='')
			$sql .=" and temp.intStyleId ='$style' ";
		if($StyleNo != '')	
			$sql .= " and o.strStyle = '$StyleNo' ";
		if($OrderType != '')
			$sql .= " and o.intOrderType = '$OrderType' ";	
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
			
		$sql .= " ) as tempQty,
(select sum(sl.leftoverStock) from leftstock_view sl
inner join  matitemlist mil on mil.intItemSerial=  sl.intMatDetailId
inner join orders o on o.intStyleId = sl.intStyleId
 where st.intMatDetailId = sl.intMatDetailId and st.strColor = sl.strColor and st.strSize = sl.strSize and st.intStyleId = sl.intStyleId";
		if($mainStores != '')
			$sql .=" and sl.strMainStoresID =$mainStores ";			
		if($mainId!='')
			$sql .=" and mil.intMainCatID =$mainId ";	
		if($subId!='')
			$sql .=" and mil.intSubCatID =$subId ";
		if($matItem!='')
			$sql .=" and sl.intMatDetailId =$matItem ";	
		if($color!='')
			$sql .=" and sl.strColor ='$color' ";
		if($size!='')
			$sql .=" and sl.strSize ='$size' ";	
		if($style!='')
			$sql .=" and sl.intStyleId ='$style' ";
		if($StyleNo != '')	
			$sql .= " and o.strStyle = '$StyleNo' ";
		if($OrderType != '')
			$sql .= " and o.intOrderType = '$OrderType' ";			
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
			 
 		$sql .= " ) as leftoverQty		
from stock_view st inner join matitemlist mil on mil.intItemSerial= st.intMatDetailId
inner join orders o on o.intStyleId = st.intStyleId 
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
		if($style!='')
			$sql .=" and st.intStyleId ='$style' ";
		if($StyleNo != '')	
			$sql .= " and o.strStyle = '$StyleNo' ";
		if($OrderType != '')
			$sql .= " and o.intOrderType = '$OrderType' ";			
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
		
		$sql .= " group by st.intStyleId, st.intMatDetailId,st.strColor,st.strSize)
union 
(select  o.strOrderNo,o.strStyle,
		(select intSRNO from specification where specification.intStyleId=st.intStyleId)As ScNo,
 mil.strItemDescription,st.intMatDetailId,st.strColor,st.strSize,st.intStyleId,0,sum(st.tempQty) as tempQty,0
from tempstock_view st inner join  matitemlist mil on mil.intItemSerial= st.intMatDetailId
inner join orders o on o.intStyleId = st.intStyleId 
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
		if($style!='')
			$sql .=" and st.intStyleId ='$style' ";
		if($StyleNo != '')	
			$sql .= " and o.strStyle = '$StyleNo' ";
		if($OrderType != '')
			$sql .= " and o.intOrderType = '$OrderType' ";			
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
			
	$sql .= " and st.intMatDetailId not in 
(select stt.intMatDetailId from stocktransactions stt inner join matitemlist mil on mil.intItemSerial= stt.intMatDetailId
inner join orders o on o.intStyleId = stt.intStyleId 
 where stt.intMatDetailId = st.intMatDetailId and stt.strColor = st.strColor and stt.strSize = st.strSize and stt.intStyleId = st.intStyleId ";
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
		if($StyleNo != '')	
			$sql .= " and o.strStyle = '$StyleNo' ";
		if($OrderType != '')
			$sql .= " and o.intOrderType = '$OrderType' ";				
		if($style!='')
			$sql .=" and stt.intStyleId ='$style' ";
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
 	$sql .= " ) group by st.intStyleId, st.intMatDetailId,st.strColor,st.strSize )
	union
 (select o.strOrderNo,o.strStyle,
		(select intSRNO from specification where specification.intStyleId=st.intStyleId)As ScNo,
  mil.strItemDescription,st.intMatDetailId,st.strColor,st.strSize,st.intStyleId,0,0,sum(leftoverStock) as leftoverStock
from leftstock_view st inner join  matitemlist mil on mil.intItemSerial= st.intMatDetailId
inner join orders o on o.intStyleId = st.intStyleId 
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
		if($StyleNo != '')	
			$sql .= " and o.strStyle = '$StyleNo' ";
		if($OrderType != '')
			$sql .= " and o.intOrderType = '$OrderType' ";			
		if($style!='')
			$sql .=" and st.intStyleId ='$style' ";
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
	$sql .= " and st.intMatDetailId not in 
(select stt.intMatDetailId from stocktransactions stt inner join matitemlist mil on mil.intItemSerial= stt.intMatDetailId
inner join orders o on o.intStyleId = stt.intStyleId 
 where stt.intMatDetailId = st.intMatDetailId and stt.strColor = st.strColor and stt.strSize = st.strSize and stt.intStyleId = st.intStyleId ";
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
		if($style!='')
			$sql .=" and stt.intStyleId ='$style' ";
		if($OrderType != '')
			$sql .= " and o.intOrderType = '$OrderType' ";		
		if($StyleNo != '')	
			$sql .= " and o.strStyle = '$StyleNo' ";	
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
 	$sql .=" )  group by st.intStyleId, st.intMatDetailId,st.strColor,st.strSize ) ";
 	 $sql .= " order by strOrderNo, strItemDescription ";
//echo $sql;
$preStyleId = '';
			$result = $db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{
			$currStyleId = $row["intStyleId"];
			$stockQty = round($row["stockQty"],2);
			$tempQty = round($row["tempQty"],2);
			$leftoverQty = round($row["leftoverQty"],2);
						
			$stockValue =0;
			$tempValue =0;
			$leftoverValue =0;
						
			if($stockQty>0)
				$stockValue = getStockValue('stocktransactions',$row["intMatDetailId"],$row["strColor"],$row["strSize"],$currStyleId,$mainStores,$subId);
			if($tempQty>0)	
				$tempValue = getStockValue('stocktransactions_temp',$row["intMatDetailId"],$row["strColor"],$row["strSize"],$currStyleId,$mainStores,$subId);
			if($leftoverQty>0)	
				$leftoverValue = getStockValue('stocktransactions_leftover',$row["intMatDetailId"],$row["strColor"],$row["strSize"],$currStyleId,$mainStores,$subId);
					
			$totStockQty += $stockQty;
			$totTempQty += $tempQty;
			$totLeftQty += $leftoverQty;
			
			$totStockValue += $stockValue;
			$totTempValue += $tempValue;
			$totLeftValue += $leftoverValue;
			
			switch($x)
			{
				case 'all':
				{
					$totQty = $stockQty + $tempQty + $leftoverQty;
					$totValue = $stockValue + $tempValue;
					if($withLeftVal=='true') 
						$totValue += $leftoverValue;
					break;
				}
				case 'running':
				{
					$totQty = $stockQty + $tempQty;
					$totValue = $stockValue + $tempValue; 
					break;
				}
				case 'leftOvers':
				{
					$totQty = $leftoverQty;
					$totValue = $leftoverValue;	
					break;
				}
				
			}	
			
			
			
			$grandTotQty += $totQty;
			$grandTotValue += $totValue;
			
			if($totQty ==0 && $with0=='false')
				continue;
				
			$strUrl  = "stockItemValueReport.php?StyleID=".$currStyleId.'&x='.$x.'&MatDetailID='.$row["intMatDetailId"].'&color='.urlencode($row["strColor"]).'&size='.urlencode($row["strSize"]).'&mainStores='.$mainStores.'&withLeftVal='.$withLeftVal;
			//echo $x;
			
			if($preStyleId != $currStyleId && $preStyleId!='')
			{
			?>
            <tr bgcolor="#FFFFFF">
          <td height="20" colspan="4" nowrap="nowrap" class="normalfnt"><span class="normalfntSMB">&nbsp;&nbsp;&nbsp;Order Wise Sub Total</span></td>
		  <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfntRite"><strong><?php  echo ($totStyleStockQty == 0?'&nbsp;':number_format($totStyleStockQty,2));		 ?></strong></td>
          <td class="normalfntRite"><strong><?php  echo ($totStyleStockValue == 0?'&nbsp;':number_format($totStyleStockValue,4));		 ?></strong></td>
           <td class="normalfntRite"><strong><?php  echo ($totStyleTempQty == 0?'&nbsp;':number_format($totStyleTempQty,2));		 ?></strong></td>
          <td class="normalfntRite"><strong><?php  echo ($totStyleTempValue == 0?'&nbsp;':number_format($totStyleTempValue,2));		 ?></strong></td>
         <?php
		  if($x == 'all')
		  {
		  ?>
          <td  class="normalfntRite"><strong><?php  echo ($totStyleLeftQty == 0?'&nbsp;':number_format($totStyleLeftQty,2));		 ?></strong></td>
          <?php if($withLeftVal=='true') {?>
          <td class="normalfntRite"><strong><?php  echo ($totStyleLeftValue == 0?'&nbsp;':number_format($totStyleLeftValue,2));		 ?></strong></td>
          
		  <?php
		  	}
		  }
		  ?>
          <td  class="normalfntRite"><strong><?php echo number_format($styleTotQty,4)?></strong></td>
          <td class="normalfntRite"><strong><?php echo number_format($stylTotValue,4)?></strong></td>
        </tr><?php
		$totStyleStockQty =0;
			$totStyleTempQty =0;
			$totStyleLeftQty =0;
			
			$totStyleStockValue =0;
			$totStyleTempValue =0;
			$totStyleLeftValue =0;
			
			$styleTotQty=0;
			$stylTotValue =0;
		
		 }?>
          
			<tr bgcolor="#FFFFFF">
			  <td class="normalfnt" nowrap="nowrap"><?php echo $row["strStyle"];?></td>
			<td class="normalfnt" nowrap="nowrap"><?php echo $row["strOrderNo"];?></td>
			<td class="normalfnt" nowrap="nowrap"><?php echo $row["ScNo"];?></td> 
			<td height="20" class="normalfnt" nowrap="nowrap"><a href="<?php echo $strUrl; ?>" target="_blank"><?php echo $row["strItemDescription"]; ?></a></td>
			<td class="normalfnt"><?php echo $row["strColor"]; ?></td>
			<td class="normalfnt"><?php  echo $row["strSize"]; ?></td>
			<td class="normalfntRite"><?php  echo ($stockQty == 0?'&nbsp;':number_format($stockQty,2)); ?></td>
			<td class="normalfntRite">
			<?php echo ($stockValue == 0?'&nbsp;':number_format($stockValue,4));  ?>
			</td>
             <td class="normalfntRite"><?php echo ($tempQty == 0?'&nbsp;':number_format($tempQty,2));  ?></td>
          <td class="normalfntRite"><?php echo ($tempValue == 0?'&nbsp;':number_format($tempValue,4)); ?></td>
			<?php 
			if($x == 'all' || $x == "leftOvers")
			{
			
			?>
			<td  class="normalfntRite"><?php echo ($leftoverQty == 0?'&nbsp;':number_format($leftoverQty,2));  ?></td>
            <?php if($withLeftVal=='true') {?>
			<td class="normalfntRite"><?php echo ($leftoverValue == 0?'&nbsp;':number_format($leftoverValue,4));  ?></td>
          <?php 
		  		}
		  }
		  ?>
          <td  nowrap="nowrap" class="normalfntRite"><?php echo  ($totQty == 0?'&nbsp;':number_format($totQty,4)); ?></td>
           <td  nowrap="nowrap" class="normalfntRite"><?php echo ($totValue == 0?'&nbsp;':number_format($totValue,4));?></td>
        </tr>
		
            <?php
			
			
			
			?>
             
			<?php
			//}//
			$preStyleId=$currStyleId;
			
			/*  order no wise totals*/
			$totStyleStockQty += $stockQty;
			$totStyleTempQty += $tempQty;
			$totStyleLeftQty += $leftoverQty;
			
			$totStyleStockValue += $stockValue;
			$totStyleTempValue += $tempValue;
			$totStyleLeftValue += $leftoverValue;
			
			switch($x)
			{
				case 'all':
				{
					$styleTotQty += $stockQty + $tempQty + $leftoverQty;  
					$stylTotValue += $stockValue + $tempValue;
					if($withLeftVal=='true') 
						$stylTotValue += $leftoverValue;		
					break;
				}
				case 'running':
				{
					$styleTotQty += $stockQty + $tempQty;  
					$stylTotValue += $stockValue + $tempValue;	
					break;
				}
				case 'leftOvers':
				{
					$styleTotQty += $leftoverQty;  
					$stylTotValue += $leftoverValue;	
					break;
				}
				
			}	
			/*  order no wise totals*/
			
		}
		?>
		  <tr bgcolor="#FFFFFF">
          <td height="20" colspan="4" nowrap="nowrap" class="normalfnt"><span class="normalfntSMB">&nbsp;&nbsp;&nbsp;Order Wise Sub Total</span></td>
		  <td class="normalfnt">&nbsp;</td>
          <td class="normalfnt">&nbsp;</td>
          <td class="normalfntRite"><strong><?php  echo ($totStyleStockQty == 0?'&nbsp;':number_format($totStyleStockQty,2));		 ?></strong></td>
          <td class="normalfntRite"><strong><?php  echo ($totStyleStockValue == 0?'&nbsp;':number_format($totStyleStockValue,4));		 ?></strong></td>
           <td class="normalfntRite"><strong><?php  echo ($totStyleTempQty == 0?'&nbsp;':number_format($totStyleTempQty,2));		 ?></strong></td>
          <td class="normalfntRite"><strong><?php  echo ($totStyleTempValue == 0?'&nbsp;':number_format($totStyleTempValue,2));		 ?></strong></td>
         <?php
		  if($x == 'all')
		  {
		  ?>
          <td  class="normalfntRite"><strong><?php  echo ($totStyleLeftQty == 0?'&nbsp;':number_format($totStyleLeftQty,2));		 ?></strong></td>
          <?php if($withLeftVal=='true') {?>
          <td class="normalfntRite"><strong><?php  echo ($totStyleLeftValue == 0?'&nbsp;':number_format($totStyleLeftValue,2));		 ?></strong></td>
		  <?php
		  		}
		  }
		  ?>
          <td  class="normalfntRite"><strong><?php echo number_format($styleTotQty,4)?></strong></td>
          <td class="normalfntRite"><strong><?php echo number_format($stylTotValue,4)?></strong></td>
        </tr>   
           
        <tr bgcolor="#EBEBEB">
         <td height="20" class="normalfnt" colspan="6" ><b>&nbsp;&nbsp;&nbsp;&nbsp;Grand Total</b></td>
          <td class="normalfntRite">&nbsp;<b><?php echo ($totStockQty == 0?'&nbsp;':number_format($totStockQty,2)); ?></b>&nbsp;</td>
           <td class="normalfntRite">&nbsp;<b><?php echo ($totStockValue == 0?'&nbsp;':number_format($totStockValue,4));  ?></b>&nbsp;</td>
            <td class="normalfntRite">&nbsp;<b><?php echo ($totTempQty == 0?'&nbsp;':number_format($totTempQty,2));  ?></b>&nbsp;</td>
          <td class="normalfntRite">&nbsp;<b><?php echo ($totTempValue == 0?'&nbsp;':number_format($totTempValue,4)); ?></b>&nbsp;</td>
           <?php 
		  	if($x == 'all')
			{
		  ?>
          <td  class="normalfntRite">&nbsp;<b><?php echo ($totLeftQty == 0?'&nbsp;':number_format($totLeftQty,2));  ?></b>&nbsp;</td>
          <?php if($withLeftVal=='true') {?>
         <td  class="normalfntRite">&nbsp;<b><?php echo ($totLeftValue == 0?'&nbsp;':number_format($totLeftValue,4));  ?></b>&nbsp;</td>
          <?php 
		    }
		  }
		  ?>
          <td  nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo  ($grandTotQty == 0?'&nbsp;':number_format($grandTotQty,4)); ?></b>&nbsp;</td>
           <td  nowrap="nowrap" class="normalfntRite">&nbsp;<b><?php echo ($grandTotValue == 0?'&nbsp;':number_format($grandTotValue,4));?></b>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
  </tr>
</table>
<?php 
function getStockValue($tbl,$matDetailID,$color,$size,$style,$mainStores,$subcategoryId)
{
	global $db;
	if($tbl != 'stocktransactions_bulk')
	{
		$sql = "select  round(sum(st.dblQty),2) as qty ,st.intMatDetailId,st.intGrnNo,st.intGrnYear ,st.intStyleId,st.strGRNType,st.strColor,st.strSize
from  matitemlist mil inner join $tbl st on st.intMatDetailId= mil.intItemSerial";
		if($tbl == 'stocktransactions_temp')
			$sql .= " inner join grnheader gh on gh.intGrnNo= st.intGrnNo and gh.intGRNYear=st.intGrnYear and gh.intStatus=1 and st.strType='GRN' ";
		$sql .= " where st.intMatDetailId ='$matDetailID'";
	if($subcategoryId != "")
		$sql .= " and  mil.intSubCatID='$subcategoryId'";	
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
 where st.intMatDetailId ='$matDetailID' ";
 		if($mainStores != "")
		$sql .= " and st.strMainStoresID = '$mainStores'";	
		if($subcategoryId != "")
		$sql .= " and  mil.intSubCatID='$subcategoryId'";	
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
 ?>
</body>
</html>