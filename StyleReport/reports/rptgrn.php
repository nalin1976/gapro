<?php
	session_start();
	include "../../Connector.php" ;
	$backwardseperator 	= "../../";	
	$strStyleNo			= $_GET["strStyleNo"];
	$strBPo				= $_GET["strBPo"];
	$intMeterial 		= $_GET["intMeterial"];
	$intCategory 		= $_GET["intCategory"];
	$intDescription 	= $_GET["intDescription"];
	$intSupplier 		= $_GET["intSupplier"];
	$intBuyer 	  		= $_GET["intBuyer"];
	$dtmDateFrom		= $_GET["dtmDateFrom"];
	$dtmDateTo 	  		= $_GET["dtmDateTo"];
	$noTo 	  			= $_GET["noTo"];
	$noFrom 	  		= $_GET["noFrom"];	
	$intCompany     	= $_GET["intCompany"];
	$txtMatItem			= $_GET["txtMatItem"];
	$intStatus 			= $_GET["status"];
	$orderType 			= $_GET["orderType"];
	
	
	if($intCompany != '')
		$report_companyId =$intCompany;
	else
		$report_companyId =$_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro - Style Reports :: Grn Details</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
.style1 {font-size: 12pt}
.style2 {font-size: 14pt}
-->
</style>
</head>


<body>
<table width="1000" border="0" align="center" cellpadding="0">
  <tr>
    <td colspan="5"><?php include $backwardseperator.'reportHeader.php'; ?></td>
  </tr>
  <tr>
     <td colspan="7" class="normalfnt2bldBLACKmid"><?php echo ("GRN REGISTER.")?></td>
  </tr>
  <tr>
   <td colspan="7" class="normalfnth2" style="text-align:center">
	<?php 		
		if ($intStatus==1) echo "(CONFIRMED LIST)"; 
		elseif ($intStatus==0) echo "(PENDING LIST)";					 
		elseif ($intStatus==10) echo "(CANCELED LIST)"; 				
	?>	</td>
  </tr> 
  	<?php 		
