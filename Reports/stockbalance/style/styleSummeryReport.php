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
$dfrom		= $_GET["dfrom"];
$dTo		= $_GET["dTo"];
$CompanyID  	= $_SESSION["FactoryID"];
$report_companyId = $CompanyID;
$checkDate  = $_GET["checkDate"];
$OrderType = $_GET["OrderType"];
$withLeftVal = $_GET["withLeftVal"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>GaPro | Style Wise Stock Summary Balance Report</title>
<link href="../../../css/erpstyle.css"  rel="stylesheet" type="text/css" />
</head>

<body>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><?php include $backwardseperator.'reportHeader.php'?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="head1" align="center">STYLE WISE STOCK SUMMARY BALANCE REPORT <?php if($checkDate == 'true'){?>FROM <?php echo $dfrom?> TO <?php echo $dTo?> <?php }?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000">
	<thead>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="4%" height="25" >No</th>
        <th width="9%" >Stores</th>
        <th width="7%" >Buyer PO No</th>
        <th width="16%" >Description</th>
        <th width="6%" >Color</th>
        <th width="7%" >Size</th>
        <th width="11%" >Supplier</th>
        <th width="6%" >Unit</th>
        <th width="9%" >Book Balance as At <?php echo $dTo; ?></th>
        <th width="7%" >Currency</th>
        <th width="6%" >Unit Price</th>
        <th width="9%" >Book Balance Value <?php echo $dTo; ?></th>
        <th width="6%" >Nature</th>
      </tr>
	</thead>
      <?php
	  $value=0;
	  if($x=='leftOvers')
				$tbl = 'stocktransactions_leftover';
			else
				$tbl = 'stocktransactions';	
	   //get item nature
	   if($x=='leftOvers')
	   		$nature = 'LeftOver';
		else if($x=='running')	
			$nature = 'Running';
	   
	  $sql = "(SELECT ST.intStyleId,strOrderNo, MIL.strItemDescription, ST.strColor, ST.strSize, round(sum(ST.dblQty),4) as balanceQty,
ST.intGrnNo,ST.intGrnYear,ST.strGRNType, ST.intMatDetailId,ms.strName,ST.strUnit,1 as nature 
FROM $tbl ST 
Inner Join matitemlist MIL ON MIL.intItemSerial = ST.intMatDetailId 
inner join orders O ON O.intStyleId = ST.intStyleId
inner join mainstores ms on ms.strMainID = ST.strMainStoresID
where ST.strMainStoresID>0 ";
	
	if($checkDate == 'true')
	{
		$sql .=" and date(ST.dtmDate) between '$dfrom' and '$dTo' ";		
	}
	if($mainStores != '')
		$sql .=" and ST.strMainStoresID =$mainStores ";			
	if($mainId!='')
		$sql .=" and intMainCatID =$mainId ";	
	if($subId!='')
		$sql .=" and intSubCatID =$subId ";
	if($matItem!='')
		$sql .=" and intMatDetailId =$matItem ";	
	if($color!='')
		$sql .=" and strColor ='$color' ";
	if($size!='')
		$sql .=" and strSize ='$size' ";	
	if($style!='')
		$sql .=" and ST.intStyleId ='$style' ";	
	if($OrderType !='')
			$sql .= " and O.intOrderType ='$OrderType' ";	
	if($x=='running')
		$sql .=" and O.intStatus not in (13,14) ";
	/*if($x=='leftOvers')
		$sql .=" and O.intStatus=13 ";*/	
	$sql .= "GROUP BY ST.intStyleId,ST.intMatDetailId,ST.strColor,ST.strSize,ST.intGrnNo,ST.intGrnYear,ST.strGRNType ";
	if($with0=='true')
		$sql .= "having balanceQty>=0 )";
	else
		$sql .= "having balanceQty>0 )";
	if($x == 'all')
	{
		 $sql .= " union (SELECT ST.intStyleId,strOrderNo, MIL.strItemDescription, ST.strColor, ST.strSize, round(sum(ST.dblQty),4) as balanceQty,
ST.intGrnNo,ST.intGrnYear,ST.strGRNType, ST.intMatDetailId,ms.strName,ST.strUnit,0 as nature
FROM stocktransactions_leftover ST 
Inner Join matitemlist MIL ON MIL.intItemSerial = ST.intMatDetailId 
inner join orders O ON O.intStyleId = ST.intStyleId
inner join mainstores ms on ms.strMainID = ST.strMainStoresID
where  ST.strMainStoresID>0  ";
	
	if($checkDate == 'true')
	{
		$sql .=" and date(ST.dtmDate) between '$dfrom' and '$dTo' ";		
	}
	if($mainStores != '')
		$sql .=" and ST.strMainStoresID =$mainStores ";			
	if($mainId!='')
		$sql .=" and intMainCatID =$mainId ";	
	if($subId!='')
		$sql .=" and intSubCatID =$subId ";
	if($matItem!='')
		$sql .=" and intMatDetailId =$matItem ";	
	if($color!='')
		$sql .=" and strColor ='$color' ";
	if($size!='')
		$sql .=" and strSize ='$size' ";	
	if($style!='')
		$sql .=" and ST.intStyleId ='$style' ";	
	if($OrderType !='')
			$sql .= " and O.intOrderType ='$OrderType' ";	
		
	$sql .= "GROUP BY ST.intStyleId,ST.intMatDetailId,ST.strColor,ST.strSize,ST.intGrnNo,ST.intGrnYear,ST.strGRNType ";
	if($with0=='true')
		$sql .= "having balanceQty>=0 )";
	else
		$sql .= "having balanceQty>0 )";
	}
	
 
	$sql .= " order by intStyleId,strItemDescription"	;
	//echo $sql;
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$matDetailId = $row["intMatDetailId"];
		$grnNo = $row["intGrnNo"];
		$grnYear = $row["intGrnYear"];
		$value=0;
		$intStyleId = $row["intStyleId"];
		if($x=='all')
		{
			$itemNature = $row["nature"];
			switch($itemNature)
			{
				case 0:
				{
					$nature = 'LeftOver';
					break;
				}
				case 1:
				{
					$nature = 'Running';
					break;
				}
			}
		}
	  ?>
      <tr class="bcgcolor-tblrowWhite" onMouseOver="this.style.background ='#D6E7F5';" onMouseOut="this.style.background='';">
        <td height="20" nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["intMatDetailId"]; ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strName"]; ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strOrderNo"]; ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strItemDescription"]; ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strColor"]; ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strSize"]; ?>&nbsp;</td>
        <?php 
		if($row["strGRNType"] == 'S')
		{
			$sqlSup = "select s.strTitle,gd.dblInvoicePrice,c.strCurrency,gh.dblExRate
from grndetails gd 
inner join grnheader gh on gd.intGrnNo= gh.intGrnNo and gh.intGRNYear = gd.intGRNYear
inner join purchaseorderheader poh on poh.intPONo=gh.intPoNo and poh.intYear=gh.intYear
inner join suppliers s on s.strSupplierID = poh.strSupplierID
inner join currencytypes c on c.intCurID= poh.strCurrency
where gd.intGrnNo='$grnNo' and gd.intGRNYear='$grnYear'  and gd.intMatDetailID='$matDetailId' and gd.strColor='".$row["strColor"]."' and  gd.strSize = '".$row["strSize"]."'  and gd.intStyleId = '$intStyleId'";

			$result_sup = $db->RunQuery($sqlSup); 
			$rowSup = mysql_fetch_array($result_sup);
			
			$supplier = $rowSup["strTitle"];
			$currency = $rowSup["strCurrency"];
			$unitPrice = $rowSup["dblInvoicePrice"];
			$exRate = $rowSup["dblExRate"];
		}
		else if($row["strGRNType"] == 'B')
		{
			$sqlSup = "select s.strTitle,gd.dblRate,c.strCurrency,gh.dblRate as exRate
from bulkgrndetails gd 
inner join bulkgrnheader gh on gd.intBulkGrnNo= gh.intBulkGrnNo and gh.intYear = gd.intYear
inner join bulkpurchaseorderheader poh on poh.intBulkPoNo=gh.intBulkPoNo and poh.intYear=gh.intBulkPoYear
inner join suppliers s on s.strSupplierID = poh.strSupplierID
inner join currencytypes c on c.intCurID= poh.strCurrency
where gd.intBulkGrnNo='$grnNo' and gd.intYear='$grnYear'  and gd.intMatDetailID='$matDetailId' and gd.strColor='".$row["strColor"]."' and  gd.strSize = '".$row["strSize"]."' ";
			$result_sup = $db->RunQuery($sqlSup); 
			$rowSup = mysql_fetch_array($result_sup);
			
			$supplier = $rowSup["strTitle"];
			$currency = $rowSup["strCurrency"];
			$unitPrice = $rowSup["dblRate"];
			$exRate = $rowSup["exRate"];
			
		}
		$value = $row["balanceQty"]*$unitPrice/$exRate;
		
		//open stock leftover do not have po,grn details
		if($grnNo<20)
		{
			//$supplier = '&nbsp;';
			$supplier = 'Leftover uploaded from old ERP';
			$currency = '&nbsp;';
			$unitPrice = '&nbsp;';
			$value=0;
		}
		if(!($withLeftVal=='true') && $nature=='LeftOver')
			$value=0;
		?>
        <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $supplier; ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $row["strUnit"]; ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($row["balanceQty"],4); ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $currency; ?></td>
        <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($unitPrice,4); ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfntRite">&nbsp;<?php echo number_format($value,4); ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfnt">&nbsp;<?php echo $nature; ?>&nbsp;</td>
      </tr>
      <?php 
	  $grandTotal += round($row["balanceQty"],4);
	  $grandTotalValue += round($value,4);
	 $grandTotalUP += round($unitPrice,4);
	  }
	  
	  //get not trim inspected items from stock temp - confirmed GRN 
	   if($x!='leftOvers')
	   {
	  $sql_temp .= " SELECT ST.intStyleId,strOrderNo, MIL.strItemDescription, ST.strColor, ST.strSize, round(sum(ST.dblQty),4) as balanceQty,
ST.intGrnNo,ST.intGrnYear,ST.strGRNType, ST.intMatDetailId,ms.strName,ST.strUnit
FROM stocktransactions_temp ST 
Inner Join matitemlist MIL ON MIL.intItemSerial = ST.intMatDetailId 
inner join orders O ON O.intStyleId = ST.intStyleId
inner join mainstores ms on ms.strMainID = ST.strMainStoresID
inner join grnheader gh on gh.intGrnNo= ST.intGrnNo and gh.intGRNYear=ST.intGrnYear
where  strType='GRN' and gh.intStatus=1 ";
	
	if($checkDate == 'true')
		$sql_temp .= " and  date(ST.dtmDate) between '$dfrom' and '$dTo' "; 
	if($mainStores != '')
		$sql_temp .=" and ST.strMainStoresID =$mainStores ";			
	if($mainId!='')
		$sql_temp .=" and intMainCatID =$mainId ";	
	if($subId!='')
		$sql_temp .=" and intSubCatID =$subId ";
	if($matItem!='')
		$sql_temp .=" and intMatDetailId =$matItem ";	
	if($color!='')
		$sql_temp .=" and strColor ='$color' ";
	if($size!='')
		$sql_temp .=" and strSize ='$size' ";	
	if($style!='')
		$sql_temp .=" and ST.intStyleId ='$style' ";	
	if($OrderType !='')
		$sql_temp .= " and O.intOrderType ='$OrderType' ";		
	$sql_temp .= " GROUP BY ST.intStyleId,ST.intMatDetailId,ST.strColor,ST.strSize,ST.intGrnNo,ST.intGrnYear,ST.strGRNType ";
	if($with0=='true')
		$sql_temp .= " having balanceQty>=0 ";
	else
		$sql_temp .= " having balanceQty>0 ";
	
	$sql_temp .= " order by ST.intStyleId,MIL.strItemDescription"	;	
	//echo $sql_temp;
	$result_T = $db->RunQuery($sql_temp);
	while($rowT=mysql_fetch_array($result_T))
	{
		$matDetailId = $rowT["intMatDetailId"];
		$grnNo = $rowT["intGrnNo"];
		$grnYear = $rowT["intGrnYear"];
		$value=0;
		$nature = 'Not Trim inspected';
		$intStyleId = $rowT["intStyleId"];
	  ?>
       <tr class="bcgcolor-tblrowWhite" onMouseOver="this.style.background ='#D6E7F5';" onMouseOut="this.style.background='';">
        <td height="20" nowrap="nowrap" class="normalfntCentretRedSmall">&nbsp;<?php echo $rowT["intMatDetailId"]; ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfntCentretRedSmall" style="text-align:left">&nbsp;<?php echo $rowT["strName"]; ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfntCentretRedSmall" style="text-align:left">&nbsp;<?php echo $rowT["strOrderNo"]; ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfntCentretRedSmall" style="text-align:left">&nbsp;<?php echo $rowT["strItemDescription"]; ?>&nbsp;</td>
                <td nowrap="nowrap" class="normalfntCentretRedSmall" style="text-align:left">&nbsp;<?php echo $rowT["strColor"]; ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfntCentretRedSmall" style="text-align:left">&nbsp;<?php echo $rowT["strSize"]; ?>&nbsp;</td>
        <?php 
		if($rowT["strGRNType"] == 'S')
		{
			$sqlSup = "select s.strTitle,gd.dblInvoicePrice,c.strCurrency,gh.dblExRate
from grndetails gd 
inner join grnheader gh on gd.intGrnNo= gh.intGrnNo and gh.intGRNYear = gd.intGRNYear
inner join purchaseorderheader poh on poh.intPONo=gh.intPoNo and poh.intYear=gh.intYear
inner join suppliers s on s.strSupplierID = poh.strSupplierID
inner join currencytypes c on c.intCurID= poh.strCurrency
where gd.intGrnNo='$grnNo' and gd.intGRNYear='$grnYear'  and gd.intMatDetailID='$matDetailId' and gd.strColor='".$rowT["strColor"]."' and  gd.strSize = '".$rowT["strSize"]."'  and gd.intStyleId = '$intStyleId'";
			$result_sup = $db->RunQuery($sqlSup); 
			$rowSup = mysql_fetch_array($result_sup);
			
			$supplier = $rowSup["strTitle"];
			$currency = $rowSup["strCurrency"];
			$unitPrice = $rowSup["dblInvoicePrice"];
			$exRate = $rowSup["dblExRate"];
		}
		else if($rowT["strGRNType"] == 'B')
		{
			$sqlSup = "select s.strTitle,gd.dblRate,c.strCurrency,gh.dblRate as exRate
from bulkgrndetails gd 
inner join bulkgrnheader gh on gd.intBulkGrnNo= gh.intBulkGrnNo and gh.intYear = gd.intYear
inner join bulkpurchaseorderheader poh on poh.intBulkPoNo=gh.intBulkPoNo and poh.intYear=gh.intBulkPoYear
inner join suppliers s on s.strSupplierID = poh.strSupplierID
inner join currencytypes c on c.intCurID= poh.strCurrency
where gd.intBulkGrnNo='$grnNo' and gd.intYear='$grnYear'  and gd.intMatDetailID='$matDetailId' and gd.strColor='".$rowT["strColor"]."' and  gd.strSize = '".$rowT["strSize"]."' ";

			$result_sup = $db->RunQuery($sqlSup); 
			$rowSup = mysql_fetch_array($result_sup);
			
			$supplier = $rowSup["strTitle"];
			$currency = $rowSup["strCurrency"];
			$unitPrice = $rowSup["dblRate"];
			$exRate = $rowSup["exRate"];
			
		}
		$value = $rowT["balanceQty"]*$unitPrice/$exRate;
		
		//open stock leftover do not have po,grn details
		if($grnNo<20)
		{
			$supplier = '&nbsp;';
			$currency = '&nbsp;';
			$unitPrice = '&nbsp;';
			$value=0;
		}
		?>
        <td nowrap="nowrap" class="normalfntCentretRedSmall" style="text-align:left">&nbsp;<?php echo $supplier; ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfntCentretRedSmall" style="text-align:left">&nbsp;<?php echo $rowT["strUnit"]; ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfntCentretRedSmall" style="text-align:right">&nbsp;<?php echo number_format($rowT["balanceQty"],4); ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfntCentretRedSmall" style="text-align:left">&nbsp;<?php echo $currency; ?></td>
        <td nowrap="nowrap" class="normalfntCentretRedSmall" style="text-align:left">&nbsp;<?php echo number_format($unitPrice,4); ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfntCentretRedSmall" style="text-align:right">&nbsp;<?php  echo number_format($value,4); ?>&nbsp;</td>
        <td nowrap="nowrap" class="normalfntCentretRedSmall" style="text-align:left">&nbsp;<?php echo $nature; ?>&nbsp;</td>
      </tr>
	  
	<?php 
	$grandTotal += round($rowT["balanceQty"],4);
	$grandTotalValue += round($value,4);
	$grandTotalUP += round($unitPrice,4);
	}  
	
	}
	  ?>
       <tr class="bcgcolor-tblrowWhite">
         <td height="20" colspan="8" nowrap="nowrap" class="normalfntMid"><b>Grand Total</b></td>
         <td nowrap="nowrap" class="normalfntRite"><b><?php echo $grandTotal;?></b></td>
         <td nowrap="nowrap" class="normalfntMid">&nbsp;</td>
         <td nowrap="nowrap" class="normalfntMid"><b><?php echo $grandTotalUP;?></b></td>
         <td nowrap="nowrap" class="normalfntMid"><b><?php echo $grandTotalValue;?></b></td>
         <td nowrap="nowrap" class="normalfntMid">&nbsp;</td>
       </tr>

    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
