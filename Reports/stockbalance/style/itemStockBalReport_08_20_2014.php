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
<script language="javascript" src="../../../javascript/script.js"></script>
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
				case 'bulk':
				{
					$reportType = 'Bulk';
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
          <th width="40%" height="22" >Material</th>
          <th width="18%" >Color</th>
          <th width="16%" >Size</th>
          <?php 
		  if($x == 'all' || $x == "running")
			{
		  ?>
          <th width="19%" >Stock Balance </th>
          <th width="19%" >Value </th>
          <th width="19%" >Not Trim Inspected Qty</th>
          <th width="19%" >Value </th>
          <?php
		  } 
		  	if($x == 'all' || $x == "leftOvers")
			{
		  ?>
          <th width="19%" >Leftover Stock Balance</th>
          <?php if($withLeftVal=='true')
		  	{
		  ?>
           <th width="19%" > Value</th>
           
          <?php
		  	} 
		  }
		  if($x == 'all' || $x == "bulk")
			{
		  ?>
          <th width="19%" >Bulk Stock Balance</th>
           <th width="19%" > Value</th>
          
          <?php } 
		  if($x == 'all' || $x == "liability")
			{
		  ?> 
           <th width="19%" >Liability Qty</th>
           <th width="19%" >Value</th>
           <?php }?>
           <th width="19%" >Total Qty</th>
           <th width="19%" >Total Value</th>
        </tr>
		<?php
		
		
		if($x=='leftOvers')
			$tbl='stocktransactions_leftover';
		else
			$tbl = 'stocktransactions';	
		
		$sql = "(select mil.strItemDescription,st.intMatDetailId,st.strColor,st.strSize, sum(st.stockQty) as stockQty,
(select sum(temp.tempQty) from tempstock_view temp 
inner join  matitemlist mil on mil.intItemSerial= temp.intMatDetailId
inner join orders o on o.intStyleId = temp.intStyleId
where st.intMatDetailId = temp.intMatDetailId and st.strColor = temp.strColor and st.strSize = temp.strSize ";
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
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
		if($OrderType !='')
			$sql .= " and o.intOrderType ='$OrderType' ";
				
		$sql .= " ) as tempQty,
(select sum(sl.leftoverStock) from leftstock_view sl
inner join  matitemlist mil on mil.intItemSerial=  sl.intMatDetailId
inner join orders o on o.intStyleId = sl.intStyleId
 where st.intMatDetailId = sl.intMatDetailId and st.strColor = sl.strColor and st.strSize = sl.strSize ";
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
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
		if($OrderType !='')
			$sql .= " and o.intOrderType ='$OrderType' ";
				 
 		$sql .= " ) as leftoverQty,
(select sum(sb.bulkQty) from bulkstock_view sb 
inner join  matitemlist mil on mil.intItemSerial= sb.intMatDetailId
where st.intMatDetailId = sb.intMatDetailId and st.strColor = sb.strColor and st.strSize = sb.strSize ";
		if($mainStores != '')
			$sql .=" and sb.strMainStoresID =$mainStores ";			
		if($mainId!='')
			$sql .=" and mil.intMainCatID =$mainId ";	
		if($subId!='')
			$sql .=" and mil.intSubCatID =$subId ";
		if($matItem!='')
			$sql .=" and sb.intMatDetailId =$matItem ";	
		if($color!='')
			$sql .=" and sb.strColor ='$color' ";
		if($size!='')
			$sql .=" and sb.strSize ='$size' ";	
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
		$sql .= " ) as bulkQty,
		 (select sum(sl.liabilityQty) from liabilitystock_view sl
inner join  matitemlist mil on mil.intItemSerial=  sl.intMatDetailId
inner join orders o on o.intStyleId = sl.intStyleId
 where st.intMatDetailId = sl.intMatDetailId and st.strColor = sl.strColor and st.strSize = sl.strSize ";
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
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
		if($OrderType !='')
			$sql .= " and o.intOrderType ='$OrderType' ";
			
 $sql .= " ) as liabilityQty  from stock_view st inner join matitemlist mil on mil.intItemSerial= st.intMatDetailId
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
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
		if($OrderType !='')
			$sql .= " and o.intOrderType ='$OrderType' ";
		$sql .= " group by st.intMatDetailId,st.strColor,st.strSize)
union 
(select mil.strItemDescription,st.intMatDetailId,st.strColor,st.strSize,0,sum(st.tempQty) as tempQty,0,0,0 
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
		if($OrderType !='')
			$sql .= " and o.intOrderType ='$OrderType' ";	
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
			
	$sql .= " and st.intMatDetailId not in 
(select stt.intMatDetailId from stocktransactions stt inner join matitemlist mil on mil.intItemSerial= stt.intMatDetailId
inner join orders o on o.intStyleId = stt.intStyleId
 where stt.intMatDetailId = st.intMatDetailId and stt.strColor = st.strColor and stt.strSize = st.strSize ";
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
		if($OrderType !='')
			$sql .= " and o.intOrderType ='$OrderType' ";		
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
 	$sql .= " ) group by st.intMatDetailId,st.strColor,st.strSize )
	union
 (select mil.strItemDescription,st.intMatDetailId,st.strColor,st.strSize,0,0,sum(leftoverStock) as leftoverStock,0,0
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
		if($style!='')
			$sql .=" and st.intStyleId ='$style' ";
		if($OrderType !='')
			$sql .= " and o.intOrderType ='$OrderType' ";			
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
	$sql .= " and st.intMatDetailId not in 
(select stt.intMatDetailId from stocktransactions stt inner join matitemlist mil on mil.intItemSerial= stt.intMatDetailId
inner join orders o on o.intStyleId = stt.intStyleId
 where stt.intMatDetailId = st.intMatDetailId and stt.strColor = st.strColor and stt.strSize = st.strSize ";
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
		if($OrderType !='')
			$sql .= " and o.intOrderType ='$OrderType' ";	
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
 	$sql .=" )  group by st.intMatDetailId,st.strColor,st.strSize ) ";
 	$sql .= " union
 (select mil.strItemDescription,st.intMatDetailId,st.strColor,st.strSize,0,0,0,sum(bulkQty) as bulkQty,0
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
 where stt.intMatDetailId = st.intMatDetailId and stt.strColor = st.strColor and stt.strSize = st.strSize ";
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
 	$sql .= " ) group by st.intMatDetailId,st.strColor,st.strSize ) 
	union
 (select mil.strItemDescription,st.intMatDetailId,st.strColor,st.strSize,0,0,0,0,sum(liabilityQty) as liabilityQty
from liabilitystock_view st inner join  matitemlist mil on mil.intItemSerial= st.intMatDetailId
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
		if($OrderType !='')
			$sql .= " and o.intOrderType ='$OrderType' ";			
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
	$sql .= " and st.intMatDetailId not in 
(select stt.intMatDetailId from stocktransactions stt inner join matitemlist mil on mil.intItemSerial= stt.intMatDetailId
inner join orders o on o.intStyleId = stt.intStyleId
 where stt.intMatDetailId = st.intMatDetailId and stt.strColor = st.strColor and stt.strSize = st.strSize ";
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
		if($OrderType !='')
			$sql .= " and o.intOrderType ='$OrderType' ";	
		if($txtmatItem!='')
			$sql .=" and mil.strItemDescription like '%$txtmatItem%' ";
 	$sql .=" )  group by st.intMatDetailId, st.strSize, st.strColor ) ";
 $sql .= " order by strItemDescription, strSize ";
//die($sql);
			$result = $db->RunQuery($sql);
		while($row = mysql_fetch_array($result))
		{
			
			$sum = 0;
			$sum1 = 0;
			$matId = $row["intMatDetailId"];
			
			$sql_chk1 = "select  round(sum(st.dblQty),2) as chkqty 
from stocktransactions st inner join bulkgrnheader gh on gh.intBulkGrnNo=st.intGrnNo 
and gh.intYear = st.intGrnYear INNER JOIN bulkpurchaseorderheader ON gh.intBulkPoNo = bulkpurchaseorderheader.intBulkPoNo AND gh.intBulkPoYear = bulkpurchaseorderheader.intYear
where st.intMatDetailId=$matId and bulkpurchaseorderheader.strBulkPOType='1' and st.strGRNType='B' ";
			
			$res_chk  = $db->RunQuery($sql_chk1);
			$row_chk  = mysql_fetch_array($res_chk);
			if(mysql_num_rows($res_chk)>0)
				$sum=$row_chk['chkqty'];
			
			$sql_chk2 = "select round(sum(st.dblQty),2) as chkqty 
from stocktransactions_leftover st inner join bulkgrnheader gh on gh.intBulkGrnNo=st.intGrnNo 
and gh.intYear = st.intGrnYear INNER JOIN bulkpurchaseorderheader ON gh.intBulkPoNo = bulkpurchaseorderheader.intBulkPoNo AND gh.intBulkPoYear = bulkpurchaseorderheader.intYear
where st.intMatDetailId=$matId and bulkpurchaseorderheader.strBulkPOType='1' and st.strGRNType='B' ";


			$res_chk2  = $db->RunQuery($sql_chk2);
			$row_chk2  = mysql_fetch_array($res_chk2);
			
			if(mysql_num_rows($res_chk2)>0)
				$sum1=$row_chk2['chkqty'];	
			
			
			$stockQty = round($row["stockQty"]-$sum-$sum1,2);
			
			
			$tempQty = round($row["tempQty"],2);
			$leftoverQty = round($row["leftoverQty"],2);
			$bulkQty = round($row["bulkQty"],2);
			$liabilityQty = round($row["liabilityQty"],2);
			
			$stockValue =0;
			$tempValue =0;
			$leftoverValue =0;
			$bulkValue=0;
			$liabilityValue =0;
			
			if($stockQty>0)
				$stockValue = getStockValue('stocktransactions',$row["intMatDetailId"],$row["strColor"],$row["strSize"],$style,$mainStores,$subId,$OrderType);
			if($tempQty>0)	
				$tempValue = getStockValue('stocktransactions_temp',$row["intMatDetailId"],$row["strColor"],$row["strSize"],$style,$mainStores,$subId,$OrderType);
			if($leftoverQty>0)	
				$leftoverValue = getStockValue('stocktransactions_leftover',$row["intMatDetailId"],$row["strColor"],$row["strSize"],$style,$mainStores,$subId,$OrderType);
			if($bulkQty>0)	
			$bulkValue = getStockValue('stocktransactions_bulk',$row["intMatDetailId"],$row["strColor"],$row["strSize"],$style,$mainStores,$subId,$OrderType);
			if($liabilityQty>0)
				$liabilityValue = getStockValue('stocktransactions_liability',$row["intMatDetailId"],$row["strColor"],$row["strSize"],$style,$mainStores,$subId,$OrderType);
			
			//$totQty = $stockQty + $tempQty + $leftoverQty +$bulkQty; 
			//$totValue = $stockValue + $tempValue +$leftoverValue +$bulkValue;
			
			$totStockQty += $stockQty;
			$totTempQty += $tempQty;
			$totLeftQty += $leftoverQty;
			$totBulkQty += $bulkQty;
			$totLiabilityQty += $liabilityQty;
			
			$totStockValue += $stockValue;
			$totTempValue += $tempValue;
			$totLeftValue += $leftoverValue;
			$totBulkValue += $bulkValue;
			$totLiabilityValue += $liabilityValue;
			
			
			switch($x)
			{
				case 'all':
				{
					$totQty = $stockQty + $tempQty + $leftoverQty +$bulkQty+$totLiabilityQty;
					$totValue = $stockValue + $tempValue  +$bulkValue+$totLiabilityValue; 
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
					if($withLeftVal=='true')
						$totValue += $leftoverValue;	
					break;
				}
				case 'bulk':
				{
					$totQty = $bulkQty;
					$totValue = $bulkValue;	
					break;
				}
				case 'liability':
				{
					$totQty = $liabilityQty;
					$totValue = $liabilityValue;	
					break;
				}
			}	
			
			$grandTotQty += $totQty;
			$grandTotValue += $totValue;
			
			if($totQty ==0 && $with0=='false')
				continue;
				
			$strUrl  = "stockItemValueReport.php?StyleID=".$style.'&x='.$x.'&MatDetailID='.$row["intMatDetailId"].'&color='.urlencode($row["strColor"]).'&size='.urlencode($row["strSize"]).'&mainStores='.$mainStores.'&OrderType='.$OrderType.'&withLeftVal='.$withLeftVal;
			
			
		?>
       
		  <tr bgcolor="#FFFFFF" class="normalfntRite">
          <!--<td height="20" class="normalfnt"  nowrap="nowrap" onclick="viewItemDetails(<?php //echo "'".$x."'".','.$row["intMatDetailId"].','."'".$row["strColor"]."'".','."'".$row["strSize"]."'" ?>);"><a  target="_blank" ><?php //echo $row["strItemDescription"]; ?></a></td>-->
          <td height="20" class="normalfnt"  nowrap="nowrap" ><a  href="<?php echo $strUrl; ?>"  target="_blank" ><?php echo $row["strItemDescription"]; ?></a></td>
          <td class="normalfnt"  nowrap="nowrap"><?php echo $row["strColor"]; ?></td>
          <td class="normalfnt"  nowrap="nowrap"><?php echo $row["strSize"]; ?></td>
          <?php 
		  if($x == 'all' || $x == "running")
			{
		  ?>
          <td  nowrap="nowrap"><?php echo ($stockQty == 0?'&nbsp;':number_format($stockQty,2)); ?></td>
          <td  nowrap="nowrap"><?php echo ($stockValue == 0?'&nbsp;':number_format($stockValue,4));  ?></td>
          <td  nowrap="nowrap"><?php echo ($tempQty == 0?'&nbsp;':number_format($tempQty,2));  ?></td>
          <td  nowrap="nowrap"><?php echo ($tempValue == 0?'&nbsp;':number_format($tempValue,4)); ?></td>
          <?php 
		  }
		  if($x == 'all' || $x == "leftOvers")
			{
		  ?>
          <td  nowrap="nowrap"><?php echo ($leftoverQty == 0?'&nbsp;':number_format($leftoverQty,2));  ?></td>
          	<?php if($withLeftVal=='true') { ?>
          <td  nowrap="nowrap"><?php echo ($leftoverValue == 0?'&nbsp;':number_format($leftoverValue,4));  ?></td>
          <?php
		  	} 
		  }
		  if($x == 'all' || $x == "bulk")
			{
		  ?>
          <td  nowrap="nowrap"><?php echo ($bulkQty == 0?'&nbsp;':number_format($bulkQty,2));   ?></td>
          <td  nowrap="nowrap"><?php echo ($bulkValue == 0?'&nbsp;':number_format($bulkValue,4));   ?></td>
         
          <?php 
		  }
		   if($x == 'all' || $x == "liability")
			{
		  ?>
           <td  nowrap="nowrap"><?php echo ($liabilityQty ==0?'&nbsp;':number_format($liabilityQty,2)); ?></td>
          <td  nowrap="nowrap"><?php echo ($liabilityValue == 0?'&nbsp;':number_format($liabilityValue,4));   ?></td>
          <?php }?>
          <td  nowrap="nowrap"><?php echo  ($totQty == 0?'&nbsp;':number_format($totQty,4)); ?></td>
           <td  nowrap="nowrap"><?php echo ($totValue == 0?'&nbsp;':number_format($totValue,4));?></td>
          </tr>  
        <?php 
			
		}
	
		?>
        
        <tr bgcolor="#EBEBEB" class="normalfntRite">
          <td height="20" class="normalfnt"  nowrap="nowrap" colspan="3">&nbsp;&nbsp;<b>Grand Total</b></td>
          <?php 
		  if($x == 'all' || $x == "running")
			{
		  ?>
          <td  nowrap="nowrap">&nbsp;<b><?php echo ($totStockQty == 0?'&nbsp;':number_format($totStockQty,2)); ?></b>&nbsp;</td>
          <td  nowrap="nowrap">&nbsp;<b><?php echo ($totStockValue == 0?'&nbsp;':number_format($totStockValue,4));  ?></b>&nbsp;</td>
          <td  nowrap="nowrap">&nbsp;<b><?php echo ($totTempQty == 0?'&nbsp;':number_format($totTempQty,2));  ?></b>&nbsp;</td>
          <td  nowrap="nowrap">&nbsp;<b><?php echo ($totTempValue == 0?'&nbsp;':number_format($totTempValue,4)); ?></b>&nbsp;</td>
          <?php 
		  }
		   if($x == 'all' || $x == "leftOvers")
			{
		  ?>
          <td  nowrap="nowrap">&nbsp;<b><?php echo ($totLeftQty == 0?'&nbsp;':number_format($totLeftQty,2));  ?></b>&nbsp;</td>
          	<?php if($withLeftVal=='true') {?>
          <td  nowrap="nowrap">&nbsp;<b><?php echo ($totLeftValue == 0?'&nbsp;':number_format($totLeftValue,4));  ?></b>&nbsp;</td>
          <?php 
		  	}
		  }
		  if($x == 'all' || $x == "bulk")
			{
		  ?>
          <td  nowrap="nowrap">&nbsp;<b><?php echo ($totBulkQty == 0?'&nbsp;':number_format($totBulkQty,2));   ?></b>&nbsp;</td>
          <td  nowrap="nowrap">&nbsp;<b><?php echo ($totBulkValue == 0?'&nbsp;':number_format($totBulkValue,4));   ?></b>&nbsp;</td>
         
          <?php 
		  }
		   if($x == 'all' || $x == "liability")
			{
		  ?>
            <td  nowrap="nowrap">&nbsp;<b><?php echo ($totLiabilityQty == 0?'&nbsp;':number_format($totLiabilityQty,2));   ?></b>&nbsp;</td>
          <td  nowrap="nowrap">&nbsp;<b><?php echo ($totLiabilityValue == 0?'&nbsp;':number_format($totLiabilityValue,4));   ?></b>&nbsp;</td>
          <?php }?>
          <td  nowrap="nowrap">&nbsp;<b><?php echo  ($grandTotQty == 0?'&nbsp;':number_format($grandTotQty,4)); ?></b>&nbsp;</td>
           <td  nowrap="nowrap">&nbsp;<b><?php echo ($grandTotValue == 0?'&nbsp;':number_format($grandTotValue,4));?></b>&nbsp;</td>
          </tr>  
    </table></td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
  </tr>
</table>
<?php 
function getStockValue($tbl,$matDetailID,$color,$size,$style,$mainStores,$subcategoryId,$OrderType)
{
	global $db;
	if($tbl != 'stocktransactions_bulk')
	{
		$sql = "select  round(sum(st.dblQty),2) as qty ,st.intMatDetailId,st.intGrnNo,st.intGrnYear ,st.intStyleId,st.strGRNType,st.strColor,st.strSize
from  matitemlist mil inner join $tbl st on st.intMatDetailId= mil.intItemSerial
inner join orders o on o.intStyleId = st.intStyleId ";
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
	if($OrderType !='')
			$sql .= " and o.intOrderType ='$OrderType' ";		
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
	
	//echo $sql; 	
	
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
	//echo $sql;
	$grnValue = $grnQty*$row["grnprice"]/$row["exRate"];
	return $grnValue;
}
 ?>
 <script language="javascript" type="text/javascript">
 function viewItemDetails(x,MatDetailID,color,size)
{
	
	var url = "stockItemValueReport.php?";
	url += "&x="+x;
	url += "&MatDetailID="+MatDetailID;
	url += "&color="+URLEncode(color);
	url += "&size="+URLEncode(size);
	//url += "&mainStores="+mainStores;
	//url += "&itemDesc="+URLEncode(itemDesc);
	
	window.open(url);
}
 </script>
</body>
</html>