$sql = "SELECT distinct GH.intGrnNo,
		GH.intGRNYear,
		GH.intPoNo,
		GH.intYear,
		suppliers.strTitle, 
		POH.strPINO, 
		GH.dtmRecievedDate,
		GH.strSupAdviceNo,
		GH.intStatus,
		GH.strInvoiceNo,
		(select strCurrency from currencytypes CT where CT.intCurID=POH.strCurrency)as currencyName,
		companies.strName
		from grnheader GH
		inner join grndetails on GH.intGrnNo=grndetails.intGrnNo and GH.intGRNYear=grndetails.intGRNYear 
		inner join purchaseorderheader POH on GH.intPoNo =POH.intPONo AND GH.intYear=POH.intYear
		inner join suppliers on POH.strSupplierID=suppliers.strSupplierID 
		inner join specification on grndetails.intStyleId=specification.intStyleId 
		inner join matitemlist on grndetails.intMatDetailID=matitemlist.intItemSerial 
		inner join orders on grndetails.intStyleId=orders.intStyleId 
		inner join companies on companies.intCompanyID = GH.intCompanyID 
		where GH.intStatus=$intStatus";			

        #================================================================#
		/* Change On - 11/26/2014 */
		/* Description - Add GRN location to the report  */
		
		#================================================================#
		
		  
			if($noFrom!=""){
				$sql .= " and GH.intGrnNo >= '$noFrom'";
			}
			if($noTo!=""){
				$sql .= " and GH.intGrnNo <= '$noTo'";
			}			
			/*if ($intCompany!="")
			{
				$sql = $sql." and GH.intCompanyID=$intCompany ";
			}*/
						
			if ($strStyleNo!= "")
			{ 
				$sql = $sql." and grndetails.intStyleId ='$strStyleNo' ";
			}
			if($orderType != '')
				$sql .= " and orders.intOrderType in ($orderType) ";
				
			if ($strBPo	!= "")
			{
				$sql = $sql." and grndetails.strBuyerPONO='$strBPo' " ;
			}
			
			if ($intMeterial!= "")
			{					
				$sql = $sql." and matitemlist.intMainCatID=$intMeterial ";	
			}
			if ($txtMatItem!= "")
			{				
				$sql .= " and matitemlist.strItemDescription like '%$txtMatItem%' " ;
			}
			if ($intCategory!= "")
			{
				$sql = $sql." and matitemlist.intSubCatID=$intCategory " ;
			}
			
			if ($intDescription!= "")
			{
				$sql = $sql." and matitemlist.intItemSerial=$intDescription " ;
			}
			
			if ($intSupplier!="")
			{			
				$sql = $sql." and POH.strSupplierID=$intSupplier ";
			}

			if ($intBuyer!="")
			{			
				$sql = $sql." and orders.intBuyerID=$intBuyer";				
			}
			
			if($dtmDateFrom!="")
			{					
				$sql = $sql." and DATE_FORMAT(GH.dtmRecievedDate,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d')"; 
			}
			
			if($dtmDateTo!="")
			{					
			$sql = $sql." and DATE_FORMAT(GH.dtmRecievedDate,'%Y/%m/%d') <= DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
			}
			
			$sql = $sql. " order by GH.intGrnNo";			
		
			$result = $db->RunQuery($sql);
			$rowCount	= mysql_num_rows($result);
			while ($rowdata=mysql_fetch_array($result))
			{								
	?>
	<tr>
    	<td width="97" class="mainHeading4" >GRN  Number : </td>
  	    <td width="104" class="mainHeading4" ><?php echo $rowdata["intGRNYear"].'/'.$rowdata["intGrnNo"];  ?></td>
  	    <td width="75" class="mainHeading4"  >Currency : </td>
  	    <td width="96" class="mainHeading4" ><?php echo $rowdata["currencyName"]?></td>
	    <td width="99" class="mainHeading4" >Location : </td>
        <td width="524" class="mainHeading4" style="text-align:left;">&nbsp;<?php echo $rowdata["strName"]?></td>
	</tr> 
    <tr>	
    	<td colspan="6">
		<table width="965" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
		<tr>
		<td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
          <tr height="25">
            <td  width="48" height="18" class="normalfnth2B">PO No : </td>
			<td width="86" class="normalfnt"><?php echo $rowdata["intYear"],'/',$rowdata["intPoNo"]; ?></td>
			<td width="88" class="normalfnth2B">Supplier : </td>
			<td width="230" class="normalfnt"><?php echo $rowdata["strTitle"]; ?></td>
			<td width="88" class="normalfnth2B">Invoice No:</td>
			<td width="88" class="normalfnt"><?php echo $rowdata["strInvoiceNo"]; ?></td>
            <td width="107" class="normalfnth2B">AD No : <?php echo $rowdata["strSupAdviceNo"]; ?></td>
			<td width="107" class="normalfnth2B">PI NO : <?php echo $rowdata["strPINO"]; ?></td>
			<td width="44" class="normalfnth2B"> Date : </td>
			<td width="115" class="normalfnt"><?php  echo $rowdata["dtmRecievedDate"];?></td>
            
            
          </tr>          
        </table>
		<p class="head2BLCK"></p></td>
  	</tr>
	
	<tr>
    	<td height="25" colspan="3" class="normalfnth2B">Item Details</td>
  	</tr>
	<tr>
    	<td colspan="3"><table width="1003" border="0" cellpadding="0" cellspacing="0" class="tablez">
          <tr >
            <td width="100" bgcolor="#CCCCCC" class="normalfntBtab">Style No</td>
           <!-- <td width="100" bgcolor="#CCCCCC" class="normalfntBtab">Order No  </td> -->
			 <td width="25" bgcolor="#CCCCCC" class="normalfntBtab">SCNo</td>
             <td width="100" bgcolor="#CCCCCC" class="normalfntBtab">Buyer PONo</td>
             <td width="20" bgcolor="#CCCCCC" class="normalfntBtab"  >Mat</td>
	        <td width="277" bgcolor="#CCCCCC" class="normalfntBtab" >Description</td>
            <td width="118" bgcolor="#CCCCCC" class="normalfntBtab">Color</td>
            <td width="118" bgcolor="#CCCCCC" class="normalfntBtab">Size</td>
            <td width="50" bgcolor="#CCCCCC" class="normalfntBtab">Unit</td>			
			<td width="73" bgcolor="#CCCCCC" class="normalfntBtab">Qty</td>
			<td width="68" bgcolor="#CCCCCC" class="normalfntBtab">Rate</td>
			<td width="70"  bgcolor="#CCCCCC" class="normalfntBtab">Amount</td>
			<td width="70" bgcolor="#CCCCCC" class="normalfntBtab">Ret To Supp.</td>
			<td width="70" bgcolor="#CCCCCC" class="normalfntBtab">Issue Qty</td>															
			<td width="70" bgcolor="#CCCCCC" class="normalfntBtab">PO Qty</td>															
          </tr>
<?php 
$detailSql="SELECT distinct GH.intGrnNo,
GH.intGRNYear,  
grndetails.strBuyerPONO,
grndetails.intStyleId,
grndetails.intMatDetailID, 
GH.dtmRecievedDate,
matitemlist.intMainCatID,
matitemlist.intSubCatID,
GH.intStatus, 
matmaincategory.strDescription, 
matitemlist.strItemDescription,
grndetails.strColor , 
grndetails.strSize, 
grndetails.dblQty AS dblQty, 
((grndetails.dblQty) -  grndetails.dblBalance) AS retToSup,
POD.dblUnitPrice,
POD.strUnit,
specification.intSRNO,
orders.strOrderNo,
orders.strStyle,
POD.dblQty AS POQty
FROM grnheader GH
INNER JOIN grndetails ON GH.intGrnNo=grndetails.intGrnNo AND GH.intGRNYear=grndetails.intGRNYear 
INNER JOIN purchaseorderheader POH ON GH.intPoNo=POH.intPONo AND GH.intYear=POH.intYear 
INNER JOIN specification ON grndetails.intStyleId=specification.intStyleId 
INNER JOIN matitemlist ON grndetails.intMatDetailID=matitemlist.intItemSerial 
INNER JOIN orders ON grndetails.intStyleId=orders.intStyleId 
INNER JOIN matmaincategory ON matitemlist.intMainCatID=matmaincategory.intID 
inner join purchaseorderdetails POD on POH.intPoNo= POD.intPoNo  and POH.intYear= POD.intYear and POD.intStyleId=grndetails.intStyleId and POD.intMatDetailID=grndetails.intMatDetailID and POD.strColor=grndetails.strColor and POD.strSize=grndetails.strSize AND POD.strBuyerPONO = grndetails.strBuyerPONO
WHERE GH.intStatus=$intStatus 
AND GH.intGrnNo =".$rowdata["intGrnNo"]." AND GH.intGRNYear =".$rowdata["intGRNYear"]."";

			
			if ($strStyleNo!= "")
			{ 
				$detailSql .= " and grndetails.intStyleId ='$strStyleNo' ";
			}
			if($orderType != '')
				$detailSql .= " and orders.intOrderType in ($orderType) ";
				
			if ($strBPo	!= "")
			{
				$detailSql .= " and grndetails.strBuyerPONO='$strBPo' " ;
			}
			
			if ($intCompany!="")
			{
				$detailSql .= " AND GH.intCompanyID=$intCompany  ";
			}
			
			if ($intMeterial!= "")
			{					
				$detailSql .= " AND matitemlist.intMainCatID=$intMeterial ";
			}

			if ($intCategory!= "")
			{
				$detailSql .= " AND matitemlist.intSubCatID=$intCategory " ;
			}

			if ($intDescription!= "")
			{
				$detailSql .= " AND POD.intMatDetailID=$intDescription ";						
			}
			if ($txtMatItem!= "")
			{				
				$detailSql .= " and matitemlist.strItemDescription like '%$txtMatItem%' " ;
			}		
			$detailResult = $db->RunQuery($detailSql);
			$totQty=0;
			$totUnitPrice=0;
			$amount=0;
			$totAmount=0;
			$totReturnToSup=0;
			$issueQty=0;
			$totIssueQty=0;
			$totPoQty=0;
			//echo $detailSql ;
			while ($details=mysql_fetch_array($detailResult))
			{
			$totQty+=$details["dblQty"];
			$totUnitPrice+=$details["dblUnitPrice"];	
			$amount=$details["dblQty"]*$details["dblUnitPrice"];
			$totAmount+=$amount;
			$totPoQty+=$details["POQty"];
			$totReturnToSup=$details["retToSup"];
			$issueQty = GetISSUEQty($details["intGrnNo"],$details["intGRNYear"],$details["intStyleId"],$details["strBuyerPONO"],$details["intMatDetailID"],$details["strColor"],$details["strSize"]);
			$totIssueQty+=$issueQty;
		  	?>
          <tr>
            <td class="normalfntTAB"><?php echo $details["strStyle"]; ?></td>
          <!--  <td class="normalfntTAB"><?php echo $details["strOrderNo"]; ?></td> -->
			<td class="normalfntMidTAB"><?php echo $details["intSRNO"]; ?></td>
	        <td class="normalfntMidTAB"><?php echo $details["strBuyerPONO"]; ?></td>
	        <td class="normalfntTAB"><?php echo( substr($details["strDescription"],0,3)); ?></td>
            <td class="normalfntTAB"><?php echo($details["strItemDescription"]); ?></td>
            <td class="normalfntMidTAB"><?php echo $details["strColor"]; ?></td>
            <td class="normalfntMidTAB"><?php echo $details["strSize"]; ?></td>
            <td class="normalfntMidTAB"><?php echo($details["strUnit"]); ?></td>
            <td class="normalfntRiteTAB"><?php echo($details["dblQty"]); ?></td>
            <td class="normalfntRiteTAB"><?php echo(number_format($details["dblUnitPrice"],4)); ?></td>
            <td class="normalfntRiteTAB"><?php echo(number_format($details["dblQty"]*$details["dblUnitPrice"],2)); ?></td>
            <td class="normalfntRiteTAB"><?php echo round($details["retToSup"],2); ?></td>
			<td class="normalfntRiteTAB"><?php echo round(GetISSUEQty($details["intGrnNo"],$details["intGRNYear"],$details["intStyleId"],$details["strBuyerPONO"],$details["intMatDetailID"],$details["strColor"],$details["strSize"]),2); ?></td>  
            <td class="normalfntRiteTAB"><?php echo($details["POQty"]); ?></td>
          </tr>
		 <?php 		  
		  	}
		  ?>  
          
          <tr>
            <td colspan="8" class="normalfnth2B" style="text-align:center">Total</td>
            <td class="normalfntRiteTAB"><?php echo $totQty; ?></td>
            <td class="normalfntRiteTAB"><?php echo(number_format($totUnitPrice,4)); ?></td>
            <td class="normalfntRiteTAB"><?php echo(number_format($totAmount,2)); ?></td>
            <td class="normalfntRiteTAB"><?php echo round($totReturnToSup,2); ?></td>
			<td class="normalfntRiteTAB"><?php echo round(($totIssueQty),2); ?></td>  
	        <td class="normalfntRiteTAB"><?php echo round(($totPoQty),2); ?></td>    
          </tr>
		 		  
        </table></td>
  	</tr>
	</table>
	<tr><td>&nbsp;</td></tr>
<?php
	}
	
function GetISSUEQty($GrnNo,$GrnYear,$styleId,$buyerPoNo,$matId,$color,$size)
{
global $db;
$qty = 0;
	$sql="select sum(ID.dblQty)as qty 
			from issuesdetails ID 
			where ID.intGrnNo='$GrnNo' and ID.intGrnYear='$GrnYear' 
			and ID.intStyleId='$styleId' and ID.strBuyerPONO='$buyerPoNo' 
			and ID.intMatDetailID='$matId' and ID.strColor='$color' 
			and ID.strSize='$size';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$qty = $row["qty"];
	}
return $qty;
}
?>

</td></tr></table>
<script type="text/javascript">

var rowCount =<?php echo $rowCount?>;
if(rowCount<=0){
	alert("Sorry!\nNo Records found in selected options.")
	window.close();
}
</script>
</body>
</html>
