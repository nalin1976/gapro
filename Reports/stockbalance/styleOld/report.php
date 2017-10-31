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
          <th width="40%" height="22" >Material</th>
          <th width="18%" >Color</th>
          <th width="16%" >Size</th>
          <th width="19%" >Stock Balance </th>
           <th width="19%" >Stock Balance Value </th>
          <?php 
		  	if($x == 'all')
			{
		  ?>
          <th width="19%" >Leftover Stock Balance</th>
           <th width="19%" >Leftover Stock Value</th>
          <?php 
		  }
		  ?>
        </tr>
		<?php
		
		
		if($x=='leftOvers')
			$tbl='stocktransactions_leftover';
		else
			$tbl = 'stocktransactions';	
				
			$SQL = 	"(SELECT
					MIL.strItemDescription,
					ST.strColor,
					ST.strSize,
					round(sum(ST.dblQty),4) as balanceQty,
					ST.intMatDetailId,
					(select sum(SL.dblQty) from stocktransactions_leftover SL
					Inner Join matitemlist MIL ON MIL.intItemSerial = SL.intMatDetailId
					  where SL.intMatDetailId=ST.intMatDetailId and SL.strColor=ST.strColor and SL.strSize=ST.strSize and SL.strMainStoresID >0 ";
					  //get search criteria wise leftover stock qty
				if($mainStores != '')
				$SQL1 .=" and SL.strMainStoresID =$mainStores ";			
			if($mainId!='')
				$SQL1 .=" and intMainCatID =$mainId ";	
			if($subId!='')
				$SQL1 .=" and intSubCatID =$subId ";
			if($matItem!='')
				$SQL1 .=" and SL.intMatDetailId =$matItem ";	
			if($color!='')
				$SQL1 .=" and SL.strColor ='$color' ";
			if($size!='')
				$SQL1 .=" and SL.strSize ='$size' ";	
			if($style!='')
				$SQL1 .=" and SL.intStyleId ='$style' ";
			if($txtmatItem!='')
				$SQL1 .=" and MIL.strItemDescription like '%$txtmatItem%' ";
					
				$SQL1 .=" ) as leftoverStockQty ,1 as stockType
					FROM
					$tbl ST
					Inner Join matitemlist MIL ON MIL.intItemSerial = ST.intMatDetailId
					left join orders O ON O.intStyleId = ST.intStyleId
					where strMainStoresID>0";
			if($mainStores != '')
				$SQL1 .=" and strMainStoresID =$mainStores ";			
			if($mainId!='')
				$SQL1 .=" and intMainCatID =$mainId ";	
			if($subId!='')
				$SQL1 .=" and intSubCatID =$subId ";
			if($matItem!='')
				$SQL1 .=" and ST.intMatDetailId =$matItem ";	
			if($color!='')
				$SQL1 .=" and strColor ='$color' ";
			if($size!='')
				$SQL1 .=" and strSize ='$size' ";	
			if($style!='')
				$SQL1 .=" and ST.intStyleId ='$style' ";
			if($txtmatItem!='')
				$SQL1 .=" and MIL.strItemDescription like '%$txtmatItem%' ";	
			if($x=='running')
				$SQL1 .=" and O.intStatus not in (13,14) ";
			/*if($x=='leftOvers')
				$SQL1 .=" and O.intStatus=13 ";*/
				
			$SQL2 = " GROUP BY ST.intMatDetailId,strColor,strSize";
			
			if($with0=='true')
				$SQL2 .= " having balanceQty>=0 )";
			else
				$SQL2 .= " having balanceQty>0 )";
			
			//get items which are in leftoverstock
			if($x == 'all')
			{
				$SQL2 .= " union
(select mil.strItemDescription,sl.strColor,sl.strSize,0,sl.intMatDetailId,round(sum(sl.dblQty),4) as balanceQty,2
from stocktransactions_leftover sl inner join matitemlist mil on
mil.intItemSerial = sl.intMatDetailId
where sl.intMatDetailId not in (select st.intMatDetailId from stocktransactions st
inner join matitemlist mil on mil.intItemSerial = st.intMatDetailId
 where st.intMatDetailId=sl.intMatDetailId and sl.strColor = st.strColor and st.strSize=sl.strSize ";
//get search criteria wise leftover stock qty
	if($mainStores != '')
				$SQL2 .=" and strMainStoresID =$mainStores ";	
	if($mainId!='')
				$SQL2 .=" and intMainCatID =$mainId ";	
	if($subId!='')
		$SQL2 .=" and intSubCatID =$subId ";
	if($matItem!='')
		$SQL2 .=" and st.intMatDetailId =$matItem ";	
	if($color!='')
		$SQL2 .=" and strColor ='$color' ";
	if($size!='')
		$SQL2 .=" and strSize ='$size' ";	
	if($style!='')
		$SQL2 .=" and st.intStyleId ='$style' ";
	if($txtmatItem!='')
		$SQL2 .=" and mil.strItemDescription like '%$txtmatItem%' ";				
				//end search criteria wise leftover stock qty
	$SQL2 .= " ) ";
				if($mainStores != '')
				$SQL2 .=" and strMainStoresID =$mainStores ";			
			if($mainId!='')
				$SQL2 .=" and intMainCatID =$mainId ";	
			if($subId!='')
				$SQL2 .=" and intSubCatID =$subId ";
			if($matItem!='')
				$SQL2 .=" and sl.intMatDetailId =$matItem ";	
			if($color!='')
				$SQL2 .=" and strColor ='$color' ";
			if($size!='')
				$SQL2 .=" and strSize ='$size' ";	
			if($style!='')
				$SQL2 .=" and sl.intStyleId ='$style' ";
			if($txtmatItem!='')
				$SQL2 .=" and mil.strItemDescription like '%$txtmatItem%' ";	
				
				$SQL2 .= "GROUP BY strItemDescription,strColor,strSize";
			
			if($with0=='true')
				$SQL2 .= " having balanceQty>=0 )";
			else
				$SQL2 .= " having balanceQty>0 )";
			}
			
			//if leftover don't show the not trim inspected 
		if($x !='leftOvers')
			{
			$SQL2 .= " union
(select mil.strItemDescription,sl.strColor,sl.strSize,round(sum(sl.dblQty),4) as balanceQty,sl.intMatDetailId,0,3
from stocktransactions_temp sl inner join matitemlist mil on
mil.intItemSerial = sl.intMatDetailId
inner join grnheader gh on gh.intGrnNo= sl.intGrnNo and gh.intGRNYear=sl.intGrnYear
where  sl.strType='GRN' and gh.intStatus=1 ";
				if($mainStores != '')
				$SQL2 .=" and strMainStoresID =$mainStores ";			
			if($mainId!='')
				$SQL2 .=" and intMainCatID =$mainId ";	
			if($subId!='')
				$SQL2 .=" and intSubCatID =$subId ";
			if($matItem!='')
				$SQL2 .=" and sl.intMatDetailId =$matItem ";	
			if($color!='')
				$SQL2 .=" and strColor ='$color' ";
			if($size!='')
				$SQL2 .=" and strSize ='$size' ";	
			if($style!='')
				$SQL2 .=" and sl.intStyleId ='$style' ";
			if($txtmatItem!='')
				$SQL2 .=" and mil.strItemDescription like '%$txtmatItem%' ";	
				
				$SQL2 .= "GROUP BY strItemDescription,strColor,strSize";
				
			if($with0=='true')
				$SQL2 .= " having balanceQty>=0 )";
			else
				$SQL2 .= " having balanceQty>0 )";
			}	
			$SQL3 = " ORDER BY strItemDescription,strColor,strSize ASC ";
			$SQL = $SQL.$SQL1.$SQL2.$SQL3;
			//echo $SQL;
			$result = $db->RunQuery($SQL);
			$totRunStock =0;
			$totLeftStock = 0;
			$totVal=0;
			$totLeftVal =0;
			while($row = mysql_fetch_array($result))
			{
				$totRunStock +=  $row["balanceQty"];
				$totLeftStock +=  $row["leftoverStockQty"];
				$trimInsValue =0;
				$value=0;
			//stockType 1-get data from stocktransation , 3- get data from stocktransaction temp(not trim inspected data)
				$stockType = $row["stockType"];
				switch($stockType)
				{
					case 1:
					{
						$value = getStockValue($row["intMatDetailId"],$row["strColor"],$row["strSize"],$with0,$mainStores,$style,$tbl);
						$trimInsValue =0;
						$tblVal=$tbl;
						break;
					}
					case 3:
					{
						$value = 0;
						$trimInsValue =getTrimInspectValue($row["intMatDetailId"],$row["strColor"],$row["strSize"],$with0,$mainStores,$style,'stocktransactions_temp');
						$tblVal= 'stocktransactions_temp';
						break;
					}
				}
				$value += $trimInsValue;
			/*if(round($row["balanceQty"],4)>0)
			{*/
				$strUrl  = "stockItemValueReport.php?StyleID=".$style.'&x='.$x.'&MatDetailID='.$row["intMatDetailId"].'&color='.$row["strColor"].'&size='.$row["strSize"].'&tbl='.$tblVal.'&mainStores='.$mainStores.'&itemDesc='.$row["strItemDescription"].'&x='.$x;
			/*}
			else
			{
				$strUrl = '#';
			}*/
			//echo $x;
			if($stockType !=3)	
			{
			//$matDetailID,$color,$size,$with0,$mainStores,$style,$tbl
				
		?>
        <tr bgcolor="#FFFFFF"> 
          <td height="20" class="normalfnt" nowrap="nowrap"><a href="<?php echo $strUrl; ?>" target="_blank"><?php echo $row["strItemDescription"]; ?></a></td>
          <td class="normalfnt"><?php echo $row["strColor"]; ?></td>
          <td class="normalfnt"><?php echo $row["strSize"]; ?></td>
          <td class="normalfntRite"><?php echo round($row["balanceQty"],4); ?></td>
           <td class="normalfntRite"><?php 
		   $totVal += $value;
		    echo number_format($value,4);
		    ?></td>
           <?php 
		  	if($x == 'all')
			{
		  ?>
          <td  class="normalfntRite"><?php echo round($row["leftoverStockQty"],4); ?></td>
          <td class="normalfntRite"><?php $leftValue = getStockValue($row["intMatDetailId"],$row["strColor"],$row["strSize"],$with0,$mainStores,$style,'stocktransactions_leftover');
		 
		   $totLeftVal += $leftValue;
		  echo number_format($leftValue,4);
		 	  
		   ?></td>
          <?php 
		  }
		  ?>
        </tr>
		<?php
			}
			else
			{
			?>
             <tr bgcolor="#FFFFFF"> 
          <td height="20" class="normalfntCentretRedSmall" nowrap="nowrap" style="text-align:left"><a href="<?php echo $strUrl; ?>" target="_blank"><?php echo $row["strItemDescription"]; ?></a></td>
          <td class="normalfntCentretRedSmall"  style="text-align:left"><?php echo $row["strColor"]; ?></td>
          <td class="normalfntCentretRedSmall"  style="text-align:left"><?php echo $row["strSize"]; ?></td>
          <td class="normalfntCentretRedSmall"  style="text-align:right"><?php echo round($row["balanceQty"],4); ?></td>
           <td class="normalfntCentretRedSmall"  style="text-align:right"><?php 
		   $totVal += $value;
		    echo number_format($value,4);
		    ?></td>
           <?php 
		  	if($x == 'all')
			{
		  ?>
          <td  class="normalfntCentretRedSmall"  style="text-align:right"><?php echo round($row["leftoverStockQty"],4); ?></td>
          <td class="normalfntCentretRedSmall" style="text-align:right"><?php $leftValue = getStockValue($row["intMatDetailId"],$row["strColor"],$row["strSize"],$with0,$mainStores,$style,'stocktransactions_leftover');
		   $totLeftVal += $leftValue;
		  echo number_format($leftValue,4);
		 	  
		   ?></td>
          <?php 
		  }
		  ?>
        </tr>
            <?php
			}		
		}
		?>
        <tr bgcolor="#EBEBEB">
         <td height="20" class="normalfnt" colspan="3" ><b>&nbsp;&nbsp;&nbsp;&nbsp;Grand Total</b></td>
          <td class="normalfntRite"><?php echo round($totRunStock,4); ?></td>
           <td class="normalfntRite"><?php echo number_format($totVal,4); ?></td>
           <?php 
		  	if($x == 'all')
			{
		  ?>
          <td  class="normalfntRite"><?php echo round($totLeftStock,4); ?></td>
         <td  class="normalfntRite"><?php echo number_format($totLeftVal,4); ?></td>
          <?php 
		  }
		  ?>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
  </tr>
</table>
<?php 
function getStockValue($matDetailID,$color,$size,$with0,$mainStores,$style,$tbl)
{
	global $db;
	$sql = "select sum(dblQty) as qty,intGrnNo,intGrnYear,strGRNType,intStyleId";
	
	if($tbl == 'stocktransactions_leftover')
		$sql .= " ,dblUnitPrice ";
		
 	$sql .= " from $tbl where intMatDetailId='$matDetailID' and strColor='$color' and strSize='$size' ";
	
	if($mainStores !='')
		$sql .= " and strMainStoresID = '$mainStores' ";
	if($style !='')
		$sql .= " and intStyleId = '$style' ";
	
	$sql .= " group by intGrnNo,intGrnYear,strGRNType";
	
	/*if($tbl == 'stocktransactions_leftover')
		$sql .= " ,dblUnitPrice ";*/
	
	if($with0 == 'false')
		$sql .= " having qty>0 ";
	//echo $sql;
	$result = $db->RunQuery($sql);
	$value =0;
	while($row = mysql_fetch_array($result))
	{
		$grnQty = $row["qty"];
		$intGrnNo = $row["intGrnNo"];
		$intGrnYear = $row["intGrnYear"];
		$strGRNType = $row["strGRNType"];
		$intStyleId = $row["intStyleId"];
		
		if($strGRNType == 'S')
		{
			$sqlSup = "select s.strTitle,gd.dblInvoicePrice,c.strCurrency,gh.dblExRate
from grndetails gd 
inner join grnheader gh on gd.intGrnNo= gh.intGrnNo and gh.intGRNYear = gd.intGRNYear
inner join purchaseorderheader poh on poh.intPONo=gh.intPoNo and poh.intYear=gh.intYear
inner join suppliers s on s.strSupplierID = poh.strSupplierID
inner join currencytypes c on c.intCurID= poh.strCurrency
where gd.intGrnNo='$intGrnNo' and gd.intGRNYear='$intGrnYear'  and gd.intMatDetailID='$matDetailID' and gd.strColor='$color' and  gd.strSize = '$size' and gd.intStyleId = '$intStyleId' ";
			$result_sup = $db->RunQuery($sqlSup); 
			$rowSup = mysql_fetch_array($result_sup);
			
			$supplier = $rowSup["strTitle"];
			$currency = $rowSup["strCurrency"];
			$unitPrice = $rowSup["dblInvoicePrice"];
			$exRate = $rowSup["dblExRate"];
		}
		else if($strGRNType == 'B')
		{
			$sqlSup = "select s.strTitle,gd.dblRate,c.strCurrency,gh.dblRate as exRate
from bulkgrndetails gd 
inner join bulkgrnheader gh on gd.intBulkGrnNo= gh.intBulkGrnNo and gh.intYear = gd.intYear
inner join bulkpurchaseorderheader poh on poh.intBulkPoNo=gh.intBulkPoNo and poh.intYear=gh.intBulkPoYear
inner join suppliers s on s.strSupplierID = poh.strSupplierID
inner join currencytypes c on c.intCurID= poh.strCurrency
where gd.intBulkGrnNo='$intGrnNo' and gd.intYear='$intGrnYear'  and gd.intMatDetailID='$matDetailID' and gd.strColor ='$color'  and gd.strSize ='$size' ";

			$result_sup = $db->RunQuery($sqlSup); 
			$rowSup = mysql_fetch_array($result_sup);
			
			$supplier = $rowSup["strTitle"];
			$currency = $rowSup["strCurrency"];
			$unitPrice = $rowSup["dblRate"];
			$exRate = $rowSup["exRate"];
		}
		
		$value += $grnQty*$unitPrice/$exRate;
		if($intGrnNo<20)
			$value+=$grnQty*$row["dblUnitPrice"];
	}
	return round($value,4);
	
}
function getTrimInspectValue($matDetailID,$color,$size,$with0,$mainStores,$style,$tbl)
{
	global $db;
	$sql = "select sum(dblQty) as qty,ST.intGrnNo,ST.intGrnYear,ST.strGRNType,ST.intStyleId
 from $tbl  ST 
 inner join grnheader gh on gh.intGrnNo= ST.intGrnNo and gh.intGRNYear=ST.intGrnYear
 where strType='GRN' and gh.intStatus=1 and intMatDetailId='$matDetailID' and strColor='$color' and strSize='$size'
  ";
	
	if($mainStores !='')
		$sql .= " and strMainStoresID = '$mainStores' ";
	if($style !='')
		$sql .= " and ST.intStyleId = '$style' ";
	
	$sql .= " group by ST.intGrnNo,ST.intGrnYear,ST.strGRNType";
	
	if($with0 == 'false')
		$sql .= " having qty>0 ";
	//echo $sql;	
	$result = $db->RunQuery($sql);
	$value =0;
	while($row = mysql_fetch_array($result))
	{
		$grnQty = $row["qty"];
		$intGrnNo = $row["intGrnNo"];
		$intGrnYear = $row["intGrnYear"];
		$strGRNType = $row["strGRNType"];
		$intStyleId = $row["intStyleId"];
		
		if($strGRNType == 'S')
		{
			$sqlSup = "select s.strTitle,gd.dblInvoicePrice,c.strCurrency,gh.dblExRate
from grndetails gd 
inner join grnheader gh on gd.intGrnNo= gh.intGrnNo and gh.intGRNYear = gd.intGRNYear
inner join purchaseorderheader poh on poh.intPONo=gh.intPoNo and poh.intYear=gh.intYear
inner join suppliers s on s.strSupplierID = poh.strSupplierID
inner join currencytypes c on c.intCurID= poh.strCurrency
where gd.intGrnNo='$intGrnNo' and gd.intGRNYear='$intGrnYear'  and gd.intMatDetailID='$matDetailID' and gd.strColor='$color' and  gd.strSize = '$size' and gd.intStyleId = '$intStyleId' ";
			$result_sup = $db->RunQuery($sqlSup); 
			$rowSup = mysql_fetch_array($result_sup);
			
			$supplier = $rowSup["strTitle"];
			$currency = $rowSup["strCurrency"];
			$unitPrice = $rowSup["dblInvoicePrice"];
			$exRate = $rowSup["dblExRate"];
		}
		else if($strGRNType == 'B')
		{
			$sqlSup = "select s.strTitle,gd.dblRate,c.strCurrency,gh.dblRate as exRate
from bulkgrndetails gd 
inner join bulkgrnheader gh on gd.intBulkGrnNo= gh.intBulkGrnNo and gh.intYear = gd.intYear
inner join bulkpurchaseorderheader poh on poh.intBulkPoNo=gh.intBulkPoNo and poh.intYear=gh.intBulkPoYear
inner join suppliers s on s.strSupplierID = poh.strSupplierID
inner join currencytypes c on c.intCurID= poh.strCurrency
where gd.intBulkGrnNo='$intGrnNo' and gd.intYear='$intGrnYear'  and gd.intMatDetailID='$matDetailID' and gd.strColor ='$color'  and gd.strSize ='$size' ";

			$result_sup = $db->RunQuery($sqlSup); 
			$rowSup = mysql_fetch_array($result_sup);
			
			$supplier = $rowSup["strTitle"];
			$currency = $rowSup["strCurrency"];
			$unitPrice = $rowSup["dblRate"];
			$exRate = $rowSup["exRate"];
		}
		
		$value += $grnQty*$unitPrice/$exRate;
		if($intGrnNo<20)
			$value=0;
	}
	//echo $value;
	return round($value,4);
	
}
 ?>
</body>
</html>