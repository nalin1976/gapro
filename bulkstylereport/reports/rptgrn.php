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
	$intStatus 			= $_GET["status"];
	$report_companyId 	= $_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Bulk Reports - Grn Details</title>
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
    <td colspan="3"><?php include $backwardseperator.'reportHeader.php'; ?></td>
  </tr>
  <tr>
     <td colspan="5" class="normalfnt2bldBLACKmid"><?php echo ("BULK GRN REGISTER.")?></td>
  </tr>
  <tr>
   <td colspan="5" class="normalfnth2" style="text-align:center">
	<?php 		
		if ($intStatus==1) echo "(CONFIRMED LIST)"; 
		elseif ($intStatus==0) echo "(PENDING LIST)";					 
		elseif ($intStatus==10) echo "(CANCELED LIST)"; 				
	?>
	</td>
  </tr> 
  	<?php 		
$sql = "SELECT distinct BGH.intYear, BGH.intBulkGrnNo, BGH.intBulkPoNo, BGH.intBulkPoYear, S.strTitle, BPH.strPINO, BGH.dtRecdDate ,
(select CT.strCurrency from currencytypes CT where CT.intCurID=BPH.strCurrency)as currencyName
FROM bulkgrnheader BGH
inner join bulkgrndetails BGD on BGD.intBulkGrnNo=BGH.intBulkGrnNo and BGD.intYear=BGH.intYear
Inner Join bulkpurchaseorderheader BPH ON BPH.intBulkPoNo = BGH.intBulkPoNo AND BPH.intYear=BGH.intYear 
Inner Join suppliers S ON S.strSupplierID = BPH.strSupplierID 
inner join matitemlist MIL on MIL.intItemSerial=BGD.intMatDetailID where BGH.intStatus=$intStatus";			

if($noFrom!="")
	$sql .= " and BGH.intBulkGrnNo >= '$noFrom'";
if($noTo!="")
	$sql .= " and BGH.intBulkGrnNo <= '$noTo'";
if ($intCompany!="")
	$sql .= " and BGH.intCompanyID=$intCompany ";
if ($intMeterial!= "")
	$sql .= " and MIL.intMainCatID=$intMeterial ";	
if ($intCategory!= "")
	$sql .= " and MIL.intSubCatID=$intCategory " ;
if ($intDescription!= "")
	$sql .= " and MIL.intItemSerial=$intDescription " ;
if ($intSupplier!="")
	$sql .= " and BPH.strSupplierID=$intSupplier ";
if($dtmDateFrom!="")
	$sql .= " and DATE_FORMAT(BGH.dtRecdDate,'%Y/%m/%d') >= DATE_FORMAT('$dtmDateFrom','%Y/%m/%d')"; 
if($dtmDateTo!="")
	$sql .= " and DATE_FORMAT(BGH.dtRecdDate,'%Y/%m/%d') <= DATE_FORMAT('$dtmDateTo','%Y/%m/%d')"; 
			
			$sql .= " order by BGH.intYear,BGH.intBulkGrnNo";
			$result = $db->RunQuery($sql);
			$rowCount	= mysql_num_rows($result);
			while ($rowdata=mysql_fetch_array($result))
			{								
	?>
	<tr>
    	<td width="87" class="mainHeading4" >GRN  Number</td>
  	    <td width="114" class="mainHeading4" ><?php echo $rowdata["intYear"].'/'.$rowdata["intBulkGrnNo"];  ?></td>
  	    <td width="800" >&nbsp;</td>
  	</tr> 
    <tr>	
    	<td colspan="3">
		<table width="965" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
		<tr>
		<td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder">
          <tr height="25">
            <td  width="53" height="18" class="normalfnth2B">Po No : </td>
			<td width="98" class="normalfnt"><?php echo $rowdata["intYear"],'/',$rowdata["intBulkPoNo"]; ?></td>
			<td width="94" class="normalfnth2B">Supplier : </td>
			<td colspan="2" class="normalfnt"><?php echo $rowdata["strTitle"]; ?></td>
			<td width="122" class="normalfnt">PIN NO : <?php echo $rowdata["strPINO"]; ?></td>
			<td width="46" class="normalfnth2B"> Date : </td>
			<td width="126" class="normalfnt"><?php  echo substr($rowdata["dtRecdDate"],0,10);?></td>
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
            <td width="20" bgcolor="#CCCCCC" class="normalfntBtab"  >Mat</td>
	        <td width="277" bgcolor="#CCCCCC" class="normalfntBtab" >Description</td>
            <td width="118" bgcolor="#CCCCCC" class="normalfntBtab">Color</td>
            <td width="118" bgcolor="#CCCCCC" class="normalfntBtab">Size</td>
            <td width="50" bgcolor="#CCCCCC" class="normalfntBtab">Unit</td>			
			<td width="73" bgcolor="#CCCCCC" class="normalfntBtab">Qty</td>
			<td width="68" bgcolor="#CCCCCC" class="normalfntBtab">Rate <br/>(<?php echo $rowdata["currencyName"];?>)</td>
			<td width="70"  bgcolor="#CCCCCC" class="normalfntBtab">Amount <br/>(<?php echo $rowdata["currencyName"];?>)</td>
			<td width="70" bgcolor="#CCCCCC" class="normalfntBtab">Ret To Supp.</td>															
          </tr>
<?php 
$detailSql="SELECT distinct GH.intBulkGrnNo,GH.intYear, 
			BGD.intMatDetailID,
			MIL.intMainCatID, 
			MIL.intSubCatID,GH.intStatus,
			MMC.strDescription, 
			MIL.strItemDescription, 
			BGD.strColor , 
			BGD.strSize,
			BGD.dblQty AS dblQty, ((BGD.dblExQty +BGD.dblQty) - BGD.dblBalance) AS retToSup, 
			POD.dblUnitPrice, POD.strUnit 
			FROM bulkgrnheader GH
			INNER JOIN bulkgrndetails BGD ON GH.intBulkGrnNo=BGD.intBulkGrnNo AND GH.intYear=BGD.intYear 
			INNER JOIN bulkpurchaseorderheader POH ON GH.intBulkPoNo=POH.intbulkPONo AND GH.intYear=POH.intYear 
			INNER JOIN matitemlist MIL ON BGD.intMatDetailID=MIL.intItemSerial 
			INNER JOIN matmaincategory MMC ON MIL.intMainCatID=MMC.intID
			inner join bulkpurchaseorderdetails POD on POH.intbulkPoNo= POD.intbulkPoNo and POH.intYear= POD.intYear and POD.intMatDetailID=BGD.intMatDetailID 			and POD.strColor=BGD.strColor and POD.strSize=BGD.strSize 
			WHERE GH.intStatus=$intStatus AND GH.intBulkGrnNo =".$rowdata["intBulkGrnNo"]." AND GH.intYear =".$rowdata["intYear"]."";

			if ($intCompany!="")
				$detailSql .= " AND GH.intCompanyID=$intCompany  ";
			if ($intMeterial!= "")
				$detailSql .= " AND MIL.intMainCatID=$intMeterial ";
			if ($intCategory!= "")
				$detailSql .= " AND MIL.intSubCatID=$intCategory " ;
			if ($intDescription!= "")
				$detailSql .= " AND POD.intMatDetailID=$intDescription ";						
			$detailResult = $db->RunQuery($detailSql);			
			while ($details=mysql_fetch_array($detailResult))
			{				
		  	?>
          <tr>
	        <td class="normalfntTAB"><?php echo( substr($details["strDescription"],0,3)); ?></td>
            <td class="normalfntTAB"><?php echo($details["strItemDescription"]); ?></td>
            <td class="normalfntMidTAB"><?php echo $details["strColor"]; ?></td>
            <td class="normalfntMidTAB"><?php echo $details["strSize"]; ?></td>
            <td class="normalfntMidTAB"><?php echo($details["strUnit"]); ?></td>
            <td class="normalfntRiteTAB"><?php echo($details["dblQty"]); ?></td>
            <td class="normalfntRiteTAB"><?php echo(number_format($details["dblUnitPrice"],4)); ?></td>
            <td class="normalfntRiteTAB"><?php echo(number_format($details["dblQty"]*$details["dblUnitPrice"],2)); ?></td>
            <td class="normalfntRiteTAB"><?php echo round(retToSup,2); ?></td>          
          </tr>
		  
		  <?php 		  
		  	}
		  ?>		  
        </table></td>
  	</tr>
	</table>
	<tr><td>&nbsp;</td></tr>
<?php
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
